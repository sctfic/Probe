<?
	$this->symb = array (
			'CR' => chr(0x0D), // \r
			'LF' => chr(0x0A), // \n
			'LFCR' => chr(0x0A).chr(0x0D),
			'ESC' => chr(0x1b), // Echap
			'ACK' => chr(0x06), // Compris
			'NAK' => chr(0x21), // Pas Compris
			'CANCEL' => chr(0x18), // Bad CRC Code
			'_OK_' => "\n\rOK\n\r"
	);
	$this->table = array(
	0x0,  0x1021,  0x2042,  0x3063,  0x4084,  0x50a5,  0x60c6,  0x70e7,
	0x8108,  0x9129,  0xa14a,  0xb16b,  0xc18c,  0xd1ad,  0xe1ce,  0xf1ef,
	0x1231,  0x210,  0x3273,  0x2252,  0x52b5,  0x4294,  0x72f7,  0x62d6,
	0x9339,  0x8318,  0xb37b,  0xa35a,  0xd3bd,  0xc39c,  0xf3ff,  0xe3de,
	0x2462,  0x3443,  0x420,  0x1401,  0x64e6,  0x74c7,  0x44a4,  0x5485,
	0xa56a,  0xb54b,  0x8528,  0x9509,  0xe5ee,  0xf5cf,  0xc5ac,  0xd58d,
	0x3653,  0x2672,  0x1611,  0x630,  0x76d7,  0x66f6,  0x5695,  0x46b4,
	0xb75b,  0xa77a,  0x9719,  0x8738,  0xf7df,  0xe7fe,  0xd79d,  0xc7bc,
	0x48c4,  0x58e5,  0x6886,  0x78a7,  0x840,  0x1861,  0x2802,  0x3823,
	0xc9cc,  0xd9ed,  0xe98e,  0xf9af,  0x8948,  0x9969,  0xa90a,  0xb92b,
	0x5af5,  0x4ad4,  0x7ab7,  0x6a96,  0x1a71,  0xa50,  0x3a33,  0x2a12,
	0xdbfd,  0xcbdc,  0xfbbf,  0xeb9e,  0x9b79,  0x8b58,  0xbb3b,  0xab1a,
	0x6ca6,  0x7c87,  0x4ce4,  0x5cc5,  0x2c22,  0x3c03,  0xc60,  0x1c41,
	0xedae,  0xfd8f,  0xcdec,  0xddcd,  0xad2a,  0xbd0b,  0x8d68,  0x9d49,
	0x7e97,  0x6eb6,  0x5ed5,  0x4ef4,  0x3e13,  0x2e32,  0x1e51,  0xe70,
	0xff9f,  0xefbe,  0xdfdd,  0xcffc,  0xbf1b,  0xaf3a,  0x9f59,  0x8f78,
	0x9188,  0x81a9,  0xb1ca,  0xa1eb,  0xd10c,  0xc12d,  0xf14e,  0xe16f,
	0x1080,  0xa1,  0x30c2,  0x20e3,  0x5004,  0x4025,  0x7046,  0x6067,
	0x83b9,  0x9398,  0xa3fb,  0xb3da,  0xc33d,  0xd31c,  0xe37f,  0xf35e,
	0x2b1,  0x1290,  0x22f3,  0x32d2,  0x4235,  0x5214,  0x6277,  0x7256,
	0xb5ea,  0xa5cb,  0x95a8,  0x8589,  0xf56e,  0xe54f,  0xd52c,  0xc50d,
	0x34e2,  0x24c3,  0x14a0,  0x481,  0x7466,  0x6447,  0x5424,  0x4405,
	0xa7db,  0xb7fa,  0x8799,  0x97b8,  0xe75f,  0xf77e,  0xc71d,  0xd73c,
	0x26d3,  0x36f2,  0x691,  0x16b0,  0x6657,  0x7676,  0x4615,  0x5634,
	0xd94c,  0xc96d,  0xf90e,  0xe92f,  0x99c8,  0x89e9,  0xb98a,  0xa9ab,
	0x5844,  0x4865,  0x7806,  0x6827,  0x18c0,  0x8e1,  0x3882,  0x28a3,
	0xcb7d,  0xdb5c,  0xeb3f,  0xfb1e,  0x8bf9,  0x9bd8,  0xabbb,  0xbb9a,
	0x4a75,  0x5a54,  0x6a37,  0x7a16,  0xaf1,  0x1ad0,  0x2ab3,  0x3a92,
	0xfd2e,  0xed0f,  0xdd6c,  0xcd4d,  0xbdaa,  0xad8b,  0x9de8,  0x8dc9,
	0x7c26,  0x6c07,  0x5c64,  0x4c45,  0x3ca2,  0x2c83,  0x1ce0,  0xcc1,
	0xef1f,  0xff3e,  0xcf5d,  0xdf7c,  0xaf9b,  0xbfba,  0x8fd9,  0x9ff8,
	0x6e17,  0x7e36,  0x4e55,  0x5e74,  0x2e93,  0x3eb2,  0xed1,  0x1ef0);

