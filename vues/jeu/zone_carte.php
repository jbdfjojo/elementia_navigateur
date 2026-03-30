<?php
$positionCarteJoueur = $carte['position_joueur'] ?? ['x' => (int) ($personnage['position_x'] ?? 18), 'y' => (int) ($personnage['position_y'] ?? 12)];

$creerInteraction = static function (string $id, string $nom, string $icone, float $x, float $y, string $type, string $texte, array $options = []): array {
    return array_merge([
        'id' => $id,
        'nom' => $nom,
        'icone' => $icone,
        'x' => $x,
        'y' => $y,
        'type' => $type,
        'texte' => $texte,
    ], $options);
};

$creerLieuInterieur = static function (string $nomVille, string $idLieu, string $nomLieu, ?array $definitionPnjVille = null) use ($creerInteraction): array {
    $definitionsLieux = [
        'guilde_aventuriers' => [
            'titre' => 'Guilde des aventuriers',
            'sous_titre' => 'Missions, grades, rumeurs et progression héroïque',
            'fond' => 'ressources/images/fonds_dialogue/Hall_aventuriers.png',
            'description' => 'La Guilde des aventuriers de ' . $nomVille . ' centralise les missions officielles, la progression des membres, les rumeurs utiles et la revente des trophées de quête.',
            'interactions' => [
                $creerInteraction('tableau_missions', 'Tableau des missions', '📜', 16, 44, 'action', 'Le tableau des missions affichera les contrats disponibles, les objectifs régionaux et les quêtes principales ou secondaires.'),
                $creerInteraction('maitre_guilde', 'Maître de guilde', '🧙', 35, 60, 'pnj', 'Le maître de guilde permettra de discuter, de s’enregistrer, de valider votre niveau, de réinitialiser toutes vos compétences ou d’en supprimer une seule pour en reprendre une nouvelle au niveau 1.'),
                $creerInteraction('tableau_rumeurs_guilde', 'Tableau de rumeurs', '🗺', 53, 36, 'action', 'Le tableau de rumeurs servira à découvrir des informations cachées, des quêtes qui ne sont pas affichées au tableau principal et des opportunités rares.'),
                $creerInteraction('informations_guilde', 'Informations', 'ℹ', 72, 55, 'action', 'La section informations expliquera le monde des aventuriers, les grades, les niveaux, les droits et le fonctionnement de la guilde.'),
                $creerInteraction('revente_trophees', 'Revente des trophées', '💎', 84, 38, 'action', 'Ici, le joueur pourra revendre les objets ou preuves récupérés pendant certaines quêtes pour obtenir des cristaux.'),
            ],
        ],
        'guilde_commerce' => [
            'titre' => 'Guilde du commerce',
            'sous_titre' => 'Marchés, rumeurs marchandes et progression commerciale',
            'fond' => 'ressources/images/fonds_dialogue/Hall_guilde_marchande.png',
            'description' => 'La Guilde du commerce organise les échanges, les prix, les informations marchandes et l’inscription des commerçants ambitieux.',
            'interactions' => [
                $creerInteraction('tableau_rumeurs_commerce', 'Tableau de rumeurs', '📌', 18, 42, 'action', 'Le tableau de rumeurs marchandes signalera les besoins des villes, les pénuries, les occasions rares et certaines quêtes commerciales.'),
                $creerInteraction('bourse_villes', 'Bourse', '📈', 52, 35, 'action', 'La bourse affichera le cours du marché dans toutes les villes pour aider le joueur à savoir où vendre au meilleur prix.'),
                $creerInteraction('maitre_commerce', 'Maître marchand', '💼', 78, 58, 'pnj', 'Le maître marchand permettra de discuter, de s’inscrire à la guilde du commerce et de passer les niveaux liés au rang commercial.'),
            ],
        ],
        'marche' => [
            'titre' => 'Marché',
            'sous_titre' => 'Échanges rapides, étals et circulation des biens',
            'fond' => 'ressources/images/fonds_dialogue/Marche.png',
            'description' => 'Le marché de ' . $nomVille . ' rassemble vendeurs, récolteurs et voyageurs autour des ventes courantes et des besoins immédiats de la ville.',
            'scene_initiale' => 'accueil',
            'scenes' => [
                'accueil' => [
                    'titre' => 'Marché',
                    'sous_titre' => 'Échanges rapides, étals et circulation des biens',
                    'fond' => 'ressources/images/fonds_dialogue/Marche.png',
                    'description' => 'Le marché de ' . $nomVille . ' rassemble vendeurs, récolteurs et voyageurs autour des ventes courantes et des besoins immédiats de la ville.',
                    'interactions' => [
                        $creerInteraction('pnj_marche', 'Marchand du marché', '🧑', 24, 58, 'pnj', 'Le marchand du marché permettra de discuter, d’obtenir des rumeurs locales et de vendre rapidement certaines marchandises.'),
                        $creerInteraction('etal_vente', 'Étal de vente', '🧺', 56, 42, 'scene', 'Vous vous approchez des étals de vente du marché.', ['scene_cible' => 'etal']),
                        $creerInteraction('annonces_marche', 'Annonces', '📢', 82, 56, 'scene', 'Vous vous dirigez vers le panneau des annonces du marché.', ['scene_cible' => 'annonces']),
                    ],
                ],
                'etal' => [
                    'titre' => 'Étal de vente',
                    'sous_titre' => 'Marchandises courantes et échanges rapides',
                    'fond' => 'ressources/images/fonds_dialogue/Magasin_normal.png',
                    'description' => 'Vous êtes devant un étal où s’échangent provisions, petits objets et ressources locales.',
                    'interactions' => [
                        $creerInteraction('vendeur_etal', 'Vendeur', '🧑', 30, 56, 'pnj', 'Le vendeur vous renseigne sur les prix du moment et les produits disponibles.'),
                        $creerInteraction('acheter_etal', 'Acheter / vendre', '💰', 72, 44, 'action', 'Cette interface ouvrira plus tard le commerce rapide des biens courants.'),
                        $creerInteraction('discussion_etal', 'Parler', '💬', 50, 60, 'pnj', 'Le vendeur vous adresse quelques mots pendant que vous observez l’étal.'),
                        $creerInteraction('retour_etal', 'Retour accueil', '↩', 82, 86, 'retour_scene', 'Vous revenez à la place principale du marché.'),
                    ],
                ],
                'annonces' => [
                    'titre' => 'Annonces du marché',
                    'sous_titre' => 'Panneau public et besoins urgents',
                    'fond' => 'ressources/images/fonds_dialogue/Hall_guilde_marchande.png',
                    'description' => 'Le panneau des annonces regroupe les besoins urgents, petites demandes locales et occasions à saisir.',
                    'interactions' => [
                        $creerInteraction('lire_annonces', 'Lire les annonces', '📜', 38, 48, 'action', 'Cette zone affichera plus tard les annonces marchandes et besoins urgents de la ville.'),
                        $creerInteraction('responsable_annonces', 'Responsable', '👩', 70, 58, 'pnj', 'Le responsable peut vous orienter vers certaines opportunités commerciales.'),
                        $creerInteraction('discussion_annonces', 'Parler', '💬', 50, 60, 'pnj', 'Un responsable du panneau peut vous expliquer les annonces affichées ici.'),
                        $creerInteraction('retour_annonces', 'Retour accueil', '↩', 82, 86, 'retour_scene', 'Vous revenez à la place principale du marché.'),
                    ],
                ],
            ],
        ],
        'boutique' => [
            'titre' => 'Boutique',
            'sous_titre' => 'Vente simple et discussion avec le marchand',
            'fond' => 'ressources/images/fonds_dialogue/Magasin_normal.png',
            'description' => 'La boutique sert aux transactions directes avec un marchand local et à la vente des objets transportés par le joueur.',
            'interactions' => [
                $creerInteraction('pnj_boutique', 'Marchand', '🧑', 28, 58, 'pnj', 'Le marchand de la boutique permettra de discuter, de demander conseil et d’accéder au commerce local.'),
                $creerInteraction('vente_boutique', 'Vendre', '💰', 72, 42, 'action', 'Cette action servira à vendre vos objets directement à la boutique.'),
            ],
        ],
        'auberge' => [
            'titre' => 'Auberge',
            'sous_titre' => 'Accueil, repas et chambres louées',
            'fond' => 'ressources/images/fonds_dialogue/auberge/auberge_accueil.png',
            'description' => 'L’auberge accueille les voyageurs, nourrit les aventuriers fatigués et donne accès aux chambres déjà louées.',
            'scene_initiale' => 'accueil',
            'scenes' => [
                'accueil' => [
                    'titre' => 'Auberge',
                    'sous_titre' => 'Accueil, repas et chambres louées',
                    'fond' => 'ressources/images/fonds_dialogue/auberge/auberge_accueil.png',
                    'description' => 'L’auberge accueille les voyageurs, nourrit les aventuriers fatigués et donne accès aux chambres déjà louées.',
                    'interactions' => [
                        $creerInteraction('accueil_auberge', 'Accueil', '🛎', 22, 54, 'pnj', 'L’aubergiste permettra de discuter, d’obtenir des informations, d’acheter une chambre ou de gérer votre hébergement.'),
                        $creerInteraction('restaurant_auberge', 'Restaurant', '🍲', 52, 40, 'scene', 'Vous vous dirigez vers la salle du restaurant.', ['scene_cible' => 'restaurant']),
                        $creerInteraction('chambre_auberge', 'Chambre', '🛏', 78, 58, 'scene', 'Vous montez vers les chambres de l’auberge.', ['scene_cible' => 'chambre']),
                    ],
                ],
                'restaurant' => [
                    'titre' => 'Restaurant de l’auberge',
                    'sous_titre' => 'Repas chauds et discussions entre voyageurs',
                    'fond' => 'ressources/images/fonds_dialogue/auberge/auberge_resto.png',
                    'description' => 'La salle du restaurant est animée par les voyageurs, les repas servis et les rumeurs échangées à table.',
                    'interactions' => [
                        $creerInteraction('serveuse_auberge', 'Serveuse', '👩', 28, 54, 'pnj', 'La serveuse vous parle des plats du jour et des clients présents dans la salle.'),
                        $creerInteraction('commander_repas', 'Commander', '🍽', 72, 44, 'action', 'Cette action servira plus tard à manger pour reprendre des forces.'),
                        $creerInteraction('discussion_resto', 'Parler', '💬', 50, 60, 'pnj', 'Une personne présente dans la salle peut échanger quelques mots avec vous.'),
                        $creerInteraction('retour_resto', 'Retour accueil', '↩', 82, 86, 'retour_scene', 'Vous revenez à l’accueil de l’auberge.'),
                    ],
                ],
                'chambre' => [
                    'titre' => 'Chambre de l’auberge',
                    'sous_titre' => 'Repos, sommeil et espace personnel',
                    'fond' => 'ressources/images/fonds_dialogue/auberge/auberge_chambre.png',
                    'description' => 'Cette chambre permet de se reposer, de préparer son prochain départ et de retrouver un peu de calme.',
                    'interactions' => [
                        $creerInteraction('se_reposer', 'Se reposer', '😴', 38, 50, 'action', 'Cette action permettra plus tard de dormir et de restaurer vos ressources.'),
                        $creerInteraction('coffre_chambre', 'Coffre', '🧰', 72, 58, 'action', 'Un coffre personnel pourra être utilisé ici plus tard si la location le permet.'),
                        $creerInteraction('discussion_chambre', 'Parler', '💬', 50, 60, 'pnj', 'Vous prenez un instant pour réfléchir ou relire vos notes dans le calme de la chambre.'),
                        $creerInteraction('retour_chambre', 'Retour accueil', '↩', 82, 86, 'retour_scene', 'Vous revenez à l’accueil de l’auberge.'),
                    ],
                ],
            ],
        ],
        'herboristerie' => [
            'titre' => 'Herboristerie',
            'sous_titre' => 'Herbes, potions et arrière-salle discrète',
            'fond' => 'ressources/images/fonds_dialogue/herboriste.png',
            'description' => 'L’herboristerie permet d’échanger des plantes, des remèdes et parfois d’accéder à une arrière-salle liée à certaines quêtes.',
            'scene_initiale' => 'accueil',
            'scenes' => [
                'accueil' => [
                    'titre' => 'Herboristerie',
                    'sous_titre' => 'Herbes, potions et arrière-salle discrète',
                    'fond' => 'ressources/images/fonds_dialogue/herboriste.png',
                    'description' => 'L’herboristerie permet d’échanger des plantes, des remèdes et parfois d’accéder à une arrière-salle liée à certaines quêtes.',
                    'interactions' => [
                        $creerInteraction('pnj_herboriste', 'Herboriste', '🌿', 24, 56, 'pnj', 'L’herboriste permettra de discuter, de recevoir quelques indications et d’ouvrir certaines pistes liées à la nature ou aux soins.'),
                        $creerInteraction('achat_vente_herbes', 'Acheter / vendre', '🧪', 54, 38, 'action', 'Cette action servira à vendre ou acheter des herbes, composants et potions.'),
                        $creerInteraction('arriere_salle', 'Arrière-salle', '🚪', 82, 58, 'scene', 'Vous passez vers l’arrière-salle de l’herboristerie.', ['scene_cible' => 'serre']),
                    ],
                ],
                'serre' => [
                    'titre' => 'Serre de l’herboristerie',
                    'sous_titre' => 'Culture, remèdes et préparations',
                    'fond' => 'ressources/images/fonds_dialogue/herboriste_Serre.png',
                    'description' => 'La serre sert à faire pousser les plantes les plus précieuses et à préparer certains remèdes.',
                    'interactions' => [
                        $creerInteraction('discussion_serre', 'Parler', '💬', 50, 60, 'pnj', 'L’herboriste peut vous parler des plantes rares cultivées dans cette serre.'),
                        $creerInteraction('retour_serre', 'Retour accueil', '↩', 82, 86, 'retour_scene', 'Vous revenez à la boutique principale de l’herboristerie.'),
                    ],
                ],
            ],
        ],
        'poste_garde' => [
            'titre' => 'Poste de garde',
            'sous_titre' => 'Sécurité, prison et armurerie',
            'fond' => 'ressources/images/fonds_dialogue/armurerie.png',
            'description' => 'Le poste de garde centralise les discussions avec les gardes, l’accès à la prison et les équipements militaires conditionnels.',
            'scene_initiale' => 'accueil',
            'scenes' => [
                'accueil' => [
                    'titre' => 'Poste de garde',
                    'sous_titre' => 'Sécurité, prison et armurerie',
                    'fond' => 'ressources/images/fonds_dialogue/armurerie.png',
                    'description' => 'Le poste de garde centralise les discussions avec les gardes, l’accès à la prison et les équipements militaires conditionnels.',
                    'interactions' => [
                        $creerInteraction('garde_principal', 'Garde', '🛡', 22, 56, 'pnj', 'Le garde permettra de discuter de différentes choses, de demander des informations et d’obtenir certains accès liés à la ville.'),
                        $creerInteraction('prison_ville', 'Prison', '⛓', 52, 40, 'scene', 'Vous avancez vers la prison du poste de garde.', ['scene_cible' => 'prison']),
                        $creerInteraction('armurerie_ville', 'Armurerie', '⚔', 80, 58, 'scene', 'Vous vous dirigez vers l’armurerie de la garde.', ['scene_cible' => 'armurerie']),
                    ],
                ],
                'prison' => [
                    'titre' => 'Prison',
                    'sous_titre' => 'Cellules et surveillance',
                    'fond' => 'ressources/images/fonds_dialogue/Prison.png',
                    'description' => 'La prison regroupe les cellules, les prisonniers et les accès restreints de la ville.',
                    'interactions' => [
                        $creerInteraction('discussion_prison', 'Parler', '💬', 50, 60, 'pnj', 'Un garde en faction peut vous répondre brièvement sur l’état des cellules.'),
                        $creerInteraction('retour_prison', 'Retour accueil', '↩', 82, 86, 'retour_scene', 'Vous revenez à l’accueil du poste de garde.'),
                    ],
                ],
                'armurerie' => [
                    'titre' => 'Armurerie',
                    'sous_titre' => 'Équipement militaire et stockage',
                    'fond' => 'ressources/images/fonds_dialogue/Magasin_arme.png',
                    'description' => 'Cette armurerie stocke armes, protections et équipements réservés aux personnes autorisées.',
                    'interactions' => [
                        $creerInteraction('discussion_armurerie', 'Parler', '💬', 50, 60, 'pnj', 'Un responsable de l’armurerie peut vous donner quelques explications sur l’équipement rangé ici.'),
                        $creerInteraction('retour_armurerie', 'Retour accueil', '↩', 82, 86, 'retour_scene', 'Vous revenez à l’accueil du poste de garde.'),
                    ],
                ],
            ],
        ],
        'temple' => [
            'titre' => 'Temple',
            'sous_titre' => 'Prières, rituels et soins sacrés',
            'fond' => 'ressources/images/fonds_dialogue/Temple.png',
            'description' => 'Le temple d’Aeros est un lieu sacré où les fidèles consultent le prêtre, accomplissent des rituels et prennent soin des malades.',
            'scene_initiale' => 'accueil',
            'scenes' => [
                'accueil' => [
                    'titre' => 'Temple',
                    'sous_titre' => 'Prières, rituels et soins sacrés',
                    'fond' => 'ressources/images/fonds_dialogue/Temple.png',
                    'description' => 'Le temple d’Aeros est un lieu sacré où les fidèles consultent le prêtre, accomplissent des rituels et prennent soin des malades.',
                    'interactions' => [
                        $creerInteraction('prete_temple', 'Prêtre', '🙏', 24, 56, 'pnj', 'Le prêtre permettra de discuter, de recevoir des conseils spirituels et d’accéder à certaines quêtes ou bénédictions.'),
                        $creerInteraction('salle_rituels', 'Salle des rituels', '✨', 52, 38, 'scene', 'Vous entrez dans la salle des rituels du temple.', ['scene_cible' => 'rituels']),
                        $creerInteraction('hopital_temple', 'Malades', '🏥', 80, 58, 'scene', 'Vous avancez vers l’aile des malades du temple.', ['scene_cible' => 'malades']),
                    ],
                ],
                'rituels' => [
                    'titre' => 'Salle des rituels',
                    'sous_titre' => 'Cérémonies, purification et magie sacrée',
                    'fond' => 'ressources/images/fonds_dialogue/Chambre_rituelle.png',
                    'description' => 'Cette salle accueillera plus tard les rituels, bénédictions et événements spéciaux du temple.',
                    'interactions' => [
                        $creerInteraction('discussion_rituels', 'Parler', '💬', 50, 60, 'pnj', 'Un officiant peut vous parler des rites pratiqués dans cette salle.'),
                        $creerInteraction('retour_rituels', 'Retour accueil', '↩', 82, 86, 'retour_scene', 'Vous revenez à l’accueil du temple.'),
                    ],
                ],
                'malades' => [
                    'titre' => 'Aile des malades',
                    'sous_titre' => 'Soin, repos et assistance',
                    'fond' => 'ressources/images/fonds_dialogue/Hopital.png',
                    'description' => 'Cette aile fait office d’hôpital et de zone de soins pour les blessés, malades ou personnes à aider.',
                    'interactions' => [
                        $creerInteraction('discussion_malades', 'Parler', '💬', 50, 60, 'pnj', 'Un soignant ou un patient peut vous adresser quelques mots dans l’aile des malades.'),
                        $creerInteraction('retour_malades', 'Retour accueil', '↩', 82, 86, 'retour_scene', 'Vous revenez à l’accueil du temple.'),
                    ],
                ],
            ],
        ],
    ];

    if ($definitionPnjVille !== null) {
        $rolePnj = (string) ($definitionPnjVille['role'] ?? 'habitant');
        $descriptionPnj = (string) ($definitionPnjVille['description'] ?? ('Un habitant de ' . $nomVille . ' a peut-être quelque chose à vous apprendre.'));
        $texteRumeurs = (string) ($definitionPnjVille['texte_rumeurs'] ?? ('Cet habitant connaît des rumeurs locales, des bruits de rue et des pistes discrètes dans ' . $nomVille . '.'));
        $texteQuetes = (string) ($definitionPnjVille['texte_quetes'] ?? ('Cette personne peut lancer une quête, aider à en faire progresser une ou en recevoir le résultat selon votre avancement.'));

        $definitionsLieux[$idLieu] = [
            'titre' => $nomLieu,
            'sous_titre' => 'Discussion · ' . ucfirst($rolePnj),
            'fond' => 'ressources/images/fonds_dialogue/Marche.png',
            'description' => $descriptionPnj,
            'texte_interaction_initial' => $descriptionPnj . ' ' . $texteRumeurs,
            'interactions' => [],
        ];
    }

    $definition = $definitionsLieux[$idLieu] ?? [
        'titre' => $nomLieu,
        'sous_titre' => 'Lieu intérieur',
        'fond' => 'ressources/images/fonds_dialogue/fond_vide.png',
        'description' => 'Ce lieu est prêt à être enrichi avec des interactions supplémentaires.',
        'interactions' => [],
    ];

    $interactions = $definition['interactions'] ?? [];
    $interactions[] = $creerInteraction('retour_ville', 'Retour à ' . $nomVille, '↩', 50, 84, 'retour', 'Vous revenez à la vue générale de ' . $nomVille . '.');

    $scenes = [];
    if (!empty($definition['scenes']) && is_array($definition['scenes'])) {
        foreach ($definition['scenes'] as $identifiantScene => $scene) {
            $interactionsScene = $scene['interactions'] ?? [];
            $retourDejaPresent = false;

            foreach ($interactionsScene as $interactionScene) {
                if (($interactionScene['type'] ?? '') === 'retour') {
                    $retourDejaPresent = true;
                    break;
                }
            }

            if (!$retourDejaPresent) {
                $interactionsScene[] = $creerInteraction(
                    'retour_ville_scene_' . $identifiantScene,
                    'Retour à ' . $nomVille,
                    '↩',
                    50,
                    84,
                    'retour',
                    'Vous revenez à la vue générale de ' . $nomVille . '.'
                );
            }

            $scenes[$identifiantScene] = [
                'titre' => $scene['titre'] ?? $definition['titre'],
                'sous_titre' => $scene['sous_titre'] ?? $definition['sous_titre'],
                'fond' => $scene['fond'] ?? $definition['fond'],
                'description' => $scene['description'] ?? $definition['description'],
                'interactions' => $interactionsScene,
            ];
        }
    }

    return [
        'titre' => $definition['titre'],
        'sous_titre' => $definition['sous_titre'],
        'fond' => $definition['fond'],
        'description' => $definition['description'],
        'interactions' => $interactions,
        'scene_initiale' => $definition['scene_initiale'] ?? null,
        'scenes' => $scenes,
    ];
};

