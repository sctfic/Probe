<?php
require_once APPPATH."models/service/service.php";

class Service_User extends Service {
    function __construct() {
        parent::__construct();

        //Daos
        $this->load->model('dao/Dao_User');
    }

	/*
	* return an User object when for authentified user, otherwise throw an error
	*/
    public function authentify($username, $pwd) {
    	$encryptedPwd = md5($pwd);
    	$user = $this->Dao_User->lire($username, $encryptedPwd);

    	if($user == NULL) {
    		throw new BusinessException( i18n('login.fail.username.password.incorrect') );
    	}

    	$user->setAuthentifie(true);
    	return $user;
    }

}
?>