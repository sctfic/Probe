<?php	//	clear;php5 -f ./VP2-IP.GetClasses.php
class VP2
{
	public $IP=NULL; //
	public $Port=NULL;   //
	public $fp=NULL;
	public $symb=NULL;

	function __construct()
	{
		setVP2_value();
		$this->symb = array (
		'CR' => chr(0x0D), // \r
		'LF' => chr(0x0A), // \n
		'LFCR' => chr(0x0A).chr(0x0D),
		'ESC' => chr(0x1b), // Echap
		'ACK' => chr(0x06), // Compris
		'NAK' => chr(0x21), // Pas Compris
		'CANCEL' => chr(0x18), // Bad CRC Code
		'_OK_' => "\n\rOK\n\r");
	}
	function setVP2_value($i=0)
	{
		$filename='./VP2-IP.conf';
		$handle = fopen($filename, "rb");
			$conf = unserialize(fread($handle, filesize($filename)));
		fclose($handle);
		if ($i<=array_count_values($conf))
		{
			$this->IP=$conf[$i]['IP'];
			$this->Port=$conf[$i]['Port'];
		}
		else return false;
		return true;
	}
	public static function Waiting ($s=10, $msg = 'Waiting and retry')
	{
		$w = '-\|/';
		if ($s==0) echo "\r".date('Y/m/d H:i:s u')."\t".$msg;
		for ($j=0;$j<$s;$j++)
		{
			usleep(100000);
			echo "\r".date('Y/m/d H:i:s u')."\t".$msg.' '.$w[$j%4];
		}
		echo "\n";
	}
	public static function HexToDec($hex)
	{
		return hexdec(bin2hex($hex));
	}
	
}
class Connect extends VP2
{
	private $retry=3; // number of attempts before aborting
	private $backLightScreen=false; // actual state of backlight screen
	function __construct(){}
	public static function initConnection()
	{
		parent::$fp = fsockopen(parent::$IP, parent::$Port);
		stream_set_timeout(parent::$fp, 0, 2500000);
		if (parent::$fp)
		{
			if ($this->wakeUp())
			{
				$this->toggleBacklight(1);
				return true;
			}
		}
		return false;
	}
	public static function wakeUp()
	{
		for ($i=0;$i<=$this->retry;$i++)
		{
			fwrite (parent::$fp,parent::$symb['LF']);
			if (fread(parent::$fp,6)==parent::$symb['LFCR'])
				return true;
			usleep(1200000);
		}
		return false;
	}
	public static function toggleBacklight($force=-1)
	{
		if ($force==-1)
		{
			fwrite (parent::$fp,'LAMPS '.(($this->backLightScreen)?'0':'1').parent::$symb['LF']);
		}
		else
		{
			fwrite (parent::$fp,'LAMPS '.($force?'1':'0').parent::$symb['LF']);
		}
		if (fread(parent::$fp,6);==parent::$symb['_OK_'])
		{
			if ($force==-1)$this->backLightScreen = !$this->backLightScreen;
			else $this->backLightScreen = $force;
			return TRUE;
		}
		return FALSE;
	}
	public static function CloseConnection()
	{
		$this->toggleBacklight(0);
		fclose(parent::$fp);
		return true;
	}
}
class _LOOP extends VP2
{
	private $retry=3; // number of attempts before aborting
	function __construct(){}
	function GetRaw()
	{
		for ($i=0;$i<=$this->retry;$i++)
		{}
		return true;
	}
}
class _HILOWS extends VP2
{
	private $retry=3; // number of attempts before aborting
	function __construct(){}
	function GetRaw()
	{
		for ($i=0;$i<=$this->retry;$i++)
		{
			fwrite (parent::$fp, "HILOWS\n");
			parent::Waiting (8,'HILOWS : attente de la reponce.');
			$r = fread(parent::$fp, 1);
			if ($r == parent::$symb['ACK'])
			{
				parent::Waiting (8,'HILOWS : attente des donnees brutes.');
				$HILOWS = fread(parent::$fp, 438);
				$crc = CRC16_CCITT($HILOWS);
				if ($crc==0x0000)
				{
					$HILOWS = substr($HILOWS,0,-2);
					// echo date('Y/m/d H:i:s u')."\t".'Traitement des valeurs Maxi et Mini...'."\n";
					// fonction de conversion...
				}
			//	file_put_contents("./VP2-data.brut",$HILOWS);
			}
			else if ($r == parent::$symb['NAK'])
			{
				// echo date('Y/m/d H:i:s u')."\t".'HILOWS NAK'."\n";
			}
			else
			{
				// echo date('Y/m/d H:i:s u')."\t".'HILOWS NULL  '.'$r = 0x'.dechex($r)."\n";
				fread(parent::$fp, 999);
				if ($i<$this->retry)	parent::Waiting (8);
			}
		}
		return true;
	}
}
class _TIME extends VP2
{
	private $retry=3; // number of attempts before aborting
	function __construct(){}
	function GetRaw()
	{
		for ($i=0;$i<=$this->retry;$i++)
		{}
		return true;
	}
}
class _DMPAFT extends VP2
{
	private $retry=3; // number of attempts before aborting
	function __construct(){}
	function GetRaw()
	{
		for ($i=0;$i<=$this->retry;$i++)
		{
fwrite($fp,"DMPAFT\n");
Waiting (4,'Recuperation des Archives.');
$r = fread($fp, 1);
if ($r == $symb['ACK'])
{
	$d = DMPAFT_SetVP2Date(date('Y/m/d H:00:00'));
	fwrite($fp, $d[0].$d[1].$d[2].$d[3]);
	Waiting (4,'Demande d archives');
	$crc = CRC16_CCITT($d[0].$d[1].$d[2].$d[3]);
	fwrite($fp, $crc[0].$crc[1]);
	Waiting (12,'confirmation par CRC');
	$r = fread($fp, 1);
	if ($r == $symb['ACK'])
	{
		Waiting (1,'CRC Confirme, Recuperation des Archives');
		$r = fread($fp, 6);
//				echo strlen($r).' - '.$n.'  = '.bin2hex($n).' - '.$p.'  = '.bin2hex($p).' - ';
		$crc = CRC16_CCITT($r);
//				echo $r.'        = 0x'.bin2hex($r)."\n";
//				echo $crc['all'].'        = 0x'.bin2hex($crc['all'])."\n";
//				echo $crc[0].' '.$crc[1].'        = 0x'.dechex(ord($crc[0])).dechex(ord($crc[1]))."\n";
		if ($crc['Confirm'])
		{
			$n = ($r >> 32) & 0xffff ;
			$p = ($r >> 16) & 0xffff;
			//$n = (ord($r[0])<<8)+ord($r[1]);
			//$p = (ord($r[2])<<8)+ord($r[3]);
			echo date('Y/m/d H:i:s u')."\t".'Nombre de Pages : '.$n.'. debute aux data : '.$p.".\n";
			fwrite($fp, $symb['ACK']);
			for ($j=0;$j<$n && $j<5;$j++)
			{
				$archives[$j] = fread($fp, 267);
				Waiting (4,'Download ARCHIVE : '.$j);
				if (CRC16_CCITT($archives[$j]))
				{
					Waiting (4,'ARCHIVE #'.$j.' du '.DMPAFT_GetVP2Date(array($archives[$j][1],$archives[$j][2],$archives[$j][3],$archives[$j][4])).' valide');
					fwrite($fp, $symb['ACK']);
				}
				else
				{
					fwrite($fp, $symb['NAK']);
					Waiting (4,'ARCHIVE #'.$j.' invalide, retry.');
				}
			}
			fwrite($fp, $symb['ESC']);
		}
		else if ($r == $symb['NAK'])
			echo date('Y/m/d H:i:s u')."\t".'DMPAFT Pages NAK'."\n";
		else
		{
			echo date('Y/m/d H:i:s u')."\t".'DMPAFT Pages NULL  '.'$r = 0x'.dechex($r)."\n";
			fread($fp, 999); // vidange
			if ($i<$retry)	Waiting (8);
		}
	}
	else if ($r == $symb['NAK'])
		echo date('Y/m/d H:i:s u')."\t".'DMPAFT Date NAK'."\n";
	else
	{
		echo date('Y/m/d H:i:s u')."\t".'DMPAFT Date NULL  '.'$r = 0x'.dechex($r)."\n";
		fread($fp, 999); // vidange
		if ($i<$retry)	Waiting (8);
	}
	$skip = true;
}
else if ($r == $symb['NAK'])
	echo date('Y/m/d H:i:s u')."\t".'DMPAFT NAK'."\n";
else
{
	echo date('Y/m/d H:i:s u')."\t".'DMPAFT NULL  '.'$r = 0x'.dechex($r)."\n";
	fread($fp, 999); // vidange
	if ($i<$retry)	Waiting (8);
}

		}
		return true;
	}
	public static function Date2Human()
	{
		return true;
	}
	public static function Human2Date()
	{
		return true;
	}
	
}
class CRC16CCITT extends VP2
{
	private $table = array( // CRC16-CCITT
	0x0000,  0x1021,  0x2042,  0x3063,  0x4084,  0x50a5,  0x60c6,  0x70e7,
	0x8108,  0x9129,  0xa14a,  0xb16b,  0xc18c,  0xd1ad,  0xe1ce,  0xf1ef,
	0x1231,  0x0210,  0x3273,  0x2252,  0x52b5,  0x4294,  0x72f7,  0x62d6,
	0x9339,  0x8318,  0xb37b,  0xa35a,  0xd3bd,  0xc39c,  0xf3ff,  0xe3de,
	0x2462,  0x3443,  0x0420,  0x1401,  0x64e6,  0x74c7,  0x44a4,  0x5485,
	0xa56a,  0xb54b,  0x8528,  0x9509,  0xe5ee,  0xf5cf,  0xc5ac,  0xd58d,
	0x3653,  0x2672,  0x1611,  0x0630,  0x76d7,  0x66f6,  0x5695,  0x46b4,
	0xb75b,  0xa77a,  0x9719,  0x8738,  0xf7df,  0xe7fe,  0xd79d,  0xc7bc,
	0x48c4,  0x58e5,  0x6886,  0x78a7,  0x0840,  0x1861,  0x2802,  0x3823,
	0xc9cc,  0xd9ed,  0xe98e,  0xf9af,  0x8948,  0x9969,  0xa90a,  0xb92b,
	0x5af5,  0x4ad4,  0x7ab7,  0x6a96,  0x1a71,  0x0a50,  0x3a33,  0x2a12,
	0xdbfd,  0xcbdc,  0xfbbf,  0xeb9e,  0x9b79,  0x8b58,  0xbb3b,  0xab1a,
	0x6ca6,  0x7c87,  0x4ce4,  0x5cc5,  0x2c22,  0x3c03,  0x0c60,  0x1c41,
	0xedae,  0xfd8f,  0xcdec,  0xddcd,  0xad2a,  0xbd0b,  0x8d68,  0x9d49,
	0x7e97,  0x6eb6,  0x5ed5,  0x4ef4,  0x3e13,  0x2e32,  0x1e51,  0x0e70,
	0xff9f,  0xefbe,  0xdfdd,  0xcffc,  0xbf1b,  0xaf3a,  0x9f59,  0x8f78,
	0x9188,  0x81a9,  0xb1ca,  0xa1eb,  0xd10c,  0xc12d,  0xf14e,  0xe16f,
	0x1080,  0x00a1,  0x30c2,  0x20e3,  0x5004,  0x4025,  0x7046,  0x6067,
	0x83b9,  0x9398,  0xa3fb,  0xb3da,  0xc33d,  0xd31c,  0xe37f,  0xf35e,
	0x02b1,  0x1290,  0x22f3,  0x32d2,  0x4235,  0x5214,  0x6277,  0x7256,
	0xb5ea,  0xa5cb,  0x95a8,  0x8589,  0xf56e,  0xe54f,  0xd52c,  0xc50d,
	0x34e2,  0x24c3,  0x14a0,  0x0481,  0x7466,  0x6447,  0x5424,  0x4405,
	0xa7db,  0xb7fa,  0x8799,  0x97b8,  0xe75f,  0xf77e,  0xc71d,  0xd73c,
	0x26d3,  0x36f2,  0x0691,  0x16b0,  0x6657,  0x7676,  0x4615,  0x5634,
	0xd94c,  0xc96d,  0xf90e,  0xe92f,  0x99c8,  0x89e9,  0xb98a,  0xa9ab,
	0x5844,  0x4865,  0x7806,  0x6827,  0x18c0,  0x08e1,  0x3882,  0x28a3,
	0xcb7d,  0xdb5c,  0xeb3f,  0xfb1e,  0x8bf9,  0x9bd8,  0xabbb,  0xbb9a,
	0x4a75,  0x5a54,  0x6a37,  0x7a16,  0x0af1,  0x1ad0,  0x2ab3,  0x3a92,
	0xfd2e,  0xed0f,  0xdd6c,  0xcd4d,  0xbdaa,  0xad8b,  0x9de8,  0x8dc9,
	0x7c26,  0x6c07,  0x5c64,  0x4c45,  0x3ca2,  0x2c83,  0x1ce0,  0x0cc1,
	0xef1f,  0xff3e,  0xcf5d,  0xdf7c,  0xaf9b,  0xbfba,  0x8fd9,  0x9ff8,
	0x6e17,  0x7e36,  0x4e55,  0x5e74,  0x2e93,  0x3eb2,  0x0ed1,  0x1ef0);
	function __construct(){}
	public static function Calculate($ptr)
	{
		$crc = 0x0000;
		for ($i = 0; $i < strlen($ptr); $i++)
		{
			$crc =  $this->table[(($crc>>8) ^ ord($ptr[$i]))] ^ (($crc<<8) & 0x00FFFF);
		}
//		return array( 'Confirm' => !$crc, 0 => chr(($crc>>8)&0xff), 1 => chr($crc&0xff), 'all' => $crc);
		return parent::HexToDec($crc);
	}
}
?>