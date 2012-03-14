<?php
	if (is_file($GLOBALS['workingFolder'].'../stations.conf'))
		$stationConfig = eval('return '.file_get_contents($GLOBALS['workingFolder'].'../stations.conf').';');
	else {
		$stationConfig = array ();
	}

	include ($GLOBALS['workingFolder'].'home.php');

	file_put_contents ($GLOBALS['workingFolder'].'../stations.conf', var_export($stationConfig, true ));
?>