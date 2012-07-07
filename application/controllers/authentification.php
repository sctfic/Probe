<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class Authentification extends CI_Controller {
	/**
	 * Url sur laquelle l'user sera redirigé s'il n'est pas loggué.
	 * Les classes filles peuvent la redéfinir. Par défaut, la redirection se fait sur "base_url"
	 * @var String
	 */
	protected $urlConnexion = NULL;


	/**
	 * User connecté
	 * @var user
	 */
	protected $user = NULL;


	/**
	 * Vérifie que le client est loggué. S'il ne l'ai pas redirige vers la page de login définie dans le fichier de config 'authentification_url'
	 */
	public function __construct() {
		parent::__construct();

		$this->load->helper('url');

		// Si url pas redéfini par les classes fille alors url par défaut
		if($this->urlConnexion == NULL) {
			$this->urlConnexion = $this->config->item('base_url');
		}

		//Récupération de l'user en session
		$this->user = unserialize($this->session->userdata('user'));

	}

	/**
	 * Vérifie que l'user est connecté. S'il ne l'ai pas, redirige vers la page prévu à cet effet.
	 * Ne vérifie pas l'authe sur la page affichant le formulaire "connexion"
	 */
	public function checkConnexionStatus() {
		// Detect the method that called this one
		// see: Codeigniter: Redirecting from construct in Controller http://stackoverflow.com/a/3364878
		$methode = $this->router->fetch_method();

		// when user is unknown/NULL, we redirect him to the login page
		if($methode != "connexion" && $methode != "connecter") {
			if($this->user == NULL || !$this->user->isAuthentified()) {
				redirect($this->urlConnexion);
				exit();
			}
		}
	}


	/**
	 * Affiche le formulaire de login
	 */
	public abstract function connexion();

	/**
	 * Permet d'authentifier l'user sur le système.
	 */
	public abstract function connect();

	/**
	 * Permet de déconnecter l'user du système et redirige vers l'url d'accueil du site "base_url"
	 */
	public function deconnecter() {
		$this->session->unset_userdata("user");
		redirect($this->config->item('base_url'));
	}
}