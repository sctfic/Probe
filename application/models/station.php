<?php
class station extends CI_Model {
	protected $data = NULL;
	public $confExtend = NULL;
	
	public $type = NULL;
	public $name = NULL;
	public $conf = NULL;
	
	function __construct($conf)
	{
		parent::__construct();
		/** il faut dissocier l initialisation des variable du chargement de la classe */
		$this->type = $conf['type'];
// 			unset ($conf['type']);
		$this->name = $conf['name'];
// 			unset ($conf['name']);
		$this->conf = $conf;
		$this->load->helper(array('cli_tools','binary','s.i.converter'));
		/**
		on charge la classe qui correspond a notre type de station,
		elle sera disponible sous la denominatiosn : $this->Current_Station->*
		**/
		$this->load->model($this->type, 'Current_Station', FALSE, $this->conf);
	}
	function get_archives()
	{
		try {
			if (!$this->Current_Station->initConnection())
				throw new Exception(sprintf(_('[Échec] Impossible de se connecter à %s par %s:%s'), $this->name, $this->conf['ip'], $this->conf['port']));
			$clock = $this->Current_Station->clockSync(5);
			$LastGetArch = '2012/08/03 23:10:00'; // cette valeur doit etre lu sur la derniere ligne de la base principale
			$this->data = $this->Current_Station->GetDmpAft($LastGetArch);
			if (!$this->Current_Station->closeConnection())
				throw new Exception(sprintf(_('[Échec] Fermeture de %s.'), $this->name));
			return true;
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
		return False;
	}

	function get_confs()
	{
		if ($this->Current_Station->initConnection()){
			log_message('wswds', _( sprintf('[Succès] Ouverture de la connexion à %s', $this->name) ) );
			if ($conf = $this->Current_Station->GetConfig()) {
				$this->confExtend = end($conf);
			}
			if ($this->Current_Station->closeConnection())
				log_message('wswds', sprintf( _('[Succès] Fermeture de %s correcte.'), $this->name ) );
			else
				log_message('warning', sprintf( _('[Échec] Fermeture de %s.'), $this->name ) );
		}
		else
			log_message('warning', sprintf( _('[Échec] Impossible de se connecter à %s par %s:%s.'), $this->name, $this->conf['ip'], $this->conf['port']) );
	}
	
	function dbSave() {
	
	}
	function fileSave() {
// 		$conf['Last']['DumpAfter'] = date('Y/m/d H:i:s');
		foreach ($this->data as $h=>$arch) {
			$folder = APPPATH.'../data/'.$this->name.'/'.substr($h, 0, 4).'/'.substr($h, 5, 2);
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