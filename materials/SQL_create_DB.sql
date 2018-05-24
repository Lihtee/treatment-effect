-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema maindb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `maindb` ;

-- -----------------------------------------------------
-- Schema maindb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `maindb` DEFAULT CHARACTER SET utf8 ;
USE `maindb` ;

-- -----------------------------------------------------
-- Table `maindb`.`operator`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maindb`.`operator` ;

CREATE TABLE IF NOT EXISTS `maindb`.`operator` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `value` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maindb`.`company`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maindb`.`company` ;

CREATE TABLE IF NOT EXISTS `maindb`.`company` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maindb`.`state_analysis`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maindb`.`state_analysis` ;

CREATE TABLE IF NOT EXISTS `maindb`.`state_analysis` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maindb`.`branch`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maindb`.`branch` ;

CREATE TABLE IF NOT EXISTS `maindb`.`branch` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maindb`.`data_set`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maindb`.`data_set` ;

CREATE TABLE IF NOT EXISTS `maindb`.`data_set` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  `id_company` INT NULL,
  `id_state_analysis` INT NULL,
  `id_branch` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_data_set_company1`
    FOREIGN KEY (`id_company`)
    REFERENCES `maindb`.`company` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_data_set_state_analysis1`
    FOREIGN KEY (`id_state_analysis`)
    REFERENCES `maindb`.`state_analysis` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_data_set_branch1`
    FOREIGN KEY (`id_branch`)
    REFERENCES `maindb`.`branch` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_data_set_company1_idx` ON `maindb`.`data_set` (`id_company` ASC);

CREATE INDEX `fk_data_set_state_analysis1_idx` ON `maindb`.`data_set` (`id_state_analysis` ASC);

CREATE INDEX `fk_data_set_branch1_idx` ON `maindb`.`data_set` (`id_branch` ASC);


-- -----------------------------------------------------
-- Table `maindb`.`type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maindb`.`type` ;

CREATE TABLE IF NOT EXISTS `maindb`.`type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maindb`.`subtype`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maindb`.`subtype` ;

CREATE TABLE IF NOT EXISTS `maindb`.`subtype` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_type` INT NULL,
  `name` VARCHAR(45) NULL,
  `id_parent_subtype` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_subtype_subtype1`
    FOREIGN KEY (`id_parent_subtype`)
    REFERENCES `maindb`.`subtype` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_subtype_type1`
    FOREIGN KEY (`id_type`)
    REFERENCES `maindb`.`type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_subtype_subtype1_idx` ON `maindb`.`subtype` (`id_parent_subtype` ASC);

CREATE INDEX `fk_subtype_type1_idx` ON `maindb`.`subtype` (`id_type` ASC);


-- -----------------------------------------------------
-- Table `maindb`.`data_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maindb`.`data_type` ;

CREATE TABLE IF NOT EXISTS `maindb`.`data_type` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `maindb`.`data_column`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maindb`.`data_column` ;

CREATE TABLE IF NOT EXISTS `maindb`.`data_column` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_data_set` INT NULL,
  `id_subtype` INT NULL,
  `id_data_type` INT NULL,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_data_column_data_set1`
    FOREIGN KEY (`id_data_set`)
    REFERENCES `maindb`.`data_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_data_column_subtype1`
    FOREIGN KEY (`id_subtype`)
    REFERENCES `maindb`.`subtype` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_data_column_data_type1`
    FOREIGN KEY (`id_data_type`)
    REFERENCES `maindb`.`data_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_data_column_data_set1_idx` ON `maindb`.`data_column` (`id_data_set` ASC);

CREATE INDEX `fk_data_column_subtype1_idx` ON `maindb`.`data_column` (`id_subtype` ASC);

CREATE INDEX `fk_data_column_data_type1_idx` ON `maindb`.`data_column` (`id_data_type` ASC);


-- -----------------------------------------------------
-- Table `maindb`.`analysis_result`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maindb`.`analysis_result` ;

CREATE TABLE IF NOT EXISTS `maindb`.`analysis_result` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ate` FLOAT NULL,
  `tte` FLOAT NULL,
  `id_data_set` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_analysis_result_data_set1`
    FOREIGN KEY (`id_data_set`)
    REFERENCES `maindb`.`data_set` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_analysis_result_data_set1_idx` ON `maindb`.`analysis_result` (`id_data_set` ASC);


-- -----------------------------------------------------
-- Table `maindb`.`variable_description`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maindb`.`variable_description` ;

CREATE TABLE IF NOT EXISTS `maindb`.`variable_description` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_result` INT NULL,
  `id_variable` INT NULL,
  `id_operator` INT NULL,
  `value` FLOAT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_variable_description_operator`
    FOREIGN KEY (`id_operator`)
    REFERENCES `maindb`.`operator` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_variable_description_data_column1`
    FOREIGN KEY (`id_variable`)
    REFERENCES `maindb`.`data_column` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_variable_description_analysis_result1`
    FOREIGN KEY (`id_result`)
    REFERENCES `maindb`.`analysis_result` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_variable_description_operator_idx` ON `maindb`.`variable_description` (`id_operator` ASC);

CREATE INDEX `fk_variable_description_data_column1_idx` ON `maindb`.`variable_description` (`id_variable` ASC);

CREATE INDEX `fk_variable_description_analysis_result1_idx` ON `maindb`.`variable_description` (`id_result` ASC);


-- -----------------------------------------------------
-- Table `maindb`.`email`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `maindb`.`email` ;

CREATE TABLE IF NOT EXISTS `maindb`.`email` (
  `email` VARCHAR(45) NOT NULL,
  `id_company` INT NULL,
  PRIMARY KEY (`email`),
  CONSTRAINT `fk_email_company1`
    FOREIGN KEY (`id_company`)
    REFERENCES `maindb`.`company` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_email_company1_idx` ON `maindb`.`email` (`id_company` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
