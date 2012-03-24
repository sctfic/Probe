<?php // clear;php5 -f WsWds/index.php
// StationScript
$workingFolder = dirname(__FILE__).DIRECTORY_SEPARATOR;
require_once($workingFolder.'../config/rwConf.c.php');
$stationConf = configManager::readConfig('station');
var_export($stationConf);
foreach($stationConf as $configKey=>$configValue)
{
	$stationFolder = $configValue['type']; // folder with class related to the given station model
	require_once sprintf( "%s/%s/Main.c.php", $workingFolder, $stationFolder ); // load correct station class so it can be instantiated later

	switch ($configValue['type'])
	{
		case 'VP2-IP':
			echo sprintf ("\n%'+40s %16s %'+40s\n", "", $configKey, "");
			$station = new station($configKey, $configValue);
			if ($station->initConnection()){
				$configValue['Last']['Connected'] = date('Y/m/d H:i:s');
				$station->Waiting( 0, _( sprintf('[Succès] Ouverture de la connexion à %s', $configKey) ) );

// 				if (($retuned = $station->get_HILOWS())) {
// 					$configValue['Last']['HiLows'] = date('Y/m/d H:i:s');
// 					var_export($retuned);	// OK
// 				}
// 				if (($retuned = $station->get_LOOP())) {
// 					$configValue['Last']['Loop'] = date('Y/m/d H:i:s');
// 					var_export($retuned);	// OK
// 				}
				if (($retuned = $station->get_DMPAFT($configValue['Last']['DumpAfter']))) {
					$configValue['Last']['DumpAfter'] = date('Y/m/d H:i:s');
					var_export($retuned);	// OK
				}
// 				if (($retuned = $station->EEBRD_Confs())) {
// 					$configValue['Last']['AllConfs'] = date('Y/m/d H:i:s');
// 					var_export($retuned);	// OK
// 				}
// 				if (($retuned = $station->clockSync(5))) {
// 					$configValue['Last']['ClockSync'] = date('Y/m/d H:i:s');
// 					var_export($retuned);	// OK
// 				}

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
	$stationConf[$configKey]=$configValue;
	configManager::writeConfig('station', $stationConf);
}
echo "\n\n\n\n";
?>