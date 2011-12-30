<?php // clear;php5 -f WsWds/index.php
// WsWdsScript

$_WsWdsFOLDER = dirname(__FILE__).DIRECTORY_SEPARATOR;
include_once($_WsWdsFOLDER .'StationScript/index.php');

// file_put_contents ($_StationFOLDER.'WsWds.conf',
// 	var_export(array (
// 	'SaveInDb'=>true,
// 		'DataBase' =>array ('Serveur' => 'VP2','Port' => 732,'Username' => 'WsWds','Password' => '',),
// 	'SaveInFile'=>true,
// 		'FilesSave' =>array ('Protocole' => 'ftp','Serveur' => 'nas','Port' => 21,'Username' => 'WsWds','Password' => '','FileName' => '',),
// 	'UseWebInterface'=>true,
// 		'WebInterface'=>array ('URL'=>'',),
// 	'WebAdmin'=>array ('Username' => 'WsWds','Password' => 'WsWds',),
// ), true));

?>
