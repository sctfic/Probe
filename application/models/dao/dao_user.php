<?php

require_once APPPATH."models/dao/dao_database.php";
require_once APPPATH."annotation/MyORM.php";

class Dao_User extends Dao_Database {
    function __construct() {
        parent::__construct();
    }

    public function read($userName, $pwd) {
    	$user = NULL;
    	$sql = "SELECT * FROM TA_USER WHERE USR_USERNAME=:username AND USR_PWD=:pwd";
    	$res = $this->probepdo->query($sql, array(
    			":username" => $userName,
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

    public function write($userName, $pwd) {
        $user = false;

        $sql = "INSERT INTO `TA_USER` (:username, :pwd);";
        $res = $this->probepdo->query($sql, array(
                ":username" => $userName,
                ":pwd" => $pwd
            )
        );

        // Si un user est bien insérer.
        if($res->rowCount() > 0) {
            $user = $this->read($userInserted, $pwd);
        }
        return $user;
    }
}
?>