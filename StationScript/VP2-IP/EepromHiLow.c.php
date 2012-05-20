<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 24, 25,26)
/// 2. HILOW data format
/// The "HILOWS" command sends a 436 byte data packet and a 2 byte CRC value. The data packet is
/// broken up into sections of related data values.
// ##############################################################################################

class GETER extends abstract_VP2_Tools
{
	function __construct($name, $myConfig)	{
		$this->setStationFolder( dirname(__FILE__).DIRECTORY_SEPARATOR );
/*		$this->IP = $myConfig['IP'];
		$this->Port = $myConfig['Port'];*/
		$this->conf = $myConfig;
// 		$this->setStationConfig($stationConfig);
		require ($this->StationFolder.'Tools.h.php');
		require ($this->StationFolder.'EepromDumpAfter.h.php');
		require ($this->StationFolder.'EepromLoop.h.php');
		require ($this->StationFolder.'EepromHiLow.h.php');
		require ($this->StationFolder.'EepromConfig.h.php');	
	}
	function GET_HILOWS()	{
		fwrite ($this->fp, "HILOWS\n");
		$r = fread($this->fp, 1);
		if ($r == Tools::symb['ACK'])
		{
			$HILOWS = fread($this->fp, 438);
			if (strlen($HILOWS)==438 && (Tools::CalculateCRC($HILOWS))==0x0000)
			{
				Tools::Waiting (0,'[HILOWS] : Download Mini and Maxi');
				$x = array();
				foreach($this->HiLow as $key=>$val)
				{
					$StrValue = substr ($HILOWS, $val['pos'], $val['len']);
// 						Tools::Waiting (0,$key.'['.strlen($StrValue).'] : '.$val['fn'].'('.$StrValue.');  '.$val['fn'].'('.$this->hexToDec($StrValue).');'); 
					$mesure = $this->$val['fn'] ($StrValue);
					if ($mesure != $val['err'] && $mesure >= $val['min'] && $mesure <= $val['max'] || is_array($mesure)) {
						if (!empty($val['SI'])) { 
							$x[$key] = $this->$val['SI'] ($mesure);
						}
						else
							$x[$key] = $mesure;
					}
					else
						$x[$key] = NULL;
				}
				return $x;
			}
			else
				Tools::Waiting (0,'[HILOWS] : Erreur de CRC');
		}
		else if ($r == Tools::symb['NAK'])
		{
			Tools::Waiting (0,'[HILOWS] : Erreur de NAK');
		}
		else
		{
			fread($this->fp, 666);
				Tools::Waiting (0,'[HILOWS] : unknown Error');
		}
		return FALSE;
	}
	function GET_Confs()
	{
		$a = $this->EEBRD(0, 177);
		if (is_array($a)){
			$b = $this->EEBRD(4092, 1);
			if (is_array($b)){
				$EE = array_merge($a, $b, $a['UnitBits'], $a['SetupBits']);
				unset($EE['UnitBits']);
				unset($EE['SetupBits']);
				return $EE;
			}
			else return false;
		}
		else return false;
	}

