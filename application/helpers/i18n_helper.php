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
	if ($dynamic == true) { log_message('I18N', printf('%s', $key ) ); }
	return _($key);
}
