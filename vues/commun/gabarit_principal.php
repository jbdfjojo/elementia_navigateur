<?php
$messages_erreur_affichage = $_SESSION['messages_erreur'] ?? [];
$messages_succes_affichage = $_SESSION['messages_succes'] ?? [];
$ancien_pseudo = $_SESSION['ancien_pseudo'] ?? '';
$nettoyer_interface_jeu = $_SESSION['nettoyer_interface_jeu'] ?? '';
unset($_SESSION['messages_erreur'], $_SESSION['messages_succes'], $_SESSION['ancien_pseudo'], $_SESSION['nettoyer_interface_jeu']);
$est_vue_jeu = ($vue === 'jeu');
if ($est_vue_jeu) { $messages_succes_affichage = []; }
$personnage_id_body = isset($_SESSION['personnage_id']) ? (int) $_SESSION['personnage_id'] : 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elementia</title>
    <link rel="stylesheet" href="ressources/css/base.css">
    <link rel="stylesheet" href="ressources/css/connexion.css">
    <link rel="stylesheet" href="ressources/css/personnages.css">
    <link rel="stylesheet" href="ressources/css/jeu.css">
    <link rel="stylesheet" href="ressources/css/fenetres.css">
</head>
<body class="<?= $est_vue_jeu ? 'body-mode-jeu' : ''; ?>" data-est-vue-jeu="<?= $est_vue_jeu ? 'oui' : 'non'; ?>" data-personnage-id="<?= $personnage_id_body; ?>" data-nettoyer-interface-jeu="<?= htmlspecialchars((string) $nettoyer_interface_jeu, ENT_QUOTES, 'UTF-8'); ?>">
    <div id="ecran-chargement" class="ecran-chargement" style="display:none !important;">
        <div class="boite-chargement">
            <img src="ressources/images/logo.png" alt="Logo Elementia" class="logo-chargement">
            <div class="spinner-chargement"></div>
            <p>Chargement...</p>
        </div>
    </div>

    <main class="<?= $est_vue_jeu ? 'page-jeu-principale' : 'page-authentification'; ?>">
        <section class="<?= $est_vue_jeu ? 'carte-jeu-principale' : 'carte-authentification'; ?> <?= (!$est_vue_jeu && ($vue === 'connexion' || $vue === 'inscription')) ? 'carte-authentification-simple' : ''; ?>">
            <?php if (!$est_vue_jeu) : ?>
                <div class="zone-logo">
                    <img src="ressources/images/logo.png" alt="Logo Elementia" class="logo-principal">
                    <?php if ($vue === 'connexion') : ?><p class="sous-titre">Connexion du joueur</p>
                    <?php elseif ($vue === 'inscription') : ?><p class="sous-titre">Création du compte joueur</p>
                    <?php elseif ($vue === 'selection_personnage') : ?><p class="sous-titre">Sélection du personnage</p>
                    <?php elseif ($vue === 'creation_personnage') : ?><p class="sous-titre">Création d’un personnage</p><?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($messages_erreur_affichage)) : ?>
                <div class="boite-message boite-erreur <?= $est_vue_jeu ? 'boite-message-jeu' : ''; ?>" <?= $est_vue_jeu ? 'data-message-temporaire="oui"' : ''; ?>>
                    <?php foreach ($messages_erreur_affichage as $message_erreur) : ?><p><?= htmlspecialchars($message_erreur, ENT_QUOTES, 'UTF-8'); ?></p><?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($messages_succes_affichage)) : ?>
                <div class="boite-message boite-succes <?= $est_vue_jeu ? 'boite-message-jeu' : ''; ?>" <?= $est_vue_jeu ? 'data-message-temporaire="oui"' : ''; ?>>
                    <?php foreach ($messages_succes_affichage as $message_succes) : ?><p><?= htmlspecialchars($message_succes, ENT_QUOTES, 'UTF-8'); ?></p><?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php
            if ($vue === 'connexion') {
                include __DIR__ . '/../connexion/vue_connexion.php';
            } elseif ($vue === 'inscription') {
                include __DIR__ . '/../inscription/vue_inscription.php';
            } elseif ($vue === 'selection_personnage') {
                include __DIR__ . '/../personnages/vue_selection_personnage.php';
            } elseif ($vue === 'creation_personnage') {
                include __DIR__ . '/../personnages/vue_creation_personnage.php';
            } else {
                include __DIR__ . '/../jeu/vue_jeu.php';
            }
            ?>
        </section>
    </main>

    <script src="ressources/js/interface.js"></script>
    <script src="ressources/js/connexion.js"></script>
    <script src="ressources/js/personnages.js"></script>

    <?php if ($est_vue_jeu) : ?>
        <script src="ressources/js/temps.js"></script>
        <script src="ressources/js/jeu.js"></script>
        <script src="ressources/js/carte.js"></script>
        <script src="ressources/js/carte_monde.js"></script>
        <script src="ressources/js/carte_live.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('[data-message-temporaire="oui"]').forEach(function (message) {
                    window.setTimeout(function () {
                        message.style.transition = 'opacity 0.25s ease';
                        message.style.opacity = '0';
                        window.setTimeout(function () {
                            if (message.parentNode) {
                                message.parentNode.removeChild(message);
                            }
                        }, 250);
                    }, 1400);
                });
            });
        </script>
    <?php endif; ?>
</body>
</html>
