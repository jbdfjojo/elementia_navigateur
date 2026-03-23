<?php
// ---------------------------------------------------------
// ROUTEUR CENTRAL D'ELEMENTIA
// ---------------------------------------------------------
declare(strict_types=1);

class Routeur
{
    // -----------------------------------------------------
    // Point d’entrée principal
    // -----------------------------------------------------
    public static function gerer(PDO $connexion_base): void
    {
        if (!isset($_SESSION['vue_auth'])) {
            $_SESSION['vue_auth'] = 'connexion';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            self::traiterActions($connexion_base);
        }

        $vue = self::determinerVue();
        include __DIR__ . '/../vues/commun/gabarit_principal.php';
    }

    // -----------------------------------------------------
    // Détermine la vue à afficher
    // -----------------------------------------------------
    private static function determinerVue(): string
    {
        if (!isset($_SESSION['compte_id'])) {
            return $_SESSION['vue_auth'] === 'inscription' ? 'inscription' : 'connexion';
        }

        if (!isset($_SESSION['personnage_id'])) {
            if (isset($_SESSION['vue_personnage']) && $_SESSION['vue_personnage'] === 'creation_personnage') {
                return 'creation_personnage';
            }

            return 'selection_personnage';
        }

        return 'jeu';
    }

    // -----------------------------------------------------
    // Traite toutes les actions des formulaires
    // -----------------------------------------------------
    private static function traiterActions(PDO $connexion_base): void
    {
        $action = $_POST['action'] ?? '';

        if ($action === 'afficher_inscription') {
            $_SESSION['vue_auth'] = 'inscription';
            self::redirigerIndex();
        }

        if ($action === 'afficher_connexion') {
            $_SESSION['vue_auth'] = 'connexion';
            self::redirigerIndex();
        }

        if ($action === 'deconnexion') {
            $_SESSION = [];
            session_destroy();
            session_start();
            $_SESSION['vue_auth'] = 'connexion';
            self::redirigerIndex();
        }

        if ($action === 'connexion') {
            self::traiterConnexion($connexion_base);
        }

        if ($action === 'inscription') {
            self::traiterInscription($connexion_base);
        }

        if ($action === 'afficher_creation_personnage') {
            self::verifierCompteConnecte();
            self::initialiserCreationPersonnage();
            $_SESSION['vue_personnage'] = 'creation_personnage';
            self::redirigerIndex();
        }

        if ($action === 'retour_selection_personnage') {
            self::verifierCompteConnecte();
            unset($_SESSION['creation_personnage']);
            $_SESSION['vue_personnage'] = 'selection_personnage';
            self::redirigerIndex();
        }

        if ($action === 'creation_personnage_etape_1') {
            self::traiterCreationPersonnageEtape1();
        }

        if ($action === 'creation_personnage_etape_2') {
            self::traiterCreationPersonnageEtape2();
        }

        if ($action === 'creation_personnage_etape_3') {
            self::traiterCreationPersonnageEtape3();
        }

        if ($action === 'creation_personnage_etape_4') {
            self::traiterCreationPersonnageEtape4();
        }

        if ($action === 'creation_personnage_etape_5') {
            self::traiterCreationPersonnageEtape5($connexion_base);
        }

        if ($action === 'creation_personnage_retour_etape_1') {
            self::verifierCompteConnecte();
            self::verifierCreationPersonnageActive();
            $_SESSION['creation_personnage']['etape'] = 1;
            self::redirigerIndex();
        }

        if ($action === 'creation_personnage_retour_etape_2') {
            self::verifierCompteConnecte();
            self::verifierCreationPersonnageActive();
            $_SESSION['creation_personnage']['etape'] = 2;
            self::redirigerIndex();
        }

        if ($action === 'creation_personnage_retour_etape_3') {
            self::verifierCompteConnecte();
            self::verifierCreationPersonnageActive();
            $_SESSION['creation_personnage']['etape'] = 3;
            self::redirigerIndex();
        }

        if ($action === 'creation_personnage_retour_etape_4') {
            self::verifierCompteConnecte();
            self::verifierCreationPersonnageActive();
            $_SESSION['creation_personnage']['etape'] = 4;
            self::redirigerIndex();
        }

        if ($action === 'selectionner_personnage') {
            self::traiterSelectionPersonnage($connexion_base);
        }

        if ($action === 'supprimer_personnage') {
            self::traiterSuppressionPersonnage($connexion_base);
        }
    }

