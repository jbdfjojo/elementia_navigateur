<?php
// ---------------------------------------------------------
// RÉCUPÉRATION DES MESSAGES TEMPORAIRES
// ---------------------------------------------------------
$messages_erreur_affichage = $_SESSION['messages_erreur'] ?? [];

// ---------------------------------------------------------
// RÉCUPÉRATION DES MESSAGES DE SUCCÈS TEMPORAIRES
// ---------------------------------------------------------
$messages_succes_affichage = $_SESSION['messages_succes'] ?? [];

// ---------------------------------------------------------
// RÉCUPÉRATION DE L’ANCIEN PSEUDO SAISI
// ---------------------------------------------------------
$ancien_pseudo = $_SESSION['ancien_pseudo'] ?? '';

// ---------------------------------------------------------
// NETTOYAGE DES MESSAGES TEMPORAIRES APRÈS LECTURE
// ---------------------------------------------------------
unset($_SESSION['messages_erreur'], $_SESSION['messages_succes'], $_SESSION['ancien_pseudo']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Définition de l’encodage -->
    <meta charset="UTF-8">

    <!-- Adaptation mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Titre global -->
    <title>Elementia</title>

    <!-- Feuille de style principale -->
    <link rel="stylesheet" href="ressources/css/base.css">
</head>
<body>
    <!-- Écran de chargement -->
    <div id="ecran-chargement" class="ecran-chargement">
        <div class="boite-chargement">
            <!-- Petit logo uniquement pour le chargement -->
            <img src="ressources/images/logo.png" alt="Logo Elementia" class="logo-chargement">

            <!-- Animation de chargement -->
            <div class="spinner-chargement"></div>

            <!-- Texte de chargement -->
            <p>Chargement...</p>
        </div>
    </div>

    <!-- Conteneur principal -->
    <main class="page-authentification">
        <!-- Carte principale -->
        <section class="carte-authentification <?= ($vue === 'connexion' || $vue === 'inscription') ? 'carte-authentification-simple' : ''; ?>">

            <!-- Zone du titre uniquement -->
            <div class="zone-logo">
				<!-- Logo principal du jeu -->
				<img src="ressources/images/logo.png" alt="Logo Elementia" class="logo-principal">

                <!-- Sous-titre selon la vue actuelle -->
                <?php if ($vue === 'connexion') : ?>
                    <p class="sous-titre">Connexion du joueur</p>
                <?php elseif ($vue === 'inscription') : ?>
                    <p class="sous-titre">Création du compte joueur</p>
                <?php elseif ($vue === 'selection_personnage') : ?>
                    <p class="sous-titre">Sélection du personnage</p>
                <?php elseif ($vue === 'creation_personnage') : ?>
                    <p class="sous-titre">Création d’un personnage</p>
                <?php else : ?>
                    <p class="sous-titre">Entrée dans le monde</p>
                <?php endif; ?>
            </div>

            <!-- Affichage des erreurs -->
            <?php if (!empty($messages_erreur_affichage)) : ?>
                <div class="boite-message boite-erreur">
                    <?php foreach ($messages_erreur_affichage as $message_erreur) : ?>
                        <p><?= htmlspecialchars($message_erreur, ENT_QUOTES, 'UTF-8'); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Affichage des succès -->
            <?php if (!empty($messages_succes_affichage)) : ?>
                <div class="boite-message boite-succes">
                    <?php foreach ($messages_succes_affichage as $message_succes) : ?>
                        <p><?= htmlspecialchars($message_succes, ENT_QUOTES, 'UTF-8'); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Chargement de la bonne vue -->
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

    <!-- Script de gestion du chargement -->
    <script src="ressources/js/interface.js"></script>
</body>
</html>