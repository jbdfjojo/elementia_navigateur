<p class="texte-explicatif">
    Élément choisi : <strong><?= htmlspecialchars($element_choisi, ENT_QUOTES, 'UTF-8'); ?></strong>
    — Région de départ : <strong><?= htmlspecialchars((string) ($creation['region_depart'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></strong>
</p>

<form method="post" action="index.php" class="formulaire-avec-chargement">
    <input type="hidden" name="action" value="creation_personnage_etape_2">

    <div class="grille-choix-cartes">
        <?php foreach ($classes_disponibles as $nom_classe => $description_classe) : ?>
            <label class="carte-choix-classe">
                <input type="radio" name="classe" value="<?= htmlspecialchars($nom_classe, ENT_QUOTES, 'UTF-8'); ?>" <?= $classe_choisie === $nom_classe ? 'checked' : ''; ?> required>
                <strong><?= htmlspecialchars($nom_classe, ENT_QUOTES, 'UTF-8'); ?></strong>
                <small><?= htmlspecialchars($description_classe, ENT_QUOTES, 'UTF-8'); ?></small>
            </label>
        <?php endforeach; ?>
    </div>

    <button type="submit">Valider la classe</button>
</form>

<form method="post" action="index.php" class="formulaire-secondaire formulaire-avec-chargement">
    <input type="hidden" name="action" value="creation_personnage_retour_etape_1">
    <button type="submit" class="bouton-secondaire">Retour à l’étape précédente</button>
</form>
