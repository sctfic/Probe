<?php
require_once 'resources/php/page.phpc';

$workingFolder = dirname(__FILE__).DIRECTORY_SEPARATOR;
$page = new page();

<<<<<<< HEAD:WebAdmin/index.php
$salt = '$2a$07$WsWds.0cEzRZZaN/PX8M0w'; // whit CRYPT_BLOWFISH
=======
// webAdmin
// define ('CRYPT_BLOWFISH', true);
$salt = '$2a$07$WsWds.0cEzRZZaN/PX8M0w';
>>>>>>> 15ba41eb85b27393f7d8b83e61b96cef83f150c6:admin/index.php

$spath = session_save_path();
if (strpos ($spath, ";") !== FALSE) {
    $spath = substr ($spath, strpos($spath, ";")+1);
}
if (!is_dir($spath) && !empty($spath)) {
	echo __FILE__."\n".'Problem on line '.(__LINE__ - 2)."\n";
	if (!is_dir(mkdirs(str_replace(realpath('./'), '.', $spath), 0700, true))) {
		echo __FILE__."\n".'Problem on line '.(__LINE__ - 2)."\n";
		echo ' ("'.session_save_path().'").<br>';
	}
}
ini_set('session.use_cookies', '1');
ini_set('session.use_only_cookies', '0');
session_cache_limiter ('nocache');
session_cache_expire (60);            // set cache time out


if (session_start()) {
	if (isset($_GET['stop'])) { // sur une demande de fermeture
		$_SESSION['WsWds'] = array(0);		// on vide bien la variable de session
		unset($_SESSION['WsWds']);			// et on detruit le contenue de session ki nous conserne
		if (empty($_SESSION)) {				// si aprés ca la session est vide on peut en deduire que personne d'autre ne l'utilise
			setcookie(session_name(), '', time()-100000, '/');	// on force le cookie de session a etre périmé
			session_destroy();						// on detruit la session sur le serveur
		}
		echo _('loged out !');
/*
 remplacer le exit par une redirection
*/
//		exit();
		echo '0 : '.$_GET['username'].' : '.$_GET['password'];
	} elseif (isset($_GET['username'])
            && empty($GLOBALS['WsWdsConfig']['AdminInterface']['Username'])
            && empty($GLOBALS['WsWdsConfig']['AdminInterface']['Password'])
            && strlen($_GET['username'])>2
            && $_GET['password']==$_GET['confirm']
    ) { // Si le compte admin n´as jamais était definie alors c'est le moment
		$_SESSION['WsWds']['login'] = $GLOBALS['WsWdsConfig']['AdminInterface']['Username'] = $_GET['username'];
		$GLOBALS['WsWdsConfig']['AdminInterface']['Password'] = crypt($_GET['password'], $salt);
		$page->setPage('admin');
<<<<<<< HEAD:WebAdmin/index.php
// 		include ($workingFolder.'Admin.php');
=======
// 		include ($GLOBALS['workingFolder'].'admin.php');
>>>>>>> 15ba41eb85b27393f7d8b83e61b96cef83f150c6:admin/index.php
		echo '1 : '.$_GET['username'].' : '.$_GET['password'];
	} elseif (isset($_GET['username'])
            && ($_GET['username']==$GLOBALS['WsWdsConfig']['AdminInterface']['Username']
            && crypt($_GET['password'], $salt)==$GLOBALS['WsWdsConfig']['AdminInterface']['Password'])
    ) { // password is correct/valid
		$_SESSION['WsWds']['login'] = $_GET['username'];
		$page->setPage('admin');
<<<<<<< HEAD:WebAdmin/index.php
// 		include ($workingFolder.'Admin.php');
		echo '2 : '.$_GET['username'].' : '.$_GET['password'];
	} elseif (!empty($_SESSION['WsWds']['login'])) { // authentification has been successful
		if (isset($_POST['query'])) {
            include ($workingFolder.'AJAX.php');
        } else {
//          include ($workingFolder.'Admin.php');
=======
// 		include ($GLOBALS['workingFolder'].'admin.php');
		echo '2 : '.$_GET['username'].' : '.$_GET['password'];
	} elseif (!empty($_SESSION['WsWds']['login'])) { // authentification has been successful
		if (isset($_POST['query'])) {
            include ($GLOBALS['workingFolder'].'AJAX.php');
        } else {
//          include ($GLOBALS['workingFolder'].'admin.php');
>>>>>>> 15ba41eb85b27393f7d8b83e61b96cef83f150c6:admin/index.php
    $page->setPage('admin');
		echo '3 : '.$_GET['username'].' : '.$_GET['password'];
    }
  }
<<<<<<< HEAD:WebAdmin/index.php
	else
	{ // on invite l´utiliseteur a s´identifier
// 		include ($workingFolder.'login.php');
=======
	else { // on invite l´utiliseteur a s´identifier
// 		include ($GLOBALS['workingFolder'].'login.php');
>>>>>>> 15ba41eb85b27393f7d8b83e61b96cef83f150c6:admin/index.php
		$page->setPage('login');
		// on quitte directement le scripte
// 		echo '4 : '.$_GET['username'].' : '.$_GET['password'];
	}

<<<<<<< HEAD:WebAdmin/index.php
	if (!file_put_contents ($workingFolder.'WsWds.conf', var_export( $GLOBALS['WsWdsConfig'], true )))
		sprintf("%s%s", _('Fail to save modifications.'), _('Please check your rights are corrects.'));
=======
	if (!file_put_contents ($GLOBALS['workingFolder'].'WsWds.conf', var_export( $GLOBALS['WsWdsConfig'], true ))) {
        sprintf("%s%s", _('Fail to save modifications.'), _('Please check your rights are corrects.'));
    }
>>>>>>> 15ba41eb85b27393f7d8b83e61b96cef83f150c6:admin/index.php
//     	echo _('Impossible d´enregistrer les changements, Merci de verifier les droits.');
}

// <p>
//  Pour continuer, <a href="nextpage.php?<?php echo htmlspecialchars(SID); ? >">cliquez ici</a>.
// </p>

require_once './themes/head.php';
    $page->View();
require_once './themes/js-libs.html';
require_once './themes/footer.php';
?>
