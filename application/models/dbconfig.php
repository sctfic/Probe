<?php
// http://fmaz.developpez.com/tutoriels/php/comprendre-pdo/
class dbconfig extends CI_Model {
	protected $DBConf = NULL;
	public $lst = NULL;

	function __construct()
	{
		log_message('debug',  '__construct() '.__FILE__);
		parent::__construct();
		$this->list_stations();
	}

	/**
	 * retourne un tableau de tous les noms et db_ID de toute les stations
	 * @return	array (db_ID => Name)
	 */
	function list_stations()
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
				log_message('warning', 'Missing confs for '.$item);
				unset($confs[$item]);
			}
		}
		if (count($confs) == 0){
			throw new Exception(_('Aucune configuration valide n\'est disponible'));
		}
		return $confs;
	}
	
	function arrays2dbconfs($id, $conf)
	{
		$query = 'REPLACE INTO `TR_CONFIG` (CFG_STATION_ID, CFG_LABEL, CFG_VALUE, CFG_LAST_WRITE) VALUES (?, ?, ?, ?);';
		$prep = $this->db->conn_id->prepare($query);
		foreach ($conf as $label => $value) {
			//Associer des valeurs aux place holders
			$prep->bindValue(1, $id, PDO::PARAM_INT);
			$prep->bindValue(2, $label, PDO::PARAM_STR);
			$prep->bindValue(3, $value, PDO::PARAM_STR);
			$prep->bindValue(4, strtotime (date ("Y-m-d H:i:s")), PDO::PARAM_STR);
			//Compiler et exécuter la requête
			$prep->execute();
		}
		//Clore la requête préparée
		$prep->closeCursor();
		$prep = NULL;
	}
}