$creerConfigurationVille = static function (string $nomVille, string $imageJour, string $imageNuit, array $casesMonde, array $positions, array $pnjsSecondaires = [], bool $avecTemple = false): array {
    $pointsInterieur = [
        ['id' => 'guilde_aventuriers', 'nom' => 'Guilde des aventuriers', 'icone' => '⚔', 'x' => (float) ($positions['guilde_aventuriers'][0] ?? 30), 'y' => (float) ($positions['guilde_aventuriers'][1] ?? 25), 'categorie' => 'lieu'],
        ['id' => 'guilde_commerce', 'nom' => 'Guilde du commerce', 'icone' => '₵', 'x' => (float) ($positions['guilde_commerce'][0] ?? 70), 'y' => (float) ($positions['guilde_commerce'][1] ?? 24), 'categorie' => 'lieu'],
        ['id' => 'marche', 'nom' => 'Marché', 'icone' => '🛒', 'x' => (float) ($positions['marche'][0] ?? 50), 'y' => (float) ($positions['marche'][1] ?? 47), 'categorie' => 'lieu'],
        ['id' => 'boutique', 'nom' => 'Boutique', 'icone' => '🧰', 'x' => (float) ($positions['boutique'][0] ?? 26), 'y' => (float) ($positions['boutique'][1] ?? 52), 'categorie' => 'lieu'],
        ['id' => 'auberge', 'nom' => 'Auberge', 'icone' => '🛏', 'x' => (float) ($positions['auberge'][0] ?? 74), 'y' => (float) ($positions['auberge'][1] ?? 52), 'categorie' => 'lieu'],
        ['id' => 'herboristerie', 'nom' => 'Herboristerie', 'icone' => '🌿', 'x' => (float) ($positions['herboristerie'][0] ?? 31), 'y' => (float) ($positions['herboristerie'][1] ?? 78), 'categorie' => 'lieu'],
        ['id' => 'poste_garde', 'nom' => 'Poste de garde', 'icone' => '🛡', 'x' => (float) ($positions['poste_garde'][0] ?? 68), 'y' => (float) ($positions['poste_garde'][1] ?? 78), 'categorie' => 'lieu'],
    ];

    if ($avecTemple) {
        $pointsInterieur[] = ['id' => 'temple', 'nom' => 'Temple', 'icone' => '⛪', 'x' => (float) ($positions['temple'][0] ?? 50), 'y' => (float) ($positions['temple'][1] ?? 8), 'categorie' => 'lieu'];
    }

    foreach ($pnjsSecondaires as $pnjSecondaire) {
        $pointsInterieur[] = [
            'id' => (string) ($pnjSecondaire['id'] ?? ''),
            'nom' => (string) ($pnjSecondaire['nom'] ?? 'Habitant'),
            'icone' => (string) ($pnjSecondaire['icone'] ?? '🙂'),
            'x' => (float) ($pnjSecondaire['x'] ?? 50),
            'y' => (float) ($pnjSecondaire['y'] ?? 50),
            'categorie' => 'pnj_ville',
        ];
    }

    foreach (($positions['sorties'] ?? []) as $sortie) {
        $pointsInterieur[] = [
            'id' => (string) ($sortie['id'] ?? 'sortie'),
            'nom' => (string) ($sortie['nom'] ?? 'Sortie'),
            'icone' => (string) ($sortie['icone'] ?? '🚪'),
            'x' => (float) ($sortie['x'] ?? 50),
            'y' => (float) ($sortie['y'] ?? 50),
            'categorie' => 'sortie',
            'destination_x' => (int) ($sortie['destination_x'] ?? 0),
            'destination_y' => (int) ($sortie['destination_y'] ?? 0),
        ];
    }

    return [
        'nom' => $nomVille,
        'image_jour' => $imageJour,
        'image_nuit' => $imageNuit,
        'cases_monde' => $casesMonde,
        'points_interieur' => $pointsInterieur,
        'pnjs_secondaires' => $pnjsSecondaires,
    ];
};

