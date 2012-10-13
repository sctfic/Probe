<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once APPPATH."/controllers/checkSetup.php";
require_once APPPATH."/controllers/pages.php";


class Installer extends CI_Controller {

	public function __construct() {
	parent::__construct();

// 	$this->i18n->setLocaleEnv($this->config->item('ws:locale'), 'global'); // set language

$locale = "fr_FR";
putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("global", "application/language/locales/");
textdomain("global");
//     $this->encrypt->set_cipher(MCRYPT_BLOWFISH);
//     $this->startSetup();
	}

	private function startSetup() {
	try {
	$this->requestDsnForConfigDb();
	} catch (exception $e){
	log_message('error', printf('%s: %s', i18n("error.setup.database"), $e->getMessage()) );
	}

    try {
//       $this->requestCredentialsForAdminUser();
    } catch (exception $e){
      log_message('error', printf('%s: %s', i18n("error.setup.amdin-user"), $e->getMessage()) );
    }

  }

  // CI require a landing function called: 'index'
  public function index() {
    $this->startSetup();
  }
  
  public function requestDsnForConfigDb() {
    $this->load->helper('pages');
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');

    // build view data
    $data = pageFetchConfig('setup-dbms'); // fetch information to build the HTML header
    $data['dbmsIp'] = null;
    $data['dbmsPort'] = 3306;
    $data['dbmsUsername'] = null;
    $data['dbmsPassword'] = null;
    
    // display the view
    $pages = new Pages();
    $pages->view('setup/dbms', $data);
  }

  public function requestCredentialsForAdminUser() {
    $this->load->helper('pages');
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');

    // build view data
    $data = pageFetchConfig('setup-admin-user'); // fetch information to build the HTML header
    $data['adminUsername'] = NULL;
    $data['adminPassword'] = NULL;
    $data['adminPasswordConfirmation'] = NULL;
    
    // display the view
    $pages = new Pages();
    $pages->view('setup/admin-user', $data);
  }

	/*
	* alias method to have nice URL
	*/
	public function adminUser() { $this->requestCredentialsForAdminUser(); }

   function setupDbms() {
    // call to model/db_builder.php
	$ip=$this->input->post('dbms-ip');
	$port=$this->input->post('dbms-port');
	$engine=$this->input->post('dbms-engine');
	$username=$this->input->post('dbms-username');
	$pass=$this->input->post('dbms-password');
	log_message('info', sprintf('%s', i18n("info.setup.database_!")));

	require_once(BASEPATH.'core/Model.php'); // need for load models manualy
	require_once(APPPATH.'models/db_builder.php');
	try {
		$this->dbb = new db_builder($pass, $username, $engine, $ip, $port);
		$dns = $this->dbb->make_db_config();
	} catch (Exception $e) {
			log_message('db',  $e->getMessage() );
	}
  }

	function setupAdminUser() {
	// call to model/db_builder.php
	log_message('info', printf('%s', i18n("info.setup.admin-user") ) );
	}
}