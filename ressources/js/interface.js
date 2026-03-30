document.addEventListener('DOMContentLoaded', function () {
    initialiserAffichageErreursGlobales();

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

    try {
        initialiserGestionnaireFenetresJeu();
        initialiserOngletsInventaire();
        initialiserPanneauxDetailsJeu();
    } catch (erreur) {
        afficherErreurJeu(erreur, 'Erreur pendant l\'initialisation de l\'interface');
        throw erreur;
    }
});

function masquerChargementBloquant() {
    const ecranChargement = document.getElementById('ecran-chargement');

    if (ecranChargement) {
        ecranChargement.classList.add('cache');
        ecranChargement.style.display = 'none';
        ecranChargement.style.visibility = 'hidden';
        ecranChargement.style.pointerEvents = 'none';
    }
}

function creerPanneauErreursSiAbsent() {
    let panneau = document.getElementById('panneau-erreurs-js');

    if (panneau) {
        return panneau;
    }

    panneau = document.createElement('div');
    panneau.id = 'panneau-erreurs-js';
    panneau.style.position = 'fixed';
    panneau.style.left = '12px';
    panneau.style.right = '12px';
    panneau.style.bottom = '12px';
    panneau.style.maxHeight = '40vh';
    panneau.style.overflow = 'auto';
    panneau.style.zIndex = '999999';
    panneau.style.background = 'rgba(20, 8, 8, 0.96)';
    panneau.style.color = '#ffd7d7';
    panneau.style.border = '2px solid #b45757';
    panneau.style.borderRadius = '8px';
    panneau.style.padding = '12px';
    panneau.style.fontFamily = 'monospace';
    panneau.style.fontSize = '13px';
    panneau.style.whiteSpace = 'pre-wrap';
    panneau.style.boxShadow = '0 10px 30px rgba(0,0,0,0.45)';

    const titre = document.createElement('div');
    titre.textContent = 'Erreurs JavaScript détectées';
    titre.style.fontWeight = '700';
    titre.style.marginBottom = '8px';
    titre.style.color = '#ffb4b4';

    const boutonFermer = document.createElement('button');
    boutonFermer.type = 'button';
    boutonFermer.textContent = 'Fermer';
    boutonFermer.style.float = 'right';
    boutonFermer.style.marginLeft = '12px';
    boutonFermer.style.cursor = 'pointer';
    boutonFermer.addEventListener('click', function () {
        panneau.style.display = 'none';
    });

    const contenu = document.createElement('div');
    contenu.id = 'panneau-erreurs-js-contenu';

    titre.appendChild(boutonFermer);
    panneau.appendChild(titre);
    panneau.appendChild(contenu);
    document.body.appendChild(panneau);

    return panneau;
}

function afficherErreurJeu(erreur, contexte) {
    masquerChargementBloquant();

    const panneau = creerPanneauErreursSiAbsent();
    panneau.style.display = 'block';

    const contenu = document.getElementById('panneau-erreurs-js-contenu');

    let message = '';

    if (contexte) {
        message += '[' + contexte + ']\n';
    }

    if (erreur && erreur.stack) {
        message += erreur.stack;
    } else if (erreur && erreur.reason && erreur.reason.stack) {
        message += erreur.reason.stack;
    } else if (erreur && erreur.message) {
        message += erreur.message;
    } else if (erreur && erreur.reason) {
        message += String(erreur.reason);
    } else {
        message += String(erreur);
    }

    const bloc = document.createElement('div');
    bloc.style.borderTop = '1px solid rgba(255,255,255,0.15)';
    bloc.style.paddingTop = '8px';
    bloc.style.marginTop = '8px';
    bloc.textContent = message;

    contenu.appendChild(bloc);

    console.error('Erreur capturée par le panneau de debug :', erreur);
}

function initialiserAffichageErreursGlobales() {
    window.addEventListener('error', function (evenement) {
        afficherErreurJeu(
            evenement.error || new Error(evenement.message + ' @ ' + evenement.filename + ':' + evenement.lineno),
            'window.error'
        );
    });

    window.addEventListener('unhandledrejection', function (evenement) {
        afficherErreurJeu(evenement, 'unhandledrejection');
    });
}

