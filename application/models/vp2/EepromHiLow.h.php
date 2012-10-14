<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 24, 25,26)
/// 2. HILOW data format
/// The "HILOWS" command sends a 436 byte data packet and a 2 byte CRC value. The data packet is
/// broken up into sections of related data values.
// ##############################################################################################

	$this->HiLow = array (
	'No:Current:Various:Bar:DailyLow'               =>	array( 'pos' => 0,      'len' => 2,	'fn'=>'_0001',      'SI'=>'inHg2hPa',         'min'=>25,      'max'=>33,	'err'=>0,       'unit'=> 'in.Hg'),
	'No:Current:Various:Bar:DailyHigh'              =>	array( 'pos' => 2,      'len' => 2,	'fn'=>'_0001',      'SI'=>'inHg2hPa',         'min'=>25,      'max'=>33,	'err'=>0,       'unit'=> 'in.Hg'),
	'No:Current:Various:Bar:MonthLow'               =>	array( 'pos' => 4,      'len' => 2,	'fn'=>'_0001',      'SI'=>'inHg2hPa',         'min'=>25,      'max'=>33,	'err'=>0,       'unit'=> 'in.Hg'),
	'No:Current:Various:Bar:MonthHigh'              =>	array( 'pos' => 6,      'len' => 2,	'fn'=>'_0001',      'SI'=>'inHg2hPa',         'min'=>25,      'max'=>33,	'err'=>0,       'unit'=> 'in.Hg'),
	'No:Current:Various:Bar:YearLow'                =>	array( 'pos' => 8,      'len' => 2,	'fn'=>'_0001',      'SI'=>'inHg2hPa',         'min'=>25,      'max'=>33,	'err'=>0,       'unit'=> 'in.Hg'),
	'No:Current:Various:Bar:YearHigh'               =>	array( 'pos' => 10,     'len' => 2,	'fn'=>'_0001',      'SI'=>'inHg2hPa',         'min'=>25,      'max'=>33,	'err'=>0,       'unit'=> 'in.Hg'),
	'No:Current:Various:Bar:TimeDailyLow'           =>	array( 'pos' => 12,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Various:Bar:TimeDailyHigh'          =>	array( 'pos' => 14,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),

    'No:Current:Various:Wind:DailyHighSpeed'        =>	array( 'pos' => 16,     'len' => 1,	'fn'=>'hexToDec',   'SI'=>'mph2mBySec',       'min'=>0,       'max'=>160,	'err'=>0,       'unit'=> 'mph'),
	'No:Current:Various:Wind:TimeDailyHighSpeed'    =>	array( 'pos' => 17,     'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Various:Wind:MonthHighSpeed'        =>	array( 'pos' => 19,     'len' => 1,	'fn'=>'hexToDec',   'SI'=>'mph2mBySec',       'min'=>0,       'max'=>160,	'err'=>0,       'unit'=> 'mph'),
	'No:Current:Various:Wind:YearHighSpeed'         =>	array( 'pos' => 20,     'len' => 1,	'fn'=>'hexToDec',   'SI'=>'mph2mBySec',       'min'=>0,       'max'=>160,	'err'=>0,       'unit'=> 'mph'),

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
	'No:Current:Rain:RainRate:YearHigh'             =>	array( 'pos' => 124,	'len' => 2,	's2uSht',           'SI'=>'RainSample2mm',    'min'=>0,       'max'=>900,	'err'=>0,       'unit'=> 'clic/h'),

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
	
	'No:Current:Temp:Out#x:TimeDailyLow'            =>	array( 'pos' => 156,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out#x:TimeDailyHigh'           =>	array( 'pos' => 186,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Temp:Out#x:MonthHigh'               =>	array( 'pos' => 216,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#x:MonthLow'                =>	array( 'pos' => 231,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#x:YearHigh'                =>	array( 'pos' => 246,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),
	'No:Current:Temp:Out#x:YearLow'                 =>	array( 'pos' => 261,	'len' => 1,	'fn'=>'SmallTemp',  'SI'=>'F2kelvin',         'min'=>-50,     'max'=>160,	'err'=>255,     'unit'=> '°F'),

///						*********** extra Humidity ***********						///
	'No:Current:Hum:Out:DailyLow'                   =>	array( 'pos' => 276,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#2:DailyLow'                 =>	array( 'pos' => 277,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#3:DailyLow'                 =>	array( 'pos' => 278,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#4:DailyLow'                 =>	array( 'pos' => 279,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#5:DailyLow'                 =>	array( 'pos' => 280,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#6:DailyLow'                 =>	array( 'pos' => 281,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#7:DailyLow'                 =>	array( 'pos' => 282,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#8:DailyLow'                 =>	array( 'pos' => 283,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

	'No:Current:Hum:Out#x:DailyHigh'                =>	array( 'pos' => 284,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#x:TimeDailyLow'             =>	array( 'pos' => 300,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#x:TimeDailyHigh'            =>	array( 'pos' => 316,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:Hum:Out#x:MonthHigh'                =>	array( 'pos' => 324,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#x:MonthLow'                 =>	array( 'pos' => 332,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#x:YearHigh'                 =>	array( 'pos' => 340,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:Hum:Out#x:YearLow'                  =>	array( 'pos' => 348,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

///						*********** soil moisture ***********						///
	'No:Current:SoilMoisture:Soil:DailyHigh'        =>	array( 'pos' => 356,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil:TimeDailyHigh'    =>	array( 'pos' => 360,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:SoilMoisture:Soil:DailyLow'         =>	array( 'pos' => 368,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil:TimeDailyLow'     =>	array( 'pos' => 372,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,    'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:SoilMoisture:Soil:MonthLow'         =>	array( 'pos' => 380,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil:MonthHigh'        =>	array( 'pos' => 384,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil:YearLow'          =>	array( 'pos' => 388,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:SoilMoisture:Soil:YearHigh'         =>	array( 'pos' => 392,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),

///						*********** leaf Wetness ***********						///
	'No:Current:LeafWetnesses:Leaf:DailyHigh'       =>	array( 'pos' => 496,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf:TimeDailyHigh'   =>	array( 'pos' => 500,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,     'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:LeafWetnesses:Leaf:DailyLow'        =>	array( 'pos' => 508,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf:TimeDailyLow'    =>	array( 'pos' => 512,	'len' => 2,	'fn'=>'Raw2Date',   'SI'=>NULL,               'min'=>NULL,     'max'=>NULL,'err'=>0xFFFF,	'unit'=> 'Date'),
	'No:Current:LeafWetnesses:Leaf:MonthLow'        =>	array( 'pos' => 520,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf:MonthHigh'       =>	array( 'pos' => 524,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf:YearLow'         =>	array( 'pos' => 528,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	'No:Current:LeafWetnesses:Leaf:YearHigh'        =>	array( 'pos' => 532,	'len' => 1,	'fn'=>'s2uc',       'SI'=>NULL,               'min'=>0,       'max'=>100,	'err'=>255,     'unit'=> '%'),
	
// 	'CRC'                       =>	array( 'pos' => 536,	'len' => 2,	'fn'=>'crc',		      'SI'=>NULL,         'min'=>0,       'max'=>0xFF,	'err'=>255,     'unit'=> ''	),
	);
?>