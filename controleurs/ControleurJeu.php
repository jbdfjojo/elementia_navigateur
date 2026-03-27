<?php
declare(strict_types=1);

require_once __DIR__ . '/../modeles/Personnage.php';
require_once __DIR__ . '/../modeles/Inventaire.php';
require_once __DIR__ . '/../modeles/Equipement.php';
require_once __DIR__ . '/../modeles/Objet.php';
require_once __DIR__ . '/../modeles/Competence.php';
require_once __DIR__ . '/../modeles/Quete.php';
require_once __DIR__ . '/../modeles/Journal.php';
require_once __DIR__ . '/../modeles/Carte.php';
require_once __DIR__ . '/../configuration/base_de_donnees.php';

if (!class_exists('ControleurJeu')) {
class ControleurJeu
{
    public static function chargerDonnees(int $personnageId): array
    {
        global $connexion_base;
        self::traiterActionsPost($personnageId);
        Personnage::corrigerPositionSiInvalide($personnageId);
        $personnage = Personnage::calculerStats($personnageId);
        $inventaire = Inventaire::charger($personnageId);
        $poidsInventaire = Inventaire::calculerPoidsTotal($personnageId);
        $modeleEquipement = new Equipement($connexion_base);
        $equipements = $modeleEquipement->listerEquipementPersonnage($personnageId);
        $competences = Competence::chargerCompetencesPersonnage($personnageId);
        $quetes = Quete::chargerQuetesPersonnage($personnageId, $personnage ?: []);
        $journal = Journal::chargerEntreesPersonnage($personnageId, $personnage ?: [], $quetes, $competences);
        $carte = Carte::chargerDonneesFenetre($personnage ?: []);
        return [
            'personnage' => $personnage ?: [],
            'inventaire' => $inventaire,
            'poids_inventaire' => $poidsInventaire,
            'equipements' => $equipements,
            'competences' => $competences,
            'quetes' => $quetes,
            'journal' => $journal,
            'carte' => $carte,
        ];
    }

    private static function traiterActionsPost(int $personnageId): void
    {
        global $connexion_base;
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') return;
        $action = (string) ($_POST['action'] ?? '');
        if ($action === '') return;

        if ($action === 'debug_retirer_vie_fixe') {
            Personnage::retirerVieFixe($personnageId, 50);
            return;
        }
        if ($action === 'debug_retirer_vie_pourcentage') {
            Personnage::retirerViePourcentage($personnageId, 10);
            return;
        }
        if ($action === 'debug_retirer_mana_fixe') {
            Personnage::retirerManaFixe($personnageId, 50);
            return;
        }
        if ($action === 'debug_retirer_mana_pourcentage') {
            Personnage::retirerManaPourcentage($personnageId, 10);
            return;
        }

        $instanceObjetId = (int) ($_POST['instance_objet_id'] ?? 0);
        if ($instanceObjetId <= 0) return;
        $modeleEquipement = new Equipement($connexion_base);
        if (!$modeleEquipement->verifierProprieteInstance($personnageId, $instanceObjetId)) return;

        if ($action === 'utiliser_objet_inventaire') {
            Objet::utiliserObjetInventaire($personnageId, $instanceObjetId);
            return;
        }
        if ($action === 'equiper_ou_remplacer_objet') {
            self::equiperOuRemplacerObjet($personnageId, $instanceObjetId, $modeleEquipement);
            return;
        }
        if ($action === 'equiper_objet_inventaire') {
            self::equiperObjetInventaire($personnageId, $instanceObjetId, $modeleEquipement);
            return;
        }
        if ($action === 'equiper_objet_slot') {
            $slotCible = (string) ($_POST['slot_cible'] ?? '');
            if ($slotCible !== '') self::equiperObjetDansSlotCible($personnageId, $instanceObjetId, $slotCible, $modeleEquipement);
            return;
        }
        if ($action === 'desequiper_objet_equipe') {
            self::desequiperObjetEquipe($personnageId, $instanceObjetId, $modeleEquipement);
            return;
        }
        if ($action === 'jeter_objet_inventaire') {
            $connexion_base->beginTransaction();
            try {
                $modeleEquipement->desequiperInstance($personnageId, $instanceObjetId);
                Inventaire::retirerInstance($personnageId, $instanceObjetId);
                Inventaire::supprimerInstanceObjet($personnageId, $instanceObjetId);
                $connexion_base->commit();
            } catch (\Throwable $erreur) {
                if ($connexion_base->inTransaction()) $connexion_base->rollBack();
                throw $erreur;
            }
        }
    }

    private static function equiperObjetInventaire(int $personnageId, int $instanceObjetId, Equipement $modeleEquipement): void
    {
        global $connexion_base;
        $connexion_base->beginTransaction();
        try {
            if ($modeleEquipement->instanceDejaEquipee($instanceObjetId)) { $connexion_base->rollBack(); return; }
            $slotsCibles = $modeleEquipement->determinerSlotsCiblesPourInstance($personnageId, $instanceObjetId);
            if (empty($slotsCibles) || !$modeleEquipement->slotsSontLibres($personnageId, $slotsCibles)) { $connexion_base->rollBack(); return; }
            Inventaire::retirerInstance($personnageId, $instanceObjetId);
            $modeleEquipement->equiperInstanceDansSlots($personnageId, $slotsCibles, $instanceObjetId);
            $connexion_base->commit();
        } catch (\Throwable $erreur) {
            if ($connexion_base->inTransaction()) $connexion_base->rollBack();
            throw $erreur;
        }
    }

    private static function equiperObjetDansSlotCible(int $personnageId, int $instanceObjetId, string $slotCible, Equipement $modeleEquipement): void
    {
        global $connexion_base;
        $connexion_base->beginTransaction();
        try {
            if ($modeleEquipement->instanceDejaEquipee($instanceObjetId)) { $connexion_base->rollBack(); return; }
            $slotTrouve = $modeleEquipement->trouverSlotCompatiblePourCible($personnageId, $instanceObjetId, $slotCible);
            if (!$slotTrouve) { $connexion_base->rollBack(); return; }
            $slotId = (int) $slotTrouve['id'];
            $occupants = $modeleEquipement->listerEquipementsDansSlots($personnageId, [$slotId]);
            foreach ($occupants as $equipementExistant) {
                $instanceExistante = (int) ($equipementExistant['instance_objet_id'] ?? 0);
                if ($instanceExistante > 0) {
                    $slotLibreInventaire = Inventaire::trouverProchainSlotLibre($personnageId);
                    if ($slotLibreInventaire === null) { $connexion_base->rollBack(); return; }
                    $modeleEquipement->desequiperInstance($personnageId, $instanceExistante);
                    Inventaire::ajouterInstanceDansSlot($personnageId, $instanceExistante, $slotLibreInventaire, 1);
                }
            }
            Inventaire::retirerInstance($personnageId, $instanceObjetId);
            $modeleEquipement->equiperInstanceDansSlots($personnageId, [$slotId], $instanceObjetId);
            $connexion_base->commit();
        } catch (\Throwable $erreur) {
            if ($connexion_base->inTransaction()) $connexion_base->rollBack();
            throw $erreur;
        }
    }

    private static function equiperOuRemplacerObjet(int $personnageId, int $instanceObjetId, Equipement $modeleEquipement): void
    {
        global $connexion_base;
        $connexion_base->beginTransaction();
        try {
            if ($modeleEquipement->instanceDejaEquipee($instanceObjetId)) { $connexion_base->rollBack(); return; }
            $slotsCibles = $modeleEquipement->determinerSlotsCiblesPourInstance($personnageId, $instanceObjetId);
            if (empty($slotsCibles)) { $connexion_base->rollBack(); return; }

            $equipementsExistants = $modeleEquipement->listerEquipementsDansSlots($personnageId, $slotsCibles);
            $instancesExistantes = [];
            foreach ($equipementsExistants as $equipementExistant) {
                $instancesExistantes[] = (int) $equipementExistant['instance_objet_id'];
            }
            $instancesExistantes = array_values(array_unique($instancesExistantes));

            foreach ($instancesExistantes as $instanceExistante) {
                $slotLibreInventaire = Inventaire::trouverProchainSlotLibre($personnageId);
                if ($slotLibreInventaire === null) { $connexion_base->rollBack(); return; }
                $modeleEquipement->desequiperInstance($personnageId, $instanceExistante);
                Inventaire::ajouterInstanceDansSlot($personnageId, $instanceExistante, $slotLibreInventaire, 1);
            }

            Inventaire::retirerInstance($personnageId, $instanceObjetId);
            $modeleEquipement->equiperInstanceDansSlots($personnageId, $slotsCibles, $instanceObjetId);
            $connexion_base->commit();
        } catch (\Throwable $erreur) {
            if ($connexion_base->inTransaction()) $connexion_base->rollBack();
            throw $erreur;
        }
    }

    private static function desequiperObjetEquipe(int $personnageId, int $instanceObjetId, Equipement $modeleEquipement): void
    {
        global $connexion_base;
        $connexion_base->beginTransaction();
        try {
            $slotLibre = Inventaire::trouverProchainSlotLibre($personnageId);
            if ($slotLibre === null) { $connexion_base->rollBack(); return; }
            $modeleEquipement->desequiperInstance($personnageId, $instanceObjetId);
            Inventaire::ajouterInstanceDansSlot($personnageId, $instanceObjetId, $slotLibre, 1);
            $connexion_base->commit();
        } catch (\Throwable $erreur) {
            if ($connexion_base->inTransaction()) $connexion_base->rollBack();
            throw $erreur;
        }
    }
}
}
