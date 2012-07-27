<?php
// http://www.davisnet.com/support/weather/downloads/software_direct.asp?SoftCat=4&SoftwareID=172
/**
		#################################################################################
		################	Function for RAW data convertion	#################
		#################################################################################
**/
	function Gain($str) {// ...
		return hexToDec(strrev($str))/1000;
	}
	function Cal($str) {// ...
		return hexToDec(strrev($str))/1000;
	}
	function Offset($str) {// ...
		return s2sSht($str);
	}
	function Alt($str) {// Altitude
		return s2sSht($str);
	}
	function GPS($str) {// Position GPS
		return s2sSht($str)/10;
	}
	function GMT($str) {// ...
		$val = s2sSht($str);
		return (int)($val/100).":".str_pad((abs($val)%100),2,"0",STR_PAD_LEFT);
	}
	function Station($str) {// ...
		return null;
	}
	function Pressure($str) {// Pressure...
		$val = hexToDec(strrev($str));
		return $val/1000;
	}
	function Temp($str) {// Temperature...
		return s2sSht($str)/10;
	}
	function CalTemp($str) {// Temperature...
		return s2sc($str)/10;
	}
	function SmallTemp($str) {// Temperature...
		return s2uc($str)-90;
	}
	function SmallTemp120($str) {// Temperature...
		return s2uc($str)-120;
	}
	function Speed($str) {// Wind Speed...
		return hexToDec($str);
	}
	function Samples($str) {// number of clic...
		return s2uSht($str);
	}
	function Radiation($str) {// Solar Radiation...
		return s2sSht($str);
	}
	function ET_h($str) {// Evapotranspiration...
		return s2uc($str)/1000;
	}
	function ET1000($str) {// Evapotranspiration...
		return s2uSht($str)/1000;
	}
	function ET100($str) {// Evapotranspiration...
		return s2uSht($str)/100;
	}
	function UV($str) {// UV level...
		return s2uc($str)/10;
	}

	function Forecast($str) {// Forecast for next day...
		return s2uc($str);
	}

	function Rate($str) {// Percentage...
		return s2uc($str);
	}
	function Moistures ($str){ // Humidite du sol
		return s2uc($str);
	}
	function Wetnesses($str) {// Humectometre...
		return s2uc($str);
	}

	function Angle16($str) {// Wind Direction...
		return s2uc($str);
	}
	function Angle360($str) {// Wind Direction...
		return s2sSht($str);
	}
	function SpRev($str) {// Special revision...
		if (hexToDec($str)==255)
			return 'Rev A';
		return 'Rev B';
	}
	function BTrend($str) {// ...
		return $TREND[s2uc($str)];
	}

	function RainAlarms($str) {// ...
		return s2sSht($str);
	}
	function HumidityAlarms($str) {// ...
		return s2uc($str);
	}
	function Soil_LeafAlarms($str) {// ...
		$val = hexToDec($str);
		return $val;
	}
	function Voltage($str) {// Tension of inside battery
		return ((s2uSht($str)*300)/512)/100.0;
	}
	function Icons($str) {// ...
		return s2uc($str);
	}
	function metric($val){
		return round($val/3.2808, 2);
	}
	function tempSI($val){
		return celcius($val);
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