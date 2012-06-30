<?php

require_once APPPATH."models/dao/daodatabase.php";
require_once APPPATH."annotation/MyORM.php";

class DaoUtilisateur extends DaoDatabase {
    function __construct() {
        parent::__construct();
    }
    
    public function lire($login, $mdp) {
    	$utilisateur = NULL;    	
    	$sql = "SELECT * FROM TA_UTILISATEUR WHERE UTI_LOGIN=:login AND UTI_MDP=:mdp";
    	$res = $this->wswdspdo->query($sql, array(":login" => $login, ":mdp" => $mdp));

    	// Si un utilisateur correspond à ces identifiants
         if($res->rowCount() > 0) {
    		$u = $res->firstRow();
         	$utilisateur = Utilisateur::fromBD($u);
         }

        return $utilisateur;
    }

}
?>