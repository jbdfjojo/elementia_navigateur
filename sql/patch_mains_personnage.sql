-- Patch SQL : gestion des mains + isolation d'équipement par personnage

ALTER TABLE catalogue_objets
    ADD COLUMN mode_maniement ENUM('aucun','une_main_gauche','une_main_droite','deux_mains','double_slot_lie') NOT NULL DEFAULT 'aucun' AFTER est_equipable,
    ADD COLUMN code_groupe_slots_lies VARCHAR(80) NULL AFTER mode_maniement;

-- On autorise désormais le même objet équipé sur plusieurs slots visuels liés
ALTER TABLE equipements_personnage
    DROP INDEX uk_equipements_personnage_instance_objet_id,
    ADD INDEX idx_equipements_personnage_instance_objet_id (instance_objet_id);

-- Paramétrage des objets de test actuels
UPDATE catalogue_objets
SET mode_maniement = 'double_slot_lie',
    code_groupe_slots_lies = 'gants'
WHERE categorie_objet = 'gants';

UPDATE catalogue_objets
SET mode_maniement = 'une_main_gauche',
    code_groupe_slots_lies = NULL
WHERE code_objet = 'OBJ_TEST_EPEE_LONGUE';

UPDATE catalogue_objets
SET mode_maniement = 'deux_mains',
    code_groupe_slots_lies = NULL
WHERE code_objet = 'OBJ_TEST_BATON_MAGIQUE';

UPDATE catalogue_objets
SET mode_maniement = 'une_main_droite',
    code_groupe_slots_lies = NULL
WHERE code_objet = 'OBJ_TEST_BOUCLIER_BOIS';

-- Cohérence des slots autorisés actuels
UPDATE catalogue_objets_slots_autorises
SET est_slot_principal = CASE
    WHEN catalogue_objet_id = 5 AND catalogue_slot_id = 9 THEN 1
    WHEN catalogue_objet_id = 5 AND catalogue_slot_id = 11 THEN 0
    WHEN catalogue_objet_id = 11 AND catalogue_slot_id = 9 THEN 1
    WHEN catalogue_objet_id = 11 AND catalogue_slot_id = 11 THEN 0
    WHEN catalogue_objet_id = 6 AND catalogue_slot_id = 11 THEN 1
    WHEN catalogue_objet_id = 6 AND catalogue_slot_id = 9 THEN 0
    ELSE est_slot_principal
END
WHERE catalogue_objet_id IN (5, 6, 11);

-- Insertion des slots manquants si besoin pour les objets à deux mains / gauche / droite
INSERT IGNORE INTO catalogue_objets_slots_autorises (catalogue_objet_id, catalogue_slot_id, est_slot_principal)
VALUES
    (5, 9, 1),
    (5, 11, 0),
    (11, 9, 1),
    (11, 11, 0),
    (6, 11, 1);
