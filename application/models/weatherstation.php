<?php
// http://fmaz.developpez.com/tutoriels/php/comprendre-pdo/
class weatherstation extends CI_Model {
	protected $DBConf = NULL;
	public $lst = NULL;
	protected $data = NULL;
	protected $confExtend = NULL;	
	protected $type = NULL;
	protected $name = NULL;
	protected $conf = NULL;
	
	function __construct()
	{
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		parent::__construct();
		$this->load->database(); // charge la base par defaut
		$this->lstNames();
	}
	
	/**
	 * retourne un tableau de tous les noms et db_ID de toute les stations
	 * @return	array (db_ID => Name)
	 */
	function lstNames()
	{
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		// on demande la liste des NOM des stations meteo et les ID assoc
		$lst = $this->db->query( 
			'SELECT `CFG_STATION_ID`, `CFG_VALUE` 
			FROM `TR_CONFIG` 
			WHERE `CFG_LABEL`=\'_name\' 
			LIMIT 16');
		if ($lst->num_rows() > 0)
		{
			foreach($lst->result() as $item) { // on met en forme les resultat sous forme de tableau
				$this->lst[$item->CFG_STATION_ID] = $item->CFG_VALUE;
			}
			if (is_array($this->lst))
				return $this->lst;
		}
		log_message('warning', 'List of Weather Station is empty!');
		return false;
	}
	/**
	 * recupere les premier ID nom utilisé parmis la liste des ID des stations
	 * @return array ()
	 **/
	function availableID () {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		// given array : $this->lst. [0,1,  3,4,  6,7  ]
		// construct a new array :   [0,1,2,3,4,5,6,7,8]
		// use array_diff to get the missing elements 
		if (empty($this->lst))
			return array(0);
		return array_diff (range(0, max(array_keys($this->lst))+1), array_keys($this->lst)); // [2,5,8]
	}
	/**
	 * recupere sous forme de table l'ensemble des configs d'une ou de toutes les station
	 * @var item
		item peut etre le Numero db_ID ou le nom de la station dont on veut les confs
		si item est ommis alors toutes les conf de toutes les stations sont retourné
	 * @return array ('name' => array (configs))
	 */
	function config($item = null)	{
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		if (!is_array($this->lst = $this->lstNames()))
			return array();
		if (!empty($item)) {
			if (is_numeric($item) && array_key_exists($item, $this->lst)) {
			//dans le cas ou je connais deja de ID de ma station
				$lst[$item]=$this->lst[$item];
			}
			elseif (in_array($item, $this->lst))
			//dans le cas ou je ne connais que le nom
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
			$confs[$item]['_id'] = $id;
			foreach($CurentStation->result() as $val)
			{ // on integre chacune des configs dans un tableau a 2 dimensions qui sera utilisé par la suite
				$confs[$item][strtolower($val->CFG_LABEL)] = $val->CFG_VALUE;
			}
			if (empty($confs[$item]['username']) || empty($confs[$item]['password']) || empty($confs[$item]['dbdriver']) || empty($confs[$item]['_ip']) || empty($confs[$item]['_port']) || empty($confs[$item]['_type'])) {
				log_message('warning', 'Missing confs for '.$item.' > Skipped!');
				unset($confs[$item]);
			}
		}
		if (count($confs) == 0){
			throw new Exception(_('Aucune configuration valide n\'est disponible'));
		}
		// on decode le password.
		$confs[$item]['password'] = $this->encrypt->decode($confs[$item]['password']);
		return $confs;
	}
	function HilowsCollector($conf) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__);
		$type = strtolower($conf['_type']);
		include_once(APPPATH.'models/'.$type.'.php');
		$Current_WS = new $type($conf);
		try {
			if ( !$Current_WS->initConnection() )
				throw new Exception( sprintf( _('Impossible de se connecter à %s par %s:%s'), $conf['_name'], $conf['_ip'], $conf['_port']));
			$this->data = $Current_WS->GetHiLows ( );
			if ( !$Current_WS->closeConnection() )
				throw new Exception( sprintf( _('Fermeture de %s impossible'), $conf['_name']) );
		}
		catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
		return true;
	}
	function LpsCollector($conf) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__);
		$type = strtolower($conf['_type']);
		include_once(APPPATH.'models/'.$type.'.php');
		$Current_WS = new $type($conf);
		try {
			if ( !$Current_WS->initConnection() )
				throw new Exception( sprintf( _('Impossible de se connecter à %s par %s:%s'), $conf['_name'], $conf['_ip'], $conf['_port']));
			$this->data = $Current_WS->GetLPS ( );
			if ( !$Current_WS->closeConnection() )
				throw new Exception( sprintf( _('Fermeture de %s impossible'), $conf['_name']) );
		}
		catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
		return true;
	}
	/**
	 * recupere sous forme de table l'ensemble des configs d'une ou de toutes les station
	 * @var item
		item peut etre le Numero db_ID ou le nom de la station dont on veut les confs
		si item est homis alors toutes les conf de toutes les stations sont retourné
	 * @return array ('name' => array (configs))
	 */
	function ArchCollector($conf)
	{
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__);
		$type = strtolower($conf['_type']);
		include_once(APPPATH.'models/'.$type.'.php');
		$Current_WS = new $type($conf);
		try {
			if ( !$Current_WS->initConnection() )
				throw new Exception( sprintf( _('Impossible de se connecter à %s par %s:%s'), $conf['_name'], $conf['_ip'], $conf['_port']));
			$clock = $Current_WS->clockSync(5);
			$this->data = $Current_WS->GetDmpAft ( $Current_WS->get_Last_Date() );
			if ( !$Current_WS->closeConnection() )
				throw new Exception( sprintf( _('Fermeture de %s impossible'), $conf['_name']) );
		}
		catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
		return true;
	}

	function ConfCollector($conf)
	{
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__);
		$type = strtolower($conf['_type']);
		include_once(APPPATH.'models/'.$type.'.php');
		$Current_WS = new $type($conf);
		try {
			if ( !$Current_WS->initConnection() )
				throw new Exception( sprintf( _('Impossible de se connecter à %s par %s:%s'), $conf['_name'], $conf['_ip'], $conf['_port']));
			$clock = $Current_WS->clockSync(2);
			if (!($realconf = end($Current_WS->GetConfig())))
				throw new Exception( sprintf( _('Lecture des config de %s impossible'),$conf['_name']));
			// conf est un array('2012/08/04 15:30:00'=>array(...))
			// qui ne contiend qu'une seule valeur de niveau 1 mais dont la clef est variable
			// end() permet de recupere cette valeur quelque soit ca clef.
			if ( !$Current_WS->closeConnection() )
				throw new Exception( sprintf( _('Fermeture de %s impossible'), $conf['_name']) );
		}
		catch (Exception $e) {
			throw new Exception( $e->getMessage() );
		}
		return $realconf;
	}
	
	
	
		
	function arrays2dbconfs($id, $conf)
	{/** 3 cas sont possible :
	la conf n'existe pas > INSERT INTO
	la conf existe mais ne change pas de valeur > on ni change rien ! ou on reecris la meme valeur.
	la conf existe mais la valeur et modifier > UPDATE de la valeur et de la date */
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__);
		if (isset($conf['password']))
			$conf['password'] = $this->encrypt->encode($conf['password']);

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