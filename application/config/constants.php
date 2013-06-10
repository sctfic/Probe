<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @description Condition some behaviors (e.g. use of Google API only in production)
 * @param value as return by $_SERVER["HTTP_HOST"]
 */
define('DEV_HOST', 'probe.dev');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

const ADMIN_ROLE_ID = 1; // it's the first role created so it's 1
const ADMIN_ROLE_CODE = 'app-admin'; // it's the first code admin user

/*
|--------------------------------------------------------------------------
| VP2 CONSTANT
|--------------------------------------------------------------------------
|
| These constant are used to test result of telnet VP2 dialog
|
*/
const CR	=	"\r";		// chr(0x0D)
const LF	=	"\n";		// chr(0x0A)
const LFCR	=	"\n\r";		// chr(0x0A).chr(0x0D)
const ESC	=	"\x1b";		// chr(0x1b), Echap
const ACK	=	"\x06";		// chr(0x06), Compris
const NAK	=	"\x21";		// chr(0x21), Pas Compris
const OK	=	"\n\rOK\n\r";	// Confirm
const CANCEL	=	"\x18";		// chr(0x18), Bad CRC Code
const DBL_NULL	=	"\x00\x00";	// valeur de confirmation d'un CRC

// 	var $WinDir = array('N','NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW');

    $RAIN_COLLECTOR = array(0=>0.01, 1=>0.2, 2=>0.1);
    $TREND = array(196=>-2, 236=>-1, 0=>0, 20=>1, 60=>2, 80=>'Rev A');
    $TIME_ZONE = array(
        0 	=>	array( 'GMToffset' =>-1200, 'name' => '(GMT-12:00) Eniwetok, Kwajalein'),
        1 	=>	array( 'GMToffset' =>-1100, 'name' => '(GMT-11:00) Midway Island, Samoa'),
        2 	=>	array( 'GMToffset' =>-1000, 'name' => '(GMT-10:00) Hawaii'),
        3 	=>	array( 'GMToffset' => -900,	'name' => '(GMT-09:00) Alaska'),
        4 	=>	array( 'GMToffset' => -800,	'name' => '(GMT-08:00) Pacific Time, Tijuana'),
        5 	=>	array( 'GMToffset' => -700,	'name' => '(GMT-07:00) Mountain Time'),
        6 	=>	array( 'GMToffset' => -600,	'name' => '(GMT-06:00) Central Time'),
        7 	=>	array( 'GMToffset' => -600,	'name' => '(GMT-06:00) Mexico City'),
        8 	=>	array( 'GMToffset' => -600,	'name' => '(GMT-06:00) Central America'),
        9 	=>	array( 'GMToffset' => -500,	'name' => '(GMT-05.00) Bogota, Lima, Quito'),
        10	=>	array( 'GMToffset' => -500,	'name' => '(GMT-05:00) Eastern Time'),
        11	=>	array( 'GMToffset' => -400,	'name' => '(GMT-04:00) Atlantic Time'),
        12	=>	array( 'GMToffset' => -400,	'name' => '(GMT-04.00) Caracas, La Paz, Santiago'),
        13	=>	array( 'GMToffset' => -330,	'name' => '(GMT-03.30) Newfoundland'),
        14	=>	array( 'GMToffset' => -300,	'name' => '(GMT-03.00) Brasilia'),
        15	=>	array( 'GMToffset' => -300,	'name' => '(GMT-03.00) Buenos Aires, Georgetown, Greenland'),
        16	=>	array( 'GMToffset' => -200,	'name' => '(GMT-02.00) Mid-Atlantic'),
        17	=>	array( 'GMToffset' => -100,	'name' => '(GMT-01:00) Azores, Cape Verde Is.'),
        18	=>	array( 'GMToffset' =>   0,	'name' => '(GMT) Greenwich Mean Time, Dublin, Edinburgh, Lisbon, London'),
        19	=>	array( 'GMToffset' =>   0,	'name' => '(GMT) Monrovia, Casablanca'),
        20	=>	array( 'GMToffset' =>  100,	'name' => '(GMT+01.00) Berlin, Rome, Amsterdam, Bern, Stockholm, Vienna'),
        21	=>	array( 'GMToffset' =>  100,	'name' => '(GMT+01.00) Paris, Madrid, Brussels, Copenhagen, W Central Africa'),
        22	=>	array( 'GMToffset' =>  100,	'name' => '(GMT+01.00) Prague, Belgrade, Bratislava, Budapest, Ljubljana'),
        23	=>	array( 'GMToffset' =>  200,	'name' => '(GMT+02.00) Athens, Helsinki, Istanbul, Minsk, Riga, Tallinn'),
        24	=>	array( 'GMToffset' =>  200,	'name' => '(GMT+02:00) Cairo'),
        25	=>	array( 'GMToffset' =>  200,	'name' => '(GMT+02.00) Eastern Europe, Bucharest'),
        26	=>	array( 'GMToffset' =>  200,	'name' => '(GMT+02:00) Harare, Pretoria'),
        27	=>	array( 'GMToffset' =>  200,	'name' => '(GMT+02.00) Israel, Jerusalem'),
        28	=>	array( 'GMToffset' =>  300,	'name' => '(GMT+03:00) Baghdad, Kuwait, Nairobi, Riyadh'),
        29	=>	array( 'GMToffset' =>  300,	'name' => '(GMT+03.00) Moscow, St. Petersburg, Volgograd'),
        30	=>	array( 'GMToffset' =>  330,	'name' => '(GMT+03:30) Tehran'),
        31	=>	array( 'GMToffset' =>  400,	'name' => '(GMT+04:00) Abu Dhabi, Muscat, Baku, Tblisi, Yerevan, Kazan'),
        32	=>	array( 'GMToffset' =>  430,	'name' => '(GMT+04:30) Kabul'),
        33	=>	array( 'GMToffset' =>  500,	'name' => '(GMT+05:00) Islamabad, Karachi, Ekaterinburg, Tashkent'),
        34	=>	array( 'GMToffset' =>  530,	'name' => '(GMT+05:30) Bombay, Calcutta, Madras, New Delhi, Chennai'),
        35	=>	array( 'GMToffset' =>  600,	'name' => '(GMT+06:00) Almaty, Dhaka, Colombo, Novosibirsk, Astana'),
        36	=>	array( 'GMToffset' =>  700,	'name' => '(GMT+07:00) Bangkok, Jakarta, Hanoi, Krasnoyarsk'),
        37	=>	array( 'GMToffset' =>  800,	'name' => '(GMT+08:00) Beijing, Chongqing, Urumqi, Irkutsk, Ulaan Bataar'),
        38	=>	array( 'GMToffset' =>  800,	'name' => '(GMT+08:00) Hong Kong, Perth, Singapore, Taipei, Kuala Lumpur'),
        39	=>	array( 'GMToffset' =>  900,	'name' => '(GMT+09:00) Tokyo, Osaka, Sapporo, Seoul, Yakutsk'),
        40	=>	array( 'GMToffset' =>  930,	'name' => '(GMT+09:30) Adelaide'),
        41	=>	array( 'GMToffset' =>  930,	'name' => '(GMT+09:30) Darwin'),
        42	=>	array( 'GMToffset' => 1000,	'name' => '(GMT+10:00) Brisbane, Melbourne, Sydney, Canberra'),
        43	=>	array( 'GMToffset' => 1000,	'name' => '(GMT+10.00) Hobart, Guam, Port Moresby, Vladivostok'),
        44	=>	array( 'GMToffset' => 1100,	'name' => '(GMT+11:00) Magadan, Solomon Is, New Caledonia'),
        45	=>	array( 'GMToffset' => 1200,	'name' => '(GMT+12:00) Fiji, Kamchatka, Marshall Is.'),
        46	=>	array( 'GMToffset' => 1200,	'name' => '(GMT+12:00) Wellington, Auckland')
    );
    $TABLE_CRC16 = array(
            0x0000,  0x1021,  0x2042,  0x3063,  0x4084,  0x50a5,  0x60c6,  0x70e7,
            0x8108,  0x9129,  0xa14a,  0xb16b,  0xc18c,  0xd1ad,  0xe1ce,  0xf1ef,
            0x1231,  0x0210,  0x3273,  0x2252,  0x52b5,  0x4294,  0x72f7,  0x62d6,
            0x9339,  0x8318,  0xb37b,  0xa35a,  0xd3bd,  0xc39c,  0xf3ff,  0xe3de,
            0x2462,  0x3443,  0x0420,  0x1401,  0x64e6,  0x74c7,  0x44a4,  0x5485,
            0xa56a,  0xb54b,  0x8528,  0x9509,  0xe5ee,  0xf5cf,  0xc5ac,  0xd58d,
            0x3653,  0x2672,  0x1611,  0x0630,  0x76d7,  0x66f6,  0x5695,  0x46b4,
            0xb75b,  0xa77a,  0x9719,  0x8738,  0xf7df,  0xe7fe,  0xd79d,  0xc7bc,
            0x48c4,  0x58e5,  0x6886,  0x78a7,  0x0840,  0x1861,  0x2802,  0x3823,
            0xc9cc,  0xd9ed,  0xe98e,  0xf9af,  0x8948,  0x9969,  0xa90a,  0xb92b,
            0x5af5,  0x4ad4,  0x7ab7,  0x6a96,  0x1a71,  0x0a50,  0x3a33,  0x2a12,
            0xdbfd,  0xcbdc,  0xfbbf,  0xeb9e,  0x9b79,  0x8b58,  0xbb3b,  0xab1a,
            0x6ca6,  0x7c87,  0x4ce4,  0x5cc5,  0x2c22,  0x3c03,  0x0c60,  0x1c41,
            0xedae,  0xfd8f,  0xcdec,  0xddcd,  0xad2a,  0xbd0b,  0x8d68,  0x9d49,
            0x7e97,  0x6eb6,  0x5ed5,  0x4ef4,  0x3e13,  0x2e32,  0x1e51,  0x0e70,
            0xff9f,  0xefbe,  0xdfdd,  0xcffc,  0xbf1b,  0xaf3a,  0x9f59,  0x8f78,
            0x9188,  0x81a9,  0xb1ca,  0xa1eb,  0xd10c,  0xc12d,  0xf14e,  0xe16f,
            0x1080,  0x00a1,  0x30c2,  0x20e3,  0x5004,  0x4025,  0x7046,  0x6067,
            0x83b9,  0x9398,  0xa3fb,  0xb3da,  0xc33d,  0xd31c,  0xe37f,  0xf35e,
            0x02b1,  0x1290,  0x22f3,  0x32d2,  0x4235,  0x5214,  0x6277,  0x7256,
            0xb5ea,  0xa5cb,  0x95a8,  0x8589,  0xf56e,  0xe54f,  0xd52c,  0xc50d,
            0x34e2,  0x24c3,  0x14a0,  0x0481,  0x7466,  0x6447,  0x5424,  0x4405,
            0xa7db,  0xb7fa,  0x8799,  0x97b8,  0xe75f,  0xf77e,  0xc71d,  0xd73c,
            0x26d3,  0x36f2,  0x0691,  0x16b0,  0x6657,  0x7676,  0x4615,  0x5634,
            0xd94c,  0xc96d,  0xf90e,  0xe92f,  0x99c8,  0x89e9,  0xb98a,  0xa9ab,
            0x5844,  0x4865,  0x7806,  0x6827,  0x18c0,  0x08e1,  0x3882,  0x28a3,
            0xcb7d,  0xdb5c,  0xeb3f,  0xfb1e,  0x8bf9,  0x9bd8,  0xabbb,  0xbb9a,
            0x4a75,  0x5a54,  0x6a37,  0x7a16,  0x0af1,  0x1ad0,  0x2ab3,  0x3a92,
            0xfd2e,  0xed0f,  0xdd6c,  0xcd4d,  0xbdaa,  0xad8b,  0x9de8,  0x8dc9,
            0x7c26,  0x6c07,  0x5c64,  0x4c45,  0x3ca2,  0x2c83,  0x1ce0,  0x0cc1,
            0xef1f,  0xff3e,  0xcf5d,  0xdf7c,  0xaf9b,  0xbfba,  0x8fd9,  0x9ff8,
            0x6e17,  0x7e36,  0x4e55,  0x5e74,  0x2e93,  0x3eb2,  0x0ed1,  0x1ef0
            );

define('BINDER_DIR', 'd3/');
define('BINDER_PATH', FCPATH.APPPATH.'views/'.BINDER_DIR);

/**
 * Directory holding DDL files, SQL queries and SQLite DB.
 */
define('SQL_DIR', APPPATH.'models/sql/');
/**
 * If user choose to use SQLite database here is the path to the file
 */
define('SQLITE_PATH', SQL_DIR.'db-default.sqlite');

/* End of file constants.php */
/* Location: ./application/config/constants.php */