	function EEBRD($Pos=0, $Len=177)	{
		$P=str_pad(strtoupper(dechex($Pos)),3,'0',STR_PAD_LEFT);
		$L=str_pad(strtoupper(dechex($Len)),2,'0',STR_PAD_LEFT);
		fwrite ($this->fp, "EEBRD $P $L\n");
		$r = fread($this->fp, 1);
		if ($r == Tools::symb['ACK'])
		{
			$StrEE = fread($this->fp, $Len);
			$CRC = fread($this->fp, 2);
			if (strlen($StrEE)==$Len && $CRC==Tools::CalculateCRC($StrEE))
			{
				Tools::Waiting (0,"[EEBRD] $P $L: OK");
				$x = array();
				foreach($this->EEPROM as $key=>$val)
				{
					if ($val['pos'] >= $Pos && $val['pos'] < $Pos+$Len) {
						$StrValue = substr ($StrEE, $val['pos']-$Pos, $val['len']);
// 						Tools::Waiting (0,$key.'['.strlen($StrValue).'] : '.$val['fn'].'('.$StrValue.');  '.$val['fn'].'('.$this->hexToDec($StrValue).');'); 
						$mesure = $this->$val['fn'] ($StrValue);
						if ($mesure != $val['err'] && $mesure >= $val['min'] && $mesure <= $val['max'] || is_array($mesure)) {
							if (!empty($val['SI'])) { 
								$x[$key] = $this->$val['SI'] ($mesure);
							}
							else
								$x[$key] = $mesure;
						}
						else
							$x[$key] = NULL;
					}
				}
				return $x;
			}
			else {
				Tools::Waiting (0,'[EEBRD] : CRC Error > '.strlen($StrEE));
			}
			return FALSE;
		}
		else if ($r == Tools::symb['NAK'])
		{
			Tools::Waiting (0,'[EEBRD] : Erreur de NAK');
		}
		else
		{
			fread($this->fp, 666);
				Tools::Waiting (0,'[EEBRD] : unknown Error');
		}
		return FALSE;
	}
	function GET_LOOP($nbr=1)
	{
		$_NBR = $nbr;	
		fwrite ($this->fp, "LOOP $nbr\n");
		$r = fread($this->fp, 1);
		if ($r == Tools::symb['ACK'])
		{
			while ($nbr-- > 0)
			{
				$LOOP = fread($this->fp, 99);
				if (strlen($LOOP)==99 && !Tools::CalculateCRC($LOOP))
				{
					Tools::Waiting (0,'[LOOP] : Download the current Values');
					$x = array();
					foreach($this->Loop as $key=>$val)
					{
						$StrValue = substr ($LOOP, $val['pos'], $val['len']);
// 						Tools::Waiting (0,$key.'['.strlen($StrValue).'] : '.$val['fn'].'('.$StrValue.');  '.$val['fn'].'('.$this->hexToDec($StrValue).');'); 
						$mesure = $this->$val['fn'] ($StrValue);
						if ($mesure != $val['err'] && $mesure >= $val['min'] && $mesure <= $val['max'] || is_array($mesure)) {
							if (!empty($val['SI'])) { 
								$x[$key] = $this->$val['SI'] ($mesure);
							}
							else
								$x[$key] = $mesure;
						}
						else
							$x[$key] = NULL;
					}
					echo implode("\t",$LOOP=$x)."\n";
				}
				else
					Tools::Waiting (0,'[LOOP] : Erreur de CRC');
				if ($nbr > 0) sleep(1);
				$LOOPS[]=$LOOP;
			}
			return $LOOPS;
		}
		else if ($r == Tools::symb['NAK'])
		{
			Tools::Waiting (0,'[LOOP] : Erreur de NAK');
		}
		else
		{
			fwrite ($this->fp, Tools::symb['CR']); // Cancel this command
			fread($this->fp, 666)
			Tools::Waiting (0,'[LOOP] : unknown Error');
		}
		return FALSE;
	}
	function GET_DMPAFT ($last='2012/01/01 00:00:00')	{
		$dateRegex = '/^20[\d]{2}\/[\d]{2}\/[\d]{2}\s[\d]{2}:[\d]{2}:[\d]{2}$/';
		if (preg_match($dateRegex, $last)!=1)
			$last='2012/01/01 00:00:00';
		fwrite($this->fp,"DMPAFT\n");			// Send the command to VP2 : DumpAfter
		$r = fread($this->fp, 1);			// Read the answer
		if ($r == Tools::symb['ACK'])			// ACK if VP2 understood
		{
			$d = $this->DMPAFT_SetVP2Date($last);
			fwrite($this->fp, $d);				// Send this date
			$crc = Tools::CalculateCRC($d);			// define the CRC of my date
			fwrite($this->fp, $crc);			// Send this CRC
			$r = fread($this->fp, 1);			// Read the answer
			if ($r == Tools::symb['ACK'])			// ACK if VP2 confirm the CRC
			{
				$r = fread($this->fp, 6);		// Read the answer
				if (strlen($r)==6 && Tools::CalculateCRC($r)==0x0000)
				{
					$nbrArch=0;
					$LastArchDate = 0;
					$retry = $this->retry-1;
					$nbrPages = $this->hexToDec (strrev(substr($r,0,2)));		// Split Bytes in revers order : Nbr of page
					$firstArch = $this->hexToDec (strrev(substr($r,2,2)));		// Split Bytes in revers order : # of first archive
					Tools::Waiting (0,'There are '.$nbrPages.'p. in queue, from archive '.$firstArch.' on first page since '.$last.'.');
					fwrite($this->fp, Tools::symb['ACK']);	// Send ACK to start
					for ($j=0;$j<$nbrPages;$j++)
					{
						$Page = fread($this->fp, 267);
						Tools::Waiting (0,'Download Archive PAGE #'.$j.' since : '.$this->DMPAFT_GetVP2Date(substr($Page,1+52*($firstArch),4)));
						if (strlen($Page)==267 && Tools::CalculateCRC($Page)==0x0000)
						{
							fwrite ($this->fp, Tools::symb['ACK']);
							for ($k=$firstArch; $k<=4; $k++)
							{
								$ArchiveStrRaw = substr ($Page, 1+52*$k, 52);
								$ArchDate = $this->DMPAFT_GetVP2Date(substr($ArchiveStrRaw,0,4));
								
								if (strtotime($ArchDate) > strtotime($LastArchDate)) // && strtotime($ArchDate) > strtotime($last))
								{// ignore les 1er et derniere valeur hors champ.
									$x = array();
									foreach($this->DumpAfter as $key=>$val)
									{
										$StrValue = substr ($ArchiveStrRaw, $val['pos'], $val['len']);
				// 						Tools::Waiting (0,$key.'['.strlen($StrValue).'] : '.$val['fn'].'('.$StrValue.');  '.$val['fn'].'('.$this->hexToDec($StrValue).');'); 
										$mesure = $this->$val['fn'] ($StrValue);
/*										if ($val['pos']==4 || $val['pos']==6 || $val['pos']==8)
											Tools::Waiting (0,$StrValue.' = '.bin2hex($StrValue).' = '.($this->hexToDec($StrValue)/10).' = '.$this->tempSI($this->hexToDec($StrValue)/10).' >> '.strrev($StrValue).' = '.bin2hex(strrev($StrValue)).' = '.($this->hexToDec(strrev($StrValue))/10).' = '.$this->tempSI($this->hexToDec(strrev($StrValue))/10));*/
										if ($mesure != $val['err'] && $mesure >= $val['min'] && $mesure <= $val['max'] || is_array($mesure)) {
											if (!empty($val['SI'])) {
												$x[$key] = $this->$val['SI'] ($mesure);
											}
											else
												$x[$key] = $mesure;
										}
										else
											$x[$key] = NULL;
									}
									var_export($x);
									echo implode("\t",$x)."\n";
									Tools::Waiting (0,'Page #'.$j.'-'.$k.' of '.$ArchDate.' archived Ok.');
									$LastArchDate = $ArchDate;
								}
								else {
									Tools::Waiting (0,'Page #'.$j.'-'.$k.' of '.$ArchDate.' Ignored (Out of Range).');
								}
							}
							$retry = $this->retry;
							$firstArch=0;
						}
						else
						{
							if (!$retry)
							{
								Tools::Waiting (0,'Page #'.$j.' invalide, Aborting Download.');
								fread($this->fp, 666); // vidange
								fwrite($this->fp, Tools::symb['ESC']);
								return $LastArchDate;
							}
							else
							{
								$this->wakeUp();
								$vidange = fread($this->fp, 666); // vidange
								Tools::Waiting (100,'Page #'.$j.' invalide by wrong CRC ('.strlen($vidange).'-'.strlen($Page).'), retry. '.$retry);
								fwrite($this->fp, Tools::symb['NAK']);
								$retry--;
								$j--;
							}
						}
					}
					Tools::Waiting (0,'Download '.$nbrPages.' Archives PAGES.');
					return $LastArchDate;
				}
				else if ($r == Tools::symb['NAK'])
					Tools::Waiting (0,'DMPAFT Pages : NAK on first page, wrong Date or CRC!');
				else
				{
					Tools::Waiting (0,'DMPAFT Pages : NULL!');
					fread($this->fp, 666); // vidange
					Tools::Waiting (8);
				}
			}
			else if ($r == Tools::symb['NAK'])
				Tools::Waiting (0,'DMPAFT Date : NAK Bad CRC16!');
			else
			{
				Tools::Waiting (0,'DMPAFT Date : NULL!');
				fread($this->fp, 666); // vidange
				Tools::Waiting (8);
			}
		}
		else if ($r == Tools::symb['NAK'])
			Tools::Waiting (0,'DMPAFT NAK : Bad Command!');
		else
		{
			Tools::Waiting (0,'DMPAFT NULL!');
			fread($this->fp, 666); // vidange
			Tools::Waiting (8);
		}
		return FALSE;
	}

}
?>