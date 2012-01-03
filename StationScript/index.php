<?php // clear;php5 -f WsWds/index.php
// StationScript
$workingFolder = dirname(__FILE__).DIRECTORY_SEPARATOR;
$stationConfig = eval('return '.file_get_contents($workingFolder.'/../stations.conf').';');
// file_put_contents ($stationFolder.'Station.conf',
// 	var_export(
// 		array(
// 			'VP2-Inside'=>array('IP'=>'VP2','Port'=>22222,'type'=>'VP2-IP','Last_DMPAFT'=>'0'),
// 			'VP2-Gtd'=>array('IP'=>'nas-alban.no-ip.org','Port'=>22222,'type'=>'VP2-IP','Last_DMPAFT'=>'0'),
// 		), true));



foreach($stationConfig as $configKey=>$configValue)
{
	$stationFolder = $configValue['type']; // folder with class related to the given station model
	require_once sprintf( "%s/%s/Station.phpc", $workingFolder, $stationFolder ); // load correct station class so it can be instantiated later

	if ($configValue['type']=='VP2-IP')
	{
// 		echo "\n++++++++++++++++++++++\t{$configKey}\t++++++++++++++++++++++++++++++++++++++++++++\n";
		echo sprintf ("\n%'+40s %10s %'+40s\n", "", $configKey, "");

		$station = new station($stationConfig, $configKey);
		if ($station->initConnection())
		{
			$station->Waiting( 0, _( sprintf('[Succès] Ouverture de la connexion à %s', $configKey) ) );

			var_export ($station->GET_infos());	// OK
/// 			$station->Get_HILOWS_Raw();	// OK
/// 			$station->Get_LOOP_Raw();	// OK
/// 			$station->Get_DMPAFT_Raw();	// OK
/// 			if (abs(strtotime($station->fetchStationTime()) - strtotime(date('Y/m/d H:i:s'))) > 3)
/// 			  if ($station->updateStationTime())
/// 					$Station->Waiting (0,'Clock synch.');

			if ($station->closeConnection())
				$station->Waiting( 0, sprintf( _('[Succès] Fermeture de %s correcte.'), $configKey ) );
			else
				$station->Waiting( 0, sprintf( _('[Échec] Fermeture de %s.'), $configKey ) );
		}
			else
				$station->Waiting( 0, sprintf( _('[Échec] Impossible de se connecter à %s.'), $configKey ) );
	}
}

?>
