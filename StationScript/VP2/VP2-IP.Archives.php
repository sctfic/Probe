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
//	fread($fp, 99); // vidange
	fclose($fp);
}
else echo date('Y/m/d H:i:s u')."\t".'Echec de la connexion !';
	
function Avaible ($fp)
{	// la connection est faite reste a verifier si la VP2 repond
	$av = false;
	$retry = 2;
	$symb = $GLOBALS['symbols'];
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
			GetArchives (&$fp);
			echo date('Y/m/d H:i:s u')."\t".'Synchronisation des horloges.'."\n";
			Waiting (4, 'Desactivation du retroeclairage');
			toggleLAMP($fp);
		}
		else
		{
			echo date('Y/m/d H:i:s u')."\t".'VP2 N´est pas disponible ! '.$ans."\n";
			fread($fp, 99); // vidange
			if ($i<$retry)	Waiting (40);
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
//			echo DMPAFT_GetVP2Date($d[0].$d[1].$d[2].$d[3]).' - >'.dechex(ord($d[0])).dechex(ord($d[1])).dechex(ord($d[2])).dechex(ord($d[3]))."<\n";
			fwrite($fp, $d[0].$d[1].$d[2].$d[3]);
			Waiting (4,'Demande d archives');
			$crc = CRC16_CCITT($d[0].$d[1].$d[2].$d[3]);
			fwrite($fp, $crc[0].$crc[1]);
			Waiting (12,'confirmation par CRC');
			$r = fread($fp, 1);
			if ($r == $symb['ACK'])
			{
				Waiting (1,'CRC Confirme, Recuperation des Archives');
				$n = fread($fp, 2);
				$p = fread($fp, 2);
				$r = fread($fp, 2);
//				echo strlen($r)."\n";
				$crc = CRC16_CCITT($n.$p.$r);
				if ($crc['Confirm'])
				{
					// $n = $r >> 32 & 0xff;
					// $p = $r >> 16 & 0xff;
					//$n = (ord($r[0])<<8)+ord($r[1]);
					//$p = (ord($r[2])<<8)+ord($r[3]);
					echo date('Y/m/d H:i:s u')."\t".'Nombre de Pages : '.pack("I",$n).'. debute aux data : '.((int)$p).".\n";
					fwrite($fp, $symb['ACK']);
					for ($j=0;$j<$n && $j<5;$j++)
					{
						$archives[$j] = fread($fp, 267);
						if (CRC16_CCITT($archives[$j]))
						{
							Waiting (4,'ARCHIVE : '.$j.' du '.DMPAFT_GetVP2Date(array($archives[$j][1],$archives[$j][2],$archives[$j][3],$archives[$j][4])).' valide');
							
							fwrite($fp, $symb['ACK']);
						}
						else fwrite($fp, $symb['NAK']);
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
	$crc=array('Confirm'=>false,0=>'',1=>'');
	$retry = 3;
	$symb = $GLOBALS['symbols'];
	echo date('Y/m/d H:i:s u')."\t".'Recuperation des valeurs Maxi et Mini.'."\n";
	for ($i=0;$i<=$retry && !$crc['Confirm'];$i++)
	{
		fwrite ($fp, "HILOWS\n");
		Waiting (8,'HILOWS : attente de la reponce.');
		$r = fread($fp, 1);
		if ($r == $symb['ACK'])
		{
			Waiting (8,'HILOWS : attente des donnees brutes.');
			$HILOWS = fread($fp, 438);
			$crc = CRC16_CCITT(&$HILOWS);
			if ($crc['Confirm'])
			{
				echo date('Y/m/d H:i:s u')."\t".'Traitement des valeurs Maxi et Mini...'."\n";
				// fonction de conversion...
			}
//	file_put_contents("./VP2-data.brut",$HILOWS);
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
	return $crc['Confirm'];
}
?>
