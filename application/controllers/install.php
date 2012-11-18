<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once APPPATH."/controllers/checkSetup.php";
require_once APPPATH."/controllers/pages.php";


class Install extends CI_Controller {

  public function __construct() {
    parent::__construct();
    where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

    $this->load->helper('url');
    $this->load->library('bcrypt');
    $this->i18n->setLocaleEnv($this->config->item('probe:locale'), 'global');

    if (file_exists(APPPATH."config/db-default.php")) {
      try {
        $this->load->database();
      } catch (Exception $e) { 
        show_error( array(
            'error-title' => i18n('error.database.unreachable.title'),
            'error-description' => i18n('error.database.unreachable'),
            'error-solution' => i18n('solution.database.unreachable')
          ),
          500,
          i18n('error.database.unreachable.header')
        ); 
        // show_error($e->getMessage(), 500, 'test'); 
      }
    }
  }


  /* 
  * TODO: try not to use redirect() method for redirect
  * @description: entry point to the install process
      CI require a landing function called: 'index' 
  */
  public function index() {
    where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

		# show form if config file missing
    if (!file_exists(APPPATH."config/db-default.php")) {
      // $this->requestDsnForConfigDb();
      redirect("install/dbms");
    } else { # file exists, 
      redirect("install/admin-user");
    }
  }


/**
* @description: check if it's necessary to display the 'dbms setup' screen. 
*   Otherwise continue to 'admin setup'  screen.
**/
  public function dbms() {
    where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

    if (file_exists(APPPATH."config/db-default.php")) {
      redirect('install/admin-user');
    }

  	$this->requestDsnForConfigDb(); 
  }

/**
* View: form to request the application administrator's credentials.
**/
  private function requestDsnForConfigDb() {
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


  /**
  * @description: create the database and relative configuration' files
  **/
  public function setupDbms() {
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
      redirect("install/admin-user");
    } catch (Exception $e) {
        log_message('db',  $e->getMessage() );
    }
  }


  /**
  * @description: check if it's necessary to display the 'admin setup' screen. 
  *   Otherwise continue to 'login' screen.
  **/
  public function adminUser() {
    where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

    try {
      $this->load->model('dao/Dao_User');
      // $this->load->database();
      $admin = $this->Dao_User->readAdmin();

      if ($admin['count'] > 0) {
        redirect("admin/admin/connexion");
      } 
    } catch (Exception $e) {
      log_message('error', sprintf('%s', i18n("error.install.admin.exists") ) );
    }
		$this->requestCredentialsForAdminUser(); 
  }

  /**
  * @description: form to request the application administrator's credentials.
  **/
  private function requestCredentialsForAdminUser() {
    where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

    try {
      $this->load->database();
    } catch (Exception $e) {
      show_error(i18n('error.database.unreachable====')); 
    }

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


	public function setupAdministrator() {
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