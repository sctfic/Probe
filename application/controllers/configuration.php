<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once APPPATH."/controllers/checkSetup.php";
require_once APPPATH."/controllers/pages.php";

class Configuration extends CI_Controller {

	public function __construct() {
		parent::__construct();
  	$this->i18n->setLocaleEnv($this->config->item('probe:locale'), 'global');
	}

	public function index() {
    // include_once(APPPATH.'models/station.php');
    // $this->stations = new station();
    $this->load->model('station');

		$this->stations();

		// redirect('configure/')
	}

	public function stations() {
		$this->load->helper('pages');

        // build view data
        $data = pageFetchConfig('configure-station-list'); // fetch information to build the HTML header
        $data['stationsList'] = $this->station->stationsList;
        
        // display the view
        $pages = new Pages();
        $pages->view('configuration/stations-list', $data);
	}


public function addStation() {

}
public function removeStation() {

}
public function updateStation() {

}

}