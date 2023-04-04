-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 04 avr. 2023 à 11:44
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pemead`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateurs`
--

DROP TABLE IF EXISTS `administrateurs`;
CREATE TABLE IF NOT EXISTS `administrateurs` (
  `AID` int(255) NOT NULL AUTO_INCREMENT,
  `UID` int(255) DEFAULT NULL,
  PRIMARY KEY (`AID`),
  UNIQUE KEY `UID` (`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `CID` int(255) NOT NULL AUTO_INCREMENT,
  `Cours` varchar(255) DEFAULT NULL,
  `GID` int(255) DEFAULT NULL,
  PRIMARY KEY (`CID`),
  UNIQUE KEY `Cours` (`Cours`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `DID` int(255) NOT NULL AUTO_INCREMENT,
  `Document` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `MID` int(255) DEFAULT NULL,
  `FID` int(255) DEFAULT NULL,
  `statut` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`DID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `evalactives`
--

DROP TABLE IF EXISTS `evalactives`;
CREATE TABLE IF NOT EXISTS `evalactives` (
  `EAID` int(255) NOT NULL AUTO_INCREMENT,
  `ETID` int(255) DEFAULT NULL,
  `MID` int(255) DEFAULT NULL,
  `CID` int(255) DEFAULT NULL,
  `PID` int(255) DEFAULT NULL,
  PRIMARY KEY (`EAID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `evaltemplates`
--

DROP TABLE IF EXISTS `evaltemplates`;
CREATE TABLE IF NOT EXISTS `evaltemplates` (
  `ETID` int(255) NOT NULL AUTO_INCREMENT,
  `Eval` varchar(255) DEFAULT NULL,
  `MID` int(255) DEFAULT NULL,
  PRIMARY KEY (`ETID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `fichiers`
--

DROP TABLE IF EXISTS `fichiers`;
CREATE TABLE IF NOT EXISTS `fichiers` (
  `FID` int(255) NOT NULL AUTO_INCREMENT,
  `Fichier` varchar(255) DEFAULT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `GID` int(255) DEFAULT NULL,
  `Path` varchar(255) DEFAULT NULL,
  `Poster` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`FID`),
  UNIQUE KEY `Path` (`Path`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `groupements`
--

DROP TABLE IF EXISTS `groupements`;
CREATE TABLE IF NOT EXISTS `groupements` (
  `GID` int(255) NOT NULL AUTO_INCREMENT,
  `Groupement` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`GID`),
  UNIQUE KEY `Groupement` (`Groupement`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `instructeurs`
--

DROP TABLE IF EXISTS `instructeurs`;
CREATE TABLE IF NOT EXISTS `instructeurs` (
  `IID` int(255) NOT NULL AUTO_INCREMENT,
  `UID` int(255) DEFAULT NULL,
  `GID` int(255) DEFAULT NULL,
  PRIMARY KEY (`IID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

DROP TABLE IF EXISTS `matieres`;
CREATE TABLE IF NOT EXISTS `matieres` (
  `MID` int(255) NOT NULL AUTO_INCREMENT,
  `Matiere` varchar(255) DEFAULT NULL,
  `CID` int(255) DEFAULT NULL,
  PRIMARY KEY (`MID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `pilotes`
--

DROP TABLE IF EXISTS `pilotes`;
CREATE TABLE IF NOT EXISTS `pilotes` (
  `PILID` int(255) NOT NULL AUTO_INCREMENT,
  `UID` int(255) DEFAULT NULL,
  `CID` int(255) DEFAULT NULL,
  PRIMARY KEY (`PILID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE IF NOT EXISTS `promotions` (
  `PID` int(255) NOT NULL AUTO_INCREMENT,
  `CID` int(255) DEFAULT NULL,
  `Promotion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`PID`),
  UNIQUE KEY `CID` (`CID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `QID` int(255) DEFAULT NULL,
  `ETID` int(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

DROP TABLE IF EXISTS `reponses`;
CREATE TABLE IF NOT EXISTS `reponses` (
  `RID` int(255) NOT NULL AUTO_INCREMENT,
  `QID` int(255) DEFAULT NULL,
  `Points` float DEFAULT NULL,
  PRIMARY KEY (`RID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `SID` int(255) NOT NULL AUTO_INCREMENT,
  `UID` int(255) DEFAULT NULL,
  `PID` int(255) DEFAULT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UID` int(255) NOT NULL AUTO_INCREMENT,
  `Grade` varchar(255) DEFAULT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `Prenom` varchar(255) DEFAULT NULL,
  `Matricule` varchar(255) DEFAULT NULL,
  `DateOfBirth` datetime DEFAULT NULL,
  `Mail` varchar(255) DEFAULT NULL,
  `Sha256` varchar(255) DEFAULT NULL,
  `Statut` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UID`),
  UNIQUE KEY `Mail` (`Mail`),
  UNIQUE KEY `Matricule` (`Matricule`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
