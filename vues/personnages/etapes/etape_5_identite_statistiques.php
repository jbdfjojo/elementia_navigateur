<p class="texte-explicatif">
    Renseignez l’identité finale du personnage et répartissez <strong>exactement 30 points</strong> dans ses statistiques.
</p>

<div class="bloc-suggestion">
    <h3>Suggestion automatique pour la classe <?= htmlspecialchars($classe_choisie, ENT_QUOTES, 'UTF-8'); ?></h3>
    <div class="grille-suggestion">
        <?php foreach ($suggestion as $nom_statistique => $valeur_statistique) : ?>
            <div class="ligne-suggestion">
                <span><?= htmlspecialchars(str_replace('_', ' ', $nom_statistique), ENT_QUOTES, 'UTF-8'); ?></span>
                <strong><?= (int) $valeur_statistique; ?></strong>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<form method="post" action="index.php" class="formulaire-avec-chargement formulaire-statistiques">
    <input type="hidden" name="action" value="creation_personnage_etape_5">
    <input type="hidden" id="avatar" name="avatar" value="<?= htmlspecialchars((string) ($creation['avatar'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">

    <label for="nom_personnage">Nom du personnage</label>
    <input type="text" id="nom_personnage" name="nom_personnage" maxlength="50" value="<?= htmlspecialchars((string) ($creation['nom'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required>

    <label for="sexe">Sexe</label>
    <select id="sexe" name="sexe" required>
        <option value="">Choisir</option>
        <option value="homme" <?= ($creation['sexe'] ?? '') === 'homme' ? 'selected' : ''; ?>>Homme</option>
        <option value="femme" <?= ($creation['sexe'] ?? '') === 'femme' ? 'selected' : ''; ?>>Femme</option>
    </select>

    <label for="variante_avatar">Variante de l’avatar</label>
    <select id="variante_avatar" name="variante_avatar" required>
        <option value="1" <?= ((int) ($creation['variante_avatar'] ?? 1) === 1) ? 'selected' : ''; ?>>Variante 1</option>
        <option value="2" <?= ((int) ($creation['variante_avatar'] ?? 1) === 2) ? 'selected' : ''; ?>>Variante 2</option>
    </select>

    <label>Aperçu de l’avatar</label>
    <div class="zone-apercu-avatar">
        <div class="carre-apercu-avatar" id="carre-apercu-avatar">
            <span id="texte-apercu-avatar-vide" class="texte-apercu-avatar-vide">Choisissez le sexe puis la variante</span>
            <img id="image-apercu-avatar" src="" alt="Avatar automatique" class="image-apercu-avatar" style="display:none;">
        </div>
        <div class="texte-apercu-avatar" id="texte-apercu-avatar" style="display:none;">
            <strong id="titre-apercu-avatar"><?= htmlspecialchars($classe_choisie, ENT_QUOTES, 'UTF-8'); ?></strong>
            <small id="sous-titre-apercu-avatar"></small>
        </div>
    </div>

    <div id="compteur-statistiques" class="compteur-statistiques">Total utilisé : 0 / 30</div>

    <div class="grille-statistiques">
        <?php foreach ($statistiques_affichees as $nom_statistique => $valeur_statistique) : ?>
            <div class="champ-statistique">
                <label for="<?= htmlspecialchars($nom_statistique, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $nom_statistique)), ENT_QUOTES, 'UTF-8'); ?></label>
                <input type="number" id="<?= htmlspecialchars($nom_statistique, ENT_QUOTES, 'UTF-8'); ?>" name="<?= htmlspecialchars($nom_statistique, ENT_QUOTES, 'UTF-8'); ?>" min="0" step="1" inputmode="none" onkeydown="return false;" onpaste="return false;" ondrop="return false;" value="<?= (int) $valeur_statistique; ?>" required>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="submit">Créer le personnage</button>
</form>

<form method="post" action="index.php" class="formulaire-secondaire formulaire-avec-chargement">
    <input type="hidden" name="action" value="creation_personnage_retour_etape_4">
    <button type="submit" class="bouton-secondaire">Retour à l’étape précédente</button>
</form>