    // -----------------------------------------------------
    // Initialise la structure de création personnage
    // -----------------------------------------------------
    private static function initialiserCreationPersonnage(): void
    {
        $_SESSION['creation_personnage'] = [
            'etape' => 1,
            'element' => '',
            'classe' => '',
            'region_depart' => '',
            'competences_elementaires' => [],
            'competences_neutres' => [],
            'nom' => '',
            'sexe' => '',
            'avatar' => '',
            'statistiques' => [
                'point_de_vie' => 0,
                'attaque' => 0,
                'magie' => 0,
                'agilite' => 0,
                'intelligence' => 0,
                'synchronisation_elementaire' => 0,
                'critique' => 0,
                'dexterite' => 0,
                'defense' => 0
            ]
        ];
    }

    // -----------------------------------------------------
    // Étape 1
    // -----------------------------------------------------
    private static function traiterCreationPersonnageEtape1(): void
    {
        self::verifierCompteConnecte();
        self::verifierCreationPersonnageActive();

        $element = trim($_POST['element'] ?? '');
        $elements_valides = ['Feu', 'Eau', 'Air', 'Terre'];

        if (!in_array($element, $elements_valides, true)) {
            $_SESSION['messages_erreur'] = ['Vous devez choisir un élément valide.'];
            $_SESSION['vue_personnage'] = 'creation_personnage';
            self::redirigerIndex();
        }

        $_SESSION['creation_personnage']['element'] = $element;
        $_SESSION['creation_personnage']['region_depart'] = self::obtenirRegionDepartParElement($element);
        $_SESSION['creation_personnage']['etape'] = 2;

        self::redirigerIndex();
    }

    // -----------------------------------------------------
    // Étape 2
    // -----------------------------------------------------
    private static function traiterCreationPersonnageEtape2(): void
    {
        self::verifierCompteConnecte();
        self::verifierCreationPersonnageActive();

        $classe = trim($_POST['classe'] ?? '');
        $classes_valides = ['Tank', 'Heal', 'DPS'];

        if (!in_array($classe, $classes_valides, true)) {
            $_SESSION['messages_erreur'] = ['Vous devez choisir une classe valide.'];
            $_SESSION['vue_personnage'] = 'creation_personnage';
            self::redirigerIndex();
        }

        $_SESSION['creation_personnage']['classe'] = $classe;
        $_SESSION['creation_personnage']['etape'] = 3;

        self::redirigerIndex();
    }

    // -----------------------------------------------------
    // Étape 3
    // -----------------------------------------------------
    private static function traiterCreationPersonnageEtape3(): void
    {
        self::verifierCompteConnecte();
        self::verifierCreationPersonnageActive();
        self::verifierEtapeMinimumCreationPersonnage(2);

        $competences = $_POST['competences_elementaires'] ?? [];

        if (!is_array($competences)) {
            $competences = [];
        }

        $competences = array_values(array_unique(array_map('strval', $competences)));

        $competences_disponibles = self::obtenirCompetencesElementairesFictives(
            $_SESSION['creation_personnage']['element'],
            $_SESSION['creation_personnage']['classe']
        );

        $competences_valides = [];
        foreach ($competences as $competence) {
            if (in_array($competence, $competences_disponibles, true)) {
                $competences_valides[] = $competence;
            }
        }

        if (count($competences_valides) !== 4) {
            $_SESSION['messages_erreur'] = ['Vous devez choisir exactement 4 compétences élémentaires.'];
            $_SESSION['vue_personnage'] = 'creation_personnage';
            self::redirigerIndex();
        }

        $_SESSION['creation_personnage']['competences_elementaires'] = $competences_valides;
        $_SESSION['creation_personnage']['etape'] = 4;

        self::redirigerIndex();
    }

