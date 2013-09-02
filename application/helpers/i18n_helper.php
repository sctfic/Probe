<?
/* 
* This file contains the dynamic i18n key logged with i18n( $string , true );
* dynamic keys can't correctly retrieved by gettext as they exists only at run time
* so we log them and then collected them in a file using a bash script : 
	BASEPATH="$HOME/probe"; # I host the project in my home directory
	cd "$BASEPATH";
	grep 'I18N' "$BASEPATH"/logs/log-*.php >> "$APPPATH"/language/i18n-collected-keys.php
*/
?>
<?php
/*
@description: wrapper for the gettext method or Code Igniter language method
@param: $str, i18n key
@param: $dynamic, default 'false'.
		'true' means the key is known at run-time only, so we log it.
		'false' means the key is write in the file (so extractable by gettext).
@return: translated string
*/
function i18n($key, $dynamic = false) { //
	$i18nCollector = FCPATH.APPPATH.'language/i18n-collected-keys.php';

	if ($dynamic == true && strpos(file_get_contents($i18nCollector), $key) === FALSE) { 
		// log_message('i18n', sprintf('%s', $key ) ); 

		file_put_contents($i18nCollector, sprintf("i18n('%s');\n", $key ), FILE_APPEND );
	}
	return _($key);
}