// ##############################################################################################
/// IX. Data Formats (See docs on pages 20, 21, 22)
/// 1. LOOP data format
/// Only values read directly from sensors are included in the LOOP packet. Desired values (i.e.,
/// Dew Point or Wind Chill) must be calculated on the PC. The LOOP packet also contains
/// information on the current status of all Vantage Alarm conditions, battery status, weather
/// forecasts, and sunrise and sunset times.
// ##############################################################################################

	$this->Loop = array (
// 	'L'			=>	array( 'pos' => 0,	'len' => 1,	'write'=>false,	'fn'=>'',		'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
// 	'O'			=>	array( 'pos' => 1,	'len' => 1,	'write'=>false,	'fn'=>'',		'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
// 	'O'			=>	array( 'pos' => 2,	'len' => 1,	'write'=>false,	'fn'=>'',		'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
	'BarTrend'		=>	array( 'pos' => 3,	'len' => 1,	'write'=>false,	'fn'=>'BTrend',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'PacketType'		=>	array( 'pos' => 4,	'len' => 1,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Nextrecord'		=>	array( 'pos' => 5,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Barometer'		=>	array( 'pos' => 7,	'len' => 2,	'write'=>false,	'fn'=>'Pressure',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'InsideTemperature'	=>	array( 'pos' => 9,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'InsideHumidity'	=>	array( 'pos' => 11,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.Out'		=>	array( 'pos' => 12,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'WindSpeed'		=>	array( 'pos' => 14,	'len' => 1,	'write'=>false,	'fn'=>'Speed',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'10MinAvgWindSpeed'	=>	array( 'pos' => 15,	'len' => 1,	'write'=>false,	'fn'=>'Speed',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'WindDirection'		=>	array( 'pos' => 16,	'len' => 2,	'write'=>false,	'fn'=>'Angle360',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Temp.extra2'	=>	array( 'pos' => 18,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.extra3'	=>	array( 'pos' => 19,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.extra4'	=>	array( 'pos' => 20,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.extra5'	=>	array( 'pos' => 21,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.extra6'	=>	array( 'pos' => 22,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.extra7'	=>	array( 'pos' => 23,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.extra8'	=>	array( 'pos' => 24,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Temp.soil1'	=>	array( 'pos' => 25,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.soil2'	=>	array( 'pos' => 26,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.soil3'	=>	array( 'pos' => 27,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.soil4'	=>	array( 'pos' => 28,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Temp.leaf1'	=>	array( 'pos' => 29,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.leaf2'	=>	array( 'pos' => 30,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.leaf3'	=>	array( 'pos' => 31,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.leaf4'	=>	array( 'pos' => 32,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Hum.Out'		=>	array( 'pos' => 33,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Hum.extra2'	=>	array( 'pos' => 34,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Hum.extra3'	=>	array( 'pos' => 35,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Hum.extra4'	=>	array( 'pos' => 36,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Hum.extra5'	=>	array( 'pos' => 37,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Hum.extra6'	=>	array( 'pos' => 38,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Hum.extra7'	=>	array( 'pos' => 39,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Hum.extra8'	=>	array( 'pos' => 40,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'RainRate'		=>	array( 'pos' => 41,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'UV'			=>	array( 'pos' => 43,	'len' => 1,	'write'=>false,	'fn'=>'UV',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'SolarRadiation'	=>	array( 'pos' => 44,	'len' => 2,	'write'=>false,	'fn'=>'Radiation',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StormRain'		=>	array( 'pos' => 46,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StartDateOfCurrentStorm'=>	array( 'pos' => 48,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Date',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayRain'		=>	array( 'pos' => 50,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthRain'		=>	array( 'pos' => 52,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearRain'		=>	array( 'pos' => 54,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayET'			=>	array( 'pos' => 56,	'len' => 2,	'write'=>false,	'fn'=>'ET1000',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthET'		=>	array( 'pos' => 58,	'len' => 2,	'write'=>false,	'fn'=>'ET100',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearET'		=>	array( 'pos' => 60,	'len' => 2,	'write'=>false,	'fn'=>'ET100',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Moisture.soil1'	=>	array( 'pos' => 62,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Moisture.soil2'	=>	array( 'pos' => 63,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Moisture.soil3'	=>	array( 'pos' => 64,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Moisture.soil4'	=>	array( 'pos' => 65,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Wetnesses.leaf1'	=>	array( 'pos' => 66,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Wetnesses.leaf2'	=>	array( 'pos' => 67,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Wetnesses.leaf3'	=>	array( 'pos' => 68,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Wetnesses.leaf4'	=>	array( 'pos' => 69,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'InsideAlarms'		=>	array( 'pos' => 70,	'len' => 2,	'write'=>false,	'fn'=>'RainAlarms',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'OutsideAlarms'		=>	array( 'pos' => 72,	'len' => 2,	'write'=>false,	'fn'=>'RainAlarms',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'OutHumidityAlarms'	=>	array( 'pos' => 74,	'len' => 1,	'write'=>false,	'fn'=>'HumidityAlarms',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'ExtraTemp/HumAlarms0'	=>	array( 'pos' => 75,	'len' => 1,	'write'=>false,	'fn'=>'Temp_HumAlarms',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'ExtraTemp/HumAlarms1'	=>	array( 'pos' => 76,	'len' => 1,	'write'=>false,	'fn'=>'Temp_HumAlarms',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'ExtraTemp/HumAlarms2'	=>	array( 'pos' => 77,	'len' => 1,	'write'=>false,	'fn'=>'Temp_HumAlarms',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'ExtraTemp/HumAlarms3'	=>	array( 'pos' => 78,	'len' => 1,	'write'=>false,	'fn'=>'Temp_HumAlarms',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'ExtraTemp/HumAlarms4'	=>	array( 'pos' => 79,	'len' => 1,	'write'=>false,	'fn'=>'Temp_HumAlarms',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'ExtraTemp/HumAlarms5'	=>	array( 'pos' => 80,	'len' => 1,	'write'=>false,	'fn'=>'Temp_HumAlarms',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'ExtraTemp/HumAlarms6'	=>	array( 'pos' => 81,	'len' => 1,	'write'=>false,	'fn'=>'Temp_HumAlarms',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'Soil&LeafAlarms0'	=>	array( 'pos' => 82,	'len' => 1,	'write'=>false,	'fn'=>'s2uc','min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'Soil&LeafAlarms1'	=>	array( 'pos' => 83,	'len' => 1,	'write'=>false,	'fn'=>'s2uc','min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'Soil&LeafAlarms2'	=>	array( 'pos' => 84,	'len' => 1,	'write'=>false,	'fn'=>'s2uc','min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'Soil&LeafAlarms3'	=>	array( 'pos' => 85,	'len' => 1,	'write'=>false,	'fn'=>'s2uc','min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'TransmitterBatteryStatus'=>	array( 'pos' => 86,	'len' => 1,	'write'=>false,	'fn'=>'',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'ConsoleBatteryVoltage'	=>	array( 'pos' => 87,	'len' => 2,	'write'=>false,	'fn'=>'Voltage',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'ForecastIcons'		=>	array( 'pos' => 89,	'len' => 1,	'write'=>false,	'fn'=>'Icons',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'ForecastRuleNumber'	=>	array( 'pos' => 90,	'len' => 1,	'write'=>false,	'fn'=>'Forecast',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfSunrise'		=>	array( 'pos' => 91,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfSunset'		=>	array( 'pos' => 93,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	);


// ##############################################################################################
/// IX. Data Formats (See docs on pages 28, 29)
/// 3. DMP and DMPAFT data format
/// There are two different archived data formats. Rev "A" firmware, dated before April 24, 2002
/// uses the old format. Rev "B" firmware dated on or after April 24, 2002 uses the new format. The
/// fields up to ET are identical for both formats. The only differences are in the Soil, Leaf, Extra
// ##############################################################################################

	$this->DumpAfter = array (
	'DateStamp'		=>	array( 'pos' => 0,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Date',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'Date'	),
	'TimeStamp'		=>	array( 'pos' => 2,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'Time'	),
	'OutsideTemperature'	=>	array( 'pos' => 4,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFFFF,	'err'=>32767,	'unit'=> '°F'	),
	'HighOutTemperature'	=>	array( 'pos' => 6,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFFFF,	'err'=>-32768,	'unit'=> '°F'	),
	'LowOutTemperature'	=>	array( 'pos' => 8,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFFFF,	'err'=>-32767,	'unit'=> '°F'	),
	'Rainfall'		=>	array( 'pos' => 10,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'clic'	),
	'HighRainRate'		=>	array( 'pos' => 12,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'clic/h'),
	'Barometer'		=>	array( 'pos' => 14,	'len' => 2,	'write'=>false,	'fn'=>'Pressure',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'in.Hg'),
	'SolarRadiation'	=>	array( 'pos' => 16,	'len' => 2,	'write'=>false,	'fn'=>'Radiation',	'min'=>0,	'max'=>0xFFFF,	'err'=>32767,	'unit'=> 'W/m²'	),
	'NumberofWindSamples'	=>	array( 'pos' => 18,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> '-'	),
	'InsideTemperature'	=>	array( 'pos' => 20,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFFFF,	'err'=>32767,	'unit'=> '°F'	),
	'IndideHumidity'	=>	array( 'pos' => 22,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '%'	),
	'OutsideHumidity'	=>	array( 'pos' => 23,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '%'	),
	'AverageWindSpeed'	=>	array( 'pos' => 24,	'len' => 1,	'write'=>false,	'fn'=>'Speed',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'mph'	),
	'HighWindSpeed'		=>	array( 'pos' => 25,	'len' => 1,	'write'=>false,	'fn'=>'Speed',		'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> 'mph'	),
	'DirectionofHiWindSpeed'=>	array( 'pos' => 26,	'len' => 1,	'write'=>false,	'fn'=>'Angle16',	'min'=>0,	'max'=>16,	'err'=>255,	'unit'=> '°'	),
	'PrevailingWindDirection'=>	array( 'pos' => 27,	'len' => 1,	'write'=>false,	'fn'=>'Angle16',	'min'=>0,	'max'=>16,	'err'=>255,	'unit'=> '°'	),
	'AverageUVIndex'	=>	array( 'pos' => 28,	'len' => 1,	'write'=>false,	'fn'=>'UV',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '-'	),
	'ETLastHour'		=>	array( 'pos' => 29,	'len' => 1,	'write'=>false,	'fn'=>'ET_h',		'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> 'mm'	),
	'HighSolarRadiation'	=>	array( 'pos' => 30,	'len' => 2,	'write'=>false,	'fn'=>'Radiation',	'min'=>0,	'max'=>2000,	'err'=>0,	'unit'=> 'W/m²'	),
	'HighUVIndex'		=>	array( 'pos' => 32,	'len' => 1,	'write'=>false,	'fn'=>'UV',		'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> '-'	),
	'ForecastRule'		=>	array( 'pos' => 33,	'len' => 1,	'write'=>false,	'fn'=>'Forecast',	'min'=>0,	'max'=>0xFF,	'err'=>193,	'unit'=> '-'	),

	'Temp.leaf1'		=>	array( 'pos' => 34,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp.leaf2'		=>	array( 'pos' => 35,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),

	'Wetnesses.leaf1'	=>	array( 'pos' => 36,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'Wetnesses.leaf2'	=>	array( 'pos' => 37,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),

	'Temp.extra2'		=>	array( 'pos' => 38,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp.extra3'		=>	array( 'pos' => 39,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp.extra4'		=>	array( 'pos' => 40,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp.extra5'		=>	array( 'pos' => 41,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),

// 	'DownloadRecordType'	=>	array( 'pos' => 42,	'len' => 1,	'write'=>false,	'fn'=>'SpRev',		'min'=>0,	'max'=>0xFF,	'err'=>null,	'unit'=> 'Rev'	),
	'Hum.extra1'		=>	array( 'pos' => 43,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '%'	),
	'Hum.extra2'		=>	array( 'pos' => 44,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '%'	),

	'Temp.extra1'		=>	array( 'pos' => 45,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp.extra2'		=>	array( 'pos' => 46,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'Temp.extra3'		=>	array( 'pos' => 47,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),

	'Moistures.soil1'	=>	array( 'pos' => 48,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'Moistures.soil2'	=>	array( 'pos' => 49,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'Moistures.soil3'	=>	array( 'pos' => 50,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'Moistures.soil4'	=>	array( 'pos' => 51,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	); 



// ##############################################################################################
/// XII. EEPROM configuration settings (See Docs on pages 35, 36, 67, 38)
/// 
// ##############################################################################################

	$this->EEPROM = array (
	'BarGain'		=>	array( 'pos' => 1,	'len' => 2,	'write'=>false,	'fn'=>'Gain',	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'BarOffset'		=>	array( 'pos' => 3,	'len' => 2,	'write'=>false,	'fn'=>'Offset',	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'BarCal'		=>	array( 'pos' => 5,	'len' => 2,	'write'=>false,	'fn'=>'Cal',	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Hum33'			=>	array( 'pos' => 7,	'len' => 2,	'write'=>false,	'fn'=>'Offset',	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Hum80'			=>	array( 'pos' => 9,	'len' => 2,	'write'=>false,	'fn'=>'Offset',	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Latitude'		=>	array( 'pos' => 11,	'len' => 2,	'write'=>false,	'fn'=>'GPS',	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> '°N'	),
	'Longitude'		=>	array( 'pos' => 13,	'len' => 2,	'write'=>false,	'fn'=>'GPS',	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> '°E'	),
	'Elevation'		=>	array( 'pos' => 15,	'len' => 2,	'write'=>false,	'fn'=>'Alt',	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> 'feet'	),
	'TimeZone'		=>	array( 'pos' => 17,	'len' => 1,	'write'=>false,	'fn'=>'s2sc',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'ManualOrAuto'		=>	array( 'pos' => 18,	'len' => 1,	'write'=>false,	'fn'=>'Bool',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DaylightSavings'	=>	array( 'pos' => 19,	'len' => 1,	'write'=>false,	'fn'=>'Bool',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'GmtOffset'		=>	array( 'pos' => 20,	'len' => 2,	'write'=>false,	'fn'=>'GMT',	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'GmtOrZone'		=>	array( 'pos' => 22,	'len' => 1,	'write'=>false,	'fn'=>'Bool',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Usetx'			=>	array( 'pos' => 23,	'len' => 1,	'write'=>false,	'fn'=>'s2sc',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'ReTransmitTx'		=>	array( 'pos' => 24,	'len' => 1,	'write'=>false,	'fn'=>'s2sc',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

/*	'StationList1'		=>	array( 'pos' => 25,	'len' => 2,	'write'=>false,	'fn'=>'Station',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StationList2'		=>	array( 'pos' => 27,	'len' => 2,	'write'=>false,	'fn'=>'Station',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StationList3'		=>	array( 'pos' => 29,	'len' => 2,	'write'=>false,	'fn'=>'Station',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StationList4'		=>	array( 'pos' => 31,	'len' => 2,	'write'=>false,	'fn'=>'Station',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StationList5'		=>	array( 'pos' => 33,	'len' => 2,	'write'=>false,	'fn'=>'Station',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StationList6'		=>	array( 'pos' => 35,	'len' => 2,	'write'=>false,	'fn'=>'Station',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StationList7'		=>	array( 'pos' => 37,	'len' => 2,	'write'=>false,	'fn'=>'Station',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StationList8'		=>	array( 'pos' => 39,	'len' => 2,	'write'=>false,	'fn'=>'Station',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),*/

	'UnitBits'		=>	array( 'pos' => 41,	'len' => 1,	'write'=>false,	'fn'=>'UnitBits',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'UnitBitsComp'		=>	array( 'pos' => 42,	'len' => 1,	'write'=>false,	'fn'=>'s2sc',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'SetupBits'		=>	array( 'pos' => 43,	'len' => 1,	'write'=>false,	'fn'=>'SetupBits',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'RainSeasonStart'	=>	array( 'pos' => 44,	'len' => 1,	'write'=>false,	'fn'=>'s2uc',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'Month'	),
	'ArchivePeriod'		=>	array( 'pos' => 45,	'len' => 1,	'write'=>false,	'fn'=>'s2uc',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'min'	),

	'TempInCal'		=>	array( 'pos' => 50,	'len' => 1,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'TempInComp'		=>	array( 'pos' => 51,	'len' => 1,	'write'=>false,	'fn'=>'s2sc',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TempCal.Out'		=>	array( 'pos' => 52,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.extra2'	=>	array( 'pos' => 53,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.extra3'	=>	array( 'pos' => 54,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.extra4'	=>	array( 'pos' => 55,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.extra5'	=>	array( 'pos' => 56,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.extra6'	=>	array( 'pos' => 57,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.extra7'	=>	array( 'pos' => 58,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.extra8'	=>	array( 'pos' => 59,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'TempCal.soil1'		=>	array( 'pos' => 60,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.soil2'		=>	array( 'pos' => 61,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.soil3'		=>	array( 'pos' => 62,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.soil4'		=>	array( 'pos' => 63,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'TempCal.leaf1'		=>	array( 'pos' => 64,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.leaf2'		=>	array( 'pos' => 65,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.leaf3'		=>	array( 'pos' => 66,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.leaf4'		=>	array( 'pos' => 67,	'len' => 1,	'write'=>false,	'fn'=>'CalTemp',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'HumInCal'		=>	array( 'pos' => 68,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.Out'		=>	array( 'pos' => 69,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.extra2'		=>	array( 'pos' => 70,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.extra3'		=>	array( 'pos' => 71,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.extra4'		=>	array( 'pos' => 72,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.extra5'		=>	array( 'pos' => 73,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.extra6'		=>	array( 'pos' => 74,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.extra7'		=>	array( 'pos' => 75,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.extra8'		=>	array( 'pos' => 76,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'DirCal'		=>	array( 'pos' => 77,	'len' => 2,	'write'=>false,	'fn'=>'Temp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'DefaultBarGraph'	=>	array( 'pos' => 79,	'len' => 1,	'write'=>false,	'fn'=>'Temp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'DefaultRainGraph'	=>	array( 'pos' => 80,	'len' => 1,	'write'=>false,	'fn'=>'Temp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'DefaultSpeedGraph'	=>	array( 'pos' => 81,	'len' => 1,	'write'=>false,	'fn'=>'Temp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm start ***********					///
	'BarRiseAlarm'		=>	array( 'pos' => 82,	'len' => 1,	'write'=>false,	'fn'=>'Pressure',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'BarFallAlarm'		=>	array( 'pos' => 83,	'len' => 1,	'write'=>false,	'fn'=>'Pressure',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeAlarm'		=>	array( 'pos' => 84,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'TimeCompAlarm'		=>	array( 'pos' => 86,	'len' => 2,	'write'=>false,	'fn'=>'s2sc',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LowTempinAlarm'	=>	array( 'pos' => 88,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HighTempInAlarm'	=>	array( 'pos' => 89,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LowTempAlarm.Out'	=>	array( 'pos' => 90,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HighTempAlarm.Out'	=>	array( 'pos' => 91,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LowTempAlarm.extra2'	=>	array( 'pos' => 92,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.extra3'	=>	array( 'pos' => 93,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.extra4'	=>	array( 'pos' => 94,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.extra5'	=>	array( 'pos' => 95,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.extra6'	=>	array( 'pos' => 96,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.extra7'	=>	array( 'pos' => 97,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.extra8'	=>	array( 'pos' => 98,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'LowTempAlarm.soil1'	=>	array( 'pos' => 99,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.soil2'	=>	array( 'pos' => 100,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.soil3'	=>	array( 'pos' => 101,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.soil4'	=>	array( 'pos' => 102,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'LowTempAlarm.leaf1'	=>	array( 'pos' => 103,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.leaf2'	=>	array( 'pos' => 104,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.leaf3'	=>	array( 'pos' => 105,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.leaf4'	=>	array( 'pos' => 106,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),


	'HighTempAlarm.extra2'	=>	array( 'pos' => 107,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.extra3'	=>	array( 'pos' => 108,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.extra4'	=>	array( 'pos' => 109,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.extra5'	=>	array( 'pos' => 110,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.extra6'	=>	array( 'pos' => 111,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.extra7'	=>	array( 'pos' => 112,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.extra8'	=>	array( 'pos' => 113,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'HighTempAlarm.soil1'	=>	array( 'pos' => 114,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.soil2'	=>	array( 'pos' => 115,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.soil3'	=>	array( 'pos' => 116,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.soil4'	=>	array( 'pos' => 117,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'HighTempAlarm.leaf1'	=>	array( 'pos' => 118,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.leaf2'	=>	array( 'pos' => 119,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.leaf3'	=>	array( 'pos' => 120,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.leaf4'	=>	array( 'pos' => 121,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),


	'LowHumInAlarm'		=>	array( 'pos' => 122,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumInAlarm'	=>	array( 'pos' => 123,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'LowHumAlarm.Out'	=>	array( 'pos' => 124,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'LowHumAlarm.extra2'	=>	array( 'pos' => 124,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'LowHumAlarm.extra3'	=>	array( 'pos' => 124,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'LowHumAlarm.extra4'	=>	array( 'pos' => 124,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'LowHumAlarm.extra5'	=>	array( 'pos' => 124,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'LowHumAlarm.extra6'	=>	array( 'pos' => 124,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'LowHumAlarm.extra7'	=>	array( 'pos' => 124,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'LowHumAlarm.extra8'	=>	array( 'pos' => 124,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'HighHumAlarm.Out'	=>	array( 'pos' => 132,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumAlarm.extra2'	=>	array( 'pos' => 132,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumAlarm.extra3'	=>	array( 'pos' => 132,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumAlarm.extra4'	=>	array( 'pos' => 132,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumAlarm.extra5'	=>	array( 'pos' => 132,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumAlarm.extra6'	=>	array( 'pos' => 132,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumAlarm.extra7'	=>	array( 'pos' => 132,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumAlarm.extra8'	=>	array( 'pos' => 132,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'LowDewAlarm'		=>	array( 'pos' => 140,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp120',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HighDewAlarm'		=>	array( 'pos' => 141,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp120',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'ChillAlarm'		=>	array( 'pos' => 142,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp120',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HeatAlarm'		=>	array( 'pos' => 143,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'ThswAlarm'		=>	array( 'pos' => 144,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'SpeedAlarm'		=>	array( 'pos' => 145,	'len' => 1,	'write'=>false,	'fn'=>'Speed',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Speed10minAlarm'	=>	array( 'pos' => 146,	'len' => 1,	'write'=>false,	'fn'=>'Speed',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'UvAlarm'		=>	array( 'pos' => 147,	'len' => 1,	'write'=>false,	'fn'=>'UV',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),


	'LowAlarm.Soil1'	=>	array( 'pos' => 149,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LowAlarm.Soil2'	=>	array( 'pos' => 150,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LowAlarm.Soil3'	=>	array( 'pos' => 151,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LowAlarm.Soil4'	=>	array( 'pos' => 152,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'HighAlarm.Soil1'	=>	array( 'pos' => 153,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HighAlarm.Soil2'	=>	array( 'pos' => 154,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HighAlarm.Soil3'	=>	array( 'pos' => 155,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HighAlarm.Soil4'	=>	array( 'pos' => 156,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LowAlarm.Leaf1'	=>	array( 'pos' => 157,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'LowAlarm.Leaf2'	=>	array( 'pos' => 158,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'LowAlarm.Leaf3'	=>	array( 'pos' => 159,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'LowAlarm.Leaf4'	=>	array( 'pos' => 160,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),

	'HighAlarm.Leaf1'	=>	array( 'pos' => 161,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'HighAlarm.Leaf2'	=>	array( 'pos' => 162,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'HighAlarm.Leaf3'	=>	array( 'pos' => 163,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'HighAlarm.Leaf4'	=>	array( 'pos' => 164,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),


	'SolarAlarm'		=>	array( 'pos' => 165,	'len' => 2,	'write'=>false,	'fn'=>'Radiation',	'min'=>0,	'max'=>2000,	'err'=>0xffff,	'unit'=> ''	),
	'RainRateAlarm'		=>	array( 'pos' => 167,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>65,	'err'=>0xffff,	'unit'=> ''	),
	'Rain15minAlarm'	=>	array( 'pos' => 169,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>65,	'err'=>0xffff,	'unit'=> ''	),
	'Rain24hAlarm'		=>	array( 'pos' => 171,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>650,	'err'=>0xffff,	'unit'=> ''	),
	'RainStormAlarm'	=>	array( 'pos' => 173,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>650,	'err'=>0xffff,	'unit'=> ''	),
	'EtDayAlarm'		=>	array( 'pos' => 175,	'len' => 2,	'write'=>false,	'fn'=>'ET1000',		'min'=>0,	'max'=>0xfffe,	'err'=>0xffff,	'unit'=> ''	),
// 	'GraphPointer'		=>	array( 'pos' => 177,	'len' => 8,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'GraphData'		=>	array( 'pos' => 185,	'len' => 3898,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LogAverageTemperature'	=>	array( 'pos' => 4092,	'len' => 1,	'write'=>false,	'fn'=>'s2sc',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	);



// ##############################################################################################
/// IX. Data Formats (See docs on pages 24, 25,26)
/// 2. HILOW data format
/// The "HILOWS" command sends a 436 byte data packet and a 2 byte CRC value. The data packet is
/// broken up into sections of related data values.
// ##############################################################################################

	$this->HiLow = array (
	'DailyLowBarometer'	=>	array( 'pos' => 0,	'len' => 2,	'write'=>false,	'fn'=>'Pressure',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DailyHighBarometer'	=>	array( 'pos' => 2,	'len' => 2,	'write'=>false,	'fn'=>'Pressure',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthLowBar'		=>	array( 'pos' => 4,	'len' => 2,	'write'=>false,	'fn'=>'Pressure',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHighBar'		=>	array( 'pos' => 6,	'len' => 2,	'write'=>false,	'fn'=>'Pressure',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearLowBarometer'	=>	array( 'pos' => 8,	'len' => 2,	'write'=>false,	'fn'=>'Pressure',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHighBarometer'	=>	array( 'pos' => 10,	'len' => 2,	'write'=>false,	'fn'=>'Pressure',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfDayLowBar'	=>	array( 'pos' => 12,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfDayHighBar'	=>	array( 'pos' => 14,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DailyHiWindSpeed'	=>	array( 'pos' => 16,	'len' => 1,	'write'=>false,	'fn'=>'Speed',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfHiSpeed'		=>	array( 'pos' => 17,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHiWindSpeed'	=>	array( 'pos' => 19,	'len' => 1,	'write'=>false,	'fn'=>'Speed',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHiWindSpeed'	=>	array( 'pos' => 20,	'len' => 1,	'write'=>false,	'fn'=>'Speed',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHiInsideTemp'	=>	array( 'pos' => 21,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowInsideTemp'	=>	array( 'pos' => 23,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayHiInTemp'	=>	array( 'pos' => 25,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayLowInTemps'	=>	array( 'pos' => 27,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthLowInTemp'	=>	array( 'pos' => 29,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHiInTemp'		=>	array( 'pos' => 31,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearLowInTemp'		=>	array( 'pos' => 33,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHiInTemp'		=>	array( 'pos' => 35,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHiInHum'		=>	array( 'pos' => 37,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowInHum'		=>	array( 'pos' => 38,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayHiInHum'	=>	array( 'pos' => 39,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayLowInHum'	=>	array( 'pos' => 41,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHiInHum'		=>	array( 'pos' => 43,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthLowInHum'		=>	array( 'pos' => 44,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHiInHum'		=>	array( 'pos' => 45,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearLowInHum'		=>	array( 'pos' => 46,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowOutTemp'		=>	array( 'pos' => 47,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHiOutTemp'		=>	array( 'pos' => 49,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayLowOutTemp'	=>	array( 'pos' => 51,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayHiOutTemp'	=>	array( 'pos' => 53,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHiOutTemp'	=>	array( 'pos' => 55,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthLowOutTemp'	=>	array( 'pos' => 57,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YeahHiOutTemp'		=>	array( 'pos' => 59,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearLowOutTemp'	=>	array( 'pos' => 61,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowDewPoint'	=>	array( 'pos' => 63,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHiDewPoint'		=>	array( 'pos' => 65,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayLowDewPoint'	=>	array( 'pos' => 67,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayHiDewPoint'	=>	array( 'pos' => 69,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHiDewPoint'	=>	array( 'pos' => 71,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthLowDewPoint'	=>	array( 'pos' => 73,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHiDewPoint'	=>	array( 'pos' => 75,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearLowDewPoint'	=>	array( 'pos' => 77,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowWindChill'	=>	array( 'pos' => 79,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayLowChill'	=>	array( 'pos' => 81,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthLowWindChill'	=>	array( 'pos' => 83,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearLowWindChill'	=>	array( 'pos' => 85,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighHeat'		=>	array( 'pos' => 87,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfDayHighHeat'	=>	array( 'pos' => 89,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHighHeat'		=>	array( 'pos' => 91,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHighHeat'		=>	array( 'pos' => 93,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTHSW'		=>	array( 'pos' => 95,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfDayHighTHSW'	=>	array( 'pos' => 97,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHighTHSW'		=>	array( 'pos' => 99,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHighTHSW'		=>	array( 'pos' => 101,	'len' => 2,	'write'=>false,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighSolarRad'	=>	array( 'pos' => 103,	'len' => 2,	'write'=>false,	'fn'=>'Radiation',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfDayHighSolar'	=>	array( 'pos' => 105,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHighSolarRad'	=>	array( 'pos' => 107,	'len' => 2,	'write'=>false,	'fn'=>'Radiation',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHighSolarRad'	=>	array( 'pos' => 109,	'len' => 2,	'write'=>false,	'fn'=>'Radiation',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighUV'		=>	array( 'pos' => 111,	'len' => 1,	'write'=>false,	'fn'=>'UV',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfDayHighUV'	=>	array( 'pos' => 112,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHighUV'		=>	array( 'pos' => 114,	'len' => 1,	'write'=>false,	'fn'=>'UV',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHighUV'		=>	array( 'pos' => 115,	'len' => 1,	'write'=>false,	'fn'=>'UV',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighRainRate'	=>	array( 'pos' => 116,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfDayHighRainRate'	=>	array( 'pos' => 118,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HourHighRainRate'	=>	array( 'pos' => 120,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHighRainRate'	=>	array( 'pos' => 122,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHighRainRate'	=>	array( 'pos' => 124,	'len' => 2,	'write'=>false,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** extra temperature ***********					///
	'DayLowTemperature.extra2'	=>	array( 'pos' => 126,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.extra3'	=>	array( 'pos' => 127,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.extra4'	=>	array( 'pos' => 128,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.extra5'	=>	array( 'pos' => 129,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.extra6'	=>	array( 'pos' => 130,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.extra7'	=>	array( 'pos' => 131,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.extra8'	=>	array( 'pos' => 132,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'DayLowTemperature.leaf1'	=>	array( 'pos' => 133,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.leaf2'	=>	array( 'pos' => 134,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.leaf3'	=>	array( 'pos' => 135,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.leaf4'	=>	array( 'pos' => 136,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'DayLowTemperature.soil1'	=>	array( 'pos' => 137,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.soil2'	=>	array( 'pos' => 138,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.soil3'	=>	array( 'pos' => 139,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.soil4'	=>	array( 'pos' => 140,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	
	'DayHighTemperature.extra2'	=>	array( 'pos' => 141,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.extra3'	=>	array( 'pos' => 142,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.extra4'	=>	array( 'pos' => 143,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.extra5'	=>	array( 'pos' => 144,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.extra6'	=>	array( 'pos' => 145,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.extra7'	=>	array( 'pos' => 146,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.extra8'	=>	array( 'pos' => 147,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'DayHighTemperature.leaf1'	=>	array( 'pos' => 148,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.leaf2'	=>	array( 'pos' => 149,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.leaf3'	=>	array( 'pos' => 150,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.leaf4'	=>	array( 'pos' => 151,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'DayHighTemperature.soil1'	=>	array( 'pos' => 152,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.soil2'	=>	array( 'pos' => 153,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.soil3'	=>	array( 'pos' => 154,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.soil4'	=>	array( 'pos' => 155,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	
	'TimeDayLowTemperature'	=>	array( 'pos' => 156,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	
	'TimeDayHiTemperature'	=>	array( 'pos' => 186,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	
	'MonthHiTemperature'	=>	array( 'pos' => 216,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	
	'MonthLowTemperature'	=>	array( 'pos' => 231,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	
	'YearHiTemperature'	=>	array( 'pos' => 246,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'YearLowTemperature'	=>	array( 'pos' => 261,	'len' => 1,	'write'=>false,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** extra Humidity ***********						///
	'DayLowHumidity.Out'	=>	array( 'pos' => 276,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowHumidity.extra2' 	=>	array( 'pos' => 277,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowHumidity.extra3' 	=>	array( 'pos' => 278,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowHumidity.extra4' 	=>	array( 'pos' => 279,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowHumidity.extra5' 	=>	array( 'pos' => 280,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowHumidity.extra6' 	=>	array( 'pos' => 281,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowHumidity.extra7' 	=>	array( 'pos' => 282,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowHumidity.extra8' 	=>	array( 'pos' => 283,	'len' => 1,	'write'=>false,	'fn'=>'Rate',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'DayHiHumidity'		=>	array( 'pos' => 284,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TimeDayLowHumidity'	=>	array( 'pos' => 300,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TimeDayHiHumidity'	=>	array( 'pos' => 316,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'MonthHiHumidity'	=>	array( 'pos' => 324,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'MonthLowHumidity'	=>	array( 'pos' => 332,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'YearHiHumidity'	=>	array( 'pos' => 340,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'YearLowHumidity'	=>	array( 'pos' => 348,	'len' => 1,	'write'=>false,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** soil moisture ***********						///
	'DayHiSoilMoisture'	=>	array( 'pos' => 356,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TimeDayHiSoilMoisture'	=>	array( 'pos' => 360,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'DayLowSoilMoisture'	=>	array( 'pos' => 368,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TimeDayLowSoilMoisture'=>	array( 'pos' => 372,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'MonthLowSoilMoisture'	=>	array( 'pos' => 380,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'MonthHiSoilMoisture'	=>	array( 'pos' => 384,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'YearLowSoilMoisture'	=>	array( 'pos' => 388,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'YearHiSoilMoisture'	=>	array( 'pos' => 392,	'len' => 1,	'write'=>false,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** leaf Wetness ***********						///
	'DayHiLeafWetness'	=>	array( 'pos' => 496,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TimeDayHiLeafWetness'	=>	array( 'pos' => 500,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'DayLowLeafWetness'	=>	array( 'pos' => 508,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TimeDayLowLeafWetness'	=>	array( 'pos' => 512,	'len' => 2,	'write'=>false,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'MonthLowLeafWetness'	=>	array( 'pos' => 520,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'MonthHiLeafWetness'	=>	array( 'pos' => 524,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'YearLowLeafWetness'	=>	array( 'pos' => 528,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'YearHiLeafWetness'	=>	array( 'pos' => 532,	'len' => 1,	'write'=>false,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	
// 	'CRC'			=>	array( 'pos' => 536,	'len' => 2,	'write'=>false,	'fn'=>'crc',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	);

	$this->WinDir = array('N','NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW');

	$this->Trend = array(196=>-2, 236=>-1, 0=>0, 20=>1, 60=>2, 80=>'Rev A');
?>
