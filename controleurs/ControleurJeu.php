<?php
declare(strict_types=1);

require_once __DIR__ . '/../modeles/Personnage.php';
require_once __DIR__ . '/../modeles/Inventaire.php';
require_once __DIR__ . '/../modeles/Equipement.php';
require_once __DIR__ . '/../configuration/base_de_donnees.php';

if (!class_exists('ControleurJeu')) {

class ControleurJeu
{
    public static function chargerDonnees(int $personnageId): array
    {
        global $connexion_base;

        self::traiterActionsPost($personnageId);

        $personnage = Personnage::calculerStats($personnageId);
        $inventaire = Inventaire::charger($personnageId);
        $poidsInventaire = Inventaire::calculerPoidsTotal($personnageId);

        $modeleEquipement = new Equipement($connexion_base);
        $equipements = $modeleEquipement->listerEquipementPersonnage($personnageId);

        return [
            'personnage' => $personnage ?: [],
            'inventaire' => $inventaire,
            'poids_inventaire' => $poidsInventaire,
            'equipements' => $equipements,
        ];
    }

    private static function traiterActionsPost(int $personnageId): void
    {
        global $connexion_base;

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            return;
        }

        $action = (string) ($_POST['action'] ?? '');

        if ($action === '') {
            return;
        }

        $instanceObjetId = (int) ($_POST['instance_objet_id'] ?? 0);

        if ($instanceObjetId <= 0) {
            return;
        }

        $modeleEquipement = new Equipement($connexion_base);

        if (!$modeleEquipement->verifierProprieteInstance($personnageId, $instanceObjetId)) {
            return;
        }

        if ($action === 'equiper_objet_inventaire') {
            $connexion_base->beginTransaction();

            try {
                if ($modeleEquipement->instanceDejaEquipee($instanceObjetId)) {
                    $connexion_base->rollBack();
                    return;
                }

                $slotLibre = $modeleEquipement->trouverSlotLibreCompatible($personnageId, $instanceObjetId);

                if (!$slotLibre) {
                    $connexion_base->rollBack();
                    return;
                }

                Inventaire::retirerInstance($personnageId, $instanceObjetId);
                $modeleEquipement->equiperInstanceDansSlot($personnageId, (int) $slotLibre['id'], $instanceObjetId);

                $connexion_base->commit();
            } catch (\Throwable $erreur) {
                if ($connexion_base->inTransaction()) {
                    $connexion_base->rollBack();
                }
                throw $erreur;
            }

            return;
        }

        if ($action === 'equiper_objet_slot') {
            $slotCible = (string) ($_POST['slot_cible'] ?? '');

            if ($slotCible === '') {
                return;
            }

            $connexion_base->beginTransaction();

            try {
                if ($modeleEquipement->instanceDejaEquipee($instanceObjetId)) {
                    $connexion_base->rollBack();
                    return;
                }

                $slotTrouve = $modeleEquipement->trouverSlotCompatiblePourCible($personnageId, $instanceObjetId, $slotCible);

                if (!$slotTrouve) {
                    $connexion_base->rollBack();
                    return;
                }

                if ($modeleEquipement->slotOccupe($personnageId, (int) $slotTrouve['id'])) {
                    $connexion_base->rollBack();
                    return;
                }

                Inventaire::retirerInstance($personnageId, $instanceObjetId);
                $modeleEquipement->equiperInstanceDansSlot($personnageId, (int) $slotTrouve['id'], $instanceObjetId);

                $connexion_base->commit();
            } catch (\Throwable $erreur) {
                if ($connexion_base->inTransaction()) {
                    $connexion_base->rollBack();
                }
                throw $erreur;
            }

            return;
        }

        if ($action === 'desequiper_objet_equipe') {
            $connexion_base->beginTransaction();

            try {
                $slotLibre = Inventaire::trouverProchainSlotLibre($personnageId);

                if ($slotLibre === null) {
                    $connexion_base->rollBack();
                    return;
                }

                $modeleEquipement->desequiperInstance($personnageId, $instanceObjetId);
                Inventaire::ajouterInstanceDansSlot($personnageId, $instanceObjetId, $slotLibre, 1);

                $connexion_base->commit();
            } catch (\Throwable $erreur) {
                if ($connexion_base->inTransaction()) {
                    $connexion_base->rollBack();
                }
                throw $erreur;
            }

            return;
        }

        if ($action === 'jeter_objet_inventaire') {
            $connexion_base->beginTransaction();

            try {
                Inventaire::retirerInstance($personnageId, $instanceObjetId);
                Inventaire::supprimerInstanceObjet($personnageId, $instanceObjetId);

                $connexion_base->commit();
            } catch (\Throwable $erreur) {
                if ($connexion_base->inTransaction()) {
                    $connexion_base->rollBack();
                }
                throw $erreur;
            }

            return;
        }
    }
}

}