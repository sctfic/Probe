<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
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
**/
class db_builder extends CI_Model {
	protected $host = NULL;
	protected $port = NULL;
	protected $user = NULL;
	protected $pass = NULL;
	protected $db_type = NULL;
	protected $pdoConnection = NULL;
// 	protected $ = NULL;
	function __construct($pass='', $user='root', $db_type='mysql', $host='localhost', $port=3306) {
		parent::__construct();
		log_message('init',  __FUNCTION__.'('.__CLASS__.")\n".__FILE__.' ['.__LINE__.']');
		$this->host = $host;
		$this->port = $port;
		$this->user = $user;
		$this->pass = $pass;
		$this->db_type = $db_type;
		try {
			$this->pdoConnection = new PDO($db_type.':host='.$host.';port='.$port, $user, $pass);
		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}
	}
	/**
	 * test is database exist or not
	 * @var $db_name
	 * @return true / false
	 */
	function is_db($db_name) {
// 		$this->pdoConnection->query("SELECT IF(EXISTS (SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'), TRUE, FALSE)");
		$result = $this->pdoConnection->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'");
		if ($result->fetchColumn() > 0) return true;
		return false;
	}
	function randomPassword($size=6) {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		for ($i = 0; $i < $size; $i++) {
			$n = rand(0, strlen($alphabet)-1);
			$pass[$i] = $alphabet[$n];
		}
		return implode($pass);
	}
	function make_user ($db, $usr, $pass)
	{
		// supprime les utilisateur vide qui provoque des probleme de connection
		$this->pdoConnection->query("DELETE FROM user WHERE user = '';");
		// Creation of user
		$this->pdoConnection->query("CREATE USER IF NOT EXISTS '".$usr."'@'%' IDENTIFIED BY '".$pass."';");
		// Adding all privileges on our newly created database
		$this->pdoConnection->query("GRANT ALL PRIVILEGES on `$db`.* TO '".$usr."'@'%' IDENTIFIED BY  '".$pass."' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;");
		// recharge les privileges
		$this->pdoConnection->query("FLUSH PRIVILEGES;");
	}
	/**
	 * create all db items (base and table) for config
	 * @var $db_name, $user, $pass
	 * @return array ()
	 */
	function make_db_config($db_name = 'probe') {
		// la base de config doit tjrs porter ce nom
		try {
			// dans le cas ou la base est fournie avec l'user adequat pas besoin de le refaire
			if (!$this->is_db($db_name)) {
				$user = 'probe'; 
				$pass = $this->randomPassword();
				
				//Creation of database "probe"
				$this->pdoConnection->query("CREATE DATABASE IF NOT EXISTS `$db_name`;");
				//Creation of user
				$this->make_user($db_name,$user,$pass);
			}
			else {
				$user = $this->user;
				$pass = $this->pass;
			}
			$this->make_table_config();
			$this->save_defaut_config($user, $pass, $db_name);
			return array(
				'dsn'=>'mysql:host='.$this->host.';port='.$this->port.';dbname='.$db_name,
				'login'=>$user,
				'pass'=>$pass);
		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}
		return false;
	}
	protected function save_defaut_config($user, $pass, $db_name) {
	if (is_writable(APPPATH.'config/db-default.php')) {
		file_put_contents(APPPATH.'config/db-default.php',
"<?php
\$db['default'] = Array(
	'hostname' => 'mysql:host=".$this->host.";port=".$this->port.";',
	'username' => '$user',
	'password' => '$pass',
	'dbdriver' => 'pdo',
	'database' => '$db_name',
	'dbprefix' => '',
	'pconnect' => true,
	'db_debug' => true,
	'cache_on' => false,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'autoinit' => true,
	'stricton' => false);");
	}
	else 
		throw new Exception( i18n('Impossible d\'ecrire le fichier de config') );
	}
	protected function make_table_config() {
		$this->pdoConnection->query("SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
			SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
			SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
			CREATE SCHEMA IF NOT EXISTS `probe` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
			USE `probe`;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `probe`.`TA_USER` (
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
			REFERENCES `probe`.`TR_ROLE` (`ROL_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `probe`.`TR_ROLE` (
			`ROL_ID` INT(11) NOT NULL AUTO_INCREMENT ,
			`ROL_CODE` VARCHAR(32) NOT NULL ,
			`ROL_LABEL` VARCHAR(64) NOT NULL ,
			PRIMARY KEY (`ROL_ID`) )
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `probe`.`TR_CONFIG` (
			`CFG_STATION_ID` TINYINT(4) NOT NULL ,
			`CFG_LABEL` VARCHAR(32) NOT NULL ,
			`CFG_VALUE` TINYTEXT NOT NULL ,
			`CFG_LAST_WRITE` DATETIME NULL DEFAULT NULL ,
			UNIQUE INDEX `CFG_KEY` (`CFG_STATION_ID` ASC, `CFG_LABEL` ASC) ,
			PRIMARY KEY (`CFG_STATION_ID`, `CFG_LABEL`) )
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Ici on stoque chaque config, ca valeur et les date d\'accé';");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `probe`.`TA_LOG` (
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
			COMMENT = 'Ici on log les different accée a chaque station ainsi qu\'une' /* comment truncated */;
			SET SQL_MODE=@OLD_SQL_MODE;
			SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
			SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;");
	}
	/**
	 * 
	 * @var $db_name, $user, $pass
	 * @return array ()
	 */
	function make_db_data($db_name) {
		if (empty($db_name)) return false;
		try {
			// dans le cas ou la base est fournie avec l'user adequat pas besoin de le refaire
			if (!$this->is_db($db_name)) {
				$user = 'probe'; 
				$pass = $this->randomPassword();
				
				//Creation of database "probe"
				$this->pdoConnection->query("CREATE DATABASE IF NOT EXISTS `$db_name`;");
				//Creation of user
				$this->make_user($db_name,$user,$pass);
			}
			else {
				$user = $this->user;
				$pass = $this->pass;
			}
			$this->make_table_data($db_name);
			return array(
			'dsn'=>'mysql:host='.$this->host.';port='.$this->port.';dbname='.$db_name,
			'login'=>$user,
			'pass'=>$pass);
		} catch (PDOException $e) {
			throw new Exception( $e->getMessage() );
		}
		return false;
	}
	
	protected function make_table_data($db_name) {
		$this->pdoConnection->query("SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
			SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
			SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
			CREATE SCHEMA IF NOT EXISTS `$db_name` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
			USE `$db_name`;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$db_name`.`TR_SENSOR` (
			`SEN_ID` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Technical sensor\'s key' ,
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
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$db_name`.`TA_VARIOUS` (
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
			`VAR_UV_INDEX` FLOAT(11) NULL DEFAULT NULL COMMENT 'niveau d\'UV (W/m²)' ,
			`VAR_UV_INDEX_HIGHT` FLOAT(11) NULL DEFAULT NULL COMMENT 'max : niveau d\'UV (W/m²)' ,
			`VAR_FORECAST_RULE` TINYINT(4) NULL DEFAULT NULL COMMENT 'prevision grossiere (voir P.22 de la doc)' ,
			`VAR_ET` FLOAT(11) NULL DEFAULT NULL COMMENT 'pluviometrie sur cette periode' ,
			PRIMARY KEY (`VAR_ID`) ,
			INDEX `IDX_DATE` (`VAR_DATE` ASC) ,
			UNIQUE INDEX `UNQ_DATE` (`VAR_DATE` ASC) )
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Table des capteurs unique (d\'autre du meme type ne peuvent e' /* comment truncated */;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$db_name`.`TA_TEMPERATURE` (
			`ID` INT(11) NOT NULL ,
			`SEN_ID` INT(11) NOT NULL ,
			`VALUE` FLOAT(11) NOT NULL ,
			PRIMARY KEY (`ID`, `SEN_ID`) ,
			INDEX `DATE_idx` (`ID` ASC) ,
			CONSTRAINT `SENSOR`
			FOREIGN KEY (`SEN_ID` )
			REFERENCES `$db_name`.`TR_SENSOR` (`SEN_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION,
			CONSTRAINT `DATE`
			FOREIGN KEY (`ID` )
			REFERENCES `$db_name`.`TA_VARIOUS` (`VAR_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Regroupe les relevés de tous les capteurs de temperature (en' /* comment truncated */;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$db_name`.`TA_WETNESSES` (
			`ID` INT(11) NOT NULL ,
			`SEN_ID` INT(11) NOT NULL ,
			`VALUE` TINYINT(4) NULL DEFAULT NULL ,
			PRIMARY KEY (`ID`, `SEN_ID`) ,
			INDEX `DATE` (`ID` ASC) ,
			CONSTRAINT `SENSOR0`
			FOREIGN KEY (`SEN_ID` )
			REFERENCES `$db_name`.`TR_SENSOR` (`SEN_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION,
			CONSTRAINT `DATE0`
			FOREIGN KEY (`ID` )
			REFERENCES `$db_name`.`TA_VARIOUS` (`VAR_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Regroupe les relevés de tous les capteurs de humidité du feu' /* comment truncated */;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$db_name`.`TA_MOISTURE` (
			`ID` INT(11) NOT NULL ,
			`SEN_ID` INT(11) NOT NULL ,
			`VALUE` TINYINT(4) NOT NULL ,
			PRIMARY KEY (`ID`, `SEN_ID`) ,
			INDEX `DATE` (`ID` ASC) ,
			CONSTRAINT `SENSOR00`
			FOREIGN KEY (`SEN_ID` )
			REFERENCES `$db_name`.`TR_SENSOR` (`SEN_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION,
			CONSTRAINT `DATE00`
			FOREIGN KEY (`ID` )
			REFERENCES `$db_name`.`TA_VARIOUS` (`VAR_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Regroupe les relevés de tous les capteurs de humidité du sol' /* comment truncated */;");
		$this->pdoConnection->query("CREATE  TABLE IF NOT EXISTS `$db_name`.`TA_HUMIDITY` (
			`ID` INT(11) NOT NULL ,
			`SEN_ID` INT(11) NOT NULL ,
			`VALUE` TINYINT(4) NOT NULL ,
			PRIMARY KEY (`ID`, `SEN_ID`) ,
			INDEX `DATE` (`ID` ASC) ,
			CONSTRAINT `SENSOR1`
			FOREIGN KEY (`SEN_ID` )
			REFERENCES `$db_name`.`TR_SENSOR` (`SEN_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION,
			CONSTRAINT `DATE1`
			FOREIGN KEY (`ID` )
			REFERENCES `$db_name`.`TA_VARIOUS` (`VAR_ID` )
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci
			COMMENT = 'Regroupe les relevés de tous les capteurs d\'humidité';
			SET SQL_MODE=@OLD_SQL_MODE;
			SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
			SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;");
	}
}