function initialiserGestionnaireFenetresJeu() {
    const fond = document.getElementById('fond-fenetres-jeu');

    if (!fond) {
        return;
    }

    let z = 200;
    const fenetres = Array.from(fond.querySelectorAll('.fenetre-jeu-modele'));

    function ouvertes() {
        return fenetres.filter(function (fenetre) {
            return fenetre.classList.contains('fenetre-jeu-ouverte');
        });
    }

    function mettreAJourFond() {
        fond.classList.toggle('visible', ouvertes().length > 0);
    }

    function mettrePremierPlan(fenetre) {
        z += 1;
        fenetre.style.zIndex = String(z);

        fenetres.forEach(function (autreFenetre) {
            autreFenetre.classList.remove('fenetre-jeu-active');
        });

        fenetre.classList.add('fenetre-jeu-active');
    }

    function ouvrirFenetre(cle) {
        const fenetre = fond.querySelector('[data-cle-fenetre="' + cle + '"]');

        if (!fenetre) {
            return;
        }

        fenetre.classList.remove('fenetre-jeu-cachee');
        fenetre.classList.add('fenetre-jeu-ouverte');

        mettrePremierPlan(fenetre);
        mettreAJourFond();
    }

    function fermerFenetre(fenetre) {
        if (!fenetre) {
            return;
        }

        fenetre.classList.remove('fenetre-jeu-ouverte', 'fenetre-jeu-active');
        fenetre.classList.add('fenetre-jeu-cachee');
        fenetre.style.zIndex = '';

        const encoreOuvertes = ouvertes();

        if (encoreOuvertes.length > 0) {
            const plusHaute = encoreOuvertes.reduce(function (fenetrePrecedente, fenetreActuelle) {
                const zPrecedent = parseInt(fenetrePrecedente.style.zIndex || '0', 10);
                const zActuel = parseInt(fenetreActuelle.style.zIndex || '0', 10);

                return zActuel > zPrecedent ? fenetreActuelle : fenetrePrecedente;
            });

            plusHaute.classList.add('fenetre-jeu-active');
        }

        mettreAJourFond();
    }

    document.querySelectorAll('[data-fenetre]').forEach(function (bouton) {
        bouton.addEventListener('click', function (evenement) {
            evenement.preventDefault();
            evenement.stopPropagation();

            const cle = bouton.getAttribute('data-fenetre');
            const fenetre = fond.querySelector('[data-cle-fenetre="' + cle + '"]');

            if (!fenetre) {
                return;
            }

            if (fenetre.classList.contains('fenetre-jeu-ouverte')) {
                fermerFenetre(fenetre);
            } else {
                ouvrirFenetre(cle);
            }
        });
    });

    fond.querySelectorAll('[data-fermer-fenetre="oui"]').forEach(function (bouton) {
        bouton.addEventListener('click', function (evenement) {
            evenement.preventDefault();
            evenement.stopPropagation();
            fermerFenetre(bouton.closest('.fenetre-jeu-modele'));
        });
    });

    fenetres.forEach(function (fenetre) {
        fenetre.addEventListener('mousedown', function () {
            if (fenetre.classList.contains('fenetre-jeu-ouverte')) {
                mettrePremierPlan(fenetre);
            }
        });

        const poignee = fenetre.querySelector('.entete-fenetre-jeu') || fenetre.querySelector('.titre-visuel-inventaire');

        if (!poignee) {
            return;
        }

        poignee.addEventListener('mousedown', function (evenement) {
            if (evenement.target.closest('[data-fermer-fenetre="oui"]')) {
                return;
            }

            if (evenement.button !== 0) {
                return;
            }

            evenement.preventDefault();
            evenement.stopPropagation();

            const rectangle = fenetre.getBoundingClientRect();
            const decalageX = evenement.clientX - rectangle.left;
            const decalageY = evenement.clientY - rectangle.top;

            fenetre.style.transform = 'none';
            fenetre.style.right = 'auto';
            fenetre.style.bottom = 'auto';
            fenetre.style.left = rectangle.left + 'px';
            fenetre.style.top = rectangle.top + 'px';

            mettrePremierPlan(fenetre);

            function deplacer(evenementDeplacement) {
                const largeurMax = window.innerWidth - fenetre.offsetWidth;
                const hauteurMax = window.innerHeight - fenetre.offsetHeight;

                let gauche = evenementDeplacement.clientX - decalageX;
                let haut = evenementDeplacement.clientY - decalageY;

                gauche = Math.max(0, Math.min(gauche, Math.max(0, largeurMax)));
                haut = Math.max(0, Math.min(haut, Math.max(0, hauteurMax)));

                fenetre.style.left = gauche + 'px';
                fenetre.style.top = haut + 'px';
            }

            function finDeplacement() {
                document.removeEventListener('mousemove', deplacer);
                document.removeEventListener('mouseup', finDeplacement);
            }

            document.addEventListener('mousemove', deplacer);
            document.addEventListener('mouseup', finDeplacement);
        });
    });

    document.addEventListener('keydown', function (evenement) {
        if (evenement.key !== 'Escape') {
            return;
        }

        const encoreOuvertes = ouvertes();

        if (encoreOuvertes.length === 0) {
            return;
        }

        const plusHaute = encoreOuvertes.reduce(function (fenetrePrecedente, fenetreActuelle) {
            const zPrecedent = parseInt(fenetrePrecedente.style.zIndex || '0', 10);
            const zActuel = parseInt(fenetreActuelle.style.zIndex || '0', 10);

            return zActuel > zPrecedent ? fenetreActuelle : fenetrePrecedente;
        });

        fermerFenetre(plusHaute);
    });

    try {
        const fenetresSauvegardees = window.sessionStorage.getItem('elementia_fenetres_ouvertes');

        if (fenetresSauvegardees) {
            fenetresSauvegardees
                .split(',')
                .map(function (cle) { return cle.trim(); })
                .filter(Boolean)
                .forEach(function (cle) {
                    ouvrirFenetre(cle);
                });
        }
    } catch (erreur) {
        console.warn('Impossible de restaurer les fenêtres ouvertes.', erreur);
    }

    mettreAJourFond();
}

