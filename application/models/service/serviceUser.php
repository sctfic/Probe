<?php
require_once APPPATH."models/service/service.php";

class ServiceUser extends Service {
    function __construct() {
        parent::__construct();

        //Daos
        $this->load->model('dao/daoUser');
    }

    public function authentifier($login, $mdp) {
    	$mdpCrypte = md5($mdp);
    	$user = $this->daoUser->lire($login, $mdpCrypte);

    	if($user == NULL) {
    		throw new BusinessException('Login ou mot de passe incorrect');
    	}

    	$user->setAuthentifie(true);
    	return $user;
    }

}
?>