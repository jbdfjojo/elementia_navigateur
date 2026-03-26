<?php
$personnage = $personnage ?? [];
$equipements = $equipements ?? [];

function valeurStatPersonnage(array $personnage, string $cle): int { return (int) ($personnage[$cle] ?? 0); }
function normaliserCleEquipement(string $texte): string {
    $texte = strtolower($texte);
    return strtr($texte, ['à'=>'a','â'=>'a','ä'=>'a','ç'=>'c','é'=>'e','è'=>'e','ê'=>'e','ë'=>'e','î'=>'i','ï'=>'i','ô'=>'o','ö'=>'o','ù'=>'u','û'=>'u','ü'=>'u','ÿ'=>'y']);
}
function cheminIconeEquipement(?string $iconeObjet): string {
    $iconeObjet = trim((string) $iconeObjet); if ($iconeObjet === '') return '';
    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    $iconeObjet = str_replace('\\', '/', $iconeObjet);
    $iconeObjet = str_replace('ressources/images/icones/objets/', 'ressources/images/icones/', $iconeObjet);
    $iconeObjet = str_replace('/objets/', '/', $iconeObjet);
    if (str_starts_with($iconeObjet, 'ressources/')) return ($base !== '' ? $base . '/' : '/') . ltrim($iconeObjet, '/');
    return ($base !== '' ? $base . '/' : '/') . 'ressources/images/icones/' . basename($iconeObjet);
}
function trouverEquipementPourSlot(array $equipements, array $correspondances): ?array {
    foreach ($equipements as $equipement) {
        $texteComparaison = normaliserCleEquipement((string) ($equipement['code_slot'] ?? '') . ' ' . (string) ($equipement['nom_slot'] ?? ''));
        foreach ($correspondances as $correspondance) if (str_contains($texteComparaison, normaliserCleEquipement($correspondance))) return $equipement;
    }
    return null;
}
$equipementTete = trouverEquipementPourSlot($equipements, ['tete']);
$equipementGantsGauche = trouverEquipementPourSlot($equipements, ['gant gauche', 'gants gauche', 'gants_gauche', 'gants']);
$equipementGantsDroite = trouverEquipementPourSlot($equipements, ['gant droite', 'gants droite', 'gants_droite']);
$equipementTorse = trouverEquipementPourSlot($equipements, ['torse', 'armure']);
$equipementJambes = trouverEquipementPourSlot($equipements, ['jambes', 'bottes', 'botte']);
$equipementCollier = trouverEquipementPourSlot($equipements, ['collier', 'amulette']);
$equipementBague1 = trouverEquipementPourSlot($equipements, ['bague 1', 'bague_1', 'bague1']);
$equipementBague2 = trouverEquipementPourSlot($equipements, ['bague 2', 'bague_2', 'bague2']);
$equipementMainGauche = trouverEquipementPourSlot($equipements, ['main gauche']);
$equipementArtefact = trouverEquipementPourSlot($equipements, ['artefact']);
$equipementMainDroite = trouverEquipementPourSlot($equipements, ['main droite']);
$equipementSac = trouverEquipementPourSlot($equipements, ['sac']);

