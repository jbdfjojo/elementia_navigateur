<?php
$competences = $competences ?? [];
$competenceSelectionnee = $competences[0] ?? null;

function etiquetteFamilleCompetenceSimple(string $famille): string {
    return $famille === 'elementaire' ? 'Élémentaire' : 'Neutre';
}
?>
<div id="fenetre-competences" class="fenetre-jeu-modele fenetre-jeu-cachee" data-cle-fenetre="competences" role="dialog" aria-modal="true" aria-labelledby="titre-fenetre-competences">
    <div class="entete-fenetre-jeu">
        <div>
            <h2 id="titre-fenetre-competences">Compétences</h2>
            <p>Consultez vos sorts sélectionnés, leur niveau, leur coût, leur effet et leur progression.</p>
        </div>
        <button type="button" class="bouton-fermer-fenetre" data-fermer-fenetre="oui" aria-label="Fermer la fenêtre">×</button>
    </div>

    <div class="contenu-fenetre-jeu contenu-fenetre-panneau-double contenu-fenetre-simple">
        <div class="colonne-liste-jeu">
            <div class="bloc-resume-fenetre">
                <strong><?= count($competences); ?></strong>
                <span>compétence(s) visible(s)</span>
            </div>

            <div class="liste-entrees-jeu" role="tablist" aria-label="Liste des compétences">
                <?php if (empty($competences)) : ?>
                    <div class="carte-entree-jeu carte-entree-vide">
                        <strong>Aucune compétence</strong>
                        <p>Le personnage n’a pas encore de compétence enregistrée.</p>
                    </div>
                <?php else : ?>
                    <?php foreach ($competences as $index => $competence) : ?>
                        <button
                            type="button"
                            class="carte-entree-jeu bouton-entree-detail<?= $index === 0 ? ' entree-active' : ''; ?>"
                            data-cible-detail="competence"
                            data-nom="<?= htmlspecialchars((string) $competence['nom'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-resume="<?= htmlspecialchars((string) $competence['resume'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-description="<?= htmlspecialchars((string) $competence['description_detaillee'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-famille="<?= htmlspecialchars(etiquetteFamilleCompetenceSimple((string) $competence['famille_competence']), ENT_QUOTES, 'UTF-8'); ?>"
                            data-element="<?= htmlspecialchars((string) $competence['element'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-classe="<?= htmlspecialchars((string) $competence['classe'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-cout="<?= (int) ($competence['cout_utilisation'] ?? 0); ?>"
                            data-ressource="<?= htmlspecialchars((string) $competence['ressource_utilisee'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-portee="<?= htmlspecialchars((string) $competence['portee'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-cible="<?= htmlspecialchars((string) $competence['type_cible'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-puissance="<?= (int) ($competence['valeur_base'] ?? 0); ?>"
                            data-formule="<?= htmlspecialchars((string) $competence['formule_effet'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-progression="<?= htmlspecialchars((string) $competence['declencheur_progression'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-niveau="<?= (int) ($competence['niveau_sort'] ?? 1); ?>"
                            data-niveau-max="<?= (int) ($competence['niveau_max_actuel'] ?? 1); ?>"
                            data-xp="<?= (int) ($competence['xp_actuelle'] ?? 0); ?>"
                            data-xp-suivante="<?= (int) ($competence['xp_suivante'] ?? 100); ?>"
                            data-pourcentage-xp="<?= (int) ($competence['pourcentage_xp'] ?? 0); ?>"
                            data-slot="<?= (int) ($competence['ordre_slot'] ?? 1); ?>"
                            data-active="<?= (int) ($competence['est_equipee'] ?? 1); ?>"
                            data-ultime="<?= (int) ($competence['est_ultime'] ?? 0); ?>"
                        >
                            <div class="ligne-entree-simple">
                                <strong><?= htmlspecialchars((string) $competence['nom'], ENT_QUOTES, 'UTF-8'); ?></strong>
                                <span class="badge-entree badge-famille-<?= htmlspecialchars((string) $competence['famille_competence'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars(etiquetteFamilleCompetenceSimple((string) $competence['famille_competence']), ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="colonne-detail-jeu" data-zone-detail="competence">
            <?php if ($competenceSelectionnee) : ?>
                <div class="entete-detail-jeu">
                    <div>
                        <span class="badge-entree badge-famille-<?= htmlspecialchars((string) $competenceSelectionnee['famille_competence'], ENT_QUOTES, 'UTF-8'); ?>" data-detail="famille"><?= htmlspecialchars(etiquetteFamilleCompetenceSimple((string) $competenceSelectionnee['famille_competence']), ENT_QUOTES, 'UTF-8'); ?></span>
                        <h3 data-detail="nom"><?= htmlspecialchars((string) $competenceSelectionnee['nom'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p data-detail="resume"><?= htmlspecialchars((string) $competenceSelectionnee['resume'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                    <div class="bloc-niveau-competence">
                        <strong data-detail="niveau">Niv. <?= (int) ($competenceSelectionnee['niveau_sort'] ?? 1); ?></strong>
                        <span data-detail="slot">Slot <?= (int) ($competenceSelectionnee['ordre_slot'] ?? 1); ?></span>
                    </div>
                </div>

                <div class="grille-informations-detail">
                    <div class="case-information-detail"><span>Élément</span><strong data-detail="element"><?= htmlspecialchars((string) $competenceSelectionnee['element'], ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div class="case-information-detail"><span>Classe</span><strong data-detail="classe"><?= htmlspecialchars((string) ($competenceSelectionnee['classe'] ?: 'Toutes'), ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div class="case-information-detail"><span>Coût</span><strong data-detail="cout"><?= (int) ($competenceSelectionnee['cout_utilisation'] ?? 0); ?> <?= htmlspecialchars((string) ($competenceSelectionnee['ressource_utilisee'] ?? 'PM'), ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div class="case-information-detail"><span>Portée</span><strong data-detail="portee"><?= htmlspecialchars((string) $competenceSelectionnee['portee'], ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div class="case-information-detail"><span>Cible</span><strong data-detail="cible"><?= htmlspecialchars((string) $competenceSelectionnee['type_cible'], ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div class="case-information-detail"><span>Puissance</span><strong data-detail="puissance"><?= (int) ($competenceSelectionnee['valeur_base'] ?? 0); ?></strong></div>
                </div>

                <div class="bloc-detail-texte">
                    <h4>Description</h4>
                    <p data-detail="description"><?= htmlspecialchars((string) $competenceSelectionnee['description_detaillee'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>

                <div class="bloc-detail-texte">
                    <h4>Effet / formule</h4>
                    <p data-detail="formule"><?= htmlspecialchars((string) ($competenceSelectionnee['formule_effet'] ?: 'Aucune formule détaillée enregistrée pour le moment.'), ENT_QUOTES, 'UTF-8'); ?></p>
                </div>

                <div class="bloc-detail-texte">
                    <h4>Progression</h4>
                    <p data-detail="progression"><?= htmlspecialchars((string) (($competenceSelectionnee['declencheur_progression'] ?? '') !== '' ? $competenceSelectionnee['declencheur_progression'] : 'Cette compétence progressera avec votre utilisation et les futures règles de progression.'), ENT_QUOTES, 'UTF-8'); ?></p>
                </div>

                <div class="bloc-progression-jeu">
                    <div class="ligne-progression-jeu">
                        <span>XP du sort</span>
                        <strong data-detail="xp">0 / 100</strong>
                    </div>
                    <div class="barre-progression-jeu">
                        <div class="barre-progression-remplissage" data-detail-style="xp" style="width: <?= (int) ($competenceSelectionnee['pourcentage_xp'] ?? 0); ?>%;"></div>
                    </div>
                </div>
            <?php else : ?>
                <div class="detail-vide-jeu">
                    <h3>Aucune compétence</h3>
                    <p>Quand des compétences seront présentes, leur détail s’affichera ici.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
