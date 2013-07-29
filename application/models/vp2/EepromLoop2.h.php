<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 20, 21, 22)
/// 1. LOOP data format
/// Only values read directly from sensors are included in the LOOP packet. Desired values (i.e.,
/// Dew Point or Wind Chill) must be calculated on the PC. The LOOP packet also contains
/// information on the current status of all Vantage Alarm conditions, battery status, weather
/// forecasts, and sunrise and sunset times.
// ##############################################################################################
/**
* @param keyName
Convention de nomage :
> Debut de chaine '/^'
> Type de Donnes en base :
			TA :
			TR :
			NO : valeur non stocket en DB
> 1er separeteur le ':'
> Famille de donnée (precédé du type de Table sur 2 caractere en MAJUSCULE) :
			Config = Config user (unité, reglage, ...),
			Arch = Valeur ou etat du relevé d´archive,
			Current = Valeur ou etat actuelle qui etende les données d´archive TA_Arch,
			Sensor = valeur associé a un capteur ex:etalonnage, valeur de declanchement d'alarme,
			Factory = Valeur Usine,
			Other = différente infos fournie par la station.
			Current = Valeur ou etat actuelle qui n´ont d´importance qu´au moment de la lecture ex: valeur d´alarme en cour de depassement.

> 2ieme separeteur le ':'
> Type de donnée :
			Hum = Humidité  
			Temp = Temperature (<!> il en existe 3 format)
			Rain = Pluviometrie
			ET = evapotranspiration
			SoilMoisture = Soil Moisture - l’humidité superficielle du sol
			LeafWetness = Leaf wetness - l’humidité residuelle sur le feuillage
			Various = pour les autres données, vent pression, UV, ...
> 3ieme separateur le ':'
> Nom du capteur :
			sur quelques lettres ex : inside, outside, #2, #3, #4...
> 4ieme separateur ':'
> Descriptif valeur :
			infos sur la valeur relevée ex : Wind:Dir, Wind:Speed, Wind:10mSpeedAvg
>Fin de chaine '$/'
*
* @param pos => possition of the raw data for this sensor  in the VP2 returned RAW string
* @param len => lenth of the raw string result for this sensor
* @param fn => how to convert raw data to number value
* @param SI => how to convert native UNIT to SI unit (NULL if is already in SI unit)
* @param min => min value on the earth *in the native unit
* @param max => max value on the earth *in the native unit
* @param err => returned value if error on this sensor
* @param unit => native unit
**/

	$this->Loop2 = array (
// 	'NO:Data::L'				=>	array( 'pos' => 0,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
// 	'NO:Data::O'				=>	array( 'pos' => 1,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
// 	'NO:Data::O'				=>	array( 'pos' => 2,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
	'NO:Current:Various:Pressure_3hTrend'	=>	array( 'pos' => 3,	'len' => 1,	'fn'=>'BTrend',		'SI'=>NULL,		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Data:Packet:Type:::'					=>	array( 'pos' => 4,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>8,		'err'=>255,	'unit'=> ''	),
// 	'NO:Data::Nextrecord'					=>	array( 'pos' => 5,	'len' => 2,	'fn'=>'Temp',		'SI'=>NULL,		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Various:Pressure_Current'	=>	array( 'pos' => 7,	'len' => 2,	'fn'=>'inHg2Pa',	'SI'=>NULL,		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'Pa'	),
	'NO:Current:Temp:Inside'				=>	array( 'pos' => 9,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>-90,	'max'=>164,		'err'=>255,	'unit'=> '°F'	),
	'NO:Current:Hum:Inside'					=>	array( 'pos' => 11,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,		'min'=>0,	'max'=>100,		'err'=>255,	'unit'=> '%'	),
	'NO:Current:Temp:Outside'				=>	array( 'pos' => 12,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>-90,	'max'=>164,		'err'=>255,	'unit'=> '°F'	),
	'NO:Current:Various:Wind_Speed'			=>	array( 'pos' => 14,	'len' => 1,	'fn'=>'Speed',		'SI'=>'MPH2SI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Various:Wind_Speed_10MinAvg'=>	array( 'pos' => 15,	'len' => 1,	'fn'=>'Speed',		'SI'=>'MPH2SI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Various:Wind_Direction'		=>	array( 'pos' => 16,	'len' => 2,	'fn'=>'Angle360',	'SI'=>NULL,		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Temp:#2'		=>	array( 'pos' => 18,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'NO:Current:Temp:#3'		=>	array( 'pos' => 19,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'NO:Current:Temp:#4'		=>	array( 'pos' => 20,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'NO:Current:Temp:#5'		=>	array( 'pos' => 21,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'NO:Current:Temp:#6'		=>	array( 'pos' => 22,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'NO:Current:Temp:#7'		=>	array( 'pos' => 23,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'NO:Current:Temp:#8'		=>	array( 'pos' => 24,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),

	'NO:Current:Temp:Soil#1'	=>	array( 'pos' => 25,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'NO:Current:Temp:Soil#2'	=>	array( 'pos' => 26,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'NO:Current:Temp:Soil#3'	=>	array( 'pos' => 27,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'NO:Current:Temp:Soil#4'	=>	array( 'pos' => 28,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),

	'NO:Current:Temp:Leaf#1'	=>	array( 'pos' => 29,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'NO:Current:Temp:Leaf#2'	=>	array( 'pos' => 30,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'NO:Current:Temp:Leaf#3'	=>	array( 'pos' => 31,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'NO:Current:Temp:Leaf#4'	=>	array( 'pos' => 32,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),

	'NO:Current:Hum:Out'		=>	array( 'pos' => 33,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'NO:Current:Hum:#2'			=>	array( 'pos' => 34,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'NO:Current:Hum:#3'			=>	array( 'pos' => 35,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'NO:Current:Hum:#4'			=>	array( 'pos' => 36,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'NO:Current:Hum:#5'			=>	array( 'pos' => 37,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'NO:Current:Hum:#6'			=>	array( 'pos' => 38,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'NO:Current:Hum:#7'			=>	array( 'pos' => 39,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'NO:Current:Hum:#8'			=>	array( 'pos' => 40,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),

///						***********  ***********					///
	'NO:Current:Various:Sample_Rain_Rate'		=>	array( 'pos' => 41,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Various:UV'						=>	array( 'pos' => 43,	'len' => 1,	'fn'=>'UV',			'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Various:Solar_Radiation'		=>	array( 'pos' => 44,	'len' => 2,	'fn'=>'Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Various:Sample_Storm'			=>	array( 'pos' => 46,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Various:StartDate_CurrentStorm'	=>	array( 'pos' => 48,	'len' => 2,	'fn'=>'Raw2Date',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'NO:Current:DailyVarious:Sample_Rain'		=>	array( 'pos' => 50,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:MonthlyVarious:Sample_Rain'		=>	array( 'pos' => 52,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:YearlyVarious:Sample_Rain'		=>	array( 'pos' => 54,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'NO:Current:DailyVarious:ET'				=>	array( 'pos' => 56,	'len' => 2,	'fn'=>'ET1000',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:MonthlyVarious:ET'				=>	array( 'pos' => 58,	'len' => 2,	'fn'=>'ET100',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:YearlyVarious:ET'				=>	array( 'pos' => 60,	'len' => 2,	'fn'=>'ET100',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						***********  ***********					///
	'NO:Current:SoilMoisture:#1'				=>	array( 'pos' => 62,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:SoilMoisture:#2'				=>	array( 'pos' => 63,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:SoilMoisture:#3'				=>	array( 'pos' => 64,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:SoilMoisture:#4'				=>	array( 'pos' => 65,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'NO:Current:LeafWetnesses:#1'				=>	array( 'pos' => 66,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:LeafWetnesses:#2'				=>	array( 'pos' => 67,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:LeafWetnesses:#3'				=>	array( 'pos' => 68,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:LeafWetnesses:#4'				=>	array( 'pos' => 69,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm start ***********					///
	'NO:Current:Alarm:Press_3hTrend_Rise'		=>	array( 'pos' => 70.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Press_3hTrend_Fall'		=>	array( 'pos' => 70.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Low_In'				=>	array( 'pos' => 70.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:High_In'				=>	array( 'pos' => 70.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:Low_In'				=>	array( 'pos' => 70.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:High_In'				=>	array( 'pos' => 70.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Time'						=>	array( 'pos' => 70.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Alarm:RainRate'					=>	array( 'pos' => 71.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Rain15min'				=>	array( 'pos' => 71.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Rain24h'					=>	array( 'pos' => 71.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:RainStorm'				=>	array( 'pos' => 71.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:EtDay'					=>	array( 'pos' => 71.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Alarm:Temp:Low_Out'				=>	array( 'pos' => 72.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:High_Out'			=>	array( 'pos' => 72.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Speed'					=>	array( 'pos' => 72.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Speed10min'				=>	array( 'pos' => 72.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:DewPt_Low'				=>	array( 'pos' => 72.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:DewPt_High'				=>	array( 'pos' => 72.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Heat_High'				=>	array( 'pos' => 72.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Chill_Low'				=>	array( 'pos' => 72.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Alarm:Thsw_High'				=>	array( 'pos' => 73.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Solar_High'				=>	array( 'pos' => 73.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Uv_High'					=>	array( 'pos' => 73.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:UvDose'					=>	array( 'pos' => 73.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:UvDose_Enabled'			=>	array( 'pos' => 73.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm Out Temp ***********					///
	'NO:Current:Alarm:Hum:Out:Low'	=>	array( 'pos' => 74.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:Out:High'	=>	array( 'pos' => 74.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Alarm:Temp:#2:Low'	=>	array( 'pos' => 75.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:#2:High'	=>	array( 'pos' => 75.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:#2:Low'	=>	array( 'pos' => 75.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:#2:High'	=>	array( 'pos' => 75.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Alarm:Temp:#3:Low'	=>	array( 'pos' => 76.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:#3:High'	=>	array( 'pos' => 76.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:#3:Low'	=>	array( 'pos' => 76.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:#3:High'	=>	array( 'pos' => 76.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Alarm:Temp:#4:Low'	=>	array( 'pos' => 77.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:#4:High'	=>	array( 'pos' => 77.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:#4:Low'	=>	array( 'pos' => 77.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:#4:High'	=>	array( 'pos' => 77.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Alarm:Temp:#5:Low'	=>	array( 'pos' => 78.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:#5:High'	=>	array( 'pos' => 78.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:#5:Low'	=>	array( 'pos' => 78.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:#5:High'	=>	array( 'pos' => 78.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Alarm:Temp:#6:Low'	=>	array( 'pos' => 79.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:#6:High'	=>	array( 'pos' => 79.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:#6:Low'	=>	array( 'pos' => 79.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:#6:High'	=>	array( 'pos' => 79.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Alarm:Temp:#7:Low'	=>	array( 'pos' => 80.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:#7:High'	=>	array( 'pos' => 80.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:#7:Low'	=>	array( 'pos' => 80.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:#7:High'	=>	array( 'pos' => 80.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Alarm:Temp:#8:Low'	=>	array( 'pos' => 81.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:#8:High'	=>	array( 'pos' => 81.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:#8:Low'	=>	array( 'pos' => 81.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Hum:#8:High'	=>	array( 'pos' => 81.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm Out Soil&Leaf ***********					///
	'NO:Current:Alarm:LeafWetnesses:Leaf#1:Low'	=>	array( 'pos' => 82.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:LeafWetnesses:Leaf#1:High'=>	array( 'pos' => 82.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:SoilMoisture:Soil#1:Low'	=>	array( 'pos' => 82.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:SoilMoisture:Soil#1:High'	=>	array( 'pos' => 82.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Leaf#1:Low'			=>	array( 'pos' => 82.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Leaf#1:High'			=>	array( 'pos' => 82.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Soil#1:Low'			=>	array( 'pos' => 82.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Soil#1:High'			=>	array( 'pos' => 82.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Alarm:LeafWetnesses:Leaf#2:Low'	=>	array( 'pos' => 83.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:LeafWetnesses:Leaf#2:High'=>	array( 'pos' => 83.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:SoilMoisture:Soil#2:Low'	=>	array( 'pos' => 83.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:SoilMoisture:Soil#2:High'	=>	array( 'pos' => 83.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Leaf#2:Low'			=>	array( 'pos' => 83.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Leaf#2:High'			=>	array( 'pos' => 83.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Soil#2:Low'			=>	array( 'pos' => 83.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Soil#2:High'			=>	array( 'pos' => 83.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Alarm:LeafWetnesses:Leaf#3:Low'	=>	array( 'pos' => 84.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:LeafWetnesses:Leaf#3:High'=>	array( 'pos' => 84.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:SoilMoisture:Soil#3:Low'	=>	array( 'pos' => 84.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:SoilMoisture:Soil#3:High'	=>	array( 'pos' => 84.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Leaf#3:Low'			=>	array( 'pos' => 84.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Leaf#3:High'			=>	array( 'pos' => 84.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Soil#3:Low'			=>	array( 'pos' => 84.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Soil#3:High'			=>	array( 'pos' => 84.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Alarm:LeafWetnesses:Leaf#4:Low'	=>	array( 'pos' => 85.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:LeafWetnesses:Leaf#4:High'=>	array( 'pos' => 85.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:SoilMoisture:Soil#4:Low'	=>	array( 'pos' => 85.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:SoilMoisture:Soil#4:High'	=>	array( 'pos' => 85.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Leaf#4:Low'			=>	array( 'pos' => 85.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Leaf#4:High'			=>	array( 'pos' => 85.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Soil#4:Low'			=>	array( 'pos' => 85.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Alarm:Temp:Soil#4:High'			=>	array( 'pos' => 85.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

// 	'TransmitterBatteryStatus'=>	array( 'pos' => 86,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'NO:Current:Various:Voltage:Console_Battery'=>	array( 'pos' => 87,	'len' => 2,	'fn'=>'Voltage',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Various:Forecast:Icons'			=>	array( 'pos' => 89,	'len' => 1,	'fn'=>'Icons',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Various:Forecast:Rule'			=>	array( 'pos' => 90,	'len' => 1,	'fn'=>'Forecast',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Various:Time:Sunrise'			=>	array( 'pos' => 91,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Current:Various:Time:Sunset'			=>	array( 'pos' => 93,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	);
?>