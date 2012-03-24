<?php	// clear;php5 -f ./StationScript/VP2-IP/index.php

class station
{
	protected $fp=NULL;	// Pointer of VP2 Connection
	protected $symb=NULL;
	protected $StationFolder=NULL;
// 	protected $StationConfig=NULL;
	protected $retry=3;	// number of attempts before aborting
	protected $backLightScreen=FALSE; // actual state of backlight screen
	protected $table = null;
	public $DumpAfter = null;
	public $Loop = null;
	public $HiLow = null;
	protected $EEPROM = null;
	protected $Trend = null;
	protected $IP = null;
	protected $Port = null;
	public $_version = 0.10;


	function __construct($name, $myConfig)	{
		$this->setStationFolder( dirname(__FILE__).DIRECTORY_SEPARATOR );
		$this->IP = $myConfig['IP'];
		$this->Port = $myConfig['Port'];
// 		$this->setStationConfig($stationConfig);
		require ($this->StationFolder.'Tools.h.php');
		require ($this->StationFolder.'EepromDumpAfter.h.php');
		require ($this->StationFolder.'EepromLoop.h.php');
		require ($this->StationFolder.'EepromHiLow.h.php');
		require ($this->StationFolder.'EepromConfig.h.php');	
	}
	
// 	function SaveConfs ()	{
// 		$confs = $this->getStationConfig();
// 		$confs[$this->getKeyConf()] = $this->StationConfig[$this->getKeyConf()];
// 		file_put_contents (dirname(__FILE__).DIRECTORY_SEPARATOR.'../../stations.conf', var_export($confs,TRUE));
// 		return TRUE;
// 	}
// 	function GetConf ()	{
// 		return eval('return '.file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../stations.conf').';');
// 	}
	
// 	function setStationConfig($value)	{ $this->StationConfig = $value; }
// 	function getStationConfig()		{ return $this->StationConfig; }
// 
	function setStationFolder($value)	{ $this->StationFolder = $value; }
	function getStationFolder()		{ return $this->StationFolder; }
// 

	public function initConnection()	{
		for ($i=1;$i>=0;$i--){
			$errno = 0;
			$this->fp = @fsockopen(
				$this->IP,
				$this->Port,
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
				else
				{
					sleep(2*$i);
					$this->CloseConnection();
					sleep(2*$i);
				}
			}
		}
		return FALSE;
	}
	protected function wakeUp()	{
		for ($i=0;$i<=$this->retry;$i++) {
			fwrite ($this->fp,$this->symb['LF']);

			if (fread($this->fp,6)==$this->symb['LFCR'])
				return TRUE;
			usleep(1200000);
		}
		return FALSE;
	}
	protected function toggleBacklight($force=-1) {
		if ($force==-1) {
			fwrite ($this->fp,'LAMPS '.(($this->backLightScreen)?'0':'1').$this->symb['LF']);
		}
		else {
			fwrite ($this->fp,'LAMPS '.($force?'1':'0').$this->symb['LF']);
		}
		if (fread($this->fp,6)==$this->symb['_OK_']) {
			if ($force==-1)$this->backLightScreen = !$this->backLightScreen;
			else $this->backLightScreen = $force;
			return TRUE;
		}
		return FALSE;
	}

	function CloseConnection()	{
		$this->toggleBacklight(0);
		if (fclose($this->fp))
			return TRUE;
		else return FALSE;
	}

