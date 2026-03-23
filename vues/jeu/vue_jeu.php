<section class="page-jeu">
    <div class="zone-monde">
        <div class="zone-carte-simulee">
            <div class="mini-bloc-evenements">
                <h3>Événements</h3>
                <p>Aucune quête active pour le moment.</p>
            </div>

            <div class="texte-centre-monde">
                <h2>Bienvenue, <?= htmlspecialchars($_SESSION['personnage_nom'] ?? 'Aventurier', ENT_QUOTES, 'UTF-8'); ?></h2>
                <p>Le monde d’Elementia vous attend.</p>
            </div>
        </div>

        <div class="barre-actions-jeu">
            <button type="button">Personnage</button>
            <button type="button">Inventaire</button>
            <button type="button">Compétences</button>
            <button type="button">Quêtes</button>
            <button type="button">Journal</button>
            <button type="button">Paramètres</button>

            <form method="post" action="index.php" class="formulaire-avec-chargement">
                <input type="hidden" name="action" value="deconnexion">
                <button type="submit" class="bouton-secondaire">Déconnexion</button>
            </form>
        </div>
    </div>
</section>
