<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('APP_DB', 'probe');

/*
try {
	include_once(BASEPATH.'core/Model.php'); // need for load models manualy
	include_once(APPPATH.'models/db_builder.php');
	$this->dbb = new db_builder('mysql', 'password', 'root', '127.0.0.1', 3306);
	$this->dbb->createAppDb();
	$dns = $this->dbb->getDsn();
	$this->dbb->createStationDb('toto');
	OR
	$this->dbb = new db_builder('mysql', 'password', 'root', '127.0.0.1', 3306);
	$this->dbb->createAppDb();
	$dns = $this->dbb->getDsn();
	$this->dbb->createStationDb('toto');
}
catch (Exception $e) {
	log_message('ERROR',  $e->getMessage());
}
*/
class db_builder extends CI_Model {
	protected $host = NULL;
	protected $port = NULL;
	protected $userName = NULL;
	protected $userPassword = NULL;
	protected $workUserName = NULL;
	protected $workUserPassword = NULL;
	protected $engine = NULL; // MySQL, SQLite, PostgreSQL
	protected $dbName = NULL;
	protected $pdoConnection = NULL;
	protected $dsn = array(); // Database Source Name

	//$dsn = "<driver>://<username>:<password>@<host>:<port>/<database>";
	function __construct($engine='mysql', $userPassword='', $userName='root', $host='localhost', $port=3306, $dbName = 'probe' ) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		parent::__construct();

		$this->setEngine($engine);
		$this->setUserName($userName);
		$this->setUserPassword($userPassword);
		$this->setWorkUserName($userName);
		$this->setWorkUserPassword($userPassword);
		$this->setHost($host);
		$this->setPort($port);
		$this->setDbName($dbName);

		try {
			$this->pdoConnection = new PDO(
				$this->engine
				.':host='.$this->host
				.';port='.$this->port, 
				$this->userName, 
				$this->userPassword
			);

		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}
	}


/* DB Host's setter/getter */
	protected function setHost($value) {
		$this->host = $value;
	}
/* DB Port's setter/getter */
	protected function setPort($value) {
		$this->port = $value;
	}
/* DB UserName's setter/getter */
	protected function setUserName($value) {
		$this->userName = $value;
	}
/* DB UserPassword's setter/getter */
	protected function setUserPassword($value) {
		$this->userPassword = $value;
	}
/* DB UserName's setter/getter */
	protected function setWorkUserName($value) {
		$this->workUserName = $value;
	}
/* DB UserPassword's setter/getter */
	protected function setWorkUserPassword($value) {
		$this->workUserPassword = $value;
	}
/* DB Engine's setter/getter */
	protected function setEngine($value) {
		$this->engine = $value;
	}
/* DB Name's setter/getter */
	protected function setDbName($value) {
		$this->dbName = $value;
	}
/* DB Data Source Name's setter/getter */
	protected function setDsn($value) {
	where_I_Am(__FILE__,__CLASS__,__FUCNTION__,__LINE__,func_get_args());
		/* @TODO: parse a DSN string to set the properties of the object
		"<driver>://<username>:<password>@<host>:<port>/<database>";
		// "<(.+)>://<(.+)>:<(.+)>@<(.+)>:<([0-9]+)>/<(.+)>";
	*/
		$this->dsn = $value;
	}
	public function getDsn() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		return array (
			'dbdriver'=> 'pdo', // we work exclusively with PDO
			// 'engine'=> $this->engine, // do not existe
			'username'=> $this->workUserName,
			'password'=> $this->workUserPassword,
			'hostname'=> $this->engine.':host='.$this->host, // need DSN format
			// 'hostname' => $this->host,
			'port' => $this->port,
			'database'=> $this->dbName
		);
	}


	/**
	 * Test if given database exists or not
	 * @param $dbName
	 * @return boolean
	 */
	function dbExists($dbName) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		switch ($this->engine) {
			case 'mysql':
				$result = $this->pdoConnection->query("SELECT COUNT(*) AS NBR FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbName'")->fetch();
				if ($result['NBR']!='0')
					return true;
				log_message('db',$dbName.' > N EXISTE PAS !!!');
				break;
			
			case 'sqlite':
				return is_file($dbName) ;
				break;
			// default:
			// 	return false;
		}
		return false;
	}


	/**
	* Add admin user to the given database
	* @param $dbID, the ID of the database to administrate
	* @param $userName => WARNING the username lenght is limited to 16 chars !
	* @param $userPassword
	*/
	function addDbUser($dbID) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		// supprime les utilisateur vide qui provoque des probleme de connection
		// $this->pdoConnection->query("DELETE FROM user WHERE user = '';");
		$this->setWorkUserName('ProbeUsr'.$dbID);
		$this->setWorkUserPassword(randomPassword(10));
		// Creation of user
		$this->pdoConnection->query("CREATE USER '".$this->workUserName."'@'%' IDENTIFIED BY '".$this->workUserPassword."';");

		// Adding all privileges on our newly created database
		$this->pdoConnection->query("GRANT ALL PRIVILEGES on `".$this->dbName."`.* TO '".$this->workUserName."'@'%';");

		// recharge les privileges
		$this->pdoConnection->query("FLUSH PRIVILEGES;");
	}


	/**
	 * @description: Create database for given
	 * @param $dbID
	 * @return array ()
	 */
	function createAppDb($dbID) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		try {
			//$this->setDbName(is_string($dbID) ? $dbID : APP_DB);
			// dans le cas ou la base est fournie avec l'user adequat pas besoin de le refaire
			if (!$this->dbExists($this->dbName)) {
				//Creation of database
				$sqlCreate = sprintf("CREATE DATABASE IF NOT EXISTS `%s`;", $this->dbName);
				$this->pdoConnection->query($sqlCreate);
				if ( ! $this->dbExists($this->dbName) )
					throw new Exception( 'Impossible de créer la base ! '.$this->dbName );
				else log_message('db', $this->dbName.' est maintenant disponible (vide) !');

				//Creation of user
				$this->addDbUser(is_numeric($dbID) ? $dbID : 'Admin');
			}
			if (is_numeric($dbID))
				$this->createStationTables();
			else
				$this->createSystemTables();
			return true;
		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}
		return false;
	}

/*
	description: Create application's tables for administrative use:
	- TA_USER: users list
	- TR_ROLE: available roles user can be granted
	- TR_CONFIG: station's configurations
	- TA_LOG: access log
*/
	protected function createSystemTables() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$sqlCreateTable = sprintf(
			file_get_contents(APPPATH.'models/sql/system.sql'),
			APP_DB,
			i18n('database.table.role:admin.label')
		);
		$this->pdoConnection->query($sqlCreateTable);
	}

	
	protected function createStationTables() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$sqlCreateTable = sprintf(
			file_get_contents(APPPATH.'models/sql/station.sql'),
			$this->dbName
		);
		$this->pdoConnection->query($sqlCreateTable);
	}

}