function initialiserOngletsInventaire() {
    const fenetreInventaire = document.getElementById('fenetre-inventaire');
    const fenetrePersonnage = document.getElementById('fenetre-personnage');
    const menuContextuel = document.getElementById('menu-contextuel-objet');
    const infobulle = document.getElementById('infobulle-objet');

    if (!fenetreInventaire && !fenetrePersonnage) {
        return;
    }

    if (infobulle && infobulle.parentElement !== document.body) {
        document.body.appendChild(infobulle);
        infobulle.style.position = 'fixed';
        infobulle.style.zIndex = '999998';
        infobulle.style.pointerEvents = 'none';
    }

    if (menuContextuel && menuContextuel.parentElement !== document.body) {
        document.body.appendChild(menuContextuel);
        menuContextuel.style.position = 'fixed';
        menuContextuel.style.zIndex = '999999';
    }

    function fermerMenuContextuel() {
        if (menuContextuel) {
            menuContextuel.hidden = true;
            menuContextuel.style.display = 'none';
            menuContextuel.removeAttribute('data-instance-objet-id');
            menuContextuel.removeAttribute('data-slot-index');
            menuContextuel.removeAttribute('data-source-menu');
            menuContextuel.removeAttribute('data-est-equipable');
            menuContextuel.removeAttribute('data-categorie-objet');
        }
    }

    function construireBonusObjet(slot) {
        const lignes = [];
        const mapping = [
            ['bonusPv', 'PV'],
            ['bonusAttaque', 'Attaque'],
            ['bonusMagie', 'Magie'],
            ['bonusAgilite', 'Agilité'],
            ['bonusIntelligence', 'Intelligence'],
            ['bonusSynchronisation', 'Synchronisation'],
            ['bonusCritique', 'Critique'],
            ['bonusDexterite', 'Dextérité'],
            ['bonusDefense', 'Défense']
        ];

        mapping.forEach(function (entree) {
            const valeur = parseInt(slot.dataset[entree[0]] || '0', 10);

            if (valeur !== 0) {
                lignes.push(entree[1] + ' : +' + valeur);
            }
        });

        return lignes;
    }

    function calculerEffetPotion(slot) {
        const categorie = String(slot.dataset.categorieObjet || '');
        const vieMax = parseInt((fenetreInventaire && fenetreInventaire.dataset.vieMax) || '0', 10);
        const vieActuelle = parseInt((fenetreInventaire && fenetreInventaire.dataset.vieActuelle) || '0', 10);
        const manaMax = parseInt((fenetreInventaire && fenetreInventaire.dataset.manaMax) || '0', 10);
        const manaActuel = parseInt((fenetreInventaire && fenetreInventaire.dataset.manaActuel) || '0', 10);

        let pourcentage = 0;
        let type = '';

        if (categorie.indexOf('potion_vie_20') === 0) {
            pourcentage = 20;
            type = 'vie';
        } else if (categorie.indexOf('potion_vie_60') === 0) {
            pourcentage = 60;
            type = 'vie';
        } else if (categorie.indexOf('potion_vie_100') === 0) {
            pourcentage = 100;
            type = 'vie';
        } else if (categorie.indexOf('potion_mana_20') === 0) {
            pourcentage = 20;
            type = 'mana';
        } else if (categorie.indexOf('potion_mana_60') === 0) {
            pourcentage = 60;
            type = 'mana';
        } else if (categorie.indexOf('potion_mana_100') === 0) {
            pourcentage = 100;
            type = 'mana';
        }

        if (!pourcentage || !type) {
            return '';
        }

        if (type === 'vie') {
            const rendu = Math.max(1, Math.round(vieMax * (pourcentage / 100)));
            const apres = Math.min(vieMax, vieActuelle + rendu);
            return 'Effet : rend ' + rendu + ' PV (' + pourcentage + '%).<br>Après usage : ' + apres + ' / ' + vieMax;
        }

        const rendu = Math.max(1, Math.round(manaMax * (pourcentage / 100)));
        const apres = Math.min(manaMax, manaActuel + rendu);
        return 'Effet : rend ' + rendu + ' mana (' + pourcentage + '%).<br>Après usage : ' + apres + ' / ' + manaMax;
    }


    function normaliserTexteComparaison(texte) {
        return String(texte || '')
            .toLowerCase()
            .normalize('NFD')
            .replace(/[̀-ͯ]/g, '');
    }

    function infererSlotsComparaison(slot) {
        const source = [
            normaliserTexteComparaison(slot.dataset.categorieObjet || ''),
            normaliserTexteComparaison(slot.dataset.typeObjet || ''),
            normaliserTexteComparaison(slot.dataset.nomObjet || '')
        ].join(' ');

        if (source.indexOf('arme') !== -1 || source.indexOf('epee') !== -1 || source.indexOf('hache') !== -1 || source.indexOf('arc') !== -1 || source.indexOf('baton') !== -1 || source.indexOf('dague') !== -1 || source.indexOf('bouclier') !== -1) {
            return ['main_droite', 'main_gauche'];
        }
        if (source.indexOf('casque') !== -1 || source.indexOf('tete') !== -1) {
            return ['tete'];
        }
        if (source.indexOf('armure') !== -1 || source.indexOf('torse') !== -1 || source.indexOf('plastron') !== -1) {
            return ['torse'];
        }
        if (source.indexOf('botte') !== -1 || source.indexOf('jambe') !== -1 || source.indexOf('pantalon') !== -1) {
            return ['jambes'];
        }
        if (source.indexOf('collier') !== -1 || source.indexOf('amulette') !== -1) {
            return ['collier'];
        }
        if (source.indexOf('bague') !== -1 || source.indexOf('anneau') !== -1) {
            return ['bague_1', 'bague_2'];
        }
        if (source.indexOf('artefact') !== -1) {
            return ['artefact'];
        }
        if (source.indexOf('gant') !== -1) {
            return ['gants_gauche', 'gants_droite'];
        }
        if (source.indexOf('sac') !== -1) {
            return ['sac'];
        }

        return [];
    }

    function extraireBonusComparaison(slot) {
        return {
            pv: parseInt(slot.dataset.bonusPv || '0', 10),
            attaque: parseInt(slot.dataset.bonusAttaque || '0', 10),
            magie: parseInt(slot.dataset.bonusMagie || '0', 10),
            agilite: parseInt(slot.dataset.bonusAgilite || '0', 10),
            intelligence: parseInt(slot.dataset.bonusIntelligence || '0', 10),
            synchronisation: parseInt(slot.dataset.bonusSynchronisation || '0', 10),
            critique: parseInt(slot.dataset.bonusCritique || '0', 10),
            dexterite: parseInt(slot.dataset.bonusDexterite || '0', 10),
            defense: parseInt(slot.dataset.bonusDefense || '0', 10)
        };
    }

    function construireBlocComparaison(slot) {
        if (!fenetrePersonnage) {
            return '';
        }

        const nature = determinerNatureObjet(slot);
        if (!nature.estEquipable) {
            return '';
        }

        const slotsCompatibles = infererSlotsComparaison(slot);
        if (slotsCompatibles.length === 0) {
            return '';
        }

        let equipementActuel = null;

        for (let i = 0; i < slotsCompatibles.length; i += 1) {
            equipementActuel = fenetrePersonnage.querySelector('.slot-personnage-equippe[data-slot-cible="' + slotsCompatibles[i] + '"]');
            if (equipementActuel) {
                break;
            }
        }

        if (!equipementActuel) {
            return '';
        }

        const nouveau = extraireBonusComparaison(slot);
        const actuel = extraireBonusComparaison(equipementActuel);
        const mapping = [
            ['PV', 'pv'],
            ['Attaque', 'attaque'],
            ['Magie', 'magie'],
            ['Agilité', 'agilite'],
            ['Intelligence', 'intelligence'],
            ['Synchronisation', 'synchronisation'],
            ['Critique', 'critique'],
            ['Dextérité', 'dexterite'],
            ['Défense', 'defense']
        ];

        let html = '<div class="infobulle-comparaison" style="margin-top:8px;padding-top:8px;border-top:1px solid rgba(255,255,255,0.15);">';
        html += '<div class="infobulle-comparaison-titre" style="font-weight:700;margin-bottom:4px;">Comparaison avec : ' + (equipementActuel.dataset.nomObjet || 'Objet équipé') + '</div>';

        let differences = 0;
        mapping.forEach(function (entree) {
            const libelle = entree[0];
            const cle = entree[1];
            const diff = (nouveau[cle] || 0) - (actuel[cle] || 0);

            if (diff !== 0) {
                differences += 1;
                const couleur = diff > 0 ? '#6ee16e' : '#ff7b7b';
                const signe = diff > 0 ? '+' : '';
                html += '<div style="display:flex;justify-content:space-between;gap:12px;">'
                    + '<span>' + libelle + '</span>'
                    + '<strong style="color:' + couleur + ';">' + signe + diff + '</strong>'
                    + '</div>';
            }
        });

        if (differences === 0) {
            html += '<div>Aucune différence</div>';
        }

        html += '</div>';
        return html;
    }

    function afficherInfobulle(slot, evenement) {
        if (!infobulle) {
            return;
        }

        const titre = infobulle.querySelector('.infobulle-objet-titre');
        const rarete = infobulle.querySelector('.infobulle-objet-rarete');
        const type = infobulle.querySelector('.infobulle-objet-type');
        const poids = infobulle.querySelector('.infobulle-objet-poids');
        const description = infobulle.querySelector('.infobulle-objet-description');
        const bonus = infobulle.querySelector('.infobulle-objet-bonus');

        if (titre) {
            titre.textContent = slot.dataset.nomObjet || 'Objet';
        }

        if (rarete) {
            rarete.textContent = 'Rareté : ' + (slot.dataset.rareteObjet || 'commune');
        }

        if (type) {
            type.textContent = 'Type : ' + (slot.dataset.typeObjet || 'inconnu');
        }

        if (poids) {
            poids.textContent = 'Poids : ' + (slot.dataset.poidsObjet || '0');
        }

        if (description) {
            description.textContent = slot.dataset.descriptionObjet || '';
        }

        if (bonus) {
            const listeBonus = construireBonusObjet(slot);
            const effetPotion = calculerEffetPotion(slot);
            let contenu = listeBonus.length > 0 ? listeBonus.join('<br>') : 'Aucun bonus';

            if (effetPotion !== '') {
                contenu += '<br><br>' + effetPotion;
            }

            const comparaison = construireBlocComparaison(slot);
            if (comparaison !== '') {
                contenu += '<br><br>' + comparaison;
            }

            bonus.innerHTML = contenu;
        }

        infobulle.hidden = false;
        infobulle.style.display = 'block';
        infobulle.style.left = (evenement.clientX + 16) + 'px';
        infobulle.style.top = (evenement.clientY + 16) + 'px';
    }

    function masquerInfobulle() {
        if (infobulle) {
            infobulle.hidden = true;
            infobulle.style.display = 'none';
        }
    }

    function determinerNatureObjet(slot) {
        const categorieObjet = String(slot.dataset.categorieObjet || '').toLowerCase();
        const typeObjet = String(slot.dataset.typeObjet || '').toLowerCase();
        const nomObjet = String(slot.dataset.nomObjet || '').toLowerCase();
        const estConsommableBrut = String(slot.dataset.estConsommable || '0') === '1';
        const estEquipableBrut = String(slot.dataset.estEquipable || '0') === '1';

        const estPotion =
            categorieObjet.indexOf('potion') !== -1 ||
            nomObjet.indexOf('potion') !== -1;

        const estConsommable =
            estPotion ||
            estConsommableBrut ||
            typeObjet === 'consommable' ||
            typeObjet === 'nourriture';

        const estEquipable =
            !estConsommable && (
                estEquipableBrut ||
                typeObjet === 'equipement' ||
                typeObjet === 'arme' ||
                typeObjet === 'armure' ||
                typeObjet === 'casque' ||
                typeObjet === 'gants' ||
                typeObjet === 'bottes' ||
                typeObjet === 'anneau' ||
                typeObjet === 'collier' ||
                typeObjet === 'artefact'
            );

        return {
            estConsommable: estConsommable,
            estEquipable: estEquipable
        };
    }

    function reglerVisibiliteBouton(bouton, visible, texte) {
        bouton.hidden = !visible;
        bouton.style.display = visible ? 'block' : 'none';

        if (visible && texte) {
            bouton.textContent = texte;
        }
    }

    function afficherActionsMenu(sourceMenu, slot) {
        if (!menuContextuel) {
            return;
        }

        const nature = determinerNatureObjet(slot);

        menuContextuel.querySelectorAll('[data-action-menu]').forEach(function (bouton) {
            const action = bouton.getAttribute('data-action-menu');

            if (sourceMenu === 'inventaire') {
                if (action === 'utiliser') {
                    reglerVisibiliteBouton(bouton, nature.estConsommable, 'Utiliser');
                    return;
                }

                if (action === 'equiper') {
                    reglerVisibiliteBouton(bouton, nature.estEquipable, 'Équiper');
                    return;
                }

                if (action === 'desequiper') {
                    reglerVisibiliteBouton(bouton, false, 'Déséquiper');
                    return;
                }

                if (action === 'jeter') {
                    reglerVisibiliteBouton(bouton, true, 'Jeter');
                    return;
                }
            }

            if (sourceMenu === 'personnage') {
                if (action === 'desequiper') {
                    reglerVisibiliteBouton(bouton, true, 'Déséquiper');
                    return;
                }

                reglerVisibiliteBouton(bouton, false, bouton.textContent);
                return;
            }

            reglerVisibiliteBouton(bouton, false, bouton.textContent);
        });
    }

    function ouvrirMenuContextuel(evenement, slot, sourceMenu) {
        if (!menuContextuel) {
            return;
        }

        evenement.preventDefault();
        evenement.stopPropagation();
        masquerInfobulle();

        afficherActionsMenu(sourceMenu, slot);

        menuContextuel.hidden = false;
        menuContextuel.style.display = 'block';
        menuContextuel.style.left = evenement.clientX + 'px';
        menuContextuel.style.top = evenement.clientY + 'px';
        menuContextuel.setAttribute('data-instance-objet-id', slot.dataset.instanceObjetId || '');
        menuContextuel.setAttribute('data-slot-index', slot.dataset.slotIndex || '');
        menuContextuel.setAttribute('data-source-menu', sourceMenu);
        menuContextuel.setAttribute('data-est-equipable', slot.dataset.estEquipable || '0');
        menuContextuel.setAttribute('data-categorie-objet', slot.dataset.categorieObjet || '');
    }

    if (fenetreInventaire) {
        fenetreInventaire.querySelectorAll('.slot-inventaire-modele').forEach(function (slot) {
            slot.addEventListener('mouseenter', function (evenement) {
                if (slot.classList.contains('slot-inventaire-occupe')) {
                    afficherInfobulle(slot, evenement);
                }
            });

            slot.addEventListener('mousemove', function (evenement) {
                if (slot.classList.contains('slot-inventaire-occupe')) {
                    afficherInfobulle(slot, evenement);
                }
            });

            slot.addEventListener('mouseleave', function () {
                masquerInfobulle();
            });

            slot.addEventListener('contextmenu', function (evenement) {
                if (!slot.classList.contains('slot-inventaire-occupe')) {
                    return;
                }

                ouvrirMenuContextuel(evenement, slot, 'inventaire');
            });
        });
    }

    if (fenetrePersonnage) {
        fenetrePersonnage.querySelectorAll('.slot-personnage-equippe').forEach(function (slot) {
            slot.addEventListener('mouseenter', function (evenement) {
                afficherInfobulle(slot, evenement);
            });

            slot.addEventListener('mousemove', function (evenement) {
                afficherInfobulle(slot, evenement);
            });

            slot.addEventListener('mouseleave', function () {
                masquerInfobulle();
            });

            slot.addEventListener('contextmenu', function (evenement) {
                ouvrirMenuContextuel(evenement, slot, 'personnage');
            });
        });
    }

    document.addEventListener('click', function (evenement) {
        if (menuContextuel && !menuContextuel.hidden && !menuContextuel.contains(evenement.target)) {
            fermerMenuContextuel();
        }
    });

    if (menuContextuel) {
        menuContextuel.addEventListener('mousedown', function (evenement) {
            evenement.preventDefault();
            evenement.stopPropagation();
        });

        menuContextuel.addEventListener('click', function (evenement) {
            evenement.preventDefault();
            evenement.stopPropagation();
        });

        menuContextuel.querySelectorAll('[data-action-menu]').forEach(function (bouton) {
            bouton.addEventListener('click', function (evenement) {
                evenement.preventDefault();
                evenement.stopPropagation();

                if (bouton.hidden || bouton.style.display === 'none') {
                    return;
                }

                const action = bouton.getAttribute('data-action-menu');
                const instanceObjetId = menuContextuel.getAttribute('data-instance-objet-id');
                const sourceMenu = menuContextuel.getAttribute('data-source-menu');

                if (!instanceObjetId) {
                    fermerMenuContextuel();
                    return;
                }

                let champ = null;

                if (sourceMenu === 'inventaire' && fenetreInventaire) {
                    if (action === 'equiper') {
                        champ = fenetreInventaire.querySelector(
                            '.formulaire-action-equiper input[name="instance_objet_id"][value="' + instanceObjetId + '"]'
                        );
                    } else if (action === 'utiliser') {
                        champ = fenetreInventaire.querySelector(
                            '.formulaire-action-utiliser input[name="instance_objet_id"][value="' + instanceObjetId + '"]'
                        );
                    } else if (action === 'jeter') {
                        champ = fenetreInventaire.querySelector(
                            '.formulaire-action-jeter input[name="instance_objet_id"][value="' + instanceObjetId + '"]'
                        );
                    }
                }

                if (sourceMenu === 'personnage' && action === 'desequiper' && fenetrePersonnage) {
                    champ = fenetrePersonnage.querySelector(
                        '.formulaire-action-desequiper input[name="instance_objet_id"][value="' + instanceObjetId + '"]'
                    );
                }

                fermerMenuContextuel();

                if (champ && champ.form) {
                    try {
                        const fenetresOuvertes = Array.from(document.querySelectorAll('.fenetre-jeu-modele.fenetre-jeu-ouverte'))
                            .map(function (fenetre) { return fenetre.getAttribute('data-cle-fenetre') || ''; })
                            .filter(Boolean);
                        window.sessionStorage.setItem('elementia_fenetres_ouvertes', fenetresOuvertes.join(','));
                    } catch (erreur) {
                        console.warn('Impossible de sauvegarder les fenêtres ouvertes.', erreur);
                    }

                    champ.form.submit();
                }
            });
        });
    }
}



