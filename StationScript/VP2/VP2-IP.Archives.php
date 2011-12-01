<?php // $ php5 -f ~/WsWds/StationScript/VP2-IP.php
$_FOLDER = dirname(__FILE__).DIRECTORY_SEPARATOR;
require_once $_FOLDER."VP2-IP.DefVarFunc.php";
$retry = 2;
$av = false;

echo date('Y/m/d H:i:s u')."\t".'Tentative de connexion...'."\n";
$fp = fsockopen($ip_vp2, $port_vp2);
//def d'un timeout adapté a la VP2 pour toutes les recup. fgets();
stream_set_timeout($fp, 0, 2500000);

if ($fp)
{
	Avaible ($fp);
	// Termeture de la connexion Telnet
	Waiting (12, 'Fermeture de la connexion');
	fread($fp, 999); // vidange
	fclose($fp);
}
else echo date('Y/m/d H:i:s u')."\t".'Echec de la connexion !';
	
function Avaible ($fp)
{	// la connection est faite reste a verifier si la VP2 repond
	$av = false;
	$retry = 2;
	$symbols = $GLOBALS['symbols'];
	echo date('Y/m/d H:i:s u')."\t".'Connexion etablie.'."\n";
	for ($i=0;$i<=$retry && !$av;$i++)
	{//on test si la vp2 est reveillée (conf chapitre IV. p.5)
		//ici par l´allumage de l´ecran au lieu de la procedure conventionnelle
		fwrite ($fp,$symb['LF']);
		Waiting (1, 'Verification de la disponibilitée.');
		//on allume l'ecran pour suivre la connexion
		$ans = fread($fp,2);
		if ($ans==$symb['LFCR'])
		{	//si on a bien confirmé, la connexion avec la VP2 est disponible
			$av = true;
			echo date('Y/m/d H:i:s u')."\t".'VP2 Disponible.'."\n";
			toggleLAMP($fp);
		  	// on passe a la recuperation des données
			$av = true;
		  	// on passe a la recuperation des données
		  	// GetMinMax (&$fp);
			// GetArchives (&$fp);
			echo date('Y/m/d H:i:s u')."\t".'Synchronisation des horloges.'."\n";
			Waiting (4, 'Desactivation du retroeclairage');
			toggleLAMP($fp);
		}
		else
		{
			echo date('Y/m/d H:i:s u')."\t".'VP2 N´est pas disponible ! '.$LED."\n";
			fread($fp, 999); // vidange
			if ($i<$retry)	Waiting (100);
		}
	}
	return $av;
}
function GetArchives (&$fp)
{
	$skip=false;
	$retry = 2;
	$symb = $GLOBALS['symbols'];
	for ($i=0;$i<=$retry && !$skip;$i++)
	{
		fwrite($fp,"DMPAFT\n");
		Waiting (4,'Recuperation des Archives.');
		$r = fread($fp, 1);
		if ($r == $symb['ACK'])
		{
			$d = DMPAFT_SetVP2Date(date('Y/m/d H:00:00'));
	echo ($d).' = '.dechex(ord(chr(($d&0xff000000)>>24))).dechex(ord(chr(($d&0xff0000)>>16))).dechex(ord(chr(($d&0xff00)>>8))).dechex(ord(chr($d&0xff)))."\n";
	echo ($d).' = '.dechex(((($d&0xff000000)>>24))).dechex(((($d&0xff0000)>>16))).dechex(((($d&0xff00)>>8))).dechex((($d&0xff)))."\n";
			echo DMPAFT_GetVP2Date($d)."\n";
			fwrite($fp, $d);
			Waiting (4,'Demande d archive');
			fwrite($fp, CRC16_CCITT($d));
			Waiting (12,'confirmation par CRC');
			$r = fread($fp, 1);
			if ($r == $symb['ACK'])
			{
			Waiting (2,'=================================================');
				$r = fread($fp, 6);
				$crc = CRC16_CCITT(&$r);
				if ($crc[0])
				{
					$n = $r>>16;
					echo date('Y/m/d H:i:s u')."\t".'Nombre de Pages : '.$r."\n";
					fwrite($fp, $symb['ACK']);
					for ($j=0;$j<$n;$j++)
					{
						$archives = fread($fp, 267);
						Waiting (8,'ARCHIVE : '.$j."\n");
						fwrite($fp, $symb['ACK']);
					}
					fwrite($fp, $symb['ESC']);
				}
				else if ($r == $symb['NAK'])
					echo date('Y/m/d H:i:s u')."\t".'DMPAFT Pages NAK'."\n";
				else
				{
					echo date('Y/m/d H:i:s u')."\t".'DMPAFT Pages NULL  '.'$r = 0x'.dechex($r)."\n";
					fread($fp, 999); // vidange
					if ($i<$retry)	Waiting (8);
				}
			}
			else if ($r == $symb['NAK'])
				echo date('Y/m/d H:i:s u')."\t".'DMPAFT Date NAK'."\n";
			else
			{
				echo date('Y/m/d H:i:s u')."\t".'DMPAFT Date NULL  '.'$r = 0x'.dechex($r)."\n";
				fread($fp, 999); // vidange
				if ($i<$retry)	Waiting (8);
			}
			$skip = true;
		}
		else if ($r == $symb['NAK'])
			echo date('Y/m/d H:i:s u')."\t".'DMPAFT NAK'."\n";
		else
		{
			echo date('Y/m/d H:i:s u')."\t".'DMPAFT NULL  '.'$r = 0x'.dechex($r)."\n";
			fread($fp, 999); // vidange
			if ($i<$retry)	Waiting (8);
		}
	}
	fread($fp, 999); // vidange
}
function GetMinMax (&$fp)
{
	$crc=false;
	$retry = 3;
	$symb = $GLOBALS['symbols'];
	echo date('Y/m/d H:i:s u')."\t".'Recuperation des valeurs Maxi et Mini.'."\n";
	for ($i=0;$i<=$retry && !$crc;$i++)
	{
		fwrite ($fp, "HILOWS\n");
		Waiting (8,'HILOWS : attente de la reponce.');
		$r = fread($fp, 1);
		if ($r == $symb['ACK'])
		{
			Waiting (8,'HILOWS : attente des donnees brutes.');
			$HILOWS = fread($fp, 438);
			$crc = CRC16_CCITT(&$HILOWS);
			if ($crc[0])
			{
				echo date('Y/m/d H:i:s u')."\t".'Traitement des valeurs Maxi et Mini...'."\n";
				// fonction de conversion...
			}
//	file_put_contents("./VP2-data.brut",$HILOWS);
//	echo date('Y/m/d H:i:s u')."\tReponce ".strlen($HILOWS)." Octes :\n0x".dechex($crc0).' = 0x'.dechex($crc1)."\n";
		}
		else if ($r == $symb['NAK'])
			echo date('Y/m/d H:i:s u')."\t".'HILOWS NAK'."\n";
		else
		{
			echo date('Y/m/d H:i:s u')."\t".'HILOWS NULL  '.'$r = 0x'.dechex($r)."\n";
			fread($fp, 999);
			if ($i<$retry)	Waiting (8);
		}
	}
	return $crc;
}
?>
