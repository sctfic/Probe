<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 28, 29)
/// 3. DMP and DMPAFT data format
/// There are two different archived data formats. Rev "A" firmware, dated before April 24, 2002
/// uses the old format. Rev "B" firmware dated on or after April 24, 2002 uses the new format. The
/// fields up to ET are identical for both formats. The only differences are in the Soil, Leaf, Extra
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

	$this->DumpAfter = array (
	'TA:Arch:none:Time:UTC'		=>	array( 'pos' => 0,	'len' => 4,	'fn'=>'DMPAFT_GetVP2Date',	'SI'=>NULL,	'min'=>NULL,	'max'=>NULL,	'err'=>0xFFFF,	'unit'=> 'Date'	),
//	'TA:Arch:none:Time'			=>	array( 'pos' => 2,	'len' => 2,	'fn'=>'Raw2Time',		'SI'=>'UTC',	'min'=>NULL,	'max'=>NULL,	'err'=>0xFFFF,	'unit'=> 'Time'	),

	'TA:Arch:Temp:Out:Average'		=>	array( 'pos' => 4,	'len' => 2,	'fn'=>'sSht_01',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>180,	'err'=>32767,	'unit'=> '°F'	),
	'TA:Arch:Temp:Out:High'			=>	array( 'pos' => 6,	'len' => 2,	'fn'=>'sSht_01',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>180,	'err'=>-32768,	'unit'=> '°F'	),
	'TA:Arch:Temp:Out:Low'			=>	array( 'pos' => 8,	'len' => 2,	'fn'=>'sSht_01',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>180,	'err'=>32767,	'unit'=> '°F'	),

	'TA:Arch:Various:RainFall:Sample'		=>	array( 'pos' => 10,	'len' => 2,	'fn'=>'s2uSht',		'SI'=>'RainSample2mm',	'min'=>0,	'max'=>600,	'err'=>32767,	'unit'=> 'clic'	),
	'TA:Arch:Various:RainRate:HighSample'	=>	array( 'pos' => 12,	'len' => 2,	'fn'=>'s2uSht',		'SI'=>'RainSample2mm',	'min'=>0,	'max'=>900,	'err'=>32767,	'unit'=> 'clic/h'),
	'TA:Arch:Various:Bar:Current'		=>	array( 'pos' => 14,	'len' => 2,	'fn'=>'_0001',		'SI'=>'inHg2Pa',	'min'=>25,	'max'=>33,	'err'=>0,	'unit'=> 'in.Hg'),
	'TA:Arch:Various:Solar:Radiation'	=>	array( 'pos' => 16,	'len' => 2,	'fn'=>'s2sSht',		'SI'=>NULL,		'min'=>0,	'max'=>1409,	'err'=>32767,	'unit'=> 'W/m²'	),
//	'TA:Arch:Various:Wind:Sample'		=>	array( 'pos' => 18,	'len' => 2,	'fn'=>'s2uSht',		'SI'=>NULL,		'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> '-'	),

	'TA:Arch:Temp:In:Average'		=>	array( 'pos' => 20,	'len' => 2,	'fn'=>'sSht_01',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>164,	'err'=>32767,	'unit'=> '°F'	),

	'TA:Arch:Hum:In:Current'		=>	array( 'pos' => 22,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'TA:Arch:Hum:Out:Current'		=>	array( 'pos' => 23,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),

	'TA:Arch:Various:Wind:SpeedAvg'	=>	array( 'pos' => 24,	'len' => 1,	'fn'=>'hexToDec',	'SI'=>'MPH2SI',		'min'=>0,	'max'=>200,	'err'=>255,	'unit'=> 'mph'	),
	'TA:Arch:Various:Wind:HighSpeed'	=>	array( 'pos' => 25,	'len' => 1,	'fn'=>'hexToDec',	'SI'=>'MPH2SI',		'min'=>0,	'max'=>250,	'err'=>255,	'unit'=> 'mph'	),
	'TA:Arch:Various:Wind:HighSpeedDirection'=>	array( 'pos' => 26,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>16,	'err'=>255,	'unit'=> '°'	),
	'TA:Arch:Various:Wind:DominantDirection'=>	array( 'pos' => 27,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>16,	'err'=>255,	'unit'=> '°'	),

	'TA:Arch:Various:UV:IndexAvg'		=>	array( 'pos' => 28,	'len' => 1,	'fn'=>'UV',		'SI'=>NULL,		'min'=>0,	'max'=>17,	'err'=>255,	'unit'=> '-'	),
	'TA:Arch:Various:ET:Hour'		=>	array( 'pos' => 29,	'len' => 1,	'fn'=>'ET_h',		'SI'=>NULL,		'min'=>0,	'max'=>2,	'err'=>255,	'unit'=> 'mm'	),
	'TA:Arch:Various:Solar:HighRadiation'	=>	array( 'pos' => 30,	'len' => 2,	'fn'=>'s2sSht',		'SI'=>NULL,		'min'=>0,	'max'=>1409,	'err'=>32767,	'unit'=> 'W/m²'	),
	'TA:Arch:Various:UV:HighIndex'		=>	array( 'pos' => 32,	'len' => 1,	'fn'=>'UV',		'SI'=>NULL,		'min'=>0,	'max'=>25,	'err'=>255,	'unit'=> 'W/m²'	),
	'TA:Arch:Various::ForecastRule'	=>	array( 'pos' => 33,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>0xFF,	'err'=>193,	'unit'=> '-'	),

	'TA:Arch:Temp:Leaf#1:Current'		=>	array( 'pos' => 34,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'TA:Arch:Temp:Leaf#2:Current'		=>	array( 'pos' => 35,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),

	'TA:Arch:LeafWetnesses:Leaf#1:Current'	=>	array( 'pos' => 36,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> '-'	),
	'TA:Arch:LeafWetnesses:Leaf#2:Current'	=>	array( 'pos' => 37,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> '-'	),

	'TA:Arch:Temp:Soil#1:Current'		=>	array( 'pos' => 38,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'TA:Arch:Temp:Soil#2:Current'		=>	array( 'pos' => 39,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'TA:Arch:Temp:Soil#3:Current'		=>	array( 'pos' => 40,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'TA:Arch:Temp:Soil#4:Current'		=>	array( 'pos' => 41,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),

// 	'Other:DownloadRecordType'		=>	array( 'pos' => 42,	'len' => 1,	'fn'=>'SpRev',		'SI'=>NULL,		'min'=>0,	'max'=>0xFF,	'err'=>null,	'unit'=> 'Rev'	),
	'TA:Arch:Hum:#2:Current'		=>	array( 'pos' => 43,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'TA:Arch:Hum:#3:Current'		=>	array( 'pos' => 44,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),

	'TA:Arch:Temp:#2:Current'		=>	array( 'pos' => 45,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'TA:Arch:Temp:#3:Current'		=>	array( 'pos' => 46,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'TA:Arch:Temp:#4:Current'		=>	array( 'pos' => 47,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'F2kelvin',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),

	'TA:Arch:SoilMoisture:Soil#1:Current'	=>	array( 'pos' => 48,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> 'CentiBar'	),
	'TA:Arch:SoilMoisture:Soil#2:Current'	=>	array( 'pos' => 49,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> 'CentiBar'	),
	'TA:Arch:SoilMoisture:Soil#3:Current'	=>	array( 'pos' => 50,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> 'CentiBar'	),
	'TA:Arch:SoilMoisture:Soil#4:Current'	=>	array( 'pos' => 51,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,		'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> 'CentiBar'	),
	);

?>
