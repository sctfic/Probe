<?php
/*
* This file contains the dynamic i18n key logged with i18n( $string , true );;
* dynamic keys can't correctly retrieved by gettext as they exists only at run time
* so we log them and then collected them in a file using a bash script :
    BASEPATH="$HOME/probe"; # I host the project in my home directory
    cd "$BASEPATH";
    grep 'I18N' "$BASEPATH"/logs/log-*.php >> "$APPPATH"/language/i18n-collected-keys.php
*/
i18n('configuration-add-station.title.metadata');
i18n('configuration-add-station.description.metadata');
i18n('configuration-station.network-_ip.label');
i18n('configuration-station.network-_ip.placeholder');
i18n('configuration-station.network-_name.label');
i18n('configuration-station.network-_name.placeholder');
i18n('configuration-station.network-_port.label');
i18n('configuration-station.network-_port.placeholder');
i18n('configuration-station.network-_type.label');
i18n('configuration-station.network-_type.placeholder');
i18n('configuration-station-list.title.metadata');
i18n('configuration-station-list.description.metadata');
i18n('login.title.metadata');
i18n('login.description.metadata');
i18n('configuration-station.dbms.label');
i18n('configuration-station.network.label');
i18n('install-dbms.title.metadata');
i18n('install-dbms.description.metadata');
i18n('install-admin-user.title.metadata');
i18n('install-admin-user.description.metadata');
i18n('windrose.title.metadata');
i18n('windrose.description.metadata');
i18n('viewer.title.metadata');
i18n('viewer.description.metadata');
i18n('probe.authors.metadata');
i18n('curve.title.metadata');
i18n('curve.description.metadata');
i18n('currents.title.metadata');
i18n('currents.description.metadata');
i18n('graph.title.metadata');
i18n('graph.description.metadata');
i18n('curves.title.metadata');
i18n('curves.description.metadata');
i18n('SmartCurve.title.metadata');
i18n('SmartCurve.description.metadata');
i18n('SmartCurves.title.metadata');
i18n('SmartCurves.description.metadata');
i18n('SmartChart.title.metadata');
i18n('SmartChart.description.metadata');
i18n('histoWind.title.metadata');
i18n('histoWind.description.metadata');
i18n('wind.title.metadata');
i18n('wind.description.metadata');
i18n('configuration-list-station.title.metadata');
i18n('configuration-list-station.description.metadata');
i18n('configuration.breadcrumb.stations.list');
i18n('configuration.breadcrumb.stations.dashboard');
i18n('configuration.breadcrumb.stations.add');
i18n('viewer.histoWind');
i18n('exemple.title.metadata');
i18n('exemple.description.metadata');
i18n('dotShart.title.metadata');
i18n('dotShart.description.metadata');
i18n('bracketChart.title.metadata');
i18n('bracketChart.description.metadata');
