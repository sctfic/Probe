<?php
// StationScript
$stationFolder = dirname(__FILE__).DIRECTORY_SEPARATOR;
require_once $stationFolder .'VP2/Station.phpc';
// file_put_contents ($stationFolder.'Station.conf',
// 	var_export(
// 		array(
// 			'VP2-Inside'=>array('IP'=>'VP2','Port'=>22222,'type'=>'VP2-IP','Last_DMPAFT'=>'0'),
// 			'VP2-Gtd'=>array('IP'=>'nas-alban.no-ip.org','Port'=>22222,'type'=>'VP2-IP','Last_DMPAFT'=>'0'),
// 		), true));

$SConfs = eval('return '.file_get_contents($stationFolder.'Station.conf').';');

foreach($SConfs as $key=>$SConf)
{
	if ($SConf['type']=='VP2-IP')
	{
		$Station = new station($SConfs, $key);
		if ($Station -> initConnection())
		{
			$Station -> Waiting (0, 'Initialisation de '.$key.' : OK!');

			// $Station -> Get_HILOWS_Raw();	// OK
			// $Station -> Get_LOOP_Raw(3);	// OK
			// $Station -> Get_DMPAFT_Raw();	// OK
			$Station -> Get_TIME_Raw();
			$Station -> Set_TIME_Raw();
			$Station -> Get_TIME_Raw();

			if ($Station -> closeConnection())
				$Station -> Waiting (0, 'Fermeture de '.$key.' : OK!');
			else
				$Station -> Waiting (0, 'Echec fermeture de '.$key.' !');
		}
			else
				$Station -> Waiting (0, 'Echec initialisation  de '.$key.' !');
	}
}
?>
