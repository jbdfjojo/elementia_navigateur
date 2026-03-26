<?php
$inventaire = $inventaire ?? [];
$poids_inventaire = $poids_inventaire ?? 0;
$personnage = $personnage ?? [];

function cheminIconeObjet(?string $iconeObjet): string {
    $iconeObjet = trim((string)$iconeObjet);

    if ($iconeObjet === '') {
        return '';
    }

    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    $iconeObjet = str_replace('\\', '/', $iconeObjet);
    $iconeObjet = str_replace('ressources/images/icones/objets/', 'ressources/images/icones/', $iconeObjet);
    $iconeObjet = str_replace('/objets/', '/', $iconeObjet);

    if (str_starts_with($iconeObjet, 'ressources/')) {
        return ($base !== '' ? $base . '/' : '/') . ltrim($iconeObjet, '/');
    }

    return ($base !== '' ? $base . '/' : '/') . 'ressources/images/icones/' . basename($iconeObjet);
}

function calculerTexteEffetObjet(array $objet, array $personnage): string {
    $categorie = (string)($objet['categorie_objet'] ?? '');
    $valeurEffet = (int)($objet['valeur_effet'] ?? 0);

    $vieMax = max(
        (int)($personnage['point_de_vie_maximum'] ?? 0),
        (int)($personnage['vie_max'] ?? 0),
        (int)($personnage['point_de_vie'] ?? 0)
    );

    $manaMax = max(
        (int)($personnage['magie_maximum'] ?? 0),
        (int)($personnage['mana_max'] ?? 0),
        (int)($personnage['magie'] ?? 0)
    );

    if (str_starts_with($categorie, 'potion_vie_20')) {
        return 'Rend : ' . (int)ceil($vieMax * 0.20) . ' PV (20%)';
    }

    if (str_starts_with($categorie, 'potion_vie_60')) {
        return 'Rend : ' . (int)ceil($vieMax * 0.60) . ' PV (60%)';
    }

    if (str_starts_with($categorie, 'potion_vie_100')) {
        return 'Rend : ' . (int)ceil($vieMax * 1.00) . ' PV (100%)';
    }

    if ($categorie === 'potion_vie' && $valeurEffet > 0) {
        return 'Rend : ' . $valeurEffet . ' PV';
    }

    if (str_starts_with($categorie, 'potion_mana_20')) {
        return 'Rend : ' . (int)ceil($manaMax * 0.20) . ' PM (20%)';
    }

    if (str_starts_with($categorie, 'potion_mana_60')) {
        return 'Rend : ' . (int)ceil($manaMax * 0.60) . ' PM (60%)';
    }

    if (str_starts_with($categorie, 'potion_mana_100')) {
        return 'Rend : ' . (int)ceil($manaMax * 1.00) . ' PM (100%)';
    }

    if ($categorie === 'potion_mana' && $valeurEffet > 0) {
        return 'Rend : ' . $valeurEffet . ' PM';
    }

    return '';
}

function quantiteObjetInventaire(array $objet): int {
    $clesPossibles = [
        'quantite',
        'quantite_objet',
        'nombre',
        'pile',
        'stack',
        'stack_count',
        'nombre_objets'
    ];

    foreach ($clesPossibles as $cle) {
        if (array_key_exists($cle, $objet) && $objet[$cle] !== null && $objet[$cle] !== '') {
            return max(1, (int)$objet[$cle]);
        }
    }

    return 1;
}

$indexInventaireParSlot = [];

foreach ($inventaire as $objetInventaire) {
    $positionSlot = (int)($objetInventaire['position_slot'] ?? 0);

    if ($positionSlot > 0) {
        $indexInventaireParSlot[$positionSlot] = $objetInventaire;
    }
}

$vieActuelle = 0;
if (array_key_exists('point_de_vie_actuel', $personnage)) {
    $vieActuelle = (int)$personnage['point_de_vie_actuel'];
} elseif (array_key_exists('vie_actuelle', $personnage)) {
    $vieActuelle = (int)$personnage['vie_actuelle'];
}

$vieMax = 0;
if (array_key_exists('point_de_vie_maximum', $personnage)) {
    $vieMax = (int)$personnage['point_de_vie_maximum'];
} elseif (array_key_exists('vie_max', $personnage)) {
    $vieMax = (int)$personnage['vie_max'];
} elseif (array_key_exists('point_de_vie', $personnage)) {
    $vieMax = (int)$personnage['point_de_vie'];
}

$manaActuel = 0;
if (array_key_exists('magie_actuelle', $personnage)) {
    $manaActuel = (int)$personnage['magie_actuelle'];
} elseif (array_key_exists('mana_actuel', $personnage)) {
    $manaActuel = (int)$personnage['mana_actuel'];
}

