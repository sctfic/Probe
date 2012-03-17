<?php
// ##############################################################################################
/// XII. EEPROM configuration settings (See Docs on pages 35, 36, 67, 38)
/// 
// ##############################################################################################

	$this->EEPROM = array (
	'BarGain'		=>	array( 'pos' => 1,	'len' => 2,	'w'=>false,	'fn'=>'Gain',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'BarOffset'		=>	array( 'pos' => 3,	'len' => 2,	'w'=>false,	'fn'=>'Offset',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'BarCal'		=>	array( 'pos' => 5,	'len' => 2,	'w'=>false,	'fn'=>'Cal',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Hum33'			=>	array( 'pos' => 7,	'len' => 2,	'w'=>false,	'fn'=>'Offset',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Hum80'			=>	array( 'pos' => 9,	'len' => 2,	'w'=>false,	'fn'=>'Offset',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Latitude'		=>	array( 'pos' => 11,	'len' => 2,	'w'=>false,	'fn'=>'GPS',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> '°N'	),
	'Longitude'		=>	array( 'pos' => 13,	'len' => 2,	'w'=>false,	'fn'=>'GPS',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> '°E'	),
	'Elevation'		=>	array( 'pos' => 15,	'len' => 2,	'w'=>false,	'fn'=>'Alt',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> 'feet'	),
	'TimeZone'		=>	array( 'pos' => 17,	'len' => 1,	'w'=>false,	'fn'=>'s2sc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'ManualOrAuto'		=>	array( 'pos' => 18,	'len' => 1,	'w'=>false,	'fn'=>'Bool',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DaylightSavings'	=>	array( 'pos' => 19,	'len' => 1,	'w'=>false,	'fn'=>'Bool',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'GmtOffset'		=>	array( 'pos' => 20,	'len' => 2,	'w'=>false,	'fn'=>'GMT',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'GmtOrZone'		=>	array( 'pos' => 22,	'len' => 1,	'w'=>false,	'fn'=>'Bool',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Usetx'			=>	array( 'pos' => 23,	'len' => 1,	'w'=>false,	'fn'=>'s2sc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'ReTransmitTx'		=>	array( 'pos' => 24,	'len' => 1,	'w'=>false,	'fn'=>'s2sc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

/*	'StationList1'		=>	array( 'pos' => 25,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StationList2'		=>	array( 'pos' => 27,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StationList3'		=>	array( 'pos' => 29,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StationList4'		=>	array( 'pos' => 31,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StationList5'		=>	array( 'pos' => 33,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StationList6'		=>	array( 'pos' => 35,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StationList7'		=>	array( 'pos' => 37,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StationList8'		=>	array( 'pos' => 39,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),*/

	'UnitBits'		=>	array( 'pos' => 41,	'len' => 1,	'w'=>false,	'fn'=>'UnitBits',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'UnitBitsComp'		=>	array( 'pos' => 42,	'len' => 1,	'w'=>false,	'fn'=>'s2sc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'SetupBits'		=>	array( 'pos' => 43,	'len' => 1,	'w'=>false,	'fn'=>'SetupBits',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'RainSeasonStart'	=>	array( 'pos' => 44,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'Month'	),
	'ArchivePeriod'		=>	array( 'pos' => 45,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'min'	),

	'TempInCal'		=>	array( 'pos' => 50,	'len' => 1,	'w'=>false,	'fn'=>'Temp',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'TempInComp'		=>	array( 'pos' => 51,	'len' => 1,	'w'=>false,	'fn'=>'s2sc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TempCal.Out'		=>	array( 'pos' => 52,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.extra2'	=>	array( 'pos' => 53,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.extra3'	=>	array( 'pos' => 54,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.extra4'	=>	array( 'pos' => 55,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.extra5'	=>	array( 'pos' => 56,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.extra6'	=>	array( 'pos' => 57,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.extra7'	=>	array( 'pos' => 58,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.extra8'	=>	array( 'pos' => 59,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'TempCal.soil1'		=>	array( 'pos' => 60,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.soil2'		=>	array( 'pos' => 61,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.soil3'		=>	array( 'pos' => 62,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.soil4'		=>	array( 'pos' => 63,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'TempCal.leaf1'		=>	array( 'pos' => 64,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.leaf2'		=>	array( 'pos' => 65,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.leaf3'		=>	array( 'pos' => 66,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'TempCal.leaf4'		=>	array( 'pos' => 67,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>NULL,	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'HumInCal'		=>	array( 'pos' => 68,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.Out'		=>	array( 'pos' => 69,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.extra2'		=>	array( 'pos' => 70,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.extra3'		=>	array( 'pos' => 71,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.extra4'		=>	array( 'pos' => 72,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.extra5'		=>	array( 'pos' => 73,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.extra6'		=>	array( 'pos' => 74,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.extra7'		=>	array( 'pos' => 75,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HumCal.extra8'		=>	array( 'pos' => 76,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'DirCal'		=>	array( 'pos' => 77,	'len' => 2,	'w'=>false,	'fn'=>'Temp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'DefaultBarGraph'	=>	array( 'pos' => 79,	'len' => 1,	'w'=>false,	'fn'=>'Temp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'DefaultRainGraph'	=>	array( 'pos' => 80,	'len' => 1,	'w'=>false,	'fn'=>'Temp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'DefaultSpeedGraph'	=>	array( 'pos' => 81,	'len' => 1,	'w'=>false,	'fn'=>'Temp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm start ***********					///
	'BarRiseAlarm'		=>	array( 'pos' => 82,	'len' => 1,	'w'=>false,	'fn'=>'Pressure',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'BarFallAlarm'		=>	array( 'pos' => 83,	'len' => 1,	'w'=>false,	'fn'=>'Pressure',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeAlarm'		=>	array( 'pos' => 84,	'len' => 2,	'w'=>false,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'TimeCompAlarm'		=>	array( 'pos' => 86,	'len' => 2,	'w'=>false,	'fn'=>'s2sc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LowTempinAlarm'	=>	array( 'pos' => 88,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HighTempInAlarm'	=>	array( 'pos' => 89,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LowTempAlarm.Out'	=>	array( 'pos' => 90,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HighTempAlarm.Out'	=>	array( 'pos' => 91,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LowTempAlarm.extra2'	=>	array( 'pos' => 92,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.extra3'	=>	array( 'pos' => 93,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.extra4'	=>	array( 'pos' => 94,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.extra5'	=>	array( 'pos' => 95,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.extra6'	=>	array( 'pos' => 96,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.extra7'	=>	array( 'pos' => 97,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.extra8'	=>	array( 'pos' => 98,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'LowTempAlarm.soil1'	=>	array( 'pos' => 99,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.soil2'	=>	array( 'pos' => 100,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.soil3'	=>	array( 'pos' => 101,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.soil4'	=>	array( 'pos' => 102,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'LowTempAlarm.leaf1'	=>	array( 'pos' => 103,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.leaf2'	=>	array( 'pos' => 104,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.leaf3'	=>	array( 'pos' => 105,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'LowTempAlarm.leaf4'	=>	array( 'pos' => 106,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),


	'HighTempAlarm.extra2'	=>	array( 'pos' => 107,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.extra3'	=>	array( 'pos' => 108,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.extra4'	=>	array( 'pos' => 109,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.extra5'	=>	array( 'pos' => 110,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.extra6'	=>	array( 'pos' => 111,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.extra7'	=>	array( 'pos' => 112,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.extra8'	=>	array( 'pos' => 113,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'HighTempAlarm.soil1'	=>	array( 'pos' => 114,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.soil2'	=>	array( 'pos' => 115,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.soil3'	=>	array( 'pos' => 116,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.soil4'	=>	array( 'pos' => 117,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'HighTempAlarm.leaf1'	=>	array( 'pos' => 118,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.leaf2'	=>	array( 'pos' => 119,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.leaf3'	=>	array( 'pos' => 120,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'HighTempAlarm.leaf4'	=>	array( 'pos' => 121,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),


	'LowHumInAlarm'		=>	array( 'pos' => 122,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumInAlarm'	=>	array( 'pos' => 123,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'LowHumAlarm.Out'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'LowHumAlarm.extra2'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'LowHumAlarm.extra3'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'LowHumAlarm.extra4'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'LowHumAlarm.extra5'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'LowHumAlarm.extra6'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'LowHumAlarm.extra7'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'LowHumAlarm.extra8'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'HighHumAlarm.Out'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumAlarm.extra2'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumAlarm.extra3'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumAlarm.extra4'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumAlarm.extra5'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumAlarm.extra6'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumAlarm.extra7'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'HighHumAlarm.extra8'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'LowDewAlarm'		=>	array( 'pos' => 140,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp120',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HighDewAlarm'		=>	array( 'pos' => 141,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp120',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'ChillAlarm'		=>	array( 'pos' => 142,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp120',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HeatAlarm'		=>	array( 'pos' => 143,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'ThswAlarm'		=>	array( 'pos' => 144,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'SpeedAlarm'		=>	array( 'pos' => 145,	'len' => 1,	'w'=>false,	'fn'=>'Speed',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Speed10minAlarm'	=>	array( 'pos' => 146,	'len' => 1,	'w'=>false,	'fn'=>'Speed',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'UvAlarm'		=>	array( 'pos' => 147,	'len' => 1,	'w'=>false,	'fn'=>'UV',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),


	'LowAlarm.Soil1'	=>	array( 'pos' => 149,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LowAlarm.Soil2'	=>	array( 'pos' => 150,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LowAlarm.Soil3'	=>	array( 'pos' => 151,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'LowAlarm.Soil4'	=>	array( 'pos' => 152,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'HighAlarm.Soil1'	=>	array( 'pos' => 153,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HighAlarm.Soil2'	=>	array( 'pos' => 154,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HighAlarm.Soil3'	=>	array( 'pos' => 155,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HighAlarm.Soil4'	=>	array( 'pos' => 156,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'LowAlarm.Leaf1'	=>	array( 'pos' => 157,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'LowAlarm.Leaf2'	=>	array( 'pos' => 158,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'LowAlarm.Leaf3'	=>	array( 'pos' => 159,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'LowAlarm.Leaf4'	=>	array( 'pos' => 160,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),

	'HighAlarm.Leaf1'	=>	array( 'pos' => 161,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'HighAlarm.Leaf2'	=>	array( 'pos' => 162,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'HighAlarm.Leaf3'	=>	array( 'pos' => 163,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'HighAlarm.Leaf4'	=>	array( 'pos' => 164,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),


	'SolarAlarm'		=>	array( 'pos' => 165,	'len' => 2,	'w'=>false,	'fn'=>'Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>2000,	'err'=>0xffff,	'unit'=> ''	),
	'RainRateAlarm'		=>	array( 'pos' => 167,	'len' => 2,	'w'=>false,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>65,	'err'=>0xffff,	'unit'=> ''	),
	'Rain15minAlarm'	=>	array( 'pos' => 169,	'len' => 2,	'w'=>false,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>65,	'err'=>0xffff,	'unit'=> ''	),
	'Rain24hAlarm'		=>	array( 'pos' => 171,	'len' => 2,	'w'=>false,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>650,	'err'=>0xffff,	'unit'=> ''	),
	'RainStormAlarm'	=>	array( 'pos' => 173,	'len' => 2,	'w'=>false,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>650,	'err'=>0xffff,	'unit'=> ''	),
	'EtDayAlarm'		=>	array( 'pos' => 175,	'len' => 2,	'w'=>false,	'fn'=>'ET1000',		'SI'=>NULL,	'min'=>0,	'max'=>0xfffe,	'err'=>0xffff,	'unit'=> ''	),
// 	'GraphPointer'		=>	array( 'pos' => 177,	'len' => 8,	'w'=>false,	'fn'=>'Temp',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'GraphData'		=>	array( 'pos' => 185,	'len' => 3898,	'w'=>false,	'fn'=>'Temp',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
//	'LogAverageTemperature'	=>	array( 'pos' => 4092,	'len' => 1,	'w'=>false,	'fn'=>'s2sc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	);
?>