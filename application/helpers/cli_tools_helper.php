<?php

function GetVP2ZoneOffset($zoneID) {
	global $TIME_ZONE;
	$offset = $TIME_ZONE[$zoneID]['GMToffset'];
	return (abs($offset)<1000 ?
				($offset<0 ?
					'-0'.(int)(abs($offset)/100):
					'+0'.(int)($offset/100))
				:(int)($offset/100))
			.":".str_pad((abs($offset)%100),2,"0",STR_PAD_LEFT);
}
/**
	#########################################################################################
	#########		Function for manage Variable and Conf-File		#########
	#########################################################################################
**/
	function is_date ($date) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		if (is_string($date)) {
			if (preg_match('/^20[\d]{2}(\/|-)[\d]{2}(\/|-)[\d]{2}(\s|T)[\d]{2}:[\d]{2}:[\d]{2}((\+|-)[0-1][\d]:?(0|3)0)?$/', $date)) {
				return substr($date, 0, 19);
			}
		}
		return '2012/01/01 00:00:00';
	}
	function Raw2Date ($DateStamp){
	
		$DateStamp = hexToDec(strrev($DateStamp));
		$y = (($DateStamp & 0xFE00)>>9)+2000;
		$m = str_pad(($DateStamp & 0x01E0)>>5,2,'0',STR_PAD_LEFT);
		$d = str_pad($DateStamp & 0x1f,2,'0',STR_PAD_LEFT);
		return $y.'/'.$m.'/'.$d;
	}
	function Raw2Time ($TimeStamp){
		$TimeStamp = hexToDec(strrev($TimeStamp));
		$h = str_pad((int)($TimeStamp/100),2,'0',STR_PAD_LEFT);
		$min = str_pad($TimeStamp-$h*100,2,'0',STR_PAD_LEFT);
/*		echo "$h => int $TimeStamp/100 = ".(int)($TimeStamp/100)."\n";*/
		return $h.':'.$min.':00';
	}
	function DMPAFT_GetVP2Date ($VP2Date)	{// 2003/06/19 09:30:00  <=  0x03A2 0x06D3
		$date = date_create(Raw2Date(substr($VP2Date,0,2)).' '.Raw2Time(substr($VP2Date,-2)));
//		return date_format($date, 'Y-m-d H:i:s');
		return date_format($date, 'c'); //ISO 8601
	}
	function DMPAFT_SetVP2Date ($StrDate)	{// 2003/06/19T09:30:00+00:00  =>  0x03A2 0x06D3
		$y = substr($StrDate, 0, 4);
		$m = substr($StrDate, 5, 2);
		$d = substr($StrDate, 8, 2);
		$h = substr($StrDate, 11, 2);
		$min = substr($StrDate, 14, 2);
		$s = substr($StrDate, 17, 2);
		$d = ((($y-2000)*512+$m*32+$d)<<16) + ($h*100+$min);							// settype($d, 'integer');
		$d = chr(($d&0xff0000)>>16).chr(($d&0xff000000)>>24).chr($d&0xff).chr(($d&0xff00)>>8);	// Reverse version
		return $d;
	}


	// Converts a unix timestamp to iCal format (UTC) - if no timezone is 
	// specified then it presumes the uStamp is already in UTC format. 
	// tzone must be in decimal such as 1hr 45mins would be 1.75, behind 
	// times should be represented as negative decimals 10hours behind 
	// would be -10      
    function unixToiCal($uStamp = 0, $tzone = 0.0) { 
    
        $uStampUTC = $uStamp + ($tzone * 3600);        
        $stamp  = date("c", $uStampUTC); //ISO 8601
        
        return $stamp;        

    }

	function CalculateCRC($ptr)	{ // echo dechex($crc)
		global $TABLE_CRC16; // do not use a GLOBAL, PHP don't like it for this

		$crc = 0x0000;
		settype($crc, "integer");
		for ($i = 0; $i < strlen($ptr); $i++) {
			$crc =  $TABLE_CRC16[(($crc>>8) ^ ord($ptr[$i]))] ^ (($crc<<8) & 0x00FFFF);
		}
		return !$crc?$crc:chr($crc>>8).chr($crc&0xff);
	}


	function Waiting ($s=10, $msg = 'Waiting and retry') {
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
