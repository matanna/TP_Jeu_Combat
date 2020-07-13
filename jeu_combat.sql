-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  lun. 13 juil. 2020 à 18:38
-- Version du serveur :  8.0.18
-- Version de PHP :  7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `jeu_combat`
--

-- --------------------------------------------------------

--
-- Structure de la table `personnage`
--

DROP TABLE IF EXISTS `personnage`;
CREATE TABLE IF NOT EXISTS `personnage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `forcePerso` int(11) NOT NULL,
  `degats` int(11) NOT NULL,
  `niveau` int(11) NOT NULL,
  `experience` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `personnage`
--

INSERT INTO `personnage` (`id`, `nom`, `forcePerso`, `degats`, `niveau`, `experience`) VALUES
(1, 'Matanna2', 50, 0, 3, 154),
(2, 'Lilou3', 25, 12, 8, 268),
(3, 'Mya25', 65, 2, 1, 52),
(4, 'TataNana', 1, 89, 1, 6);

-- --------------------------------------------------------

--
-- Structure de la table `personnages`
--

DROP TABLE IF EXISTS `personnages`;
CREATE TABLE IF NOT EXISTS `personnages` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `degats` tinyint(3) NOT NULL DEFAULT '0',
  `type` enum('magicien','guerrier','','') NOT NULL,
  `atout` tinyint(3) NOT NULL,
  `reveil` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `personnages`
--

INSERT INTO `personnages` (`id`, `nom`, `degats`, `type`, `atout`, `reveil`) VALUES
(67, 'Sarouman', 20, 'magicien', 4, 1594553733),
(61, 'Mathieu', 80, 'magicien', 1, 1594637991),
(75, 'Angie', 0, 'guerrier', 4, 0),
(58, 'oiuuy', 69, 'guerrier', 2, 1594637867),
(66, 'Gandalf', 45, 'magicien', 3, 0),
(65, 'debile', 9, 'guerrier', 4, 1594553708),
(68, 'Red Dead Redemption', 15, 'magicien', 4, 0),
(69, 'Mya', 33, 'guerrier', 3, 1594553732),
(70, 'Mario', 25, 'magicien', 4, 0),
(76, 'Twisty', 0, 'magicien', 4, 0),
(71, 'Anna', 1, 'guerrier', 4, 1594553653),
(72, 'Dexter', 1, 'guerrier', 4, 1594553656),
(73, 'faberger', 5, 'magicien', 4, 1594553706),
(74, 'Maya', 1, 'guerrier', 4, 0),
(77, 'chien', 0, 'guerrier', 4, 0),
(78, 'dddd', 0, 'guerrier', 4, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
