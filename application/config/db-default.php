<?php

include_once(APPPATH.'libraries/WS_rev_crypt.php');

$db['default']['hostname'] = 'mysql:host=localhost';
// this is the default user name for the database
$db['default']['username'] = 'wswds';
	$crypt = new WS_rev_crypt('db-default');
// this is the default PASSWORD for the database. 
// Once you had a successful run, you MUST remove this line 

	// cette syntaxe ne fonctionne pas dans ce fichier, nous ne somme pas dans le contexte de CI
	// $this->load->libraries('WS_rev_crypt', 'default');
	// $this->WS_rev_crypt->read();

	$db['default']['password'] = $crypt->read();
		unset($crypt);
$db['default']['database'] = 'wswds';
$db['default']['dbdriver'] = 'pdo';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

if (is_array($db['default']))
	log_message('db', _('Config chargee : "default"'));
