<?php

class ProbePdo {
	protected $CI;
	
	protected $hostname;
	protected $userName;
	protected $password;
	protected $database;
	protected $engine;
	
	/** 
	 * Connection pdo
	 */
	protected $connection;
	
	
	public function __construct($parameters = array()) {
		$this->CI =& get_instance();
		
		// Is the config file in the environment folder?
		if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php')) {
			if ( ! file_exists($file_path = APPPATH.'config/database.php')) {
				show_error('The configuration file database.php does not exist.');
			}
		}
		
		include($file_path);
		
		if ( ! isset($db) OR count($db) == 0) {
			show_error('No database connection settings were found in the database config file.');
		}
		
		
		$groupBD = (empty($parameters["group"])) ? $active_group: $parameters["group"];
		
		if ( ! isset($active_group) OR ! isset($db[$active_group])) {
			show_error('You have specified an invalid database connection group.');
		}
		
		$params = $db[$groupBD];
		$this->hostname = $params["hostname"];
		$this->userName = $params["username"];
		$this->password = $params["password"];
		if(isset($params["database"])) {
			$this->database = $params["database"];
		}
		
		$this->engine = $params["dbdriver"];
		$this->initialize();
	}
	
	/**
	 * Initialise la connexion pdo
	 */
	private function initialize() {
		$this->hostname = (empty($this->database)) ? $this->hostname : $this->hostname .= ";dbname=".$this->database;
		$this->connection = new PDO($this->hostname, $this->userName, $this->password);
		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	
	
	public function query($sql, $param, $fetch = PDO::FETCH_ASSOC) {
		$requete = $this->connection->prepare($sql);
		$requete->execute($param);
		
		// Instanciation d'un résultat
		$driver			= $this->load_rdriver();
		$RES			= new $driver();
		$RES->statement	= $requete;
		
		return $RES;
	}
	
	
	/**
	 * Load the result drivers
	 *
	 * @access	public
	 * @return	string	the name of the result class
	 */
	function load_rdriver() {
		$driver = 'ProbePdoResult';
		if (!class_exists($driver)) {
			require_once(APPPATH.'libraries/ProbePdoResult.php');
		}
		return $driver;
	}
}
