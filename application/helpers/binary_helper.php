<?php
	function hexToDec($hex)	{
		return hexdec(bin2hex($hex));
	}
	function Bool($str) {// 
		return ord($str) ? 1 : 0 ;
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
// 		echo decbin($oct).' > '.$bitPos.','.$nbrBit.' = '.decbin($oct>>$bitPos).' & '.decbin(pow(2,$nbrBit)-1).' => '.decbin(($oct>>$bitPos)&(pow(2,$nbrBit)-1))."\n";
		return ($oct>>$bitPos)&(pow(2,$nbrBit)-1);
	}