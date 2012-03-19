<?php // clear;php5 -f WsWds/index.php
// StationScript
$workingFolder = dirname(__FILE__).DIRECTORY_SEPARATOR;
require_once($GLOBALS['workingFolder'].'../resources/php/configManager.phpc');
$stationConf = configManager::getConfig('station');

$stationConfig = eval('return '.file_get_contents($workingFolder.'../stations.conf').';');

foreach($stationConfig as $configKey=>$configValue)
{
	$stationFolder = $configValue['type']; // folder with class related to the given station model
	require_once sprintf( "%s/%s/Main.c.php", $workingFolder, $stationFolder ); // load correct station class so it can be instantiated later

	switch ($configValue['type'])
	{
		case 'VP2-IP':
			echo sprintf ("\n%'+40s %10s %'+40s\n", "", $configKey, "");
			$station = new station($stationConfig, $configKey);
			if ($station->initConnection())
			{
				$station->Waiting( 0, _( sprintf('[Succès] Ouverture de la connexion à %s', $configKey) ) );

// 				var_export ($station->Read_Configs());
// 				$station->Get_HILOWS_Raw();	// OK
// 				$station->Get_LOOP_Raw();	// OK
// 				$station->Get_DMPAFT_Raw();	// OK
// 				$station->EEBRD(11, 6);	// OK
				var_export($station->EEBRD_Confs());	// OK

				if ($station->closeConnection())
					$station->Waiting( 0, sprintf( _('[Succès] Fermeture de %s correcte.'), $configKey ) );
				else
					$station->Waiting( 0, sprintf( _('[Échec] Fermeture de %s.'), $configKey ) );
			}
			else
				$station->Waiting( 0, sprintf( _('[Échec] Impossible de se connecter à %s par %s:%s.'), $configKey, $configValue['IP'], $configValue['Port']) );
			break;
		default :
	}
}
echo "\n\n\n\n";
?>
