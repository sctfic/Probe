<?php

require_once APPPATH."models/dao/dao_database.php";
require_once APPPATH."annotation/MyORM.php";

class Dao_User extends Dao_Database {
    function __construct() {
        parent::__construct();
    }

    public function read($username, $pwd) {
    	$user = NULL;
    	$sql = "SELECT * FROM TA_USER WHERE USR_USERNAME=:username AND USR_PWD=:pwd";
    	$res = $this->probepdo->query($sql, array(
    			":username" => $username,
    			":pwd" => $pwd
			)
    	);

    	// Si un user correspond à ces identifiants
         if($res->rowCount() > 0) {
    		$u = $res->firstRow();
         	$user = User::fromBD($u);
         }

        return $user;
    }

}
?>