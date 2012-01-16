<?php
// WebAdmin
$workingFolder = dirname(__FILE__).DIRECTORY_SEPARATOR;
if (is_file($workingFolder.'/../stations.conf'))
	$stationConfig = eval('return '.file_get_contents($workingFolder.'/../stations.conf').';');
else
	file_put_contents ($workingFolder.'/../stations.conf',
		var_export( array ( 'VP2-Inside' =>
			array (
				'IP' => 'VP2',
				'Port' => 22222,
				'type' => 'VP2-IP',
				'Last_DMPAFT' => '',
				'Last_Connected' => '',
				'Last_Read_Config' => '',
				'Last_SETTIME' => '',
				'AVERAGE_TEMP' => '',
				'VER' => '',
				'NVER' => '',
				'RXCHECK' =>   array ( ),
				'BARDATA' =>   array ( ),
				'BAR_OFFSET' => 0,
				'BAR_CAL' => 0,
				'LATITUDE' => 0,
				'LONGITUDE' => 0,
				'ELEVATION' => 0,
				'TIME_ZONE' => 0,
				'GTM_OFFSET' => '',
				'GTM_OR_ZONE' => '',
				'UNIT_BITS' =>  array ( ),
				'SETUP_BITS' => array ( ),
				'RAIN_SEASON_START' => 0,
				'ARCHIVE_PERIOD' => 0,
				'TEMP_IN_CAL' => 0,
				'WIND_DIR_CAL' => 0,
				'TEMP_OUT_CAL' => 0,
			),), true));
if (is_file($workingFolder.'/../WsWds.conf'))
	$WsWdsConfig = eval('return '.file_get_contents($workingFolder.'/../WsWds.conf').';');
else
	file_put_contents ($workingFolder.'/../stations.conf',
		var_export( array (
			'AdminInterface' =>
			array (
				'Username' => 'WsWds',
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
			),
			), true));
?>
