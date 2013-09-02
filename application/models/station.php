<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// http://fmaz.developpez.com/tutoriels/php/comprendre-pdo/
class Station extends CI_Model {

/**

	* 
	*/
	protected $DBConf = NULL;
	public $stationsList = array();
	protected $data = NULL;
	protected $confExtend = NULL;	
	protected $type = NULL;
	protected $name = NULL;
	protected $conf = NULL;
	

/**

	* @param
	* @var 
	* @return 
	*/
	function __construct() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		parent::__construct();
		$this->load->database(); // charge la base par defaut : probe
		$this->listStations();
	}
	
	
/**

	* retourne un tableau de tous les noms et db_ID de toute les stations
	* @return	array (db_ID => Name)
	*/
	function listStations() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

		// on demande la liste des NOM des stations meteo et les ID assoc
		$sqlStationsList = 
			" SELECT `CFG_STATION_ID`, `CFG_VALUE` 
				FROM `TR_CONFIG` 
				WHERE `CFG_LABEL`='_name' 
				LIMIT 16;
			";
		$dbStationsList = $this->db->query( $sqlStationsList );

		if ($dbStationsList->num_rows() > 0)
		{
			foreach($dbStationsList->result() as $item) { // on met en forme les resultat sous forme de tableau
				$this->stationsList[$item->CFG_STATION_ID] = $item->CFG_VALUE;
			}
			if (is_array($this->stationsList) and !empty($this->stationsList))
				return $this->stationsList;
		}
		// log_message('warning', 'List of Weather Station is empty!');
		return false;
	}


/**

	* recupere les premier ID nom utilisé parmis la liste des ID des stations
	* @return array ()
	*/
	function availableID () {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		// given array : $this->stationsList. [0,1,  3,4,  6,7  ]
		// construct a new array :   [0,1,2,3,4,5,6,7,8]
		// use array_diff to get the missing elements 
		if (empty($this->stationsList))
			return array(0);
		return array_diff (range(0, max(array_keys($this->stationsList))+1), array_keys($this->stationsList)); // [2,5,8]
	}


/**

	* recupere sous forme de table l'ensemble des configs d'une ou de toutes les station
	* @var item
		item peut etre le Numero db_ID ou le nom de la station dont on veut les confs
		si item est ommis alors toutes les conf de toutes les stations sont retourné
	* @return array ('name' => array (configs))
	*/
	function config($item = null) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		if (is_numeric($item) && array_key_exists($item, $this->stationsList)) {
			//dans le cas ou je connais deja de ID de ma station
			$stationsList[$item]=$this->stationsList[$item];
		}
		elseif (in_array($item, $this->stationsList)){
			//dans le cas ou je ne connais que le nom
			$stationsList[array_search($item, $this->stationsList)]=$item;
		}
		else throw new Exception(
            // i18n('error.parameter:type-exception.label')
        );
		
		$query = 'SELECT * FROM `TR_CONFIG` WHERE `CFG_STATION_ID`=? LIMIT 100';

		foreach($stationsList as $id => $item)
		{ // pour chaque station meteo on dresse la liste des configs
			log_message('db', sprintf(
                i18n("station[%s%s].fetch-config.label"),
                $item, $id
            ));
			$CurentStation = $this->db->query($query, $id);
			$confs[$item]['_id'] = $id;
			foreach($CurentStation->result() as $val)
			{ // on integre chacune des configs dans un tableau a 2 dimensions qui sera utilisé par la suite
				$confs[$item][$val->CFG_LABEL] = $val->CFG_VALUE;
			}
			if (empty($confs[$item]['username']) || empty($confs[$item]['password']) || empty($confs[$item]['dbdriver']) || empty($confs[$item]['_ip']) || empty($confs[$item]['_port']) || empty($confs[$item]['_type'])) {
				log_message('warning', sprintf(
                    i18n('station[%s].fetch-config:fail.label'),
                    $item
                ));
				unset($confs[$item]);
			}
		}
		if (count($confs) == 0){
			throw new Exception(
                i18n('station.fetch-config:none.label')
            );
		}
		// on decode le password.
		$confs[$item]['password'] = $this->encrypt->decode($confs[$item]['password']);

		return $confs;
	}


