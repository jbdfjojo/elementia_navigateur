<?php
$positionCarteJoueur = $carte['position_joueur'] ?? ['x' => (int) ($personnage['position_x'] ?? 18), 'y' => (int) ($personnage['position_y'] ?? 12)];

$configurationsVilles = [
    'versalis' => [
        'nom' => 'Versalis',
        'image_jour' => 'ressources/images/city/versalis_jours.png',
        'image_nuit' => 'ressources/images/city/versalis_nuit.png',
        'cases_monde' => [
            ['x' => 11, 'y' => 6],
            ['x' => 12, 'y' => 6],
        ],
        'points_interieur' => [
            ['id' => 'guilde_aventuriers', 'nom' => 'Guilde des aventuriers', 'icone' => '⚔', 'x' => 30, 'y' => 25, 'categorie' => 'lieu'],
            ['id' => 'guilde_commerce', 'nom' => 'Guilde du commerce', 'icone' => '₵', 'x' => 70, 'y' => 22, 'categorie' => 'lieu'],
            ['id' => 'marche', 'nom' => 'Marché', 'icone' => '🛒', 'x' => 50, 'y' => 47, 'categorie' => 'lieu'],
            ['id' => 'boutique', 'nom' => 'Boutique', 'icone' => '🧰', 'x' => 25, 'y' => 50, 'categorie' => 'lieu'],
            ['id' => 'auberge', 'nom' => 'Auberge', 'icone' => '🛏', 'x' => 76, 'y' => 50, 'categorie' => 'lieu'],
            ['id' => 'herboristerie', 'nom' => 'Herboristerie', 'icone' => '🌿', 'x' => 30, 'y' => 78, 'categorie' => 'lieu'],
            ['id' => 'poste_garde', 'nom' => 'Poste de garde', 'icone' => '🛡', 'x' => 68, 'y' => 80, 'categorie' => 'lieu'],
            ['id' => 'porte_ouest', 'nom' => 'Porte ouest', 'icone' => '🚪', 'x' => 2, 'y' => 45, 'categorie' => 'sortie', 'destination_x' => 10, 'destination_y' => 6],
            ['id' => 'porte_est', 'nom' => 'Porte est', 'icone' => '🚪', 'x' => 98, 'y' => 47, 'categorie' => 'sortie', 'destination_x' => 13, 'destination_y' => 6],
            ['id' => 'porte_sud', 'nom' => 'Porte sud', 'icone' => '🚪', 'x' => 50, 'y' => 95, 'categorie' => 'sortie', 'destination_x' => 11, 'destination_y' => 7],
        ],
    ],
    'aqualis' => [
        'nom' => 'Aqualis',
        'image_jour' => 'ressources/images/city/aqualis_jours.png',
        'image_nuit' => 'ressources/images/city/aqualis_nuit.png',
        'cases_monde' => [
            ['x' => 23, 'y' => 9],
            ['x' => 24, 'y' => 9],
        ],
        'points_interieur' => [
            ['id' => 'guilde_aventuriers', 'nom' => 'Guilde des aventuriers', 'icone' => '⚔', 'x' => 30, 'y' => 25, 'categorie' => 'lieu'],
            ['id' => 'guilde_commerce', 'nom' => 'Guilde du commerce', 'icone' => '₵', 'x' => 68, 'y' => 25, 'categorie' => 'lieu'],
            ['id' => 'marche', 'nom' => 'Marché', 'icone' => '🛒', 'x' => 50, 'y' => 48, 'categorie' => 'lieu'],
            ['id' => 'boutique', 'nom' => 'Boutique', 'icone' => '🧰', 'x' => 26, 'y' => 50, 'categorie' => 'lieu'],
            ['id' => 'auberge', 'nom' => 'Auberge', 'icone' => '🛏', 'x' => 74, 'y' => 50, 'categorie' => 'lieu'],
            ['id' => 'herboristerie', 'nom' => 'Herboristerie', 'icone' => '🌿', 'x' => 31, 'y' => 80, 'categorie' => 'lieu'],
            ['id' => 'poste_garde', 'nom' => 'Poste de garde', 'icone' => '🛡', 'x' => 69, 'y' => 79, 'categorie' => 'lieu'],
            ['id' => 'porte_ouest', 'nom' => 'Porte ouest', 'icone' => '🚪', 'x' => 6, 'y' => 33, 'categorie' => 'sortie', 'destination_x' => 22, 'destination_y' => 9],
            ['id' => 'porte_est', 'nom' => 'Porte est', 'icone' => '🚪', 'x' => 90, 'y' => 40, 'categorie' => 'sortie', 'destination_x' => 25, 'destination_y' => 9],
            ['id' => 'porte_sud', 'nom' => 'Porte sud', 'icone' => '🚪', 'x' => 40, 'y' => 85, 'categorie' => 'sortie', 'destination_x' => 24, 'destination_y' => 10],
        ],
    ],
    'pyros' => [
        'nom' => 'Pyros',
        'image_jour' => 'ressources/images/city/pyros_jours.png',
        'image_nuit' => 'ressources/images/city/pyros_nuit.png',
        'cases_monde' => [
			['x' => 16, 'y' => 18],
            ['x' => 16, 'y' => 19],
        ],
        'points_interieur' => [
            ['id' => 'guilde_aventuriers', 'nom' => 'Guilde des aventuriers', 'icone' => '⚔', 'x' => 30, 'y' => 21, 'categorie' => 'lieu'],
            ['id' => 'guilde_commerce', 'nom' => 'Guilde du commerce', 'icone' => '₵', 'x' => 69, 'y' => 22, 'categorie' => 'lieu'],
            ['id' => 'marche', 'nom' => 'Marché', 'icone' => '🛒', 'x' => 50, 'y' => 46, 'categorie' => 'lieu'],
            ['id' => 'boutique', 'nom' => 'Boutique', 'icone' => '🧰', 'x' => 27, 'y' => 50, 'categorie' => 'lieu'],
            ['id' => 'auberge', 'nom' => 'Auberge', 'icone' => '🛏', 'x' => 75, 'y' => 50, 'categorie' => 'lieu'],
            ['id' => 'herboristerie', 'nom' => 'Herboristerie', 'icone' => '🌿', 'x' => 32, 'y' => 75, 'categorie' => 'lieu'],
            ['id' => 'poste_garde', 'nom' => 'Poste de garde', 'icone' => '🛡', 'x' => 68, 'y' => 75, 'categorie' => 'lieu'],
            ['id' => 'porte_ouest', 'nom' => 'Porte ouest', 'icone' => '🚪', 'x' => 4, 'y' => 49, 'categorie' => 'sortie', 'destination_x' => 29, 'destination_y' => 16],
            ['id' => 'porte_est', 'nom' => 'Porte est', 'icone' => '🚪', 'x' => 96, 'y' => 49, 'categorie' => 'sortie', 'destination_x' => 32, 'destination_y' => 16],
            ['id' => 'porte_sud', 'nom' => 'Porte sud', 'icone' => '🚪', 'x' => 50, 'y' => 95, 'categorie' => 'sortie', 'destination_x' => 30, 'destination_y' => 18],
        ],
    ],
    'aeros' => [
        'nom' => 'Aeros',
        'image_jour' => 'ressources/images/city/aeros_jours.png',
        'image_nuit' => 'ressources/images/city/aeros_nuit.png',
        'cases_monde' => [
			['x' => 30, 'y' => 16],
            ['x' => 31, 'y' => 16],
            ['x' => 30, 'y' => 17],
            ['x' => 31, 'y' => 17],
        ],
        'points_interieur' => [
            ['id' => 'guilde_aventuriers', 'nom' => 'Guilde des aventuriers', 'icone' => '⚔', 'x' => 30, 'y' => 25, 'categorie' => 'lieu'],
            ['id' => 'guilde_commerce', 'nom' => 'Guilde du commerce', 'icone' => '₵', 'x' => 70, 'y' => 24, 'categorie' => 'lieu'],
            ['id' => 'marche', 'nom' => 'Marché', 'icone' => '🛒', 'x' => 50, 'y' => 47, 'categorie' => 'lieu'],
            ['id' => 'boutique', 'nom' => 'Boutique', 'icone' => '🧰', 'x' => 24, 'y' => 50, 'categorie' => 'lieu'],
            ['id' => 'auberge', 'nom' => 'Auberge', 'icone' => '🛏', 'x' => 74, 'y' => 45, 'categorie' => 'lieu'],
            ['id' => 'herboristerie', 'nom' => 'Herboristerie', 'icone' => '🌿', 'x' => 33, 'y' => 68, 'categorie' => 'lieu'],
            ['id' => 'poste_garde', 'nom' => 'Poste de garde', 'icone' => '🛡', 'x' => 68, 'y' => 68, 'categorie' => 'lieu'],
            ['id' => 'porte_ouest', 'nom' => 'Porte ouest', 'icone' => '🚪', 'x' => 13, 'y' => 70, 'categorie' => 'sortie', 'destination_x' => 15, 'destination_y' => 18],
            ['id' => 'porte_est', 'nom' => 'Porte est', 'icone' => '🚪', 'x' => 87, 'y' => 70, 'categorie' => 'sortie', 'destination_x' => 17, 'destination_y' => 18],
            ['id' => 'porte_sud', 'nom' => 'Porte sud', 'icone' => '🚪', 'x' => 50, 'y' => 86, 'categorie' => 'sortie', 'destination_x' => 16, 'destination_y' => 20],
        ],
    ],
    'elementia' => [
        'nom' => 'Elementia',
        'image_jour' => 'ressources/images/city/elementia_jours.png',
        'image_nuit' => 'ressources/images/city/elementia_nuit.png',
        'cases_monde' => [
            ['x' => 18, 'y' => 12],
            ['x' => 18, 'y' => 13],
        ],
        'points_interieur' => [
            ['id' => 'guilde_aventuriers', 'nom' => 'Guilde des aventuriers', 'icone' => '⚔', 'x' => 29, 'y' => 21, 'categorie' => 'lieu'],
            ['id' => 'guilde_commerce', 'nom' => 'Guilde du commerce', 'icone' => '₵', 'x' => 71, 'y' => 21, 'categorie' => 'lieu'],
            ['id' => 'marche', 'nom' => 'Marché', 'icone' => '🛒', 'x' => 50, 'y' => 46, 'categorie' => 'lieu'],
            ['id' => 'boutique', 'nom' => 'Boutique', 'icone' => '🧰', 'x' => 26, 'y' => 56, 'categorie' => 'lieu'],
            ['id' => 'auberge', 'nom' => 'Auberge', 'icone' => '🛏', 'x' => 74, 'y' => 56, 'categorie' => 'lieu'],
            ['id' => 'herboristerie', 'nom' => 'Herboristerie', 'icone' => '🌿', 'x' => 31, 'y' => 80, 'categorie' => 'lieu'],
            ['id' => 'poste_garde', 'nom' => 'Poste de garde', 'icone' => '🛡', 'x' => 68, 'y' => 80, 'categorie' => 'lieu'],
            ['id' => 'porte_ouest', 'nom' => 'Porte ouest', 'icone' => '🚪', 'x' => 4, 'y' => 49, 'categorie' => 'sortie', 'destination_x' => 17, 'destination_y' => 12],
            ['id' => 'porte_est', 'nom' => 'Porte est', 'icone' => '🚪', 'x' => 96, 'y' => 49, 'categorie' => 'sortie', 'destination_x' => 19, 'destination_y' => 12],
            ['id' => 'porte_sud', 'nom' => 'Porte sud', 'icone' => '🚪', 'x' => 50, 'y' => 95, 'categorie' => 'sortie', 'destination_x' => 18, 'destination_y' => 14],
        ],
    ],
];

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
            <h3 id="titre-lieu-ville">Lieu</h3>
            <button type="button" id="bouton-fermer-lieu-ville" class="bouton-fermer-lieu-ville" aria-label="Fermer le lieu">×</button>
        </div>
        <p id="texte-lieu-ville">Ce lieu sera détaillé à l’étape suivante.</p>
        <div class="actions-lieu-ville">
            <button type="button" id="bouton-retour-ville" class="bouton-secondaire bouton-parametre-secondaire">Retour à la ville</button>
        </div>
    </div>
</div>

<script id="configuration-villes-jeu" type="application/json"><?= htmlspecialchars(json_encode([
    'villes' => $configurationsVilles,
    'points_monde' => $pointsVilleMonde,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8'); ?></script>
