<?php
$carte = $carte ?? [];
$pointsInteret = $carte['points_interet'] ?? [];
$zonesColoriees = $carte['zones_colorees'] ?? [];
$legende = $carte['legende'] ?? [];
$regions = $carte['regions'] ?? [];
$positionJoueur = $carte['position_joueur'] ?? ['x' => 18, 'y' => 12, 'region' => 'Elementia'];
$colonnesCarte = max(1, (int) ($carte['colonnes'] ?? 40));
$lignesCarte = max(1, (int) ($carte['lignes'] ?? 27));
?>
<div id="fenetre-carte" class="fenetre-jeu-modele fenetre-carte fenetre-jeu-cachee" data-cle-fenetre="carte" data-colonnes="<?= $colonnesCarte; ?>" data-lignes="<?= $lignesCarte; ?>" role="dialog" aria-modal="true" aria-labelledby="titre-fenetre-carte">
    <div class="entete-fenetre-jeu">
        <div>
            <h2 id="titre-fenetre-carte">Carte du monde</h2>
            <p>Vue quadrillée du monde, coordonnées réelles et repères personnels du joueur.</p>
        </div>
        <button type="button" class="bouton-fermer-fenetre" data-fermer-fenetre="oui" aria-label="Fermer la fenêtre">×</button>
    </div>

    <div class="contenu-fenetre-jeu contenu-fenetre-carte-complete">
        <div class="zone-carte-complete">
            <div class="barre-filtres-carte">
                <label><input type="checkbox" class="filtre-carte" value="ville" checked> Villes</label>
                <label><input type="checkbox" class="filtre-carte" value="ponton" checked> Pontons</label>
                <label><input type="checkbox" class="filtre-carte" value="special" checked> Lieux spéciaux</label>
                <label><input type="checkbox" class="filtre-carte" value="repere" checked> Repères personnels</label>
            </div>

            <div class="cadre-carte-complete cadre-carte-complete-grille" id="cadre-carte-complete" data-colonnes="<?= $colonnesCarte; ?>" data-lignes="<?= $lignesCarte; ?>" data-position-x="<?= (int) ($positionJoueur['x'] ?? 0); ?>" data-position-y="<?= (int) ($positionJoueur['y'] ?? 0); ?>">
                <img src="<?= htmlspecialchars((string) ($carte['image_carte'] ?? 'ressources/images/carte/carte_du_monde.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Carte complète du monde d’Elementia" class="image-carte-complete">
                <div class="grille-carte-complete" aria-hidden="true"></div>

                <div class="calque-zones-carte" id="calque-zones-carte">
                    <?php foreach ($zonesColoriees as $zone) : ?>
                        <div class="zone-carte-coloriee zone-carte-coloriee-<?= htmlspecialchars((string) ($zone['type'] ?? 'special'), ENT_QUOTES, 'UTF-8'); ?>" data-type="<?= htmlspecialchars((string) ($zone['type'] ?? 'special'), ENT_QUOTES, 'UTF-8'); ?>" title="<?= htmlspecialchars((string) ($zone['nom'] ?? 'Zone'), ENT_QUOTES, 'UTF-8'); ?>" style="left: <?= (((int) ($zone['colonne'] ?? 0)) / $colonnesCarte) * 100; ?>%; top: <?= (((int) ($zone['ligne'] ?? 0)) / $lignesCarte) * 100; ?>%; width: <?= ((max(1, (int) ($zone['largeur'] ?? 1))) / $colonnesCarte) * 100; ?>%; height: <?= ((max(1, (int) ($zone['hauteur'] ?? 1))) / $lignesCarte) * 100; ?>%;"></div>
                    <?php endforeach; ?>
                </div>

                <div class="calque-points-carte" id="calque-points-carte">
                    <?php foreach ($pointsInteret as $point) : ?>
                        <div class="marqueur-carte marqueur-carte-officiel marqueur-carte-<?= htmlspecialchars((string) ($point['type'] ?? 'ville'), ENT_QUOTES, 'UTF-8'); ?>" style="left: <?= (((float) ($point['x'] ?? 0) + 0.5) / $colonnesCarte) * 100; ?>%; top: <?= (((float) ($point['y'] ?? 0) + 0.5) / $lignesCarte) * 100; ?>%;" data-type="<?= htmlspecialchars((string) ($point['type'] ?? 'ville'), ENT_QUOTES, 'UTF-8'); ?>" data-x="<?= (float) ($point['x'] ?? 0); ?>" data-y="<?= (float) ($point['y'] ?? 0); ?>" title="<?= htmlspecialchars((string) ($point['nom'] ?? 'Point d’intérêt'), ENT_QUOTES, 'UTF-8'); ?> (<?= (float) ($point['x'] ?? 0); ?> x <?= (float) ($point['y'] ?? 0); ?>)">
                            <span class="marqueur-carte-point"></span>
                            <span class="marqueur-carte-etiquette"><?= htmlspecialchars((string) ($point['nom'] ?? 'Point d’intérêt'), ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    <?php endforeach; ?>

                    <div class="marqueur-carte marqueur-carte-joueur" id="marqueur-carte-joueur" style="left: <?= (((float) ($positionJoueur['x'] ?? 0) + 0.5) / $colonnesCarte) * 100; ?>%; top: <?= (((float) ($positionJoueur['y'] ?? 0) + 0.5) / $lignesCarte) * 100; ?>%;" title="Vous (<?= (int) ($positionJoueur['x'] ?? 0); ?> x <?= (int) ($positionJoueur['y'] ?? 0); ?>)">
                        <span class="marqueur-carte-point"></span>
                        <span class="marqueur-carte-etiquette">Vous</span>
                    </div>

                    <div class="marqueur-carte marqueur-carte-quete" id="marqueur-carte-quete" style="display:none;"><span class="marqueur-carte-point"></span><span class="marqueur-carte-etiquette">Quête suivie</span></div>
                    <div class="calque-reperes-personnels" id="calque-reperes-personnels"></div>
                </div>
            </div>

            <div class="barre-outils-carte">
                <button type="button" id="bouton-ajouter-repere-carte" class="bouton-parametre-secondaire">Ajouter un repère</button>
                <button type="button" id="bouton-supprimer-repere-carte" class="bouton-petit-parametre">Supprimer le repère sélectionné</button>
                <div class="etat-mode-carte" id="etat-mode-carte">Mode normal</div>
            </div>
        </div>

        <div class="colonne-carte-infos">
            <section class="carte-parametres-jeu">
                <h3>Position actuelle</h3>
                <p>Coordonnées : <strong><?= (int) ($positionJoueur['x'] ?? 0); ?> x <?= (int) ($positionJoueur['y'] ?? 0); ?></strong></p>
                <p>Région liée au personnage : <strong><?= htmlspecialchars((string) ($positionJoueur['region'] ?? 'Elementia'), ENT_QUOTES, 'UTF-8'); ?></strong></p>
                <p>La grande carte reprend les mêmes coordonnées de cases que la carte du jeu.</p>
            </section>

            <section class="carte-parametres-jeu">
                <h3>Légende</h3>
                <div class="liste-legende-carte">
                    <?php foreach ($legende as $entreeLegende) : ?>
                        <div class="ligne-legende-carte">
                            <span class="pastille-legende-carte" style="background: <?= htmlspecialchars((string) ($entreeLegende['couleur'] ?? '#ffffff'), ENT_QUOTES, 'UTF-8'); ?>;"></span>
                            <div><strong><?= htmlspecialchars((string) ($entreeLegende['libelle'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></strong></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <?php if (!empty($regions)) : ?>
                <section class="carte-parametres-jeu">
                    <h3>Régions</h3>
                    <div class="liste-regions-carte">
                        <?php foreach ($regions as $region) : ?>
                            <div class="ligne-region-carte">
                                <strong><?= htmlspecialchars((string) ($region['nom'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></strong>
                                <p><?= htmlspecialchars((string) ($region['resume'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </div>
</div>
