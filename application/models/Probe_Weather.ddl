-- SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
-- SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `%s` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
			USE `%s`;

CREATE  TABLE IF NOT EXISTS `TR_SENSOR` (
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
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'Table descriptive des capteurs present sur la station';

CREATE  TABLE IF NOT EXISTS `TA_VARIOUS` (
        `UTC` TIMESTAMP NOT NULL ,
        `SEN_ID` SMALLINT(6) NOT NULL ,
        `VALUE` FLOAT(11) NULL DEFAULT NULL ,
        PRIMARY KEY (`UTC`, `SEN_ID`) ,
        INDEX `VARIOUS` (`SEN_ID` ASC) ,
        CONSTRAINT `SENSOR000`
        FOREIGN KEY (`SEN_ID` )
        REFERENCES `TR_SENSOR` (`SEN_ID` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'Regroupe les releves de tous les autres type de capteurs';

CREATE  TABLE IF NOT EXISTS `TA_TEMPERATURE` (
        `UTC` TIMESTAMP NOT NULL ,
        `SEN_ID` SMALLINT(6) NOT NULL ,
        `VALUE` FLOAT(11) NULL DEFAULT NULL ,
        INDEX `TEMP` (`SEN_ID` ASC) ,
        PRIMARY KEY (`UTC`, `SEN_ID`) ,
        CONSTRAINT `SENSOR`
        FOREIGN KEY (`SEN_ID` )
        REFERENCES `TR_SENSOR` (`SEN_ID` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'Regroupe les relevÃ©s de tous les capteurs de temperature (e' /* comment truncated */;

CREATE  TABLE IF NOT EXISTS `TA_WETNESSES` (
        `UTC` TIMESTAMP NOT NULL ,
        `SEN_ID` SMALLINT(6) NOT NULL ,
        `VALUE` TINYINT(4) NULL DEFAULT NULL ,
        INDEX `WETNESSES` (`SEN_ID` ASC) ,
        PRIMARY KEY (`UTC`, `SEN_ID`) ,
        CONSTRAINT `SENSOR0`
        FOREIGN KEY (`SEN_ID` )
        REFERENCES `TR_SENSOR` (`SEN_ID` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'Regroupe les relevÃ©s de tous les capteurs de humiditÃ© du f' /* comment truncated */;

CREATE  TABLE IF NOT EXISTS `TA_MOISTURE` (
        `UTC` TIMESTAMP NOT NULL ,
        `SEN_ID` SMALLINT(6) NOT NULL ,
        `VALUE` TINYINT(4) NULL DEFAULT NULL ,
        INDEX `MOISTURE` (`SEN_ID` ASC) ,
        PRIMARY KEY (`SEN_ID`, `UTC`) ,
        CONSTRAINT `SENSOR00`
        FOREIGN KEY (`SEN_ID` )
        REFERENCES `TR_SENSOR` (`SEN_ID` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'Regroupe les relevÃ©s de tous les capteurs de humiditee du s' /* comment truncated */;

CREATE  TABLE IF NOT EXISTS `TA_HUMIDITY` (
        `UTC` TIMESTAMP NOT NULL ,
        `SEN_ID` SMALLINT(6) NOT NULL ,
        `VALUE` TINYINT(4) NULL DEFAULT NULL ,
        INDEX `HUM` (`SEN_ID` ASC) ,
        PRIMARY KEY (`SEN_ID`, `UTC`) ,
        CONSTRAINT `SENSOR1`
        FOREIGN KEY (`SEN_ID` )
        REFERENCES `TR_SENSOR` (`SEN_ID` )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_general_ci
        COMMENT = 'Regroupe les releves de tous les capteurs d humiditee';