<article class="bloc-formulaire">
    <h2>Connexion</h2>

    <form method="post" action="index.php" class="formulaire-avec-chargement">
        <label for="pseudo_connexion">Pseudo</label>
        <input
            type="text"
            id="pseudo_connexion"
            name="pseudo"
            maxlength="50"
            value="<?= htmlspecialchars($ancien_pseudo, ENT_QUOTES, 'UTF-8'); ?>"
            required
        >

        <label for="mot_de_passe_connexion">Mot de passe</label>
        <input
            type="password"
            id="mot_de_passe_connexion"
            name="mot_de_passe"
            required
        >

        <input type="hidden" name="action" value="connexion">

        <button type="submit">Se connecter</button>
    </form>

    <form method="post" action="index.php" class="formulaire-secondaire formulaire-avec-chargement">
        <input type="hidden" name="action" value="afficher_inscription">
        <p class="lien-secondaire">
            Pas encore de compte ?
            <button type="submit" class="bouton-lien">Créer un compte</button>
        </p>
    </form>
</article>
