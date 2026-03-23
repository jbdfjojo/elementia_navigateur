// ---------------------------------------------------------
// GESTION DU CHARGEMENT VISUEL
// ---------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
    const ecranChargement = document.getElementById('ecran-chargement');

    window.setTimeout(function () {
        if (ecranChargement) {
            ecranChargement.classList.add('cache');
        }
    }, 350);

    const formulairesAvecChargement = document.querySelectorAll('.formulaire-avec-chargement');

    formulairesAvecChargement.forEach(function (formulaire) {
        formulaire.addEventListener('submit', function () {
            if (ecranChargement) {
                ecranChargement.classList.remove('cache');
            }
        });
    });

    const formulairesLimites = document.querySelectorAll('.formulaire-limite-choix');

    formulairesLimites.forEach(function (formulaire) {
        const maximum = parseInt(formulaire.dataset.maxSelection || '0', 10);
        const cases = formulaire.querySelectorAll('input[type="checkbox"]');

        let compteur = null;

        if (maximum === 4) {
            compteur = document.getElementById('compteur-competences-elementaires');
        } else if (maximum === 3) {
            compteur = document.getElementById('compteur-competences-neutres');
        }

        function mettreAJourCompteur() {
            const nombreCochees = formulaire.querySelectorAll('input[type="checkbox"]:checked').length;

            cases.forEach(function (caseACocher) {
                if (!caseACocher.checked) {
                    caseACocher.disabled = nombreCochees >= maximum;
                } else {
                    caseACocher.disabled = false;
                }
            });

            if (compteur) {
                compteur.textContent = nombreCochees + ' / ' + maximum + ' sélectionnée(s)';
                compteur.classList.remove('valide', 'invalide');

                if (nombreCochees === maximum) {
                    compteur.classList.add('valide');
                } else {
                    compteur.classList.add('invalide');
                }
            }
        }

        cases.forEach(function (caseACocher) {
            caseACocher.addEventListener('change', mettreAJourCompteur);
        });

        formulaire.addEventListener('submit', function (evenement) {
            const nombreCochees = formulaire.querySelectorAll('input[type="checkbox"]:checked').length;

            if (nombreCochees !== maximum) {
                evenement.preventDefault();

                if (compteur) {
                    compteur.classList.remove('valide');
                    compteur.classList.add('invalide');
                }

                alert('Vous devez sélectionner exactement ' + maximum + ' choix.');
            }
        });

        mettreAJourCompteur();
    });

    const formulaireStatistiques = document.querySelector('.formulaire-statistiques');
    const compteurStatistiques = document.getElementById('compteur-statistiques');

    if (formulaireStatistiques && compteurStatistiques) {
        const champsStatistiques = formulaireStatistiques.querySelectorAll('input[type="number"]');
        const totalAutorise = 30;

        function mettreAJourStatistiques() {
            let total = 0;

            champsStatistiques.forEach(function (champ) {
                const valeur = parseInt(champ.value || '0', 10);
                total += isNaN(valeur) ? 0 : valeur;
            });

            compteurStatistiques.textContent = 'Total utilisé : ' + total + ' / ' + totalAutorise;
            compteurStatistiques.classList.remove('valide', 'invalide', 'attention');

            if (total === totalAutorise) {
                compteurStatistiques.classList.add('valide');
            } else if (total < totalAutorise) {
                compteurStatistiques.classList.add('attention');
            } else {
                compteurStatistiques.classList.add('invalide');
            }
        }

        champsStatistiques.forEach(function (champ) {
            champ.addEventListener('input', mettreAJourStatistiques);
        });

        formulaireStatistiques.addEventListener('submit', function (evenement) {
            let total = 0;

            champsStatistiques.forEach(function (champ) {
                const valeur = parseInt(champ.value || '0', 10);
                total += isNaN(valeur) ? 0 : valeur;
            });

            if (total !== totalAutorise) {
                evenement.preventDefault();
                compteurStatistiques.classList.remove('valide', 'attention');
                compteurStatistiques.classList.add('invalide');
                alert('Vous devez répartir exactement 30 points de statistiques.');
            }
        });

        mettreAJourStatistiques();
    }

    // -----------------------------------------------------
    // Gestion du filtrage des avatars selon le sexe choisi
    // -----------------------------------------------------
    const champSexe = document.getElementById('sexe');
    const cartesAvatars = document.querySelectorAll('.carte-avatar');

    if (champSexe && cartesAvatars.length > 0) {
        function mettreAJourAvatars() {
            const sexeChoisi = champSexe.value;

            cartesAvatars.forEach(function (carteAvatar) {
                const sexeAvatar = carteAvatar.dataset.sexe || '';
                const inputRadio = carteAvatar.querySelector('input[type="radio"]');

                if (sexeChoisi === '') {
                    carteAvatar.style.display = 'none';
                    if (inputRadio) {
                        inputRadio.checked = false;
                    }
                    return;
                }

                if (sexeAvatar === sexeChoisi) {
                    carteAvatar.style.display = 'flex';
                } else {
                    carteAvatar.style.display = 'none';
                    if (inputRadio) {
                        inputRadio.checked = false;
                    }
                }
            });
        }

        champSexe.addEventListener('change', mettreAJourAvatars);
        mettreAJourAvatars();
    }
});