<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 24, 25,26)
/// 2. HILOW data format
/// The "HILOWS" command sends a 436 byte data packet and a 2 byte CRC value. The data packet is
/// broken up into sections of related data values.
// ##############################################################################################

	$this->HiLows = array (
	'No:Current:Various:Bar:DailyLow'               =>	array( 'pos' => 0,      'len' => 2,	'fn'=>'_0001',      'SI'=>'inHg2hPa',         'min'=>25,      'max'=>33,	'err'=>0,       'unit'=> 'in.Hg'),
	'No:Current:Various:Bar:DailyHigh'              =>	array( 'pos' => 2,      'len' => 2,	'fn'=>'_0001',      'SI'=>'inHg2hPa',         'min'=>25,      'max'=>33,	'err'=>0,       'unit'=> 'in.Hg'),
	'No:Current:Various:Bar:MonthLow'               =>	array( 'pos' => 4,      'len' => 2,	'fn'=>'_0001',      'SI'=>'inHg2hPa',         'min'=>25,      'max'=>33,	'err'=>0,       'unit'=> 'in.Hg'),
	'No:Current:Various:Bar:MonthHigh'              =>	array( 'pos' => 6,      'len' => 2,	'fn'=>'_0001',      'SI'=>'inHg2hPa',         'min'=>25,      'max'=>33,	'err'=>0,       'unit'=> 'in.Hg'),
	'No:Current:Various:Bar:YearLow'                =>	array( 'pos' => 8,      'len' => 2,	'fn'=>'_0001',      'SI'=>'inHg2hPa',         'min'=>25,      'max'=>33,	'err'=>0,       'unit'=> 'in.Hg'),
	'No:Current:Various:Bar:YearHigh'               =>	array( 'pos' => 10,     'len' => 2,	'fn'=>'_0001',      'SI'=>'inHg2hPa',         'min'=>25,      'max'=>33,	'err'=>0,       'unit'=> 'in.Hg'),
	'No:Current:Various:Bar:TimeDailyLow'           =>	array( 'pos' => 12,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Various:Bar:TimeDailyHigh'          =>	array( 'pos' => 14,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),

    'No:Current:Various:Wind:DailyHighSpeed'        =>	array( 'pos' => 16,     'len' => 1,	'fn'=>'hexToDec',   'SI'=>'MPH2SI',       'min'=>0,       'max'=>160,	'err'=>0,       'unit'=> 'mph'),
	'No:Current:Various:Wind:TimeDailyHighSpeed'    =>	array( 'pos' => 17,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Various:Wind:MonthHighSpeed'        =>	array( 'pos' => 19,     'len' => 1,	'fn'=>'hexToDec',   'SI'=>'MPH2SI',       'min'=>0,       'max'=>160,	'err'=>0,       'unit'=> 'mph'),
	'No:Current:Various:Wind:YearHighSpeed'         =>	array( 'pos' => 20,     'len' => 1,	'fn'=>'hexToDec',   'SI'=>'MPH2SI',       'min'=>0,       'max'=>160,	'err'=>0,       'unit'=> 'mph'),

    'No:Current:Temp:In:DailyHigh'                  =>	array( 'pos' => 21,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>30,      'max'=>150,	'err'=>255,     'unit'=> '°F'),
    'No:Current:Temp:In:DailyLow'                   =>	array( 'pos' => 23,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>30,      'max'=>150,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:In:TimeDailyHigh'              =>	array( 'pos' => 25,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:In:TimeDailyLow'               =>	array( 'pos' => 27,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:In:MonthLow'                   =>	array( 'pos' => 29,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>30,      'max'=>150,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:In:MonthHigh'                  =>	array( 'pos' => 31,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>30,      'max'=>150,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:In:YearLow'                    =>	array( 'pos' => 33,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>30,      'max'=>150,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:In:YearHigh'                   =>	array( 'pos' => 35,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>30,      'max'=>150,	'err'=>255,     'unit'=> '°F'),

    'No:Current:Hum:In:DailyHigh'                   =>	array( 'pos' => 37,     'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:In:DailyLow'                    =>	array( 'pos' => 38,     'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:In:TimeDailyHigh'               =>	array( 'pos' => 39,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:In:TimeDailyLow'                =>	array( 'pos' => 41,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:In:MonthHigh'                   =>	array( 'pos' => 43,     'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:In:MonthLow'                    =>	array( 'pos' => 44,     'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:In:YearHigh'                    =>	array( 'pos' => 45,     'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:In:YearLow'                     =>	array( 'pos' => 46,     'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

    'No:Current:Temp:Out:DailyLow'                  =>	array( 'pos' => 47,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out:DailyHigh'                 =>	array( 'pos' => 49,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out:TimeDailyLow'              =>	array( 'pos' => 51,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out:TimeDailyHigh'             =>	array( 'pos' => 53,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out:MonthHigh'                 =>	array( 'pos' => 55,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out:MonthLow'                  =>	array( 'pos' => 57,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out:YeahHigh'                  =>	array( 'pos' => 59,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out:YearLow'                   =>	array( 'pos' => 61,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

    'No:Current:Temp:DewPoint:DailyLow'             =>	array( 'pos' => 63,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-115,    'max'=>140,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:DewPoint:DaylyHigh'            =>	array( 'pos' => 65,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-115,    'max'=>140,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:DewPoint:TimeDailyLow'         =>	array( 'pos' => 67,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:DewPoint:TimeDailyHigh'        =>	array( 'pos' => 69,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:DewPoint:MonthHigh'            =>	array( 'pos' => 71,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-115,    'max'=>140,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:DewPoint:MonthLow'             =>	array( 'pos' => 73,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-115,    'max'=>140,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:DewPoint:YearHigh'             =>	array( 'pos' => 75,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-115,    'max'=>140,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:DewPoint:YearLow'              =>	array( 'pos' => 77,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-115,    'max'=>140,	'err'=>255,     'unit'=> '°F'),

    'No:Current:Temp:WindChill:DailyLow'            =>	array( 'pos' => 79,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-100,    'max'=>145,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:WindChill:TimeDailyLow'        =>	array( 'pos' => 81,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:WindChill:MonthLow'            =>	array( 'pos' => 83,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-100,    'max'=>145,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:WindChill:YearLow'             =>	array( 'pos' => 85,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-100,    'max'=>145,	'err'=>255,     'unit'=> '°F'),

    'No:Current:Temp:HeatIndex:DailyHigh'           =>	array( 'pos' => 87,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-50,     'max'=>145,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:HeatIndex:TimeDailyHigh'       =>	array( 'pos' => 89,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:HeatIndex:MonthHigh'           =>	array( 'pos' => 91,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-50,     'max'=>145,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:HeatIndex:YearHigh'            =>	array( 'pos' => 93,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-50,     'max'=>145,	'err'=>255,     'unit'=> '°F'),

    'No:Current:Temp:THSW:DailyHigh'                =>	array( 'pos' => 95,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-130,    'max'=>140,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:THSW:TimeDailyHigh'            =>	array( 'pos' => 97,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:THSW:MonthHigh'                =>	array( 'pos' => 99,     'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-130,    'max'=>140,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:THSW:YearHigh'                 =>	array( 'pos' => 101,	'len' => 2,	'fn'=>'sSht_01',    'SI'=>'F2kelvin',         'min'=>-130,    'max'=>140,	'err'=>255,     'unit'=> '°F'),

    'No:Current:Various:Solar:DailyHighRadiation'   =>	array( 'pos' => 103,	'len' => 2,	'fn'=>'s2sSht',     'SI'=>NULL,               'min'=>0,       'max'=>1810,'err'=>255,     'unit'=> 'W/m²'),
	'No:Current:Various:Solar:TimeDailyHighRadiation'=>	array( 'pos' => 105,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Various:Solar:MonthHighRadiation'   =>	array( 'pos' => 107,	'len' => 2,	'fn'=>'s2sSht',     'SI'=>NULL,               'min'=>0,       'max'=>1810,'err'=>255,     'unit'=> 'W/m²'),
	'No:Current:Various:Solar:YearHighRadiation'    =>	array( 'pos' => 109,	'len' => 2,	'fn'=>'s2sSht',     'SI'=>NULL,               'min'=>0,       'max'=>1810,'err'=>255,     'unit'=> 'W/m²'),

    'No:Current:Various:UV:DailyHigh'               =>	array( 'pos' => 111,	'len' => 1,	'fn'=>'UV',         'SI'=>NULL,               'min'=>0,       'max'=>17,	'err'=>255,     'unit'=> '-'	),
	'No:Current:Various:UV:TimeDailyHigh'           =>	array( 'pos' => 112,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Various:UV:MonthHigh'               =>	array( 'pos' => 114,	'len' => 1,	'fn'=>'UV',         'SI'=>NULL,               'min'=>0,       'max'=>17,	'err'=>255,     'unit'=> '-'	),
	'No:Current:Various:UV:YearHigh'                =>	array( 'pos' => 115,	'len' => 1,	'fn'=>'UV',         'SI'=>NULL,               'min'=>0,       'max'=>17,	'err'=>255,     'unit'=> '-'	),

    'No:Current:Rain:RainRate:DailyHigh'            =>	array( 'pos' => 116,	'len' => 2,	'fn'=>'s2uSht',     'SI'=>'RainSample2mm',    'min'=>0,       'max'=>900,	'err'=>0,       'unit'=> 'clic/h'),
	'No:Current:Rain:RainRate:TimeDailyHigh'        =>	array( 'pos' => 118,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Rain:RainRate:HourHigh'             =>	array( 'pos' => 120,	'len' => 2,	'fn'=>'Raw2Time',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Rain:RainRate:MonthHigh'            =>	array( 'pos' => 122,	'len' => 2,	'fn'=>'s2uSht',     'SI'=>'RainSample2mm',    'min'=>0,       'max'=>900,	'err'=>0,       'unit'=> 'clic/h'),
	'No:Current:Rain:RainRate:YearHigh'             =>	array( 'pos' => 124,	'len' => 2,	'fn'=>'s2uSht',     'SI'=>'RainSample2mm',    'min'=>0,       'max'=>900,	'err'=>0,       'unit'=> 'clic/h'),

///						*********** extra temperature ***********					///
	'No:Current:Temp:Out#2:DailyLow'                =>	array( 'pos' => 126,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#3:DailyLow'                =>	array( 'pos' => 127,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#4:DailyLow'                =>	array( 'pos' => 128,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#5:DailyLow'                =>	array( 'pos' => 129,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#6:DailyLow'                =>	array( 'pos' => 130,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#7:DailyLow'                =>	array( 'pos' => 131,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#8:DailyLow'                =>	array( 'pos' => 132,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

	'No:Current:Temp:Leaf#1:DailyLow'               =>	array( 'pos' => 133,    'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#2:DailyLow'               =>	array( 'pos' => 134,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#3:DailyLow'               =>	array( 'pos' => 135,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#4:DailyLow'               =>	array( 'pos' => 136,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

	'No:Current:Temp:Soil#1:DailyLow'               =>	array( 'pos' => 137,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#2:DailyLow'               =>	array( 'pos' => 138,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#3:DailyLow'               =>	array( 'pos' => 139,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#4:DailyLow'               =>	array( 'pos' => 140,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),


	'No:Current:Temp:Out#2:DailyHigh'               =>	array( 'pos' => 141,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#3:DailyHigh'               =>	array( 'pos' => 142,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#4:DailyHigh'               =>	array( 'pos' => 143,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#5:DailyHigh'               =>	array( 'pos' => 144,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#6:DailyHigh'               =>	array( 'pos' => 145,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#7:DailyHigh'               =>	array( 'pos' => 146,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#8:DailyHigh'               =>	array( 'pos' => 147,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

	'No:Current:Temp:Leaf#1:DailyHigh'              =>	array( 'pos' => 148,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#2:DailyHigh'              =>	array( 'pos' => 149,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#3:DailyHigh'              =>	array( 'pos' => 150,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#4:DailyHigh'              =>	array( 'pos' => 151,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

	'No:Current:Temp:Soil#1:DailyHigh'              =>	array( 'pos' => 152,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#2:DailyHigh'              =>	array( 'pos' => 153,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#3:DailyHigh'              =>	array( 'pos' => 154,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#4:DailyHigh'              =>	array( 'pos' => 155,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),


	'No:Current:Temp:Out#2:TimeDailyLow'            =>	array( 'pos' => 156,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out#3:TimeDailyLow'            =>	array( 'pos' => 158,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out#4:TimeDailyLow'            =>	array( 'pos' => 160,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out#5:TimeDailyLow'            =>	array( 'pos' => 162,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out#6:TimeDailyLow'            =>	array( 'pos' => 164,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out#7:TimeDailyLow'            =>	array( 'pos' => 166,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out#8:TimeDailyLow'            =>	array( 'pos' => 168,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),

	'No:Current:Temp:Leaf#1:TimeDailyLow'            =>	array( 'pos' => 170,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Leaf#2:TimeDailyLow'            =>	array( 'pos' => 172,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Leaf#3:TimeDailyLow'            =>	array( 'pos' => 174,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Leaf#4:TimeDailyLow'            =>	array( 'pos' => 176,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),

	'No:Current:Temp:Soil#1:TimeDailyLow'            =>	array( 'pos' => 178,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Soil#2:TimeDailyLow'            =>	array( 'pos' => 180,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Soil#3:TimeDailyLow'            =>	array( 'pos' => 182,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Soil#4:TimeDailyLow'            =>	array( 'pos' => 184,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),


	'No:Current:Temp:Out#2:TimeDailyHigh'           =>	array( 'pos' => 186,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out#3:TimeDailyHigh'           =>	array( 'pos' => 188,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out#4:TimeDailyHigh'           =>	array( 'pos' => 190,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out#5:TimeDailyHigh'           =>	array( 'pos' => 192,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out#6:TimeDailyHigh'           =>	array( 'pos' => 194,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out#7:TimeDailyHigh'           =>	array( 'pos' => 196,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out#8:TimeDailyHigh'           =>	array( 'pos' => 198,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),

	'No:Current:Temp:Leaf#1:TimeDailyHigh'           =>	array( 'pos' => 200,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Leaf#2:TimeDailyHigh'           =>	array( 'pos' => 202,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Leaf#3:TimeDailyHigh'           =>	array( 'pos' => 204,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Leaf#4:TimeDailyHigh'           =>	array( 'pos' => 206,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),

	'No:Current:Temp:Soil#1:TimeDailyHigh'           =>	array( 'pos' => 208,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Soil#2:TimeDailyHigh'           =>	array( 'pos' => 210,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Soil#3:TimeDailyHigh'           =>	array( 'pos' => 212,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Soil#4:TimeDailyHigh'           =>	array( 'pos' => 214,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),


	'No:Current:Temp:Out#2:MonthHigh'               =>	array( 'pos' => 216,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#3:MonthHigh'               =>	array( 'pos' => 217,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#4:MonthHigh'               =>	array( 'pos' => 218,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#5:MonthHigh'               =>	array( 'pos' => 219,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#6:MonthHigh'               =>	array( 'pos' => 220,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#7:MonthHigh'               =>	array( 'pos' => 221,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#8:MonthHigh'               =>	array( 'pos' => 222,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

	'No:Current:Temp:Leaf#1:MonthHigh'               =>	array( 'pos' => 223,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#2:MonthHigh'               =>	array( 'pos' => 224,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#3:MonthHigh'               =>	array( 'pos' => 225,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#4:MonthHigh'               =>	array( 'pos' => 226,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

	'No:Current:Temp:Soil#1:MonthHigh'               =>	array( 'pos' => 227,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#2:MonthHigh'               =>	array( 'pos' => 228,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#3:MonthHigh'               =>	array( 'pos' => 229,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#4:MonthHigh'               =>	array( 'pos' => 230,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),


	'No:Current:Temp:Out#2:MonthLow'                =>	array( 'pos' => 231,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#3:MonthLow'                =>	array( 'pos' => 232,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#4:MonthLow'                =>	array( 'pos' => 233,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#5:MonthLow'                =>	array( 'pos' => 234,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#6:MonthLow'                =>	array( 'pos' => 235,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#7:MonthLow'                =>	array( 'pos' => 236,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#8:MonthLow'                =>	array( 'pos' => 237,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

	'No:Current:Temp:Leaf#1:MonthLow'                =>	array( 'pos' => 238,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#2:MonthLow'                =>	array( 'pos' => 239,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#3:MonthLow'                =>	array( 'pos' => 240,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#4:MonthLow'                =>	array( 'pos' => 241,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

	'No:Current:Temp:Soil#1:MonthLow'                =>	array( 'pos' => 242,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#2:MonthLow'                =>	array( 'pos' => 243,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#3:MonthLow'                =>	array( 'pos' => 244,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#4:MonthLow'                =>	array( 'pos' => 245,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),


	'No:Current:Temp:Out#2:YearHigh'                =>	array( 'pos' => 246,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#3:YearHigh'                =>	array( 'pos' => 247,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#4:YearHigh'                =>	array( 'pos' => 248,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#5:YearHigh'                =>	array( 'pos' => 249,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#6:YearHigh'                =>	array( 'pos' => 250,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#7:YearHigh'                =>	array( 'pos' => 251,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#8:YearHigh'                =>	array( 'pos' => 252,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

	'No:Current:Temp:Leaf#1:YearHigh'                =>	array( 'pos' => 253,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#2:YearHigh'                =>	array( 'pos' => 254,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#3:YearHigh'                =>	array( 'pos' => 255,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#4:YearHigh'                =>	array( 'pos' => 256,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

	'No:Current:Temp:Soil#1:YearHigh'                =>	array( 'pos' => 257,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#2:YearHigh'                =>	array( 'pos' => 258,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#3:YearHigh'                =>	array( 'pos' => 259,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#4:YearHigh'                =>	array( 'pos' => 260,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),


	'No:Current:Temp:Out#2:YearLow'                 =>	array( 'pos' => 261,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#3:YearLow'                 =>	array( 'pos' => 262,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#4:YearLow'                 =>	array( 'pos' => 263,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#5:YearLow'                 =>	array( 'pos' => 264,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#6:YearLow'                 =>	array( 'pos' => 265,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#7:YearLow'                 =>	array( 'pos' => 266,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#8:YearLow'                 =>	array( 'pos' => 267,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

	'No:Current:Temp:Leaf#1:YearLow'                 =>	array( 'pos' => 268,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#2:YearLow'                 =>	array( 'pos' => 269,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#3:YearLow'                 =>	array( 'pos' => 270,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Leaf#4:YearLow'                 =>	array( 'pos' => 271,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

	'No:Current:Temp:Soil#1:YearLow'                 =>	array( 'pos' => 272,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#2:YearLow'                 =>	array( 'pos' => 273,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#3:YearLow'                 =>	array( 'pos' => 274,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Soil#4:YearLow'                 =>	array( 'pos' => 275,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

///						*********** extra Humidity ***********						///
	'No:Current:Hum:Out:DailyLow'                   =>	array( 'pos' => 276,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#2:DailyLow'                 =>	array( 'pos' => 277,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#3:DailyLow'                 =>	array( 'pos' => 278,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#4:DailyLow'                 =>	array( 'pos' => 279,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#5:DailyLow'                 =>	array( 'pos' => 280,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#6:DailyLow'                 =>	array( 'pos' => 281,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#7:DailyLow'                 =>	array( 'pos' => 282,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#8:DailyLow'                 =>	array( 'pos' => 283,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:Hum:Out:DailyHigh'                =>	array( 'pos' => 284,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#2:DailyHigh'                =>	array( 'pos' => 285,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#3:DailyHigh'                =>	array( 'pos' => 286,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#4:DailyHigh'                =>	array( 'pos' => 287,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#5:DailyHigh'                =>	array( 'pos' => 288,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#6:DailyHigh'                =>	array( 'pos' => 289,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#7:DailyHigh'                =>	array( 'pos' => 290,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#8:DailyHigh'                =>	array( 'pos' => 291,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:Hum:Out:TimeDailyLow'             =>	array( 'pos' => 292,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#2:TimeDailyLow'             =>	array( 'pos' => 294,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#3:TimeDailyLow'             =>	array( 'pos' => 296,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#4:TimeDailyLow'             =>	array( 'pos' => 298,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#5:TimeDailyLow'             =>	array( 'pos' => 300,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#6:TimeDailyLow'             =>	array( 'pos' => 302,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#7:TimeDailyLow'             =>	array( 'pos' => 304,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#8:TimeDailyLow'             =>	array( 'pos' => 306,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),

	'No:Current:Hum:Out:TimeDailyHigh'            =>	array( 'pos' => 308,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#2:TimeDailyHigh'            =>	array( 'pos' => 310,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#3:TimeDailyHigh'            =>	array( 'pos' => 312,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#4:TimeDailyHigh'            =>	array( 'pos' => 314,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#5:TimeDailyHigh'            =>	array( 'pos' => 316,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#6:TimeDailyHigh'            =>	array( 'pos' => 318,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#7:TimeDailyHigh'            =>	array( 'pos' => 320,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#8:TimeDailyHigh'            =>	array( 'pos' => 322,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),

	'No:Current:Hum:Out:MonthHigh'                =>	array( 'pos' => 324,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#2:MonthHigh'                =>	array( 'pos' => 325,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#3:MonthHigh'                =>	array( 'pos' => 326,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#4:MonthHigh'                =>	array( 'pos' => 327,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#5:MonthHigh'                =>	array( 'pos' => 328,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#6:MonthHigh'                =>	array( 'pos' => 329,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#7:MonthHigh'                =>	array( 'pos' => 330,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#8:MonthHigh'                =>	array( 'pos' => 331,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:Hum:Out:MonthLow'                 =>	array( 'pos' => 332,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#2:MonthLow'                 =>	array( 'pos' => 333,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#3:MonthLow'                 =>	array( 'pos' => 334,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#4:MonthLow'                 =>	array( 'pos' => 335,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#5:MonthLow'                 =>	array( 'pos' => 336,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#6:MonthLow'                 =>	array( 'pos' => 337,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#7:MonthLow'                 =>	array( 'pos' => 338,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#8:MonthLow'                 =>	array( 'pos' => 339,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:Hum:Out:YearHigh'                 =>	array( 'pos' => 340,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#2:YearHigh'                 =>	array( 'pos' => 341,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#3:YearHigh'                 =>	array( 'pos' => 342,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#4:YearHigh'                 =>	array( 'pos' => 343,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#5:YearHigh'                 =>	array( 'pos' => 344,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#6:YearHigh'                 =>	array( 'pos' => 345,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#7:YearHigh'                 =>	array( 'pos' => 346,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#8:YearHigh'                 =>	array( 'pos' => 347,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:Hum:Out:YearLow'                  =>	array( 'pos' => 348,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#2:YearLow'                  =>	array( 'pos' => 349,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#3:YearLow'                  =>	array( 'pos' => 350,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#4:YearLow'                  =>	array( 'pos' => 351,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#5:YearLow'                  =>	array( 'pos' => 352,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#6:YearLow'                  =>	array( 'pos' => 353,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#7:YearLow'                  =>	array( 'pos' => 354,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#8:YearLow'                  =>	array( 'pos' => 355,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

///						*********** soil moisture ***********						///

	'No:Current:SoilMoisture:Soil#1:DailyHigh'        =>	array( 'pos' => 356,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#2:DailyHigh'        =>	array( 'pos' => 357,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#3:DailyHigh'        =>	array( 'pos' => 358,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#4:DailyHigh'        =>	array( 'pos' => 359,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:SoilMoisture:Soil#1:TimeDailyHigh'    =>	array( 'pos' => 360,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:SoilMoisture:Soil#2:TimeDailyHigh'    =>	array( 'pos' => 362,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:SoilMoisture:Soil#3:TimeDailyHigh'    =>	array( 'pos' => 364,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:SoilMoisture:Soil#4:TimeDailyHigh'    =>	array( 'pos' => 366,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),

	'No:Current:SoilMoisture:Soil#1:DailyLow'         =>	array( 'pos' => 368,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#2:DailyLow'         =>	array( 'pos' => 369,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#3:DailyLow'         =>	array( 'pos' => 370,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#4:DailyLow'         =>	array( 'pos' => 371,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:SoilMoisture:Soil#1:TimeDailyLow'     =>	array( 'pos' => 372,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:SoilMoisture:Soil#2:TimeDailyLow'     =>	array( 'pos' => 374,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:SoilMoisture:Soil#3:TimeDailyLow'     =>	array( 'pos' => 376,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:SoilMoisture:Soil#4:TimeDailyLow'     =>	array( 'pos' => 378,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),

	'No:Current:SoilMoisture:Soil#1:MonthLow'         =>	array( 'pos' => 380,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#2:MonthLow'         =>	array( 'pos' => 381,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#3:MonthLow'         =>	array( 'pos' => 382,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#4:MonthLow'         =>	array( 'pos' => 383,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:SoilMoisture:Soil#1:MonthHigh'        =>	array( 'pos' => 384,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#2:MonthHigh'        =>	array( 'pos' => 385,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#3:MonthHigh'        =>	array( 'pos' => 386,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#4:MonthHigh'        =>	array( 'pos' => 387,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:SoilMoisture:Soil#1:YearLow'          =>	array( 'pos' => 388,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#2:YearLow'          =>	array( 'pos' => 389,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#3:YearLow'          =>	array( 'pos' => 390,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#4:YearLow'          =>	array( 'pos' => 391,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:SoilMoisture:Soil#1:YearHigh'         =>	array( 'pos' => 392,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#2:YearHigh'         =>	array( 'pos' => 393,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#3:YearHigh'         =>	array( 'pos' => 394,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil#4:YearHigh'         =>	array( 'pos' => 395,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

///						*********** leaf Wetness ***********						///
	'No:Current:LeafWetnesses:Leaf#1:DailyHigh'       =>	array( 'pos' => 396,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#2:DailyHigh'       =>	array( 'pos' => 397,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#3:DailyHigh'       =>	array( 'pos' => 398,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#4:DailyHigh'       =>	array( 'pos' => 399,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:LeafWetnesses:Leaf#1:TimeDailyHigh'   =>	array( 'pos' => 400,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,     'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:LeafWetnesses:Leaf#2:TimeDailyHigh'   =>	array( 'pos' => 402,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,     'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:LeafWetnesses:Leaf#3:TimeDailyHigh'   =>	array( 'pos' => 404,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,     'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:LeafWetnesses:Leaf#4:TimeDailyHigh'   =>	array( 'pos' => 406,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,     'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),

	'No:Current:LeafWetnesses:Leaf#1:DailyLow'        =>	array( 'pos' => 408,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#2:DailyLow'        =>	array( 'pos' => 409,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#3:DailyLow'        =>	array( 'pos' => 410,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#4:DailyLow'        =>	array( 'pos' => 411,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:LeafWetnesses:Leaf#1:TimeDailyLow'    =>	array( 'pos' => 412,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,     'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:LeafWetnesses:Leaf#2:TimeDailyLow'    =>	array( 'pos' => 414,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,     'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:LeafWetnesses:Leaf#3:TimeDailyLow'    =>	array( 'pos' => 416,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,     'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:LeafWetnesses:Leaf#4:TimeDailyLow'    =>	array( 'pos' => 418,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,     'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),

	'No:Current:LeafWetnesses:Leaf#1:MonthLow'        =>	array( 'pos' => 420,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#2:MonthLow'        =>	array( 'pos' => 421,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#3:MonthLow'        =>	array( 'pos' => 422,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#4:MonthLow'        =>	array( 'pos' => 423,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:LeafWetnesses:Leaf#1:MonthHigh'       =>	array( 'pos' => 424,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#2:MonthHigh'       =>	array( 'pos' => 425,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#3:MonthHigh'       =>	array( 'pos' => 426,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#4:MonthHigh'       =>	array( 'pos' => 427,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:LeafWetnesses:Leaf#1:YearLow'         =>	array( 'pos' => 428,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#2:YearLow'         =>	array( 'pos' => 429,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#3:YearLow'         =>	array( 'pos' => 430,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#4:YearLow'         =>	array( 'pos' => 431,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:LeafWetnesses:Leaf#1:YearHigh'        =>	array( 'pos' => 432,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#2:YearHigh'        =>	array( 'pos' => 433,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#3:YearHigh'        =>	array( 'pos' => 434,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf#4:YearHigh'        =>	array( 'pos' => 435,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	
// 	'CRC'                       =>	array( 'pos' => 436,	'len' => 2,	'fn'=>'crc',		      'SI'=>NULL,         'min'=>0,       'max'=>0xFF,	'err'=>255,     'unit'=> ''	),
	);
?>