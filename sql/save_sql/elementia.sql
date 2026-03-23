-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 23 mars 2026 à 14:02
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `elementia`
--

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

DROP TABLE IF EXISTS `comptes`;
CREATE TABLE IF NOT EXISTS `comptes` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `derniere_connexion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`id`, `pseudo`, `mot_de_passe`, `date_creation`, `derniere_connexion`) VALUES
(1, 'test', '$2y$10$0bLEeM2disvIz3zUaZI9N.CD2DjubHsq9d3zROnUQDJYqVDl3rXlm', '2026-03-23 09:50:44', '2026-03-23 11:15:14');

-- --------------------------------------------------------

--
-- Structure de la table `personnages`
--

DROP TABLE IF EXISTS `personnages`;
CREATE TABLE IF NOT EXISTS `personnages` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `compte_id` int UNSIGNED NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `element` enum('Feu','Eau','Air','Terre') COLLATE utf8mb4_unicode_ci NOT NULL,
  `portrait` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region_depart` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position_x` int NOT NULL DEFAULT '0',
  `position_y` int NOT NULL DEFAULT '0',
  `niveau` int NOT NULL DEFAULT '1',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `classe` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `point_de_vie` int NOT NULL DEFAULT '0',
  `attaque` int NOT NULL DEFAULT '0',
  `magie` int NOT NULL DEFAULT '0',
  `agilite` int NOT NULL DEFAULT '0',
  `intelligence` int NOT NULL DEFAULT '0',
  `synchronisation_elementaire` int NOT NULL DEFAULT '0',
  `critique` int NOT NULL DEFAULT '0',
  `dexterite` int NOT NULL DEFAULT '0',
  `defense` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_personnages_compte_id` (`compte_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personnages`
--

INSERT INTO `personnages` (`id`, `compte_id`, `nom`, `element`, `portrait`, `region_depart`, `position_x`, `position_y`, `niveau`, `date_creation`, `classe`, `sexe`, `point_de_vie`, `attaque`, `magie`, `agilite`, `intelligence`, `synchronisation_elementaire`, `critique`, `dexterite`, `defense`) VALUES
(3, 1, 'test', 'Feu', 'ressources/images/portraits/villagois/villagois_adulte_garcon_A.png', 'Ignivar', 0, 0, 1, '2026-03-23 13:04:29', 'Tank', 'homme', 30, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `personnage_competences`
--

DROP TABLE IF EXISTS `personnage_competences`;
CREATE TABLE IF NOT EXISTS `personnage_competences` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `personnage_id` int UNSIGNED NOT NULL,
  `nom_competence` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_competence` enum('elementaire','neutre') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordre_affichage` int NOT NULL DEFAULT '1',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_personnage_competences_personnage_id` (`personnage_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personnage_competences`
--

INSERT INTO `personnage_competences` (`id`, `personnage_id`, `nom_competence`, `type_competence`, `ordre_affichage`, `date_creation`) VALUES
(15, 3, 'Feu - Tank - Éclat primaire', 'elementaire', 1, '2026-03-23 13:04:29'),
(16, 3, 'Feu - Tank - Lame ancestrale', 'elementaire', 2, '2026-03-23 13:04:29'),
(17, 3, 'Feu - Tank - Marque sacrée', 'elementaire', 3, '2026-03-23 13:04:29'),
(18, 3, 'Feu - Tank - Nexus intérieur', 'elementaire', 4, '2026-03-23 13:04:29'),
(19, 3, 'Observation calme', 'neutre', 5, '2026-03-23 13:04:30'),
(20, 3, 'Méditation guidée', 'neutre', 6, '2026-03-23 13:04:30'),
(21, 3, 'Volonté stable', 'neutre', 7, '2026-03-23 13:04:30');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `personnages`
--
ALTER TABLE `personnages`
  ADD CONSTRAINT `fk_personnages_compte` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `personnage_competences`
--
ALTER TABLE `personnage_competences`
  ADD CONSTRAINT `fk_personnage_competences_personnage` FOREIGN KEY (`personnage_id`) REFERENCES `personnages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
