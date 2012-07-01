<?php // clear;php5 -f WsWds/Archie.cron.php
// StationScript
$workingFolder = dirname(__FILE__).DIRECTORY_SEPARATOR;
$daoFolder = $workingFolder.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'dao'.DIRECTORY_SEPARATOR.'VP2-IP'.DIRECTORY_SEPARATOR;
require_once($workingFolder.'../config/rwConf.c.php');
$stationConf = configManager::readConfig('station');
// var_export($stationConf);
foreach($stationConf as $configKey=>$configValue)
{
	$stationFolder = $configValue['type']; // folder with class related to the given station model
	require_once sprintf( '%sConnexionManager.c.php', $daoFolder ); // load correct station class so it can be instantiated later
	require_once sprintf( '%sEepromManager.c.php', $daoFolder ); // load correct station class so it can be instantiated later

	switch ($configValue['type'])
	{
		case 'VP2-IP':
			echo sprintf ("\n%'+40s %16s %'+40s\n", "", $configKey, "");
			$station = new dataFetcher($configKey, $configValue);
			if ($station->initConnection()){
				$configValue['Last']['Connected'] = date('Y/m/d H:i:s');
				Tools::Waiting( 0, _( sprintf('[Succès] Ouverture de la connexion à %s', $configKey) ) );

				if (($retuned = $station->clockSync(5))) {
					var_export($retuned);	// OK
					$configValue['Last']['ClockSync'] = $retuned;
				}
				if (($retuned = $station->GetDmpAft($configValue['Last']['_DumpAfter']))) {
					var_export(end($retuned));	// OK
					$configValue['Last']['_DumpAfter'] = key($retuned);
					$configValue['Last']['DumpAfter'] = date('Y/m/d H:i:s');
					foreach ($retuned as $h=>$arch) {
						$folder = $workingFolder.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$configKey.DIRECTORY_SEPARATOR.substr($h, 0, 4).'/'.substr($h, 5, 2);
						$file = $folder.DIRECTORY_SEPARATOR.substr($h, 8, 2).'.txt';
						if (is_file($file)) {
							file_put_contents($file,
								implode("\t",$arch)."\n", FILE_APPEND);
						}
						else {
							if (!file_exists($folder))
								mkdir($folder, 0777, true);
							file_put_contents($file,
								implode("\t",array_keys($arch))."\n".implode("\t",$arch)."\n");
						}
					}
				}
				if ($station->closeConnection())
					Tools::Waiting( 0, sprintf( _('[Succès] Fermeture de %s correcte.'), $configKey ) );
				else
					Tools::Waiting( 0, sprintf( _('[Échec] Fermeture de %s.'), $configKey ) );
			}
			else
				Tools::Waiting( 0, sprintf( _('[Échec] Impossible de se connecter à %s par %s:%s.'), $configKey, $configValue['IP'], $configValue['Port']) );
			break;
		default :
	}
	$stationConf[$configKey]=$configValue;
	configManager::writeConfig('station', $stationConf);
}
// echo "\n\n\n\n";
?>