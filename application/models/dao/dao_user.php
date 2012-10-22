<?php

require_once APPPATH."models/dao/dao_database.php";
require_once APPPATH."annotation/MyORM.php";

class Dao_User extends Dao_Database {
    function __construct() {
        parent::__construct();
    }

    public function read($userName, $userPassword) {
    	$user = NULL;
    	$sql = "SELECT * FROM TA_USER WHERE USR_USERNAME=:username AND USR_PWD=:pwd";
    	$res = $this->probepdo->query($sql, array(
    			":username" => $userName,
    			":pwd" => $userPassword
			)
    	);

    	// Si un user correspond à ces identifiants
         if($res->rowCount() > 0) {
    		$u = $res->firstRow();
         	$user = User::fromBD($u);
         }

        return $user;
    }

    public function write($userName, $userPassword, $firstName, $familyName, $email, $role) {
        $user = false;

        $sql = "INSERT INTO `probe`.`TA_USER` (
                `USR_ID` ,
                `USR_USERNAME` ,
                `USR_PWD` ,
                `USR_FIRST_NAME` ,
                `USR_FAMILY_NAME`,
                `USR_EMAIL` ,
                `ROL_ID`
                )
                VALUES (
                NULL , 
                ':userName', 
                ':userPassword', 
                ':firstName', 
                ':familyName',
                ':email', 
                ':role'
            );";
        $res = $this->probepdo->query($sql, array(
                ":userName" => $userName,
                ":userPassword" => $userPassword,
                ':firstName' => $firstName, 
                ':familyName' => $familyName,
                ':email' => $email, 
                ':role' => $role
            )
        );

        // Si un user est bien insérer.
        if($res->rowCount() > 0) {
            $user = $this->read($userInserted, $userPassword);
        }
        return $user;
    }
}
?>