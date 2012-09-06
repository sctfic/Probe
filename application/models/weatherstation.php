<?php
// http://fmaz.developpez.com/tutoriels/php/comprendre-pdo/
class weatherstation extends CI_Model {
	protected $DBConf = NULL;
	public $lst = NULL;
	protected $data = NULL;
	public $confExtend = NULL;	
	public $type = NULL;
	public $name = NULL;
	public $conf = NULL;
	
	function __construct()
	{
		parent::__construct();
		log_message('debug',  __FUNCTION__.'('.__CLASS__.') '.__FILE__);
		$this->load->database(); // charge la base par defaut
		$this->type = $conf['type'];
// 			unset ($conf['type']);
		$this->name = $conf['name'];
// 			unset ($conf['name']);
		$this->conf = $conf;
		/**
			on charge la classe qui correspond a notre type de station,
			elle sera disponible sous la denominatiosn : $this->Current_Station->*
		*/
// 		$this->load->model($this->type, 'Current_Station', FALSE, $this->conf);
		include_once(APPPATH.'models/'.strtolower($this->type).'.php');
		$this->Current_Station = new $this->type($this->conf);
		
		try {
			if (is_string($conf['db']))
			{
				global $db, $active_group, $active_record;
				if (file_exists($file_path = APPPATH.'config/database.php'))
					include_once($file_path);
				else
					throw new Exception( _('Impossible de trouver le fichier : */config/database.php'));

				if ( isset($db[$this->conf['db']]) && is_array($db[$this->conf['db']])) {
					include_once(APPPATH.'models/dbdata.php');
					$this->dbdata = new dbdata($this->conf['db']);
// 					$this->load->model('dbdata', '', false, $conf['db']);
// 					$this->dbdata->__construct($conf['db']);
					if ( isset($this->dbdata) )
						log_message('db', sprintf( _('la basse 2 donnée [%s] est deffinie pour : %s'),$this->conf['db'], $this->name));
				}
				else throw new Exception(sprintf( _('Aucune Base 2 donnee definie pour cette station : %s (%s)'), $this->name, $this->conf['db']));
			}
			else throw new Exception(sprintf( _('Aucune config vers une Base 2 donnee pour cette station : %s'), $this->name));
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
		
		return true;
	}
	
	function get_archives()
	{
		try {
			if ( !$this->Current_Station->initConnection() )
				throw new Exception( sprintf( _('Impossible de se connecter à %s par %s:%s'), $this->name, $this->conf['ip'], $this->conf['port']));
			$clock = $this->Current_Station->clockSync(5);
			echo ">> ".$this->dbdata->get_Last_Date()." <<\n\n";
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
	
	/**
	 * retourne un tableau de tous les noms et db_ID de toute les stations
	 * @return	array (db_ID => Name)
	 */
	function lstNames()
	{// on demande la liste des NOM des stations meteo et les ID assoc
	$lst = $this->db->query( 
			'SELECT `CFG_STATION_ID`, `CFG_VALUE` 
			FROM `TR_CONFIG` 
			WHERE `CFG_LABEL`=\'name\' 
			LIMIT 16');
// 		$this->db->select('CFG_STATION_ID, CFG_VALUE')->from('TR_CONFIG')->where('CFG_LABEL','name')->limit(16);
// 		$lst = $this->db->get();

		log_message('db', 'Request list of sation');
		foreach($lst->result() as $item) { // on met en forme les resultat sous forme de tableau
			$this->lst[$item->CFG_STATION_ID] = $item->CFG_VALUE;
		}
		if (!is_array($this->lst)){
			log_message('warning', 'List of Weather Station is empty!');
			return false;
		}
		return $this->lst;
	}

	/**
	 * recupere sous forme de table l'ensemble des configs d'une ou de toutes les station
	 * @var item
		item peut etre le Numero db_ID ou le nom de la station dont on veut les confs
		si item est homis alors toutes les conf de toutes les stations sont retourné
	 * @return array ('name' => array (configs))
	 */
	function dbconfs2arrays($item = null)
	{
		if (!empty($item)) {
			if (is_numeric($item) && array_key_exists($item, $this->lst))
				$lst[$item]=$this->lst[$item];
			elseif (in_array($item, $this->lst))
				$lst[array_search($item, $this->lst)]=$item;
		}
		else {
			$lst=$this->lst;
		}
		
		$query = 'SELECT * FROM `TR_CONFIG` WHERE `CFG_STATION_ID`=? LIMIT 100';

		foreach($lst as $id => $item)
		{ // pour chaque station meteo on dresse la liste des configs
			log_message('db', "Load DB confs for : $item (id:$id)");
			$CurentStation = $this->db->query($query, $id);
			foreach($CurentStation->result() as $val)
			{ // on integre chacune des configs dans un tableau a 2 dimensions qui sera utilisé par la suite
				$confs[$item][strtolower($val->CFG_LABEL)]=$val->CFG_VALUE;
			}
			if (!isset($confs[$item]['ip']) || !isset($confs[$item]['port']) || !isset($confs[$item]['type'])) {
				log_message('warning', 'Missing confs for '.$item.' > Skipped!');
				unset($confs[$item]);
			}
		}
		if (count($confs) == 0){
			throw new Exception(_('Aucune configuration valide n\'est disponible'));
		}
		return $confs;
	}
	
	function arrays2dbconfs($id, $conf)
	{/** 3 cas sont possible :
	la conf n'existe pas > INSERT INTO
	la conf existe mais ne change pas de valeur > on ni change rien ! ou on reecris la meme valeur.
	la conf existe mais la valeur et modifier > UPDATE de la valeur et de la date */
		foreach ($conf as $label => $value) {
			$val = $this->db->escape($value);
		// http://codeigniter.com/user_guide/database/queries.html
			$query = 'INSERT INTO 
				`TR_CONFIG` (CFG_STATION_ID, CFG_LABEL, CFG_VALUE, CFG_LAST_WRITE) VALUES ('.$id.', \''.$label.'\', '.$val.', \''.date ("Y/m/d H:i:s").'\') 
			ON DUPLICATE KEY UPDATE 
				CFG_LAST_WRITE = IF('.$val.' != CFG_VALUE, \''.date ("Y/m/d H:i:s").'\',CFG_LAST_WRITE),
				CFG_VALUE = '.$val.';';
			$this->db->query($query);
		}
		log_message('db',  'Setting saved in DB');
	}
}