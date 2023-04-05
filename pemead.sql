-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 05 avr. 2023 à 23:02
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Structure de la table `copies`
--

DROP TABLE IF EXISTS `copies`;
CREATE TABLE IF NOT EXISTS `copies` (
  `ERID` int(255) NOT NULL AUTO_INCREMENT,
  `EAID` int(255) DEFAULT NULL,
  `UID` int(255) DEFAULT NULL,
  `Note` float DEFAULT NULL,
  `Path` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ERID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `CID` int(255) NOT NULL AUTO_INCREMENT,
  `Cours` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `GID` int(255) DEFAULT NULL,
  PRIMARY KEY (`CID`),
  UNIQUE KEY `Cours` (`Cours`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `DID` int(255) NOT NULL AUTO_INCREMENT,
  `Document` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `Description` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `MID` int(255) DEFAULT NULL,
  `FID` int(255) DEFAULT NULL,
  `statut` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`DID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Structure de la table `evals`
--

DROP TABLE IF EXISTS `evals`;
CREATE TABLE IF NOT EXISTS `evals` (
  `EAID` int(255) NOT NULL AUTO_INCREMENT,
  `ETID` int(255) DEFAULT NULL,
  `PID` int(255) DEFAULT NULL,
  `Statut` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`EAID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Structure de la table `evaltemplates`
--

DROP TABLE IF EXISTS `evaltemplates`;
CREATE TABLE IF NOT EXISTS `evaltemplates` (
  `ETID` int(255) NOT NULL AUTO_INCREMENT,
  `Eval` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `Description` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `MID` int(255) DEFAULT NULL,
  PRIMARY KEY (`ETID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Structure de la table `fichiers`
--

DROP TABLE IF EXISTS `fichiers`;
CREATE TABLE IF NOT EXISTS `fichiers` (
  `FID` int(255) NOT NULL AUTO_INCREMENT,
  `Fichier` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `Type` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `GID` int(255) DEFAULT NULL,
  `Path` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `Poster` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`FID`),
  UNIQUE KEY `Path` (`Path`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Structure de la table `groupements`
--

DROP TABLE IF EXISTS `groupements`;
CREATE TABLE IF NOT EXISTS `groupements` (
  `GID` int(255) NOT NULL AUTO_INCREMENT,
  `Groupement` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`GID`),
  UNIQUE KEY `Groupement` (`Groupement`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

DROP TABLE IF EXISTS `matieres`;
CREATE TABLE IF NOT EXISTS `matieres` (
  `MID` int(255) NOT NULL AUTO_INCREMENT,
  `Matiere` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `CID` int(255) DEFAULT NULL,
  PRIMARY KEY (`MID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE IF NOT EXISTS `promotions` (
  `PID` int(255) NOT NULL AUTO_INCREMENT,
  `CID` int(255) DEFAULT NULL,
  `Promotion` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`PID`),
  UNIQUE KEY `CID` (`CID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `QID` int(255) NOT NULL AUTO_INCREMENT,
  `ETID` int(255) DEFAULT NULL,
  `Question` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`QID`),
  KEY `QETID` (`ETID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

DROP TABLE IF EXISTS `reponses`;
CREATE TABLE IF NOT EXISTS `reponses` (
  `RID` int(255) NOT NULL AUTO_INCREMENT,
  `QID` int(255) DEFAULT NULL,
  `Reponse` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `Points` float DEFAULT NULL,
  PRIMARY KEY (`RID`),
  KEY `QQID` (`QID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UID` int(255) NOT NULL AUTO_INCREMENT,
  `Grade` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `Nom` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `Prenom` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `Matricule` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `DateOfBirth` datetime DEFAULT NULL,
  `Mail` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `Sha256` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `Statut` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UID`),
  UNIQUE KEY `Mail` (`Mail`),
  UNIQUE KEY `Matricule` (`Matricule`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`ETID`) REFERENCES `evaltemplates` (`ETID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD CONSTRAINT `reponses_ibfk_1` FOREIGN KEY (`QID`) REFERENCES `questions` (`QID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
