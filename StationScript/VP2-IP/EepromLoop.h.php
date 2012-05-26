<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 20, 21, 22)
/// 1. LOOP data format
/// Only values read directly from sensors are included in the LOOP packet. Desired values (i.e.,
/// Dew Point or Wind Chill) must be calculated on the PC. The LOOP packet also contains
/// information on the current status of all Vantage Alarm conditions, battery status, weather
/// forecasts, and sunrise and sunset times.
// ##############################################################################################

	$this->Loop = array (
// 	'L'				=>	array( 'pos' => 0,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
// 	'O'				=>	array( 'pos' => 1,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
// 	'O'				=>	array( 'pos' => 2,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
	'Current.Common:Pressure_3hTrend'	=>	array( 'pos' => 3,	'len' => 1,	'fn'=>'Tools::BTrend',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'PacketType'			=>	array( 'pos' => 4,	'len' => 1,	'fn'=>'Tools::Temp',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Nextrecord'			=>	array( 'pos' => 5,	'len' => 2,	'fn'=>'Tools::Temp',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Common:Pressure_Current'	=>	array( 'pos' => 7,	'len' => 2,	'fn'=>'Tools::Pressure',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Temp:Inside'		=>	array( 'pos' => 9,	'len' => 2,	'fn'=>'Tools::Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Hum:Inside'		=>	array( 'pos' => 11,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Temp:Outside'		=>	array( 'pos' => 12,	'len' => 2,	'fn'=>'Tools::Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Common:Wind_Speed'	=>	array( 'pos' => 14,	'len' => 1,	'fn'=>'Tools::Speed',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Common:Wind_Speed_10MinAvg'=>	array( 'pos' => 15,	'len' => 1,	'fn'=>'Tools::Speed',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Common:Wind_Direction'	=>	array( 'pos' => 16,	'len' => 2,	'fn'=>'Tools::Angle360',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Current.Temp:#2'		=>	array( 'pos' => 18,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Temp:#3'		=>	array( 'pos' => 19,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Temp:#4'		=>	array( 'pos' => 20,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Temp:#5'		=>	array( 'pos' => 21,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Temp:#6'		=>	array( 'pos' => 22,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Temp:#7'		=>	array( 'pos' => 23,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Temp:#8'		=>	array( 'pos' => 24,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Current.Temp:Soil#1'	=>	array( 'pos' => 25,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Temp:Soil#2'	=>	array( 'pos' => 26,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Temp:Soil#3'	=>	array( 'pos' => 27,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Temp:Soil#4'	=>	array( 'pos' => 28,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Current.Temp:Leaf#1'	=>	array( 'pos' => 29,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Temp:Leaf#2'	=>	array( 'pos' => 30,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Temp:Leaf#3'	=>	array( 'pos' => 31,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Temp:Leaf#4'	=>	array( 'pos' => 32,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Current.Hum:Out'		=>	array( 'pos' => 33,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Hum:#2'		=>	array( 'pos' => 34,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Hum:#3'		=>	array( 'pos' => 35,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Hum:#4'		=>	array( 'pos' => 36,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Hum:#5'		=>	array( 'pos' => 37,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Hum:#6'		=>	array( 'pos' => 38,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Hum:#7'		=>	array( 'pos' => 39,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Hum:#8'		=>	array( 'pos' => 40,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						***********  ***********					///
	'Current.Common:Sample_Rain_Rate'		=>	array( 'pos' => 41,	'len' => 2,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Current.Common:UV'			=>	array( 'pos' => 43,	'len' => 1,	'fn'=>'Tools::UV',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Common:Solar_Radiation'		=>	array( 'pos' => 44,	'len' => 2,	'fn'=>'Tools::Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Current.Common:Sample_Storm'		=>	array( 'pos' => 46,	'len' => 2,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Common:Start_Date_Of_Current_Storm'	=>	array( 'pos' => 48,	'len' => 2,	'fn'=>'Tools::Raw2Date',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Current.DailyCommon:Sample_Rain'		=>	array( 'pos' => 50,	'len' => 2,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.MonthlyCommon:Sample_Rain'	=>	array( 'pos' => 52,	'len' => 2,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.YearlyCommon:Sample_Rain'	=>	array( 'pos' => 54,	'len' => 2,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Current.DailyCommon:ET'			=>	array( 'pos' => 56,	'len' => 2,	'fn'=>'Tools::ET1000',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.MonthlyCommon:ET'		=>	array( 'pos' => 58,	'len' => 2,	'fn'=>'Tools::ET100',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.YearlyCommon:ET'			=>	array( 'pos' => 60,	'len' => 2,	'fn'=>'Tools::ET100',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						***********  ***********					///
	'Current.Moisture:Soil#1'	=>	array( 'pos' => 62,	'len' => 1,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Moisture:Soil#2'	=>	array( 'pos' => 63,	'len' => 1,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Moisture:Soil#3'	=>	array( 'pos' => 64,	'len' => 1,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Moisture:Soil#4'	=>	array( 'pos' => 65,	'len' => 1,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Current.Wetnesses:Leaf#1'	=>	array( 'pos' => 66,	'len' => 1,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Wetnesses:Leaf#2'	=>	array( 'pos' => 67,	'len' => 1,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Wetnesses:Leaf#3'	=>	array( 'pos' => 68,	'len' => 1,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Wetnesses:Leaf#4'	=>	array( 'pos' => 69,	'len' => 1,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm start ***********					///
	'Alarm.Statut:Press_3hTrend_Rise'=>	array( 'pos' => 70.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Press_3hTrend_Fall'=>	array( 'pos' => 70.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Low_In'	=>	array( 'pos' => 70.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight_In'	=>	array( 'pos' => 70.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:Low_In'	=>	array( 'pos' => 70.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:High_In'	=>	array( 'pos' => 70.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Time'		=>	array( 'pos' => 70.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'Alarm.Statut:RainRate'		=>	array( 'pos' => 71.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Rain15min'	=>	array( 'pos' => 71.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Rain24h'		=>	array( 'pos' => 71.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:RainStorm'	=>	array( 'pos' => 71.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:EtDay'		=>	array( 'pos' => 71.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'Alarm.Statut:Temp:Low_Out'	=>	array( 'pos' => 72.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight_Out'	=>	array( 'pos' => 72.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Speed'		=>	array( 'pos' => 72.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Speed10min'	=>	array( 'pos' => 72.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:DewPt_Low'	=>	array( 'pos' => 72.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:DewPt_High'	=>	array( 'pos' => 72.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Heat_High'	=>	array( 'pos' => 72.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Chill_Low'	=>	array( 'pos' => 72.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'Alarm.Statut:Thsw_High'	=>	array( 'pos' => 73.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Solar_High'	=>	array( 'pos' => 73.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Uv_High'		=>	array( 'pos' => 73.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:UvDose'		=>	array( 'pos' => 73.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:UvDose_Enabled'	=>	array( 'pos' => 73.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm Out Temp ***********					///
	'Alarm.Statut:Hum:Low_Out'	=>	array( 'pos' => 74.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:High_Out'	=>	array( 'pos' => 74.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'Alarm.Statut:Temp:Low#2'	=>	array( 'pos' => 75.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight#2'	=>	array( 'pos' => 75.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:Low#2'	=>	array( 'pos' => 75.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:High#2'	=>	array( 'pos' => 75.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'Alarm.Statut:Temp:Low#3'	=>	array( 'pos' => 76.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight#3'	=>	array( 'pos' => 76.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:Low#3'	=>	array( 'pos' => 76.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:High#3'	=>	array( 'pos' => 76.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'Alarm.Statut:Temp:Low#4'	=>	array( 'pos' => 77.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight#4'	=>	array( 'pos' => 77.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:Low#4'	=>	array( 'pos' => 77.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:High#4'	=>	array( 'pos' => 77.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'Alarm.Statut:Temp:Low#5'	=>	array( 'pos' => 78.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight#5'	=>	array( 'pos' => 78.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:Low#5'	=>	array( 'pos' => 78.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:High#5'	=>	array( 'pos' => 78.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'Alarm.Statut:Temp:Low#6'	=>	array( 'pos' => 79.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight#6'	=>	array( 'pos' => 79.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:Low#6'	=>	array( 'pos' => 79.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:High#6'	=>	array( 'pos' => 79.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'Alarm.Statut:Temp:Low#7'	=>	array( 'pos' => 80.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight#7'	=>	array( 'pos' => 80.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:Low#7'	=>	array( 'pos' => 80.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:High#7'	=>	array( 'pos' => 80.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'Alarm.Statut:Temp:Low#8'	=>	array( 'pos' => 81.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight#8'	=>	array( 'pos' => 81.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:Low#8'	=>	array( 'pos' => 81.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Hum:High#8'	=>	array( 'pos' => 81.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

///						*********** Alarm Out Soil&Leaf ***********					///
	'Alarm.Statut:Wetnesses:Leaf_Low#1'	=>	array( 'pos' => 82.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Wetnesses:Leaf_High#1'	=>	array( 'pos' => 82.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Moisture:Soil_Low#1'	=>	array( 'pos' => 82.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Moisture:Soil_High#1'	=>	array( 'pos' => 82.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Low_Leaf#1'		=>	array( 'pos' => 82.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight_Leaf#1'	=>	array( 'pos' => 82.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Low_soil#1'		=>	array( 'pos' => 82.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight_soil#1'	=>	array( 'pos' => 82.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'Alarm.Statut:Wetnesses:Leaf_Low#2'	=>	array( 'pos' => 83.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Wetnesses:Leaf_High#2'	=>	array( 'pos' => 83.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Moisture:Soil_Low#2'	=>	array( 'pos' => 83.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Moisture:Soil_High#2'	=>	array( 'pos' => 83.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Low_Leaf#2'		=>	array( 'pos' => 83.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight_Leaf#2'	=>	array( 'pos' => 83.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Low_soil#2'		=>	array( 'pos' => 83.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight_soil#2'	=>	array( 'pos' => 83.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'Alarm.Statut:Wetnesses:Leaf_Low#3'	=>	array( 'pos' => 84.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Wetnesses:Leaf_High#3'	=>	array( 'pos' => 84.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Moisture:Soil_Low#3'	=>	array( 'pos' => 84.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Moisture:Soil_High#3'	=>	array( 'pos' => 84.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Low_Leaf#3'		=>	array( 'pos' => 84.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight_Leaf#3'	=>	array( 'pos' => 84.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Low_soil#3'		=>	array( 'pos' => 84.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight_soil#3'	=>	array( 'pos' => 84.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

	'Alarm.Statut:Wetnesses:Leaf_Low#4'	=>	array( 'pos' => 85.1,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Wetnesses:Leaf_High#4'	=>	array( 'pos' => 85.2,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Moisture:Soil_Low#4'	=>	array( 'pos' => 85.3,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Moisture:Soil_High#4'	=>	array( 'pos' => 85.4,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Low_Leaf#4'		=>	array( 'pos' => 85.5,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight_Leaf#4'	=>	array( 'pos' => 85.6,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Low_soil#4'		=>	array( 'pos' => 85.7,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),
	'Alarm.Statut:Temp:Hight_soil#4'	=>	array( 'pos' => 85.8,	'len' => 1,	'fn'=>'',	'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>255,	'unit'=> ''	),

// 	'TransmitterBatteryStatus'=>	array( 'pos' => 86,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Current.DailyCommon:Voltage_Console_Battery'	=>	array( 'pos' => 87,	'len' => 2,	'fn'=>'Tools::Voltage',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Common:Forecast_Icons'			=>	array( 'pos' => 89,	'len' => 1,	'fn'=>'Tools::Icons',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.Common:Forecast_Rule_Number'		=>	array( 'pos' => 90,	'len' => 1,	'fn'=>'Tools::Forecast',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.DailyCommon:Time_Of_Sunrise'		=>	array( 'pos' => 91,	'len' => 2,	'fn'=>'Tools::Raw2Time',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Current.DailyCommon:Time_Of_Sunset'		=>	array( 'pos' => 93,	'len' => 2,	'fn'=>'Tools::Raw2Time',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	);
?>