$pnjsVersalis = [
    ['id' => 'pnj_ville_versalis_1', 'nom' => 'Mila la coursière', 'icone' => '🙂', 'x' => 42, 'y' => 20, 'role' => 'messagère', 'description' => 'Mila traverse sans cesse Versalis avec des lettres, des paquets et des nouvelles à demi murmurées.', 'texte_rumeurs' => 'Mila connaît souvent les dernières nouvelles, les petites urgences et les quêtes qui circulent avant d’être affichées.', 'texte_quetes' => 'Elle peut confier des livraisons, récupérer un objet pour quelqu’un ou valider certaines missions urbaines simples.'],
    ['id' => 'pnj_ville_versalis_2', 'nom' => 'Oren le charretier', 'icone' => '🧑', 'x' => 58, 'y' => 34, 'role' => 'charretier', 'description' => 'Oren passe son temps entre les entrepôts et la porte de la ville, toujours au courant des mouvements de marchandises.', 'texte_rumeurs' => 'Oren parle des cargaisons, des routes sûres et des ressources qui manquent dans les environs.', 'texte_quetes' => 'Il peut lancer des quêtes de transport, de récupération ou valider la remise d’un colis.'],
    ['id' => 'pnj_ville_versalis_3', 'nom' => 'Sera la fileuse', 'icone' => '👩', 'x' => 44, 'y' => 63, 'role' => 'artisan', 'description' => 'Sera travaille près des ateliers et remarque rapidement ce qui manque aux artisans du quartier.', 'texte_rumeurs' => 'Elle partage des rumeurs liées aux ateliers, aux commandes urgentes et aux besoins des habitants.', 'texte_quetes' => 'Elle peut demander des composants précis ou reprendre le résultat d’une petite mission artisanale.'],
    ['id' => 'pnj_ville_versalis_4', 'nom' => 'Bram le veilleur', 'icone' => '🧔', 'x' => 60, 'y' => 70, 'role' => 'veilleur', 'description' => 'Bram observe les allées et venues et repère vite les visiteurs inhabituels ou les tensions de quartier.', 'texte_rumeurs' => 'Bram connaît les rumeurs de sécurité, les disparitions et les problèmes dont la garde n’a pas encore parlé.', 'texte_quetes' => 'Il peut orienter vers des quêtes d’enquête, de surveillance ou confirmer une information sensible.'],
    ['id' => 'pnj_ville_versalis_5', 'nom' => 'Lina la rêveuse', 'icone' => '👧', 'x' => 50, 'y' => 54, 'role' => 'citadine', 'description' => 'Lina traîne près des places animées et capte de nombreux murmures qui échappent aux adultes pressés.', 'texte_rumeurs' => 'Elle relaie des rumeurs étranges, des légendes urbaines et des pistes inattendues.', 'texte_quetes' => 'Elle peut déclencher de petites quêtes secrètes ou orienter vers un lieu négligé.'],
];

