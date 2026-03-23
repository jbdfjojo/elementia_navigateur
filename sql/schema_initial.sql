-- =========================================================
-- ELEMENTIA
-- Schéma SQL initial
-- Version de départ pour WampServer / phpMyAdmin / MySQL
-- =========================================================

-- ---------------------------------------------------------
-- Suppression de la base si elle existe déjà
-- Attention : à utiliser seulement en phase de test
-- ---------------------------------------------------------
DROP DATABASE IF EXISTS elementia;

-- ---------------------------------------------------------
-- Création de la base de données
-- ---------------------------------------------------------
CREATE DATABASE elementia
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Sélection de la base de données
-- ---------------------------------------------------------
USE elementia;

-- ---------------------------------------------------------
-- Table des comptes joueurs
-- Cette table stocke :
-- - le pseudo
-- - le mot de passe hashé
-- - les dates utiles
-- ---------------------------------------------------------
CREATE TABLE comptes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    derniere_connexion DATETIME NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Table des personnages
-- Cette table stocke :
-- - le compte propriétaire
-- - le nom du personnage
-- - son élément principal
-- - sa position de départ
-- - son niveau
-- ---------------------------------------------------------
CREATE TABLE personnages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    compte_id INT UNSIGNED NOT NULL,
    nom VARCHAR(50) NOT NULL,
    element ENUM('Feu', 'Eau', 'Air', 'Terre') NOT NULL,
    portrait VARCHAR(255) NULL,
    region_depart VARCHAR(100) NULL,
    position_x INT NOT NULL DEFAULT 0,
    position_y INT NOT NULL DEFAULT 0,
    niveau INT NOT NULL DEFAULT 1,
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_personnages_compte
        FOREIGN KEY (compte_id)
        REFERENCES comptes(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Index utile pour retrouver rapidement les personnages
-- d’un compte joueur
-- ---------------------------------------------------------
CREATE INDEX idx_personnages_compte_id ON personnages(compte_id);