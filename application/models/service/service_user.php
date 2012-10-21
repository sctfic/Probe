<?php
require_once APPPATH."models/service/service.php";

class Service_User extends Service {
    function __construct() {
        parent::__construct();

        //Daos
        $this->load->model('dao/Dao_User');
        $this->load->library('encrypt');
        $this->encrypt->set_cipher();
    }

	/*
	* return an User object when for authentified user, otherwise throw an error
	*/
    public function authentify($userName, $userPassword) {
        $this->load->library('encrypt');
    	$user = $this->Dao_User->read($userName, $this->encrypt->encode($userPassword) );

    	if($user == NULL) {
    		throw new BusinessException( i18n('login.fail.username.password.incorrect') );
    	}

    	$user->setAuthentified(true);
    	return $user;
    }

    /*
    * return an User object when for authentified user, otherwise throw an error
    */
    public function register($userName, $userPassword) {
        include_once(APPPATH.'libraries/PROBE_rev_crypt.php');
        $this->load->library('encrypt');
        $user = $this->Dao_User->read($userName, $this->encrypt->encode($userPassword) );

        if($user == NULL) {
            throw new BusinessException( i18n('login.fail.username.password.incorrect') );
        }

        $user->setRegistered(true);
        return $user;
    }
}
?>