<?php
	$ip_vp2 = "10.1.253.200";
	$port_vp2 = 22222;
	$fp = fsockopen($ip_vp2, $port_vp2);
	$symbols = array (
	'CR' => chr(0x0D), // \r
	'LF' => chr(0x0A), // \n
	'ACK' => chr(0x06), // Compris
	'NAK' => chr(0x21), // Pas Compris
	'CANCEL' => chr(0x18), // Bad CRC Code
	);
	
	if ($fp)
	{// la connection est faite reste a verifier si la VP2 repond
	//def d'un timeout adequat
		stream_set_timeout($fp, 0, 100 000);
	//test si elle est reveillée (conf chapitre IV. p.5)
		fputs($fp, "\n");
		for ($i=0;$i<3 && $c(fgets($fp)!="\n\r");$i++)
			usleep(1200 000);
		if (!$c)
		{//si on a bien confirmé la connexion avec la VP2
		//on allume l'ecran pour suivre la connexion
			fputs($fp, "LAMPS 1\n");
			usleep(100 000);
	  	//on passe a la recuperation des données




			$bContinu = true;
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
			while( $iCpt > 0 );

			fputs($fp, "LAMPS 0\n");
			usleep(100 000);
		}
		else echo 'echec socket';
		//close
		fclose($fp);
	}
	else echo 'echec socket';
?>
