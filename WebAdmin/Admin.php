<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr">
	<head>
	<!-- En-tête du document  -->
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />

	<!-- Balise meta  -->
	<meta name="title" content="WsWds : Config Pages" />
	<meta name="description" content="Weather Station Web Data Share : Admin page" />
	<meta name="keywords" content="Weather Station, Web Data Share, Station meteo" />

	<!-- Indexer et suivre -->
	<meta name="robots" content="index" />

<?php
	if (is_file($workingFolder.'../stations.conf'))
		$stationConfig = eval('return '.file_get_contents($workingFolder.'../stations.conf').';');
	else {
		$stationConfig = array ();
	}
?>
	<!--  Relier une feuille CSS externe  -->
	<link rel='stylesheet' href='votre-fichier.css' type='text/css' />

	<!-- Incorporez du CSS dans la page  -->
	<style type="text/css" media="screen">
		p { color:red; }
	</style>

	<!-- fichier JavaScript  -->
	<script type="text/javascript" src="votre-script.js"></script>

	<!-- JavaScript dans la page  -->
	<script type="text/javascript">
		
	</script>

	<noscript><?echo _('echec de chargement des scripte *.JS');?></noscript>

	</head>
	<body>
	<!-- CORPS DE LA PAGE  -->
<?php
	include ($workingFolder.'banner.php');
	include ($workingFolder.'header.php');
	include ($workingFolder.'home.php');
	include ($workingFolder.'footer.php');
?>
	</body>
</html>
<?
	file_put_contents ($workingFolder.'../stations.conf', var_export($stationConfig, true ));
?>