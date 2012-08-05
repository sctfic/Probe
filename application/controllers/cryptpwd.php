<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class cryptPwd extends CI_Controller {

	function __construct() {
		if (isset($_SERVER['REMOTE_ADDR'])) { // n'est pas definie en php5-cli
			log_message('warning',  'CLI script access allowed only');
			die();
		}
		log_message('debug',  '__construct() '.__FILE__);
		parent::__construct();
		include(APPPATH.'libraries/WS_rev_crypt.php');
	}

	// clear;clear;php5 -f /var/www/WsWds/cli.php 'cryptpwd/read' 'toto'
	function read($name){
		$crypt = new WS_rev_crypt($name);
		echo "\t>\t".$name.':'.$crypt->read()."\n";
		unset($crypt);

	}
	// clear;clear;php5 -f /var/www/WsWds/cli.php 'cryptpwd/write' 'toto' 'psswrd'
	function write($name, $pwd) {
		$crypt = new WS_rev_crypt($name);
		$crypt->write($pwd);
		unset($crypt);
	}
}
