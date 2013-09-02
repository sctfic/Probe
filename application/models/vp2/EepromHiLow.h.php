<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 24, 25,26)
/// 2. HILOW data format
/// The "HILOWS" command sends a 436 byte data packet and a 2 byte CRC value. The data packet is
/// broken up into sections of related data values.
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
* @param pos => possition of the raw data for this sensor	in the VP2 returned RAW string
* @param len => lenth of the raw string result for this sensor
* @param fn => how to convert raw data to number value
* @param SI => how to convert native UNIT to SI unit (NULL if is already in SI unit)
* @param min => min value on the earth *in the native unit
* @param max => max value on the earth *in the native unit
* @param err => returned value if error on this sensor
* @param unit => native unit ===
**/
	$this->HiLows = array (
'HLW:Current:Air:Pressure:.Bar:Daily:Low'		=> array( 'pos' => 0,'len' => 2, 'fn'=>'_0001','SI'=>'inHg2hPa', 'min'=>25,'max'=>33, 'err'=>0,'unit'=> 'in.Hg'),
'HLW:Current:Air:Pressure:.Bar:Daily:High'		=> array( 'pos' => 2,'len' => 2, 'fn'=>'_0001','SI'=>'inHg2hPa', 'min'=>25,'max'=>33, 'err'=>0,'unit'=> 'in.Hg'),
'HLW:Current:Air:Pressure:.Bar:Month:Low'		=> array( 'pos' => 4,'len' => 2, 'fn'=>'_0001','SI'=>'inHg2hPa', 'min'=>25,'max'=>33, 'err'=>0,'unit'=> 'in.Hg'),
'HLW:Current:Air:Pressure:.Bar:Month:High'		=> array( 'pos' => 6,'len' => 2, 'fn'=>'_0001','SI'=>'inHg2hPa', 'min'=>25,'max'=>33, 'err'=>0,'unit'=> 'in.Hg'),
'HLW:Current:Air:Pressure:.Bar:Year:Low'		=> array( 'pos' => 8,'len' => 2, 'fn'=>'_0001','SI'=>'inHg2hPa', 'min'=>25,'max'=>33, 'err'=>0,'unit'=> 'in.Hg'),
'HLW:Current:Air:Pressure:.Bar:Year:High'		=> array( 'pos' => 10,'len' => 2, 'fn'=>'_0001','SI'=>'inHg2hPa', 'min'=>25,'max'=>33, 'err'=>0,'unit'=> 'in.Hg'),
'HLW:Current:Air:Pressure:.Bar:TimeDaily:Low'		=> array( 'pos' => 12,'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Pressure:.Bar:TimeDaily:High'		=> array( 'pos' => 14,'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),

'HLW:Current:Air:Wind:.Speed:Daily:High'		=> array( 'pos' => 16,'len' => 1, 'fn'=>'hexToDec', 'SI'=>'MPH2SI','min'=>0,'max'=>160, 'err'=>0,'unit'=> 'mph'),
'HLW:Current:Air:Wind:.Speed:Daily:TimeHigh'		=> array( 'pos' => 17,'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Wind:.Speed:Month:High'		=> array( 'pos' => 19,'len' => 1, 'fn'=>'hexToDec', 'SI'=>'MPH2SI','min'=>0,'max'=>160, 'err'=>0,'unit'=> 'mph'),
'HLW:Current:Air:Wind:.Speed:Year:High'		=> array( 'pos' => 20,'len' => 1, 'fn'=>'hexToDec', 'SI'=>'MPH2SI','min'=>0,'max'=>160, 'err'=>0,'unit'=> 'mph'),

'HLW:Current:Air:Temp:In#0:Daily:High'		=> array( 'pos' => 21,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:In#0:Daily:Low'		=> array( 'pos' => 23,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:In#0:TimeDaily:High'		=> array( 'pos' => 25,'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:In#0:TimeDaily:Low'		=> array( 'pos' => 27,'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:In#0:Month:Low'		=> array( 'pos' => 29,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:In#0:Month:High'		=> array( 'pos' => 31,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:In#0:Year:Low'		=> array( 'pos' => 33,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:In#0:Year:High'		=> array( 'pos' => 35,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Air:Hum:In#0:Daily:High'		=> array( 'pos' => 37,'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:In#0:Daily:Low'		=> array( 'pos' => 38,'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:In#0:TimeDaily:High'		=> array( 'pos' => 39,'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:In#0:TimeDaily:Low'		=> array( 'pos' => 41,'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:In#0:Month:High'		=> array( 'pos' => 43,'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:In#0:Month:Low'		=> array( 'pos' => 44,'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:In#0:Year:High'		=> array( 'pos' => 45,'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:In#0:Year:Low'		=> array( 'pos' => 46,'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Air:Temp:Out#1:Daily:Low'		=> array( 'pos' => 47,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#1:Daily:High'		=> array( 'pos' => 49,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#1:TimeDaily:Low'		=> array( 'pos' => 51,'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:Out#1:TimeDaily:High'		=> array( 'pos' => 53,'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:Out#1:Month:High'		=> array( 'pos' => 55,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#1:Month:Low'		=> array( 'pos' => 57,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#1:Yeah:High'		=> array( 'pos' => 59,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#1:Year:Low'		=> array( 'pos' => 61,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Virtual:Temp:DewPoint:Daily:Low'		=> array( 'pos' => 63,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Virtual:Temp:DewPoint:Dayly:High'		=> array( 'pos' => 65,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Virtual:Temp:DewPoint:TimeDaily:Low'		=> array( 'pos' => 67,'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Virtual:Temp:DewPoint:TimeDaily:High'		=> array( 'pos' => 69,'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Virtual:Temp:DewPoint:Month:High'		=> array( 'pos' => 71,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Virtual:Temp:DewPoint:Month:Low'		=> array( 'pos' => 73,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Virtual:Temp:DewPoint:Year:High'		=> array( 'pos' => 75,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Virtual:Temp:DewPoint:Year:Low'		=> array( 'pos' => 77,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Virtual:Temp:WindChill:Daily:Low'		=> array( 'pos' => 79,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Virtual:Temp:WindChill:TimeDaily:Low'		=> array( 'pos' => 81,'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Virtual:Temp:WindChill:Month:Low'		=> array( 'pos' => 83,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Virtual:Temp:WindChill:Year:Low'		=> array( 'pos' => 85,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Virtual:Temp:HeatIndex:Daily:High'		=> array( 'pos' => 87,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Virtual:Temp:HeatIndex:TimeDaily:High'		=> array( 'pos' => 89,'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Virtual:Temp:HeatIndex:Month:High'		=> array( 'pos' => 91,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Virtual:Temp:HeatIndex:Year:High'		=> array( 'pos' => 93,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Virtual:Temp:THSW:Daily:High'		=> array( 'pos' => 95,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Virtual:Temp:THSW:TimeDaily:High'		=> array( 'pos' => 97,'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Virtual:Temp:THSW:Month:High'		=> array( 'pos' => 99,'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Virtual:Temp:THSW:Year:High'		=> array( 'pos' => 101, 'len' => 2, 'fn'=>'sSht_01', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Air:Solar:Radiation:Daily:High'		=> array( 'pos' => 103, 'len' => 2, 'fn'=>'s2sSht','SI'=>NULL,'min'=>0,'max'=>1810,'err'=>255,'unit'=> 'W/m²'),
'HLW:Current:Air:Solar:Radiation:TimeDaily:High'		=> array( 'pos' => 105, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Solar:Radiation:Month:High'		=> array( 'pos' => 107, 'len' => 2, 'fn'=>'s2sSht','SI'=>NULL,'min'=>0,'max'=>1810,'err'=>255,'unit'=> 'W/m²'),
'HLW:Current:Air:Solar:Radiation:Year:High'		=> array( 'pos' => 109, 'len' => 2, 'fn'=>'s2sSht','SI'=>NULL,'min'=>0,'max'=>1810,'err'=>255,'unit'=> 'W/m²'),

'HLW:Current:Air:Solar:UV:Daily:High'		=> array( 'pos' => 111, 'len' => 1, 'fn'=>'UV', 'SI'=>NULL,'min'=>0,'max'=>17, 'err'=>255,'unit'=> '-' ),
'HLW:Current:Air:Solar:UV:TimeDaily:High'		=> array( 'pos' => 112, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Solar:UV:Month:High'		=> array( 'pos' => 114, 'len' => 1, 'fn'=>'UV', 'SI'=>NULL,'min'=>0,'max'=>17, 'err'=>255,'unit'=> '-' ),
'HLW:Current:Air:Solar:UV:Year:High'		=> array( 'pos' => 115, 'len' => 1, 'fn'=>'UV', 'SI'=>NULL,'min'=>0,'max'=>17, 'err'=>255,'unit'=> '-' ),

'HLW:Current:Air:Rain:FlowRate:Daily:High'		=> array( 'pos' => 116, 'len' => 2, 'fn'=>'s2uSht','SI'=>'RainSample2mm', 'min'=>0,'max'=>900, 'err'=>0,'unit'=> 'clic/h'),
'HLW:Current:Air:Rain:FlowRate:TimeDaily:High'		=> array( 'pos' => 118, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Rain:FlowRate:Hour:High'		=> array( 'pos' => 120, 'len' => 2, 'fn'=>'s2uSht','SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>0xFFFF, 'unit'=> 'Date'),
'HLW:Current:Air:Rain:FlowRate:Month:High'		=> array( 'pos' => 122, 'len' => 2, 'fn'=>'s2uSht','SI'=>'RainSample2mm', 'min'=>0,'max'=>900, 'err'=>0,'unit'=> 'clic/h'),
'HLW:Current:Air:Rain:FlowRate:Year:High'		=> array( 'pos' => 124, 'len' => 2, 'fn'=>'s2uSht','SI'=>'RainSample2mm', 'min'=>0,'max'=>900, 'err'=>0,'unit'=> 'clic/h'),

	///*********** extra temperature *********** ///
'HLW:Current:Air:Temp:Out#2:Daily:Low'		=> array( 'pos' => 126, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#3:Daily:Low'		=> array( 'pos' => 127, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#4:Daily:Low'		=> array( 'pos' => 128, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#5:Daily:Low'		=> array( 'pos' => 129, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#6:Daily:Low'		=> array( 'pos' => 130, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#7:Daily:Low'		=> array( 'pos' => 131, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#8:Daily:Low'		=> array( 'pos' => 132, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Leaf:Temp:Leaf#1:Daily:Low'		=> array( 'pos' => 133, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#2:Daily:Low'		=> array( 'pos' => 134, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#3:Daily:Low'		=> array( 'pos' => 135, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#4:Daily:Low'		=> array( 'pos' => 136, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Soil:Temp:Soil#1:Daily:Low'		=> array( 'pos' => 137, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#2:Daily:Low'		=> array( 'pos' => 138, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#3:Daily:Low'		=> array( 'pos' => 139, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#4:Daily:Low'		=> array( 'pos' => 140, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),


'HLW:Current:Air:Temp:Out#2:Daily:High'		=> array( 'pos' => 141, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#3:Daily:High'		=> array( 'pos' => 142, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#4:Daily:High'		=> array( 'pos' => 143, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#5:Daily:High'		=> array( 'pos' => 144, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#6:Daily:High'		=> array( 'pos' => 145, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#7:Daily:High'		=> array( 'pos' => 146, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#8:Daily:High'		=> array( 'pos' => 147, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Leaf:Temp:Leaf#1:Daily:High'		=> array( 'pos' => 148, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#2:Daily:High'		=> array( 'pos' => 149, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#3:Daily:High'		=> array( 'pos' => 150, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#4:Daily:High'		=> array( 'pos' => 151, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Soil:Temp:Soil#1:Daily:High'		=> array( 'pos' => 152, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#2:Daily:High'		=> array( 'pos' => 153, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#3:Daily:High'		=> array( 'pos' => 154, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#4:Daily:High'		=> array( 'pos' => 155, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),


'HLW:Current:Air:Temp:Out#2:TimeDaily:Low'		=> array( 'pos' => 156, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:Out#3:TimeDaily:Low'		=> array( 'pos' => 158, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:Out#4:TimeDaily:Low'		=> array( 'pos' => 160, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:Out#5:TimeDaily:Low'		=> array( 'pos' => 162, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:Out#6:TimeDaily:Low'		=> array( 'pos' => 164, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:Out#7:TimeDaily:Low'		=> array( 'pos' => 166, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:Out#8:TimeDaily:Low'		=> array( 'pos' => 168, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),

'HLW:Current:Leaf:Temp:Leaf#1:TimeDaily:Low'		=> array( 'pos' => 170, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Leaf:Temp:Leaf#2:TimeDaily:Low'		=> array( 'pos' => 172, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Leaf:Temp:Leaf#3:TimeDaily:Low'		=> array( 'pos' => 174, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Leaf:Temp:Leaf#4:TimeDaily:Low'		=> array( 'pos' => 176, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),

'HLW:Current:Soil:Temp:Soil#1:TimeDaily:Low'		=> array( 'pos' => 178, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Soil:Temp:Soil#2:TimeDaily:Low'		=> array( 'pos' => 180, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Soil:Temp:Soil#3:TimeDaily:Low'		=> array( 'pos' => 182, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Soil:Temp:Soil#4:TimeDaily:Low'		=> array( 'pos' => 184, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),


'HLW:Current:Air:Temp:Out#2:TimeDaily:High'		=> array( 'pos' => 186, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:Out#3:TimeDaily:High'		=> array( 'pos' => 188, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:Out#4:TimeDaily:High'		=> array( 'pos' => 190, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:Out#5:TimeDaily:High'		=> array( 'pos' => 192, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:Out#6:TimeDaily:High'		=> array( 'pos' => 194, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:Out#7:TimeDaily:High'		=> array( 'pos' => 196, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Temp:Out#8:TimeDaily:High'		=> array( 'pos' => 198, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),

'HLW:Current:Leaf:Temp:Leaf#1:TimeDaily:High'		=> array( 'pos' => 200, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Leaf:Temp:Leaf#2:TimeDaily:High'		=> array( 'pos' => 202, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Leaf:Temp:Leaf#3:TimeDaily:High'		=> array( 'pos' => 204, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Leaf:Temp:Leaf#4:TimeDaily:High'		=> array( 'pos' => 206, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),

'HLW:Current:Soil:Temp:Soil#1:TimeDaily:High'		=> array( 'pos' => 208, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Soil:Temp:Soil#2:TimeDaily:High'		=> array( 'pos' => 210, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Soil:Temp:Soil#3:TimeDaily:High'		=> array( 'pos' => 212, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Soil:Temp:Soil#4:TimeDaily:High'		=> array( 'pos' => 214, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),


'HLW:Current:Air:Temp:Out#2:Month:High'		=> array( 'pos' => 216, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#3:Month:High'		=> array( 'pos' => 217, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#4:Month:High'		=> array( 'pos' => 218, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#5:Month:High'		=> array( 'pos' => 219, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#6:Month:High'		=> array( 'pos' => 220, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#7:Month:High'		=> array( 'pos' => 221, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#8:Month:High'		=> array( 'pos' => 222, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Leaf:Temp:Leaf#1:Month:High'		=> array( 'pos' => 223, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#2:Month:High'		=> array( 'pos' => 224, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#3:Month:High'		=> array( 'pos' => 225, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#4:Month:High'		=> array( 'pos' => 226, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Soil:Temp:Soil#1:Month:High'		=> array( 'pos' => 227, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#2:Month:High'		=> array( 'pos' => 228, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#3:Month:High'		=> array( 'pos' => 229, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#4:Month:High'		=> array( 'pos' => 230, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),


'HLW:Current:Air:Temp:Out#2:Month:Low'		=> array( 'pos' => 231, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#3:Month:Low'		=> array( 'pos' => 232, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#4:Month:Low'		=> array( 'pos' => 233, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#5:Month:Low'		=> array( 'pos' => 234, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#6:Month:Low'		=> array( 'pos' => 235, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#7:Month:Low'		=> array( 'pos' => 236, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#8:Month:Low'		=> array( 'pos' => 237, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Leaf:Temp:Leaf#1:Month:Low'		=> array( 'pos' => 238, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#2:Month:Low'		=> array( 'pos' => 239, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#3:Month:Low'		=> array( 'pos' => 240, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#4:Month:Low'		=> array( 'pos' => 241, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Soil:Temp:Soil#1:Month:Low'		=> array( 'pos' => 242, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#2:Month:Low'		=> array( 'pos' => 243, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#3:Month:Low'		=> array( 'pos' => 244, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#4:Month:Low'		=> array( 'pos' => 245, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),


'HLW:Current:Air:Temp:Out#2:Year:High'		=> array( 'pos' => 246, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#3:Year:High'		=> array( 'pos' => 247, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#4:Year:High'		=> array( 'pos' => 248, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#5:Year:High'		=> array( 'pos' => 249, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#6:Year:High'		=> array( 'pos' => 250, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#7:Year:High'		=> array( 'pos' => 251, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#8:Year:High'		=> array( 'pos' => 252, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Leaf:Temp:Leaf#1:Year:High'		=> array( 'pos' => 253, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#2:Year:High'		=> array( 'pos' => 254, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#3:Year:High'		=> array( 'pos' => 255, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#4:Year:High'		=> array( 'pos' => 256, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Soil:Temp:Soil#1:Year:High'		=> array( 'pos' => 257, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#2:Year:High'		=> array( 'pos' => 258, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#3:Year:High'		=> array( 'pos' => 259, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#4:Year:High'		=> array( 'pos' => 260, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),


'HLW:Current:Air:Temp:Out#2:Year:Low'		=> array( 'pos' => 261, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#3:Year:Low'		=> array( 'pos' => 262, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#4:Year:Low'		=> array( 'pos' => 263, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#5:Year:Low'		=> array( 'pos' => 264, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#6:Year:Low'		=> array( 'pos' => 265, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#7:Year:Low'		=> array( 'pos' => 266, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Air:Temp:Out#8:Year:Low'		=> array( 'pos' => 267, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Leaf:Temp:Leaf#1:Year:Low'		=> array( 'pos' => 268, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#2:Year:Low'		=> array( 'pos' => 269, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#3:Year:Low'		=> array( 'pos' => 270, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Leaf:Temp:Leaf#4:Year:Low'		=> array( 'pos' => 271, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),

'HLW:Current:Soil:Temp:Soil#1:Year:Low'		=> array( 'pos' => 272, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#2:Year:Low'		=> array( 'pos' => 273, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#3:Year:Low'		=> array( 'pos' => 274, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
'HLW:Current:Soil:Temp:Soil#4:Year:Low'		=> array( 'pos' => 275, 'len' => 1, 'fn'=>'SmallTemp', 'SI'=>'F2kelvin', 'min'=>-90, 'max'=>164, 'err'=>255,'unit'=> '°F'),
 
//'/*********** extra Humidity ***********///						'
'HLW:Current:Air:Hum:Out#1:Daily:Low'		=> array( 'pos' => 276, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#2:Daily:Low'		=> array( 'pos' => 277, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#3:Daily:Low'		=> array( 'pos' => 278, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#4:Daily:Low'		=> array( 'pos' => 279, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#5:Daily:Low'		=> array( 'pos' => 280, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#6:Daily:Low'		=> array( 'pos' => 281, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#7:Daily:Low'		=> array( 'pos' => 282, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#8:Daily:Low'		=> array( 'pos' => 283, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Air:Hum:Out#1:Daily:High'		=> array( 'pos' => 284, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#2:Daily:High'		=> array( 'pos' => 285, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#3:Daily:High'		=> array( 'pos' => 286, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#4:Daily:High'		=> array( 'pos' => 287, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#5:Daily:High'		=> array( 'pos' => 288, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#6:Daily:High'		=> array( 'pos' => 289, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#7:Daily:High'		=> array( 'pos' => 290, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#8:Daily:High'		=> array( 'pos' => 291, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Air:Hum:Out#1:TimeDaily:Low'		=> array( 'pos' => 292, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:Out#2:TimeDaily:Low'		=> array( 'pos' => 294, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:Out#3:TimeDaily:Low'		=> array( 'pos' => 296, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:Out#4:TimeDaily:Low'		=> array( 'pos' => 298, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:Out#5:TimeDaily:Low'		=> array( 'pos' => 300, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:Out#6:TimeDaily:Low'		=> array( 'pos' => 302, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:Out#7:TimeDaily:Low'		=> array( 'pos' => 304, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:Out#8:TimeDaily:Low'		=> array( 'pos' => 306, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),

'HLW:Current:Air:Hum:Out#1:TimeDaily:High'		=> array( 'pos' => 308, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:Out#2:TimeDaily:High'		=> array( 'pos' => 310, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:Out#3:TimeDaily:High'		=> array( 'pos' => 312, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:Out#4:TimeDaily:High'		=> array( 'pos' => 314, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:Out#5:TimeDaily:High'		=> array( 'pos' => 316, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:Out#6:TimeDaily:High'		=> array( 'pos' => 318, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:Out#7:TimeDaily:High'		=> array( 'pos' => 320, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Air:Hum:Out#8:TimeDaily:High'		=> array( 'pos' => 322, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),

'HLW:Current:Air:Hum:Out#1:Month:High'		=> array( 'pos' => 324, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#2:Month:High'		=> array( 'pos' => 325, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#3:Month:High'		=> array( 'pos' => 326, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#4:Month:High'		=> array( 'pos' => 327, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#5:Month:High'		=> array( 'pos' => 328, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#6:Month:High'		=> array( 'pos' => 329, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#7:Month:High'		=> array( 'pos' => 330, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#8:Month:High'		=> array( 'pos' => 331, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Air:Hum:Out#1:Month:Low'		=> array( 'pos' => 332, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#2:Month:Low'		=> array( 'pos' => 333, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#3:Month:Low'		=> array( 'pos' => 334, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#4:Month:Low'		=> array( 'pos' => 335, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#5:Month:Low'		=> array( 'pos' => 336, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#6:Month:Low'		=> array( 'pos' => 337, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#7:Month:Low'		=> array( 'pos' => 338, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#8:Month:Low'		=> array( 'pos' => 339, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Air:Hum:Out#1:Year:High'		=> array( 'pos' => 340, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#2:Year:High'		=> array( 'pos' => 341, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#3:Year:High'		=> array( 'pos' => 342, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#4:Year:High'		=> array( 'pos' => 343, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#5:Year:High'		=> array( 'pos' => 344, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#6:Year:High'		=> array( 'pos' => 345, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#7:Year:High'		=> array( 'pos' => 346, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#8:Year:High'		=> array( 'pos' => 347, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Air:Hum:Out#1:Year:Low'		=> array( 'pos' => 348, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#2:Year:Low'		=> array( 'pos' => 349, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#3:Year:Low'		=> array( 'pos' => 350, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#4:Year:Low'		=> array( 'pos' => 351, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#5:Year:Low'		=> array( 'pos' => 352, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#6:Year:Low'		=> array( 'pos' => 353, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#7:Year:Low'		=> array( 'pos' => 354, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Air:Hum:Out#8:Year:Low'		=> array( 'pos' => 355, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
 
//'/*********** soil moisture ***********///						'

'HLW:Current:Soil:Moisture:Soil#1:Daily:High'		=> array( 'pos' => 356, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#2:Daily:High'		=> array( 'pos' => 357, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#3:Daily:High'		=> array( 'pos' => 358, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#4:Daily:High'		=> array( 'pos' => 359, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Soil:Moisture:Soil#1:TimeDaily:High'		=> array( 'pos' => 360, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Soil:Moisture:Soil#2:TimeDaily:High'		=> array( 'pos' => 362, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Soil:Moisture:Soil#3:TimeDaily:High'		=> array( 'pos' => 364, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Soil:Moisture:Soil#4:TimeDaily:High'		=> array( 'pos' => 366, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),

'HLW:Current:Soil:Moisture:Soil#1:Daily:Low'		=> array( 'pos' => 368, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#2:Daily:Low'		=> array( 'pos' => 369, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#3:Daily:Low'		=> array( 'pos' => 370, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#4:Daily:Low'		=> array( 'pos' => 371, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Soil:Moisture:Soil#1:TimeDaily:Low'		=> array( 'pos' => 372, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Soil:Moisture:Soil#2:TimeDaily:Low'		=> array( 'pos' => 374, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Soil:Moisture:Soil#3:TimeDaily:Low'		=> array( 'pos' => 376, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Soil:Moisture:Soil#4:TimeDaily:Low'		=> array( 'pos' => 378, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL, 'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),

'HLW:Current:Soil:Moisture:Soil#1:Month:Low'		=> array( 'pos' => 380, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#2:Month:Low'		=> array( 'pos' => 381, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#3:Month:Low'		=> array( 'pos' => 382, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#4:Month:Low'		=> array( 'pos' => 383, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Soil:Moisture:Soil#1:Month:High'		=> array( 'pos' => 384, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#2:Month:High'		=> array( 'pos' => 385, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#3:Month:High'		=> array( 'pos' => 386, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#4:Month:High'		=> array( 'pos' => 387, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Soil:Moisture:Soil#1:Year:Low'		=> array( 'pos' => 388, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#2:Year:Low'		=> array( 'pos' => 389, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#3:Year:Low'		=> array( 'pos' => 390, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#4:Year:Low'		=> array( 'pos' => 391, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Soil:Moisture:Soil#1:Year:High'		=> array( 'pos' => 392, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#2:Year:High'		=> array( 'pos' => 393, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#3:Year:High'		=> array( 'pos' => 394, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Soil:Moisture:Soil#4:Year:High'		=> array( 'pos' => 395, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

	///*********** leaf Wetness ***********///
'HLW:Current:Leaf:Wetnesses:Leaf#1:Daily:High'		=> array( 'pos' => 396, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#2:Daily:High'		=> array( 'pos' => 397, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#3:Daily:High'		=> array( 'pos' => 398, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#4:Daily:High'		=> array( 'pos' => 399, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Leaf:Wetnesses:Leaf#1:TimeDaily:High'		=> array( 'pos' => 400, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL,'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Leaf:Wetnesses:Leaf#2:TimeDaily:High'		=> array( 'pos' => 402, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL,'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Leaf:Wetnesses:Leaf#3:TimeDaily:High'		=> array( 'pos' => 404, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL,'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Leaf:Wetnesses:Leaf#4:TimeDaily:High'		=> array( 'pos' => 406, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL,'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),

'HLW:Current:Leaf:Wetnesses:Leaf#1:Daily:Low'		=> array( 'pos' => 408, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#2:Daily:Low'		=> array( 'pos' => 409, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#3:Daily:Low'		=> array( 'pos' => 410, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#4:Daily:Low'		=> array( 'pos' => 411, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Leaf:Wetnesses:Leaf#1:TimeDaily:Low'		=> array( 'pos' => 412, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL,'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Leaf:Wetnesses:Leaf#2:TimeDaily:Low'		=> array( 'pos' => 414, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL,'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Leaf:Wetnesses:Leaf#3:TimeDaily:Low'		=> array( 'pos' => 416, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL,'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),
'HLW:Current:Leaf:Wetnesses:Leaf#4:TimeDaily:Low'		=> array( 'pos' => 418, 'len' => 2, 'fn'=>'Raw2Time', 'SI'=>NULL,'min'=>NULL,'max'=>NULL,'err'=>'655:35:00', 'unit'=> 'H:m:s'),

'HLW:Current:Leaf:Wetnesses:Leaf#1:Month:Low'		=> array( 'pos' => 420, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#2:Month:Low'		=> array( 'pos' => 421, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#3:Month:Low'		=> array( 'pos' => 422, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#4:Month:Low'		=> array( 'pos' => 423, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Leaf:Wetnesses:Leaf#1:Month:High'		=> array( 'pos' => 424, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#2:Month:High'		=> array( 'pos' => 425, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#3:Month:High'		=> array( 'pos' => 426, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#4:Month:High'		=> array( 'pos' => 427, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Leaf:Wetnesses:Leaf#1:Year:Low'		=> array( 'pos' => 428, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#2:Year:Low'		=> array( 'pos' => 429, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#3:Year:Low'		=> array( 'pos' => 430, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#4:Year:Low'		=> array( 'pos' => 431, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),

'HLW:Current:Leaf:Wetnesses:Leaf#1:Year:High'		=> array( 'pos' => 432, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#2:Year:High'		=> array( 'pos' => 433, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#3:Year:High'		=> array( 'pos' => 434, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
'HLW:Current:Leaf:Wetnesses:Leaf#4:Year:High'		=> array( 'pos' => 435, 'len' => 1, 'fn'=>'s2uc','SI'=>NULL,'min'=>0,'max'=>100, 'err'=>255,'unit'=> '%'),
 
//'CRC::::::'		=> array( 'pos' => 436, 'len' => 2, 'fn'=>'crc','SI'=>NULL, 'min'=>0,'max'=>0xFF, 'err'=>255,'unit'=> '' ),
	);
	?>