$pnjsAqualis = [
    ['id' => 'pnj_ville_aqualis_1', 'nom' => 'Nerio le marin', 'icone' => '🧑', 'x' => 41, 'y' => 22, 'role' => 'marin', 'description' => 'Nerio connaît les arrivées de navires, les cargaisons et les zones dangereuses des environs maritimes.', 'texte_rumeurs' => 'Il partage des rumeurs sur les quais, les prises rares et les problèmes de navigation.', 'texte_quetes' => 'Il peut lancer des quêtes liées aux quais, aux filets, aux marchandises ou à la pêche.'],
    ['id' => 'pnj_ville_aqualis_2', 'nom' => 'Cyra la poissonnière', 'icone' => '👩', 'x' => 61, 'y' => 33, 'role' => 'marchande', 'description' => 'Cyra vend au marché mais garde toujours une oreille sur les demandes inhabituelles des voyageurs.', 'texte_rumeurs' => 'Elle signale les besoins en denrées, les prix instables et les visiteurs bizarres du port.', 'texte_quetes' => 'Elle peut lancer une quête d’approvisionnement ou reprendre une livraison.'],
    ['id' => 'pnj_ville_aqualis_3', 'nom' => 'Pavel le plongeur', 'icone' => '🙂', 'x' => 43, 'y' => 64, 'role' => 'plongeur', 'description' => 'Pavel récupère ce qui tombe à l’eau et connaît les recoins immergés autour de la ville.', 'texte_rumeurs' => 'Il parle d’objets perdus, de caches noyées et de mouvements suspects près des jetées.', 'texte_quetes' => 'Il peut initier des quêtes de récupération ou confirmer la fin d’une recherche aquatique.'],
    ['id' => 'pnj_ville_aqualis_4', 'nom' => 'Merea la guérisseuse', 'icone' => '👵', 'x' => 58, 'y' => 67, 'role' => 'guérisseuse', 'description' => 'Merea soigne les gens du port et entend nombre de confidences pendant qu’elle prépare ses remèdes.', 'texte_rumeurs' => 'Elle connaît les rumeurs sur les malades, les herbes rares et les passages secrets utilisés la nuit.', 'texte_quetes' => 'Elle peut ouvrir des quêtes de soin ou recevoir des composants rapportés.'],
    ['id' => 'pnj_ville_aqualis_5', 'nom' => 'Timo le mousse', 'icone' => '👦', 'x' => 52, 'y' => 50, 'role' => 'mousse', 'description' => 'Timo court partout et aperçoit bien des choses que les adultes ignorent.', 'texte_rumeurs' => 'Il remonte des rumeurs vives, parfois désordonnées, mais souvent utiles.', 'texte_quetes' => 'Il peut guider vers une quête cachée ou servir d’intermédiaire pour remettre un petit objet.'],
];

