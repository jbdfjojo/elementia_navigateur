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
$competences_elementaires = [];
if (($creation['element'] ?? '') !== '' && ($creation['classe'] ?? '') !== '') {
    $competences_elementaires = Routeur::obtenirCompetencesElementairesFictives(
        (string) $creation['element'],
        (string) $creation['classe']
    );
}

$competences_neutres = Routeur::obtenirCompetencesNeutresFictives();
$avatars = Routeur::obtenirAvatarsFictifs();
$suggestion = Routeur::obtenirSuggestionStatistiques((string) ($creation['classe'] ?? 'DPS'));
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
                    <input type="radio" name="element" value="Feu" <?= ($creation['element'] ?? '') === 'Feu' ? 'checked' : ''; ?> required>
                    <span class="icone-element">🔥</span>
                    <strong>Feu</strong>
                    <small>Région : <?= htmlspecialchars(Routeur::obtenirRegionDepartParElement('Feu'), ENT_QUOTES, 'UTF-8'); ?></small>
                </label>

                <label class="carte-choix-element element-eau">
                    <input type="radio" name="element" value="Eau" <?= ($creation['element'] ?? '') === 'Eau' ? 'checked' : ''; ?> required>
                    <span class="icone-element">💧</span>
                    <strong>Eau</strong>
                    <small>Région : <?= htmlspecialchars(Routeur::obtenirRegionDepartParElement('Eau'), ENT_QUOTES, 'UTF-8'); ?></small>
                </label>

                <label class="carte-choix-element element-air">
                    <input type="radio" name="element" value="Air" <?= ($creation['element'] ?? '') === 'Air' ? 'checked' : ''; ?> required>
                    <span class="icone-element">🌪</span>
                    <strong>Air</strong>
                    <small>Région : <?= htmlspecialchars(Routeur::obtenirRegionDepartParElement('Air'), ENT_QUOTES, 'UTF-8'); ?></small>
                </label>

                <label class="carte-choix-element element-terre">
                    <input type="radio" name="element" value="Terre" <?= ($creation['element'] ?? '') === 'Terre' ? 'checked' : ''; ?> required>
                    <span class="icone-element">🌿</span>
                    <strong>Terre</strong>
                    <small>Région : <?= htmlspecialchars(Routeur::obtenirRegionDepartParElement('Terre'), ENT_QUOTES, 'UTF-8'); ?></small>
                </label>
            </div>

            <button type="submit">Valider l’élément</button>
        </form>

    <?php elseif ($etape === 2) : ?>
        <p class="texte-explicatif">
            Élément choisi : <strong><?= htmlspecialchars((string) $creation['element'], ENT_QUOTES, 'UTF-8'); ?></strong>
            — Région de départ : <strong><?= htmlspecialchars((string) $creation['region_depart'], ENT_QUOTES, 'UTF-8'); ?></strong>
        </p>

        <form method="post" action="index.php" class="formulaire-avec-chargement">
            <input type="hidden" name="action" value="creation_personnage_etape_2">

            <div class="grille-choix-cartes">
                <label class="carte-choix-classe">
                    <input type="radio" name="classe" value="Tank" <?= ($creation['classe'] ?? '') === 'Tank' ? 'checked' : ''; ?> required>
                    <strong>Tank</strong>
                    <small>Style défensif et résistance élevée.</small>
                </label>

                <label class="carte-choix-classe">
                    <input type="radio" name="classe" value="Heal" <?= ($creation['classe'] ?? '') === 'Heal' ? 'checked' : ''; ?> required>
                    <strong>Heal</strong>
                    <small>Style de soutien et soins.</small>
                </label>

                <label class="carte-choix-classe">
                    <input type="radio" name="classe" value="DPS" <?= ($creation['classe'] ?? '') === 'DPS' ? 'checked' : ''; ?> required>
                    <strong>DPS</strong>
                    <small>Style offensif et dégâts rapides.</small>
                </label>
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
            Élément : <strong><?= htmlspecialchars((string) $creation['element'], ENT_QUOTES, 'UTF-8'); ?></strong>
            — Classe : <strong><?= htmlspecialchars((string) $creation['classe'], ENT_QUOTES, 'UTF-8'); ?></strong>
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
                            value="<?= htmlspecialchars($competence, ENT_QUOTES, 'UTF-8'); ?>"
                            <?= in_array($competence, $creation['competences_elementaires'] ?? [], true) ? 'checked' : ''; ?>
                        >
                        <strong><?= htmlspecialchars($competence, ENT_QUOTES, 'UTF-8'); ?></strong>
                        <small>Compétence fictive temporaire pour la structure du code.</small>
                    </label>
                <?php endforeach; ?>
            </div>

            <button type="submit">Valider les compétences élémentaires</button>
        </form>

        <form method="post" action="index.php" class="formulaire-secondaire formulaire-avec-chargement">
            <input type="hidden" name="action" value="creation_personnage_retour_etape_2">
            <button type="submit" class="bouton-secondaire">Retour à l’étape précédente</button>
        </form>

    <?php elseif ($etape === 4) : ?>
        <p class="texte-explicatif">
            Choisissez exactement <strong>3 compétences neutres</strong> parmi les 5 proposées.
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
                            value="<?= htmlspecialchars($competence, ENT_QUOTES, 'UTF-8'); ?>"
                            <?= in_array($competence, $creation['competences_neutres'] ?? [], true) ? 'checked' : ''; ?>
                        >
                        <strong><?= htmlspecialchars($competence, ENT_QUOTES, 'UTF-8'); ?></strong>
                        <small>Compétence neutre fictive récupérable plus tard en jeu.</small>
                    </label>
                <?php endforeach; ?>
            </div>

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
            <h3>Suggestion automatique pour la classe <?= htmlspecialchars((string) $creation['classe'], ENT_QUOTES, 'UTF-8'); ?></h3>

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
                    <label
                        class="carte-avatar"
                        data-sexe="<?= htmlspecialchars($avatar['sexe'], ENT_QUOTES, 'UTF-8'); ?>"
                    >
                        <input
                            type="radio"
                            name="avatar"
                            value="<?= htmlspecialchars($avatar['identifiant'], ENT_QUOTES, 'UTF-8'); ?>"
                            <?= ($creation['avatar'] ?? '') === $avatar['identifiant'] ? 'checked' : ''; ?>
                        >

                        <div class="cadre-avatar-image">
                            <img
                                src="<?= htmlspecialchars($avatar['image'], ENT_QUOTES, 'UTF-8'); ?>"
                                alt="<?= htmlspecialchars($avatar['nom'], ENT_QUOTES, 'UTF-8'); ?>"
                                class="image-avatar"
                            >
                        </div>

                        <strong><?= htmlspecialchars($avatar['nom'], ENT_QUOTES, 'UTF-8'); ?></strong>
                    </label>
                <?php endforeach; ?>
            </div>

            <div id="compteur-statistiques" class="compteur-statistiques">
                Total utilisé : 0 / 30
            </div>

            <div class="grille-statistiques">
                <div class="champ-statistique">
                    <label for="point_de_vie">Point de vie</label>
                    <input type="number" id="point_de_vie" name="point_de_vie" min="0" value="<?= (int) (($creation['statistiques']['point_de_vie'] ?? 0)); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="attaque">Attaque</label>
                    <input type="number" id="attaque" name="attaque" min="0" value="<?= (int) (($creation['statistiques']['attaque'] ?? 0)); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="magie">Magie</label>
                    <input type="number" id="magie" name="magie" min="0" value="<?= (int) (($creation['statistiques']['magie'] ?? 0)); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="agilite">Agilité</label>
                    <input type="number" id="agilite" name="agilite" min="0" value="<?= (int) (($creation['statistiques']['agilite'] ?? 0)); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="intelligence">Intelligence</label>
                    <input type="number" id="intelligence" name="intelligence" min="0" value="<?= (int) (($creation['statistiques']['intelligence'] ?? 0)); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="synchronisation_elementaire">Synchronisation élémentaire</label>
                    <input type="number" id="synchronisation_elementaire" name="synchronisation_elementaire" min="0" value="<?= (int) (($creation['statistiques']['synchronisation_elementaire'] ?? 0)); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="critique">Critique</label>
                    <input type="number" id="critique" name="critique" min="0" value="<?= (int) (($creation['statistiques']['critique'] ?? 0)); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="dexterite">Dextérité</label>
                    <input type="number" id="dexterite" name="dexterite" min="0" value="<?= (int) (($creation['statistiques']['dexterite'] ?? 0)); ?>" required>
                </div>

                <div class="champ-statistique">
                    <label for="defense">Défense</label>
                    <input type="number" id="defense" name="defense" min="0" value="<?= (int) (($creation['statistiques']['defense'] ?? 0)); ?>" required>
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