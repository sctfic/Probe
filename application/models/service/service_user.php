<?php
require_once APPPATH."models/service/service.php";

class Service_User extends Service {
	function __construct() {
		parent::__construct();

		//Daos
		$this->load->model('dao/Dao_User');
		$this->load->library('encrypt');
		$this->encrypt->set_cipher(MCRYPT_BLOWFISH);
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

		$user['Authentified']=true;

		return $user;
	}

	/*
	* return an User object when for authentified user, otherwise throw an error
	*/
	public function register($userName, $userPassword, $firstName = null, $familyName = null, $email = null, $role = 0) {
		$this->load->library('encrypt');
		$user = $this->Dao_User->write(
			$userName, 
			$this->encrypt->encode($userPassword),
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