/**

	* teste depuis combien de temps on ne s'est pas connecter a la station
	* si besoin alors on s'y connecte et on lit les configs, les datas et on refait une synchro.
	* @param array (toute les dernieres config de la station a verifier)
	* @return retourne true si tous s'est bien passé
	*/
	function AllCollector($conf = null) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__);
		if (!isset($conf['_type']))
			throw new Exception(
                i18n('error.parameter:type-exception.label')
            );
		$type = strtolower($conf['_type']);
		include_once(APPPATH.'models/'.$type.'.php');
		$Current_WS = new $type($conf);
		$Last_Arch = $Current_WS->get_Last_Date();
		if (!isset($conf['time:archive:period'])
			|| strtotime(date ("Y/m/d H:i:s")) > strtotime($Last_Arch) + $conf['time:archive:period']*60*2)
		{
			try {
				if ( !$Current_WS->initConnection() )
					throw new Exception( sprintf(
                        i18n('station[%s].open-connexion[%s%s]:fail.label'),
                        $conf['_name'],
                        $conf['_ip'],
                        $conf['_port']
                    ));
	
				// on lit et sauve les configs
				$readconf = end ($Current_WS->GetConfig ( ));
				foreach ($readconf as $key => $val) {
					if (strpos($key, 'TR:Config:')!==FALSE) {
						$ToStoreConfig[str_replace('TR:Config:', '', $key)] = $val;
						$conf[str_replace('TR:Config:', '', $key)] = $val;
					}
				}
				$this->station->arrays2dbconfs($conf['_id'], $ToStoreConfig);
	
				// on synchronise les orloges
				$Current_WS->clockSync(5);
	
				// on lit et sauve les valeurs courantes
				$Current_WS->GetLPS ( );
	
				// on recupere les archives seulement si ca fait plus de 2 periode qu'on ne l'as pas fait
				$this->data = $Current_WS->GetDmpAft ( $Last_Arch );
	
				// on lit et sauve les maxi-mini
				$this->data = $Current_WS->GetHiLows ( );
	
				if ( !$Current_WS->closeConnection() )
					throw new Exception( sprintf(
                        i18n('station.close-connexion[%s]:fail.label'),
                        $conf['_name']
                    ));
			}
			catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
		else throw new Exception(sprintf(
            i18n('station[%s].archives:up-to-date[%s].label'),
            $conf['_name'],
            $Last_Arch
        ));
	}
/**

	* teste depuis combien de temps on ne s'est pas connecter a la station
	* si besoin alors on s'y connecte et on lit les configs, les datas et on refait une synchro.
	* @param array (toute les dernieres config de la station a verifier)
	* @return retourne true si tous s'est bien passé
	*/
	function CurrentsCollector($conf = null) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__);
		if (!isset($conf['_type']))
			throw new Exception(i18n('error.parameter:type-exception.label'));
		$type = strtolower($conf['_type']);
		include_once(APPPATH.'models/'.$type.'.php');
		$Current_WS = new $type($conf);

		try {
			if ( !$Current_WS->initConnection() )
				throw new Exception( sprintf(
                    i18n('station[%s].open-connexion[%s%s]:fail.label'),
                    $conf['_name'],
                    $conf['_ip'],
                    $conf['_port']
                ));

            // $this->data['CONF'] = $conf;

			// on lit et sauve les valeurs courantes
			$this->data['LPS'] = $Current_WS->GetLPS (1,1 );

			// on lit et sauve les maxi-mini
			$this->data['HILOW'] = $Current_WS->GetHiLows ( );

			if ( !$Current_WS->closeConnection() )
				throw new Exception( sprintf(
                    i18n('station.close-connexion[%s]:fail.label'), $conf['_name']
                ));
		}
		catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
		return $this->data;
	}
	

/**

	* @param
	* @var 
	* @return 
	*/		
	function arrays2dbconfs($id, $conf) {/** 3 cas sont possible :
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