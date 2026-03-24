<div class="zone-monde">
    <div
        id="zone-carte-monde"
        class="zone-carte-monde"
        data-taille-case="64"
        data-colonnes="40"
        data-lignes="27"
        data-zoom="1.65"
        data-colonne-depart="18"
        data-ligne-depart="12"
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

                    <div class="repere-joueur-monde" id="repere-joueur-monde" aria-label="Position du joueur">
                        <span class="repere-joueur-noyau"></span>
                    </div>
                </div>
            </div>

            <?php include __DIR__ . '/bloc_evenements.php'; ?>

            <div class="bloc-position-joueur">
                <strong>Position</strong>
                <span id="valeur-position-joueur">Case 18 x 12</span>
            </div>

            <div class="bloc-aide-carte">
                <strong>Déplacement</strong>
                <span>Clique une case ou utilise ZQSD / flèches.</span>
            </div>
        </div>
    </div>
</div>
