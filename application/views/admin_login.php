<html>
	<head></head>
	<body>
	<?php echo $msg; ?>
	<form action="<?php echo site_url("admin/admin/connecter"); ?>">
		Login  : <input name="login" type="text" /><br />
		Mdp  : <input name="mdp" type="text" /><br />
		<input type="submit" value="connexion" />
	</form>
	
	</body>
</html>