<?php
// ---------------------------------------------------------
// ROUTEUR CENTRAL D'ELEMENTIA
// ---------------------------------------------------------
declare(strict_types=1);

class Routeur
{
    // -----------------------------------------------------
    // Méthode principale de gestion
    // -----------------------------------------------------
    public static function gerer(PDO $connexion_base): void
    {
        // -------------------------------------------------
        // Initialisation de l'état d'authentification
        // -------------------------------------------------
        if (!isset($_SESSION['vue_auth'])) {
            $_SESSION['vue_auth'] = 'connexion';
        }

        // -------------------------------------------------
        // Initialisation des tableaux de messages
        // -------------------------------------------------
        $messages_erreur = [];
        $messages_succes = [];

        // -------------------------------------------------
        // Traitement des actions envoyées en POST
        // -------------------------------------------------
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            self::traiterActions($connexion_base, $messages_erreur, $messages_succes);
        }

        // -------------------------------------------------
        // Détermination de la vue à afficher
        // -------------------------------------------------
        $vue = self::determinerVue();

        // -------------------------------------------------
        // Chargement du gabarit principal
        // -------------------------------------------------
        include __DIR__ . '/../vues/commun/gabarit_principal.php';
    }

    // -----------------------------------------------------
    // Détermine la vue à afficher selon la session
    // -----------------------------------------------------
    private static function determinerVue(): string
    {
        // -------------------------------------------------
        // Si aucun compte n'est connecté
        // -------------------------------------------------
        if (!isset($_SESSION['compte_id'])) {
            // ---------------------------------------------
            // Retourne la vue d'authentification demandée
            // ---------------------------------------------
            if ($_SESSION['vue_auth'] === 'inscription') {
                return 'inscription';
            }

            return 'connexion';
        }

        // -------------------------------------------------
        // Si le compte est connecté mais aucun personnage
        // n'est encore actif
        // -------------------------------------------------
        if (!isset($_SESSION['personnage_id'])) {
            // ---------------------------------------------
            // Si l'utilisateur veut voir la création
            // ---------------------------------------------
            if (isset($_SESSION['vue_personnage']) && $_SESSION['vue_personnage'] === 'creation_personnage') {
                return 'creation_personnage';
            }

            return 'selection_personnage';
        }

        // -------------------------------------------------
        // Sinon le joueur entre dans le jeu
        // -------------------------------------------------
        return 'jeu';
    }

    // -----------------------------------------------------
    // Traite toutes les actions envoyées par formulaire
    // -----------------------------------------------------
    private static function traiterActions(PDO $connexion_base, array &$messages_erreur, array &$messages_succes): void
    {
        // -------------------------------------------------
        // Récupération de l'action demandée
        // -------------------------------------------------
        $action = $_POST['action'] ?? '';

        // -------------------------------------------------
        // Demande d'affichage de l'inscription
        // -------------------------------------------------
        if ($action === 'afficher_inscription') {
            $_SESSION['vue_auth'] = 'inscription';
            self::redirigerIndex();
        }

        // -------------------------------------------------
        // Demande d'affichage de la connexion
        // -------------------------------------------------
        if ($action === 'afficher_connexion') {
            $_SESSION['vue_auth'] = 'connexion';
            self::redirigerIndex();
        }

        // -------------------------------------------------
        // Demande de déconnexion
        // -------------------------------------------------
        if ($action === 'deconnexion') {
            $_SESSION = [];
            session_destroy();
            session_start();
            $_SESSION['vue_auth'] = 'connexion';
            self::redirigerIndex();
        }

        // -------------------------------------------------
        // Traitement de la connexion
        // -------------------------------------------------
        if ($action === 'connexion') {
            self::traiterConnexion($connexion_base, $messages_erreur);
        }

        // -------------------------------------------------
        // Traitement de l'inscription
        // -------------------------------------------------
        if ($action === 'inscription') {
            self::traiterInscription($connexion_base, $messages_erreur);
        }

        // -------------------------------------------------
        // Passage à la vue de création personnage
        // -------------------------------------------------
        if ($action === 'afficher_creation_personnage') {
            self::verifierCompteConnecte();
            $_SESSION['vue_personnage'] = 'creation_personnage';
            self::redirigerIndex();
        }

        // -------------------------------------------------
        // Retour à la sélection personnage
        // -------------------------------------------------
        if ($action === 'retour_selection_personnage') {
            self::verifierCompteConnecte();
            $_SESSION['vue_personnage'] = 'selection_personnage';
            self::redirigerIndex();
        }

        // -------------------------------------------------
        // Création d'un personnage
        // -------------------------------------------------
        if ($action === 'creer_personnage') {
            self::traiterCreationPersonnage($connexion_base, $messages_erreur);
        }

        // -------------------------------------------------
        // Sélection d'un personnage existant
        // -------------------------------------------------
        if ($action === 'selectionner_personnage') {
            self::traiterSelectionPersonnage($connexion_base, $messages_erreur);
        }
    }

    // -----------------------------------------------------
    // Gestion de la connexion
    // -----------------------------------------------------
    private static function traiterConnexion(PDO $connexion_base, array &$messages_erreur): void
    {
        $pseudo = trim($_POST['pseudo'] ?? '');
        $mot_de_passe = $_POST['mot_de_passe'] ?? '';

        if ($pseudo === '') {
            $messages_erreur[] = 'Le pseudo est obligatoire.';
        }

        if ($mot_de_passe === '') {
            $messages_erreur[] = 'Le mot de passe est obligatoire.';
        }

        if (!empty($messages_erreur)) {
            $_SESSION['messages_erreur'] = $messages_erreur;
            $_SESSION['ancien_pseudo'] = $pseudo;
            $_SESSION['vue_auth'] = 'connexion';
            self::redirigerIndex();
        }

        $requete = $connexion_base->prepare('SELECT id, pseudo, mot_de_passe FROM comptes WHERE pseudo = :pseudo LIMIT 1');
        $requete->execute([
            'pseudo' => $pseudo
        ]);
        $compte = $requete->fetch();

        if (!$compte || !password_verify($mot_de_passe, $compte['mot_de_passe'])) {
            $_SESSION['messages_erreur'] = ['Pseudo ou mot de passe incorrect.'];
            $_SESSION['ancien_pseudo'] = $pseudo;
            $_SESSION['vue_auth'] = 'connexion';
            self::redirigerIndex();
        }

        session_regenerate_id(true);

        $_SESSION['compte_id'] = (int) $compte['id'];
        $_SESSION['pseudo'] = $compte['pseudo'];
        $_SESSION['vue_personnage'] = 'selection_personnage';

        $mise_a_jour = $connexion_base->prepare('UPDATE comptes SET derniere_connexion = NOW() WHERE id = :id');
        $mise_a_jour->execute([
            'id' => $compte['id']
        ]);

        self::redirigerIndex();
    }

    // -----------------------------------------------------
    // Gestion de l'inscription
    // -----------------------------------------------------
    private static function traiterInscription(PDO $connexion_base, array &$messages_erreur): void
    {
        $pseudo = trim($_POST['pseudo'] ?? '');
        $mot_de_passe = $_POST['mot_de_passe'] ?? '';

        if ($pseudo === '') {
            $messages_erreur[] = 'Le pseudo est obligatoire.';
        }

        if ($mot_de_passe === '') {
            $messages_erreur[] = 'Le mot de passe est obligatoire.';
        }

        if ($pseudo !== '' && mb_strlen($pseudo) < 3) {
            $messages_erreur[] = 'Le pseudo doit contenir au moins 3 caractères.';
        }

        if ($pseudo !== '' && mb_strlen($pseudo) > 50) {
            $messages_erreur[] = 'Le pseudo ne peut pas dépasser 50 caractères.';
        }

        if ($mot_de_passe !== '' && mb_strlen($mot_de_passe) < 6) {
            $messages_erreur[] = 'Le mot de passe doit contenir au moins 6 caractères.';
        }

        if (empty($messages_erreur)) {
            $requete = $connexion_base->prepare('SELECT id FROM comptes WHERE pseudo = :pseudo LIMIT 1');
            $requete->execute([
                'pseudo' => $pseudo
            ]);
            $compte_existant = $requete->fetch();

            if ($compte_existant) {
                $messages_erreur[] = 'Ce pseudo est déjà utilisé.';
            }
        }

        if (!empty($messages_erreur)) {
            $_SESSION['messages_erreur'] = $messages_erreur;
            $_SESSION['ancien_pseudo'] = $pseudo;
            $_SESSION['vue_auth'] = 'inscription';
            self::redirigerIndex();
        }

        $mot_de_passe_hashe = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        $requete_insertion = $connexion_base->prepare(
            'INSERT INTO comptes (pseudo, mot_de_passe, derniere_connexion) VALUES (:pseudo, :mot_de_passe, NOW())'
        );

        $requete_insertion->execute([
            'pseudo' => $pseudo,
            'mot_de_passe' => $mot_de_passe_hashe
        ]);

        $nouvel_identifiant_compte = (int) $connexion_base->lastInsertId();

        session_regenerate_id(true);

        $_SESSION['compte_id'] = $nouvel_identifiant_compte;
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['vue_personnage'] = 'selection_personnage';

        self::redirigerIndex();
    }

    // -----------------------------------------------------
    // Gestion de la création d'un personnage
    // -----------------------------------------------------
    private static function traiterCreationPersonnage(PDO $connexion_base, array &$messages_erreur): void
    {
        self::verifierCompteConnecte();

        $nom = trim($_POST['nom_personnage'] ?? '');
        $element = trim($_POST['element'] ?? '');
        $portrait = trim($_POST['portrait'] ?? '');
        $region_depart = trim($_POST['region_depart'] ?? '');

        if ($nom === '') {
            $messages_erreur[] = 'Le nom du personnage est obligatoire.';
        }

        if ($nom !== '' && mb_strlen($nom) < 3) {
            $messages_erreur[] = 'Le nom du personnage doit contenir au moins 3 caractères.';
        }

        if ($nom !== '' && mb_strlen($nom) > 50) {
            $messages_erreur[] = 'Le nom du personnage ne peut pas dépasser 50 caractères.';
        }

        $elements_valides = ['Feu', 'Eau', 'Air', 'Terre'];

        if (!in_array($element, $elements_valides, true)) {
            $messages_erreur[] = 'L’élément sélectionné est invalide.';
        }

        $requete_nombre = $connexion_base->prepare('SELECT COUNT(*) AS total FROM personnages WHERE compte_id = :compte_id');
        $requete_nombre->execute([
            'compte_id' => $_SESSION['compte_id']
        ]);
        $resultat_nombre = $requete_nombre->fetch();
        $nombre_personnages = (int) ($resultat_nombre['total'] ?? 0);

        if ($nombre_personnages >= 3) {
            $messages_erreur[] = 'Vous avez déjà atteint la limite de 3 personnages.';
        }

        if (!empty($messages_erreur)) {
            $_SESSION['messages_erreur'] = $messages_erreur;
            $_SESSION['vue_personnage'] = 'creation_personnage';
            self::redirigerIndex();
        }

        $requete_insertion = $connexion_base->prepare(
            'INSERT INTO personnages (compte_id, nom, element, portrait, region_depart, position_x, position_y, niveau)
             VALUES (:compte_id, :nom, :element, :portrait, :region_depart, 0, 0, 1)'
        );

        $requete_insertion->execute([
            'compte_id' => $_SESSION['compte_id'],
            'nom' => $nom,
            'element' => $element,
            'portrait' => $portrait !== '' ? $portrait : null,
            'region_depart' => $region_depart !== '' ? $region_depart : null
        ]);

        $_SESSION['messages_succes'] = ['Personnage créé avec succès.'];
        $_SESSION['vue_personnage'] = 'selection_personnage';

        self::redirigerIndex();
    }

    // -----------------------------------------------------
    // Gestion de la sélection d'un personnage
    // -----------------------------------------------------
    private static function traiterSelectionPersonnage(PDO $connexion_base, array &$messages_erreur): void
    {
        self::verifierCompteConnecte();

        $personnage_id = (int) ($_POST['personnage_id'] ?? 0);

        if ($personnage_id <= 0) {
            $_SESSION['messages_erreur'] = ['Le personnage demandé est invalide.'];
            $_SESSION['vue_personnage'] = 'selection_personnage';
            self::redirigerIndex();
        }

        $requete = $connexion_base->prepare(
            'SELECT id, nom, compte_id FROM personnages WHERE id = :id AND compte_id = :compte_id LIMIT 1'
        );

        $requete->execute([
            'id' => $personnage_id,
            'compte_id' => $_SESSION['compte_id']
        ]);

        $personnage = $requete->fetch();

        if (!$personnage) {
            $_SESSION['messages_erreur'] = ['Accès refusé à ce personnage.'];
            $_SESSION['vue_personnage'] = 'selection_personnage';
            self::redirigerIndex();
        }

        $_SESSION['personnage_id'] = (int) $personnage['id'];
        $_SESSION['personnage_nom'] = $personnage['nom'];

        self::redirigerIndex();
    }

    // -----------------------------------------------------
    // Vérifie qu'un compte est connecté
    // -----------------------------------------------------
    private static function verifierCompteConnecte(): void
    {
        if (!isset($_SESSION['compte_id'])) {
            $_SESSION['vue_auth'] = 'connexion';
            self::redirigerIndex();
        }
    }

    // -----------------------------------------------------
    // Redirection interne vers index.php
    // -----------------------------------------------------
    private static function redirigerIndex(): void
    {
        header('Location: index.php');
        exit;
    }
}
