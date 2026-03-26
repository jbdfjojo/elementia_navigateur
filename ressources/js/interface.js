document.addEventListener('DOMContentLoaded', function () {
    initialiserStockageInterfaceJeu();
    initialiserGestionnaireFenetresJeu();
    initialiserActionsInventaire();
    initialiserDragAndDropEquipement();
    initialiserInteractionsInventaire();
    initialiserInteractionsEquipement();
    restaurerFenetresOuvertes();
});

function obtenirCleFenetresOuvertes() {
    const body = document.body;
    const personnageId = body ? (body.dataset.personnageId || '0') : '0';
    return 'elementia_fenetres_ouvertes_' + personnageId;
}

function estVueJeuActive() {
    return document.body && document.body.dataset.estVueJeu === 'oui';
}

function nettoyerToutesLesClesInterfaceJeu() {
    const clesASupprimer = [];
    for (let i = 0; i < window.localStorage.length; i++) {
        const cle = window.localStorage.key(i);
        if (cle && cle.indexOf('elementia_fenetres_ouvertes_') === 0) {
            clesASupprimer.push(cle);
        }
    }
    clesASupprimer.forEach(function (cle) { window.localStorage.removeItem(cle); });
}

function initialiserStockageInterfaceJeu() {
    if (!estVueJeuActive()) {
        nettoyerToutesLesClesInterfaceJeu();
        return;
    }

    if (document.body.dataset.nettoyerInterfaceJeu === 'oui') {
        nettoyerToutesLesClesInterfaceJeu();
    }
}

function memoriserFenetresOuvertes() {
    if (!estVueJeuActive()) return;
    const ouvertes = Array.from(document.querySelectorAll('.fenetre-jeu-modele.fenetre-jeu-ouverte')).map(function (fenetre) {
        return fenetre.getAttribute('data-cle-fenetre');
    }).filter(Boolean);
    localStorage.setItem(obtenirCleFenetresOuvertes(), JSON.stringify(ouvertes));
}

function restaurerFenetresOuvertes() {
    if (!estVueJeuActive()) return;
    let ouvertes = [];
    try {
        ouvertes = JSON.parse(localStorage.getItem(obtenirCleFenetresOuvertes()) || '[]');
    } catch (erreur) {
        ouvertes = [];
    }
    ouvertes.forEach(function (cle) {
        const fenetre = document.querySelector('.fenetre-jeu-modele[data-cle-fenetre="' + cle + '"]');
        if (!fenetre) return;
        fenetre.classList.remove('fenetre-jeu-cachee');
        fenetre.classList.add('fenetre-jeu-ouverte');
    });
    const fond = document.getElementById('fond-fenetres-jeu');
    if (fond) fond.classList.toggle('visible', ouvertes.length > 0);
}

