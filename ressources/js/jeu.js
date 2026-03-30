document.addEventListener('DOMContentLoaded', function () {
    const pageJeu = document.querySelector('.page-jeu');

    if (!pageJeu) {
        return;
    }

    const selectQualiteGraphique = document.getElementById('qualite-graphique');
    const curseurVolumeGeneral = document.getElementById('volume-general');
    const texteVolumeGeneral = document.getElementById('texte-volume-general');
    const boutonPleinEcran = document.getElementById('bouton-plein-ecran');
    const boutonReductionBlocInformations = document.getElementById('bouton-reduire-bloc-informations');
    const blocInformationsJoueur = document.getElementById('bloc-informations-joueur');
    const cleStockageParametres = 'elementia_parametres_jeu';
    const cleStockageBlocInformations = 'elementia_bloc_informations_reduit';

    function lireParametresJeu() {
        try {
            const valeurBrute = window.localStorage.getItem(cleStockageParametres);

            if (!valeurBrute) {
                return {
                    qualite_graphique: 'elevee',
                    volume_general: 70
                };
            }

            const donnees = JSON.parse(valeurBrute);

            return {
                qualite_graphique: donnees.qualite_graphique || 'elevee',
                volume_general: Number.isFinite(Number(donnees.volume_general)) ? Number(donnees.volume_general) : 70
            };
        } catch (erreur) {
            return {
                qualite_graphique: 'elevee',
                volume_general: 70
            };
        }
    }

    function sauvegarderParametresJeu(parametres) {
        window.localStorage.setItem(cleStockageParametres, JSON.stringify(parametres));
    }

    function appliquerQualiteGraphique(valeur) {
        document.body.setAttribute('data-qualite-graphique', valeur);
    }

    function mettreAJourTexteVolume(valeur) {
        if (texteVolumeGeneral) {
            texteVolumeGeneral.textContent = String(valeur) + '%';
        }
    }

    function appliquerEtatBlocInformations(estReduit) {
        if (!blocInformationsJoueur || !boutonReductionBlocInformations) {
            return;
        }

        if (estReduit) {
            blocInformationsJoueur.classList.add('reduit');
            boutonReductionBlocInformations.textContent = '+';
            boutonReductionBlocInformations.setAttribute('aria-expanded', 'false');
            boutonReductionBlocInformations.setAttribute('title', 'Afficher le bloc');
        } else {
            blocInformationsJoueur.classList.remove('reduit');
            boutonReductionBlocInformations.textContent = '−';
            boutonReductionBlocInformations.setAttribute('aria-expanded', 'true');
            boutonReductionBlocInformations.setAttribute('title', 'Réduire le bloc');
        }
    }

    function initialiserAffichageTempsJeu() {
        const valeurTempsJeu = document.getElementById('valeur-temps-jeu');
        const valeurDateJeu = document.getElementById('valeur-date-jeu');
        const calendrierNomMois = document.getElementById('calendrier-nom-mois');
        const calendrierJour = document.getElementById('calendrier-jour');
        const calendrierHeure = document.getElementById('calendrier-heure');
        const calendrierPeriode = document.getElementById('calendrier-periode');
        const calendrierImage = document.getElementById('calendrier-image-mois');
        const debugTempsHeure = document.getElementById('debug-temps-heure');
        const debugTempsDate = document.getElementById('debug-temps-date');
        const debugTempsPeriode = document.getElementById('debug-temps-periode');
        const debugTempsEtat = document.getElementById('debug-temps-etat');
        const debugTempsVitesse = document.getElementById('debug-temps-vitesse');

        document.addEventListener('elementia:temps-mis-a-jour', function (evenement) {
            const detail = evenement.detail;

            if (valeurTempsJeu) {
                valeurTempsJeu.textContent = detail.texte_heure + ' · ' + detail.periode;
            }

            if (valeurDateJeu) {
                valeurDateJeu.textContent = 'Jour ' + String(detail.jour) + ' · ' + detail.nom_mois;
            }

            if (calendrierNomMois) {
                calendrierNomMois.textContent = detail.nom_mois;
            }

            if (calendrierJour) {
                calendrierJour.textContent = String(detail.jour);
            }

            if (calendrierHeure) {
                calendrierHeure.textContent = detail.texte_heure;
            }

            if (calendrierPeriode) {
                calendrierPeriode.textContent = detail.periode;
            }

            if (calendrierImage && window.ElementiaTemps) {
                calendrierImage.src = window.ElementiaTemps.obtenirCheminImageMois(detail.mois);
            }

            if (debugTempsHeure) {
                debugTempsHeure.textContent = detail.texte_heure;
            }

            if (debugTempsDate) {
                debugTempsDate.textContent = 'Jour ' + String(detail.jour) + ' · ' + detail.nom_mois;
            }

            if (debugTempsPeriode) {
                debugTempsPeriode.textContent = detail.periode;
            }

            if (debugTempsEtat) {
                debugTempsEtat.textContent = detail.est_en_pause ? 'En pause' : 'En cours';
            }

            if (debugTempsVitesse) {
                debugTempsVitesse.textContent = 'x' + String(detail.vitesse);
            }
        });

        if (window.ElementiaTemps) {
            window.ElementiaTemps.diffuserMiseAJourTemps();
        }
    }

    function initialiserDebugTempsJeu() {
        const configurationBoutons = [
            ['bouton-debug-temps-pause', function () { window.ElementiaTemps.pause(); }],
            ['bouton-debug-temps-reprendre', function () { window.ElementiaTemps.reprendre(); }],
            ['bouton-debug-temps-plus-heure', function () { window.ElementiaTemps.ajouterHeures(1); }],
            ['bouton-debug-temps-moins-heure', function () { window.ElementiaTemps.ajouterHeures(-1); }],
            ['bouton-debug-temps-plus-jour', function () { window.ElementiaTemps.ajouterJours(1); }],
            ['bouton-debug-temps-moins-jour', function () { window.ElementiaTemps.ajouterJours(-1); }],
            ['bouton-debug-temps-forcer-jour', function () { window.ElementiaTemps.forcerJour(); }],
            ['bouton-debug-temps-forcer-nuit', function () { window.ElementiaTemps.forcerNuit(); }],
            ['bouton-debug-temps-vitesse-1', function () { window.ElementiaTemps.definirVitesse(1); }],
            ['bouton-debug-temps-vitesse-2', function () { window.ElementiaTemps.definirVitesse(2); }],
            ['bouton-debug-temps-vitesse-5', function () { window.ElementiaTemps.definirVitesse(5); }]
        ];

        configurationBoutons.forEach(function (configuration) {
            const bouton = document.getElementById(configuration[0]);

            if (!bouton || !window.ElementiaTemps) {
                return;
            }

            bouton.addEventListener('click', function () {
                configuration[1]();
            });
        });
    }

    const parametresJeu = lireParametresJeu();

    if (selectQualiteGraphique) {
        selectQualiteGraphique.value = parametresJeu.qualite_graphique;
        appliquerQualiteGraphique(parametresJeu.qualite_graphique);

        selectQualiteGraphique.addEventListener('change', function () {
            parametresJeu.qualite_graphique = selectQualiteGraphique.value;
            appliquerQualiteGraphique(parametresJeu.qualite_graphique);
            sauvegarderParametresJeu(parametresJeu);
        });
    }

    if (curseurVolumeGeneral) {
        curseurVolumeGeneral.value = String(parametresJeu.volume_general);
        mettreAJourTexteVolume(parametresJeu.volume_general);

        curseurVolumeGeneral.addEventListener('input', function () {
            parametresJeu.volume_general = Number(curseurVolumeGeneral.value);
            mettreAJourTexteVolume(parametresJeu.volume_general);
            sauvegarderParametresJeu(parametresJeu);
        });
    }

    if (boutonPleinEcran) {
        boutonPleinEcran.addEventListener('click', async function () {
            try {
                if (!document.fullscreenElement) {
                    await document.documentElement.requestFullscreen();
                } else {
                    await document.exitFullscreen();
                }
            } catch (erreur) {
                window.alert('Le plein écran n’a pas pu être modifié sur ce navigateur.');
            }
        });
    }

    if (blocInformationsJoueur) {
        blocInformationsJoueur.addEventListener('click', function (evenement) {
            evenement.stopPropagation();
        });

        blocInformationsJoueur.addEventListener('mousedown', function (evenement) {
            evenement.stopPropagation();
        });
    }

    if (boutonReductionBlocInformations && blocInformationsJoueur) {
        const etatInitialReduit = window.localStorage.getItem(cleStockageBlocInformations) === 'oui';
        appliquerEtatBlocInformations(etatInitialReduit);

        boutonReductionBlocInformations.addEventListener('click', function (evenement) {
            evenement.preventDefault();
            evenement.stopPropagation();

            const estReduit = !blocInformationsJoueur.classList.contains('reduit');
            appliquerEtatBlocInformations(estReduit);
            window.localStorage.setItem(cleStockageBlocInformations, estReduit ? 'oui' : 'non');
        });

        boutonReductionBlocInformations.addEventListener('mousedown', function (evenement) {
            evenement.preventDefault();
            evenement.stopPropagation();
        });
    }

    initialiserAffichageTempsJeu();
    initialiserDebugTempsJeu();
});
