<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once APPPATH."/controllers/checkSetup.php";
require_once APPPATH."/controllers/pages.php";


class Installer extends CI_Controller {

	public function __construct() {
  	parent::__construct();
    $this->load->helper('url');

  	$this->i18n->setLocaleEnv($this->config->item('probe:locale'), 'global');
	}

	private function startSetup() {
    $this->load->helper('url');
    # show form if config file missing
    if (!file_exists(APPPATH."config/db-default.php")) {
      // $this->requestDsnForConfigDb();
      redirect("setup/installer/dbms");
    } else { # file exists, 
      try { # connect to the db and check if there is any admin user
    log_message('loader',  __FUNCTION__.'('.__CLASS__.")\n".__FILE__.' ['.__LINE__.']');
        $this->load->database();
        $query = $this->query("SELECT COUNT(*) AS `AdminCount`
          FROM `TA_USER` INNER JOIN `TR_ROLE`
          ON `TA_USER`.`ROL_ID` = `TR_ROLE`.`ROL_ID` 
          WHERE `TR_ROLE`.`ROL_CODE` = 'admin';"
        );
        if (count($query->result_array()) == 0) { # no admin yet
          $this->requestCredentialsForAdminUser();
        }
      } catch (Exception $e) {
        log_message('error', printf('%s', i18n("error.setup.dbms.connect") ) );
      }
    }
  }

  /* CI require a landing function called: 'index' */
  public function index() { $this->startSetup(); }
  

  /* alias method to have nice URL */
  public function dbms() { $this->requestDsnForConfigDb(); }
  /*
  * View: form to request the application administrator's credentials.
  */
  public function requestDsnForConfigDb() {
    $this->load->helper('pages');
    $this->load->helper(array('form', 'url'));
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
    $pages->view('setup/dbms', $data);
  }


  /*
  * Model: create the database and relative configuration' files
  */
  function setupDbms() {
    $this->load->helper('url');
    require_once(BASEPATH.'core/Model.php'); // need for load models manualy
    require_once(APPPATH.'models/db_builder.php');

    $dbEngine=$this->input->post('dbms-engine');
    $userName=$this->input->post('dbms-username');
    $userPassword=$this->input->post('dbms-password');
    $dbHost=$this->input->post('dbms-host');
    $dbPort=$this->input->post('dbms-port');

    try {
    log_message('db',  __FUNCTION__.'('.__CLASS__.")\n".__FILE__.' ['.__LINE__.']'.$dbEngine.' - '.$userPassword.' - '.$userName.' - '.$dbHost.' - '.$dbPort);

      $this->dbb = new db_builder($dbEngine, $userPassword, $userName, $dbHost, $dbPort);

      $this->dbb->createAppDb();
      $dns = $this->dbb->getDsn();
      array2conf_php(APPPATH.'config/db-default.php', $dns, "db['default']");
      redirect("setup/installer/adminUser");
    } catch (Exception $e) {
        log_message('db',  $e->getMessage() );
    }
  }


  /* alias method to have nice URL */
  public function adminUser() { $this->requestCredentialsForAdminUser(); }
  /*
  * View: form to request the application administrator's credentials.
  */
  public function requestCredentialsForAdminUser() {
    $this->load->helper('pages');
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');

    // build view data
    $data = pageFetchConfig('setup-admin-user'); // fetch information to build the HTML header
    $data['administratorUsername'] = NULL;
    $data['administratorPassword'] = NULL;
    $data['administratorPasswordConfirmation'] = NULL;
    
//     redirect("admin/admin"); // ca c l'ancien avec le soleil
    // display the view
    $pages = new Pages();
    $pages->view('setup/admin-user', $data);
  }


	function setupAdministrator() {
    $administratorUsername = $this->input->post('administrator-username');
    $administratorPassword = $this->input->post('administrator-password');
    $administratorPasswordConfirmation  = $this->input->post('administrator-password-confirmation');

    if ($administratorPassword == $administratorPasswordConfirmation) {
      $this->load->model('service/Service_User');

      try {
        //Chercher l'user correspondant au couple login/pwd
        $user = $this->Service_User->register($administratorUsername, $administratorPassword);
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