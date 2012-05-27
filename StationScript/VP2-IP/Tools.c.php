<?php
class Tools
{
	const CR	=	"\r";		// chr(0x0D)
	const LF	=	"\n";		// chr(0x0A)
	const LFCR	=	"\n\r";		// chr(0x0A).chr(0x0D)
	const ESC	=	"\x1b";		// chr(0x1b), Echap
	const ACK	=	"\x06";		// chr(0x06), Compris
	const NAK	=	"\x21";		// chr(0x21), Pas Compris
	const CANCEL	=	"\x18";		// chr(0x18), Bad CRC Code
	const OK	=	"\n\rOK\n\r";	// Confirm

	private static $TABLE = array(
	0x0,  0x1021,  0x2042,  0x3063,  0x4084,  0x50a5,  0x60c6,  0x70e7,
	0x8108,  0x9129,  0xa14a,  0xb16b,  0xc18c,  0xd1ad,  0xe1ce,  0xf1ef,
	0x1231,  0x210,  0x3273,  0x2252,  0x52b5,  0x4294,  0x72f7,  0x62d6,
	0x9339,  0x8318,  0xb37b,  0xa35a,  0xd3bd,  0xc39c,  0xf3ff,  0xe3de,
	0x2462,  0x3443,  0x420,  0x1401,  0x64e6,  0x74c7,  0x44a4,  0x5485,
	0xa56a,  0xb54b,  0x8528,  0x9509,  0xe5ee,  0xf5cf,  0xc5ac,  0xd58d,
	0x3653,  0x2672,  0x1611,  0x630,  0x76d7,  0x66f6,  0x5695,  0x46b4,
	0xb75b,  0xa77a,  0x9719,  0x8738,  0xf7df,  0xe7fe,  0xd79d,  0xc7bc,
	0x48c4,  0x58e5,  0x6886,  0x78a7,  0x840,  0x1861,  0x2802,  0x3823,
	0xc9cc,  0xd9ed,  0xe98e,  0xf9af,  0x8948,  0x9969,  0xa90a,  0xb92b,
	0x5af5,  0x4ad4,  0x7ab7,  0x6a96,  0x1a71,  0xa50,  0x3a33,  0x2a12,
	0xdbfd,  0xcbdc,  0xfbbf,  0xeb9e,  0x9b79,  0x8b58,  0xbb3b,  0xab1a,
	0x6ca6,  0x7c87,  0x4ce4,  0x5cc5,  0x2c22,  0x3c03,  0xc60,  0x1c41,
	0xedae,  0xfd8f,  0xcdec,  0xddcd,  0xad2a,  0xbd0b,  0x8d68,  0x9d49,
	0x7e97,  0x6eb6,  0x5ed5,  0x4ef4,  0x3e13,  0x2e32,  0x1e51,  0xe70,
	0xff9f,  0xefbe,  0xdfdd,  0xcffc,  0xbf1b,  0xaf3a,  0x9f59,  0x8f78,
	0x9188,  0x81a9,  0xb1ca,  0xa1eb,  0xd10c,  0xc12d,  0xf14e,  0xe16f,
	0x1080,  0xa1,  0x30c2,  0x20e3,  0x5004,  0x4025,  0x7046,  0x6067,
	0x83b9,  0x9398,  0xa3fb,  0xb3da,  0xc33d,  0xd31c,  0xe37f,  0xf35e,
	0x2b1,  0x1290,  0x22f3,  0x32d2,  0x4235,  0x5214,  0x6277,  0x7256,
	0xb5ea,  0xa5cb,  0x95a8,  0x8589,  0xf56e,  0xe54f,  0xd52c,  0xc50d,
	0x34e2,  0x24c3,  0x14a0,  0x481,  0x7466,  0x6447,  0x5424,  0x4405,
	0xa7db,  0xb7fa,  0x8799,  0x97b8,  0xe75f,  0xf77e,  0xc71d,  0xd73c,
	0x26d3,  0x36f2,  0x691,  0x16b0,  0x6657,  0x7676,  0x4615,  0x5634,
	0xd94c,  0xc96d,  0xf90e,  0xe92f,  0x99c8,  0x89e9,  0xb98a,  0xa9ab,
	0x5844,  0x4865,  0x7806,  0x6827,  0x18c0,  0x8e1,  0x3882,  0x28a3,
	0xcb7d,  0xdb5c,  0xeb3f,  0xfb1e,  0x8bf9,  0x9bd8,  0xabbb,  0xbb9a,
	0x4a75,  0x5a54,  0x6a37,  0x7a16,  0xaf1,  0x1ad0,  0x2ab3,  0x3a92,
	0xfd2e,  0xed0f,  0xdd6c,  0xcd4d,  0xbdaa,  0xad8b,  0x9de8,  0x8dc9,
	0x7c26,  0x6c07,  0x5c64,  0x4c45,  0x3ca2,  0x2c83,  0x1ce0,  0xcc1,
	0xef1f,  0xff3e,  0xcf5d,  0xdf7c,  0xaf9b,  0xbfba,  0x8fd9,  0x9ff8,
	0x6e17,  0x7e36,  0x4e55,  0x5e74,  0x2e93,  0x3eb2,  0xed1,  0x1ef0);

// 	var $WinDir = array('N','NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW');

