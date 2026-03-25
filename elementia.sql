-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 25 mars 2026 à 12:30
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
-- Structure de la table `catalogue_competences`
--

DROP TABLE IF EXISTS `catalogue_competences`;
CREATE TABLE IF NOT EXISTS `catalogue_competences` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code_competence` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `famille_competence` enum('elementaire','ultime','neutre') COLLATE utf8mb4_unicode_ci NOT NULL,
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `classe` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jet` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_resolution` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `effet_principal` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valeur_base` int NOT NULL DEFAULT '0',
  `effet_duree` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aucun',
  `valeur_par_tour` int NOT NULL DEFAULT '0',
  `duree_tours` int NOT NULL DEFAULT '0',
  `niveau_initial` int NOT NULL DEFAULT '1',
  `niveau_max_naturel` int NOT NULL,
  `peut_devenir_ultime` tinyint(1) NOT NULL DEFAULT '0',
  `code_competence_ultime` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_competence_source` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `palier_evolution_ultime` int DEFAULT NULL,
  `cout_utilisation` int NOT NULL DEFAULT '0',
  `ressource_utilisee` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xp_gain_utilisation` int NOT NULL DEFAULT '0',
  `declencheur_progression` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'utilisation_competence',
  `deblocable_par_choix_initial` tinyint(1) NOT NULL DEFAULT '1',
  `ordre_affichage` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_competence` (`code_competence`),
  KEY `idx_catalogue_famille` (`famille_competence`),
  KEY `idx_catalogue_element` (`element`),
  KEY `idx_catalogue_classe` (`classe`),
  KEY `idx_catalogue_role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=219 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `catalogue_competences`
--

