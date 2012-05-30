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
// 			echo $val['fn']." = ";
			$returnValue = call_user_func($val['fn'], $StrValue);
// 			$returnValue = eval('return '.$val['fn'].' ($StrValue);');
// 			echo $returnValue."\n";
			$x[]=$returnValue;
		}
		
		return $x;
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
				$LOOPS[date('Y/m/d H:i:s')]=self::RawConverter($this->Loop, $data);
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
	function GetDmpAft($last='2012/01/01 00:00:00') { //
		try {
			$DATAS=false;
			$firstDate2Get=Tools::is_date($last);
			self::RequestCmd("DMPAFT\n");
			$RawDate = Tools::DMPAFT_SetVP2Date($firstDate2Get);
			fwrite($this->fp, $RawDate);				// Send this date (parametre #1)
			$crc = Tools::CalculateCRC($RawDate);			// define the CRC of my date
			self::RequestCmd($crc);					// Send the CRC (parametre #2)
			$data = fread($this->fp, 6);				// we read the properties : item count and first item position
			self::VerifAnswersAndCRC($data, 6);
// 			$nbrArch=0;
			$LastArchDate = 0;
// 			$retry = $this->retry-1;
			$nbrPages = Tools::hexToDec (strrev(substr($data,0,2)));	// Split Bytes in revers order : Nbr of page
			$firstArch = Tools::hexToDec (strrev(substr($data,2,2)));	// Split Bytes in revers order : # of first archived
				Tools::Waiting (0,'There are '.$nbrPages.'p. in queue, from archive '.$firstArch.' on first page since '.$last.'.');
			fwrite($this->fp, Tools::ACK);				// Send ACK to start
			for ($j=0; $j<$nbrPages; $j++) {
				if ( !((time()+10)%300) ) {
				// la recuperation des archives bloque la lecture des capteurs donc on le fait par petit bout
					throw new Exception(_('Please retry later to finish, Data sensors must be checked in few second.'));
				}
				$Page = fread($this->fp, 267);
				Tools::Waiting (0,'Download Archive PAGE #'.$j.' since : '.Tools::DMPAFT_GetVP2Date(substr($Page,1+52*($firstArch),4)));
				self::VerifAnswersAndCRC($Page, 267);
				fwrite ($this->fp, Tools::ACK);
				for ($k=$firstArch; $k<=4; $k++) {			// ignore les 1er valeur hors champ.
					$ArchiveStrRaw = substr ($Page, 1+52*$k, 52);
					$ArchDate = Tools::DMPAFT_GetVP2Date(substr($ArchiveStrRaw,0,4));
					if (strtotime($ArchDate) > strtotime($LastArchDate)) {
					// ignore les derniere valeur hors champ, car on parcoure une liste circulaire
					// donc la deniere valeur a extraire precede la plus vielle valleur de cette liste
						$DATAS[$ArchDate] = self::RawConverter($this->DumpAfter, $ArchiveStrRaw);
						Tools::Waiting (0,'Page #'.$j.'-'.$k.' of '.$ArchDate.' archived Ok.');
						$LastArchDate = $ArchDate;
					}
					else {
						throw new Exception(sprintf(_('Page #%d-%d of %s Ignored (Out of Range).'),$j, $k, $ArchDate));
					}
					$firstArch=0;
				}
			}
			return $DATAS;
		}
		catch (Exception $e) {
			Tools::Waiting (0, $e->getMessage());
			return $DATAS;
		}
		return false;
	}
	/*
	@description: functionDescription
	@return: functionReturn
	@param: returnValue
	*/
	function GetConfig() { //
		
		return $CONFS;
	}
}































?>