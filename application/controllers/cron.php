<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// clear;php5 -f /var/www/WsWds/cli.php 'cron'
class Cron extends CI_Controller {

	function __construct() {
		if (isset($_SERVER['REMOTE_ADDR'])) { // n'est pas definie en php5-cli
			die();
		}
		parent::__construct();
		/**
		on charge notre modele avec le 3ieme parametre a TRUE pour qu'il charge la base par defaut
		elle sera disponible sous la denominatiosn : $this->db->*
		**/
		$this->load->model('dbconfig', '', true);
	}

	// la fonction qui ce lancera par defaut dans cette classe 
	// clear;php5 -f /var/www/WsWds/cli.php 'cron'
	function index() { // affiche la liste des stations presente en DB

	}

	// clear;php5 -f /var/www/WsWds/cli.php 'cron/ReadArch'
	function ReadArch() {
// 		$StaConfs = $this->dbconfig->dbconfs2arrays();
$this->dbconfig->lst=array(2=>'VP2-Outside');
// $this->dbconfig->lst=array(1=>'VP2-Inside'); // reste a gerer les exceptions
		foreach($this->dbconfig->lst as $id => $name){
// 			$this->benchmark->mark('code_start');
			$conf = $this->dbconfig->dbconfs2arrays($name);
			$this->load->model(	'station', '', FALSE,	$conf[$name]);
			$this->station->get_archives();
			$this->station->fileSave();
// 			$this->benchmark->mark('code_end');
// 			echo $this->benchmark->elapsed_time('code_start', 'code_end')."\n";
		}
	}
	function ReadConf() {
// 		$StaConfs = $this->dbconfig->dbconfs2arrays();
$this->dbconfig->lst=array(2=>'VP2-Outside');
// $this->dbconfig->lst=array(1=>'VP2-Inside'); // reste a gerer les exceptions
		foreach($this->dbconfig->lst as $id => $name){
// 			$this->benchmark->mark('code_start');
			$conf = $this->dbconfig->dbconfs2arrays($name);
			$this->load->model(	'station', '', FALSE,	$conf[$name]);
			$this->station->get_confs();
			foreach ($this->station->confExtend as $key => $val) {
				if (strpos($key, 'TR:Config:')!==FALSE)
					$conf[$name][str_replace('TR:Config:', '', $key)] = $val;
			}
			print_r($conf);
			$this->dbconfig->arrays2dbconfs($id, $conf[$name]);
// 			$this->benchmark->mark('code_end');
// 			echo $this->benchmark->elapsed_time('code_start', 'code_end')."\n";
		}
	}
}
