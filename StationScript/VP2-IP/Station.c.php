<?php	//	clear;php5 -f ./Station.phpc

class station
{
	protected $KeyConf=NULL;	// FileConf of this Vantage Pro2
	protected $fp=NULL;	// Pointer of VP2 Connection
	protected $symb=NULL;
	protected $StationFolder=NULL;
	protected $StationConfig=NULL;
	protected $retry=3;	// number of attempts before aborting
	protected $backLightScreen=FALSE; // actual state of backlight screen
	protected $table = null;
	public $DumpAfter = null;
	public $Loop = null;
	public $HiLow = null;
	protected $EEPROM = null;
	protected $Trend = null;
	public $_version = 0.09;

	function __construct($stationConfig, $name)	{
		$this->setKeyConf($name);
		$this->setStationConfig($stationConfig);
		$this->setStationFolder( dirname(__FILE__).DIRECTORY_SEPARATOR );
		require ($this->StationFolder.'Station.h.php');
	}
	public function initConnection()	{
		$errno = 0;
		$this->fp = @fsockopen(
			$this->getStationIP(),
			$this->getStationPort(),
			&$errno
		);

		if ($this->fp && $errno==0)
		{
			stream_set_timeout($this->fp, 0, 2500000);
			if ($this->wakeUp())
			{
				$this->toggleBacklight(1);
				return TRUE;
			}
		}
		return FALSE;
	}
	protected function wakeUp()	{
		for ($i=0;$i<=$this->retry;$i++)
		{
			fwrite ($this->fp,$this->symb['LF']);

			if (fread($this->fp,6)==$this->symb['LFCR'])
				return TRUE;
			usleep(1200000);
		}
		return FALSE;
	}
	protected function toggleBacklight($force=-1) {
		if ($force==-1)
		{
			fwrite ($this->fp,'LAMPS '.(($this->backLightScreen)?'0':'1').$this->symb['LF']);
		} else
		{
			fwrite ($this->fp,'LAMPS '.($force?'1':'0').$this->symb['LF']);
		}
		if (fread($this->fp,6)==$this->symb['_OK_'])
		{
			if ($force==-1)$this->backLightScreen = !$this->backLightScreen;
			else $this->backLightScreen = $force;
			return TRUE;
		}
		return FALSE;
	}
	function Read_Configs() {
		$cmd = array();
		foreach($this->EEPROM as $key=>$val)
		{
			if (is_array($val))
				$cmd[$key] = $this->GET_EEPROM($key);
			else
				$cmd[$key] = $this->GET_info($key);
			if ($cmd[$key])
			{
				$this->StationConfig[$this->getKeyConf()]['Last_Read_Config'] = date('Y/m/d H:i:s');
				$this->StationConfig[$this->getKeyConf()][$key] = $cmd[$key];
				$this->SaveConfs();
			}
		}
		return $cmd;
	}
	function PUT_infos($cmd) { // $cmd = array('PUTRAIN'=>'', 'PUTET'=>'', 'BAR'=>'', 'SETPER'=>'');
		foreach($cmd as $key=>$val)
		{
			$cmd[$key] = $this-PUT_info($key);
		}
		return $cmd;
	}
	private function GET_info($cmd) { // VER, NVER, RXCHECK, BARDATA
		fwrite ($this->fp, strtoupper($cmd)."\n");
		if (fread($this->fp,6)==$this->symb['_OK_'])
		{
			$val = fread($this->fp,99);
			$this->Waiting (0,'GET_info '.$cmd.' : OK');
			return eval('return '.$this->EEPROM[$cmd].';');
		}
		$this->Waiting (0,'GET_info : Answer Error');
		return FALSE;
	}
	function GET_EEPROM_4K() {
		fwrite ($this->fp, strtoupper('GETEE'."\n");
		$r = fread($this->fp, 1);
		if ($r == $this->symb['ACK'])
		{
			$EE = fread($this->fp, 4096);
			$CRC = fread($this->fp, 2);
			if (strlen($EE)==4096 && $CRC==$this->CalculateCRC($EE))
			{
				$this->Waiting (0,'GET_EEPROM_4K : OK');
				$this->StationConfig[$this->getKeyConf()]['Last_GET_EEPROM_4K'] = date('Y/m/d H:i:s');
				$this->SaveConfs();
				echo implode("\t",$this->ConvertStrRaw($EE))."\n";
				return $this->EE;
			}
			$this->Waiting (0,'GET_EEPROM_4K : CRC Error');
			return False;
		}
		$this->Waiting (0,'GET_EEPROM_4K : Answer Error');
		return FALSE;
	}
	function GET_EEPROM($cmd) {
		fwrite ($this->fp, strtoupper('EEBRD '.$this->_EEPROM[$cmd]['pos']).' '.$this->_EEPROM[$cmd]['len']."\n");
		$r = fread($this->fp, 1);
		if ($r == $this->symb['ACK'])
		{
			$EEBRD = fread($this->fp, $this->_EEPROM[$cmd]['len']+2);
			if (strlen($EEBRD)==$this->_EEPROM[$cmd]['len']+2 && !$this->CalculateCRC($EEBRD))
			{
				$val = $this->hexToDec(strrev(substr($EEBRD, 0,-2)));
// 				$this->Waiting (0, decbin($val));
				$this->Waiting (0,'GET_EEPROM '.$cmd.' : OK');
				return eval('return '.$this->_EEPROM[$cmd]['eval'].';');
			}
			$this->Waiting (0,'GET_EEPROM : CRC Error');
			return False;
		}
		$this->Waiting (0,'GET_EEPROM : Answer Error');
		return FALSE;
	}
	private function PUT_info($cmd) { // PUTRAIN, PUTET, BAR=P H, SETPER
		fwrite ($this->fp, strtoupper($cmd)."\n");
		$r = fread($this->fp, 1);
		if ($r == $this->symb['ACK'])
		{
			$this->Waiting (0,'PUT_info '.$cmd.' : OK');
			return true;
		}
		$this->Waiting (0,'PUT_info : Answer Error');
		return FALSE;
	}
	function CloseConnection()	{
		$this->StationConfig[$this->getKeyConf()]['Last_Connected'] = date('Y/m/d H:i:s');
		$this->SaveConfs();
		$this->toggleBacklight(0);
		fclose($this->fp);
		return TRUE;
	}
	function Get_LOOP_Raw($nbr=1)	{
		$_NBR = $nbr;
		fwrite ($this->fp, "LOOP $nbr\n");
		$r = fread($this->fp, 1);
		if ($r == $this->symb['ACK'])
		{
			while ($nbr-- > 0)
			{
				$LOOP = fread($this->fp, 99);
				if (strlen($LOOP)==99 && !$this->CalculateCRC($LOOP))
				{
// 					$LOOP = substr($LOOP,0,-2);
					$this->Waiting (0,'LOOP : Download the current Values');
// 					file_put_contents($this->StationFolder.'../../ExportedData/LOOP['.($_NBR-$nbr).'].brut',$LOOP);
					$this->StationConfig[$this->getKeyConf()]['Last_LOOP'] = date('Y/m/d H:i:s');
					$this->SaveConfs();
					echo implode("\t",$this->ConvertStrRaw($LOOP))."\n";
				}
				else
					$this->Waiting (0,'LOOP : Erreur de CRC');
				if ($nbr > 0) sleep(1);
			}
			return true;
		}
		else if ($r == $this->symb['NAK'])
		{
			$this->Waiting (0,'LOOP : Erreur de NAK');
		}
		else
		{
			fwrite ($this->fp, $this->symb['CR']); // Cancel this command
			fread($this->fp, 999);
			$this->Waiting (0,'LOOP : unknown Error');
		}
		return true;
	}
	function Get_HILOWS_Raw()	{
		fwrite ($this->fp, "HILOWS\n");
		$r = fread($this->fp, 1);
		if ($r == $this->symb['ACK'])
		{
			$HILOWS = fread($this->fp, 438);
			if (strlen($HILOWS)==438 && ($this->CalculateCRC($HILOWS))==0x0000)
			{
// 				$HILOWS = substr($HILOWS,0,-2);
				$this->Waiting (0,'HILOWS : Download Mini and Maxi');
// 				file_put_contents($this->StationFolder.'../../ExportedData/HILOWS.brut',$HILOWS);
				$this->StationConfig[$this->getKeyConf()]['Last_HILOWS'] = date('Y/m/d H:i:s');
				$this->SaveConfs();
				echo implode("\t",$this->ConvertStrRaw($HILOWS))."\n";
				return true;
			}
			else
				$this->Waiting (0,'HILOWS : Erreur de CRC');
		}
		else if ($r == $this->symb['NAK'])
		{
			$this->Waiting (0,'HILOWS : Erreur de NAK');
		}
		else
		{
			fread($this->fp, 999);
				$this->Waiting (0,'HILOWS : unknown Error');
		}
		return true;
	}
	function fetchStationTime()	{// 0x35 16 00 1d 0c 6f  0x7c 44  ==  2011/12/29 00:22:53
		fwrite ($this->fp, "GETTIME\n");
		$r = fread($this->fp, 1);
		if ($r == $this->symb['ACK'])
		{
			$GETTIME = fread($this->fp, 8);
			if (strlen($GETTIME)==8 && $this->CalculateCRC($GETTIME)==0x0000)
			{
				$GETTIME = (ord($GETTIME[5])+1900).'/'.str_pad(ord($GETTIME[4]),2,'0',STR_PAD_LEFT).'/'.str_pad(ord($GETTIME[3]),2,'0',STR_PAD_LEFT).' '.str_pad(ord($GETTIME[2]),2,'0',STR_PAD_LEFT).':'.str_pad(ord($GETTIME[1]),2,'0',STR_PAD_LEFT).':'.str_pad(ord($GETTIME[0]),2,'0',STR_PAD_LEFT);
				$this->Waiting (0, 'Real Time : '.date('Y/m/d H:i:s').' vs GETTIME : '.$GETTIME);
				return $GETTIME;
			}
			else
				$this->Waiting (0,'GETTIME : Erreur de CRC');
		}
		else
		{
			fread($this->fp, 999);
				$this->Waiting (0,'GETTIME : unknown Error');
		}
		return false;
	}
	function updateStationTime()	{// 0x35 16 00 1d 0c 6f  0x7c 44  ==  2011/12/29 00:22:53
		fwrite ($this->fp, "SETTIME\n");
		$r = fread($this->fp, 1);
		if ($r == $this->symb['ACK'])
		{
			list($_date, $_clock) = explode(' ', date('Y/m/d H:i:s'));
			list($y,$m,$d) = explode('/', $_date);
			list($h,$i,$s) = explode(':', $_clock);
			$SETTIME = chr($s).chr($i).chr($h).chr($d).chr($m).chr($y-1900);
			$crc = $this->CalculateCRC($SETTIME);
			fwrite ($this->fp, $SETTIME.$crc);
			$r = fread($this->fp, 1);
			if ($r == $this->symb['ACK'])
			{
				$this->Waiting (0,'SETTIME : '.$_date.' '.$_clock);
				$this->StationConfig[$this->getKeyConf()]['Last_SETTIME'] = $_date.' '.$_clock;
				$this->SaveConfs();
				return $_date.' '.$_clock;
			}
			else
				$this->Waiting (0,'SETTIME : invalid date.');
		}
		else
		{
			fread($this->fp, 999);
				$this->Waiting (0,'SETTIME : unknown Error');
		}
		return FALSE;
	}
	function Get_DMPAFT_Raw()	{
		fwrite($this->fp,"DMPAFT\n");			// Send the command to VP2 : DumpAfter
		$r = fread($this->fp, 1);			// Read the answer
		if ($r == $this->symb['ACK'])			// ACK if VP2 understood
		{
			$d = $this->DMPAFT_SetVP2Date($this->StationConfig[$this->getKeyConf()]['Last_DMPAFT']); // define date of first archives record
			fwrite($this->fp, $d);				// Send this date
			$crc = $this->CalculateCRC($d);		// define the CRC of my date
			fwrite($this->fp, $crc);			// Send this CRC
			$r = fread($this->fp, 1);			// Read the answer
			if ($r == $this->symb['ACK'])			// ACK if VP2 confirm the CRC
			{
				$r = fread($this->fp, 6);			// Read the answer
				if (strlen($r)==6 && $this->CalculateCRC($r)==0x0000)
				{
					$nbrArch=0;
					$retry = $this->retry;
					$nbrPages = $this->hexToDec (strrev(substr($r,0,2)));		// Split Bytes in revers order : Nbr of page
					$firstArch = $this->hexToDec (strrev(substr($r,2,2)));		// Split Bytes in revers order : # of first archive
					$this->Waiting (0,'There are '.$nbrPages.'p. in queue, from archive '.$firstArch.' on first page.');
					fwrite($this->fp, $this->symb['ACK']);	// Send ACK to start
					for ($j=0;$j<$nbrPages;$j++)
					{
						$Page = fread($this->fp, 267);
						$this->Waiting (0,'Download Archive PAGE #'.$j.' since : '.$this->DMPAFT_GetVP2Date(substr($Page,1,4)));
						if (strlen($Page)==267 && $this->CalculateCRC($Page)==0x0000)
						{
							fwrite($this->fp, $this->symb['ACK']);
							for($k=$firstArch;$k<=4;$k++)
							{
								$ArchiveStrRaw=substr($Page,1+52*$k,52);
								$ArchDate = $this->DMPAFT_GetVP2Date(substr($ArchiveStrRaw,0,4));
								if (strtotime($ArchDate) > strtotime($this->StationConfig[$this->getKeyConf()]['Last_DMPAFT']))
								{
// 									$this->Waiting (0,"\t".'ARCHIVE #'.($nbrArch++).' of '.$ArchDate.' saved.');
// 									var_export ($this->ConvertStrRaw($ArchiveStrRaw));
									echo implode("\t",$this->ConvertStrRaw($ArchiveStrRaw))."\n";
									$this->StationConfig[$this->getKeyConf()]['Last_DMPAFT'] = $ArchDate;
								}
							}
							$this->SaveConfs();
							$retry = $this->retry;
							$firstArch=0;
						}
						else
						{
							if (!$retry)
							{
								$this->Waiting (0,'Page #'.$j.' invalide, Aborting Download.');
								fread($this->fp, 999); // vidange
								fwrite($this->fp, $this->symb['ESC']);
								return false;
							}
							else
							{
								$vidange = fread($this->fp, 999); // vidange
								$this->Waiting (100,'Page #'.$j.' invalide by wrong CRC ('.strlen($vidange).'-'.strlen($Page).'), retry. '.$retry);
								fwrite($this->fp, $this->symb['NAK']);
								$retry--;
								$j--;
							}
						}
					}
					return true;
				}
				else if ($r == $this->symb['NAK'])
					$this->Waiting (0,'DMPAFT Pages : NAK on first page, wrong Date or CRC!');
				else
				{
					$this->Waiting (0,'DMPAFT Pages : NULL!');
					fread($this->fp, 999); // vidange
					$this->Waiting (8);
				}
			}
			else if ($r == $this->symb['NAK'])
				$this->Waiting (0,'DMPAFT Date : NAK Bad CRC16!');
			else
			{
				$this->Waiting (0,'DMPAFT Date : NULL!');
				fread($this->fp, 999); // vidange
				$this->Waiting (8);
			}
		}
		else if ($r == $this->symb['NAK'])
			$this->Waiting (0,'DMPAFT NAK : Bad Command!');
		else
		{
			$this->Waiting (0,'DMPAFT NULL!');
			fread($this->fp, 999); // vidange
			$this->Waiting (8);
		}
		return true;
	}

/**
	#########################################################################################
	#########		Function for manage Variable and Conf-File		#########
	#########################################################################################
**/
	function DMPAFT_SetVP2Date ($StrDate)	{// 2003/06/19 09:30:00  =>  0x03A2 0x06D3
		$y = substr($StrDate, 0, 4);
		$m = substr($StrDate, 5, 2);
		$d = substr($StrDate, 8, 2);
		$h = substr($StrDate, -8, 2);
		$min = substr($StrDate, -5, 2);
		$s = substr($StrDate, -2);
		$d = ((($y-2000)*512+$m*32+$d)<<16) + ($h*100+$min);							// settype($d, 'integer');
// 		$d = chr(($d&0xff000000)>>24).chr(($d&0xff0000)>>16).chr(($d&0xff00)>>8).chr($d&0xff);	// settype($d, 'string');
		$d = chr(($d&0xff0000)>>16).chr(($d&0xff000000)>>24).chr($d&0xff).chr(($d&0xff00)>>8);	// Reverse version
		return $d;
	}
	function Raw2Date ($DateStamp){
		$DateStamp = $this->hexToDec(strrev($DateStamp));
		$y = (($DateStamp & 0xFE00)>>9)+2000;
		$m = str_pad(($DateStamp & 0x01E0)>>5,2,'0',STR_PAD_LEFT);
		$d = str_pad($DateStamp & 0x1f,2,'0',STR_PAD_LEFT);
		return $y.'/'.$m.'/'.$d;
	}
	function Raw2Time ($TimeStamp){
		$TimeStamp = $this->hexToDec(strrev($TimeStamp));
		$h = str_pad((int)($TimeStamp/100),2,'0',STR_PAD_LEFT);
		$min = str_pad($TimeStamp-$h*100,2,'0',STR_PAD_LEFT);
		return $h.':'.$min.':00';
	}
	function DMPAFT_GetVP2Date ($VP2Date)	{// 2003/06/19 09:30:00  <=  0x03A2 0x06D3
		return $this->Raw2Date(substr($VP2Date,0,2)).' '.$this->Raw2Time(substr($VP2Date,-2));
	}
	function CalculateCRC($ptr)	{
		$crc = 0x0000;
		settype($crc, "integer");
		for ($i = 0; $i < strlen($ptr); $i++)
		{
			$crc =  $this->table[(($crc>>8) ^ ord($ptr[$i]))] ^ (($crc<<8) & 0x00FFFF);
// 			$this->waiting(0,ord($ptr[$i]).' : '.dechex($this->table[(($crc>>8) ^ ord($ptr[$i]))]).' > '.dechex($crc>>8).' '.dechex($crc&0xff));
		}
		return !$crc?$crc:chr($crc>>8).chr($crc&0xff);
	}
	function Waiting ($s=10, $msg = 'Waiting and retry')	{
		$w = '-\|/';
		if ($s==0)
			echo "\r".date('Y/m/d H:i:s u')."\t".$msg;
		for ($j=0;$j<$s;$j++)
		{
			usleep(100000);
			echo "\r".date('Y/m/d H:i:s u')."\t".$msg.' '.$w[$j%4];
		}
		echo "\n";
	}
	function hexToDec($hex)	{
		return hexdec(bin2hex($hex));
	}
	private function SaveConfs ()	{
		$confs = $this->getStationConfig();
		$confs[$this->getKeyConf()] = $this->StationConfig[$this->getKeyConf()];
		file_put_contents (dirname(__FILE__).DIRECTORY_SEPARATOR.'../../stations.conf', var_export($confs,true));
		return true;
	}
	private function GetConf ()	{
		return eval('return '.file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../stations.conf').';');
	}
	function setKeyConf($value)	{ $this->KeyConf = $value; }
	function getKeyConf()		{ return $this->KeyConf; }

	function setStationConfig($value)	{ $this->StationConfig = $value; }
	function getStationConfig()		{ return $this->StationConfig; }

	function setStationFolder($value)	{ $this->StationFolder = $value; }
	function getStationFolder()		{ return $this->StationFolder; }

	function getStationIP()		{ return $this->StationConfig[$this->getKeyConf()]['IP']; }
	function getStationPort()	{ return $this->StationConfig[$this->getKeyConf()]['Port']; }
}
?>
