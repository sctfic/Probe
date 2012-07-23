<?php // clear;php5 -f /var/www/WsWds/cli.php 'cron'
class Cron extends CI_Controller {
	function __construct() {
		if (isset($_SERVER['REMOTE_ADDR'])) { // n'est pas definie en php5-cli
			die();
		}
		parent::__construct();
	}	
	// la fonction qui ce lancera par defaut dans cette classe 
	// clear;php5 -f /var/www/WsWds/cli.php 'cron'
	function index() {
		echo CI_VERSION." - ".ENVIRONMENT." - ".EXT." - ".FCPATH." - ".SELF." - ".BASEPATH." - ".APPPATH."\n";
// 		$this->config->load('station', TRUE);
// 		$stationConf = $this->config->item('station');
	}
	// clear;php5 -f /var/www/WsWds/cli.php 'cron/AutoArch'
	function Read() {
		foreach($stationConf as $configKey=>$configValue)
		{
			require_once (APPPATH.'models/dao/'.$configValue['type'].'/ConnexionManager.c.php');
			require_once (APPPATH.'models/dao/'.$configValue['type'].'/EepromManager.c.php');
			
			echo sprintf ("\n%'+40s %16s %'+40s\n", "", $configKey, "");
			$station = new dataFetcher($configKey, $configValue);
			if ($station->initConnection()){
				$configValue['Last']['Connected'] = date('Y/m/d H:i:s');
				Tools::Waiting( 0, _( sprintf('[Succès] Ouverture de la connexion à %s', $configKey) ) );
				if (($retuned = $station->clockSync(5))) {
					var_export($retuned);	// OK
					$configValue['Last']['ClockSync'] = $retuned;
				}
				if (($retuned = $station->GetDmpAft($configValue['Last']['_DumpAfter']))) {
					var_export(end($retuned));	// OK
					$configValue['Last']['_DumpAfter'] = key($retuned);
					$configValue['Last']['DumpAfter'] = date('Y/m/d H:i:s');
					foreach ($retuned as $h=>$arch) {
						$folder = APPPATH.'../data/'.$configKey.'/'.substr($h, 0, 4).'/'.substr($h, 5, 2);
						$file = $folder.'/'.substr($h, 8, 2).'.txt';
						if (is_file($file)) {
							file_put_contents($file,
								implode("\t",$arch)."\n", FILE_APPEND);
						}
						else {
							if (!file_exists($folder))
								mkdir($folder, 0777, true);
							file_put_contents($file,
								implode("\t",array_keys($arch))."\n".implode("\t",$arch)."\n");
						}
					}
				}
				if ($station->closeConnection())
					Tools::Waiting( 0, sprintf( _('[Succès] Fermeture de %s correcte.'), $configKey ) );
				else
					Tools::Waiting( 0, sprintf( _('[Échec] Fermeture de %s.'), $configKey ) );
			}
			else
				Tools::Waiting( 0, sprintf( _('[Échec] Impossible de se connecter à %s par %s:%s.'), $configKey, $configValue['IP'], $configValue['Port']) );
		}
// 		$this->config->set_item('station');
	}
}
