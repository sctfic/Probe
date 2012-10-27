<?php
/**
* this function generate a random string
* @param size of string
* @param list of autorized char
**/
function randomPassword($size=8, $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789") {
	for ($i = 0; $i < $size; $i++) {
		$n = rand(0, strlen($alphabet)-1);
		$pass[$i] = $alphabet[$n];
	}
	return implode($pass);
}
/**
* this function write in APPPATH.'config/db-default.php' file the 
* necessary connection config to reconnect later
* @param array () of config
**/
function array2conf_php($file, $conf_val, $conf_name="db['default']") {
	if (file_put_contents($file, "<?php\n\$".$conf_name." = ".var_export($conf_val, TRUE).";") === FALSE)
		throw new Exception( i18n('Impossible d ecrire le fichier de config : '.APPPATH.'config/db-default.php') );
	return true;
}
function where_I_Am ($f, $c, $fn, $l, $args) {
			log_message('current',  basename($f).'['.$l."]:\n".$c.'->'.$fn.'('.implode(', ',$args).')');
}