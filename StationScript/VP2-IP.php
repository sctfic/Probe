<?php // $ php5 -f ~/WsWds/StationScript/VP2-IP.php
	$ip_vp2 = "10.1.253.200";
	$port_vp2 = 22222;
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
			//on allume l'ecran pour suivre la connexion
		if ($LED=TelnetOutput($fp))
		{//si on a bien confirmé, la connexion avec la VP2 est disponible
			echo date('Y/m/d H:i:s u')."\t".'VP2 Disponible.'."\n";
			echo date('Y/m/d H:i:s u')."\t".'Activation du retroeclairage.'."\n";
		  	//on passe a la recuperation des données




/*			$bContinu = true;
			while( $bContinu )
			{
				$line = fgets($fp, 1024);
				//vidange buffer
				$info = stream_get_meta_data($fp);
				if($info['timed_out']) 
				{
					echo "-------------------\r\n";
					$bContinu = false;
				}
			}

			echo "recup data...\r\n";
			fwrite($fp, "LOO 10\n");
			sleep(2);
			$iCpt = 10;
			do
			{
				$line = fgets($fp, 1024);
				echo $line.'';
				$iCpt--;
			}
			while( $iCpt > 0 );*/

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

function TelnetOutput(&$fp)
{

	for ($i=0; $i<5 && strlen($result=fgets($fp))<3; $i++);
	if (strlen($result)<3) return false;
	else return $result;
	
}

?>
