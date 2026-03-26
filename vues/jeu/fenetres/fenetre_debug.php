<?php
require_once __DIR__ . '/../../../modeles/Objet.php';
$catalogue_debug = Objet::listerCataloguePourDebug();
?>
<div id="fenetre-debug" class="fenetre-jeu-modele fenetre-debug fenetre-jeu-cachee" data-cle-fenetre="debug" role="dialog" aria-modal="true" aria-labelledby="titre-fenetre-debug">
    <div class="entete-fenetre-jeu">
        <div>
            <h2 id="titre-fenetre-debug">Debug</h2>
            <p>Suivi technique du déplacement, de la navigation et outils de test d’inventaire.</p>
        </div>

        <button type="button" class="bouton-fermer-fenetre" data-fermer-fenetre="oui" aria-label="Fermer la fenêtre">×</button>
    </div>

    <div class="contenu-fenetre-jeu grille-debug-jeu">
        <div class="carte-parametres-jeu">
            <h3>État actuel</h3>
            <div class="ligne-valeur-parametre"><span>Position</span><strong id="debug-etat-position">18 x 12</strong></div>
            <div class="ligne-valeur-parametre"><span>Mode</span><strong id="debug-etat-mode">À pied</strong></div>
            <div class="ligne-valeur-parametre"><span>Bateau</span><strong id="debug-etat-bateau">Non</strong></div>
            <div class="ligne-valeur-parametre"><span>Sécurité</span><strong id="debug-etat-securite">Normale</strong></div>
            <div class="ligne-valeur-parametre"><span>Jet de rencontre</span><strong id="debug-etat-rencontre">En attente</strong></div>
        </div>

        <div class="carte-parametres-jeu">
            <h3>Actions debug</h3>
            <div class="colonne-boutons-debug">
                <button type="button" id="bouton-debug-monture" class="bouton-parametre-principal">Activer monture</button>
                <button type="button" id="bouton-debug-afficher-cases" class="bouton-secondaire bouton-parametre-secondaire">Afficher les cases atteignables</button>
                <button type="button" id="bouton-debug-reinitialiser-logs" class="bouton-secondaire bouton-parametre-secondaire">Réinitialiser logs</button>
            </div>
        </div>

        <div class="carte-parametres-jeu">
            <h3>Tests PV / PM</h3>
            <div class="colonne-boutons-debug">
                <form method="post" class="formulaire-debug-ressource"><input type="hidden" name="action" value="debug_retirer_vie_fixe"><button type="submit" class="bouton-parametre-principal">Retirer 50 PV</button></form>
                <form method="post" class="formulaire-debug-ressource"><input type="hidden" name="action" value="debug_retirer_vie_pourcentage"><button type="submit" class="bouton-secondaire bouton-parametre-secondaire">Retirer 10% PV</button></form>
                <form method="post" class="formulaire-debug-ressource"><input type="hidden" name="action" value="debug_retirer_mana_fixe"><button type="submit" class="bouton-parametre-principal">Retirer 50 PM</button></form>
                <form method="post" class="formulaire-debug-ressource"><input type="hidden" name="action" value="debug_retirer_mana_pourcentage"><button type="submit" class="bouton-secondaire bouton-parametre-secondaire">Retirer 10% PM</button></form>
            </div>
        </div>

        <div class="carte-parametres-jeu">
            <h3>Ajouter un objet de test</h3>
            <form method="post" class="ligne-option-parametre">
                <input type="hidden" name="action" value="debug_ajouter_objet_inventaire">

                <label for="debug-catalogue-objet">Objet</label>
                <select id="debug-catalogue-objet" name="catalogue_objet_id" required>
                    <option value="">Choisir un objet</option>
                    <?php foreach ($catalogue_debug as $objet_debug) : ?>
                        <option value="<?= (int) $objet_debug['id'] ?>">
                            <?= htmlspecialchars((string) $objet_debug['nom_objet'], ENT_QUOTES, 'UTF-8') ?>
                            — <?= htmlspecialchars((string) $objet_debug['type_objet'], ENT_QUOTES, 'UTF-8') ?>
                            / <?= htmlspecialchars((string) $objet_debug['categorie_objet'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="debug-quantite-objet">Quantité</label>
                <input type="number" id="debug-quantite-objet" name="quantite" min="1" max="99" value="1" required>

                <button type="submit" class="bouton-parametre-principal">Ajouter dans l’inventaire</button>
            </form>
        </div>

        <div class="carte-parametres-jeu carte-debug-logs">
            <h3>Journal de déplacement</h3>
            <div id="debug-journal-deplacement" class="debug-journal-deplacement"></div>
        </div>
    </div>
</div>
