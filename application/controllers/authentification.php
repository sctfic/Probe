<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class Authentification extends CI_Controller {
	/**
	 * Url sur laquelle l'utilisateur sera redirigé s'il n'est pas loggué.
	 * Les classes filles peuvent la redéfinir. Par défaut, la redirection se fait sur "base_url"
	 * @var String
	 */
	protected $urlConnexion = NULL;
	
	
	/**
	 * Utilisateur connecté
	 * @var utilisateur
	 */
	protected $utilisateur = NULL;
	
	
	/**
	 * Vérifie que le client est loggué. S'il ne l'ai pas redirige vers la page de login définie dans le fichier de config 'authentification_url'
	 */
	public function __construct() {		
		parent::__construct();
		
		// Si url pas redéfini par les classes fille alors url par défaut
		if($this->urlConnexion == NULL) {
			$this->urlConnexion = $this->config->item('base_url');
		}
		
		//Récupération de l'utilisateur en session
		$this->utilisateur = unserialize($this->session->userdata('utilisateur'));
		
	}
	
	/**
	 * Vérifie que l'utilisateur est connecté. S'il ne l'ai pas, redirige vers la page prévu à cet effet.
	 * Ne vérifie pas l'authent sur la page affichant le formulaire "connexion"
	 */
	public function verificationConnexion() {
		$methode = $this->router->fetch_method();
		
		if($methode != "connexion" && $methode != "connecter") {
			if($this->utilisateur == NULL || !$this->utilisateur->isAuthentifie()) {
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
	 * Permet d'authentifier l'utilisateur sur le système.
	 */
	public abstract function connecter();
	
	/**
	 * Permet de déconnecter l'utilisateur du système et redirige vers l'url d'accueil du site "base_url"
	 */
	public function deconnecter() {
		$this->session->unset_userdata("utilisateur");
		redirect($this->config->item('base_url'));
	}
}