function rendreSlotEquipement(?array $equipement, string $texteDefaut, string $classeCss, string $slotCible): void {
    $estOccupe = $equipement !== null;
    echo '<div class="slot-personnage ' . htmlspecialchars($classeCss, ENT_QUOTES, 'UTF-8') . ($estOccupe ? ' slot-personnage-occupe' : ' slot-personnage-vide') . '" data-slot-cible="' . htmlspecialchars($slotCible, ENT_QUOTES, 'UTF-8') . '">';
    if ($equipement) {
        $nomObjet = (string) ($equipement['nom_objet'] ?? $texteDefaut);
        $cheminIcone = cheminIconeEquipement((string) ($equipement['icone_objet'] ?? ''));
        echo '<div class="slot-personnage-contenu slot-personnage-equippe" data-instance-objet-id="' . (int) ($equipement['instance_objet_id'] ?? 0) . '" data-slot-cible="' . htmlspecialchars($slotCible, ENT_QUOTES, 'UTF-8') . '" data-categorie-objet="' . htmlspecialchars((string) ($equipement['categorie_objet'] ?? ''), ENT_QUOTES, 'UTF-8') . '" data-nom-objet="' . htmlspecialchars($nomObjet, ENT_QUOTES, 'UTF-8') . '" data-description-objet="' . htmlspecialchars((string) ($equipement['description_objet'] ?? ''), ENT_QUOTES, 'UTF-8') . '" data-rarete-objet="' . htmlspecialchars((string) ($equipement['rarete_objet'] ?? ''), ENT_QUOTES, 'UTF-8') . '" data-type-objet="' . htmlspecialchars((string) ($equipement['type_objet'] ?? ''), ENT_QUOTES, 'UTF-8') . '" data-poids-objet="' . (int) ($equipement['poids_unitaire'] ?? 0) . '" data-bonus-pv="' . (int) ($equipement['bonus_point_de_vie'] ?? 0) . '" data-bonus-attaque="' . (int) ($equipement['bonus_attaque'] ?? 0) . '" data-bonus-magie="' . (int) ($equipement['bonus_magie'] ?? 0) . '" data-bonus-agilite="' . (int) ($equipement['bonus_agilite'] ?? 0) . '" data-bonus-intelligence="' . (int) ($equipement['bonus_intelligence'] ?? 0) . '" data-bonus-synchronisation="' . (int) ($equipement['bonus_synchronisation_elementaire'] ?? 0) . '" data-bonus-critique="' . (int) ($equipement['bonus_critique'] ?? 0) . '" data-bonus-dexterite="' . (int) ($equipement['bonus_dexterite'] ?? 0) . '" data-bonus-defense="' . (int) ($equipement['bonus_defense'] ?? 0) . '">';
        if ($cheminIcone !== '') {
            echo '<img class="slot-personnage-icone" src="' . htmlspecialchars($cheminIcone, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($nomObjet, ENT_QUOTES, 'UTF-8') . '" onerror="this.style.display=\'none\'; this.nextElementSibling.classList.add(\'slot-personnage-fallback-visible\');">';
            echo '<span class="slot-personnage-texte slot-personnage-fallback">' . htmlspecialchars(substr($nomObjet, 0, 3), ENT_QUOTES, 'UTF-8') . '</span>';
        } else {
            echo '<span class="slot-personnage-texte slot-personnage-fallback-visible">' . htmlspecialchars($nomObjet, ENT_QUOTES, 'UTF-8') . '</span>';
        }
        echo '</div>';
        echo '<form method="post" class="formulaire-action-equipement formulaire-action-desequiper"><input type="hidden" name="action" value="desequiper_objet_equipe"><input type="hidden" name="instance_objet_id" value="' . (int) ($equipement['instance_objet_id'] ?? 0) . '"></form>';
    } else {
        echo '<span class="slot-personnage-texte">' . htmlspecialchars($texteDefaut, ENT_QUOTES, 'UTF-8') . '</span>';
    }
    echo '<form method="post" class="formulaire-equipement-slot"><input type="hidden" name="action" value="equiper_objet_slot"><input type="hidden" name="instance_objet_id" value=""><input type="hidden" name="slot_cible" value="' . htmlspecialchars($slotCible, ENT_QUOTES, 'UTF-8') . '"></form>';
    echo '</div>';
}
?>
<div id="fenetre-personnage" class="fenetre-jeu-modele fenetre-jeu-cachee" data-cle-fenetre="personnage" role="dialog" aria-modal="true" aria-labelledby="titre-fenetre-personnage">
<div class="entete-fenetre-jeu entete-fenetre-personnage"><div><h2 id="titre-fenetre-personnage">Personnage</h2><p>Équipement du personnage à gauche et statistiques du personnage actif à droite.</p></div><button type="button" class="bouton-fermer-fenetre" data-fermer-fenetre="oui" aria-label="Fermer la fenêtre">×</button></div>
<div class="contenu-fenetre-jeu contenu-fenetre-personnage"><div class="zone-feuille-personnage"><section class="carte-personnage"><div class="zone-silhouette-personnage"><div class="silhouette-personnage-image" aria-hidden="true"></div>
<?php rendreSlotEquipement($equipementTete, 'Tête', 'slot-tete', 'tete'); ?>
<?php rendreSlotEquipement($equipementGantsGauche, 'Gants', 'slot-gants-gauche', 'gants_gauche'); ?>
<?php rendreSlotEquipement($equipementGantsDroite, 'Gants', 'slot-gants-droite', 'gants_droite'); ?>
<?php rendreSlotEquipement($equipementTorse, 'Torse', 'slot-torse', 'torse'); ?>
<?php rendreSlotEquipement($equipementJambes, 'Jambes', 'slot-jambes', 'jambes'); ?>
<?php rendreSlotEquipement($equipementCollier, 'Collier', 'slot-collier', 'collier'); ?>
<?php rendreSlotEquipement($equipementBague1, 'Bague I', 'slot-bague-1', 'bague_1'); ?>
<?php rendreSlotEquipement($equipementBague2, 'Bague II', 'slot-bague-2', 'bague_2'); ?>
<?php rendreSlotEquipement($equipementMainGauche, 'Main gauche', 'slot-main-gauche', 'main_gauche'); ?>
<?php rendreSlotEquipement($equipementArtefact, 'Artefact', 'slot-artefact', 'artefact'); ?>
<?php rendreSlotEquipement($equipementMainDroite, 'Main droite', 'slot-main-droite', 'main_droite'); ?>
<?php rendreSlotEquipement($equipementSac, 'Sac', 'slot-sac', 'sac'); ?>
</div></section><aside class="carte-statistiques"><div class="entete-stats-personnage"><h3>Statistiques</h3><p>Valeurs actuelles du personnage actif.</p></div><div class="grille-statistiques-personnage">
<div class="ligne-statistique-personnage"><span>PV</span><strong><?= valeurStatPersonnage($personnage, 'point_de_vie') ?></strong></div>
<div class="ligne-statistique-personnage"><span>Attaque</span><strong><?= valeurStatPersonnage($personnage, 'attaque') ?></strong></div>
<div class="ligne-statistique-personnage"><span>Magie</span><strong><?= valeurStatPersonnage($personnage, 'magie') ?></strong></div>
<div class="ligne-statistique-personnage"><span>Agilité</span><strong><?= valeurStatPersonnage($personnage, 'agilite') ?></strong></div>
<div class="ligne-statistique-personnage"><span>Intelligence</span><strong><?= valeurStatPersonnage($personnage, 'intelligence') ?></strong></div>
<div class="ligne-statistique-personnage"><span>Synchronisation</span><strong><?= valeurStatPersonnage($personnage, 'synchronisation_elementaire') ?></strong></div>
<div class="ligne-statistique-personnage"><span>Critique</span><strong><?= valeurStatPersonnage($personnage, 'critique') ?></strong></div>
<div class="ligne-statistique-personnage"><span>Dextérité</span><strong><?= valeurStatPersonnage($personnage, 'dexterite') ?></strong></div>
<div class="ligne-statistique-personnage ligne-statistique-personnage-large"><span>Défense</span><strong><?= valeurStatPersonnage($personnage, 'defense') ?></strong></div>
</div></aside></div></div>
<div id="menu-contextuel-equipement" class="menu-contextuel-objet" hidden><button type="button" data-action-menu-equipement="desequiper">Déséquiper</button></div>
</div>
