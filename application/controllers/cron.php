<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// clear;php5 -f /var/www/WsWds/cli.php 'cron'
class Cron extends CI_Controller {
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
		$this->load->model('dbconfig');

		return true;
	}

	// la fonction qui ce lancera par defaut dans cette classe 
	// clear;php5 -f /var/www/WsWds/cli.php 'cron'
	function index() {
		$this->load->unload('dbconfig');
		$this->load->model('dbconfig');
		$this->load->unload('dbconfig');
		$this->load->model('dbconfig');
		$this->load->unload('dbconfig');
		$this->load->model('dbconfig');
		$this->load->unload('dbconfig');
		$this->load->model('dbconfig');
		$this->load->unload('dbconfig');
		$this->load->model('dbconfig');
		$this->load->unload('dbconfig');
	}

	// clear;php5 -f /var/www/WsWds/cli.php 'cron/ReadArch'
	function ReadArch() {
		foreach($this->dbconfig->lst as $id => $name){
			try {
				$this->benchmark->mark('r_start');
				$conf = $this->dbconfig->dbconfs2arrays($name);
				$this->load->model('station', '', FALSE,	$conf[$name]);
				$this->station->__construct($conf[$name]);
				
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
				$this->load->model('station', '', FALSE,	$conf[$name]);
				$this->station->__construct($conf[$name]);
				
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
