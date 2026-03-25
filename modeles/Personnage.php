<?php
// ======================================================
// MODELE PERSONNAGE
// ======================================================

require_once __DIR__ . '/../configuration/base_de_donnees.php';

class Personnage
{
    // --------------------------------------------------
    // Charger un personnage par ID
    // --------------------------------------------------
    public static function charger(int $personnageId)
    {
        global $connexion_base;

        $sql = "
            SELECT *
            FROM personnages
            WHERE id = :id
            LIMIT 1
        ";

        $requete = $connexion_base->prepare($sql);
        $requete->execute([
            'id' => $personnageId
        ]);

        return $requete->fetch();
    }

    // --------------------------------------------------
    // Calculer les statistiques finales avec équipement
    // --------------------------------------------------
    public static function calculerStats(int $personnageId)
    {
        global $connexion_base;

        $sql = "
            SELECT
                p.id,
                p.compte_id,
                p.nom,
                p.element,
                p.classe,
                p.sexe,
                p.niveau,
                p.position_x,
                p.position_y,
                p.date_creation,

                (p.point_de_vie + IFNULL(SUM(co.bonus_point_de_vie), 0)) AS point_de_vie,
                (p.attaque + IFNULL(SUM(co.bonus_attaque), 0)) AS attaque,
                (p.magie + IFNULL(SUM(co.bonus_magie), 0)) AS magie,
                (p.agilite + IFNULL(SUM(co.bonus_agilite), 0)) AS agilite,
                (p.intelligence + IFNULL(SUM(co.bonus_intelligence), 0)) AS intelligence,
                (p.synchronisation_elementaire + IFNULL(SUM(co.bonus_synchronisation_elementaire), 0)) AS synchronisation_elementaire,
                (p.critique + IFNULL(SUM(co.bonus_critique), 0)) AS critique,
                (p.dexterite + IFNULL(SUM(co.bonus_dexterite), 0)) AS dexterite,
                (p.defense + IFNULL(SUM(co.bonus_defense), 0)) AS defense

            FROM personnages p
            LEFT JOIN equipements_personnage ep
                ON ep.personnage_id = p.id
            LEFT JOIN instances_objets io
                ON io.id = ep.instance_objet_id
            LEFT JOIN catalogue_objets co
                ON co.id = io.catalogue_objet_id
            WHERE p.id = :id
            GROUP BY
                p.id,
                p.compte_id,
                p.nom,
                p.element,
                p.classe,
                p.sexe,
                p.niveau,
                p.position_x,
                p.position_y,
                p.date_creation,
                p.point_de_vie,
                p.attaque,
                p.magie,
                p.agilite,
                p.intelligence,
                p.synchronisation_elementaire,
                p.critique,
                p.dexterite,
                p.defense
            LIMIT 1
        ";

        $requete = $connexion_base->prepare($sql);
        $requete->execute([
            'id' => $personnageId
        ]);

        return $requete->fetch();
    }
}