(function () {
    let carteDejaInitialisee = false;

    function initialiserCarteElementia() {
        if (carteDejaInitialisee) {
            return;
        }

        const zoneCarte = document.getElementById('zone-carte-monde');
        if (!zoneCarte) {
            return;
        }

        const viewport = document.getElementById('carte-monde-viewport');
        const contenu = document.getElementById('carte-monde-contenu');
        const imageCarte = document.getElementById('image-carte-monde');
        const grille = document.getElementById('grille-carte-monde');
        const repereJoueur = document.getElementById('repere-joueur-monde');
        const valeurPositionJoueur = document.getElementById('valeur-position-joueur');

        if (!viewport || !contenu || !imageCarte || !grille || !repereJoueur || !valeurPositionJoueur) {
            console.error('[Elementia] DOM carte incomplet.');
            return;
        }

        const tailleCase = Number(zoneCarte.dataset.tailleCase || 96);
        const zoomCarte = Number(zoneCarte.dataset.zoom || 1.65);
        const cheminCarte = 'ressources/images/carte/carte_du_monde.png';

        const etatCarte = {
            largeurMonde: 0,
            hauteurMonde: 0,
            colonne: Number(zoneCarte.dataset.colonneDepart || 14),
            ligne: Number(zoneCarte.dataset.ligneDepart || 11),
            cameraX: 0,
            cameraY: 0,
            colonneMax: 0,
            ligneMax: 0
        };

        function borner(valeur, minimum, maximum) {
            return Math.max(minimum, Math.min(maximum, valeur));
        }

        function mettreAJourCoordonneesAffichees() {
            valeurPositionJoueur.textContent = 'Case ' + etatCarte.colonne + ' x ' + etatCarte.ligne;
        }

        function mettreAJourRepereJoueur() {
            const centreX = (etatCarte.colonne * tailleCase) + (tailleCase / 2);
            const centreY = (etatCarte.ligne * tailleCase) + (tailleCase / 2);
            repereJoueur.style.left = centreX + 'px';
            repereJoueur.style.top = centreY + 'px';
        }

        function mettreAJourCamera() {
            const largeurViewport = viewport.clientWidth;
            const hauteurViewport = viewport.clientHeight;
            if (largeurViewport <= 0 || hauteurViewport <= 0) {
                console.warn('[Elementia] Viewport nul', largeurViewport, hauteurViewport);
                return;
            }

            const centreX = (etatCarte.colonne * tailleCase) + (tailleCase / 2);
            const centreY = (etatCarte.ligne * tailleCase) + (tailleCase / 2);

            const cameraXMax = Math.max(0, etatCarte.largeurMonde - largeurViewport);
            const cameraYMax = Math.max(0, etatCarte.hauteurMonde - hauteurViewport);

            etatCarte.cameraX = borner(centreX - (largeurViewport / 2), 0, cameraXMax);
            etatCarte.cameraY = borner(centreY - (hauteurViewport / 2), 0, cameraYMax);

            contenu.style.transform = 'translate3d(' + (-etatCarte.cameraX) + 'px, ' + (-etatCarte.cameraY) + 'px, 0)';
        }

        function rendreCarte() {
            mettreAJourRepereJoueur();
            mettreAJourCamera();
            mettreAJourCoordonneesAffichees();
        }

        function deplacerJoueurVers(colonne, ligne) {
            etatCarte.colonne = borner(colonne, 0, etatCarte.colonneMax);
            etatCarte.ligne = borner(ligne, 0, etatCarte.ligneMax);
            rendreCarte();
        }

        function convertirClickEnCase(evenement) {
            const rectangleViewport = viewport.getBoundingClientRect();
            const xDansViewport = evenement.clientX - rectangleViewport.left;
            const yDansViewport = evenement.clientY - rectangleViewport.top;
            const xMonde = etatCarte.cameraX + xDansViewport;
            const yMonde = etatCarte.cameraY + yDansViewport;
            return {
                colonne: Math.floor(xMonde / tailleCase),
                ligne: Math.floor(yMonde / tailleCase)
            };
        }

        function finaliserInitialisation() {
            etatCarte.largeurMonde = Math.round(imageCarte.naturalWidth * zoomCarte);
            etatCarte.hauteurMonde = Math.round(imageCarte.naturalHeight * zoomCarte);
            etatCarte.colonneMax = Math.max(0, Math.floor(etatCarte.largeurMonde / tailleCase) - 1);
            etatCarte.ligneMax = Math.max(0, Math.floor(etatCarte.hauteurMonde / tailleCase) - 1);

            contenu.style.width = etatCarte.largeurMonde + 'px';
            contenu.style.height = etatCarte.hauteurMonde + 'px';

            imageCarte.style.width = etatCarte.largeurMonde + 'px';
            imageCarte.style.height = etatCarte.hauteurMonde + 'px';
            imageCarte.style.display = 'block';

            grille.style.width = etatCarte.largeurMonde + 'px';
            grille.style.height = etatCarte.hauteurMonde + 'px';
            grille.style.backgroundSize = tailleCase + 'px ' + tailleCase + 'px';
            grille.style.display = 'block';

            rendreCarte();
            carteDejaInitialisee = true;
            console.log('[Elementia] Carte prête', {
                naturalWidth: imageCarte.naturalWidth,
                naturalHeight: imageCarte.naturalHeight,
                viewportWidth: viewport.clientWidth,
                viewportHeight: viewport.clientHeight,
                largeurMonde: etatCarte.largeurMonde,
                hauteurMonde: etatCarte.hauteurMonde
            });
        }

        function essayerInitialiser() {
            if (!imageCarte.complete || imageCarte.naturalWidth <= 0 || viewport.clientWidth <= 0 || viewport.clientHeight <= 0) {
                requestAnimationFrame(essayerInitialiser);
                return;
            }
            finaliserInitialisation();
        }

        viewport.addEventListener('click', function (evenement) {
            const caseCliquee = convertirClickEnCase(evenement);
            deplacerJoueurVers(caseCliquee.colonne, caseCliquee.ligne);
        });

        window.addEventListener('resize', function () {
            if (carteDejaInitialisee) {
                mettreAJourCamera();
            }
        });

        document.addEventListener('keydown', function (evenement) {
            const tagCible = (evenement.target && evenement.target.tagName) ? evenement.target.tagName.toLowerCase() : '';
            if (tagCible === 'input' || tagCible === 'textarea' || tagCible === 'select') {
                return;
            }
            if (evenement.key === 'ArrowUp' || evenement.key === 'z' || evenement.key === 'Z') {
                deplacerJoueurVers(etatCarte.colonne, etatCarte.ligne - 1);
            }
            if (evenement.key === 'ArrowDown' || evenement.key === 's' || evenement.key === 'S') {
                deplacerJoueurVers(etatCarte.colonne, etatCarte.ligne + 1);
            }
            if (evenement.key === 'ArrowLeft' || evenement.key === 'q' || evenement.key === 'Q') {
                deplacerJoueurVers(etatCarte.colonne - 1, etatCarte.ligne);
            }
            if (evenement.key === 'ArrowRight' || evenement.key === 'd' || evenement.key === 'D') {
                deplacerJoueurVers(etatCarte.colonne + 1, etatCarte.ligne);
            }
        });

        imageCarte.addEventListener('error', function () {
            console.error('[Elementia] Image carte introuvable : ' + cheminCarte);
        });

        imageCarte.src = cheminCarte;
        essayerInitialiser();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialiserCarteElementia);
    } else {
        initialiserCarteElementia();
    }
})();