	private static $TREND = array(196=>-2, 236=>-1, 0=>0, 20=>1, 60=>2, 80=>'Rev A');

	/**
	#########################################################################################
	#########		Function for manage Variable and Conf-File		#########
	#########################################################################################
**/
	public static function is_date ($date) {
		if (is_string($date)) {
			if (preg_match('/^20[\d]{2}\/[\d]{2}\/[\d]{2}\s[\d]{2}:[\d]{2}:[\d]{2}$/', $date)==1) {
				return $date;
			}
		}
		return '2012/01/01 00:00:00';
	}
	public static function Raw2Date ($DateStamp){
	
		$DateStamp = self::hexToDec(strrev($DateStamp));
		$y = (($DateStamp & 0xFE00)>>9)+2000;
		$m = str_pad(($DateStamp & 0x01E0)>>5,2,'0',STR_PAD_LEFT);
		$d = str_pad($DateStamp & 0x1f,2,'0',STR_PAD_LEFT);
		return $y.'/'.$m.'/'.$d;
	}
	public static function Raw2Time ($TimeStamp){
		$TimeStamp = self::hexToDec(strrev($TimeStamp));
		$h = str_pad((int)($TimeStamp/100),2,'0',STR_PAD_LEFT);
		$min = str_pad($TimeStamp-$h*100,2,'0',STR_PAD_LEFT);
/*		echo "$h => int $TimeStamp/100 = ".(int)($TimeStamp/100)."\n";*/
		return $h.':'.$min.':00';
	}
	public static function DMPAFT_GetVP2Date ($VP2Date)	{// 2003/06/19 09:30:00  <=  0x03A2 0x06D3
		return self::Raw2Date(substr($VP2Date,0,2)).' '.self::Raw2Time(substr($VP2Date,-2));
	}
	public static function DMPAFT_SetVP2Date ($StrDate)	{// 2003/06/19 09:30:00  =>  0x03A2 0x06D3
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
	public static function CalculateCRC($ptr)	{
		$crc = 0x0000;
		settype($crc, "integer");
		for ($i = 0; $i < strlen($ptr); $i++)
		{
			$crc =  self::$TABLE[(($crc>>8) ^ ord($ptr[$i]))] ^ (($crc<<8) & 0x00FFFF);
		}
		return !$crc?$crc:chr($crc>>8).chr($crc&0xff);
	}
	public static function Waiting ($s=10, $msg = 'Waiting and retry')	{
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
	public static function hexToDec($hex)	{
		return hexdec(bin2hex($hex));
	}
// http://www.davisnet.com/support/weather/downloads/software_direct.asp?SoftCat=4&SoftwareID=172
/**
		#################################################################################
		################	Function for RAW data convertion	#################
		#################################################################################
**/

	public static function Bool($str) {// 
		return ord($str) ? TRUE : FALSE ;
	}

	public static function Char2Signed($val) {
	// Char2Signed http://en.wikipedia.org/wiki/Two%27s_complement
	// return value between 0 - 255 into signed -128 - +127...Two's complement
		return (($val>>7)?(($val ^ 0xFF)+1)*(-1):$val);
	}
	public static function s2sc($str) {// String to Signed Char
		return self::Char2Signed($str);
	}
	public static function s2uc($str) {// String to unSigned Char
		return (self::hexToDec($str));
	}

	public static function Short2Signed($val) {
	// Char2Signed http://en.wikipedia.org/wiki/Two%27s_complement
	// return value between 0 - 65532 into signed -32768 - +32767...Two's complement
		return (($val>>15)?(($val ^ 0xFFFF)+1)*(-1):$val);
	}
	public static function s2sSht($str) {// String to Signed Short
		return self::Short2Signed(self::hexToDec(strrev($str)));
	}
	public static function s2uSht($str) {// String to unSigned Short
		return (self::hexToDec(strrev($str)));
	}

	public static function Gain($str) {// ...
		return self::hexToDec(strrev($str))/1000;
	}
	public static function Cal($str) {// ...
		return self::hexToDec(strrev($str))/1000;
	}
	public static function Offset($str) {// ...
		return self::s2sSht($str);
	}
	public static function Alt($str) {// Altitude
		return self::s2sSht($str);
	}
	public static function GPS($str) {// Position GPS
		return self::s2sSht($str)/10;
	}
	public static function GMT($str) {// ...
		$val = self::s2sSht($str);
		return (int)($val/100).":".str_pad((abs($val)%100),2,"0",STR_PAD_LEFT);
	}
	public static function Station($str) {// ...
		return null;
	}
	public static function getBits($oct, $bitPos, $nbrBit) { // recupaire dans un octé $oct l´etat des $nbrBit a partir du bit $bitPos
		return ($oct<<$bitPos)&(pow(2,$nbrBit)-1);
	}
// 	public static function UnitBits($str) {// ...
// 		$val = self::s2uc($str);
// 		return array_combine(array("Unit.Wind","Unit.Rain","Unit.Elev","Unit.Temp","Unit.Barom"),
// 			array(
// 				!(($val&0xC0)>>6)?"mph":(((($val&0xC0)>>6)==1)?"m/s":(((($val&0xC0)>>6)==2)?"Km/h":"Knots")),
// 				(($val&0x20)>>5)?"mm":"in",
// 				(($val&0x10)>>4)?"m":"ft",
// 				!(($val&0x0C)>>2)?"1 °F":(((($val&0x0C)>>2)==1)?"0.1 °F":(((($val&0x0C)>>2)==2)?"1 °C":"0.1 °C")),
// 				!($val&0x03)?"0.01 in":((($val&0x03)==1)?"0.1 mm":((($val&0x03)==2)?"0.1 hpa":"0.1 mB")),
// 		));
// 	}
// 	public static function SetupBits($str) {// ...
// 		$val = self::s2uc($str);
// 		return array_combine(array("Setup.Longitude","Setup.Latitude","Setup.RainCupSize","Setup.WinCupSize","Setup.DayMonth","Setup.AM/PM","Setup.12/24"),
// 			array(
// 				(($val&0x80)>>7)?"East":"West",
// 				(($val&0x40)>>6)?"Nord":"South",
// 				!(($val&30)>>4)?"0.01 in":(((($val&30)>>4)==1)?"0.2 mm":"0.1 mm"),
// 				(($val&0x08)>>3)?"Large":"Small",
// 				(($val&0x04)>>2)?"Day/Month":"Month/Day",
// 				(($val&0x02)>>1)?"AM?":"PM?",
// 				($val&0x01)?"24h?":"AM/PM?",
// 			));
// 	}
	
	public static function Pressure($str) {// Pressure...
		$val = self::hexToDec(strrev($str));
		return $val/1000;
	}
	public static function Temp($str) {// Temperature...
		return self::s2sSht($str)/10;
	}
	public static function CalTemp($str) {// Temperature...
		return self::s2sc($str)/10;
	}
	public static function SmallTemp($str) {// Temperature...
		return self::s2uc($str)-90;
	}
	public static function SmallTemp120($str) {// Temperature...
		return self::s2uc($str)-120;
	}

	public static function Speed($str) {// Wind Speed...
		return self::hexToDec($str);
	}
	public static function Samples($str) {// number of clic...
		return self::s2uSht($str);
	}

	public static function Radiation($str) {// Solar Radiation...
		return self::s2sSht($str);
	}
	public static function ET_h($str) {// Evapotranspiration...
		return self::s2uc($str)/1000;
	}
	public static function ET1000($str) {// Evapotranspiration...
		return self::s2uSht($str)/1000;
	}
	public static function ET100($str) {// Evapotranspiration...
		return self::s2uSht($str)/100;
	}
	public static function UV($str) {// UV level...
		return self::s2uc($str)/10;
	}

	public static function Forecast($str) {// Forecast for next day...
		return self::s2uc($str);
	}

	public static function Rate($str) {// Percentage...
		return self::s2uc($str);
	}
	public static function Moistures ($str){ // Humidite du sol
		return self::s2uc($str);
	}
	public static function Wetnesses($str) {// Humectometre...
		return self::s2uc($str);
	}

	public static function Angle16($str) {// Wind Direction...
		return self::s2uc($str);
	}
	public static function Angle360($str) {// Wind Direction...
		return self::s2sSht($str);
	}
	public static function SpRev($str) {// Special revision...
		if (self::hexToDec($str)==255)
			return 'Rev A';
		return 'Rev B';
	}
	public static function BTrend($str) {// ...
		return self::$TREND[self::s2uc($str)];
	}

	public static function RainAlarms($str) {// ...
		return self::s2sSht($str);
	}
	public static function HumidityAlarms($str) {// ...
		return self::s2uc($str);
	}
	public static function Soil_LeafAlarms($str) {// ...
		$val = self::hexToDec($str);
		return $val;
	}
	public static function Voltage($str) {// Tension of inside battery
		return ((self::s2uSht($str)*300)/512)/100.0;
	}
	public static function Icons($str) {// ...
		return self::s2uc($str);
	}
/**
		#################################################################################
		################	Function for Numeric data convertion to SI	#################
		#################################################################################
**/
	public static function metric($val){
		return round($val/3.2808, 2);
	}
	public static function tempSI($val){
		return self::celcius($val);
	}
	public static function celcius($val){ // convert °F to celcius
		return round(($val-32)*5/9, 2);
	}
	public static function kelvin($val){ // convert °F to Kelvin
		return round(($val+459.67)*5/9, 2);
	}
	public static function mBySec($val){ // convert milles per hour speed 
		return round($val/2.2369362920544, 3); // (3600/((5280*12)*0.0254));
	}
	public static function kmByh($val){ // convert milles per hour speed 
		return round($val*1,609.345, 2); // (3600/((5280*12)*0.0254));
	}
	public static function barSI ($val){
	return $val;
	}
	public static function UTC ($val){
	return strtotime($val);
	}

}
?>