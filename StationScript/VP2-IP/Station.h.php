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

	$this->Loop = array ();
	$this->HiLow = array ();
	$this->DumpAfter = array (
	'DateStamp'		=>	array( 'pos' => 0,	'len' => 2,	'fn'=>'Raw2Date',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'Date'	),
	'TimeStamp'		=>	array( 'pos' => 2,	'len' => 2,	'fn'=>'Raw2Time',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'Time'	),
	'OutsideTemperature'	=>	array( 'pos' => 4,	'len' => 2,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFFFF,	'err'=>32767,	'unit'=> '°F'	),
	'HighOutTemperature'	=>	array( 'pos' => 6,	'len' => 2,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFFFF,	'err'=>-32768,	'unit'=> '°F'	),
	'LowOutTemperature'	=>	array( 'pos' => 8,	'len' => 2,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFFFF,	'err'=>-32767,	'unit'=> '°F'	),
	'Rainfall'		=>	array( 'pos' => 10,	'len' => 2,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'clic'	),
	'HighRainRate'		=>	array( 'pos' => 12,	'len' => 2,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'clic/h'),
	'Barometer'		=>	array( 'pos' => 14,	'len' => 2,	'fn'=>'Pressure',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'in.Hg'),
	'SolarRadiation'	=>	array( 'pos' => 16,	'len' => 2,	'fn'=>'Radiation',	'min'=>0,	'max'=>0xFFFF,	'err'=>32767,	'unit'=> 'W/m²'	),
	'NumberofWindSamples'	=>	array( 'pos' => 18,	'len' => 2,	'fn'=>'Samples',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> '-'	),
	'InsideTemperature'	=>	array( 'pos' => 20,	'len' => 2,	'fn'=>'Temp',		'min'=>0,	'max'=>0xFFFF,	'err'=>32767,	'unit'=> '°F'	),
	'IndideHumidity'	=>	array( 'pos' => 22,	'len' => 1,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '%'	),
	'OutsideHumidity'	=>	array( 'pos' => 23,	'len' => 1,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '%'	),
	'AverageWindSpeed'	=>	array( 'pos' => 24,	'len' => 1,	'fn'=>'Speed',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'mph'	),
	'HighWindSpeed'		=>	array( 'pos' => 25,	'len' => 1,	'fn'=>'Speed',		'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> 'mph'	),
	'DirectionofHiWindSpeed'=>	array( 'pos' => 26,	'len' => 1,	'fn'=>'Angle',		'min'=>0,	'max'=>360,	'err'=>255,	'unit'=> '°'	),
	'PrevailingWindDirection'=>	array( 'pos' => 27,	'len' => 1,	'fn'=>'Angle',		'min'=>0,	'max'=>360,	'err'=>255,	'unit'=> '°'	),
	'AverageUVIndex'	=>	array( 'pos' => 28,	'len' => 1,	'fn'=>'UV',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '-'	),
	'ET'			=>	array( 'pos' => 29,	'len' => 1,	'fn'=>'ET',		'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> 'mm'	),
	'HighSolarRadiation'	=>	array( 'pos' => 30,	'len' => 2,	'fn'=>'Radiation',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'W/m²'	),
	'HighUVIndex'		=>	array( 'pos' => 32,	'len' => 1,	'fn'=>'UV',		'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> '-'	),
	'ForecastRule'		=>	array( 'pos' => 33,	'len' => 1,	'fn'=>'Forecast',	'min'=>0,	'max'=>0xFF,	'err'=>193,	'unit'=> '-'	),
	'LeafTemperature-0'	=>	array( 'pos' => 34,	'len' => 1,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'LeafTemperature-1'	=>	array( 'pos' => 35,	'len' => 1,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'LeafWetnesses-0'	=>	array( 'pos' => 36,	'len' => 1,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'LeafWetnesses-1'	=>	array( 'pos' => 37,	'len' => 1,	'fn'=>'Wetnesses',	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'SoilTemperature-0'	=>	array( 'pos' => 38,	'len' => 1,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'SoilTemperature-1'	=>	array( 'pos' => 39,	'len' => 1,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'SoilTemperature-2'	=>	array( 'pos' => 40,	'len' => 1,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'SoilTemperature-3'	=>	array( 'pos' => 41,	'len' => 1,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'DownloadRecordType'	=>	array( 'pos' => 42,	'len' => 1,	'fn'=>'SpRev',		'min'=>0,	'max'=>0xFF,	'err'=>null,	'unit'=> 'Rev'	),
	'ExtraHumidities-0'	=>	array( 'pos' => 43,	'len' => 1,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '%'	),
	'ExtraHumidities-1'	=>	array( 'pos' => 44,	'len' => 1,	'fn'=>'Rate',		'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '%'	),
	'ExtraTemperatures-0'	=>	array( 'pos' => 45,	'len' => 1,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'ExtraTemperatures-1'	=>	array( 'pos' => 46,	'len' => 1,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'ExtraTemperatures-2'	=>	array( 'pos' => 47,	'len' => 1,	'fn'=>'SmallTemp',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'SoilMoistures-0'	=>	array( 'pos' => 48,	'len' => 1,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'SoilMoistures-1'	=>	array( 'pos' => 49,	'len' => 1,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'SoilMoistures-2'	=>	array( 'pos' => 50,	'len' => 1,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'SoilMoistures-3'	=>	array( 'pos' => 51,	'len' => 1,	'fn'=>'Moistures',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	);

	$this->WinDir = array('N','NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW');

	$this->EEPROM = array( // Docs pages 35 to 38
	'BAR_GAIN'	=>	array('pos' => '01','len' => 2, 'eval'=>'$this->Short2Signed($val)',	'unit'=>'*'),
	'BAR_OFFSET'	=>	array('pos' => '03','len' => 2, 'eval'=>'$this->Short2Signed($val)',	'unit'=>'+'),
	'BAR_CAL'	=>	array('pos' => '05','len' => 2, 'eval'=>'$this->Short2Signed($val)',	'unit'=>''),
	'LATITUDE'	=>	array('pos' => '0B','len' => 2, 'eval'=>'$this->Short2Signed($val)/10',	'unit'=>'°'),
	'LONGITUDE'	=>	array('pos' => '0D','len' => 2, 'eval'=>'$this->Short2Signed($val)/10',	'unit'=>'°'),
	'ELEVATION'	=>	array('pos' => '0F','len' => 2, 'eval'=>'$this->Short2Signed($val)',	'unit'=>'feet'),
	'TIME_ZONE'	=>	array('pos' => '11','len' => 1, 'eval'=>'$this->Char2Signed($val)',	'unit'=>''),
	'GTM_OFFSET'	=>	array('pos' => '14','len' => 2, 'eval'=>'(int)($val/100).":".str_pad(($val%100),2,"0",STR_PAD_LEFT)',	'unit'=>'h:mm'),
	'GTM_OR_ZONE'	=>	array('pos' => '16','len' => 1, 'eval'=>'$val?"GTM":"ZONE"',	'unit'=>''),
	'UNIT_BITS'	=>	array('pos' => '29','len' => 1, 'eval'=>'array_combine(array("Wind","Rain","Elev","Temp","Barom"),
											array(
												!(($val&0xC0)>>6)?"mph":(((($val&0xC0)>>6)==1)?"m/s":(((($val&0xC0)>>6)==2)?"Km/h":"Knots")),
												(($val&0x20)>>5)?"mm":"in",
												(($val&0x10)>>4)?"m":"ft",
												!(($val&0x0C)>>2)?"1 °F":(((($val&0x0C)>>2)==1)?"0.1 °F":(((($val&0x0C)>>2)==2)?"1 °C":"0.1 °C")),
												!($val&0x03)?"0.01 in":((($val&0x03)==1)?"0.1 mm":((($val&0x03)==2)?"0.1 hpa":"0.1 mB")),
											))',	'unit'=>'Bits'),
	'SETUP_BITS'	=>	array('pos' => '2B','len' => 1, 'eval'=>'array_combine(array("Longitude:","Latitude:","RainCupSize","WinCupSize","DayMonth","AM/PM","12/24"),
											array(
												(($val&0x80)>>7)?"East":"West",
												(($val&0x40)>>6)?"Nord":"South",
												!(($val&30)>>4)?"0.01 in":(((($val&30)>>4)==1)?"0.2 mm":"0.1 mm"),
												(($val&0x08)>>3)?"Large":"Small",
												(($val&0x04)>>2)?"Day/Month":"Month/Day",
												(($val&0x02)>>1)?"AM?":"PM?",
												($val&0x01)?"24h?":"AM/PM?",
											))',	'unit'=>'Bits'), // AM/PM bits 0 and 1 are WRONG !
	'RAIN_SEASON_START'=>	array('pos' => '2C','len' => 1, 'eval'=>'$val',	'unit'=>'month'),
	'ARCHIVE_PERIOD'=>	array('pos' => '2D','len' => 1, 'eval'=>'$val',	'unit'=>'min'), // STEPER () , START() , STOP()
	'TEMP_IN_CAL'	=>	array('pos' => '32','len' => 1, 'eval'=>'$this->Char2Signed($val)/10',	'unit'=>'°F'),
	'TEMP_OUT_CAL'	=>	array('pos' => '34','len' => 1, 'eval'=>'$this->Char2Signed($val)/10',	'unit'=>'°F'),
	'HUM_IN_CAL'	=>	array('pos' => '44','len' => 1, 'eval'=>'$val',	'unit'=>'%'),
	'WIND_DIR_CAL'	=>	array('pos' => '4D','len' => 2, 'eval'=>'$this->Short2Signed($val)',	'unit'=>'degrees'),
	'AVERAGE_TEMP'	=>	array('pos' => '0FFC','len' => 1, 'eval'=>'$val?"Last":"Average"',	'unit'=>' '),
	'VER'		=>	'substr($val,0,-2)',
	'NVER'		=>	'substr($val,0,-2)',
	'RXCHECK'	=>	'array_combine(array("Received","Missed","Resync","LargestReceived","CRC-Error"),explode(" ",substr($val,0,-2)))',
	'BARDATA'	=>	'explode(chr(0x0A).chr(0x0D),$val)',
// 	''	=>		array('pos' => '','len' => 1, 'eval'=>'',	'unit'=>''),
	);
?>
