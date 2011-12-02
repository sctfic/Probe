<?php // $ php5 -f ~/WsWds/StationScript/VP2-IP.php
$_FOLDER = dirname(__FILE__).DIRECTORY_SEPARATOR;
require_once $_FOLDER."VP2-IP.DefVarFunc.php";

echo date('Y/m/d H:i:s u')."\t".'Tentative de connexion...'."\n";
$fp = fsockopen($ip_vp2, $port_vp2);
//def d'un timeout adapté a la VP2 pour toutes les recup. fgets();
stream_set_timeout($fp, 0, 2500000);

if ($fp)
{
	CurrentLoop ($fp);
	// Termeture de la connexion Telnet
	Waiting (4, 'Fermeture de la connexion');
//	fread($fp, 99); // vidange
	fclose($fp);
}
else echo date('Y/m/d H:i:s u')."\t".'Echec de la connexion !';

function CurrentLoop ($fp)
{	// la connection est faite reste a verifier si la VP2 repond
	$av = false;
	$retry = 2;
	$crc = array(false,'','');
	$symb = $GLOBALS['symbols'];
	echo date('Y/m/d H:i:s u')."\t".'Connexion etablie.'."\n";
	for ($i=0;$i<=$retry && !$av;$i++)
	{//on test si la vp2 est reveillée (conf chapitre IV. p.5)
		//ici par l´allumage de l´ecran au lieu de la procedure conventionnelle
		fwrite ($fp,$symb['LF']);
		Waiting (1, 'Verification de la disponibilitée.');
		//on allume l'ecran pour suivre la connexion
		$ans=fread($fp,6);
		if ($ans==$symb['LFCR'])
		{	//si on a bien confirmé, la connexion avec la VP2 est disponible
			$av = true;
			echo date('Y/m/d H:i:s u')."\t".'VP2 Disponible.'."\n";
			toggleLAMP($fp);
		  	// on passe a la recuperation des données
			echo date('Y/m/d H:i:s u')."\t".'Recuperation des valeurs Maxi et Mini.'."\n";
			for ($i=0;$i<=$retry && !$crc['Confirm'];$i++)
			{
				fwrite ($fp, 'LOOP 1'.$symb['LF']);
				Waiting (8,'CURRENT VALUE : attente de la reponce.');
				$r = fread($fp, 1);
				if ($r == $symb['ACK'])
				{
					Waiting (8,'CURRENT VALUE : attente des donnees brutes.');
					$CURRENT = fread($fp, 99);
					$crc = CRC16_CCITT(&$CURRENT);
					if ($crc['Confirm'])
					{
						echo date('Y/m/d H:i:s u')."\t".'Traitement des valeurs Maxi et Mini...'."\n";
						// fonction de conversion...
					}
			file_put_contents($GLOBALS['_FOLDER']."VP2-data.current.brut",$CURRENT);
		//	echo date('Y/m/d H:i:s u')."\tReponce ".strlen($CURRENT)." Octes :\n0x".dechex($crc0).' = 0x'.dechex($crc1)."\n";
				}
				else if ($r == $symb['NAK'])
					echo date('Y/m/d H:i:s u')."\t".'CURRENT VALUE NAK'."\n";
				else
				{
					echo date('Y/m/d H:i:s u')."\t".'CURRENT VALUE NULL  '.'$r = 0x'.dechex($r)."\n";
					fread($fp, 999);
					if ($i<$retry)	Waiting (8);
				}
			}
			toggleLAMP($fp);
		}
		else
		{
			echo date('Y/m/d H:i:s u')."\t".'VP2 N´est pas disponible !'."\n";
			fread($fp, 999); // vidange
			if ($i<$retry)	Waiting (30);
		}
	}
	return $av;
}

?>
