<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once APPPATH."/controllers/checkSetup.php";
require_once APPPATH."/controllers/pages.php";
define('ADMIN_ROLE_ID', 1); // it's the first role created so it's 1

class Install extends CI_Controller {

	public function __construct() {
  	parent::__construct();
    where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
    $this->load->helper('url');
    $this->load->library('bcrypt');
  	$this->i18n->setLocaleEnv($this->config->item('probe:locale'), 'global');
	}

	private function startSetup() {
    where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		# show form if config file missing
    if (!file_exists(APPPATH."config/db-default.php")) {
      // $this->requestDsnForConfigDb();
      redirect("install/dbms");
    } else { # file exists, 
      try { # connect to the db and check if there is any admin user
        $sqlCountAdmin = "SELECT COUNT(*) AS `AdminCount`
          FROM `TA_USER` INNER JOIN `TR_ROLE`
          ON `TA_USER`.`ROL_ID` = `TR_ROLE`.`ROL_ID` 
          WHERE `TR_ROLE`.`ROL_CODE` = 'admin' 
          LIMIT 1;";
          
        $this->load->database();
        $row = $this->db->query($sqlCountAdmin)->row();

        // log_message('info', $row->AdminCount );
        if ($row->AdminCount == 0) { # no admin yet
          redirect("install/adminUser");
        }
      } catch (Exception $e) {
        // sprintf("<p>%s</p>",  sprintf('%s', i18n("error.install.dbms.connect") ) );
        log_message('error', sprintf('%s', i18n("error.install.dbms.connect") ) );
      }
    }
  }

  /* CI require a landing function called: 'index' */
  public function index() {
    where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$this->startSetup(); }
  

  /* alias method to have nice URL */
  public function dbms() {
    where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$this->requestDsnForConfigDb(); }
  /*
  * View: form to request the application administrator's credentials.
  */
  public function requestDsnForConfigDb() {
    where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$this->load->helper('pages');
    $this->load->helper(array('form'));
    $this->load->library('form_validation');

    // build view data
    $data = pageFetchConfig('setup-dbms'); // fetch information to build the HTML header
    $data['dbmsUsername'] = null;
    $data['dbmsPassword'] = null;
    $data['dbmsHost'] = null;
    $data['dbmsPort'] = 3306;
    $data['dbmsDatabaseName'] = $this->config->item('mainDb');
    
    // display the view
    $pages = new Pages();
    $pages->view('install/dbms', $data);
  }


  /*
  * Model: create the database and relative configuration' files
  */
  function setupDbms() {
    where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
	  require_once(BASEPATH.'core/Model.php'); // need for load models manualy
    require_once(APPPATH.'models/db_builder.php');

    $dbEngine=$this->input->post('dbms-engine');
    $dbUserName=$this->input->post('dbms-username');
    $dbUserPassword=$this->input->post('dbms-password');
    $dbHost=$this->input->post('dbms-host');
    $dbPort=$this->input->post('dbms-port');

    try {
      $this->dbb = new db_builder($dbEngine, $dbUserPassword, $dbUserName, $dbHost, $dbPort);

      $this->dbb->createAppDb();
      $dns = $this->dbb->getDsn();

      saveDataOnFile(APPPATH.'config/db-default', $dns, FORMAT_PHP, "db['default']");
      redirect("install/adminUser");
    } catch (Exception $e) {
        log_message('db',  $e->getMessage() );
    }
  }


  /* alias method to have nice URL */
  public function adminUser() {
    where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$this->requestCredentialsForAdminUser(); }
  /*
  * View: form to request the application administrator's credentials.
  */
  public function requestCredentialsForAdminUser() {
    where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$this->load->helper('pages');
    $this->load->helper(array('form'));
    $this->load->library('form_validation');

    // build view data
    $data = pageFetchConfig('setup-admin-user'); // fetch information to build the HTML header
    $data['administratorUsername'] = NULL;
    $data['administratorPassword'] = NULL;
    $data['administratorPasswordConfirmation'] = NULL;
    
    // display the view
    $pages = new Pages();
    $pages->view('install/admin-user', $data);
  }


	function setupAdministrator() {
    where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$administratorUsername = $this->input->post('administrator-username');
    $administratorPassword = $this->input->post('administrator-password');
    $administratorPasswordConfirmation  = $this->input->post('administrator-password-confirmation');

    if ($administratorPassword == $administratorPasswordConfirmation) {
      $this->load->model('service/Service_User');

      try {
        //Chercher l'user correspondant au couple login/pwd
        $user = $this->Service_User->register(
          $administratorUsername, $administratorPassword,
          null, // $firstName
          null, // $familyName
          null, // $email
          ADMIN_ROLE_ID // $role
        );
        // $this->session->set_userdata("user", serialize($user));
        redirect("admin");
      }
      catch(BusinessException $be) {
        //Message d'erreur dans la variable "msg" de la session. Impossible d'utiliser flashdata car il y a 2 redirections en cas d'erreur de login
        // $this->session->set_userdata("msg", $be->getMessage());
        log_message('error', $be->getMessage());
      }
    }
	}
}