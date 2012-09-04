<?php
$db['ws-template']['hostname'] = 'mysql:host=localhost';
$db['ws-template']['username'] = 'wswds';
$crypt = new WS_rev_crypt('db-default');
$db['ws-template']['password'] = $crypt->read();
	unset($crypt);
$db['ws-template']['database'] = 'wswds';
$db['ws-template']['dbdriver'] = 'pdo';
$db['ws-template']['dbprefix'] = '';
$db['ws-template']['pconnect'] = TRUE;
$db['ws-template']['db_debug'] = TRUE;
$db['ws-template']['cache_on'] = FALSE;
$db['ws-template']['cachedir'] = '';
$db['ws-template']['char_set'] = 'utf8';
$db['ws-template']['dbcollat'] = 'utf8_general_ci';
$db['ws-template']['swap_pre'] = '';
$db['ws-template']['autoinit'] = TRUE;
$db['ws-template']['stricton'] = FALSE;

if (is_array($db['ws-template']))
	log_message('db', _('Config chargee : "ws-template"'));