    // -----------------------------------------------------
    // Étape 4
    // -----------------------------------------------------
    private static function traiterCreationPersonnageEtape4(): void
    {
        self::verifierCompteConnecte();
        self::verifierCreationPersonnageActive();
        self::verifierEtapeMinimumCreationPersonnage(3);

        $competences = $_POST['competences_neutres'] ?? [];

        if (!is_array($competences)) {
            $competences = [];
        }

        $competences = array_values(array_unique(array_map('strval', $competences)));
        $competences_disponibles = self::obtenirCompetencesNeutresFictives();

        $competences_valides = [];
        foreach ($competences as $competence) {
            if (in_array($competence, $competences_disponibles, true)) {
                $competences_valides[] = $competence;
            }
        }

        if (count($competences_valides) !== 3) {
            $_SESSION['messages_erreur'] = ['Vous devez choisir exactement 3 compétences neutres.'];
            $_SESSION['vue_personnage'] = 'creation_personnage';
            self::redirigerIndex();
        }

        $_SESSION['creation_personnage']['competences_neutres'] = $competences_valides;
        $_SESSION['creation_personnage']['etape'] = 5;

        self::redirigerIndex();
    }

    // -----------------------------------------------------
    // Étape 5
    // -----------------------------------------------------
    private static function traiterCreationPersonnageEtape5(PDO $connexion_base): void
    {
        self::verifierCompteConnecte();
        self::verifierCreationPersonnageActive();
        self::verifierEtapeMinimumCreationPersonnage(4);

        $nom = trim($_POST['nom_personnage'] ?? '');
        $sexe = trim($_POST['sexe'] ?? '');
        $avatar = trim($_POST['avatar'] ?? '');

        $point_de_vie = (int) ($_POST['point_de_vie'] ?? 0);
        $attaque = (int) ($_POST['attaque'] ?? 0);
        $magie = (int) ($_POST['magie'] ?? 0);
        $agilite = (int) ($_POST['agilite'] ?? 0);
        $intelligence = (int) ($_POST['intelligence'] ?? 0);
        $synchronisation_elementaire = (int) ($_POST['synchronisation_elementaire'] ?? 0);
        $critique = (int) ($_POST['critique'] ?? 0);
        $dexterite = (int) ($_POST['dexterite'] ?? 0);
        $defense = (int) ($_POST['defense'] ?? 0);

        $messages_erreur = [];

        if ($nom === '') {
            $messages_erreur[] = 'Le nom du personnage est obligatoire.';
        }

        if ($nom !== '' && mb_strlen($nom) < 3) {
            $messages_erreur[] = 'Le nom du personnage doit contenir au moins 3 caractères.';
        }

        if ($nom !== '' && mb_strlen($nom) > 50) {
            $messages_erreur[] = 'Le nom du personnage ne peut pas dépasser 50 caractères.';
        }

        if (!in_array($sexe, ['homme', 'femme'], true)) {
            $messages_erreur[] = 'Vous devez choisir un sexe valide.';
        }

        $statistiques = [
            'point_de_vie' => $point_de_vie,
            'attaque' => $attaque,
            'magie' => $magie,
            'agilite' => $agilite,
            'intelligence' => $intelligence,
            'synchronisation_elementaire' => $synchronisation_elementaire,
            'critique' => $critique,
            'dexterite' => $dexterite,
            'defense' => $defense
        ];

        foreach ($statistiques as $nom_statistique => $valeur_statistique) {
            if ($valeur_statistique < 0) {
                $messages_erreur[] = 'La statistique ' . $nom_statistique . ' ne peut pas être négative.';
            }
        }

        $total_points = array_sum($statistiques);
        if ($total_points !== 30) {
            $messages_erreur[] = 'Vous devez répartir exactement 30 points de statistiques.';
        }

        $requete_nom = $connexion_base->prepare('SELECT id FROM personnages WHERE nom = :nom LIMIT 1');
        $requete_nom->execute([
            'nom' => $nom
        ]);
        $personnage_existant = $requete_nom->fetch();

        if ($personnage_existant) {
            $messages_erreur[] = 'Ce nom de personnage est déjà utilisé.';
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

        $avatars_disponibles = self::obtenirAvatarsFictifs();
        $avatar_valide = false;
        $image_avatar_selectionnee = '';

        foreach ($avatars_disponibles as $avatar_disponible) {
            if (
                $avatar_disponible['identifiant'] === $avatar
                && $avatar_disponible['sexe'] === $sexe
            ) {
                $avatar_valide = true;
                $image_avatar_selectionnee = $avatar_disponible['image'];
                break;
            }
        }

        if (!$avatar_valide) {
            $messages_erreur[] = 'Vous devez choisir un avatar valide correspondant au sexe sélectionné.';
        }

        if (!empty($messages_erreur)) {
            $_SESSION['messages_erreur'] = $messages_erreur;
            $_SESSION['creation_personnage']['nom'] = $nom;
            $_SESSION['creation_personnage']['sexe'] = $sexe;
            $_SESSION['creation_personnage']['avatar'] = $avatar;
            $_SESSION['creation_personnage']['statistiques'] = $statistiques;
            $_SESSION['vue_personnage'] = 'creation_personnage';
            self::redirigerIndex();
        }

        $requete_insertion = $connexion_base->prepare(
            'INSERT INTO personnages (
                compte_id,
                nom,
                element,
                classe,
                portrait,
                sexe,
                region_depart,
                position_x,
                position_y,
                niveau,
                point_de_vie,
                attaque,
                magie,
                agilite,
                intelligence,
                synchronisation_elementaire,
                critique,
                dexterite,
                defense
            ) VALUES (
                :compte_id,
                :nom,
                :element,
                :classe,
                :portrait,
                :sexe,
                :region_depart,
                0,
                0,
                1,
                :point_de_vie,
                :attaque,
                :magie,
                :agilite,
                :intelligence,
                :synchronisation_elementaire,
                :critique,
                :dexterite,
                :defense
            )'
        );

        $requete_insertion->execute([
            'compte_id' => $_SESSION['compte_id'],
            'nom' => $nom,
            'element' => $_SESSION['creation_personnage']['element'],
            'classe' => $_SESSION['creation_personnage']['classe'],
            'portrait' => $image_avatar_selectionnee,
            'sexe' => $sexe,
            'region_depart' => $_SESSION['creation_personnage']['region_depart'],
            'point_de_vie' => $point_de_vie,
            'attaque' => $attaque,
            'magie' => $magie,
            'agilite' => $agilite,
            'intelligence' => $intelligence,
            'synchronisation_elementaire' => $synchronisation_elementaire,
            'critique' => $critique,
            'dexterite' => $dexterite,
            'defense' => $defense
        ]);

        $personnage_id = (int) $connexion_base->lastInsertId();

        $requete_competence = $connexion_base->prepare(
            'INSERT INTO personnage_competences (personnage_id, nom_competence, type_competence, ordre_affichage)
             VALUES (:personnage_id, :nom_competence, :type_competence, :ordre_affichage)'
        );

        $ordre_affichage = 1;
        foreach ($_SESSION['creation_personnage']['competences_elementaires'] as $competence_elementaire) {
            $requete_competence->execute([
                'personnage_id' => $personnage_id,
                'nom_competence' => $competence_elementaire,
                'type_competence' => 'elementaire',
                'ordre_affichage' => $ordre_affichage
            ]);
            $ordre_affichage++;
        }

        foreach ($_SESSION['creation_personnage']['competences_neutres'] as $competence_neutre) {
            $requete_competence->execute([
                'personnage_id' => $personnage_id,
                'nom_competence' => $competence_neutre,
                'type_competence' => 'neutre',
                'ordre_affichage' => $ordre_affichage
            ]);
            $ordre_affichage++;
        }

        $_SESSION['messages_succes'] = ['Personnage créé avec succès.'];
        unset($_SESSION['creation_personnage']);
        $_SESSION['vue_personnage'] = 'selection_personnage';

        self::redirigerIndex();
    }

