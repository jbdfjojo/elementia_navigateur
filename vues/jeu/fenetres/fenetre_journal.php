<?php
$journal = $journal ?? [];
$entreeSelectionnee = $journal[0] ?? null;
?>
<div id="fenetre-journal" class="fenetre-jeu-modele fenetre-jeu-cachee" data-cle-fenetre="journal" role="dialog" aria-modal="true" aria-labelledby="titre-fenetre-journal">
    <div class="entete-fenetre-jeu">
        <div>
            <h2 id="titre-fenetre-journal">Journal</h2>
            <p>Historique du joueur et du monde : événements, combats, quêtes et faits importants.</p>
        </div>
        <button type="button" class="bouton-fermer-fenetre" data-fermer-fenetre="oui" aria-label="Fermer la fenêtre">×</button>
    </div>

    <div class="contenu-fenetre-jeu contenu-fenetre-panneau-double">
        <div class="colonne-liste-jeu">
            <div class="bloc-resume-fenetre">
                <strong><?= count($journal); ?></strong>
                <span>entrée(s) enregistrée(s)</span>
            </div>

            <div class="liste-entrees-jeu" role="tablist" aria-label="Entrées du journal">
                <?php if (empty($journal)) : ?>
                    <div class="carte-entree-jeu carte-entree-vide">
                        <strong>Journal vide</strong>
                        <p>Aucun événement n’est encore enregistré.</p>
                    </div>
                <?php else : ?>
                    <?php foreach ($journal as $index => $entree) : ?>
                        <button
                            type="button"
                            class="carte-entree-jeu bouton-entree-detail<?= $index === 0 ? ' entree-active' : ''; ?>"
                            data-cible-detail="journal"
                            data-titre="<?= htmlspecialchars((string) $entree['titre'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-resume="<?= htmlspecialchars((string) $entree['resume'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-details="<?= htmlspecialchars((string) $entree['details'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-categorie="<?= htmlspecialchars((string) $entree['categorie'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-importance="<?= htmlspecialchars((string) $entree['importance'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-date="<?= htmlspecialchars((string) $entree['date_evenement'], ENT_QUOTES, 'UTF-8'); ?>"
                        >
                            <div class="ligne-entete-simple ligne-entete-journal">
                                <span class="badge-entree badge-categorie-journal"><?= htmlspecialchars((string) ucfirst((string) $entree['categorie']), ENT_QUOTES, 'UTF-8'); ?></span>
                                <strong><?= htmlspecialchars((string) $entree['titre'], ENT_QUOTES, 'UTF-8'); ?></strong>
                            </div>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="colonne-detail-jeu" data-zone-detail="journal">
            <?php if ($entreeSelectionnee) : ?>
                <div class="entete-detail-jeu">
                    <div>
                        <span class="badge-entree badge-categorie-journal" data-detail="categorie"><?= htmlspecialchars((string) ucfirst((string) $entreeSelectionnee['categorie']), ENT_QUOTES, 'UTF-8'); ?></span>
                        <h3 data-detail="titre"><?= htmlspecialchars((string) $entreeSelectionnee['titre'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p data-detail="resume"><?= htmlspecialchars((string) $entreeSelectionnee['resume'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </div>

                <div class="grille-informations-detail">
                    <div class="case-information-detail"><span>Catégorie</span><strong data-detail="categorie-secondaire"><?= htmlspecialchars((string) ucfirst((string) $entreeSelectionnee['categorie']), ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div class="case-information-detail"><span>Importance</span><strong data-detail="importance"><?= htmlspecialchars((string) ucfirst((string) $entreeSelectionnee['importance']), ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div class="case-information-detail case-information-detail-large"><span>Date</span><strong data-detail="date"><?= htmlspecialchars((string) ($entreeSelectionnee['date_evenement'] ?: 'Non renseignée'), ENT_QUOTES, 'UTF-8'); ?></strong></div>
                </div>

                <div class="bloc-detail-texte">
                    <h4>Détail</h4>
                    <p data-detail="details"><?= htmlspecialchars((string) $entreeSelectionnee['details'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            <?php else : ?>
                <div class="detail-vide-jeu">
                    <h3>Journal vide</h3>
                    <p>Quand des événements seront enregistrés, leur détail s’affichera ici.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
