<!DOCTYPE html PUBLIC "-//W3C//DTD Xhtml 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Login</title>
		<script type="text/javascript" src="*.js"></script>
		<link href="*.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="divLogin">
		<form action="?" method="get" id="formLogin" >
			<input type="text" name="login" id="login" />
			<input type="password" name="code" id="code" />
<?php
	if (empty($WsWdsConfig['AdminInterface']['Username']) && empty($WsWdsConfig['AdminInterface']['Password']))
		echo '			<input type="password" name="confirm" id="confirm" />'."\n";
?>
		<input type="submit" value="login" />
		<!--keygen name="security" /-->
		</form>
		<span id="erreur" style="color:red"></span>
		</div>
	</body>
</html>