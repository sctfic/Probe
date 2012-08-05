<?php
class station extends CI_Model {
	protected $data = NULL;
	public $confExtend = NULL;
	
	public $type = NULL;
	public $name = NULL;
	public $conf = NULL;
	
	function __construct($conf)
	{
		log_message('debug',  '__construct('.$conf['name'].') '.__FILE__);
		parent::__construct();
		/** il faut dissocier l initialisation des variable du chargement de la classe */
		$this->type = $conf['type'];
// 			unset ($conf['type']);
		$this->name = $conf['name'];
// 			unset ($conf['name']);
		$this->conf = $conf;
		$this->load->helper(array('cli_tools','binary','s.i.converter'));
		
		/**	on charge la classe qui correspond a notre type de station,
			elle sera disponible sous la denominatiosn : $this->Current_Station->*	*/
		$this->load->model($this->type, 'Current_Station', FALSE, $this->conf);
		$this->Current_Station->__construct($this->conf);
	}
	function get_archives()
	{
		try {
			if (!$this->Current_Station->initConnection())
				throw new Exception(sprintf(_('Impossible de se connecter à %s par %s:%s'), $this->name, $this->conf['ip'], $this->conf['port']));
			$clock = $this->Current_Station->clockSync(5);
			
			$LastGetArch = '2012/08/04 21:30:00'; // cette valeur doit etre lu sur la derniere ligne de la base principale
			$this->data = $this->Current_Station->GetDmpAft($LastGetArch);
			if (!$this->Current_Station->closeConnection())
				throw new Exception(sprintf(_('Fermeture de %s impossible'), $this->name));
		}
		catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
		return true;
	}

	function get_confs()
	{
		try {
			if (!$this->Current_Station->initConnection())
				throw new Exception(sprintf(_('Impossible de se connecter à %s par %s:%s'), $this->name, $this->conf['ip'], $this->conf['port']));
			$conf = $this->Current_Station->GetConfig();
			if (!$conf)
				throw new Exception(sprintf(_('Lecture des config de %s impossible'), $this->name));
			// conf est un array('2012/08/04 15:30:00'=>array(...))
			// qui ne contiend qu'une seule valeur de niveau 1 mais dont la clef est variable
			// end() permet de recupere cette valeur quelque soit ca clef.
			$this->confExtend = end($conf);
			if (!$this->Current_Station->closeConnection())
				throw new Exception(sprintf(_('Fermeture de %s impossible'), $this->name));
			return $this->confExtend;
		}
		catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
		return true;
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