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
  `USR_USERNAME` VARCHAR(32) NOT NULL ,
  `USR_PWD` VARCHAR(64) NOT NULL ,
  `USR_FIRST_NAME` VARCHAR(45) NULL ,
  `USR_EMAIL` VARCHAR(45) NULL ,
  `ROL_ID` INT NOT NULL ,
  `USR_FAMILY_NAME` VARCHAR(45) NULL ,
  PRIMARY KEY (`USR_ID`) ,
  CONSTRAINT `FK_USR_ROL`
    FOREIGN KEY (`ROL_ID` )
    REFERENCES `wswds`.`TR_ROLE` (`ROL_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `IDX_FK_USR_ROL` ON `wswds`.`TA_USER` (`ROL_ID` ASC) ;


-- -----------------------------------------------------
-- Table `wswds`.`TR_CONFIG`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wswds`.`TR_CONFIG` ;

CREATE  TABLE IF NOT EXISTS `wswds`.`TR_CONFIG` (
  `CFG_ID` INT NOT NULL AUTO_INCREMENT ,
  `CFG_STATION_ID` TINYINT NULL ,
  `CFG_CODE` TINYINT NOT NULL ,
  `CFG_LABEL` TINYTEXT NULL ,
  `CFG_VALUE` TINYTEXT NOT NULL ,
  `CFG_LAST_READ` DATETIME NULL ,
  `CFG_LAST_WRITE` DATETIME NULL ,
  PRIMARY KEY (`CFG_ID`) )
ENGINE = InnoDB
COMMENT = 'Ici on stoque chaque config, ca valeur et les date d\'accé';

CREATE UNIQUE INDEX `IDX_UNI_CFG_CODE` ON `wswds`.`TR_CONFIG` (`CFG_CODE` ASC) ;


-- -----------------------------------------------------
-- Table `wswds`.`TA_LOG`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wswds`.`TA_LOG` ;

CREATE  TABLE IF NOT EXISTS `wswds`.`TA_LOG` (
  `LOG_ID` INT NOT NULL ,
  `LOG_STATION_ID` TINYINT NULL ,
  `LOG_CODE` TINYINT NULL ,
  `LOG_LABEL` TINYTEXT NULL ,
  `LOG_Value` MEDIUMTEXT NULL ,
  `LOG_Date` DATETIME NULL ,
  PRIMARY KEY (`LOG_ID`) )
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
  PRIMARY KEY (`SEN_ID`) )
ENGINE = InnoDB;

CREATE UNIQUE INDEX `IDX_UNI_SEN_CODE` ON `ws-template`.`TR_SENSOR` (`SEN_CODE` ASC) ;


-- -----------------------------------------------------
-- Table `ws-template`.`TA_WETNESSES`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ws-template`.`TA_WETNESSES` ;

CREATE  TABLE IF NOT EXISTS `ws-template`.`TA_WETNESSES` (
  `WET_ID` DATETIME NOT NULL ,
  `WET_VALUE` VARCHAR(45) NULL ,
  `SEN_ID` INT NOT NULL ,
  PRIMARY KEY (`WET_ID`) ,
  CONSTRAINT `IDX_FK_WET_SEN`
    FOREIGN KEY (`SEN_ID` )
    REFERENCES `ws-template`.`TR_SENSOR` (`SEN_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `IDX_FK_WET_SEN` ON `ws-template`.`TA_WETNESSES` (`SEN_ID` ASC) ;


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
  CONSTRAINT `IDX_FK_TEM_SEN`
    FOREIGN KEY (`SEN_ID` )
    REFERENCES `ws-template`.`TR_SENSOR` (`SEN_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `IDX_FK_TEM_SEN` ON `ws-template`.`TA_TEMPERATURE` (`SEN_ID` ASC) ;


-- -----------------------------------------------------
-- Table `ws-template`.`TA_MOISTURE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ws-template`.`TA_MOISTURE` ;

CREATE  TABLE IF NOT EXISTS `ws-template`.`TA_MOISTURE` (
  `MOI_ID` DATETIME NOT NULL ,
  `MOI_VALUE` VARCHAR(45) NULL ,
  `SEN_ID` INT NOT NULL ,
  PRIMARY KEY (`MOI_ID`) ,
  CONSTRAINT `IDX_FK_MOI_SEN`
    FOREIGN KEY (`SEN_ID` )
    REFERENCES `ws-template`.`TR_SENSOR` (`SEN_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `IDX_FK_MOI_SEN` ON `ws-template`.`TA_MOISTURE` (`SEN_ID` ASC) ;


-- -----------------------------------------------------
-- Table `ws-template`.`TA_HUMIDITY`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ws-template`.`TA_HUMIDITY` ;

CREATE  TABLE IF NOT EXISTS `ws-template`.`TA_HUMIDITY` (
  `HUM_ID` DATETIME NOT NULL ,
  `HUM_VALUE` VARCHAR(45) NULL ,
  `SEN_ID` INT NOT NULL ,
  PRIMARY KEY (`HUM_ID`) ,
  CONSTRAINT `IDX_FK_HUM_SEN`
    FOREIGN KEY (`SEN_ID` )
    REFERENCES `ws-template`.`TR_SENSOR` (`SEN_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `IDX_FK_HUM_SEN` ON `ws-template`.`TA_HUMIDITY` (`SEN_ID` ASC) ;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
