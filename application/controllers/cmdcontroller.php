<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// clear;php5 -f /var/www/Probe/cli.php 'cmdcontroller'
class cmdController extends CI_Controller {
	function __construct() {
		if (isset($_SERVER['REMOTE_ADDR'])) { // n'est pas definie en php5-cli
			log_message('warning',  'CLI script access allowed only');
			die();
		}
		parent::__construct();
		log_message('init',  __FUNCTION__.'('.__CLASS__.")\n".__FILE__.' ['.__LINE__.']');
		/**
		on charge notre modele avec le 3ieme parametre a TRUE pour qu'il charge la base par defaut
		elle sera disponible sous la denominatiosn : $this->db->*
		**/
		include_once(BASEPATH.'core/Model.php'); // need for load models manualy
		include_once(APPPATH.'models/weatherstation.php');

		$this->WS = new weatherstation();
	}

	// la fonction qui ce lancera par defaut dans cette classe 
	// clear;php5 -f /var/www/Probe/cli.php 'cmdcontroller'
	function index() {
		$this->configCollectors();
		$this->dataCollectors();
	}

	// clear;php5 -f /var/www/Probe/cli.php 'cmdcontroller/hilowCollectors'
	function hilowCollectors($station = null) {
		try {
			if ($item_ID = array_search($station, $this->WS->lst)) {
				// on rapelle cette meme fonction mais avec de vrai paarametre : Toutes les stations
				// on recupere les confs de $station
				$conf = end($this->WS->config($item_ID)); // $station est le ID ou le nom
				$this->WS->HilowCollector ($item);
				return false;
			}
			else return false;
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
	}
	
	// clear;php5 -f /var/www/Probe/cli.php 'cmdcontroller/curentCollectors'
	function curentCollectors($station = null) {
		try {
			if ($item_ID = array_search($station, $this->WS->lst)) {
				// on rapelle cette meme fonction mais avec de vrai paarametre : Toutes les stations
				// on recupere les confs de $station
				$conf = end($this->WS->config($item_ID)); // $station est le ID ou le nom
				$this->WS->LpsCollector ($item);
				return false;
			}
			else return false;
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
	}

	// clear;php5 -f /var/www/Probe/cli.php 'cmdcontroller/dataCollectors'
	function dataCollectors($station = null) {
		if (is_array($station)) {
			foreach ($station as $item) {
				// on rapelle cette meme fonction mais individuellement pour chaque station
				$this->dataCollectors($item);
			}
			return false;
		}
		elseif ($station===null && is_array($this->WS->lst)) {
			// on rapelle cette meme fonction mais avec de vrai paarametre : Toutes les stations
			$this->dataCollectors (array_keys ($this->WS->lst));
			return false;
		}
		else return false;
		try {
			// on recupere les confs de $station
			$conf = end($this->WS->config($station)); // $station est le ID ou le nom
			
			// on lance la recup des Archives de cette station
			$this->WS->ArchCollector($conf);
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
	}
	
	
	// clear;php5 -f /var/www/Probe/cli.php 'cmdcontroller/configCollectors'
	function configCollectors($station = null, $force = false) {
		if (is_array($station)) {
			foreach ($station as $item) {
				// on rapelle cette meme fonction mais individuellement pour chaque station
				$this->configCollectors($item);
			}
			return false;
		}
		elseif (empty($station)) {
			// on rapelle cette meme fonction mais avec de vrai paarametre : Toutes les stations
			if (!empty($this->WS->lst))
				$this->configCollectors (array_keys ($this->WS->lst));
			return false;
		}
		else return false;
		try {
			$conf = end($this->WS->config($station));
			if (count($conf)<10 or $force==true) {
				$readconf = $this->WS->ConfCollector($conf);
				foreach ($readconf as $key => $val) {
					if (strpos($key, 'TR:Config:')!==FALSE)
						$ToStoreConfig[str_replace('TR:Config:', '', $key)] = $val;
				}
				$this->WS->arrays2dbconfs($conf['_id'], $ToStoreConfig);
			}
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
	}
	// 'cmdcontroller/makeNewStation'
	function makeNewStation($pass='nbv4023', $user='root', $db_type='mysql', $host='localhost', $port=3306) {
		try {
			include_once(APPPATH.'models/db_builder.php');
			$dbb = new db_builder($pass, $user, $db_type, $host, $port);

			$newID = current ($this->WS->availableID());
			log_message('id',$newID);
			$this->WS->arrays2dbconfs($newID, $dsn);
			$dsn = $dbb->make_db_data('VP2-'.$newID);
			return $this->WS->config($newID);
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
	}
}
