document.addEventListener('DOMContentLoaded', function () {
    const pageJeu = document.querySelector('.page-jeu');

    if (!pageJeu) {
        return;
    }

    const fondFenetresJeu = document.getElementById('fond-fenetres-jeu');
    const boutonsFenetre = document.querySelectorAll('[data-fenetre]');
    const boutonsFermeture = document.querySelectorAll('[data-fermer-fenetre="oui"]');
    const selectQualiteGraphique = document.getElementById('qualite-graphique');
    const curseurVolumeGeneral = document.getElementById('volume-general');
    const texteVolumeGeneral = document.getElementById('texte-volume-general');
    const boutonPleinEcran = document.getElementById('bouton-plein-ecran');
    const boutonReductionBlocInformations = document.getElementById('bouton-reduire-bloc-informations');
    const blocInformationsJoueur = document.getElementById('bloc-informations-joueur');
    const cleStockageParametres = 'elementia_parametres_jeu';
    const cleStockageBlocInformations = 'elementia_bloc_informations_reduit';

    function obtenirFenetreParCle(cleFenetre) {
        if (!cleFenetre) {
            return null;
        }

        return document.querySelector('[data-cle-fenetre="' + cleFenetre + '"]');
    }

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

    function fermerToutesLesFenetresJeu() {
        const fenetres = document.querySelectorAll('[data-cle-fenetre]');

        fenetres.forEach(function (fenetre) {
            fenetre.classList.add('fenetre-jeu-cachee');
            fenetre.setAttribute('aria-hidden', 'true');
        });
    }

    function ouvrirFenetreJeu(cleFenetre) {
        if (!fondFenetresJeu) {
            return;
        }

        const fenetre = obtenirFenetreParCle(cleFenetre);

        if (!fenetre) {
            window.alert('Cette fenêtre sera branchée dans une prochaine étape : ' + cleFenetre + '.');
            return;
        }

        fermerToutesLesFenetresJeu();
        fenetre.classList.remove('fenetre-jeu-cachee');
        fenetre.setAttribute('aria-hidden', 'false');

        fondFenetresJeu.classList.add('visible');
        fondFenetresJeu.setAttribute('aria-hidden', 'false');
    }

    function fermerFenetreJeu() {
        if (!fondFenetresJeu) {
            return;
        }

        fondFenetresJeu.classList.remove('visible');
        fondFenetresJeu.setAttribute('aria-hidden', 'true');
        fermerToutesLesFenetresJeu();
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

    boutonsFenetre.forEach(function (bouton) {
        bouton.addEventListener('click', function () {
            const cleFenetre = bouton.getAttribute('data-fenetre');
            ouvrirFenetreJeu(cleFenetre);
        });
    });

    boutonsFermeture.forEach(function (bouton) {
        bouton.addEventListener('click', fermerFenetreJeu);
    });

    if (fondFenetresJeu) {
        fondFenetresJeu.addEventListener('click', function (evenement) {
            if (evenement.target === fondFenetresJeu) {
                fermerFenetreJeu();
            }
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

    document.addEventListener('keydown', function (evenement) {
        if (evenement.key === 'Escape' && fondFenetresJeu && fondFenetresJeu.classList.contains('visible')) {
            fermerFenetreJeu();
        }
    });
});