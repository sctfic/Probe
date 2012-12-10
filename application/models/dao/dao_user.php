<?php

// require_once APPPATH."models/dao/dao_database.php";
require_once APPPATH."annotation/MyORM.php";

class Dao_User extends CI_Model {
	function __construct() {
		parent::__construct();
		try {
			$this->load->database();
		} catch (Exception $e) {}
	}

/*
* @description: try to read if there is a given user whom Username and password match.
* @param: $userName, string
* @param: $userPassword, string
* @return: Array(
				[USR_ID]=>43
				[USR_USERNAME]=>me
				[USR_PWD]=>$2a$08$arNx0pEHouyxd8YyilkFy.zTlbKQJV387ljE/Pbb249rcUGSi90wG
				[USR_FIRST_NAME]=>
				[USR_EMAIL]=>me@mail.com
				[ROL_ID]=>1
				[USR_FAMILY_NAME]=>)
*/
	public function read($userName, $userPassword) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$user = NULL;
		try {
			$this->db->where('USR_USERNAME', $userName);
			// $this->db->where('USR_PWD', $userPassword); // password valitity is tested later
 			$this->db->limit(1);

			$query = $this->db->get('TA_USER');

			// only return the first user matching this user/password credentials
			$user = $query->row_array();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		return $user;
	}


/*
* @description: try to read if there is an admin user for this application
*/
	public function readAdmin() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$admin = NULL;
		try {
			$this->db->select('COUNT(ROL_CODE) AS `count`');
			$this->db->from('TA_USER');
			$this->db->join('TR_ROLE', 'TA_USER.ROL_ID = TR_ROLE.ROL_ID');
			$this->db->where('TR_ROLE.ROL_CODE', ADMIN_ROLE_CODE );
 			$this->db->limit(1);

			$query = $this->db->get();

			// only return the first admin matching this admin/password credentials
			$admin = $query->row_array(); //array of arrays
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		return $admin;
	}


/*
* @description: insert new user in the database with given credentials 
and role.
* @param: $userName, string
* @param: $userPassword, string
* @param: $firstName, string
* @param: $familyName, string
* @param: $email, valid email adress
* @param: $role, integer
*/
	public function write($userName, $userPassword, $firstName, $familyName, $email, $role) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$user = FALSE;

		try {
			if ( !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE )
			{
				throw new InvalidArgumentException(i18n("error.user-creation.invalid.email"));
			}

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

		} catch (InvalidArgumentException $e) {
			echo $e->getMessage() ;
		} catch (Exception $e) {
			echo $e->getMessage() ;
		}

		return $user;
	}
}
?>