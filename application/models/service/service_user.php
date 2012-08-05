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
    	include_once(APPPATH.'libraries/WS_rev_crypt.php');
    	$crypt = new WS_rev_crypt('db-default');
    	$encryptedPwd = $crypt->code($pwd);
    	$user = $this->Dao_User->read($username, $encryptedPwd);

    	if($user == NULL) {
    		throw new BusinessException( i18n('login.fail.username.password.incorrect') );
    	}

    	$user->setAuthentified(true);
    	return $user;
    }

}
?>