$pnjsPyros = [
    ['id' => 'pnj_ville_pyros_1', 'nom' => 'Doran le forgeron', 'icone' => '🧔', 'x' => 42, 'y' => 18, 'role' => 'forgeron', 'description' => 'Doran voit défiler aventuriers, gardes et mineurs dans son atelier brûlant.', 'texte_rumeurs' => 'Il partage des rumeurs sur les métaux, les convois et les tensions autour des fours.', 'texte_quetes' => 'Il peut confier des réparations, demander des matériaux ou récupérer des pièces forgées.'],
    ['id' => 'pnj_ville_pyros_2', 'nom' => 'Hina la laveuse', 'icone' => '👩', 'x' => 60, 'y' => 31, 'role' => 'ouvrière', 'description' => 'Hina travaille près des ateliers et connaît les soucis des habitants qui vivent au rythme des braises.', 'texte_rumeurs' => 'Elle relaie des rumeurs sur les quartiers chauds, les coupures d’approvisionnement et les disputes locales.', 'texte_quetes' => 'Elle peut lancer de petites quêtes d’entraide ou confirmer un service rendu.'],
    ['id' => 'pnj_ville_pyros_3', 'nom' => 'Kael le convoyeur', 'icone' => '🧑', 'x' => 45, 'y' => 61, 'role' => 'convoyeur', 'description' => 'Kael transporte minerais et outils entre les points sensibles de Pyros.', 'texte_rumeurs' => 'Il connaît les routes les plus dangereuses et les ressources que l’on attend avec impatience.', 'texte_quetes' => 'Il peut proposer des escortes, des livraisons ou récupérer des marchandises précieuses.'],
    ['id' => 'pnj_ville_pyros_4', 'nom' => 'Vessa la sentinelle', 'icone' => '🙂', 'x' => 61, 'y' => 63, 'role' => 'sentinelle', 'description' => 'Vessa surveille la discipline en ville et écoute ce qui se dit autour des postes de garde.', 'texte_rumeurs' => 'Elle possède des rumeurs de sécurité, d’ennemis potentiels et de tensions discrètes.', 'texte_quetes' => 'Elle peut orienter vers des missions de défense ou valider certains rapports.'],
    ['id' => 'pnj_ville_pyros_5', 'nom' => 'Nilo le gamin des braises', 'icone' => '👦', 'x' => 52, 'y' => 44, 'role' => 'enfant des rues', 'description' => 'Nilo surgit partout là où personne ne pense à regarder.', 'texte_rumeurs' => 'Il donne des rumeurs rapides sur les recoins oubliés, les cachettes et les adultes suspects.', 'texte_quetes' => 'Il peut lancer une quête secrète ou servir d’intermédiaire pour une remise discrète.'],
];