function initialiserGestionnaireFenetresJeu() {
    const fond = document.getElementById('fond-fenetres-jeu');
    if (!fond) return;
    let zIndexCourant = 200;
    const fenetres = Array.from(fond.querySelectorAll('.fenetre-jeu-modele'));

    function mettreAJourFond() {
        fond.classList.toggle('visible', fenetres.some(function (fenetre) { return fenetre.classList.contains('fenetre-jeu-ouverte'); }));
    }

    function mettreAuPremierPlan(fenetre) {
        zIndexCourant += 1;
        fenetre.style.zIndex = String(zIndexCourant);
        fenetres.forEach(function (autreFenetre) { autreFenetre.classList.remove('fenetre-jeu-active'); });
        fenetre.classList.add('fenetre-jeu-active');
    }

    function ouvrirFenetre(cle) {
        const fenetre = fond.querySelector('.fenetre-jeu-modele[data-cle-fenetre="' + cle + '"]');
        if (!fenetre) return;
        fenetre.classList.remove('fenetre-jeu-cachee');
        fenetre.classList.add('fenetre-jeu-ouverte');
        mettreAuPremierPlan(fenetre);
        mettreAJourFond();
        memoriserFenetresOuvertes();
    }

    function fermerFenetre(fenetre) {
        if (!fenetre) return;
        fenetre.classList.remove('fenetre-jeu-ouverte', 'fenetre-jeu-active');
        fenetre.classList.add('fenetre-jeu-cachee');
        fenetre.style.zIndex = '';
        mettreAJourFond();
        memoriserFenetresOuvertes();
    }

    document.querySelectorAll('[data-fenetre]').forEach(function (bouton) {
        bouton.addEventListener('click', function (evenement) {
            evenement.preventDefault();
            evenement.stopPropagation();
            const cle = bouton.getAttribute('data-fenetre');
            const fenetre = fond.querySelector('.fenetre-jeu-modele[data-cle-fenetre="' + cle + '"]');
            if (!fenetre) return;
            if (fenetre.classList.contains('fenetre-jeu-ouverte')) fermerFenetre(fenetre); else ouvrirFenetre(cle);
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
            if (fenetre.classList.contains('fenetre-jeu-ouverte')) mettreAuPremierPlan(fenetre);
        });

        const poignee = fenetre.querySelector('.entete-fenetre-jeu') || fenetre.querySelector('.titre-visuel-inventaire');
        if (!poignee) return;

        poignee.addEventListener('mousedown', function (evenement) {
            if (evenement.button !== 0 || evenement.target.closest('[data-fermer-fenetre="oui"]')) return;
            evenement.preventDefault();
            const rectangle = fenetre.getBoundingClientRect();
            const decalageX = evenement.clientX - rectangle.left;
            const decalageY = evenement.clientY - rectangle.top;
            fenetre.style.transform = 'none';
            fenetre.style.right = 'auto';
            fenetre.style.bottom = 'auto';
            fenetre.style.left = rectangle.left + 'px';
            fenetre.style.top = rectangle.top + 'px';
            mettreAuPremierPlan(fenetre);

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
        if (evenement.key !== 'Escape') return;
        const ouvertes = fenetres.filter(function (fenetre) { return fenetre.classList.contains('fenetre-jeu-ouverte'); });
        if (ouvertes.length === 0) return;
        const plusHaute = ouvertes.reduce(function (precedente, actuelle) {
            const zPrecedent = parseInt(precedente.style.zIndex || '0', 10);
            const zActuel = parseInt(actuelle.style.zIndex || '0', 10);
            return zActuel > zPrecedent ? actuelle : precedente;
        });
        fermerFenetre(plusHaute);
    });

    mettreAJourFond();
}

function initialiserActionsInventaire() {
    document.querySelectorAll('.formulaire-action-equiper, .formulaire-action-jeter, .formulaire-equipement-slot, .formulaire-action-desequiper, .formulaire-action-double-clic').forEach(function (formulaire) {
        formulaire.addEventListener('submit', function () { memoriserFenetresOuvertes(); });
    });
}

function construireBonusObjetDepuisDataset(dataset) {
    const lignes = [];
    const mapping = [['bonusPv', 'PV'], ['bonusAttaque', 'Attaque'], ['bonusMagie', 'Magie'], ['bonusAgilite', 'Agilité'], ['bonusIntelligence', 'Intelligence'], ['bonusSynchronisation', 'Synchronisation'], ['bonusCritique', 'Critique'], ['bonusDexterite', 'Dextérité'], ['bonusDefense', 'Défense']];
    mapping.forEach(function (entree) {
        const valeur = parseInt(dataset[entree[0]] || '0', 10);
        if (valeur !== 0) lignes.push(entree[1] + ' : ' + (valeur > 0 ? '+' : '') + valeur);
    });
    return lignes;
}

function trouverObjetEquipeComparable(categorieObjet) {
    if (!categorieObjet) return null;
    const equipements = Array.from(document.querySelectorAll('#fenetre-personnage .slot-personnage-equippe'));
    return equipements.find(function (equipement) { return (equipement.dataset.categorieObjet || '') === categorieObjet; }) || null;
}

function remplirInfobulle(infobulle, sourceDataset, evenement) {
    const titre = infobulle.querySelector('.infobulle-objet-titre');
    const rarete = infobulle.querySelector('.infobulle-objet-rarete');
    const type = infobulle.querySelector('.infobulle-objet-type');
    const poids = infobulle.querySelector('.infobulle-objet-poids');
    const description = infobulle.querySelector('.infobulle-objet-description');
    const bonus = infobulle.querySelector('.infobulle-objet-bonus');
    const estEquipe = !!sourceDataset.slotCible;
    if (titre) titre.textContent = sourceDataset.nomObjet || 'Objet';
    if (rarete) rarete.textContent = 'Rareté : ' + (sourceDataset.rareteObjet || 'commune');
    if (type) type.textContent = 'Type : ' + (sourceDataset.typeObjet || 'inconnu') + ' — ' + (estEquipe ? 'équipé' : 'dans le sac');
    if (poids) poids.textContent = 'Poids : ' + (sourceDataset.poidsObjet || '0');
    if (description) description.textContent = sourceDataset.descriptionObjet || '';
    if (bonus) {
        const bonusObjet = construireBonusObjetDepuisDataset(sourceDataset);
        const equipementComparable = trouverObjetEquipeComparable(sourceDataset.categorieObjet || '');
        let html = '<strong>' + (estEquipe ? 'Objet équipé' : 'Objet survolé dans le sac') + '</strong><br>' + (bonusObjet.length > 0 ? bonusObjet.join('<br>') : 'Aucun bonus');
        if (!estEquipe) {
            if (equipementComparable && equipementComparable.dataset.instanceObjetId !== sourceDataset.instanceObjetId) {
                const bonusEquipe = construireBonusObjetDepuisDataset(equipementComparable.dataset);
                html += '<br><br><strong>Objet actuellement équipé</strong><br>' + (equipementComparable.dataset.nomObjet || 'Objet équipé') + '<br>' + (bonusEquipe.length > 0 ? bonusEquipe.join('<br>') : 'Aucun bonus');
            } else {
                html += '<br><br><strong>Objet actuellement équipé</strong><br>Aucun équipement porté sur cet emplacement';
            }
        }
        bonus.innerHTML = html;
    }
    infobulle.hidden = false;
    infobulle.style.position = 'fixed';
    infobulle.style.left = (evenement.clientX + 16) + 'px';
    infobulle.style.top = (evenement.clientY + 16) + 'px';
}

function masquerInfobulle() {
    const infobulle = document.getElementById('infobulle-objet');
    if (infobulle) infobulle.hidden = true;
}

function preparerMenuContextuel(menu) {
    if (!menu) return null;
    if (menu.parentElement !== document.body) document.body.appendChild(menu);
    menu.style.position = 'fixed';
    menu.style.zIndex = '99999';
    return menu;
}

function positionnerMenuContextuel(menu, clientX, clientY) {
    if (!menu) return;
    menu.hidden = false;
    menu.style.left = '0px';
    menu.style.top = '0px';
    const marge = 8;
    const largeur = menu.offsetWidth || 180;
    const hauteur = menu.offsetHeight || 60;
    let gauche = clientX + marge;
    let haut = clientY + marge;
    if (gauche + largeur > window.innerWidth - marge) gauche = window.innerWidth - largeur - marge;
    if (haut + hauteur > window.innerHeight - marge) haut = window.innerHeight - hauteur - marge;
    if (gauche < marge) gauche = marge;
    if (haut < marge) haut = marge;
    menu.style.left = gauche + 'px';
    menu.style.top = haut + 'px';
}

function initialiserInteractionsInventaire() {
    const fenetreInventaire = document.getElementById('fenetre-inventaire');
    if (!fenetreInventaire) return;
    const menuContextuel = preparerMenuContextuel(document.getElementById('menu-contextuel-objet'));
    const infobulle = document.getElementById('infobulle-objet');

    function fermerMenuContextuel() {
        if (!menuContextuel) return;
        menuContextuel.hidden = true;
        menuContextuel.removeAttribute('data-instance-objet-id');
    }

    fenetreInventaire.querySelectorAll('.slot-inventaire-modele').forEach(function (slot) {
        slot.addEventListener('mouseenter', function (evenement) { if (infobulle && slot.classList.contains('slot-inventaire-occupe')) remplirInfobulle(infobulle, slot.dataset, evenement); });
        slot.addEventListener('mousemove', function (evenement) { if (infobulle && slot.classList.contains('slot-inventaire-occupe')) remplirInfobulle(infobulle, slot.dataset, evenement); });
        slot.addEventListener('mouseleave', function () { masquerInfobulle(); });
        slot.addEventListener('dblclick', function () {
            if (!slot.classList.contains('slot-inventaire-occupe')) return;
            const formulaire = slot.querySelector('.formulaire-action-double-clic');
            if (formulaire) { memoriserFenetresOuvertes(); formulaire.submit(); }
        });
        slot.addEventListener('contextmenu', function (evenement) {
            if (!slot.classList.contains('slot-inventaire-occupe')) return;
            evenement.preventDefault();
            masquerInfobulle();
            if (!menuContextuel) return;
            menuContextuel.setAttribute('data-instance-objet-id', slot.dataset.instanceObjetId || '');
            positionnerMenuContextuel(menuContextuel, evenement.clientX, evenement.clientY);
        });
    });

    document.addEventListener('click', function (evenement) {
        if (menuContextuel && !menuContextuel.hidden && !menuContextuel.contains(evenement.target)) fermerMenuContextuel();
    });

    if (menuContextuel) {
        menuContextuel.querySelectorAll('[data-action-menu]').forEach(function (bouton) {
            bouton.addEventListener('click', function () {
                const action = bouton.getAttribute('data-action-menu');
                const instanceObjetId = menuContextuel.getAttribute('data-instance-objet-id');
                if (!instanceObjetId) { fermerMenuContextuel(); return; }
                const selecteurFormulaire = action === 'equiper'
                    ? '.formulaire-action-equiper input[name="instance_objet_id"][value="' + instanceObjetId + '"]'
                    : '.formulaire-action-jeter input[name="instance_objet_id"][value="' + instanceObjetId + '"]';
                const champ = fenetreInventaire.querySelector(selecteurFormulaire);
                if (champ && champ.form) { memoriserFenetresOuvertes(); champ.form.submit(); }
                fermerMenuContextuel();
            });
        });
    }
}

function initialiserDragAndDropEquipement() {
    let instanceObjetIdEnCours = '';
    document.querySelectorAll('#fenetre-inventaire .slot-inventaire-occupe').forEach(function (slotInventaire) {
        slotInventaire.addEventListener('dragstart', function (evenement) {
            const instanceObjetId = slotInventaire.getAttribute('data-instance-objet-id') || '';
            if (!instanceObjetId) { evenement.preventDefault(); return; }
            instanceObjetIdEnCours = instanceObjetId;
            slotInventaire.classList.add('slot-drag-source');
            if (evenement.dataTransfer) {
                evenement.dataTransfer.setData('text/plain', instanceObjetId);
                evenement.dataTransfer.effectAllowed = 'move';
            }
        });
        slotInventaire.addEventListener('dragend', function () {
            instanceObjetIdEnCours = '';
            slotInventaire.classList.remove('slot-drag-source');
            document.querySelectorAll('#fenetre-personnage .slot-personnage').forEach(function (slotPersonnage) { slotPersonnage.classList.remove('slot-drop-survole'); });
        });
    });

    document.querySelectorAll('#fenetre-personnage .slot-personnage').forEach(function (slotPersonnage) {
        slotPersonnage.addEventListener('dragover', function (evenement) {
            if (slotPersonnage.classList.contains('slot-personnage-occupe')) return;
            evenement.preventDefault();
            if (evenement.dataTransfer) evenement.dataTransfer.dropEffect = 'move';
            slotPersonnage.classList.add('slot-drop-survole');
        });
        slotPersonnage.addEventListener('dragleave', function () { slotPersonnage.classList.remove('slot-drop-survole'); });
        slotPersonnage.addEventListener('drop', function (evenement) {
            evenement.preventDefault();
            slotPersonnage.classList.remove('slot-drop-survole');
            if (slotPersonnage.classList.contains('slot-personnage-occupe')) return;
            const instanceObjetId = (evenement.dataTransfer && evenement.dataTransfer.getData('text/plain')) || instanceObjetIdEnCours;
            const formulaire = slotPersonnage.querySelector('.formulaire-equipement-slot');
            if (!instanceObjetId || !formulaire) return;
            const champInstance = formulaire.querySelector('input[name="instance_objet_id"]');
            if (!champInstance) return;
            champInstance.value = instanceObjetId;
            memoriserFenetresOuvertes();
            formulaire.submit();
        });
    });
}

function initialiserInteractionsEquipement() {
    const menuEquipement = preparerMenuContextuel(document.getElementById('menu-contextuel-equipement'));
    const infobulle = document.getElementById('infobulle-objet');

    document.querySelectorAll('#fenetre-personnage .slot-personnage-equippe').forEach(function (slotEquipe) {
        slotEquipe.addEventListener('mouseenter', function (evenement) { if (infobulle) remplirInfobulle(infobulle, slotEquipe.dataset, evenement); });
        slotEquipe.addEventListener('mousemove', function (evenement) { if (infobulle) remplirInfobulle(infobulle, slotEquipe.dataset, evenement); });
        slotEquipe.addEventListener('mouseleave', function () { masquerInfobulle(); });
        slotEquipe.addEventListener('contextmenu', function (evenement) {
            evenement.preventDefault();
            masquerInfobulle();
            if (!menuEquipement) return;
            menuEquipement.setAttribute('data-instance-objet-id', slotEquipe.getAttribute('data-instance-objet-id') || '');
            positionnerMenuContextuel(menuEquipement, evenement.clientX, evenement.clientY);
        });
    });

    document.addEventListener('click', function (evenement) {
        if (menuEquipement && !menuEquipement.hidden && !menuEquipement.contains(evenement.target)) {
            menuEquipement.hidden = true;
            menuEquipement.removeAttribute('data-instance-objet-id');
        }
    });

    if (menuEquipement) {
        menuEquipement.querySelectorAll('[data-action-menu-equipement]').forEach(function (bouton) {
            bouton.addEventListener('click', function () {
                const action = bouton.getAttribute('data-action-menu-equipement');
                const instanceObjetId = menuEquipement.getAttribute('data-instance-objet-id');
                if (action !== 'desequiper' || !instanceObjetId) {
                    menuEquipement.hidden = true;
                    return;
                }
                const champ = document.querySelector('#fenetre-personnage .formulaire-action-desequiper input[name="instance_objet_id"][value="' + instanceObjetId + '"]');
                if (champ && champ.form) { memoriserFenetresOuvertes(); champ.form.submit(); }
                menuEquipement.hidden = true;
                menuEquipement.removeAttribute('data-instance-objet-id');
            });
        });
    }
}
