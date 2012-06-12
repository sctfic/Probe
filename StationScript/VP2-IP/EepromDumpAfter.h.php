<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 28, 29)
/// 3. DMP and DMPAFT data format
/// There are two different archived data formats. Rev "A" firmware, dated before April 24, 2002
/// uses the old format. Rev "B" firmware dated on or after April 24, 2002 uses the new format. The
/// fields up to ET are identical for both formats. The only differences are in the Soil, Leaf, Extra
// ##############################################################################################
/**
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
**/

	$this->DumpAfter = array (
	'Archive:UTC'			=>	array( 'pos' => 0,	'len' => 4,	'fn'=>'Tools::DMPAFT_GetVP2Date',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFFFF,	'err'=>0xFFFF,	'unit'=> 'Date'	),
//	'Archive.none:Time'			=>	array( 'pos' => 2,	'len' => 2,	'fn'=>'Tools::Raw2Time',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFFFF,	'err'=>0xFFFF,	'unit'=> 'Time'	),

	'Archive.Temp:Avg_Out'			=>	array( 'pos' => 4,	'len' => 2,	'fn'=>'Tools::Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>32767,	'unit'=> '°F'	),
	'Archive.Temp:High_Out'			=>	array( 'pos' => 6,	'len' => 2,	'fn'=>'Tools::Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>-32768,	'unit'=> '°F'	),
	'Archive.Temp:Low_Out'			=>	array( 'pos' => 8,	'len' => 2,	'fn'=>'Tools::Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>-32767,	'unit'=> '°F'	),

	'Archive.Rain:Sample_Rainfall'	=>	array( 'pos' => 10,	'len' => 2,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'clic'	),
	'Archive.Rain:Sample_High_Rain_Rate'	=>	array( 'pos' => 12,	'len' => 2,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'clic/h'),
	'Archive.Common:Pressure'		=>	array( 'pos' => 14,	'len' => 2,	'fn'=>'Tools::Pressure',	'SI'=>'barSI',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'in.Hg'),
	'Archive.Common:Solar_Radiation'	=>	array( 'pos' => 16,	'len' => 2,	'fn'=>'Tools::Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>3000,	'err'=>32767,	'unit'=> 'W/m²'	),
	'Archive.Common:Sample_Wind'		=>	array( 'pos' => 18,	'len' => 2,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> '-'	),

	'Archive.Temp:Inside'			=>	array( 'pos' => 20,	'len' => 2,	'fn'=>'Tools::Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>32767,	'unit'=> '°F'	),

	'Archive.Hum:Inside'			=>	array( 'pos' => 22,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'Archive.Hum:Outside'			=>	array( 'pos' => 23,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),

	'Archive.Common:Avg_Wind_Speed'		=>	array( 'pos' => 24,	'len' => 1,	'fn'=>'Tools::Speed',		'SI'=>'mBySec',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'mph'	),
	'Archive.Common:High_Wind_Speed'	=>	array( 'pos' => 25,	'len' => 1,	'fn'=>'Tools::Speed',		'SI'=>'mBySec',	'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> 'mph'	),
	'Archive.Common:Direction_High_Wind_Speed'=>	array( 'pos' => 26,	'len' => 1,	'fn'=>'Tools::Angle16',	'SI'=>NULL,	'min'=>0,	'max'=>16,	'err'=>255,	'unit'=> '°'	),
	'Archive.Common:Dominant_Wind_Direction'=>	array( 'pos' => 27,	'len' => 1,	'fn'=>'Tools::Angle16',	'SI'=>NULL,	'min'=>0,	'max'=>16,	'err'=>255,	'unit'=> '°'	),

	'Archive.Common:Avg_UV_Index'		=>	array( 'pos' => 28,	'len' => 1,	'fn'=>'Tools::UV',		'SI'=>NULL,	'min'=>0,	'max'=>25,	'err'=>255,	'unit'=> '-'	),
	'Archive.ET:Last_Hour'		=>	array( 'pos' => 29,	'len' => 1,	'fn'=>'Tools::ET_h',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> 'mm'	),
	'Archive.Common:High_Solar_Rad'		=>	array( 'pos' => 30,	'len' => 2,	'fn'=>'Tools::Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>2000,	'err'=>0,	'unit'=> 'W/m²'	),
	'Archive.Common:High_UV_Index'		=>	array( 'pos' => 32,	'len' => 1,	'fn'=>'Tools::UV',		'SI'=>NULL,	'min'=>0,	'max'=>25,	'err'=>255,	'unit'=> 'W/m²'	),
	'Archive.Common:Forecast_Rule'		=>	array( 'pos' => 33,	'len' => 1,	'fn'=>'Tools::Forecast',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>193,	'unit'=> '-'	),

	'Archive.Temp:Leaf#1'			=>	array( 'pos' => 34,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'Archive.Temp:Leaf#2'			=>	array( 'pos' => 35,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),

	'Archive.Wetnesses:Leaf#1'	=>	array( 'pos' => 36,	'len' => 1,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> '-'	),
	'Archive.Wetnesses:Leaf#2'	=>	array( 'pos' => 37,	'len' => 1,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> '-'	),

	'Archive.Temp:Soil#1'		=>	array( 'pos' => 38,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Archive.Temp:Soil#2'		=>	array( 'pos' => 39,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Archive.Temp:Soil#3'		=>	array( 'pos' => 40,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Archive.Temp:Soil#4'		=>	array( 'pos' => 41,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),

// 	'Other:DownloadRecordType'	=>	array( 'pos' => 42,	'len' => 1,	'fn'=>'Tools::SpRev',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>null,	'unit'=> 'Rev'	),
	'Archive.Hum:#2'		=>	array( 'pos' => 43,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'Archive.Hum:#3'		=>	array( 'pos' => 44,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),

	'Archive.Temp:#2'		=>	array( 'pos' => 45,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Archive.Temp:#3'		=>	array( 'pos' => 46,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Archive.Temp:#4'		=>	array( 'pos' => 47,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),

	'Archive.Moistures:Soil#1'	=>	array( 'pos' => 48,	'len' => 1,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'Archive.Moistures:Soil#2'	=>	array( 'pos' => 49,	'len' => 1,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'Archive.Moistures:Soil#3'	=>	array( 'pos' => 50,	'len' => 1,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'Archive.Moistures:Soil#4'	=>	array( 'pos' => 51,	'len' => 1,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	);

?>