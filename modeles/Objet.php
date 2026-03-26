<?php
require_once __DIR__ . '/../configuration/base_de_donnees.php';
require_once __DIR__ . '/Inventaire.php';
require_once __DIR__ . '/Personnage.php';

class Objet
{
    public static function charger(int $objetId)
    {
        global $connexion_base;

        $requete = $connexion_base->prepare("
            SELECT *
            FROM catalogue_objets
            WHERE id = :id
            LIMIT 1
        ");

        $requete->execute(['id' => $objetId]);

        return $requete->fetch() ?: null;
    }

    public static function chargerDepuisInstance(int $personnageId, int $instanceObjetId)
    {
        global $connexion_base;

        $sql = "
            SELECT
                io.id AS instance_objet_id,
                io.catalogue_objet_id,
                io.personnage_proprietaire_id,
                io.quantite,
                io.durabilite_actuelle,
                io.durabilite_maximum,
                io.est_verrouille,
                io.source_obtention,
                io.date_obtention,
                co.*
            FROM instances_objets io
            INNER JOIN catalogue_objets co
                ON co.id = io.catalogue_objet_id
            WHERE io.id = :instance_objet_id
              AND io.personnage_proprietaire_id = :personnage_id
            LIMIT 1
        ";

        $requete = $connexion_base->prepare($sql);
        $requete->execute([
            'instance_objet_id' => $instanceObjetId,
            'personnage_id' => $personnageId
        ]);

        return $requete->fetch() ?: null;
    }

    public static function chargerInstancePersonnage(int $personnageId, int $instanceObjetId)
    {
        return self::chargerDepuisInstance($personnageId, $instanceObjetId);
    }

    public static function estEquipable(array $objet): bool
    {
        return (int) ($objet['est_equipable'] ?? 0) === 1
            || (string) ($objet['type_objet'] ?? '') === 'equipement';
    }

    public static function estConsommable(array $objet): bool
    {
        $typeObjet = (string) ($objet['type_objet'] ?? '');
        $categorieObjet = (string) ($objet['categorie_objet'] ?? '');

        return in_array($typeObjet, ['consommable', 'nourriture'], true)
            || in_array($categorieObjet, [
                'potion_vie',
                'potion_mana',
                'potion_vie_20',
                'potion_vie_60',
                'potion_vie_100',
                'potion_mana_20',
                'potion_mana_60',
                'potion_mana_100'
            ], true);
    }

    public static function listerCataloguePourDebug(): array
    {
        global $connexion_base;

        $sql = "
            SELECT
                id,
                code_objet,
                nom_objet,
                type_objet,
                categorie_objet,
                rarete_objet,
                est_empilable,
                quantite_max_par_pile,
                est_equipable,
                icone_objet
            FROM catalogue_objets
            WHERE COALESCE(est_actif, 1) = 1
            ORDER BY
                CASE WHEN type_objet = 'equipement' THEN 0 ELSE 1 END,
                categorie_objet ASC,
                nom_objet ASC
        ";

        $requete = $connexion_base->query($sql);

        return $requete ? ($requete->fetchAll() ?: []) : [];
    }

    public static function ajouterObjetDebugAuPersonnage(int $personnageId, int $catalogueObjetId, int $quantiteDemandee): int
    {
        global $connexion_base;

        $objetCatalogue = self::charger($catalogueObjetId);

        if (!$objetCatalogue) {
            return 0;
        }

        $quantiteDemandee = max(1, $quantiteDemandee);
        $estEmpilable = (int) ($objetCatalogue['est_empilable'] ?? 0) === 1;
        $quantiteMaxParPile = (int) ($objetCatalogue['quantite_max_par_pile'] ?? 1);
        $typeObjet = (string) ($objetCatalogue['type_objet'] ?? '');
        $durabilite = $typeObjet === 'equipement'
            ? (int) (($objetCatalogue['durabilite_maximum'] ?? 100) ?: 100)
            : 1;

        $nombreAjoutes = 0;

        $connexion_base->beginTransaction();

        try {
            if ($estEmpilable) {
                $quantiteRestante = $quantiteDemandee;

                while ($quantiteRestante > 0) {
                    $slotLibre = Inventaire::trouverProchainSlotLibre($personnageId);

                    if ($slotLibre === null) {
                        break;
                    }

                    $quantitePile = $quantiteMaxParPile > 0
                        ? min($quantiteRestante, $quantiteMaxParPile)
                        : $quantiteRestante;

                    $instanceObjetId = self::creerInstanceObjet(
                        $personnageId,
                        $catalogueObjetId,
                        $quantitePile,
                        $durabilite,
                        'debug'
                    );

                    Inventaire::ajouterInstanceDansSlot($personnageId, $instanceObjetId, $slotLibre, 1);

                    $nombreAjoutes += $quantitePile;
                    $quantiteRestante -= $quantitePile;
                }
            } else {
                for ($index = 0; $index < $quantiteDemandee; $index++) {
                    $slotLibre = Inventaire::trouverProchainSlotLibre($personnageId);

                    if ($slotLibre === null) {
                        break;
                    }

                    $instanceObjetId = self::creerInstanceObjet(
                        $personnageId,
                        $catalogueObjetId,
                        1,
                        $durabilite,
                        'debug'
                    );

                    Inventaire::ajouterInstanceDansSlot($personnageId, $instanceObjetId, $slotLibre, 1);
                    $nombreAjoutes++;
                }
            }

            $connexion_base->commit();

            return $nombreAjoutes;
        } catch (Throwable $exception) {
            if ($connexion_base->inTransaction()) {
                $connexion_base->rollBack();
            }

            throw $exception;
        }
    }

    public static function utiliserObjetInventaire(int $personnageId, int $instanceObjetId): bool
    {
        global $connexion_base;

        $objet = self::chargerDepuisInstance($personnageId, $instanceObjetId);

        if (!$objet || !self::estConsommable($objet)) {
            return false;
        }

        $ressources = Personnage::chargerRessources($personnageId);
        $effets = self::calculerEffetsConsommable($objet, $ressources);

        if (($effets['vie'] ?? 0) <= 0 && ($effets['mana'] ?? 0) <= 0) {
            return false;
        }

        $vieActuelle = (int) ($ressources['vie_actuelle'] ?? 0);
        $vieMax = (int) ($ressources['vie_max'] ?? 0);
        $manaActuel = (int) ($ressources['mana_actuel'] ?? 0);
        $manaMax = (int) ($ressources['mana_max'] ?? 0);
        $peutSoignerVie = (($effets['vie'] ?? 0) > 0) && ($vieActuelle < $vieMax);
        $peutSoignerMana = (($effets['mana'] ?? 0) > 0) && ($manaActuel < $manaMax);

        if (!$peutSoignerVie && !$peutSoignerMana) {
            return false;
        }

        $connexion_base->beginTransaction();

        try {
            if ($peutSoignerVie) {
                $requeteVie = $connexion_base->prepare("
                    UPDATE personnages
                    SET
                        point_de_vie_actuel = LEAST(point_de_vie_maximum, point_de_vie_actuel + :valeur),
                        vie_actuelle = LEAST(vie_max, vie_actuelle + :valeur)
                    WHERE id = :id
                ");
                $requeteVie->execute([
                    'id' => $personnageId,
                    'valeur' => (int) $effets['vie']
                ]);
            }

            if ($peutSoignerMana) {
                $requeteMana = $connexion_base->prepare("
                    UPDATE personnages
                    SET
                        magie_actuelle = LEAST(magie_maximum, magie_actuelle + :valeur),
                        mana_actuel = LEAST(mana_max, mana_actuel + :valeur)
                    WHERE id = :id
                ");
                $requeteMana->execute([
                    'id' => $personnageId,
                    'valeur' => (int) $effets['mana']
                ]);
            }

            self::consommerUneQuantiteOuSupprimer($personnageId, $instanceObjetId);
            $connexion_base->commit();

            return true;
        } catch (Throwable $exception) {
            if ($connexion_base->inTransaction()) {
                $connexion_base->rollBack();
            }

            throw $exception;
        }
    }

    public static function consommerUneQuantiteOuSupprimer(int $personnageId, int $instanceObjetId): bool
    {
        global $connexion_base;

        $objet = self::chargerDepuisInstance($personnageId, $instanceObjetId);

        if (!$objet) {
            return false;
        }

        $quantite = (int) ($objet['quantite'] ?? 1);

        if ($quantite > 1) {
            $requete = $connexion_base->prepare("
                UPDATE instances_objets
                SET quantite = quantite - 1
                WHERE id = :instance_objet_id
                  AND personnage_proprietaire_id = :personnage_id
            ");

            return $requete->execute([
                'instance_objet_id' => $instanceObjetId,
                'personnage_id' => $personnageId
            ]);
        }

        Inventaire::retirerInstance($personnageId, $instanceObjetId);

        return Inventaire::supprimerInstanceObjet($personnageId, $instanceObjetId);
    }

    private static function calculerEffetsConsommable(array $objet, array $ressources = []): array
    {
        $categorieObjet = (string) ($objet['categorie_objet'] ?? '');
        $valeurEffet = (int) ($objet['valeur_effet'] ?? 0);
        $vieMax = max(0, (int) ($ressources['vie_max'] ?? $objet['vie_max'] ?? $objet['point_de_vie_maximum'] ?? 0));
        $manaMax = max(0, (int) ($ressources['mana_max'] ?? $objet['mana_max'] ?? $objet['magie_maximum'] ?? 0));

        if ($categorieObjet === 'potion_vie_20') {
            return ['vie' => max(1, (int) ceil($vieMax * 0.20)), 'mana' => 0];
        }
        if ($categorieObjet === 'potion_vie_60') {
            return ['vie' => max(1, (int) ceil($vieMax * 0.60)), 'mana' => 0];
        }
        if ($categorieObjet === 'potion_vie_100') {
            return ['vie' => max(1, (int) ceil($vieMax * 1.00)), 'mana' => 0];
        }
        if ($categorieObjet === 'potion_mana_20') {
            return ['vie' => 0, 'mana' => max(1, (int) ceil($manaMax * 0.20))];
        }
        if ($categorieObjet === 'potion_mana_60') {
            return ['vie' => 0, 'mana' => max(1, (int) ceil($manaMax * 0.60))];
        }
        if ($categorieObjet === 'potion_mana_100') {
            return ['vie' => 0, 'mana' => max(1, (int) ceil($manaMax * 1.00))];
        }
        if ($categorieObjet === 'potion_vie') {
            return ['vie' => max(1, $valeurEffet), 'mana' => 0];
        }
        if ($categorieObjet === 'potion_mana') {
            return ['vie' => 0, 'mana' => max(1, $valeurEffet)];
        }

        return ['vie' => 0, 'mana' => 0];
    }

    private static function creerInstanceObjet(int $personnageId, int $catalogueObjetId, int $quantite, int $durabilite, string $sourceObtention): int
    {
        global $connexion_base;

        $sql = "
            INSERT INTO instances_objets (
                catalogue_objet_id,
                personnage_proprietaire_id,
                quantite,
                durabilite_actuelle,
                durabilite_maximum,
                est_verrouille,
                source_obtention
            ) VALUES (
                :catalogue_objet_id,
                :personnage_proprietaire_id,
                :quantite,
                :durabilite_actuelle,
                :durabilite_maximum,
                0,
                :source_obtention
            )
        ";

        $requete = $connexion_base->prepare($sql);
        $requete->execute([
            'catalogue_objet_id' => $catalogueObjetId,
            'personnage_proprietaire_id' => $personnageId,
            'quantite' => max(1, $quantite),
            'durabilite_actuelle' => max(1, $durabilite),
            'durabilite_maximum' => max(1, $durabilite),
            'source_obtention' => $sourceObtention
        ]);

        return (int) $connexion_base->lastInsertId();
    }
}
