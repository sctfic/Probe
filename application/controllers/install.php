<?php
/**
* Manage the installation and configuration of the application
*
* @category Install
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */
// namespace Probe\Install;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once APPPATH."/controllers/checkSetup.php";

/**
* Manage the installation and configuration of the application
*
* @category Install
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */

class Install extends CI_Controller {
    /*
     * data for the breadcrumbs related to installation
     */
    protected  $_breadcrumb = array(
        'dbms' =>  array(
            array(
                'status' => 'active',
                'url' => '/install/dbms',
                'i18n' => 'install.dbms.breadcrumb'
            ),
            'install.administrator.breadcrumb',
            'install.login.breadcrumb'
        ),
        'admin-user' => array(
            array(
                'url' => '/install/dbms',
                'i18n' => 'install.dbms.breadcrumb',
            ),
            array(
                'status' => 'active',
                'url' => '/install/admin-user',
                'i18n' => 'install.administrator.breadcrumb',
            ),
            'install.login.breadcrumb'
        )
    );

    /**
     * entry point
     */
    public function __construct()
    {
        parent::__construct();
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());

        $this->load->helper('url');
        $this->load->library('Page_manager');
        $this->i18n->setLocaleEnv($this->config->item('probe:locale'), 'global');

        if (file_exists(APPPATH."config/db-default.php")) {
            try {
                $this->load->database();
            } catch (Exception $e) {
                show_error(
                    array(
                        'error-title' => i18n('error.database.unreachable.title'),
                        'error-description' => i18n('error.database.unreachable'),
                        'error-solution' => i18n('solution.database.unreachable')
                        ),
                    500,
                    i18n('error.database.unreachable.header')
                );
            }
        }
    }

    /**
     * TODO: try not to use redirect() method for redirect
     * entry point to the install process.
     * CI entry point
     *
     * @return void redirect to next step
     */
    public function index()
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());

        // show form if config file missing
        if (!file_exists(APPPATH."config/db-default.php")) {
            redirect("install/dbms");
        } else { // file exists
            redirect("install/admin-user");
        }
    }

    /**
    * check if it's necessary to display the 'dbms setup' screen.
    * Otherwise continue to 'admin setup'  screen.
    *
    * @return view admin-user or dbms configuration view
    */
    public function dbms()
    {
            where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());

        if (file_exists(APPPATH."config/db-default.php")) {
            redirect('install/admin-user');
        }

        $this->_requestDsnForConfigDb();
    }

    /**
     * View: form to request the application administrator's credentials.
     *
     * @return view dbms view
     */
    private function _requestDsnForConfigDb()
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());

        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $page = new Page_manager();

        // build view data
        $page->addData('breadcrumb', $this->_breadcrumb['dbms'] );
        $page->addData('dbmsUsername', null );
        $page->addData('dbmsPassword', null );
        $page->addData('dbmsHost', null );
        $page->addData('dbmsPort', 3306 );
        $page->addData('dbmsDatabaseName', $this->config->item('mainDb') );
        $page->addMetadata('install-dbms'); // fetch information to build the HTML header

        // display the view
        $page->view('install/dbms');
    }

    /**
     * create the database and relative configuration' files
     *
     * @return string DNS
     */
    public function setupDbms()
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());
        include_once BASEPATH.'core/Model.php'; // need for load models manualy
        include_once APPPATH.'models/db_builder.php';

        $dbEngine=$this->input->post('dbms-engine');
        $dbUserPassword=$this->input->post('dbms-password');
        $dbUserName=$this->input->post('dbms-username');
        $dbHost=$this->input->post('dbms-host');
        $dbPort=$this->input->post('dbms-port');

        try {
            $this->dbb = new db_builder($dbEngine, $dbUserPassword, $dbUserName, $dbHost, $dbPort);

            $this->dbb->createAppDb(APP_DB);
            $dns = $this->dbb->getDsn();

            saveDataOnFile(APPPATH.'config/db-default', $dns, FORMAT_PHP, "db['default']");
            redirect("install/admin-user");
        } catch (Exception $e) {
            log_message('db',  $e->getMessage());
            show_error(
                array(
                    'error-title' => i18n('error.database.access-denied.title'),
                    'error-description' => i18n('error.database.access-denied'),
                    'error-solution' => i18n('solution.database.access-denied')
                ),
                500,
                i18n('error.database.access-denied.header')
            );
        }
    }


    /**
    * check if it's necessary to display the 'admin setup' screen.
    * Otherwise continue to 'login' screen.
    *
    * @return view admin-user or login form
    */
    public function adminUser()
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());

        try {
            $this->load->model('dao/Dao_User');
            $admin = $this->Dao_User->readAdmin();

            if ($admin['count'] > 0) {
                redirect("admin/admin/connexion");
            }
        } catch (Exception $e) {
            log_message('error', sprintf('%s', i18n("error.install.admin.exists")));
        }
        $this->_requestCredentialsForAdminUser();
    }

    /**
    * form to request the application administrator's credentials.
    *
    * @return view admin-user form
    */
    private function _requestCredentialsForAdminUser()
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());

        try {
            $this->load->database();
        } catch (Exception $e) {
            ;
        }

        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $page = new Page_manager();

        // build view data
        $page->addData('breadcrumb', $this->_breadcrumb['admin-user'] );
        $page->addData('adminUsername', null );
        $page->addData('adminPassword', null );
        $page->addData('adminConfirm', null );
        $page->addMetadata('install-admin-user'); // fetch information to build the HTML header

        // display the view
        $page->view('install/admin-user');
    }

    /**
     * Register administrator user
     *
     * @return view [description]
     */
    public function setupAdministrator()
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());
        $adminUsername = $this->input->post('admin-username');
        $adminPassword = $this->input->post('admin-password');
        $adminConfirm  = $this->input->post('admin-password-confirmation');

        if ($adminPassword == $adminConfirm) {
            $this->load->model('service/Service_User');

            try {
                //Chercher l'user correspondant au couple login/pwd
                $this->Service_User->register(
                    $adminUsername, $adminPassword,
                    null, // $firstName
                    null, // $familyName
                    null, // $email
                    ADMIN_ROLE_ID // $role
                );
                // $this->session->set_userdata("user", serialize($user));
                redirect("admin");
            } catch (BusinessException $be) {
                //Message d'erreur dans la variable "msg" de la session. Impossible d'utiliser flashdata car il y a 2 redirections en cas d'erreur de login
                // $this->session->set_userdata("msg", $be->getMessage());
                log_message('error', $be->getMessage());
            }
        }
    }
}
