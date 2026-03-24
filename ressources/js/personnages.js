
// ---------------------------------------------------------
// OUTILS PERSONNAGES : SÉLECTIONS, STATISTIQUES, AVATAR, MODALE
// ---------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
    const racinePersonnages = document.querySelector('.module-personnages');

    if (!racinePersonnages) {
        return;
    }

    const donneesAvatar = racinePersonnages.dataset;

    const champSexe = document.getElementById('sexe');
    const champVariante = document.getElementById('variante_avatar');
    const champAvatar = document.getElementById('avatar');
    const imageApercu = document.getElementById('image-apercu-avatar');
    const texteVide = document.getElementById('texte-apercu-avatar-vide');
    const blocTexte = document.getElementById('texte-apercu-avatar');
    const sousTitreApercu = document.getElementById('sous-titre-apercu-avatar');

    const fondModalConfirmation = document.getElementById('fond-modal-confirmation');
    const titreModalConfirmation = document.getElementById('titre-modal-confirmation');
    const texteModalConfirmation = document.getElementById('texte-modal-confirmation');
    const listeModalConfirmation = document.getElementById('liste-modal-confirmation');
    const boutonAnnulerModal = document.getElementById('bouton-annuler-modal');
    const boutonConfirmerModal = document.getElementById('bouton-confirmer-modal');

    let formulaireEnAttenteConfirmation = null;

    const contenusConfirmation = {
        elementaires: {
            titre: '⚠️ Attention',
            texte: 'Les compétences élémentaires sont un choix important.',
            points: [
                'Elles ne pourront pas être modifiées librement.',
                'Un maître spécialisé sera nécessaire pour les changer.',
                'En cas de changement, elles reviendront niveau 1.'
            ],
            nomChamp: 'confirmation_competences_elementaires'
        },
        neutres: {
            titre: 'ℹ️ Information',
            texte: 'Les compétences neutres évoluent avec vos actions.',
            points: [
                'Elles peuvent être débloquées et améliorées.',
                'Elles dépendent de votre style de jeu.',
                'Votre progression naturelle influencera leur évolution.'
            ],
            nomChamp: 'confirmation_competences_neutres'
        }
    };

    function fermerModalConfirmation() {
        if (!fondModalConfirmation) {
            return;
        }

        fondModalConfirmation.classList.remove('visible');
        fondModalConfirmation.setAttribute('aria-hidden', 'true');
        formulaireEnAttenteConfirmation = null;
    }

    function ouvrirModalConfirmation(typeConfirmation, formulaire) {
        const contenu = contenusConfirmation[typeConfirmation];

        if (!fondModalConfirmation || !titreModalConfirmation || !texteModalConfirmation || !listeModalConfirmation || !contenu) {
            return;
        }

        formulaireEnAttenteConfirmation = formulaire;
        titreModalConfirmation.textContent = contenu.titre;
        texteModalConfirmation.textContent = contenu.texte;
        listeModalConfirmation.innerHTML = '';

        contenu.points.forEach(function (point) {
            const ligne = document.createElement('li');
            ligne.textContent = '✔ ' + point;
            listeModalConfirmation.appendChild(ligne);
        });

        fondModalConfirmation.classList.add('visible');
        fondModalConfirmation.setAttribute('aria-hidden', 'false');
    }

    function mettreAJourApercuAvatar() {
        if (!champSexe || !champVariante || !imageApercu || !texteVide || !blocTexte || !sousTitreApercu) {
            return;
        }

        const sexe = champSexe.value;
        const variante = champVariante.value;
        const elementChoisi = donneesAvatar.elementChoisi || '';
        const classeChoisie = donneesAvatar.classeChoisie || '';

        if (!sexe || !variante || !elementChoisi || !classeChoisie) {
            imageApercu.style.display = 'none';
            imageApercu.src = '';
            texteVide.style.display = 'block';
            texteVide.textContent = 'Choisissez le sexe puis la variante';
            blocTexte.style.display = 'none';

            if (champAvatar) {
                champAvatar.value = '';
            }

            return;
        }

        const mappingElement = {
            'Feu': 'feu',
            'Eau': 'eau',
            'Air': 'air',
            'Terre': 'terre'
        };

        const mappingClasse = {
            'Guerrier du Feu': 'guerrier',
            'Berserker du Feu': 'berserker',
            'Mage du Feu': 'mage',
            'Prêtre du Feu': 'pretre',
            'Guerrier de l’Eau': 'guerrier',
            'Combattant de l’Eau': 'berserker',
            'Mage de l’Eau': 'mage',
            'Prêtre de l’Eau': 'pretre',
            'Guerrier de l’Air': 'guerrier',
            'Chasseur de l’Air': 'berserker',
            'Mage de l’Air': 'mage',
            'Prêtre de l’Air': 'pretre',
            'Guerrier de la Terre': 'guerrier',
            'Briseur de Terre': 'berserker',
            'Mage de la Terre': 'mage',
            'Prêtre de la Terre': 'pretre'
        };

        const elementFichier = mappingElement[elementChoisi] || '';
        const classeFichier = mappingClasse[classeChoisie] || '';

        if (!elementFichier || !classeFichier) {
            imageApercu.style.display = 'none';
            imageApercu.src = '';
            texteVide.style.display = 'block';
            texteVide.textContent = 'Mapping avatar introuvable';
            blocTexte.style.display = 'none';

            if (champAvatar) {
                champAvatar.value = '';
            }

            return;
        }

        const nomAvatar = elementFichier + '_' + classeFichier + '_' + sexe + '_' + variante + '.png';
        const cheminAvatar = 'ressources/images/avatars/' + nomAvatar;

        if (champAvatar) {
            champAvatar.value = nomAvatar;
        }

        imageApercu.onload = function () {
            imageApercu.style.display = 'block';
            texteVide.style.display = 'none';
            blocTexte.style.display = 'flex';
            sousTitreApercu.textContent = sexe.charAt(0).toUpperCase() + sexe.slice(1) + ' — Variante ' + variante;
        };

        imageApercu.onerror = function () {
            imageApercu.style.display = 'none';
            imageApercu.src = '';
            texteVide.style.display = 'block';
            texteVide.textContent = 'Image introuvable';
            blocTexte.style.display = 'none';

            if (champAvatar) {
                champAvatar.value = '';
            }
        };

        imageApercu.src = cheminAvatar + '?v=' + Date.now();
    }

    function brancherCompteursSelection() {
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
                    caseACocher.disabled = !caseACocher.checked && nombreCochees >= maximum;
                });

                if (compteur) {
                    compteur.textContent = maximum === 4
                        ? nombreCochees + ' / ' + maximum + ' compétence(s) élémentaire(s) sélectionnée(s)'
                        : nombreCochees + ' / ' + maximum + ' compétence(s) neutre(s) sélectionnée(s)';
                    compteur.classList.remove('valide', 'invalide');
                    compteur.classList.add(nombreCochees === maximum ? 'valide' : 'invalide');
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
    }

    function brancherCompteurStatistiques() {
        const formulaireStatistiques = document.querySelector('.formulaire-statistiques');
        const compteurStatistiques = document.getElementById('compteur-statistiques');

        if (!formulaireStatistiques || !compteurStatistiques) {
            return;
        }

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

    function brancherModalesConfirmation() {
        const formulairesConfirmationCompetences = document.querySelectorAll('.formulaire-confirmation-competences');

        formulairesConfirmationCompetences.forEach(function (formulaire) {
            formulaire.addEventListener('submit', function (evenement) {
                const typeConfirmation = formulaire.dataset.typeConfirmation || '';
                const contenu = contenusConfirmation[typeConfirmation];

                if (!contenu) {
                    return;
                }

                const champConfirmation = formulaire.querySelector('input[name="' + contenu.nomChamp + '"]');

                if (!champConfirmation || champConfirmation.value === 'oui') {
                    return;
                }

                evenement.preventDefault();
                ouvrirModalConfirmation(typeConfirmation, formulaire);
            });
        });

        if (boutonAnnulerModal) {
            boutonAnnulerModal.addEventListener('click', fermerModalConfirmation);
        }

        if (boutonConfirmerModal) {
            boutonConfirmerModal.addEventListener('click', function () {
                if (!formulaireEnAttenteConfirmation) {
                    fermerModalConfirmation();
                    return;
                }

                const typeConfirmation = formulaireEnAttenteConfirmation.dataset.typeConfirmation || '';
                const contenu = contenusConfirmation[typeConfirmation];
                const champConfirmation = contenu
                    ? formulaireEnAttenteConfirmation.querySelector('input[name="' + contenu.nomChamp + '"]')
                    : null;

                if (champConfirmation) {
                    champConfirmation.value = 'oui';
                }

                const formulaireAEnvoyer = formulaireEnAttenteConfirmation;
                fermerModalConfirmation();
                formulaireAEnvoyer.submit();
            });
        }

        if (fondModalConfirmation) {
            fondModalConfirmation.addEventListener('click', function (evenement) {
                if (evenement.target === fondModalConfirmation) {
                    fermerModalConfirmation();
                }
            });
        }

        document.addEventListener('keydown', function (evenement) {
            if (evenement.key === 'Escape' && fondModalConfirmation && fondModalConfirmation.classList.contains('visible')) {
                fermerModalConfirmation();
            }
        });
    }

    brancherCompteursSelection();
    brancherCompteurStatistiques();
    brancherModalesConfirmation();

    if (champSexe) {
        champSexe.addEventListener('change', mettreAJourApercuAvatar);
    }

    if (champVariante) {
        champVariante.addEventListener('change', mettreAJourApercuAvatar);
    }

    mettreAJourApercuAvatar();
});
