<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 28, 29)
/// 3. DMP and DMPAFT data format
/// There are two different archived data formats. Rev "A" firmware, dated before April 24, 2002
/// uses the old format. Rev "B" firmware dated on or after April 24, 2002 uses the new format. The
/// fields up to ET are identical for both formats. The only differences are in the Soil, Leaf, Extra
// ##############################################################################################

	$this->DumpAfter = array (
	'DateStamp'		=>	array( 'pos' => 0,	'len' => 2,	'fn'=>'Raw2Date',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'Date'	),
	'TimeStamp'		=>	array( 'pos' => 2,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'Time'	),
	'OutsideTemperature'	=>	array( 'pos' => 4,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>32767,	'unit'=> '°F'	),
	'HighOutTemperature'	=>	array( 'pos' => 6,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>-32768,	'unit'=> '°F'	),
	'LowOutTemperature'	=>	array( 'pos' => 8,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>-32767,	'unit'=> '°F'	),
	'Rainfall'		=>	array( 'pos' => 10,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'clic'	),
	'HighRainRate'		=>	array( 'pos' => 12,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'clic/h'),
	'Barometer'		=>	array( 'pos' => 14,	'len' => 2,	'fn'=>'Pressure',	'SI'=>'barSI',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'in.Hg'),
	'SolarRadiation'	=>	array( 'pos' => 16,	'len' => 2,	'fn'=>'Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>3000,	'err'=>32767,	'unit'=> 'W/m²'	),
	'NumberOfWindSamples'	=>	array( 'pos' => 18,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> '-'	),
	'InsideTemperature'	=>	array( 'pos' => 20,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>32767,	'unit'=> '°F'	),
	'IndideHumidity'	=>	array( 'pos' => 22,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'OutsideHumidity'	=>	array( 'pos' => 23,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'AverageWindSpeed'	=>	array( 'pos' => 24,	'len' => 1,	'fn'=>'Speed',		'SI'=>'mBySec',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'mph'	),
	'HighWindSpeed'		=>	array( 'pos' => 25,	'len' => 1,	'fn'=>'Speed',		'SI'=>'mBySec',	'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> 'mph'	),
	'DirectionofHiWindSpeed'=>	array( 'pos' => 26,	'len' => 1,	'fn'=>'Angle16',	'SI'=>NULL,	'min'=>0,	'max'=>16,	'err'=>255,	'unit'=> '°'	),
	'PrevailingWindDirection'=>	array( 'pos' => 27,	'len' => 1,	'fn'=>'Angle16',	'SI'=>NULL,	'min'=>0,	'max'=>16,	'err'=>255,	'unit'=> '°'	),
	'AverageUVIndex'	=>	array( 'pos' => 28,	'len' => 1,	'fn'=>'UV',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '-'	),
	'ETLastHour'		=>	array( 'pos' => 29,	'len' => 1,	'fn'=>'ET_h',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> 'mm'	),
	'HighSolarRadiation'	=>	array( 'pos' => 30,	'len' => 2,	'fn'=>'Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>2000,	'err'=>0,	'unit'=> 'W/m²'	),
	'HighUVIndex'		=>	array( 'pos' => 32,	'len' => 1,	'fn'=>'UV',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> '-'	),
	'ForecastRule'		=>	array( 'pos' => 33,	'len' => 1,	'fn'=>'Forecast',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>193,	'unit'=> '-'	),

	'Temp.leaf1'		=>	array( 'pos' => 34,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'Temp.leaf2'		=>	array( 'pos' => 35,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),

	'Wetnesses.leaf1'	=>	array( 'pos' => 36,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> '-'	),
	'Wetnesses.leaf2'	=>	array( 'pos' => 37,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> '-'	),

	'Temp.extra2'		=>	array( 'pos' => 38,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp.extra3'		=>	array( 'pos' => 39,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp.extra4'		=>	array( 'pos' => 40,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp.extra5'		=>	array( 'pos' => 41,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),

// 	'DownloadRecordType'	=>	array( 'pos' => 42,	'len' => 1,	'fn'=>'SpRev',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>null,	'unit'=> 'Rev'	),
	'Hum.extra1'		=>	array( 'pos' => 43,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'Hum.extra2'		=>	array( 'pos' => 44,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),

	'Temp.extra1'		=>	array( 'pos' => 45,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp.extra2'		=>	array( 'pos' => 46,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp.extra3'		=>	array( 'pos' => 47,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),

	'Moistures.soil1'	=>	array( 'pos' => 48,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'Moistures.soil2'	=>	array( 'pos' => 49,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'Moistures.soil3'	=>	array( 'pos' => 50,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'Moistures.soil4'	=>	array( 'pos' => 51,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	); 
?>