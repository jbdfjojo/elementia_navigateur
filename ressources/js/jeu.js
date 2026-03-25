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
});
