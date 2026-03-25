<?php
require_once __DIR__ . '/../configuration/base_de_donnees.php';

class Inventaire
{
    public static function charger(int $personnageId): array
    {
        global $connexion_base;

        $sql = "
            SELECT
                ipi.id AS inventaire_id,
                ipi.personnage_id,
                ipi.catalogue_onglet_id,
                ipi.instance_objet_id,
                ipi.position_slot,
                io.catalogue_objet_id,
                io.quantite,
                io.durabilite_actuelle,
                io.durabilite_maximum,
                io.est_verrouille,
                io.source_obtention,
                io.date_obtention,
                co.code_objet,
                co.nom_objet,
                co.description_objet,
                co.type_objet,
                co.categorie_objet,
                co.rarete_objet,
                co.poids_unitaire,
                co.est_empilable,
                co.quantite_max_par_pile,
                co.icone_objet,
                co.bonus_point_de_vie,
                co.bonus_attaque,
                co.bonus_magie,
                co.bonus_agilite,
                co.bonus_intelligence,
                co.bonus_synchronisation_elementaire,
                co.bonus_critique,
                co.bonus_dexterite,
                co.bonus_defense
            FROM inventaire_personnage_instances ipi
            INNER JOIN instances_objets io
                ON io.id = ipi.instance_objet_id
            INNER JOIN catalogue_objets co
                ON co.id = io.catalogue_objet_id
            WHERE ipi.personnage_id = :id
            ORDER BY ipi.position_slot ASC
        ";

        $requete = $connexion_base->prepare($sql);
        $requete->execute([
            'id' => $personnageId
        ]);

        return $requete->fetchAll() ?: [];
    }

    public static function calculerPoidsTotal(int $personnageId): int
    {
        global $connexion_base;

        $sql = "
            SELECT IFNULL(SUM(io.quantite * co.poids_unitaire), 0) AS poids_total
            FROM inventaire_personnage_instances ipi
            INNER JOIN instances_objets io
                ON io.id = ipi.instance_objet_id
            INNER JOIN catalogue_objets co
                ON co.id = io.catalogue_objet_id
            WHERE ipi.personnage_id = :id
        ";

        $requete = $connexion_base->prepare($sql);
        $requete->execute([
            'id' => $personnageId
        ]);

        $resultat = $requete->fetch();
        return (int) ($resultat['poids_total'] ?? 0);
    }

    public static function retirerInstance(int $personnageId, int $instanceObjetId): bool
    {
        global $connexion_base;

        $sql = "
            DELETE FROM inventaire_personnage_instances
            WHERE personnage_id = :personnage_id
              AND instance_objet_id = :instance_objet_id
        ";

        $requete = $connexion_base->prepare($sql);

        return $requete->execute([
            'personnage_id' => $personnageId,
            'instance_objet_id' => $instanceObjetId
        ]);
    }

    public static function supprimerInstanceObjet(int $personnageId, int $instanceObjetId): bool
    {
        global $connexion_base;

        $sql = "
            DELETE FROM instances_objets
            WHERE id = :instance_objet_id
              AND personnage_proprietaire_id = :personnage_id
        ";

        $requete = $connexion_base->prepare($sql);

        return $requete->execute([
            'instance_objet_id' => $instanceObjetId,
            'personnage_id' => $personnageId
        ]);
    }

    public static function trouverProchainSlotLibre(int $personnageId, int $maximumSlots = 48): ?int
    {
        $inventaire = self::charger($personnageId);
        $slotsOccupes = [];

        foreach ($inventaire as $objetInventaire) {
            $slot = (int) ($objetInventaire['position_slot'] ?? 0);

            if ($slot > 0) {
                $slotsOccupes[$slot] = true;
            }
        }

        for ($slot = 1; $slot <= $maximumSlots; $slot++) {
            if (!isset($slotsOccupes[$slot])) {
                return $slot;
            }
        }

        return null;
    }

    public static function ajouterInstanceDansSlot(int $personnageId, int $instanceObjetId, int $positionSlot, int $catalogueOngletId = 1): bool
    {
        global $connexion_base;

        $sql = "
            INSERT INTO inventaire_personnage_instances (
                personnage_id,
                catalogue_onglet_id,
                instance_objet_id,
                position_slot
            ) VALUES (
                :personnage_id,
                :catalogue_onglet_id,
                :instance_objet_id,
                :position_slot
            )
        ";

        $requete = $connexion_base->prepare($sql);

        return $requete->execute([
            'personnage_id' => $personnageId,
            'catalogue_onglet_id' => $catalogueOngletId,
            'instance_objet_id' => $instanceObjetId,
            'position_slot' => $positionSlot
        ]);
    }
}