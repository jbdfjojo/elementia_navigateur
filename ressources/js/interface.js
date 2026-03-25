document.addEventListener('DOMContentLoaded', function () {
    initialiserGestionnaireFenetresJeu();
    initialiserActionsInventaire();
    initialiserDragAndDropEquipement();
    initialiserInteractionsEquipement();
    restaurerFenetresOuvertes();
});

function memoriserFenetresOuvertes() {
    const ouvertes = Array.from(document.querySelectorAll('.fenetre-jeu-modele.fenetre-jeu-ouverte'))
        .map(function (fenetre) {
            return fenetre.getAttribute('data-cle-fenetre');
        })
        .filter(function (cle) {
            return !!cle;
        });

    localStorage.setItem('elementia_fenetres_ouvertes', JSON.stringify(ouvertes));
}

function restaurerFenetresOuvertes() {
    let ouvertes = [];

    try {
        ouvertes = JSON.parse(localStorage.getItem('elementia_fenetres_ouvertes') || '[]');
    } catch (erreur) {
        ouvertes = [];
    }

    ouvertes.forEach(function (cle) {
        const fenetre = document.querySelector('.fenetre-jeu-modele[data-cle-fenetre="' + cle + '"]');

        if (!fenetre) {
            return;
        }

        fenetre.classList.remove('fenetre-jeu-cachee');
        fenetre.classList.add('fenetre-jeu-ouverte');
    });

    const fond = document.getElementById('fond-fenetres-jeu');

    if (fond) {
        fond.classList.toggle('visible', ouvertes.length > 0);
    }
}

