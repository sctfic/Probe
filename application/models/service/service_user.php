<?php
require_once APPPATH."models/service/service.php";

class Service_User extends Service {
	function __construct() {
		parent::__construct();

		//Daos
		$this->load->model('dao/Dao_User');
		$this->load->library('bcrypt');
	}

	/*
	* return an User object when for authentified user, otherwise throw an error
	*/
	public function authentify($userName, $password) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$matchingUser = $this->Dao_User->read($userName, $password );
		if(!isset($matchingUser) || empty($matchingUser) || $this->bcrypt->check_password($password, $matchingUser['USR_PWD'])==false) {
			throw new BusinessException( i18n('login.fail.username.password.incorrect') );
		}
		$user = $matchingUser;
		$user['Authentified']=true;
		return $user;
	}

	/*
	* return an User object when for authentified user, otherwise throw an error
	*/
	public function register($userName, $userPassword, $firstName = null, $familyName = null, $email = null, $role = 0) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$user = $this->Dao_User->write(
			$userName, 
			$this->bcrypt->hash_password($userPassword),
			$firstName, 
			$familyName, 
			$email, 
			$role
		);
		if($user == NULL) {
			throw new BusinessException( i18n('register.fail.username.password.incorrect') );
		}
		$user['Registered']=true;
		return $user;
	}
}
?>