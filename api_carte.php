<?php
declare(strict_types=1);

session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/configuration/base_de_donnees.php';
require_once __DIR__ . '/modeles/Personnage.php';
require_once __DIR__ . '/modeles/Carte.php';
require_once __DIR__ . '/modeles/Quete.php';

if (empty($_SESSION['personnage_id'])) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'message' => 'Personnage non connecté.']);
    exit;
}

$personnageId = (int) $_SESSION['personnage_id'];
$action = (string) ($_REQUEST['action'] ?? '');

if ($action === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Action manquante.']);
    exit;
}

try {
    if ($action === 'charger_etat') {
        $position = Personnage::chargerPosition($personnageId);
        $reperes = Carte::listerReperesPersonnels($personnageId);
        $destination = Carte::lireDestinationActive($personnageId);
        $quetes = Quete::chargerQuetesPersonnage($personnageId, Personnage::calculerStats($personnageId) ?: []);

        $queteActive = null;
        if ((int) ($destination['quete_id'] ?? 0) > 0) {
            foreach ($quetes as $quete) {
                if ((int) ($quete['id'] ?? 0) === (int) ($destination['quete_id'] ?? 0) && !empty($quete['position_carte'])) {
                    $queteActive = [
                        'id' => (int) $quete['id'],
                        'titre' => (string) $quete['titre'],
                        'x' => (int) ($quete['position_carte']['x'] ?? 0),
                        'y' => (int) ($quete['position_carte']['y'] ?? 0),
                    ];
                    break;
                }
            }
        }

        $repereSelectionne = null;
        if ((int) ($destination['repere_id'] ?? 0) > 0) {
            foreach ($reperes as $repere) {
                if ((int) ($repere['id'] ?? 0) === (int) ($destination['repere_id'] ?? 0)) {
                    $repereSelectionne = $repere;
                    break;
                }
            }
        }

        echo json_encode([
            'ok' => true,
            'position' => $position,
            'reperes' => $reperes,
            'destination' => $destination,
            'quete_active' => $queteActive,
            'quete_suivie' => $queteActive,
            'repere_selectionne' => $repereSelectionne,
        ]);
        exit;
    }

    if ($action === 'sauvegarder_position') {
        $positionX = (int) ($_POST['position_x'] ?? $_GET['position_x'] ?? 18);
        $positionY = (int) ($_POST['position_y'] ?? $_GET['position_y'] ?? 12);
        Personnage::sauvegarderPosition($personnageId, $positionX, $positionY);
        echo json_encode(['ok' => true]);
        exit;
    }

    if ($action === 'creer_repere') {
        $nom = (string) ($_POST['nom'] ?? $_GET['nom'] ?? '');
        $positionX = (int) ($_POST['position_x'] ?? $_GET['position_x'] ?? 0);
        $positionY = (int) ($_POST['position_y'] ?? $_GET['position_y'] ?? 0);
        $repere = Carte::creerReperePersonnel($personnageId, $nom, $positionX, $positionY);
        echo json_encode(['ok' => true, 'repere' => $repere]);
        exit;
    }

    if ($action === 'supprimer_repere') {
        $repereId = (int) ($_POST['repere_id'] ?? $_GET['repere_id'] ?? 0);
        Carte::supprimerReperePersonnel($personnageId, $repereId);
        echo json_encode(['ok' => true]);
        exit;
    }

    if ($action === 'definir_repere_actif') {
        $repereId = (int) ($_POST['repere_id'] ?? $_GET['repere_id'] ?? 0);
        Carte::definirRepereActif($personnageId, $repereId);
        echo json_encode(['ok' => true]);
        exit;
    }

    if ($action === 'definir_quete_suivie') {
        $queteId = (int) ($_POST['quete_id'] ?? $_GET['quete_id'] ?? 0);
        if ($queteId > 0) {
            Quete::definirQueteSuivie($personnageId, $queteId);
        } else {
            Quete::effacerQueteSuivie($personnageId);
        }
        echo json_encode(['ok' => true]);
        exit;
    }

    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Action inconnue.']);
} catch (Throwable $erreur) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => $erreur->getMessage()]);
}
