<?php
// ##############################################################################################
/// XII. EEPROM configuration settings (See Docs on pages 35, 36, 37, 38)
/// 
// ##############################################################################################

	$this->EEPROM = array (
	'Factory:Bar_Gain'		=>	array( 'pos' => 1,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Gain',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Factory:Bar_Offset'		=>	array( 'pos' => 3,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Offset',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Factory:Bar_Cal'		=>	array( 'pos' => 5,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Cal',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Factory:Hum@33%'		=>	array( 'pos' => 7,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Offset',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Factory:Hum@80%'		=>	array( 'pos' => 9,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Offset',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Config:Latitude'		=>	array( 'pos' => 11,	'len' => 2,	'w'=>false,	'fn'=>'Tools::GPS',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> '°N'	),
	'Config:Longitude'		=>	array( 'pos' => 13,	'len' => 2,	'w'=>false,	'fn'=>'Tools::GPS',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> '°E'	),
	'Config:Elevation'		=>	array( 'pos' => 15,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Alt',		'SI'=>'metric',	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> 'feet'	),
	'Config:TimeZone'		=>	array( 'pos' => 17,	'len' => 1,	'w'=>false,	'fn'=>'Tools::s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:ManualOrAuto'		=>	array( 'pos' => 18,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Bool',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:DaylightSavings'	=>	array( 'pos' => 19,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Bool',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:GmtOffset'		=>	array( 'pos' => 20,	'len' => 2,	'w'=>false,	'fn'=>'Tools::GMT',		'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),
	'Config:GmtOrZone'		=>	array( 'pos' => 22,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Bool',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:Usetx'			=>	array( 'pos' => 23,	'len' => 1,	'w'=>false,	'fn'=>'Tools::s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:ReTransmitTx'		=>	array( 'pos' => 24,	'len' => 1,	'w'=>false,	'fn'=>'Tools::s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

/*	'Other:StationList1'		=>	array( 'pos' => 25,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList2'		=>	array( 'pos' => 27,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList3'		=>	array( 'pos' => 29,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList4'		=>	array( 'pos' => 31,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList5'		=>	array( 'pos' => 33,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList6'		=>	array( 'pos' => 35,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList7'		=>	array( 'pos' => 37,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Other:StationList8'		=>	array( 'pos' => 39,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Station',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),*/

	'Config:Barometer_Unit'		=>	array( 'pos' => 41.1,	'len' => 2,	'w'=>false,	'fn'=>false,	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:Temperature_Unit'	=>	array( 'pos' => 41.3,	'len' => 2,	'w'=>false,	'fn'=>false,	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:Elevation_Unit'		=>	array( 'pos' => 41.5,	'len' => 1,	'w'=>false,	'fn'=>false,	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:Rain_Unit'		=>	array( 'pos' => 41.6,	'len' => 1,	'w'=>false,	'fn'=>false,	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:Wind_Unit'		=>	array( 'pos' => 41.7,	'len' => 2,	'w'=>false,	'fn'=>false,	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:UnitBitsComp'		=>	array( 'pos' => 42,	'len' => 1,	'w'=>false,	'fn'=>'Tools::s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Config:AM/PM_Mode'		=>	array( 'pos' => 43.1,	'len' => 1,	'w'=>false,	'fn'=>false,	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:PM_Now'			=>	array( 'pos' => 43.2,	'len' => 1,	'w'=>false,	'fn'=>false,	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:Month/Day_format'	=>	array( 'pos' => 43.3,	'len' => 1,	'w'=>false,	'fn'=>false,	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:Large_Wind_Cup'		=>	array( 'pos' => 43.4,	'len' => 1,	'w'=>false,	'fn'=>false,	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:Rain_Collector'		=>	array( 'pos' => 43.5,	'len' => 2,	'w'=>false,	'fn'=>false,	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:Latitude_North'		=>	array( 'pos' => 43.7,	'len' => 1,	'w'=>false,	'fn'=>false,	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:Longitude_East'		=>	array( 'pos' => 43.8,	'len' => 1,	'w'=>false,	'fn'=>false,	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Config:RainSeasonStart'	=>	array( 'pos' => 44,	'len' => 1,	'w'=>false,	'fn'=>'Tools::s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'Month'	),
	'Config:ArchivePeriod'		=>	array( 'pos' => 45,	'len' => 1,	'w'=>false,	'fn'=>'Tools::s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'min'	),

	'Calibrate:Temp_In'		=>	array( 'pos' => 50,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:TempInComp'		=>	array( 'pos' => 51,	'len' => 1,	'w'=>false,	'fn'=>'Tools::s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Calibrate:Temp_Out'		=>	array( 'pos' => 52,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempS/.I',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibrate:Temp#2'		=>	array( 'pos' => 53,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibrate:Temp#3'		=>	array( 'pos' => 54,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibrate:Temp#4'		=>	array( 'pos' => 55,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibrate:Temp#5'		=>	array( 'pos' => 56,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibrate:Temp#6'		=>	array( 'pos' => 57,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibrate:Temp#7'		=>	array( 'pos' => 58,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibrate:Temp#8'		=>	array( 'pos' => 59,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'Calibrate:Temp_soil#1'		=>	array( 'pos' => 60,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibrate:Temp_soil#2'		=>	array( 'pos' => 61,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibrate:Temp_soil#3'		=>	array( 'pos' => 62,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibrate:Temp_soil#4'		=>	array( 'pos' => 63,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'Calibrate:Temp_Leaf#1'		=>	array( 'pos' => 64,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibrate:Temp_Leaf#2'		=>	array( 'pos' => 65,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibrate:Temp_Leaf#3'		=>	array( 'pos' => 66,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),
	'Calibrate:Temp_Leaf#4'		=>	array( 'pos' => 67,	'len' => 1,	'w'=>false,	'fn'=>'Tools::CalTemp',	'SI'=>'tempSI',	'min'=>-12.8,	'max'=>12.7,	'err'=>NULL,	'unit'=> ''	),

	'Calibrate:Hum_In'		=>	array( 'pos' => 68,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibrate:Hum_Out'		=>	array( 'pos' => 69,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibrate:Hum#2'		=>	array( 'pos' => 70,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibrate:Hum#3'		=>	array( 'pos' => 71,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibrate:Hum#4'		=>	array( 'pos' => 72,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibrate:Hum#5'		=>	array( 'pos' => 73,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibrate:Hum#6'		=>	array( 'pos' => 74,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibrate:Hum#7'		=>	array( 'pos' => 75,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Calibrate:Hum#8'		=>	array( 'pos' => 76,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'Calibrate:Wind_Direction'	=>	array( 'pos' => 77,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Temp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:DefaultBarGraph'		=>	array( 'pos' => 79,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Temp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:DefaultRainGraph'	=>	array( 'pos' => 80,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Temp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:DefaultSpeedGraph'	=>	array( 'pos' => 81,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Temp',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm start ***********					///
	'Alarm.Press:3hTrend_Rise'	=>	array( 'pos' => 82,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Pressure',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm.Press:3hTrend_Fall'	=>	array( 'pos' => 83,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Pressure',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Time'			=>	array( 'pos' => 84,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:TimeComp'		=>	array( 'pos' => 86,	'len' => 2,	'w'=>false,	'fn'=>'Tools::s2uc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Alarm.Temp:Low_In'	=>	array( 'pos' => 88,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm.Temp:Hight_In'	=>	array( 'pos' => 89,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Alarm.Temp:Low_Out'	=>	array( 'pos' => 90,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm.Temp:Hight_Out'	=>	array( 'pos' => 91,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Alarm.Temp:Low#2'	=>	array( 'pos' => 92,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Low#3'	=>	array( 'pos' => 93,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Low#4'	=>	array( 'pos' => 94,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Low#5'	=>	array( 'pos' => 95,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Low#6'	=>	array( 'pos' => 96,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Low#7'	=>	array( 'pos' => 97,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Low#8'	=>	array( 'pos' => 98,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'Alarm.Temp:Low_soil#1'	=>	array( 'pos' => 99,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Low_soil#2'	=>	array( 'pos' => 100,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Low_soil#3'	=>	array( 'pos' => 101,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Low_soil#4'	=>	array( 'pos' => 102,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'Alarm.Temp:Low_Leaf#1'	=>	array( 'pos' => 103,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Low_Leaf#2'	=>	array( 'pos' => 104,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Low_Leaf#3'	=>	array( 'pos' => 105,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Low_Leaf#4'	=>	array( 'pos' => 106,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),


	'Alarm.Temp:Hight#2'		=>	array( 'pos' => 107,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Hight#3'		=>	array( 'pos' => 108,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Hight#4'		=>	array( 'pos' => 109,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Hight#5'		=>	array( 'pos' => 110,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Hight#6'		=>	array( 'pos' => 111,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Hight#7'		=>	array( 'pos' => 112,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Hight#8'		=>	array( 'pos' => 113,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'Alarm.Temp:Hight_soil#1'	=>	array( 'pos' => 114,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Hight_soil#2'	=>	array( 'pos' => 115,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Hight_soil#3'	=>	array( 'pos' => 116,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Hight_soil#4'	=>	array( 'pos' => 117,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'Alarm.Temp:Hight_Leaf#1'	=>	array( 'pos' => 118,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Hight_Leaf#2'	=>	array( 'pos' => 119,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Hight_Leaf#3'	=>	array( 'pos' => 120,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),
	'Alarm.Temp:Hight_Leaf#4'	=>	array( 'pos' => 121,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>165,	'err'=>NULL,	'unit'=> ''	),

	'Alarm.Hum:Low_In'	=>	array( 'pos' => 122,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:High_In'	=>	array( 'pos' => 123,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'Alarm.Hum:Low_Out'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:Low#2'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:Low#3'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:Low#4'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:Low#5'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:Low#6'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:Low#7'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:Low#8'	=>	array( 'pos' => 124,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'Alarm.Hum:High_Out'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:High#2'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:High#3'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:High#4'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:High#5'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:High#6'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:High#7'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),
	'Alarm.Hum:High#8'	=>	array( 'pos' => 132,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Rate',	'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'Alarm.eTemp:DewPt_Low'	=>	array( 'pos' => 140,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp120',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm.eTemp:DewPt_High'=>	array( 'pos' => 141,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp120',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm.eTemp:Chill_Low'	=>	array( 'pos' => 142,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp120',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm.Temp:Heat_High'	=>	array( 'pos' => 143,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm.Temp:Thsw_High'	=>	array( 'pos' => 144,	'len' => 1,	'w'=>false,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Speed'		=>	array( 'pos' => 145,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Speed',		'SI'=>'mBySec',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Speed10min'	=>	array( 'pos' => 146,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Speed',		'SI'=>'mBySec',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm:Uv_High'		=>	array( 'pos' => 147,	'len' => 1,	'w'=>false,	'fn'=>'Tools::UV',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm Out Soil&Leaf ***********					///
	'Alarm.Moisture:Soil_Low#1'	=>	array( 'pos' => 149,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm.Moisture:Soil_Low#2'	=>	array( 'pos' => 150,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm.Moisture:Soil_Low#3'	=>	array( 'pos' => 151,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm.Moisture:Soil_Low#4'	=>	array( 'pos' => 152,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Alarm.Moisture:Soil_High#1'	=>	array( 'pos' => 153,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm.Moisture:Soil_High#2'	=>	array( 'pos' => 154,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm.Moisture:Soil_High#3'	=>	array( 'pos' => 155,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Alarm.Moisture:Soil_High#4'	=>	array( 'pos' => 156,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Alarm.Wetnesses:Leaf_Low#1'	=>	array( 'pos' => 157,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'Alarm.Wetnesses:Leaf_Low#2'	=>	array( 'pos' => 158,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'Alarm.Wetnesses:Leaf_Low#3'	=>	array( 'pos' => 159,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'Alarm.Wetnesses:Leaf_Low#4'	=>	array( 'pos' => 160,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),

	'Alarm.Wetnesses:Leaf_High#1'	=>	array( 'pos' => 161,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'Alarm.Wetnesses:Leaf_High#2'	=>	array( 'pos' => 162,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'Alarm.Wetnesses:Leaf_High#3'	=>	array( 'pos' => 163,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),
	'Alarm.Wetnesses:Leaf_High#4'	=>	array( 'pos' => 164,	'len' => 1,	'w'=>false,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> ''	),


	'Alarm:Solar_High'	=>	array( 'pos' => 165,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>2000,	'err'=>0xffff,	'unit'=> ''	),
	'Alarm:RainRate'	=>	array( 'pos' => 167,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>65,	'err'=>0xffff,	'unit'=> ''	),
	'Alarm:Rain15min'	=>	array( 'pos' => 169,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>65,	'err'=>0xffff,	'unit'=> ''	),
	'Alarm:Rain24h'		=>	array( 'pos' => 171,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>650,	'err'=>0xffff,	'unit'=> ''	),
	'Alarm:RainStorm'	=>	array( 'pos' => 173,	'len' => 2,	'w'=>false,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>650,	'err'=>0xffff,	'unit'=> ''	),
	'Alarm:EtDay'		=>	array( 'pos' => 175,	'len' => 2,	'w'=>false,	'fn'=>'Tools::ET1000',		'SI'=>NULL,	'min'=>0,	'max'=>0xfffe,	'err'=>0xffff,	'unit'=> ''	),
// 	'Other:GraphPointer'		=>	array( 'pos' => 177,	'len' => 8,	'w'=>false,	'fn'=>'Tools::Temp',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Other:GraphData'		=>	array( 'pos' => 185,	'len' => 3898,	'w'=>false,	'fn'=>'Tools::Temp',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Config:Temp_LogAverage'	=>	array( 'pos' => 4092,	'len' => 1,	'w'=>true,	'fn'=>'Tools::Bool',		'SI'=>NULL,	'min'=>0,	'max'=>1,	'err'=>255,	'unit'=> ''	),
	);

?>