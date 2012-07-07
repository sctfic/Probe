<?php

require_once APPPATH."models/dao/dao_database.php";
require_once APPPATH."annotation/MyORM.php";

class Dao_User extends Dao_Database {
    function __construct() {
        parent::__construct();
    }

    public function lire($login, $mdp) {
    	$user = NULL;
    	$sql = "SELECT * FROM TA_UTILISATEUR WHERE UTI_LOGIN=:login AND UTI_MDP=:mdp";
    	$res = $this->wswdspdo->query($sql, array(":login" => $login, ":mdp" => $mdp));

    	// Si un user correspond à ces identifiants
         if($res->rowCount() > 0) {
    		$u = $res->firstRow();
         	$user = User::fromBD($u);
         }

        return $user;
    }

}
?>