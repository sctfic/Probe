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

	$this->Loop = array (
// 	'LPS0:Data::L'				=>	array( 'pos' => 0,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
// 	'LPS0:Data::O'				=>	array( 'pos' => 1,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
// 	'LPS0:Data::O'				=>	array( 'pos' => 2,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
	'LPS0:Current:Air:Bar:3hTrend'	=>	array( 'pos' => 3,	'len' => 1,	'fn'=>'BTrend',		'SI'=>NULL,		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Data:Packet:Type'					=>	array( 'pos' => 4,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>8,		'err'=>255,	'unit'=> ''	),
// 	'LPS0:Data::Nextrecord'					=>	array( 'pos' => 5,	'len' => 2,	'fn'=>'Temp',		'SI'=>NULL,		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Bar:now'	=>	array( 'pos' => 7,	'len' => 2,	'fn'=>'Pressure',	'SI'=>NULL,		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Temp:Inside:now'				=>	array( 'pos' => 9,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>-90,	'max'=>164,		'err'=>255,	'unit'=> '°F'	),
	'LPS0:Current:Air:Hum:Inside:now'					=>	array( 'pos' => 11,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,		'min'=>0,	'max'=>100,		'err'=>255,	'unit'=> '%'	),
	'LPS0:Current:Air:Temp:Sensor#1:now'				=>	array( 'pos' => 12,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>-90,	'max'=>164,		'err'=>255,	'unit'=> '°F'	),
	'LPS0:Current:Air:Wind:Speed:now'			=>	array( 'pos' => 14,	'len' => 1,	'fn'=>'Speed',		'SI'=>'MPH2SI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Wind:Speed_10MinAvg'=>	array( 'pos' => 15,	'len' => 1,	'fn'=>'Speed',		'SI'=>'MPH2SI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Wind:Direction'		=>	array( 'pos' => 16,	'len' => 2,	'fn'=>'Angle360',	'SI'=>NULL,		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Air:Temp:Sensor#2:now'		=>	array( 'pos' => 18,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'LPS0:Current:Air:Temp:Sensor#3:now'		=>	array( 'pos' => 19,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'LPS0:Current:Air:Temp:Sensor#4:now'		=>	array( 'pos' => 20,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'LPS0:Current:Air:Temp:Sensor#5:now'		=>	array( 'pos' => 21,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'LPS0:Current:Air:Temp:Sensor#6:now'		=>	array( 'pos' => 22,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'LPS0:Current:Air:Temp:Sensor#7:now'		=>	array( 'pos' => 23,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'LPS0:Current:Air:Temp:Sensor#8:now'		=>	array( 'pos' => 24,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),

	'LPS0:Current:Soil:Temp:Sensor#1:now'	=>	array( 'pos' => 25,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'LPS0:Current:Soil:Temp:Sensor#2:now'	=>	array( 'pos' => 26,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'LPS0:Current:Soil:Temp:Sensor#3:now'	=>	array( 'pos' => 27,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'LPS0:Current:Soil:Temp:Sensor#4:now'	=>	array( 'pos' => 28,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),

	'LPS0:Current:Leaf:Temp:Sensor#1:now'	=>	array( 'pos' => 29,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'LPS0:Current:Leaf:Temp:Sensor#2:now'	=>	array( 'pos' => 30,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'LPS0:Current:Leaf:Temp:Sensor#3:now'	=>	array( 'pos' => 31,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'LPS0:Current:Leaf:Temp:Sensor#4:now'	=>	array( 'pos' => 32,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),

	'LPS0:Current:Air:Hum:Sensor#1:now'		=>	array( 'pos' => 33,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'LPS0:Current:Air:Hum:Sensor#2:now'			=>	array( 'pos' => 34,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'LPS0:Current:Air:Hum:Sensor#3:now'			=>	array( 'pos' => 35,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'LPS0:Current:Air:Hum:Sensor#4:now'			=>	array( 'pos' => 36,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'LPS0:Current:Air:Hum:Sensor#5:now'			=>	array( 'pos' => 37,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'LPS0:Current:Air:Hum:Sensor#6:now'			=>	array( 'pos' => 38,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'LPS0:Current:Air:Hum:Sensor#7:now'			=>	array( 'pos' => 39,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'LPS0:Current:Air:Hum:Sensor#8:now'			=>	array( 'pos' => 40,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),

///						***********  ***********					///
	'LPS0:Current:Sample_Rain_Rate'		=>	array( 'pos' => 41,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:UV'						=>	array( 'pos' => 43,	'len' => 1,	'fn'=>'UV',			'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Solar_Radiation'		=>	array( 'pos' => 44,	'len' => 2,	'fn'=>'Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Sample_Storm'			=>	array( 'pos' => 46,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:StartDate_CurrentStorm'	=>	array( 'pos' => 48,	'len' => 2,	'fn'=>'Raw2Date',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:DailySample_Rain'		=>	array( 'pos' => 50,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:MonthlySample_Rain'		=>	array( 'pos' => 52,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:YearlySample_Rain'		=>	array( 'pos' => 54,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:DailyET'				=>	array( 'pos' => 56,	'len' => 2,	'fn'=>'ET1000',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:MonthlyET'				=>	array( 'pos' => 58,	'len' => 2,	'fn'=>'ET100',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:YearlyET'				=>	array( 'pos' => 60,	'len' => 2,	'fn'=>'ET100',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						***********  ***********					///
	'LPS0:Current:Soil:Moisture:Sensor#1:now'				=>	array( 'pos' => 62,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Moisture:Sensor#2:now'				=>	array( 'pos' => 63,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Moisture:Sensor#3:now'				=>	array( 'pos' => 64,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Moisture:Sensor#4:now'				=>	array( 'pos' => 65,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Leaf:Wetnesses:Sensor#1:now'				=>	array( 'pos' => 66,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Wetnesses:Sensor#2:now'				=>	array( 'pos' => 67,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Wetnesses:Sensor#3:now'				=>	array( 'pos' => 68,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Wetnesses:Sensor#4:now'				=>	array( 'pos' => 69,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm start ***********					///
	'LPS0:Current:Press_3hTrend_Rise:AlarmStatut'		=>	array( 'pos' => 70.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Press_3hTrend_Fall:AlarmStatut'		=>	array( 'pos' => 70.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Temp:Inside:Low:AlarmStatut'				=>	array( 'pos' => 70.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Temp:Inside:High:AlarmStatut'				=>	array( 'pos' => 70.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Inside:Low:AlarmStatut'				=>	array( 'pos' => 70.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Inside:High:AlarmStatut'				=>	array( 'pos' => 70.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Data:Time:AlarmStatut'						=>	array( 'pos' => 70.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:RainRate:AlarmStatut'					=>	array( 'pos' => 71.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Rain15min:AlarmStatut'				=>	array( 'pos' => 71.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Rain24h:AlarmStatut'					=>	array( 'pos' => 71.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:RainStorm:AlarmStatut'				=>	array( 'pos' => 71.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:EtDay:AlarmStatut'					=>	array( 'pos' => 71.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Air:Temp:Sensor#1:AlarmStatut:Low'				=>	array( 'pos' => 72.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Temp:Sensor#1:AlarmStatut:High'			=>	array( 'pos' => 72.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Speed:AlarmStatut'					=>	array( 'pos' => 72.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Speed10min:AlarmStatut'				=>	array( 'pos' => 72.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:DewPt:Low:AlarmStatut'				=>	array( 'pos' => 72.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:DewPt:High:AlarmStatut'				=>	array( 'pos' => 72.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Heat:High:AlarmStatut'				=>	array( 'pos' => 72.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Chill:Low:AlarmStatut'				=>	array( 'pos' => 72.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Air:Thsw:High:AlarmStatut'				=>	array( 'pos' => 73.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Solar:High:AlarmStatut'				=>	array( 'pos' => 73.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Uv:High:AlarmStatut'					=>	array( 'pos' => 73.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:UvDose:AlarmStatut'					=>	array( 'pos' => 73.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Data:UvDose:Enabled:AlarmStatut'			=>	array( 'pos' => 73.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm Out Temp ***********					///
	'LPS0:Current:Air:Hum:Sensor#1:AlarmStatut:Low'	=>	array( 'pos' => 74.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#1:AlarmStatut:High'	=>	array( 'pos' => 74.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Air:Temp:Sensor#2:AlarmStatut:Low'	=>	array( 'pos' => 75.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Temp:Sensor#2:AlarmStatut:High'	=>	array( 'pos' => 75.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#2:AlarmStatut:Low'	=>	array( 'pos' => 75.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#2:AlarmStatut:High'	=>	array( 'pos' => 75.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Air:Temp:Sensor#3:AlarmStatut:Low'	=>	array( 'pos' => 76.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Temp:Sensor#3:AlarmStatut:High'	=>	array( 'pos' => 76.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#3:AlarmStatut:Low'	=>	array( 'pos' => 76.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#3:AlarmStatut:High'	=>	array( 'pos' => 76.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Air:Temp:Sensor#4:AlarmStatut:Low'	=>	array( 'pos' => 77.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Temp:Sensor#4:AlarmStatut:High'	=>	array( 'pos' => 77.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#4:AlarmStatut:Low'	=>	array( 'pos' => 77.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#4:AlarmStatut:High'	=>	array( 'pos' => 77.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Air:Temp:Sensor#5:AlarmStatut:Low'	=>	array( 'pos' => 78.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Temp:Sensor#5:AlarmStatut:High'	=>	array( 'pos' => 78.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#5:AlarmStatut:Low'	=>	array( 'pos' => 78.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#5:AlarmStatut:High'	=>	array( 'pos' => 78.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Air:Temp:Sensor#6:AlarmStatut:Low'	=>	array( 'pos' => 79.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Temp:Sensor#6:AlarmStatut:High'	=>	array( 'pos' => 79.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#6:AlarmStatut:Low'	=>	array( 'pos' => 79.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#6:AlarmStatut:High'	=>	array( 'pos' => 79.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Air:Temp:Sensor#7:AlarmStatut:Low'	=>	array( 'pos' => 80.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Temp:Sensor#7:AlarmStatut:High'	=>	array( 'pos' => 80.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#7:AlarmStatut:Low'	=>	array( 'pos' => 80.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#7:AlarmStatut:High'	=>	array( 'pos' => 80.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Air:Temp:Sensor#8:AlarmStatut:Low'	=>	array( 'pos' => 81.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Temp:Sensor#8:AlarmStatut:High'	=>	array( 'pos' => 81.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#8:AlarmStatut:Low'	=>	array( 'pos' => 81.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Air:Hum:Sensor#8:AlarmStatut:High'	=>	array( 'pos' => 81.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm Out Soil&Leaf ***********					///
	'LPS0:Current:Leaf:Wetnesses:Sensor#1:AlarmStatut:Low'	=>	array( 'pos' => 82.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Wetnesses:Sensor#1:AlarmStatut:High'=>	array( 'pos' => 82.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Moisture:Sensor#1:AlarmStatut:Low'	=>	array( 'pos' => 82.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Moisture:Sensor#1:AlarmStatut:High'	=>	array( 'pos' => 82.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Temp:Sensor#1:AlarmStatut:Low'			=>	array( 'pos' => 82.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Temp:Sensor#1:AlarmStatut:High'			=>	array( 'pos' => 82.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Temp:Sensor#1:AlarmStatut:Low'			=>	array( 'pos' => 82.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Temp:Sensor#1:AlarmStatut:High'			=>	array( 'pos' => 82.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Leaf:Wetnesses:Sensor#2:AlarmStatut:Low'	=>	array( 'pos' => 83.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Wetnesses:Sensor#2:AlarmStatut:High'=>	array( 'pos' => 83.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Moisture:Sensor#2:AlarmStatut:Low'	=>	array( 'pos' => 83.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Moisture:Sensor#2:AlarmStatut:High'	=>	array( 'pos' => 83.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Temp:Sensor#2:AlarmStatut:Low'			=>	array( 'pos' => 83.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Temp:Sensor#2:AlarmStatut:High'			=>	array( 'pos' => 83.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Temp:Sensor#2:AlarmStatut:Low'			=>	array( 'pos' => 83.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Temp:Sensor#2:AlarmStatut:High'			=>	array( 'pos' => 83.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Leaf:Wetnesses:Sensor#3:AlarmStatut:Low'	=>	array( 'pos' => 84.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Wetnesses:Sensor#3:AlarmStatut:High'=>	array( 'pos' => 84.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Moisture:Sensor#3:AlarmStatut:Low'	=>	array( 'pos' => 84.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Moisture:Sensor#3:AlarmStatut:High'	=>	array( 'pos' => 84.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Temp:Sensor#3:AlarmStatut:Low'			=>	array( 'pos' => 84.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Temp:Sensor#3:AlarmStatut:High'			=>	array( 'pos' => 84.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Temp:Sensor#3:AlarmStatut:Low'			=>	array( 'pos' => 84.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Temp:Sensor#3:AlarmStatut:High'			=>	array( 'pos' => 84.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Leaf:Wetnesses:Sensor#4:AlarmStatut:Low'	=>	array( 'pos' => 85.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Wetnesses:Sensor#4:AlarmStatut:High'=>	array( 'pos' => 85.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Moisture:Sensor#4:AlarmStatut:Low'	=>	array( 'pos' => 85.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Moisture:Sensor#4:AlarmStatut:High'	=>	array( 'pos' => 85.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Temp:Sensor#4:AlarmStatut:Low'			=>	array( 'pos' => 85.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Leaf:Temp:Sensor#4:AlarmStatut:High'			=>	array( 'pos' => 85.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Temp:Sensor#4:AlarmStatut:Low'			=>	array( 'pos' => 85.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Soil:Temp:Sensor#4:AlarmStatut:High'			=>	array( 'pos' => 85.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

// 	'TransmitterBatteryStatus'=>	array( 'pos' => 86,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LPS0:Current:Voltage:Console_Battery'=>	array( 'pos' => 87,	'len' => 2,	'fn'=>'Voltage',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Forecast:Icons'			=>	array( 'pos' => 89,	'len' => 1,	'fn'=>'Icons',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Forecast:Rule'			=>	array( 'pos' => 90,	'len' => 1,	'fn'=>'Forecast',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Time:Sunrise'			=>	array( 'pos' => 91,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LPS0:Current:Time:Sunset'			=>	array( 'pos' => 93,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	);
?>