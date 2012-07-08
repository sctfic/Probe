<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/controllers/authentification.php";
require_once APPPATH."/controllers/pages.php";
class Admin extends Authentification {

	/**
	 * Url sur laquelle l'user sera redirigé une fois connecté
	 * Les classes filles peuvent la redéfinir. Par défaut, la redirection se fait sur "base_url"
	 * @var String
	 */
	protected $urlWhenLogged= NULL; # when user is authentified go to this URL

	public function __construct() {
		parent::__construct();

		$this->i18n->setLocaleEnv($this->config->item('ws:locale'), 'global'); // set language
		$this->encrypt->set_cipher(MCRYPT_BLOWFISH);

		//Modèles
		$this->load->model('service/Service_User');

		// set URL to login page (not yet authentified)
		$this->urlConnexion = $this->config->item('admin_connexion');
		// set URL to redirect to when user is authentified
		$this->urlWhenLogged 	= $this->config->item('admin_dashboard');
		$this->checkConnexionStatus();
	}

	public function index() {
		$this->lang->load('admin', 'french');

		echo "PAGE ACCUEIL ADMIN : ".$this->lang->line('admin.bienvenue');
	}

	/*
	* Login interface for unknown/authentified user
	* see Authentification.php for the abstract class
	*/
	public function connexion() {
		// requirements
		$this->load->helper('pages');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		// build view data
		$data = pageFetchConfig('login'); // fetch information to build the HTML header
		$data['msg'] = $this->session->userdata("msg"); // message to display in the page
		$data['username'] = NULL;

		$this->session->set_userdata("msg", NULL); // reset session message

		// form control
		$this->form_validation->set_rules('username', i18n('Username'), 'required');
		$this->form_validation->set_rules('password', i18n('Password'), 'required');
		$this->form_validation->set_rules('confirm', i18n('Password Confirmation'), 'required');

		// display the view
		$pages = new Pages();
		$pages->view('login', $data);
	}

	/*
	* Redirect user depending on its credentials validation
	* see Authentification.php for the abstract class
	*/
	public function connect() {
		$username 	=  	$this->input->get('username');
		$pwd 			=  	$this->input->get('password');

		try {
			//Chercher l'user correspondant au couple login/pwd
		  $user = $this->Service_User->authentify($username, $pwd);
			$this->session->set_userdata("user", serialize($user));
		}
		catch(BusinessException $be) {
			//Message d'erreur dans la variable "msg" de la session. Impossible d'utiliser flashdata car il y a 2 redirections en cas d'erreur de login
			$this->session->set_userdata("msg", $be->getMessage());
		}

		redirect($this->urlWhenLogged);
	}
}