<?php
// ##############################################################################################
/// XII. EEPROM configuration settings (See Docs on pages 35, 36, 37, 38)
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

	$this->EEPROM = array (
	'TR:Config:Bar:Calibration:Gain'	=>	array( 'pos' => 1,	'len' => 2,	'w'=>false,	'fn'=>'_0001',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Bar:Calibration:Offset'	=>	array( 'pos' => 3,	'len' => 2,	'w'=>false,	'fn'=>'s2sSht',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Bar:Calibration:Cal'		=>	array( 'pos' => 5,	'len' => 2,	'w'=>false,	'fn'=>'_0001',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Hum:Calibration:@33%'	=>	array( 'pos' => 7,	'len' => 2,	'w'=>false,	'fn'=>'s2sSht',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Hum:Calibration:@80%'	=>	array( 'pos' => 9,	'len' => 2,	'w'=>false,	'fn'=>'s2sSht',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Geo:Latitude:NordValue'	=>	array( 'pos' => 11,	'len' => 2,	'w'=>false,	'fn'=>'sSht_01',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> '°N'	),
	'TR:Config:Geo:Longitude:EstValue'	=>	array( 'pos' => 13,	'len' => 2,	'w'=>false,	'fn'=>'sSht_01',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> '°E'	),
	'TR:Config:Geo:Elevation:Ocean'		=>	array( 'pos' => 15,	'len' => 2,	'w'=>false,	'fn'=>'s2sSht',		'SI'=>'ft2m',	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> 'feet'	),
	'TR:Config:Geo:Time:Zone'			=>	array( 'pos' => 17,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Daylight:Savings:Manual'	=>	array( 'pos' => 18,	'len' => 1,	'w'=>false,	'fn'=>'Bool',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Daylight:Savings:Enable'	=>	array( 'pos' => 19,	'len' => 1,	'w'=>false,	'fn'=>'Bool',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Time:Gmt:Offset'			=>	array( 'pos' => 20,	'len' => 2,	'w'=>false,	'fn'=>'GMT',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Time:Gmt:Enable'			=>	array( 'pos' => 22,	'len' => 1,	'w'=>false,	'fn'=>'Bool',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Other:::UseTx'					=>	array( 'pos' => 23,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'NO:Other:::ReTransmitTx'			=>	array( 'pos' => 24,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

/*	'Other:StationList1'		=>	array( 'pos' => 25,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList2'		=>	array( 'pos' => 27,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList3'		=>	array( 'pos' => 29,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList4'		=>	array( 'pos' => 31,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList5'		=>	array( 'pos' => 33,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList6'		=>	array( 'pos' => 35,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList7'		=>	array( 'pos' => 37,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList8'		=>	array( 'pos' => 39,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),*/

	'TR:Config:Bar:Display:Unit'		=>	array( 'pos' => 41.1,	'len' => 2,	'w'=>false,	'fn'=>'none',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Temp:Display:Unit'		=>	array( 'pos' => 41.3,	'len' => 2,	'w'=>false,	'fn'=>'none',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Geo:Elevation:Unit'		=>	array( 'pos' => 41.5,	'len' => 1,	'w'=>false,	'fn'=>'none',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Rain:Display:Unit'		=>	array( 'pos' => 41.6,	'len' => 1,	'w'=>false,	'fn'=>'none',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Wind:Display:Unit'		=>	array( 'pos' => 41.7,	'len' => 2,	'w'=>false,	'fn'=>'none',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:UnitBitsComp'				=>	array( 'pos' => 42,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TR:Config:Time:Mode:AM/PM'			=>	array( 'pos' => 43.1,	'len' => 1,	'w'=>false,	'fn'=>'none',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Time:Mode:isAM'			=>	array( 'pos' => 43.2,	'len' => 1,	'w'=>false,	'fn'=>'none',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Time:Format:Day/Month'	=>	array( 'pos' => 43.3,	'len' => 1,	'w'=>false,	'fn'=>'none',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Wind:Cup:Large'			=>	array( 'pos' => 43.4,	'len' => 1,	'w'=>false,	'fn'=>'none',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Rain:Collector:Size'		=>	array( 'pos' => 43.5,	'len' => 2,	'w'=>false,	'fn'=>'none',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Geo:Latitude:directionNorth'=>	array( 'pos' => 43.7,	'len' => 1,	'w'=>false,	'fn'=>'none',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Geo:Longitude:directionEast'=>	array( 'pos' => 43.8,	'len' => 1,	'w'=>false,	'fn'=>'none',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TR:Config:Rain::SeasonStart'		=>	array( 'pos' => 44,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'Month'	),
	'TR:Config:Time:Archive:Period'		=>	array( 'pos' => 45,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'min'	),

	'TR:Sensor:Temp:In:Offset'		=>	array( 'pos' => 50,	'len' => 1,	'w'=>false,	'fn'=>'sSht_01',	'SI'=>'F2kelvin',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:TempInComp'			=>	array( 'pos' => 51,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Temp:Out:Offset'		=>	array( 'pos' => 52,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#2:Offset'		=>	array( 'pos' => 53,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#3:Offset'		=>	array( 'pos' => 54,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#4:Offset'		=>	array( 'pos' => 55,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#5:Offset'		=>	array( 'pos' => 56,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#6:Offset'		=>	array( 'pos' => 57,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#7:Offset'		=>	array( 'pos' => 58,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#8:Offset'		=>	array( 'pos' => 59,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'TR:Sensor:Temp:Soil#1:Offset'		=>	array( 'pos' => 60,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Soil#2:Offset'		=>	array( 'pos' => 61,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Soil#3:Offset'		=>	array( 'pos' => 62,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Soil#4:Offset'		=>	array( 'pos' => 63,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'TR:Sensor:Temp:Leaf#1:Offset'		=>	array( 'pos' => 64,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Leaf#2:Offset'		=>	array( 'pos' => 65,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Leaf#3:Offset'		=>	array( 'pos' => 66,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Leaf#4:Offset'		=>	array( 'pos' => 67,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'F2kelvin',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'TR:Sensor:Hum:In:Offset'		=>	array( 'pos' => 68,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:Out:Offset'		=>	array( 'pos' => 69,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#2:Offset'		=>	array( 'pos' => 70,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#3:Offset'		=>	array( 'pos' => 71,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#4:Offset'		=>	array( 'pos' => 72,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#5:Offset'		=>	array( 'pos' => 73,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#6:Offset'		=>	array( 'pos' => 74,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#7:Offset'		=>	array( 'pos' => 75,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#8:Offset'		=>	array( 'pos' => 76,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'TR:Sensor:Wind:Direction:Offset'	=>	array( 'pos' => 77,	'len' => 2,	'w'=>false,	'fn'=>'sSht_01',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:DefaultBarGraph'		=>	array( 'pos' => 79,	'len' => 1,	'w'=>false,	'fn'=>'sSht_01',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:DefaultRainGraph'	=>	array( 'pos' => 80,	'len' => 1,	'w'=>false,	'fn'=>'sSht_01',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:DefaultSpeedGraph'	=>	array( 'pos' => 81,	'len' => 1,	'w'=>false,	'fn'=>'sSht_01',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm start ***********					///
	'TR:Sensor:Bar::3hTrend.RiseAlarm'	=>	array( 'pos' => 82,	'len' => 1,	'w'=>false,	'fn'=>'_0001',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Bar::3hTrend.FallAlarm'	=>	array( 'pos' => 83,	'len' => 1,	'w'=>false,	'fn'=>'_0001',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Time:Clock:Alarm'		=>	array( 'pos' => 84,	'len' => 2,	'w'=>false,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:TimeComp'		=>	array( 'pos' => 86,	'len' => 2,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TR:Sensor:Temp:In:LowAlarm'		=>	array( 'pos' => 88,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Temp:In:HighAlarm'		=>	array( 'pos' => 89,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TR:Sensor:Temp:Out:LowAlarm'		=>	array( 'pos' => 90,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Temp:Out:HighAlarm'		=>	array( 'pos' => 91,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TR:Sensor:Temp:#2:LowAlarm'		=>	array( 'pos' => 92,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#3:LowAlarm'		=>	array( 'pos' => 93,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#4:LowAlarm'		=>	array( 'pos' => 94,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#5:LowAlarm'		=>	array( 'pos' => 95,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#6:LowAlarm'		=>	array( 'pos' => 96,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#7:LowAlarm'		=>	array( 'pos' => 97,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#8:LowAlarm'		=>	array( 'pos' => 98,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'TR:Sensor:Temp:Soil#1:LowAlarm'	=>	array( 'pos' => 99,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Soil#2:LowAlarm'	=>	array( 'pos' => 100,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Soil#3:LowAlarm'	=>	array( 'pos' => 101,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Soil#4:LowAlarm'	=>	array( 'pos' => 102,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'TR:Sensor:Temp:Leaf#1:LowAlarm'	=>	array( 'pos' => 103,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Leaf#2:LowAlarm'	=>	array( 'pos' => 104,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Leaf#3:LowAlarm'	=>	array( 'pos' => 105,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Leaf#4:LowAlarm'	=>	array( 'pos' => 106,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),


	'TR:Sensor:Temp:#2:HighAlarm'		=>	array( 'pos' => 107,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#3:HighAlarm'		=>	array( 'pos' => 108,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#4:HighAlarm'		=>	array( 'pos' => 109,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#5:HighAlarm'		=>	array( 'pos' => 110,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#6:HighAlarm'		=>	array( 'pos' => 111,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#7:HighAlarm'		=>	array( 'pos' => 112,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:#8:HighAlarm'		=>	array( 'pos' => 113,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'TR:Sensor:Temp:Soil#1:HighAlarm'	=>	array( 'pos' => 114,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Soil#2:HighAlarm'	=>	array( 'pos' => 115,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Soil#3:HighAlarm'	=>	array( 'pos' => 116,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Soil#4:HighAlarm'	=>	array( 'pos' => 117,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'TR:Sensor:Temp:Leaf#1:HighAlarm'	=>	array( 'pos' => 118,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Leaf#2:HighAlarm'	=>	array( 'pos' => 119,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Leaf#3:HighAlarm'	=>	array( 'pos' => 120,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'TR:Sensor:Temp:Leaf#4:HighAlarm'	=>	array( 'pos' => 121,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'TR:Sensor:Hum:In:LowAlarm'			=>	array( 'pos' => 122,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:In:HighAlarm'		=>	array( 'pos' => 123,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'TR:Sensor:Hum:Out:LowAlarm'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#2:LowAlarm'		=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#3:LowAlarm'		=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#4:LowAlarm'		=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#5:LowAlarm'		=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#6:LowAlarm'		=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#7:LowAlarm'		=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#8:LowAlarm'		=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'TR:Sensor:Hum:Out:LowAlarm'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#2:LowAlarm'		=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#3:LowAlarm'		=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#4:LowAlarm'		=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#5:LowAlarm'		=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#6:LowAlarm'		=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#7:LowAlarm'		=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Hum:#8:LowAlarm'		=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'TR:Sensor:Temp:DewPt:LowAlarm'		=>	array( 'pos' => 140,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp120',	'SI'=>'F2kelvin',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Temp:DewPt:HighAlarm'	=>	array( 'pos' => 141,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp120',	'SI'=>'F2kelvin',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Temp:Chill:LowAlarm'		=>	array( 'pos' => 142,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp120',	'SI'=>'F2kelvin',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Temp:Heat:HighAlarm'		=>	array( 'pos' => 143,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Temp:Thsw:HighAlarm'		=>	array( 'pos' => 144,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Wind::CurrentSpeed.HighAlarm'=>	array( 'pos' => 145,	'len' => 1,	'w'=>false,	'fn'=>'hexToDec',	'SI'=>'mBySec',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:Wind::10minSpeed.HighAlarm'	=>	array( 'pos' => 146,	'len' => 1,	'w'=>false,	'fn'=>'hexToDec',	'SI'=>'mBySec',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:UV::HighAlarm'			=>	array( 'pos' => 147,	'len' => 1,	'w'=>false,	'fn'=>'UV',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm Out Soil&Leaf ***********					///
	'TR:Sensor:SoilMoisture:Soil#1:LowAlarm'	=>	array( 'pos' => 149,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:SoilMoisture:Soil#2:LowAlarm'	=>	array( 'pos' => 150,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:SoilMoisture:Soil#3:LowAlarm'	=>	array( 'pos' => 151,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:SoilMoisture:Soil#4:LowAlarm'	=>	array( 'pos' => 152,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TR:Sensor:SoilMoisture:Soil#1:HighAlarm'	=>	array( 'pos' => 153,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:SoilMoisture:Soil#2:HighAlarm'	=>	array( 'pos' => 154,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:SoilMoisture:Soil#3:HighAlarm'	=>	array( 'pos' => 155,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:SoilMoisture:Soil#4:HighAlarm'	=>	array( 'pos' => 156,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TR:Sensor:LeafWetnesses:Leaf#1:LowAlarm'	=>	array( 'pos' => 157,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:LeafWetnesses:Leaf#2:LowAlarm'	=>	array( 'pos' => 158,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:LeafWetnesses:Leaf#3:LowAlarm'	=>	array( 'pos' => 159,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:LeafWetnesses:Leaf#4:LowAlarm'	=>	array( 'pos' => 160,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),

	'TR:Sensor:LeafWetnesses:Leaf#1:HighAlarm'	=>	array( 'pos' => 161,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:LeafWetnesses:Leaf#2:HighAlarm'	=>	array( 'pos' => 162,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:LeafWetnesses:Leaf#3:HighAlarm'	=>	array( 'pos' => 163,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'TR:Sensor:LeafWetnesses:Leaf#4:HighAlarm'	=>	array( 'pos' => 164,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),


	'TR:Sensor:Solar::HighAlarm'	=>	array( 'pos' => 165,	'len' => 2,	'w'=>false,	'fn'=>'s2sSht',		'SI'=>NULL,	'min'=>0,	'max'=>2000,	'err'=>0xffff,	'unit'=> ''	),
	'TR:Sensor:Rain::RateAlarm'		=>	array( 'pos' => 167,	'len' => 2,	'w'=>false,	'fn'=>'s2uSht',		'SI'=>'RainSample2mm',	'min'=>0,	'max'=>65,	'err'=>0xffff,	'unit'=> ''	),
	'TR:Sensor:Rain::15minAlarm'	=>	array( 'pos' => 169,	'len' => 2,	'w'=>false,	'fn'=>'s2uSht',		'SI'=>'RainSample2mm',	'min'=>0,	'max'=>65,	'err'=>0xffff,	'unit'=> ''	),
	'TR:Sensor:Rain::24hAlarm'		=>	array( 'pos' => 171,	'len' => 2,	'w'=>false,	'fn'=>'s2uSht',		'SI'=>'RainSample2mm',	'min'=>0,	'max'=>650,	'err'=>0xffff,	'unit'=> ''	),
	'TR:Sensor:Rain::StormAlarm'	=>	array( 'pos' => 173,	'len' => 2,	'w'=>false,	'fn'=>'s2uSht',		'SI'=>'RainSample2mm',	'min'=>0,	'max'=>650,	'err'=>0xffff,	'unit'=> ''	),
	'TR:Sensor:Et::DayAlarm'		=>	array( 'pos' => 175,	'len' => 2,	'w'=>false,	'fn'=>'ET1000',		'SI'=>NULL,	'min'=>0,	'max'=>0xfffe,	'err'=>0xffff,	'unit'=> ''	),
// 	'Other:GraphPointer'		=>	array( 'pos' => 177,	'len' => 8,	'w'=>false,	'fn'=>'sSht_01',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:GraphData'			=>	array( 'pos' => 185,	'len' => 3898,	'w'=>false,	'fn'=>'sSht_01',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TR:Config:Temp:Log:Average'	=>	array( 'pos' => 4092,	'len' => 1,	'w'=>true,	'fn'=>'Bool',		'SI'=>NULL,	'min'=>0,	'max'=>1,	'err'=>255,	'unit'=> ''	),
	);
//var_export(array_keys($EEPROM));
?>