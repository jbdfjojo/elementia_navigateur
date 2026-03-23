-- =========================================================
-- ELEMENTIA
-- Mise à jour de la base pour la création personnage
-- Version compatible avec une base déjà partiellement mise à jour
-- =========================================================

USE elementia;

-- ---------------------------------------------------------
-- Ajout sécurisé des colonnes dans la table personnages
-- ---------------------------------------------------------

SET @base_de_donnees = 'elementia';

-- classe
SET @requete_colonne = (
    SELECT IF(
        EXISTS(
            SELECT 1
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = @base_de_donnees
              AND TABLE_NAME = 'personnages'
              AND COLUMN_NAME = 'classe'
        ),
        'SELECT ''Colonne classe déjà présente'';',
        'ALTER TABLE personnages ADD COLUMN classe VARCHAR(20) NULL;'
    )
);
PREPARE requete_temporaire FROM @requete_colonne;
EXECUTE requete_temporaire;
DEALLOCATE PREPARE requete_temporaire;

-- sexe
SET @requete_colonne = (
    SELECT IF(
        EXISTS(
            SELECT 1
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = @base_de_donnees
              AND TABLE_NAME = 'personnages'
              AND COLUMN_NAME = 'sexe'
        ),
        'SELECT ''Colonne sexe déjà présente'';',
        'ALTER TABLE personnages ADD COLUMN sexe VARCHAR(10) NULL;'
    )
);
PREPARE requete_temporaire FROM @requete_colonne;
EXECUTE requete_temporaire;
DEALLOCATE PREPARE requete_temporaire;

-- point_de_vie
SET @requete_colonne = (
    SELECT IF(
        EXISTS(
            SELECT 1
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = @base_de_donnees
              AND TABLE_NAME = 'personnages'
              AND COLUMN_NAME = 'point_de_vie'
        ),
        'SELECT ''Colonne point_de_vie déjà présente'';',
        'ALTER TABLE personnages ADD COLUMN point_de_vie INT NOT NULL DEFAULT 0;'
    )
);
PREPARE requete_temporaire FROM @requete_colonne;
EXECUTE requete_temporaire;
DEALLOCATE PREPARE requete_temporaire;

-- attaque
SET @requete_colonne = (
    SELECT IF(
        EXISTS(
            SELECT 1
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = @base_de_donnees
              AND TABLE_NAME = 'personnages'
              AND COLUMN_NAME = 'attaque'
        ),
        'SELECT ''Colonne attaque déjà présente'';',
        'ALTER TABLE personnages ADD COLUMN attaque INT NOT NULL DEFAULT 0;'
    )
);
PREPARE requete_temporaire FROM @requete_colonne;
EXECUTE requete_temporaire;
DEALLOCATE PREPARE requete_temporaire;

-- magie
SET @requete_colonne = (
    SELECT IF(
        EXISTS(
            SELECT 1
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = @base_de_donnees
              AND TABLE_NAME = 'personnages'
              AND COLUMN_NAME = 'magie'
        ),
        'SELECT ''Colonne magie déjà présente'';',
        'ALTER TABLE personnages ADD COLUMN magie INT NOT NULL DEFAULT 0;'
    )
);
PREPARE requete_temporaire FROM @requete_colonne;
EXECUTE requete_temporaire;
DEALLOCATE PREPARE requete_temporaire;

-- agilite
SET @requete_colonne = (
    SELECT IF(
        EXISTS(
            SELECT 1
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = @base_de_donnees
              AND TABLE_NAME = 'personnages'
              AND COLUMN_NAME = 'agilite'
        ),
        'SELECT ''Colonne agilite déjà présente'';',
        'ALTER TABLE personnages ADD COLUMN agilite INT NOT NULL DEFAULT 0;'
    )
);
PREPARE requete_temporaire FROM @requete_colonne;
EXECUTE requete_temporaire;
DEALLOCATE PREPARE requete_temporaire;