function convertirDateDetailVersTempsJeu(cible, valeur) {
    if (!valeur) {
        return '—';
    }

    if (window.ElementiaTemps && typeof window.ElementiaTemps.formaterDateJeuDepuisHorodatageReel === 'function') {
        return window.ElementiaTemps.formaterDateJeuDepuisHorodatageReel(valeur);
    }

    return valeur;
}

function synchroniserDatesQuetesAvecTempsJeu() {
    const panneauxQuetes = document.querySelectorAll('[data-cible-detail="quete"]');

    panneauxQuetes.forEach(function (panneau) {
        const boutons = panneau.querySelectorAll('.bouton-entree-detail[data-date]');

        boutons.forEach(function (bouton) {
            const dateReelle = bouton.dataset.date || '';
            const dateFormatee = (window.ElementiaTemps && typeof window.ElementiaTemps.formaterDateJeuDepuisHorodatageReel === 'function')
                ? window.ElementiaTemps.formaterDateJeuDepuisHorodatageReel(dateReelle)
                : (dateReelle || '—');

            bouton.dataset.dateFormatee = dateFormatee;

            const cibleDate = bouton.querySelector('[data-role="date-quete"]');
            if (cibleDate) {
                cibleDate.textContent = dateFormatee;
            }
        });

        const boutonActif = panneau.querySelector('.bouton-entree-detail.entree-active[data-date]')
            || panneau.querySelector('.bouton-entree-detail[data-date]');

        if (!boutonActif) {
            return;
        }

        const zoneDetail = panneau.querySelector('.case-information-detail-panel');
        const dateDetail = zoneDetail ? zoneDetail.querySelector('[data-detail="date"]') : null;

        if (dateDetail) {
            const dateReelle = boutonActif.dataset.date || '';
            dateDetail.textContent = boutonActif.dataset.dateFormatee
                || ((window.ElementiaTemps && typeof window.ElementiaTemps.formaterDateJeuDepuisHorodatageReel === 'function')
                    ? window.ElementiaTemps.formaterDateJeuDepuisHorodatageReel(dateReelle)
                    : (dateReelle || '—'));
        }
    });
}

