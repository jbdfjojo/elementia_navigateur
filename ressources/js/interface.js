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

    initialiserGestionnaireFenetresJeu();
    initialiserOngletsInventaire();
});

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

    mettreAJourFond();
}

function initialiserOngletsInventaire() {
    const fenetreInventaire = document.getElementById('fenetre-inventaire');

    if (!fenetreInventaire) {
        return;
    }

    const onglets = Array.from(fenetreInventaire.querySelectorAll('.onglet-sac-modele'));
    const champNom = document.getElementById('inventaire-nom-sac-actif');
    const champMonnaie = document.getElementById('inventaire-monnaie-sac');
    const champPoids = document.getElementById('inventaire-poids-sac');

    if (onglets.length === 0 || !champNom || !champMonnaie || !champPoids) {
        return;
    }

    function appliquerSac(ongletActif) {
        onglets.forEach(function (onglet) {
            const estActif = onglet === ongletActif;

            onglet.classList.toggle('actif', estActif);
            onglet.setAttribute('aria-pressed', estActif ? 'true' : 'false');
        });

        champNom.textContent = ongletActif.getAttribute('data-sac-nom') || 'Sac';
        champMonnaie.textContent = 'Monnaie : ' + (ongletActif.getAttribute('data-sac-monnaie') || '0');
        champPoids.textContent = 'Poids : ' + (ongletActif.getAttribute('data-sac-poids') || '0 / 0');
    }

    onglets.forEach(function (onglet) {
        onglet.addEventListener('click', function () {
            appliquerSac(onglet);
        });
    });

    const ongletInitial = fenetreInventaire.querySelector('.onglet-sac-modele.actif') || onglets[0];
    appliquerSac(ongletInitial);
}
