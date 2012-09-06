<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// clear;php5 -f /var/www/WsWds/cli.php 'cron'
class cmdController extends CI_Controller {
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
		include_once(BASEPATH.'core/Model.php'); // need for load models manualy
		include_once(APPPATH.'models/weatherstation.php');
		$this->load->helper(array('cli_tools','binary','s.i.converter'));
		$this->WS = new weatherstation();
	}

	// la fonction qui ce lancera par defaut dans cette classe 
	// clear;php5 -f /var/www/WsWds/cli.php 'cron'
	function index() {
	
	}
	
	// clear;php5 -f /var/www/WsWds/cli.php 'cron/dataCollector'
	function dataCollector($station = null) {
		if (is_array($station)) {
			foreach ($station as $item) {
				$this->dataCollector($item);
			}
			return ;
		}
		elseif (empty($station)) {
			$this->dataCollector (array_keys ($this->WS->lst));
		}
		
		try {
			$this->WS->dbconfs2arrays($station);
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}

	}
	// clear;php5 -f /var/www/WsWds/cli.php 'cron/ReadArch'
	function ReadArch() {
		foreach($this->dbconfig->lst as $id => $name){
			try {
				$conf = $this->dbconfig->dbconfs2arrays($name);
				$this->station = new station($conf[$name]);
				$this->station->get_archives();
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
