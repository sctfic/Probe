<?php
// _#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#
/// XII. EEPROM configuration settings (See Docs on pages 35, 36, 67, 38)
/// 
// _#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#

	$this->EEPROM = array (
	'Factory:Bar_Gain'		=>	array( 'pos' => 1,	'len' => 2,	'w'=>false,	'fn'=>'Gain',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Factory:Bar_Offset'		=>	array( 'pos' => 3,	'len' => 2,	'w'=>false,	'fn'=>'Offset',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Factory:Bar_Cal'		=>	array( 'pos' => 5,	'len' => 2,	'w'=>false,	'fn'=>'Cal',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Factory:Hum@33%'		=>	array( 'pos' => 7,	'len' => 2,	'w'=>false,	'fn'=>'Offset',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Factory:Hum@80%'		=>	array( 'pos' => 9,	'len' => 2,	'w'=>false,	'fn'=>'Offset',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Config:Latitude'		=>	array( 'pos' => 11,	'len' => 2,	'w'=>false,	'fn'=>'GPS',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> '°N'	),
	'Config:Longitude'		=>	array( 'pos' => 13,	'len' => 2,	'w'=>false,	'fn'=>'GPS',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> '°E'	),
	'Config:Elevation'		=>	array( 'pos' => 15,	'len' => 2,	'w'=>false,	'fn'=>'Alt',		'SI'=>'metric',	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> 'feet'	),
	'Config:TimeZone'		=>	array( 'pos' => 17,	'len' => 1,	'w'=>false,	'fn'=>'s2sc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:ManualOrAuto'		=>	array( 'pos' => 18,	'len' => 1,	'w'=>false,	'fn'=>'Bool',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:DaylightSavings'	=>	array( 'pos' => 19,	'len' => 1,	'w'=>false,	'fn'=>'Bool',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:GmtOffset'		=>	array( 'pos' => 20,	'len' => 2,	'w'=>false,	'fn'=>'GMT',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Config:GmtOrZone'		=>	array( 'pos' => 22,	'len' => 1,	'w'=>false,	'fn'=>'Bool',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:Usetx'			=>	array( 'pos' => 23,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:ReTransmitTx'		=>	array( 'pos' => 24,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

/*	'Other:StationList1'		=>	array( 'pos' => 25,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList2'		=>	array( 'pos' => 27,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList3'		=>	array( 'pos' => 29,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList4'		=>	array( 'pos' => 31,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList5'		=>	array( 'pos' => 33,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList6'		=>	array( 'pos' => 35,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList7'		=>	array( 'pos' => 37,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList8'		=>	array( 'pos' => 39,	'len' => 2,	'w'=>false,	'fn'=>'Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),*/

	'Config:UnitBits'		=>	array( 'pos' => 41,	'len' => 1,	'w'=>false,	'fn'=>'UnitBits',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:UnitBitsComp'		=>	array( 'pos' => 42,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Config:SetupBits'		=>	array( 'pos' => 43,	'len' => 1,	'w'=>false,	'fn'=>'SetupBits',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Config:RainSeasonStart'	=>	array( 'pos' => 44,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'Month'	),
	'Config:ArchivePeriod'		=>	array( 'pos' => 45,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'min'	),

	'Calibate:Temp_In'	=>	array( 'pos' => 50,	'len' => 1,	'w'=>false,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:TempInComp'		=>	array( 'pos' => 51,	'len' => 1,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Calibate:Temp_Out'	=>	array( 'pos' => 52,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempS/.I',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibate:Temp_#2'	=>	array( 'pos' => 53,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibate:Temp_#3'	=>	array( 'pos' => 54,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibate:Temp_#4'	=>	array( 'pos' => 55,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibate:Temp_#5'	=>	array( 'pos' => 56,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibate:Temp_#6'	=>	array( 'pos' => 57,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibate:Temp_#7'	=>	array( 'pos' => 58,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibate:Temp_#8'	=>	array( 'pos' => 59,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'Calibate:Temp_soil_#1'		=>	array( 'pos' => 60,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibate:Temp_soil_#2'		=>	array( 'pos' => 61,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibate:Temp_soil_#3'		=>	array( 'pos' => 62,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibate:Temp_soil_#4'		=>	array( 'pos' => 63,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'Calibate:Temp_Leaf_#1'		=>	array( 'pos' => 64,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibate:Temp_Leaf_#2'		=>	array( 'pos' => 65,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibate:Temp_Leaf_#3'		=>	array( 'pos' => 66,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibate:Temp_Leaf_#4'		=>	array( 'pos' => 67,	'len' => 1,	'w'=>false,	'fn'=>'CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'Calibate:Hum_In'		=>	array( 'pos' => 68,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibate:Hum_Out'		=>	array( 'pos' => 69,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibate:Hum_#2'		=>	array( 'pos' => 70,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibate:Hum_#3'		=>	array( 'pos' => 71,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibate:Hum_#4'		=>	array( 'pos' => 72,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibate:Hum_#5'		=>	array( 'pos' => 73,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibate:Hum_#6'		=>	array( 'pos' => 74,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibate:Hum_#7'		=>	array( 'pos' => 75,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibate:Hum_#8'		=>	array( 'pos' => 76,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'Calibate:Wind_Direction'	=>	array( 'pos' => 77,	'len' => 2,	'w'=>false,	'fn'=>'Temp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:DefaultBarGraph'	=>	array( 'pos' => 79,	'len' => 1,	'w'=>false,	'fn'=>'Temp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:DefaultRainGraph'	=>	array( 'pos' => 80,	'len' => 1,	'w'=>false,	'fn'=>'Temp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:DefaultSpeedGraph'	=>	array( 'pos' => 81,	'len' => 1,	'w'=>false,	'fn'=>'Temp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm start ***********					///
	'Alarm:Press_3hTrend_Rise'	=>	array( 'pos' => 82,	'len' => 1,	'w'=>false,	'fn'=>'Pressure',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Press_3hTrend_Fall'	=>	array( 'pos' => 83,	'len' => 1,	'w'=>false,	'fn'=>'Pressure',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Time'		=>	array( 'pos' => 84,	'len' => 2,	'w'=>false,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:TimeComp'		=>	array( 'pos' => 86,	'len' => 2,	'w'=>false,	'fn'=>'s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Alarm:Temp_Low_In'	=>	array( 'pos' => 88,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Temp_Hight_In'	=>	array( 'pos' => 89,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Alarm:Temp_Low_Out'	=>	array( 'pos' => 90,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Temp_Hight_Out'	=>	array( 'pos' => 91,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Alarm:Temp_Low_#2'	=>	array( 'pos' => 92,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Low_#3'	=>	array( 'pos' => 93,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Low_#4'	=>	array( 'pos' => 94,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Low_#5'	=>	array( 'pos' => 95,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Low_#6'	=>	array( 'pos' => 96,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Low_#7'	=>	array( 'pos' => 97,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Low_#8'	=>	array( 'pos' => 98,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'Alarm:Temp_Low_soil_#1'	=>	array( 'pos' => 99,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Low_soil_#2'	=>	array( 'pos' => 100,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Low_soil_#3'	=>	array( 'pos' => 101,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Low_soil_#4'	=>	array( 'pos' => 102,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'Alarm:Temp_Low_Leaf_#1'	=>	array( 'pos' => 103,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Low_Leaf_#2'	=>	array( 'pos' => 104,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Low_Leaf_#3'	=>	array( 'pos' => 105,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Low_Leaf_#4'	=>	array( 'pos' => 106,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),


	'Alarm:Temp_Hight_#2'	=>	array( 'pos' => 107,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Hight_#3'	=>	array( 'pos' => 108,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Hight_#4'	=>	array( 'pos' => 109,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Hight_#5'	=>	array( 'pos' => 110,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Hight_#6'	=>	array( 'pos' => 111,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Hight_#7'	=>	array( 'pos' => 112,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Hight_#8'	=>	array( 'pos' => 113,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'Alarm:Temp_Hight_soil_#1'	=>	array( 'pos' => 114,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Hight_soil_#2'	=>	array( 'pos' => 115,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Hight_soil_#3'	=>	array( 'pos' => 116,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Hight_soil_#4'	=>	array( 'pos' => 117,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'Alarm:Temp_Hight_Leaf_#1'	=>	array( 'pos' => 118,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Hight_Leaf_#2'	=>	array( 'pos' => 119,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Hight_Leaf_#3'	=>	array( 'pos' => 120,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm:Temp_Hight_Leaf_#4'	=>	array( 'pos' => 121,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'Alarm:Hum_Low_In'	=>	array( 'pos' => 122,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_High_In'	=>	array( 'pos' => 123,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'Alarm:Hum_Low_Out'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_Low_#2'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_Low_#3'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_Low_#4'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_Low_#5'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_Low_#6'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_Low_#7'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_Low_#8'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'Alarm:Hum_High_Out'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_High_#2'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_High_#3'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_High_#4'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_High_#5'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_High_#6'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_High_#7'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm:Hum_High_#8'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'Alarm:DewPt_Low'	=>	array( 'pos' => 140,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp120',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:DewPt_High'	=>	array( 'pos' => 141,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp120',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Chill_Low'	=>	array( 'pos' => 142,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp120',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Heat_High'	=>	array( 'pos' => 143,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Thsw_High'	=>	array( 'pos' => 144,	'len' => 1,	'w'=>false,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Speed'		=>	array( 'pos' => 145,	'len' => 1,	'w'=>false,	'fn'=>'Speed',		'SI'=>'mBySec',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Speed10min'	=>	array( 'pos' => 146,	'len' => 1,	'w'=>false,	'fn'=>'Speed',		'SI'=>'mBySec',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Uv_High'		=>	array( 'pos' => 147,	'len' => 1,	'w'=>false,	'fn'=>'UV',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm Out Soil&Leaf ***********					///
	'Alarm:Soil_Moisture_Low_#1'	=>	array( 'pos' => 149,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Soil_Moisture_Low_#2'	=>	array( 'pos' => 150,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Soil_Moisture_Low_#3'	=>	array( 'pos' => 151,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Soil_Moisture_Low_#4'	=>	array( 'pos' => 152,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Alarm:Soil_Moisture_High_#1'	=>	array( 'pos' => 153,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Soil_Moisture_High_#2'	=>	array( 'pos' => 154,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Soil_Moisture_High_#3'	=>	array( 'pos' => 155,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Soil_Moisture_High_#4'	=>	array( 'pos' => 156,	'len' => 1,	'w'=>false,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Alarm:Leaf_Wetnesses_Low_#1'	=>	array( 'pos' => 157,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'Alarm:Leaf_Wetnesses_Low_#2'	=>	array( 'pos' => 158,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'Alarm:Leaf_Wetnesses_Low_#3'	=>	array( 'pos' => 159,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'Alarm:Leaf_Wetnesses_Low_#4'	=>	array( 'pos' => 160,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),

	'Alarm:Leaf_Wetnesses_High_#1'	=>	array( 'pos' => 161,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'Alarm:Leaf_Wetnesses_High_#2'	=>	array( 'pos' => 162,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'Alarm:Leaf_Wetnesses_High_#3'	=>	array( 'pos' => 163,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'Alarm:Leaf_Wetnesses_High_#4'	=>	array( 'pos' => 164,	'len' => 1,	'w'=>false,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),


	'Alarm:Solar_High'	=>	array( 'pos' => 165,	'len' => 2,	'w'=>false,	'fn'=>'Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>2000,	'err'=>0xffff,	'unit'=> ''	),
	'Alarm:RainRate'	=>	array( 'pos' => 167,	'len' => 2,	'w'=>false,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>65,	'err'=>0xffff,	'unit'=> ''	),
	'Alarm:Rain15min'	=>	array( 'pos' => 169,	'len' => 2,	'w'=>false,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>65,	'err'=>0xffff,	'unit'=> ''	),
	'Alarm:Rain24h'		=>	array( 'pos' => 171,	'len' => 2,	'w'=>false,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>650,	'err'=>0xffff,	'unit'=> ''	),
	'Alarm:RainStorm'	=>	array( 'pos' => 173,	'len' => 2,	'w'=>false,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>650,	'err'=>0xffff,	'unit'=> ''	),
	'Alarm:EtDay'		=>	array( 'pos' => 175,	'len' => 2,	'w'=>false,	'fn'=>'ET1000',		'SI'=>NULL,	'min'=>0,	'max'=>0xfffe,	'err'=>0xffff,	'unit'=> ''	),
// 	'Other:GraphPointer'		=>	array( 'pos' => 177,	'len' => 8,	'w'=>false,	'fn'=>'Temp',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:GraphData'		=>	array( 'pos' => 185,	'len' => 3898,	'w'=>false,	'fn'=>'Temp',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:Temp_LogAverage'	=>	array( 'pos' => 4092,	'len' => 1,	'w'=>true,	'fn'=>'Bool',		'SI'=>NULL,	'min'=>0,	'max'=>1,	'err'=>255,	'unit'=> ''	),
	);

?>