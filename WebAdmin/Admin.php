<?php
	if (is_file($GLOBALS['WsWdsConfig']['path']['root'].'stations.conf'))
		$stationConfig = eval('return '.file_get_contents($GLOBALS['WsWdsConfig']['path']['root'].'stations.conf').';');
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
	include ($GLOBALS['WsWdsConfig']['path']['root'].'WebAdmin/home.php');
?>
	</body>
</html>
<?
	file_put_contents ($GLOBALS['WsWdsConfig']['path']['root'].'stations.conf', var_export($stationConfig, true ));
?>