	function EEBRD_Confs()	{
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
		if ($r == $this->symb['ACK'])
		{
			$StrEE = fread($this->fp, $Len);
			$CRC = fread($this->fp, 2);
			if (strlen($StrEE)==$Len && $CRC==$this->CalculateCRC($StrEE))
			{
				$this->Waiting (0,"[EEBRD] $P $L: OK");
				$x = array();
				foreach($this->EEPROM as $key=>$val)
				{
					if ($val['pos'] >= $Pos && $val['pos'] < $Pos+$Len) {
						$StrValue = substr ($StrEE, $val['pos']-$Pos, $val['len']);
// 						$this->Waiting (0,$key.'['.strlen($StrValue).'] : '.$val['fn'].'('.$StrValue.');  '.$val['fn'].'('.$this->hexToDec($StrValue).');'); 
						$mesure = $this->$val['fn'] ($StrValue);
						if ($mesure != $val['err'] && $mesure >= $val['min'] && $mesure <= $val['max'] || is_array($mesure))
							$x[$key] = $mesure;
						else
							$x[$key] = NULL;
					}
				}
				return $x;
			}
			else {
				$this->Waiting (0,'[EEBRD] : CRC Error > '.strlen($StrEE));
			}
			return FALSE;
		}
		else if ($r == $this->symb['NAK'])
		{
			$this->Waiting (0,'[EEBRD] : Erreur de NAK');
		}
		else
		{
			fread($this->fp, 666);
				$this->Waiting (0,'[EEBRD] : unknown Error');
		}
		return FALSE;
	}

