<?php
// WebAdmin
$workingFolder = dirname(__FILE__).DIRECTORY_SEPARATOR;
// define ('CRYPT_BLOWFISH', true);
$salt = '$2a$07$WsWds.0cEzRZZaN/PX8M0w';

$spath = session_save_path();
if (strpos ($spath, ";") !== FALSE)
	$spath = substr ($spath, strpos($spath, ";")+1);
if (!is_dir($spath) && !empty($spath))
{
	echo __FILE__."\n".'Problem on line '.(__LINE__ - 2)."\n";
	if (!is_dir(mkdirs(str_replace(realpath('./'), '.', $spath), 0700, true)))
	{
		echo __FILE__."\n".'Problem on line '.(__LINE__ - 2)."\n";
		echo ' ("'.session_save_path().'").<br>';
	}
}
ini_set('session.use_cookies', '1');
ini_set('session.use_only_cookies', '0');
session_cache_limiter ('nocache');
session_cache_expire (60);            // Configure le délai d'expiration à 60 minutes

if (session_start()) {
	if (is_file($workingFolder.'../WsWds.conf'))
		$WsWdsConfig = eval('return '.file_get_contents($workingFolder.'../WsWds.conf').';');
	else {
		$WsWdsConfig = array (
			'AdminInterface' =>
			array (
				'Username' => '',
				'Password' => '',
			),
			'DataBase' =>
			array (
				'useIt' => true,
				'Serveur' => '127.0.0.1',
				'Port' => 999,
				'Username' => 'WsWds',
				'Password' => '',
			),
			'LocalFile' =>
			array (
				'useIt' => True,
				'FilesNames' => 'VP2-%n%.data',
				'Port' => 21,
				'Username' => 'WsWds',
				'Password' => '',
			),
			'FTP' =>
			array (
				'useIt' => False,
				'Serveur' => '127.0.0.1',
				'Port' => 21,
				'Username' => 'WsWds',
				'Password' => '',
			),
			'SSH' =>
			array (
				'useIt' => False,
				'Serveur' => '127.0.0.1',
				'Port' => 22,
				'Username' => 'WsWds',
				'Password' => '',
			),
			'WebInterface' =>
			array (
				'useIt' => True,
				'Serveur' => '127.0.0.1',
				'Port' => 80,
				'Username' => 'WsWds',
				'Password' => '',
			),
			'' =>
			array (
				'useIt' => False,
				'Serveur' => '127.0.0.1',
				'Port' => 21,
			),
			'NOAA' =>
			array (
				'useIt' => True,
				'Serveur' => '127.0.0.1',
				'Port' => 80,
			),);
	}

	if (isset($_GET['stop']))
	{ // sur une demande de fermeture
		$_SESSION['WsWds'] = array(0);		// on vide bien la variable de session
		unset($_SESSION['WsWds']);			// et on detruit le contenue de session ki nous conserne
		if (empty($_SESSION))				// si aprés ca la session est vide on peut en deduire que personne d'autre ne l'utilise
		{
			setcookie(session_name(), '', time()-100000, '/');	// on force le cookie de session a etre périmé
			session_destroy();						// on detruit la session sur le serveur
		}
		echo _('loged out !');
		exit();
	}
	elseif (isset($_GET['login']) && empty($WsWdsConfig['AdminInterface']['Username']) && empty($WsWdsConfig['AdminInterface']['Password']) && strlen($_GET['login'])>2 && $_GET['code']==$_GET['confirm'])
	{ // Si le compte admin n´as jamais était definie alors c'est le moment
		$_SESSION['WsWds']['login'] = $WsWdsConfig['AdminInterface']['Username'] = $_GET['login'];
		$WsWdsConfig['AdminInterface']['Password'] = crypt($_GET['code'], $salt);
		include ($workingFolder.'Admin.php');
		echo 'ici : '.$_GET['login'];
	}
	elseif (isset($_GET['login']) && ($_GET['login']==$WsWdsConfig['AdminInterface']['Username'] && crypt($_GET['code'], $salt)==$WsWdsConfig['AdminInterface']['Password']))
	{ // si le code de connexion est le bon
		$_SESSION['WsWds']['login'] = $_GET['login'];
		include ($workingFolder.'Admin.php');
	}
	elseif (!empty($_SESSION['WsWds']['login']))
	{ // l´identification a deja été faites avec succé
		if (isset($_POST['query']))
			include ($workingFolder.'AJAX.php');
		else
			include ($workingFolder.'Admin.php');
	}
	else
	{ // on invite l´utiliseteur a s´identifier
		include ($workingFolder.'login.php');
		// on quitte directement le scripte
		exit();
	}

	if (!file_put_contents ($workingFolder.'../WsWds.conf', var_export( $WsWdsConfig, true )))
		echo _('Impossible d´enregistrer les changements, Merci de verifier les droits.');
}

// <p>
//  Pour continuer, <a href="nextpage.php?<?php echo htmlspecialchars(SID); ? >">cliquez ici</a>.
// </p>



?>
