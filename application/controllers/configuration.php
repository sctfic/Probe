<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once APPPATH."/controllers/checkSetup.php";
require_once APPPATH."/controllers/pages.php";

class Configuration extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('pages');

		$this->i18n->setLocaleEnv($this->config->item('probe:locale'), 'global');
	}

	public function index() {
		// include_once(APPPATH.'models/station.php');
		// $this->stations = new station();
		$this->load->model('station');

		$this->listStations();

		// redirect('configuration/stations-list');
	}

	public function listStations() {
		// $this->load->helper('pages');

		// build view data
		$data = pageFetchConfig('configure-station-list'); // fetch information to build the HTML header
		foreach ($this->station->stationsList as $id => $station) {
			$data['stationsConf'][$station] = current($this->station->config($id));
			// unset($data['stationsConf'][$station]['_name']);
			// unset($data['stationsConf'][$station]['password']);
		}
		// display the view
		$pages = new Pages();
		$pages->view('configuration/list-stations', $data);
	}


  public function addStation() {
		$this->load->library('form_validation');

		$data = pageFetchConfig('configure-add-station'); // fetch information to build the HTML header
		$data['form'] = array(
			'dbms' => array(
				'engine' => array(
					'type' => 'radio',
					'values' => array(
						'mysql',
						'sqlite'
					)
				),
				'username' => 'text',
				'password' => 'password',
				'host' => 'text',
				'port' => 'number', // already

				// 'database' => 'text',
				// 'dbdriver' => 'text', // fixed: pdo
				// 'hostname' => 'mysql:host=localhost;port=3306',
				// 'password' => 'password',
				// 'username' => 'text', 
			),
			'network' => array(
				// '_ip' => 'pattern="([0-2][0-5][0-5]\.){4}"',
				'_ip' => 'pattern="\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b"',
				'_name' => 'text',
				'_port' => 'number',
				'_type' => 'text',
			)
		);

		$data['dbmsUsername'] = null;
		$data['dbmsPassword'] = null;
		$data['dbmsHost'] = null;
		$data['dbmsPort'] = 3306;
		$data['dbmsDatabaseName'] = null;

	// display the view
	$pages = new Pages();
	$pages->view('configuration/add-station', $data);
  }
public function removeStation() {

}
public function updateStation() {

}

}