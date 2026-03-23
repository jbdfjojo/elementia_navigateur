<article class="bloc-formulaire">
    <h2>Créer un personnage</h2>

    <form method="post" action="index.php" class="formulaire-avec-chargement">
        <label for="nom_personnage">Nom du personnage</label>
        <input type="text" id="nom_personnage" name="nom_personnage" maxlength="50" required>

        <label for="element">Élément</label>
        <select id="element" name="element" required>
            <option value="Feu">Feu</option>
            <option value="Eau">Eau</option>
            <option value="Air">Air</option>
            <option value="Terre">Terre</option>
        </select>

        <label for="portrait">Portrait (chemin image ou vide)</label>
        <input type="text" id="portrait" name="portrait" placeholder="ressources/images/portraits/...">

        <label for="region_depart">Région de départ</label>
        <input type="text" id="region_depart" name="region_depart" placeholder="Exemple : Verdalis">

        <input type="hidden" name="action" value="creer_personnage">

        <button type="submit">Créer ce personnage</button>
    </form>

    <form method="post" action="index.php" class="formulaire-secondaire formulaire-avec-chargement">
        <input type="hidden" name="action" value="retour_selection_personnage">
        <p class="lien-secondaire">
            Retour :
            <button type="submit" class="bouton-lien">liste des personnages</button>
        </p>
    </form>
</article>
