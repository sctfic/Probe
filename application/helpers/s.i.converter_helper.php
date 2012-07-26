<?php
// http://www.davisnet.com/support/weather/downloads/software_direct.asp?SoftCat=4&SoftwareID=172
/**
		#################################################################################
		################	Function for RAW data convertion	#################
		#################################################################################
**/
	function Gain($str) {// ...
		return self::hexToDec(strrev($str))/1000;
	}
	function Cal($str) {// ...
		return self::hexToDec(strrev($str))/1000;
	}
	function Offset($str) {// ...
		return self::s2sSht($str);
	}
	function Alt($str) {// Altitude
		return self::s2sSht($str);
	}
	function GPS($str) {// Position GPS
		return self::s2sSht($str)/10;
	}
	function GMT($str) {// ...
		$val = self::s2sSht($str);
		return (int)($val/100).":".str_pad((abs($val)%100),2,"0",STR_PAD_LEFT);
	}
	function Station($str) {// ...
		return null;
	}
	function Pressure($str) {// Pressure...
		$val = self::hexToDec(strrev($str));
		return $val/1000;
	}
	function Temp($str) {// Temperature...
		return self::s2sSht($str)/10;
	}
	function CalTemp($str) {// Temperature...
		return self::s2sc($str)/10;
	}
	function SmallTemp($str) {// Temperature...
		return self::s2uc($str)-90;
	}
	function SmallTemp120($str) {// Temperature...
		return self::s2uc($str)-120;
	}
	function Speed($str) {// Wind Speed...
		return self::hexToDec($str);
	}
	function Samples($str) {// number of clic...
		return self::s2uSht($str);
	}
	function Radiation($str) {// Solar Radiation...
		return self::s2sSht($str);
	}
	function ET_h($str) {// Evapotranspiration...
		return self::s2uc($str)/1000;
	}
	function ET1000($str) {// Evapotranspiration...
		return self::s2uSht($str)/1000;
	}
	function ET100($str) {// Evapotranspiration...
		return self::s2uSht($str)/100;
	}
	function UV($str) {// UV level...
		return self::s2uc($str)/10;
	}

	function Forecast($str) {// Forecast for next day...
		return self::s2uc($str);
	}

	function Rate($str) {// Percentage...
		return self::s2uc($str);
	}
	function Moistures ($str){ // Humidite du sol
		return self::s2uc($str);
	}
	function Wetnesses($str) {// Humectometre...
		return self::s2uc($str);
	}

	function Angle16($str) {// Wind Direction...
		return self::s2uc($str);
	}
	function Angle360($str) {// Wind Direction...
		return self::s2sSht($str);
	}
	function SpRev($str) {// Special revision...
		if (self::hexToDec($str)==255)
			return 'Rev A';
		return 'Rev B';
	}
	function BTrend($str) {// ...
		return self::$TREND[self::s2uc($str)];
	}

	function RainAlarms($str) {// ...
		return self::s2sSht($str);
	}
	function HumidityAlarms($str) {// ...
		return self::s2uc($str);
	}
	function Soil_LeafAlarms($str) {// ...
		$val = self::hexToDec($str);
		return $val;
	}
	function Voltage($str) {// Tension of inside battery
		return ((self::s2uSht($str)*300)/512)/100.0;
	}
	function Icons($str) {// ...
		return self::s2uc($str);
	}
	function metric($val){
		return round($val/3.2808, 2);
	}
	function tempSI($val){
		return self::celcius($val);
	}
	function celcius($val){ // convert °F to celcius
		return round(($val-32)*5/9, 2);
	}
	function kelvin($val){ // convert °F to Kelvin
		return round(($val+459.67)*5/9, 2);
	}
	function mBySec($val){ // convert milles per hour speed 
		return round($val/2.2369362920544, 3); // (3600/((5280*12)*0.0254));
	}
	function kmByh($val){ // convert milles per hour speed 
		return round($val*1,609.345, 2); // (3600/((5280*12)*0.0254));
	}
	function barSI ($val){
	return $val;
	}
	function UTC ($val){
	return strtotime($val);
	}