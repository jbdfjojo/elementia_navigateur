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
    'variante_avatar' => 1,
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
$suggestion = Routeur::obtenirSuggestionStatistiques($classe_choisie);

// ---------------------------------------------------------
// Pré-remplissage intelligent des statistiques
// ---------------------------------------------------------
$statistiques_actuelles = $creation['statistiques'] ?? [];

$total_statistiques_actuelles = 0;
foreach ($statistiques_actuelles as $valeur_statistique_actuelle) {
    $total_statistiques_actuelles += (int) $valeur_statistique_actuelle;
}

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

<style>
.zone-apercu-avatar {
    display: flex;
    align-items: center;
    gap: 14px;
    margin: 6px 0 18px 0;
}

.carre-apercu-avatar {
    width: 140px;
    height: 140px;
    border: 1px solid rgba(201, 161, 74, 0.35);
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.03);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    padding: 6px;
}

.image-apercu-avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
    display: block;
}

.texte-apercu-avatar-vide {
    color: #cfc6b1;
    text-align: center;
    font-size: 14px;
    line-height: 1.35;
}

.texte-apercu-avatar {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.texte-apercu-avatar strong {
    color: #e0bf73;
}

.texte-apercu-avatar small {
    color: #cfc6b1;
}

@media (max-width: 900px) {
    .zone-apercu-avatar {
        flex-direction: column;
        align-items: flex-start;
    }
}

.message-importance-competences {
    margin: 14px 0 18px 0;
    padding: 14px 16px;
    border-radius: 14px;
    border: 1px solid rgba(201, 161, 74, 0.30);
    background: rgba(201, 161, 74, 0.08);
    color: #f2eadb;
}

.message-importance-competences strong {
    color: #f0cb78;
}

.carte-competence-detaillee {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.carte-competence-entete {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
}

.badge-competence {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 4px 10px;
    border-radius: 999px;
    border: 1px solid rgba(201, 161, 74, 0.30);
    background: rgba(255, 255, 255, 0.04);
    color: #e9c97f;
    font-size: 12px;
    white-space: nowrap;
}

.resume-competence {
    color: #d9cfba;
    line-height: 1.45;
}

.grille-infos-competence {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 10px;
}

.bloc-info-competence {
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding: 10px 12px;
    border-radius: 12px;
    background: rgba(0, 0, 0, 0.20);
    border: 1px solid rgba(201, 161, 74, 0.16);
}

.bloc-info-competence span {
    color: #c7bda8;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.bloc-info-competence strong {
    color: #f2eadb;
    font-size: 14px;
}

.fond-modal-confirmation {
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(4, 6, 10, 0.76);
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.fond-modal-confirmation.visible {
    display: flex;
}

.modal-confirmation {
    width: min(100%, 620px);
    border-radius: 20px;
    border: 1px solid rgba(201, 161, 74, 0.32);
    background: linear-gradient(180deg, rgba(27, 31, 38, 0.98), rgba(19, 22, 28, 0.98));
    box-shadow: 0 18px 60px rgba(0, 0, 0, 0.45);
    padding: 24px;
    color: #f2eadb;
}

.modal-confirmation-entete {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 16px;
}

.modal-confirmation-entete h3 {
    margin: 0;
    color: #f0cb78;
    font-size: 24px;
}

.modal-confirmation-entete p {
    margin: 0;
    color: #d6ccb8;
    line-height: 1.5;
}

.liste-confirmation {
    margin: 0 0 20px 0;
    padding: 0;
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.liste-confirmation li {
    padding: 12px 14px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(201, 161, 74, 0.16);
}

.actions-modal-confirmation {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    flex-wrap: wrap;
}

</style>

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

        <form method="post" action="index.php" class="formulaire-avec-chargement formulaire-limite-choix formulaire-confirmation-competences" data-max-selection="4" data-type-confirmation="elementaires">
            <input type="hidden" name="action" value="creation_personnage_etape_3">
            <input type="hidden" name="confirmation_competences_elementaires" value="non">

            <div class="grille-competences">
                <?php foreach ($competences_elementaires as $competence) : ?>
                    <label class="carte-competence carte-competence-detaillee">
                        <input
                            type="checkbox"
                            name="competences_elementaires[]"
                            value="<?= htmlspecialchars((string) $competence['code_competence'], ENT_QUOTES, 'UTF-8'); ?>"
                            <?= in_array((string) $competence['code_competence'], $creation['competences_elementaires'] ?? [], true) ? 'checked' : ''; ?>
                        >

                        <div class="carte-competence-entete">
                            <strong><?= htmlspecialchars((string) $competence['nom'], ENT_QUOTES, 'UTF-8'); ?></strong>
                            <span class="badge-competence">Actif élémentaire</span>
                        </div>

                        <div class="resume-competence">
                            <?= htmlspecialchars((string) $competence['resume'], ENT_QUOTES, 'UTF-8'); ?>
                        </div>

                        <div class="grille-infos-competence">
                            <div class="bloc-info-competence">
                                <span>Coût</span>
                                <strong><?= (int) ($competence['cout_utilisation'] ?? 0); ?></strong>
                            </div>

                            <div class="bloc-info-competence">
                                <span>Ressource</span>
                                <strong><?= htmlspecialchars((string) ($competence['ressource_utilisee'] ?? 'Non renseignée'), ENT_QUOTES, 'UTF-8'); ?></strong>
                            </div>

                            <div class="bloc-info-competence">
                                <span>Choix</span>
                                <strong>Définitif au départ</strong>
                            </div>
                        </div>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="message-importance-competences">
                <strong>Attention :</strong> les compétences élémentaires sont un choix important. Elles ne pourront pas être changées librement. Un maître spécialisé sera nécessaire et elles reviendront niveau 1.
            </div>

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

        <form method="post" action="index.php" class="formulaire-avec-chargement formulaire-limite-choix formulaire-confirmation-competences" data-max-selection="3" data-type-confirmation="neutres">
            <input type="hidden" name="action" value="creation_personnage_etape_4">
            <input type="hidden" name="confirmation_competences_neutres" value="non">

            <div class="grille-competences">
                <?php foreach ($competences_neutres as $competence) : ?>
                    <label class="carte-competence carte-competence-detaillee">
                        <input
                            type="checkbox"
                            name="competences_neutres[]"
                            value="<?= htmlspecialchars((string) $competence['code_competence'], ENT_QUOTES, 'UTF-8'); ?>"
                            <?= in_array((string) $competence['code_competence'], $creation['competences_neutres'] ?? [], true) ? 'checked' : ''; ?>
                        >

                        <div class="carte-competence-entete">
                            <strong><?= htmlspecialchars((string) $competence['nom'], ENT_QUOTES, 'UTF-8'); ?></strong>
                            <span class="badge-competence">Neutre évolutive</span>
                        </div>

                        <div class="resume-competence">
                            <?= htmlspecialchars((string) $competence['resume'], ENT_QUOTES, 'UTF-8'); ?>
                        </div>

                        <div class="grille-infos-competence">
                            <div class="bloc-info-competence">
                                <span>Type</span>
                                <strong>Progression naturelle</strong>
                            </div>

                            <div class="bloc-info-competence">
                                <span>Déblocage</span>
                                <strong><?= htmlspecialchars((string) ($competence['declencheur_progression'] ?? 'Non renseigné'), ENT_QUOTES, 'UTF-8'); ?></strong>
                            </div>

                            <div class="bloc-info-competence">
                                <span>Évolution</span>
                                <strong>Selon vos actions</strong>
                            </div>
                        </div>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="message-importance-competences">
                <strong>Information :</strong> les compétences neutres évoluent avec vos actions. Elles peuvent être débloquées et améliorées selon votre style de jeu et votre progression naturelle.
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

            <label for="variante_avatar">Variante de l’avatar</label>
            <select id="variante_avatar" name="variante_avatar" required>
                <option value="1" <?= ((int) ($creation['variante_avatar'] ?? 1) === 1) ? 'selected' : ''; ?>>Variante 1</option>
                <option value="2" <?= ((int) ($creation['variante_avatar'] ?? 1) === 2) ? 'selected' : ''; ?>>Variante 2</option>
            </select>

            <label>Aperçu de l’avatar</label>
            <div class="zone-apercu-avatar">
                <div class="carre-apercu-avatar" id="carre-apercu-avatar">
                    <span id="texte-apercu-avatar-vide" class="texte-apercu-avatar-vide">Choisissez le sexe puis la variante</span>
                    <img id="image-apercu-avatar" src="" alt="Avatar automatique" class="image-apercu-avatar" style="display:none;">
                </div>

                <div class="texte-apercu-avatar" id="texte-apercu-avatar" style="display:none;">
                    <strong id="titre-apercu-avatar"><?= htmlspecialchars($classe_choisie, ENT_QUOTES, 'UTF-8'); ?></strong>
                    <small id="sous-titre-apercu-avatar"></small>
                </div>
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


<div id="fond-modal-confirmation" class="fond-modal-confirmation" aria-hidden="true">
    <div class="modal-confirmation" role="dialog" aria-modal="true" aria-labelledby="titre-modal-confirmation">
        <div class="modal-confirmation-entete">
            <h3 id="titre-modal-confirmation">Confirmation</h3>
            <p id="texte-modal-confirmation"></p>
        </div>

        <ul id="liste-modal-confirmation" class="liste-confirmation"></ul>

        <div class="actions-modal-confirmation">
            <button type="button" id="bouton-annuler-modal" class="bouton-secondaire">Retour</button>
            <button type="button" id="bouton-confirmer-modal">Confirmer</button>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const champSexe = document.getElementById('sexe');
    const champVariante = document.getElementById('variante_avatar');
    const carreApercu = document.getElementById('carre-apercu-avatar');
    const imageApercu = document.getElementById('image-apercu-avatar');
    const texteVide = document.getElementById('texte-apercu-avatar-vide');
    const blocTexte = document.getElementById('texte-apercu-avatar');
    const titreApercu = document.getElementById('titre-apercu-avatar');
    const sousTitreApercu = document.getElementById('sous-titre-apercu-avatar');

    const fondModalConfirmation = document.getElementById('fond-modal-confirmation');
    const titreModalConfirmation = document.getElementById('titre-modal-confirmation');
    const texteModalConfirmation = document.getElementById('texte-modal-confirmation');
    const listeModalConfirmation = document.getElementById('liste-modal-confirmation');
    const boutonAnnulerModal = document.getElementById('bouton-annuler-modal');
    const boutonConfirmerModal = document.getElementById('bouton-confirmer-modal');

    let formulaireEnAttenteConfirmation = null;

    const contenusConfirmation = {
        elementaires: {
            titre: '⚠️ Attention',
            texte: 'Les compétences élémentaires sont un choix important.',
            points: [
                'Elles ne pourront pas être modifiées librement.',
                'Un maître spécialisé sera nécessaire pour les changer.',
                'En cas de changement, elles reviendront niveau 1.'
            ],
            nomChamp: 'confirmation_competences_elementaires'
        },
        neutres: {
            titre: 'ℹ️ Information',
            texte: 'Les compétences neutres évoluent avec vos actions.',
            points: [
                'Elles peuvent être débloquées et améliorées.',
                'Elles dépendent de votre style de jeu.',
                'Votre progression naturelle influencera leur évolution.'
            ],
            nomChamp: 'confirmation_competences_neutres'
        }
    };

    function fermerModalConfirmation() {
        if (!fondModalConfirmation) {
            return;
        }

        fondModalConfirmation.classList.remove('visible');
        fondModalConfirmation.setAttribute('aria-hidden', 'true');
        formulaireEnAttenteConfirmation = null;
    }

    function ouvrirModalConfirmation(typeConfirmation, formulaire) {
        if (!fondModalConfirmation || !titreModalConfirmation || !texteModalConfirmation || !listeModalConfirmation) {
            return;
        }

        const contenu = contenusConfirmation[typeConfirmation];

        if (!contenu) {
            return;
        }

        formulaireEnAttenteConfirmation = formulaire;
        titreModalConfirmation.textContent = contenu.titre;
        texteModalConfirmation.textContent = contenu.texte;
        listeModalConfirmation.innerHTML = '';

        contenu.points.forEach(function (point) {
            const ligne = document.createElement('li');
            ligne.textContent = '✔ ' + point;
            listeModalConfirmation.appendChild(ligne);
        });

        fondModalConfirmation.classList.add('visible');
        fondModalConfirmation.setAttribute('aria-hidden', 'false');
    }


    const elementChoisi = <?= json_encode($element_choisi, JSON_UNESCAPED_UNICODE); ?>;
    const classeChoisie = <?= json_encode($classe_choisie, JSON_UNESCAPED_UNICODE); ?>;

    const mappingElement = {
        'Feu': 'feu',
        'Eau': 'eau',
        'Air': 'air',
        'Terre': 'terre'
    };

    const mappingClasse = {
        'Guerrier du Feu': 'guerrier',
        'Berserker du Feu': 'berserker',
        'Mage du Feu': 'mage',
        'Prêtre du Feu': 'pretre',
        'Guerrier de l’Eau': 'guerrier',
        'Combattant de l’Eau': 'berserker',
        'Mage de l’Eau': 'mage',
        'Prêtre de l’Eau': 'pretre',
        'Guerrier de l’Air': 'guerrier',
        'Chasseur de l’Air': 'berserker',
        'Mage de l’Air': 'mage',
        'Prêtre de l’Air': 'pretre',
        'Guerrier de la Terre': 'guerrier',
        'Briseur de Terre': 'berserker',
        'Mage de la Terre': 'mage',
        'Prêtre de la Terre': 'pretre'
    };

    function mettreAJourApercuAvatar() {
        if (!champSexe || !champVariante || !imageApercu || !texteVide || !blocTexte || !sousTitreApercu) {
            return;
        }

        const sexe = champSexe.value;
        const variante = champVariante.value;

        if (!sexe || !variante || !elementChoisi || !classeChoisie) {
            imageApercu.style.display = 'none';
            imageApercu.src = '';
            texteVide.style.display = 'block';
            blocTexte.style.display = 'none';
            return;
        }

        const elementFichier = mappingElement[elementChoisi] || '';
        const classeFichier = mappingClasse[classeChoisie] || '';

        if (!elementFichier || !classeFichier) {
            imageApercu.style.display = 'none';
            imageApercu.src = '';
            texteVide.style.display = 'block';
            texteVide.textContent = 'Mapping avatar introuvable';
            blocTexte.style.display = 'none';
            return;
        }

        const cheminAvatar = 'ressources/images/avatars/' + elementFichier + '_' + classeFichier + '_' + sexe + '_' + variante + '.png';

        imageApercu.onload = function () {
            imageApercu.style.display = 'block';
            texteVide.style.display = 'none';
            blocTexte.style.display = 'flex';
            sousTitreApercu.textContent = sexe.charAt(0).toUpperCase() + sexe.slice(1) + ' — Variante ' + variante;
        };

        imageApercu.onerror = function () {
            imageApercu.style.display = 'none';
            imageApercu.src = '';
            texteVide.style.display = 'block';
            texteVide.textContent = 'Image introuvable';
            blocTexte.style.display = 'none';
        };

        imageApercu.src = cheminAvatar + '?v=' + Date.now();
    }

    if (champSexe) {
        champSexe.addEventListener('change', mettreAJourApercuAvatar);
    }

    if (champVariante) {
        champVariante.addEventListener('change', mettreAJourApercuAvatar);
    }


    const formulairesConfirmationCompetences = document.querySelectorAll('.formulaire-confirmation-competences');

    formulairesConfirmationCompetences.forEach(function (formulaire) {
        formulaire.addEventListener('submit', function (evenement) {
            const typeConfirmation = formulaire.dataset.typeConfirmation || '';
            const contenu = contenusConfirmation[typeConfirmation];

            if (!contenu) {
                return;
            }

            const champConfirmation = formulaire.querySelector('input[name="' + contenu.nomChamp + '"]');

            if (!champConfirmation) {
                return;
            }

            if (champConfirmation.value === 'oui') {
                return;
            }

            evenement.preventDefault();
            ouvrirModalConfirmation(typeConfirmation, formulaire);
        });
    });

    if (boutonAnnulerModal) {
        boutonAnnulerModal.addEventListener('click', function () {
            fermerModalConfirmation();
        });
    }

    if (boutonConfirmerModal) {
        boutonConfirmerModal.addEventListener('click', function () {
            if (!formulaireEnAttenteConfirmation) {
                fermerModalConfirmation();
                return;
            }

            const typeConfirmation = formulaireEnAttenteConfirmation.dataset.typeConfirmation || '';
            const contenu = contenusConfirmation[typeConfirmation];

            if (!contenu) {
                fermerModalConfirmation();
                return;
            }

            const champConfirmation = formulaireEnAttenteConfirmation.querySelector('input[name="' + contenu.nomChamp + '"]');

            if (champConfirmation) {
                champConfirmation.value = 'oui';
            }

            const formulaireAEnvoyer = formulaireEnAttenteConfirmation;
            fermerModalConfirmation();
            formulaireAEnvoyer.submit();
        });
    }

    if (fondModalConfirmation) {
        fondModalConfirmation.addEventListener('click', function (evenement) {
            if (evenement.target === fondModalConfirmation) {
                fermerModalConfirmation();
            }
        });
    }

    document.addEventListener('keydown', function (evenement) {
        if (evenement.key === 'Escape' && fondModalConfirmation && fondModalConfirmation.classList.contains('visible')) {
            fermerModalConfirmation();
        }
    });


    mettreAJourApercuAvatar();
});
</script>