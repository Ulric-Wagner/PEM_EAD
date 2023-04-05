-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 05 avr. 2023 à 22:11
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `administrateurs`
--

INSERT INTO `administrateurs` (`AID`, `UID`) VALUES
(2, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `copies`
--

INSERT INTO `copies` (`ERID`, `EAID`, `UID`, `Note`, `Path`, `Date`) VALUES
(10, 2, 2, NULL, NULL, '2023-04-05 23:50:07'),
(11, 2, 2, NULL, NULL, '2023-04-05 23:50:14'),
(12, 2, 2, NULL, NULL, '2023-04-05 23:50:32'),
(13, 2, 2, NULL, NULL, '2023-04-05 23:52:38'),
(14, 2, 2, NULL, NULL, '2023-04-05 23:52:46'),
(15, 2, 2, NULL, NULL, '2023-04-05 23:54:15'),
(16, 2, 2, NULL, NULL, '2023-04-05 23:54:18'),
(17, 2, 2, NULL, NULL, '2023-04-05 23:54:32'),
(18, 2, 2, NULL, NULL, '2023-04-05 23:58:51'),
(19, 2, 2, NULL, NULL, '2023-04-05 23:58:58'),
(20, 2, 2, NULL, NULL, '2023-04-06 00:01:10'),
(21, 2, 2, NULL, NULL, '2023-04-06 00:01:56'),
(22, 2, 2, NULL, NULL, '2023-04-06 00:06:49'),
(23, 2, 2, NULL, NULL, '2023-04-06 00:07:13');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`CID`, `Cours`, `GID`) VALUES
(1, 'CSUP CYBER', 1),
(2, 'BAT SYNUM', 1),
(3, 'BS OPS', 2),
(4, 'CSUP TECHOPS', 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `documents`
--

INSERT INTO `documents` (`DID`, `Document`, `Description`, `MID`, `FID`, `statut`) VALUES
(1, 'Pare-feu', 'il s&amp;#039agit d&amp;#039un cours sur les pare-feu', 1, 1, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `evals`
--

INSERT INTO `evals` (`EAID`, `ETID`, `PID`, `Statut`) VALUES
(2, 16, 1, 1);

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

--
-- Déchargement des données de la table `evaltemplates`
--

INSERT INTO `evaltemplates` (`ETID`, `Eval`, `Description`, `MID`) VALUES
(16, 'Test de bon fonctionement', 'petit devoir', 1);

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

--
-- Déchargement des données de la table `fichiers`
--

INSERT INTO `fichiers` (`FID`, `Fichier`, `Type`, `GID`, `Path`, `Poster`) VALUES
(1, 'RSEC_FW.pptx', 'pptx', 2, 'files/RSEC_FW.pptx', 'M. BAH Alfa');

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

--
-- Déchargement des données de la table `groupements`
--

INSERT INTO `groupements` (`GID`, `Groupement`) VALUES
(2, 'OPS'),
(1, 'SIC');

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

--
-- Déchargement des données de la table `instructeurs`
--

INSERT INTO `instructeurs` (`IID`, `UID`, `GID`) VALUES
(23, 1, 1),
(28, 3, 1),
(29, 3, 1),
(30, 3, 2),
(31, 3, 1),
(32, 3, 2);

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

--
-- Déchargement des données de la table `matieres`
--

INSERT INTO `matieres` (`MID`, `Matiere`, `CID`) VALUES
(1, 'PARE-FEU', 1),
(2, 'LINUX', 4);

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

--
-- Déchargement des données de la table `pilotes`
--

INSERT INTO `pilotes` (`PILID`, `UID`, `CID`) VALUES
(19, 1, 1);

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

--
-- Déchargement des données de la table `promotions`
--

INSERT INTO `promotions` (`PID`, `CID`, `Promotion`) VALUES
(1, 1, '22.1'),
(2, 2, '23.1'),
(3, 4, '22.1');

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

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`QID`, `ETID`, `Question`) VALUES
(2, 16, 'quel est le role d&amp;#039un pare-feu?'),
(3, 16, 'dans cette liste cochez les pare-feu:');

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

--
-- Déchargement des données de la table `reponses`
--

INSERT INTO `reponses` (`RID`, `QID`, `Reponse`, `Points`) VALUES
(13, 2, 'un puissant sort de mage', -0.5),
(14, 2, 's&amp;#039interfacer en coupure entre deux réseau afin de filtrer le trafic', 1),
(15, 2, 'filtrer des url', -0.5),
(17, 3, 'ALCAZAR', -0.5),
(18, 3, 'PFSENSE', 1);

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

--
-- Déchargement des données de la table `students`
--

INSERT INTO `students` (`SID`, `UID`, `PID`) VALUES
(20, 2, 3);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

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
