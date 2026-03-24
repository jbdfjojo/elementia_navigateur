<?php
$chemin_image = 'ressources/images/carte/carte_du_monde.png';
$taille_case = 64;
$zoom = 1.65;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cartographie du monde</title>
<style>
    * { box-sizing: border-box; }
    body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        background: #10151d;
        color: #f2eadb;
    }
    .barre-outils {
        position: sticky;
        top: 0;
        z-index: 20;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        padding: 10px 12px;
        background: rgba(10, 12, 16, 0.96);
        border-bottom: 1px solid rgba(255,255,255,0.10);
    }
    .palette {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
    }
    .pastille {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        border: 2px solid rgba(255,255,255,0.25);
        cursor: pointer;
    }
    .pastille.active {
        outline: 3px solid #ffffff;
        outline-offset: 1px;
    }
    button {
        padding: 8px 12px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        background: #d1972c;
        color: #fff;
        font-weight: bold;
    }
    button.secondaire {
        background: #4d5968;
    }
    .infos {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        font-size: 14px;
        color: #cfd8e3;
    }
    .conteneur {
        padding: 16px;
        overflow: auto;
    }
    .planche {
        position: relative;
        display: inline-block;
        line-height: 0;
        user-select: none;
    }
    .carte {
        display: block;
        transform-origin: top left;
    }
    .grille {
        position: absolute;
        inset: 0;
        pointer-events: auto;
    }
    .case {
        position: absolute;
        border: 1px solid rgba(180, 225, 255, 0.35);
        color: rgba(255,255,255,0.65);
        font-size: 11px;
        line-height: 1;
        padding: 4px;
        overflow: hidden;
        cursor: crosshair;
    }
    .case:hover {
        box-shadow: inset 0 0 0 2px rgba(255,255,255,0.45);
    }
    .panneau-export {
        padding: 12px;
        background: rgba(255,255,255,0.04);
        border-top: 1px solid rgba(255,255,255,0.10);
    }
    textarea {
        width: 100%;
        min-height: 220px;
        resize: vertical;
        background: #0b0f14;
        color: #dfe8f2;
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 8px;
        padding: 12px;
        font-family: Consolas, monospace;
        font-size: 13px;
    }
</style>
</head>
<body>
<div class="barre-outils">
    <div class="palette" id="palette"></div>
    <button id="bouton-effacer" class="secondaire" type="button">Effacer la case</button>
    <button id="bouton-exporter" type="button">Exporter le JSON complet</button>
    <button id="bouton-reset" class="secondaire" type="button">Réinitialiser</button>
    <div class="infos">
        <span id="info-dimensions"></span>
        <span id="info-case-active"></span>
    </div>
</div>

<div class="conteneur">
    <div class="planche" id="planche-carte">
        <img id="image-carte" class="carte" src="<?php echo htmlspecialchars($chemin_image, ENT_QUOTES, 'UTF-8'); ?>" alt="Carte du monde">
        <div id="grille-carte" class="grille"></div>
    </div>
</div>

<div class="panneau-export">
    <textarea id="sortie-json" placeholder="Le JSON complet apparaîtra ici..."></textarea>
</div>