function initialiserPanneauxDetailsJeu() {
    document.querySelectorAll('.bouton-entree-detail').forEach(function (bouton) {
        bouton.addEventListener('click', function () {
            const cible = bouton.getAttribute('data-cible-detail');
            if (!cible) {
                return;
            }

            const zoneDetail = document.querySelector('[data-zone-detail="' + cible + '"]');
            if (!zoneDetail) {
                return;
            }

            const liste = bouton.closest('.liste-entrees-jeu');
            if (liste) {
                liste.querySelectorAll('.bouton-entree-detail').forEach(function (autreBouton) {
                    autreBouton.classList.remove('entree-active');
                });
            }

            bouton.classList.add('entree-active');

            const mappingsTexte = {
                competence: {
                    nom: 'nom',
                    resume: 'resume',
                    description: 'description',
                    famille: 'famille',
                    element: 'element',
                    classe: 'classe',
                    portee: 'portee',
                    cible: 'cible',
                    formule: 'formule',
                    progression: 'progression'
                },
                quete: {
                    titre: 'titre',
                    resume: 'resume',
                    description: 'description',
                    objectif: 'objectif',
                    recompense: 'recompense',
                    etat: 'etat',
                    categorie: 'categorie',
                    zone: 'zone',
                    date: 'date',
                    progression: 'progression',
                    'progression-barre': 'progression'
                },
                journal: {
                    titre: 'titre',
                    resume: 'resume',
                    details: 'details',
                    categorie: 'categorie',
                    'categorie-secondaire': 'categorie',
                    importance: 'importance',
                    date: 'date'
                }
            };

            const mappingActif = mappingsTexte[cible] || {};

            Object.keys(mappingActif).forEach(function (cleDetail) {
                const champ = zoneDetail.querySelector('[data-detail="' + cleDetail + '"]');
                if (!champ) {
                    return;
                }

                const valeur = bouton.dataset[mappingActif[cleDetail]] || '';
                const valeurAffichee = (cleDetail === 'date') ? convertirDateDetailVersTempsJeu(cible, valeur) : valeur;
                champ.textContent = valeurAffichee !== '' ? valeurAffichee : '—';
            });

            if (cible === 'competence') {
                const niveau = bouton.dataset.niveau || '1';
                const slot = bouton.dataset.slot || '1';
                const cout = bouton.dataset.cout || '0';
                const ressource = bouton.dataset.ressource || 'PM';
                const puissance = bouton.dataset.puissance || '0';
                const xp = bouton.dataset.xp || '0';
                const xpSuivante = bouton.dataset.xpSuivante || '100';
                const classe = bouton.dataset.classe || 'Toutes';
                const progression = bouton.dataset.progression || 'Cette compétence progressera avec votre utilisation et les futures règles de progression.';
                const formule = bouton.dataset.formule || 'Aucune formule détaillée enregistrée pour le moment.';

                const niveauNode = zoneDetail.querySelector('[data-detail="niveau"]');
                const slotNode = zoneDetail.querySelector('[data-detail="slot"]');
                const coutNode = zoneDetail.querySelector('[data-detail="cout"]');
                const puissanceNode = zoneDetail.querySelector('[data-detail="puissance"]');
                const xpNode = zoneDetail.querySelector('[data-detail="xp"]');
                const classeNode = zoneDetail.querySelector('[data-detail="classe"]');
                const progressionNode = zoneDetail.querySelector('[data-detail="progression"]');
                const formuleNode = zoneDetail.querySelector('[data-detail="formule"]');
                const barre = zoneDetail.querySelector('[data-detail-style="xp"]');

                if (niveauNode) niveauNode.textContent = 'Niv. ' + niveau;
                if (slotNode) slotNode.textContent = 'Slot ' + slot;
                if (coutNode) coutNode.textContent = cout + ' ' + ressource;
                if (puissanceNode) puissanceNode.textContent = puissance;
                if (xpNode) xpNode.textContent = xp + ' / ' + xpSuivante;
                if (classeNode) classeNode.textContent = classe !== '' ? classe : 'Toutes';
                if (progressionNode) progressionNode.textContent = progression;
                if (formuleNode) formuleNode.textContent = formule;
                if (barre) barre.style.width = (bouton.dataset.pourcentageXp || '0') + '%';
            }

            if (cible === 'quete') {
                const barre = zoneDetail.querySelector('[data-detail-style="progression"]');
                if (barre) {
                    barre.style.width = (bouton.dataset.pourcentage || '0') + '%';
                }
            }
        });
    });

    synchroniserDatesQuetesAvecTempsJeu();

    document.addEventListener('elementia:temps-mis-a-jour', function () {
        synchroniserDatesQuetesAvecTempsJeu();
    });
}