$manaMax = 0;
if (array_key_exists('magie_maximum', $personnage)) {
    $manaMax = (int)$personnage['magie_maximum'];
} elseif (array_key_exists('mana_max', $personnage)) {
    $manaMax = (int)$personnage['mana_max'];
} elseif (array_key_exists('magie', $personnage)) {
    $manaMax = (int)$personnage['magie'];
}
?>
<div
    id="fenetre-inventaire"
    class="fenetre-jeu-modele fenetre-jeu-cachee fenetre-jeu-inventaire"
    data-cle-fenetre="inventaire"
    data-vie-actuelle="<?= (int)$vieActuelle ?>"
    data-vie-max="<?= (int)$vieMax ?>"
    data-mana-actuel="<?= (int)$manaActuel ?>"
    data-mana-max="<?= (int)$manaMax ?>"
>
    <div class="contenu-fenetre-inventaire-modele">
        <div class="titre-visuel-inventaire">
            <h2 id="titre-fenetre-inventaire">Inventaire</h2>
        </div>

        <button
            type="button"
            class="bouton-fermer-fenetre bouton-fermer-fenetre-inventaire"
            data-fermer-fenetre="oui"
        >
            ×
        </button>

        <div class="modele-inventaire-complet">
            <section class="modele-zone-grille-inventaire">
                <div class="grille-slots-modele">
                    <?php for ($indexSlot = 1; $indexSlot <= 48; $indexSlot++): ?>
                        <?php $objet = $indexInventaireParSlot[$indexSlot] ?? null; ?>

                        <div
                            class="slot-inventaire-modele<?= $objet ? ' slot-inventaire-occupe' : '' ?>"
                            data-slot-index="<?= $indexSlot ?>"
                            draggable="<?= $objet ? 'true' : 'false' ?>"
                            style="position: relative;"
                            <?php if ($objet): ?>
                                <?php
                                $typeObjet = strtolower((string)($objet['type_objet'] ?? ''));
                                $categorieObjet = strtolower((string)($objet['categorie_objet'] ?? ''));
                                $nomObjet = strtolower((string)($objet['nom_objet'] ?? ''));
                                $estPotion = str_contains($categorieObjet, 'potion') || str_contains($nomObjet, 'potion');
                                $estConsommable = $estPotion || in_array($typeObjet, ['consommable', 'nourriture'], true);
                                $estEquipable = !$estConsommable && (int)($objet['est_equipable'] ?? 0) === 1;
                                $quantiteObjet = quantiteObjetInventaire($objet);
                                ?>
                                data-instance-objet-id="<?= (int)$objet['instance_objet_id'] ?>"
                                data-nom-objet="<?= htmlspecialchars((string)($objet['nom_objet'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                data-description-objet="<?= htmlspecialchars((string)($objet['description_objet'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                data-rarete-objet="<?= htmlspecialchars((string)($objet['rarete_objet'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                data-type-objet="<?= htmlspecialchars((string)($objet['type_objet'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                data-categorie-objet="<?= htmlspecialchars((string)($objet['categorie_objet'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                data-poids-objet="<?= (int)($objet['poids_unitaire'] ?? 0) ?>"
                                data-bonus-pv="<?= (int)($objet['bonus_point_de_vie'] ?? 0) ?>"
                                data-bonus-attaque="<?= (int)($objet['bonus_attaque'] ?? 0) ?>"
                                data-bonus-magie="<?= (int)($objet['bonus_magie'] ?? 0) ?>"
                                data-bonus-agilite="<?= (int)($objet['bonus_agilite'] ?? 0) ?>"
                                data-bonus-intelligence="<?= (int)($objet['bonus_intelligence'] ?? 0) ?>"
                                data-bonus-synchronisation="<?= (int)($objet['bonus_synchronisation_elementaire'] ?? 0) ?>"
                                data-bonus-critique="<?= (int)($objet['bonus_critique'] ?? 0) ?>"
                                data-bonus-dexterite="<?= (int)($objet['bonus_dexterite'] ?? 0) ?>"
                                data-bonus-defense="<?= (int)($objet['bonus_defense'] ?? 0) ?>"
                                data-est-equipable="<?= $estEquipable ? 1 : 0 ?>"
                                data-est-consommable="<?= $estConsommable ? 1 : 0 ?>"
                                data-quantite-objet="<?= $quantiteObjet ?>"
                                data-effet-objet="<?= htmlspecialchars(calculerTexteEffetObjet($objet, $personnage), ENT_QUOTES, 'UTF-8') ?>"
                            <?php endif; ?>
                        >
                            <?php if ($objet): ?>
                                <?php $cheminIcone = cheminIconeObjet((string)($objet['icone_objet'] ?? '')); ?>

                                <?php if ($cheminIcone !== ''): ?>
                                    <img
                                        class="slot-inventaire-icone"
                                        src="<?= htmlspecialchars($cheminIcone, ENT_QUOTES, 'UTF-8') ?>"
                                        alt="<?= htmlspecialchars((string)($objet['nom_objet'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                        onerror="this.style.display='none'; this.nextElementSibling.classList.add('slot-inventaire-fallback-visible');"
                                    >
                                <?php endif; ?>

                                <div class="slot-inventaire-fallback<?= $cheminIcone === '' ? ' slot-inventaire-fallback-visible' : '' ?>">
                                    <?= htmlspecialchars(substr((string)($objet['nom_objet'] ?? '?'), 0, 3), ENT_QUOTES, 'UTF-8') ?>
                                </div>

                                <?php if ($quantiteObjet > 1): ?>
                                    <span
                                        class="slot-inventaire-quantite"
                                        style="
                                            position: absolute;
                                            right: 4px;
                                            bottom: 2px;
                                            min-width: 18px;
                                            padding: 1px 4px;
                                            border-radius: 10px;
                                            background: rgba(15, 10, 10, 0.92);
                                            border: 1px solid #d48a4a;
                                            color: #ffd37a;
                                            font-size: 12px;
                                            font-weight: 700;
                                            line-height: 1.2;
                                            text-align: center;
                                            z-index: 5;
                                            pointer-events: none;
                                        "
                                    ><?= $quantiteObjet ?></span>
                                <?php endif; ?>

                                <form method="post" class="formulaire-action-objet formulaire-action-equiper">
                                    <input type="hidden" name="action" value="equiper_ou_remplacer_objet">
                                    <input type="hidden" name="instance_objet_id" value="<?= (int)$objet['instance_objet_id'] ?>">
                                    <input type="hidden" name="fenetres_ouvertes" value="inventaire,personnage">
                                </form>

                                <form method="post" class="formulaire-action-objet formulaire-action-utiliser">
                                    <input type="hidden" name="action" value="utiliser_objet_inventaire">
                                    <input type="hidden" name="instance_objet_id" value="<?= (int)$objet['instance_objet_id'] ?>">
                                    <input type="hidden" name="fenetres_ouvertes" value="inventaire,personnage">
                                </form>

                                <form method="post" class="formulaire-action-objet formulaire-action-double-clic">
                                    <input type="hidden" name="action" value="equiper_ou_remplacer_objet">
                                    <input type="hidden" name="instance_objet_id" value="<?= (int)$objet['instance_objet_id'] ?>">
                                    <input type="hidden" name="fenetres_ouvertes" value="inventaire,personnage">
                                </form>

                                <form method="post" class="formulaire-action-objet formulaire-action-jeter">
                                    <input type="hidden" name="action" value="jeter_objet_inventaire">
                                    <input type="hidden" name="instance_objet_id" value="<?= (int)$objet['instance_objet_id'] ?>">
                                    <input type="hidden" name="fenetres_ouvertes" value="inventaire,personnage">
                                </form>
                            <?php else: ?>
                                <span class="texte-cache">Emplacement <?= $indexSlot ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </section>

            <footer class="modele-panneaux-bas-inventaire">
                <section class="panneau-bas-inventaire panneau-bas-gauche">
                    <div class="contenu-panneau-bas-inventaire">
                        <span class="libelle-panneau-bas">Monnaie</span>
                        <strong id="inventaire-monnaie-sac">0 or</strong>
                    </div>
                </section>

                <section class="panneau-bas-inventaire panneau-bas-droite">
                    <div class="contenu-panneau-bas-inventaire contenu-panneau-bas-inventaire-droit">
                        <span class="libelle-panneau-bas">Poids</span>
                        <strong id="inventaire-poids-sac"><?= (int)$poids_inventaire ?> / 100</strong>
                    </div>
                </section>
            </footer>
        </div>
    </div>

    <div id="menu-contextuel-objet" class="menu-contextuel-objet" hidden style="display: none;">
        <button type="button" data-action-menu="utiliser" hidden style="display: none;">Utiliser</button>
        <button type="button" data-action-menu="equiper" hidden style="display: none;">Équiper</button>
        <button type="button" data-action-menu="desequiper" hidden style="display: none;">Déséquiper</button>
        <button type="button" data-action-menu="jeter" hidden style="display: none;">Jeter</button>
    </div>

    <div id="infobulle-objet" class="infobulle-objet" hidden>
        <div class="infobulle-objet-titre"></div>
        <div class="infobulle-objet-ligne infobulle-objet-rarete"></div>
        <div class="infobulle-objet-ligne infobulle-objet-type"></div>
        <div class="infobulle-objet-ligne infobulle-objet-poids"></div>
        <div class="infobulle-objet-description"></div>
        <div class="infobulle-objet-bonus"></div>
    </div>
</div>