<div id="fenetre-parametres" class="fenetre-jeu-modele fenetre-parametres fenetre-jeu-cachee" data-cle-fenetre="parametres" role="dialog" aria-modal="true" aria-labelledby="titre-fenetre-parametres">
    <div class="entete-fenetre-jeu">
        <div>
            <h2 id="titre-fenetre-parametres">Paramètres</h2>
            <p>Réglages rapides du joueur et accès aux actions principales.</p>
        </div>

        <button type="button" class="bouton-fermer-fenetre" data-fermer-fenetre="oui" aria-label="Fermer la fenêtre">×</button>
    </div>

    <div class="contenu-fenetre-jeu grille-parametres-jeu">
        <div class="carte-parametres-jeu">
            <h3>Navigation</h3>

            <form method="post" action="index.php" class="formulaire-parametre-jeu">
                <input type="hidden" name="action" value="quitter_jeu_vers_selection_personnage">
                <button type="submit" class="bouton-parametre-principal">Retour à la sélection des personnages</button>
            </form>

            <form method="post" action="index.php" class="formulaire-parametre-jeu">
                <input type="hidden" name="action" value="deconnexion">
                <button type="submit" class="bouton-secondaire bouton-parametre-secondaire">Déconnexion</button>
            </form>
        </div>

        <div class="carte-parametres-jeu">
            <h3>Affichage</h3>

            <label for="qualite-graphique">Qualité graphique</label>
            <select id="qualite-graphique" name="qualite_graphique">
                <option value="faible">Faible</option>
                <option value="moyenne">Moyenne</option>
                <option value="elevee">Élevée</option>
            </select>

            <label class="ligne-option-parametre">
                <span>Plein écran</span>
                <button type="button" id="bouton-plein-ecran" class="bouton-parametre-principal bouton-petit-parametre">Activer / désactiver</button>
            </label>
        </div>

        <div class="carte-parametres-jeu">
            <h3>Son</h3>

            <label for="volume-general">Volume général</label>
            <input type="range" id="volume-general" name="volume_general" min="0" max="100" value="70">

            <div class="ligne-valeur-parametre">
                <span>Niveau actuel</span>
                <strong id="texte-volume-general">70%</strong>
            </div>
        </div>
    </div>
</div>
