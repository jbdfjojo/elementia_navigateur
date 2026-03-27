<?php
$quetes = $quetes ?? [];
$queteSelectionnee = $quetes[0] ?? null;

function etiquetteEtatQuete(string $etat): string {
    return match ($etat) {
        'terminee' => 'Terminée',
        'echouee' => 'Échouée',
        'en_attente' => 'En attente',
        default => 'En cours',
    };
}
?>
<div id="fenetre-quetes" class="fenetre-jeu-modele fenetre-jeu-cachee" data-cle-fenetre="quetes" role="dialog" aria-modal="true" aria-labelledby="titre-fenetre-quetes">
    <div class="entete-fenetre-jeu">
        <div>
            <h2 id="titre-fenetre-quetes">Quêtes</h2>
            <p>Suivi clair de vos quêtes avec objectif, progression et récompenses.</p>
        </div>
        <button type="button" class="bouton-fermer-fenetre" data-fermer-fenetre="oui" aria-label="Fermer la fenêtre">×</button>
    </div>

    <div class="contenu-fenetre-jeu contenu-fenetre-panneau-double">
        <div class="colonne-liste-jeu">
            <div class="bloc-resume-fenetre">
                <strong><?= count($quetes); ?></strong>
                <span>quête(s) visible(s)</span>
            </div>
            <p class="texte-aide-quetes">Cochez <strong>Suivre</strong> pour afficher la quête sur la carte. Le repère personnel reste visible en même temps avec sa propre flèche rose.</p>

            <div class="liste-entrees-jeu" role="tablist" aria-label="Liste des quêtes">
                <?php if (empty($quetes)) : ?>
                    <div class="carte-entree-jeu carte-entree-vide">
                        <strong>Aucune quête</strong>
                        <p>Le personnage n’a pas encore de quête suivie.</p>
                    </div>
                <?php else : ?>
                    <?php foreach ($quetes as $index => $quete) : ?>
                        <div class="carte-entree-jeu ligne-quete-avec-actions<?= $index === 0 ? ' entree-active' : ''; ?>">
                            <button
                                type="button"
                                class="bouton-entree-detail bouton-entree-detail-quete<?= $index === 0 ? ' entree-active' : ''; ?>"
                                data-quete-id="<?= (int) ($quete['id'] ?? 0); ?>"
                                data-a-position-carte="<?= !empty($quete['a_position_carte']) ? 'oui' : 'non'; ?>"
                                data-cible-detail="quete"
                                data-titre="<?= htmlspecialchars((string) $quete['titre'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-resume="<?= htmlspecialchars((string) $quete['resume'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-description="<?= htmlspecialchars((string) $quete['description'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-objectif="<?= htmlspecialchars((string) $quete['objectif'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-recompense="<?= htmlspecialchars((string) $quete['recompense'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-etat="<?= htmlspecialchars(etiquetteEtatQuete((string) $quete['etat']), ENT_QUOTES, 'UTF-8'); ?>"
                                data-categorie="<?= htmlspecialchars((string) $quete['categorie'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-zone="<?= htmlspecialchars((string) $quete['zone'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-progression="<?= (int) ($quete['progression_actuelle'] ?? 0); ?> / <?= (int) ($quete['progression_maximum'] ?? 1); ?>"
                                data-pourcentage="<?= (int) ($quete['pourcentage_progression'] ?? 0); ?>"
                                data-date="<?= htmlspecialchars((string) $quete['date_evenement'], ENT_QUOTES, 'UTF-8'); ?>"
                            >
                                <div class="ligne-entete-simple">
                                    <strong><?= htmlspecialchars((string) $quete['titre'], ENT_QUOTES, 'UTF-8'); ?></strong>
                                    <div class="ligne-actions-quete">
                                        <?php if (!empty($quete['a_position_carte'])) : ?>
                                            <span class="badge-entree badge-carte-quete">Carte</span>
                                        <?php endif; ?>
                                        <span class="badge-entree badge-etat-<?= htmlspecialchars((string) $quete['etat'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars(etiquetteEtatQuete((string) $quete['etat']), ENT_QUOTES, 'UTF-8'); ?></span>
                                    </div>
                                </div>
                            </button>

                            <label class="case-suivi-quete" title="Suivre cette quête">
                                <input
                                    type="checkbox"
                                    class="case-a-cocher-suivi-quete"
                                    data-quete-id="<?= (int) ($quete['id'] ?? 0); ?>"
                                    <?= !empty($quete['est_suivie']) ? 'checked' : ''; ?>
                                    <?= empty($quete['a_position_carte']) ? 'disabled' : ''; ?>
                                >
                                <span>Suivre</span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="colonne-detail-jeu" data-zone-detail="quete">
            <?php if ($queteSelectionnee) : ?>
                <div class="entete-detail-jeu">
                    <div>
                        <span class="badge-entree badge-etat-<?= htmlspecialchars((string) $queteSelectionnee['etat'], ENT_QUOTES, 'UTF-8'); ?>" data-detail="etat"><?= htmlspecialchars(etiquetteEtatQuete((string) $queteSelectionnee['etat']), ENT_QUOTES, 'UTF-8'); ?></span>
                        <h3 data-detail="titre"><?= htmlspecialchars((string) $queteSelectionnee['titre'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p data-detail="resume"><?= htmlspecialchars((string) $queteSelectionnee['resume'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </div>

                <div class="grille-informations-detail">
                    <div class="case-information-detail"><span>Catégorie</span><strong data-detail="categorie"><?= htmlspecialchars((string) ucfirst((string) $queteSelectionnee['categorie']), ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div class="case-information-detail"><span>Zone</span><strong data-detail="zone"><?= htmlspecialchars((string) ($queteSelectionnee['zone'] ?: 'Monde'), ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div class="case-information-detail"><span>Progression</span><strong data-detail="progression"><?= (int) ($queteSelectionnee['progression_actuelle'] ?? 0); ?> / <?= (int) ($queteSelectionnee['progression_maximum'] ?? 1); ?></strong></div>
                    <div class="case-information-detail"><span>Mise à jour</span><strong data-detail="date"><?= htmlspecialchars((string) ($queteSelectionnee['date_evenement'] ?: 'Non renseignée'), ENT_QUOTES, 'UTF-8'); ?></strong></div>
                </div>

                <div class="bloc-detail-texte">
                    <h4>Description</h4>
                    <p data-detail="description"><?= htmlspecialchars((string) $queteSelectionnee['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>

                <div class="bloc-detail-texte">
                    <h4>Objectif</h4>
                    <p data-detail="objectif"><?= htmlspecialchars((string) $queteSelectionnee['objectif'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>

                <div class="bloc-detail-texte">
                    <h4>Récompense</h4>
                    <p data-detail="recompense"><?= htmlspecialchars((string) $queteSelectionnee['recompense'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>

                <div class="bloc-progression-jeu">
                    <div class="ligne-progression-jeu">
                        <span>Avancement</span>
                        <strong data-detail="progression-barre"><?= (int) ($queteSelectionnee['progression_actuelle'] ?? 0); ?> / <?= (int) ($queteSelectionnee['progression_maximum'] ?? 1); ?></strong>
                    </div>
                    <div class="barre-progression-jeu">
                        <div class="barre-progression-remplissage" data-detail-style="progression" style="width: <?= (int) ($queteSelectionnee['pourcentage_progression'] ?? 0); ?>%;"></div>
                    </div>
                </div>
            <?php else : ?>
                <div class="detail-vide-jeu">
                    <h3>Aucune quête</h3>
                    <p>Quand des quêtes seront actives, leur détail s’affichera ici.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
