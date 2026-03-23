<article class="bloc-formulaire">
    <h2>Inscription</h2>

    <form method="post" action="index.php" class="formulaire-avec-chargement">
        <label for="pseudo_inscription">Pseudo</label>
        <input
            type="text"
            id="pseudo_inscription"
            name="pseudo"
            maxlength="50"
            value="<?= htmlspecialchars($ancien_pseudo, ENT_QUOTES, 'UTF-8'); ?>"
            required
        >

        <label for="mot_de_passe_inscription">Mot de passe</label>
        <input
            type="password"
            id="mot_de_passe_inscription"
            name="mot_de_passe"
            required
        >

        <input type="hidden" name="action" value="inscription">

        <button type="submit">Créer mon compte</button>
    </form>

    <form method="post" action="index.php" class="formulaire-secondaire formulaire-avec-chargement">
        <input type="hidden" name="action" value="afficher_connexion">
        <p class="lien-secondaire">
            Vous avez déjà un compte ?
            <button type="submit" class="bouton-lien">Retour à la connexion</button>
        </p>
    </form>
</article>
