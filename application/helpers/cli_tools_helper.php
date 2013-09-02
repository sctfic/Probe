<?php

function GetZoneOffset($zoneID) {
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

	/**
	@description: teste si le parametre d'entrée est une date
	@return: retourne le parametre date si c'est une date sinon retourne une vrai date
	@param: string date au formet ISO 8601 par exemple
	*/
	function is_date ($date) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		if (is_string($date)) {
			if (preg_match('/^20[\d]{2}(\/|-)[\d]{2}(\/|-)[\d]{2}(\s|T)[\d]{2}:[\d]{2}:[\d]{2}((\+|-)[0-1][\d]:?(0|3)0)?$/', $date)) {
				return substr($date, 0, 19);
			}
		}
		return '2012/01/01 00:00:00';
	}

	/**
	@description: converti une chaine binaire provenant de la VP2 en date Y/M/D
	@return: retourne une chaine date de 10 Octes : yyyy/mm/dd
	@param: chaine binaire de 2 octés
	*/
	function Raw2Date ($DateStamp){
	
		$DateStamp = hexToDec(strrev($DateStamp));
		$y = (($DateStamp & 0xFE00)>>9)+2000;
		$m = str_pad(($DateStamp & 0x01E0)>>5,2,'0',STR_PAD_LEFT);
		$d = str_pad($DateStamp & 0x1f,2,'0',STR_PAD_LEFT);
		return $y.'/'.$m.'/'.$d;
	}

	/**
	@description: converti une chaine binaire provenant de la VP2 en heure H:m:s
	@return: retourne une chaine date de 8 Octes : hh/mm/ss
	@param: chaine binaire de 2 octés
	*/
	function Raw2Time ($TimeStamp){
		$TimeStamp = hexToDec(strrev($TimeStamp));
		$h = str_pad((int)($TimeStamp/100),2,'0',STR_PAD_LEFT);
		$min = str_pad($TimeStamp-$h*100,2,'0',STR_PAD_LEFT);
		return $h.':'.$min.':00';
	}

	/**
	@description: converti une chaine dinaire a destination de la VP2
	@param: chaine binaire de 4 Octes en provenance de la VP2 (tester avec dechex($d);)
	@param: string de 6octés correspondant au decalage GMT : +hh:mm
	@return: string date au format ISO 8601
	*/
	function DMPAFT_GetVP2Date ($VP2Date, $offsetGMT)	{// 2003/06/19 09:30:00  <=  0x03A2 0x06D3
		$date = date_create(Raw2Date(substr($VP2Date,0,2)).' '.Raw2Time(substr($VP2Date,-2)).$offsetGMT);
//		return date_format($date, 'Y-m-d H:i:s');
		return date_format($date, 'c'); //ISO 8601
	}

	/**
	@description: converti une chaine date en une chaine dinaire a destination de la VP2
	@return: retourne une chaine binaire de 4 Octes (tester avec bin2hex($d);)
	@param: string date au format ISO 8601 par exemple
	*/
	function DMPAFT_SetVP2Date ($StrDate)	{
		// 2012-12-08 22:30:00 => 0x8819 0xb608
		// 2003/06/19T09:30:00+hh:mm => 0xd306 0xa203
		// 2003/06/06T09:30:00+hh:mm => 0xc606 0xa203
		$y = substr($StrDate, 0, 4);
		$m = substr($StrDate, 5, 2);
		$d = substr($StrDate, 8, 2);
		$h = substr($StrDate, 11, 2);
		$min = substr($StrDate, 14, 2);
		$s = substr($StrDate, 17, 2);
		$d = ((($y-2000)*512+$m*32+$d)<<16) + ($h*100+$min);	// settype($d, 'integer');
		$d = chr(($d&0xff0000)>>16).chr(($d&0xff000000)>>24).chr($d&0xff).chr(($d&0xff00)>>8);	// Reverse version
		return $d;
	}


	/**
	@description: calcule le CRC16 d'une chaine
	@return: retourne une chaine binaire de 2 Octes (tester avec dechex($d);)
	@param: string date au format ISO 8601 par exemple
	*/
	function CalculateCRC($ptr)	{
		// 0xC6 0xCE 0xA2 0x03 => 0xE2B4
		// 0x88 0x19 0xb6 0x08 => 0xb0aa
		global $TABLE_CRC16;
		$crc = 0x0000;
		settype($crc, "integer");
		for ($i = 0; $i < strlen($ptr); $i++) {
			$crc =  $TABLE_CRC16[(($crc>>8) ^ ord($ptr[$i]))] ^ (($crc<<8) & 0x00FFFF);
		}
		// echo bin2hex($ptr).' => '.dechex($crc)."\n";
		return !$crc?$crc:chr($crc>>8).chr($crc&0xff);
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

