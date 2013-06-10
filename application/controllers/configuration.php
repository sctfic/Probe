<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once APPPATH."/controllers/checkSetup.php";

class Configuration extends CI_Controller {
    /**
     * @var array data for the breadcrumbs related to installation
     */
    protected  $_breadcrumb = array(
        'dashboard' => array(// in case list-station isn't the home anymore
            array(
                'status' => 'active',
                'url' => '/configuration',
                'i18n' => 'configuration-station.dashboard.breadcrumb'
            )
        ),
        'list-stations' => array(
            array(
                'url' => '/configuration',
                'i18n' => 'configuration-station.dashboard.breadcrumb'
            ),
            array(
                'status' => 'active',
                'url' => '/configuration/list-stations',
                'i18n' => 'configuration-station.list.breadcrumb'
            ),
        ),
        'add-station' => array(
            array(
                'url' => '/configuration',
                'i18n' => 'configuration-station.dashboard.breadcrumb'
            ),
            array(
                'url' => '/configuration/',
                'i18n' => 'configuration-station.list.breadcrumb'
            ),
            array(
                'status' => 'active',
                'url' => '/configuration/',
                'i18n' => 'configuration-station.add.breadcrumb'
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

        $page = new Page_manager();
        $page->addData('breadcrumb', $this->_breadcrumb['dashboard'] );
        $page->addMetadata('configuration-dashboard'); // fetch information to build the HTML header

        // display the view
        $page->view('configuration/dashboard');
	}

	public function listStations() {
        $this->load->model('station');
        $page = new Page_manager();

        // build view data
        foreach ($this->station->stationsList as $id => $station) {
            $page->addData('stationsConf', array($station => $this->_breadcrumb['dashboard']) );
        }
        $page->addData('breadcrumb', $this->_breadcrumb['list-stations'] );
        $page->addMetadata('configuration-list-station'); // fetch information to build the HTML header

        // display the view
		$page->view('configuration/list-stations');
	}


	public function addStation() {
        $this->load->library('form_validation');
        $page = new Page_manager();

        // build view data
        $page->addData('breadcrumb', $this->_breadcrumb['add-station'] );
        $page->addData('dbmsUsername', null );
        $page->addData('dbmsPassword', null );
        $page->addData('dbmsHost', null );
        $page->addData('dbmsPort', 3306 );
        $page->addData('dbmsDatabaseName', null );
        $page->addData('form', $this->config->item('add-station.form.structure') );
        $page->addMetadata('configuration-add-station'); // fetch information to build the HTML header

        // display the view
		$page->view('configuration/add-station');
	}
	public function removeStation() {

	}
	public function updateStation() {

	}

}