$pnjsAeros = [
    ['id' => 'pnj_ville_aeros_1', 'nom' => 'Elyne la novice', 'icone' => '👩', 'x' => 41, 'y' => 18, 'role' => 'novice', 'description' => 'Elyne sert au temple et croise autant les fidèles que les voyageurs en quête d’aide.', 'texte_rumeurs' => 'Elle murmure des rumeurs sur les malades, les rituels et les visiteurs inhabituels du temple.', 'texte_quetes' => 'Elle peut guider vers une quête spirituelle ou recueillir un objet pour le temple.'],
    ['id' => 'pnj_ville_aeros_2', 'nom' => 'Faren le chantre', 'icone' => '🧑', 'x' => 60, 'y' => 29, 'role' => 'chantre', 'description' => 'Faren circule entre les places d’Aeros et écoute ce que disent les pèlerins.', 'texte_rumeurs' => 'Il relaie les rumeurs importantes venues du haut de la ville et des voyageurs de passage.', 'texte_quetes' => 'Il peut lancer des quêtes liées aux pèlerins, aux cérémonies ou aux besoins du temple.'],
    ['id' => 'pnj_ville_aeros_3', 'nom' => 'Soline la guérisseuse', 'icone' => '👵', 'x' => 44, 'y' => 60, 'role' => 'guérisseuse', 'description' => 'Soline soigne les habitants et connaît les soucis cachés de nombreux foyers.', 'texte_rumeurs' => 'Elle partage des rumeurs sur les malades, les herbes rares et les urgences silencieuses.', 'texte_quetes' => 'Elle peut demander des soins, récupérer des remèdes ou orienter vers l’aile des malades.'],
    ['id' => 'pnj_ville_aeros_4', 'nom' => 'Rhel le veilleur', 'icone' => '🧔', 'x' => 63, 'y' => 58, 'role' => 'veilleur', 'description' => 'Rhel protège les hauteurs d’Aeros et remarque vite les allées et venues inhabituelles.', 'texte_rumeurs' => 'Il connaît les rumeurs de garde, les passages étroits et les incidents passés sous silence.', 'texte_quetes' => 'Il peut lancer des quêtes de surveillance ou reconnaître la réussite d’une mission discrète.'],
    ['id' => 'pnj_ville_aeros_5', 'nom' => 'Lysa la petite plume', 'icone' => '👧', 'x' => 52, 'y' => 42, 'role' => 'habitante', 'description' => 'Lysa observe beaucoup et parle franchement à ceux qui prennent le temps de l’écouter.', 'texte_rumeurs' => 'Elle fournit des rumeurs étonnantes sur la ville haute, les clochers et les secrets de famille.', 'texte_quetes' => 'Elle peut déclencher une quête cachée ou signaler qu’un objectif discret a été accompli.'],
];

$pnjsElementia = [
    ['id' => 'pnj_ville_elementia_1', 'nom' => 'Taren le scribe', 'icone' => '🧑', 'x' => 42, 'y' => 18, 'role' => 'scribe', 'description' => 'Taren note les faits importants et entend beaucoup de choses entre les institutions d’Elementia.', 'texte_rumeurs' => 'Il partage des rumeurs du centre du monde, des tensions politiques et des décisions à venir.', 'texte_quetes' => 'Il peut ouvrir des quêtes officielles, administratives ou de transmission d’informations.'],
    ['id' => 'pnj_ville_elementia_2', 'nom' => 'Maela la voyageuse', 'icone' => '👩', 'x' => 60, 'y' => 22, 'role' => 'voyageuse', 'description' => 'Maela passe d’une région à l’autre et rapporte toujours des nouvelles des quatre peuples.', 'texte_rumeurs' => 'Elle connaît des rumeurs régionales, des changements de marché et des problèmes d’itinéraires.', 'texte_quetes' => 'Elle peut lancer des quêtes de liaison entre régions ou confirmer la remise d’un message.'],
    ['id' => 'pnj_ville_elementia_3', 'nom' => 'Borel le jardinier', 'icone' => '🧔', 'x' => 45, 'y' => 66, 'role' => 'jardinier', 'description' => 'Borel entretient les abords du centre et voit passer tout le monde sans en avoir l’air.', 'texte_rumeurs' => 'Il dévoile des rumeurs paisibles en apparence mais souvent utiles sur les habitudes des habitants.', 'texte_quetes' => 'Il peut proposer une mission simple, demander de l’aide ou récupérer un objet discret.'],
    ['id' => 'pnj_ville_elementia_4', 'nom' => 'Seli la médiatrice', 'icone' => '🙂', 'x' => 62, 'y' => 68, 'role' => 'médiatrice', 'description' => 'Seli aide à calmer les tensions entre visiteurs et habitants.', 'texte_rumeurs' => 'Elle connaît les différends naissants, les alliances utiles et les personnes à contacter.', 'texte_quetes' => 'Elle peut lancer des quêtes de médiation, de dialogue ou valider une mission sociale.'],
    ['id' => 'pnj_ville_elementia_5', 'nom' => 'Nima la jeune guide', 'icone' => '👧', 'x' => 52, 'y' => 48, 'role' => 'guide', 'description' => 'Nima adore orienter les nouveaux venus dans la cité centrale.', 'texte_rumeurs' => 'Elle partage des rumeurs sur les lieux importants et les gens qui cherchent de l’aide.', 'texte_quetes' => 'Elle peut déclencher une petite quête d’introduction ou servir de lien vers un autre PNJ.'],
];

