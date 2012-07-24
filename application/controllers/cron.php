<?php // clear;php5 -f /var/www/WsWds/cli.php 'cron'
class Cron extends CI_Controller {


	protected $Stations = NULL;


	function __construct() {
		if (isset($_SERVER['REMOTE_ADDR'])) { // n'est pas definie en php5-cli
			die();
		}
		parent::__construct();
		try{	//to connect
			$DBConf = $this->load->database('default', TRUE); // on se connecte a notre table (via pdo)
			$query = $DBConf->query( // on demande la liste des NOM des stations meteo et les ID associé
				'SELECT `CFG_STATION_ID`, `CFG_VALUE` 
				FROM `TR_CONFIG` 
				WHERE `CFG_CODE`=1 
				LIMIT 0 , 10');
			foreach($query->result() as $Lst)
			{ // pour chaque station meteo on dresse la liste des configs
				$CurentStation = $DBConf->query(
					'SELECT * 
					FROM `TR_CONFIG` 
					WHERE `CFG_STATION_ID`='.$Lst->CFG_STATION_ID.' 
					LIMIT 0 , 100');
				foreach($CurentStation->result() as $val)
				{ // on integre chacune des configs dans un tableau a 2 dimensions qui sera utilisé par la suite
					$this->Stations[$Lst->CFG_VALUE][$val->CFG_LABEL]=$val->CFG_VALUE;
				}
			}
			$DBConf->close();
			unset($DBConf); 
		}
		catch(PDOException $e) {
			echo 'Please contact Admin: '.$e->getMessage();
		}
	}



	// la fonction qui ce lancera par defaut dans cette classe 
	// clear;php5 -f /var/www/WsWds/cli.php 'cron'
	function index() { // affiche la liste des stations presente en DB
		print_r($this->Stations);
	}



	// clear;php5 -f /var/www/WsWds/cli.php 'cron/ReadArch'
	function ReadArch() {
		foreach($this->Stations as $configKey=>$configValue)
		{
			require_once	(APPPATH.'models/service/'.$configValue['Type'].'/Archive.php');
			$data=run ($configKey, $configValue);
			fileSave($data, $configKey);
			dbSave($data, $configKey);
		}
// 		$this->config->set_item('station');
	}
}
