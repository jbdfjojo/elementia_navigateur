<p class="texte-explicatif">
    Choisissez exactement <strong>3 compétences neutres</strong> parmi les 10 proposées.
</p>

<div id="compteur-competences-neutres" class="compteur-selection">
    0 / 3 compétence(s) neutre(s) sélectionnée(s)
</div>

<form method="post" action="index.php" class="formulaire-avec-chargement formulaire-limite-choix formulaire-confirmation-competences" data-max-selection="3" data-type-confirmation="neutres">
    <input type="hidden" name="action" value="creation_personnage_etape_4">
    <input type="hidden" name="confirmation_competences_neutres" value="non">

    <div class="grille-competences">
        <?php foreach ($competences_neutres as $competence) : ?>
            <label class="carte-competence carte-competence-detaillee">
                <input type="checkbox" name="competences_neutres[]" value="<?= htmlspecialchars((string) $competence['code_competence'], ENT_QUOTES, 'UTF-8'); ?>" <?= in_array((string) $competence['code_competence'], $creation['competences_neutres'] ?? [], true) ? 'checked' : ''; ?>>
                <div class="carte-competence-entete">
                    <strong><?= htmlspecialchars((string) $competence['nom'], ENT_QUOTES, 'UTF-8'); ?></strong>
                    <span class="badge-competence">Neutre évolutive</span>
                </div>
                <div class="resume-competence"><?= htmlspecialchars((string) $competence['resume'], ENT_QUOTES, 'UTF-8'); ?></div>
                <div class="grille-infos-competence">
                    <div class="bloc-info-competence"><span>Type</span><strong>Progression naturelle</strong></div>
                    <div class="bloc-info-competence"><span>Déblocage</span><strong><?= htmlspecialchars((string) ($competence['declencheur_progression'] ?? 'Non renseigné'), ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div class="bloc-info-competence"><span>Évolution</span><strong>Selon vos actions</strong></div>
                </div>
            </label>
        <?php endforeach; ?>
    </div>

    <div class="message-importance-competences">
        <strong>Information :</strong> les compétences neutres évoluent avec vos actions. Elles peuvent être débloquées et améliorées selon votre style de jeu et votre progression naturelle.
    </div>

    <button type="submit">Valider les compétences neutres</button>
</form>

<form method="post" action="index.php" class="formulaire-secondaire formulaire-avec-chargement">
    <input type="hidden" name="action" value="creation_personnage_retour_etape_3">
    <button type="submit" class="bouton-secondaire">Retour à l’étape précédente</button>
</form>
