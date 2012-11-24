<?
/* 
* This file contains the dynamic i18n key logged with i18n( $string , true );
* dynamic keys can't correctly retrieved by gettext as they exists only at run time
* so we log them and then collected them in a file using a bash script : 
	BASEPATH="$HOME/probe"; # I host the project in my home directory
	cd "$BASEPATH";
	grep 'I18N' "$BASEPATH"/logs/log-*.php >> "$APPPATH"/language/i18n-collected-keys.php
*/
i18n('configure-add-station:title')
i18n('configure-add-station:description')
i18n('configure-add-station:author')
i18n('configuration.station.network._ip')
i18n('configuration.station.network._ip.placeholder')
i18n('configuration.station.network._name')
i18n('configuration.station.network._name.placeholder')
i18n('configuration.station.network._port')
i18n('configuration.station.network._port.placeholder')
i18n('configuration.station.network._type')
i18n('configuration.station.network._type.placeholder')
i18n('setup-admin-user:title')
i18n('setup-admin-user:description')
i18n('setup-admin-user:author')
i18n('login:title')
i18n('login:description')
i18n('login:author')
i18n('configure-station-list:title')
i18n('configure-station-list:description')
i18n('configure-station-list:author')
