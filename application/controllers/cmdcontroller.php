<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// clear;php5 -f /var/www/Probe/cli.php 'cmdcontroller'
class cmdController extends CI_Controller {
	function __construct() {
		if (isset($_SERVER['REMOTE_ADDR'])) { // n'est pas definie en php5-cli
			log_message('warning',  'CLI script access allowed only');
			die();
		}
		parent::__construct();
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		/*
		* on charge notre modele avec le 3e parametre a TRUE pour qu'il charge 
		* la base par defaut. 
		* Elle sera disponible sous la denominatiosn : $this->db->*
		**/
		include_once(BASEPATH.'core/Model.php'); // need for load models manualy
		include_once(APPPATH.'models/weatherstation.php');

		$this->WS = new weatherstation();
	}

	// la fonction qui ce lancera par defaut dans cette classe 
	// clear;php5 -f /var/www/Probe/cli.php 'cmdcontroller'
	function index() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		// $this->configCollectors();
		// $this->dataCollectors();
		// $this->hilowsCollectors(0);
		$this->curentCollectors(0);
	}

	// clear;php5 -f /var/www/Probe/cli.php 'cmdcontroller/hilowCollectors'
	function hilowsCollectors($station = null) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		try {
			$item_ID = is_numeric($station) ? array_search($station, $this->WS->lst) : $station;
			if (isset($item_ID)) {
				// on rapelle cette meme fonction mais avec de vrai paarametre : Toutes les stations
				// on recupere les confs de $station
				$itemConf = end($this->WS->config($item_ID)); // $station est le ID ou le nom
				$this->WS->HilowsCollector ($itemConf);
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
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		try {
			$item_ID = is_numeric($station) ? array_search($station, $this->WS->lst) : $station;
			if (isset($item_ID)) {
				// on rapelle cette meme fonction mais avec de vrai paarametre : Toutes les stations
				// on recupere les confs de $station
				$itemConf = end($this->WS->config($item_ID)); // $station est le ID ou le nom
				$this->WS->LpsCollector ($itemConf);
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
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		if (is_array($station)) {
			foreach ($station as $item) {
				// on rapelle cette meme fonction mais individuellement pour chaque station
				$this->dataCollectors($item);
			}
			return false;
		}
		elseif ($station===null && !empty($this->WS->lst)) {
			// on rapelle cette meme fonction mais avec de vrai paarametre : Toutes les stations
			$this->dataCollectors (array_keys ($this->WS->lst));
			return false;
		}
//		else return false;
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
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		if (is_array($station)) {
			foreach ($station as $item) {
				// on rapelle cette meme fonction mais individuellement pour chaque station
				$this->configCollectors($item);
			}
			return false;
		}
		elseif ($station===null && !empty($this->WS->lst)) {
			// on rapelle cette meme fonction mais avec de vrai parametre : les ID de toutes les stations
			$this->configCollectors (array_keys ($this->WS->lst));
			return false;
		}
//		else return false;
		try {
			$conf = end($this->WS->config($station));
			log_message('count', count($conf));

			if (count($conf)<30 or $force==true) {
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
	// clear;php5 -f /var/www/Probe/cli.php 'cmdcontroller/makeNewStation'
	function makeNewStation() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

		try {
			include_once(APPPATH.'models/db_builder.php');
			include(APPPATH.'config/db-default.php');
			$newID = current ($this->WS->availableID()); // prend le 1er ID vide parmis ceux disponible

			$dbb = new db_builder('mysql','nbv4023','root','localhost',3306,'');
			$dbb->createAppDb($newID);
			$dsn = $dbb->getDsn();

			$this->WS->arrays2dbconfs($newID, array_merge(array('_ip'=>'', '_port'=>'', '_name'=>'', '_type'=>''), $dsn));
			return $this->WS->config($newID);
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
	}
}