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
	protected $Host = NULL;
	protected $Port = NULL;
	protected $UserName = NULL;
	protected $UserPassword = NULL;
	protected $WorkUserName = NULL;
	protected $WorkUserPassword = NULL;
	protected $Engine = NULL; // MySQL, SQLite, PostgreSQL
	protected $DbName = NULL;
	protected $pdoConnection = NULL;
	protected $dsn = array(); // Database Source Name

	//$dsn = "<driver>://<username>:<password>@<host>:<port>/<database>";
	function __construct($engine='mysql', $userPassword='', $userName='root', $host='localhost', $port=3306, $dbName = 'probe' ) {
		parent::__construct();
		log_message('init',  __FUNCTION__.'('.__CLASS__.")\n".__FILE__.' ['.__LINE__.']');
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
				$this->Engine
				.':host='.$this->Host
				.';port='.$this->Port, 
				$this->UserName, 
				$this->UserPassword
			);

		} catch (PDOException $e) {
		log_message('PDOException',  __FUNCTION__.'('.__CLASS__.")\n".__FILE__.' ['.__LINE__.']');
			throw new Exception( $e->getMessage() );
		}
	}


/* DB Host's setter/getter */
	protected function setHost($value) {
		$this->Host = $value;
	}
/* DB Port's setter/getter */
	protected function setPort($value) {
		$this->Port = $value;
	}
/* DB UserName's setter/getter */
	protected function setUserName($value) {
		$this->UserName = $value;
	}
/* DB UserPassword's setter/getter */
	protected function setUserPassword($value) {
		$this->UserPassword = $value;
	}
/* DB UserName's setter/getter */
	protected function setWorkUserName($value) {
		$this->WorkUserName = $value;
	}
/* DB UserPassword's setter/getter */
	protected function setWorkUserPassword($value) {
		$this->WorkUserPassword = $value;
	}
/* DB Engine's setter/getter */
	protected function setEngine($value) {
		$this->Engine = $value;
	}
/* DB Name's setter/getter */
	protected function setDbName($value) {
		$this->DbName = $value;
	}
/* DB Data Source Name's setter/getter */
	protected function setDsn($value) {
	/* @TODO: parse a DSN string to set the properties of the object
		"<driver>://<username>:<password>@<host>:<port>/<database>";
		// "<(.+)>://<(.+)>:<(.+)>@<(.+)>:<([0-9]+)>/<(.+)>";
	*/
		$this->dsn = $value;
	}
	public function getDsn() {
		return array (
			'dbdriver'=> 'pdo',
			'username'=> $this->WorkUserName,
			'password'=> $this->WorkUserPassword,
			'hostname'=> $this->Engine.':host='.$this->Host.';port='.$this->Port,
			'database'=> $this->DbName
		);
	}


	/**
	 * Test if given database exists or not
	 * @param $dbName
	 * @return boolean
	 */
	function dbExists($dbName) {
// 		$this->pdoConnection->query("SELECT IF(EXISTS (SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbName'), TRUE, FALSE)");
		$result = $this->pdoConnection->query("SELECT COUNT(*) AS NBR FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbName'")->fetch();

		if ($result['NBR']!='0') {
			log_message('db', $dbName." existe deja, les tables seront créée dedans!\n");
			return true;}
		log_message('db',$dbName." N'existe PAS, elle va etre crée !\n");
		return false;
	}


	/**
	* Add admin user to the given database
	* @param $dbName, the name of the database to administrate
	* @param $userName
	* @param $userPassword
	*/
	function addDbUser() {
		// supprime les utilisateur vide qui provoque des probleme de connection
		// $this->pdoConnection->query("DELETE FROM user WHERE user = '';");
		$this->setWorkUserName('probe_user');
		$this->setWorkUserPassword(randomPassword(10));
		// Creation of user
		$this->pdoConnection->query("CREATE USER IF NOT EXISTS '".$this->WorkUserName."'@'%' IDENTIFIED BY PASSWORD('".$this->WorkUserPassword."');");
		// Adding all privileges on our newly created database
		$this->pdoConnection->query("GRANT ALL PRIVILEGES on `".$this->DbName."`.* TO '".$this->WorkUserName."'@'%';");
		// define the password
		$this->pdoConnection->query("SET PASSWORD FOR  '".$this->WorkUserName."'@'%' = PASSWORD('".$this->WorkUserPassword."');");
		// recharge les privileges
		$this->pdoConnection->query("FLUSH PRIVILEGES;");
	}


	/**
	 * @description: Create application's database. It will contains :
	 * 	- app configuration (users, roles, etc.)
	 *	- stations configurations (host, port, etc.)
	 */
	function createAppDb() {
		// the database MUST be name 'probe' !
		try {
			$this->dbExists('noBase');
			// dans le cas ou la base est fournie avec l'user adequat pas besoin de le refaire
			if ( ! $this->dbExists(APP_DB) ) {
				// create the 'probe' database
				$sqlCreateDb = sprintf("CREATE DATABASE IF NOT EXISTS `%s`;", APP_DB);
				$this->pdoConnection->query($sqlCreateDb);

				$this->setDbName(APP_DB);
				// create an admin user for this base
				$this->addDbUser();
			}
			$this->createAppTables();
		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}
	}


	/**
	* @description: Create application's tables for administrative use:
	* 	- TA_USER: users list
	*	- TR_ROLE: available roles user can be granted
	*	- TR_CONFIG: station's configurations
	*	- TA_LOG: access log
	*/
	protected function createAppTables() {
		$sqlCreateSchema = sprintf(
			"SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
			SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
			SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
			CREATE SCHEMA IF NOT EXISTS `%s` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
			USE `%s`;", 
			APP_DB,
			APP_DB
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
				NULL , 'app-admin', %s
				);
			",
			APP_DB,
			i18n('table.role.label')
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
			COMMENT = 'Stock each station's properties/value and access datetime';",
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
		$this->pdoConnection->query($sqlCreateUsersTable);
		$this->pdoConnection->query($sqlCreateRolesTable);
		$this->pdoConnection->query($sqlAddRoleAdmin);
		$this->pdoConnection->query($sqlCreateConfigsTable);
		$this->pdoConnection->query($sqlCreateLogsTable);
	}


	/**
	 * @description: Create database for given
	 * @param $dbName
	 * @return array ()
	 */
	function createStationDb($dbName) {
		if (empty($dbName)) return false;
		$this->setDbName($dbName);
		try {
			// dans le cas ou la base est fournie avec l'user adequat pas besoin de le refaire
			if (!$this->dbExists($dbName)) {				
				//Creation of database "probe"
				$sqlCreate = sprintf("CREATE DATABASE IF NOT EXISTS `%s`;", $this->DbName);
				$this->pdoConnection->query();

				//Creation of user
				$this->addDbUser();
			}
			$this->createStationTables();
		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}
		return false;
	}
	
	protected function createStationTables() {
		$sqlCreateSchema = sprintf(
			"SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
			SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
			SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
			CREATE SCHEMA IF NOT EXISTS `%s` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
			USE `%s`;", 
			$this->DbName,
			$this->DbName
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
			$this->DbName
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
			$this->DbName
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
			$this->DbName,
			$this->DbName,
			$this->DbName
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
			$this->DbName,
			$this->DbName,
			$this->DbName
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
			$this->DbName,
			$this->DbName,
			$this->DbName
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
			$this->DbName,
			$this->DbName,
			$this->DbName
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