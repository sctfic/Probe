<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class cryptPwd extends CI_Controller {
	protected $cryptPwdinited=false;

	function __construct() {
		if (isset($_SERVER['REMOTE_ADDR'])) { // n'est pas definie en php5-cli
			log_message('warning',  'CLI script access allowed only');
			die();
		}
		parent::__construct();
		log_message('debug',  '__construct() '.__FILE__);
		include(APPPATH.'libraries/PROBE_rev_crypt.php');
		$this->__init();
	}	
	function __init($force=false)
	{ // initialise le constante de cette classe separement du __construct()
		if ($this->cryptPwdinited && !$force) return false;
		log_message('debug',  '__init() '.__FILE__);
		return true;
	}

	// clear;clear;php5 -f /var/www/Probe/cli.php 'cryptpwd/read' 'toto'
	function read($name){
		$crypt = new PROBE_rev_crypt($name);
		echo "\t>\t".$name.':'.$crypt->read()."\n";
		unset($crypt);

	}
	// clear;clear;php5 -f /var/www/Probe/cli.php 'cryptpwd/write' 'toto' 'psswrd'
	function write($name, $pwd) {
		$crypt = new PROBE_rev_crypt($name);
		$crypt->write($pwd);
		unset($crypt);
	}
}
