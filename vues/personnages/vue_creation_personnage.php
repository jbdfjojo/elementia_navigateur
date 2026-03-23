<?php
// ---------------------------------------------------------
// Initialisation de la session de création personnage
// ---------------------------------------------------------
$creation = $_SESSION['creation_personnage'] ?? [
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

// ---------------------------------------------------------
// Lecture de l’étape en cours
// ---------------------------------------------------------
$etape = (int) ($creation['etape'] ?? 1);

// ---------------------------------------------------------
// Préparation des données d’affichage
// ---------------------------------------------------------
$element_choisi = (string) ($creation['element'] ?? '');
$classe_choisie = (string) ($creation['classe'] ?? '');

$classes_disponibles = [];
if ($element_choisi !== '') {
    $classes_disponibles = Routeur::obtenirClassesParElement($element_choisi);
}

$competences_elementaires = [];
if ($element_choisi !== '' && $classe_choisie !== '') {
    $competences_elementaires = Routeur::obtenirCompetencesElementairesCatalogue(
        $connexion_base,
        $element_choisi,
        $classe_choisie
    );
}

$competences_neutres = Routeur::obtenirCompetencesNeutresCatalogue($connexion_base);
$avatars = Routeur::obtenirAvatarsFictifs();
$suggestion = Routeur::obtenirSuggestionStatistiques($classe_choisie);

// ---------------------------------------------------------
// Pré-remplissage intelligent des statistiques
// ---------------------------------------------------------
$statistiques_actuelles = $creation['statistiques'] ?? [];

$total_statistiques_actuelles = 0;

foreach ($statistiques_actuelles as $valeur_statistique_actuelle) {
    $total_statistiques_actuelles += (int) $valeur_statistique_actuelle;
}

$statistiques_affichees = [];

if ($total_statistiques_actuelles > 0) {
    $statistiques_affichees = [
        'point_de_vie' => (int) ($statistiques_actuelles['point_de_vie'] ?? 0),
        'attaque' => (int) ($statistiques_actuelles['attaque'] ?? 0),
        'magie' => (int) ($statistiques_actuelles['magie'] ?? 0),
        'agilite' => (int) ($statistiques_actuelles['agilite'] ?? 0),
        'intelligence' => (int) ($statistiques_actuelles['intelligence'] ?? 0),
        'synchronisation_elementaire' => (int) ($statistiques_actuelles['synchronisation_elementaire'] ?? 0),
        'critique' => (int) ($statistiques_actuelles['critique'] ?? 0),
        'dexterite' => (int) ($statistiques_actuelles['dexterite'] ?? 0),
        'defense' => (int) ($statistiques_actuelles['defense'] ?? 0)
    ];
} else {
    $statistiques_affichees = [
        'point_de_vie' => (int) ($suggestion['point_de_vie'] ?? 0),
        'attaque' => (int) ($suggestion['attaque'] ?? 0),
        'magie' => (int) ($suggestion['magie'] ?? 0),
        'agilite' => (int) ($suggestion['agilite'] ?? 0),
        'intelligence' => (int) ($suggestion['intelligence'] ?? 0),
        'synchronisation_elementaire' => (int) ($suggestion['synchronisation_elementaire'] ?? 0),
        'critique' => (int) ($suggestion['critique'] ?? 0),
        'dexterite' => (int) ($suggestion['dexterite'] ?? 0),
        'defense' => (int) ($suggestion['defense'] ?? 0)
    ];
}
?>
<div class="bloc-formulaire">
    <div class="zone-entete-creation">
        <h2>Création du personnage</h2>

        <form method="post" action="index.php" class="formulaire-avec-chargement zone-annulation-creation">
            <input type="hidden" name="action" value="retour_selection_personnage">
            <button type="submit" class="bouton-secondaire">Quitter la création</button>
        </form>
    </div>

    <div class="barre-etapes-creation">
        <div class="etape-creation <?= $etape >= 1 ? 'active' : ''; ?>">1. Élément</div>
        <div class="etape-creation <?= $etape >= 2 ? 'active' : ''; ?>">2. Classe</div>
        <div class="etape-creation <?= $etape >= 3 ? 'active' : ''; ?>">3. Compétences élémentaires</div>
        <div class="etape-creation <?= $etape >= 4 ? 'active' : ''; ?>">4. Compétences neutres</div>
        <div class="etape-creation <?= $etape >= 5 ? 'active' : ''; ?>">5. Identité et statistiques</div>
    </div>

    <?php if ($etape === 1) : ?>
        <p class="texte-explicatif">
            Choisissez le type élémentaire que votre personnage incarnera.
            Ce choix détermine aussi la région de départ.
        </p>

        <form method="post" action="index.php" class="formulaire-avec-chargement">
            <input type="hidden" name="action" value="creation_personnage_etape_1">

            <div class="grille-choix-cartes">
                <label class="carte-choix-element element-feu">
                    <input type="radio" name="element" value="Feu" <?= $element_choisi === 'Feu' ? 'checked' : ''; ?> required>
                    <span class="icone-element">🔥</span>
                    <strong>Feu</strong>
                    <small>Région : <?= htmlspecialchars(Routeur::obtenirRegionDepartParElement('Feu'), ENT_QUOTES, 'UTF-8'); ?></small>
                </label>

                <label class="carte-choix-element element-eau">
                    <input type="radio" name="element" value="Eau" <?= $element_choisi === 'Eau' ? 'checked' : ''; ?> required>
                    <span class="icone-element">💧</span>
                    <strong>Eau</strong>
                    <small>Région : <?= htmlspecialchars(Routeur::obtenirRegionDepartParElement('Eau'), ENT_QUOTES, 'UTF-8'); ?></small>
                </label>

                <label class="carte-choix-element element-air">
                    <input type="radio" name="element" value="Air" <?= $element_choisi === 'Air' ? 'checked' : ''; ?> required>
                    <span class="icone-element">🌪</span>
                    <strong>Air</strong>
                    <small>Région : <?= htmlspecialchars(Routeur::obtenirRegionDepartParElement('Air'), ENT_QUOTES, 'UTF-8'); ?></small>
                </label>

                <label class="carte-choix-element element-terre">
                    <input type="radio" name="element" value="Terre" <?= $element_choisi === 'Terre' ? 'checked' : ''; ?> required>
                    <span class="icone-element">🌿</span>
                    <strong>Terre</strong>
                    <small>Région : <?= htmlspecialchars(Routeur::obtenirRegionDepartParElement('Terre'), ENT_QUOTES, 'UTF-8'); ?></small>
                </label>
            </div>

            <button type="submit">Valider l’élément</button>
        </form>

    <?php elseif ($etape === 2) : ?>
        <p class="texte-explicatif">
            Élément choisi : <strong><?= htmlspecialchars($element_choisi, ENT_QUOTES, 'UTF-8'); ?></strong>
            — Région de départ : <strong><?= htmlspecialchars((string) ($creation['region_depart'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></strong>
        </p>

        <form method="post" action="index.php" class="formulaire-avec-chargement">
            <input type="hidden" name="action" value="creation_personnage_etape_2">

            <div class="grille-choix-cartes">
                <?php foreach ($classes_disponibles as $nom_classe => $description_classe) : ?>
                    <label class="carte-choix-classe">
                        <input
                            type="radio"
                            name="classe"
                            value="<?= htmlspecialchars($nom_classe, ENT_QUOTES, 'UTF-8'); ?>"
                            <?= $classe_choisie === $nom_classe ? 'checked' : ''; ?>
                            required
                        >
                        <strong><?= htmlspecialchars($nom_classe, ENT_QUOTES, 'UTF-8'); ?></strong>
                        <small><?= htmlspecialchars($description_classe, ENT_QUOTES, 'UTF-8'); ?></small>
                    </label>
                <?php endforeach; ?>
            </div>

            <button type="submit">Valider la classe</button>
        </form>

        <form method="post" action="index.php" class="formulaire-secondaire formulaire-avec-chargement">
            <input type="hidden" name="action" value="creation_personnage_retour_etape_1">
            <button type="submit" class="bouton-secondaire">Retour à l’étape précédente</button>
        </form>

    <?php elseif ($etape === 3) : ?>
        <p class="texte-explicatif">
            Choisissez exactement <strong>4 compétences élémentaires</strong> parmi les 10 proposées.
        </p>

        <p class="texte-explicatif">
            Élément : <strong><?= htmlspecialchars($element_choisi, ENT_QUOTES, 'UTF-8'); ?></strong>
            — Classe : <strong><?= htmlspecialchars($classe_choisie, ENT_QUOTES, 'UTF-8'); ?></strong>
        </p>

        <div id="compteur-competences-elementaires" class="compteur-selection">
            0 / 4 compétence(s) élémentaire(s) sélectionnée(s)
        </div>

        <form method="post" action="index.php" class="formulaire-avec-chargement formulaire-limite-choix" data-max-selection="4">
            <input type="hidden" name="action" value="creation_personnage_etape_3">

            <div class="grille-competences">
                <?php foreach ($competences_elementaires as $competence) : ?>
                    <label class="carte-competence">
                        <input
                            type="checkbox"
                            name="competences_elementaires[]"
                            value="<?= htmlspecialchars((string) $competence['code_competence'], ENT_QUOTES, 'UTF-8'); ?>"
                            <?= in_array((string) $competence['code_competence'], $creation['competences_elementaires'] ?? [], true) ? 'checked' : ''; ?>
                        >
                        <strong><?= htmlspecialchars((string) $competence['nom'], ENT_QUOTES, 'UTF-8'); ?></strong>
                        <small><?= htmlspecialchars((string) $competence['resume'], ENT_QUOTES, 'UTF-8'); ?></small>
                        <small>Coût : <?= (int) ($competence['cout_utilisation'] ?? 0); ?> — <?= htmlspecialchars((string) ($competence['ressource_utilisee'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></small>
                    </label>
                <?php endforeach; ?>
            </div>

            <p class="texte-explicatif">
                Ce choix est définitif. Pour modifier une compétence plus tard, il faudra consulter un maître spécialisé.
            </p>

            <button type="submit">Valider les compétences élémentaires</button>
        </form>

        <form method="post" action="index.php" class="formulaire-secondaire formulaire-avec-chargement">
            <input type="hidden" name="action" value="creation_personnage_retour_etape_2">
            <button type="submit" class="bouton-secondaire">Retour à l’étape précédente</button>
        </form>

    <?php elseif ($etape === 4) : ?>
        <p class="texte-explicatif">
            Choisissez exactement <strong>3 compétences neutres</strong> parmi les 10 proposées.
        </p>

        <div id="compteur-competences-neutres" class="compteur-selection">
            0 / 3 compétence(s) neutre(s) sélectionnée(s)
        </div>

        <form method="post" action="index.php" class="formulaire-avec-chargement formulaire-limite-choix" data-max-selection="3">
            <input type="hidden" name="action" value="creation_personnage_etape_4">

            <div class="grille-competences">
                <?php foreach ($competences_neutres as $competence) : ?>
                    <label class="carte-competence">
                        <input
                            type="checkbox"
                            name="competences_neutres[]"
                            value="<?= htmlspecialchars((string) $competence['code_competence'], ENT_QUOTES, 'UTF-8'); ?>"
                            <?= in_array((string) $competence['code_competence'], $creation['competences_neutres'] ?? [], true) ? 'checked' : ''; ?>
                        >
                        <strong><?= htmlspecialchars((string) $competence['nom'], ENT_QUOTES, 'UTF-8'); ?></strong>
                        <small><?= htmlspecialchars((string) $competence['resume'], ENT_QUOTES, 'UTF-8'); ?></small>
                        <small>Progression : <?= htmlspecialchars((string) ($competence['declencheur_progression'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></small>
                    </label>
                <?php endforeach; ?>
            </div>

            <p class="texte-explicatif">
                Ce choix est définitif. Vous pourrez les remplacer plus tard uniquement via un maître spécialisé.
            </p>

            <button type="submit">Valider les compétences neutres</button>
        </form>

        <form method="post" action="index.php" class="formulaire-secondaire formulaire-avec-chargement">
            <input type="hidden" name="action" value="creation_personnage_retour_etape_3">
            <button type="submit" class="bouton-secondaire">Retour à l’étape précédente</button>
        </form>

    <?php else : ?>
        <p class="texte-explicatif">
            Renseignez l’identité finale du personnage et répartissez <strong>exactement 30 points</strong> dans ses statistiques.
        </p>

        <div class="bloc-suggestion">
            <h3>Suggestion automatique pour la classe <?= htmlspecialchars($classe_choisie, ENT_QUOTES, 'UTF-8'); ?></h3>

            <div class="grille-suggestion">
                <?php foreach ($suggestion as $nom_statistique => $valeur_statistique) : ?>
                    <div class="ligne-suggestion">
                        <span><?= htmlspecialchars(str_replace('_', ' ', $nom_statistique), ENT_QUOTES, 'UTF-8'); ?></span>
                        <strong><?= (int) $valeur_statistique; ?></strong>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <form method="post" action="index.php" class="formulaire-avec-chargement formulaire-statistiques">
            <input type="hidden" name="action" value="creation_personnage_etape_5">

            <label for="nom_personnage">Nom du personnage</label>
            <input type="text" id="nom_personnage" name="nom_personnage" maxlength="50" value="<?= htmlspecialchars((string) ($creation['nom'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required>

            <label for="sexe">Sexe</label>
            <select id="sexe" name="sexe" required>
                <option value="">Choisir</option>
                <option value="homme" <?= ($creation['sexe'] ?? '') === 'homme' ? 'selected' : ''; ?>>Homme</option>
                <option value="femme" <?= ($creation['sexe'] ?? '') === 'femme' ? 'selected' : ''; ?>>Femme</option>
            </select>

            <label>Choix de l’avatar</label>
            <div id="grille-avatars" class="grille-avatars">
                <?php foreach ($avatars as $avatar) : ?>
                    <label class="carte-avatar" data-sexe="<?= htmlspecialchars((string) $avatar['sexe'], ENT_QUOTES, 'UTF-8'); ?>">
                        <input
                            type="radio"
                            name="avatar"
                            value="<?= htmlspecialchars((string) $avatar['identifiant'], ENT_QUOTES, 'UTF-8'); ?>"
                            <?= ($creation['avatar'] ?? '') === $avatar['identifiant'] ? 'checked' : ''; ?>
                        >
                        <div class="cadre-avatar-image">
                            <img
                                src="<?= htmlspecialchars((string) $avatar['image'], ENT_QUOTES, 'UTF-8'); ?>"
                                alt="<?= htmlspecialchars((string) $avatar['nom'], ENT_QUOTES, 'UTF-8'); ?>"
                                class="image-avatar"
                            >
                        </div>
                        <strong><?= htmlspecialchars((string) $avatar['nom'], ENT_QUOTES, 'UTF-8'); ?></strong>
                    </label>
                <?php endforeach; ?>
            </div>

            <div id="compteur-statistiques" class="compteur-statistiques">
                Total utilisé : 0 / 30
            </div>

            <div class="grille-statistiques">
                <div class="champ-statistique">
                    <label for="point_de_vie">Point de vie</label>
                    <input type="number" id="point_de_vie" name="point_de_vie" min="0" step="1" inputmode="none" onkeydown="return false;" onpaste="return false;" ondrop="return false;" value="<?= (int) ($statistiques_affichees['point_de_vie'] ?? 0); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="attaque">Attaque</label>
                    <input type="number" id="attaque" name="attaque" min="0" step="1" inputmode="none" onkeydown="return false;" onpaste="return false;" ondrop="return false;" value="<?= (int) ($statistiques_affichees['attaque'] ?? 0); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="magie">Magie</label>
                    <input type="number" id="magie" name="magie" min="0" step="1" inputmode="none" onkeydown="return false;" onpaste="return false;" ondrop="return false;" value="<?= (int) ($statistiques_affichees['magie'] ?? 0); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="agilite">Agilité</label>
                    <input type="number" id="agilite" name="agilite" min="0" step="1" inputmode="none" onkeydown="return false;" onpaste="return false;" ondrop="return false;" value="<?= (int) ($statistiques_affichees['agilite'] ?? 0); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="intelligence">Intelligence</label>
                    <input type="number" id="intelligence" name="intelligence" min="0" step="1" inputmode="none" onkeydown="return false;" onpaste="return false;" ondrop="return false;" value="<?= (int) ($statistiques_affichees['intelligence'] ?? 0); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="synchronisation_elementaire">Synchronisation élémentaire</label>
                    <input type="number" id="synchronisation_elementaire" name="synchronisation_elementaire" min="0" step="1" inputmode="none" onkeydown="return false;" onpaste="return false;" ondrop="return false;" value="<?= (int) ($statistiques_affichees['synchronisation_elementaire'] ?? 0); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="critique">Critique</label>
                    <input type="number" id="critique" name="critique" min="0" step="1" inputmode="none" onkeydown="return false;" onpaste="return false;" ondrop="return false;" value="<?= (int) ($statistiques_affichees['critique'] ?? 0); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="dexterite">Dextérité</label>
                    <input type="number" id="dexterite" name="dexterite" min="0" step="1" inputmode="none" onkeydown="return false;" onpaste="return false;" ondrop="return false;" value="<?= (int) ($statistiques_affichees['dexterite'] ?? 0); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="defense">Défense</label>
                    <input type="number" id="defense" name="defense" min="0" step="1" inputmode="none" onkeydown="return false;" onpaste="return false;" ondrop="return false;" value="<?= (int) ($statistiques_affichees['defense'] ?? 0); ?>" required>
                </div>
            </div>

            <button type="submit">Créer le personnage</button>
        </form>

        <form method="post" action="index.php" class="formulaire-secondaire formulaire-avec-chargement">
            <input type="hidden" name="action" value="creation_personnage_retour_etape_4">
            <button type="submit" class="bouton-secondaire">Retour à l’étape précédente</button>
        </form>
    <?php endif; ?>
</div>
