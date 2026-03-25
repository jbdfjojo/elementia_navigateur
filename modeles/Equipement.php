<?php
// ---------------------------------------------------------
// MODÈLE ÉQUIPEMENT
// ---------------------------------------------------------
declare(strict_types=1);

if (!class_exists('Equipement')) {
    class Equipement
    {
        // -------------------------------------------------
        // Connexion PDO partagée
        // -------------------------------------------------
        private PDO $connexion_base;

        // -------------------------------------------------
        // Constructeur
        // -------------------------------------------------
        public function __construct(PDO $connexion_base)
        {
            // ---------------------------------------------
            // On stocke la connexion SQL
            // ---------------------------------------------
            $this->connexion_base = $connexion_base;
        }

        // -------------------------------------------------
        // Liste l'équipement complet du personnage
        // -------------------------------------------------
        public function listerEquipementPersonnage(int $personnage_id): array
        {
            // ---------------------------------------------
            // Requête SQL détaillée de l'équipement
            // ---------------------------------------------
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

            // ---------------------------------------------
            // Exécution
            // ---------------------------------------------
            $requete->execute([
                'personnage_id' => $personnage_id,
            ]);

            // ---------------------------------------------
            // Retour des lignes
            // ---------------------------------------------
            return $requete->fetchAll();
        }

        // -------------------------------------------------
        // Retourne l'équipement indexé par code de slot
        // -------------------------------------------------
        public function listerEquipementIndexeParCodeSlot(int $personnage_id): array
        {
            // ---------------------------------------------
            // Lecture brute de l'équipement
            // ---------------------------------------------
            $equipements = $this->listerEquipementPersonnage($personnage_id);

            // ---------------------------------------------
            // Tableau final indexé par code de slot
            // ---------------------------------------------
            $resultat = [];

            // ---------------------------------------------
            // Indexation manuelle par code de slot
            // ---------------------------------------------
            foreach ($equipements as $equipement) {
                $resultat[$equipement['code_slot']] = $equipement;
            }

            // ---------------------------------------------
            // Retour du tableau indexé
            // ---------------------------------------------
            return $resultat;
        }

        // -------------------------------------------------
        // Équipe une instance d'objet dans un slot donné
        // -------------------------------------------------
        public function equiperInstanceDansSlot(int $personnage_id, int $catalogue_slot_id, int $instance_objet_id): bool
        {
            // ---------------------------------------------
            // Insertion ou remplacement du slot occupé
            // ---------------------------------------------
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

            // ---------------------------------------------
            // Exécution
            // ---------------------------------------------
            return $requete->execute([
                'personnage_id' => $personnage_id,
                'catalogue_slot_id' => $catalogue_slot_id,
                'instance_objet_id' => $instance_objet_id,
            ]);
        }

        // -------------------------------------------------
        // Déséquipe un objet d'un slot donné
        // -------------------------------------------------
        public function desequiperSlot(int $personnage_id, int $catalogue_slot_id): bool
        {
            // ---------------------------------------------
            // Requête SQL de suppression du lien d'équipement
            // ---------------------------------------------
            $requete = $this->connexion_base->prepare(
                'DELETE FROM equipements_personnage
                 WHERE personnage_id = :personnage_id
                   AND catalogue_slot_id = :catalogue_slot_id'
            );

            // ---------------------------------------------
            // Exécution
            // ---------------------------------------------
            return $requete->execute([
                'personnage_id' => $personnage_id,
                'catalogue_slot_id' => $catalogue_slot_id,
            ]);
        }
    }
}
