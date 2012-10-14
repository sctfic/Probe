<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// clear;php5 -f /var/www/Probe/cli.php 'cron'
class dataCollector extends CI_Controller {
	function __construct() {
		if (isset($_SERVER['REMOTE_ADDR'])) { // n'est pas definie en php5-cli
			log_message('warning',  'CLI script access allowed only');
			die();
		}
		parent::__construct();
		log_message('debug',  __FUNCTION__.'('.__CLASS__.') '.__FILE__);
		/**
		on charge notre modele avec le 3ieme parametre a TRUE pour qu'il charge la base par defaut
		elle sera disponible sous la denominatiosn : $this->db->*
		**/
		global $db, $active_group, $active_record;
		include_once(BASEPATH.'core/Model.php'); // need for load models manualy
		include_once(APPPATH.'models/dbconfig.php');
		include_once(APPPATH.'models/station.php');
		$this->dbconfig = new dbconfig();
	}

	// la fonction qui ce lancera par defaut dans cette classe 
	// clear;php5 -f /var/www/Probe/cli.php 'cron'
	function index() {
	}
	// clear;php5 -f /var/www/Probe/cli.php 'cron/dataCollector'
	function dataCollector() {
		foreach($this->dbconfig->lst as $id => $name){
			try {

			}
			catch (Exception $e) {
				log_message('warning',  $e->getMessage());
			}
		}
	}
	// clear;php5 -f /var/www/Probe/cli.php 'cron/ReadArch'
	function ReadArch() {
		foreach($this->dbconfig->lst as $id => $name){
			try {
				$this->benchmark->mark('r_start');
				$conf = $this->dbconfig->dbconfs2arrays($name);
				$this->station = new station($conf[$name]);

				log_message('cli', "Try to read Archive for : $name");
				$this->station->get_archives();
				$this->station->fileSave();
				$this->benchmark->mark('r_end');
				log_message('time', $this->benchmark->elapsed_time('r_start', 'r_end'));
			}
			catch (Exception $e) {
				log_message('warning',  $e->getMessage());
			}
		}
	}

	function ReadConf() {
		foreach($this->dbconfig->lst as $id => $name){
			try {
				log_message('cli', "Read Config for : $name (id:$id)");
				$conf = $this->dbconfig->dbconfs2arrays($name);
				$this->station = new station($conf[$name]);
				
				$this->station->get_confs();
				foreach ($this->station->confExtend as $key => $val) {
					if (strpos($key, 'TR:Config:')!==FALSE)
						$conf[$name][str_replace('TR:Config:', '', $key)] = $val;
				}
				$this->dbconfig->arrays2dbconfs($id, $conf[$name]);
			}
			catch (Exception $e) {
				log_message('warning',  $e->getMessage());
			}
		}
	}
}
