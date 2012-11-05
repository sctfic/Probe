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
			// 'dbdriver'=> 'pdo', // why the heck is it 'pdo' here ?
			'dbdriver'=> $this->engine,
			'engine'=> $this->engine,
			'username'=> $this->workUserName,
			'password'=> $this->workUserPassword,
			// 'hostname'=> $this->engine.':host='.$this->host.';port='.$this->port,
			'hostname' => $this->host,
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
			`ROL_ID` INT(11) NOT NULL AUTO_INCREMENT ,
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
			`USR_ID` INT(11) NOT NULL AUTO_INCREMENT ,
			`USR_USERNAME` VARCHAR(32) NOT NULL ,
			`USR_PWD` VARCHAR(64) NOT NULL ,
			`USR_FIRST_NAME` VARCHAR(45) NULL DEFAULT NULL ,
			`USR_EMAIL` VARCHAR(45) NULL DEFAULT NULL ,
			`ROL_ID` INT(11) NOT NULL ,
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
			UNIQUE INDEX `CFG_KEY` (`CFG_STATION_ID` ASC, `CFG_LABEL` ASC) ,
			PRIMARY KEY (`CFG_STATION_ID`, `CFG_LABEL`) )
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Stock each station\'s properties/value and access datetime';",
			APP_DB
		);
		$sqlCreateLogsTable = sprintf(
			"CREATE  TABLE IF NOT EXISTS `%s`.`TA_LOG` (
			`LOG_ID` INT(11) NOT NULL ,
			`LOG_STATION_ID` TINYINT(4) NULL DEFAULT NULL ,
			`LOG_CODE` TINYINT(4) NULL DEFAULT NULL ,
			`LOG_LABEL` TINYTEXT NULL DEFAULT NULL ,
			`LOG_Value` MEDIUMTEXT NULL DEFAULT NULL ,
			`LOG_Date` DATETIME NULL DEFAULT NULL ,
			PRIMARY KEY (`LOG_ID`) )
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Access log to each station';
			SET SQL_MODE=@OLD_SQL_MODE;
			SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
			SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;",
			APP_DB
		);

		$this->pdoConnection->query($sqlCreateSchema);
		$this->pdoConnection->query($sqlCreateRolesTable);
		$this->pdoConnection->query($sqlAddRoleAdmin);
		$this->pdoConnection->query($sqlCreateUsersTable);
		$this->pdoConnection->query($sqlCreateConfigsTable);
		$this->pdoConnection->query($sqlCreateLogsTable);
	}



	
	protected function createStationTables() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		$sqlCreateSchema = sprintf(
			"SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
			SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
			SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
			CREATE SCHEMA IF NOT EXISTS `%s` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
			USE `%s`;", 
			$this->dbName,
			$this->dbName
		);
		$sqlCreateSensorsTable = sprintf(
			"CREATE  TABLE IF NOT EXISTS `%s`.`TR_SENSOR` (
			`SEN_ID` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Technical sensor s key' ,
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
			UNIQUE INDEX `SEN_NAME_UNIQUE` (`SEN_NAME` ASC) ,
			PRIMARY KEY (`SEN_ID`) )
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Table descriptive des capteurs present sur la station';",
			$this->dbName
		);
		$sqlCreateVariousTable = sprintf(
			"CREATE  TABLE IF NOT EXISTS `%s`.`TA_VARIOUS` (
			`VAR_ID` INT(11) NOT NULL AUTO_INCREMENT ,
			`VAR_DATE` DATETIME NULL DEFAULT NULL ,
			`VAR_PRESSURE_ALT0` FLOAT(11) NULL DEFAULT NULL COMMENT 'Pression admospherique' ,
			`VAR_SAMPLE_RAINFALL` FLOAT(11) NULL DEFAULT NULL COMMENT 'pluviometrie totale sur cet episode pluvieux' ,
			`VAR_SAMPLE_RAINFALL_HIGHT` FLOAT(11) NULL DEFAULT NULL COMMENT 'debit max pluviometrie sur cet episode pluvieux' ,
			`VAR_SOLAR_RADIATION` INT(11) NULL DEFAULT NULL COMMENT 'puissance du rayonnement soalaire (en W/m²)' ,
			`VAR_SOLAR_RADIATION_HIGHT` INT(11) NULL DEFAULT NULL COMMENT 'max : puissance du rayonnement soalaire (en W/m²)' ,
			`VAR_WIND_SPEED` FLOAT(11) NULL DEFAULT NULL COMMENT 'vitesse du vent' ,
			`VAR_WIND_SPEED_HIGHT` FLOAT(11) NULL DEFAULT NULL COMMENT 'max vitesse de vent' ,
			`VAR_WIND_SPEED_HIGHT_DIR` TINYINT(4) NULL DEFAULT NULL COMMENT 'direction du vent de la plus haute rafale de vent sur cette periode' ,
			`VAR_WIND_SPEED_DOMINANT_DIR` TINYINT(4) NULL DEFAULT NULL COMMENT 'direction des vent dominant sur cette periode' ,
			`VAR_UV_INDEX` FLOAT(11) NULL DEFAULT NULL COMMENT 'niveau d UV (W/m²)' ,
			`VAR_UV_INDEX_HIGHT` FLOAT(11) NULL DEFAULT NULL COMMENT 'max : niveau d UV (W/m²)' ,
			`VAR_FORECAST_RULE` TINYINT(4) NULL DEFAULT NULL COMMENT 'prevision grossiere (voir P.22 de la doc)' ,
			`VAR_ET` FLOAT(11) NULL DEFAULT NULL COMMENT 'pluviometrie sur cette periode' ,
			PRIMARY KEY (`VAR_ID`) ,
			INDEX `IDX_DATE` (`VAR_DATE` ASC) ,
			UNIQUE INDEX `UNQ_DATE` (`VAR_DATE` ASC) )
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Table des capteurs unique (d autre du meme type ne peuvent e' /* comment truncated */;",
			$this->dbName
		);

		$sqlCreateTemperatureTable = sprintf(
			"CREATE  TABLE IF NOT EXISTS `%s`.`TA_TEMPERATURE` (
			`ID` INT(11) NOT NULL ,
			`SEN_ID` INT(11) NOT NULL ,
			`VALUE` FLOAT(11) NOT NULL ,
			PRIMARY KEY (`ID`, `SEN_ID`) ,
			INDEX `DATE_idx` (`ID` ASC) ,
			CONSTRAINT `SENSOR`
			FOREIGN KEY (`SEN_ID` )
			REFERENCES `%s`.`TR_SENSOR` (`SEN_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION,
			CONSTRAINT `DATE`
			FOREIGN KEY (`ID` )
			REFERENCES `%s`.`TA_VARIOUS` (`VAR_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Regroupe les relevés de tous les capteurs de temperature (en' /* comment truncated */;",
			$this->dbName,
			$this->dbName,
			$this->dbName
		);
		$sqlCreateWetnessesTable = sprintf(
			"CREATE  TABLE IF NOT EXISTS `%s`.`TA_WETNESSES` (
			`ID` INT(11) NOT NULL ,
			`SEN_ID` INT(11) NOT NULL ,
			`VALUE` TINYINT(4) NULL DEFAULT NULL ,
			PRIMARY KEY (`ID`, `SEN_ID`) ,
			INDEX `DATE` (`ID` ASC) ,
			CONSTRAINT `SENSOR0`
			FOREIGN KEY (`SEN_ID` )
			REFERENCES `%s`.`TR_SENSOR` (`SEN_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION,
			CONSTRAINT `DATE0`
			FOREIGN KEY (`ID` )
			REFERENCES `%s`.`TA_VARIOUS` (`VAR_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Regroupe les relevés de tous les capteurs de humidité du feu' /* comment truncated */;",
			$this->dbName,
			$this->dbName,
			$this->dbName
		);
		$sqlCreateMoistureTable = sprintf(
			"CREATE  TABLE IF NOT EXISTS `%s`.`TA_MOISTURE` (
			`ID` INT(11) NOT NULL ,
			`SEN_ID` INT(11) NOT NULL ,
			`VALUE` TINYINT(4) NOT NULL ,
			PRIMARY KEY (`ID`, `SEN_ID`) ,
			INDEX `DATE` (`ID` ASC) ,
			CONSTRAINT `SENSOR00`
			FOREIGN KEY (`SEN_ID` )
			REFERENCES `%s`.`TR_SENSOR` (`SEN_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION,
			CONSTRAINT `DATE00`
			FOREIGN KEY (`ID` )
			REFERENCES `%s`.`TA_VARIOUS` (`VAR_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Regroupe les relevés de tous les capteurs de humidité du sol' /* comment truncated */;",
			$this->dbName,
			$this->dbName,
			$this->dbName
		);
		$sqlCreateHumidityTable = sprintf(
			"CREATE  TABLE IF NOT EXISTS `%s`.`TA_HUMIDITY` (
			`ID` INT(11) NOT NULL ,
			`SEN_ID` INT(11) NOT NULL ,
			`VALUE` TINYINT(4) NOT NULL ,
			PRIMARY KEY (`ID`, `SEN_ID`) ,
			INDEX `DATE` (`ID` ASC) ,
			CONSTRAINT `SENSOR1`
			FOREIGN KEY (`SEN_ID` )
			REFERENCES `%s`.`TR_SENSOR` (`SEN_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION,
			CONSTRAINT `DATE1`
			FOREIGN KEY (`ID` )
			REFERENCES `%s`.`TA_VARIOUS` (`VAR_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Regroupe les relevés de tous les capteurs d humidité';
			SET SQL_MODE=@OLD_SQL_MODE;
			SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
			SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;",
			$this->dbName,
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