<script>
(function () {
    const tailleCase = <?php echo (int)$taille_case; ?>;
    const zoom = <?php echo json_encode($zoom); ?>;
    const cleStockage = 'elementia_cartographie_monde_v4';

    const types = [
        { code: 'plaine', couleur: 'rgba(64, 214, 54, 0.45)', titre: 'Plaine' },
        { code: 'eau', couleur: 'rgba(67, 167, 255, 0.45)', titre: 'Eau' },
        { code: 'montagne', couleur: 'rgba(120, 120, 120, 0.50)', titre: 'Montagne' },
        { code: 'route', couleur: 'rgba(163, 102, 43, 0.50)', titre: 'Route' },
        { code: 'ville', couleur: 'rgba(255, 215, 84, 0.55)', titre: 'Ville' },
        { code: 'ponton', couleur: 'rgba(255, 146, 36, 0.55)', titre: 'Ponton' },
        { code: 'foret', couleur: 'rgba(20, 135, 54, 0.50)', titre: 'Forêt' },
        { code: 'zone_speciale', couleur: 'rgba(176, 88, 255, 0.45)', titre: 'Zone spéciale' },
        { code: 'danger', couleur: 'rgba(255, 74, 74, 0.48)', titre: 'Danger' },
    ];

    const imageCarte = document.getElementById('image-carte');
    const grilleCarte = document.getElementById('grille-carte');
    const palette = document.getElementById('palette');
    const boutonExporter = document.getElementById('bouton-exporter');
    const boutonEffacer = document.getElementById('bouton-effacer');
    const boutonReset = document.getElementById('bouton-reset');
    const sortieJson = document.getElementById('sortie-json');
    const infoDimensions = document.getElementById('info-dimensions');
    const infoCaseActive = document.getElementById('info-case-active');

    let typeActif = 'plaine';
    let dessinActif = false;
    let colonnes = 0;
    let lignes = 0;
    let largeurAffichee = 0;
    let hauteurAffichee = 0;

    const etatCases = {};

    function sauvegarder() {
        localStorage.setItem(cleStockage, JSON.stringify(etatCases));
    }

    function charger() {
        try {
            const brut = localStorage.getItem(cleStockage);
            if (!brut) return;
            const data = JSON.parse(brut);
            if (data && typeof data === 'object') {
                Object.assign(etatCases, data);
            }
        } catch (e) {}
    }

    function couleurDuType(code) {
        const entree = types.find(t => t.code === code);
        return entree ? entree.couleur : 'transparent';
    }

    function construirePalette() {
        palette.innerHTML = '';
        types.forEach((type) => {
            const bouton = document.createElement('button');
            bouton.type = 'button';
            bouton.className = 'pastille' + (type.code === typeActif ? ' active' : '');
            bouton.style.background = type.couleur;
            bouton.title = type.titre;
            bouton.dataset.type = type.code;
            bouton.addEventListener('click', function () {
                typeActif = type.code;
                construirePalette();
            });
            palette.appendChild(bouton);
        });
    }

    function mettreAJourCase(colonne, ligne, type) {
        const cle = colonne + '_' + ligne;
        etatCases[cle] = type;
        const cellule = grilleCarte.querySelector('[data-cle="' + cle + '"]');
        if (cellule) cellule.style.background = couleurDuType(type);
        infoCaseActive.textContent = 'Case active : ' + colonne + ',' + ligne + ' → ' + type;
        sauvegarder();
    }

    function effacerCase(colonne, ligne) {
        const cle = colonne + '_' + ligne;
        delete etatCases[cle];
        const cellule = grilleCarte.querySelector('[data-cle="' + cle + '"]');
        if (cellule) cellule.style.background = 'transparent';
        infoCaseActive.textContent = 'Case active : ' + colonne + ',' + ligne + ' → vide';
        sauvegarder();
    }

    function appliquerActionSurCellule(cellule, effacer = false) {
        const colonne = Number(cellule.dataset.colonne);
        const ligne = Number(cellule.dataset.ligne);
        if (effacer) {
            effacerCase(colonne, ligne);
        } else {
            mettreAJourCase(colonne, ligne, typeActif);
        }
    }

    function genererJsonComplet() {
        const casesCompletes = [];
        for (let ligne = 0; ligne < lignes; ligne += 1) {
            for (let colonne = 0; colonne < colonnes; colonne += 1) {
                const cle = colonne + '_' + ligne;
                casesCompletes.push({
                    colonne: colonne,
                    ligne: ligne,
                    type: etatCases[cle] || 'vide'
                });
            }
        }

        return {
            version: 2,
            carte_code: 'monde_principal',
            largeur_source: imageCarte.naturalWidth,
            hauteur_source: imageCarte.naturalHeight,
            zoom: zoom,
            largeur_affichee: largeurAffichee,
            hauteur_affichee: hauteurAffichee,
            taille_case: tailleCase,
            colonnes: colonnes,
            lignes: lignes,
            total_cases: colonnes * lignes,
            cases: casesCompletes
        };
    }

    function construireGrille() {
        largeurAffichee = Math.round(imageCarte.naturalWidth * zoom);
        hauteurAffichee = Math.round(imageCarte.naturalHeight * zoom);
        colonnes = Math.ceil(largeurAffichee / tailleCase);
        lignes = Math.ceil(hauteurAffichee / tailleCase);

        imageCarte.style.width = largeurAffichee + 'px';
        imageCarte.style.height = hauteurAffichee + 'px';
        grilleCarte.style.width = largeurAffichee + 'px';
        grilleCarte.style.height = hauteurAffichee + 'px';

        grilleCarte.innerHTML = '';

        for (let ligne = 0; ligne < lignes; ligne += 1) {
            for (let colonne = 0; colonne < colonnes; colonne += 1) {
                const cellule = document.createElement('div');
                const cle = colonne + '_' + ligne;
                cellule.className = 'case';
                cellule.dataset.colonne = String(colonne);
                cellule.dataset.ligne = String(ligne);
                cellule.dataset.cle = cle;
                cellule.textContent = colonne + ',' + ligne;
                cellule.style.left = (colonne * tailleCase) + 'px';
                cellule.style.top = (ligne * tailleCase) + 'px';
                cellule.style.width = tailleCase + 'px';
                cellule.style.height = tailleCase + 'px';
                cellule.style.background = couleurDuType(etatCases[cle] || 'vide');

                cellule.addEventListener('mousedown', function (event) {
                    event.preventDefault();
                    dessinActif = true;
                    appliquerActionSurCellule(cellule, false);
                });

                cellule.addEventListener('mouseenter', function () {
                    if (dessinActif) {
                        appliquerActionSurCellule(cellule, false);
                    }
                });

                grilleCarte.appendChild(cellule);
            }
        }

        infoDimensions.textContent = 'Grille : ' + colonnes + ' colonnes × ' + lignes + ' lignes = ' + (colonnes * lignes) + ' cases';
    }

    boutonExporter.addEventListener('click', function () {
        sortieJson.value = JSON.stringify(genererJsonComplet(), null, 2);
        sortieJson.focus();
        sortieJson.select();
    });

    boutonEffacer.addEventListener('mousedown', function (event) {
        event.preventDefault();
        const gestionnaire = function (evt) {
            const cellule = evt.target.closest('.case');
            if (cellule) {
                appliquerActionSurCellule(cellule, true);
            }
        };

        document.addEventListener('mousedown', gestionnaire, { once: true });
    });

    boutonReset.addEventListener('click', function () {
        if (!confirm('Réinitialiser toute la cartographie locale de cette page ?')) return;
        Object.keys(etatCases).forEach((cle) => delete etatCases[cle]);
        sauvegarder();
        construireGrille();
        sortieJson.value = '';
    });

    document.addEventListener('mouseup', function () {
        dessinActif = false;
    });

    document.addEventListener('mouseleave', function () {
        dessinActif = false;
    });

    charger();
    construirePalette();

    if (imageCarte.complete && imageCarte.naturalWidth > 0) {
        construireGrille();
    } else {
        imageCarte.addEventListener('load', construireGrille, { once: true });
    }
})();
</script>
</body>
</html>
