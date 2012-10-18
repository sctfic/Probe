<?
/* 
* This file contains the dynamic i18n key logged with i18n( $string , true );
* dynamic keys can't correctly retrieved by gettext as they exists only at run time
* so we log them and then collected them in a file using a bash script : 
	BASEPATH="$HOME/probe"; # I host the project in my home directory
	cd "$BASEPATH";
	grep 'I18N' "$BASEPATH"/logs/log-*.php >> "$APPPATH"/language/i18n-collected-keys.php
*/
_();