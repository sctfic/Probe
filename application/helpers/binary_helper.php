<?php
	function hexToDec($hex)	{
		return hexdec(bin2hex($hex));
	}
	function Bool($str) {// 
		return ord($str) ? TRUE : FALSE ;
	}
	function Char2Signed($val) {
	// Char2Signed http://en.wikipedia.org/wiki/Two%27s_complement
	// return value between 0 - 255 into signed -128 - +127...Two's complement
		return (($val>>7)?(($val ^ 0xFF)+1)*(-1):$val);
	}
	/** IL SEMBLE Y AVOIR UN PB ENTRE s2sc et Char2Signed **/
	function s2sc($str) {// String to Signed Char
		return Char2Signed($str);
	}
	function s2uc($str) {// String to unSigned Char
		return (hexToDec($str));
	}
	function Short2Signed($val) {
	// Char2Signed http://en.wikipedia.org/wiki/Two%27s_complement
	// return value between 0 - 65532 into signed -32768 - +32767...Two's complement
		return (($val>>15)?(($val ^ 0xFFFF)+1)*(-1):$val);
	}
	function s2sSht($str) {// String to Signed Short
		return Short2Signed(hexToDec(strrev($str)));
	}
	function s2uSht($str) {// String to unSigned Short
		return (hexToDec(strrev($str)));
	}
	function getBits($oct, $bitPos, $nbrBit) { // recupaire dans un octé $oct l´etat des $nbrBit a partir du bit $bitPos
		return ($oct<<$bitPos)&(pow(2,$nbrBit)-1);
	}
// 	function UnitBits($str) {// ...
// 		$val = s2uc($str);
// 		return array_combine(array("Unit.Wind","Unit.Rain","Unit.Elev","Unit.Temp","Unit.Barom"),
// 			array(
// 				!(($val&0xC0)>>6)?"mph":(((($val&0xC0)>>6)==1)?"m/s":(((($val&0xC0)>>6)==2)?"Km/h":"Knots")),
// 				(($val&0x20)>>5)?"mm":"in",
// 				(($val&0x10)>>4)?"m":"ft",
// 				!(($val&0x0C)>>2)?"1 °F":(((($val&0x0C)>>2)==1)?"0.1 °F":(((($val&0x0C)>>2)==2)?"1 °C":"0.1 °C")),
// 				!($val&0x03)?"0.01 in":((($val&0x03)==1)?"0.1 mm":((($val&0x03)==2)?"0.1 hpa":"0.1 mB")),
// 		));
// 	}
// 	function SetupBits($str) {// ...
// 		$val = s2uc($str);
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