<?php
class dbconfig extends CI_Model {
	protected $DBConf = NULL;
	public $lst = NULL;

	function __construct()
	{
		parent::__construct();
		try{	//to connect
			$this->DBConf = $this->load->database('default', TRUE); // on se connecte a notre table (via pdo)
			$this->list_stations();
//			$DBConf->close();
//			unset($DBConf); 
		}
		catch(PDOException $e) {
			echo 'Please contact Admin: '.$e->getMessage();
		}
	}

	/**
	 * retourne un tableau de tous les noms et db_ID de toute les stations
	 * @return	array (db_ID => Name)
	 */
	function list_stations()
	{
		// on demande la liste des NOM des stations meteo et les ID associé
		$lst = $this->DBConf->query( 
			'SELECT `CFG_STATION_ID`, `CFG_VALUE` 
			FROM `TR_CONFIG` 
			WHERE `CFG_CODE`=1 
			LIMIT 0 , 16');

		// on met en forme les resultat sous forme de tableau
		foreach($lst->result() as $item)
			$this->lst[$item->CFG_STATION_ID] = $item->CFG_VALUE;

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

		foreach($lst as $id => $item)
		{ // pour chaque station meteo on dresse la liste des configs
			$CurentStation = $this->DBConf->query(
				'SELECT * 
				FROM `TR_CONFIG` 
				WHERE `CFG_STATION_ID`='.$id.' 
				LIMIT 0 , 100');
			foreach($CurentStation->result() as $val)
			{ // on integre chacune des configs dans un tableau a 2 dimensions qui sera utilisé par la suite
				$confs[$item][strtolower($val->CFG_LABEL)]=$val->CFG_VALUE;
			}
		}
		return $confs;
	}
	
	function arrays2dbconfs()
	{
		
	}
}