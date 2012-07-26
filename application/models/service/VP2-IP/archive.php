<?php // Use the controller tu run it
// $this->load->model('service/VP2-IP/archive');
class Archive extends CI_Model {
	protected $data = NULL;

	function __construct()
	{
		parent::__construct();
	}

	function get($name, $conf) {
		echo sprintf ("\n%'+40s %16s %'+40s\n", "", $name, "");
		require_once	(APPPATH.'models/dao/'.$conf['Type'].'/ConnexionManager.c.php');
		require_once	(APPPATH.'models/dao/'.$conf['Type'].'/EepromManager.c.php');
		
		$station = new dataFetcher($name, $conf);
		if ($station->initConnection()){
			$conf['Last']['Connected'] = date('Y/m/d H:i:s');
			Tools::Waiting( 0, _( sprintf('[Succès] Ouverture de la connexion à %s', $name) ) );
			if (($clock = $station->clockSync(5))) {
				$conf['Last']['ClockSync'] = $clock;
			}
		$LastGetArch = '2012/07/24 16:20:00'; // cette valeur doit etre lu sur la derniere ligne de la base principale
			$this->data = $station->GetDmpAft($LastGetArch);
//			var_export(end($retuned));	// OK
			if ($station->closeConnection())
				Tools::Waiting( 0, sprintf( _('[Succès] Fermeture de %s correcte.'), $name ) );
			else
				Tools::Waiting( 0, sprintf( _('[Échec] Fermeture de %s.'), $name ) );
		}
		else
			Tools::Waiting( 0, sprintf( _('[Échec] Impossible de se connecter à %s par %s:%s.'), $name, $conf['IP'], $conf['Port']) );
	}
	function dbSave($name) {
	
	}

	function fileSave($name) {
		$conf['Last']['DumpAfter'] = date('Y/m/d H:i:s');
		foreach ($this->data as $h=>$arch) {
			$folder = APPPATH.'../data/'.$name.'/'.substr($h, 0, 4).'/'.substr($h, 5, 2);
			$file = $folder.'/'.substr($h, 8, 2).'.txt';
			if (is_file($file) && substr($h, -8, 8)!='00:00:00') {
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
}
