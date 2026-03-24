<div id="bloc-informations-joueur" class="mini-bloc-evenements bloc-informations-joueur">
    <div class="entete-bloc-informations-joueur">
        <div class="titres-bloc-informations-joueur">
            <h3>Informations du joueur</h3>
            <p>Suivi rapide de votre position, de votre portée et de l’exploration.</p>
        </div>

        <button
            type="button"
            id="bouton-reduire-bloc-informations"
            class="bouton-reduire-bloc-informations"
            aria-expanded="true"
            aria-controls="contenu-bloc-informations-joueur"
            title="Réduire ou afficher le bloc"
        >
            −
        </button>
    </div>

    <div id="contenu-bloc-informations-joueur" class="contenu-bloc-informations-joueur">
        <div class="ligne-information-joueur">
            <strong>Position</strong>
            <span id="valeur-position-joueur">Case 18 x 12</span>
        </div>

        <div class="ligne-information-joueur">
            <strong>Déplacement</strong>
            <span id="valeur-portee-joueur">À pied · portée 4</span>
        </div>

        <div class="ligne-information-joueur">
            <strong>Navigation</strong>
            <span id="valeur-navigation-joueur">À terre · sans bateau</span>
        </div>

        <div class="separateur-information-joueur"></div>

        <div class="zone-evenements-joueur">
            <strong>Événements</strong>
            <p id="ligne-evenement-principale">Cliquez sur votre pion pour afficher les cases atteignables.</p>
            <p id="ligne-evenement-secondaire">Aucune rencontre résolue pour le moment.</p>
        </div>
    </div>
</div>
