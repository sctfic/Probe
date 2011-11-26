<?php // $ php5 -f ~/WsWds/StationScript/VP2-IP.php

	$ip_vp2 = "10.1.253.200";
//	$ip_vp2 = "nas-alban.no-ip.org";

	$port_vp2 = 22222;
	include ('./VP2-CRC.php');

	echo date('Y/m/d H:i:s u')."\t".'Tentative de connexion...'."\n";
	$fp = fsockopen($ip_vp2, $port_vp2);
	$symbols = array (
	'CR' => chr(0x0D), // \r
	'LF' => chr(0x0A), // \n
	'LFCR' => chr(0x0A).chr(0x0D),
	'ACK' => chr(0x06), // Compris
	'NAK' => chr(0x21), // Pas Compris
	'CANCEL' => chr(0x18) // Bad CRC Code
	);
	
	//def d'un timeout adapté a la VP2 pour toutes les recup. fgets();
	stream_set_timeout($fp, 0, 2500000);
	
	if ($fp)
	{	// la connection est faite reste a verifier si la VP2 repond
		echo date('Y/m/d H:i:s u')."\t".'Connexion etablie.'."\n\t\t\t\t".'Verification de la disponibilitée...'."\n";
			//on test si la vp2 est reveillée (conf chapitre IV. p.5)
			//ici par l´allumage de l´ecran au lieu de la procedure conventionnelle
		fwrite ($fp,"LAMPS 1\n");
		usleep(100000);
			//on allume l'ecran pour suivre la connexion
		$LED=fread($fp,6);
		if (strlen($LED) && $LED==$symbols['LFCR'].'OK'.$symbols['LFCR'])
		{	//si on a bien confirmé, la connexion avec la VP2 est disponible
			echo date('Y/m/d H:i:s u')."\t".'VP2 Disponible.'."\n";
			echo date('Y/m/d H:i:s u')."\t".'Activation du retroeclairage.'."\n";
		  	//on passe a la recuperation des données
		  	if (GetMinMax ($fp))
				echo date('Y/m/d H:i:s u')."\t".'Traitement des valeurs Maxi et Mini...'."\n";
			
			GetArchives ($fp);
			echo date('Y/m/d H:i:s u')."\t".'Recuperation des Archives.'."\n";
//			$DMPAFT=GetTelnetOutputData($fp,"DMPAFT");
//			echo date('Y/m/d H:i:s u')."\t\n".$DMPAFT."\n";
			echo date('Y/m/d H:i:s u')."\t".'Synchronisation des horloges.'."\n";
//			fwrite ($fp,"GETTIME\n");
//			$vp2time=TelnetOutput($fp);
//			echo date('Y/m/d H:i:s u')."\tVP2 TIME : ".$vp2time."\n";
			usleep(100000);
			echo date('Y/m/d H:i:s u')."\t".'Desactivation du retroeclairage.'."\n";
			fwrite($fp, "LAMPS 0\n");
		}
		else
			echo date('Y/m/d H:i:s u')."\t".'VP2 N´est pas disponible !'."\n";

		// Termeture de la connexion Telnet
		echo date('Y/m/d H:i:s u')."\t".'Fermeture de la connexion...'."\n";
		fclose($fp);
	}
	else echo date('Y/m/d H:i:s u')."\t".'Echec de la connexion !';
//	preg_split();
/*function GetTelnetOutputData(&$fp, $cmd, $len)
{
	$symb = $GLOBALS['symbols'];
	fwrite ($fp, $cmd."\n");
//	$r = '0';//fgets($fp, 2);
	sleep(1);
	$str = fread($fp, $len);
	echo '0x'.dechex(ord($str[0]))."\n";
	if ($str[0] == $symb['ACK'])
		return $str;
	else if ($str[0] == $symb['NAK'])
	{
		echo 'NAK'."\n";
		return false;
	}
	else
	{
		echo 'NULL > '.strlen($str)."\n";
		return null;
	}
}*/
function GetMinMax (&$fp)
{
	$crc=false;
	$symb = $GLOBALS['symbols'];
	echo date('Y/m/d H:i:s u')."\t".'Recuperation des valeurs Maxi et Mini.'."\n";
	for ($i=0;$i<5 && !$crc;$i++)
	{
		fwrite ($fp, "HILOWS\n");
		usleep(100000);
		$r = fread($fp, 1);
		usleep(100000);
		if ($r == $symb['ACK'])
		{
			$HILOWS = fread($fp, 436);
			$CRC = fread($fp, 2);
			$crc = true;//(genCRC(&$HILOWS, strlen($HILOWS))==$CRC)?true:false;
			file_put_contents("./VP2-data.brut",$HILOWS);
		}
		else if ($r == $symb['NAK'])
			echo date('Y/m/d H:i:s u')."\t".'NAK'."\n";
		else
			echo date('Y/m/d H:i:s u')."\t".'NULL'."\n";
	}
//	$HILOWS = GetTelnetOutputData($fp,"HILOWS\n", 440);
//	echo date('Y/m/d H:i:s u')."\tReponce ".strlen($HILOWS)." Octes :\n".$HILOWS."\n";
	return $crc;
}

?>

