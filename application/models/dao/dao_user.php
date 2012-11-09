<?php

// require_once APPPATH."models/dao/dao_database.php";
require_once APPPATH."annotation/MyORM.php";

class Dao_User extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function read($userName, $userPassword) {
		$user = NULL;
		try {
			$this->db->where(array(
					'USR_USERNAME' => $userName,
					'USR_PWD' => $userPassword
					)
				);
			$users = $this->db->get('TA_USER')->result_array();

			// $users = $query->result_array(); //array of arrays

		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}
		return $users;
	}

	public function write($userName, $userPassword, $firstName, $familyName, $email, $role) {
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

			// Si un user est bien insérer.
			if ($added)
				$user = $this->read($userName, $userPassword);

		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}
		return $user;
	}
}
?>