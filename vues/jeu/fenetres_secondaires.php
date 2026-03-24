<div id="fond-fenetres-jeu" class="fond-fenetres-jeu" aria-hidden="true">
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

    <div id="fenetre-aide" class="fenetre-jeu-modele fenetre-aide fenetre-jeu-cachee" data-cle-fenetre="aide" role="dialog" aria-modal="true" aria-labelledby="titre-fenetre-aide">
        <div class="entete-fenetre-jeu">
            <div>
                <h2 id="titre-fenetre-aide">Aide</h2>
                <p>Repères rapides pour lire la carte et comprendre l’interface.</p>
            </div>

            <button type="button" class="bouton-fermer-fenetre" data-fermer-fenetre="oui" aria-label="Fermer la fenêtre">×</button>
        </div>

        <div class="contenu-fenetre-jeu">
            <div class="grille-aide-jeu">
                <div class="carte-parametres-jeu">
                    <h3>Carte du monde</h3>
                    <p>La carte représente l’ensemble du monde d’Elementia.</p>
                    <p>La grille visible permet de savoir précisément sur quelle case vous vous trouvez.</p>
                </div>

                <div class="carte-parametres-jeu">
                    <h3>Position</h3>
                    <p>Votre position actuelle apparaît dans le bloc d’informations du joueur.</p>
                    <p>Ce bloc peut être réduit pour libérer la vue quand vous en avez besoin.</p>
                </div>

                <div class="carte-parametres-jeu">
                    <h3>Déplacements</h3>
                    <p>Le déplacement sur la grille sera utilisé pour l’exploration du monde et l’entrée dans les zones importantes.</p>
                    <p>Les villes et points d’intérêt serviront ensuite de transitions vers leurs cartes locales.</p>
                </div>

                <div class="carte-parametres-jeu">
                    <h3>Interface</h3>
                    <p>La barre du bas ouvre les différents panneaux du joueur : personnage, inventaire, compétences, quêtes, journal et paramètres.</p>
                </div>
            </div>
        </div>
    </div>

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
</div>
