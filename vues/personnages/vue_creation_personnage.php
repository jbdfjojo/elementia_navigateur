<?php
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

$etape = (int) ($creation['etape'] ?? 1);
$element_choisi = (string) ($creation['element'] ?? '');
$classe_choisie = (string) ($creation['classe'] ?? '');
$classes_disponibles = $element_choisi !== '' ? Routeur::obtenirClassesParElement($element_choisi) : [];
$competences_elementaires = ($element_choisi !== '' && $classe_choisie !== '')
    ? Routeur::obtenirCompetencesElementairesCatalogue($connexion_base, $element_choisi, $classe_choisie)
    : [];
$competences_neutres = Routeur::obtenirCompetencesNeutresCatalogue($connexion_base);
$suggestion = Routeur::obtenirSuggestionStatistiques($classe_choisie);
$statistiques_actuelles = $creation['statistiques'] ?? [];
$total_statistiques_actuelles = 0;
foreach ($statistiques_actuelles as $valeur_statistique_actuelle) {
    $total_statistiques_actuelles += (int) $valeur_statistique_actuelle;
}
$statistiques_affichees = $total_statistiques_actuelles > 0 ? [
    'point_de_vie' => (int) ($statistiques_actuelles['point_de_vie'] ?? 0),
    'attaque' => (int) ($statistiques_actuelles['attaque'] ?? 0),
    'magie' => (int) ($statistiques_actuelles['magie'] ?? 0),
    'agilite' => (int) ($statistiques_actuelles['agilite'] ?? 0),
    'intelligence' => (int) ($statistiques_actuelles['intelligence'] ?? 0),
    'synchronisation_elementaire' => (int) ($statistiques_actuelles['synchronisation_elementaire'] ?? 0),
    'critique' => (int) ($statistiques_actuelles['critique'] ?? 0),
    'dexterite' => (int) ($statistiques_actuelles['dexterite'] ?? 0),
    'defense' => (int) ($statistiques_actuelles['defense'] ?? 0)
] : [
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
?>
<div class="bloc-formulaire module-personnages" data-element-choisi="<?= htmlspecialchars($element_choisi, ENT_QUOTES, 'UTF-8'); ?>" data-classe-choisie="<?= htmlspecialchars($classe_choisie, ENT_QUOTES, 'UTF-8'); ?>">
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

    <?php include __DIR__ . '/formulaire_creation_personnage.php'; ?>
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
