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
        // -------------------------------------------------
        // Initialisation des vues par défaut
        // -------------------------------------------------
        if (!isset($_SESSION['vue_auth'])) {
            $_SESSION['vue_auth'] = 'connexion';
        }

        // -------------------------------------------------
        // Traitement des actions envoyées en POST
        // -------------------------------------------------
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            self::traiterActions($connexion_base);
        }

        // -------------------------------------------------
        // Détermination de la vue finale à afficher
        // -------------------------------------------------
        $vue = self::determinerVue();

        // -------------------------------------------------
        // Chargement du gabarit principal
        // -------------------------------------------------
        include __DIR__ . '/../vues/commun/gabarit_principal.php';
    }

    // -----------------------------------------------------
    // Détermine la vue à afficher
    // -----------------------------------------------------
    private static function determinerVue(): string
    {
        // -------------------------------------------------
        // Si aucun compte n’est connecté
        // -------------------------------------------------
        if (!isset($_SESSION['compte_id'])) {
            return $_SESSION['vue_auth'] === 'inscription' ? 'inscription' : 'connexion';
        }

        // -------------------------------------------------
        // Si aucun personnage actif n’est sélectionné
        // -------------------------------------------------
        if (!isset($_SESSION['personnage_id'])) {
            if (isset($_SESSION['vue_personnage']) && $_SESSION['vue_personnage'] === 'creation_personnage') {
                return 'creation_personnage';
            }

            return 'selection_personnage';
        }

        // -------------------------------------------------
        // Sinon le joueur entre dans le monde
        // -------------------------------------------------
        return 'jeu';
    }

    // -----------------------------------------------------
    // Traite toutes les actions des formulaires
    // -----------------------------------------------------
    private static function traiterActions(PDO $connexion_base): void
    {
        // -------------------------------------------------
        // Récupération de l’action
        // -------------------------------------------------
        $action = $_POST['action'] ?? '';

        // -------------------------------------------------
        // Navigation authentification
        // -------------------------------------------------
        if ($action === 'afficher_inscription') {
            $_SESSION['vue_auth'] = 'inscription';
            self::redirigerIndex();
        }

        if ($action === 'afficher_connexion') {
            $_SESSION['vue_auth'] = 'connexion';
            self::redirigerIndex();
        }

        // -------------------------------------------------
        // Déconnexion complète
        // -------------------------------------------------
        if ($action === 'deconnexion') {
            $_SESSION = [];
            session_destroy();
            session_start();
            $_SESSION['vue_auth'] = 'connexion';
            self::redirigerIndex();
        }

        // -------------------------------------------------
        // Actions inventaire / équipement
        // -------------------------------------------------
        if ($action === 'equiper_objet_inventaire') {
            self::verifierCompteConnecte();
            self::verifierPersonnageActif();

            require_once __DIR__ . '/../modeles/Inventaire.php';
            require_once __DIR__ . '/../modeles/Equipement.php';

            $personnage_id = (int) ($_SESSION['personnage_id'] ?? 0);
            $instance_objet_id = (int) ($_POST['instance_objet_id'] ?? 0);

            if ($instance_objet_id <= 0) {
                $_SESSION['messages_erreur'] = ['Objet invalide.'];
                self::redirigerIndex();
            }

            $modeleEquipement = new Equipement($connexion_base);

            if (!$modeleEquipement->verifierProprieteInstance($personnage_id, $instance_objet_id)) {
                $_SESSION['messages_erreur'] = ['Cet objet ne vous appartient pas.'];
                self::redirigerIndex();
            }

            if ($modeleEquipement->instanceDejaEquipee($instance_objet_id)) {
                $_SESSION['messages_erreur'] = ['Cet objet est déjà équipé.'];
                self::redirigerIndex();
            }

            $slotCompatible = $modeleEquipement->trouverSlotLibreCompatible($personnage_id, $instance_objet_id);

            if (!$slotCompatible) {
                $_SESSION['messages_erreur'] = ['Aucun emplacement libre compatible pour cet objet.'];
                self::redirigerIndex();
            }

            $connexion_base->beginTransaction();

            try {
                $modeleEquipement->equiperInstanceDansSlot(
                    $personnage_id,
                    (int) $slotCompatible['id'],
                    $instance_objet_id
                );

                Inventaire::retirerInstance($personnage_id, $instance_objet_id);

                $connexion_base->commit();
            } catch (Throwable $exception) {
                if ($connexion_base->inTransaction()) {
                    $connexion_base->rollBack();
                }

                $_SESSION['messages_erreur'] = ['Impossible d’équiper l’objet.'];
            }

            self::redirigerIndex();
        }

        if ($action === 'jeter_objet_inventaire') {
            self::verifierCompteConnecte();
            self::verifierPersonnageActif();

            require_once __DIR__ . '/../modeles/Inventaire.php';
            require_once __DIR__ . '/../modeles/Equipement.php';

            $personnage_id = (int) ($_SESSION['personnage_id'] ?? 0);
            $instance_objet_id = (int) ($_POST['instance_objet_id'] ?? 0);

            if ($instance_objet_id <= 0) {
                $_SESSION['messages_erreur'] = ['Objet invalide.'];
                self::redirigerIndex();
            }

            $modeleEquipement = new Equipement($connexion_base);

            if (!$modeleEquipement->verifierProprieteInstance($personnage_id, $instance_objet_id)) {
                $_SESSION['messages_erreur'] = ['Cet objet ne vous appartient pas.'];
                self::redirigerIndex();
            }

            $connexion_base->beginTransaction();

            try {
                $modeleEquipement->desequiperInstance($personnage_id, $instance_objet_id);
                Inventaire::retirerInstance($personnage_id, $instance_objet_id);
                Inventaire::supprimerInstanceObjet($personnage_id, $instance_objet_id);

                $connexion_base->commit();
            } catch (Throwable $exception) {
                if ($connexion_base->inTransaction()) {
                    $connexion_base->rollBack();
                }

                $_SESSION['messages_erreur'] = ['Impossible de jeter l’objet.'];
            }

            self::redirigerIndex();
        }

        if ($action === 'debug_ajouter_objet_inventaire') {
            self::verifierCompteConnecte();
            self::verifierPersonnageActif();

            require_once __DIR__ . '/../modeles/Objet.php';

            $personnage_id = (int) ($_SESSION['personnage_id'] ?? 0);
            $catalogue_objet_id = (int) ($_POST['catalogue_objet_id'] ?? 0);
            $quantite = max(1, (int) ($_POST['quantite'] ?? 1));

            if ($catalogue_objet_id <= 0) {
                $_SESSION['messages_erreur'] = ['Objet de debug invalide.'];
                self::redirigerIndex();
            }

            try {
                $nombreAjoutes = Objet::ajouterObjetDebugAuPersonnage($personnage_id, $catalogue_objet_id, $quantite);

                if ($nombreAjoutes <= 0) {
                    $_SESSION['messages_erreur'] = ['Aucun objet n’a pu être ajouté.'];
                }
            } catch (Throwable $exception) {
                $_SESSION['messages_erreur'] = ['Impossible d’ajouter l’objet de debug.'];
            }

            self::redirigerIndex();
        }

        // -------------------------------------------------
        // Connexion / inscription
        // -------------------------------------------------
        if ($action === 'connexion') {
            self::traiterConnexion($connexion_base);
        }

        if ($action === 'inscription') {
            self::traiterInscription($connexion_base);
        }

        // -------------------------------------------------
        // Accès à la création personnage
        // -------------------------------------------------
        if ($action === 'afficher_creation_personnage') {
            self::verifierCompteConnecte();
            self::initialiserCreationPersonnage();
            $_SESSION['vue_personnage'] = 'creation_personnage';
            self::redirigerIndex();
        }

        // -------------------------------------------------
        // Retour à la liste des personnages
        // -------------------------------------------------
        if ($action === 'retour_selection_personnage') {
            self::verifierCompteConnecte();
            unset($_SESSION['creation_personnage']);
            $_SESSION['vue_personnage'] = 'selection_personnage';
            self::redirigerIndex();
        }

        // -------------------------------------------------
        // Étapes de création personnage
        // -------------------------------------------------
        if ($action === 'creation_personnage_etape_1') {
            self::traiterCreationPersonnageEtape1();
        }

        if ($action === 'creation_personnage_etape_2') {
            self::traiterCreationPersonnageEtape2();
        }

        if ($action === 'creation_personnage_etape_3') {
            self::traiterCreationPersonnageEtape3($connexion_base);
        }

        if ($action === 'creation_personnage_etape_4') {
            self::traiterCreationPersonnageEtape4($connexion_base);
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

        // -------------------------------------------------
        // Sélection d’un personnage existant
        // -------------------------------------------------
        if ($action === 'selectionner_personnage') {
            self::traiterSelectionPersonnage($connexion_base);
        }

        // -------------------------------------------------
        // Suppression d’un personnage existant
        // -------------------------------------------------
        if ($action === 'supprimer_personnage') {
            self::traiterSuppressionPersonnage($connexion_base);
        }

        // -------------------------------------------------
        // Retour à la sélection des personnages depuis le jeu
        // -------------------------------------------------
        if ($action === 'quitter_jeu_vers_selection_personnage') {
            self::traiterRetourSelectionDepuisJeu();
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
            'variante_avatar' => 1,
            'statistiques' => [
                'attaque' => 0,
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
    // Étape 1 : choix de l’élément
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
    // Étape 2 : choix de la classe
    // -----------------------------------------------------
    // -----------------------------------------------------
    // Étape 2 : choix de la classe liée à l’élément
    // -----------------------------------------------------
    private static function traiterCreationPersonnageEtape2(): void
    {
        self::verifierCompteConnecte();
        self::verifierCreationPersonnageActive();

        $classe = trim($_POST['classe'] ?? '');
        $element = (string) ($_SESSION['creation_personnage']['element'] ?? '');

        $classes_valides = array_keys(self::obtenirClassesParElement($element));

        if (!in_array($classe, $classes_valides, true)) {
            $_SESSION['messages_erreur'] = ['Vous devez choisir une classe valide pour cet élément.'];
            $_SESSION['vue_personnage'] = 'creation_personnage';
            self::redirigerIndex();
        }

        $_SESSION['creation_personnage']['classe'] = $classe;
        $_SESSION['creation_personnage']['etape'] = 3;

        self::redirigerIndex();
    }

    // -----------------------------------------------------
    // Étape 3 : choix de 4 compétences élémentaires
    // -----------------------------------------------------
    // -----------------------------------------------------
    // Étape 3 : choix de 4 compétences élémentaires du catalogue
    // -----------------------------------------------------
    private static function traiterCreationPersonnageEtape3(PDO $connexion_base): void
    {
        self::verifierCompteConnecte();
        self::verifierCreationPersonnageActive();
        self::verifierEtapeMinimumCreationPersonnage(2);

        $competences = $_POST['competences_elementaires'] ?? [];

        if (!is_array($competences)) {
            $competences = [];
        }

        $competences = array_values(array_unique(array_map('strval', $competences)));

        $catalogue = self::obtenirCompetencesElementairesCatalogue(
            $connexion_base,
            (string) $_SESSION['creation_personnage']['element'],
            (string) $_SESSION['creation_personnage']['classe']
        );

        $codes_valides = array_column($catalogue, 'code_competence');
        $competences_valides = [];

        foreach ($competences as $code_competence) {
            if (in_array($code_competence, $codes_valides, true)) {
                $competences_valides[] = $code_competence;
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
    // Étape 4 : choix de 3 compétences neutres
    // -----------------------------------------------------
    // -----------------------------------------------------
    // Étape 4 : choix de 3 compétences neutres du catalogue
    // -----------------------------------------------------
    private static function traiterCreationPersonnageEtape4(PDO $connexion_base): void
    {
        self::verifierCompteConnecte();
        self::verifierCreationPersonnageActive();
        self::verifierEtapeMinimumCreationPersonnage(3);

        $competences = $_POST['competences_neutres'] ?? [];

        if (!is_array($competences)) {
            $competences = [];
        }

        $competences = array_values(array_unique(array_map('strval', $competences)));

        $catalogue = self::obtenirCompetencesNeutresCatalogue($connexion_base);
        $codes_valides = array_column($catalogue, 'code_competence');
        $competences_valides = [];

        foreach ($competences as $code_competence) {
            if (in_array($code_competence, $codes_valides, true)) {
                $competences_valides[] = $code_competence;
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
    // Étape 5 : identité + statistiques + création finale
    // -----------------------------------------------------
    private static function traiterCreationPersonnageEtape5(PDO $connexion_base): void
    {
        self::verifierCompteConnecte();
        self::verifierCreationPersonnageActive();
        self::verifierEtapeMinimumCreationPersonnage(4);

        $nom = trim($_POST['nom_personnage'] ?? '');
        $sexe = trim($_POST['sexe'] ?? '');
        $variante_avatar = (int) ($_POST['variante_avatar'] ?? 1);
        $avatar = trim($_POST['avatar'] ?? '');

        $point_de_vie = self::obtenirBasePointDeVieParClasse((string) ($_SESSION['creation_personnage']['classe'] ?? ''));
        $attaque = (int) ($_POST['attaque'] ?? 0);
        $magie = self::obtenirBaseMagieParClasse((string) ($_SESSION['creation_personnage']['classe'] ?? ''));
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

        $avatar_valide = self::verifierAvatarCreationPersonnage(
            $avatar,
            $sexe,
            (string) ($_SESSION['creation_personnage']['element'] ?? ''),
            (string) ($_SESSION['creation_personnage']['classe'] ?? ''),
            $variante_avatar
        );

        if (!$avatar_valide) {
            $messages_erreur[] = 'Vous devez choisir un avatar valide correspondant au sexe sélectionné.';
        }

        $statistiques = [
            'attaque' => $attaque,
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

        if (!empty($messages_erreur)) {
            $_SESSION['messages_erreur'] = $messages_erreur;
            $_SESSION['creation_personnage']['nom'] = $nom;
            $_SESSION['creation_personnage']['sexe'] = $sexe;
            $_SESSION['creation_personnage']['avatar'] = $avatar;
            $_SESSION['creation_personnage']['variante_avatar'] = $variante_avatar;
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
            'portrait' => 'ressources/images/avatars/' . $avatar,
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
            'INSERT INTO personnage_competences_progression (
                personnage_id,
                code_competence,
                niveau_sort,
                niveau_max_actuel,
                est_ultime,
                xp_actuelle,
                xp_suivante,
                est_equipee,
                ordre_slot
            ) VALUES (
                :personnage_id,
                :code_competence,
                :niveau_sort,
                :niveau_max_actuel,
                0,
                0,
                100,
                1,
                :ordre_slot
            )'
        );

        $ordre_affichage = 1;
        foreach ($_SESSION['creation_personnage']['competences_elementaires'] as $code_competence) {
            $niveau_max_actuel = self::obtenirNiveauMaxCompetenceDepuisCatalogue($connexion_base, $code_competence);

            $requete_competence->execute([
                'personnage_id' => $personnage_id,
                'code_competence' => $code_competence,
                'niveau_sort' => 1,
                'niveau_max_actuel' => $niveau_max_actuel,
                'ordre_slot' => $ordre_affichage
            ]);
            $ordre_affichage++;
        }

        foreach ($_SESSION['creation_personnage']['competences_neutres'] as $code_competence) {
            $niveau_max_actuel = self::obtenirNiveauMaxCompetenceDepuisCatalogue($connexion_base, $code_competence);

            $requete_competence->execute([
                'personnage_id' => $personnage_id,
                'code_competence' => $code_competence,
                'niveau_sort' => 1,
                'niveau_max_actuel' => $niveau_max_actuel,
                'ordre_slot' => $ordre_affichage
            ]);
            $ordre_affichage++;
        }

        $_SESSION['messages_succes'] = ['Personnage créé avec succès.'];
        unset($_SESSION['creation_personnage']);
        $_SESSION['vue_personnage'] = 'selection_personnage';

        self::redirigerIndex();
    }

    // -----------------------------------------------------
    // Connexion du compte
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
    // Inscription du compte
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
    // Sélection d’un personnage existant
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
    // Suppression d’un personnage existant
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
    // Retourne de la vue jeu vers la sélection personnage
    // -----------------------------------------------------
    private static function traiterRetourSelectionDepuisJeu(): void
    {
        self::verifierCompteConnecte();

        unset($_SESSION['personnage_id'], $_SESSION['personnage_nom']);
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
    // Liste des classes disponibles selon l’élément choisi
    // -----------------------------------------------------
    public static function obtenirClassesParElement(string $element): array
    {
        $classes = [
            'Feu' => [
                'Guerrier du Feu' => 'Tank défensif renforcé par le feu.',
                'Berserker du Feu' => 'DPS énergie brutal au corps à corps.',
                'Mage du Feu' => 'DPS magie spécialisé dans les flammes.',
                'Prêtre du Feu' => 'Soutien et soins par le feu vital.',
            ],
            'Eau' => [
                'Guerrier de l’Eau' => 'Tank fluide et protecteur.',
                'Combattant de l’Eau' => 'DPS énergie mobile et offensif.',
                'Mage de l’Eau' => 'DPS magie des flots et des abysses.',
                'Prêtre de l’Eau' => 'Soutien et purification par l’eau.',
            ],
            'Air' => [
                'Guerrier de l’Air' => 'Tank mobile porté par les vents.',
                'Chasseur de l’Air' => 'DPS énergie précis à distance.',
                'Mage de l’Air' => 'DPS magie des rafales et tempêtes.',
                'Prêtre de l’Air' => 'Soutien, protection et soins légers.',
            ],
            'Terre' => [
                'Guerrier de la Terre' => 'Tank lourd et résistant.',
                'Briseur de Terre' => 'DPS énergie de puissance brute.',
                'Mage de la Terre' => 'DPS magie tellurique.',
                'Prêtre de la Terre' => 'Soutien et régénération naturelle.',
            ],
        ];

        return $classes[$element] ?? [];
    }

    // -----------------------------------------------------
    // Récupère les 10 compétences élémentaires normales
    // pour l’élément et la classe choisis
    // -----------------------------------------------------
    public static function obtenirCompetencesElementairesCatalogue(PDO $connexion_base, string $element, string $classe): array
    {
        $requete = $connexion_base->prepare(
            "SELECT code_competence, nom, resume, cout_utilisation, ressource_utilisee
             FROM catalogue_competences
             WHERE famille_competence = 'elementaire'
               AND element = :element
               AND classe = :classe
             ORDER BY ordre_affichage ASC, code_competence ASC"
        );

        $requete->execute([
            'element' => $element,
            'classe' => $classe
        ]);

        return $requete->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    // -----------------------------------------------------
    // Récupère les 10 compétences neutres du catalogue
    // -----------------------------------------------------
    public static function obtenirCompetencesNeutresCatalogue(PDO $connexion_base): array
    {
        $requete = $connexion_base->query(
            "SELECT code_competence, nom, resume, declencheur_progression
             FROM catalogue_competences
             WHERE famille_competence = 'neutre'
             ORDER BY ordre_affichage ASC, code_competence ASC"
        );

        return $requete ? ($requete->fetchAll(PDO::FETCH_ASSOC) ?: []) : [];
    }

    // -----------------------------------------------------
    // Récupère le niveau max naturel d’une compétence depuis
    // le catalogue statique
    // -----------------------------------------------------
    public static function obtenirNiveauMaxCompetenceDepuisCatalogue(PDO $connexion_base, string $code_competence): int
    {
        $requete = $connexion_base->prepare(
            "SELECT niveau_max_naturel
             FROM catalogue_competences
             WHERE code_competence = :code_competence
             LIMIT 1"
        );

        $requete->execute([
            'code_competence' => $code_competence
        ]);

        $ligne = $requete->fetch(PDO::FETCH_ASSOC);

        return (int) ($ligne['niveau_max_naturel'] ?? 1);
    }

    // -----------------------------------------------------
    // Retourne le chemin complet de l’avatar selon son identifiant
    // -----------------------------------------------------
    public static function obtenirCheminAvatarParIdentifiant(string $identifiant_avatar): string
    {
        foreach (self::obtenirAvatarsFictifs() as $avatar) {
            if ($avatar['identifiant'] === $identifiant_avatar) {
                return (string) $avatar['image'];
            }
        }

        return '';
    }

    // -----------------------------------------------------
    // Avatars fictifs
    // -----------------------------------------------------

    public static function verifierAvatarCreationPersonnage(
        string $avatar,
        string $sexe,
        string $element,
        string $classe,
        int $variante_avatar
    ): bool
    {
        $avatar = trim($avatar);

        if ($avatar === '' || !in_array($sexe, ['homme', 'femme'], true)) {
            return false;
        }

        $mappingElement = [
            'Feu' => 'feu',
            'Eau' => 'eau',
            'Air' => 'air',
            'Terre' => 'terre'
        ];

        $mappingClasse = [
            'Guerrier du Feu' => 'guerrier',
            'Berserker du Feu' => 'berserker',
            'Mage du Feu' => 'mage',
            'Prêtre du Feu' => 'pretre',
            'Guerrier de l’Eau' => 'guerrier',
            'Combattant de l’Eau' => 'berserker',
            'Mage de l’Eau' => 'mage',
            'Prêtre de l’Eau' => 'pretre',
            'Guerrier de l’Air' => 'guerrier',
            'Chasseur de l’Air' => 'berserker',
            'Mage de l’Air' => 'mage',
            'Prêtre de l’Air' => 'pretre',
            'Guerrier de la Terre' => 'guerrier',
            'Briseur de Terre' => 'berserker',
            'Mage de la Terre' => 'mage',
            'Prêtre de la Terre' => 'pretre'
        ];

        $elementFichier = $mappingElement[$element] ?? '';
        $classeFichier = $mappingClasse[$classe] ?? '';

        if ($elementFichier !== '' && $classeFichier !== '') {
            $avatarAttendu = $elementFichier . '_' . $classeFichier . '_' . $sexe . '_' . $variante_avatar . '.png';

            if ($avatar === $avatarAttendu) {
                $cheminAvatar = __DIR__ . '/../ressources/images/avatars/' . $avatarAttendu;
                if (is_file($cheminAvatar)) {
                    return true;
                }
            }
        }

        $avatars_disponibles = self::obtenirAvatarsFictifs();
        foreach ($avatars_disponibles as $avatar_disponible) {
            if (
                ($avatar_disponible['identifiant'] ?? '') === $avatar
                && ($avatar_disponible['sexe'] ?? '') === $sexe
            ) {
                return true;
            }
        }

        return false;
    }

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
        $classes_tank = ['Guerrier du Feu', 'Guerrier de l’Eau', 'Guerrier de l’Air', 'Guerrier de la Terre'];
        $classes_heal = ['Prêtre du Feu', 'Prêtre de l’Eau', 'Prêtre de l’Air', 'Prêtre de la Terre'];
        $classes_dps_magie = ['Mage du Feu', 'Mage de l’Eau', 'Mage de l’Air', 'Mage de la Terre'];

        if (in_array($classe, $classes_tank, true)) {
            return [
                'attaque' => 4,
                'agilite' => 3,
                'intelligence' => 2,
                'synchronisation_elementaire' => 3,
                'critique' => 2,
                'dexterite' => 4,
                'defense' => 12
            ];
        }

        if (in_array($classe, $classes_heal, true)) {
            return [
                'attaque' => 2,
                'agilite' => 3,
                'intelligence' => 8,
                'synchronisation_elementaire' => 7,
                'critique' => 2,
                'dexterite' => 3,
                'defense' => 5
            ];
        }

        if (in_array($classe, $classes_dps_magie, true)) {
            return [
                'attaque' => 2,
                'agilite' => 4,
                'intelligence' => 8,
                'synchronisation_elementaire' => 8,
                'critique' => 3,
                'dexterite' => 3,
                'defense' => 2
            ];
        }

        return [
            'attaque' => 8,
            'agilite' => 6,
            'intelligence' => 2,
            'synchronisation_elementaire' => 3,
            'critique' => 4,
            'dexterite' => 5,
            'defense' => 2
        ];
    }

    public static function obtenirBasePointDeVieParClasse(string $classe): int
    {
        $classes_tank = ['Guerrier du Feu', 'Guerrier de l’Eau', 'Guerrier de l’Air', 'Guerrier de la Terre'];
        $classes_heal = ['Prêtre du Feu', 'Prêtre de l’Eau', 'Prêtre de l’Air', 'Prêtre de la Terre'];
        $classes_dps_magie = ['Mage du Feu', 'Mage de l’Eau', 'Mage de l’Air', 'Mage de la Terre'];

        if (in_array($classe, $classes_tank, true)) {
            return 200;
        }

        if (in_array($classe, $classes_heal, true)) {
            return 140;
        }

        if (in_array($classe, $classes_dps_magie, true)) {
            return 120;
        }

        return 160;
    }

    public static function obtenirBaseMagieParClasse(string $classe): int
    {
        $classes_tank = ['Guerrier du Feu', 'Guerrier de l’Eau', 'Guerrier de l’Air', 'Guerrier de la Terre'];
        $classes_heal = ['Prêtre du Feu', 'Prêtre de l’Eau', 'Prêtre de l’Air', 'Prêtre de la Terre'];
        $classes_dps_magie = ['Mage du Feu', 'Mage de l’Eau', 'Mage de l’Air', 'Mage de la Terre'];

        if (in_array($classe, $classes_tank, true)) {
            return 40;
        }

        if (in_array($classe, $classes_heal, true)) {
            return 120;
        }

        if (in_array($classe, $classes_dps_magie, true)) {
            return 140;
        }

        return 60;
    }


    // -----------------------------------------------------
    // Vérifie qu'un personnage actif est sélectionné
    // -----------------------------------------------------
    private static function verifierPersonnageActif(): void
    {
        if (!isset($_SESSION['personnage_id']) || (int) $_SESSION['personnage_id'] <= 0) {
            $_SESSION['messages_erreur'] = ['Aucun personnage actif sélectionné.'];
            self::redirigerIndex();
        }
    }

    // -----------------------------------------------------
    // Redirection interne
    // -----------------------------------------------------
    private static function redirigerIndex(): void
    {
        header('Location: index.php');
        exit;
    }
	
	// -----------------------------------------------------
	// Détermine automatiquement le nom du fichier avatar
	// -----------------------------------------------------
	public static function obtenirAvatarAutomatique(string $element, string $classe, string $sexe, int $variante = 1): string
	{
		if (!in_array($sexe, ['homme', 'femme'], true)) {
			return '';
		}

		if (!in_array($variante, [1, 2], true)) {
			$variante = 1;
		}

		$elements = [
			'Feu' => 'feu',
			'Eau' => 'eau',
			'Air' => 'air',
			'Terre' => 'terre'
		];

		$classes = [
			'Guerrier du Feu' => 'guerrier',
			'Berserker du Feu' => 'berserker',
			'Mage du Feu' => 'mage',
			'Prêtre du Feu' => 'pretre',

			'Guerrier de l’Eau' => 'guerrier',
			'Combattant de l’Eau' => 'berserker',
			'Mage de l’Eau' => 'mage',
			'Prêtre de l’Eau' => 'pretre',

			'Guerrier de l’Air' => 'guerrier',
			'Chasseur de l’Air' => 'berserker',
			'Mage de l’Air' => 'mage',
			'Prêtre de l’Air' => 'pretre',

			'Guerrier de la Terre' => 'guerrier',
			'Briseur de Terre' => 'berserker',
			'Mage de la Terre' => 'mage',
			'Prêtre de la Terre' => 'pretre'
		];

		$element_fichier = $elements[$element] ?? '';
		$classe_fichier = $classes[$classe] ?? '';

		if ($element_fichier === '' || $classe_fichier === '') {
			return '';
		}

		return $element_fichier . '_' . $classe_fichier . '_' . $sexe . '_' . $variante . '.png';
	}

	// -----------------------------------------------------
	// Retourne le chemin complet de l’avatar automatique
	// -----------------------------------------------------
	public static function obtenirCheminAvatarAutomatique(string $element, string $classe, string $sexe, int $variante = 1): string
	{
		$avatar = self::obtenirAvatarAutomatique($element, $classe, $sexe, $variante);

		if ($avatar === '') {
			return '';
		}

		return 'ressources/images/avatars/' . $avatar;
	}
}
