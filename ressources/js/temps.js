(function () {
    const cleStockageTemps = 'elementia_temps_global';
    const dureeSecondeJeuParSecondeReelle = 6;
    const dureeJourJeuEnSecondes = 24 * 60 * 60;
    const dureeMoisJeuEnJours = 28;
    const nombreMoisJeu = 12;
    const dureeMoisJeuEnSecondes = dureeMoisJeuEnJours * dureeJourJeuEnSecondes;
    const dureeAnneeJeuEnSecondes = nombreMoisJeu * dureeMoisJeuEnSecondes;
    const nomsMois = [
        'Mois 1', 'Mois 2', 'Mois 3', 'Mois 4', 'Mois 5', 'Mois 6',
        'Mois 7', 'Mois 8', 'Mois 9', 'Mois 10', 'Mois 11', 'Mois 12'
    ];

    function normaliserSecondesJeu(secondes) {
        let valeur = Math.floor(Number(secondes) || 0);

        while (valeur < 0) {
            valeur += dureeAnneeJeuEnSecondes;
        }

        return valeur % dureeAnneeJeuEnSecondes;
    }

    function lireEtatTemps() {
        try {
            const donneesBrutes = window.localStorage.getItem(cleStockageTemps);

            if (!donneesBrutes) {
                return {
                    est_en_pause: false,
                    vitesse: 1,
                    secondes_jeu_reference: (7 * 24 * 60 * 60) + (8 * 60 * 60),
                    horodatage_reference: Date.now()
                };
            }

            const donnees = JSON.parse(donneesBrutes);

            return {
                est_en_pause: donnees.est_en_pause === true,
                vitesse: [1, 2, 5].includes(Number(donnees.vitesse)) ? Number(donnees.vitesse) : 1,
                secondes_jeu_reference: normaliserSecondesJeu(donnees.secondes_jeu_reference),
                horodatage_reference: Number.isFinite(Number(donnees.horodatage_reference)) ? Number(donnees.horodatage_reference) : Date.now()
            };
        } catch (erreur) {
            return {
                est_en_pause: false,
                vitesse: 1,
                secondes_jeu_reference: (7 * 24 * 60 * 60) + (8 * 60 * 60),
                horodatage_reference: Date.now()
            };
        }
    }

    function sauvegarderEtatTemps(etatTemps) {
        window.localStorage.setItem(cleStockageTemps, JSON.stringify(etatTemps));
    }

    const etatTemps = lireEtatTemps();

    function obtenirSecondesJeuActuelles() {
        if (etatTemps.est_en_pause) {
            return normaliserSecondesJeu(etatTemps.secondes_jeu_reference);
        }

        const maintenant = Date.now();
        const secondesReellesEcoulees = Math.max(0, (maintenant - etatTemps.horodatage_reference) / 1000);
        const secondesJeuAjoutees = secondesReellesEcoulees * dureeSecondeJeuParSecondeReelle * etatTemps.vitesse;

        return normaliserSecondesJeu(etatTemps.secondes_jeu_reference + secondesJeuAjoutees);
    }

    function figerReferenceCourante() {
        etatTemps.secondes_jeu_reference = obtenirSecondesJeuActuelles();
        etatTemps.horodatage_reference = Date.now();
        sauvegarderEtatTemps(etatTemps);
    }

    function decomposerSecondesJeu(secondesJeu) {
        const secondesNormalisees = normaliserSecondesJeu(secondesJeu);
        const indexMois = Math.floor(secondesNormalisees / dureeMoisJeuEnSecondes);
        const resteMois = secondesNormalisees % dureeMoisJeuEnSecondes;
        const jourIndex = Math.floor(resteMois / dureeJourJeuEnSecondes);
        const resteJour = resteMois % dureeJourJeuEnSecondes;
        const heure = Math.floor(resteJour / 3600);
        const minute = Math.floor((resteJour % 3600) / 60);
        const periode = (heure >= 8 && heure < 20) ? 'Jour' : 'Nuit';

        return {
            secondes: secondesNormalisees,
            mois: indexMois + 1,
            nom_mois: nomsMois[indexMois],
            jour: jourIndex + 1,
            heure: heure,
            minute: minute,
            periode: periode,
            texte_heure: String(heure).padStart(2, '0') + ':' + String(minute).padStart(2, '0')
        };
    }

    function diffuserMiseAJourTemps() {
        const detail = decomposerSecondesJeu(obtenirSecondesJeuActuelles());
        detail.est_en_pause = etatTemps.est_en_pause;
        detail.vitesse = etatTemps.vitesse;

        document.dispatchEvent(new CustomEvent('elementia:temps-mis-a-jour', {
            detail: detail
        }));
    }

    function pause() {
        if (etatTemps.est_en_pause) {
            return;
        }

        figerReferenceCourante();
        etatTemps.est_en_pause = true;
        sauvegarderEtatTemps(etatTemps);
        diffuserMiseAJourTemps();
    }

    function reprendre() {
        if (!etatTemps.est_en_pause) {
            return;
        }

        etatTemps.est_en_pause = false;
        etatTemps.horodatage_reference = Date.now();
        sauvegarderEtatTemps(etatTemps);
        diffuserMiseAJourTemps();
    }

    function ajouterSecondes(secondesAAjouter) {
        figerReferenceCourante();
        etatTemps.secondes_jeu_reference = normaliserSecondesJeu(etatTemps.secondes_jeu_reference + secondesAAjouter);
        sauvegarderEtatTemps(etatTemps);
        diffuserMiseAJourTemps();
    }

    function definirVitesse(vitesse) {
        if (![1, 2, 5].includes(Number(vitesse))) {
            return;
        }

        figerReferenceCourante();
        etatTemps.vitesse = Number(vitesse);
        etatTemps.horodatage_reference = Date.now();
        sauvegarderEtatTemps(etatTemps);
        diffuserMiseAJourTemps();
    }

    function forcerHeure(heure, minute) {
        const detailActuel = decomposerSecondesJeu(obtenirSecondesJeuActuelles());
        const secondesDebutJour = ((Number(heure) || 0) * 3600) + ((Number(minute) || 0) * 60);
        const nouvellesSecondes = ((detailActuel.mois - 1) * dureeMoisJeuEnSecondes)
            + ((detailActuel.jour - 1) * dureeJourJeuEnSecondes)
            + secondesDebutJour;

        figerReferenceCourante();
        etatTemps.secondes_jeu_reference = normaliserSecondesJeu(nouvellesSecondes);
        sauvegarderEtatTemps(etatTemps);
        diffuserMiseAJourTemps();
    }

    function convertirDateReelleEnSecondesJeu(valeurDate) {
        if (!valeurDate) {
            return null;
        }

        const horodatage = Date.parse(String(valeurDate).replace(' ', 'T'));

        if (!Number.isFinite(horodatage)) {
            return null;
        }

        const secondesJeu = etatTemps.secondes_jeu_reference
            + (((horodatage - etatTemps.horodatage_reference) / 1000) * dureeSecondeJeuParSecondeReelle);

        return normaliserSecondesJeu(secondesJeu);
    }

    function formaterDateJeuDepuisHorodatageReel(valeurDate) {
        const secondesJeu = convertirDateReelleEnSecondesJeu(valeurDate);

        if (secondesJeu === null) {
            return valeurDate || '—';
        }

        const detail = decomposerSecondesJeu(secondesJeu);
        return 'Jour ' + String(detail.jour) + ' · ' + detail.nom_mois + ' · ' + detail.texte_heure;
    }

    window.ElementiaTemps = {
        obtenirEtat: function () {
            return decomposerSecondesJeu(obtenirSecondesJeuActuelles());
        },
        pause: pause,
        reprendre: reprendre,
        ajouterHeures: function (heures) {
            ajouterSecondes((Number(heures) || 0) * 3600);
        },
        ajouterJours: function (jours) {
            ajouterSecondes((Number(jours) || 0) * dureeJourJeuEnSecondes);
        },
        definirVitesse: definirVitesse,
        forcerJour: function () {
            forcerHeure(8, 0);
        },
        forcerNuit: function () {
            forcerHeure(20, 0);
        },
        diffuserMiseAJourTemps: diffuserMiseAJourTemps,
        convertirDateReelleEnSecondesJeu: convertirDateReelleEnSecondesJeu,
        formaterDateJeuDepuisHorodatageReel: formaterDateJeuDepuisHorodatageReel,
        formaterSecondesJeu: function (secondesJeu) {
            const detail = decomposerSecondesJeu(secondesJeu);
            return 'Jour ' + String(detail.jour) + ' · ' + detail.nom_mois + ' · ' + detail.texte_heure;
        },
        obtenirCheminImageMois: function (numeroMois) {
            return 'ressources/images/interface/calendrier/mois_' + String(numeroMois) + '.png';
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        diffuserMiseAJourTemps();

        window.setInterval(function () {
            diffuserMiseAJourTemps();
        }, 1000);
    });
})();
