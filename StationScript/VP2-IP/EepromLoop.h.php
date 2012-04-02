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
// 	'L'			=>	array( 'pos' => 0,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
// 	'O'			=>	array( 'pos' => 1,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
// 	'O'			=>	array( 'pos' => 2,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0,	'err'=>0,	'unit'=> ''	),
	'BarTrend'		=>	array( 'pos' => 3,	'len' => 1,	'fn'=>'BTrend',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'PacketType'		=>	array( 'pos' => 4,	'len' => 1,	'fn'=>'Temp',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'Nextrecord'		=>	array( 'pos' => 5,	'len' => 2,	'fn'=>'Temp',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Barometer'		=>	array( 'pos' => 7,	'len' => 2,	'fn'=>'Pressure',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'InsideTemperature'	=>	array( 'pos' => 9,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'InsideHumidity'	=>	array( 'pos' => 11,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.Out'		=>	array( 'pos' => 12,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'WindSpeed'		=>	array( 'pos' => 14,	'len' => 1,	'fn'=>'Speed',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'10MinAvgWindSpeed'	=>	array( 'pos' => 15,	'len' => 1,	'fn'=>'Speed',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'WindDirection'		=>	array( 'pos' => 16,	'len' => 2,	'fn'=>'Angle360',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Temp.extra2'		=>	array( 'pos' => 18,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.extra3'		=>	array( 'pos' => 19,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.extra4'		=>	array( 'pos' => 20,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.extra5'		=>	array( 'pos' => 21,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.extra6'		=>	array( 'pos' => 22,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.extra7'		=>	array( 'pos' => 23,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.extra8'		=>	array( 'pos' => 24,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Temp.soil1'		=>	array( 'pos' => 25,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.soil2'		=>	array( 'pos' => 26,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.soil3'		=>	array( 'pos' => 27,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.soil4'		=>	array( 'pos' => 28,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Temp.leaf1'		=>	array( 'pos' => 29,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.leaf2'		=>	array( 'pos' => 30,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.leaf3'		=>	array( 'pos' => 31,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Temp.leaf4'		=>	array( 'pos' => 32,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Hum.Out'		=>	array( 'pos' => 33,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Hum.extra2'		=>	array( 'pos' => 34,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Hum.extra3'		=>	array( 'pos' => 35,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Hum.extra4'		=>	array( 'pos' => 36,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Hum.extra5'		=>	array( 'pos' => 37,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Hum.extra6'		=>	array( 'pos' => 38,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Hum.extra7'		=>	array( 'pos' => 39,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Hum.extra8'		=>	array( 'pos' => 40,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'RainRate'		=>	array( 'pos' => 41,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'UV'			=>	array( 'pos' => 43,	'len' => 1,	'fn'=>'UV',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'SolarRadiation'	=>	array( 'pos' => 44,	'len' => 2,	'fn'=>'Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StormRain'		=>	array( 'pos' => 46,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'StartDateOfCurrentStorm'=>	array( 'pos' => 48,	'len' => 2,	'fn'=>'Raw2Date',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayRain'		=>	array( 'pos' => 50,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthRain'		=>	array( 'pos' => 52,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearRain'		=>	array( 'pos' => 54,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayET'			=>	array( 'pos' => 56,	'len' => 2,	'fn'=>'ET1000',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthET'		=>	array( 'pos' => 58,	'len' => 2,	'fn'=>'ET100',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearET'		=>	array( 'pos' => 60,	'len' => 2,	'fn'=>'ET100',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Moisture.soil1'	=>	array( 'pos' => 62,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Moisture.soil2'	=>	array( 'pos' => 63,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Moisture.soil3'	=>	array( 'pos' => 64,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Moisture.soil4'	=>	array( 'pos' => 65,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'Wetnesses.leaf1'	=>	array( 'pos' => 66,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Wetnesses.leaf2'	=>	array( 'pos' => 67,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Wetnesses.leaf3'	=>	array( 'pos' => 68,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'Wetnesses.leaf4'	=>	array( 'pos' => 69,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'InsideAlarms'		=>	array( 'pos' => 70,	'len' => 2,	'fn'=>'RainAlarms',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'OutsideAlarms'		=>	array( 'pos' => 72,	'len' => 2,	'fn'=>'RainAlarms',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'OutHumidityAlarms'	=>	array( 'pos' => 74,	'len' => 1,	'fn'=>'HumidityAlarms',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'ExtraTemp/HumAlarms0'	=>	array( 'pos' => 75,	'len' => 1,	'fn'=>'Temp_HumAlarms',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'ExtraTemp/HumAlarms1'	=>	array( 'pos' => 76,	'len' => 1,	'fn'=>'Temp_HumAlarms',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'ExtraTemp/HumAlarms2'	=>	array( 'pos' => 77,	'len' => 1,	'fn'=>'Temp_HumAlarms',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'ExtraTemp/HumAlarms3'	=>	array( 'pos' => 78,	'len' => 1,	'fn'=>'Temp_HumAlarms',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'ExtraTemp/HumAlarms4'	=>	array( 'pos' => 79,	'len' => 1,	'fn'=>'Temp_HumAlarms',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'ExtraTemp/HumAlarms5'	=>	array( 'pos' => 80,	'len' => 1,	'fn'=>'Temp_HumAlarms',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'ExtraTemp/HumAlarms6'	=>	array( 'pos' => 81,	'len' => 1,	'fn'=>'Temp_HumAlarms',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'Soil&LeafAlarms0'	=>	array( 'pos' => 82,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'Soil&LeafAlarms1'	=>	array( 'pos' => 83,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'Soil&LeafAlarms2'	=>	array( 'pos' => 84,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// *	'Soil&LeafAlarms3'	=>	array( 'pos' => 85,	'len' => 1,	'fn'=>'s2uc',		'SI'=>NULL,'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
// 	'TransmitterBatteryStatus'=>	array( 'pos' => 86,	'len' => 1,	'fn'=>'',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'ConsoleBatteryVoltage'	=>	array( 'pos' => 87,	'len' => 2,	'fn'=>'Voltage',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'ForecastIcons'		=>	array( 'pos' => 89,	'len' => 1,	'fn'=>'Icons',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'ForecastRuleNumber'	=>	array( 'pos' => 90,	'len' => 1,	'fn'=>'Forecast',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfSunrise'		=>	array( 'pos' => 91,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfSunset'		=>	array( 'pos' => 93,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	);
?>