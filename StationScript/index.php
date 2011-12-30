<?php // clear;php5 -f WsWds/index.php
// StationScript
$_StationFOLDER = dirname(__FILE__).DIRECTORY_SEPARATOR;
// file_put_contents ($_StationFOLDER.'Station.conf',
// 	var_export(
// 		array(
// 			'VP2-Inside'=>array('IP'=>'VP2','Port'=>22222,'type'=>'VP2-IP','Last_DMPAFT'=>'0','Last_HILOWS' => '2012/01/01 00:00:00','Last_LOOP' => '2012/01/01 00:00:00','Last_Connected' => '2012/01/01 00:00:00',),
// 			'VP2-Gtd'=>array('IP'=>'nas-alban.no-ip.org','Port'=>22222,'type'=>'VP2-IP','Last_DMPAFT'=>'0','Last_HILOWS' => '2012/01/01 00:00:00','Last_LOOP' => '2012/01/01 00:00:00','Last_Connected' => '2012/01/01 00:00:00',),
// 		), true));

$SConfs = eval('return '.file_get_contents($_StationFOLDER.'Station.conf').';');

foreach($SConfs as $key=>$SConf)
{
	if ($SConf['type']=='VP2-IP')
	{
		include_once($_StationFOLDER .'VP2-IP/Station.phpc');
		$Station = new station($key);
		if ($Station -> initConnection())
		{
			$Station -> Waiting (0, 'Init. '.$key.' : OK!');

			$Station -> Get_HILOWS_Raw();	// OK
			$Station -> Get_LOOP_Raw();	// OK
			$Station -> Get_DMPAFT_Raw();	// OK
			if (abs(strtotime($Station -> Get_TIME_Raw()) - strtotime(date('Y/m/d H:i:s'))) > 3)
				if ($Station -> Set_TIME_Raw());
// 					$Station->Waiting (0,'Clock synch.');
			if ($Station -> closeConnection())
				$Station -> Waiting (0, 'Close '.$key.'!');
			else
				$Station -> Waiting (0, 'Closing '.$key.' error !');
		}
			else
				$Station -> Waiting (0, 'Init. '.$key.' error !');
	}
}
?>
