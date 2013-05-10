<?php
/*
* This file contains the dynamic i18n key logged with i18n( $string , true );;
* dynamic keys can't correctly retrieved by gettext as they exists only at run time
* so we log them and then collected them in a file using a bash script :
    BASEPATH="$HOME/probe"; # I host the project in my home directory
    cd "$BASEPATH";
    grep 'I18N' "$BASEPATH"/logs/log-*.php >> "$APPPATH"/language/i18n-collected-keys.php
*/
i18n('configure-add-station:title');
i18n('configure-add-station:description');
i18n('configuration.station.network._ip');
i18n('configuration.station.network._ip.placeholder');
i18n('configuration.station.network._name');
i18n('configuration.station.network._name.placeholder');
i18n('configuration.station.network._port');
i18n('configuration.station.network._port.placeholder');
i18n('configuration.station.network._type');
i18n('configuration.station.network._type.placeholder');
i18n('configure-station-list:title');
i18n('configure-station-list:description');
i18n('login:title');
i18n('login:description');
i18n('configuration.station.tab.dbms');
i18n('configuration.station.tab.network');
i18n('setup-dbms:title');
i18n('setup-dbms:description');
i18n('setup-admin-user:title');
i18n('setup-admin-user:description');
i18n('probe_d3:title');
i18n('probe_d3:description');
i18n('windrose:title');
i18n('windrose:description');
i18n('list-view:title');
i18n('list-view:description');
i18n('viewer:title');
i18n('viewer:description');
i18n('probe:authors');
i18n('curve:title');
i18n('curve:description');
i18n('curents:title');
i18n('curents:description');
i18n('currents:title');
i18n('currents:description');
i18n('graph:title');
i18n('graph:description');
i18n('curves:title');
i18n('curves:description');
i18n('SmartCurve:title');
i18n('SmartCurve:description');
i18n('SmartCurve?station=VP2_GTD&sensor=TA:Arch:Temp:Out:Average:title');
i18n('SmartCurve?station=VP2_GTD&sensor=TA:Arch:Temp:Out:Average:description');
i18n('SmartCurve?station=VP2_Gtd&sensor=test:title');
i18n('SmartCurve?station=VP2_Gtd&sensor=test:description');
i18n('SmartCurves:title');
i18n('SmartCurves:description');
i18n('SmartChart:title');
i18n('SmartChart:description');
i18n('histoWind:title');
i18n('histoWind:description');
i18n('wind:title');
i18n('wind:description');
i18n('configure-list-station:title');
i18n('configure-list-station:description');
i18n('configuration.breadcrumb.stations.list');
i18n('configuration.breadcrumb.stations.dashboard');
i18n('configuration.breadcrumb.stations.add');
i18n('viewer.histoWind');
