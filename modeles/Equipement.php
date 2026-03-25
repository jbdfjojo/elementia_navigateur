<?php
declare(strict_types=1);

if (!class_exists('Equipement')) {
    class Equipement
    {
        private PDO $connexion_base;

        public function __construct(PDO $connexion_base)
        {
            $this->connexion_base = $connexion_base;
        }

        public function listerEquipementPersonnage(int $personnage_id): array
        {
            $requete = $this->connexion_base->prepare(
                'SELECT
                    ep.id AS equipement_id,
                    ep.personnage_id,
                    ep.catalogue_slot_id,
                    ep.instance_objet_id,
                    cse.code_slot,
                    cse.nom_slot,
                    cse.icone_slot_vide,
                    cse.position_x_interface,
                    cse.position_y_interface,
                    cse.largeur_interface,
                    cse.hauteur_interface,
                    co.id AS catalogue_objet_id,
                    co.code_objet,
                    co.nom_objet,
                    co.description_objet,
                    co.type_objet,
                    co.categorie_objet,
                    co.rarete_objet,
                    co.icone_objet,
                    co.bonus_point_de_vie,
                    co.bonus_attaque,
                    co.bonus_magie,
                    co.bonus_agilite,
                    co.bonus_intelligence,
                    co.bonus_synchronisation_elementaire,
                    co.bonus_critique,
                    co.bonus_dexterite,
                    co.bonus_defense,
                    co.poids_unitaire,
                    io.quantite,
                    io.durabilite_actuelle,
                    io.durabilite_maximum
                 FROM equipements_personnage ep
                 INNER JOIN catalogue_slots_equipement cse
                         ON cse.id = ep.catalogue_slot_id
                 INNER JOIN instances_objets io
                         ON io.id = ep.instance_objet_id
                 INNER JOIN catalogue_objets co
                         ON co.id = io.catalogue_objet_id
                 WHERE ep.personnage_id = :personnage_id
                 ORDER BY cse.ordre_affichage ASC'
            );

            $requete->execute([
                'personnage_id' => $personnage_id,
            ]);

            return $requete->fetchAll() ?: [];
        }

        public function trouverSlotLibreCompatible(int $personnage_id, int $instance_objet_id): ?array
        {
            $requete = $this->connexion_base->prepare(
                'SELECT
                    cse.*
                 FROM instances_objets io
                 INNER JOIN catalogue_objets co
                         ON co.id = io.catalogue_objet_id
                 INNER JOIN catalogue_slots_equipement cse
                         ON cse.groupe_slot = "equipement_personnage"
                        AND cse.categorie_principale_autorisee = co.categorie_objet
                 LEFT JOIN equipements_personnage ep
                        ON ep.personnage_id = :personnage_id
                       AND ep.catalogue_slot_id = cse.id
                 WHERE io.id = :instance_objet_id
                   AND io.personnage_proprietaire_id = :personnage_id
                   AND ep.id IS NULL
                 ORDER BY cse.ordre_affichage ASC
                 LIMIT 1'
            );

            $requete->execute([
                'personnage_id' => $personnage_id,
                'instance_objet_id' => $instance_objet_id,
            ]);

            $slot = $requete->fetch();
            return $slot ?: null;
        }

        public function trouverSlotCompatiblePourCible(int $personnage_id, int $instance_objet_id, string $slot_cible): ?array
        {
            $tousLesSlots = $this->listerSlotsCompatiblesPourInstance($personnage_id, $instance_objet_id);

            $mapping = [
                'tete' => ['tete'],
                'gants_gauche' => ['gant gauche', 'gants gauche', 'gants'],
                'gants_droite' => ['gant droite', 'gants droite'],
                'torse' => ['torse', 'armure'],
                'jambes' => ['jambes', 'botte', 'bottes'],
                'collier' => ['collier', 'amulette'],
                'bague_1' => ['bague 1', 'bague1'],
                'bague_2' => ['bague 2', 'bague2'],
                'main_gauche' => ['main gauche'],
                'artefact' => ['artefact'],
                'main_droite' => ['main droite'],
                'sac' => ['sac'],
            ];

            $correspondances = $mapping[$slot_cible] ?? [$slot_cible];

            foreach ($tousLesSlots as $slot) {
                $comparaison = $this->normaliser(
                    (string) ($slot['code_slot'] ?? '') . ' ' . (string) ($slot['nom_slot'] ?? '')
                );

                foreach ($correspondances as $mot) {
                    if (str_contains($comparaison, $this->normaliser($mot))) {
                        return $slot;
                    }
                }
            }

            return null;
        }

        public function listerSlotsCompatiblesPourInstance(int $personnage_id, int $instance_objet_id): array
        {
            $requete = $this->connexion_base->prepare(
                'SELECT
                    cse.*
                 FROM instances_objets io
                 INNER JOIN catalogue_objets co
                         ON co.id = io.catalogue_objet_id
                 INNER JOIN catalogue_slots_equipement cse
                         ON cse.groupe_slot = "equipement_personnage"
                        AND cse.categorie_principale_autorisee = co.categorie_objet
                 WHERE io.id = :instance_objet_id
                   AND io.personnage_proprietaire_id = :personnage_id
                 ORDER BY cse.ordre_affichage ASC'
            );

            $requete->execute([
                'personnage_id' => $personnage_id,
                'instance_objet_id' => $instance_objet_id,
            ]);

            return $requete->fetchAll() ?: [];
        }

        public function verifierProprieteInstance(int $personnage_id, int $instance_objet_id): bool
        {
            $requete = $this->connexion_base->prepare(
                'SELECT id
                 FROM instances_objets
                 WHERE id = :instance_objet_id
                   AND personnage_proprietaire_id = :personnage_id
                 LIMIT 1'
            );

            $requete->execute([
                'instance_objet_id' => $instance_objet_id,
                'personnage_id' => $personnage_id,
            ]);

            return (bool) $requete->fetch();
        }

        public function instanceDejaEquipee(int $instance_objet_id): bool
        {
            $requete = $this->connexion_base->prepare(
                'SELECT id
                 FROM equipements_personnage
                 WHERE instance_objet_id = :instance_objet_id
                 LIMIT 1'
            );

            $requete->execute([
                'instance_objet_id' => $instance_objet_id,
            ]);

            return (bool) $requete->fetch();
        }

        public function slotOccupe(int $personnage_id, int $catalogue_slot_id): bool
        {
            $requete = $this->connexion_base->prepare(
                'SELECT id
                 FROM equipements_personnage
                 WHERE personnage_id = :personnage_id
                   AND catalogue_slot_id = :catalogue_slot_id
                 LIMIT 1'
            );

            $requete->execute([
                'personnage_id' => $personnage_id,
                'catalogue_slot_id' => $catalogue_slot_id,
            ]);

            return (bool) $requete->fetch();
        }

        public function equiperInstanceDansSlot(int $personnage_id, int $catalogue_slot_id, int $instance_objet_id): bool
        {
            $requete = $this->connexion_base->prepare(
                'INSERT INTO equipements_personnage (
                    personnage_id,
                    catalogue_slot_id,
                    instance_objet_id
                 ) VALUES (
                    :personnage_id,
                    :catalogue_slot_id,
                    :instance_objet_id
                 )
                 ON DUPLICATE KEY UPDATE
                    instance_objet_id = VALUES(instance_objet_id),
                    date_mise_a_jour = CURRENT_TIMESTAMP'
            );

            return $requete->execute([
                'personnage_id' => $personnage_id,
                'catalogue_slot_id' => $catalogue_slot_id,
                'instance_objet_id' => $instance_objet_id,
            ]);
        }

        public function desequiperInstance(int $personnage_id, int $instance_objet_id): bool
        {
            $requete = $this->connexion_base->prepare(
                'DELETE FROM equipements_personnage
                 WHERE personnage_id = :personnage_id
                   AND instance_objet_id = :instance_objet_id'
            );

            return $requete->execute([
                'personnage_id' => $personnage_id,
                'instance_objet_id' => $instance_objet_id,
            ]);
        }

        private function normaliser(string $texte): string
        {
            $texte = strtolower($texte);
            return strtr($texte, [
                'à' => 'a', 'â' => 'a', 'ä' => 'a',
                'ç' => 'c',
                'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
                'î' => 'i', 'ï' => 'i',
                'ô' => 'o', 'ö' => 'o',
                'ù' => 'u', 'û' => 'u', 'ü' => 'u',
                'ÿ' => 'y'
            ]);
        }
    }
}