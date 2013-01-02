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
		$result = $this->pdoConnection->query("SELECT COUNT(*) AS NBR FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbName'")->fetch();

		if ($result['NBR']!='0')
			return true;
		log_message('db',$dbName.' > N EXISTE PAS !!!');
		return false;
	}


	/**
	* Add admin user to the given database
	* @param $dbID, the ID of the database to administrate
	* @param $userName => WARNING the username lenght is limited to 16 chars !
	* @param $userPassword
	*/
	function addDbUser($dbID='') {
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
	function createAppDb($dbID=APP_DB) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		try {
			$this->setDbName(is_numeric($dbID) ? 'Probe_Weather'.$dbID : APP_DB);
			// dans le cas ou la base est fournie avec l'user adequat pas besoin de le refaire
			if (!$this->dbExists($this->dbName)) {
				//Creation of database
				$sqlCreate = sprintf("CREATE DATABASE IF NOT EXISTS `%s`;", $this->dbName);
				$this->pdoConnection->query($sqlCreate);
				if ( ! $this->dbExists($this->dbName) )
					throw new Exception( 'Impossible de créer la base ! '.$this->dbName );
				else log_message('db', $this->dbName.' est maintenant disponible !');

				//Creation of user
				$this->addDbUser(is_numeric($dbID) ? $dbID : 'Admin');
			}
			if (is_numeric($dbID))
				$this->createStationTables();
			else
				$this->createAppTables();
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
	protected function createAppTables() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$sqlCreateSchema = sprintf(
			"SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
			SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
			SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
			CREATE SCHEMA IF NOT EXISTS `%s` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
			USE `%s`;", 
			APP_DB,
			APP_DB
		);
		$sqlCreateRolesTable = sprintf(
      "CREATE  TABLE IF NOT EXISTS `%s`.`TR_ROLE` (
        `ROL_ID` TINYINT(4) NOT NULL AUTO_INCREMENT ,
        `ROL_CODE` VARCHAR(32) NOT NULL ,
        `ROL_LABEL` VARCHAR(64) NOT NULL ,
        PRIMARY KEY (`ROL_ID`) )
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'Available roles for the users';",
      APP_DB
    );
		$sqlAddRoleAdmin = sprintf(
			"INSERT INTO `%s`.`TR_ROLE` (
				`ROL_ID` ,
				`ROL_CODE` ,
				`ROL_LABEL`
				)
				VALUES (
				NULL , 'app-admin', '%s'
				);
			",
			APP_DB,
			i18n('database.table.role:admin.label')
		);
		$sqlCreateUsersTable = sprintf(
		"CREATE  TABLE IF NOT EXISTS `%s`.`TA_USER` (
        `USR_ID` TINYINT(4) NOT NULL AUTO_INCREMENT ,
        `USR_USERNAME` VARCHAR(32) NOT NULL ,
        `USR_PWD` VARCHAR(64) NOT NULL ,
        `USR_FIRST_NAME` VARCHAR(45) NULL DEFAULT NULL ,
        `USR_EMAIL` VARCHAR(45) NULL DEFAULT NULL ,
        `ROL_ID` TINYINT(4) NOT NULL ,
        `USR_FAMILY_NAME` VARCHAR(45) NULL DEFAULT NULL ,
        PRIMARY KEY (`USR_ID`) ,
        INDEX `IDX_FK_USR_ROL` (`ROL_ID` ASC) ,
        CONSTRAINT `FK_USR_ROL`
        FOREIGN KEY (`ROL_ID` )
        REFERENCES `%s`.`TR_ROLE` (`ROL_ID` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'User list for this application';",
      APP_DB,
      APP_DB
    );
		$sqlCreateConfigsTable = sprintf(
		"CREATE  TABLE IF NOT EXISTS `%s`.`TR_CONFIG` (
        `CFG_STATION_ID` TINYINT(4) NOT NULL ,
        `CFG_LABEL` VARCHAR(32) NOT NULL ,
        `CFG_VALUE` TINYTEXT NOT NULL ,
        `CFG_LAST_WRITE` DATETIME NULL DEFAULT NULL ,
        `CFG_HTML` VARCHAR(45) NULL DEFAULT NULL ,
        `CFG_JS` VARCHAR(45) NULL DEFAULT NULL ,
        `CFG_PHP` VARCHAR(45) NULL DEFAULT NULL ,
        PRIMARY KEY (`CFG_STATION_ID`, `CFG_LABEL`) ,
        UNIQUE INDEX `CFG_KEY` (`CFG_STATION_ID` ASC, `CFG_LABEL` ASC) )
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'Stock each station\'s properties/value and access datetime';",
      APP_DB
    );

		$this->pdoConnection->query($sqlCreateSchema);
		$this->pdoConnection->query($sqlCreateRolesTable);
		$this->pdoConnection->query($sqlAddRoleAdmin);
		$this->pdoConnection->query($sqlCreateUsersTable);
		$this->pdoConnection->query($sqlCreateConfigsTable);
	}



	
	protected function createStationTables() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$sqlCreateSchema = sprintf(
			// "SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
			// SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
			// SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
			"CREATE SCHEMA IF NOT EXISTS `%s` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
			USE `%s`;", 
			$this->dbName,
			$this->dbName
		);
		$sqlCreateSensorsTable = sprintf(
      "CREATE  TABLE IF NOT EXISTS `%s`.`TR_SENSOR` (
        `SEN_ID` SMALLINT(6) NOT NULL AUTO_INCREMENT COMMENT 'Technical sensor s key' ,
        `SEN_NAME` VARCHAR(64) NOT NULL COMMENT 'Name of the sensor' ,
        `SEN_HUMAN_NAME` VARCHAR(64) NULL DEFAULT NULL ,
        `SEN_DESCRIPTIF` MEDIUMTEXT NULL DEFAULT NULL ,
        `SEN_MIN_REALISTIC` FLOAT(11) NULL DEFAULT NULL COMMENT 'Minimum value realiste in real context' ,
        `SEN_MAX_REALISTIC` FLOAT(11) NULL DEFAULT NULL COMMENT 'Maximum value realiste in real context' ,
        `SEN_UNITE_SIGN` VARCHAR(16) NULL DEFAULT NULL ,
        `SEN_DEF_PLOT` VARCHAR(64) NULL DEFAULT NULL ,
        `SEN_MAX_ALARM` FLOAT(11) NULL DEFAULT NULL ,
        `SEN_MIN_ALARM` FLOAT(11) NULL DEFAULT NULL ,
        `SEN_LAST_CALIBRATE` DATE NULL DEFAULT NULL ,
        `SEN_CALIBRATE_PERIOD` VARCHAR(32) NULL DEFAULT NULL ,
        PRIMARY KEY (`SEN_ID`) ,
        UNIQUE INDEX `SEN_NAME_UNIQUE` (`SEN_NAME` ASC) ,
        UNIQUE INDEX `SEN_ID_UNIQUE` (`SEN_ID` ASC) )
        ENGINE = InnoDB
        AUTO_INCREMENT = 20
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'Table descriptive des capteurs present sur la station';",
        $this->dbName
    );
		$sqlCreateVariousTable = sprintf(
      "CREATE  TABLE IF NOT EXISTS `%s`.`TA_VARIOUS` (
        `UTC` TIMESTAMP NOT NULL ,
        `SEN_ID` SMALLINT(6) NOT NULL ,
        `VALUE` FLOAT(11) NULL DEFAULT NULL ,
        PRIMARY KEY (`UTC`, `SEN_ID`) ,
        INDEX `VARIOUS` (`SEN_ID` ASC) ,
        CONSTRAINT `SENSOR000`
        FOREIGN KEY (`SEN_ID` )
        REFERENCES `%s`.`TR_SENSOR` (`SEN_ID` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'Regroupe les releves de tous les autres type de capteurs';",
        $this->dbName,
        $this->dbName
    );

		$sqlCreateTemperatureTable = sprintf(
      "CREATE  TABLE IF NOT EXISTS `%s`.`TA_TEMPERATURE` (
        `UTC` TIMESTAMP NOT NULL ,
        `SEN_ID` SMALLINT(6) NOT NULL ,
        `VALUE` FLOAT(11) NULL DEFAULT NULL ,
        INDEX `TEMP` (`SEN_ID` ASC) ,
        PRIMARY KEY (`UTC`, `SEN_ID`) ,
        CONSTRAINT `SENSOR`
        FOREIGN KEY (`SEN_ID` )
        REFERENCES `%s`.`TR_SENSOR` (`SEN_ID` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'Regroupe les relevÃ©s de tous les capteurs de temperature (e' /* comment truncated */;",
        $this->dbName,
        $this->dbName
    );
		$sqlCreateWetnessesTable = sprintf(
      "CREATE  TABLE IF NOT EXISTS `%s`.`TA_WETNESSES` (
        `UTC` TIMESTAMP NOT NULL ,
        `SEN_ID` SMALLINT(6) NOT NULL ,
        `VALUE` TINYINT(4) NULL DEFAULT NULL ,
        INDEX `WETNESSES` (`SEN_ID` ASC) ,
        PRIMARY KEY (`UTC`, `SEN_ID`) ,
        CONSTRAINT `SENSOR0`
        FOREIGN KEY (`SEN_ID` )
        REFERENCES `%s`.`TR_SENSOR` (`SEN_ID` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'Regroupe les relevÃ©s de tous les capteurs de humiditÃ© du f' /* comment truncated */;",
        $this->dbName,
        $this->dbName
    );
		$sqlCreateMoistureTable = sprintf(
      "CREATE  TABLE IF NOT EXISTS `%s`.`TA_MOISTURE` (
        `UTC` TIMESTAMP NOT NULL ,
        `SEN_ID` SMALLINT(6) NOT NULL ,
        `VALUE` TINYINT(4) NULL DEFAULT NULL ,
        INDEX `MOISTURE` (`SEN_ID` ASC) ,
        PRIMARY KEY (`SEN_ID`, `UTC`) ,
        CONSTRAINT `SENSOR00`
        FOREIGN KEY (`SEN_ID` )
        REFERENCES `%s`.`TR_SENSOR` (`SEN_ID` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'Regroupe les relevÃ©s de tous les capteurs de humiditÃ© du s' /* comment truncated */;",
        $this->dbName,
        $this->dbName
    );
		$sqlCreateHumidityTable = sprintf(
      "CREATE  TABLE IF NOT EXISTS `%s`.`TA_HUMIDITY` (
        `UTC` TIMESTAMP NOT NULL ,
        `SEN_ID` SMALLINT(6) NOT NULL ,
        `VALUE` TINYINT(4) NULL DEFAULT NULL ,
        INDEX `HUM` (`SEN_ID` ASC) ,
        PRIMARY KEY (`SEN_ID`, `UTC`) ,
        CONSTRAINT `SENSOR1`
        FOREIGN KEY (`SEN_ID` )
        REFERENCES `%s`.`TR_SENSOR` (`SEN_ID` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'Regroupe les relevÃ©s de tous les capteurs d humiditÃ©';",
        $this->dbName,
        $this->dbName
    );

		$this->pdoConnection->query($sqlCreateSchema);
		$this->pdoConnection->query($sqlCreateSensorsTable);
		$this->pdoConnection->query($sqlCreateVariousTable);
		$this->pdoConnection->query($sqlCreateTemperatureTable);
		$this->pdoConnection->query($sqlCreateWetnessesTable);
		$this->pdoConnection->query($sqlCreateMoistureTable);
		$this->pdoConnection->query($sqlCreateHumidityTable);
	}

}