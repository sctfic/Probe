<?php
// WebAdmin
$workingFolder = dirname(__FILE__).DIRECTORY_SEPARATOR;
// define ('CRYPT_BLOWFISH', true);
$salt = '$2a$07$WsWds.0cEzRZZaN/PX8M0w';

if (session_start()) {
	if (is_file($workingFolder.'/../WsWds.conf'))
		$WsWdsConfig = eval('return '.file_get_contents($workingFolder.'/../WsWds.conf').';');
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

	if (isset($_GET['login']) && $WsWdsConfig['AdminInterface']['Username']=='' && $WsWdsConfig['AdminInterface']['Password']=='' && strlen($_GET['login'])>2 && $_GET['code']==$_GET['confirm'])
	{ // Si le compte admin n´as jamais était definie alors c'est le moment
		$_SESSION['login'] = $WsWdsConfig['AdminInterface']['Username'] = $_GET['login'];
		$WsWdsConfig['AdminInterface']['Password'] = crypt($_GET['code'], $salt);
		require_once $workingFolder.'Admin.php?page=0';
		echo 'ici';
	}
	elseif (isset($_GET['login']) && ($_GET['login']==$WsWdsConfig['AdminInterface']['Username'] && crypt($_GET['code'], $salt)==$WsWdsConfig['AdminInterface']['Password']))
	{ // si le code de connexion est le bon
		$_SESSION['login'] = $_GET['login'];
		require_once $workingFolder.'Admin.php?page=0';
		echo 'la';
	}
	elseif (!empty($_SESSION['login']))
	{
		require_once $workingFolder.'Admin.php?page=0';
		echo 'truc';
	}
	else
		require_once $workingFolder.'login.php';
	file_put_contents ($workingFolder.'/../WsWds.conf', var_export( $WsWdsConfig, true ));
}







// <p>
//  Pour continuer, <a href="nextpage.php?<?php echo htmlspecialchars(SID); ? >">cliquez ici</a>.
// </p>



?>
