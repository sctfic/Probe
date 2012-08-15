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
		$this->load->helper(array('cli_tools','binary','s.i.converter'));

		self::__init($conf);
	}

	function __destruct()
	{
		log_message('debug',  __FUNCTION__.'('.__CLASS__.') '.__FILE__);
		unset ($this->load->_ci_models [array_search (__CLASS__, $this->load->_ci_models)]);
	}
	
	function __init($conf, $force=false)
	{ // initialise le constante de cette classe separement du __construct()
		if (self::inited || !$force) return false;
		$this->type = $conf['type'];
// 			unset ($conf['type']);
		$this->name = $conf['name'];
// 			unset ($conf['name']);
		$this->conf = $conf;
		/**
			on charge la classe qui correspond a notre type de station,
			elle sera disponible sous la denominatiosn : $this->Current_Station->*
		*/
		$this->load->model($this->type, 'Current_Station', FALSE, $this->conf);
		$this->Current_Station->__init($this->conf);
		
		try {
			if (is_string($conf['db']))
			{
				if (file_exists($file_path = APPPATH.'config/database.php'))
					include($file_path);
				else if (defined('ENVIRONMENT') and file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php'))
					include($file_path);
				else
					throw new Exception( _('Impossible de trouver le fichier : */config/database.php'));
					
				if ( isset($db[$conf['db']]) && is_array($db[$conf['db']])) {
					$this->load->model('dbdata', '', false, $conf['db']);
					$this->dbdata->__construct($conf['db']);
					if ( isset($this->dbdata) )
						log_message('db', sprintf( _('la basse 2 donnée [%s] est deffinie pour : %s'),$conf['db'], $this->name));
				}
				else throw new Exception(sprintf( _('Aucune Base 2 donnee definie pour cette station : %s'), $this->name));
			}
			else throw new Exception(sprintf( _('Aucune config vers une Base 2 donnee pour cette station : %s'), $this->name));
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
		
		log_message('debug',  '__init('.$conf['name'].') '.__FILE__);
		return true;
	}
	
	function get_archives()
	{
		try {
			if ( !$this->Current_Station->initConnection() )
				throw new Exception( sprintf( _('Impossible de se connecter à %s par %s:%s'), $this->name, $this->conf['ip'], $this->conf['port']));
			$clock = $this->Current_Station->clockSync(5);
			$this->data = $this->Current_Station->GetDmpAft ( $this->dbdata->get_Last_Date() );
			if ( !$this->Current_Station->closeConnection() )
				throw new Exception( sprintf( _('Fermeture de %s impossible'), $this->name) );
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
				throw new Exception( sprintf( _('Impossible de se connecter à %s par %s:%s'), $this->name, $this->conf['ip'], $this->conf['port']));
			$conf = $this->Current_Station->GetConfig();
			if (!$conf)
				throw new Exception( sprintf( _('Lecture des config de %s impossible'), $this->name));
			// conf est un array('2012/08/04 15:30:00'=>array(...))
			// qui ne contiend qu'une seule valeur de niveau 1 mais dont la clef est variable
			// end() permet de recupere cette valeur quelque soit ca clef.
			$this->confExtend = end($conf);
			if (!$this->Current_Station->closeConnection())
				throw new Exception( sprintf( _('Fermeture de %s impossible'), $this->name));
			return $this->confExtend;
		}
		catch (Exception $e) {
			throw new Exception( $e->getMessage() );
		}
		return true;
	}
	
	function fileSave() {
/**
	sauve un fichier par jour sans doublon de donnée.
	dans le dossier ./data/ %année% / %mois% / %jour%.tsv
	Tabulation separated values >> http://fr.wikipedia.org/wiki/Format_TSV
*/
// 		$conf['Last']['DumpAfter'] = date('Y/m/d H:i:s');
		foreach ($this->data as $h=>$arch) {
			$folder = APPPATH.'../data/'.$this->name.'/'.substr($h, 0, 4).'/'.substr($h, 5, 2);
			$file = $folder.'/'.substr($h, 8, 2).'.tsv';
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