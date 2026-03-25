<?php
/* ========================================================= */
/* FENÊTRE INVENTAIRE SIMPLE                                 */
/* ========================================================= */
?>
<div id="fenetre-inventaire"
     class="fenetre-jeu-modele fenetre-jeu-cachee fenetre-jeu-inventaire"
     data-cle-fenetre="inventaire"
     role="dialog"
     aria-modal="false"
     aria-labelledby="titre-fenetre-inventaire">

    <div class="contenu-fenetre-inventaire-modele">
        <div class="titre-visuel-inventaire">
            <h2 id="titre-fenetre-inventaire">Inventaire</h2>
        </div>

        <button type="button"
                class="bouton-fermer-fenetre bouton-fermer-fenetre-inventaire"
                data-fermer-fenetre="oui"
                aria-label="Fermer l'inventaire">×</button>

        <div class="modele-inventaire-complet">
            <section class="modele-zone-grille-inventaire" aria-label="Grille de l'inventaire">
                <div class="grille-slots-modele">
<?php for ($indexSlot = 1; $indexSlot <= 48; $indexSlot++): ?>
                    <div class="slot-inventaire-modele"
                         data-slot-index="<?= $indexSlot ?>"
                         aria-hidden="true"></div>
<?php endfor; ?>
                </div>
            </section>

            <footer class="modele-panneaux-bas-inventaire">
                <section class="panneau-bas-inventaire panneau-bas-gauche" aria-live="polite">
                    <div class="contenu-panneau-bas-inventaire">
                        <span class="libelle-panneau-bas">Monnaie</span>
                        <strong id="inventaire-monnaie-sac">0 or</strong>
                    </div>
                </section>

                <section class="panneau-bas-inventaire panneau-bas-droite" aria-live="polite">
                    <div class="contenu-panneau-bas-inventaire">
                        <span class="libelle-panneau-bas">Poids</span>
                        <strong id="inventaire-poids-sac">0 / 100</strong>
                    </div>
                </section>
            </footer>
        </div>
    </div>
</div>
