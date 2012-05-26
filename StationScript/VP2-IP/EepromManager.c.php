<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 28, 29)
/// 3. DMP and DMPAFT data format
/// There are two different archived data formats. Rev "A" firmware, dated before April 24, 2002
/// uses the old format. Rev "B" firmware dated on or after April 24, 2002 uses the new format. The
/// fields up to ET are identical for both formats. The only differences are in the Soil, Leaf, Extra
// ##############################################################################################

class dataFetcher extends ConnexionManager
{
	function __construct($name, $myConfig)	{
		parent::__construct($name, $myConfig);
	}
	
	/*
	@description: functionDescription
	@return: functionReturn
	@param: returnValue
	*/
	function VerifAnswersAndCRC($data, $len) {
		if (strlen($data)!=$len){
			throw new Exception(sprintf(_('Incomplete Data strlen = %d insted of : %d'),strlen($data),$len));
		}
		
		$crc = Tools::CalculateCRC($data);
		if ($crc != chr(0).chr(0)){
			throw new Exception(sprintf(_('Wrong CRC, on good data : 0x%X'),$crc));
		}
		return true;
	}
	/*
	@description: functionDescription
	@return: functionReturn
	@param: returnValue
	*/
	function RequestCmd($cmd) { //
		fwrite ($this->fp, $cmd);
		$r = fread($this->fp, 1);
		if ($r == Tools::ACK){
			return true;
		}
		else if ($r == Tools::NAK)
		{
			throw new Exception(sprintf(_('Command [%s] not understand'),$cmd));
		}
		else {
			throw new Exception(_('Unknow Error, Reconnection'));
		}
	}

	/*
	@description: functionDescription
	@return: functionReturn
	@param: returnValue
	*/
	function RawConverter($DataModele, $RawStr) { //
		$x = array();
		foreach($DataModele as $key=>$val) {
			if (is_int($val['pos'])) {
				$StrValue = substr ($RawStr, $val['pos'], $val['len']);
			}
			else {
				$StrValue = Tools::getBits(
					substr ($RawStr, (int)$val['pos'],1),
					($val['pos']-(int)$val['pos']-0.1)*10,
					$val['len']);
			}
			echo $val['fn']."\n";
			eval('return '.$val['fn'].' ($StrValue);');
		}
		
		return $returnValue;
	}

	/*
	@description: functionDescription
	@return: functionReturn
	@param: returnValue
	*/
	function GetLoop ($nbr=1) {
		$_NBR = $nbr;	
		try {
			self::RequestCmd("LOOP $nbr\n");
			while ($nbr-- > 0) {
				$data = fread($this->fp, 99);
				self::VerifAnswersAndCRC($data, 99);
				Tools::Waiting (0,'[LOOP] : Download the current Values');
				$LOOPS[]=self::RawConverter($this->Loop, $data);
				echo implode("\t",$LOOPS[0])."\n";
			}
		}
		catch (Exception $e) {
			Tools::Waiting (0, $e->getMessage());
		}
		return $LOOPS;
	}
	/*
	@description: functionDescription
	@return: functionReturn
	@param: returnValue
	*/
	function GetDmpAft($last=0) { //
		try {
			Tools::is_date($last);
			self::RequestCmd("DMPAFT\n");
			$RawDate = Tools::DMPAFT_SetVP2Date($last);
			fwrite($this->fp, $RawDate);				// Send this date (parametre #1)
			$crc = Tools::CalculateCRC($RawDate);			// define the CRC of my date
			self::RequestCmd($crc);					// Send the CRC (parametre #2)
			$data = fread($this->fp, 6);				// we read the properties : item count and first item position
			self::VerifAnswersAndCRC($data, 6);
// 			$nbrArch=0;
// 			$LastArchDate = 0;
// 			$retry = $this->retry-1;
			$nbrPages = $this->hexToDec (strrev(substr($r,0,2)));	// Split Bytes in revers order : Nbr of page
			$firstArch = $this->hexToDec (strrev(substr($r,2,2)));	// Split Bytes in revers order : # of first archived
				Tools::Waiting (0,'There are '.$nbrPages.'p. in queue, from archive '.$firstArch.' on first page since '.$last.'.');
			fwrite($this->fp, Tools::ACK);			// Send ACK to start
			for ($j=0;$j<$nbrPages;$j++) {
				$Page = fread($this->fp, 267);
					Tools::Waiting (0,'Download Archive PAGE #'.$j.' since : '.Tools::DMPAFT_GetVP2Date(substr($Page,1+52*($firstArch),4)));
				self::VerifAnswersAndCRC($Page, 267);
				fwrite ($this->fp, Tools::ACK);
				for ($k=$firstArch; $k<=4; $k++) {
					$ArchiveStrRaw = substr ($Page, 1+52*$k, 52);
					$ArchDate = Tools::DMPAFT_GetVP2Date(substr($ArchiveStrRaw,0,4));
					if (strtotime($ArchDate) > strtotime($LastArchDate)) {// ignore les 1er et derniere valeur hors champ.
						$DATA=self::RawConverter($this->DumpAfter, $ArchiveStrRaw);
						echo implode("\t",$DATA)."\n";
						$DATAS[]=$DATA;
					}
				}
			}
			
			
			
			
			
			
			
			
		}
		catch (Exception $e) {
			Tools::Waiting (0, $e->getMessage());
		}
		return $data;
	}

}






























?>