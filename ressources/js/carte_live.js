(function () {
    let dernierePositionEnvoyee = null;
    let dernierEtatCharge = null;

    function lirePositionDepuisInterface() {
        const valeurPosition = document.getElementById('valeur-position-joueur');
        if (!valeurPosition) {
            return null;
        }

        const correspondance = valeurPosition.textContent.match(/(\d+)\s*x\s*(\d+)/i);
        if (!correspondance) {
            return null;
        }

        return {
            x: Number(correspondance[1]),
            y: Number(correspondance[2])
        };
    }

    function appelerApi(action, donnees) {
        const corps = new URLSearchParams();
        corps.set('action', action);

        Object.keys(donnees || {}).forEach(function (cle) {
            corps.set(cle, String(donnees[cle]));
        });

        return fetch('api_carte.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
            body: corps.toString(),
            credentials: 'same-origin'
        }).then(function (reponse) {
            return reponse.json();
        });
    }

    function appliquerPositionMonde(position) {
        const marqueurCarte = document.getElementById('marqueur-carte-joueur');
        const cadreCarte = document.getElementById('cadre-carte-complete');

        if (!marqueurCarte || !cadreCarte || !position) {
            return;
        }

        const colonnes = Number(cadreCarte.dataset.colonnes || 40);
        const lignes = Number(cadreCarte.dataset.lignes || 27);

        marqueurCarte.style.left = (((position.x + 0.5) / colonnes) * 100) + '%';
        marqueurCarte.style.top = (((position.y + 0.5) / lignes) * 100) + '%';
        marqueurCarte.title = 'Vous (' + position.x + ' x ' + position.y + ')';
        cadreCarte.dataset.positionX = String(position.x);
        cadreCarte.dataset.positionY = String(position.y);
    }

    function appliquerFlecheUnique(element, position, destination, couleur, prefixe) {
        if (!element || !position) {
            return null;
        }

        if (!destination) {
            element.style.opacity = '0';
            element.style.transform = 'translate(-50%, -50%) rotate(0deg)';
            element.title = prefixe + ' : aucune';
            return {
                texte: prefixe + ' : aucune',
                titre: prefixe + ' : aucune'
            };
        }

        const deltaX = Number(destination.x) - Number(position.x);
        const deltaY = Number(destination.y) - Number(position.y);
        const nom = destination.nom || prefixe;

        if (deltaX === 0 && deltaY === 0) {
            element.style.opacity = '1';
            element.style.transform = 'translate(-50%, -50%) rotate(0deg)';
            element.style.color = couleur;
            element.title = prefixe + ' atteinte : ' + nom;
            return {
                texte: prefixe + ' : atteinte',
                titre: element.title
            };
        }

        const angle = Math.atan2(deltaY, deltaX) * (180 / Math.PI);
        const distance = Math.max(Math.abs(deltaX), Math.abs(deltaY));

        element.style.opacity = '1';
        element.style.transform = 'translate(-50%, -50%) rotate(' + angle + 'deg)';
        element.style.color = couleur;
        element.title = prefixe + ' : ' + nom + ' (' + distance + ' case(s))';

        return {
            texte: prefixe + ' : ' + nom + ' (' + distance + ' case(s))',
            titre: element.title
        };
    }

    function appliquerFlechesDirection(position, destinationQuete, destinationRepere) {
        const texteDirection = document.getElementById('valeur-direction-joueur');
        const flecheQuete = document.getElementById('fleche-direction-quete');
        const flecheRepere = document.getElementById('fleche-direction-repere');
        const repereJoueur = document.getElementById('repere-joueur-monde');

        if (!texteDirection || !position) {
            return;
        }

        const resultatQuete = appliquerFlecheUnique(flecheQuete, position, destinationQuete, '#ffd44f', 'Quête');
        const resultatRepere = appliquerFlecheUnique(flecheRepere, position, destinationRepere, '#ff4fa3', 'Repère');

        texteDirection.textContent =
            (resultatQuete ? resultatQuete.texte : 'Quête : aucune') +
            ' · ' +
            (resultatRepere ? resultatRepere.texte : 'Repère : aucun');

        if (repereJoueur) {
            repereJoueur.title =
                (resultatQuete ? resultatQuete.titre : 'Quête : aucune') +
                ' | ' +
                (resultatRepere ? resultatRepere.titre : 'Repère : aucun');
        }
    }

    function appliquerMarqueurQuete(queteActive) {
        const marqueur = document.getElementById('marqueur-carte-quete');
        const cadreCarte = document.getElementById('cadre-carte-complete');

        if (!marqueur || !cadreCarte) {
            return;
        }

        if (!queteActive) {
            marqueur.style.display = 'none';
            return;
        }

        const colonnes = Number(cadreCarte.dataset.colonnes || 40);
        const lignes = Number(cadreCarte.dataset.lignes || 27);

        marqueur.style.display = '';
        marqueur.style.left = (((Number(queteActive.x) + 0.5) / colonnes) * 100) + '%';
        marqueur.style.top = (((Number(queteActive.y) + 0.5) / lignes) * 100) + '%';
        marqueur.title = (queteActive.titre || 'Quête suivie') + ' (' + queteActive.x + ' x ' + queteActive.y + ')';

        const etiquette = marqueur.querySelector('.marqueur-carte-etiquette');
        if (etiquette) {
            etiquette.textContent = queteActive.titre || 'Quête suivie';
        }
    }

    function reconstruireReperes(reperes) {
        const calque = document.getElementById('calque-reperes-personnels');
        const cadreCarte = document.getElementById('cadre-carte-complete');

        if (!calque || !cadreCarte) {
            return;
        }

        const colonnes = Number(cadreCarte.dataset.colonnes || 40);
        const lignes = Number(cadreCarte.dataset.lignes || 27);
        calque.innerHTML = '';

        (reperes || []).forEach(function (repere) {
            const element = document.createElement('button');
            element.type = 'button';
            element.className =
                'marqueur-carte marqueur-carte-personnel marqueur-carte-repere' +
                ((repere.selectionne || repere.actif) ? ' selectionne' : '');

            element.style.left = (((Number(repere.x) + 0.5) / colonnes) * 100) + '%';
            element.style.top = (((Number(repere.y) + 0.5) / lignes) * 100) + '%';
            element.title = (repere.nom || 'Repère') + ' (' + repere.x + ' x ' + repere.y + ')';
            element.dataset.id = String(repere.id);
            element.dataset.type = 'repere';

            const point = document.createElement('span');
            point.className = 'marqueur-carte-point';

            const etiquette = document.createElement('span');
            etiquette.className = 'marqueur-carte-etiquette';
            etiquette.textContent = repere.nom || 'Repère';

            element.appendChild(point);
            element.appendChild(etiquette);

            element.addEventListener('click', function (evenement) {
                evenement.preventDefault();
                evenement.stopPropagation();

                appelerApi('definir_repere_actif', { repere_id: repere.id }).then(function () {
                    chargerEtatServeur();
                }).catch(function (erreur) {
                    console.warn('Impossible de définir le repère actif.', erreur);
                });
            });

            calque.appendChild(element);
        });
    }

    function chargerEtatServeur() {
        appelerApi('charger_etat', {}).then(function (etat) {
            if (!etat || !etat.ok) {
                return;
            }

            dernierEtatCharge = etat;

            appliquerPositionMonde(etat.position);
            reconstruireReperes(etat.reperes || []);
            appliquerMarqueurQuete(etat.quete_active || null);

            let destinationQuete = null;
            let destinationRepere = null;

            if (etat.quete_suivie) {
                destinationQuete = {
                    x: Number(etat.quete_suivie.x),
                    y: Number(etat.quete_suivie.y),
                    nom: etat.quete_suivie.titre || 'Quête suivie',
                    type: 'quete'
                };
            }

            if (etat.repere_selectionne) {
                destinationRepere = {
                    x: Number(etat.repere_selectionne.x),
                    y: Number(etat.repere_selectionne.y),
                    nom: etat.repere_selectionne.nom || 'Repère',
                    type: 'repere'
                };
            }

            appliquerFlechesDirection(etat.position, destinationQuete, destinationRepere);
        }).catch(function (erreur) {
            console.warn('Impossible de charger l’état carte.', erreur);
        });
    }

    function surveillerPosition() {
        const position = lirePositionDepuisInterface();

        if (!position) {
            return;
        }

        const cle = position.x + '_' + position.y;
        if (cle === dernierePositionEnvoyee) {
            return;
        }

        dernierePositionEnvoyee = cle;

        appelerApi('sauvegarder_position', {
            position_x: position.x,
            position_y: position.y
        }).then(function () {
            chargerEtatServeur();
        }).catch(function (erreur) {
            console.warn('Impossible de sauvegarder la position.', erreur);
        });
    }

    function initialiserSuiviQuetes() {
        document.querySelectorAll('.case-a-cocher-suivi-quete').forEach(function (caseSuivi) {
            caseSuivi.addEventListener('change', function () {
                document.querySelectorAll('.case-a-cocher-suivi-quete').forEach(function (autreCase) {
                    if (autreCase !== caseSuivi) {
                        autreCase.checked = false;
                    }
                });

                appelerApi('definir_quete_suivie', {
                    quete_id: caseSuivi.checked ? Number(caseSuivi.dataset.queteId || 0) : 0
                }).then(function () {
                    chargerEtatServeur();
                }).catch(function (erreur) {
                    console.warn('Impossible de définir la quête suivie.', erreur);
                });
            });
        });
    }

    function initialiserReperesCarte() {
        const cadreCarte = document.getElementById('cadre-carte-complete');
        const boutonAjouter = document.getElementById('bouton-ajouter-repere-carte');
        const boutonSupprimer = document.getElementById('bouton-supprimer-repere-carte');
        const etatMode = document.getElementById('etat-mode-carte');

        if (!cadreCarte || !boutonAjouter || !boutonSupprimer || !etatMode) {
            return;
        }

        let modePlacement = false;

        boutonAjouter.addEventListener('click', function () {
            modePlacement = !modePlacement;
            cadreCarte.classList.toggle('mode-placement', modePlacement);
            etatMode.textContent = modePlacement ? 'Mode placement actif : cliquez sur une case.' : 'Mode normal';
        });

        boutonSupprimer.addEventListener('click', function () {
            if (!dernierEtatCharge || !Array.isArray(dernierEtatCharge.reperes)) {
                return;
            }

            const repereActif = dernierEtatCharge.reperes.find(function (repere) {
                return !!repere.actif || !!repere.selectionne;
            });

            if (!repereActif) {
                return;
            }

            appelerApi('supprimer_repere', { repere_id: repereActif.id }).then(function () {
                chargerEtatServeur();
            }).catch(function (erreur) {
                console.warn('Impossible de supprimer le repère.', erreur);
            });
        });

        cadreCarte.addEventListener('click', function (evenement) {
            if (!modePlacement) {
                return;
            }

            const rectangle = cadreCarte.getBoundingClientRect();
            const colonnes = Number(cadreCarte.dataset.colonnes || 40);
            const lignes = Number(cadreCarte.dataset.lignes || 27);

            const colonne = Math.max(
                0,
                Math.min(
                    colonnes - 1,
                    Math.floor(((evenement.clientX - rectangle.left) / rectangle.width) * colonnes)
                )
            );

            const ligne = Math.max(
                0,
                Math.min(
                    lignes - 1,
                    Math.floor(((evenement.clientY - rectangle.top) / rectangle.height) * lignes)
                )
            );

            const nomPropose = 'Repère ' + colonne + ' x ' + ligne;
            const nom = window.prompt('Nom du repère :', nomPropose);

            if (nom === null) {
                return;
            }

            appelerApi('creer_repere', {
                nom: String(nom).trim() || nomPropose,
                position_x: colonne,
                position_y: ligne
            }).then(function () {
                modePlacement = false;
                cadreCarte.classList.remove('mode-placement');
                etatMode.textContent = 'Mode normal';
                chargerEtatServeur();
            }).catch(function (erreur) {
                console.warn('Impossible de créer le repère.', erreur);
            });
        });
    }

    function initialiser() {
        if (!document.body || document.body.dataset.estVueJeu !== 'oui') {
            return;
        }

        initialiserSuiviQuetes();
        initialiserReperesCarte();
        chargerEtatServeur();
        window.setInterval(surveillerPosition, 500);
        window.setInterval(chargerEtatServeur, 2000);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialiser);
    } else {
        initialiser();
    }
})();