-- intelligence
SET @requete_colonne = (
    SELECT IF(
        EXISTS(
            SELECT 1
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = @base_de_donnees
              AND TABLE_NAME = 'personnages'
              AND COLUMN_NAME = 'intelligence'
        ),
        'SELECT ''Colonne intelligence déjà présente'';',
        'ALTER TABLE personnages ADD COLUMN intelligence INT NOT NULL DEFAULT 0;'
    )
);
PREPARE requete_temporaire FROM @requete_colonne;
EXECUTE requete_temporaire;
DEALLOCATE PREPARE requete_temporaire;

-- synchronisation_elementaire
SET @requete_colonne = (
    SELECT IF(
        EXISTS(
            SELECT 1
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = @base_de_donnees
              AND TABLE_NAME = 'personnages'
              AND COLUMN_NAME = 'synchronisation_elementaire'
        ),
        'SELECT ''Colonne synchronisation_elementaire déjà présente'';',
        'ALTER TABLE personnages ADD COLUMN synchronisation_elementaire INT NOT NULL DEFAULT 0;'
    )
);
PREPARE requete_temporaire FROM @requete_colonne;
EXECUTE requete_temporaire;
DEALLOCATE PREPARE requete_temporaire;

-- critique
SET @requete_colonne = (
    SELECT IF(
        EXISTS(
            SELECT 1
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = @base_de_donnees
              AND TABLE_NAME = 'personnages'
              AND COLUMN_NAME = 'critique'
        ),
        'SELECT ''Colonne critique déjà présente'';',
        'ALTER TABLE personnages ADD COLUMN critique INT NOT NULL DEFAULT 0;'
    )
);
PREPARE requete_temporaire FROM @requete_colonne;
EXECUTE requete_temporaire;
DEALLOCATE PREPARE requete_temporaire;

-- dexterite
SET @requete_colonne = (
    SELECT IF(
        EXISTS(
            SELECT 1
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = @base_de_donnees
              AND TABLE_NAME = 'personnages'
              AND COLUMN_NAME = 'dexterite'
        ),
        'SELECT ''Colonne dexterite déjà présente'';',
        'ALTER TABLE personnages ADD COLUMN dexterite INT NOT NULL DEFAULT 0;'
    )
);
PREPARE requete_temporaire FROM @requete_colonne;
EXECUTE requete_temporaire;
DEALLOCATE PREPARE requete_temporaire;

-- defense
SET @requete_colonne = (
    SELECT IF(
        EXISTS(
            SELECT 1
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = @base_de_donnees
              AND TABLE_NAME = 'personnages'
              AND COLUMN_NAME = 'defense'
        ),
        'SELECT ''Colonne defense déjà présente'';',
        'ALTER TABLE personnages ADD COLUMN defense INT NOT NULL DEFAULT 0;'
    )
);
PREPARE requete_temporaire FROM @requete_colonne;
EXECUTE requete_temporaire;
DEALLOCATE PREPARE requete_temporaire;

-- ---------------------------------------------------------
-- Création de la table des compétences du personnage
-- ---------------------------------------------------------

CREATE TABLE IF NOT EXISTS personnage_competences (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    personnage_id INT UNSIGNED NOT NULL,
    nom_competence VARCHAR(150) NOT NULL,
    type_competence ENUM('elementaire', 'neutre') NOT NULL,
    ordre_affichage INT NOT NULL DEFAULT 1,
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_personnage_competences_personnage
        FOREIGN KEY (personnage_id)
        REFERENCES personnages(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Création sécurisée de l’index s’il n’existe pas
-- ---------------------------------------------------------

SET @requete_index = (
    SELECT IF(
        EXISTS(
            SELECT 1
            FROM INFORMATION_SCHEMA.STATISTICS
            WHERE TABLE_SCHEMA = @base_de_donnees
              AND TABLE_NAME = 'personnage_competences'
              AND INDEX_NAME = 'idx_personnage_competences_personnage_id'
        ),
        'SELECT ''Index idx_personnage_competences_personnage_id déjà présent'';',
        'CREATE INDEX idx_personnage_competences_personnage_id ON personnage_competences(personnage_id);'
    )
);
PREPARE requete_index_temporaire FROM @requete_index;
EXECUTE requete_index_temporaire;
DEALLOCATE PREPARE requete_index_temporaire;