	function get_LOOP($nbr=1)	{
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
					$this->Waiting (0,'[LOOP] : Download the current Values');
// 					file_put_contents($this->StationFolder.'../../ExportedData/LOOP['.($_NBR-$nbr).'].brut',$LOOP);
					echo implode("\t",$LOOP=$this->ConvertStrRaw($LOOP))."\n";
				}
				else
					$this->Waiting (0,'[LOOP] : Erreur de CRC');
				if ($nbr > 0) sleep(1);
				$LOOPS[]=$LOOP;
			}
			return $LOOPS;
		}
		else if ($r == $this->symb['NAK'])
		{
			$this->Waiting (0,'[LOOP] : Erreur de NAK');
		}
		else
		{
			fwrite ($this->fp, $this->symb['CR']); // Cancel this command
			fread($this->fp, 666);
			$this->Waiting (0,'[LOOP] : unknown Error');
		}
		return FALSE;
	}
	function get_HILOWS()	{
		fwrite ($this->fp, "HILOWS\n");
		$r = fread($this->fp, 1);
		if ($r == $this->symb['ACK'])
		{
			$HILOWS = fread($this->fp, 438);
			if (strlen($HILOWS)==438 && ($this->CalculateCRC($HILOWS))==0x0000)
			{
// 				$HILOWS = substr($HILOWS,0,-2);
				$this->Waiting (0,'[HILOWS] : Download Mini and Maxi');
// 				file_put_contents($this->StationFolder.'../../ExportedData/HILOWS.brut',$HILOWS);
				echo implode("\t",$HILOWS=$this->ConvertStrRaw($HILOWS))."\n";
				return $HILOWS;
			}
			else
				$this->Waiting (0,'[HILOWS] : Erreur de CRC');
		}
		else if ($r == $this->symb['NAK'])
		{
			$this->Waiting (0,'[HILOWS] : Erreur de NAK');
		}
		else
		{
			fread($this->fp, 666);
				$this->Waiting (0,'[HILOWS] : unknown Error');
		}
		return FALSE;
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
				$this->Waiting (0,'[GETTIME] : Erreur de CRC');
		}
		else
		{
			fread($this->fp, 666);
				$this->Waiting (0,'[GETTIME] : unknown Error '.ord($r).'='.ord($this->symb['ACK']));
		}
		return FALSE;
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
				$this->Waiting (0,'[SETTIME] : '.$_date.' '.$_clock);
				return $_date.' '.$_clock;
			}
			else
				$this->Waiting (0,'[SETTIME] : invalid date.');
		}
		else
		{
			fread($this->fp, 666);
				$this->Waiting (0,'[SETTIME] : unknown Error');
		}
		return FALSE;
	}
	function clockSync($maxLag)
	{
		$realLag = abs(strtotime($station->fetchStationTime()) - strtotime(date('Y/m/d H:i:s')));
		if ($realLag > $maxLag) {	// OK
			$this->Waiting( 0, sprintf( _('[Infos] Default Clock synchronize : %ssec'), $realLag) );
			if ($this->updateStationTime())								// OK
				$this->Waiting (0,_('[Infos] Clock synchronizing.'));					// OK
			else $this->Waiting( 0, _( '[Echec] Clock synch.'));
		}
	}
	function get_DMPAFT($last='2012/01/01 00:00:00')	{
		$dateRegex = '/^20[\d]{2}\/[\d]{2}\/[\d]{2}\s[\d]{2}:[\d]{2}:[\d]{2}$/';
		if (preg_match($dateRegex, $last)!=1)
			$last='2012/01/01 00:00:00';
		fwrite($this->fp,"DMPAFT\n");			// Send the command to VP2 : DumpAfter
		$r = fread($this->fp, 1);			// Read the answer
		if ($r == $this->symb['ACK'])			// ACK if VP2 understood
		{
			$d = $this->DMPAFT_SetVP2Date($last);
			fwrite($this->fp, $d);				// Send this date
			$crc = $this->CalculateCRC($d);			// define the CRC of my date
			fwrite($this->fp, $crc);			// Send this CRC
			$r = fread($this->fp, 1);			// Read the answer
			if ($r == $this->symb['ACK'])			// ACK if VP2 confirm the CRC
			{
				$r = fread($this->fp, 6);		// Read the answer
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
						$this->Waiting (0,'Download Archive PAGE #'.$j.' since : '.$this->DMPAFT_GetVP2Date(substr($Page,1+52*($firstArch),4)));
						if (strlen($Page)==267 && $this->CalculateCRC($Page)==0x0000)
						{
							fwrite($this->fp, $this->symb['ACK']);
							for($k=$firstArch;$k<=4;$k++)
							{
								$ArchiveStrRaw=substr($Page,1+52*$k,52);
								$ArchDate = $this->DMPAFT_GetVP2Date(substr($ArchiveStrRaw,0,4));
								if (strtotime($ArchDate) > strtotime($last))
								{
// 									$this->Waiting (0,"\t".'ARCHIVE #'.($nbrArch++).' of '.$ArchDate.' saved.');
// 									var_export ($this->ConvertStrRaw($ArchiveStrRaw));
									echo implode("\t",$this->ConvertStrRaw($ArchiveStrRaw))."\n";
									$LastArchDate = $ArchDate;
								}
							}
							$retry = $this->retry;
							$firstArch=0;
						}
						else
						{
							if (!$retry)
							{
								$this->Waiting (0,'Page #'.$j.' invalide, Aborting Download.');
								fread($this->fp, 666); // vidange
								fwrite($this->fp, $this->symb['ESC']);
								return $LastArchDate;
							}
							else
							{
								$vidange = fread($this->fp, 666); // vidange
								$this->Waiting (100,'Page #'.$j.' invalide by wrong CRC ('.strlen($vidange).'-'.strlen($Page).'), retry. '.$retry);
								fwrite($this->fp, $this->symb['NAK']);
								$retry--;
								$j--;
							}
						}
					}
					return $LastArchDate;
				}
				else if ($r == $this->symb['NAK'])
					$this->Waiting (0,'DMPAFT Pages : NAK on first page, wrong Date or CRC!');
				else
				{
					$this->Waiting (0,'DMPAFT Pages : NULL!');
					fread($this->fp, 666); // vidange
					$this->Waiting (8);
				}
			}
			else if ($r == $this->symb['NAK'])
				$this->Waiting (0,'DMPAFT Date : NAK Bad CRC16!');
			else
			{
				$this->Waiting (0,'DMPAFT Date : NULL!');
				fread($this->fp, 666); // vidange
				$this->Waiting (8);
			}
		}
		else if ($r == $this->symb['NAK'])
			$this->Waiting (0,'DMPAFT NAK : Bad Command!');
		else
		{
			$this->Waiting (0,'DMPAFT NULL!');
			fread($this->fp, 666); // vidange
			$this->Waiting (8);
		}
		return FALSE;
	}
