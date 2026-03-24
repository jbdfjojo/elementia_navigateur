<p class="texte-explicatif">
    Choisissez exactement <strong>4 compétences élémentaires</strong> parmi les 10 proposées.
</p>

<p class="texte-explicatif">
    Élément : <strong><?= htmlspecialchars($element_choisi, ENT_QUOTES, 'UTF-8'); ?></strong>
    — Classe : <strong><?= htmlspecialchars($classe_choisie, ENT_QUOTES, 'UTF-8'); ?></strong>
</p>

<div id="compteur-competences-elementaires" class="compteur-selection">
    0 / 4 compétence(s) élémentaire(s) sélectionnée(s)
</div>

<form method="post" action="index.php" class="formulaire-avec-chargement formulaire-limite-choix formulaire-confirmation-competences" data-max-selection="4" data-type-confirmation="elementaires">
    <input type="hidden" name="action" value="creation_personnage_etape_3">
    <input type="hidden" name="confirmation_competences_elementaires" value="non">

    <div class="grille-competences">
        <?php foreach ($competences_elementaires as $competence) : ?>
            <label class="carte-competence carte-competence-detaillee">
                <input type="checkbox" name="competences_elementaires[]" value="<?= htmlspecialchars((string) $competence['code_competence'], ENT_QUOTES, 'UTF-8'); ?>" <?= in_array((string) $competence['code_competence'], $creation['competences_elementaires'] ?? [], true) ? 'checked' : ''; ?>>
                <div class="carte-competence-entete">
                    <strong><?= htmlspecialchars((string) $competence['nom'], ENT_QUOTES, 'UTF-8'); ?></strong>
                    <span class="badge-competence">Actif élémentaire</span>
                </div>
                <div class="resume-competence"><?= htmlspecialchars((string) $competence['resume'], ENT_QUOTES, 'UTF-8'); ?></div>
                <div class="grille-infos-competence">
                    <div class="bloc-info-competence"><span>Coût</span><strong><?= (int) ($competence['cout_utilisation'] ?? 0); ?></strong></div>
                    <div class="bloc-info-competence"><span>Ressource</span><strong><?= htmlspecialchars((string) ($competence['ressource_utilisee'] ?? 'Non renseignée'), ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div class="bloc-info-competence"><span>Choix</span><strong>Définitif au départ</strong></div>
                </div>
            </label>
        <?php endforeach; ?>
    </div>

    <div class="message-importance-competences">
        <strong>Attention :</strong> les compétences élémentaires sont un choix important. Elles ne pourront pas être changées librement. Un maître spécialisé sera nécessaire et elles reviendront niveau 1.
    </div>

    <button type="submit">Valider les compétences élémentaires</button>
</form>

<form method="post" action="index.php" class="formulaire-secondaire formulaire-avec-chargement">
    <input type="hidden" name="action" value="creation_personnage_retour_etape_2">
    <button type="submit" class="bouton-secondaire">Retour à l’étape précédente</button>
</form>
