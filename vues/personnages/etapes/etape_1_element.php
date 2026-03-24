<p class="texte-explicatif">
    Choisissez le type élémentaire que votre personnage incarnera.
    Ce choix détermine aussi la région de départ.
</p>

<form method="post" action="index.php" class="formulaire-avec-chargement">
    <input type="hidden" name="action" value="creation_personnage_etape_1">

    <div class="grille-choix-cartes">
        <label class="carte-choix-element element-feu">
            <input type="radio" name="element" value="Feu" <?= $element_choisi === 'Feu' ? 'checked' : ''; ?> required>
            <span class="icone-element">🔥</span>
            <strong>Feu</strong>
            <small>Région : <?= htmlspecialchars(Routeur::obtenirRegionDepartParElement('Feu'), ENT_QUOTES, 'UTF-8'); ?></small>
        </label>

        <label class="carte-choix-element element-eau">
            <input type="radio" name="element" value="Eau" <?= $element_choisi === 'Eau' ? 'checked' : ''; ?> required>
            <span class="icone-element">💧</span>
            <strong>Eau</strong>
            <small>Région : <?= htmlspecialchars(Routeur::obtenirRegionDepartParElement('Eau'), ENT_QUOTES, 'UTF-8'); ?></small>
        </label>

        <label class="carte-choix-element element-air">
            <input type="radio" name="element" value="Air" <?= $element_choisi === 'Air' ? 'checked' : ''; ?> required>
            <span class="icone-element">🌪</span>
            <strong>Air</strong>
            <small>Région : <?= htmlspecialchars(Routeur::obtenirRegionDepartParElement('Air'), ENT_QUOTES, 'UTF-8'); ?></small>
        </label>

        <label class="carte-choix-element element-terre">
            <input type="radio" name="element" value="Terre" <?= $element_choisi === 'Terre' ? 'checked' : ''; ?> required>
            <span class="icone-element">🌿</span>
            <strong>Terre</strong>
            <small>Région : <?= htmlspecialchars(Routeur::obtenirRegionDepartParElement('Terre'), ENT_QUOTES, 'UTF-8'); ?></small>
        </label>
    </div>

    <button type="submit">Valider l’élément</button>
</form>
