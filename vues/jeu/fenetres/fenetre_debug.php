<div id="fenetre-debug" class="fenetre-jeu-modele fenetre-debug fenetre-jeu-cachee" data-cle-fenetre="debug" role="dialog" aria-modal="true" aria-labelledby="titre-fenetre-debug">
    <div class="entete-fenetre-jeu">
        <div>
            <h2 id="titre-fenetre-debug">Debug</h2>
            <p>Suivi technique du déplacement, de la navigation et des jets de rencontre.</p>
        </div>

        <button type="button" class="bouton-fermer-fenetre" data-fermer-fenetre="oui" aria-label="Fermer la fenêtre">×</button>
    </div>

    <div class="contenu-fenetre-jeu grille-debug-jeu">
        <div class="carte-parametres-jeu">
            <h3>État actuel</h3>

            <div class="ligne-valeur-parametre">
                <span>Position</span>
                <strong id="debug-etat-position">18 x 12</strong>
            </div>

            <div class="ligne-valeur-parametre">
                <span>Mode</span>
                <strong id="debug-etat-mode">À pied</strong>
            </div>

            <div class="ligne-valeur-parametre">
                <span>Bateau</span>
                <strong id="debug-etat-bateau">Non</strong>
            </div>

            <div class="ligne-valeur-parametre">
                <span>Sécurité</span>
                <strong id="debug-etat-securite">Normale</strong>
            </div>

            <div class="ligne-valeur-parametre">
                <span>Jet de rencontre</span>
                <strong id="debug-etat-rencontre">En attente</strong>
            </div>
        </div>

        <div class="carte-parametres-jeu">
            <h3>Actions debug</h3>

            <div class="colonne-boutons-debug">
                <button type="button" id="bouton-debug-monture" class="bouton-parametre-principal">Activer monture</button>
                <button type="button" id="bouton-debug-afficher-cases" class="bouton-secondaire bouton-parametre-secondaire">Afficher les cases atteignables</button>
                <button type="button" id="bouton-debug-reinitialiser-logs" class="bouton-secondaire bouton-parametre-secondaire">Réinitialiser logs</button>
            </div>
        </div>

        <div class="carte-parametres-jeu carte-debug-logs">
            <h3>Journal de déplacement</h3>
            <div id="debug-journal-deplacement" class="debug-journal-deplacement"></div>
        </div>
    </div>
</div>
