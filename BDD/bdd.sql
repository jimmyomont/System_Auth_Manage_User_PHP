-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `members`
--

-- --------------------------------------------------------

--
-- Structure de la table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `pseudo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `courriel` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Actif','Désactivé','Bloqué') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Actif',
  `profil_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profil_id` (`profil_id`)
) ;

--
-- Déchargement des données de la table `member`
--
INSERT INTO `member` (`id`, `name`, `firstname`, `pseudo`, `courriel`, `password`, `status`, `profil_id`) VALUES
(1, 'DOE', 'John', 'John92', 'John@DOE.com', '8c4790dc52bf8b18e9f0ea874491bf9d', 'Actif', 1);

-- password : johndoe1234
-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

DROP TABLE IF EXISTS `profil`;
CREATE TABLE IF NOT EXISTS `profil` (
  `id` int NOT NULL AUTO_INCREMENT,
  `level` enum('Utilisateurs','Contributeurs','Administrateur') COLLATE utf8mb4_general_ci NOT NULL,
  `type` enum('Professeur','Chercheur','Etudiant','Collaborateur','Partenaire') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `genre` enum('Homme','Femme','Neutre') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`id`, `level`, `type`, `genre`) VALUES
(1, 'Administrateur', 'Collaborateur', 'Homme');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