$configurationsVilles = [
    'versalis' => $creerConfigurationVille(
        'Versalis',
        'ressources/images/city/versalis_jours.png',
        'ressources/images/city/versalis_nuit.png',
        [
            ['x' => 11, 'y' => 6],
            ['x' => 12, 'y' => 6],
        ],
        [
            'guilde_aventuriers' => [30, 25],
            'guilde_commerce' => [70, 22],
            'marche' => [50, 47],
            'boutique' => [25, 50],
            'auberge' => [76, 50],
            'herboristerie' => [30, 78],
            'poste_garde' => [68, 80],
            'sorties' => [
                ['id' => 'porte_ouest', 'nom' => 'Porte ouest', 'icone' => '🚪', 'x' => 2, 'y' => 45, 'destination_x' => 10, 'destination_y' => 6],
                ['id' => 'porte_est', 'nom' => 'Porte est', 'icone' => '🚪', 'x' => 98, 'y' => 47, 'destination_x' => 13, 'destination_y' => 6],
                ['id' => 'porte_sud', 'nom' => 'Porte sud', 'icone' => '🚪', 'x' => 50, 'y' => 95, 'destination_x' => 11, 'destination_y' => 7],
            ],
        ],
        $pnjsVersalis
    ),
    'aqualis' => $creerConfigurationVille(
        'Aqualis',
        'ressources/images/city/aqualis_jours.png',
        'ressources/images/city/aqualis_nuit.png',
        [
            ['x' => 23, 'y' => 9],
            ['x' => 24, 'y' => 9],
        ],
        [
            'guilde_aventuriers' => [30, 25],
            'guilde_commerce' => [68, 25],
            'marche' => [50, 48],
            'boutique' => [26, 50],
            'auberge' => [74, 50],
            'herboristerie' => [31, 80],
            'poste_garde' => [69, 79],
            'sorties' => [
                ['id' => 'porte_ouest', 'nom' => 'Porte ouest', 'icone' => '🚪', 'x' => 6, 'y' => 33, 'destination_x' => 22, 'destination_y' => 9],
                ['id' => 'porte_est', 'nom' => 'Porte est', 'icone' => '🚪', 'x' => 90, 'y' => 40, 'destination_x' => 25, 'destination_y' => 9],
                ['id' => 'porte_sud', 'nom' => 'Porte sud', 'icone' => '🚪', 'x' => 40, 'y' => 85, 'destination_x' => 24, 'destination_y' => 10],
            ],
        ],
        $pnjsAqualis
    ),
    'pyros' => $creerConfigurationVille(
        'Pyros',
        'ressources/images/city/pyros_jours.png',
        'ressources/images/city/pyros_nuit.png',
        [
            ['x' => 16, 'y' => 18],
            ['x' => 16, 'y' => 19],
        ],
        [
            'guilde_aventuriers' => [30, 21],
            'guilde_commerce' => [69, 22],
            'marche' => [50, 46],
            'boutique' => [27, 50],
            'auberge' => [75, 50],
            'herboristerie' => [32, 75],
            'poste_garde' => [68, 75],
            'sorties' => [
                ['id' => 'porte_ouest', 'nom' => 'Porte ouest', 'icone' => '🚪', 'x' => 4, 'y' => 49, 'destination_x' => 29, 'destination_y' => 16],
                ['id' => 'porte_est', 'nom' => 'Porte est', 'icone' => '🚪', 'x' => 96, 'y' => 49, 'destination_x' => 32, 'destination_y' => 16],
                ['id' => 'porte_sud', 'nom' => 'Porte sud', 'icone' => '🚪', 'x' => 50, 'y' => 95, 'destination_x' => 30, 'destination_y' => 18],
            ],
        ],
        $pnjsPyros
    ),
    'aeros' => $creerConfigurationVille(
        'Aeros',
        'ressources/images/city/aeros_jours.png',
        'ressources/images/city/aeros_nuit.png',
        [
            ['x' => 30, 'y' => 16],
            ['x' => 31, 'y' => 16],
            ['x' => 30, 'y' => 17],
            ['x' => 31, 'y' => 17],
        ],
        [
            'guilde_aventuriers' => [30, 25],
            'guilde_commerce' => [70, 24],
            'marche' => [50, 47],
            'boutique' => [24, 50],
            'auberge' => [74, 45],
            'herboristerie' => [33, 68],
            'poste_garde' => [68, 68],
            'temple' => [50, 8],
            'sorties' => [
                ['id' => 'porte_ouest', 'nom' => 'Porte ouest', 'icone' => '🚪', 'x' => 13, 'y' => 70, 'destination_x' => 15, 'destination_y' => 18],
                ['id' => 'porte_est', 'nom' => 'Porte est', 'icone' => '🚪', 'x' => 87, 'y' => 70, 'destination_x' => 17, 'destination_y' => 18],
                ['id' => 'porte_sud', 'nom' => 'Porte sud', 'icone' => '🚪', 'x' => 50, 'y' => 86, 'destination_x' => 16, 'destination_y' => 20],
            ],
        ],
        $pnjsAeros,
        true
    ),
    'elementia' => $creerConfigurationVille(
        'Elementia',
        'ressources/images/city/elementia_jours.png',
        'ressources/images/city/elementia_nuit.png',
        [
            ['x' => 18, 'y' => 12],
            ['x' => 18, 'y' => 13],
        ],
        [
            'guilde_aventuriers' => [29, 21],
            'guilde_commerce' => [71, 21],
            'marche' => [50, 46],
            'boutique' => [26, 56],
            'auberge' => [74, 56],
            'herboristerie' => [31, 80],
            'poste_garde' => [68, 80],
            'sorties' => [
                ['id' => 'porte_ouest', 'nom' => 'Porte ouest', 'icone' => '🚪', 'x' => 4, 'y' => 49, 'destination_x' => 17, 'destination_y' => 12],
                ['id' => 'porte_est', 'nom' => 'Porte est', 'icone' => '🚪', 'x' => 96, 'y' => 49, 'destination_x' => 19, 'destination_y' => 12],
                ['id' => 'porte_sud', 'nom' => 'Porte sud', 'icone' => '🚪', 'x' => 50, 'y' => 95, 'destination_x' => 18, 'destination_y' => 14],
            ],
        ],
        $pnjsElementia
    ),
];