/**
	#########################################################################################
	#########		Function for manage Variable and Conf-File		#########
	#########################################################################################
**/
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
		echo "$h => int $TimeStamp/100 = ".(int)($TimeStamp/100)."\n";
		return $h.':'.$min.':00';
	}
	function DMPAFT_GetVP2Date ($VP2Date)	{// 2003/06/19 09:30:00  <=  0x03A2 0x06D3
		return $this->Raw2Date(substr($VP2Date,0,2)).' '.$this->Raw2Time(substr($VP2Date,-2));
	}
	function DMPAFT_SetVP2Date ($StrDate)	{// 2003/06/19 09:30:00  =>  0x03A2 0x06D3
		$y = substr($StrDate, 0, 4);
		$m = substr($StrDate, 5, 2);
		$d = substr($StrDate, 8, 2);
		$h = substr($StrDate, -8, 2);
		$min = substr($StrDate, -5, 2);
		$s = substr($StrDate, -2);
		
		$d = ((($y-2000)*512+$m*32+$d)<<16) + ($h*100+$min);							// settype($d, 'integer');
		$d = chr(($d&0xff0000)>>16).chr(($d&0xff000000)>>24).chr($d&0xff).chr(($d&0xff00)>>8);	// Reverse version
		return $d;
	}
	function CalculateCRC($ptr)	{
		$crc = 0x0000;
		settype($crc, "integer");
		for ($i = 0; $i < strlen($ptr); $i++)
		{
			$crc =  $this->table[(($crc>>8) ^ ord($ptr[$i]))] ^ (($crc<<8) & 0x00FFFF);
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

// http://www.davisnet.com/support/weather/downloads/software_direct.asp?SoftCat=4&SoftwareID=172
/**
		#################################################################################
		################	Function for RAW data convertion	#################
		#################################################################################
**/
	function ConvertStrRaw($Str) {// ConvertStrRaw return les donnees RAW au format Numerique dans un tableau...
		switch (strlen($Str)) {
			case 50:
			case 52:
				$modele = $this->DumpAfter;
				break;
			case 97:
			case 99:
				$modele = $this->Loop;
				break;
			case 436:
			case 438:
				$modele = $this->HiLow;
				break;
		}
		$x = array();
		foreach($modele as $key=>$val)
		{
			$StrValue = substr ($Str, $val['pos'], $val['len']);
// 			$this->Waiting (0,$key.'['.strlen($StrValue).'] : '.$val['fn'].'('.$StrValue.');  '.$val['fn'].'('.$this->hexToDec($StrValue).');'); 
			$mesure = $this->$val['fn'] ($StrValue);
			if ($mesure != $val['err'] && $mesure >= $val['min'] && $mesure <= $val['max'] || is_bool($mesure) || is_string($mesure))
				$x[$key] = $mesure;
			else
				$x[$key] = NULL;
		}
		return $x;
	}
	function Bool($str) {// 
		return ord($str) ? TRUE : FALSE ;
	}

	function Char2Signed($val) {
	// Char2Signed http://en.wikipedia.org/wiki/Two%27s_complement
	// return value between 0 - 255 into signed -128 - +127...Two's complement
		return (($val>>7)?(($val ^ 0xFF)+1)*(-1):$val);
	}
	function s2sc($str) {// String to Signed Char
		return $this->Char2Signed($str);
	}
	function s2uc($str) {// String to unSigned Char
		return ($this->hexToDec($str));
	}

	function Short2Signed($val) {
	// Char2Signed http://en.wikipedia.org/wiki/Two%27s_complement
	// return value between 0 - 65532 into signed -32768 - +32767...Two's complement
		return (($val>>15)?(($val ^ 0xFFFF)+1)*(-1):$val);
	}
	function s2sSht($str) {// String to Signed Short
		return $this->Short2Signed($this->hexToDec(strrev($str)));
	}
	function s2uSht($str) {// String to unSigned Short
		return ($this->hexToDec(strrev($str)));
	}

	function Gain($str) {// ...
		return $this->hexToDec(strrev($str))/1000;
	}
	function Cal($str) {// ...
		return $this->hexToDec(strrev($str))/1000;
	}
	function Offset($str) {// ...
		return $this->s2sSht($str);
	}
	function Alt($str) {// Altitude
		return $this->s2sSht($str);
	}
	function GPS($str) {// Position GPS
		return $this->s2sSht($str)/10;
	}
	function GMT($str) {// ...
		$val = $this->s2sSht($str);
		return (int)($val/100).":".str_pad((abs($val)%100),2,"0",STR_PAD_LEFT);
	}
	function Station($str) {// ...
		return null;
	}

	function UnitBits($str) {// ...
		$val = $this->s2uc($str);
		return array_combine(array("Unit.Wind","Unit.Rain","Unit.Elev","Unit.Temp","Unit.Barom"),
			array(
				!(($val&0xC0)>>6)?"mph":(((($val&0xC0)>>6)==1)?"m/s":(((($val&0xC0)>>6)==2)?"Km/h":"Knots")),
				(($val&0x20)>>5)?"mm":"in",
				(($val&0x10)>>4)?"m":"ft",
				!(($val&0x0C)>>2)?"1 °F":(((($val&0x0C)>>2)==1)?"0.1 °F":(((($val&0x0C)>>2)==2)?"1 °C":"0.1 °C")),
				!($val&0x03)?"0.01 in":((($val&0x03)==1)?"0.1 mm":((($val&0x03)==2)?"0.1 hpa":"0.1 mB")),
		));
	}
	function SetupBits($str) {// ...
		$val = $this->s2uc($str);
		return array_combine(array("Setup.Longitude","Setup.Latitude","Setup.RainCupSize","Setup.WinCupSize","Setup.DayMonth","Setup.AM/PM","Setup.12/24"),
			array(
				(($val&0x80)>>7)?"East":"West",
				(($val&0x40)>>6)?"Nord":"South",
				!(($val&30)>>4)?"0.01 in":(((($val&30)>>4)==1)?"0.2 mm":"0.1 mm"),
				(($val&0x08)>>3)?"Large":"Small",
				(($val&0x04)>>2)?"Day/Month":"Month/Day",
				(($val&0x02)>>1)?"AM?":"PM?",
				($val&0x01)?"24h?":"AM/PM?",
			));
	}
	
	function Pressure($str) {// Pressure...
		$val = $this->hexToDec(strrev($str));
		return $val/1000;
	}
	function Temp($str) {// Temperature...
		return $this->s2sSht($str)/10;
	}
	function CalTemp($str) {// Temperature...
		return $this->s2sc($str)/10;
	}
	function SmallTemp($str) {// Temperature...
		return $this->s2uc($str)-90;
	}
	function SmallTemp120($str) {// Temperature...
		return $this->s2uc($str)-120;
	}

	function Speed($str) {// Wind Speed...
		return $this->hexToDec($str);
	}
	function Samples($str) {// number of clic...
		return $this->s2uSht($str);
	}

	function Radiation($str) {// Solar Radiation...
		return $this->s2sSht($str);
	}
	function ET_h($str) {// Evapotranspiration...
		return $this->s2uc($str)/1000;
	}
	function ET1000($str) {// Evapotranspiration...
		return $this->s2uSht($str)/1000;
	}
	function ET100($str) {// Evapotranspiration...
		return $this->s2uSht($str)/100;
	}
	function UV($str) {// UV level...
		return $this->s2uc($str)/10;
	}

	function Forecast($str) {// Forecast for next day...
		return $this->s2uc($str);
	}

	function Rate($str) {// Percentage...
		return $this->s2uc($str);
	}
	function Moistures ($str){ // Humidite du sol
		return $this->s2uc($str);
	}
	function Wetnesses($str) {// Humectometre...
		return $this->s2uc($str);
	}

	function Angle16($str) {// Wind Direction...
		return $this->s2uc($str);
	}
	function Angle360($str) {// Wind Direction...
		return $this->s2sSht($str);
	}
	function SpRev($str) {// Special revision...
		if ($this->hexToDec($str)==255)
			return 'Rev A';
		return 'Rev B';
	}
	function BTrend($str) {// ...
		return $this->Trend[$this->s2uc($str)];
	}

	function RainAlarms($str) {// ...
		return $this->s2sSht($str);
	}
	function HumidityAlarms($str) {// ...
		return $this->s2uc($str);
	}
	function Soil_LeafAlarms($str) {// ...
		$val = $this->hexToDec($str);
		return $val;
	}
	function Voltage($str) {// Tension of inside battery
		return (($this->s2uSht($str)*300)/512)/100.0;
	}
	function Icons($str) {// ...
		return $this->s2uc($str);
	}
}
?>
