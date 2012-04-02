<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 24, 25,26)
/// 2. HILOW data format
/// The "HILOWS" command sends a 436 byte data packet and a 2 byte CRC value. The data packet is
/// broken up into sections of related data values.
// ##############################################################################################

	$this->HiLow = array (
	'DailyLowBarometer'	=>	array( 'pos' => 0,	'len' => 2,	'fn'=>'Pressure',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DailyHighBarometer'	=>	array( 'pos' => 2,	'len' => 2,	'fn'=>'Pressure',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthLowBar'		=>	array( 'pos' => 4,	'len' => 2,	'fn'=>'Pressure',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHighBar'		=>	array( 'pos' => 6,	'len' => 2,	'fn'=>'Pressure',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearLowBarometer'	=>	array( 'pos' => 8,	'len' => 2,	'fn'=>'Pressure',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHighBarometer'	=>	array( 'pos' => 10,	'len' => 2,	'fn'=>'Pressure',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfDayLowBar'	=>	array( 'pos' => 12,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfDayHighBar'	=>	array( 'pos' => 14,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DailyHiWindSpeed'	=>	array( 'pos' => 16,	'len' => 1,	'fn'=>'Speed',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfHiSpeed'		=>	array( 'pos' => 17,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHiWindSpeed'	=>	array( 'pos' => 19,	'len' => 1,	'fn'=>'Speed',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHiWindSpeed'	=>	array( 'pos' => 20,	'len' => 1,	'fn'=>'Speed',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHiInsideTemp'	=>	array( 'pos' => 21,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowInsideTemp'	=>	array( 'pos' => 23,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayHiInTemp'	=>	array( 'pos' => 25,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayLowInTemps'	=>	array( 'pos' => 27,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthLowInTemp'	=>	array( 'pos' => 29,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHiInTemp'		=>	array( 'pos' => 31,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearLowInTemp'		=>	array( 'pos' => 33,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHiInTemp'		=>	array( 'pos' => 35,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHiInHum'		=>	array( 'pos' => 37,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowInHum'		=>	array( 'pos' => 38,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayHiInHum'	=>	array( 'pos' => 39,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayLowInHum'	=>	array( 'pos' => 41,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHiInHum'		=>	array( 'pos' => 43,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthLowInHum'		=>	array( 'pos' => 44,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHiInHum'		=>	array( 'pos' => 45,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearLowInHum'		=>	array( 'pos' => 46,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowOutTemp'		=>	array( 'pos' => 47,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHiOutTemp'		=>	array( 'pos' => 49,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayLowOutTemp'	=>	array( 'pos' => 51,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayHiOutTemp'	=>	array( 'pos' => 53,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHiOutTemp'	=>	array( 'pos' => 55,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthLowOutTemp'	=>	array( 'pos' => 57,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YeahHiOutTemp'		=>	array( 'pos' => 59,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearLowOutTemp'	=>	array( 'pos' => 61,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowDewPoint'	=>	array( 'pos' => 63,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHiDewPoint'		=>	array( 'pos' => 65,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayLowDewPoint'	=>	array( 'pos' => 67,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayHiDewPoint'	=>	array( 'pos' => 69,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHiDewPoint'	=>	array( 'pos' => 71,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthLowDewPoint'	=>	array( 'pos' => 73,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHiDewPoint'	=>	array( 'pos' => 75,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearLowDewPoint'	=>	array( 'pos' => 77,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowWindChill'	=>	array( 'pos' => 79,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeDayLowChill'	=>	array( 'pos' => 81,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthLowWindChill'	=>	array( 'pos' => 83,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearLowWindChill'	=>	array( 'pos' => 85,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighHeat'		=>	array( 'pos' => 87,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfDayHighHeat'	=>	array( 'pos' => 89,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHighHeat'		=>	array( 'pos' => 91,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHighHeat'		=>	array( 'pos' => 93,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTHSW'		=>	array( 'pos' => 95,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfDayHighTHSW'	=>	array( 'pos' => 97,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHighTHSW'		=>	array( 'pos' => 99,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHighTHSW'		=>	array( 'pos' => 101,	'len' => 2,	'fn'=>'Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighSolarRad'	=>	array( 'pos' => 103,	'len' => 2,	'fn'=>'Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfDayHighSolar'	=>	array( 'pos' => 105,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHighSolarRad'	=>	array( 'pos' => 107,	'len' => 2,	'fn'=>'Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHighSolarRad'	=>	array( 'pos' => 109,	'len' => 2,	'fn'=>'Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighUV'		=>	array( 'pos' => 111,	'len' => 1,	'fn'=>'UV',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfDayHighUV'	=>	array( 'pos' => 112,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHighUV'		=>	array( 'pos' => 114,	'len' => 1,	'fn'=>'UV',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHighUV'		=>	array( 'pos' => 115,	'len' => 1,	'fn'=>'UV',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighRainRate'	=>	array( 'pos' => 116,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'TimeOfDayHighRainRate'	=>	array( 'pos' => 118,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'HourHighRainRate'	=>	array( 'pos' => 120,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'MonthHighRainRate'	=>	array( 'pos' => 122,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'YearHighRainRate'	=>	array( 'pos' => 124,	'len' => 2,	'fn'=>'Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** extra temperature ***********					///
	'DayLowTemperature.extra2'	=>	array( 'pos' => 126,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.extra3'	=>	array( 'pos' => 127,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.extra4'	=>	array( 'pos' => 128,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.extra5'	=>	array( 'pos' => 129,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.extra6'	=>	array( 'pos' => 130,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.extra7'	=>	array( 'pos' => 131,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.extra8'	=>	array( 'pos' => 132,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'DayLowTemperature.leaf1'	=>	array( 'pos' => 133,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.leaf2'	=>	array( 'pos' => 134,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.leaf3'	=>	array( 'pos' => 135,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.leaf4'	=>	array( 'pos' => 136,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'DayLowTemperature.soil1'	=>	array( 'pos' => 137,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.soil2'	=>	array( 'pos' => 138,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.soil3'	=>	array( 'pos' => 139,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowTemperature.soil4'	=>	array( 'pos' => 140,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	
	'DayHighTemperature.extra2'	=>	array( 'pos' => 141,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.extra3'	=>	array( 'pos' => 142,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.extra4'	=>	array( 'pos' => 143,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.extra5'	=>	array( 'pos' => 144,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.extra6'	=>	array( 'pos' => 145,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.extra7'	=>	array( 'pos' => 146,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.extra8'	=>	array( 'pos' => 147,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'DayHighTemperature.leaf1'	=>	array( 'pos' => 148,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.leaf2'	=>	array( 'pos' => 149,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.leaf3'	=>	array( 'pos' => 150,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.leaf4'	=>	array( 'pos' => 151,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'DayHighTemperature.soil1'	=>	array( 'pos' => 152,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.soil2'	=>	array( 'pos' => 153,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.soil3'	=>	array( 'pos' => 154,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayHighTemperature.soil4'	=>	array( 'pos' => 155,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	
	'TimeDayLowTemperature'		=>	array( 'pos' => 156,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	
	'TimeDayHiTemperature'		=>	array( 'pos' => 186,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	
	'MonthHiTemperature'		=>	array( 'pos' => 216,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	
	'MonthLowTemperature'		=>	array( 'pos' => 231,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	
	'YearHiTemperature'		=>	array( 'pos' => 246,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'YearLowTemperature'		=>	array( 'pos' => 261,	'len' => 1,	'fn'=>'SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** extra Humidity ***********						///
	'DayLowHumidity.Out'		=>	array( 'pos' => 276,	'len' => 1,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowHumidity.extra2' 	=>	array( 'pos' => 277,	'len' => 1,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowHumidity.extra3' 	=>	array( 'pos' => 278,	'len' => 1,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowHumidity.extra4' 	=>	array( 'pos' => 279,	'len' => 1,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowHumidity.extra5' 	=>	array( 'pos' => 280,	'len' => 1,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowHumidity.extra6' 	=>	array( 'pos' => 281,	'len' => 1,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowHumidity.extra7' 	=>	array( 'pos' => 282,	'len' => 1,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	'DayLowHumidity.extra8' 	=>	array( 'pos' => 283,	'len' => 1,	'fn'=>'Rate',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'DayHiHumidity'		=>	array( 'pos' => 284,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'TimeDayLowHumidity'	=>	array( 'pos' => 300,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),

	'TimeDayHiHumidity'	=>	array( 'pos' => 316,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>255,	'unit'=> ''	),

	'MonthHiHumidity'	=>	array( 'pos' => 324,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'MonthLowHumidity'	=>	array( 'pos' => 332,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'YearHiHumidity'	=>	array( 'pos' => 340,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

	'YearLowHumidity'	=>	array( 'pos' => 348,	'len' => 1,	'fn'=>'Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> ''	),

///						*********** soil moisture ***********						///
	'DayHiSoilMoisture'	=>	array( 'pos' => 356,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TimeDayHiSoilMoisture'	=>	array( 'pos' => 360,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'DayLowSoilMoisture'	=>	array( 'pos' => 368,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TimeDayLowSoilMoisture'=>	array( 'pos' => 372,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'MonthLowSoilMoisture'	=>	array( 'pos' => 380,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'MonthHiSoilMoisture'	=>	array( 'pos' => 384,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'YearLowSoilMoisture'	=>	array( 'pos' => 388,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'YearHiSoilMoisture'	=>	array( 'pos' => 392,	'len' => 1,	'fn'=>'Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

///						*********** leaf Wetness ***********						///
	'DayHiLeafWetness'	=>	array( 'pos' => 496,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TimeDayHiLeafWetness'	=>	array( 'pos' => 500,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'DayLowLeafWetness'	=>	array( 'pos' => 508,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'TimeDayLowLeafWetness'	=>	array( 'pos' => 512,	'len' => 2,	'fn'=>'Raw2Time',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'MonthLowLeafWetness'	=>	array( 'pos' => 520,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'MonthHiLeafWetness'	=>	array( 'pos' => 524,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'YearLowLeafWetness'	=>	array( 'pos' => 528,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),

	'YearHiLeafWetness'	=>	array( 'pos' => 532,	'len' => 1,	'fn'=>'Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	
// 	'CRC'			=>	array( 'pos' => 536,	'len' => 2,	'fn'=>'crc',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> ''	),
	);
?>