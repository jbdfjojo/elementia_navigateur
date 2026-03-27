<?php
// ======================================================
// MODELE PERSONNAGE
// ======================================================

require_once __DIR__ . '/../configuration/base_de_donnees.php';

class Personnage
{
    public static function charger(int $personnageId)
    {
        global $connexion_base;

        $sql = "SELECT * FROM personnages WHERE id = :id LIMIT 1";
        $requete = $connexion_base->prepare($sql);
        $requete->execute(['id' => $personnageId]);
        return $requete->fetch();
    }



    public static function corrigerPositionSiInvalide(int $personnageId): void
    {
        global $connexion_base;

        $sqlLecture = "SELECT position_x, position_y FROM personnages WHERE id = :id LIMIT 1";
        $requeteLecture = $connexion_base->prepare($sqlLecture);
        $requeteLecture->execute(['id' => $personnageId]);
        $position = $requeteLecture->fetch();

        if (!$position) {
            return;
        }

        $positionX = (int) ($position['position_x'] ?? 0);
        $positionY = (int) ($position['position_y'] ?? 0);

        if ($positionX > 0 && $positionY > 0) {
            return;
        }

        $sqlMiseAJour = "UPDATE personnages SET position_x = :position_x, position_y = :position_y WHERE id = :id";
        $requeteMiseAJour = $connexion_base->prepare($sqlMiseAJour);
        $requeteMiseAJour->execute([
            'position_x' => 18,
            'position_y' => 12,
            'id' => $personnageId,
        ]);
    }


    public static function chargerPosition(int $personnageId): array
    {
        global $connexion_base;

        $sql = "SELECT position_x, position_y FROM personnages WHERE id = :id LIMIT 1";
        $requete = $connexion_base->prepare($sql);
        $requete->execute(['id' => $personnageId]);
        $position = $requete->fetch() ?: [];

        return [
            'x' => max(0, (int) ($position['position_x'] ?? 18)),
            'y' => max(0, (int) ($position['position_y'] ?? 12)),
        ];
    }

    public static function sauvegarderPosition(int $personnageId, int $positionX, int $positionY): void
    {
        global $connexion_base;

        $positionX = max(0, min(39, $positionX));
        $positionY = max(0, min(26, $positionY));

        $sql = "UPDATE personnages SET position_x = :position_x, position_y = :position_y WHERE id = :id";
        $requete = $connexion_base->prepare($sql);
        $requete->execute([
            'id' => $personnageId,
            'position_x' => $positionX,
            'position_y' => $positionY,
        ]);
    }

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
                p.point_de_vie_actuel,
                p.point_de_vie_maximum,
                p.magie_actuelle,
                p.magie_maximum,
                p.vie_actuelle,
                p.vie_max,
                p.mana_actuel,
                p.mana_max,

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
            LEFT JOIN (
                SELECT DISTINCT personnage_id, instance_objet_id
                FROM equipements_personnage
                WHERE personnage_id = :id
            ) epu ON epu.personnage_id = p.id
            LEFT JOIN instances_objets io ON io.id = epu.instance_objet_id
            LEFT JOIN catalogue_objets co ON co.id = io.catalogue_objet_id
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
                p.point_de_vie_actuel,
                p.point_de_vie_maximum,
                p.attaque,
                p.magie,
                p.magie_actuelle,
                p.magie_maximum,
                p.agilite,
                p.intelligence,
                p.synchronisation_elementaire,
                p.critique,
                p.dexterite,
                p.defense,
                p.vie_actuelle,
                p.vie_max,
                p.mana_actuel,
                p.mana_max
            LIMIT 1
        ";

