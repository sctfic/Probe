<?php // clear;php5 -f /var/www/WsWds/cli.php 'cron'
class Cron extends CI_Controller {

	function __construct() {
		if (isset($_SERVER['REMOTE_ADDR'])) { // n'est pas definie en php5-cli
			die();
		}
		parent::__construct();
		$this->load->model('dbconfig');
		$this->load->model('station');
	}

	// la fonction qui ce lancera par defaut dans cette classe 
	// clear;php5 -f /var/www/WsWds/cli.php 'cron'
	function index() { // affiche la liste des stations presente en DB
	
	}

	// clear;php5 -f /var/www/WsWds/cli.php 'cron/ReadArch'
	function ReadArch() {
		$this->Stations = $this->dbconfig->dbconfs2arrays()
		foreach($this->Stations as $configKey => $configValue)
		{
// 			require_once	(APPPATH.'models/service/'.$configValue['Type'].'/Archive.php');
			$data = $this->archive->get ($configKey, $configValue);
			$this->archive->fileSave($data, $configKey);
			$this->archive->dbSave($data, $configKey);
		}
// 		$this->config->set_item('station');
	}
}
