-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema ebabilon
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema ebabilon
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ebabilon` DEFAULT CHARACTER SET utf8 ;
USE `ebabilon` ;

-- -----------------------------------------------------
-- Table `ebabilon`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebabilon`.`users` ;

CREATE TABLE IF NOT EXISTS `ebabilon`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `user_name` VARCHAR(45) NOT NULL COMMENT '',
  `email` VARCHAR(255) NOT NULL COMMENT '',
  `salt` VARCHAR(255) NOT NULL COMMENT '',
  `password` VARCHAR(2555) NOT NULL COMMENT '',
  `first_name` VARCHAR(45) NOT NULL COMMENT '',
  `middle_name` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `last_name` VARCHAR(45) NOT NULL COMMENT '',
  `maiden_name` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `user_image` VARCHAR(100) NOT NULL DEFAULT '/images/stock/default-user.png' COMMENT '',
  `isAdmin` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '',
  `optOutEmail` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  UNIQUE INDEX `id_UNIQUE` (`id` ASC)  COMMENT '',
  INDEX `name` (`first_name` ASC, `middle_name` ASC, `last_name` ASC, `maiden_name` ASC)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 27
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ebabilon`.`event_categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebabilon`.`event_categories` ;

CREATE TABLE IF NOT EXISTS `ebabilon`.`event_categories` (
  `id_category` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`id_category`)  COMMENT '',
  UNIQUE INDEX `id_category_UNIQUE` (`id_category` ASC)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ebabilon`.`events`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebabilon`.`events` ;

CREATE TABLE IF NOT EXISTS `ebabilon`.`events` (
  `id_event` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(255) NOT NULL COMMENT '',
  `time` DATETIME NULL DEFAULT NULL COMMENT '',
  `place` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  `admin` INT(11) NOT NULL COMMENT '',
  `category` INT(11) NULL DEFAULT NULL COMMENT '',
  `description` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  `event_image` VARCHAR(100) NOT NULL DEFAULT '/images/stock/runner.png' COMMENT '',
  PRIMARY KEY (`id_event`)  COMMENT '',
  UNIQUE INDEX `id_event_UNIQUE` (`id_event` ASC)  COMMENT '',
  INDEX `admin_idx` (`admin` ASC)  COMMENT '',
  INDEX `event_category_idx` (`category` ASC)  COMMENT '',
  CONSTRAINT `event_admin`
    FOREIGN KEY (`admin`)
    REFERENCES `ebabilon`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `event_category`
    FOREIGN KEY (`category`)
    REFERENCES `ebabilon`.`event_categories` (`id_category`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 53
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ebabilon`.`attendees`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebabilon`.`attendees` ;

CREATE TABLE IF NOT EXISTS `ebabilon`.`attendees` (
  `id_event` INT(11) NOT NULL COMMENT '',
  `id_attendee` INT(11) NOT NULL COMMENT '',
  INDEX `id_event_idx` (`id_event` ASC)  COMMENT '',
  INDEX `id_user_idx` (`id_attendee` ASC)  COMMENT '',
  CONSTRAINT `id_attendee`
    FOREIGN KEY (`id_attendee`)
    REFERENCES `ebabilon`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `id_event`
    FOREIGN KEY (`id_event`)
    REFERENCES `ebabilon`.`events` (`id_event`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ebabilon`.`business_categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebabilon`.`business_categories` ;

