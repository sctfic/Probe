<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| Configuration for the Probe application.
*/

$config['mainDb'] = 'probe';
// $config['probe:username'] = 'edouard.lopez';
$config['probe:username'] = '';
// $config['probe:password'] = 'edouard.lopez';
$config['probe:password'] = '';

// Locale/language to use for the interface
$config['probe:locale'] = 'fr';

// Label that will appear after page title (e.g.: installation - Probe.com)
$config['page.title:suffix.metadata'] = 'Probe';


/*
*redirection URLs for the admin area
*/
// landing page after user is successfully authentified
$config['page-login']	= "admin/admin/connexion";
// Login page, un-authentified users will land on this page to provide their credentials
$config['page-station-list']	= "configuration/stations";

$config['require_directories']	= array("entity", "exceptions");
$config['require_blacklist'] = array( "Address");

$config['add-station.form.structure'] = array(
            'dbms' => array(
                'engine' => array(
                    'type' => 'radio',
                    'values' => array(
                        'mysql',
                        'sqlite'
                    )
                ),
                'username' => 'text',
                'password' => 'password',
                'host' => 'text',
                'port' => 'number', // already

                // 'database' => 'text',
                // 'dbdriver' => 'text', // fixed: pdo
                // 'hostname' => 'mysql:host=localhost;port=3306',
                // 'password' => 'password',
                // 'username' => 'text',
            ),
            'network' => array(
                // '_ip' => 'pattern="([0-2][0-5][0-5]\.){4}"',
                '_ip' => 'pattern="\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b"',
                '_name' => 'text',
                '_port' => 'number',
                '_type' => 'text',
            )
        );

//###################################### REQUIRES ######################################
$absoluteAppPath = str_replace(
        end(explode('/', $_SERVER['SCRIPT_FILENAME'])),
        '',
        $_SERVER['SCRIPT_FILENAME']
    )
    .''.APPPATH;
// echo $absoluteAppPath."<br/>";

foreach ($config['require_directories'] as $unDossier) {
    require_once_file_autoload($absoluteAppPath."".$unDossier , $config['require_blacklist']);
}

function require_once_file_autoload($chemin , $exclude = array() )
{
    $contenuDossier = scandir($chemin);
    foreach ($contenuDossier as $unElt) {
        $unEltComplet = "$chemin/$unElt";

        if (  $unElt != "."
        && $unElt != ".."
        && !in_array($unElt.".php", $exclude) ) {
            if (is_dir($unEltComplet)) {
                a($unEltComplet);
            } else {
                require_once $unEltComplet;
            }
        }
    }
}