    // -----------------------------------------------------
    // Connexion
    // -----------------------------------------------------
    private static function traiterConnexion(PDO $connexion_base): void
    {
        $pseudo = trim($_POST['pseudo'] ?? '');
        $mot_de_passe = $_POST['mot_de_passe'] ?? '';
        $messages_erreur = [];

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
    // Inscription
    // -----------------------------------------------------
    private static function traiterInscription(PDO $connexion_base): void
    {
        $pseudo = trim($_POST['pseudo'] ?? '');
        $mot_de_passe = $_POST['mot_de_passe'] ?? '';
        $messages_erreur = [];

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
    // Sélection d’un personnage
    // -----------------------------------------------------
    private static function traiterSelectionPersonnage(PDO $connexion_base): void
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
    // Suppression d’un personnage
    // -----------------------------------------------------
    private static function traiterSuppressionPersonnage(PDO $connexion_base): void
    {
        self::verifierCompteConnecte();

        $personnage_id = (int) ($_POST['personnage_id'] ?? 0);

        if ($personnage_id <= 0) {
            $_SESSION['messages_erreur'] = ['Le personnage à supprimer est invalide.'];
            $_SESSION['vue_personnage'] = 'selection_personnage';
            self::redirigerIndex();
        }

        $requete_verification = $connexion_base->prepare(
            'SELECT id, nom FROM personnages WHERE id = :id AND compte_id = :compte_id LIMIT 1'
        );

        $requete_verification->execute([
            'id' => $personnage_id,
            'compte_id' => $_SESSION['compte_id']
        ]);

        $personnage = $requete_verification->fetch();

        if (!$personnage) {
            $_SESSION['messages_erreur'] = ['Impossible de supprimer ce personnage.'];
            $_SESSION['vue_personnage'] = 'selection_personnage';
            self::redirigerIndex();
        }

        $requete_suppression = $connexion_base->prepare(
            'DELETE FROM personnages WHERE id = :id AND compte_id = :compte_id'
        );

        $requete_suppression->execute([
            'id' => $personnage_id,
            'compte_id' => $_SESSION['compte_id']
        ]);

        if (isset($_SESSION['personnage_id']) && (int) $_SESSION['personnage_id'] === $personnage_id) {
            unset($_SESSION['personnage_id'], $_SESSION['personnage_nom']);
        }

        $_SESSION['messages_succes'] = [
            'Le personnage "' . $personnage['nom'] . '" a été supprimé.'
        ];

        $_SESSION['vue_personnage'] = 'selection_personnage';
        self::redirigerIndex();
    }

    // -----------------------------------------------------
    // Vérifie qu’un compte est connecté
    // -----------------------------------------------------
    private static function verifierCompteConnecte(): void
    {
        if (!isset($_SESSION['compte_id'])) {
            $_SESSION['vue_auth'] = 'connexion';
            self::redirigerIndex();
        }
    }

    // -----------------------------------------------------
    // Vérifie que la création personnage existe
    // -----------------------------------------------------
    private static function verifierCreationPersonnageActive(): void
    {
        if (!isset($_SESSION['creation_personnage'])) {
            self::initialiserCreationPersonnage();
        }
    }

    // -----------------------------------------------------
    // Vérifie l’étape minimale
    // -----------------------------------------------------
    private static function verifierEtapeMinimumCreationPersonnage(int $etape_minimale): void
    {
        $etape_courante = (int) ($_SESSION['creation_personnage']['etape'] ?? 1);

        if ($etape_courante < $etape_minimale) {
            $_SESSION['messages_erreur'] = ['Vous devez suivre les étapes dans l’ordre.'];
            $_SESSION['vue_personnage'] = 'creation_personnage';
            self::redirigerIndex();
        }
    }

    // -----------------------------------------------------
    // Région de départ par élément
    // -----------------------------------------------------
    public static function obtenirRegionDepartParElement(string $element): string
    {
        $correspondances = [
            'Feu' => 'Ignivar',
            'Eau' => 'Aqualis',
            'Air' => 'Aeris',
            'Terre' => 'Verdalis'
        ];

        return $correspondances[$element] ?? 'Elementia';
    }

    // -----------------------------------------------------
    // Compétences élémentaires fictives
    // -----------------------------------------------------
    public static function obtenirCompetencesElementairesFictives(string $element, string $classe): array
    {
        return [
            $element . ' - ' . $classe . ' - Éclat primaire',
            $element . ' - ' . $classe . ' - Lame ancestrale',
            $element . ' - ' . $classe . ' - Souffle concentré',
            $element . ' - ' . $classe . ' - Onde de force',
            $element . ' - ' . $classe . ' - Marque sacrée',
            $element . ' - ' . $classe . ' - Sceau vivant',
            $element . ' - ' . $classe . ' - Rayon rituel',
            $element . ' - ' . $classe . ' - Danse du flux',
            $element . ' - ' . $classe . ' - Aube guerrière',
            $element . ' - ' . $classe . ' - Nexus intérieur'
        ];
    }

    // -----------------------------------------------------
    // Compétences neutres fictives
    // -----------------------------------------------------
    public static function obtenirCompetencesNeutresFictives(): array
    {
        return [
            'Observation calme',
            'Endurance simple',
            'Méditation guidée',
            'Réflexe précis',
            'Volonté stable'
        ];
    }

    // -----------------------------------------------------
    // Avatars fictifs avec chemins complets
    // -----------------------------------------------------
    public static function obtenirAvatarsFictifs(): array
    {
        return [
            [
                'identifiant' => 'avatar_homme_01',
                'nom' => 'Villageois A',
                'sexe' => 'homme',
                'image' => 'ressources/images/portraits/villagois/villagois_adulte_garcon_A.png'
            ],
            [
                'identifiant' => 'avatar_homme_02',
                'nom' => 'Noble garçon A',
                'sexe' => 'homme',
                'image' => 'ressources/images/portraits/noble/noble_garcon_A.png'
            ],
            [
                'identifiant' => 'avatar_homme_03',
                'nom' => 'Noble garçon B',
                'sexe' => 'homme',
                'image' => 'ressources/images/portraits/noble/noble_garcon_B.png'
            ],
            [
                'identifiant' => 'avatar_homme_04',
                'nom' => 'Voyageur',
                'sexe' => 'homme',
                'image' => 'ressources/images/portraits/villagois/villagois_voyageur.png'
            ],
            [
                'identifiant' => 'avatar_homme_05',
                'nom' => 'Duc',
                'sexe' => 'homme',
                'image' => 'ressources/images/portraits/noble/duc.png'
            ],
            [
                'identifiant' => 'avatar_femme_01',
                'nom' => 'Villageoise A',
                'sexe' => 'femme',
                'image' => 'ressources/images/portraits/villagois/villagois_adulte_fille_A.png'
            ],
            [
                'identifiant' => 'avatar_femme_02',
                'nom' => 'Villageoise B',
                'sexe' => 'femme',
                'image' => 'ressources/images/portraits/villagois/villagois_adulte_fille_B.png'
            ],
            [
                'identifiant' => 'avatar_femme_03',
                'nom' => 'Noble fille A',
                'sexe' => 'femme',
                'image' => 'ressources/images/portraits/noble/noble_fille_A.png'
            ],
            [
                'identifiant' => 'avatar_femme_04',
                'nom' => 'Noble fille B',
                'sexe' => 'femme',
                'image' => 'ressources/images/portraits/noble/noble_file_B.png'
            ],
            [
                'identifiant' => 'avatar_femme_05',
                'nom' => 'Duchesse',
                'sexe' => 'femme',
                'image' => 'ressources/images/portraits/noble/duchesse.png'
            ]
        ];
    }

    // -----------------------------------------------------
    // Suggestion de répartition selon la classe
    // -----------------------------------------------------
    public static function obtenirSuggestionStatistiques(string $classe): array
    {
        if ($classe === 'Tank') {
            return [
                'point_de_vie' => 7,
                'attaque' => 2,
                'magie' => 1,
                'agilite' => 2,
                'intelligence' => 2,
                'synchronisation_elementaire' => 3,
                'critique' => 1,
                'dexterite' => 2,
                'defense' => 10
            ];
        }

        if ($classe === 'Heal') {
            return [
                'point_de_vie' => 3,
                'attaque' => 1,
                'magie' => 6,
                'agilite' => 2,
                'intelligence' => 6,
                'synchronisation_elementaire' => 5,
                'critique' => 1,
                'dexterite' => 2,
                'defense' => 4
            ];
        }

        return [
            'point_de_vie' => 3,
            'attaque' => 6,
            'magie' => 4,
            'agilite' => 5,
            'intelligence' => 2,
            'synchronisation_elementaire' => 4,
            'critique' => 3,
            'dexterite' => 2,
            'defense' => 1
        ];
    }

    // -----------------------------------------------------
    // Redirection interne
    // -----------------------------------------------------
    private static function redirigerIndex(): void
    {
        header('Location: index.php');
        exit;
    }
}