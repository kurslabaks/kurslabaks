SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `kurslabaks` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `kurslabaks` ;

-- -----------------------------------------------------
-- Table `kurslabaks`.`tweet`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kurslabaks`.`tweet` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `tweet_id` INT NULL ,
  `user` VARCHAR(45) NULL DEFAULT NULL ,
  `text` VARCHAR(140) NULL ,
  `date` DATE NULL DEFAULT NULL ,
  `mood` TINYINT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `tweet_id_UNIQUE` (`tweet_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kurslabaks`.`category`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kurslabaks`.`category` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `text` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kurslabaks`.`brand`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kurslabaks`.`brand` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `text` VARCHAR(45) NULL ,
  `category_id` INT NULL ,
  `parent_id` INT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `parent_id` (`parent_id` ASC) ,
  INDEX `category_id` (`category_id` ASC) ,
  CONSTRAINT `parent_id`
    FOREIGN KEY (`parent_id` )
    REFERENCES `kurslabaks`.`brand` (`id` )
    ON DELETE cascade
    ON UPDATE cascade,
  CONSTRAINT `category_id`
    FOREIGN KEY (`category_id` )
    REFERENCES `kurslabaks`.`category` (`id` )
    ON DELETE cascade
    ON UPDATE cascade)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kurslabaks`.`tweet_brand`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `kurslabaks`.`tweet_brand` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `tweet_id` INT NULL ,
  `brand_id` INT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `tweet_id` (`tweet_id` ASC) ,
  INDEX `brand_id` (`brand_id` ASC) ,
  CONSTRAINT `tweet_id`
    FOREIGN KEY (`tweet_id` )
    REFERENCES `kurslabaks`.`tweet` (`id` )
    ON DELETE cascade
    ON UPDATE cascade,
  CONSTRAINT `brand_id`
    FOREIGN KEY (`brand_id` )
    REFERENCES `kurslabaks`.`brand` (`id` )
    ON DELETE cascade
    ON UPDATE cascade)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
