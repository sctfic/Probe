<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once APPPATH."/controllers/checkSetup.php";

class Configuration extends CI_Controller {
    /*
     * data for the breadcrumbs related to installation
     */
    protected  $_breadcrumb = array(
        'dashboard' => array(// in case list-station isn't the home anymore
            array(
                'status' => 'active',
                'url' => '/configuration/list-stations',
                'i18n' => 'configuration.breadcrumb.stations.dashboard'
            )
        ),
        'list-stations' => array(
            array(
                'url' => '/configuration/list-stations',
                'i18n' => 'configuration.breadcrumb.stations.list'
            ),
        array(
            'status' => 'active',
            'url' => '/configuration/list-stations',
            'i18n' => 'configuration.breadcrumb.stations.list'
        )
        ),
        'add-station' => array(
            array(
                'url' => '/configuration/',
                'i18n' => 'configuration.breadcrumb.stations.list'
            ),
            array(
                'status' => 'active',
                'url' => '/configuration/',
                'i18n' => 'configuration.breadcrumb.stations.add'
            )
        )

    );


	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
        $this->load->library('page_manager');

		$this->i18n->setLocaleEnv($this->config->item('probe:locale'), 'global');
	}

	public function index() {
		$this->load->model('station');

		$this->listStations();
	}

	public function listStations() {
        $this->load->model('station');
        $page = new Page_manager();

        // build view data
        $data = $page->fetchConfig('configure-list-station'); // fetch information to build the HTML header
        foreach ($this->station->stationsList as $id => $station) {
            $data['stationsConf'][$station] = current($this->station->config($id));
        }
        $data['breadcrumb'] = $this->_breadcrumb['dashboard'];
        // display the view
		$page->view('configuration/list-stations', $data);
	}


	public function addStation() {
        $this->load->library('form_validation');

        $page = new Page_manager();
        $data = $page->fetchConfig('configure-add-station'); // fetch information to build the HTML header
        $data['breadcrumb'] = $this->_breadcrumb['add-station'];
        $data['form'] = $this->config->item('form.add-station');

        $data['dbmsUsername'] = null;
        $data['dbmsPassword'] = null;
        $data['dbmsHost'] = null;
        $data['dbmsPort'] = 3306;
        $data['dbmsDatabaseName'] = null;

        // display the view
		$page->view('configuration/add-station', $data);
	}
	public function removeStation() {

	}
	public function updateStation() {

	}

}