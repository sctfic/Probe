<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
try {
	include_once(BASEPATH.'core/Model.php'); // need for load models manualy
	include_once(APPPATH.'models/db_builder.php');
	$this->dbb = new db_builder('password', 'root', 'mysql', '127.0.0.1', 3306);
	$this->dbb->make_db_config();
	$this->dbb->make_db_data('toto');
	OR
	$this->dbb = new db_builder('password', 'user', 'mysql', '127.0.0.1', 3306);
	$this->dbb->make_db_config();
	$this->dbb->make_db_data('toto');
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
	protected $dbEngine = NULL; // MySQL, SQLite, PostgreSQL
	protected $pdoConnection = NULL;
	protected $dns = array(); // Database Name Source


	function __construct($userPassword='', $userName='root', $dbEngine='mysql', $host='localhost', $port=3306) {
		parent::__construct();
		log_message('init',  __FUNCTION__.'('.__CLASS__.")\n".__FILE__.' ['.__LINE__.']');
		$this->setHost($host);
		$this->setPort($port)
		$this->setUserName($userName);
		$this->setUserPassword($userPassword);
		$this->setDbEngine($dbEngine);
		$this->cryptor = $this->load->library('encrypt');
		try {
			$this->pdoConnection = new PDO(
				$this->getDbEngine()
				.':host='.$this->getHost()
				.';port='.$this->getPort(), 
				$this->getUserName(), 
				$this->getUserPassword()
			);

		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}
	}


/* DB Host's setter/getter */
	protected function setHost($value) {
		$this->host = $value;
	}
	protected function getHost($value) {
		return $this->host;
	}

/* DB Port's setter/getter */
	protected function setPort($value) {
		$this->port = $value;
	}
	protected function getPort($value) {
		return $this->port;
	}

/* DB UserName's setter/getter */
	protected function setUserName($value) {
		$this->userName = $value;
	}
	protected function getUserName($value) {
		return $this->userName;
	}

/* DB UserPassword's setter/getter */
	protected function setUserPassword($value) {
		$this->userPassword = $value;
	}
	protected function getUserPassword($value) {
		return $this->userPassword;
	}

/* DB Engine's setter/getter */
	protected function setDbEngine($value) {
		$this->dbEngine = $value;
	}
	protected function getDbEngine($value) {
		return $this->dbEngine;
	}

/* DB Data Source Name's setter/getter */
	protected function setDns($value) {
		$this->dns = $value;
	}
	protected function getDns($value) {
		return $this->dns;	
	}



	/**
	 * Test if database exists or not
	 * @param $dbName
	 * @return boolean
	 */
	function dbExists($dbName) {
// 		$this->pdoConnection->query("SELECT IF(EXISTS (SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbName'), TRUE, FALSE)");
		$result = $this->pdoConnection->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbName'");
		if ($result->fetchColumn() > 0) return true;
		return false;
	}

	/*
	* Add admin user to the database
	* @param $dbName, the name of the database to administrate
	* @param $userName
	* @param $userPassword
	*/
	function addAdminUser($dbName, $userName, $userPassword) {
		// supprime les utilisateur vide qui provoque des probleme de connection
		$this->pdoConnection->query("DELETE FROM user WHERE user = '';");
		// Creation of user
		$this->pdoConnection->query("CREATE USER IF NOT EXISTS '".$userName."'@'%' IDENTIFIED BY '".$userPassword."';");
		// Adding all privileges on our newly created database
		$this->pdoConnection->query("GRANT ALL PRIVILEGES on `".$dbName."`.* TO '".$userName."'@'%' IDENTIFIED BY  '".$userPassword."' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;");
		// recharge les privileges
		$this->pdoConnection->query("FLUSH PRIVILEGES;");
	}


	/**
	 * create all db items (base and table) for config
	 * @param $dbName, working database
	 * @return array(), should be non-empty
	 */
	function make_db_config($dbName = 'probe') {
		// the database MUST be name 'probe' !
		try {
			/*  */
			// dans le cas ou la base est fournie avec l'user adequat pas besoin de le refaire
			if (!$this->dbExists($dbName)) {
				$userName = 'probe'; 
				$userPassword = randomPassword();
				
				//Creation of database "probe"
				$this->pdoConnection->query("CREATE DATABASE IF NOT EXISTS `$dbName`;");
				//Creation of user
				$this->addAdminUser($dbName, $userName, $userPassword);
			}
			else {
				$userName = $this->userName;
				$userPassword = $this->userPassword;
			}
			$this->make_table_config();

			return array (
				'dbdriver'=> 'pdo',
				'username'=> $userName,
				'password'=> $userPassword,
				'hostname'=> $dbEngine.':host='.$host.';port='.$port,
				'database'=> $dbName
			);

		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}
		return array();
	}


/*
* Create various tables for administrative use:
* * TA_USER: users list
* * TR_ROLE: available roles user can be granted
* * TR_CONFIG: station's configurations
* * TA_LOG: access log
*/
	protected function make_table_config($dbName = 'probe') {
		$this->pdoConnection->query("SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
			SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
			SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
			CREATE SCHEMA IF NOT EXISTS `probe` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
			USE `probe`;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$dbName`.`TA_USER` (
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
			REFERENCES `$dbName`.`TR_ROLE` (`ROL_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$dbName`.`TR_ROLE` (
			`ROL_ID` INT(11) NOT NULL AUTO_INCREMENT ,
			`ROL_CODE` VARCHAR(32) NOT NULL ,
			`ROL_LABEL` VARCHAR(64) NOT NULL ,
			PRIMARY KEY (`ROL_ID`) )
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$dbName`.`TR_CONFIG` (
			`CFG_STATION_ID` TINYINT(4) NOT NULL ,
			`CFG_LABEL` VARCHAR(32) NOT NULL ,
			`CFG_VALUE` TINYTEXT NOT NULL ,
			`CFG_LAST_WRITE` DATETIME NULL DEFAULT NULL ,
			UNIQUE INDEX `CFG_KEY` (`CFG_STATION_ID` ASC, `CFG_LABEL` ASC) ,
			PRIMARY KEY (`CFG_STATION_ID`, `CFG_LABEL`) )
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Ici on stoque chaque config, ca valeur et les date d accé';");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$dbName`.`TA_LOG` (
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
			COMMENT = 'Ici on log les different accée a chaque station ainsi qu une';
			SET SQL_MODE=@OLD_SQL_MODE;
			SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
			SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;");
	}
	/**
	 * 
	 * @param $dbName
	 * @return array ()
	 */
	function make_db_data($dbName) {
		if (empty($dbName)) return false;
		try {
			// dans le cas ou la base est fournie avec l'user adequat pas besoin de le refaire
			if (!$this->dbExists($dbName)) {
				$userName = 'probe'; 
				$userPassword = randomPassword();
				
				//Creation of database "probe"
				$this->pdoConnection->query("CREATE DATABASE IF NOT EXISTS `$dbName`;");
				//Creation of user
				$this->addAdminUser($dbName, $userName ,$userPassword);
			}
			else {
				$userName = $this->userName;
				$userPassword = $this->userPassword;
			}
			$this->make_table_data($dbName);
			
			$connectConf = array (
				'dbdriver'=> 'pdo',
				'username'=> $userName,
				'password'=> $this->encrypt->encode($userPassword),
				'hostname'=> $dbEngine.':host='.$host.';port='.$port,
				'database'=> $dbName);

			return $connectConf; // arrays2dbconfs($id, $conf)

		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}
		return false;
	}
	
	protected function make_table_data($dbName) {
		$this->pdoConnection->query("SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
			SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
			SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
			CREATE SCHEMA IF NOT EXISTS `$dbName` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
			USE `$dbName`;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$dbName`.`TR_SENSOR` (
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
			COMMENT = 'Table descriptive des capteurs present sur la station';");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$dbName`.`TA_VARIOUS` (
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
			COMMENT = 'Table des capteurs unique (d autre du meme type ne peuvent e' /* comment truncated */;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$dbName`.`TA_TEMPERATURE` (
			`ID` INT(11) NOT NULL ,
			`SEN_ID` INT(11) NOT NULL ,
			`VALUE` FLOAT(11) NOT NULL ,
			PRIMARY KEY (`ID`, `SEN_ID`) ,
			INDEX `DATE_idx` (`ID` ASC) ,
			CONSTRAINT `SENSOR`
			FOREIGN KEY (`SEN_ID` )
			REFERENCES `$dbName`.`TR_SENSOR` (`SEN_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION,
			CONSTRAINT `DATE`
			FOREIGN KEY (`ID` )
			REFERENCES `$dbName`.`TA_VARIOUS` (`VAR_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Regroupe les relevés de tous les capteurs de temperature (en' /* comment truncated */;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$dbName`.`TA_WETNESSES` (
			`ID` INT(11) NOT NULL ,
			`SEN_ID` INT(11) NOT NULL ,
			`VALUE` TINYINT(4) NULL DEFAULT NULL ,
			PRIMARY KEY (`ID`, `SEN_ID`) ,
			INDEX `DATE` (`ID` ASC) ,
			CONSTRAINT `SENSOR0`
			FOREIGN KEY (`SEN_ID` )
			REFERENCES `$dbName`.`TR_SENSOR` (`SEN_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION,
			CONSTRAINT `DATE0`
			FOREIGN KEY (`ID` )
			REFERENCES `$dbName`.`TA_VARIOUS` (`VAR_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Regroupe les relevés de tous les capteurs de humidité du feu' /* comment truncated */;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$dbName`.`TA_MOISTURE` (
			`ID` INT(11) NOT NULL ,
			`SEN_ID` INT(11) NOT NULL ,
			`VALUE` TINYINT(4) NOT NULL ,
			PRIMARY KEY (`ID`, `SEN_ID`) ,
			INDEX `DATE` (`ID` ASC) ,
			CONSTRAINT `SENSOR00`
			FOREIGN KEY (`SEN_ID` )
			REFERENCES `$dbName`.`TR_SENSOR` (`SEN_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION,
			CONSTRAINT `DATE00`
			FOREIGN KEY (`ID` )
			REFERENCES `$dbName`.`TA_VARIOUS` (`VAR_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Regroupe les relevés de tous les capteurs de humidité du sol' /* comment truncated */;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$dbName`.`TA_HUMIDITY` (
			`ID` INT(11) NOT NULL ,
			`SEN_ID` INT(11) NOT NULL ,
			`VALUE` TINYINT(4) NOT NULL ,
			PRIMARY KEY (`ID`, `SEN_ID`) ,
			INDEX `DATE` (`ID` ASC) ,
			CONSTRAINT `SENSOR1`
			FOREIGN KEY (`SEN_ID` )
			REFERENCES `$dbName`.`TR_SENSOR` (`SEN_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION,
			CONSTRAINT `DATE1`
			FOREIGN KEY (`ID` )
			REFERENCES `$dbName`.`TA_VARIOUS` (`VAR_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Regroupe les relevés de tous les capteurs d humidité';
			SET SQL_MODE=@OLD_SQL_MODE;
			SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
			SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;");
	}

}