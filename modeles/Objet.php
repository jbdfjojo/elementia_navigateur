<?php
// ======================================================
// MODELE OBJET
// ======================================================

require_once __DIR__ . '/../configuration/base_de_donnees.php';
require_once __DIR__ . '/Inventaire.php';

class Objet
{
    public static function charger(int $objetId)
    {
        global $connexion_base;

        $sql = "
            SELECT *
            FROM catalogue_objets
            WHERE id = :id
        ";

        $requete = $connexion_base->prepare($sql);
        $requete->execute(['id' => $objetId]);

        return $requete->fetch();
    }

    public static function listerCataloguePourDebug(): array
    {
        global $connexion_base;

        $sql = "
            SELECT
                id,
                nom_objet,
                type_objet,
                categorie_objet,
                rarete_objet,
                est_empilable,
                quantite_max_par_pile
            FROM catalogue_objets
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
        $durabilite = $typeObjet === 'equipement' ? 100 : 1;
        $sourceObtention = 'debug';
        $nombreAjoutes = 0;

        $connexion_base->beginTransaction();

        try {
            if ($estEmpilable) {
                $slotLibre = Inventaire::trouverProchainSlotLibre($personnageId);

                if ($slotLibre === null) {
                    $connexion_base->rollBack();
                    return 0;
                }

                $quantitePile = $quantiteMaxParPile > 0 ? min($quantiteDemandee, $quantiteMaxParPile) : $quantiteDemandee;
                $instanceObjetId = self::creerInstanceObjet($personnageId, $catalogueObjetId, $quantitePile, $durabilite, $sourceObtention);
                Inventaire::ajouterInstanceDansSlot($personnageId, $instanceObjetId, $slotLibre, 1);
                $nombreAjoutes = $quantitePile;
            } else {
                for ($index = 0; $index < $quantiteDemandee; $index++) {
                    $slotLibre = Inventaire::trouverProchainSlotLibre($personnageId);

                    if ($slotLibre === null) {
                        break;
                    }

                    $instanceObjetId = self::creerInstanceObjet($personnageId, $catalogueObjetId, 1, $durabilite, $sourceObtention);
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
