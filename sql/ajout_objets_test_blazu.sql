-- =========================================================
-- AJOUT OBJETS TEST POUR BLAZU (personnage_id = 7)
-- =========================================================
START TRANSACTION;

SET @personnage_id = 7;
SET @onglet_principal_id = 1;

-- Nettoyage léger des anciens objets test non équipés / équipés
DELETE ep
FROM equipements_personnage ep
INNER JOIN instances_objets io ON io.id = ep.instance_objet_id
WHERE ep.personnage_id = @personnage_id
  AND io.catalogue_objet_id IN (1,2,3,4);

DELETE ipi
FROM inventaire_personnage_instances ipi
INNER JOIN instances_objets io ON io.id = ipi.instance_objet_id
WHERE ipi.personnage_id = @personnage_id
  AND io.catalogue_objet_id IN (1,2,3,4);

DELETE FROM instances_objets
WHERE personnage_proprietaire_id = @personnage_id
  AND catalogue_objet_id IN (1,2,3,4);

INSERT INTO instances_objets (catalogue_objet_id, personnage_proprietaire_id, quantite, durabilite_actuelle, durabilite_maximum, est_verrouille, source_obtention)
VALUES
(1, @personnage_id, 1, 40, 40, 0, 'debug_test'),
(2, @personnage_id, 1, 60, 60, 0, 'debug_test'),
(3, @personnage_id, 1, 30, 30, 0, 'debug_test'),
(4, @personnage_id, 1, 35, 35, 0, 'debug_test');

SET @id1 = LAST_INSERT_ID() - 3;
SET @id2 = LAST_INSERT_ID() - 2;
SET @id3 = LAST_INSERT_ID() - 1;
SET @id4 = LAST_INSERT_ID();

INSERT INTO inventaire_personnage_instances (personnage_id, catalogue_onglet_id, instance_objet_id, position_slot)
VALUES
(@personnage_id, @onglet_principal_id, @id1, 1),
(@personnage_id, @onglet_principal_id, @id2, 2),
(@personnage_id, @onglet_principal_id, @id3, 3),
(@personnage_id, @onglet_principal_id, @id4, 4);

COMMIT;