foreach ($configurationsVilles as $codeVille => &$configurationVille) {
    $configurationVille['lieux_interieurs'] = [];

    foreach (($configurationVille['points_interieur'] ?? []) as $pointInterieur) {
        $categoriePoint = (string) ($pointInterieur['categorie'] ?? '');
        if ($categoriePoint === 'sortie') {
            continue;
        }

        $identifiantLieu = (string) ($pointInterieur['id'] ?? '');
        $nomLieu = (string) ($pointInterieur['nom'] ?? 'Lieu');
        $definitionPnjVille = null;

        if ($categoriePoint === 'pnj_ville') {
            foreach (($configurationVille['pnjs_secondaires'] ?? []) as $pnjSecondaire) {
                if (($pnjSecondaire['id'] ?? '') === $identifiantLieu) {
                    $definitionPnjVille = $pnjSecondaire;
                    break;
                }
            }
        }

        $configurationVille['lieux_interieurs'][$identifiantLieu] = $creerLieuInterieur((string) $configurationVille['nom'], $identifiantLieu, $nomLieu, $definitionPnjVille);
    }
}
unset($configurationVille);

$pointsVilleMonde = [];
foreach ($configurationsVilles as $codeVille => $configurationVille) {
    foreach (($configurationVille['cases_monde'] ?? []) as $caseVille) {
        $pointsVilleMonde[] = [
            'code' => $codeVille,
            'nom' => $configurationVille['nom'],
            'x' => (float) ($caseVille['x'] ?? 0),
            'y' => (float) ($caseVille['y'] ?? 0),
        ];
    }
}
?>
<div class="zone-monde">
    <div
        id="zone-carte-monde"
        class="zone-carte-monde"
        data-taille-case="64"
        data-colonnes="40"
        data-lignes="27"
        data-colonne-depart="<?= (int) ($positionCarteJoueur['x'] ?? 18); ?>"
        data-ligne-depart="<?= (int) ($positionCarteJoueur['y'] ?? 12); ?>"
        data-largeur-monde="2534"
        data-hauteur-monde="1690"
    >
        <div class="carte-monde-viewport" id="carte-monde-viewport">
            <div class="carte-monde-camera" id="carte-monde-camera">
                <div class="carte-monde-contenu" id="carte-monde-contenu">
                    <img
                        id="image-carte-monde"
                        class="image-carte-monde"
                        src="ressources/images/carte/carte_du_monde.png"
                        alt="Carte du monde d’Elementia"
                        draggable="false"
                    >

                    <div class="grille-carte-monde" id="grille-carte-monde" aria-hidden="true"></div>
                    <div class="surbrillance-lieux-monde" id="surbrillance-lieux-monde" aria-hidden="true"></div>
                    <div class="surbrillance-deplacement-monde" id="surbrillance-deplacement-monde" aria-hidden="true"></div>

                    <div
                        class="repere-joueur-monde"
                        id="repere-joueur-monde"
                        aria-label="Position du joueur"
                        role="button"
                        tabindex="0"
                        title="Cliquer pour afficher les déplacements possibles"
                    >
                        <span class="repere-joueur-noyau"></span>
                        <span id="fleche-direction-quete" class="fleche-direction-joueur fleche-direction-quete" aria-hidden="true">➜</span>
                        <span id="fleche-direction-repere" class="fleche-direction-joueur fleche-direction-repere" aria-hidden="true">➜</span>
                    </div>
                </div>
            </div>

            <?php include __DIR__ . '/bloc_evenements.php'; ?>
        </div>
    </div>
</div>

<div id="superposition-ville" class="superposition-ville superposition-ville-cachee" aria-hidden="true">
    <div class="superposition-ville-entete">
        <div>
            <h2 id="titre-ville-active">Ville</h2>
            <p id="sous-titre-ville-active">Choisissez un lieu à visiter.</p>
        </div>
        <button type="button" id="bouton-fermer-ville" class="bouton-fermer-ville" aria-label="Fermer la ville">×</button>
    </div>

    <div class="superposition-ville-contenu">
        <img id="image-ville-active" class="image-ville-active" src="" alt="Vue de ville">
        <div id="calque-points-ville" class="calque-points-ville"></div>
    </div>

    <div id="fenetre-lieu-ville" class="fenetre-lieu-ville fenetre-lieu-ville-cachee" role="dialog" aria-modal="false" aria-labelledby="titre-lieu-ville">
        <div class="fenetre-lieu-ville-entete">
            <div class="titres-fenetre-lieu-ville">
                <h3 id="titre-lieu-ville">Lieu</h3>
                <p id="sous-titre-lieu-ville">Explorez le lieu et choisissez une interaction.</p>
            </div>
            <button type="button" id="bouton-fermer-lieu-ville" class="bouton-fermer-lieu-ville" aria-label="Fermer le lieu">×</button>
        </div>

        <div class="fenetre-lieu-ville-contenu">
            <div class="scene-lieu-ville">
                <img id="image-lieu-ville" class="image-lieu-ville" src="ressources/images/fonds_dialogue/fond_vide.png" alt="Décor du lieu" draggable="false">
                <div id="calque-interactions-lieu-ville" class="calque-interactions-lieu-ville"></div>
            </div>

            <div class="panneau-lieu-ville">
                <div style="margin-bottom:12px;">
                    <button
                        type="button"
                        id="bouton-retour-scene"
                        class="bouton-secondaire bouton-parametre-secondaire"
                        style="display:none; width:100%; min-height:44px; font-size:16px; font-weight:700;"
                    >Retour à l’accueil</button>
                </div>

                <p id="texte-lieu-ville" class="texte-lieu-ville">Ce lieu sera détaillé à l’étape suivante.</p>

                <div id="contenu-lieu-ville" class="contenu-lieu-ville">
                    <div class="bloc-placeholder-lieu-ville">
                        <strong>Interface du lieu</strong>
                        <p>Sélectionnez une interaction dans l’image pour afficher le panneau correspondant.</p>
                    </div>
                </div>

                <div class="encart-interaction-lieu-ville">
                    <strong id="titre-interaction-lieu-ville">Interaction</strong>
                    <p id="etat-interaction-lieu-ville">Cliquez sur une icône du lieu pour lancer une discussion ou une action.</p>
                </div>

                <div class="actions-lieu-ville">
                    <button type="button" id="bouton-retour-ville" class="bouton-secondaire bouton-parametre-secondaire">Retour à la ville</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script id="configuration-villes-jeu" type="application/json"><?= htmlspecialchars(json_encode([
    'villes' => $configurationsVilles,
    'points_monde' => $pointsVilleMonde,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8'); ?></script>
