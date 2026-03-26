<?php
$inventaire = $inventaire ?? [];
$poids_inventaire = $poids_inventaire ?? 0;
function cheminIconeObjet(?string $iconeObjet): string {
    $iconeObjet = trim((string)$iconeObjet);
    if ($iconeObjet === '') return '';
    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    $iconeObjet = str_replace('\\', '/', $iconeObjet);
    $iconeObjet = str_replace('ressources/images/icones/objets/', 'ressources/images/icones/', $iconeObjet);
    $iconeObjet = str_replace('/objets/', '/', $iconeObjet);
    if (str_starts_with($iconeObjet, 'ressources/')) return ($base !== '' ? $base . '/' : '/') . ltrim($iconeObjet, '/');
    return ($base !== '' ? $base . '/' : '/') . 'ressources/images/icones/' . basename($iconeObjet);
}
$indexInventaireParSlot = [];
foreach ($inventaire as $objetInventaire) {
    $positionSlot = (int)($objetInventaire['position_slot'] ?? 0);
    if ($positionSlot > 0) $indexInventaireParSlot[$positionSlot] = $objetInventaire;
}
?>
<div id="fenetre-inventaire" class="fenetre-jeu-modele fenetre-jeu-cachee fenetre-jeu-inventaire" data-cle-fenetre="inventaire">
<div class="contenu-fenetre-inventaire-modele"><div class="titre-visuel-inventaire"><h2 id="titre-fenetre-inventaire">Inventaire</h2></div><button type="button" class="bouton-fermer-fenetre bouton-fermer-fenetre-inventaire" data-fermer-fenetre="oui">×</button><div class="modele-inventaire-complet"><section class="modele-zone-grille-inventaire"><div class="grille-slots-modele">
<?php for ($indexSlot = 1; $indexSlot <= 48; $indexSlot++): ?>
<?php $objet = $indexInventaireParSlot[$indexSlot] ?? null; ?>
<div class="slot-inventaire-modele<?= $objet ? ' slot-inventaire-occupe' : '' ?>" data-slot-index="<?= $indexSlot ?>" draggable="<?= $objet ? 'true' : 'false' ?>"
<?php if ($objet): ?>
data-instance-objet-id="<?= (int)$objet['instance_objet_id'] ?>" data-nom-objet="<?= htmlspecialchars((string)($objet['nom_objet'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" data-description-objet="<?= htmlspecialchars((string)($objet['description_objet'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" data-rarete-objet="<?= htmlspecialchars((string)($objet['rarete_objet'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" data-type-objet="<?= htmlspecialchars((string)($objet['type_objet'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" data-categorie-objet="<?= htmlspecialchars((string)($objet['categorie_objet'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" data-poids-objet="<?= (int)($objet['poids_unitaire'] ?? 0) ?>" data-bonus-pv="<?= (int)($objet['bonus_point_de_vie'] ?? 0) ?>" data-bonus-attaque="<?= (int)($objet['bonus_attaque'] ?? 0) ?>" data-bonus-magie="<?= (int)($objet['bonus_magie'] ?? 0) ?>" data-bonus-agilite="<?= (int)($objet['bonus_agilite'] ?? 0) ?>" data-bonus-intelligence="<?= (int)($objet['bonus_intelligence'] ?? 0) ?>" data-bonus-synchronisation="<?= (int)($objet['bonus_synchronisation_elementaire'] ?? 0) ?>" data-bonus-critique="<?= (int)($objet['bonus_critique'] ?? 0) ?>" data-bonus-dexterite="<?= (int)($objet['bonus_dexterite'] ?? 0) ?>" data-bonus-defense="<?= (int)($objet['bonus_defense'] ?? 0) ?>"
<?php endif; ?>>
<?php if ($objet): ?>
<?php $cheminIcone = cheminIconeObjet((string)($objet['icone_objet'] ?? '')); ?>
<?php if ($cheminIcone !== ''): ?><img class="slot-inventaire-icone" src="<?= htmlspecialchars($cheminIcone, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars((string)($objet['nom_objet'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" onerror="this.style.display='none'; this.nextElementSibling.classList.add('slot-inventaire-fallback-visible');"><?php endif; ?>
<div class="slot-inventaire-fallback<?= $cheminIcone === '' ? ' slot-inventaire-fallback-visible' : '' ?>"><?= htmlspecialchars(substr((string)($objet['nom_objet'] ?? '?'), 0, 3), ENT_QUOTES, 'UTF-8') ?></div>
<form method="post" class="formulaire-action-objet formulaire-action-equiper"><input type="hidden" name="action" value="equiper_objet_inventaire"><input type="hidden" name="instance_objet_id" value="<?= (int)$objet['instance_objet_id'] ?>"></form>
<form method="post" class="formulaire-action-objet formulaire-action-double-clic"><input type="hidden" name="action" value="equiper_ou_remplacer_objet"><input type="hidden" name="instance_objet_id" value="<?= (int)$objet['instance_objet_id'] ?>"></form>
<form method="post" class="formulaire-action-objet formulaire-action-jeter"><input type="hidden" name="action" value="jeter_objet_inventaire"><input type="hidden" name="instance_objet_id" value="<?= (int)$objet['instance_objet_id'] ?>"></form>
<?php else: ?><span class="texte-cache">Emplacement <?= $indexSlot ?></span><?php endif; ?>
</div>
<?php endfor; ?>
</div></section><footer class="modele-panneaux-bas-inventaire"><section class="panneau-bas-inventaire panneau-bas-gauche"><div class="contenu-panneau-bas-inventaire"><span class="libelle-panneau-bas">Monnaie</span><strong id="inventaire-monnaie-sac">0 or</strong></div></section><section class="panneau-bas-inventaire panneau-bas-droite"><div class="contenu-panneau-bas-inventaire contenu-panneau-bas-inventaire-droit"><span class="libelle-panneau-bas">Poids</span><strong id="inventaire-poids-sac"><?= (int)$poids_inventaire ?> / 100</strong></div></section></footer></div></div>
<div id="menu-contextuel-objet" class="menu-contextuel-objet" hidden><button type="button" data-action-menu="equiper">Équiper</button><button type="button" data-action-menu="jeter">Jeter</button></div>
<div id="infobulle-objet" class="infobulle-objet" hidden><div class="infobulle-objet-titre"></div><div class="infobulle-objet-ligne infobulle-objet-rarete"></div><div class="infobulle-objet-ligne infobulle-objet-type"></div><div class="infobulle-objet-ligne infobulle-objet-poids"></div><div class="infobulle-objet-description"></div><div class="infobulle-objet-bonus"></div></div>
</div>