function initialiserGestionnaireFenetresJeu() {
    const fond = document.getElementById('fond-fenetres-jeu');

    if (!fond) {
        return;
    }

    let zIndexCourant = 200;
    const fenetres = Array.from(fond.querySelectorAll('.fenetre-jeu-modele'));

    function mettreAJourFond() {
        const auMoinsUneOuverte = fenetres.some(function (fenetre) {
            return fenetre.classList.contains('fenetre-jeu-ouverte');
        });

        fond.classList.toggle('visible', auMoinsUneOuverte);
    }

    function mettreAuPremierPlan(fenetre) {
        zIndexCourant += 1;
        fenetre.style.zIndex = String(zIndexCourant);

        fenetres.forEach(function (autreFenetre) {
            autreFenetre.classList.remove('fenetre-jeu-active');
        });

        fenetre.classList.add('fenetre-jeu-active');
    }

    function ouvrirFenetre(cle) {
        const fenetre = fond.querySelector('.fenetre-jeu-modele[data-cle-fenetre="' + cle + '"]');

        if (!fenetre) {
            return;
        }

        fenetre.classList.remove('fenetre-jeu-cachee');
        fenetre.classList.add('fenetre-jeu-ouverte');

        mettreAuPremierPlan(fenetre);
        mettreAJourFond();
        memoriserFenetresOuvertes();
    }

    function fermerFenetre(fenetre) {
        if (!fenetre) {
            return;
        }

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

            const fenetre = bouton.closest('.fenetre-jeu-modele');
            fermerFenetre(fenetre);
        });
    });

    fenetres.forEach(function (fenetre) {
        fenetre.addEventListener('mousedown', function () {
            if (fenetre.classList.contains('fenetre-jeu-ouverte')) {
                mettreAuPremierPlan(fenetre);
            }
        });

        const poignee = fenetre.querySelector('.entete-fenetre-jeu') || fenetre.querySelector('.titre-visuel-inventaire');

        if (!poignee) {
            return;
        }

        poignee.addEventListener('mousedown', function (evenement) {
            if (evenement.button !== 0) {
                return;
            }

            if (evenement.target.closest('[data-fermer-fenetre="oui"]')) {
                return;
            }

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
        if (evenement.key !== 'Escape') {
            return;
        }

        const ouvertes = fenetres.filter(function (fenetre) {
            return fenetre.classList.contains('fenetre-jeu-ouverte');
        });

        if (ouvertes.length === 0) {
            return;
        }

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
    document.querySelectorAll('.formulaire-action-equiper, .formulaire-action-jeter, .formulaire-equipement-slot, .formulaire-action-desequiper').forEach(function (formulaire) {
        formulaire.addEventListener('submit', function () {
            memoriserFenetresOuvertes();
        });
    });
}

function construireBonusObjetDepuisDataset(dataset) {
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
        const valeur = parseInt(dataset[entree[0]] || '0', 10);

        if (valeur !== 0) {
            const prefixe = valeur > 0 ? '+' : '';
            lignes.push(entree[1] + ' : ' + prefixe + valeur);
        }
    });

    return lignes;
}

function remplirInfobulle(infobulle, sourceDataset, evenement) {
    const titre = infobulle.querySelector('.infobulle-objet-titre');
    const rarete = infobulle.querySelector('.infobulle-objet-rarete');
    const type = infobulle.querySelector('.infobulle-objet-type');
    const poids = infobulle.querySelector('.infobulle-objet-poids');
    const description = infobulle.querySelector('.infobulle-objet-description');
    const bonus = infobulle.querySelector('.infobulle-objet-bonus');

    if (titre) {
        titre.textContent = sourceDataset.nomObjet || 'Objet';
    }

    if (rarete) {
        rarete.textContent = 'Rareté : ' + (sourceDataset.rareteObjet || 'commune');
    }

    if (type) {
        type.textContent = 'Type : ' + (sourceDataset.typeObjet || 'inconnu');
    }

    if (poids) {
        poids.textContent = 'Poids : ' + (sourceDataset.poidsObjet || '0');
    }

    if (description) {
        description.textContent = sourceDataset.descriptionObjet || '';
    }

    if (bonus) {
        const listeBonus = construireBonusObjetDepuisDataset(sourceDataset);
        bonus.innerHTML = listeBonus.length > 0 ? listeBonus.join('<br>') : 'Aucun bonus';
    }

    infobulle.hidden = false;
    infobulle.style.left = (evenement.clientX + 16) + 'px';
    infobulle.style.top = (evenement.clientY + 16) + 'px';
}

function initialiserDragAndDropEquipement() {
    let instanceObjetIdEnCours = '';

    document.querySelectorAll('#fenetre-inventaire .slot-inventaire-occupe').forEach(function (slotInventaire) {
        slotInventaire.addEventListener('dragstart', function (evenement) {
            const instanceObjetId = slotInventaire.getAttribute('data-instance-objet-id') || '';

            if (!instanceObjetId) {
                evenement.preventDefault();
                return;
            }

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

            document.querySelectorAll('#fenetre-personnage .slot-personnage').forEach(function (slotPersonnage) {
                slotPersonnage.classList.remove('slot-drop-survole');
            });
        });
    });

    document.querySelectorAll('#fenetre-personnage .slot-personnage').forEach(function (slotPersonnage) {
        slotPersonnage.addEventListener('dragover', function (evenement) {
            if (slotPersonnage.classList.contains('slot-personnage-occupe')) {
                return;
            }

            evenement.preventDefault();

            if (evenement.dataTransfer) {
                evenement.dataTransfer.dropEffect = 'move';
            }

            slotPersonnage.classList.add('slot-drop-survole');
        });

        slotPersonnage.addEventListener('dragleave', function () {
            slotPersonnage.classList.remove('slot-drop-survole');
        });

        slotPersonnage.addEventListener('drop', function (evenement) {
            evenement.preventDefault();
            slotPersonnage.classList.remove('slot-drop-survole');

            if (slotPersonnage.classList.contains('slot-personnage-occupe')) {
                return;
            }

            const instanceObjetId = (evenement.dataTransfer && evenement.dataTransfer.getData('text/plain')) || instanceObjetIdEnCours;
            const formulaire = slotPersonnage.querySelector('.formulaire-equipement-slot');

            if (!instanceObjetId || !formulaire) {
                return;
            }

            const champInstance = formulaire.querySelector('input[name="instance_objet_id"]');

            if (!champInstance) {
                return;
            }

            champInstance.value = instanceObjetId;
            memoriserFenetresOuvertes();
            formulaire.submit();
        });
    });
}

function initialiserInteractionsEquipement() {
    const menuEquipement = document.getElementById('menu-contextuel-equipement');
    const infobulle = document.getElementById('infobulle-objet');

    document.querySelectorAll('#fenetre-personnage .slot-personnage-equippe').forEach(function (slotEquipe) {
        slotEquipe.addEventListener('mouseenter', function (evenement) {
            if (infobulle) {
                remplirInfobulle(infobulle, slotEquipe.dataset, evenement);
            }
        });

        slotEquipe.addEventListener('mousemove', function (evenement) {
            if (infobulle) {
                remplirInfobulle(infobulle, slotEquipe.dataset, evenement);
            }
        });

        slotEquipe.addEventListener('mouseleave', function () {
            if (infobulle) {
                infobulle.hidden = true;
            }
        });

        slotEquipe.addEventListener('contextmenu', function (evenement) {
            evenement.preventDefault();

            if (!menuEquipement) {
                return;
            }

            menuEquipement.hidden = false;
            menuEquipement.style.left = evenement.clientX + 'px';
            menuEquipement.style.top = evenement.clientY + 'px';
            menuEquipement.setAttribute('data-instance-objet-id', slotEquipe.getAttribute('data-instance-objet-id') || '');
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

                if (champ && champ.form) {
                    memoriserFenetresOuvertes();
                    champ.form.submit();
                }

                menuEquipement.hidden = true;
                menuEquipement.removeAttribute('data-instance-objet-id');
            });
        });
    }
}