        $requete = $connexion_base->prepare($sql);
        $requete->execute(['id' => $personnageId]);
        return $requete->fetch();
    }

    public static function chargerRessources(int $personnageId): array
    {
        $personnage = self::charger($personnageId) ?: [];
        $stats = self::calculerStats($personnageId) ?: [];

        $vieActuelle = array_key_exists('point_de_vie_actuel', $personnage)
            ? (int) $personnage['point_de_vie_actuel']
            : (int) ($personnage['vie_actuelle'] ?? 0);

        $manaActuel = array_key_exists('magie_actuelle', $personnage)
            ? (int) $personnage['magie_actuelle']
            : (int) ($personnage['mana_actuel'] ?? 0);

        $vieMax = max(
            (int) ($personnage['point_de_vie_maximum'] ?? 0),
            (int) ($personnage['vie_max'] ?? 0),
            (int) ($stats['point_de_vie'] ?? 0)
        );

        $manaMax = max(
            (int) ($personnage['magie_maximum'] ?? 0),
            (int) ($personnage['mana_max'] ?? 0),
            (int) ($stats['magie'] ?? 0)
        );

        if ($vieMax <= 0) {
            $vieMax = max(1, (int) ($stats['point_de_vie'] ?? 1));
        }

        if ($manaMax <= 0) {
            $manaMax = max(1, (int) ($stats['magie'] ?? 1));
        }

        $vieActuelle = max(0, min($vieActuelle, $vieMax));
        $manaActuel = max(0, min($manaActuel, $manaMax));

        return [
            'vie_actuelle' => $vieActuelle,
            'vie_max' => $vieMax,
            'mana_actuel' => $manaActuel,
            'mana_max' => $manaMax,
        ];
    }

    public static function ajouterVie(int $personnageId, int $quantite): int
    {
        $ressources = self::chargerRessources($personnageId);
        $nouvelleVie = min($ressources['vie_max'], $ressources['vie_actuelle'] + max(0, $quantite));
        self::enregistrerRessources($personnageId, $nouvelleVie, $ressources['mana_actuel'], $ressources['vie_max'], $ressources['mana_max']);
        return $nouvelleVie;
    }

    public static function ajouterMana(int $personnageId, int $quantite): int
    {
        $ressources = self::chargerRessources($personnageId);
        $nouveauMana = min($ressources['mana_max'], $ressources['mana_actuel'] + max(0, $quantite));
        self::enregistrerRessources($personnageId, $ressources['vie_actuelle'], $nouveauMana, $ressources['vie_max'], $ressources['mana_max']);
        return $nouveauMana;
    }

    public static function retirerVieFixe(int $personnageId, int $quantite): int
    {
        $ressources = self::chargerRessources($personnageId);
        $nouvelleVie = max(0, $ressources['vie_actuelle'] - max(0, $quantite));
        self::enregistrerRessources($personnageId, $nouvelleVie, $ressources['mana_actuel'], $ressources['vie_max'], $ressources['mana_max']);
        return $nouvelleVie;
    }

    public static function retirerViePourcentage(int $personnageId, int $pourcentage): int
    {
        $ressources = self::chargerRessources($personnageId);
        $quantite = (int) ceil($ressources['vie_max'] * max(0, $pourcentage) / 100);
        return self::retirerVieFixe($personnageId, $quantite);
    }

    public static function retirerManaFixe(int $personnageId, int $quantite): int
    {
        $ressources = self::chargerRessources($personnageId);
        $nouveauMana = max(0, $ressources['mana_actuel'] - max(0, $quantite));
        self::enregistrerRessources($personnageId, $ressources['vie_actuelle'], $nouveauMana, $ressources['vie_max'], $ressources['mana_max']);
        return $nouveauMana;
    }

    public static function retirerManaPourcentage(int $personnageId, int $pourcentage): int
    {
        $ressources = self::chargerRessources($personnageId);
        $quantite = (int) ceil($ressources['mana_max'] * max(0, $pourcentage) / 100);
        return self::retirerManaFixe($personnageId, $quantite);
    }

    private static function enregistrerRessources(int $personnageId, int $vieActuelle, int $manaActuel, int $vieMax, int $manaMax): void
    {
        global $connexion_base;

        $sql = "
            UPDATE personnages
            SET
                point_de_vie_actuel = :point_de_vie_actuel,
                vie_actuelle = :vie_actuelle,
                point_de_vie_maximum = :point_de_vie_maximum,
                vie_max = :vie_max,
                magie_actuelle = :magie_actuelle,
                mana_actuel = :mana_actuel,
                magie_maximum = :magie_maximum,
                mana_max = :mana_max
            WHERE id = :id
        ";

        $requete = $connexion_base->prepare($sql);
        $requete->execute([
            'id' => $personnageId,
            'point_de_vie_actuel' => max(0, $vieActuelle),
            'vie_actuelle' => max(0, $vieActuelle),
            'point_de_vie_maximum' => max(1, $vieMax),
            'vie_max' => max(1, $vieMax),
            'magie_actuelle' => max(0, $manaActuel),
            'mana_actuel' => max(0, $manaActuel),
            'magie_maximum' => max(1, $manaMax),
            'mana_max' => max(1, $manaMax),
        ]);
    }
}