INSERT INTO `catalogue_competences` (`id`, `code_competence`, `nom`, `famille_competence`, `element`, `classe`, `role`, `resume`, `jet`, `type_resolution`, `effet_principal`, `valeur_base`, `effet_duree`, `valeur_par_tour`, `duree_tours`, `niveau_initial`, `niveau_max_naturel`, `peut_devenir_ultime`, `code_competence_ultime`, `code_competence_source`, `palier_evolution_ultime`, `cout_utilisation`, `ressource_utilisee`, `xp_gain_utilisation`, `declencheur_progression`, `deblocable_par_choix_initial`, `ordre_affichage`) VALUES
(1, 'FEU_GUERRIER_DU_FEU_001', 'Armure de braise', 'elementaire', 'Feu', 'Guerrier du Feu', 'Tank', 'Renforce le corps avec le feu', '1d20 + Défense', 'Défense', 'buff', 3, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 3, 'Énergie', 10, 'utilisation_competence', 1, 1),
(2, 'FEU_GUERRIER_DU_FEU_002', 'Frappe ardente', 'elementaire', 'Feu', 'Guerrier du Feu', 'Tank', 'Coup enflammé', '1d20 + Attaque', 'Attaque', 'degats', 6, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Énergie', 10, 'utilisation_competence', 1, 2),
(3, 'FEU_GUERRIER_DU_FEU_003', 'Aura brûlante', 'elementaire', 'Feu', 'Guerrier du Feu', 'Tank', 'Chaleur défensive autour de soi', '1d20 + Défense', 'Défense', 'reduction_degats', 2, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 4, 'Énergie', 10, 'utilisation_competence', 1, 3),
(4, 'FEU_GUERRIER_DU_FEU_004', 'Rempart de feu', 'elementaire', 'Feu', 'Guerrier du Feu', 'Tank', 'Bouclier de flammes', '1d20 + Défense', 'Défense', 'buff', 5, 'aucun', 0, 1, 1, 20, 1, 'FEU_GUERRIER_DU_FEU_U01', NULL, 20, 5, 'Énergie', 8, 'utilisation_competence', 1, 4),
(5, 'FEU_GUERRIER_DU_FEU_005', 'Provocation ardente', 'elementaire', 'Feu', 'Guerrier du Feu', 'Tank', 'Attire les ennemis', '1d20 + Défense', 'Défense', 'aggro', 1, 'aucun', 0, 1, 1, 20, 0, NULL, NULL, NULL, 5, 'Énergie', 8, 'utilisation_competence', 1, 5),
(6, 'FEU_GUERRIER_DU_FEU_006', 'Peau de lave', 'elementaire', 'Feu', 'Guerrier du Feu', 'Tank', 'Corps durci par le feu', '1d20 + Défense', 'Défense', 'reduction_degats', 4, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 6, 'Énergie', 8, 'utilisation_competence', 1, 6),
(7, 'FEU_GUERRIER_DU_FEU_007', 'Onde thermique', 'elementaire', 'Feu', 'Guerrier du Feu', 'Tank', 'Repousse les ennemis proches', '1d20 + Attaque', 'Attaque', 'degats_recul', 5, 'aucun', 0, 0, 1, 20, 1, 'FEU_GUERRIER_DU_FEU_U02', NULL, 20, 6, 'Énergie', 8, 'utilisation_competence', 1, 7),
(8, 'FEU_GUERRIER_DU_FEU_008', 'Cœur incandescent', 'elementaire', 'Feu', 'Guerrier du Feu', 'Tank', 'Renforce l’endurance', '1d20 + Défense', 'Défense', 'buff', 6, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 7, 'Énergie', 7, 'utilisation_competence', 1, 8),
(9, 'FEU_GUERRIER_DU_FEU_009', 'Mur de magma', 'elementaire', 'Feu', 'Guerrier du Feu', 'Tank', 'Protection massive', '1d20 + Défense', 'Défense', 'reduction_degats', 6, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 8, 'Énergie', 7, 'utilisation_competence', 1, 9),
(10, 'FEU_GUERRIER_DU_FEU_010', 'Avatar du brasier', 'elementaire', 'Feu', 'Guerrier du Feu', 'Tank', 'Forme défensive ultime', '1d20 + Défense', 'Défense', 'buff', 10, 'aucun', 0, 2, 1, 20, 1, 'FEU_GUERRIER_DU_FEU_U03', NULL, 20, 10, 'Énergie', 6, 'utilisation_competence', 1, 10),
(11, 'FEU_GUERRIER_DU_FEU_U01', 'Citadelle volcanique', 'ultime', 'Feu', 'Guerrier du Feu', 'Tank', 'Évolution ultime de FEU_GUERRIER_DU_FEU_004', '1d20 + Défense', 'Défense', 'buff', 12, 'aucun', 0, 2, 1, 5, 0, NULL, 'FEU_GUERRIER_DU_FEU_004', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 101),
(12, 'FEU_GUERRIER_DU_FEU_U02', 'Déflagration magmatique', 'ultime', 'Feu', 'Guerrier du Feu', 'Tank', 'Évolution ultime de FEU_GUERRIER_DU_FEU_007', '1d20 + Attaque', 'Attaque', 'degats_recul', 14, 'brulure', 4, 2, 1, 5, 0, NULL, 'FEU_GUERRIER_DU_FEU_007', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 102),
(13, 'FEU_GUERRIER_DU_FEU_U03', 'Trône du brasier éternel', 'ultime', 'Feu', 'Guerrier du Feu', 'Tank', 'Évolution ultime de FEU_GUERRIER_DU_FEU_010', '1d20 + Défense', 'Défense', 'buff', 18, 'aucun', 0, 3, 1, 5, 0, NULL, 'FEU_GUERRIER_DU_FEU_010', NULL, 12, 'Énergie', 5, 'utilisation_competence', 0, 103),
(14, 'FEU_BERSERKER_DU_FEU_001', 'Coup embrasé', 'elementaire', 'Feu', 'Berserker du Feu', 'DPS Énergie', 'Attaque enflammée', '1d20 + Attaque', 'Attaque', 'degats', 8, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Énergie', 10, 'utilisation_competence', 1, 1),
(15, 'FEU_BERSERKER_DU_FEU_002', 'Rage ardente', 'elementaire', 'Feu', 'Berserker du Feu', 'DPS Énergie', 'Augmente la puissance', '1d20 + Attaque', 'Attaque', 'buff', 3, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 4, 'Énergie', 10, 'utilisation_competence', 1, 2),
(16, 'FEU_BERSERKER_DU_FEU_003', 'Entaille brûlante', 'elementaire', 'Feu', 'Berserker du Feu', 'DPS Énergie', 'Coup rapide', '1d20 + Attaque', 'Attaque', 'degats', 9, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Énergie', 10, 'utilisation_competence', 1, 3),
(17, 'FEU_BERSERKER_DU_FEU_004', 'Frappe volcanique', 'elementaire', 'Feu', 'Berserker du Feu', 'DPS Énergie', 'Attaque lourde', '1d20 + Attaque', 'Attaque', 'degats', 12, 'aucun', 0, 0, 1, 20, 1, 'FEU_BERSERKER_DU_FEU_U01', NULL, 20, 5, 'Énergie', 8, 'utilisation_competence', 1, 4),
(18, 'FEU_BERSERKER_DU_FEU_005', 'Danse des flammes', 'elementaire', 'Feu', 'Berserker du Feu', 'DPS Énergie', 'Combo rapide', '1d20 + Agilité', 'Agilité', 'degats', 10, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Énergie', 8, 'utilisation_competence', 1, 5),
(19, 'FEU_BERSERKER_DU_FEU_006', 'Explosion de rage', 'elementaire', 'Feu', 'Berserker du Feu', 'DPS Énergie', 'Dégâts de zone', '1d20 + Attaque', 'Attaque', 'degats_zone', 10, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Énergie', 8, 'utilisation_competence', 1, 6),
(20, 'FEU_BERSERKER_DU_FEU_007', 'Lame incendiaire', 'elementaire', 'Feu', 'Berserker du Feu', 'DPS Énergie', 'Attaque renforcée', '1d20 + Attaque', 'Attaque', 'degats', 13, 'aucun', 0, 0, 1, 20, 1, 'FEU_BERSERKER_DU_FEU_U02', NULL, 20, 7, 'Énergie', 8, 'utilisation_competence', 1, 7),
(21, 'FEU_BERSERKER_DU_FEU_008', 'Fureur du brasier', 'elementaire', 'Feu', 'Berserker du Feu', 'DPS Énergie', 'Augmente les dégâts', '1d20 + Attaque', 'Attaque', 'buff', 5, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 8, 'Énergie', 7, 'utilisation_competence', 1, 8),
(22, 'FEU_BERSERKER_DU_FEU_009', 'Choc brûlant', 'elementaire', 'Feu', 'Berserker du Feu', 'DPS Énergie', 'Coup violent', '1d20 + Attaque', 'Attaque', 'degats', 15, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 9, 'Énergie', 7, 'utilisation_competence', 1, 9),
(23, 'FEU_BERSERKER_DU_FEU_010', 'Cataclysme ardent', 'elementaire', 'Feu', 'Berserker du Feu', 'DPS Énergie', 'Attaque ultime', '1d20 + Attaque', 'Attaque', 'degats', 20, 'aucun', 0, 0, 1, 20, 1, 'FEU_BERSERKER_DU_FEU_U03', NULL, 20, 10, 'Énergie', 6, 'utilisation_competence', 1, 10),
(24, 'FEU_BERSERKER_DU_FEU_U01', 'Volcan sanguin', 'ultime', 'Feu', 'Berserker du Feu', 'DPS Énergie', 'Évolution ultime de FEU_BERSERKER_DU_FEU_004', '1d20 + Attaque', 'Attaque', 'degats', 22, 'brulure', 6, 2, 1, 5, 0, NULL, 'FEU_BERSERKER_DU_FEU_004', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 101),
(25, 'FEU_BERSERKER_DU_FEU_U02', 'Lame du cataclysme', 'ultime', 'Feu', 'Berserker du Feu', 'DPS Énergie', 'Évolution ultime de FEU_BERSERKER_DU_FEU_007', '1d20 + Attaque', 'Attaque', 'degats', 24, 'aucun', 0, 0, 1, 5, 0, NULL, 'FEU_BERSERKER_DU_FEU_007', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 102),
(26, 'FEU_BERSERKER_DU_FEU_U03', 'Fin des cendres', 'ultime', 'Feu', 'Berserker du Feu', 'DPS Énergie', 'Évolution ultime de FEU_BERSERKER_DU_FEU_010', '1d20 + Attaque', 'Attaque', 'degats_zone', 28, 'brulure', 8, 3, 1, 5, 0, NULL, 'FEU_BERSERKER_DU_FEU_010', NULL, 12, 'Énergie', 5, 'utilisation_competence', 0, 103),
(27, 'FEU_MAGE_DU_FEU_001', 'Trait de feu', 'elementaire', 'Feu', 'Mage du Feu', 'DPS Magie', 'Projectile magique de feu', '1d20 + Magie', 'Magie', 'degats', 8, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Mana', 10, 'utilisation_competence', 1, 1),
(28, 'FEU_MAGE_DU_FEU_002', 'Boule de feu', 'elementaire', 'Feu', 'Mage du Feu', 'DPS Magie', 'Explosion simple', '1d20 + Magie', 'Magie', 'degats', 10, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 2),
(29, 'FEU_MAGE_DU_FEU_003', 'Souffle ardent', 'elementaire', 'Feu', 'Mage du Feu', 'DPS Magie', 'Vague de feu rapide', '1d20 + Magie', 'Magie', 'degats', 9, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 3),
(30, 'FEU_MAGE_DU_FEU_004', 'Explosion de braise', 'elementaire', 'Feu', 'Mage du Feu', 'DPS Magie', 'Explosion localisée', '1d20 + Magie', 'Magie', 'degats', 11, 'aucun', 0, 0, 1, 20, 1, 'FEU_MAGE_DU_FEU_U01', NULL, 20, 5, 'Mana', 8, 'utilisation_competence', 1, 4),
(31, 'FEU_MAGE_DU_FEU_005', 'Marque brûlante', 'elementaire', 'Feu', 'Mage du Feu', 'DPS Magie', 'Brûlure progressive', '1d20 + Magie', 'Magie', 'degats', 0, 'brulure', 6, 2, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 5),
(32, 'FEU_MAGE_DU_FEU_006', 'Orbe incandescente', 'elementaire', 'Feu', 'Mage du Feu', 'DPS Magie', 'Sphère explosive', '1d20 + Magie', 'Magie', 'degats', 13, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 6),
(33, 'FEU_MAGE_DU_FEU_007', 'Vague de chaleur', 'elementaire', 'Feu', 'Mage du Feu', 'DPS Magie', 'Onde brûlante', '1d20 + Magie', 'Magie', 'degats', 14, 'aucun', 0, 0, 1, 20, 1, 'FEU_MAGE_DU_FEU_U02', NULL, 20, 7, 'Mana', 8, 'utilisation_competence', 1, 7),
(34, 'FEU_MAGE_DU_FEU_008', 'Tempête de feu', 'elementaire', 'Feu', 'Mage du Feu', 'DPS Magie', 'Attaque de zone', '1d20 + Magie', 'Magie', 'degats_zone', 15, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 8, 'Mana', 7, 'utilisation_competence', 1, 8),
(35, 'FEU_MAGE_DU_FEU_009', 'Nova flamboyante', 'elementaire', 'Feu', 'Mage du Feu', 'DPS Magie', 'Explosion circulaire', '1d20 + Magie', 'Magie', 'degats_zone', 17, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 9, 'Mana', 7, 'utilisation_competence', 1, 9),
(36, 'FEU_MAGE_DU_FEU_010', 'Apogée du brasier', 'elementaire', 'Feu', 'Mage du Feu', 'DPS Magie', 'Puissance maximale', '1d20 + Magie', 'Magie', 'degats', 20, 'aucun', 0, 0, 1, 20, 1, 'FEU_MAGE_DU_FEU_U03', NULL, 20, 10, 'Mana', 6, 'utilisation_competence', 1, 10),
(37, 'FEU_MAGE_DU_FEU_U01', 'Déflagration infernale', 'ultime', 'Feu', 'Mage du Feu', 'DPS Magie', 'Évolution ultime de FEU_MAGE_DU_FEU_004', '1d20 + Magie', 'Magie', 'degats_zone', 22, 'brulure', 8, 2, 1, 5, 0, NULL, 'FEU_MAGE_DU_FEU_004', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 101),
(38, 'FEU_MAGE_DU_FEU_U02', 'Cataclysme solaire', 'ultime', 'Feu', 'Mage du Feu', 'DPS Magie', 'Évolution ultime de FEU_MAGE_DU_FEU_007', '1d20 + Magie', 'Magie', 'degats_zone', 24, 'aucun', 0, 0, 1, 5, 0, NULL, 'FEU_MAGE_DU_FEU_007', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 102),
(39, 'FEU_MAGE_DU_FEU_U03', 'Apocalypse de feu', 'ultime', 'Feu', 'Mage du Feu', 'DPS Magie', 'Évolution ultime de FEU_MAGE_DU_FEU_010', '1d20 + Magie', 'Magie', 'degats_zone', 28, 'brulure', 10, 3, 1, 5, 0, NULL, 'FEU_MAGE_DU_FEU_010', NULL, 12, 'Mana', 5, 'utilisation_competence', 0, 103),
(40, 'FEU_PRETRE_DU_FEU_001', 'Flamme vitale', 'elementaire', 'Feu', 'Prêtre du Feu', 'Heal', 'Soigne une cible', '1d20 + Intelligence', 'Intelligence', 'soin', 8, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Mana', 10, 'utilisation_competence', 1, 1),
(41, 'FEU_PRETRE_DU_FEU_002', 'Chaleur curative', 'elementaire', 'Feu', 'Prêtre du Feu', 'Heal', 'Régénération de vie', '1d20 + Intelligence', 'Intelligence', 'soin', 0, 'regeneration', 5, 2, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 2),
(42, 'FEU_PRETRE_DU_FEU_003', 'Lumière du feu', 'elementaire', 'Feu', 'Prêtre du Feu', 'Heal', 'Soin léger de zone', '1d20 + Intelligence', 'Intelligence', 'soin_zone', 6, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 3),
(43, 'FEU_PRETRE_DU_FEU_004', 'Purification ardente', 'elementaire', 'Feu', 'Prêtre du Feu', 'Heal', 'Supprime un effet', '1d20 + Intelligence', 'Intelligence', 'dissipation', 1, 'aucun', 0, 0, 1, 20, 1, 'FEU_PRETRE_DU_FEU_U01', NULL, 20, 5, 'Mana', 8, 'utilisation_competence', 1, 4),
(44, 'FEU_PRETRE_DU_FEU_005', 'Aura du phénix', 'elementaire', 'Feu', 'Prêtre du Feu', 'Heal', 'Régénération de zone', '1d20 + Intelligence', 'Intelligence', 'soin', 0, 'regeneration', 6, 2, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 5),
(45, 'FEU_PRETRE_DU_FEU_006', 'Renaissance', 'elementaire', 'Feu', 'Prêtre du Feu', 'Heal', 'Gros soin', '1d20 + Intelligence', 'Intelligence', 'soin', 15, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 6),
(46, 'FEU_PRETRE_DU_FEU_007', 'Bénédiction solaire', 'elementaire', 'Feu', 'Prêtre du Feu', 'Heal', 'Boost allié', '1d20 + Intelligence', 'Intelligence', 'buff', 4, 'aucun', 0, 2, 1, 20, 1, 'FEU_PRETRE_DU_FEU_U02', NULL, 20, 7, 'Mana', 8, 'utilisation_competence', 1, 7),
(47, 'FEU_PRETRE_DU_FEU_008', 'Flamme protectrice', 'elementaire', 'Feu', 'Prêtre du Feu', 'Heal', 'Réduit les dégâts', '1d20 + Intelligence', 'Intelligence', 'reduction_degats', 4, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 8, 'Mana', 7, 'utilisation_competence', 1, 8),
(48, 'FEU_PRETRE_DU_FEU_009', 'Miracle ardent', 'elementaire', 'Feu', 'Prêtre du Feu', 'Heal', 'Soin massif', '1d20 + Intelligence', 'Intelligence', 'soin', 20, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 9, 'Mana', 7, 'utilisation_competence', 1, 9),
(49, 'FEU_PRETRE_DU_FEU_010', 'Résurgence du phénix', 'elementaire', 'Feu', 'Prêtre du Feu', 'Heal', 'Soin ultime', '1d20 + Intelligence', 'Intelligence', 'soin', 25, 'aucun', 0, 0, 1, 20, 1, 'FEU_PRETRE_DU_FEU_U03', NULL, 20, 10, 'Mana', 6, 'utilisation_competence', 1, 10),
(50, 'FEU_PRETRE_DU_FEU_U01', 'Second souffle du phénix', 'ultime', 'Feu', 'Prêtre du Feu', 'Heal', 'Évolution ultime de FEU_PRETRE_DU_FEU_004', '1d20 + Intelligence', 'Intelligence', 'dissipation', 1, 'regeneration', 8, 2, 1, 5, 0, NULL, 'FEU_PRETRE_DU_FEU_004', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 101),
(51, 'FEU_PRETRE_DU_FEU_U02', 'Aurore flamboyante', 'ultime', 'Feu', 'Prêtre du Feu', 'Heal', 'Évolution ultime de FEU_PRETRE_DU_FEU_007', '1d20 + Intelligence', 'Intelligence', 'buff', 6, 'regeneration', 8, 2, 1, 5, 0, NULL, 'FEU_PRETRE_DU_FEU_007', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 102),
(52, 'FEU_PRETRE_DU_FEU_U03', 'Jugement du phénix', 'ultime', 'Feu', 'Prêtre du Feu', 'Heal', 'Évolution ultime de FEU_PRETRE_DU_FEU_010', '1d20 + Intelligence', 'Intelligence', 'soin_zone', 32, 'aucun', 0, 0, 1, 5, 0, NULL, 'FEU_PRETRE_DU_FEU_010', NULL, 12, 'Mana', 5, 'utilisation_competence', 0, 103),
(53, 'EAU_GUERRIER_DE_LEAU_001', 'Armure des marées', 'elementaire', 'Eau', 'Guerrier de l’Eau', 'Tank', 'Renforce la défense par une couche d’eau dense', '1d20 + Défense', 'Défense', 'buff', 3, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 3, 'Énergie', 10, 'utilisation_competence', 1, 1),
(54, 'EAU_GUERRIER_DE_LEAU_002', 'Frappe des flots', 'elementaire', 'Eau', 'Guerrier de l’Eau', 'Tank', 'Coup chargé d’eau', '1d20 + Attaque', 'Attaque', 'degats', 6, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Énergie', 10, 'utilisation_competence', 1, 2),
(55, 'EAU_GUERRIER_DE_LEAU_003', 'Voile liquide', 'elementaire', 'Eau', 'Guerrier de l’Eau', 'Tank', 'Pellicule défensive absorbant les chocs', '1d20 + Défense', 'Défense', 'reduction_degats', 2, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 4, 'Énergie', 10, 'utilisation_competence', 1, 3),
(56, 'EAU_GUERRIER_DE_LEAU_004', 'Rempart des vagues', 'elementaire', 'Eau', 'Guerrier de l’Eau', 'Tank', 'Mur d’eau protecteur', '1d20 + Défense', 'Défense', 'buff', 5, 'aucun', 0, 1, 1, 20, 1, 'EAU_GUERRIER_DE_LEAU_U01', NULL, 20, 5, 'Énergie', 8, 'utilisation_competence', 1, 4),
(57, 'EAU_GUERRIER_DE_LEAU_005', 'Appel des marées', 'elementaire', 'Eau', 'Guerrier de l’Eau', 'Tank', 'Force les ennemis à s’approcher', '1d20 + Défense', 'Défense', 'aggro', 1, 'aucun', 0, 1, 1, 20, 0, NULL, NULL, NULL, 5, 'Énergie', 8, 'utilisation_competence', 1, 5),
(58, 'EAU_GUERRIER_DE_LEAU_006', 'Peau d’écume dense', 'elementaire', 'Eau', 'Guerrier de l’Eau', 'Tank', 'Réduit l’impact des coups', '1d20 + Défense', 'Défense', 'reduction_degats', 4, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 6, 'Énergie', 8, 'utilisation_competence', 1, 6),
(59, 'EAU_GUERRIER_DE_LEAU_007', 'Onde de recul', 'elementaire', 'Eau', 'Guerrier de l’Eau', 'Tank', 'Repousse les ennemis proches', '1d20 + Attaque', 'Attaque', 'degats_recul', 5, 'aucun', 0, 0, 1, 20, 1, 'EAU_GUERRIER_DE_LEAU_U02', NULL, 20, 6, 'Énergie', 8, 'utilisation_competence', 1, 7),
(60, 'EAU_GUERRIER_DE_LEAU_008', 'Cœur des marées', 'elementaire', 'Eau', 'Guerrier de l’Eau', 'Tank', 'Renforce la tenue au combat', '1d20 + Défense', 'Défense', 'buff', 6, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 7, 'Énergie', 7, 'utilisation_competence', 1, 8),
(61, 'EAU_GUERRIER_DE_LEAU_009', 'Bastion d’écume', 'elementaire', 'Eau', 'Guerrier de l’Eau', 'Tank', 'Protection renforcée de grande ampleur', '1d20 + Défense', 'Défense', 'reduction_degats', 6, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 8, 'Énergie', 7, 'utilisation_competence', 1, 9),
(62, 'EAU_GUERRIER_DE_LEAU_010', 'Avatar des profondeurs', 'elementaire', 'Eau', 'Guerrier de l’Eau', 'Tank', 'Forme défensive ultime de l’eau', '1d20 + Défense', 'Défense', 'buff', 10, 'aucun', 0, 2, 1, 20, 1, 'EAU_GUERRIER_DE_LEAU_U03', NULL, 20, 10, 'Énergie', 6, 'utilisation_competence', 1, 10),
(63, 'EAU_GUERRIER_DE_LEAU_U01', 'Citadelle des marées', 'ultime', 'Eau', 'Guerrier de l’Eau', 'Tank', 'Évolution ultime de EAU_GUERRIER_DE_LEAU_004', '1d20 + Défense', 'Défense', 'buff', 12, 'aucun', 0, 2, 1, 5, 0, NULL, 'EAU_GUERRIER_DE_LEAU_004', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 101),
(64, 'EAU_GUERRIER_DE_LEAU_U02', 'Ressac du gouffre', 'ultime', 'Eau', 'Guerrier de l’Eau', 'Tank', 'Évolution ultime de EAU_GUERRIER_DE_LEAU_007', '1d20 + Attaque', 'Attaque', 'degats_recul', 14, 'aucun', 0, 0, 1, 5, 0, NULL, 'EAU_GUERRIER_DE_LEAU_007', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 102),
(65, 'EAU_GUERRIER_DE_LEAU_U03', 'Trône des profondeurs', 'ultime', 'Eau', 'Guerrier de l’Eau', 'Tank', 'Évolution ultime de EAU_GUERRIER_DE_LEAU_010', '1d20 + Défense', 'Défense', 'buff', 18, 'regeneration', 4, 3, 1, 5, 0, NULL, 'EAU_GUERRIER_DE_LEAU_010', NULL, 12, 'Énergie', 5, 'utilisation_competence', 0, 103),
(66, 'EAU_COMBATTANT_DE_LEAU_001', 'Taille des flots', 'elementaire', 'Eau', 'Combattant de l’Eau', 'DPS Énergie', 'Coup rapide chargé d’eau', '1d20 + Attaque', 'Attaque', 'degats', 8, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Énergie', 10, 'utilisation_competence', 1, 1),
(67, 'EAU_COMBATTANT_DE_LEAU_002', 'Élancement liquide', 'elementaire', 'Eau', 'Combattant de l’Eau', 'DPS Énergie', 'Accélère les mouvements', '1d20 + Agilité', 'Agilité', 'buff', 3, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 4, 'Énergie', 10, 'utilisation_competence', 1, 2),
(68, 'EAU_COMBATTANT_DE_LEAU_003', 'Entaille des marées', 'elementaire', 'Eau', 'Combattant de l’Eau', 'DPS Énergie', 'Coupe fluide et précise', '1d20 + Attaque', 'Attaque', 'degats', 9, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Énergie', 10, 'utilisation_competence', 1, 3),
(69, 'EAU_COMBATTANT_DE_LEAU_004', 'Frappe abyssale', 'elementaire', 'Eau', 'Combattant de l’Eau', 'DPS Énergie', 'Coup lourd imbibé de puissance', '1d20 + Attaque', 'Attaque', 'degats', 12, 'aucun', 0, 0, 1, 20, 1, 'EAU_COMBATTANT_DE_LEAU_U01', NULL, 20, 5, 'Énergie', 8, 'utilisation_competence', 1, 4),
(70, 'EAU_COMBATTANT_DE_LEAU_005', 'Danse des courants', 'elementaire', 'Eau', 'Combattant de l’Eau', 'DPS Énergie', 'Série de frappes rapides', '1d20 + Agilité', 'Agilité', 'degats', 10, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Énergie', 8, 'utilisation_competence', 1, 5),
(71, 'EAU_COMBATTANT_DE_LEAU_006', 'Déferlante brutale', 'elementaire', 'Eau', 'Combattant de l’Eau', 'DPS Énergie', 'Attaque de zone', '1d20 + Attaque', 'Attaque', 'degats_zone', 10, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Énergie', 8, 'utilisation_competence', 1, 6),
(72, 'EAU_COMBATTANT_DE_LEAU_007', 'Lame des abysses', 'elementaire', 'Eau', 'Combattant de l’Eau', 'DPS Énergie', 'Attaque renforcée d’eau tranchante', '1d20 + Attaque', 'Attaque', 'degats', 13, 'aucun', 0, 0, 1, 20, 1, 'EAU_COMBATTANT_DE_LEAU_U02', NULL, 20, 7, 'Énergie', 8, 'utilisation_competence', 1, 7),
(73, 'EAU_COMBATTANT_DE_LEAU_008', 'Furie des marées', 'elementaire', 'Eau', 'Combattant de l’Eau', 'DPS Énergie', 'Augmente la pression offensive', '1d20 + Attaque', 'Attaque', 'buff', 5, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 8, 'Énergie', 7, 'utilisation_competence', 1, 8),
(74, 'EAU_COMBATTANT_DE_LEAU_009', 'Choc du ressac', 'elementaire', 'Eau', 'Combattant de l’Eau', 'DPS Énergie', 'Coup violent repoussant', '1d20 + Attaque', 'Attaque', 'degats_recul', 15, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 9, 'Énergie', 7, 'utilisation_competence', 1, 9),
(75, 'EAU_COMBATTANT_DE_LEAU_010', 'Déluge offensif', 'elementaire', 'Eau', 'Combattant de l’Eau', 'DPS Énergie', 'Assaut ultime des courants', '1d20 + Attaque', 'Attaque', 'degats_zone', 20, 'aucun', 0, 0, 1, 20, 1, 'EAU_COMBATTANT_DE_LEAU_U03', NULL, 20, 10, 'Énergie', 6, 'utilisation_competence', 1, 10),
(76, 'EAU_COMBATTANT_DE_LEAU_U01', 'Raz-de-marée furieux', 'ultime', 'Eau', 'Combattant de l’Eau', 'DPS Énergie', 'Évolution ultime de EAU_COMBATTANT_DE_LEAU_004', '1d20 + Attaque', 'Attaque', 'degats', 22, 'aucun', 0, 0, 1, 5, 0, NULL, 'EAU_COMBATTANT_DE_LEAU_004', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 101),
(77, 'EAU_COMBATTANT_DE_LEAU_U02', 'Lame du gouffre', 'ultime', 'Eau', 'Combattant de l’Eau', 'DPS Énergie', 'Évolution ultime de EAU_COMBATTANT_DE_LEAU_007', '1d20 + Attaque', 'Attaque', 'degats', 24, 'saignement', 6, 2, 1, 5, 0, NULL, 'EAU_COMBATTANT_DE_LEAU_007', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 102),
(78, 'EAU_COMBATTANT_DE_LEAU_U03', 'Fin du ressac', 'ultime', 'Eau', 'Combattant de l’Eau', 'DPS Énergie', 'Évolution ultime de EAU_COMBATTANT_DE_LEAU_010', '1d20 + Attaque', 'Attaque', 'degats_zone', 28, 'aucun', 0, 0, 1, 5, 0, NULL, 'EAU_COMBATTANT_DE_LEAU_010', NULL, 12, 'Énergie', 5, 'utilisation_competence', 0, 103),
(79, 'EAU_MAGE_DE_LEAU_001', 'Trait aqueux', 'elementaire', 'Eau', 'Mage de l’Eau', 'DPS Magie', 'Projectile d’eau condensée', '1d20 + Magie', 'Magie', 'degats', 8, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Mana', 10, 'utilisation_competence', 1, 1),
(80, 'EAU_MAGE_DE_LEAU_002', 'Orbe des flots', 'elementaire', 'Eau', 'Mage de l’Eau', 'DPS Magie', 'Sphère d’eau explosive', '1d20 + Magie', 'Magie', 'degats', 10, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 2),
(81, 'EAU_MAGE_DE_LEAU_003', 'Vague vive', 'elementaire', 'Eau', 'Mage de l’Eau', 'DPS Magie', 'Impact rapide d’eau', '1d20 + Magie', 'Magie', 'degats', 9, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 3),
(82, 'EAU_MAGE_DE_LEAU_004', 'Explosion des marées', 'elementaire', 'Eau', 'Mage de l’Eau', 'DPS Magie', 'Onde de choc liquide', '1d20 + Magie', 'Magie', 'degats_zone', 11, 'aucun', 0, 0, 1, 20, 1, 'EAU_MAGE_DE_LEAU_U01', NULL, 20, 5, 'Mana', 8, 'utilisation_competence', 1, 4),
(83, 'EAU_MAGE_DE_LEAU_005', 'Marque des profondeurs', 'elementaire', 'Eau', 'Mage de l’Eau', 'DPS Magie', 'Affaiblit progressivement la cible', '1d20 + Magie', 'Magie', 'degats', 0, 'humidite', 6, 2, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 5),
(84, 'EAU_MAGE_DE_LEAU_006', 'Sphère abyssale', 'elementaire', 'Eau', 'Mage de l’Eau', 'DPS Magie', 'Masse d’eau très dense', '1d20 + Magie', 'Magie', 'degats', 13, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 6),
(85, 'EAU_MAGE_DE_LEAU_007', 'Souffle des abysses', 'elementaire', 'Eau', 'Mage de l’Eau', 'DPS Magie', 'Projection large d’eau pressurisée', '1d20 + Magie', 'Magie', 'degats', 14, 'aucun', 0, 0, 1, 20, 1, 'EAU_MAGE_DE_LEAU_U02', NULL, 20, 7, 'Mana', 8, 'utilisation_competence', 1, 7),
(86, 'EAU_MAGE_DE_LEAU_008', 'Tempête marine', 'elementaire', 'Eau', 'Mage de l’Eau', 'DPS Magie', 'Déluge magique sur une zone', '1d20 + Magie', 'Magie', 'degats_zone', 15, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 8, 'Mana', 7, 'utilisation_competence', 1, 8),
(87, 'EAU_MAGE_DE_LEAU_009', 'Nova des marées', 'elementaire', 'Eau', 'Mage de l’Eau', 'DPS Magie', 'Explosion circulaire aqueuse', '1d20 + Magie', 'Magie', 'degats_zone', 17, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 9, 'Mana', 7, 'utilisation_competence', 1, 9),
(88, 'EAU_MAGE_DE_LEAU_010', 'Courroux océanique', 'elementaire', 'Eau', 'Mage de l’Eau', 'DPS Magie', 'Sort ultime des flots', '1d20 + Magie', 'Magie', 'degats_zone', 22, 'aucun', 0, 0, 1, 20, 1, 'EAU_MAGE_DE_LEAU_U03', NULL, 20, 10, 'Mana', 6, 'utilisation_competence', 1, 10),
(89, 'EAU_MAGE_DE_LEAU_U01', 'Abysse déchaînée', 'ultime', 'Eau', 'Mage de l’Eau', 'DPS Magie', 'Évolution ultime de EAU_MAGE_DE_LEAU_004', '1d20 + Magie', 'Magie', 'degats_zone', 22, 'humidite', 8, 2, 1, 5, 0, NULL, 'EAU_MAGE_DE_LEAU_004', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 101),
(90, 'EAU_MAGE_DE_LEAU_U02', 'Marée noire sacrée', 'ultime', 'Eau', 'Mage de l’Eau', 'DPS Magie', 'Évolution ultime de EAU_MAGE_DE_LEAU_007', '1d20 + Magie', 'Magie', 'degats_zone', 24, 'aucun', 0, 0, 1, 5, 0, NULL, 'EAU_MAGE_DE_LEAU_007', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 102),
(91, 'EAU_MAGE_DE_LEAU_U03', 'Jugement de l’océan', 'ultime', 'Eau', 'Mage de l’Eau', 'DPS Magie', 'Évolution ultime de EAU_MAGE_DE_LEAU_010', '1d20 + Magie', 'Magie', 'degats_zone', 28, 'humidite', 10, 3, 1, 5, 0, NULL, 'EAU_MAGE_DE_LEAU_010', NULL, 12, 'Mana', 5, 'utilisation_competence', 0, 103),
(92, 'EAU_PRETRE_DE_LEAU_001', 'Source bienfaitrice', 'elementaire', 'Eau', 'Prêtre de l’Eau', 'Heal', 'Soigne une cible par eau pure', '1d20 + Intelligence', 'Intelligence', 'soin', 8, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Mana', 10, 'utilisation_competence', 1, 1),
(93, 'EAU_PRETRE_DE_LEAU_002', 'Courant réparateur', 'elementaire', 'Eau', 'Prêtre de l’Eau', 'Heal', 'Régénération douce', '1d20 + Intelligence', 'Intelligence', 'soin', 0, 'regeneration', 5, 2, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 2),
(94, 'EAU_PRETRE_DE_LEAU_003', 'Pluie pure', 'elementaire', 'Eau', 'Prêtre de l’Eau', 'Heal', 'Soin léger de zone', '1d20 + Intelligence', 'Intelligence', 'soin_zone', 6, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 3),
(95, 'EAU_PRETRE_DE_LEAU_004', 'Lavis sacré', 'elementaire', 'Eau', 'Prêtre de l’Eau', 'Heal', 'Dissipe une altération', '1d20 + Intelligence', 'Intelligence', 'dissipation', 1, 'aucun', 0, 0, 1, 20, 1, 'EAU_PRETRE_DE_LEAU_U01', NULL, 20, 5, 'Mana', 8, 'utilisation_competence', 1, 4),
(96, 'EAU_PRETRE_DE_LEAU_005', 'Aura des sources', 'elementaire', 'Eau', 'Prêtre de l’Eau', 'Heal', 'Régénération pour les alliés proches', '1d20 + Intelligence', 'Intelligence', 'soin', 0, 'regeneration', 6, 2, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 5),
(97, 'EAU_PRETRE_DE_LEAU_006', 'Renaissance des flots', 'elementaire', 'Eau', 'Prêtre de l’Eau', 'Heal', 'Soin important', '1d20 + Intelligence', 'Intelligence', 'soin', 15, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 6),
(98, 'EAU_PRETRE_DE_LEAU_007', 'Bénédiction marine', 'elementaire', 'Eau', 'Prêtre de l’Eau', 'Heal', 'Renforce les alliés', '1d20 + Intelligence', 'Intelligence', 'buff', 4, 'aucun', 0, 2, 1, 20, 1, 'EAU_PRETRE_DE_LEAU_U02', NULL, 20, 7, 'Mana', 8, 'utilisation_competence', 1, 7),
(99, 'EAU_PRETRE_DE_LEAU_008', 'Voile des marées', 'elementaire', 'Eau', 'Prêtre de l’Eau', 'Heal', 'Réduit les dégâts reçus', '1d20 + Intelligence', 'Intelligence', 'reduction_degats', 4, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 8, 'Mana', 7, 'utilisation_competence', 1, 8),
(100, 'EAU_PRETRE_DE_LEAU_009', 'Miracle des sources', 'elementaire', 'Eau', 'Prêtre de l’Eau', 'Heal', 'Grand soin instantané', '1d20 + Intelligence', 'Intelligence', 'soin', 20, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 9, 'Mana', 7, 'utilisation_competence', 1, 9),
(101, 'EAU_PRETRE_DE_LEAU_010', 'Grâce océanique', 'elementaire', 'Eau', 'Prêtre de l’Eau', 'Heal', 'Soin ultime de l’eau sacrée', '1d20 + Intelligence', 'Intelligence', 'soin', 25, 'aucun', 0, 0, 1, 20, 1, 'EAU_PRETRE_DE_LEAU_U03', NULL, 20, 10, 'Mana', 6, 'utilisation_competence', 1, 10),
(102, 'EAU_PRETRE_DE_LEAU_U01', 'Baptême des sources', 'ultime', 'Eau', 'Prêtre de l’Eau', 'Heal', 'Évolution ultime de EAU_PRETRE_DE_LEAU_004', '1d20 + Intelligence', 'Intelligence', 'dissipation', 1, 'regeneration', 8, 2, 1, 5, 0, NULL, 'EAU_PRETRE_DE_LEAU_004', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 101),
(103, 'EAU_PRETRE_DE_LEAU_U02', 'Aube marine', 'ultime', 'Eau', 'Prêtre de l’Eau', 'Heal', 'Évolution ultime de EAU_PRETRE_DE_LEAU_007', '1d20 + Intelligence', 'Intelligence', 'buff', 6, 'regeneration', 8, 2, 1, 5, 0, NULL, 'EAU_PRETRE_DE_LEAU_007', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 102),
(104, 'EAU_PRETRE_DE_LEAU_U03', 'Miséricorde abyssale', 'ultime', 'Eau', 'Prêtre de l’Eau', 'Heal', 'Évolution ultime de EAU_PRETRE_DE_LEAU_010', '1d20 + Intelligence', 'Intelligence', 'soin_zone', 32, 'aucun', 0, 0, 1, 5, 0, NULL, 'EAU_PRETRE_DE_LEAU_010', NULL, 12, 'Mana', 5, 'utilisation_competence', 0, 103),
(105, 'AIR_GUERRIER_DE_LAIR_001', 'Armure des vents', 'elementaire', 'Air', 'Guerrier de l’Air', 'Tank', 'Renforce la défense par des flux d’air', '1d20 + Défense', 'Défense', 'buff', 3, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 3, 'Énergie', 10, 'utilisation_competence', 1, 1),
(106, 'AIR_GUERRIER_DE_LAIR_002', 'Frappe aérienne', 'elementaire', 'Air', 'Guerrier de l’Air', 'Tank', 'Coup rapide porté par le vent', '1d20 + Attaque', 'Attaque', 'degats', 6, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Énergie', 10, 'utilisation_competence', 1, 2),
(107, 'AIR_GUERRIER_DE_LAIR_003', 'Voile des brises', 'elementaire', 'Air', 'Guerrier de l’Air', 'Tank', 'Réduit les dégâts reçus', '1d20 + Défense', 'Défense', 'reduction_degats', 2, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 4, 'Énergie', 10, 'utilisation_competence', 1, 3),
(108, 'AIR_GUERRIER_DE_LAIR_004', 'Rempart du vent', 'elementaire', 'Air', 'Guerrier de l’Air', 'Tank', 'Bouclier d’air protecteur', '1d20 + Défense', 'Défense', 'buff', 5, 'aucun', 0, 1, 1, 20, 1, 'AIR_GUERRIER_DE_LAIR_U01', NULL, 20, 5, 'Énergie', 8, 'utilisation_competence', 1, 4),
(109, 'AIR_GUERRIER_DE_LAIR_005', 'Appel des rafales', 'elementaire', 'Air', 'Guerrier de l’Air', 'Tank', 'Attire l’attention des ennemis', '1d20 + Défense', 'Défense', 'aggro', 1, 'aucun', 0, 1, 1, 20, 0, NULL, NULL, NULL, 5, 'Énergie', 8, 'utilisation_competence', 1, 5),
(110, 'AIR_GUERRIER_DE_LAIR_006', 'Peau de vent dense', 'elementaire', 'Air', 'Guerrier de l’Air', 'Tank', 'Réduit l’impact des attaques', '1d20 + Défense', 'Défense', 'reduction_degats', 4, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 6, 'Énergie', 8, 'utilisation_competence', 1, 6),
(111, 'AIR_GUERRIER_DE_LAIR_007', 'Onde de dispersion', 'elementaire', 'Air', 'Guerrier de l’Air', 'Tank', 'Repousse les ennemis proches', '1d20 + Attaque', 'Attaque', 'degats_recul', 5, 'aucun', 0, 0, 1, 20, 1, 'AIR_GUERRIER_DE_LAIR_U02', NULL, 20, 6, 'Énergie', 8, 'utilisation_competence', 1, 7),
(112, 'AIR_GUERRIER_DE_LAIR_008', 'Cœur du vent', 'elementaire', 'Air', 'Guerrier de l’Air', 'Tank', 'Renforce la mobilité défensive', '1d20 + Défense', 'Défense', 'buff', 6, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 7, 'Énergie', 7, 'utilisation_competence', 1, 8),
(113, 'AIR_GUERRIER_DE_LAIR_009', 'Mur des tempêtes', 'elementaire', 'Air', 'Guerrier de l’Air', 'Tank', 'Protection avancée', '1d20 + Défense', 'Défense', 'reduction_degats', 6, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 8, 'Énergie', 7, 'utilisation_competence', 1, 9),
(114, 'AIR_GUERRIER_DE_LAIR_010', 'Avatar des tempêtes', 'elementaire', 'Air', 'Guerrier de l’Air', 'Tank', 'Forme défensive ultime', '1d20 + Défense', 'Défense', 'buff', 10, 'aucun', 0, 2, 1, 20, 1, 'AIR_GUERRIER_DE_LAIR_U03', NULL, 20, 10, 'Énergie', 6, 'utilisation_competence', 1, 10),
(115, 'AIR_GUERRIER_DE_LAIR_U01', 'Citadelle des tempêtes', 'ultime', 'Air', 'Guerrier de l’Air', 'Tank', 'Évolution ultime de AIR_GUERRIER_DE_LAIR_004', '1d20 + Défense', 'Défense', 'buff', 12, 'aucun', 0, 2, 1, 5, 0, NULL, 'AIR_GUERRIER_DE_LAIR_004', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 101),
(116, 'AIR_GUERRIER_DE_LAIR_U02', 'Cyclone du rempart', 'ultime', 'Air', 'Guerrier de l’Air', 'Tank', 'Évolution ultime de AIR_GUERRIER_DE_LAIR_007', '1d20 + Attaque', 'Attaque', 'degats_recul', 14, 'aucun', 0, 0, 1, 5, 0, NULL, 'AIR_GUERRIER_DE_LAIR_007', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 102),
(117, 'AIR_GUERRIER_DE_LAIR_U03', 'Trône des nuées', 'ultime', 'Air', 'Guerrier de l’Air', 'Tank', 'Évolution ultime de AIR_GUERRIER_DE_LAIR_010', '1d20 + Défense', 'Défense', 'buff', 18, 'aucun', 0, 3, 1, 5, 0, NULL, 'AIR_GUERRIER_DE_LAIR_010', NULL, 12, 'Énergie', 5, 'utilisation_competence', 0, 103),
(118, 'AIR_CHASSEUR_DE_LAIR_001', 'Flèche rapide', 'elementaire', 'Air', 'Chasseur de l’Air', 'DPS Énergie', 'Tir rapide guidé par le vent', '1d20 + Dextérité', 'Dextérité', 'degats', 8, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Énergie', 10, 'utilisation_competence', 1, 1),
(119, 'AIR_CHASSEUR_DE_LAIR_002', 'Accélération des vents', 'elementaire', 'Air', 'Chasseur de l’Air', 'DPS Énergie', 'Augmente la vitesse d’attaque', '1d20 + Agilité', 'Agilité', 'buff', 3, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 4, 'Énergie', 10, 'utilisation_competence', 1, 2),
(120, 'AIR_CHASSEUR_DE_LAIR_003', 'Tir perforant', 'elementaire', 'Air', 'Chasseur de l’Air', 'DPS Énergie', 'Flèche précise et puissante', '1d20 + Dextérité', 'Dextérité', 'degats', 9, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Énergie', 10, 'utilisation_competence', 1, 3),
(121, 'AIR_CHASSEUR_DE_LAIR_004', 'Rafale concentrée', 'elementaire', 'Air', 'Chasseur de l’Air', 'DPS Énergie', 'Tir chargé', '1d20 + Dextérité', 'Dextérité', 'degats', 12, 'aucun', 0, 0, 1, 20, 1, 'AIR_CHASSEUR_DE_LAIR_U01', NULL, 20, 5, 'Énergie', 8, 'utilisation_competence', 1, 4),
(122, 'AIR_CHASSEUR_DE_LAIR_005', 'Danse du vent', 'elementaire', 'Air', 'Chasseur de l’Air', 'DPS Énergie', 'Série de tirs rapides', '1d20 + Agilité', 'Agilité', 'degats', 10, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Énergie', 8, 'utilisation_competence', 1, 5),
(123, 'AIR_CHASSEUR_DE_LAIR_006', 'Pluie de flèches', 'elementaire', 'Air', 'Chasseur de l’Air', 'DPS Énergie', 'Attaque de zone', '1d20 + Dextérité', 'Dextérité', 'degats_zone', 10, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Énergie', 8, 'utilisation_competence', 1, 6),
(124, 'AIR_CHASSEUR_DE_LAIR_007', 'Tir des hauteurs', 'elementaire', 'Air', 'Chasseur de l’Air', 'DPS Énergie', 'Tir renforcé par l’altitude', '1d20 + Dextérité', 'Dextérité', 'degats', 13, 'aucun', 0, 0, 1, 20, 1, 'AIR_CHASSEUR_DE_LAIR_U02', NULL, 20, 7, 'Énergie', 8, 'utilisation_competence', 1, 7),
(125, 'AIR_CHASSEUR_DE_LAIR_008', 'Précision absolue', 'elementaire', 'Air', 'Chasseur de l’Air', 'DPS Énergie', 'Augmente les dégâts', '1d20 + Dextérité', 'Dextérité', 'buff', 5, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 8, 'Énergie', 7, 'utilisation_competence', 1, 8),
(126, 'AIR_CHASSEUR_DE_LAIR_009', 'Flèche des tempêtes', 'elementaire', 'Air', 'Chasseur de l’Air', 'DPS Énergie', 'Tir puissant', '1d20 + Dextérité', 'Dextérité', 'degats', 15, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 9, 'Énergie', 7, 'utilisation_competence', 1, 9),
(127, 'AIR_CHASSEUR_DE_LAIR_010', 'Jugement du ciel', 'elementaire', 'Air', 'Chasseur de l’Air', 'DPS Énergie', 'Attaque ultime', '1d20 + Dextérité', 'Dextérité', 'degats', 20, 'aucun', 0, 0, 1, 20, 1, 'AIR_CHASSEUR_DE_LAIR_U03', NULL, 20, 10, 'Énergie', 6, 'utilisation_competence', 1, 10),
(128, 'AIR_CHASSEUR_DE_LAIR_U01', 'Ouragan perce-ciel', 'ultime', 'Air', 'Chasseur de l’Air', 'DPS Énergie', 'Évolution ultime de AIR_CHASSEUR_DE_LAIR_004', '1d20 + Dextérité', 'Dextérité', 'degats', 22, 'aucun', 0, 0, 1, 5, 0, NULL, 'AIR_CHASSEUR_DE_LAIR_004', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 101),
(129, 'AIR_CHASSEUR_DE_LAIR_U02', 'Œil de la tempête', 'ultime', 'Air', 'Chasseur de l’Air', 'DPS Énergie', 'Évolution ultime de AIR_CHASSEUR_DE_LAIR_007', '1d20 + Dextérité', 'Dextérité', 'degats', 24, 'saignement', 6, 2, 1, 5, 0, NULL, 'AIR_CHASSEUR_DE_LAIR_007', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 102),
(130, 'AIR_CHASSEUR_DE_LAIR_U03', 'Sentence céleste', 'ultime', 'Air', 'Chasseur de l’Air', 'DPS Énergie', 'Évolution ultime de AIR_CHASSEUR_DE_LAIR_010', '1d20 + Dextérité', 'Dextérité', 'degats_zone', 28, 'aucun', 0, 0, 1, 5, 0, NULL, 'AIR_CHASSEUR_DE_LAIR_010', NULL, 12, 'Énergie', 5, 'utilisation_competence', 0, 103),
(131, 'AIR_MAGE_DE_LAIR_001', 'Trait de vent', 'elementaire', 'Air', 'Mage de l’Air', 'DPS Magie', 'Projectile d’air tranchant', '1d20 + Magie', 'Magie', 'degats', 8, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Mana', 10, 'utilisation_competence', 1, 1),
(132, 'AIR_MAGE_DE_LAIR_002', 'Lame de vent', 'elementaire', 'Air', 'Mage de l’Air', 'DPS Magie', 'Coupe aérienne', '1d20 + Magie', 'Magie', 'degats', 10, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 2),
(133, 'AIR_MAGE_DE_LAIR_003', 'Souffle rapide', 'elementaire', 'Air', 'Mage de l’Air', 'DPS Magie', 'Attaque rapide', '1d20 + Magie', 'Magie', 'degats', 9, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 3),
(134, 'AIR_MAGE_DE_LAIR_004', 'Explosion aérienne', 'elementaire', 'Air', 'Mage de l’Air', 'DPS Magie', 'Onde de choc', '1d20 + Magie', 'Magie', 'degats_zone', 11, 'aucun', 0, 0, 1, 20, 1, 'AIR_MAGE_DE_LAIR_U01', NULL, 20, 5, 'Mana', 8, 'utilisation_competence', 1, 4),
(135, 'AIR_MAGE_DE_LAIR_005', 'Marque des vents', 'elementaire', 'Air', 'Mage de l’Air', 'DPS Magie', 'Dégâts sur la durée', '1d20 + Magie', 'Magie', 'degats', 0, 'vent_coupant', 6, 2, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 5),
(136, 'AIR_MAGE_DE_LAIR_006', 'Orbe des tempêtes', 'elementaire', 'Air', 'Mage de l’Air', 'DPS Magie', 'Sphère d’air instable', '1d20 + Magie', 'Magie', 'degats', 13, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 6),
(137, 'AIR_MAGE_DE_LAIR_007', 'Souffle des cieux', 'elementaire', 'Air', 'Mage de l’Air', 'DPS Magie', 'Attaque large', '1d20 + Magie', 'Magie', 'degats', 14, 'aucun', 0, 0, 1, 20, 1, 'AIR_MAGE_DE_LAIR_U02', NULL, 20, 7, 'Mana', 8, 'utilisation_competence', 1, 7),
(138, 'AIR_MAGE_DE_LAIR_008', 'Tempête violente', 'elementaire', 'Air', 'Mage de l’Air', 'DPS Magie', 'Zone de dégâts', '1d20 + Magie', 'Magie', 'degats_zone', 15, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 8, 'Mana', 7, 'utilisation_competence', 1, 8),
(139, 'AIR_MAGE_DE_LAIR_009', 'Nova des vents', 'elementaire', 'Air', 'Mage de l’Air', 'DPS Magie', 'Explosion circulaire', '1d20 + Magie', 'Magie', 'degats_zone', 17, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 9, 'Mana', 7, 'utilisation_competence', 1, 9),
(140, 'AIR_MAGE_DE_LAIR_010', 'Colère des cieux', 'elementaire', 'Air', 'Mage de l’Air', 'DPS Magie', 'Sort ultime', '1d20 + Magie', 'Magie', 'degats_zone', 22, 'aucun', 0, 0, 1, 20, 1, 'AIR_MAGE_DE_LAIR_U03', NULL, 20, 10, 'Mana', 6, 'utilisation_competence', 1, 10),
(141, 'AIR_MAGE_DE_LAIR_U01', 'Jugement des nuées', 'ultime', 'Air', 'Mage de l’Air', 'DPS Magie', 'Évolution ultime de AIR_MAGE_DE_LAIR_004', '1d20 + Magie', 'Magie', 'degats_zone', 22, 'vent_coupant', 8, 2, 1, 5, 0, NULL, 'AIR_MAGE_DE_LAIR_004', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 101),
(142, 'AIR_MAGE_DE_LAIR_U02', 'Ciel déchiré', 'ultime', 'Air', 'Mage de l’Air', 'DPS Magie', 'Évolution ultime de AIR_MAGE_DE_LAIR_007', '1d20 + Magie', 'Magie', 'degats_zone', 24, 'aucun', 0, 0, 1, 5, 0, NULL, 'AIR_MAGE_DE_LAIR_007', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 102),
(143, 'AIR_MAGE_DE_LAIR_U03', 'Fin du tonnerre', 'ultime', 'Air', 'Mage de l’Air', 'DPS Magie', 'Évolution ultime de AIR_MAGE_DE_LAIR_010', '1d20 + Magie', 'Magie', 'degats_zone', 28, 'vent_coupant', 10, 3, 1, 5, 0, NULL, 'AIR_MAGE_DE_LAIR_010', NULL, 12, 'Mana', 5, 'utilisation_competence', 0, 103),
(144, 'AIR_PRETRE_DE_LAIR_001', 'Souffle vital', 'elementaire', 'Air', 'Prêtre de l’Air', 'Heal', 'Soigne avec l’air pur', '1d20 + Intelligence', 'Intelligence', 'soin', 8, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Mana', 10, 'utilisation_competence', 1, 1),
(145, 'AIR_PRETRE_DE_LAIR_002', 'Brise réparatrice', 'elementaire', 'Air', 'Prêtre de l’Air', 'Heal', 'Régénération légère', '1d20 + Intelligence', 'Intelligence', 'soin', 0, 'regeneration', 5, 2, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 2),
(146, 'AIR_PRETRE_DE_LAIR_003', 'Vent apaisant', 'elementaire', 'Air', 'Prêtre de l’Air', 'Heal', 'Soin de zone', '1d20 + Intelligence', 'Intelligence', 'soin_zone', 6, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 3),
(147, 'AIR_PRETRE_DE_LAIR_004', 'Purification des vents', 'elementaire', 'Air', 'Prêtre de l’Air', 'Heal', 'Retire un effet négatif', '1d20 + Intelligence', 'Intelligence', 'dissipation', 1, 'aucun', 0, 0, 1, 20, 1, 'AIR_PRETRE_DE_LAIR_U01', NULL, 20, 5, 'Mana', 8, 'utilisation_competence', 1, 4),
(148, 'AIR_PRETRE_DE_LAIR_005', 'Aura des brises', 'elementaire', 'Air', 'Prêtre de l’Air', 'Heal', 'Régénération de groupe', '1d20 + Intelligence', 'Intelligence', 'soin', 0, 'regeneration', 6, 2, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 5),
(149, 'AIR_PRETRE_DE_LAIR_006', 'Renaissance aérienne', 'elementaire', 'Air', 'Prêtre de l’Air', 'Heal', 'Soin important', '1d20 + Intelligence', 'Intelligence', 'soin', 15, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 6),
(150, 'AIR_PRETRE_DE_LAIR_007', 'Bénédiction céleste', 'elementaire', 'Air', 'Prêtre de l’Air', 'Heal', 'Boost allié', '1d20 + Intelligence', 'Intelligence', 'buff', 4, 'aucun', 0, 2, 1, 20, 1, 'AIR_PRETRE_DE_LAIR_U02', NULL, 20, 7, 'Mana', 8, 'utilisation_competence', 1, 7),
(151, 'AIR_PRETRE_DE_LAIR_008', 'Voile du vent', 'elementaire', 'Air', 'Prêtre de l’Air', 'Heal', 'Réduction des dégâts', '1d20 + Intelligence', 'Intelligence', 'reduction_degats', 4, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 8, 'Mana', 7, 'utilisation_competence', 1, 8),
(152, 'AIR_PRETRE_DE_LAIR_009', 'Miracle des cieux', 'elementaire', 'Air', 'Prêtre de l’Air', 'Heal', 'Soin massif', '1d20 + Intelligence', 'Intelligence', 'soin', 20, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 9, 'Mana', 7, 'utilisation_competence', 1, 9),
(153, 'AIR_PRETRE_DE_LAIR_010', 'Grâce céleste', 'elementaire', 'Air', 'Prêtre de l’Air', 'Heal', 'Soin ultime', '1d20 + Intelligence', 'Intelligence', 'soin', 25, 'aucun', 0, 0, 1, 20, 1, 'AIR_PRETRE_DE_LAIR_U03', NULL, 20, 10, 'Mana', 6, 'utilisation_competence', 1, 10),
(154, 'AIR_PRETRE_DE_LAIR_U01', 'Jugement des brises', 'ultime', 'Air', 'Prêtre de l’Air', 'Heal', 'Évolution ultime de AIR_PRETRE_DE_LAIR_004', '1d20 + Intelligence', 'Intelligence', 'dissipation', 1, 'regeneration', 8, 2, 1, 5, 0, NULL, 'AIR_PRETRE_DE_LAIR_004', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 101),
(155, 'AIR_PRETRE_DE_LAIR_U02', 'Aile protectrice', 'ultime', 'Air', 'Prêtre de l’Air', 'Heal', 'Évolution ultime de AIR_PRETRE_DE_LAIR_007', '1d20 + Intelligence', 'Intelligence', 'buff', 6, 'regeneration', 8, 2, 1, 5, 0, NULL, 'AIR_PRETRE_DE_LAIR_007', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 102),
(156, 'AIR_PRETRE_DE_LAIR_U03', 'Miséricorde céleste', 'ultime', 'Air', 'Prêtre de l’Air', 'Heal', 'Évolution ultime de AIR_PRETRE_DE_LAIR_010', '1d20 + Intelligence', 'Intelligence', 'soin_zone', 32, 'aucun', 0, 0, 1, 5, 0, NULL, 'AIR_PRETRE_DE_LAIR_010', NULL, 12, 'Mana', 5, 'utilisation_competence', 0, 103),
(157, 'TERRE_GUERRIER_DE_LA_TERRE_001', 'Peau de pierre', 'elementaire', 'Terre', 'Guerrier de la Terre', 'Tank', 'Renforce la défense', '1d20 + Défense', 'Défense', 'buff', 3, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 3, 'Énergie', 10, 'utilisation_competence', 1, 1),
(158, 'TERRE_GUERRIER_DE_LA_TERRE_002', 'Frappe tellurique', 'elementaire', 'Terre', 'Guerrier de la Terre', 'Tank', 'Coup lourd terrestre', '1d20 + Attaque', 'Attaque', 'degats', 6, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Énergie', 10, 'utilisation_competence', 1, 2),
(159, 'TERRE_GUERRIER_DE_LA_TERRE_003', 'Armure minérale', 'elementaire', 'Terre', 'Guerrier de la Terre', 'Tank', 'Réduit les dégâts subis', '1d20 + Défense', 'Défense', 'reduction_degats', 2, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 4, 'Énergie', 10, 'utilisation_competence', 1, 3),
(160, 'TERRE_GUERRIER_DE_LA_TERRE_004', 'Mur de roche', 'elementaire', 'Terre', 'Guerrier de la Terre', 'Tank', 'Bouclier solide', '1d20 + Défense', 'Défense', 'buff', 5, 'aucun', 0, 1, 1, 20, 1, 'TERRE_GUERRIER_DE_LA_TERRE_U01', NULL, 20, 5, 'Énergie', 8, 'utilisation_competence', 1, 4),
(161, 'TERRE_GUERRIER_DE_LA_TERRE_005', 'Provocation terrestre', 'elementaire', 'Terre', 'Guerrier de la Terre', 'Tank', 'Attire les ennemis', '1d20 + Défense', 'Défense', 'aggro', 1, 'aucun', 0, 1, 1, 20, 0, NULL, NULL, NULL, 5, 'Énergie', 8, 'utilisation_competence', 1, 5),
(162, 'TERRE_GUERRIER_DE_LA_TERRE_006', 'Carapace de granite', 'elementaire', 'Terre', 'Guerrier de la Terre', 'Tank', 'Réduction importante', '1d20 + Défense', 'Défense', 'reduction_degats', 4, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 6, 'Énergie', 8, 'utilisation_competence', 1, 6),
(163, 'TERRE_GUERRIER_DE_LA_TERRE_007', 'Onde sismique', 'elementaire', 'Terre', 'Guerrier de la Terre', 'Tank', 'Repousse les ennemis', '1d20 + Attaque', 'Attaque', 'degats_recul', 5, 'aucun', 0, 0, 1, 20, 1, 'TERRE_GUERRIER_DE_LA_TERRE_U02', NULL, 20, 6, 'Énergie', 8, 'utilisation_competence', 1, 7),
(164, 'TERRE_GUERRIER_DE_LA_TERRE_008', 'Cœur de pierre', 'elementaire', 'Terre', 'Guerrier de la Terre', 'Tank', 'Renforce la résistance', '1d20 + Défense', 'Défense', 'buff', 6, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 7, 'Énergie', 7, 'utilisation_competence', 1, 8),
(165, 'TERRE_GUERRIER_DE_LA_TERRE_009', 'Bastion terrestre', 'elementaire', 'Terre', 'Guerrier de la Terre', 'Tank', 'Protection avancée', '1d20 + Défense', 'Défense', 'reduction_degats', 6, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 8, 'Énergie', 7, 'utilisation_competence', 1, 9),
(166, 'TERRE_GUERRIER_DE_LA_TERRE_010', 'Avatar du colosse', 'elementaire', 'Terre', 'Guerrier de la Terre', 'Tank', 'Forme ultime défensive', '1d20 + Défense', 'Défense', 'buff', 10, 'aucun', 0, 2, 1, 20, 1, 'TERRE_GUERRIER_DE_LA_TERRE_U03', NULL, 20, 10, 'Énergie', 6, 'utilisation_competence', 1, 10),
(167, 'TERRE_GUERRIER_DE_LA_TERRE_U01', 'Citadelle du granite', 'ultime', 'Terre', 'Guerrier de la Terre', 'Tank', 'Évolution ultime de TERRE_GUERRIER_DE_LA_TERRE_004', '1d20 + Défense', 'Défense', 'buff', 12, 'aucun', 0, 2, 1, 5, 0, NULL, 'TERRE_GUERRIER_DE_LA_TERRE_004', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 101),
(168, 'TERRE_GUERRIER_DE_LA_TERRE_U02', 'Rupture tectonique', 'ultime', 'Terre', 'Guerrier de la Terre', 'Tank', 'Évolution ultime de TERRE_GUERRIER_DE_LA_TERRE_007', '1d20 + Attaque', 'Attaque', 'degats_recul', 14, 'fissure', 4, 2, 1, 5, 0, NULL, 'TERRE_GUERRIER_DE_LA_TERRE_007', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 102),
(169, 'TERRE_GUERRIER_DE_LA_TERRE_U03', 'Trône du colosse', 'ultime', 'Terre', 'Guerrier de la Terre', 'Tank', 'Évolution ultime de TERRE_GUERRIER_DE_LA_TERRE_010', '1d20 + Défense', 'Défense', 'buff', 18, 'aucun', 0, 3, 1, 5, 0, NULL, 'TERRE_GUERRIER_DE_LA_TERRE_010', NULL, 12, 'Énergie', 5, 'utilisation_competence', 0, 103),
(170, 'TERRE_BRISEUR_DE_TERRE_001', 'Coup écrasant', 'elementaire', 'Terre', 'Briseur de Terre', 'DPS Énergie', 'Attaque lourde', '1d20 + Attaque', 'Attaque', 'degats', 8, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Énergie', 10, 'utilisation_competence', 1, 1),
(171, 'TERRE_BRISEUR_DE_TERRE_002', 'Force de la montagne', 'elementaire', 'Terre', 'Briseur de Terre', 'DPS Énergie', 'Augmente la puissance', '1d20 + Attaque', 'Attaque', 'buff', 3, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 4, 'Énergie', 10, 'utilisation_competence', 1, 2),
(172, 'TERRE_BRISEUR_DE_TERRE_003', 'Entaille de roche', 'elementaire', 'Terre', 'Briseur de Terre', 'DPS Énergie', 'Coup précis', '1d20 + Attaque', 'Attaque', 'degats', 9, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Énergie', 10, 'utilisation_competence', 1, 3),
(173, 'TERRE_BRISEUR_DE_TERRE_004', 'Frappe tectonique', 'elementaire', 'Terre', 'Briseur de Terre', 'DPS Énergie', 'Attaque lourde', '1d20 + Attaque', 'Attaque', 'degats', 12, 'aucun', 0, 0, 1, 20, 1, 'TERRE_BRISEUR_DE_TERRE_U01', NULL, 20, 5, 'Énergie', 8, 'utilisation_competence', 1, 4),
(174, 'TERRE_BRISEUR_DE_TERRE_005', 'Danse des pierres', 'elementaire', 'Terre', 'Briseur de Terre', 'DPS Énergie', 'Combo', '1d20 + Agilité', 'Agilité', 'degats', 10, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Énergie', 8, 'utilisation_competence', 1, 5),
(175, 'TERRE_BRISEUR_DE_TERRE_006', 'Éboulement', 'elementaire', 'Terre', 'Briseur de Terre', 'DPS Énergie', 'Dégâts de zone', '1d20 + Attaque', 'Attaque', 'degats_zone', 10, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Énergie', 8, 'utilisation_competence', 1, 6),
(176, 'TERRE_BRISEUR_DE_TERRE_007', 'Lame minérale', 'elementaire', 'Terre', 'Briseur de Terre', 'DPS Énergie', 'Attaque renforcée', '1d20 + Attaque', 'Attaque', 'degats', 13, 'aucun', 0, 0, 1, 20, 1, 'TERRE_BRISEUR_DE_TERRE_U02', NULL, 20, 7, 'Énergie', 8, 'utilisation_competence', 1, 7);
INSERT INTO `catalogue_competences` (`id`, `code_competence`, `nom`, `famille_competence`, `element`, `classe`, `role`, `resume`, `jet`, `type_resolution`, `effet_principal`, `valeur_base`, `effet_duree`, `valeur_par_tour`, `duree_tours`, `niveau_initial`, `niveau_max_naturel`, `peut_devenir_ultime`, `code_competence_ultime`, `code_competence_source`, `palier_evolution_ultime`, `cout_utilisation`, `ressource_utilisee`, `xp_gain_utilisation`, `declencheur_progression`, `deblocable_par_choix_initial`, `ordre_affichage`) VALUES
(177, 'TERRE_BRISEUR_DE_TERRE_008', 'Rage terrestre', 'elementaire', 'Terre', 'Briseur de Terre', 'DPS Énergie', 'Boost dégâts', '1d20 + Attaque', 'Attaque', 'buff', 5, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 8, 'Énergie', 7, 'utilisation_competence', 1, 8),
(178, 'TERRE_BRISEUR_DE_TERRE_009', 'Impact du titan', 'elementaire', 'Terre', 'Briseur de Terre', 'DPS Énergie', 'Coup violent', '1d20 + Attaque', 'Attaque', 'degats', 15, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 9, 'Énergie', 7, 'utilisation_competence', 1, 9),
(179, 'TERRE_BRISEUR_DE_TERRE_010', 'Cataclysme rocheux', 'elementaire', 'Terre', 'Briseur de Terre', 'DPS Énergie', 'Attaque ultime', '1d20 + Attaque', 'Attaque', 'degats_zone', 20, 'aucun', 0, 0, 1, 20, 1, 'TERRE_BRISEUR_DE_TERRE_U03', NULL, 20, 10, 'Énergie', 6, 'utilisation_competence', 1, 10),
(180, 'TERRE_BRISEUR_DE_TERRE_U01', 'Faim du séisme', 'ultime', 'Terre', 'Briseur de Terre', 'DPS Énergie', 'Évolution ultime de TERRE_BRISEUR_DE_TERRE_004', '1d20 + Attaque', 'Attaque', 'degats', 22, 'fissure', 6, 2, 1, 5, 0, NULL, 'TERRE_BRISEUR_DE_TERRE_004', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 101),
(181, 'TERRE_BRISEUR_DE_TERRE_U02', 'Lame du titan', 'ultime', 'Terre', 'Briseur de Terre', 'DPS Énergie', 'Évolution ultime de TERRE_BRISEUR_DE_TERRE_007', '1d20 + Attaque', 'Attaque', 'degats', 24, 'aucun', 0, 0, 1, 5, 0, NULL, 'TERRE_BRISEUR_DE_TERRE_007', NULL, 10, 'Énergie', 5, 'utilisation_competence', 0, 102),
(182, 'TERRE_BRISEUR_DE_TERRE_U03', 'Fin du monde de pierre', 'ultime', 'Terre', 'Briseur de Terre', 'DPS Énergie', 'Évolution ultime de TERRE_BRISEUR_DE_TERRE_010', '1d20 + Attaque', 'Attaque', 'degats_zone', 28, 'fissure', 8, 3, 1, 5, 0, NULL, 'TERRE_BRISEUR_DE_TERRE_010', NULL, 12, 'Énergie', 5, 'utilisation_competence', 0, 103),
(183, 'TERRE_MAGE_DE_LA_TERRE_001', 'Projectile rocheux', 'elementaire', 'Terre', 'Mage de la Terre', 'DPS Magie', 'Lance un rocher', '1d20 + Magie', 'Magie', 'degats', 8, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Mana', 10, 'utilisation_competence', 1, 1),
(184, 'TERRE_MAGE_DE_LA_TERRE_002', 'Pic de pierre', 'elementaire', 'Terre', 'Mage de la Terre', 'DPS Magie', 'Pointe surgissante', '1d20 + Magie', 'Magie', 'degats', 10, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 2),
(185, 'TERRE_MAGE_DE_LA_TERRE_003', 'Onde minérale', 'elementaire', 'Terre', 'Mage de la Terre', 'DPS Magie', 'Attaque rapide', '1d20 + Magie', 'Magie', 'degats', 9, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 3),
(186, 'TERRE_MAGE_DE_LA_TERRE_004', 'Explosion tellurique', 'elementaire', 'Terre', 'Mage de la Terre', 'DPS Magie', 'Zone de dégâts', '1d20 + Magie', 'Magie', 'degats_zone', 11, 'aucun', 0, 0, 1, 20, 1, 'TERRE_MAGE_DE_LA_TERRE_U01', NULL, 20, 5, 'Mana', 8, 'utilisation_competence', 1, 4),
(187, 'TERRE_MAGE_DE_LA_TERRE_005', 'Fissure persistante', 'elementaire', 'Terre', 'Mage de la Terre', 'DPS Magie', 'Dégâts dans le temps', '1d20 + Magie', 'Magie', 'degats', 0, 'fissure', 6, 2, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 5),
(188, 'TERRE_MAGE_DE_LA_TERRE_006', 'Sphère de granite', 'elementaire', 'Terre', 'Mage de la Terre', 'DPS Magie', 'Attaque dense', '1d20 + Magie', 'Magie', 'degats', 13, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 6),
(189, 'TERRE_MAGE_DE_LA_TERRE_007', 'Souffle de poussière', 'elementaire', 'Terre', 'Mage de la Terre', 'DPS Magie', 'Attaque large', '1d20 + Magie', 'Magie', 'degats', 14, 'aucun', 0, 0, 1, 20, 1, 'TERRE_MAGE_DE_LA_TERRE_U02', NULL, 20, 7, 'Mana', 8, 'utilisation_competence', 1, 7),
(190, 'TERRE_MAGE_DE_LA_TERRE_008', 'Tempête de pierre', 'elementaire', 'Terre', 'Mage de la Terre', 'DPS Magie', 'Zone puissante', '1d20 + Magie', 'Magie', 'degats_zone', 15, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 8, 'Mana', 7, 'utilisation_competence', 1, 8),
(191, 'TERRE_MAGE_DE_LA_TERRE_009', 'Nova terrestre', 'elementaire', 'Terre', 'Mage de la Terre', 'DPS Magie', 'Explosion circulaire', '1d20 + Magie', 'Magie', 'degats_zone', 17, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 9, 'Mana', 7, 'utilisation_competence', 1, 9),
(192, 'TERRE_MAGE_DE_LA_TERRE_010', 'Colère de la terre', 'elementaire', 'Terre', 'Mage de la Terre', 'DPS Magie', 'Sort ultime', '1d20 + Magie', 'Magie', 'degats_zone', 22, 'aucun', 0, 0, 1, 20, 1, 'TERRE_MAGE_DE_LA_TERRE_U03', NULL, 20, 10, 'Mana', 6, 'utilisation_competence', 1, 10),
(193, 'TERRE_MAGE_DE_LA_TERRE_U01', 'Séisme ancestral', 'ultime', 'Terre', 'Mage de la Terre', 'DPS Magie', 'Évolution ultime de TERRE_MAGE_DE_LA_TERRE_004', '1d20 + Magie', 'Magie', 'degats_zone', 22, 'fissure', 8, 2, 1, 5, 0, NULL, 'TERRE_MAGE_DE_LA_TERRE_004', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 101),
(194, 'TERRE_MAGE_DE_LA_TERRE_U02', 'Roche du néant', 'ultime', 'Terre', 'Mage de la Terre', 'DPS Magie', 'Évolution ultime de TERRE_MAGE_DE_LA_TERRE_007', '1d20 + Magie', 'Magie', 'degats_zone', 24, 'aucun', 0, 0, 1, 5, 0, NULL, 'TERRE_MAGE_DE_LA_TERRE_007', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 102),
(195, 'TERRE_MAGE_DE_LA_TERRE_U03', 'Jugement du monde', 'ultime', 'Terre', 'Mage de la Terre', 'DPS Magie', 'Évolution ultime de TERRE_MAGE_DE_LA_TERRE_010', '1d20 + Magie', 'Magie', 'degats_zone', 28, 'fissure', 10, 3, 1, 5, 0, NULL, 'TERRE_MAGE_DE_LA_TERRE_010', NULL, 12, 'Mana', 5, 'utilisation_competence', 0, 103),
(196, 'TERRE_PRETRE_DE_LA_TERRE_001', 'Soin naturel', 'elementaire', 'Terre', 'Prêtre de la Terre', 'Heal', 'Soigne une cible', '1d20 + Intelligence', 'Intelligence', 'soin', 8, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 3, 'Mana', 10, 'utilisation_competence', 1, 1),
(197, 'TERRE_PRETRE_DE_LA_TERRE_002', 'Régénération sylvestre', 'elementaire', 'Terre', 'Prêtre de la Terre', 'Heal', 'Soin sur la durée', '1d20 + Intelligence', 'Intelligence', 'soin', 0, 'regeneration', 5, 2, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 2),
(198, 'TERRE_PRETRE_DE_LA_TERRE_003', 'Étreinte de la nature', 'elementaire', 'Terre', 'Prêtre de la Terre', 'Heal', 'Soin de zone', '1d20 + Intelligence', 'Intelligence', 'soin_zone', 6, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 4, 'Mana', 10, 'utilisation_competence', 1, 3),
(199, 'TERRE_PRETRE_DE_LA_TERRE_004', 'Purification terrestre', 'elementaire', 'Terre', 'Prêtre de la Terre', 'Heal', 'Retire un malus', '1d20 + Intelligence', 'Intelligence', 'dissipation', 1, 'aucun', 0, 0, 1, 20, 1, 'TERRE_PRETRE_DE_LA_TERRE_U01', NULL, 20, 5, 'Mana', 8, 'utilisation_competence', 1, 4),
(200, 'TERRE_PRETRE_DE_LA_TERRE_005', 'Aura végétale', 'elementaire', 'Terre', 'Prêtre de la Terre', 'Heal', 'Régénération de groupe', '1d20 + Intelligence', 'Intelligence', 'soin', 0, 'regeneration', 6, 2, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 5),
(201, 'TERRE_PRETRE_DE_LA_TERRE_006', 'Renaissance forestière', 'elementaire', 'Terre', 'Prêtre de la Terre', 'Heal', 'Soin important', '1d20 + Intelligence', 'Intelligence', 'soin', 15, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 6, 'Mana', 8, 'utilisation_competence', 1, 6),
(202, 'TERRE_PRETRE_DE_LA_TERRE_007', 'Bénédiction racinaire', 'elementaire', 'Terre', 'Prêtre de la Terre', 'Heal', 'Boost allié', '1d20 + Intelligence', 'Intelligence', 'buff', 4, 'aucun', 0, 2, 1, 20, 1, 'TERRE_PRETRE_DE_LA_TERRE_U02', NULL, 20, 7, 'Mana', 8, 'utilisation_competence', 1, 7),
(203, 'TERRE_PRETRE_DE_LA_TERRE_008', 'Protection végétale', 'elementaire', 'Terre', 'Prêtre de la Terre', 'Heal', 'Réduction dégâts', '1d20 + Intelligence', 'Intelligence', 'reduction_degats', 4, 'aucun', 0, 2, 1, 20, 0, NULL, NULL, NULL, 8, 'Mana', 7, 'utilisation_competence', 1, 8),
(204, 'TERRE_PRETRE_DE_LA_TERRE_009', 'Miracle de la nature', 'elementaire', 'Terre', 'Prêtre de la Terre', 'Heal', 'Soin massif', '1d20 + Intelligence', 'Intelligence', 'soin', 20, 'aucun', 0, 0, 1, 20, 0, NULL, NULL, NULL, 9, 'Mana', 7, 'utilisation_competence', 1, 9),
(205, 'TERRE_PRETRE_DE_LA_TERRE_010', 'Grâce ancestrale', 'elementaire', 'Terre', 'Prêtre de la Terre', 'Heal', 'Soin ultime', '1d20 + Intelligence', 'Intelligence', 'soin', 25, 'aucun', 0, 0, 1, 20, 1, 'TERRE_PRETRE_DE_LA_TERRE_U03', NULL, 20, 10, 'Mana', 6, 'utilisation_competence', 1, 10),
(206, 'TERRE_PRETRE_DE_LA_TERRE_U01', 'Éveil du chêne ancien', 'ultime', 'Terre', 'Prêtre de la Terre', 'Heal', 'Évolution ultime de TERRE_PRETRE_DE_LA_TERRE_004', '1d20 + Intelligence', 'Intelligence', 'dissipation', 1, 'regeneration', 8, 2, 1, 5, 0, NULL, 'TERRE_PRETRE_DE_LA_TERRE_004', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 101),
(207, 'TERRE_PRETRE_DE_LA_TERRE_U02', 'Aube des racines', 'ultime', 'Terre', 'Prêtre de la Terre', 'Heal', 'Évolution ultime de TERRE_PRETRE_DE_LA_TERRE_007', '1d20 + Intelligence', 'Intelligence', 'buff', 6, 'regeneration', 8, 2, 1, 5, 0, NULL, 'TERRE_PRETRE_DE_LA_TERRE_007', NULL, 10, 'Mana', 5, 'utilisation_competence', 0, 102),
(208, 'TERRE_PRETRE_DE_LA_TERRE_U03', 'Miséricorde primordiale', 'ultime', 'Terre', 'Prêtre de la Terre', 'Heal', 'Évolution ultime de TERRE_PRETRE_DE_LA_TERRE_010', '1d20 + Intelligence', 'Intelligence', 'soin_zone', 32, 'aucun', 0, 0, 1, 5, 0, NULL, 'TERRE_PRETRE_DE_LA_TERRE_010', NULL, 12, 'Mana', 5, 'utilisation_competence', 0, 103),
(209, 'NEUTRE_001', 'Pas du voyageur', 'neutre', 'Neutre', 'Compétence neutre', 'Passif', 'Votre corps s’adapte aux longues routes', 'aucun', 'vitesse', 'passif', 1, 'aucun', 0, 0, 1, 10, 0, NULL, NULL, NULL, 0, 'Aucune', 10, 'deplacement', 1, 1),
(210, 'NEUTRE_002', 'Souffle maîtrisé', 'neutre', 'Neutre', 'Compétence neutre', 'Passif', 'Votre endurance s’améliore avec l’effort', 'aucun', 'reduction_cout_energie', 'passif', 1, 'aucun', 0, 0, 1, 10, 0, NULL, NULL, NULL, 0, 'Aucune', 10, 'effort', 1, 2),
(211, 'NEUTRE_003', 'Puissance naturelle', 'neutre', 'Neutre', 'Compétence neutre', 'Passif', 'Vos gestes deviennent plus puissants', 'aucun', 'buff_attaque', 'passif', 1, 'aucun', 0, 0, 1, 10, 0, NULL, NULL, NULL, 0, 'Aucune', 10, 'combat_physique', 1, 3),
(212, 'NEUTRE_004', 'Regard affûté', 'neutre', 'Neutre', 'Compétence neutre', 'Passif', 'Vous apprenez à viser juste', 'aucun', 'buff_precision', 'passif', 1, 'aucun', 0, 0, 1, 10, 0, NULL, NULL, NULL, 0, 'Aucune', 10, 'attaque_reussie', 1, 4),
(213, 'NEUTRE_005', 'Peau endurcie', 'neutre', 'Neutre', 'Compétence neutre', 'Passif', 'Votre corps encaisse mieux les coups', 'aucun', 'buff_defense', 'passif', 1, 'aucun', 0, 0, 1, 10, 0, NULL, NULL, NULL, 0, 'Aucune', 10, 'degats_recus', 1, 5),
(214, 'NEUTRE_006', 'Calme intérieur', 'neutre', 'Neutre', 'Compétence neutre', 'Passif', 'Votre esprit retrouve son équilibre', 'aucun', 'regeneration_mana', 'passif', 1, 'aucun', 0, 0, 1, 10, 0, NULL, NULL, NULL, 0, 'Aucune', 10, 'repos', 1, 6),
(215, 'NEUTRE_007', 'Instinct vital', 'neutre', 'Neutre', 'Compétence neutre', 'Passif', 'Votre survie devient instinctive', 'aucun', 'reduction_degats_critiques', 'passif', 1, 'aucun', 0, 0, 1, 10, 0, NULL, NULL, NULL, 0, 'Aucune', 10, 'danger', 1, 7),
(216, 'NEUTRE_008', 'Main habile', 'neutre', 'Neutre', 'Compétence neutre', 'Passif', 'Vos gestes deviennent précis et efficaces', 'aucun', 'bonus_recolte', 'passif', 1, 'aucun', 0, 0, 1, 10, 0, NULL, NULL, NULL, 0, 'Aucune', 10, 'artisanat', 1, 8),
(217, 'NEUTRE_009', 'Appel du monde', 'neutre', 'Neutre', 'Compétence neutre', 'Passif', 'Vous êtes attiré par l’inconnu', 'aucun', 'bonus_decouverte', 'passif', 1, 'aucun', 0, 0, 1, 10, 0, NULL, NULL, NULL, 0, 'Aucune', 10, 'exploration', 1, 9),
(218, 'NEUTRE_010', 'Sens du moment', 'neutre', 'Neutre', 'Compétence neutre', 'Passif', 'Vous savez frapper au bon instant', 'aucun', 'bonus_conditionnel', 'passif', 1, 'aucun', 0, 0, 1, 10, 0, NULL, NULL, NULL, 0, 'Aucune', 10, 'opportunite', 1, 10);

-- --------------------------------------------------------

--
-- Structure de la table `catalogue_objets`
--

DROP TABLE IF EXISTS `catalogue_objets`;
CREATE TABLE IF NOT EXISTS `catalogue_objets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code_objet` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_objet` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_objet` text COLLATE utf8mb4_unicode_ci,
  `type_objet` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorie_objet` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rarete_objet` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'commun',
  `poids_unitaire` int NOT NULL DEFAULT '0',
  `est_empilable` tinyint(1) NOT NULL DEFAULT '0',
  `quantite_max_par_pile` int NOT NULL DEFAULT '1',
  `icone_objet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bonus_point_de_vie` int NOT NULL DEFAULT '0',
  `bonus_attaque` int NOT NULL DEFAULT '0',
  `bonus_magie` int NOT NULL DEFAULT '0',
  `bonus_agilite` int NOT NULL DEFAULT '0',
  `bonus_intelligence` int NOT NULL DEFAULT '0',
  `bonus_synchronisation_elementaire` int NOT NULL DEFAULT '0',
  `bonus_critique` int NOT NULL DEFAULT '0',
  `bonus_dexterite` int NOT NULL DEFAULT '0',
  `bonus_defense` int NOT NULL DEFAULT '0',
  `durabilite_maximum` int DEFAULT NULL,
  `niveau_minimum_requis` int NOT NULL DEFAULT '1',
  `est_equipable` tinyint(1) NOT NULL DEFAULT '0',
  `est_actif` tinyint(1) NOT NULL DEFAULT '1',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_catalogue_objets_code_objet` (`code_objet`),
  KEY `idx_catalogue_objets_type_objet` (`type_objet`),
  KEY `idx_catalogue_objets_categorie_objet` (`categorie_objet`),
  KEY `idx_catalogue_objets_est_equipable` (`est_equipable`),
  KEY `idx_catalogue_objets_est_actif` (`est_actif`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `catalogue_objets`
--

INSERT INTO `catalogue_objets` (`id`, `code_objet`, `nom_objet`, `description_objet`, `type_objet`, `categorie_objet`, `rarete_objet`, `poids_unitaire`, `est_empilable`, `quantite_max_par_pile`, `icone_objet`, `bonus_point_de_vie`, `bonus_attaque`, `bonus_magie`, `bonus_agilite`, `bonus_intelligence`, `bonus_synchronisation_elementaire`, `bonus_critique`, `bonus_dexterite`, `bonus_defense`, `durabilite_maximum`, `niveau_minimum_requis`, `est_equipable`, `est_actif`, `date_creation`) VALUES
(1, 'OBJ_TEST_CASQUE_CUIR', 'Casque de cuir', 'Casque simple de test pour guerrier.', 'equipement', 'tete', 'commun', 2, 0, 1, 'ressources/images/icones/objets/equipement_casque_cuir.png', 0, 0, 0, 0, 0, 0, 0, 0, 3, 40, 1, 1, 1, '2026-03-25 07:33:24'),
(2, 'OBJ_TEST_ARMURE_CUIR', 'Armure de cuir', 'Armure simple de test pour guerrier.', 'equipement', 'torse', 'commun', 4, 0, 1, 'ressources/images/icones/objets/equipement_armure_cuir.png', 5, 0, 0, 0, 0, 0, 0, 0, 6, 60, 1, 1, 1, '2026-03-25 07:33:24'),
(3, 'OBJ_TEST_GANTS_CUIR', 'Gants de cuir', 'Gants simples de test.', 'equipement', 'gants', 'commun', 1, 0, 1, 'ressources/images/icones/objets/equipement_gant_cuir.png', 0, 2, 0, 0, 0, 0, 0, 0, 1, 30, 1, 1, 1, '2026-03-25 07:33:24'),
(4, 'OBJ_TEST_BOTTES_CUIR', 'Bottes de cuir', 'Bottes simples de test.', 'equipement', 'jambes', 'commun', 2, 0, 1, 'ressources/images/icones/objets/equipement_bottes_cuir.png', 0, 0, 0, 2, 0, 0, 0, 0, 1, 35, 1, 1, 1, '2026-03-25 07:33:24'),
(5, 'OBJ_TEST_EPEE_LONGUE', 'Épée longue', 'Arme simple de test.', 'equipement', 'arme', 'commun', 3, 0, 1, 'ressources/images/icones/objets/arme_epee_longue.png', 0, 6, 0, 0, 0, 0, 1, 0, 0, 50, 1, 1, 1, '2026-03-25 07:33:24'),
(6, 'OBJ_TEST_BOUCLIER_BOIS', 'Bouclier de bois', 'Bouclier simple de test.', 'equipement', 'bouclier', 'commun', 3, 0, 1, 'ressources/images/icones/objets/bouclier_bois.png', 0, 0, 0, 0, 0, 0, 0, 0, 5, 45, 1, 1, 1, '2026-03-25 07:33:24'),
(7, 'OBJ_TEST_CAPUCHE_MAGE', 'Capuche du mage', 'Capuche simple de test pour mage.', 'equipement', 'tete', 'commun', 1, 0, 1, 'ressources/images/icones/objets/equipement_chapeau_hood.png', 0, 0, 2, 0, 2, 0, 0, 0, 1, 30, 1, 1, 1, '2026-03-25 07:33:24'),
(8, 'OBJ_TEST_ROBE_MAGE', 'Robe du mage', 'Robe simple de test pour mage.', 'equipement', 'torse', 'commun', 2, 0, 1, 'ressources/images/icones/objets/equipement_robe.png', 0, 0, 3, 0, 3, 0, 0, 0, 1, 35, 1, 1, 1, '2026-03-25 07:33:24'),
(9, 'OBJ_TEST_COLLIER_MAGIQUE', 'Collier magique', 'Collier de test pour lanceur de sorts.', 'equipement', 'collier', 'rare', 1, 0, 1, 'ressources/images/icones/objets/bijou_collier_or.png', 0, 0, 2, 0, 3, 1, 0, 0, 0, 25, 1, 1, 1, '2026-03-25 07:33:25'),
(10, 'OBJ_TEST_BAGUE_MAGIE', 'Bague de magie', 'Bague de test augmentant la magie.', 'equipement', 'bague', 'rare', 1, 0, 1, 'ressources/images/icones/objets/bijou_bague_simple.png', 0, 0, 4, 0, 1, 0, 1, 0, 0, 20, 1, 1, 1, '2026-03-25 07:33:25'),
(11, 'OBJ_TEST_BATON_MAGIQUE', 'Bâton magique', 'Bâton simple de test pour mage.', 'equipement', 'arme_magique', 'rare', 2, 0, 1, 'ressources/images/icones/objets/arme_baton_magique.png', 0, 0, 6, 0, 2, 1, 0, 0, 0, 50, 1, 1, 1, '2026-03-25 07:33:25'),
(12, 'OBJ_TEST_ARTEFACT_MINEUR', 'Artefact mineur', 'Artefact de test augmentant les capacités magiques.', 'equipement', 'artefact', 'epique', 1, 0, 1, 'ressources/images/icones/objets/orbe_violette.png', 0, 0, 5, 0, 0, 3, 0, 0, 0, 35, 1, 1, 1, '2026-03-25 07:33:25'),
(13, 'OBJ_TEST_POTION_VIE', 'Potion de vie', 'Potion de test restaurant la vie.', 'consommable', 'potion_vie', 'commun', 1, 1, 20, 'ressources/images/icones/objets/potion_normale_rouge.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 1, 0, 1, '2026-03-25 07:33:25'),
(14, 'OBJ_TEST_POTION_MANA', 'Potion de mana', 'Potion de test restaurant le mana.', 'consommable', 'potion_mana', 'commun', 1, 1, 20, 'ressources/images/icones/objets/potion_normale_bleue.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 1, 0, 1, '2026-03-25 07:33:25'),
(15, 'OBJ_TEST_POMME', 'Pomme', 'Nourriture de test.', 'nourriture', 'fruit', 'commun', 1, 1, 20, 'ressources/images/icones/objets/nourriture_pomme.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 1, 0, 1, '2026-03-25 07:33:25'),
(16, 'OBJ_TEST_PAIN', 'Pain', 'Nourriture de test.', 'nourriture', 'pain', 'commun', 1, 1, 20, 'ressources/images/icones/objets/nourriture_pain.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 1, 0, 1, '2026-03-25 07:33:26'),
(17, 'OBJ_TEST_BOIS', 'Bois', 'Ressource de test.', 'ressource', 'bois', 'commun', 2, 1, 50, 'ressources/images/icones/objets/ressource_bois.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 1, 0, 1, '2026-03-25 07:33:26'),
(18, 'OBJ_TEST_PIERRE', 'Pierre', 'Ressource de test.', 'ressource', 'pierre', 'commun', 2, 1, 50, 'ressources/images/icones/objets/ressource_pierre.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 1, 0, 1, '2026-03-25 07:33:26');

-- --------------------------------------------------------

--
-- Structure de la table `catalogue_objets_slots_autorises`
--

DROP TABLE IF EXISTS `catalogue_objets_slots_autorises`;
CREATE TABLE IF NOT EXISTS `catalogue_objets_slots_autorises` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `catalogue_objet_id` bigint UNSIGNED NOT NULL,
  `catalogue_slot_id` bigint UNSIGNED NOT NULL,
  `est_slot_principal` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_catalogue_objets_slots_autorises_objet_slot` (`catalogue_objet_id`,`catalogue_slot_id`),
  KEY `idx_catalogue_objets_slots_autorises_slot` (`catalogue_slot_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `catalogue_objets_slots_autorises`
--

INSERT INTO `catalogue_objets_slots_autorises` (`id`, `catalogue_objet_id`, `catalogue_slot_id`, `est_slot_principal`) VALUES
(1, 7, 1, 1),
(2, 1, 1, 1),
(4, 2, 4, 1),
(5, 8, 4, 1),
(7, 3, 3, 1),
(8, 3, 2, 1),
(10, 4, 5, 1),
(11, 9, 6, 1),
(12, 10, 7, 1),
(13, 10, 8, 1),
(15, 5, 11, 1),
(16, 11, 11, 1),
(17, 5, 9, 0),
(18, 11, 9, 0),
(22, 6, 9, 1),
(23, 12, 10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `catalogue_onglets_inventaire`
--

DROP TABLE IF EXISTS `catalogue_onglets_inventaire`;
CREATE TABLE IF NOT EXISTS `catalogue_onglets_inventaire` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code_onglet` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_onglet` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_onglet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordre_affichage` int NOT NULL DEFAULT '0',
  `nombre_slots` int NOT NULL DEFAULT '20',
  `icone_onglet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cout_deblocage_cristaux` int DEFAULT NULL,
  `est_debloque_par_defaut` tinyint(1) NOT NULL DEFAULT '0',
  `est_actif` tinyint(1) NOT NULL DEFAULT '1',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_catalogue_onglets_inventaire_code_onglet` (`code_onglet`),
  KEY `idx_catalogue_onglets_inventaire_est_actif` (`est_actif`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `catalogue_onglets_inventaire`
--

INSERT INTO `catalogue_onglets_inventaire` (`id`, `code_onglet`, `nom_onglet`, `description_onglet`, `ordre_affichage`, `nombre_slots`, `icone_onglet`, `cout_deblocage_cristaux`, `est_debloque_par_defaut`, `est_actif`, `date_creation`) VALUES
(1, 'sac_principal', 'Sac principal', 'Premier sac disponible dès le début.', 10, 20, 'ressources/images/icones/inventaire/onglet_sac_principal.png', NULL, 1, 1, '2026-03-25 06:45:29'),
(2, 'sac_secondaire', 'Sac secondaire', 'Second sac déblocable plus tard.', 20, 20, 'ressources/images/icones/inventaire/onglet_sac_secondaire.png', 250, 0, 1, '2026-03-25 06:45:29'),
(3, 'sac_tertiaire', 'Sac tertiaire', 'Troisième sac déblocable plus tard.', 30, 20, 'ressources/images/icones/inventaire/onglet_sac_tertiaire.png', 500, 0, 1, '2026-03-25 06:45:29'),
(4, 'sac_reliques', 'Sac reliques', 'Sac spécialisé pour objets rares et artefacts.', 40, 10, 'ressources/images/icones/inventaire/onglet_sac_reliques.png', 1000, 0, 1, '2026-03-25 06:45:29');

-- --------------------------------------------------------

--
-- Structure de la table `catalogue_slots_equipement`
--

DROP TABLE IF EXISTS `catalogue_slots_equipement`;
CREATE TABLE IF NOT EXISTS `catalogue_slots_equipement` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code_slot` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_slot` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_slot` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `groupe_slot` enum('equipement_personnage','inventaire') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'equipement_personnage',
  `categorie_principale_autorisee` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_objets_maximum` int NOT NULL DEFAULT '1',
  `ordre_affichage` int NOT NULL DEFAULT '0',
  `icone_slot_vide` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position_x_interface` int NOT NULL DEFAULT '0',
  `position_y_interface` int NOT NULL DEFAULT '0',
  `largeur_interface` int NOT NULL DEFAULT '98',
  `hauteur_interface` int NOT NULL DEFAULT '52',
  `est_actif` tinyint(1) NOT NULL DEFAULT '1',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_catalogue_slots_equipement_code_slot` (`code_slot`),
  KEY `idx_catalogue_slots_equipement_groupe_slot` (`groupe_slot`),
  KEY `idx_catalogue_slots_equipement_est_actif` (`est_actif`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `catalogue_slots_equipement`
--

INSERT INTO `catalogue_slots_equipement` (`id`, `code_slot`, `nom_slot`, `description_slot`, `groupe_slot`, `categorie_principale_autorisee`, `nombre_objets_maximum`, `ordre_affichage`, `icone_slot_vide`, `position_x_interface`, `position_y_interface`, `largeur_interface`, `hauteur_interface`, `est_actif`, `date_creation`) VALUES
(1, 'tete', 'Tête', 'Emplacement réservé aux casques, capuches et couronnes.', 'equipement_personnage', 'tete', 1, 10, 'ressources/images/icones/slots/slot_tete.png', 210, 20, 98, 52, 1, '2026-03-25 06:45:28'),
(2, 'gants_gauche', 'Gants gauche', 'Emplacement visuel pour la protection de la main gauche.', 'equipement_personnage', 'gants', 1, 20, 'ressources/images/icones/slots/slot_gants.png', 40, 200, 98, 52, 1, '2026-03-25 06:45:28'),
(3, 'gants_droite', 'Gants droite', 'Emplacement visuel pour la protection de la main droite.', 'equipement_personnage', 'gants', 1, 30, 'ressources/images/icones/slots/slot_gants.png', 380, 200, 98, 52, 1, '2026-03-25 06:45:28'),
(4, 'torse', 'Torse', 'Emplacement réservé aux armures et tenues de torse.', 'equipement_personnage', 'torse', 1, 40, 'ressources/images/icones/slots/slot_torse.png', 210, 160, 98, 52, 1, '2026-03-25 06:45:28'),
(5, 'jambes', 'Jambes', 'Emplacement réservé aux pantalons, robes et protections de jambes.', 'equipement_personnage', 'jambes', 1, 50, 'ressources/images/icones/slots/slot_jambes.png', 210, 330, 98, 52, 1, '2026-03-25 06:45:28'),
(6, 'collier', 'Collier', 'Emplacement réservé aux colliers et pendentifs.', 'equipement_personnage', 'collier', 1, 60, 'ressources/images/icones/slots/slot_collier.png', 40, 260, 98, 52, 1, '2026-03-25 06:45:28'),
(7, 'bague_1', 'Bague I', 'Premier emplacement de bague.', 'equipement_personnage', 'bague', 1, 70, 'ressources/images/icones/slots/slot_bague.png', 380, 260, 98, 52, 1, '2026-03-25 06:45:28'),
(8, 'bague_2', 'Bague II', 'Second emplacement de bague.', 'equipement_personnage', 'bague', 1, 80, 'ressources/images/icones/slots/slot_bague.png', 380, 330, 98, 52, 1, '2026-03-25 06:45:28'),
(9, 'main_gauche', 'Main gauche', 'Objet tenu en main gauche.', 'equipement_personnage', 'main', 1, 90, 'ressources/images/icones/slots/slot_main.png', 40, 448, 98, 52, 1, '2026-03-25 06:45:28'),
(10, 'artefact', 'Artefact', 'Emplacement réservé aux artefacts spéciaux.', 'equipement_personnage', 'artefact', 1, 100, 'ressources/images/icones/slots/slot_artefact.png', 210, 448, 98, 52, 1, '2026-03-25 06:45:28'),
(11, 'main_droite', 'Main droite', 'Objet tenu en main droite.', 'equipement_personnage', 'main', 1, 110, 'ressources/images/icones/slots/slot_main.png', 380, 448, 98, 52, 1, '2026-03-25 06:45:28');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`id`, `pseudo`, `mot_de_passe`, `date_creation`, `derniere_connexion`) VALUES
(1, 'test', '$2y$10$0bLEeM2disvIz3zUaZI9N.CD2DjubHsq9d3zROnUQDJYqVDl3rXlm', '2026-03-23 09:50:44', '2026-03-24 08:42:45'),
(2, 'test2', '$2y$10$xwpkpAwp6kFmkP5CafqMYuGO8Wok4OBWlnvITgLcw/N6iWX70.N9K', '2026-03-24 08:15:20', '2026-03-24 08:15:20');

-- --------------------------------------------------------

--
-- Structure de la table `configuration_competences`
--

DROP TABLE IF EXISTS `configuration_competences`;
CREATE TABLE IF NOT EXISTS `configuration_competences` (
  `cle_configuration` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valeur_configuration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`cle_configuration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `configuration_competences`
--

INSERT INTO `configuration_competences` (`cle_configuration`, `valeur_configuration`) VALUES
('multiplicateur_xp_niveau_suivant', '1.5'),
('niveau_max_competence_elementaire', '20'),
('niveau_max_competence_neutre', '10'),
('niveau_max_competence_ultime', '5'),
('niveau_max_joueur', '50'),
('palier_avance_max', '18'),
('palier_basique_max', '6'),
('palier_intermediaire_max', '11'),
('palier_maitre_max', '20'),
('xp_base_competence', '100');

-- --------------------------------------------------------

--
-- Structure de la table `equipements_personnage`
--

DROP TABLE IF EXISTS `equipements_personnage`;
CREATE TABLE IF NOT EXISTS `equipements_personnage` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `personnage_id` int UNSIGNED NOT NULL,
  `catalogue_slot_id` bigint UNSIGNED NOT NULL,
  `instance_objet_id` bigint UNSIGNED NOT NULL,
  `date_equipement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_mise_a_jour` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_equipements_personnage_personnage_slot` (`personnage_id`,`catalogue_slot_id`),
  UNIQUE KEY `uk_equipements_personnage_instance_objet_id` (`instance_objet_id`),
  KEY `idx_equipements_personnage_slot` (`catalogue_slot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `instances_objets`
--

DROP TABLE IF EXISTS `instances_objets`;
CREATE TABLE IF NOT EXISTS `instances_objets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `catalogue_objet_id` bigint UNSIGNED NOT NULL,
  `personnage_proprietaire_id` int UNSIGNED NOT NULL,
  `quantite` int NOT NULL DEFAULT '1',
  `durabilite_actuelle` int DEFAULT NULL,
  `durabilite_maximum` int DEFAULT NULL,
  `est_verrouille` tinyint(1) NOT NULL DEFAULT '0',
  `source_obtention` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_obtention` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_mise_a_jour` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_instances_objets_catalogue_objet_id` (`catalogue_objet_id`),
  KEY `idx_instances_objets_personnage_proprietaire_id` (`personnage_proprietaire_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inventaire_personnage_instances`
--

DROP TABLE IF EXISTS `inventaire_personnage_instances`;
CREATE TABLE IF NOT EXISTS `inventaire_personnage_instances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `personnage_id` int UNSIGNED NOT NULL,
  `catalogue_onglet_id` bigint UNSIGNED NOT NULL,
  `instance_objet_id` bigint UNSIGNED NOT NULL,
  `position_slot` int NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_mise_a_jour` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_inventaire_personnage_instances_instance_objet_id` (`instance_objet_id`),
  UNIQUE KEY `uk_inventaire_personnage_instances_personnage_onglet_position` (`personnage_id`,`catalogue_onglet_id`,`position_slot`),
  KEY `idx_inventaire_personnage_instances_catalogue_onglet_id` (`catalogue_onglet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `monde_cartes`
--

DROP TABLE IF EXISTS `monde_cartes`;
CREATE TABLE IF NOT EXISTS `monde_cartes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code_carte` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_carte` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `largeur_source` int NOT NULL,
  `hauteur_source` int NOT NULL,
  `zoom` decimal(6,2) NOT NULL,
  `largeur_affichee` int NOT NULL,
  `hauteur_affichee` int NOT NULL,
  `taille_case` int NOT NULL,
  `colonnes` int NOT NULL,
  `lignes` int NOT NULL,
  `total_cases` int NOT NULL,
  `actif` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `monde_cartes`
--

INSERT INTO `monde_cartes` (`id`, `code_carte`, `nom_carte`, `largeur_source`, `hauteur_source`, `zoom`, `largeur_affichee`, `hauteur_affichee`, `taille_case`, `colonnes`, `lignes`, `total_cases`, `actif`) VALUES
(1, 'monde_principal', 'Monde principal Elementia', 1536, 1024, 1.65, 2534, 1690, 64, 40, 27, 1080, 1);

-- --------------------------------------------------------

--
-- Structure de la table `monde_cases`
--

DROP TABLE IF EXISTS `monde_cases`;
CREATE TABLE IF NOT EXISTS `monde_cases` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code_carte` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colonne` int DEFAULT NULL,
  `ligne` int DEFAULT NULL,
  `type_case` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'vide',
  `est_traversable_pied` tinyint(1) DEFAULT '0',
  `est_traversable_monture` tinyint(1) DEFAULT '0',
  `est_traversable_bateau` tinyint(1) DEFAULT '0',
  `est_ponton` tinyint(1) DEFAULT '0',
  `est_ville` tinyint(1) DEFAULT '0',
  `est_zone_dangereuse` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1465 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `monde_cases`
--

INSERT INTO `monde_cases` (`id`, `code_carte`, `colonne`, `ligne`, `type_case`, `est_traversable_pied`, `est_traversable_monture`, `est_traversable_bateau`, `est_ponton`, `est_ville`, `est_zone_dangereuse`) VALUES
(385, 'monde_principal', 0, 0, 'eau', 0, 0, 1, 0, 0, 0),
(386, 'monde_principal', 1, 0, 'eau', 0, 0, 1, 0, 0, 0),
(387, 'monde_principal', 2, 0, 'eau', 0, 0, 1, 0, 0, 0),
(388, 'monde_principal', 3, 0, 'eau', 0, 0, 1, 0, 0, 0),
(389, 'monde_principal', 4, 0, 'eau', 0, 0, 1, 0, 0, 0),
(390, 'monde_principal', 5, 0, 'eau', 0, 0, 1, 0, 0, 0),
(391, 'monde_principal', 6, 0, 'eau', 0, 0, 1, 0, 0, 0),
(392, 'monde_principal', 7, 0, 'eau', 0, 0, 1, 0, 0, 0),
(393, 'monde_principal', 8, 0, 'eau', 0, 0, 1, 0, 0, 0),
(394, 'monde_principal', 9, 0, 'eau', 0, 0, 1, 0, 0, 0),
(395, 'monde_principal', 10, 0, 'eau', 0, 0, 1, 0, 0, 0),
(396, 'monde_principal', 11, 0, 'eau', 0, 0, 1, 0, 0, 0),
(397, 'monde_principal', 12, 0, 'eau', 0, 0, 1, 0, 0, 0),
(398, 'monde_principal', 13, 0, 'eau', 0, 0, 1, 0, 0, 0),
(399, 'monde_principal', 14, 0, 'eau', 0, 0, 1, 0, 0, 0),
(400, 'monde_principal', 15, 0, 'eau', 0, 0, 1, 0, 0, 0),
(401, 'monde_principal', 16, 0, 'eau', 0, 0, 1, 0, 0, 0),
(402, 'monde_principal', 17, 0, 'eau', 0, 0, 1, 0, 0, 0),
(403, 'monde_principal', 18, 0, 'eau', 0, 0, 1, 0, 0, 0),
(404, 'monde_principal', 19, 0, 'eau', 0, 0, 1, 0, 0, 0),
(405, 'monde_principal', 20, 0, 'eau', 0, 0, 1, 0, 0, 0),
(406, 'monde_principal', 21, 0, 'eau', 0, 0, 1, 0, 0, 0),
(407, 'monde_principal', 22, 0, 'eau', 0, 0, 1, 0, 0, 0),
(408, 'monde_principal', 23, 0, 'eau', 0, 0, 1, 0, 0, 0),
(409, 'monde_principal', 24, 0, 'eau', 0, 0, 1, 0, 0, 0),
(410, 'monde_principal', 25, 0, 'eau', 0, 0, 1, 0, 0, 0),
(411, 'monde_principal', 26, 0, 'eau', 0, 0, 1, 0, 0, 0),
(412, 'monde_principal', 27, 0, 'eau', 0, 0, 1, 0, 0, 0),
(413, 'monde_principal', 28, 0, 'eau', 0, 0, 1, 0, 0, 0),
(414, 'monde_principal', 29, 0, 'eau', 0, 0, 1, 0, 0, 0),
(415, 'monde_principal', 30, 0, 'eau', 0, 0, 1, 0, 0, 0),
(416, 'monde_principal', 31, 0, 'eau', 0, 0, 1, 0, 0, 0),
(417, 'monde_principal', 32, 0, 'eau', 0, 0, 1, 0, 0, 0),
(418, 'monde_principal', 33, 0, 'eau', 0, 0, 1, 0, 0, 0),
(419, 'monde_principal', 34, 0, 'eau', 0, 0, 1, 0, 0, 0),
(420, 'monde_principal', 35, 0, 'eau', 0, 0, 1, 0, 0, 0),
(421, 'monde_principal', 36, 0, 'eau', 0, 0, 1, 0, 0, 0),
(422, 'monde_principal', 37, 0, 'eau', 0, 0, 1, 0, 0, 0),
(423, 'monde_principal', 38, 0, 'eau', 0, 0, 1, 0, 0, 0),
(424, 'monde_principal', 39, 0, 'eau', 0, 0, 1, 0, 0, 0),
(425, 'monde_principal', 0, 1, 'eau', 0, 0, 1, 0, 0, 0),
(426, 'monde_principal', 1, 1, 'eau', 0, 0, 1, 0, 0, 0),
(427, 'monde_principal', 2, 1, 'eau', 0, 0, 1, 0, 0, 0),
(428, 'monde_principal', 3, 1, 'eau', 0, 0, 1, 0, 0, 0),
(429, 'monde_principal', 4, 1, 'eau', 0, 0, 1, 0, 0, 0),
(430, 'monde_principal', 5, 1, 'eau', 0, 0, 1, 0, 0, 0),
(431, 'monde_principal', 6, 1, 'eau', 0, 0, 1, 0, 0, 0),
(432, 'monde_principal', 7, 1, 'eau', 0, 0, 1, 0, 0, 0),
(433, 'monde_principal', 8, 1, 'eau', 0, 0, 1, 0, 0, 0),
(434, 'monde_principal', 9, 1, 'eau', 0, 0, 1, 0, 0, 0),
(435, 'monde_principal', 10, 1, 'eau', 0, 0, 1, 0, 0, 0),
(436, 'monde_principal', 11, 1, 'eau', 0, 0, 1, 0, 0, 0),
(437, 'monde_principal', 12, 1, 'eau', 0, 0, 1, 0, 0, 0),
(438, 'monde_principal', 13, 1, 'eau', 0, 0, 1, 0, 0, 0),
(439, 'monde_principal', 14, 1, 'eau', 0, 0, 1, 0, 0, 0),
(440, 'monde_principal', 15, 1, 'eau', 0, 0, 1, 0, 0, 0),
(441, 'monde_principal', 16, 1, 'eau', 0, 0, 1, 0, 0, 0),
(442, 'monde_principal', 17, 1, 'eau', 0, 0, 1, 0, 0, 0),
(443, 'monde_principal', 18, 1, 'eau', 0, 0, 1, 0, 0, 0),
(444, 'monde_principal', 19, 1, 'eau', 0, 0, 1, 0, 0, 0),
(445, 'monde_principal', 20, 1, 'eau', 0, 0, 1, 0, 0, 0),
(446, 'monde_principal', 21, 1, 'eau', 0, 0, 1, 0, 0, 0),
(447, 'monde_principal', 22, 1, 'eau', 0, 0, 1, 0, 0, 0),
(448, 'monde_principal', 23, 1, 'eau', 0, 0, 1, 0, 0, 0),
(449, 'monde_principal', 24, 1, 'eau', 0, 0, 1, 0, 0, 0),
(450, 'monde_principal', 25, 1, 'eau', 0, 0, 1, 0, 0, 0),
(451, 'monde_principal', 26, 1, 'eau', 0, 0, 1, 0, 0, 0),
(452, 'monde_principal', 27, 1, 'eau', 0, 0, 1, 0, 0, 0),
(453, 'monde_principal', 28, 1, 'eau', 0, 0, 1, 0, 0, 0),
(454, 'monde_principal', 29, 1, 'eau', 0, 0, 1, 0, 0, 0),
(455, 'monde_principal', 30, 1, 'eau', 0, 0, 1, 0, 0, 0),
(456, 'monde_principal', 31, 1, 'eau', 0, 0, 1, 0, 0, 0),
(457, 'monde_principal', 32, 1, 'eau', 0, 0, 1, 0, 0, 0),
(458, 'monde_principal', 33, 1, 'eau', 0, 0, 1, 0, 0, 0),
(459, 'monde_principal', 34, 1, 'eau', 0, 0, 1, 0, 0, 0),
(460, 'monde_principal', 35, 1, 'eau', 0, 0, 1, 0, 0, 0),
(461, 'monde_principal', 36, 1, 'eau', 0, 0, 1, 0, 0, 0),
(462, 'monde_principal', 37, 1, 'eau', 0, 0, 1, 0, 0, 0),
(463, 'monde_principal', 38, 1, 'eau', 0, 0, 1, 0, 0, 0),
(464, 'monde_principal', 39, 1, 'eau', 0, 0, 1, 0, 0, 0),
(465, 'monde_principal', 0, 2, 'eau', 0, 0, 1, 0, 0, 0),
(466, 'monde_principal', 1, 2, 'eau', 0, 0, 1, 0, 0, 0),
(467, 'monde_principal', 2, 2, 'eau', 0, 0, 1, 0, 0, 0),
(468, 'monde_principal', 3, 2, 'eau', 0, 0, 1, 0, 0, 0),
(469, 'monde_principal', 4, 2, 'eau', 0, 0, 1, 0, 0, 0),
(470, 'monde_principal', 5, 2, 'eau', 0, 0, 1, 0, 0, 0),
(471, 'monde_principal', 6, 2, 'eau', 0, 0, 1, 0, 0, 0),
(472, 'monde_principal', 7, 2, 'eau', 0, 0, 1, 0, 0, 0),
(473, 'monde_principal', 8, 2, 'eau', 0, 0, 1, 0, 0, 0),
(474, 'monde_principal', 9, 2, 'eau', 0, 0, 1, 0, 0, 0),
(475, 'monde_principal', 10, 2, 'plaine', 1, 1, 0, 0, 0, 0),
(476, 'monde_principal', 11, 2, 'plaine', 1, 1, 0, 0, 0, 0),
(477, 'monde_principal', 12, 2, 'eau', 0, 0, 1, 0, 0, 0),
(478, 'monde_principal', 13, 2, 'eau', 0, 0, 1, 0, 0, 0),
(479, 'monde_principal', 14, 2, 'eau', 0, 0, 1, 0, 0, 0),
(480, 'monde_principal', 15, 2, 'eau', 0, 0, 1, 0, 0, 0),
(481, 'monde_principal', 16, 2, 'eau', 0, 0, 1, 0, 0, 0),
(482, 'monde_principal', 17, 2, 'eau', 0, 0, 1, 0, 0, 0),
(483, 'monde_principal', 18, 2, 'eau', 0, 0, 1, 0, 0, 0),
(484, 'monde_principal', 19, 2, 'plaine', 1, 1, 0, 0, 0, 0),
(485, 'monde_principal', 20, 2, 'eau', 0, 0, 1, 0, 0, 0),
(486, 'monde_principal', 21, 2, 'eau', 0, 0, 1, 0, 0, 0),
(487, 'monde_principal', 22, 2, 'eau', 0, 0, 1, 0, 0, 0),
(488, 'monde_principal', 23, 2, 'eau', 0, 0, 1, 0, 0, 0),
(489, 'monde_principal', 24, 2, 'eau', 0, 0, 1, 0, 0, 0),
(490, 'monde_principal', 25, 2, 'eau', 0, 0, 1, 0, 0, 0),
(491, 'monde_principal', 26, 2, 'eau', 0, 0, 1, 0, 0, 0),
(492, 'monde_principal', 27, 2, 'eau', 0, 0, 1, 0, 0, 0),
(493, 'monde_principal', 28, 2, 'eau', 0, 0, 1, 0, 0, 0),
(494, 'monde_principal', 29, 2, 'eau', 0, 0, 1, 0, 0, 0),
(495, 'monde_principal', 30, 2, 'eau', 0, 0, 1, 0, 0, 0),
(496, 'monde_principal', 31, 2, 'eau', 0, 0, 1, 0, 0, 0),
(497, 'monde_principal', 32, 2, 'eau', 0, 0, 1, 0, 0, 0),
(498, 'monde_principal', 33, 2, 'eau', 0, 0, 1, 0, 0, 0),
(499, 'monde_principal', 34, 2, 'eau', 0, 0, 1, 0, 0, 0),
(500, 'monde_principal', 35, 2, 'eau', 0, 0, 1, 0, 0, 0),
(501, 'monde_principal', 36, 2, 'eau', 0, 0, 1, 0, 0, 0),
(502, 'monde_principal', 37, 2, 'eau', 0, 0, 1, 0, 0, 0),
(503, 'monde_principal', 38, 2, 'eau', 0, 0, 1, 0, 0, 0),
(504, 'monde_principal', 39, 2, 'eau', 0, 0, 1, 0, 0, 0),
(505, 'monde_principal', 0, 3, 'eau', 0, 0, 1, 0, 0, 0),
(506, 'monde_principal', 1, 3, 'eau', 0, 0, 1, 0, 0, 0),
(507, 'monde_principal', 2, 3, 'eau', 0, 0, 1, 0, 0, 0),
(508, 'monde_principal', 3, 3, 'eau', 0, 0, 1, 0, 0, 0),
(509, 'monde_principal', 4, 3, 'eau', 0, 0, 1, 0, 0, 0),
(510, 'monde_principal', 5, 3, 'eau', 0, 0, 1, 0, 0, 0),
(511, 'monde_principal', 6, 3, 'eau', 0, 0, 1, 0, 0, 0),
(512, 'monde_principal', 7, 3, 'eau', 0, 0, 1, 0, 0, 0),
(513, 'monde_principal', 8, 3, 'plaine', 1, 1, 0, 0, 0, 0),
(514, 'monde_principal', 9, 3, 'plaine', 1, 1, 0, 0, 0, 0),
(515, 'monde_principal', 10, 3, 'plaine', 1, 1, 0, 0, 0, 0),
(516, 'monde_principal', 11, 3, 'plaine', 1, 1, 0, 0, 0, 0),
(517, 'monde_principal', 12, 3, 'plaine', 1, 1, 0, 0, 0, 0),
(518, 'monde_principal', 13, 3, 'plaine', 1, 1, 0, 0, 0, 0),
(519, 'monde_principal', 14, 3, 'plaine', 1, 1, 0, 0, 0, 0),
(520, 'monde_principal', 15, 3, 'plaine', 1, 1, 0, 0, 0, 0),
(521, 'monde_principal', 16, 3, 'plaine', 1, 1, 0, 0, 0, 0),
(522, 'monde_principal', 17, 3, 'plaine', 1, 1, 0, 0, 0, 0),
(523, 'monde_principal', 18, 3, 'plaine', 1, 1, 0, 0, 0, 0),
(524, 'monde_principal', 19, 3, 'plaine', 1, 1, 0, 0, 0, 0),
(525, 'monde_principal', 20, 3, 'ponton', 1, 1, 0, 1, 0, 0),
(526, 'monde_principal', 21, 3, 'eau', 0, 0, 1, 0, 0, 0),
(527, 'monde_principal', 22, 3, 'eau', 0, 0, 1, 0, 0, 0),
(528, 'monde_principal', 23, 3, 'eau', 0, 0, 1, 0, 0, 0),
(529, 'monde_principal', 24, 3, 'plaine', 1, 1, 0, 0, 0, 0),
(530, 'monde_principal', 25, 3, 'eau', 0, 0, 1, 0, 0, 0),
(531, 'monde_principal', 26, 3, 'eau', 0, 0, 1, 0, 0, 0),
(532, 'monde_principal', 27, 3, 'eau', 0, 0, 1, 0, 0, 0),
(533, 'monde_principal', 28, 3, 'eau', 0, 0, 1, 0, 0, 0),
(534, 'monde_principal', 29, 3, 'eau', 0, 0, 1, 0, 0, 0),
(535, 'monde_principal', 30, 3, 'eau', 0, 0, 1, 0, 0, 0),
(536, 'monde_principal', 31, 3, 'eau', 0, 0, 1, 0, 0, 0),
(537, 'monde_principal', 32, 3, 'eau', 0, 0, 1, 0, 0, 0),
(538, 'monde_principal', 33, 3, 'eau', 0, 0, 1, 0, 0, 0),
(539, 'monde_principal', 34, 3, 'eau', 0, 0, 1, 0, 0, 0),
(540, 'monde_principal', 35, 3, 'eau', 0, 0, 1, 0, 0, 0),
(541, 'monde_principal', 36, 3, 'eau', 0, 0, 1, 0, 0, 0),
(542, 'monde_principal', 37, 3, 'eau', 0, 0, 1, 0, 0, 0),
(543, 'monde_principal', 38, 3, 'eau', 0, 0, 1, 0, 0, 0),
(544, 'monde_principal', 39, 3, 'eau', 0, 0, 1, 0, 0, 0),
(545, 'monde_principal', 0, 4, 'eau', 0, 0, 1, 0, 0, 0),
(546, 'monde_principal', 1, 4, 'eau', 0, 0, 1, 0, 0, 0),
(547, 'monde_principal', 2, 4, 'eau', 0, 0, 1, 0, 0, 0),
(548, 'monde_principal', 3, 4, 'eau', 0, 0, 1, 0, 0, 0),
(549, 'monde_principal', 4, 4, 'eau', 0, 0, 1, 0, 0, 0),
(550, 'monde_principal', 5, 4, 'eau', 0, 0, 1, 0, 0, 0),
(551, 'monde_principal', 6, 4, 'plaine', 1, 1, 0, 0, 0, 0),
(552, 'monde_principal', 7, 4, 'zone_speciale', 1, 1, 0, 0, 0, 0),
(553, 'monde_principal', 8, 4, 'zone_speciale', 1, 1, 0, 0, 0, 0),
(554, 'monde_principal', 9, 4, 'plaine', 1, 1, 0, 0, 0, 0),
(555, 'monde_principal', 10, 4, 'plaine', 1, 1, 0, 0, 0, 0),
(556, 'monde_principal', 11, 4, 'plaine', 1, 1, 0, 0, 0, 0),
(557, 'monde_principal', 12, 4, 'plaine', 1, 1, 0, 0, 0, 0),
(558, 'monde_principal', 13, 4, 'plaine', 1, 1, 0, 0, 0, 0),
(559, 'monde_principal', 14, 4, 'plaine', 1, 1, 0, 0, 0, 0),
(560, 'monde_principal', 15, 4, 'plaine', 1, 1, 0, 0, 0, 0),
(561, 'monde_principal', 16, 4, 'plaine', 1, 1, 0, 0, 0, 0),
(562, 'monde_principal', 17, 4, 'plaine', 1, 1, 0, 0, 0, 0),
(563, 'monde_principal', 18, 4, 'plaine', 1, 1, 0, 0, 0, 0),
(564, 'monde_principal', 19, 4, 'plaine', 1, 1, 0, 0, 0, 0),
(565, 'monde_principal', 20, 4, 'eau', 0, 0, 1, 0, 0, 0),
(566, 'monde_principal', 21, 4, 'eau', 0, 0, 1, 0, 0, 0),
(567, 'monde_principal', 22, 4, 'eau', 0, 0, 1, 0, 0, 0),
(568, 'monde_principal', 23, 4, 'eau', 0, 0, 1, 0, 0, 0),
(569, 'monde_principal', 24, 4, 'eau', 0, 0, 1, 0, 0, 0),
(570, 'monde_principal', 25, 4, 'eau', 0, 0, 1, 0, 0, 0),
(571, 'monde_principal', 26, 4, 'eau', 0, 0, 1, 0, 0, 0),
(572, 'monde_principal', 27, 4, 'eau', 0, 0, 1, 0, 0, 0),
(573, 'monde_principal', 28, 4, 'eau', 0, 0, 1, 0, 0, 0),
(574, 'monde_principal', 29, 4, 'eau', 0, 0, 1, 0, 0, 0),
(575, 'monde_principal', 30, 4, 'eau', 0, 0, 1, 0, 0, 0),
(576, 'monde_principal', 31, 4, 'eau', 0, 0, 1, 0, 0, 0),
(577, 'monde_principal', 32, 4, 'eau', 0, 0, 1, 0, 0, 0),
(578, 'monde_principal', 33, 4, 'eau', 0, 0, 1, 0, 0, 0),
(579, 'monde_principal', 34, 4, 'eau', 0, 0, 1, 0, 0, 0),
(580, 'monde_principal', 35, 4, 'eau', 0, 0, 1, 0, 0, 0),
(581, 'monde_principal', 36, 4, 'eau', 0, 0, 1, 0, 0, 0),
(582, 'monde_principal', 37, 4, 'eau', 0, 0, 1, 0, 0, 0),
(583, 'monde_principal', 38, 4, 'eau', 0, 0, 1, 0, 0, 0),
(584, 'monde_principal', 39, 4, 'eau', 0, 0, 1, 0, 0, 0),
(585, 'monde_principal', 0, 5, 'eau', 0, 0, 1, 0, 0, 0),
(586, 'monde_principal', 1, 5, 'eau', 0, 0, 1, 0, 0, 0),
(587, 'monde_principal', 2, 5, 'eau', 0, 0, 1, 0, 0, 0),
(588, 'monde_principal', 3, 5, 'eau', 0, 0, 1, 0, 0, 0),
(589, 'monde_principal', 4, 5, 'eau', 0, 0, 1, 0, 0, 0),
(590, 'monde_principal', 5, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(591, 'monde_principal', 6, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(592, 'monde_principal', 7, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(593, 'monde_principal', 8, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(594, 'monde_principal', 9, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(595, 'monde_principal', 10, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(596, 'monde_principal', 11, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(597, 'monde_principal', 12, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(598, 'monde_principal', 13, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(599, 'monde_principal', 14, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(600, 'monde_principal', 15, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(601, 'monde_principal', 16, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(602, 'monde_principal', 17, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(603, 'monde_principal', 18, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(604, 'monde_principal', 19, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(605, 'monde_principal', 20, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(606, 'monde_principal', 21, 5, 'eau', 0, 0, 1, 0, 0, 0),
(607, 'monde_principal', 22, 5, 'eau', 0, 0, 1, 0, 0, 0),
(608, 'monde_principal', 23, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(609, 'monde_principal', 24, 5, 'plaine', 1, 1, 0, 0, 0, 0),
(610, 'monde_principal', 25, 5, 'eau', 0, 0, 1, 0, 0, 0),
(611, 'monde_principal', 26, 5, 'eau', 0, 0, 1, 0, 0, 0),
(612, 'monde_principal', 27, 5, 'eau', 0, 0, 1, 0, 0, 0),
(613, 'monde_principal', 28, 5, 'zone_speciale', 1, 1, 0, 0, 0, 0),
(614, 'monde_principal', 29, 5, 'zone_speciale', 1, 1, 0, 0, 0, 0),
(615, 'monde_principal', 30, 5, 'eau', 0, 0, 1, 0, 0, 0),
(616, 'monde_principal', 31, 5, 'eau', 0, 0, 1, 0, 0, 0),
(617, 'monde_principal', 32, 5, 'eau', 0, 0, 1, 0, 0, 0),
(618, 'monde_principal', 33, 5, 'eau', 0, 0, 1, 0, 0, 0),
(619, 'monde_principal', 34, 5, 'eau', 0, 0, 1, 0, 0, 0),
(620, 'monde_principal', 35, 5, 'eau', 0, 0, 1, 0, 0, 0),
(621, 'monde_principal', 36, 5, 'eau', 0, 0, 1, 0, 0, 0),
(622, 'monde_principal', 37, 5, 'eau', 0, 0, 1, 0, 0, 0),
(623, 'monde_principal', 38, 5, 'eau', 0, 0, 1, 0, 0, 0),
(624, 'monde_principal', 39, 5, 'eau', 0, 0, 1, 0, 0, 0),
(625, 'monde_principal', 0, 6, 'eau', 0, 0, 1, 0, 0, 0),
(626, 'monde_principal', 1, 6, 'eau', 0, 0, 1, 0, 0, 0),
(627, 'monde_principal', 2, 6, 'eau', 0, 0, 1, 0, 0, 0),
(628, 'monde_principal', 3, 6, 'ponton', 1, 1, 0, 1, 0, 0),
(629, 'monde_principal', 4, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(630, 'monde_principal', 5, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(631, 'monde_principal', 6, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(632, 'monde_principal', 7, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(633, 'monde_principal', 8, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(634, 'monde_principal', 9, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(635, 'monde_principal', 10, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(636, 'monde_principal', 11, 6, 'ville', 1, 1, 0, 0, 1, 0),
(637, 'monde_principal', 12, 6, 'ville', 1, 1, 0, 0, 1, 0),
(638, 'monde_principal', 13, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(639, 'monde_principal', 14, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(640, 'monde_principal', 15, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(641, 'monde_principal', 16, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(642, 'monde_principal', 17, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(643, 'monde_principal', 18, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(644, 'monde_principal', 19, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(645, 'monde_principal', 20, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(646, 'monde_principal', 21, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(647, 'monde_principal', 22, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(648, 'monde_principal', 23, 6, 'plaine', 1, 1, 0, 0, 0, 0),
(649, 'monde_principal', 24, 6, 'eau', 0, 0, 1, 0, 0, 0),
(650, 'monde_principal', 25, 6, 'eau', 0, 0, 1, 0, 0, 0),
(651, 'monde_principal', 26, 6, 'eau', 0, 0, 1, 0, 0, 0),
(652, 'monde_principal', 27, 6, 'eau', 0, 0, 1, 0, 0, 0),
(653, 'monde_principal', 28, 6, 'zone_speciale', 1, 1, 0, 0, 0, 0),
(654, 'monde_principal', 29, 6, 'zone_speciale', 1, 1, 0, 0, 0, 0),
(655, 'monde_principal', 30, 6, 'eau', 0, 0, 1, 0, 0, 0),
(656, 'monde_principal', 31, 6, 'eau', 0, 0, 1, 0, 0, 0),
(657, 'monde_principal', 32, 6, 'eau', 0, 0, 1, 0, 0, 0),
(658, 'monde_principal', 33, 6, 'eau', 0, 0, 1, 0, 0, 0),
(659, 'monde_principal', 34, 6, 'eau', 0, 0, 1, 0, 0, 0),
(660, 'monde_principal', 35, 6, 'eau', 0, 0, 1, 0, 0, 0),
(661, 'monde_principal', 36, 6, 'eau', 0, 0, 1, 0, 0, 0),
(662, 'monde_principal', 37, 6, 'eau', 0, 0, 1, 0, 0, 0),
(663, 'monde_principal', 38, 6, 'eau', 0, 0, 1, 0, 0, 0),
(664, 'monde_principal', 39, 6, 'eau', 0, 0, 1, 0, 0, 0),
(665, 'monde_principal', 0, 7, 'eau', 0, 0, 1, 0, 0, 0),
(666, 'monde_principal', 1, 7, 'eau', 0, 0, 1, 0, 0, 0),
(667, 'monde_principal', 2, 7, 'eau', 0, 0, 1, 0, 0, 0),
(668, 'monde_principal', 3, 7, 'eau', 0, 0, 1, 0, 0, 0),
(669, 'monde_principal', 4, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(670, 'monde_principal', 5, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(671, 'monde_principal', 6, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(672, 'monde_principal', 7, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(673, 'monde_principal', 8, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(674, 'monde_principal', 9, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(675, 'monde_principal', 10, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(676, 'monde_principal', 11, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(677, 'monde_principal', 12, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(678, 'monde_principal', 13, 7, 'foret', 1, 1, 0, 0, 0, 0),
(679, 'monde_principal', 14, 7, 'foret', 1, 1, 0, 0, 0, 0),
(680, 'monde_principal', 15, 7, 'montagne', 0, 0, 0, 0, 0, 0),
(681, 'monde_principal', 16, 7, 'montagne', 0, 0, 0, 0, 0, 0),
(682, 'monde_principal', 17, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(683, 'monde_principal', 18, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(684, 'monde_principal', 19, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(685, 'monde_principal', 20, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(686, 'monde_principal', 21, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(687, 'monde_principal', 22, 7, 'plaine', 1, 1, 0, 0, 0, 0),
(688, 'monde_principal', 23, 7, 'eau', 0, 0, 1, 0, 0, 0),
(689, 'monde_principal', 24, 7, 'eau', 0, 0, 1, 0, 0, 0),
(690, 'monde_principal', 25, 7, 'eau', 0, 0, 1, 0, 0, 0),
(691, 'monde_principal', 26, 7, 'eau', 0, 0, 1, 0, 0, 0),
(692, 'monde_principal', 27, 7, 'eau', 0, 0, 1, 0, 0, 0),
(693, 'monde_principal', 28, 7, 'eau', 0, 0, 1, 0, 0, 0),
(694, 'monde_principal', 29, 7, 'eau', 0, 0, 1, 0, 0, 0),
(695, 'monde_principal', 30, 7, 'eau', 0, 0, 1, 0, 0, 0),
(696, 'monde_principal', 31, 7, 'eau', 0, 0, 1, 0, 0, 0),
(697, 'monde_principal', 32, 7, 'eau', 0, 0, 1, 0, 0, 0),
(698, 'monde_principal', 33, 7, 'eau', 0, 0, 1, 0, 0, 0),
(699, 'monde_principal', 34, 7, 'eau', 0, 0, 1, 0, 0, 0),
(700, 'monde_principal', 35, 7, 'eau', 0, 0, 1, 0, 0, 0),
(701, 'monde_principal', 36, 7, 'eau', 0, 0, 1, 0, 0, 0),
(702, 'monde_principal', 37, 7, 'eau', 0, 0, 1, 0, 0, 0),
(703, 'monde_principal', 38, 7, 'eau', 0, 0, 1, 0, 0, 0),
(704, 'monde_principal', 39, 7, 'eau', 0, 0, 1, 0, 0, 0),
(705, 'monde_principal', 0, 8, 'eau', 0, 0, 1, 0, 0, 0),
(706, 'monde_principal', 1, 8, 'eau', 0, 0, 1, 0, 0, 0),
(707, 'monde_principal', 2, 8, 'eau', 0, 0, 1, 0, 0, 0),
(708, 'monde_principal', 3, 8, 'eau', 0, 0, 1, 0, 0, 0),
(709, 'monde_principal', 4, 8, 'eau', 0, 0, 1, 0, 0, 0),
(710, 'monde_principal', 5, 8, 'eau', 0, 0, 1, 0, 0, 0),
(711, 'monde_principal', 6, 8, 'plaine', 1, 1, 0, 0, 0, 0),
(712, 'monde_principal', 7, 8, 'plaine', 1, 1, 0, 0, 0, 0),
(713, 'monde_principal', 8, 8, 'plaine', 1, 1, 0, 0, 0, 0),
(714, 'monde_principal', 9, 8, 'plaine', 1, 1, 0, 0, 0, 0),
(715, 'monde_principal', 10, 8, 'plaine', 1, 1, 0, 0, 0, 0),
(716, 'monde_principal', 11, 8, 'plaine', 1, 1, 0, 0, 0, 0),
(717, 'monde_principal', 12, 8, 'plaine', 1, 1, 0, 0, 0, 0),
(718, 'monde_principal', 13, 8, 'foret', 1, 1, 0, 0, 0, 0),
(719, 'monde_principal', 14, 8, 'foret', 1, 1, 0, 0, 0, 0),
(720, 'monde_principal', 15, 8, 'plaine', 1, 1, 0, 0, 0, 0),
(721, 'monde_principal', 16, 8, 'montagne', 0, 0, 0, 0, 0, 0),
(722, 'monde_principal', 17, 8, 'montagne', 0, 0, 0, 0, 0, 0),
(723, 'monde_principal', 18, 8, 'montagne', 0, 0, 0, 0, 0, 0),
(724, 'monde_principal', 19, 8, 'plaine', 1, 1, 0, 0, 0, 0),
(725, 'monde_principal', 20, 8, 'plaine', 1, 1, 0, 0, 0, 0),
(726, 'monde_principal', 21, 8, 'eau', 0, 0, 1, 0, 0, 0),
(727, 'monde_principal', 22, 8, 'eau', 0, 0, 1, 0, 0, 0),
(728, 'monde_principal', 23, 8, 'eau', 0, 0, 1, 0, 0, 0),
(729, 'monde_principal', 24, 8, 'eau', 0, 0, 1, 0, 0, 0),
(730, 'monde_principal', 25, 8, 'eau', 0, 0, 1, 0, 0, 0),
(731, 'monde_principal', 26, 8, 'eau', 0, 0, 1, 0, 0, 0),
(732, 'monde_principal', 27, 8, 'eau', 0, 0, 1, 0, 0, 0),
(733, 'monde_principal', 28, 8, 'eau', 0, 0, 1, 0, 0, 0),
(734, 'monde_principal', 29, 8, 'eau', 0, 0, 1, 0, 0, 0),
(735, 'monde_principal', 30, 8, 'eau', 0, 0, 1, 0, 0, 0),
(736, 'monde_principal', 31, 8, 'eau', 0, 0, 1, 0, 0, 0),
(737, 'monde_principal', 32, 8, 'eau', 0, 0, 1, 0, 0, 0),
(738, 'monde_principal', 33, 8, 'eau', 0, 0, 1, 0, 0, 0),
(739, 'monde_principal', 34, 8, 'eau', 0, 0, 1, 0, 0, 0),
(740, 'monde_principal', 35, 8, 'eau', 0, 0, 1, 0, 0, 0),
(741, 'monde_principal', 36, 8, 'eau', 0, 0, 1, 0, 0, 0),
(742, 'monde_principal', 37, 8, 'eau', 0, 0, 1, 0, 0, 0),
(743, 'monde_principal', 38, 8, 'eau', 0, 0, 1, 0, 0, 0),
(744, 'monde_principal', 39, 8, 'eau', 0, 0, 1, 0, 0, 0),
(745, 'monde_principal', 0, 9, 'eau', 0, 0, 1, 0, 0, 0),
(746, 'monde_principal', 1, 9, 'eau', 0, 0, 1, 0, 0, 0),
(747, 'monde_principal', 2, 9, 'eau', 0, 0, 1, 0, 0, 0),
(748, 'monde_principal', 3, 9, 'eau', 0, 0, 1, 0, 0, 0),
(749, 'monde_principal', 4, 9, 'eau', 0, 0, 1, 0, 0, 0),
(750, 'monde_principal', 5, 9, 'eau', 0, 0, 1, 0, 0, 0),
(751, 'monde_principal', 6, 9, 'eau', 0, 0, 1, 0, 0, 0),
(752, 'monde_principal', 7, 9, 'plaine', 1, 1, 0, 0, 0, 0),
(753, 'monde_principal', 8, 9, 'plaine', 1, 1, 0, 0, 0, 0),
(754, 'monde_principal', 9, 9, 'plaine', 1, 1, 0, 0, 0, 0),
(755, 'monde_principal', 10, 9, 'plaine', 1, 1, 0, 0, 0, 0),
(756, 'monde_principal', 11, 9, 'plaine', 1, 1, 0, 0, 0, 0),
(757, 'monde_principal', 12, 9, 'plaine', 1, 1, 0, 0, 0, 0),
(758, 'monde_principal', 13, 9, 'plaine', 1, 1, 0, 0, 0, 0),
(759, 'monde_principal', 14, 9, 'plaine', 1, 1, 0, 0, 0, 0),
(760, 'monde_principal', 15, 9, 'plaine', 1, 1, 0, 0, 0, 0),
(761, 'monde_principal', 16, 9, 'montagne', 0, 0, 0, 0, 0, 0),
(762, 'monde_principal', 17, 9, 'plaine', 1, 1, 0, 0, 0, 0),
(763, 'monde_principal', 18, 9, 'plaine', 1, 1, 0, 0, 0, 0),
(764, 'monde_principal', 19, 9, 'plaine', 1, 1, 0, 0, 0, 0),
(765, 'monde_principal', 20, 9, 'plaine', 1, 1, 0, 0, 0, 0),
(766, 'monde_principal', 21, 9, 'plaine', 1, 1, 0, 0, 0, 0),
(767, 'monde_principal', 22, 9, 'eau', 0, 0, 1, 0, 0, 0),
(768, 'monde_principal', 23, 9, 'ville', 1, 1, 0, 0, 1, 0),
(769, 'monde_principal', 24, 9, 'ville', 1, 1, 0, 0, 1, 0),
(770, 'monde_principal', 25, 9, 'eau', 0, 0, 1, 0, 0, 0),
(771, 'monde_principal', 26, 9, 'eau', 0, 0, 1, 0, 0, 0),
(772, 'monde_principal', 27, 9, 'eau', 0, 0, 1, 0, 0, 0),
(773, 'monde_principal', 28, 9, 'eau', 0, 0, 1, 0, 0, 0),
(774, 'monde_principal', 29, 9, 'eau', 0, 0, 1, 0, 0, 0),
(775, 'monde_principal', 30, 9, 'eau', 0, 0, 1, 0, 0, 0),
(776, 'monde_principal', 31, 9, 'eau', 0, 0, 1, 0, 0, 0),
(777, 'monde_principal', 32, 9, 'eau', 0, 0, 1, 0, 0, 0),
(778, 'monde_principal', 33, 9, 'eau', 0, 0, 1, 0, 0, 0),
(779, 'monde_principal', 34, 9, 'eau', 0, 0, 1, 0, 0, 0),
(780, 'monde_principal', 35, 9, 'eau', 0, 0, 1, 0, 0, 0),
(781, 'monde_principal', 36, 9, 'eau', 0, 0, 1, 0, 0, 0),
(782, 'monde_principal', 37, 9, 'eau', 0, 0, 1, 0, 0, 0),
(783, 'monde_principal', 38, 9, 'eau', 0, 0, 1, 0, 0, 0),
(784, 'monde_principal', 39, 9, 'eau', 0, 0, 1, 0, 0, 0),
(785, 'monde_principal', 0, 10, 'eau', 0, 0, 1, 0, 0, 0),
(786, 'monde_principal', 1, 10, 'eau', 0, 0, 1, 0, 0, 0),
(787, 'monde_principal', 2, 10, 'eau', 0, 0, 1, 0, 0, 0),
(788, 'monde_principal', 3, 10, 'eau', 0, 0, 1, 0, 0, 0),
(789, 'monde_principal', 4, 10, 'eau', 0, 0, 1, 0, 0, 0),
(790, 'monde_principal', 5, 10, 'eau', 0, 0, 1, 0, 0, 0),
(791, 'monde_principal', 6, 10, 'eau', 0, 0, 1, 0, 0, 0),
(792, 'monde_principal', 7, 10, 'eau', 0, 0, 1, 0, 0, 0),
(793, 'monde_principal', 8, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(794, 'monde_principal', 9, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(795, 'monde_principal', 10, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(796, 'monde_principal', 11, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(797, 'monde_principal', 12, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(798, 'monde_principal', 13, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(799, 'monde_principal', 14, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(800, 'monde_principal', 15, 10, 'montagne', 0, 0, 0, 0, 0, 0),
(801, 'monde_principal', 16, 10, 'montagne', 0, 0, 0, 0, 0, 0),
(802, 'monde_principal', 17, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(803, 'monde_principal', 18, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(804, 'monde_principal', 19, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(805, 'monde_principal', 20, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(806, 'monde_principal', 21, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(807, 'monde_principal', 22, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(808, 'monde_principal', 23, 10, 'eau', 0, 0, 1, 0, 0, 0),
(809, 'monde_principal', 24, 10, 'eau', 0, 0, 1, 0, 0, 0),
(810, 'monde_principal', 25, 10, 'eau', 0, 0, 1, 0, 0, 0),
(811, 'monde_principal', 26, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(812, 'monde_principal', 27, 10, 'plaine', 1, 1, 0, 0, 0, 0),
(813, 'monde_principal', 28, 10, 'eau', 0, 0, 1, 0, 0, 0),
(814, 'monde_principal', 29, 10, 'eau', 0, 0, 1, 0, 0, 0),
(815, 'monde_principal', 30, 10, 'eau', 0, 0, 1, 0, 0, 0),
(816, 'monde_principal', 31, 10, 'eau', 0, 0, 1, 0, 0, 0),
(817, 'monde_principal', 32, 10, 'eau', 0, 0, 1, 0, 0, 0),
(818, 'monde_principal', 33, 10, 'eau', 0, 0, 1, 0, 0, 0),
(819, 'monde_principal', 34, 10, 'eau', 0, 0, 1, 0, 0, 0),
(820, 'monde_principal', 35, 10, 'eau', 0, 0, 1, 0, 0, 0),
(821, 'monde_principal', 36, 10, 'eau', 0, 0, 1, 0, 0, 0),
(822, 'monde_principal', 37, 10, 'eau', 0, 0, 1, 0, 0, 0),
(823, 'monde_principal', 38, 10, 'eau', 0, 0, 1, 0, 0, 0),
(824, 'monde_principal', 39, 10, 'eau', 0, 0, 1, 0, 0, 0),
(825, 'monde_principal', 0, 11, 'eau', 0, 0, 1, 0, 0, 0),
(826, 'monde_principal', 1, 11, 'eau', 0, 0, 1, 0, 0, 0),
(827, 'monde_principal', 2, 11, 'eau', 0, 0, 1, 0, 0, 0),
(828, 'monde_principal', 3, 11, 'eau', 0, 0, 1, 0, 0, 0),
(829, 'monde_principal', 4, 11, 'eau', 0, 0, 1, 0, 0, 0),
(830, 'monde_principal', 5, 11, 'eau', 0, 0, 1, 0, 0, 0),
(831, 'monde_principal', 6, 11, 'eau', 0, 0, 1, 0, 0, 0),
(832, 'monde_principal', 7, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(833, 'monde_principal', 8, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(834, 'monde_principal', 9, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(835, 'monde_principal', 10, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(836, 'monde_principal', 11, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(837, 'monde_principal', 12, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(838, 'monde_principal', 13, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(839, 'monde_principal', 14, 11, 'montagne', 0, 0, 0, 0, 0, 0),
(840, 'monde_principal', 15, 11, 'montagne', 0, 0, 0, 0, 0, 0),
(841, 'monde_principal', 16, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(842, 'monde_principal', 17, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(843, 'monde_principal', 18, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(844, 'monde_principal', 19, 11, 'montagne', 0, 0, 0, 0, 0, 0),
(845, 'monde_principal', 20, 11, 'montagne', 0, 0, 0, 0, 0, 0),
(846, 'monde_principal', 21, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(847, 'monde_principal', 22, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(848, 'monde_principal', 23, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(849, 'monde_principal', 24, 11, 'eau', 0, 0, 1, 0, 0, 0),
(850, 'monde_principal', 25, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(851, 'monde_principal', 26, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(852, 'monde_principal', 27, 11, 'plaine', 1, 1, 0, 0, 0, 0),
(853, 'monde_principal', 28, 11, 'eau', 0, 0, 1, 0, 0, 0),
(854, 'monde_principal', 29, 11, 'eau', 0, 0, 1, 0, 0, 0),
(855, 'monde_principal', 30, 11, 'eau', 0, 0, 1, 0, 0, 0),
(856, 'monde_principal', 31, 11, 'eau', 0, 0, 1, 0, 0, 0),
(857, 'monde_principal', 32, 11, 'eau', 0, 0, 1, 0, 0, 0),
(858, 'monde_principal', 33, 11, 'eau', 0, 0, 1, 0, 0, 0),
(859, 'monde_principal', 34, 11, 'eau', 0, 0, 1, 0, 0, 0),
(860, 'monde_principal', 35, 11, 'eau', 0, 0, 1, 0, 0, 0),
(861, 'monde_principal', 36, 11, 'eau', 0, 0, 1, 0, 0, 0),
(862, 'monde_principal', 37, 11, 'eau', 0, 0, 1, 0, 0, 0),
(863, 'monde_principal', 38, 11, 'eau', 0, 0, 1, 0, 0, 0),
(864, 'monde_principal', 39, 11, 'eau', 0, 0, 1, 0, 0, 0),
(865, 'monde_principal', 0, 12, 'eau', 0, 0, 1, 0, 0, 0),
(866, 'monde_principal', 1, 12, 'eau', 0, 0, 1, 0, 0, 0),
(867, 'monde_principal', 2, 12, 'eau', 0, 0, 1, 0, 0, 0),
(868, 'monde_principal', 3, 12, 'eau', 0, 0, 1, 0, 0, 0),
(869, 'monde_principal', 4, 12, 'eau', 0, 0, 1, 0, 0, 0),
(870, 'monde_principal', 5, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(871, 'monde_principal', 6, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(872, 'monde_principal', 7, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(873, 'monde_principal', 8, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(874, 'monde_principal', 9, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(875, 'monde_principal', 10, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(876, 'monde_principal', 11, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(877, 'monde_principal', 12, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(878, 'monde_principal', 13, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(879, 'monde_principal', 14, 12, 'montagne', 0, 0, 0, 0, 0, 0),
(880, 'monde_principal', 15, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(881, 'monde_principal', 16, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(882, 'monde_principal', 17, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(883, 'monde_principal', 18, 12, 'ville', 1, 1, 0, 0, 1, 0),
(884, 'monde_principal', 19, 12, 'montagne', 0, 0, 0, 0, 0, 0),
(885, 'monde_principal', 20, 12, 'montagne', 0, 0, 0, 0, 0, 0),
(886, 'monde_principal', 21, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(887, 'monde_principal', 22, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(888, 'monde_principal', 23, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(889, 'monde_principal', 24, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(890, 'monde_principal', 25, 12, 'foret', 1, 1, 0, 0, 0, 0),
(891, 'monde_principal', 26, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(892, 'monde_principal', 27, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(893, 'monde_principal', 28, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(894, 'monde_principal', 29, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(895, 'monde_principal', 30, 12, 'ponton', 1, 1, 0, 1, 0, 0),
(896, 'monde_principal', 31, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(897, 'monde_principal', 32, 12, 'plaine', 1, 1, 0, 0, 0, 0),
(898, 'monde_principal', 33, 12, 'eau', 0, 0, 1, 0, 0, 0),
(899, 'monde_principal', 34, 12, 'eau', 0, 0, 1, 0, 0, 0),
(900, 'monde_principal', 35, 12, 'eau', 0, 0, 1, 0, 0, 0),
(901, 'monde_principal', 36, 12, 'eau', 0, 0, 1, 0, 0, 0),
(902, 'monde_principal', 37, 12, 'eau', 0, 0, 1, 0, 0, 0),
(903, 'monde_principal', 38, 12, 'eau', 0, 0, 1, 0, 0, 0),
(904, 'monde_principal', 39, 12, 'eau', 0, 0, 1, 0, 0, 0),
(905, 'monde_principal', 0, 13, 'eau', 0, 0, 1, 0, 0, 0),
(906, 'monde_principal', 1, 13, 'eau', 0, 0, 1, 0, 0, 0),
(907, 'monde_principal', 2, 13, 'eau', 0, 0, 1, 0, 0, 0),
(908, 'monde_principal', 3, 13, 'eau', 0, 0, 1, 0, 0, 0),
(909, 'monde_principal', 4, 13, 'eau', 0, 0, 1, 0, 0, 0),
(910, 'monde_principal', 5, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(911, 'monde_principal', 6, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(912, 'monde_principal', 7, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(913, 'monde_principal', 8, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(914, 'monde_principal', 9, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(915, 'monde_principal', 10, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(916, 'monde_principal', 11, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(917, 'monde_principal', 12, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(918, 'monde_principal', 13, 13, 'montagne', 0, 0, 0, 0, 0, 0),
(919, 'monde_principal', 14, 13, 'montagne', 0, 0, 0, 0, 0, 0),
(920, 'monde_principal', 15, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(921, 'monde_principal', 16, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(922, 'monde_principal', 17, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(923, 'monde_principal', 18, 13, 'ville', 1, 1, 0, 0, 1, 0),
(924, 'monde_principal', 19, 13, 'montagne', 0, 0, 0, 0, 0, 0),
(925, 'monde_principal', 20, 13, 'montagne', 0, 0, 0, 0, 0, 0),
(926, 'monde_principal', 21, 13, 'montagne', 0, 0, 0, 0, 0, 0),
(927, 'monde_principal', 22, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(928, 'monde_principal', 23, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(929, 'monde_principal', 24, 13, 'foret', 1, 1, 0, 0, 0, 0),
(930, 'monde_principal', 25, 13, 'foret', 1, 1, 0, 0, 0, 0),
(931, 'monde_principal', 26, 13, 'foret', 1, 1, 0, 0, 0, 0),
(932, 'monde_principal', 27, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(933, 'monde_principal', 28, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(934, 'monde_principal', 29, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(935, 'monde_principal', 30, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(936, 'monde_principal', 31, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(937, 'monde_principal', 32, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(938, 'monde_principal', 33, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(939, 'monde_principal', 34, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(940, 'monde_principal', 35, 13, 'plaine', 1, 1, 0, 0, 0, 0),
(941, 'monde_principal', 36, 13, 'eau', 0, 0, 1, 0, 0, 0),
(942, 'monde_principal', 37, 13, 'eau', 0, 0, 1, 0, 0, 0),
(943, 'monde_principal', 38, 13, 'eau', 0, 0, 1, 0, 0, 0),
(944, 'monde_principal', 39, 13, 'eau', 0, 0, 1, 0, 0, 0),
(945, 'monde_principal', 0, 14, 'eau', 0, 0, 1, 0, 0, 0),
(946, 'monde_principal', 1, 14, 'eau', 0, 0, 1, 0, 0, 0),
(947, 'monde_principal', 2, 14, 'eau', 0, 0, 1, 0, 0, 0),
(948, 'monde_principal', 3, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(949, 'monde_principal', 4, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(950, 'monde_principal', 5, 14, 'foret', 1, 1, 0, 0, 0, 0),
(951, 'monde_principal', 6, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(952, 'monde_principal', 7, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(953, 'monde_principal', 8, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(954, 'monde_principal', 9, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(955, 'monde_principal', 10, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(956, 'monde_principal', 11, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(957, 'monde_principal', 12, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(958, 'monde_principal', 13, 14, 'montagne', 0, 0, 0, 0, 0, 0),
(959, 'monde_principal', 14, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(960, 'monde_principal', 15, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(961, 'monde_principal', 16, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(962, 'monde_principal', 17, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(963, 'monde_principal', 18, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(964, 'monde_principal', 19, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(965, 'monde_principal', 20, 14, 'montagne', 0, 0, 0, 0, 0, 0),
(966, 'monde_principal', 21, 14, 'montagne', 0, 0, 0, 0, 0, 0),
(967, 'monde_principal', 22, 14, 'montagne', 0, 0, 0, 0, 0, 0),
(968, 'monde_principal', 23, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(969, 'monde_principal', 24, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(970, 'monde_principal', 25, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(971, 'monde_principal', 26, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(972, 'monde_principal', 27, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(973, 'monde_principal', 28, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(974, 'monde_principal', 29, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(975, 'monde_principal', 30, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(976, 'monde_principal', 31, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(977, 'monde_principal', 32, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(978, 'monde_principal', 33, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(979, 'monde_principal', 34, 14, 'plaine', 1, 1, 0, 0, 0, 0),
(980, 'monde_principal', 35, 14, 'eau', 0, 0, 1, 0, 0, 0),
(981, 'monde_principal', 36, 14, 'eau', 0, 0, 1, 0, 0, 0),
(982, 'monde_principal', 37, 14, 'eau', 0, 0, 1, 0, 0, 0),
(983, 'monde_principal', 38, 14, 'eau', 0, 0, 1, 0, 0, 0),
(984, 'monde_principal', 39, 14, 'eau', 0, 0, 1, 0, 0, 0),
(985, 'monde_principal', 0, 15, 'eau', 0, 0, 1, 0, 0, 0),
(986, 'monde_principal', 1, 15, 'eau', 0, 0, 1, 0, 0, 0),
(987, 'monde_principal', 2, 15, 'eau', 0, 0, 1, 0, 0, 0),
(988, 'monde_principal', 3, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(989, 'monde_principal', 4, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(990, 'monde_principal', 5, 15, 'foret', 1, 1, 0, 0, 0, 0),
(991, 'monde_principal', 6, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(992, 'monde_principal', 7, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(993, 'monde_principal', 8, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(994, 'monde_principal', 9, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(995, 'monde_principal', 10, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(996, 'monde_principal', 11, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(997, 'monde_principal', 12, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(998, 'monde_principal', 13, 15, 'montagne', 0, 0, 0, 0, 0, 0),
(999, 'monde_principal', 14, 15, 'montagne', 0, 0, 0, 0, 0, 0),
(1000, 'monde_principal', 15, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1001, 'monde_principal', 16, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1002, 'monde_principal', 17, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1003, 'monde_principal', 18, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1004, 'monde_principal', 19, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1005, 'monde_principal', 20, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1006, 'monde_principal', 21, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1007, 'monde_principal', 22, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1008, 'monde_principal', 23, 15, 'montagne', 0, 0, 0, 0, 0, 0),
(1009, 'monde_principal', 24, 15, 'montagne', 0, 0, 0, 0, 0, 0),
(1010, 'monde_principal', 25, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1011, 'monde_principal', 26, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1012, 'monde_principal', 27, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1013, 'monde_principal', 28, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1014, 'monde_principal', 29, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1015, 'monde_principal', 30, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1016, 'monde_principal', 31, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1017, 'monde_principal', 32, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1018, 'monde_principal', 33, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1019, 'monde_principal', 34, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1020, 'monde_principal', 35, 15, 'plaine', 1, 1, 0, 0, 0, 0),
(1021, 'monde_principal', 36, 15, 'eau', 0, 0, 1, 0, 0, 0),
(1022, 'monde_principal', 37, 15, 'eau', 0, 0, 1, 0, 0, 0),
(1023, 'monde_principal', 38, 15, 'eau', 0, 0, 1, 0, 0, 0),
(1024, 'monde_principal', 39, 15, 'eau', 0, 0, 1, 0, 0, 0),
(1025, 'monde_principal', 0, 16, 'eau', 0, 0, 1, 0, 0, 0),
(1026, 'monde_principal', 1, 16, 'eau', 0, 0, 1, 0, 0, 0),
(1027, 'monde_principal', 2, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1028, 'monde_principal', 3, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1029, 'monde_principal', 4, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1030, 'monde_principal', 5, 16, 'foret', 1, 1, 0, 0, 0, 0),
(1031, 'monde_principal', 6, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1032, 'monde_principal', 7, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1033, 'monde_principal', 8, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1034, 'monde_principal', 9, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1035, 'monde_principal', 10, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1036, 'monde_principal', 11, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1037, 'monde_principal', 12, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1038, 'monde_principal', 13, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1039, 'monde_principal', 14, 16, 'montagne', 0, 0, 0, 0, 0, 0),
(1040, 'monde_principal', 15, 16, 'montagne', 0, 0, 0, 0, 0, 0),
(1041, 'monde_principal', 16, 16, 'montagne', 0, 0, 0, 0, 0, 0),
(1042, 'monde_principal', 17, 16, 'montagne', 0, 0, 0, 0, 0, 0),
(1043, 'monde_principal', 18, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1044, 'monde_principal', 19, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1045, 'monde_principal', 20, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1046, 'monde_principal', 21, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1047, 'monde_principal', 22, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1048, 'monde_principal', 23, 16, 'montagne', 0, 0, 0, 0, 0, 0),
(1049, 'monde_principal', 24, 16, 'montagne', 0, 0, 0, 0, 0, 0),
(1050, 'monde_principal', 25, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1051, 'monde_principal', 26, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1052, 'monde_principal', 27, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1053, 'monde_principal', 28, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1054, 'monde_principal', 29, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1055, 'monde_principal', 30, 16, 'ville', 1, 1, 0, 0, 1, 0),
(1056, 'monde_principal', 31, 16, 'ville', 1, 1, 0, 0, 1, 0),
(1057, 'monde_principal', 32, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1058, 'monde_principal', 33, 16, 'plaine', 1, 1, 0, 0, 0, 0),
(1059, 'monde_principal', 34, 16, 'eau', 0, 0, 1, 0, 0, 0),
(1060, 'monde_principal', 35, 16, 'eau', 0, 0, 1, 0, 0, 0),
(1061, 'monde_principal', 36, 16, 'eau', 0, 0, 1, 0, 0, 0),
(1062, 'monde_principal', 37, 16, 'eau', 0, 0, 1, 0, 0, 0),
(1063, 'monde_principal', 38, 16, 'eau', 0, 0, 1, 0, 0, 0),
(1064, 'monde_principal', 39, 16, 'eau', 0, 0, 1, 0, 0, 0),
(1065, 'monde_principal', 0, 17, 'eau', 0, 0, 1, 0, 0, 0),
(1066, 'monde_principal', 1, 17, 'eau', 0, 0, 1, 0, 0, 0),
(1067, 'monde_principal', 2, 17, 'eau', 0, 0, 1, 0, 0, 0),
(1068, 'monde_principal', 3, 17, 'eau', 0, 0, 1, 0, 0, 0),
(1069, 'monde_principal', 4, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1070, 'monde_principal', 5, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1071, 'monde_principal', 6, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1072, 'monde_principal', 7, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1073, 'monde_principal', 8, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1074, 'monde_principal', 9, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1075, 'monde_principal', 10, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1076, 'monde_principal', 11, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1077, 'monde_principal', 12, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1078, 'monde_principal', 13, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1079, 'monde_principal', 14, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1080, 'monde_principal', 15, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1081, 'monde_principal', 16, 17, 'montagne', 0, 0, 0, 0, 0, 0),
(1082, 'monde_principal', 17, 17, 'montagne', 0, 0, 0, 0, 0, 0),
(1083, 'monde_principal', 18, 17, 'montagne', 0, 0, 0, 0, 0, 0),
(1084, 'monde_principal', 19, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1085, 'monde_principal', 20, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1086, 'monde_principal', 21, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1087, 'monde_principal', 22, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1088, 'monde_principal', 23, 17, 'montagne', 0, 0, 0, 0, 0, 0),
(1089, 'monde_principal', 24, 17, 'montagne', 0, 0, 0, 0, 0, 0),
(1090, 'monde_principal', 25, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1091, 'monde_principal', 26, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1092, 'monde_principal', 27, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1093, 'monde_principal', 28, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1094, 'monde_principal', 29, 17, 'plaine', 1, 1, 0, 0, 0, 0),
(1095, 'monde_principal', 30, 17, 'ville', 1, 1, 0, 0, 1, 0),
(1096, 'monde_principal', 31, 17, 'ville', 1, 1, 0, 0, 1, 0),
(1097, 'monde_principal', 32, 17, 'eau', 0, 0, 1, 0, 0, 0),
(1098, 'monde_principal', 33, 17, 'eau', 0, 0, 1, 0, 0, 0),
(1099, 'monde_principal', 34, 17, 'eau', 0, 0, 1, 0, 0, 0),
(1100, 'monde_principal', 35, 17, 'eau', 0, 0, 1, 0, 0, 0),
(1101, 'monde_principal', 36, 17, 'eau', 0, 0, 1, 0, 0, 0),
(1102, 'monde_principal', 37, 17, 'eau', 0, 0, 1, 0, 0, 0),
(1103, 'monde_principal', 38, 17, 'eau', 0, 0, 1, 0, 0, 0),
(1104, 'monde_principal', 39, 17, 'eau', 0, 0, 1, 0, 0, 0),
(1105, 'monde_principal', 0, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1106, 'monde_principal', 1, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1107, 'monde_principal', 2, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1108, 'monde_principal', 3, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1109, 'monde_principal', 4, 18, 'plaine', 1, 1, 0, 0, 0, 0),
(1110, 'monde_principal', 5, 18, 'ponton', 1, 1, 0, 1, 0, 0),
(1111, 'monde_principal', 6, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1112, 'monde_principal', 7, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1113, 'monde_principal', 8, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1114, 'monde_principal', 9, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1115, 'monde_principal', 10, 18, 'plaine', 1, 1, 0, 0, 0, 0),
(1116, 'monde_principal', 11, 18, 'plaine', 1, 1, 0, 0, 0, 0),
(1117, 'monde_principal', 12, 18, 'plaine', 1, 1, 0, 0, 0, 0),
(1118, 'monde_principal', 13, 18, 'zone_speciale', 1, 1, 0, 0, 0, 0),
(1119, 'monde_principal', 14, 18, 'zone_speciale', 1, 1, 0, 0, 0, 0),
(1120, 'monde_principal', 15, 18, 'plaine', 1, 1, 0, 0, 0, 0),
(1121, 'monde_principal', 16, 18, 'ville', 1, 1, 0, 0, 1, 0),
(1122, 'monde_principal', 17, 18, 'montagne', 0, 0, 0, 0, 0, 0),
(1123, 'monde_principal', 18, 18, 'montagne', 0, 0, 0, 0, 0, 0),
(1124, 'monde_principal', 19, 18, 'plaine', 1, 1, 0, 0, 0, 0),
(1125, 'monde_principal', 20, 18, 'plaine', 1, 1, 0, 0, 0, 0),
(1126, 'monde_principal', 21, 18, 'plaine', 1, 1, 0, 0, 0, 0),
(1127, 'monde_principal', 22, 18, 'vide', 0, 0, 0, 0, 0, 0),
(1128, 'monde_principal', 23, 18, 'montagne', 0, 0, 0, 0, 0, 0),
(1129, 'monde_principal', 24, 18, 'montagne', 0, 0, 0, 0, 0, 0),
(1130, 'monde_principal', 25, 18, 'plaine', 1, 1, 0, 0, 0, 0),
(1131, 'monde_principal', 26, 18, 'plaine', 1, 1, 0, 0, 0, 0),
(1132, 'monde_principal', 27, 18, 'plaine', 1, 1, 0, 0, 0, 0),
(1133, 'monde_principal', 28, 18, 'plaine', 1, 1, 0, 0, 0, 0),
(1134, 'monde_principal', 29, 18, 'plaine', 1, 1, 0, 0, 0, 0),
(1135, 'monde_principal', 30, 18, 'plaine', 1, 1, 0, 0, 0, 0),
(1136, 'monde_principal', 31, 18, 'zone_speciale', 1, 1, 0, 0, 0, 0),
(1137, 'monde_principal', 32, 18, 'zone_speciale', 1, 1, 0, 0, 0, 0),
(1138, 'monde_principal', 33, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1139, 'monde_principal', 34, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1140, 'monde_principal', 35, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1141, 'monde_principal', 36, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1142, 'monde_principal', 37, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1143, 'monde_principal', 38, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1144, 'monde_principal', 39, 18, 'eau', 0, 0, 1, 0, 0, 0),
(1145, 'monde_principal', 0, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1146, 'monde_principal', 1, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1147, 'monde_principal', 2, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1148, 'monde_principal', 3, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1149, 'monde_principal', 4, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1150, 'monde_principal', 5, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1151, 'monde_principal', 6, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1152, 'monde_principal', 7, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1153, 'monde_principal', 8, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1154, 'monde_principal', 9, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1155, 'monde_principal', 10, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1156, 'monde_principal', 11, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1157, 'monde_principal', 12, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1158, 'monde_principal', 13, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1159, 'monde_principal', 14, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1160, 'monde_principal', 15, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1161, 'monde_principal', 16, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1162, 'monde_principal', 17, 19, 'montagne', 0, 0, 0, 0, 0, 0),
(1163, 'monde_principal', 18, 19, 'montagne', 0, 0, 0, 0, 0, 0),
(1164, 'monde_principal', 19, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1165, 'monde_principal', 20, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1166, 'monde_principal', 21, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1167, 'monde_principal', 22, 19, 'montagne', 0, 0, 0, 0, 0, 0),
(1168, 'monde_principal', 23, 19, 'montagne', 0, 0, 0, 0, 0, 0),
(1169, 'monde_principal', 24, 19, 'montagne', 0, 0, 0, 0, 0, 0),
(1170, 'monde_principal', 25, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1171, 'monde_principal', 26, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1172, 'monde_principal', 27, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1173, 'monde_principal', 28, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1174, 'monde_principal', 29, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1175, 'monde_principal', 30, 19, 'plaine', 1, 1, 0, 0, 0, 0),
(1176, 'monde_principal', 31, 19, 'zone_speciale', 1, 1, 0, 0, 0, 0),
(1177, 'monde_principal', 32, 19, 'zone_speciale', 1, 1, 0, 0, 0, 0),
(1178, 'monde_principal', 33, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1179, 'monde_principal', 34, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1180, 'monde_principal', 35, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1181, 'monde_principal', 36, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1182, 'monde_principal', 37, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1183, 'monde_principal', 38, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1184, 'monde_principal', 39, 19, 'eau', 0, 0, 1, 0, 0, 0),
(1185, 'monde_principal', 0, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1186, 'monde_principal', 1, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1187, 'monde_principal', 2, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1188, 'monde_principal', 3, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1189, 'monde_principal', 4, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1190, 'monde_principal', 5, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1191, 'monde_principal', 6, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1192, 'monde_principal', 7, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1193, 'monde_principal', 8, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1194, 'monde_principal', 9, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1195, 'monde_principal', 10, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1196, 'monde_principal', 11, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1197, 'monde_principal', 12, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1198, 'monde_principal', 13, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1199, 'monde_principal', 14, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1200, 'monde_principal', 15, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1201, 'monde_principal', 16, 20, 'montagne', 0, 0, 0, 0, 0, 0),
(1202, 'monde_principal', 17, 20, 'montagne', 0, 0, 0, 0, 0, 0),
(1203, 'monde_principal', 18, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1204, 'monde_principal', 19, 20, 'foret', 1, 1, 0, 0, 0, 0),
(1205, 'monde_principal', 20, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1206, 'monde_principal', 21, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1207, 'monde_principal', 22, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1208, 'monde_principal', 23, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1209, 'monde_principal', 24, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1210, 'monde_principal', 25, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1211, 'monde_principal', 26, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1212, 'monde_principal', 27, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1213, 'monde_principal', 28, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1214, 'monde_principal', 29, 20, 'plaine', 1, 1, 0, 0, 0, 0),
(1215, 'monde_principal', 30, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1216, 'monde_principal', 31, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1217, 'monde_principal', 32, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1218, 'monde_principal', 33, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1219, 'monde_principal', 34, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1220, 'monde_principal', 35, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1221, 'monde_principal', 36, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1222, 'monde_principal', 37, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1223, 'monde_principal', 38, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1224, 'monde_principal', 39, 20, 'eau', 0, 0, 1, 0, 0, 0),
(1225, 'monde_principal', 0, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1226, 'monde_principal', 1, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1227, 'monde_principal', 2, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1228, 'monde_principal', 3, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1229, 'monde_principal', 4, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1230, 'monde_principal', 5, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1231, 'monde_principal', 6, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1232, 'monde_principal', 7, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1233, 'monde_principal', 8, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1234, 'monde_principal', 9, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1235, 'monde_principal', 10, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1236, 'monde_principal', 11, 21, 'plaine', 1, 1, 0, 0, 0, 0),
(1237, 'monde_principal', 12, 21, 'plaine', 1, 1, 0, 0, 0, 0),
(1238, 'monde_principal', 13, 21, 'plaine', 1, 1, 0, 0, 0, 0),
(1239, 'monde_principal', 14, 21, 'plaine', 1, 1, 0, 0, 0, 0);
INSERT INTO `monde_cases` (`id`, `code_carte`, `colonne`, `ligne`, `type_case`, `est_traversable_pied`, `est_traversable_monture`, `est_traversable_bateau`, `est_ponton`, `est_ville`, `est_zone_dangereuse`) VALUES
(1240, 'monde_principal', 15, 21, 'plaine', 1, 1, 0, 0, 0, 0),
(1241, 'monde_principal', 16, 21, 'montagne', 0, 0, 0, 0, 0, 0),
(1242, 'monde_principal', 17, 21, 'montagne', 0, 0, 0, 0, 0, 0),
(1243, 'monde_principal', 18, 21, 'plaine', 1, 1, 0, 0, 0, 0),
(1244, 'monde_principal', 19, 21, 'foret', 1, 1, 0, 0, 0, 0),
(1245, 'monde_principal', 20, 21, 'foret', 1, 1, 0, 0, 0, 0),
(1246, 'monde_principal', 21, 21, 'plaine', 1, 1, 0, 0, 0, 0),
(1247, 'monde_principal', 22, 21, 'foret', 1, 1, 0, 0, 0, 0),
(1248, 'monde_principal', 23, 21, 'plaine', 1, 1, 0, 0, 0, 0),
(1249, 'monde_principal', 24, 21, 'plaine', 1, 1, 0, 0, 0, 0),
(1250, 'monde_principal', 25, 21, 'plaine', 1, 1, 0, 0, 0, 0),
(1251, 'monde_principal', 26, 21, 'plaine', 1, 1, 0, 0, 0, 0),
(1252, 'monde_principal', 27, 21, 'plaine', 1, 1, 0, 0, 0, 0),
(1253, 'monde_principal', 28, 21, 'plaine', 1, 1, 0, 0, 0, 0),
(1254, 'monde_principal', 29, 21, 'plaine', 1, 1, 0, 0, 0, 0),
(1255, 'monde_principal', 30, 21, 'plaine', 1, 1, 0, 0, 0, 0),
(1256, 'monde_principal', 31, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1257, 'monde_principal', 32, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1258, 'monde_principal', 33, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1259, 'monde_principal', 34, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1260, 'monde_principal', 35, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1261, 'monde_principal', 36, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1262, 'monde_principal', 37, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1263, 'monde_principal', 38, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1264, 'monde_principal', 39, 21, 'eau', 0, 0, 1, 0, 0, 0),
(1265, 'monde_principal', 0, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1266, 'monde_principal', 1, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1267, 'monde_principal', 2, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1268, 'monde_principal', 3, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1269, 'monde_principal', 4, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1270, 'monde_principal', 5, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1271, 'monde_principal', 6, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1272, 'monde_principal', 7, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1273, 'monde_principal', 8, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1274, 'monde_principal', 9, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1275, 'monde_principal', 10, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1276, 'monde_principal', 11, 22, 'plaine', 1, 1, 0, 0, 0, 0),
(1277, 'monde_principal', 12, 22, 'plaine', 1, 1, 0, 0, 0, 0),
(1278, 'monde_principal', 13, 22, 'plaine', 1, 1, 0, 0, 0, 0),
(1279, 'monde_principal', 14, 22, 'plaine', 1, 1, 0, 0, 0, 0),
(1280, 'monde_principal', 15, 22, 'plaine', 1, 1, 0, 0, 0, 0),
(1281, 'monde_principal', 16, 22, 'plaine', 1, 1, 0, 0, 0, 0),
(1282, 'monde_principal', 17, 22, 'montagne', 0, 0, 0, 0, 0, 0),
(1283, 'monde_principal', 18, 22, 'plaine', 1, 1, 0, 0, 0, 0),
(1284, 'monde_principal', 19, 22, 'foret', 1, 1, 0, 0, 0, 0),
(1285, 'monde_principal', 20, 22, 'plaine', 1, 1, 0, 0, 0, 0),
(1286, 'monde_principal', 21, 22, 'plaine', 1, 1, 0, 0, 0, 0),
(1287, 'monde_principal', 22, 22, 'foret', 1, 1, 0, 0, 0, 0),
(1288, 'monde_principal', 23, 22, 'plaine', 1, 1, 0, 0, 0, 0),
(1289, 'monde_principal', 24, 22, 'montagne', 0, 0, 0, 0, 0, 0),
(1290, 'monde_principal', 25, 22, 'montagne', 0, 0, 0, 0, 0, 0),
(1291, 'monde_principal', 26, 22, 'montagne', 0, 0, 0, 0, 0, 0),
(1292, 'monde_principal', 27, 22, 'montagne', 0, 0, 0, 0, 0, 0),
(1293, 'monde_principal', 28, 22, 'plaine', 1, 1, 0, 0, 0, 0),
(1294, 'monde_principal', 29, 22, 'plaine', 1, 1, 0, 0, 0, 0),
(1295, 'monde_principal', 30, 22, 'plaine', 1, 1, 0, 0, 0, 0),
(1296, 'monde_principal', 31, 22, 'plaine', 1, 1, 0, 0, 0, 0),
(1297, 'monde_principal', 32, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1298, 'monde_principal', 33, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1299, 'monde_principal', 34, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1300, 'monde_principal', 35, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1301, 'monde_principal', 36, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1302, 'monde_principal', 37, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1303, 'monde_principal', 38, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1304, 'monde_principal', 39, 22, 'eau', 0, 0, 1, 0, 0, 0),
(1305, 'monde_principal', 0, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1306, 'monde_principal', 1, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1307, 'monde_principal', 2, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1308, 'monde_principal', 3, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1309, 'monde_principal', 4, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1310, 'monde_principal', 5, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1311, 'monde_principal', 6, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1312, 'monde_principal', 7, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1313, 'monde_principal', 8, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1314, 'monde_principal', 9, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1315, 'monde_principal', 10, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1316, 'monde_principal', 11, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1317, 'monde_principal', 12, 23, 'plaine', 1, 1, 0, 0, 0, 0),
(1318, 'monde_principal', 13, 23, 'plaine', 1, 1, 0, 0, 0, 0),
(1319, 'monde_principal', 14, 23, 'plaine', 1, 1, 0, 0, 0, 0),
(1320, 'monde_principal', 15, 23, 'plaine', 1, 1, 0, 0, 0, 0),
(1321, 'monde_principal', 16, 23, 'plaine', 1, 1, 0, 0, 0, 0),
(1322, 'monde_principal', 17, 23, 'plaine', 1, 1, 0, 0, 0, 0),
(1323, 'monde_principal', 18, 23, 'plaine', 1, 1, 0, 0, 0, 0),
(1324, 'monde_principal', 19, 23, 'plaine', 1, 1, 0, 0, 0, 0),
(1325, 'monde_principal', 20, 23, 'plaine', 1, 1, 0, 0, 0, 0),
(1326, 'monde_principal', 21, 23, 'plaine', 1, 1, 0, 0, 0, 0),
(1327, 'monde_principal', 22, 23, 'plaine', 1, 1, 0, 0, 0, 0),
(1328, 'monde_principal', 23, 23, 'plaine', 1, 1, 0, 0, 0, 0),
(1329, 'monde_principal', 24, 23, 'montagne', 0, 0, 0, 0, 0, 0),
(1330, 'monde_principal', 25, 23, 'montagne', 0, 0, 0, 0, 0, 0),
(1331, 'monde_principal', 26, 23, 'montagne', 0, 0, 0, 0, 0, 0),
(1332, 'monde_principal', 27, 23, 'montagne', 0, 0, 0, 0, 0, 0),
(1333, 'monde_principal', 28, 23, 'montagne', 0, 0, 0, 0, 0, 0),
(1334, 'monde_principal', 29, 23, 'plaine', 1, 1, 0, 0, 0, 0),
(1335, 'monde_principal', 30, 23, 'plaine', 1, 1, 0, 0, 0, 0),
(1336, 'monde_principal', 31, 23, 'ponton', 1, 1, 0, 1, 0, 0),
(1337, 'monde_principal', 32, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1338, 'monde_principal', 33, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1339, 'monde_principal', 34, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1340, 'monde_principal', 35, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1341, 'monde_principal', 36, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1342, 'monde_principal', 37, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1343, 'monde_principal', 38, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1344, 'monde_principal', 39, 23, 'eau', 0, 0, 1, 0, 0, 0),
(1345, 'monde_principal', 0, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1346, 'monde_principal', 1, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1347, 'monde_principal', 2, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1348, 'monde_principal', 3, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1349, 'monde_principal', 4, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1350, 'monde_principal', 5, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1351, 'monde_principal', 6, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1352, 'monde_principal', 7, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1353, 'monde_principal', 8, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1354, 'monde_principal', 9, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1355, 'monde_principal', 10, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1356, 'monde_principal', 11, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1357, 'monde_principal', 12, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1358, 'monde_principal', 13, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1359, 'monde_principal', 14, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1360, 'monde_principal', 15, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1361, 'monde_principal', 16, 24, 'plaine', 1, 1, 0, 0, 0, 0),
(1362, 'monde_principal', 17, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1363, 'monde_principal', 18, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1364, 'monde_principal', 19, 24, 'plaine', 1, 1, 0, 0, 0, 0),
(1365, 'monde_principal', 20, 24, 'plaine', 1, 1, 0, 0, 0, 0),
(1366, 'monde_principal', 21, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1367, 'monde_principal', 22, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1368, 'monde_principal', 23, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1369, 'monde_principal', 24, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1370, 'monde_principal', 25, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1371, 'monde_principal', 26, 24, 'plaine', 1, 1, 0, 0, 0, 0),
(1372, 'monde_principal', 27, 24, 'plaine', 1, 1, 0, 0, 0, 0),
(1373, 'monde_principal', 28, 24, 'plaine', 1, 1, 0, 0, 0, 0),
(1374, 'monde_principal', 29, 24, 'plaine', 1, 1, 0, 0, 0, 0),
(1375, 'monde_principal', 30, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1376, 'monde_principal', 31, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1377, 'monde_principal', 32, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1378, 'monde_principal', 33, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1379, 'monde_principal', 34, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1380, 'monde_principal', 35, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1381, 'monde_principal', 36, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1382, 'monde_principal', 37, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1383, 'monde_principal', 38, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1384, 'monde_principal', 39, 24, 'eau', 0, 0, 1, 0, 0, 0),
(1385, 'monde_principal', 0, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1386, 'monde_principal', 1, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1387, 'monde_principal', 2, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1388, 'monde_principal', 3, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1389, 'monde_principal', 4, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1390, 'monde_principal', 5, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1391, 'monde_principal', 6, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1392, 'monde_principal', 7, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1393, 'monde_principal', 8, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1394, 'monde_principal', 9, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1395, 'monde_principal', 10, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1396, 'monde_principal', 11, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1397, 'monde_principal', 12, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1398, 'monde_principal', 13, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1399, 'monde_principal', 14, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1400, 'monde_principal', 15, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1401, 'monde_principal', 16, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1402, 'monde_principal', 17, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1403, 'monde_principal', 18, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1404, 'monde_principal', 19, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1405, 'monde_principal', 20, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1406, 'monde_principal', 21, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1407, 'monde_principal', 22, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1408, 'monde_principal', 23, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1409, 'monde_principal', 24, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1410, 'monde_principal', 25, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1411, 'monde_principal', 26, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1412, 'monde_principal', 27, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1413, 'monde_principal', 28, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1414, 'monde_principal', 29, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1415, 'monde_principal', 30, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1416, 'monde_principal', 31, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1417, 'monde_principal', 32, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1418, 'monde_principal', 33, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1419, 'monde_principal', 34, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1420, 'monde_principal', 35, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1421, 'monde_principal', 36, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1422, 'monde_principal', 37, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1423, 'monde_principal', 38, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1424, 'monde_principal', 39, 25, 'eau', 0, 0, 1, 0, 0, 0),
(1425, 'monde_principal', 0, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1426, 'monde_principal', 1, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1427, 'monde_principal', 2, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1428, 'monde_principal', 3, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1429, 'monde_principal', 4, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1430, 'monde_principal', 5, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1431, 'monde_principal', 6, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1432, 'monde_principal', 7, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1433, 'monde_principal', 8, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1434, 'monde_principal', 9, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1435, 'monde_principal', 10, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1436, 'monde_principal', 11, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1437, 'monde_principal', 12, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1438, 'monde_principal', 13, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1439, 'monde_principal', 14, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1440, 'monde_principal', 15, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1441, 'monde_principal', 16, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1442, 'monde_principal', 17, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1443, 'monde_principal', 18, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1444, 'monde_principal', 19, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1445, 'monde_principal', 20, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1446, 'monde_principal', 21, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1447, 'monde_principal', 22, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1448, 'monde_principal', 23, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1449, 'monde_principal', 24, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1450, 'monde_principal', 25, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1451, 'monde_principal', 26, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1452, 'monde_principal', 27, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1453, 'monde_principal', 28, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1454, 'monde_principal', 29, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1455, 'monde_principal', 30, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1456, 'monde_principal', 31, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1457, 'monde_principal', 32, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1458, 'monde_principal', 33, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1459, 'monde_principal', 34, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1460, 'monde_principal', 35, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1461, 'monde_principal', 36, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1462, 'monde_principal', 37, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1463, 'monde_principal', 38, 26, 'eau', 0, 0, 1, 0, 0, 0),
(1464, 'monde_principal', 39, 26, 'eau', 0, 0, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `monde_zones`
--

DROP TABLE IF EXISTS `monde_zones`;
CREATE TABLE IF NOT EXISTS `monde_zones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code_zone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom_zone` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_zone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_carte` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colonne_origine` int DEFAULT NULL,
  `ligne_origine` int DEFAULT NULL,
  `largeur_cases` int DEFAULT '1',
  `hauteur_cases` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `monde_zones`
--

INSERT INTO `monde_zones` (`id`, `code_zone`, `nom_zone`, `type_zone`, `code_carte`, `colonne_origine`, `ligne_origine`, `largeur_cases`, `hauteur_cases`) VALUES
(1, 'verdalis', 'Verdalis', 'ville', 'monde_principal', 11, 6, 2, 1),
(2, 'pyros', 'Pyros', 'ville', 'monde_principal', 16, 18, 1, 1),
(3, 'aqualis', 'Aqualis', 'ville', 'monde_principal', 23, 9, 2, 1),
(4, 'aeron', 'Aeron', 'ville', 'monde_principal', 30, 16, 2, 2),
(5, 'elementia', 'Elementia', 'ville', 'monde_principal', 18, 12, 1, 2),
(6, 'camp_bandits', 'Camp des bandits', 'zone_speciale', 'monde_principal', 7, 4, 2, 1),
(7, 'temple_oublie_englouti', 'Temple oublié englouti', 'zone_speciale', 'monde_principal', 28, 5, 2, 2),
(8, 'volcan_activite', 'Volcan en activité', 'zone_speciale', 'monde_principal', 13, 18, 2, 1),
(9, 'ile_maudite', 'Île maudite', 'zone_speciale', 'monde_principal', 31, 18, 2, 2),
(10, 'ferme_verdalis', 'Ferme de Verdalis', 'ferme', 'monde_principal', 9, 6, 2, 2),
(11, 'champs_verdalis', 'Champs de Verdalis', 'champs', 'monde_principal', 9, 9, 4, 3),
(12, 'port_verdalis', 'Port marchand de Verdalis', 'port', 'monde_principal', 5, 11, 4, 2),
(13, 'foret_oubliee', 'Forêt oubliée', 'foret', 'monde_principal', 5, 14, 1, 3),
(14, 'foret_herbes', 'Forêt aux herbes', 'foret', 'monde_principal', 13, 7, 2, 2),
(15, 'foret_enflammee', 'Forêt enflammée', 'foret', 'monde_principal', 12, 6, 2, 1),
(16, 'forge_pyros', 'Forge de Pyros', 'forge', 'monde_principal', 11, 20, 2, 2),
(17, 'foret_champignons', 'Forêt aux champignons', 'foret', 'monde_principal', 19, 20, 2, 3),
(18, 'foret_loups', 'Forêt des loups', 'foret', 'monde_principal', 22, 21, 1, 2),
(19, 'entree_donjon_gobelins', 'Entrée du donjon des Gobelins', 'donjon', 'monde_principal', 22, 17, 1, 1),
(20, 'temple_oublie', 'Temple oublié', 'temple', 'monde_principal', 24, 21, 3, 1),
(21, 'ile_interdite', 'Île interdite', 'ile', 'monde_principal', 24, 23, 1, 1),
(22, 'village_pecheurs', 'Village de pêcheurs', 'village', 'monde_principal', 31, 12, 2, 1),
(23, 'stele_aqualis', 'Stèle de Aqualis', 'stele', 'monde_principal', 33, 7, 1, 1),
(24, 'stele_aeron', 'Stèle de Aeron', 'stele', 'monde_principal', 23, 17, 1, 1),
(25, 'stele_pyros', 'Stèle de Pyros', 'stele', 'monde_principal', 16, 22, 1, 1),
(26, 'stele_verdalis', 'Stèle de Verdalis', 'stele', 'monde_principal', 17, 25, 1, 1),
(27, 'stele_elementia', 'Stèle de Elementia', 'stele', 'monde_principal', 16, 12, 1, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personnages`
--

INSERT INTO `personnages` (`id`, `compte_id`, `nom`, `element`, `portrait`, `region_depart`, `position_x`, `position_y`, `niveau`, `date_creation`, `classe`, `sexe`, `point_de_vie`, `attaque`, `magie`, `agilite`, `intelligence`, `synchronisation_elementaire`, `critique`, `dexterite`, `defense`) VALUES
(7, 1, 'blazu', 'Feu', 'ressources/images/avatars/feu_mage_homme_1.png', 'Ignivar', 0, 0, 1, '2026-03-24 07:28:01', 'Mage du Feu', 'homme', 3, 1, 7, 3, 5, 6, 1, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `personnages_onglets_inventaire`
--

DROP TABLE IF EXISTS `personnages_onglets_inventaire`;
CREATE TABLE IF NOT EXISTS `personnages_onglets_inventaire` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `personnage_id` int UNSIGNED NOT NULL,
  `catalogue_onglet_id` bigint UNSIGNED NOT NULL,
  `est_debloque` tinyint(1) NOT NULL DEFAULT '1',
  `date_deblocage` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_personnages_onglets_inventaire_personnage_onglet` (`personnage_id`,`catalogue_onglet_id`),
  KEY `idx_personnages_onglets_inventaire_catalogue_onglet_id` (`catalogue_onglet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personnages_onglets_inventaire`
--

INSERT INTO `personnages_onglets_inventaire` (`id`, `personnage_id`, `catalogue_onglet_id`, `est_debloque`, `date_deblocage`) VALUES
(1, 7, 1, 1, '2026-03-25 06:45:32');

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

-- --------------------------------------------------------

--
-- Structure de la table `personnage_competences_progression`
--

DROP TABLE IF EXISTS `personnage_competences_progression`;
CREATE TABLE IF NOT EXISTS `personnage_competences_progression` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `personnage_id` int UNSIGNED NOT NULL,
  `code_competence` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveau_sort` int NOT NULL DEFAULT '1',
  `niveau_max_actuel` int NOT NULL DEFAULT '20',
  `est_ultime` tinyint(1) NOT NULL DEFAULT '0',
  `xp_actuelle` bigint NOT NULL DEFAULT '0',
  `xp_suivante` bigint NOT NULL DEFAULT '100',
  `est_equipee` tinyint(1) NOT NULL DEFAULT '1',
  `ordre_slot` int NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_mise_a_jour` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_personnage_competence` (`personnage_id`,`code_competence`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personnage_competences_progression`
--

INSERT INTO `personnage_competences_progression` (`id`, `personnage_id`, `code_competence`, `niveau_sort`, `niveau_max_actuel`, `est_ultime`, `xp_actuelle`, `xp_suivante`, `est_equipee`, `ordre_slot`, `date_creation`, `date_mise_a_jour`) VALUES
(22, 7, 'FEU_MAGE_DU_FEU_002', 1, 20, 0, 0, 100, 1, 1, '2026-03-24 07:28:02', '2026-03-24 07:28:02'),
(23, 7, 'FEU_MAGE_DU_FEU_006', 1, 20, 0, 0, 100, 1, 2, '2026-03-24 07:28:02', '2026-03-24 07:28:02'),
(24, 7, 'FEU_MAGE_DU_FEU_008', 1, 20, 0, 0, 100, 1, 3, '2026-03-24 07:28:02', '2026-03-24 07:28:02'),
(25, 7, 'FEU_MAGE_DU_FEU_010', 1, 20, 0, 0, 100, 1, 4, '2026-03-24 07:28:02', '2026-03-24 07:28:02'),
(26, 7, 'NEUTRE_001', 1, 10, 0, 0, 100, 1, 5, '2026-03-24 07:28:02', '2026-03-24 07:28:02'),
(27, 7, 'NEUTRE_008', 1, 10, 0, 0, 100, 1, 6, '2026-03-24 07:28:02', '2026-03-24 07:28:02'),
(28, 7, 'NEUTRE_009', 1, 10, 0, 0, 100, 1, 7, '2026-03-24 07:28:02', '2026-03-24 07:28:02');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_equipements_personnage_detail`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_equipements_personnage_detail`;
CREATE TABLE IF NOT EXISTS `vue_equipements_personnage_detail` (
`bonus_agilite` int
,`bonus_attaque` int
,`bonus_critique` int
,`bonus_defense` int
,`bonus_dexterite` int
,`bonus_intelligence` int
,`bonus_magie` int
,`bonus_point_de_vie` int
,`bonus_synchronisation_elementaire` int
,`code_objet` varchar(100)
,`code_slot` varchar(80)
,`durabilite_actuelle` int
,`durabilite_maximum` int
,`equipement_id` bigint unsigned
,`icone_objet` varchar(255)
,`instance_objet_id` bigint unsigned
,`nom_objet` varchar(150)
,`nom_personnage` varchar(50)
,`nom_slot` varchar(120)
,`personnage_id` int unsigned
,`quantite` int
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_inventaire_personnage_detail`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_inventaire_personnage_detail`;
CREATE TABLE IF NOT EXISTS `vue_inventaire_personnage_detail` (
`code_objet` varchar(100)
,`code_onglet` varchar(80)
,`durabilite_actuelle` int
,`durabilite_maximum` int
,`est_empilable` tinyint(1)
,`icone_objet` varchar(255)
,`instance_objet_id` bigint unsigned
,`inventaire_id` bigint unsigned
,`nom_objet` varchar(150)
,`nom_onglet` varchar(120)
,`nom_personnage` varchar(50)
,`personnage_id` int unsigned
,`poids_unitaire` int
,`position_slot` int
,`quantite` int
,`quantite_max_par_pile` int
);

-- --------------------------------------------------------

--
-- Structure de la vue `vue_equipements_personnage_detail`
--
DROP TABLE IF EXISTS `vue_equipements_personnage_detail`;

DROP VIEW IF EXISTS `vue_equipements_personnage_detail`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_equipements_personnage_detail`  AS SELECT `ep`.`id` AS `equipement_id`, `ep`.`personnage_id` AS `personnage_id`, `p`.`nom` AS `nom_personnage`, `cse`.`code_slot` AS `code_slot`, `cse`.`nom_slot` AS `nom_slot`, `io`.`id` AS `instance_objet_id`, `co`.`code_objet` AS `code_objet`, `co`.`nom_objet` AS `nom_objet`, `co`.`icone_objet` AS `icone_objet`, `io`.`quantite` AS `quantite`, `io`.`durabilite_actuelle` AS `durabilite_actuelle`, `io`.`durabilite_maximum` AS `durabilite_maximum`, `co`.`bonus_point_de_vie` AS `bonus_point_de_vie`, `co`.`bonus_attaque` AS `bonus_attaque`, `co`.`bonus_magie` AS `bonus_magie`, `co`.`bonus_agilite` AS `bonus_agilite`, `co`.`bonus_intelligence` AS `bonus_intelligence`, `co`.`bonus_synchronisation_elementaire` AS `bonus_synchronisation_elementaire`, `co`.`bonus_critique` AS `bonus_critique`, `co`.`bonus_dexterite` AS `bonus_dexterite`, `co`.`bonus_defense` AS `bonus_defense` FROM ((((`equipements_personnage` `ep` join `personnages` `p` on((`p`.`id` = `ep`.`personnage_id`))) join `catalogue_slots_equipement` `cse` on((`cse`.`id` = `ep`.`catalogue_slot_id`))) join `instances_objets` `io` on((`io`.`id` = `ep`.`instance_objet_id`))) join `catalogue_objets` `co` on((`co`.`id` = `io`.`catalogue_objet_id`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_inventaire_personnage_detail`
--
DROP TABLE IF EXISTS `vue_inventaire_personnage_detail`;

DROP VIEW IF EXISTS `vue_inventaire_personnage_detail`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_inventaire_personnage_detail`  AS SELECT `ipi`.`id` AS `inventaire_id`, `ipi`.`personnage_id` AS `personnage_id`, `p`.`nom` AS `nom_personnage`, `coi`.`code_onglet` AS `code_onglet`, `coi`.`nom_onglet` AS `nom_onglet`, `ipi`.`position_slot` AS `position_slot`, `io`.`id` AS `instance_objet_id`, `co`.`code_objet` AS `code_objet`, `co`.`nom_objet` AS `nom_objet`, `co`.`icone_objet` AS `icone_objet`, `io`.`quantite` AS `quantite`, `io`.`durabilite_actuelle` AS `durabilite_actuelle`, `io`.`durabilite_maximum` AS `durabilite_maximum`, `co`.`poids_unitaire` AS `poids_unitaire`, `co`.`est_empilable` AS `est_empilable`, `co`.`quantite_max_par_pile` AS `quantite_max_par_pile` FROM ((((`inventaire_personnage_instances` `ipi` join `personnages` `p` on((`p`.`id` = `ipi`.`personnage_id`))) join `catalogue_onglets_inventaire` `coi` on((`coi`.`id` = `ipi`.`catalogue_onglet_id`))) join `instances_objets` `io` on((`io`.`id` = `ipi`.`instance_objet_id`))) join `catalogue_objets` `co` on((`co`.`id` = `io`.`catalogue_objet_id`))) ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `catalogue_objets_slots_autorises`
--
ALTER TABLE `catalogue_objets_slots_autorises`
  ADD CONSTRAINT `fk_catalogue_objets_slots_autorises_objet` FOREIGN KEY (`catalogue_objet_id`) REFERENCES `catalogue_objets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_catalogue_objets_slots_autorises_slot` FOREIGN KEY (`catalogue_slot_id`) REFERENCES `catalogue_slots_equipement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `equipements_personnage`
--
ALTER TABLE `equipements_personnage`
  ADD CONSTRAINT `fk_equipements_personnage_instance_objet` FOREIGN KEY (`instance_objet_id`) REFERENCES `instances_objets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_equipements_personnage_personnage` FOREIGN KEY (`personnage_id`) REFERENCES `personnages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_equipements_personnage_slot` FOREIGN KEY (`catalogue_slot_id`) REFERENCES `catalogue_slots_equipement` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `instances_objets`
--
ALTER TABLE `instances_objets`
  ADD CONSTRAINT `fk_instances_objets_catalogue_objet` FOREIGN KEY (`catalogue_objet_id`) REFERENCES `catalogue_objets` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_instances_objets_personnage` FOREIGN KEY (`personnage_proprietaire_id`) REFERENCES `personnages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `inventaire_personnage_instances`
--
ALTER TABLE `inventaire_personnage_instances`
  ADD CONSTRAINT `fk_inventaire_personnage_instances_catalogue_onglet` FOREIGN KEY (`catalogue_onglet_id`) REFERENCES `catalogue_onglets_inventaire` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inventaire_personnage_instances_instance_objet` FOREIGN KEY (`instance_objet_id`) REFERENCES `instances_objets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inventaire_personnage_instances_personnage` FOREIGN KEY (`personnage_id`) REFERENCES `personnages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `personnages`
--
ALTER TABLE `personnages`
  ADD CONSTRAINT `fk_personnages_compte` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `personnages_onglets_inventaire`
--
ALTER TABLE `personnages_onglets_inventaire`
  ADD CONSTRAINT `fk_personnages_onglets_inventaire_catalogue_onglet` FOREIGN KEY (`catalogue_onglet_id`) REFERENCES `catalogue_onglets_inventaire` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_personnages_onglets_inventaire_personnage` FOREIGN KEY (`personnage_id`) REFERENCES `personnages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `personnage_competences`
--
ALTER TABLE `personnage_competences`
  ADD CONSTRAINT `fk_personnage_competences_personnage` FOREIGN KEY (`personnage_id`) REFERENCES `personnages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `personnage_competences_progression`
--
ALTER TABLE `personnage_competences_progression`
  ADD CONSTRAINT `fk_personnage_competences_progression_personnage` FOREIGN KEY (`personnage_id`) REFERENCES `personnages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
