<?php
	if (is_file($workingFolder.'../stations.conf'))
		$stationConfig = eval('return '.file_get_contents($workingFolder.'../stations.conf').';');
	else {
		$stationConfig = array ( 'VP2-Inside' =>
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
	}







	file_put_contents ($workingFolder.'../stations.conf', var_export($stationConfig, true ));

?>
admin.php