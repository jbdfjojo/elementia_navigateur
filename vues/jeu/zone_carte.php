<div class="zone-monde">
    <div
        id="zone-carte-monde"
        class="zone-carte-monde"
        data-taille-case="64"
        data-colonnes="40"
        data-lignes="27"
        data-colonne-depart="18"
        data-ligne-depart="12"
        data-largeur-monde="2534"
        data-hauteur-monde="1690"
    >
        <div class="carte-monde-viewport" id="carte-monde-viewport">
            <div class="carte-monde-camera" id="carte-monde-camera">
                <div class="carte-monde-contenu" id="carte-monde-contenu">
                    <img
                        id="image-carte-monde"
                        class="image-carte-monde"
                        src="ressources/images/carte/carte_du_monde.png"
                        alt="Carte du monde d’Elementia"
                        draggable="false"
                    >

                    <div class="grille-carte-monde" id="grille-carte-monde" aria-hidden="true"></div>
                    <div class="surbrillance-deplacement-monde" id="surbrillance-deplacement-monde" aria-hidden="true"></div>

                    <div
                        class="repere-joueur-monde"
                        id="repere-joueur-monde"
                        aria-label="Position du joueur"
                        role="button"
                        tabindex="0"
                        title="Cliquer pour afficher les déplacements possibles"
                    >
                        <span class="repere-joueur-noyau"></span>
                    </div>
                </div>
            </div>

            <?php include __DIR__ . '/bloc_evenements.php'; ?>
        </div>
    </div>
</div>
