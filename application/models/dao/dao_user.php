<?php

// require_once APPPATH."models/dao/dao_database.php";
require_once APPPATH."annotation/MyORM.php";

class Dao_User extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function read($userName, $userPassword) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$user = NULL;
		try {
			$this->db->where(array(
					'USR_USERNAME' => $userName,
					'USR_PWD' => $userPassword
					)
				);
			$query = $this->db->get('TA_USER');

			// on ne retournera que le 1er users qui as ces identifiants et mdp
			$user = $query->row_array(); //array of arrays
		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}
		return $user;
	}

	public function write($userName, $userPassword, $firstName, $familyName, $email, $role) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$user = false;
		try {
			$added = $this->db->insert(
				'TA_USER',
				array(
					"USR_USERNAME" => $userName,
					"USR_PWD" => $userPassword,
					'USR_FIRST_NAME' => $firstName, 
					'USR_FAMILY_NAME' => $familyName,
					'USR_EMAIL' => $email, 
					'ROL_ID' => $role
					));

			if ($added==1) // Si un user est bien insérer
				$user = $this->read($userName, $userPassword);

		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}
		return $user;
	}
}
?>