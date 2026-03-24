<?php
$requete_personnages = $connexion_base->prepare(
    'SELECT id, nom, element, classe, niveau, region_depart, portrait
     FROM personnages
     WHERE compte_id = :compte_id
     ORDER BY id ASC'
);

$requete_personnages->execute([
    'compte_id' => $_SESSION['compte_id']
]);

$personnages = $requete_personnages->fetchAll();
?>
<div class="bloc-formulaire module-personnages">
    <h2>Bienvenue <?= htmlspecialchars($_SESSION['pseudo'], ENT_QUOTES, 'UTF-8'); ?></h2>

    <p class="texte-explicatif">
        Choisissez un personnage existant, supprimez-en un, ou créez-en un nouveau.
    </p>

    <?php include __DIR__ . '/liste_personnages.php'; ?>

    <div class="zone-actions-secondaires">
        <form method="post" action="index.php" class="formulaire-avec-chargement">
            <input type="hidden" name="action" value="afficher_creation_personnage">
            <button type="submit">Créer un personnage</button>
        </form>

        <form method="post" action="index.php" class="formulaire-avec-chargement">
            <input type="hidden" name="action" value="deconnexion">
            <button type="submit" class="bouton-secondaire">Se déconnecter</button>
        </form>
    </div>
</div>
