<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
const CANCEL	=	"\x18";		// chr(0x18), Bad CRC Code
const OK	=	"\n\rOK\n\r";	// Confirm
const DBL_NULL	=	"\x00\x00";	// valeur de confirmation d'un CRC

/* End of file constants.php */
/* Location: ./application/config/constants.php */
