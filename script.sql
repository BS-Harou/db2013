-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2013 at 11:27 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `martinkadleceu3`
--

-- --------------------------------------------------------

--
-- Table structure for table `Alba`
--

CREATE TABLE IF NOT EXISTS `Alba` (
  `id_Alba` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `obal` tinytext COLLATE utf8_czech_ci,
  `datum_vydani` datetime DEFAULT NULL,
  `delka_alba` varchar(45) COLLATE utf8_czech_ci DEFAULT NULL,
  `id_Skupiny` int(11) NOT NULL,
  `id_Vydavatel` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_Alba`),
  KEY `fk_Alba_Skupiny1_idx` (`id_Skupiny`),
  KEY `fk_Alba_Vydavatele1_idx` (`id_Vydavatel`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Alba`
--


-- --------------------------------------------------------

--
-- Table structure for table `Clenove`
--

CREATE TABLE IF NOT EXISTS `Clenove` (
  `id_Clenove` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `datum_narozeni` datetime DEFAULT NULL,
  `misto_narozeni` varchar(45) COLLATE utf8_czech_ci DEFAULT NULL,
  `datum_umrti` datetime DEFAULT NULL,
  `historie` text COLLATE utf8_czech_ci,
  `www` varchar(200) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_Clenove`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Clenove`
--


-- --------------------------------------------------------

--
-- Table structure for table `Fotografie`
--

CREATE TABLE IF NOT EXISTS `Fotografie` (
  `id_Fotografie` int(11) NOT NULL AUTO_INCREMENT,
  `adresa` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `popis` varchar(200) COLLATE utf8_czech_ci DEFAULT NULL,
  `autor` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_Fotografie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Fotografie_spojova`
--

CREATE TABLE IF NOT EXISTS `Fotografie_spojova` (
  `id_Fotografie` int(11) NOT NULL,
  `typ` enum('id_vydavatel','id_alba','id_skupiny','id_clenove') COLLATE utf8_czech_ci NOT NULL,
  `id_entita` int(11) NOT NULL,
  PRIMARY KEY (`id_Fotografie`,`typ`,`id_entita`),
  KEY `fk_Fotografie_spojova_Skladby1_idx` (`id_entita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Fotografie_spojova_Clenove`
--

CREATE TABLE IF NOT EXISTS `Fotografie_spojova_Clenove` (
  `id_Clenove` int(11) NOT NULL,
  `id_Fotografie` int(11) NOT NULL,
  `typ` enum('id_vydavatel','id_alba','id_skupiny','id_clenove') COLLATE utf8_czech_ci NOT NULL,
  `id_entita` int(11) NOT NULL,
  PRIMARY KEY (`id_Clenove`,`id_Fotografie`,`typ`,`id_entita`),
  KEY `fk_Fotografie_spojova_has_Clenove_Clenove1_idx` (`id_Clenove`),
  KEY `fk_Fotografie_spojova_Clenove_Fotografie_spojova1_idx` (`id_Fotografie`,`typ`,`id_entita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Hodnoceni_alb`
--

CREATE TABLE IF NOT EXISTS `Hodnoceni_alb` (
  `id_Alba` int(11) NOT NULL,
  `id_Uzivatele` int(11) NOT NULL,
  `hodnoceni` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_Alba`,`id_Uzivatele`),
  KEY `fk_Alba_has_Uzivatele_Uzivatele1_idx` (`id_Uzivatele`),
  KEY `fk_Alba_has_Uzivatele_Alba1_idx` (`id_Alba`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Hodnoceni_clenu`
--

CREATE TABLE IF NOT EXISTS `Hodnoceni_clenu` (
  `id_Clenove` int(11) NOT NULL,
  `id_Uzivatele` int(11) NOT NULL,
  `hodnoceni` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_Clenove`,`id_Uzivatele`),
  KEY `fk_Clenove_has_Uzivatele_Uzivatele1_idx` (`id_Uzivatele`),
  KEY `fk_Clenove_has_Uzivatele_Clenove1_idx` (`id_Clenove`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Hodnoceni_skladeb`
--

CREATE TABLE IF NOT EXISTS `Hodnoceni_skladeb` (
  `id_Skladby` int(11) NOT NULL,
  `id_Uzivatele` int(11) NOT NULL,
  `hodnoceni` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_Skladby`,`id_Uzivatele`),
  KEY `fk_Skladby_has_Uzivatele_Uzivatele1_idx` (`id_Uzivatele`),
  KEY `fk_Skladby_has_Uzivatele_Skladby1_idx` (`id_Skladby`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Hodnoceni_Skupin`
--

CREATE TABLE IF NOT EXISTS `Hodnoceni_Skupin` (
  `id_Skupiny` int(11) NOT NULL,
  `id_Uzivatele` int(11) NOT NULL,
  `hodnoceni` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_Skupiny`,`id_Uzivatele`),
  KEY `fk_Skupiny_has_Uzivatele_Uzivatele1_idx` (`id_Uzivatele`),
  KEY `fk_Skupiny_has_Uzivatele_Skupiny1_idx` (`id_Skupiny`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Nastroje`
--

CREATE TABLE IF NOT EXISTS `Nastroje` (
  `id_Nastroje` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(45) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_Nastroje`),
  UNIQUE KEY `nazev` (`nazev`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Nastroje_Clenove`
--

CREATE TABLE IF NOT EXISTS `Nastroje_Clenove` (
  `id_Nastroje` int(11) NOT NULL,
  `id_Clenove` int(11) NOT NULL,
  PRIMARY KEY (`id_Nastroje`,`id_Clenove`),
  KEY `fk_Nastroje_has_Clenove_Clenove1_idx` (`id_Clenove`),
  KEY `fk_Nastroje_has_Clenove_Nastroje1_idx` (`id_Nastroje`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Oblibene_Alba`
--

CREATE TABLE IF NOT EXISTS `Oblibene_Alba` (
  `id_Alba` int(11) NOT NULL,
  `id_Uzivatele` int(11) NOT NULL,
  `popis` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_Alba`,`id_Uzivatele`),
  KEY `fk_Alba_has_Uzivatele_Uzivatele2_idx` (`id_Uzivatele`),
  KEY `fk_Alba_has_Uzivatele_Alba2_idx` (`id_Alba`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Oblibene_Clenove`
--

CREATE TABLE IF NOT EXISTS `Oblibene_Clenove` (
  `id_Uzivatele` int(11) NOT NULL,
  `id_Clenove` int(11) NOT NULL,
  `popis` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_Uzivatele`,`id_Clenove`),
  KEY `fk_Uzivatele_has_Clenove_Clenove1_idx` (`id_Clenove`),
  KEY `fk_Uzivatele_has_Clenove_Uzivatele1_idx` (`id_Uzivatele`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Oblibene_Skladby`
--

CREATE TABLE IF NOT EXISTS `Oblibene_Skladby` (
  `id_Uzivatele` int(11) NOT NULL,
  `id_Skladby` int(11) NOT NULL,
  `popis` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_Uzivatele`,`id_Skladby`),
  KEY `fk_Uzivatele_has_Skladby_Skladby1_idx` (`id_Skladby`),
  KEY `fk_Uzivatele_has_Skladby_Uzivatele1_idx` (`id_Uzivatele`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Oblibene_Skupiny`
--

CREATE TABLE IF NOT EXISTS `Oblibene_Skupiny` (
  `id_Uzivatele` int(11) NOT NULL,
  `id_Skupiny` int(11) NOT NULL,
  `popis` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_Uzivatele`,`id_Skupiny`),
  KEY `fk_Uzivatele_has_Skupiny_Skupiny1_idx` (`id_Skupiny`),
  KEY `fk_Uzivatele_has_Skupiny_Uzivatele1_idx` (`id_Uzivatele`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

CREATE TABLE IF NOT EXISTS `Role` (
  `id_Role` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(45) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_Role`),
  UNIQUE KEY `nazev` (`nazev`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Role`
--

INSERT INTO `Role` (`id_Role`, `nazev`) VALUES
(3, 'administrator'),
(2, 'moderator'),
(1, 'uzivatel');

-- --------------------------------------------------------

--
-- Table structure for table `Skladby`
--

CREATE TABLE IF NOT EXISTS `Skladby` (
  `id_Skladby` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `delka` time NOT NULL,
  `text` text COLLATE utf8_czech_ci,
  `youtube` varchar(200) COLLATE utf8_czech_ci DEFAULT NULL,
  `id_Alba` int(11) NOT NULL,
  PRIMARY KEY (`id_Skladby`),
  KEY `fk_Skladby_Alba1_idx` (`id_Alba`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Skladby`
--


-- --------------------------------------------------------

--
-- Table structure for table `Skladby_Clenove`
--

CREATE TABLE IF NOT EXISTS `Skladby_Clenove` (
  `id_Skladby` int(11) NOT NULL,
  `id_Clenove` int(11) NOT NULL,
  PRIMARY KEY (`id_Skladby`,`id_Clenove`),
  KEY `fk_Skladby_has_Clenove_Clenove1_idx` (`id_Clenove`),
  KEY `fk_Skladby_has_Clenove_Skladby1_idx` (`id_Skladby`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Skupiny`
--

CREATE TABLE IF NOT EXISTS `Skupiny` (
  `id_Skupiny` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(45) COLLATE utf8_czech_ci DEFAULT NULL,
  `rok_zalozeni` year(4) DEFAULT NULL,
  `historie` text COLLATE utf8_czech_ci,
  `www` varchar(200) COLLATE utf8_czech_ci DEFAULT NULL,
  `foto` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_Skupiny`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `Skupiny`
--


-- --------------------------------------------------------

--
-- Table structure for table `Skupiny_Clenove`
--

CREATE TABLE IF NOT EXISTS `Skupiny_Clenove` (
  `id_Skupiny` int(11) NOT NULL,
  `id_Clenove` int(11) NOT NULL,
  `aktivni` tinyint(1) DEFAULT NULL,
  `rok_zacatku` year(4) DEFAULT NULL,
  `rok_konce` year(4) DEFAULT NULL,
  PRIMARY KEY (`id_Skupiny`,`id_Clenove`),
  KEY `fk_Skupiny_has_Clenove_Clenove1_idx` (`id_Clenove`),
  KEY `fk_Skupiny_has_Clenove_Skupiny_idx` (`id_Skupiny`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- Table structure for table `Uzivatele`
--

CREATE TABLE IF NOT EXISTS `Uzivatele` (
  `id_Uzivatele` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `jmeno` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `mail` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `icq` varchar(45) COLLATE utf8_czech_ci DEFAULT NULL,
  `heslo` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `datum_registrace` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_Role` int(11) NOT NULL,
  PRIMARY KEY (`id_Uzivatele`),
  UNIQUE KEY `nickname_UNIQUE` (`nickname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Uzivatele`
--

INSERT INTO `Uzivatele` (`id_Uzivatele`, `nickname`, `jmeno`, `prijmeni`, `mail`, `icq`, `heslo`, `datum_registrace`, `id_Role`) VALUES
(2, 'test7', '', '', 'test7@heslo.db', '', '955db0b81ef1989b4a4dfeae8061a9a6', '2013-12-01 11:52:44', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Vydavatele`
--

CREATE TABLE IF NOT EXISTS `Vydavatele` (
  `id_Vydavatel` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` text COLLATE utf8_czech_ci NOT NULL,
  `popis` text COLLATE utf8_czech_ci,
  `datum_zalozeni` date DEFAULT NULL,
  PRIMARY KEY (`id_Vydavatel`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Vydavatele`
--


-- --------------------------------------------------------

--
-- Table structure for table `Zadosti`
--

CREATE TABLE IF NOT EXISTS `Zadosti` (
  `id_Zadosti` int(11) NOT NULL AUTO_INCREMENT,
  `datum` datetime NOT NULL,
  `zpracovano` tinyint(1) DEFAULT NULL,
  `schvaleno` tinyint(1) DEFAULT NULL,
  `id_Uzivatele` int(11) NOT NULL,
  PRIMARY KEY (`id_Zadosti`),
  KEY `fk_Zadosti_Uzivatele1_idx` (`id_Uzivatele`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=6 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Alba`
--
ALTER TABLE `Alba`
  ADD CONSTRAINT `fk_Alba_Skupiny1` FOREIGN KEY (`id_Skupiny`) REFERENCES `Skupiny` (`id_Skupiny`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Alba_Vydavatele1` FOREIGN KEY (`id_Vydavatel`) REFERENCES `Vydavatele` (`id_Vydavatel`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Fotografie_spojova`
--
ALTER TABLE `Fotografie_spojova`
  ADD CONSTRAINT `fk_Fotografie_spojova_Fotografie1` FOREIGN KEY (`id_Fotografie`) REFERENCES `Fotografie` (`id_Fotografie`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Fotografie_spojova_Skladby1` FOREIGN KEY (`id_entita`) REFERENCES `Skladby` (`id_Skladby`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Fotografie_spojova_Vydavatele1` FOREIGN KEY (`id_entita`) REFERENCES `Vydavatele` (`id_Vydavatel`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Fotografie_spojova_Skupiny1` FOREIGN KEY (`id_entita`) REFERENCES `Skupiny` (`id_Skupiny`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Fotografie_spojova_Clenove`
--
ALTER TABLE `Fotografie_spojova_Clenove`
  ADD CONSTRAINT `fk_Fotografie_spojova_has_Clenove_Clenove1` FOREIGN KEY (`id_Clenove`) REFERENCES `Clenove` (`id_Clenove`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Fotografie_spojova_Clenove_Fotografie_spojova1` FOREIGN KEY (`id_Fotografie`, `typ`, `id_entita`) REFERENCES `Fotografie_spojova` (`id_Fotografie`, `typ`, `id_entita`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Hodnoceni_alb`
--
ALTER TABLE `Hodnoceni_alb`
  ADD CONSTRAINT `fk_Alba_has_Uzivatele_Alba1` FOREIGN KEY (`id_Alba`) REFERENCES `Alba` (`id_Alba`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Alba_has_Uzivatele_Uzivatele1` FOREIGN KEY (`id_Uzivatele`) REFERENCES `Uzivatele` (`id_Uzivatele`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Hodnoceni_clenu`
--
ALTER TABLE `Hodnoceni_clenu`
  ADD CONSTRAINT `fk_Clenove_has_Uzivatele_Clenove1` FOREIGN KEY (`id_Clenove`) REFERENCES `Clenove` (`id_Clenove`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Clenove_has_Uzivatele_Uzivatele1` FOREIGN KEY (`id_Uzivatele`) REFERENCES `Uzivatele` (`id_Uzivatele`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Hodnoceni_skladeb`
--
ALTER TABLE `Hodnoceni_skladeb`
  ADD CONSTRAINT `fk_Skladby_has_Uzivatele_Skladby1` FOREIGN KEY (`id_Skladby`) REFERENCES `Skladby` (`id_Skladby`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Skladby_has_Uzivatele_Uzivatele1` FOREIGN KEY (`id_Uzivatele`) REFERENCES `Uzivatele` (`id_Uzivatele`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Hodnoceni_Skupin`
--
ALTER TABLE `Hodnoceni_Skupin`
  ADD CONSTRAINT `fk_Skupiny_has_Uzivatele_Skupiny1` FOREIGN KEY (`id_Skupiny`) REFERENCES `Skupiny` (`id_Skupiny`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Skupiny_has_Uzivatele_Uzivatele1` FOREIGN KEY (`id_Uzivatele`) REFERENCES `Uzivatele` (`id_Uzivatele`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Nastroje_Clenove`
--
ALTER TABLE `Nastroje_Clenove`
  ADD CONSTRAINT `fk_Nastroje_has_Clenove_Nastroje1` FOREIGN KEY (`id_Nastroje`) REFERENCES `Nastroje` (`id_Nastroje`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Nastroje_has_Clenove_Clenove1` FOREIGN KEY (`id_Clenove`) REFERENCES `Clenove` (`id_Clenove`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Oblibene_Alba`
--
ALTER TABLE `Oblibene_Alba`
  ADD CONSTRAINT `fk_Alba_has_Uzivatele_Alba2` FOREIGN KEY (`id_Alba`) REFERENCES `Alba` (`id_Alba`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Alba_has_Uzivatele_Uzivatele2` FOREIGN KEY (`id_Uzivatele`) REFERENCES `Uzivatele` (`id_Uzivatele`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Oblibene_Clenove`
--
ALTER TABLE `Oblibene_Clenove`
  ADD CONSTRAINT `fk_Uzivatele_has_Clenove_Uzivatele1` FOREIGN KEY (`id_Uzivatele`) REFERENCES `Uzivatele` (`id_Uzivatele`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Uzivatele_has_Clenove_Clenove1` FOREIGN KEY (`id_Clenove`) REFERENCES `Clenove` (`id_Clenove`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Oblibene_Skladby`
--
ALTER TABLE `Oblibene_Skladby`
  ADD CONSTRAINT `fk_Uzivatele_has_Skladby_Uzivatele1` FOREIGN KEY (`id_Uzivatele`) REFERENCES `Uzivatele` (`id_Uzivatele`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Uzivatele_has_Skladby_Skladby1` FOREIGN KEY (`id_Skladby`) REFERENCES `Skladby` (`id_Skladby`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Oblibene_Skupiny`
--
ALTER TABLE `Oblibene_Skupiny`
  ADD CONSTRAINT `fk_Uzivatele_has_Skupiny_Uzivatele1` FOREIGN KEY (`id_Uzivatele`) REFERENCES `Uzivatele` (`id_Uzivatele`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Uzivatele_has_Skupiny_Skupiny1` FOREIGN KEY (`id_Skupiny`) REFERENCES `Skupiny` (`id_Skupiny`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Skladby`
--
ALTER TABLE `Skladby`
  ADD CONSTRAINT `fk_Skladby_Alba1` FOREIGN KEY (`id_Alba`) REFERENCES `Alba` (`id_Alba`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Skladby_Clenove`
--
ALTER TABLE `Skladby_Clenove`
  ADD CONSTRAINT `fk_Skladby_has_Clenove_Skladby1` FOREIGN KEY (`id_Skladby`) REFERENCES `Skladby` (`id_Skladby`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Skladby_has_Clenove_Clenove1` FOREIGN KEY (`id_Clenove`) REFERENCES `Clenove` (`id_Clenove`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Skupiny_Clenove`
--
ALTER TABLE `Skupiny_Clenove`
  ADD CONSTRAINT `fk_Skupiny_has_Clenove_Skupiny` FOREIGN KEY (`id_Skupiny`) REFERENCES `Skupiny` (`id_Skupiny`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Skupiny_has_Clenove_Clenove1` FOREIGN KEY (`id_clenove`) REFERENCES `Clenove` (`id_Clenove`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Zadosti`
--
ALTER TABLE `Zadosti`
  ADD CONSTRAINT `fk_Zadosti_Uzivatele1` FOREIGN KEY (`id_Uzivatele`) REFERENCES `Uzivatele` (`id_Uzivatele`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
