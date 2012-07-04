SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `wswds` ;
CREATE SCHEMA IF NOT EXISTS `wswds` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
DROP SCHEMA IF EXISTS `ws-template` ;
CREATE SCHEMA IF NOT EXISTS `ws-template` DEFAULT CHARACTER SET utf8 ;
USE `wswds` ;

-- -----------------------------------------------------
-- Table `wswds`.`TR_ROLE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wswds`.`TR_ROLE` ;

CREATE  TABLE IF NOT EXISTS `wswds`.`TR_ROLE` (
  `ROL_ID` INT NOT NULL AUTO_INCREMENT ,
  `ROL_CODE` VARCHAR(32) NOT NULL ,
  `ROL_LABEL` VARCHAR(64) NOT NULL ,
  PRIMARY KEY (`ROL_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wswds`.`TA_USER`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wswds`.`TA_USER` ;

CREATE  TABLE IF NOT EXISTS `wswds`.`TA_USER` (
  `USR_ID` INT NOT NULL AUTO_INCREMENT ,
  `USR_LOGIN` VARCHAR(32) NOT NULL ,
  `USR_PWD` VARCHAR(64) NOT NULL ,
  `USR_NAME` VARCHAR(45) NULL ,
  `USR_MAIL` VARCHAR(45) NULL ,
  `ROL_ID` INT NOT NULL ,
  PRIMARY KEY (`USR_ID`) ,
  INDEX `IDX_FK_USR_ROL` (`ROL_ID` ASC) ,
  CONSTRAINT `FK_USR_ROL`
    FOREIGN KEY (`ROL_ID` )
    REFERENCES `wswds`.`TR_ROLE` (`ROL_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wswds`.`TR_STATION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wswds`.`TR_STATION` ;

CREATE  TABLE IF NOT EXISTS `wswds`.`TR_STATION` (
  `STA_ID` TINYINT NOT NULL AUTO_INCREMENT ,
  `STA_Port` INT NULL ,
  `STA_IP` VARCHAR(60) NOT NULL ,
  `STA_Name` VARCHAR(45) NULL ,
  `STA_Modele` VARCHAR(45) NULL ,
  `STA_DBName` VARCHAR(128) NULL ,
  PRIMARY KEY (`STA_ID`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'cette table liste nos differente station, l\'ip, le port, le ' /* comment truncated */;


-- -----------------------------------------------------
-- Table `wswds`.`TR_CONFIG`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wswds`.`TR_CONFIG` ;

CREATE  TABLE IF NOT EXISTS `wswds`.`TR_CONFIG` (
  `CFG_ID` INT NOT NULL AUTO_INCREMENT ,
  `CFG_CODE` VARCHAR(32) NOT NULL ,
  `CFG_LABEL` VARCHAR(64) NULL ,
  `CFG_VALUE` VARCHAR(45) NOT NULL ,
  `CFG_LAST_READ` DATETIME NULL ,
  `CFG_LAST_WRITE` DATETIME NULL ,
  `STA_ID` TINYINT NULL ,
  PRIMARY KEY (`CFG_ID`) ,
  UNIQUE INDEX `IDX_UNI_CFG_CODE` (`CFG_CODE` ASC) ,
  INDEX `fk_TR_CONFIG_1` (`STA_ID` ASC) ,
  CONSTRAINT `fk_TR_CONFIG_1`
    FOREIGN KEY (`STA_ID` )
    REFERENCES `wswds`.`TR_STATION` (`STA_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Ici on stoque chaque config, ca valeur et les date d\'accé';


-- -----------------------------------------------------
-- Table `wswds`.`TA_LOG`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wswds`.`TA_LOG` ;

CREATE  TABLE IF NOT EXISTS `wswds`.`TA_LOG` (
  `LOG_ID` INT NOT NULL ,
  `LOG_Name` VARCHAR(45) NULL ,
  `LOG_Value` TINYTEXT NULL ,
  `LOG_Date` DATETIME NULL ,
  `STA_ID` TINYINT NULL ,
  PRIMARY KEY (`LOG_ID`) ,
  INDEX `FK_Log_Station` (`STA_ID` ASC) ,
  CONSTRAINT `FK_Log_Station`
    FOREIGN KEY (`STA_ID` )
    REFERENCES `wswds`.`TR_STATION` (`STA_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Ici on log les different accée a chaque station ainsi qu\'une' /* comment truncated */;

USE `ws-template` ;

-- -----------------------------------------------------
-- Table `ws-template`.`TR_SENSOR`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ws-template`.`TR_SENSOR` ;

CREATE  TABLE IF NOT EXISTS `ws-template`.`TR_SENSOR` (
  `SEN_ID` INT NOT NULL AUTO_INCREMENT COMMENT 'Technical sensor\'s key' ,
  `SEN_CODE` VARCHAR(32) NOT NULL ,
  `SEN_NAME` VARCHAR(64) NULL COMMENT 'Name of the sensor' ,
  `SEN_MIN` FLOAT NULL COMMENT 'Minimum value' ,
  `SEN_MAX` FLOAT NULL COMMENT 'Maximum value' ,
  `SEN_ERROR` FLOAT NULL COMMENT 'Measure error' ,
  `SEN_UNITE_SIGN` INT NULL ,
  PRIMARY KEY (`SEN_ID`) ,
  UNIQUE INDEX `IDX_UNI_SEN_CODE` (`SEN_CODE` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ws-template`.`TA_WETNESSES`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ws-template`.`TA_WETNESSES` ;

CREATE  TABLE IF NOT EXISTS `ws-template`.`TA_WETNESSES` (
  `WET_ID` DATETIME NOT NULL ,
  `WET_VALUE` VARCHAR(45) NULL ,
  `SEN_ID` INT NOT NULL ,
  PRIMARY KEY (`WET_ID`) ,
  INDEX `IDX_FK_WET_SEN` (`SEN_ID` ASC) ,
  CONSTRAINT `IDX_FK_WET_SEN`
    FOREIGN KEY (`SEN_ID` )
    REFERENCES `ws-template`.`TR_SENSOR` (`SEN_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ws-template`.`TA_VARIOUS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ws-template`.`TA_VARIOUS` ;

CREATE  TABLE IF NOT EXISTS `ws-template`.`TA_VARIOUS` (
  `VAR_ID` DATETIME NOT NULL ,
  `VAR_SAMPLE_RAINFALL` FLOAT NULL COMMENT 'Indoor temperature' ,
  `VAR_SAMPLE_RAINFALL_HIGHT` FLOAT NULL COMMENT 'Humidity' ,
  `VAR_PRESSURE` FLOAT NULL ,
  `VAR_SOLAR_RADIATION` INT NULL ,
  `VAR_SOLAR_RADIATION_HIGHT` INT NULL ,
  `VAR_WIND_SPEED` FLOAT NULL ,
  `VAR_WIND_SPEED_HIGHT` FLOAT NULL ,
  `VAR_WIND_SPEED_HIGHT_DIR` TINYINT NULL ,
  `VAR_WIND_SPEED_DOMINANT_DIR` TINYINT NULL ,
  `VAR_UV_INDEX` FLOAT NULL ,
  `VAR_UV_INDEX_HIGHT` FLOAT NULL ,
  `VAR_FORECAST_RULE` TINYINT NULL ,
  `VAR_RAIN` FLOAT NULL ,
  PRIMARY KEY (`VAR_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ws-template`.`TA_TEMPERATURE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ws-template`.`TA_TEMPERATURE` ;

CREATE  TABLE IF NOT EXISTS `ws-template`.`TA_TEMPERATURE` (
  `TEM_ID` DATETIME NOT NULL ,
  `TEM_VALUE` VARCHAR(45) NULL ,
  `SEN_ID` INT NOT NULL ,
  PRIMARY KEY (`TEM_ID`) ,
  INDEX `IDX_FK_TEM_SEN` (`SEN_ID` ASC) ,
  CONSTRAINT `IDX_FK_TEM_SEN`
    FOREIGN KEY (`SEN_ID` )
    REFERENCES `ws-template`.`TR_SENSOR` (`SEN_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ws-template`.`TA_MOISTURE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ws-template`.`TA_MOISTURE` ;

CREATE  TABLE IF NOT EXISTS `ws-template`.`TA_MOISTURE` (
  `MOI_ID` DATETIME NOT NULL ,
  `MOI_VALUE` VARCHAR(45) NULL ,
  `SEN_ID` INT NOT NULL ,
  PRIMARY KEY (`MOI_ID`) ,
  INDEX `IDX_FK_MOI_SEN` (`SEN_ID` ASC) ,
  CONSTRAINT `IDX_FK_MOI_SEN`
    FOREIGN KEY (`SEN_ID` )
    REFERENCES `ws-template`.`TR_SENSOR` (`SEN_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ws-template`.`TA_HUMIDITY`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ws-template`.`TA_HUMIDITY` ;

CREATE  TABLE IF NOT EXISTS `ws-template`.`TA_HUMIDITY` (
  `HUM_ID` DATETIME NOT NULL ,
  `HUM_VALUE` VARCHAR(45) NULL ,
  `SEN_ID` INT NOT NULL ,
  PRIMARY KEY (`HUM_ID`) ,
  INDEX `IDX_FK_HUM_SEN` (`SEN_ID` ASC) ,
  CONSTRAINT `IDX_FK_HUM_SEN`
    FOREIGN KEY (`SEN_ID` )
    REFERENCES `ws-template`.`TR_SENSOR` (`SEN_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
