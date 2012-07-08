<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| Configuration for the WsWds application.
*/

// $config['wswds:username'] = 'edouard.lopez';
$config['ws:username'] = '';
// $config['wswds:password'] = 'edouard.lopez';
$config['ws:password'] = '';

// Locale/language to use for the interface
$config['ws:locale'] = 'fr';


// Url de redirection de la partie admin
$config['admin_home']	= "/admin/admin/";				// Page d'accueil de l'admin une fois l'authentification reussit
$config['admin_connexion']	= "/admin/admin/connexion";		// Page de connexion de l'admin. L'utilisateur sera redirigé vers cette page s'il tente d'accéder à une page de l'admin


$config['require_directories']	= array("entity", "exceptions");
$config['require_blacklist'] = array( "Address");







//###################################### REQUIRES ######################################
$absoluteAppPath = str_replace(
        end(explode('/', $_SERVER['SCRIPT_FILENAME'])),
        '',
        $_SERVER['SCRIPT_FILENAME']
    )
    .''.APPPATH;
// echo $absoluteAppPath."<br/>";


foreach($config['require_directories'] as $unDossier) {
	require_once_file_autoload($absoluteAppPath."".$unDossier , $config['require_blacklist']);
}


function require_once_file_autoload($chemin , $exclude = array() ) {

	$contenuDossier = scandir($chemin);
	foreach ($contenuDossier as $unElt) {
		$unEltComplet = "$chemin/$unElt";

		if (  $unElt != "."
		&& $unElt != ".."
		&& !in_array($unElt.".php", $exclude) ) {
			if(is_dir($unEltComplet)) {
				a($unEltComplet);
			}
			else {
				require_once $unEltComplet;
			}
		}
	}
}