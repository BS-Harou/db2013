SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Skupiny`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Skupiny` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Skupiny` (
  `id_Skupiny` INT NOT NULL,
  `nazev` VARCHAR(45) NULL,
  `rok_zalozeni` YEAR NULL,
  `historie` TEXT NULL,
  `www` VARCHAR(200) NULL,
  PRIMARY KEY (`id_Skupiny`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Clenove`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Clenove` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Clenove` (
  `id_Clenove` INT NOT NULL,
  `jmeno` VARCHAR(45) NOT NULL,
  `prijmeni` VARCHAR(45) NOT NULL,
  `datum_narozeni` DATETIME NULL,
  `misto_narozeni` VARCHAR(45) NULL,
  `datum_umrti` DATETIME NULL,
  `historie` TEXT NULL,
  `www` VARCHAR(200) NULL,
  PRIMARY KEY (`id_Clenove`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Skupiny_Clenove`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Skupiny_Clenove` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Skupiny_Clenove` (
  `Skupiny_id_Skupiny` INT NOT NULL,
  `Clenove_id_clenove` INT NOT NULL,
  `aktivni` TINYINT(1) NULL,
  `rok_zacatku` YEAR NULL,
  `rok_konce` YEAR NULL,
  PRIMARY KEY (`Skupiny_id_Skupiny`, `Clenove_id_clenove`),
  INDEX `fk_Skupiny_has_Clenove_Clenove1_idx` (`Clenove_id_clenove` ASC),
  INDEX `fk_Skupiny_has_Clenove_Skupiny_idx` (`Skupiny_id_Skupiny` ASC),
  CONSTRAINT `fk_Skupiny_has_Clenove_Skupiny`
    FOREIGN KEY (`Skupiny_id_Skupiny`)
    REFERENCES `mydb`.`Skupiny` (`id_Skupiny`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Skupiny_has_Clenove_Clenove1`
    FOREIGN KEY (`Clenove_id_clenove`)
    REFERENCES `mydb`.`Clenove` (`id_Clenove`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Uzivatele`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Uzivatele` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Uzivatele` (
  `id_Uzivatele` INT NOT NULL,
  `nickname` VARCHAR(45) NOT NULL,
  `jmeno` VARCHAR(45) NOT NULL,
  `prijmeni` VARCHAR(45) NOT NULL,
  `mail` VARCHAR(45) NOT NULL,
  `icq` VARCHAR(45) NULL,
  `heslo` VARCHAR(100) NOT NULL,
  `datum_registrace` DATETIME NOT NULL,
  PRIMARY KEY (`id_Uzivatele`),
  UNIQUE INDEX `nickname_UNIQUE` (`nickname` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Nastroje`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Nastroje` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Nastroje` (
  `id_Nastroje` INT NOT NULL,
  `nazev` VARCHAR(45) NULL,
  PRIMARY KEY (`id_Nastroje`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Nastroje_Clenove`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Nastroje_Clenove` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Nastroje_Clenove` (
  `Nastroje_id_Nastroje` INT NOT NULL,
  `Clenove_id_Clenove` INT NOT NULL,
  PRIMARY KEY (`Nastroje_id_Nastroje`, `Clenove_id_Clenove`),
  INDEX `fk_Nastroje_has_Clenove_Clenove1_idx` (`Clenove_id_Clenove` ASC),
  INDEX `fk_Nastroje_has_Clenove_Nastroje1_idx` (`Nastroje_id_Nastroje` ASC),
  CONSTRAINT `fk_Nastroje_has_Clenove_Nastroje1`
    FOREIGN KEY (`Nastroje_id_Nastroje`)
    REFERENCES `mydb`.`Nastroje` (`id_Nastroje`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Nastroje_has_Clenove_Clenove1`
    FOREIGN KEY (`Clenove_id_Clenove`)
    REFERENCES `mydb`.`Clenove` (`id_Clenove`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Vydavatele`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Vydavatele` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Vydavatele` (
  `id_Vydavatel` INT NOT NULL,
  `nazev` TEXT NOT NULL,
  `popis` TEXT NULL,
  `datum_zalozeni` DATE NULL,
  PRIMARY KEY (`id_Vydavatel`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Alba`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Alba` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Alba` (
  `id_Alba` INT NOT NULL,
  `obal` TINYTEXT NULL,
  `datum_vydani` DATETIME NULL,
  `delka_alba` VARCHAR(45) NULL,
  `Skupiny_id_Skupiny` INT NOT NULL,
  `Vydavatele_id_Vydavatel` INT NULL,
  PRIMARY KEY (`id_Alba`),
  INDEX `fk_Alba_Skupiny1_idx` (`Skupiny_id_Skupiny` ASC),
  INDEX `fk_Alba_Vydavatele1_idx` (`Vydavatele_id_Vydavatel` ASC),
  CONSTRAINT `fk_Alba_Skupiny1`
    FOREIGN KEY (`Skupiny_id_Skupiny`)
    REFERENCES `mydb`.`Skupiny` (`id_Skupiny`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Alba_Vydavatele1`
    FOREIGN KEY (`Vydavatele_id_Vydavatel`)
    REFERENCES `mydb`.`Vydavatele` (`id_Vydavatel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Skladby`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Skladby` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Skladby` (
  `id_Skladby` INT NOT NULL,
  `nazev` VARCHAR(45) NOT NULL,
  `delka` TIME NOT NULL,
  `text` TEXT NULL,
  `youtube` VARCHAR(200) NULL,
  `Alba_id_Alba` INT NOT NULL,
  PRIMARY KEY (`id_Skladby`),
  INDEX `fk_Skladby_Alba1_idx` (`Alba_id_Alba` ASC),
  CONSTRAINT `fk_Skladby_Alba1`
    FOREIGN KEY (`Alba_id_Alba`)
    REFERENCES `mydb`.`Alba` (`id_Alba`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Skladby_Clenove`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Skladby_Clenove` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Skladby_Clenove` (
  `Skladby_id_Skladby` INT NOT NULL,
  `Clenove_id_Clenove` INT NOT NULL,
  PRIMARY KEY (`Skladby_id_Skladby`, `Clenove_id_Clenove`),
  INDEX `fk_Skladby_has_Clenove_Clenove1_idx` (`Clenove_id_Clenove` ASC),
  INDEX `fk_Skladby_has_Clenove_Skladby1_idx` (`Skladby_id_Skladby` ASC),
  CONSTRAINT `fk_Skladby_has_Clenove_Skladby1`
    FOREIGN KEY (`Skladby_id_Skladby`)
    REFERENCES `mydb`.`Skladby` (`id_Skladby`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Skladby_has_Clenove_Clenove1`
    FOREIGN KEY (`Clenove_id_Clenove`)
    REFERENCES `mydb`.`Clenove` (`id_Clenove`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Oblibene_Skupiny`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Oblibene_Skupiny` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Oblibene_Skupiny` (
  `Uzivatele_id_Uzivatele` INT NOT NULL,
  `Skupiny_id_Skupiny` INT NOT NULL,
  `popis` VARCHAR(100) NULL,
  PRIMARY KEY (`Uzivatele_id_Uzivatele`, `Skupiny_id_Skupiny`),
  INDEX `fk_Uzivatele_has_Skupiny_Skupiny1_idx` (`Skupiny_id_Skupiny` ASC),
  INDEX `fk_Uzivatele_has_Skupiny_Uzivatele1_idx` (`Uzivatele_id_Uzivatele` ASC),
  CONSTRAINT `fk_Uzivatele_has_Skupiny_Uzivatele1`
    FOREIGN KEY (`Uzivatele_id_Uzivatele`)
    REFERENCES `mydb`.`Uzivatele` (`id_Uzivatele`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Uzivatele_has_Skupiny_Skupiny1`
    FOREIGN KEY (`Skupiny_id_Skupiny`)
    REFERENCES `mydb`.`Skupiny` (`id_Skupiny`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Oblibene_Clenove`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Oblibene_Clenove` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Oblibene_Clenove` (
  `Uzivatele_id_Uzivatele` INT NOT NULL,
  `Clenove_id_Clenove` INT NOT NULL,
  `popis` VARCHAR(100) NULL,
  PRIMARY KEY (`Uzivatele_id_Uzivatele`, `Clenove_id_Clenove`),
  INDEX `fk_Uzivatele_has_Clenove_Clenove1_idx` (`Clenove_id_Clenove` ASC),
  INDEX `fk_Uzivatele_has_Clenove_Uzivatele1_idx` (`Uzivatele_id_Uzivatele` ASC),
  CONSTRAINT `fk_Uzivatele_has_Clenove_Uzivatele1`
    FOREIGN KEY (`Uzivatele_id_Uzivatele`)
    REFERENCES `mydb`.`Uzivatele` (`id_Uzivatele`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Uzivatele_has_Clenove_Clenove1`
    FOREIGN KEY (`Clenove_id_Clenove`)
    REFERENCES `mydb`.`Clenove` (`id_Clenove`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Role` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Role` (
  `id_Role` INT NOT NULL,
  `nazev` VARCHAR(45) NULL,
  PRIMARY KEY (`id_Role`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Uzivatele_has_Role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Uzivatele_has_Role` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Uzivatele_has_Role` (
  `Uzivatele_id_Uzivatele` INT NOT NULL,
  `Role_id_Role` INT NOT NULL,
  `aktivni` TINYINT(1) NULL,
  `popis` VARCHAR(200) NULL,
  PRIMARY KEY (`Uzivatele_id_Uzivatele`, `Role_id_Role`),
  INDEX `fk_Uzivatele_has_Role_Role1_idx` (`Role_id_Role` ASC),
  INDEX `fk_Uzivatele_has_Role_Uzivatele1_idx` (`Uzivatele_id_Uzivatele` ASC),
  CONSTRAINT `fk_Uzivatele_has_Role_Uzivatele1`
    FOREIGN KEY (`Uzivatele_id_Uzivatele`)
    REFERENCES `mydb`.`Uzivatele` (`id_Uzivatele`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Uzivatele_has_Role_Role1`
    FOREIGN KEY (`Role_id_Role`)
    REFERENCES `mydb`.`Role` (`id_Role`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Zadosti`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Zadosti` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Zadosti` (
  `id_Zadosti` INT NOT NULL,
  `datum` DATETIME NOT NULL,
  `zpracovano` TINYINT(1) NULL,
  `schvaleno` TINYINT(1) NULL,
  `Uzivatele_id_Uzivatele` INT NOT NULL,
  PRIMARY KEY (`id_Zadosti`),
  INDEX `fk_Zadosti_Uzivatele1_idx` (`Uzivatele_id_Uzivatele` ASC),
  CONSTRAINT `fk_Zadosti_Uzivatele1`
    FOREIGN KEY (`Uzivatele_id_Uzivatele`)
    REFERENCES `mydb`.`Uzivatele` (`id_Uzivatele`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Hodnoceni_Skupin`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Hodnoceni_Skupin` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Hodnoceni_Skupin` (
  `Skupiny_id_Skupiny` INT NOT NULL,
  `Uzivatele_id_Uzivatele` INT NOT NULL,
  `hodnoceni` TINYINT NOT NULL,
  PRIMARY KEY (`Skupiny_id_Skupiny`, `Uzivatele_id_Uzivatele`),
  INDEX `fk_Skupiny_has_Uzivatele_Uzivatele1_idx` (`Uzivatele_id_Uzivatele` ASC),
  INDEX `fk_Skupiny_has_Uzivatele_Skupiny1_idx` (`Skupiny_id_Skupiny` ASC),
  CONSTRAINT `fk_Skupiny_has_Uzivatele_Skupiny1`
    FOREIGN KEY (`Skupiny_id_Skupiny`)
    REFERENCES `mydb`.`Skupiny` (`id_Skupiny`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Skupiny_has_Uzivatele_Uzivatele1`
    FOREIGN KEY (`Uzivatele_id_Uzivatele`)
    REFERENCES `mydb`.`Uzivatele` (`id_Uzivatele`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Hodnoceni_skladeb`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Hodnoceni_skladeb` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Hodnoceni_skladeb` (
  `Skladby_id_Skladby` INT NOT NULL,
  `Uzivatele_id_Uzivatele` INT NOT NULL,
  `hodnoceni` TINYINT NOT NULL,
  PRIMARY KEY (`Skladby_id_Skladby`, `Uzivatele_id_Uzivatele`),
  INDEX `fk_Skladby_has_Uzivatele_Uzivatele1_idx` (`Uzivatele_id_Uzivatele` ASC),
  INDEX `fk_Skladby_has_Uzivatele_Skladby1_idx` (`Skladby_id_Skladby` ASC),
  CONSTRAINT `fk_Skladby_has_Uzivatele_Skladby1`
    FOREIGN KEY (`Skladby_id_Skladby`)
    REFERENCES `mydb`.`Skladby` (`id_Skladby`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Skladby_has_Uzivatele_Uzivatele1`
    FOREIGN KEY (`Uzivatele_id_Uzivatele`)
    REFERENCES `mydb`.`Uzivatele` (`id_Uzivatele`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Hodnoceni_clenu`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Hodnoceni_clenu` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Hodnoceni_clenu` (
  `Clenove_id_Clenove` INT NOT NULL,
  `Uzivatele_id_Uzivatele` INT NOT NULL,
  `hodnoceni` TINYINT NOT NULL,
  PRIMARY KEY (`Clenove_id_Clenove`, `Uzivatele_id_Uzivatele`),
  INDEX `fk_Clenove_has_Uzivatele_Uzivatele1_idx` (`Uzivatele_id_Uzivatele` ASC),
  INDEX `fk_Clenove_has_Uzivatele_Clenove1_idx` (`Clenove_id_Clenove` ASC),
  CONSTRAINT `fk_Clenove_has_Uzivatele_Clenove1`
    FOREIGN KEY (`Clenove_id_Clenove`)
    REFERENCES `mydb`.`Clenove` (`id_Clenove`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Clenove_has_Uzivatele_Uzivatele1`
    FOREIGN KEY (`Uzivatele_id_Uzivatele`)
    REFERENCES `mydb`.`Uzivatele` (`id_Uzivatele`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Hodnoceni_alb`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Hodnoceni_alb` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Hodnoceni_alb` (
  `Alba_id_Alba` INT NOT NULL,
  `Uzivatele_id_Uzivatele` INT NOT NULL,
  `hodnoceni` TINYINT NOT NULL,
  PRIMARY KEY (`Alba_id_Alba`, `Uzivatele_id_Uzivatele`),
  INDEX `fk_Alba_has_Uzivatele_Uzivatele1_idx` (`Uzivatele_id_Uzivatele` ASC),
  INDEX `fk_Alba_has_Uzivatele_Alba1_idx` (`Alba_id_Alba` ASC),
  CONSTRAINT `fk_Alba_has_Uzivatele_Alba1`
    FOREIGN KEY (`Alba_id_Alba`)
    REFERENCES `mydb`.`Alba` (`id_Alba`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Alba_has_Uzivatele_Uzivatele1`
    FOREIGN KEY (`Uzivatele_id_Uzivatele`)
    REFERENCES `mydb`.`Uzivatele` (`id_Uzivatele`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Oblibene_Alba`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Oblibene_Alba` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Oblibene_Alba` (
  `Alba_id_Alba` INT NOT NULL,
  `Uzivatele_id_Uzivatele` INT NOT NULL,
  `popis` VARCHAR(100) NULL,
  PRIMARY KEY (`Alba_id_Alba`, `Uzivatele_id_Uzivatele`),
  INDEX `fk_Alba_has_Uzivatele_Uzivatele2_idx` (`Uzivatele_id_Uzivatele` ASC),
  INDEX `fk_Alba_has_Uzivatele_Alba2_idx` (`Alba_id_Alba` ASC),
  CONSTRAINT `fk_Alba_has_Uzivatele_Alba2`
    FOREIGN KEY (`Alba_id_Alba`)
    REFERENCES `mydb`.`Alba` (`id_Alba`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Alba_has_Uzivatele_Uzivatele2`
    FOREIGN KEY (`Uzivatele_id_Uzivatele`)
    REFERENCES `mydb`.`Uzivatele` (`id_Uzivatele`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Oblibene_Skladby`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Oblibene_Skladby` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Oblibene_Skladby` (
  `Uzivatele_id_Uzivatele` INT NOT NULL,
  `Skladby_id_Skladby` INT NOT NULL,
  `popis` VARCHAR(100) NULL,
  PRIMARY KEY (`Uzivatele_id_Uzivatele`, `Skladby_id_Skladby`),
  INDEX `fk_Uzivatele_has_Skladby_Skladby1_idx` (`Skladby_id_Skladby` ASC),
  INDEX `fk_Uzivatele_has_Skladby_Uzivatele1_idx` (`Uzivatele_id_Uzivatele` ASC),
  CONSTRAINT `fk_Uzivatele_has_Skladby_Uzivatele1`
    FOREIGN KEY (`Uzivatele_id_Uzivatele`)
    REFERENCES `mydb`.`Uzivatele` (`id_Uzivatele`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Uzivatele_has_Skladby_Skladby1`
    FOREIGN KEY (`Skladby_id_Skladby`)
    REFERENCES `mydb`.`Skladby` (`id_Skladby`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Fotografie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Fotografie` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Fotografie` (
  `id_Fotografie` INT NOT NULL,
  `adresa` VARCHAR(255) NOT NULL,
  `popis` VARCHAR(200) NULL,
  `autor` VARCHAR(100) NULL,
  PRIMARY KEY (`id_Fotografie`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Fotografie_spojova`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Fotografie_spojova` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Fotografie_spojova` (
  `Fotografie_id_Fotografie` INT NOT NULL,
  `entita_id` INT NOT NULL,
  `typ` ENUM('id_vydavatel','id_alba','id_skupiny','id_clenove') NOT NULL,
  PRIMARY KEY (`Fotografie_id_Fotografie`, `typ`, `entita_id`),
  INDEX `fk_Fotografie_has_Vydavatele_Fotografie1_idx` (`Fotografie_id_Fotografie` ASC),
  INDEX `fk_Fotografie_has_Vydavatele_Alba1_idx` (`entita_id` ASC),
  CONSTRAINT `fk_Fotografie_has_Vydavatele_Fotografie1`
    FOREIGN KEY (`Fotografie_id_Fotografie`)
    REFERENCES `mydb`.`Fotografie` (`id_Fotografie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Fotografie_has_Vydavatele_Vydavatele1`
    FOREIGN KEY (`entita_id`)
    REFERENCES `mydb`.`Vydavatele` (`id_Vydavatel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Fotografie_has_Vydavatele_Skladby1`
    FOREIGN KEY (`entita_id`)
    REFERENCES `mydb`.`Skladby` (`id_Skladby`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Fotografie_has_Vydavatele_Alba1`
    FOREIGN KEY (`entita_id`)
    REFERENCES `mydb`.`Alba` (`id_Alba`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Fotografie_spojova_Clenove`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Fotografie_spojova_Clenove` ;

CREATE TABLE IF NOT EXISTS `mydb`.`Fotografie_spojova_Clenove` (
  `Fotografie_spojova_Fotografie_id_Fotografie` INT NOT NULL,
  `Fotografie_spojova_entita_id` INT NOT NULL,
  `Fotografie_spojova_typ` ENUM('id_vydavatel','id_alba','id_skupiny','id_clenove') NOT NULL,
  `Clenove_id_Clenove` INT NOT NULL,
  PRIMARY KEY (`Fotografie_spojova_Fotografie_id_Fotografie`, `Fotografie_spojova_entita_id`, `Fotografie_spojova_typ`, `Clenove_id_Clenove`),
  INDEX `fk_Fotografie_spojova_has_Clenove_Clenove1_idx` (`Clenove_id_Clenove` ASC),
  CONSTRAINT `fk_Fotografie_spojova_has_Clenove_Fotografie_spojova1`
    FOREIGN KEY (`Fotografie_spojova_Fotografie_id_Fotografie`)
    REFERENCES `mydb`.`Fotografie_spojova` (`Fotografie_id_Fotografie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Fotografie_spojova_has_Clenove_Clenove1`
    FOREIGN KEY (`Clenove_id_Clenove`)
    REFERENCES `mydb`.`Clenove` (`id_Clenove`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