CREATE TABLE IF NOT EXISTS `ebabilon`.`business_categories` (
  `id_category` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(255) NOT NULL COMMENT '',
  PRIMARY KEY (`id_category`)  COMMENT '',
  UNIQUE INDEX `id_category_UNIQUE` (`id_category` ASC)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 18
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ebabilon`.`businesses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebabilon`.`businesses` ;

CREATE TABLE IF NOT EXISTS `ebabilon`.`businesses` (
  `id_business` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(255) NOT NULL COMMENT '',
  `address` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  `opHours` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  `admin` INT(11) NOT NULL COMMENT '',
  `category` INT(11) NULL DEFAULT NULL COMMENT '',
  `business_image` VARCHAR(100) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`id_business`)  COMMENT '',
  UNIQUE INDEX `id_business_UNIQUE` (`id_business` ASC)  COMMENT '',
  INDEX `admin_idx` (`admin` ASC)  COMMENT '',
  INDEX `category_idx` (`category` ASC)  COMMENT '',
  CONSTRAINT `business_admin`
    FOREIGN KEY (`admin`)
    REFERENCES `ebabilon`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `business_category`
    FOREIGN KEY (`category`)
    REFERENCES `ebabilon`.`business_categories` (`id_category`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 88
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ebabilon`.`followers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebabilon`.`followers` ;

CREATE TABLE IF NOT EXISTS `ebabilon`.`followers` (
  `id_business` INT(11) NOT NULL COMMENT '',
  `id_follower` INT(11) NOT NULL COMMENT '',
  INDEX `business_idx` (`id_business` ASC)  COMMENT '',
  INDEX `follower_idx` (`id_follower` ASC)  COMMENT '',
  CONSTRAINT `business`
    FOREIGN KEY (`id_business`)
    REFERENCES `ebabilon`.`businesses` (`id_business`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `follower`
    FOREIGN KEY (`id_follower`)
    REFERENCES `ebabilon`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ebabilon`.`friends_categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebabilon`.`friends_categories` ;

CREATE TABLE IF NOT EXISTS `ebabilon`.`friends_categories` (
  `id_category` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(255) NOT NULL COMMENT '',
  PRIMARY KEY (`id_category`)  COMMENT '',
  UNIQUE INDEX `id_category_UNIQUE` (`id_category` ASC)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ebabilon`.`friends`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebabilon`.`friends` ;

CREATE TABLE IF NOT EXISTS `ebabilon`.`friends` (
  `id_user` INT(11) NOT NULL COMMENT '',
  `id_friend` INT(11) NOT NULL COMMENT '',
  `category` INT(11) NULL DEFAULT '1' COMMENT '',
  INDEX `category_idx` (`category` ASC)  COMMENT '',
  INDEX `id_user_idx` (`id_user` ASC)  COMMENT '',
  INDEX `id_friend_idx` (`id_friend` ASC)  COMMENT '',
  CONSTRAINT `friend_category`
    FOREIGN KEY (`category`)
    REFERENCES `ebabilon`.`friends_categories` (`id_category`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `id_friend`
    FOREIGN KEY (`id_friend`)
    REFERENCES `ebabilon`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `id_user`
    FOREIGN KEY (`id_user`)
    REFERENCES `ebabilon`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ebabilon`.`group_categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebabilon`.`group_categories` ;

CREATE TABLE IF NOT EXISTS `ebabilon`.`group_categories` (
  `id_category` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(255) NOT NULL COMMENT '',
  PRIMARY KEY (`id_category`)  COMMENT '',
  UNIQUE INDEX `id_category_UNIQUE` (`id_category` ASC)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ebabilon`.`groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebabilon`.`groups` ;

CREATE TABLE IF NOT EXISTS `ebabilon`.`groups` (
  `id_group` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(45) NOT NULL COMMENT '',
  `admin` INT(11) NOT NULL COMMENT '',
  `category` INT(11) NULL DEFAULT NULL COMMENT '',
  `description` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  `group_image` VARCHAR(100) NOT NULL DEFAULT '/images/stock/members.png' COMMENT '',
  PRIMARY KEY (`id_group`)  COMMENT '',
  UNIQUE INDEX `id_group_UNIQUE` (`id_group` ASC)  COMMENT '',
  INDEX `category_idx` (`category` ASC)  COMMENT '',
  INDEX `admin_idx` (`admin` ASC)  COMMENT '',
  CONSTRAINT `group_admin`
    FOREIGN KEY (`admin`)
    REFERENCES `ebabilon`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `group_category`
    FOREIGN KEY (`category`)
    REFERENCES `ebabilon`.`group_categories` (`id_category`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 60
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ebabilon`.`members`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebabilon`.`members` ;

CREATE TABLE IF NOT EXISTS `ebabilon`.`members` (
  `id_group` INT(11) NOT NULL COMMENT '',
  `id_member` INT(11) NOT NULL COMMENT '',
  INDEX `id_group_idx` (`id_group` ASC)  COMMENT '',
  INDEX `id_member_idx` (`id_member` ASC)  COMMENT '',
  CONSTRAINT `id_group`
    FOREIGN KEY (`id_group`)
    REFERENCES `ebabilon`.`groups` (`id_group`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `id_member`
    FOREIGN KEY (`id_member`)
    REFERENCES `ebabilon`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ebabilon`.`posts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ebabilon`.`posts` ;

CREATE TABLE IF NOT EXISTS `ebabilon`.`posts` (
  `id_post` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `message` VARCHAR(255) NOT NULL COMMENT '',
  `date` DATETIME NOT NULL COMMENT '',
  `author` INT(11) NOT NULL COMMENT '',
  `destination` INT(11) NOT NULL COMMENT '',
  PRIMARY KEY (`id_post`)  COMMENT '',
  UNIQUE INDEX `id_post_UNIQUE` (`id_post` ASC)  COMMENT '',
  INDEX `author_idx` (`author` ASC)  COMMENT '',
  INDEX `destination_idx` (`destination` ASC)  COMMENT '',
  CONSTRAINT `user_author`
    FOREIGN KEY (`author`)
    REFERENCES `ebabilon`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `user_destination`
    FOREIGN KEY (`destination`)
    REFERENCES `ebabilon`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 64
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
