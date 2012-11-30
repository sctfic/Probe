<?php
// clear;php5 -f cli.php 'className/index'
// http://codeigniter.fr/cms/utiliser-codeigniter-dans-linvite-de-commandes/
// https://github.com/philsturgeon/codeigniter-cli

if (isset($_SERVER['REMOTE_ADDR'])) {
	die(); // Empêche l'exécution de ce fichier par le navigateur
}

DEFINE ('RUNNER', 'CLI');

set_time_limit(0);

$_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'] = $argv[1];

require dirname(__FILE__) . '/index.php';

