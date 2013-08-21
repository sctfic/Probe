<?php
// http://www.davisnet.com/support/weather/downloads/software_direct.asp?SoftCat=4&SoftwareID=172
// http://www.periodni.com/fr/systeme_international_d_unites.html
/**
		#################################################################################
		################	Function for RAW data convertion	#################
		#################################################################################
**/
	function F2celcius($val){ // convert °F to celcius
		return round(($val-32)*5/9, 2);
	}
	function F2kelvin($val){ // convert °F to Kelvin
		return round(($val+459.67)*5/9, 2);
	}


	function MPH2SI($val) {
		return mph2mBySec($val);
	}
	function mph2mBySec($val){ // convert milles per hour speed 
		return round($val/2.23693629, 3); // (3600/((5280*12)*0.0254));
	}
	function mph2KmByh($val){ // convert milles per hour speed 
		return round($val*1.609344, 2); // (3600/((5280*12)*0.0254));
	}


	function inHg2Pa ($val){
		//		http://www.sensorsone.co.uk/pressure-measurement-glossary/inhg-inch-of-mercury-0-deg-c-pressure-unit.html#factors
		return round(3386.39*$val, 0)	;
	}
	function RainSample2mm($Sample, $auge) {
		// global $auge;
        // where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,array($Sample, $auge));
    //     CURRENT	- 2013/Jun/10 14:21:03 -> s.i.converter_helper.php [34]:/RainSample2mm(
				// > Array( [0]=> [1]=>))

// UPDATE  `TA_VARIOUS` SET  `VALUE` =  `VALUE` /5,
// UTC = UTC WHERE (
// 		`SEN_ID` =5 OR  `SEN_ID` =6
// ) AND (
// 		`VALUE` =1 OR  `VALUE` =2 OR  `VALUE` =3 OR  `VALUE` =4 OR  `VALUE` =5 OR  `VALUE` =6
// )
		switch ($auge){
			case 0: // 0.1 Inche to mm
			return $Sample/10*2.54;
				break;
			case 1: // 0.2 Millimettre
			return $Sample/5;
				break;
			case 2: // 0.1 Millimettre
			return $Sample/10;
				break;
		}
	}
	function sSht_01($str) {// Position GPS, Temperature...
		return s2sSht($str)/10;
	}
	function _0001($str) {// Gain, Calibrate, Pressure
		return hexToDec(strrev($str))/1000;
	}
	function Voltage($str) {// Tension of inside battery
		return ((s2uSht($str)*300)/512)/100.0;
	}
	function ft2m($val){
		return round($val/3.2808, 2);
	}
	function none($val){
		return $val;
	}

	
/**
	function P_Alt_0($P_VP2, $Elevation_in_m, $Temp_in_K, $gravity = 9.80665) {
		//		http://en.wikipedia.org/wiki/Atmospheric_pressure#Altitude_atmospheric_pressure_variation
		return $P_VP2 / pow((1-(0.0065*$Elevation_in_m)/$Temp_in_K), ($gravity*0.0289644)/(8.31447*0.0065));
		//		http://san.hufs.ac.kr/~gwlee/session3/sealev1calc.html
		//		masse molumique de l'air humide
		//		http://fr.wikipedia.org/wiki/Masse_volumique_de_l%27air
	}
	function P_Alt_of_VP2($P_Alt0, $Elevation_in_m, $Temp_in_K, $gravity = 9.80665) {
		//		http://en.wikipedia.org/wiki/Atmospheric_pressure#Altitude_atmospheric_pressure_variation
		return $P_Alt0 * pow((1-(0.0065*$Elevation_in_m)/$Temp_in_K), ($gravity*0.0289644)/(8.31447*0.0065));
	}
	
	function Gravity($Elevation_in_meter, $latitude_in_degres = 45) {
		//		http://fr.wikipedia.org/wiki/Champ_de_gravitee#.C3.89valuation_de_la_pesanteur_terrestre
		return 9.780318 * ((1+0.0053024*SqareSin($latitude_in_degres) - 0.0000059*SqareSin(2*$latitude_in_degres)) - 0.000000315*$Elevation_in_meter);
		//		$Normal_gravity = 9.80665 m/s2
	}
	function SqareSin($x){
		// 		1/2(1-cos2x)=sin²x
		return 1/2*(1-cos(2*deg2rad($x)));
	}
**/
	
	function Soil_LeafAlarms($str) {// ...
		return hexToDec($str);
	}
	
	
	function GMT($str) {// ...
		$val = s2sSht($str);
		return (abs($val)<1000 ?
			($val<0 ?
				'-0'.(int)(abs($val)/100):
				'+0'.(int)($val/100))
			:(int)($val/100))
		.":".str_pad((abs($val)%100),2,"0",STR_PAD_LEFT);

		// return (int)($val/100).":".str_pad((abs($val)%100),2,"0",STR_PAD_LEFT);
	}
	function Station($str) {// ...
		return null;
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
	
	function Angle360($str) {// Wind Direction...
		return s2sSht($str);
	}
	function SpRev($str) {// Special revision...
		if (hexToDec($str)==255)
			return 'Rev A';
		return 'Rev B';
	}
	function BTrend($str) {// ...
		$TREND = array(
			196=>'Falling Rapidly',
			236=>'Falling Slowly',
			0=>'Steady',
			20=>'Rising Slowly',
			60=>'Rising Rapidly',
			80=>'Rev A');
		return $TREND[s2uc($str)];
	}

	function RainAlarms($str) {// ...
		return s2sSht($str);
	}

	function UTC ($val){
		return strtotime($val);
	}