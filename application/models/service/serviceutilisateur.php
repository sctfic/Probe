<?php
require_once APPPATH."models/service/service.php";

class ServiceUtilisateur extends Service {
    function __construct() {
        parent::__construct();
        
        //Daos
        $this->load->model('dao/daoutilisateur');
    }
    
    public function authentifier($login, $mdp) {
    	$mdpCrypte = md5($mdp);
    	$utilisateur = $this->daoutilisateur->lire($login, $mdpCrypte);
    	
    	if($utilisateur == NULL) {
    		throw new BusinessException('Login ou mot de passe incorrect');
    	}

    	$utilisateur->setAuthentifie(true);
    	return $utilisateur;
    }

}
?>