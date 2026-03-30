
/* --------------------------------------------------------- */
/* FONDS DIALOGUES                                           */
/* --------------------------------------------------------- */
const fondsDialogues = {
    annonce_interieur: "ressources/images/fonds_dialogue/annonce_interieur.png",
    annonce_marcher: "ressources/images/fonds_dialogue/annonce_marcher.png"
};

(function () {
    let carteDejaInitialisee = false;

    function initialiserCarteElementia() {
        if (carteDejaInitialisee) {
            return;
        }

        const zoneCarte = document.getElementById('zone-carte-monde');
        if (!zoneCarte) {
            return;
        }

        const viewport = document.getElementById('carte-monde-viewport');
        const contenu = document.getElementById('carte-monde-contenu');
        const imageCarte = document.getElementById('image-carte-monde');
        const grille = document.getElementById('grille-carte-monde');
        const surbrillance = document.getElementById('surbrillance-deplacement-monde');
        const surbrillanceLieux = document.getElementById('surbrillance-lieux-monde');
        const repereJoueur = document.getElementById('repere-joueur-monde');
        const valeurPositionJoueur = document.getElementById('valeur-position-joueur');
        const valeurPorteeJoueur = document.getElementById('valeur-portee-joueur');
        const valeurNavigationJoueur = document.getElementById('valeur-navigation-joueur');
        const ligneEvenementPrincipale = document.getElementById('ligne-evenement-principale');
        const ligneEvenementSecondaire = document.getElementById('ligne-evenement-secondaire');
        const boutonDebugMonture = document.getElementById('bouton-debug-monture');
        const boutonDebugAfficherCases = document.getElementById('bouton-debug-afficher-cases');
        const boutonDebugVilleJour = document.getElementById('bouton-debug-ville-jour');
        const boutonDebugVilleNuit = document.getElementById('bouton-debug-ville-nuit');
        const boutonDebugReinitialiserLogs = document.getElementById('bouton-debug-reinitialiser-logs');
        const debugEtatMode = document.getElementById('debug-etat-mode');
        const debugEtatBateau = document.getElementById('debug-etat-bateau');
        const debugEtatPosition = document.getElementById('debug-etat-position');
        const debugJournalDeplacement = document.getElementById('debug-journal-deplacement');
        const superpositionVille = document.getElementById('superposition-ville');
        const imageVilleActive = document.getElementById('image-ville-active');
        const titreVilleActive = document.getElementById('titre-ville-active');
        const sousTitreVilleActive = document.getElementById('sous-titre-ville-active');
        const boutonFermerVille = document.getElementById('bouton-fermer-ville');
        const calquePointsVille = document.getElementById('calque-points-ville');
        const fenetreLieuVille = document.getElementById('fenetre-lieu-ville');
        const titreLieuVille = document.getElementById('titre-lieu-ville');
        const sousTitreLieuVille = document.getElementById('sous-titre-lieu-ville');
        const texteLieuVille = document.getElementById('texte-lieu-ville');
        const titreInteractionLieuVille = document.getElementById('titre-interaction-lieu-ville');
        const etatInteractionLieuVille = document.getElementById('etat-interaction-lieu-ville');
        const imageLieuVille = document.getElementById('image-lieu-ville');
        const calqueInteractionsLieuVille = document.getElementById('calque-interactions-lieu-ville');
        const contenuLieuVille = document.getElementById('contenu-lieu-ville');
        const boutonFermerLieuVille = document.getElementById('bouton-fermer-lieu-ville');
        const boutonRetourScene = document.getElementById('bouton-retour-scene');
        const boutonRetourVille = document.getElementById('bouton-retour-ville');

        if (!viewport || !contenu || !imageCarte || !grille || !surbrillance || !surbrillanceLieux || !repereJoueur || !valeurPositionJoueur) {
            console.error('[Elementia] DOM carte incomplet.');
            return;
        }

        const tailleCase = Number(zoneCarte.dataset.tailleCase || 64);
        const nombreColonnes = Number(zoneCarte.dataset.colonnes || 40);
        const nombreLignes = Number(zoneCarte.dataset.lignes || 27);
        const largeurMondeDataset = Number(zoneCarte.dataset.largeurMonde || (nombreColonnes * tailleCase));
        const hauteurMondeDataset = Number(zoneCarte.dataset.hauteurMonde || (nombreLignes * tailleCase));
        const cheminCarte = 'ressources/images/carte/carte_du_monde.png';
        const donneesCases = [{"colonne":0,"ligne":0,"type":"eau"},{"colonne":1,"ligne":0,"type":"eau"},{"colonne":2,"ligne":0,"type":"eau"},{"colonne":3,"ligne":0,"type":"eau"},{"colonne":4,"ligne":0,"type":"eau"},{"colonne":5,"ligne":0,"type":"eau"},{"colonne":6,"ligne":0,"type":"eau"},{"colonne":7,"ligne":0,"type":"eau"},{"colonne":8,"ligne":0,"type":"eau"},{"colonne":9,"ligne":0,"type":"eau"},{"colonne":10,"ligne":0,"type":"eau"},{"colonne":11,"ligne":0,"type":"eau"},{"colonne":12,"ligne":0,"type":"eau"},{"colonne":13,"ligne":0,"type":"eau"},{"colonne":14,"ligne":0,"type":"eau"},{"colonne":15,"ligne":0,"type":"eau"},{"colonne":16,"ligne":0,"type":"eau"},{"colonne":17,"ligne":0,"type":"eau"},{"colonne":18,"ligne":0,"type":"eau"},{"colonne":19,"ligne":0,"type":"eau"},{"colonne":20,"ligne":0,"type":"eau"},{"colonne":21,"ligne":0,"type":"eau"},{"colonne":22,"ligne":0,"type":"eau"},{"colonne":23,"ligne":0,"type":"eau"},{"colonne":24,"ligne":0,"type":"eau"},{"colonne":25,"ligne":0,"type":"eau"},{"colonne":26,"ligne":0,"type":"eau"},{"colonne":27,"ligne":0,"type":"eau"},{"colonne":28,"ligne":0,"type":"eau"},{"colonne":29,"ligne":0,"type":"eau"},{"colonne":30,"ligne":0,"type":"eau"},{"colonne":31,"ligne":0,"type":"eau"},{"colonne":32,"ligne":0,"type":"eau"},{"colonne":33,"ligne":0,"type":"eau"},{"colonne":34,"ligne":0,"type":"eau"},{"colonne":35,"ligne":0,"type":"eau"},{"colonne":36,"ligne":0,"type":"eau"},{"colonne":37,"ligne":0,"type":"eau"},{"colonne":38,"ligne":0,"type":"eau"},{"colonne":39,"ligne":0,"type":"eau"},{"colonne":0,"ligne":1,"type":"eau"},{"colonne":1,"ligne":1,"type":"eau"},{"colonne":2,"ligne":1,"type":"eau"},{"colonne":3,"ligne":1,"type":"eau"},{"colonne":4,"ligne":1,"type":"eau"},{"colonne":5,"ligne":1,"type":"eau"},{"colonne":6,"ligne":1,"type":"eau"},{"colonne":7,"ligne":1,"type":"eau"},{"colonne":8,"ligne":1,"type":"eau"},{"colonne":9,"ligne":1,"type":"eau"},{"colonne":10,"ligne":1,"type":"eau"},{"colonne":11,"ligne":1,"type":"eau"},{"colonne":12,"ligne":1,"type":"eau"},{"colonne":13,"ligne":1,"type":"eau"},{"colonne":14,"ligne":1,"type":"eau"},{"colonne":15,"ligne":1,"type":"eau"},{"colonne":16,"ligne":1,"type":"eau"},{"colonne":17,"ligne":1,"type":"eau"},{"colonne":18,"ligne":1,"type":"eau"},{"colonne":19,"ligne":1,"type":"eau"},{"colonne":20,"ligne":1,"type":"eau"},{"colonne":21,"ligne":1,"type":"eau"},{"colonne":22,"ligne":1,"type":"eau"},{"colonne":23,"ligne":1,"type":"eau"},{"colonne":24,"ligne":1,"type":"eau"},{"colonne":25,"ligne":1,"type":"eau"},{"colonne":26,"ligne":1,"type":"eau"},{"colonne":27,"ligne":1,"type":"eau"},{"colonne":28,"ligne":1,"type":"eau"},{"colonne":29,"ligne":1,"type":"eau"},{"colonne":30,"ligne":1,"type":"eau"},{"colonne":31,"ligne":1,"type":"eau"},{"colonne":32,"ligne":1,"type":"eau"},{"colonne":33,"ligne":1,"type":"eau"},{"colonne":34,"ligne":1,"type":"eau"},{"colonne":35,"ligne":1,"type":"eau"},{"colonne":36,"ligne":1,"type":"eau"},{"colonne":37,"ligne":1,"type":"eau"},{"colonne":38,"ligne":1,"type":"eau"},{"colonne":39,"ligne":1,"type":"eau"},{"colonne":0,"ligne":2,"type":"eau"},{"colonne":1,"ligne":2,"type":"eau"},{"colonne":2,"ligne":2,"type":"eau"},{"colonne":3,"ligne":2,"type":"eau"},{"colonne":4,"ligne":2,"type":"eau"},{"colonne":5,"ligne":2,"type":"eau"},{"colonne":6,"ligne":2,"type":"eau"},{"colonne":7,"ligne":2,"type":"eau"},{"colonne":8,"ligne":2,"type":"eau"},{"colonne":9,"ligne":2,"type":"eau"},{"colonne":10,"ligne":2,"type":"plaine"},{"colonne":11,"ligne":2,"type":"plaine"},{"colonne":12,"ligne":2,"type":"eau"},{"colonne":13,"ligne":2,"type":"eau"},{"colonne":14,"ligne":2,"type":"eau"},{"colonne":15,"ligne":2,"type":"eau"},{"colonne":16,"ligne":2,"type":"eau"},{"colonne":17,"ligne":2,"type":"eau"},{"colonne":18,"ligne":2,"type":"eau"},{"colonne":19,"ligne":2,"type":"plaine"},{"colonne":20,"ligne":2,"type":"eau"},{"colonne":21,"ligne":2,"type":"eau"},{"colonne":22,"ligne":2,"type":"eau"},{"colonne":23,"ligne":2,"type":"eau"},{"colonne":24,"ligne":2,"type":"eau"},{"colonne":25,"ligne":2,"type":"eau"},{"colonne":26,"ligne":2,"type":"eau"},{"colonne":27,"ligne":2,"type":"eau"},{"colonne":28,"ligne":2,"type":"eau"},{"colonne":29,"ligne":2,"type":"eau"},{"colonne":30,"ligne":2,"type":"eau"},{"colonne":31,"ligne":2,"type":"eau"},{"colonne":32,"ligne":2,"type":"eau"},{"colonne":33,"ligne":2,"type":"eau"},{"colonne":34,"ligne":2,"type":"eau"},{"colonne":35,"ligne":2,"type":"eau"},{"colonne":36,"ligne":2,"type":"eau"},{"colonne":37,"ligne":2,"type":"eau"},{"colonne":38,"ligne":2,"type":"eau"},{"colonne":39,"ligne":2,"type":"eau"},{"colonne":0,"ligne":3,"type":"eau"},{"colonne":1,"ligne":3,"type":"eau"},{"colonne":2,"ligne":3,"type":"eau"},{"colonne":3,"ligne":3,"type":"eau"},{"colonne":4,"ligne":3,"type":"eau"},{"colonne":5,"ligne":3,"type":"eau"},{"colonne":6,"ligne":3,"type":"eau"},{"colonne":7,"ligne":3,"type":"eau"},{"colonne":8,"ligne":3,"type":"plaine"},{"colonne":9,"ligne":3,"type":"plaine"},{"colonne":10,"ligne":3,"type":"plaine"},{"colonne":11,"ligne":3,"type":"plaine"},{"colonne":12,"ligne":3,"type":"plaine"},{"colonne":13,"ligne":3,"type":"plaine"},{"colonne":14,"ligne":3,"type":"plaine"},{"colonne":15,"ligne":3,"type":"plaine"},{"colonne":16,"ligne":3,"type":"plaine"},{"colonne":17,"ligne":3,"type":"plaine"},{"colonne":18,"ligne":3,"type":"plaine"},{"colonne":19,"ligne":3,"type":"plaine"},{"colonne":20,"ligne":3,"type":"ponton"},{"colonne":21,"ligne":3,"type":"eau"},{"colonne":22,"ligne":3,"type":"eau"},{"colonne":23,"ligne":3,"type":"eau"},{"colonne":24,"ligne":3,"type":"plaine"},{"colonne":25,"ligne":3,"type":"eau"},{"colonne":26,"ligne":3,"type":"eau"},{"colonne":27,"ligne":3,"type":"eau"},{"colonne":28,"ligne":3,"type":"eau"},{"colonne":29,"ligne":3,"type":"eau"},{"colonne":30,"ligne":3,"type":"eau"},{"colonne":31,"ligne":3,"type":"eau"},{"colonne":32,"ligne":3,"type":"eau"},{"colonne":33,"ligne":3,"type":"eau"},{"colonne":34,"ligne":3,"type":"eau"},{"colonne":35,"ligne":3,"type":"eau"},{"colonne":36,"ligne":3,"type":"eau"},{"colonne":37,"ligne":3,"type":"eau"},{"colonne":38,"ligne":3,"type":"eau"},{"colonne":39,"ligne":3,"type":"eau"},{"colonne":0,"ligne":4,"type":"eau"},{"colonne":1,"ligne":4,"type":"eau"},{"colonne":2,"ligne":4,"type":"eau"},{"colonne":3,"ligne":4,"type":"eau"},{"colonne":4,"ligne":4,"type":"eau"},{"colonne":5,"ligne":4,"type":"eau"},{"colonne":6,"ligne":4,"type":"plaine"},{"colonne":7,"ligne":4,"type":"zone_speciale"},{"colonne":8,"ligne":4,"type":"zone_speciale"},{"colonne":9,"ligne":4,"type":"plaine"},{"colonne":10,"ligne":4,"type":"plaine"},{"colonne":11,"ligne":4,"type":"plaine"},{"colonne":12,"ligne":4,"type":"plaine"},{"colonne":13,"ligne":4,"type":"plaine"},{"colonne":14,"ligne":4,"type":"plaine"},{"colonne":15,"ligne":4,"type":"plaine"},{"colonne":16,"ligne":4,"type":"plaine"},{"colonne":17,"ligne":4,"type":"plaine"},{"colonne":18,"ligne":4,"type":"plaine"},{"colonne":19,"ligne":4,"type":"plaine"},{"colonne":20,"ligne":4,"type":"eau"},{"colonne":21,"ligne":4,"type":"eau"},{"colonne":22,"ligne":4,"type":"eau"},{"colonne":23,"ligne":4,"type":"eau"},{"colonne":24,"ligne":4,"type":"eau"},{"colonne":25,"ligne":4,"type":"eau"},{"colonne":26,"ligne":4,"type":"eau"},{"colonne":27,"ligne":4,"type":"eau"},{"colonne":28,"ligne":4,"type":"eau"},{"colonne":29,"ligne":4,"type":"eau"},{"colonne":30,"ligne":4,"type":"eau"},{"colonne":31,"ligne":4,"type":"eau"},{"colonne":32,"ligne":4,"type":"eau"},{"colonne":33,"ligne":4,"type":"eau"},{"colonne":34,"ligne":4,"type":"eau"},{"colonne":35,"ligne":4,"type":"eau"},{"colonne":36,"ligne":4,"type":"eau"},{"colonne":37,"ligne":4,"type":"eau"},{"colonne":38,"ligne":4,"type":"eau"},{"colonne":39,"ligne":4,"type":"eau"},{"colonne":0,"ligne":5,"type":"eau"},{"colonne":1,"ligne":5,"type":"eau"},{"colonne":2,"ligne":5,"type":"eau"},{"colonne":3,"ligne":5,"type":"eau"},{"colonne":4,"ligne":5,"type":"eau"},{"colonne":5,"ligne":5,"type":"plaine"},{"colonne":6,"ligne":5,"type":"plaine"},{"colonne":7,"ligne":5,"type":"plaine"},{"colonne":8,"ligne":5,"type":"plaine"},{"colonne":9,"ligne":5,"type":"plaine"},{"colonne":10,"ligne":5,"type":"plaine"},{"colonne":11,"ligne":5,"type":"plaine"},{"colonne":12,"ligne":5,"type":"plaine"},{"colonne":13,"ligne":5,"type":"plaine"},{"colonne":14,"ligne":5,"type":"plaine"},{"colonne":15,"ligne":5,"type":"plaine"},{"colonne":16,"ligne":5,"type":"plaine"},{"colonne":17,"ligne":5,"type":"plaine"},{"colonne":18,"ligne":5,"type":"plaine"},{"colonne":19,"ligne":5,"type":"plaine"},{"colonne":20,"ligne":5,"type":"plaine"},{"colonne":21,"ligne":5,"type":"eau"},{"colonne":22,"ligne":5,"type":"eau"},{"colonne":23,"ligne":5,"type":"plaine"},{"colonne":24,"ligne":5,"type":"plaine"},{"colonne":25,"ligne":5,"type":"eau"},{"colonne":26,"ligne":5,"type":"eau"},{"colonne":27,"ligne":5,"type":"eau"},{"colonne":28,"ligne":5,"type":"zone_speciale"},{"colonne":29,"ligne":5,"type":"zone_speciale"},{"colonne":30,"ligne":5,"type":"eau"},{"colonne":31,"ligne":5,"type":"eau"},{"colonne":32,"ligne":5,"type":"eau"},{"colonne":33,"ligne":5,"type":"eau"},{"colonne":34,"ligne":5,"type":"eau"},{"colonne":35,"ligne":5,"type":"eau"},{"colonne":36,"ligne":5,"type":"eau"},{"colonne":37,"ligne":5,"type":"eau"},{"colonne":38,"ligne":5,"type":"eau"},{"colonne":39,"ligne":5,"type":"eau"},{"colonne":0,"ligne":6,"type":"eau"},{"colonne":1,"ligne":6,"type":"eau"},{"colonne":2,"ligne":6,"type":"eau"},{"colonne":3,"ligne":6,"type":"ponton"},{"colonne":4,"ligne":6,"type":"plaine"},{"colonne":5,"ligne":6,"type":"plaine"},{"colonne":6,"ligne":6,"type":"plaine"},{"colonne":7,"ligne":6,"type":"plaine"},{"colonne":8,"ligne":6,"type":"plaine"},{"colonne":9,"ligne":6,"type":"plaine"},{"colonne":10,"ligne":6,"type":"plaine"},{"colonne":11,"ligne":6,"type":"ville"},{"colonne":12,"ligne":6,"type":"ville"},{"colonne":13,"ligne":6,"type":"plaine"},{"colonne":14,"ligne":6,"type":"plaine"},{"colonne":15,"ligne":6,"type":"plaine"},{"colonne":16,"ligne":6,"type":"plaine"},{"colonne":17,"ligne":6,"type":"plaine"},{"colonne":18,"ligne":6,"type":"plaine"},{"colonne":19,"ligne":6,"type":"plaine"},{"colonne":20,"ligne":6,"type":"plaine"},{"colonne":21,"ligne":6,"type":"plaine"},{"colonne":22,"ligne":6,"type":"plaine"},{"colonne":23,"ligne":6,"type":"plaine"},{"colonne":24,"ligne":6,"type":"eau"},{"colonne":25,"ligne":6,"type":"eau"},{"colonne":26,"ligne":6,"type":"eau"},{"colonne":27,"ligne":6,"type":"eau"},{"colonne":28,"ligne":6,"type":"zone_speciale"},{"colonne":29,"ligne":6,"type":"zone_speciale"},{"colonne":30,"ligne":6,"type":"eau"},{"colonne":31,"ligne":6,"type":"eau"},{"colonne":32,"ligne":6,"type":"eau"},{"colonne":33,"ligne":6,"type":"eau"},{"colonne":34,"ligne":6,"type":"eau"},{"colonne":35,"ligne":6,"type":"eau"},{"colonne":36,"ligne":6,"type":"eau"},{"colonne":37,"ligne":6,"type":"eau"},{"colonne":38,"ligne":6,"type":"eau"},{"colonne":39,"ligne":6,"type":"eau"},{"colonne":0,"ligne":7,"type":"eau"},{"colonne":1,"ligne":7,"type":"eau"},{"colonne":2,"ligne":7,"type":"eau"},{"colonne":3,"ligne":7,"type":"eau"},{"colonne":4,"ligne":7,"type":"plaine"},{"colonne":5,"ligne":7,"type":"plaine"},{"colonne":6,"ligne":7,"type":"plaine"},{"colonne":7,"ligne":7,"type":"plaine"},{"colonne":8,"ligne":7,"type":"plaine"},{"colonne":9,"ligne":7,"type":"plaine"},{"colonne":10,"ligne":7,"type":"plaine"},{"colonne":11,"ligne":7,"type":"plaine"},{"colonne":12,"ligne":7,"type":"plaine"},{"colonne":13,"ligne":7,"type":"foret"},{"colonne":14,"ligne":7,"type":"foret"},{"colonne":15,"ligne":7,"type":"montagne"},{"colonne":16,"ligne":7,"type":"montagne"},{"colonne":17,"ligne":7,"type":"plaine"},{"colonne":18,"ligne":7,"type":"plaine"},{"colonne":19,"ligne":7,"type":"plaine"},{"colonne":20,"ligne":7,"type":"plaine"},{"colonne":21,"ligne":7,"type":"plaine"},{"colonne":22,"ligne":7,"type":"plaine"},{"colonne":23,"ligne":7,"type":"eau"},{"colonne":24,"ligne":7,"type":"eau"},{"colonne":25,"ligne":7,"type":"eau"},{"colonne":26,"ligne":7,"type":"eau"},{"colonne":27,"ligne":7,"type":"eau"},{"colonne":28,"ligne":7,"type":"eau"},{"colonne":29,"ligne":7,"type":"eau"},{"colonne":30,"ligne":7,"type":"eau"},{"colonne":31,"ligne":7,"type":"eau"},{"colonne":32,"ligne":7,"type":"eau"},{"colonne":33,"ligne":7,"type":"eau"},{"colonne":34,"ligne":7,"type":"eau"},{"colonne":35,"ligne":7,"type":"eau"},{"colonne":36,"ligne":7,"type":"eau"},{"colonne":37,"ligne":7,"type":"eau"},{"colonne":38,"ligne":7,"type":"eau"},{"colonne":39,"ligne":7,"type":"eau"},{"colonne":0,"ligne":8,"type":"eau"},{"colonne":1,"ligne":8,"type":"eau"},{"colonne":2,"ligne":8,"type":"eau"},{"colonne":3,"ligne":8,"type":"eau"},{"colonne":4,"ligne":8,"type":"eau"},{"colonne":5,"ligne":8,"type":"eau"},{"colonne":6,"ligne":8,"type":"plaine"},{"colonne":7,"ligne":8,"type":"plaine"},{"colonne":8,"ligne":8,"type":"plaine"},{"colonne":9,"ligne":8,"type":"plaine"},{"colonne":10,"ligne":8,"type":"plaine"},{"colonne":11,"ligne":8,"type":"plaine"},{"colonne":12,"ligne":8,"type":"plaine"},{"colonne":13,"ligne":8,"type":"foret"},{"colonne":14,"ligne":8,"type":"foret"},{"colonne":15,"ligne":8,"type":"plaine"},{"colonne":16,"ligne":8,"type":"montagne"},{"colonne":17,"ligne":8,"type":"montagne"},{"colonne":18,"ligne":8,"type":"montagne"},{"colonne":19,"ligne":8,"type":"plaine"},{"colonne":20,"ligne":8,"type":"plaine"},{"colonne":21,"ligne":8,"type":"eau"},{"colonne":22,"ligne":8,"type":"eau"},{"colonne":23,"ligne":8,"type":"eau"},{"colonne":24,"ligne":8,"type":"eau"},{"colonne":25,"ligne":8,"type":"eau"},{"colonne":26,"ligne":8,"type":"eau"},{"colonne":27,"ligne":8,"type":"eau"},{"colonne":28,"ligne":8,"type":"eau"},{"colonne":29,"ligne":8,"type":"eau"},{"colonne":30,"ligne":8,"type":"eau"},{"colonne":31,"ligne":8,"type":"eau"},{"colonne":32,"ligne":8,"type":"eau"},{"colonne":33,"ligne":8,"type":"eau"},{"colonne":34,"ligne":8,"type":"eau"},{"colonne":35,"ligne":8,"type":"eau"},{"colonne":36,"ligne":8,"type":"eau"},{"colonne":37,"ligne":8,"type":"eau"},{"colonne":38,"ligne":8,"type":"eau"},{"colonne":39,"ligne":8,"type":"eau"},{"colonne":0,"ligne":9,"type":"eau"},{"colonne":1,"ligne":9,"type":"eau"},{"colonne":2,"ligne":9,"type":"eau"},{"colonne":3,"ligne":9,"type":"eau"},{"colonne":4,"ligne":9,"type":"eau"},{"colonne":5,"ligne":9,"type":"eau"},{"colonne":6,"ligne":9,"type":"eau"},{"colonne":7,"ligne":9,"type":"plaine"},{"colonne":8,"ligne":9,"type":"plaine"},{"colonne":9,"ligne":9,"type":"plaine"},{"colonne":10,"ligne":9,"type":"plaine"},{"colonne":11,"ligne":9,"type":"plaine"},{"colonne":12,"ligne":9,"type":"plaine"},{"colonne":13,"ligne":9,"type":"plaine"},{"colonne":14,"ligne":9,"type":"plaine"},{"colonne":15,"ligne":9,"type":"plaine"},{"colonne":16,"ligne":9,"type":"montagne"},{"colonne":17,"ligne":9,"type":"plaine"},{"colonne":18,"ligne":9,"type":"plaine"},{"colonne":19,"ligne":9,"type":"plaine"},{"colonne":20,"ligne":9,"type":"plaine"},{"colonne":21,"ligne":9,"type":"plaine"},{"colonne":22,"ligne":9,"type":"eau"},{"colonne":23,"ligne":9,"type":"ville"},{"colonne":24,"ligne":9,"type":"ville"},{"colonne":25,"ligne":9,"type":"eau"},{"colonne":26,"ligne":9,"type":"eau"},{"colonne":27,"ligne":9,"type":"eau"},{"colonne":28,"ligne":9,"type":"eau"},{"colonne":29,"ligne":9,"type":"eau"},{"colonne":30,"ligne":9,"type":"eau"},{"colonne":31,"ligne":9,"type":"eau"},{"colonne":32,"ligne":9,"type":"eau"},{"colonne":33,"ligne":9,"type":"eau"},{"colonne":34,"ligne":9,"type":"eau"},{"colonne":35,"ligne":9,"type":"eau"},{"colonne":36,"ligne":9,"type":"eau"},{"colonne":37,"ligne":9,"type":"eau"},{"colonne":38,"ligne":9,"type":"eau"},{"colonne":39,"ligne":9,"type":"eau"},{"colonne":0,"ligne":10,"type":"eau"},{"colonne":1,"ligne":10,"type":"eau"},{"colonne":2,"ligne":10,"type":"eau"},{"colonne":3,"ligne":10,"type":"eau"},{"colonne":4,"ligne":10,"type":"eau"},{"colonne":5,"ligne":10,"type":"eau"},{"colonne":6,"ligne":10,"type":"eau"},{"colonne":7,"ligne":10,"type":"eau"},{"colonne":8,"ligne":10,"type":"plaine"},{"colonne":9,"ligne":10,"type":"plaine"},{"colonne":10,"ligne":10,"type":"plaine"},{"colonne":11,"ligne":10,"type":"plaine"},{"colonne":12,"ligne":10,"type":"plaine"},{"colonne":13,"ligne":10,"type":"plaine"},{"colonne":14,"ligne":10,"type":"plaine"},{"colonne":15,"ligne":10,"type":"montagne"},{"colonne":16,"ligne":10,"type":"montagne"},{"colonne":17,"ligne":10,"type":"plaine"},{"colonne":18,"ligne":10,"type":"plaine"},{"colonne":19,"ligne":10,"type":"plaine"},{"colonne":20,"ligne":10,"type":"plaine"},{"colonne":21,"ligne":10,"type":"plaine"},{"colonne":22,"ligne":10,"type":"plaine"},{"colonne":23,"ligne":10,"type":"eau"},{"colonne":24,"ligne":10,"type":"eau"},{"colonne":25,"ligne":10,"type":"eau"},{"colonne":26,"ligne":10,"type":"plaine"},{"colonne":27,"ligne":10,"type":"plaine"},{"colonne":28,"ligne":10,"type":"eau"},{"colonne":29,"ligne":10,"type":"eau"},{"colonne":30,"ligne":10,"type":"eau"},{"colonne":31,"ligne":10,"type":"eau"},{"colonne":32,"ligne":10,"type":"eau"},{"colonne":33,"ligne":10,"type":"eau"},{"colonne":34,"ligne":10,"type":"eau"},{"colonne":35,"ligne":10,"type":"eau"},{"colonne":36,"ligne":10,"type":"eau"},{"colonne":37,"ligne":10,"type":"eau"},{"colonne":38,"ligne":10,"type":"eau"},{"colonne":39,"ligne":10,"type":"eau"},{"colonne":0,"ligne":11,"type":"eau"},{"colonne":1,"ligne":11,"type":"eau"},{"colonne":2,"ligne":11,"type":"eau"},{"colonne":3,"ligne":11,"type":"eau"},{"colonne":4,"ligne":11,"type":"eau"},{"colonne":5,"ligne":11,"type":"eau"},{"colonne":6,"ligne":11,"type":"eau"},{"colonne":7,"ligne":11,"type":"plaine"},{"colonne":8,"ligne":11,"type":"plaine"},{"colonne":9,"ligne":11,"type":"plaine"},{"colonne":10,"ligne":11,"type":"plaine"},{"colonne":11,"ligne":11,"type":"plaine"},{"colonne":12,"ligne":11,"type":"plaine"},{"colonne":13,"ligne":11,"type":"plaine"},{"colonne":14,"ligne":11,"type":"montagne"},{"colonne":15,"ligne":11,"type":"montagne"},{"colonne":16,"ligne":11,"type":"plaine"},{"colonne":17,"ligne":11,"type":"plaine"},{"colonne":18,"ligne":11,"type":"plaine"},{"colonne":19,"ligne":11,"type":"montagne"},{"colonne":20,"ligne":11,"type":"montagne"},{"colonne":21,"ligne":11,"type":"plaine"},{"colonne":22,"ligne":11,"type":"plaine"},{"colonne":23,"ligne":11,"type":"plaine"},{"colonne":24,"ligne":11,"type":"eau"},{"colonne":25,"ligne":11,"type":"plaine"},{"colonne":26,"ligne":11,"type":"plaine"},{"colonne":27,"ligne":11,"type":"plaine"},{"colonne":28,"ligne":11,"type":"eau"},{"colonne":29,"ligne":11,"type":"eau"},{"colonne":30,"ligne":11,"type":"eau"},{"colonne":31,"ligne":11,"type":"eau"},{"colonne":32,"ligne":11,"type":"eau"},{"colonne":33,"ligne":11,"type":"eau"},{"colonne":34,"ligne":11,"type":"eau"},{"colonne":35,"ligne":11,"type":"eau"},{"colonne":36,"ligne":11,"type":"eau"},{"colonne":37,"ligne":11,"type":"eau"},{"colonne":38,"ligne":11,"type":"eau"},{"colonne":39,"ligne":11,"type":"eau"},{"colonne":0,"ligne":12,"type":"eau"},{"colonne":1,"ligne":12,"type":"eau"},{"colonne":2,"ligne":12,"type":"eau"},{"colonne":3,"ligne":12,"type":"eau"},{"colonne":4,"ligne":12,"type":"eau"},{"colonne":5,"ligne":12,"type":"plaine"},{"colonne":6,"ligne":12,"type":"plaine"},{"colonne":7,"ligne":12,"type":"plaine"},{"colonne":8,"ligne":12,"type":"plaine"},{"colonne":9,"ligne":12,"type":"plaine"},{"colonne":10,"ligne":12,"type":"plaine"},{"colonne":11,"ligne":12,"type":"plaine"},{"colonne":12,"ligne":12,"type":"plaine"},{"colonne":13,"ligne":12,"type":"plaine"},{"colonne":14,"ligne":12,"type":"montagne"},{"colonne":15,"ligne":12,"type":"plaine"},{"colonne":16,"ligne":12,"type":"plaine"},{"colonne":17,"ligne":12,"type":"plaine"},{"colonne":18,"ligne":12,"type":"ville"},{"colonne":19,"ligne":12,"type":"montagne"},{"colonne":20,"ligne":12,"type":"montagne"},{"colonne":21,"ligne":12,"type":"plaine"},{"colonne":22,"ligne":12,"type":"plaine"},{"colonne":23,"ligne":12,"type":"plaine"},{"colonne":24,"ligne":12,"type":"plaine"},{"colonne":25,"ligne":12,"type":"foret"},{"colonne":26,"ligne":12,"type":"plaine"},{"colonne":27,"ligne":12,"type":"plaine"},{"colonne":28,"ligne":12,"type":"plaine"},{"colonne":29,"ligne":12,"type":"plaine"},{"colonne":30,"ligne":12,"type":"ponton"},{"colonne":31,"ligne":12,"type":"plaine"},{"colonne":32,"ligne":12,"type":"plaine"},{"colonne":33,"ligne":12,"type":"eau"},{"colonne":34,"ligne":12,"type":"eau"},{"colonne":35,"ligne":12,"type":"eau"},{"colonne":36,"ligne":12,"type":"eau"},{"colonne":37,"ligne":12,"type":"eau"},{"colonne":38,"ligne":12,"type":"eau"},{"colonne":39,"ligne":12,"type":"eau"},{"colonne":0,"ligne":13,"type":"eau"},{"colonne":1,"ligne":13,"type":"eau"},{"colonne":2,"ligne":13,"type":"eau"},{"colonne":3,"ligne":13,"type":"eau"},{"colonne":4,"ligne":13,"type":"eau"},{"colonne":5,"ligne":13,"type":"plaine"},{"colonne":6,"ligne":13,"type":"plaine"},{"colonne":7,"ligne":13,"type":"plaine"},{"colonne":8,"ligne":13,"type":"plaine"},{"colonne":9,"ligne":13,"type":"plaine"},{"colonne":10,"ligne":13,"type":"plaine"},{"colonne":11,"ligne":13,"type":"plaine"},{"colonne":12,"ligne":13,"type":"plaine"},{"colonne":13,"ligne":13,"type":"montagne"},{"colonne":14,"ligne":13,"type":"montagne"},{"colonne":15,"ligne":13,"type":"plaine"},{"colonne":16,"ligne":13,"type":"plaine"},{"colonne":17,"ligne":13,"type":"plaine"},{"colonne":18,"ligne":13,"type":"ville"},{"colonne":19,"ligne":13,"type":"montagne"},{"colonne":20,"ligne":13,"type":"montagne"},{"colonne":21,"ligne":13,"type":"montagne"},{"colonne":22,"ligne":13,"type":"plaine"},{"colonne":23,"ligne":13,"type":"plaine"},{"colonne":24,"ligne":13,"type":"foret"},{"colonne":25,"ligne":13,"type":"foret"},{"colonne":26,"ligne":13,"type":"foret"},{"colonne":27,"ligne":13,"type":"plaine"},{"colonne":28,"ligne":13,"type":"plaine"},{"colonne":29,"ligne":13,"type":"plaine"},{"colonne":30,"ligne":13,"type":"plaine"},{"colonne":31,"ligne":13,"type":"plaine"},{"colonne":32,"ligne":13,"type":"plaine"},{"colonne":33,"ligne":13,"type":"plaine"},{"colonne":34,"ligne":13,"type":"plaine"},{"colonne":35,"ligne":13,"type":"plaine"},{"colonne":36,"ligne":13,"type":"eau"},{"colonne":37,"ligne":13,"type":"eau"},{"colonne":38,"ligne":13,"type":"eau"},{"colonne":39,"ligne":13,"type":"eau"},{"colonne":0,"ligne":14,"type":"eau"},{"colonne":1,"ligne":14,"type":"eau"},{"colonne":2,"ligne":14,"type":"eau"},{"colonne":3,"ligne":14,"type":"plaine"},{"colonne":4,"ligne":14,"type":"plaine"},{"colonne":5,"ligne":14,"type":"foret"},{"colonne":6,"ligne":14,"type":"plaine"},{"colonne":7,"ligne":14,"type":"plaine"},{"colonne":8,"ligne":14,"type":"plaine"},{"colonne":9,"ligne":14,"type":"plaine"},{"colonne":10,"ligne":14,"type":"plaine"},{"colonne":11,"ligne":14,"type":"plaine"},{"colonne":12,"ligne":14,"type":"plaine"},{"colonne":13,"ligne":14,"type":"montagne"},{"colonne":14,"ligne":14,"type":"plaine"},{"colonne":15,"ligne":14,"type":"plaine"},{"colonne":16,"ligne":14,"type":"plaine"},{"colonne":17,"ligne":14,"type":"plaine"},{"colonne":18,"ligne":14,"type":"plaine"},{"colonne":19,"ligne":14,"type":"plaine"},{"colonne":20,"ligne":14,"type":"montagne"},{"colonne":21,"ligne":14,"type":"montagne"},{"colonne":22,"ligne":14,"type":"montagne"},{"colonne":23,"ligne":14,"type":"plaine"},{"colonne":24,"ligne":14,"type":"plaine"},{"colonne":25,"ligne":14,"type":"plaine"},{"colonne":26,"ligne":14,"type":"plaine"},{"colonne":27,"ligne":14,"type":"plaine"},{"colonne":28,"ligne":14,"type":"plaine"},{"colonne":29,"ligne":14,"type":"plaine"},{"colonne":30,"ligne":14,"type":"plaine"},{"colonne":31,"ligne":14,"type":"plaine"},{"colonne":32,"ligne":14,"type":"plaine"},{"colonne":33,"ligne":14,"type":"plaine"},{"colonne":34,"ligne":14,"type":"plaine"},{"colonne":35,"ligne":14,"type":"eau"},{"colonne":36,"ligne":14,"type":"eau"},{"colonne":37,"ligne":14,"type":"eau"},{"colonne":38,"ligne":14,"type":"eau"},{"colonne":39,"ligne":14,"type":"eau"},{"colonne":0,"ligne":15,"type":"eau"},{"colonne":1,"ligne":15,"type":"eau"},{"colonne":2,"ligne":15,"type":"eau"},{"colonne":3,"ligne":15,"type":"plaine"},{"colonne":4,"ligne":15,"type":"plaine"},{"colonne":5,"ligne":15,"type":"foret"},{"colonne":6,"ligne":15,"type":"plaine"},{"colonne":7,"ligne":15,"type":"plaine"},{"colonne":8,"ligne":15,"type":"plaine"},{"colonne":9,"ligne":15,"type":"plaine"},{"colonne":10,"ligne":15,"type":"plaine"},{"colonne":11,"ligne":15,"type":"plaine"},{"colonne":12,"ligne":15,"type":"plaine"},{"colonne":13,"ligne":15,"type":"montagne"},{"colonne":14,"ligne":15,"type":"montagne"},{"colonne":15,"ligne":15,"type":"plaine"},{"colonne":16,"ligne":15,"type":"plaine"},{"colonne":17,"ligne":15,"type":"plaine"},{"colonne":18,"ligne":15,"type":"plaine"},{"colonne":19,"ligne":15,"type":"plaine"},{"colonne":20,"ligne":15,"type":"plaine"},{"colonne":21,"ligne":15,"type":"plaine"},{"colonne":22,"ligne":15,"type":"plaine"},{"colonne":23,"ligne":15,"type":"montagne"},{"colonne":24,"ligne":15,"type":"montagne"},{"colonne":25,"ligne":15,"type":"plaine"},{"colonne":26,"ligne":15,"type":"plaine"},{"colonne":27,"ligne":15,"type":"plaine"},{"colonne":28,"ligne":15,"type":"plaine"},{"colonne":29,"ligne":15,"type":"plaine"},{"colonne":30,"ligne":15,"type":"plaine"},{"colonne":31,"ligne":15,"type":"plaine"},{"colonne":32,"ligne":15,"type":"plaine"},{"colonne":33,"ligne":15,"type":"plaine"},{"colonne":34,"ligne":15,"type":"plaine"},{"colonne":35,"ligne":15,"type":"plaine"},{"colonne":36,"ligne":15,"type":"eau"},{"colonne":37,"ligne":15,"type":"eau"},{"colonne":38,"ligne":15,"type":"eau"},{"colonne":39,"ligne":15,"type":"eau"},{"colonne":0,"ligne":16,"type":"eau"},{"colonne":1,"ligne":16,"type":"eau"},{"colonne":2,"ligne":16,"type":"plaine"},{"colonne":3,"ligne":16,"type":"plaine"},{"colonne":4,"ligne":16,"type":"plaine"},{"colonne":5,"ligne":16,"type":"foret"},{"colonne":6,"ligne":16,"type":"plaine"},{"colonne":7,"ligne":16,"type":"plaine"},{"colonne":8,"ligne":16,"type":"plaine"},{"colonne":9,"ligne":16,"type":"plaine"},{"colonne":10,"ligne":16,"type":"plaine"},{"colonne":11,"ligne":16,"type":"plaine"},{"colonne":12,"ligne":16,"type":"plaine"},{"colonne":13,"ligne":16,"type":"plaine"},{"colonne":14,"ligne":16,"type":"montagne"},{"colonne":15,"ligne":16,"type":"montagne"},{"colonne":16,"ligne":16,"type":"montagne"},{"colonne":17,"ligne":16,"type":"montagne"},{"colonne":18,"ligne":16,"type":"plaine"},{"colonne":19,"ligne":16,"type":"plaine"},{"colonne":20,"ligne":16,"type":"plaine"},{"colonne":21,"ligne":16,"type":"plaine"},{"colonne":22,"ligne":16,"type":"plaine"},{"colonne":23,"ligne":16,"type":"montagne"},{"colonne":24,"ligne":16,"type":"montagne"},{"colonne":25,"ligne":16,"type":"plaine"},{"colonne":26,"ligne":16,"type":"plaine"},{"colonne":27,"ligne":16,"type":"plaine"},{"colonne":28,"ligne":16,"type":"plaine"},{"colonne":29,"ligne":16,"type":"plaine"},{"colonne":30,"ligne":16,"type":"ville"},{"colonne":31,"ligne":16,"type":"ville"},{"colonne":32,"ligne":16,"type":"plaine"},{"colonne":33,"ligne":16,"type":"plaine"},{"colonne":34,"ligne":16,"type":"eau"},{"colonne":35,"ligne":16,"type":"eau"},{"colonne":36,"ligne":16,"type":"eau"},{"colonne":37,"ligne":16,"type":"eau"},{"colonne":38,"ligne":16,"type":"eau"},{"colonne":39,"ligne":16,"type":"eau"},{"colonne":0,"ligne":17,"type":"eau"},{"colonne":1,"ligne":17,"type":"eau"},{"colonne":2,"ligne":17,"type":"eau"},{"colonne":3,"ligne":17,"type":"eau"},{"colonne":4,"ligne":17,"type":"plaine"},{"colonne":5,"ligne":17,"type":"plaine"},{"colonne":6,"ligne":17,"type":"plaine"},{"colonne":7,"ligne":17,"type":"plaine"},{"colonne":8,"ligne":17,"type":"plaine"},{"colonne":9,"ligne":17,"type":"plaine"},{"colonne":10,"ligne":17,"type":"plaine"},{"colonne":11,"ligne":17,"type":"plaine"},{"colonne":12,"ligne":17,"type":"plaine"},{"colonne":13,"ligne":17,"type":"plaine"},{"colonne":14,"ligne":17,"type":"plaine"},{"colonne":15,"ligne":17,"type":"plaine"},{"colonne":16,"ligne":17,"type":"montagne"},{"colonne":17,"ligne":17,"type":"montagne"},{"colonne":18,"ligne":17,"type":"montagne"},{"colonne":19,"ligne":17,"type":"plaine"},{"colonne":20,"ligne":17,"type":"plaine"},{"colonne":21,"ligne":17,"type":"plaine"},{"colonne":22,"ligne":17,"type":"plaine"},{"colonne":23,"ligne":17,"type":"montagne"},{"colonne":24,"ligne":17,"type":"montagne"},{"colonne":25,"ligne":17,"type":"plaine"},{"colonne":26,"ligne":17,"type":"plaine"},{"colonne":27,"ligne":17,"type":"plaine"},{"colonne":28,"ligne":17,"type":"plaine"},{"colonne":29,"ligne":17,"type":"plaine"},{"colonne":30,"ligne":17,"type":"ville"},{"colonne":31,"ligne":17,"type":"ville"},{"colonne":32,"ligne":17,"type":"eau"},{"colonne":33,"ligne":17,"type":"eau"},{"colonne":34,"ligne":17,"type":"eau"},{"colonne":35,"ligne":17,"type":"eau"},{"colonne":36,"ligne":17,"type":"eau"},{"colonne":37,"ligne":17,"type":"eau"},{"colonne":38,"ligne":17,"type":"eau"},{"colonne":39,"ligne":17,"type":"eau"},{"colonne":0,"ligne":18,"type":"eau"},{"colonne":1,"ligne":18,"type":"eau"},{"colonne":2,"ligne":18,"type":"eau"},{"colonne":3,"ligne":18,"type":"eau"},{"colonne":4,"ligne":18,"type":"plaine"},{"colonne":5,"ligne":18,"type":"ponton"},{"colonne":6,"ligne":18,"type":"eau"},{"colonne":7,"ligne":18,"type":"eau"},{"colonne":8,"ligne":18,"type":"eau"},{"colonne":9,"ligne":18,"type":"eau"},{"colonne":10,"ligne":18,"type":"plaine"},{"colonne":11,"ligne":18,"type":"plaine"},{"colonne":12,"ligne":18,"type":"plaine"},{"colonne":13,"ligne":18,"type":"zone_speciale"},{"colonne":14,"ligne":18,"type":"zone_speciale"},{"colonne":15,"ligne":18,"type":"plaine"},{"colonne":16,"ligne":18,"type":"ville"},{"colonne":17,"ligne":18,"type":"montagne"},{"colonne":18,"ligne":18,"type":"montagne"},{"colonne":19,"ligne":18,"type":"plaine"},{"colonne":20,"ligne":18,"type":"plaine"},{"colonne":21,"ligne":18,"type":"plaine"},{"colonne":22,"ligne":18,"type":"vide"},{"colonne":23,"ligne":18,"type":"montagne"},{"colonne":24,"ligne":18,"type":"montagne"},{"colonne":25,"ligne":18,"type":"plaine"},{"colonne":26,"ligne":18,"type":"plaine"},{"colonne":27,"ligne":18,"type":"plaine"},{"colonne":28,"ligne":18,"type":"plaine"},{"colonne":29,"ligne":18,"type":"plaine"},{"colonne":30,"ligne":18,"type":"plaine"},{"colonne":31,"ligne":18,"type":"zone_speciale"},{"colonne":32,"ligne":18,"type":"zone_speciale"},{"colonne":33,"ligne":18,"type":"eau"},{"colonne":34,"ligne":18,"type":"eau"},{"colonne":35,"ligne":18,"type":"eau"},{"colonne":36,"ligne":18,"type":"eau"},{"colonne":37,"ligne":18,"type":"eau"},{"colonne":38,"ligne":18,"type":"eau"},{"colonne":39,"ligne":18,"type":"eau"},{"colonne":0,"ligne":19,"type":"eau"},{"colonne":1,"ligne":19,"type":"eau"},{"colonne":2,"ligne":19,"type":"eau"},{"colonne":3,"ligne":19,"type":"eau"},{"colonne":4,"ligne":19,"type":"eau"},{"colonne":5,"ligne":19,"type":"eau"},{"colonne":6,"ligne":19,"type":"eau"},{"colonne":7,"ligne":19,"type":"eau"},{"colonne":8,"ligne":19,"type":"eau"},{"colonne":9,"ligne":19,"type":"eau"},{"colonne":10,"ligne":19,"type":"eau"},{"colonne":11,"ligne":19,"type":"plaine"},{"colonne":12,"ligne":19,"type":"plaine"},{"colonne":13,"ligne":19,"type":"plaine"},{"colonne":14,"ligne":19,"type":"plaine"},{"colonne":15,"ligne":19,"type":"plaine"},{"colonne":16,"ligne":19,"type":"plaine"},{"colonne":17,"ligne":19,"type":"montagne"},{"colonne":18,"ligne":19,"type":"montagne"},{"colonne":19,"ligne":19,"type":"plaine"},{"colonne":20,"ligne":19,"type":"plaine"},{"colonne":21,"ligne":19,"type":"plaine"},{"colonne":22,"ligne":19,"type":"montagne"},{"colonne":23,"ligne":19,"type":"montagne"},{"colonne":24,"ligne":19,"type":"montagne"},{"colonne":25,"ligne":19,"type":"plaine"},{"colonne":26,"ligne":19,"type":"plaine"},{"colonne":27,"ligne":19,"type":"plaine"},{"colonne":28,"ligne":19,"type":"plaine"},{"colonne":29,"ligne":19,"type":"plaine"},{"colonne":30,"ligne":19,"type":"plaine"},{"colonne":31,"ligne":19,"type":"zone_speciale"},{"colonne":32,"ligne":19,"type":"zone_speciale"},{"colonne":33,"ligne":19,"type":"eau"},{"colonne":34,"ligne":19,"type":"eau"},{"colonne":35,"ligne":19,"type":"eau"},{"colonne":36,"ligne":19,"type":"eau"},{"colonne":37,"ligne":19,"type":"eau"},{"colonne":38,"ligne":19,"type":"eau"},{"colonne":39,"ligne":19,"type":"eau"},{"colonne":0,"ligne":20,"type":"eau"},{"colonne":1,"ligne":20,"type":"eau"},{"colonne":2,"ligne":20,"type":"eau"},{"colonne":3,"ligne":20,"type":"eau"},{"colonne":4,"ligne":20,"type":"eau"},{"colonne":5,"ligne":20,"type":"eau"},{"colonne":6,"ligne":20,"type":"eau"},{"colonne":7,"ligne":20,"type":"eau"},{"colonne":8,"ligne":20,"type":"eau"},{"colonne":9,"ligne":20,"type":"eau"},{"colonne":10,"ligne":20,"type":"plaine"},{"colonne":11,"ligne":20,"type":"plaine"},{"colonne":12,"ligne":20,"type":"plaine"},{"colonne":13,"ligne":20,"type":"plaine"},{"colonne":14,"ligne":20,"type":"plaine"},{"colonne":15,"ligne":20,"type":"plaine"},{"colonne":16,"ligne":20,"type":"montagne"},{"colonne":17,"ligne":20,"type":"montagne"},{"colonne":18,"ligne":20,"type":"plaine"},{"colonne":19,"ligne":20,"type":"foret"},{"colonne":20,"ligne":20,"type":"plaine"},{"colonne":21,"ligne":20,"type":"plaine"},{"colonne":22,"ligne":20,"type":"plaine"},{"colonne":23,"ligne":20,"type":"plaine"},{"colonne":24,"ligne":20,"type":"plaine"},{"colonne":25,"ligne":20,"type":"plaine"},{"colonne":26,"ligne":20,"type":"plaine"},{"colonne":27,"ligne":20,"type":"plaine"},{"colonne":28,"ligne":20,"type":"plaine"},{"colonne":29,"ligne":20,"type":"plaine"},{"colonne":30,"ligne":20,"type":"eau"},{"colonne":31,"ligne":20,"type":"eau"},{"colonne":32,"ligne":20,"type":"eau"},{"colonne":33,"ligne":20,"type":"eau"},{"colonne":34,"ligne":20,"type":"eau"},{"colonne":35,"ligne":20,"type":"eau"},{"colonne":36,"ligne":20,"type":"eau"},{"colonne":37,"ligne":20,"type":"eau"},{"colonne":38,"ligne":20,"type":"eau"},{"colonne":39,"ligne":20,"type":"eau"},{"colonne":0,"ligne":21,"type":"eau"},{"colonne":1,"ligne":21,"type":"eau"},{"colonne":2,"ligne":21,"type":"eau"},{"colonne":3,"ligne":21,"type":"eau"},{"colonne":4,"ligne":21,"type":"eau"},{"colonne":5,"ligne":21,"type":"eau"},{"colonne":6,"ligne":21,"type":"eau"},{"colonne":7,"ligne":21,"type":"eau"},{"colonne":8,"ligne":21,"type":"eau"},{"colonne":9,"ligne":21,"type":"eau"},{"colonne":10,"ligne":21,"type":"eau"},{"colonne":11,"ligne":21,"type":"plaine"},{"colonne":12,"ligne":21,"type":"plaine"},{"colonne":13,"ligne":21,"type":"plaine"},{"colonne":14,"ligne":21,"type":"plaine"},{"colonne":15,"ligne":21,"type":"plaine"},{"colonne":16,"ligne":21,"type":"montagne"},{"colonne":17,"ligne":21,"type":"montagne"},{"colonne":18,"ligne":21,"type":"plaine"},{"colonne":19,"ligne":21,"type":"foret"},{"colonne":20,"ligne":21,"type":"foret"},{"colonne":21,"ligne":21,"type":"plaine"},{"colonne":22,"ligne":21,"type":"foret"},{"colonne":23,"ligne":21,"type":"plaine"},{"colonne":24,"ligne":21,"type":"plaine"},{"colonne":25,"ligne":21,"type":"plaine"},{"colonne":26,"ligne":21,"type":"plaine"},{"colonne":27,"ligne":21,"type":"plaine"},{"colonne":28,"ligne":21,"type":"plaine"},{"colonne":29,"ligne":21,"type":"plaine"},{"colonne":30,"ligne":21,"type":"plaine"},{"colonne":31,"ligne":21,"type":"eau"},{"colonne":32,"ligne":21,"type":"eau"},{"colonne":33,"ligne":21,"type":"eau"},{"colonne":34,"ligne":21,"type":"eau"},{"colonne":35,"ligne":21,"type":"eau"},{"colonne":36,"ligne":21,"type":"eau"},{"colonne":37,"ligne":21,"type":"eau"},{"colonne":38,"ligne":21,"type":"eau"},{"colonne":39,"ligne":21,"type":"eau"},{"colonne":0,"ligne":22,"type":"eau"},{"colonne":1,"ligne":22,"type":"eau"},{"colonne":2,"ligne":22,"type":"eau"},{"colonne":3,"ligne":22,"type":"eau"},{"colonne":4,"ligne":22,"type":"eau"},{"colonne":5,"ligne":22,"type":"eau"},{"colonne":6,"ligne":22,"type":"eau"},{"colonne":7,"ligne":22,"type":"eau"},{"colonne":8,"ligne":22,"type":"eau"},{"colonne":9,"ligne":22,"type":"eau"},{"colonne":10,"ligne":22,"type":"eau"},{"colonne":11,"ligne":22,"type":"plaine"},{"colonne":12,"ligne":22,"type":"plaine"},{"colonne":13,"ligne":22,"type":"plaine"},{"colonne":14,"ligne":22,"type":"plaine"},{"colonne":15,"ligne":22,"type":"plaine"},{"colonne":16,"ligne":22,"type":"plaine"},{"colonne":17,"ligne":22,"type":"montagne"},{"colonne":18,"ligne":22,"type":"plaine"},{"colonne":19,"ligne":22,"type":"foret"},{"colonne":20,"ligne":22,"type":"plaine"},{"colonne":21,"ligne":22,"type":"plaine"},{"colonne":22,"ligne":22,"type":"foret"},{"colonne":23,"ligne":22,"type":"plaine"},{"colonne":24,"ligne":22,"type":"montagne"},{"colonne":25,"ligne":22,"type":"montagne"},{"colonne":26,"ligne":22,"type":"montagne"},{"colonne":27,"ligne":22,"type":"montagne"},{"colonne":28,"ligne":22,"type":"plaine"},{"colonne":29,"ligne":22,"type":"plaine"},{"colonne":30,"ligne":22,"type":"plaine"},{"colonne":31,"ligne":22,"type":"plaine"},{"colonne":32,"ligne":22,"type":"eau"},{"colonne":33,"ligne":22,"type":"eau"},{"colonne":34,"ligne":22,"type":"eau"},{"colonne":35,"ligne":22,"type":"eau"},{"colonne":36,"ligne":22,"type":"eau"},{"colonne":37,"ligne":22,"type":"eau"},{"colonne":38,"ligne":22,"type":"eau"},{"colonne":39,"ligne":22,"type":"eau"},{"colonne":0,"ligne":23,"type":"eau"},{"colonne":1,"ligne":23,"type":"eau"},{"colonne":2,"ligne":23,"type":"eau"},{"colonne":3,"ligne":23,"type":"eau"},{"colonne":4,"ligne":23,"type":"eau"},{"colonne":5,"ligne":23,"type":"eau"},{"colonne":6,"ligne":23,"type":"eau"},{"colonne":7,"ligne":23,"type":"eau"},{"colonne":8,"ligne":23,"type":"eau"},{"colonne":9,"ligne":23,"type":"eau"},{"colonne":10,"ligne":23,"type":"eau"},{"colonne":11,"ligne":23,"type":"eau"},{"colonne":12,"ligne":23,"type":"plaine"},{"colonne":13,"ligne":23,"type":"plaine"},{"colonne":14,"ligne":23,"type":"plaine"},{"colonne":15,"ligne":23,"type":"plaine"},{"colonne":16,"ligne":23,"type":"plaine"},{"colonne":17,"ligne":23,"type":"plaine"},{"colonne":18,"ligne":23,"type":"plaine"},{"colonne":19,"ligne":23,"type":"plaine"},{"colonne":20,"ligne":23,"type":"plaine"},{"colonne":21,"ligne":23,"type":"plaine"},{"colonne":22,"ligne":23,"type":"plaine"},{"colonne":23,"ligne":23,"type":"plaine"},{"colonne":24,"ligne":23,"type":"montagne"},{"colonne":25,"ligne":23,"type":"montagne"},{"colonne":26,"ligne":23,"type":"montagne"},{"colonne":27,"ligne":23,"type":"montagne"},{"colonne":28,"ligne":23,"type":"montagne"},{"colonne":29,"ligne":23,"type":"plaine"},{"colonne":30,"ligne":23,"type":"plaine"},{"colonne":31,"ligne":23,"type":"ponton"},{"colonne":32,"ligne":23,"type":"eau"},{"colonne":33,"ligne":23,"type":"eau"},{"colonne":34,"ligne":23,"type":"eau"},{"colonne":35,"ligne":23,"type":"eau"},{"colonne":36,"ligne":23,"type":"eau"},{"colonne":37,"ligne":23,"type":"eau"},{"colonne":38,"ligne":23,"type":"eau"},{"colonne":39,"ligne":23,"type":"eau"},{"colonne":0,"ligne":24,"type":"eau"},{"colonne":1,"ligne":24,"type":"eau"},{"colonne":2,"ligne":24,"type":"eau"},{"colonne":3,"ligne":24,"type":"eau"},{"colonne":4,"ligne":24,"type":"eau"},{"colonne":5,"ligne":24,"type":"eau"},{"colonne":6,"ligne":24,"type":"eau"},{"colonne":7,"ligne":24,"type":"eau"},{"colonne":8,"ligne":24,"type":"eau"},{"colonne":9,"ligne":24,"type":"eau"},{"colonne":10,"ligne":24,"type":"eau"},{"colonne":11,"ligne":24,"type":"eau"},{"colonne":12,"ligne":24,"type":"eau"},{"colonne":13,"ligne":24,"type":"eau"},{"colonne":14,"ligne":24,"type":"eau"},{"colonne":15,"ligne":24,"type":"eau"},{"colonne":16,"ligne":24,"type":"plaine"},{"colonne":17,"ligne":24,"type":"eau"},{"colonne":18,"ligne":24,"type":"eau"},{"colonne":19,"ligne":24,"type":"plaine"},{"colonne":20,"ligne":24,"type":"plaine"},{"colonne":21,"ligne":24,"type":"eau"},{"colonne":22,"ligne":24,"type":"eau"},{"colonne":23,"ligne":24,"type":"eau"},{"colonne":24,"ligne":24,"type":"eau"},{"colonne":25,"ligne":24,"type":"eau"},{"colonne":26,"ligne":24,"type":"plaine"},{"colonne":27,"ligne":24,"type":"plaine"},{"colonne":28,"ligne":24,"type":"plaine"},{"colonne":29,"ligne":24,"type":"plaine"},{"colonne":30,"ligne":24,"type":"eau"},{"colonne":31,"ligne":24,"type":"eau"},{"colonne":32,"ligne":24,"type":"eau"},{"colonne":33,"ligne":24,"type":"eau"},{"colonne":34,"ligne":24,"type":"eau"},{"colonne":35,"ligne":24,"type":"eau"},{"colonne":36,"ligne":24,"type":"eau"},{"colonne":37,"ligne":24,"type":"eau"},{"colonne":38,"ligne":24,"type":"eau"},{"colonne":39,"ligne":24,"type":"eau"},{"colonne":0,"ligne":25,"type":"eau"},{"colonne":1,"ligne":25,"type":"eau"},{"colonne":2,"ligne":25,"type":"eau"},{"colonne":3,"ligne":25,"type":"eau"},{"colonne":4,"ligne":25,"type":"eau"},{"colonne":5,"ligne":25,"type":"eau"},{"colonne":6,"ligne":25,"type":"eau"},{"colonne":7,"ligne":25,"type":"eau"},{"colonne":8,"ligne":25,"type":"eau"},{"colonne":9,"ligne":25,"type":"eau"},{"colonne":10,"ligne":25,"type":"eau"},{"colonne":11,"ligne":25,"type":"eau"},{"colonne":12,"ligne":25,"type":"eau"},{"colonne":13,"ligne":25,"type":"eau"},{"colonne":14,"ligne":25,"type":"eau"},{"colonne":15,"ligne":25,"type":"eau"},{"colonne":16,"ligne":25,"type":"eau"},{"colonne":17,"ligne":25,"type":"eau"},{"colonne":18,"ligne":25,"type":"eau"},{"colonne":19,"ligne":25,"type":"eau"},{"colonne":20,"ligne":25,"type":"eau"},{"colonne":21,"ligne":25,"type":"eau"},{"colonne":22,"ligne":25,"type":"eau"},{"colonne":23,"ligne":25,"type":"eau"},{"colonne":24,"ligne":25,"type":"eau"},{"colonne":25,"ligne":25,"type":"eau"},{"colonne":26,"ligne":25,"type":"eau"},{"colonne":27,"ligne":25,"type":"eau"},{"colonne":28,"ligne":25,"type":"eau"},{"colonne":29,"ligne":25,"type":"eau"},{"colonne":30,"ligne":25,"type":"eau"},{"colonne":31,"ligne":25,"type":"eau"},{"colonne":32,"ligne":25,"type":"eau"},{"colonne":33,"ligne":25,"type":"eau"},{"colonne":34,"ligne":25,"type":"eau"},{"colonne":35,"ligne":25,"type":"eau"},{"colonne":36,"ligne":25,"type":"eau"},{"colonne":37,"ligne":25,"type":"eau"},{"colonne":38,"ligne":25,"type":"eau"},{"colonne":39,"ligne":25,"type":"eau"},{"colonne":0,"ligne":26,"type":"eau"},{"colonne":1,"ligne":26,"type":"eau"},{"colonne":2,"ligne":26,"type":"eau"},{"colonne":3,"ligne":26,"type":"eau"},{"colonne":4,"ligne":26,"type":"eau"},{"colonne":5,"ligne":26,"type":"eau"},{"colonne":6,"ligne":26,"type":"eau"},{"colonne":7,"ligne":26,"type":"eau"},{"colonne":8,"ligne":26,"type":"eau"},{"colonne":9,"ligne":26,"type":"eau"},{"colonne":10,"ligne":26,"type":"eau"},{"colonne":11,"ligne":26,"type":"eau"},{"colonne":12,"ligne":26,"type":"eau"},{"colonne":13,"ligne":26,"type":"eau"},{"colonne":14,"ligne":26,"type":"eau"},{"colonne":15,"ligne":26,"type":"eau"},{"colonne":16,"ligne":26,"type":"eau"},{"colonne":17,"ligne":26,"type":"eau"},{"colonne":18,"ligne":26,"type":"eau"},{"colonne":19,"ligne":26,"type":"eau"},{"colonne":20,"ligne":26,"type":"eau"},{"colonne":21,"ligne":26,"type":"eau"},{"colonne":22,"ligne":26,"type":"eau"},{"colonne":23,"ligne":26,"type":"eau"},{"colonne":24,"ligne":26,"type":"eau"},{"colonne":25,"ligne":26,"type":"eau"},{"colonne":26,"ligne":26,"type":"eau"},{"colonne":27,"ligne":26,"type":"eau"},{"colonne":28,"ligne":26,"type":"eau"},{"colonne":29,"ligne":26,"type":"eau"},{"colonne":30,"ligne":26,"type":"eau"},{"colonne":31,"ligne":26,"type":"eau"},{"colonne":32,"ligne":26,"type":"eau"},{"colonne":33,"ligne":26,"type":"eau"},{"colonne":34,"ligne":26,"type":"eau"},{"colonne":35,"ligne":26,"type":"eau"},{"colonne":36,"ligne":26,"type":"eau"},{"colonne":37,"ligne":26,"type":"eau"},{"colonne":38,"ligne":26,"type":"eau"},{"colonne":39,"ligne":26,"type":"eau"}];

        const indexCases = new Map();
        donneesCases.forEach(function (caseMonde) {
            indexCases.set(caseMonde.colonne + '_' + caseMonde.ligne, caseMonde.type);
        });

        const etatCarte = {
            largeurMonde: largeurMondeDataset,
            hauteurMonde: hauteurMondeDataset,
            colonne: Number(zoneCarte.dataset.colonneDepart || 18),
            ligne: Number(zoneCarte.dataset.ligneDepart || 12),
            cameraX: 0,
            cameraY: 0,
            colonneMax: Math.max(0, nombreColonnes - 1),
            ligneMax: Math.max(0, nombreLignes - 1),
            modeMontureActif: false,
            bateauDisponible: false,
            surbrillanceActive: false,
            casesAtteignables: []
        };

        const clePositionJoueur = 'elementia_position_joueur_v1';
        const cleDestinationActive = 'elementia_destination_active_v1';
        const cleQueteSuivie = 'elementia_quete_suivie_v1';
        const iconeDirectionJoueur = document.getElementById('icone-direction-joueur');
        const texteDirectionJoueur = document.getElementById('texte-direction-joueur');
        const configurationVilleElement = document.getElementById('configuration-villes-jeu');
        let configurationVilles = { villes: {}, points_monde: [], points_interieur: [] };
        const cleModeVille = 'elementia_mode_ville_debug_v1';
        const etatVille = {
            ouverte: false,
            code: null,
            caseDeclenchee: null,
            caseFermee: null,
            mode: 'jour'
        };

        const etatLieuVille = {
            ouvert: false,
            identifiant: null,
            sceneCourante: null,
            historiqueScenes: []
        };

        const donneesPanneauxLieuVille = {
            guilde_aventuriers: {
                apercu: {
                    type: 'resume',
                    titre: 'Guilde des aventuriers',
                    description: 'Choisissez un point de la salle pour afficher le bon panneau : missions, rumeurs, informations de progression ou revente des trophées.',
                    cartes: [
                        { titre: 'Missions', texte: 'Quêtes solo, groupe, urgence et monde avec limites déjà rappelées dans l’interface.' },
                        { titre: 'Rumeurs', texte: 'Petits articles courts pour préparer le joueur avant une quête ou un danger.' },
                        { titre: 'Informations', texte: 'Grades F à S, réputation, règles et fonctionnement de la guilde.' },
                        { titre: 'Revente', texte: 'Liste d’objets de trophées avec estimation et bouton placeholder de vente.' }
                    ]
                },
                tableau_missions: {
                    type: 'missions',
                    titre: 'Tableau des missions',
                    description: 'Placeholder structuré prêt à recevoir les vraies quêtes de la base plus tard.',
                    missions: [
                        { titre: 'Patrouille sur la route de Verdalis', type: 'Solo', rang: 'F', lieu: 'Route sud de Versalis', pnj: 'Caporal Néris', recompense: '24 cristaux + 1 réputation', resume: 'Sécuriser un tronçon fréquenté par des voleurs débutants.' },
                        { titre: 'Nettoyage des caves humides', type: 'Groupe', rang: 'E', lieu: 'Sous-sols de l’auberge', pnj: 'Maître de guilde Arven', recompense: '38 cristaux + trophée de meute', resume: 'Éliminer plusieurs nuisibles dans une zone fermée.' },
                        { titre: 'Alerte blessés à la porte est', type: 'Urgence', rang: 'D', lieu: 'Remparts de Versalis', pnj: 'Garde Lorian', recompense: '46 cristaux + 2 réputation', resume: 'Intervention rapide avant la fin du délai annoncé.' },
                        { titre: 'Échos de l’ancien sanctuaire', type: 'Monde', rang: 'C', lieu: 'Temple oublié', pnj: 'Archiviste Selya', recompense: '72 cristaux + accès de suivi', resume: 'Quête globale liée aux rumeurs actives du monde.' }
                    ],
                    pied: 'Limites affichées : 2 quêtes personnelles, 1 quête de groupe, 1 quête d’urgence.'
                },
                maitre_guilde: {
                    type: 'dialogue',
                    titre: 'Maître de guilde',
                    description: 'Discussion placeholder avec les thèmes principaux demandés.',
                    dialogues: [
                        { titre: 'Inscription aventurier', texte: 'Ouverture future du formulaire d’inscription et validation du statut d’aventurier.' },
                        { titre: 'Questionnaire', texte: 'Questions sur votre style de combat, votre élément et votre préparation.' },
                        { titre: 'Validation', texte: 'Le maître de guilde vérifiera plus tard rang, prérequis et accès aux missions.' }
                    ]
                },
                tableau_rumeurs_guilde: {
                    type: 'rumeurs',
                    titre: 'Tableau des rumeurs',
                    description: 'Petits articles immersifs affichés comme demandé.',
                    rumeurs: [
                        { titre: 'Brume au nord', texte: 'Des silhouettes ont été vues près de la vieille route au lever du jour.' },
                        { titre: 'Chasseur disparu', texte: 'Un pisteur serait entré dans la forêt oubliée sans jamais revenir.' },
                        { titre: 'Voix sous les pierres', texte: 'Des aventuriers jurent avoir entendu chanter sous un ancien escalier scellé.' }
                    ]
                },
                informations_guilde: {
                    type: 'informations',
                    titre: 'Informations de la guilde',
                    description: 'Récapitulatif propre du fonctionnement aventurier.',
                    informations: [
                        { libelle: 'Grades', valeur: 'F → E → D → C → B → A → S' },
                        { libelle: 'Progression', valeur: 'Monstres vaincus, quêtes terminées et réputation générale.' },
                        { libelle: 'Quêtes solo', valeur: 'Accessibles selon votre rang actuel.' },
                        { libelle: 'Quêtes de groupe', valeur: '+1 rang maximum autorisé par rapport au vôtre.' },
                        { libelle: 'Quêtes urgence', valeur: 'Disponibles pendant une durée limitée seulement.' },
                        { libelle: 'Quêtes monde', valeur: 'Événements globaux touchant plusieurs joueurs et plusieurs lieux.' }
                    ]
                },
                revente_trophees: {
                    type: 'vente',
                    titre: 'Revente des trophées',
                    description: 'Placeholder de vente avec objets, estimation et gains en cristaux.',
                    cristal: 'Total estimé : 67 cristaux',
                    stock: [
                        { nom: 'Crocs de loup gris', quantite: 4, prix: 16, progression: 68 },
                        { nom: 'Œil de limon trouble', quantite: 2, prix: 14, progression: 54 },
                        { nom: 'Écusson fendu de brigand', quantite: 1, prix: 37, progression: 92 }
                    ]
                }
            },
            guilde_commerce: {
                apercu: {
                    type: 'resume',
                    titre: 'Guilde du commerce',
                    description: 'Les trois boutons principaux sont déjà branchés : rumeurs commerciales, bourse et maître marchand.',
                    cartes: [
                        { titre: 'Rumeurs', texte: 'Convois, pénuries et besoins urgents par zone.' },
                        { titre: 'Bourse', texte: 'Prix par ville, tendance et variation simplifiée.' },
                        { titre: 'Maître marchand', texte: 'Discussion placeholder d’inscription et progression commerciale.' }
                    ]
                },
                tableau_rumeurs_commerce: {
                    type: 'rumeurs',
                    titre: 'Rumeurs commerciales',
                    description: 'Articles placeholder orientés économie et trajets commerciaux.',
                    rumeurs: [
                        { titre: 'Convoi retardé', texte: 'Le convoi de bois n’est toujours pas arrivé à Versalis ce matin.' },
                        { titre: 'Hausse du sel', texte: 'Les réserves côtières baissent et les prix remontent dans l’intérieur.' },
                        { titre: 'Demande d’herbes', texte: 'Les apothicaires paient mieux les plantes fraîches cette semaine.' }
                    ]
                },
                bourse_villes: {
                    type: 'bourse',
                    titre: 'Bourse des villes',
                    description: 'Vue lisible des variations de prix, prête à être reliée à la vraie économie.',
                    stock: [
                        { nom: 'Bois brut · Versalis', quantite: '12/u', prix: '+8%', progression: 58 },
                        { nom: 'Herbes communes · Verdalis', quantite: '9/u', prix: '-3%', progression: 34 },
                        { nom: 'Sel marin · Port marchand', quantite: '17/u', prix: '+12%', progression: 76 },
                        { nom: 'Minerai rouge · Pyros', quantite: '21/u', prix: '+5%', progression: 49 }
                    ]
                },
                maitre_commerce: {
                    type: 'dialogue',
                    titre: 'Maître marchand',
                    description: 'PNJ placeholder pour l’inscription commerciale et les conseils de marché.',
                    dialogues: [
                        { titre: 'Inscription', texte: 'La guilde vérifiera plus tard votre profil avant de vous accepter.' },
                        { titre: 'Licence', texte: 'Certaines opérations demanderont un rang commercial minimal.' },
                        { titre: 'Conseils', texte: 'Le maître marchand vous orientera vers les meilleures routes et villes.' }
                    ]
                }
            },
            marche: {
                apercu: {
                    type: 'resume',
                    titre: 'Marché',
                    description: 'Le marché est déjà découpé en accueil, étal de vente et annonces. Chaque bouton a maintenant son vrai panneau placeholder.',
                    cartes: [
                        { titre: 'Marchand', texte: 'Discussion locale et informations rapides.' },
                        { titre: 'Étal de vente', texte: 'Interface joueur pour vendre et consulter ses articles.' },
                        { titre: 'Annonces', texte: 'Petits articles de ville, prix et besoins urgents.' }
                    ]
                },
                pnj_marche: {
                    type: 'dialogue',
                    titre: 'Marchand du marché',
                    description: 'Discussion courte avec le marchand principal du marché.',
                    dialogues: [
                        { titre: 'Accueil', texte: 'Le marchand vous salue et vous présente les tendances locales.' },
                        { titre: 'Prix du jour', texte: 'Les denrées simples tournent vite, les trophées moins.' },
                        { titre: 'Conseil', texte: 'Les annonces changent vite, revenez souvent vérifier le panneau.' }
                    ]
                },
                etal_vente: {
                    type: 'vente',
                    titre: 'Étal de vente',
                    description: 'Interface placeholder de vente joueur au marché.',
                    cristal: 'Total potentiel : 53 cristaux',
                    stock: [
                        { nom: 'Pommes sauvages', quantite: 6, prix: 12, progression: 44 },
                        { nom: 'Peau de renard', quantite: 2, prix: 18, progression: 62 },
                        { nom: 'Vieille dague', quantite: 1, prix: 23, progression: 81 }
                    ]
                },
                annonces_marche: {
                    type: 'rumeurs',
                    titre: 'Annonces du marché',
                    description: 'Panneau public de la ville avec besoins et infos locales.',
                    rumeurs: [
                        { titre: 'Recherche de farine', texte: 'Une cuisinière paie bien pour une livraison avant la tombée du soir.' },
                        { titre: 'Prix des peaux', texte: 'Les fourrures se vendent mieux depuis le retour du froid.' },
                        { titre: 'Place libre', texte: 'Un étal sera disponible demain pour un vendeur occasionnel.' }
                    ]
                },
                vendeur_etal: {
                    type: 'dialogue',
                    titre: 'Vendeur de l’étal',
                    description: 'Discussion placeholder liée à l’étal de vente.',
                    dialogues: [
                        { titre: 'Stock', texte: 'Le vendeur peut vous indiquer ce qui se vend vite aujourd’hui.' },
                        { titre: 'Marge', texte: 'Les petits objets partent vite mais rapportent moins.' }
                    ]
                },
                acheter_etal: {
                    type: 'vente',
                    titre: 'Acheter / vendre à l’étal',
                    description: 'Vue simplifiée prête pour la future vraie logique d’achat et vente.',
                    cristal: 'Panier estimé : 31 cristaux',
                    stock: [
                        { nom: 'Pain du jour', quantite: 3, prix: 6, progression: 20 },
                        { nom: 'Bandage simple', quantite: 2, prix: 9, progression: 35 },
                        { nom: 'Lanterne usée', quantite: 1, prix: 16, progression: 57 }
                    ]
                },
                responsable_annonces: {
                    type: 'dialogue',
                    titre: 'Responsable des annonces',
                    description: 'Discussion placeholder du panneau des annonces.',
                    dialogues: [
                        { titre: 'Tri des affiches', texte: 'Les annonces urgentes restent en haut, les autres tournent chaque jour.' },
                        { titre: 'Règlement', texte: 'Les affiches frauduleuses seront retirées par la ville.' }
                    ]
                },
                lire_annonces: {
                    type: 'rumeurs',
                    titre: 'Lecture des annonces',
                    description: 'Lecture directe du panneau des annonces publiques.',
                    rumeurs: [
                        { titre: 'Achat de bois sec', texte: 'Le restaurant cherche du bois sec pour ses fours.' },
                        { titre: 'Main-d’œuvre', texte: 'Un artisan cherche une aide ponctuelle pour transporter des caisses.' },
                        { titre: 'Récolte urgente', texte: 'Les herbes fraîches sont reprises au-dessus du prix habituel.' }
                    ]
                }
            }
        };

        function decoderEntitesHtml(texte) {
            if (!texte) {
                return '';
            }

            const zoneTemporaire = document.createElement('textarea');
            zoneTemporaire.innerHTML = texte;
            return zoneTemporaire.value;
        }

        function lireConfigurationVilles() {
            if (!configurationVilleElement) {
                return configurationVilles;
            }

            const contenuBrut = String(configurationVilleElement.textContent || '').trim();
            if (!contenuBrut) {
                return configurationVilles;
            }

            try {
                return JSON.parse(contenuBrut) || configurationVilles;
            } catch (erreurBrute) {
                try {
                    const contenuDecode = decoderEntitesHtml(contenuBrut).trim();
                    return JSON.parse(contenuDecode) || configurationVilles;
                } catch (erreurDecodee) {
                    console.warn('[Elementia] Configuration des villes invalide.', erreurDecodee);
                    return configurationVilles;
                }
            }
        }

        configurationVilles = lireConfigurationVilles();

        function lireStockageJson(cle) {
            try {
                const brut = window.localStorage.getItem(cle);
                return brut ? JSON.parse(brut) : null;
            } catch (erreur) {
                return null;
            }
        }

        function ecrireStockageJson(cle, donnees) {
            if (donnees === null || typeof donnees === 'undefined') {
                window.localStorage.removeItem(cle);
                return;
            }

            window.localStorage.setItem(cle, JSON.stringify(donnees));
        }

        function chargerPositionPersistante() {
            const position = lireStockageJson(clePositionJoueur);
            if (!position) {
                return;
            }

            etatCarte.colonne = borner(Number(position.x || etatCarte.colonne), 0, etatCarte.colonneMax);
            etatCarte.ligne = borner(Number(position.y || etatCarte.ligne), 0, etatCarte.ligneMax);
        }

        function sauvegarderPositionJoueur() {
            const position = {
                x: etatCarte.colonne,
                y: etatCarte.ligne
            };

            ecrireStockageJson(clePositionJoueur, position);
            window.dispatchEvent(new CustomEvent('elementia-position-joueur-changee', { detail: position }));
        }

        function lireDestinationActive() {
            const destinationPersonnalisee = lireStockageJson(cleDestinationActive);
            if (destinationPersonnalisee && Number.isFinite(Number(destinationPersonnalisee.x)) && Number.isFinite(Number(destinationPersonnalisee.y))) {
                return destinationPersonnalisee;
            }

            const queteSuivie = lireStockageJson(cleQueteSuivie);
            if (queteSuivie && Number.isFinite(Number(queteSuivie.x)) && Number.isFinite(Number(queteSuivie.y))) {
                return queteSuivie;
            }

            return null;
        }

        function calculerDirectionTexte(destination) {
            if (!destination) {
                return {
                    icone: '•',
                    texte: 'Aucune destination suivie'
                };
            }

            const deltaX = Number(destination.x) - etatCarte.colonne;
            const deltaY = Number(destination.y) - etatCarte.ligne;

            if (deltaX === 0 && deltaY === 0) {
                return {
                    icone: '✓',
                    texte: 'Destination atteinte : ' + (destination.nom || destination.titre || 'repère')
                };
            }

            let directionVerticale = '';
            let directionHorizontale = '';
            let iconeVerticale = '';
            let iconeHorizontale = '';

            if (deltaY < 0) {
                directionVerticale = 'nord';
                iconeVerticale = '↑';
            } else if (deltaY > 0) {
                directionVerticale = 'sud';
                iconeVerticale = '↓';
            }

            if (deltaX < 0) {
                directionHorizontale = 'ouest';
                iconeHorizontale = '←';
            } else if (deltaX > 0) {
                directionHorizontale = 'est';
                iconeHorizontale = '→';
            }

            const morceaux = [directionVerticale, directionHorizontale].filter(Boolean);
            const direction = morceaux.join('-');
            const icone = (iconeVerticale || '') + (iconeHorizontale || '');

            return {
                icone: icone || '•',
                texte: (destination.nom || destination.titre || 'Destination') + ' · ' + direction + ' · ' + Math.abs(deltaX) + ' case(s) X / ' + Math.abs(deltaY) + ' case(s) Y'
            };
        }

        function mettreAJourDirectionActive() {
            const direction = calculerDirectionTexte(lireDestinationActive());

            if (iconeDirectionJoueur) {
                iconeDirectionJoueur.textContent = direction.icone;
            }

            if (texteDirectionJoueur) {
                texteDirectionJoueur.textContent = direction.texte;
            }
        }

        chargerPositionPersistante();

        function cleCase(colonne, ligne) {
            return colonne + '_' + ligne;
        }

        function borner(valeur, minimum, maximum) {
            return Math.max(minimum, Math.min(maximum, valeur));
        }

        function obtenirTypeCase(colonne, ligne) {
            return indexCases.get(cleCase(colonne, ligne)) || 'vide';
        }

        function obtenirPorteeMaximum() {
            return etatCarte.modeMontureActif ? 6 : 4;
        }

        function estCaseTraversable(typeCase, bateauDisponible) {
            if (typeCase === 'montagne' || typeCase === 'vide') {
                return false;
            }

            if (typeCase === 'eau') {
                return bateauDisponible;
            }

            return true;
        }

        function obtenirEtatBateauApresArrivee(typeCaseArrivee) {
            if (typeCaseArrivee === 'ponton') {
                return true;
            }

            if (typeCaseArrivee === 'eau') {
                return true;
            }

            return false;
        }

        function ajouterLogDebug(message) {
            if (!debugJournalDeplacement) {
                return;
            }

            const ligne = document.createElement('div');
            ligne.className = 'ligne-debug-journal';
            ligne.textContent = message;
            debugJournalDeplacement.prepend(ligne);
        }

        function viderLogsDebug() {
            if (debugJournalDeplacement) {
                debugJournalDeplacement.innerHTML = '';
            }
        }

        function mettreAJourCoordonneesAffichees() {
            const textePosition = 'Case ' + etatCarte.colonne + ' x ' + etatCarte.ligne;
            valeurPositionJoueur.textContent = textePosition;
            const valeurPositionCarteComplete = document.getElementById('valeur-position-carte-complete');
            if (valeurPositionCarteComplete) {
                valeurPositionCarteComplete.textContent = etatCarte.colonne + ' x ' + etatCarte.ligne;
            }

            if (debugEtatPosition) {
                debugEtatPosition.textContent = etatCarte.colonne + ' x ' + etatCarte.ligne;
            }
        }

        function mettreAJourInformationsEtat() {
            const texteMode = etatCarte.modeMontureActif ? 'Monture active · portée 6' : 'À pied · portée 4';
            const typeCaseActuelle = obtenirTypeCase(etatCarte.colonne, etatCarte.ligne);
            const texteNavigation = typeCaseActuelle === 'eau'
                ? 'En navigation · bateau actif'
                : (etatCarte.bateauDisponible ? 'Sur ponton · bateau disponible' : 'À terre · sans bateau');

            if (valeurPorteeJoueur) {
                valeurPorteeJoueur.textContent = texteMode;
            }

            if (valeurNavigationJoueur) {
                valeurNavigationJoueur.textContent = texteNavigation;
            }

            if (debugEtatMode) {
                debugEtatMode.textContent = etatCarte.modeMontureActif ? 'Monture active' : 'À pied';
            }

            if (debugEtatBateau) {
                debugEtatBateau.textContent = etatCarte.bateauDisponible ? 'Oui' : 'Non';
            }

            if (boutonDebugMonture) {
                boutonDebugMonture.textContent = etatCarte.modeMontureActif ? 'Désactiver la monture' : 'Activer la monture';
            }
        }


function obtenirGeometrieAffichee() {
    const largeurCaseAffichee = etatCarte.largeurMonde / nombreColonnes;
    const hauteurCaseAffichee = etatCarte.hauteurMonde / nombreLignes;

    return {
        largeurCaseAffichee: largeurCaseAffichee,
        hauteurCaseAffichee: hauteurCaseAffichee
    };
}


        function dessinerSurbrillancesLieux() {
            surbrillanceLieux.innerHTML = '';

            const geometrie = obtenirGeometrieAffichee();

            donneesCases.forEach(function (caseMonde) {
                if (caseMonde.type !== 'ville' && caseMonde.type !== 'ponton') {
                    return;
                }

                const element = document.createElement('div');
                const estVille = caseMonde.type === 'ville';

                element.className = 'case-lieu-monde';
                element.style.position = 'absolute';
                element.style.left = (caseMonde.colonne * geometrie.largeurCaseAffichee) + 'px';
                element.style.top = (caseMonde.ligne * geometrie.hauteurCaseAffichee) + 'px';
                element.style.width = geometrie.largeurCaseAffichee + 'px';
                element.style.height = geometrie.hauteurCaseAffichee + 'px';
                element.style.margin = '0';
                element.style.padding = '0';
                element.style.boxSizing = 'border-box';
                element.style.pointerEvents = 'none';
                element.style.border = estVille ? '1px solid rgba(120, 220, 140, 0.85)' : '1px solid rgba(120, 190, 255, 0.85)';
                element.style.background = estVille ? 'rgba(120, 220, 140, 0.14)' : 'rgba(120, 190, 255, 0.14)';
                element.style.boxShadow = estVille
                    ? 'inset 0 0 0 1px rgba(255,255,255,0.10)'
                    : 'inset 0 0 0 1px rgba(255,255,255,0.08)';

                surbrillanceLieux.appendChild(element);
            });
        }

        function determinerTypeRencontreDepuisJet(resultatJet) {
            if (resultatJet <= 49) {
                return null;
            }

            if (resultatJet <= 79) {
                return 'commun';
            }

            if (resultatJet <= 89) {
                return 'rare';
            }

            return 'elite';
        }

        function lancerJetRencontre(typeCaseActuelle) {
            if (typeCaseActuelle === 'ville' || typeCaseActuelle === 'ponton') {
                ajouterLogDebug('Aucun jet de rencontre sur cette case.');
                return;
            }

            const resultatJet = Math.floor(Math.random() * 101);
            const typeRencontre = determinerTypeRencontreDepuisJet(resultatJet);

            if (typeRencontre === null) {
                ligneEvenementPrincipale.textContent = 'Jet de rencontre : ' + resultatJet + '/100 · Aucun monstre.';
                ligneEvenementSecondaire.textContent = 'La zone reste calme pour le moment.';
                ajouterLogDebug('Jet de rencontre : ' + resultatJet + '/100 · Aucun monstre.');
                return;
            }

            if (typeRencontre === 'commun') {
                ligneEvenementPrincipale.textContent = 'Jet de rencontre : ' + resultatJet + '/100 · Monstre commun.';
                ligneEvenementSecondaire.textContent = 'Test génération : une rencontre de type commun doit se lancer.';
                ajouterLogDebug('Jet de rencontre : ' + resultatJet + '/100 · Monstre commun.');
                return;
            }

            if (typeRencontre === 'rare') {
                ligneEvenementPrincipale.textContent = 'Jet de rencontre : ' + resultatJet + '/100 · Monstre rare.';
                ligneEvenementSecondaire.textContent = 'Test génération : une rencontre de type rare doit se lancer.';
                ajouterLogDebug('Jet de rencontre : ' + resultatJet + '/100 · Monstre rare.');
                return;
            }

            ligneEvenementPrincipale.textContent = 'Jet de rencontre : ' + resultatJet + '/100 · Monstre élite.';
            ligneEvenementSecondaire.textContent = 'Test génération : une rencontre de type élite doit se lancer.';
            ajouterLogDebug('Jet de rencontre : ' + resultatJet + '/100 · Monstre élite.');
        }

        function mettreAJourEvenements(typeCaseActuelle) {
            if (!ligneEvenementPrincipale || !ligneEvenementSecondaire) {
                return;
            }

            if (typeCaseActuelle === 'ville') {
                ligneEvenementPrincipale.textContent = 'Vous êtes dans une ville. Aucun jet de rencontre ne se lance ici.';
                ligneEvenementSecondaire.textContent = 'Les villes servent de zones sûres et de points d’entrée vers les cartes locales.';
                return;
            }

            if (typeCaseActuelle === 'ponton') {
                ligneEvenementPrincipale.textContent = 'Vous êtes sur un ponton. Aucun jet de rencontre ne se lance ici.';
                ligneEvenementSecondaire.textContent = 'Le bateau est maintenant disponible pour rejoindre l’eau.';
                return;
            }

            if (typeCaseActuelle === 'eau') {
                ligneEvenementPrincipale.textContent = 'Vous naviguez actuellement sur l’eau.';
                ligneEvenementSecondaire.textContent = 'Revenir sur une case terrestre vous fera perdre le bateau.';
                return;
            }

            ligneEvenementPrincipale.textContent = 'Cliquez sur votre pion pour afficher les cases atteignables.';
            ligneEvenementSecondaire.textContent = 'Les rencontres aléatoires seront branchées dans une prochaine étape.';
        }

        function mettreAJourRepereJoueur() {
            const geometrie = obtenirGeometrieAffichee();
            const centreX = (etatCarte.colonne * geometrie.largeurCaseAffichee) + (geometrie.largeurCaseAffichee / 2);
            const centreY = (etatCarte.ligne * geometrie.hauteurCaseAffichee) + (geometrie.hauteurCaseAffichee / 2);
            repereJoueur.style.left = centreX + 'px';
            repereJoueur.style.top = centreY + 'px';
        }

        function mettreAJourCamera() {
            const largeurViewport = viewport.clientWidth;
            const hauteurViewport = viewport.clientHeight;
            if (largeurViewport <= 0 || hauteurViewport <= 0) {
                return;
            }

            const geometrie = obtenirGeometrieAffichee();
            const centreX = (etatCarte.colonne * geometrie.largeurCaseAffichee) + (geometrie.largeurCaseAffichee / 2);
            const centreY = (etatCarte.ligne * geometrie.hauteurCaseAffichee) + (geometrie.hauteurCaseAffichee / 2);

            const cameraXMax = Math.max(0, etatCarte.largeurMonde - largeurViewport);
            const cameraYMax = Math.max(0, etatCarte.hauteurMonde - hauteurViewport);

            etatCarte.cameraX = borner(centreX - (largeurViewport / 2), 0, cameraXMax);
            etatCarte.cameraY = borner(centreY - (hauteurViewport / 2), 0, cameraYMax);

            contenu.style.transform = 'translate3d(' + (-etatCarte.cameraX) + 'px, ' + (-etatCarte.cameraY) + 'px, 0)';
        }

        function dessinerCasesAtteignables() {
			surbrillance.innerHTML = '';

			const geometrie = obtenirGeometrieAffichee();

			etatCarte.casesAtteignables.forEach(function (caseAtteignable) {
				const element = document.createElement('div');

				element.className = 'case-atteignable-monde';
				element.dataset.colonne = String(caseAtteignable.colonne);
				element.dataset.ligne = String(caseAtteignable.ligne);

				element.style.position = 'absolute';
				element.style.left = (caseAtteignable.colonne * geometrie.largeurCaseAffichee) + 'px';
				element.style.top = (caseAtteignable.ligne * geometrie.hauteurCaseAffichee) + 'px';
				element.style.width = geometrie.largeurCaseAffichee + 'px';
				element.style.height = geometrie.hauteurCaseAffichee + 'px';
				element.style.margin = '0';
				element.style.padding = '0';
				element.style.minWidth = '0';
				element.style.minHeight = '0';
				element.style.boxSizing = 'border-box';
				element.style.display = 'block';
				element.style.pointerEvents = 'auto';

				surbrillance.appendChild(element);
			});
		}
		
        function masquerCasesAtteignables() {
            etatCarte.surbrillanceActive = false;
            etatCarte.casesAtteignables = [];
            surbrillance.innerHTML = '';
            surbrillance.classList.remove('visible');
        }

        function calculerCasesAtteignables() {
            const porteeMaximum = obtenirPorteeMaximum();
            const file = [{
                colonne: etatCarte.colonne,
                ligne: etatCarte.ligne,
                distance: 0,
                bateauDisponible: etatCarte.bateauDisponible
            }];
            const visites = new Map();
            const resultats = [];

            visites.set(cleCase(etatCarte.colonne, etatCarte.ligne) + '_bateau_' + (etatCarte.bateauDisponible ? '1' : '0'), true);

            while (file.length > 0) {
                const noeud = file.shift();

                if (noeud.distance > 0) {
                    resultats.push({
                        colonne: noeud.colonne,
                        ligne: noeud.ligne
                    });
                }

                if (noeud.distance >= porteeMaximum) {
                    continue;
                }

                const directions = [
                    { colonne: 1, ligne: 0 },
                    { colonne: -1, ligne: 0 },
                    { colonne: 0, ligne: 1 },
                    { colonne: 0, ligne: -1 }
                ];

                directions.forEach(function (direction) {
                    const prochaineColonne = noeud.colonne + direction.colonne;
                    const prochaineLigne = noeud.ligne + direction.ligne;

                    if (prochaineColonne < 0 || prochaineColonne > etatCarte.colonneMax || prochaineLigne < 0 || prochaineLigne > etatCarte.ligneMax) {
                        return;
                    }

                    const typeCaseSuivante = obtenirTypeCase(prochaineColonne, prochaineLigne);

                    if (!estCaseTraversable(typeCaseSuivante, noeud.bateauDisponible)) {
                        return;
                    }

                    const prochainEtatBateau = obtenirEtatBateauApresArrivee(typeCaseSuivante);
                    const cleVisite = cleCase(prochaineColonne, prochaineLigne) + '_bateau_' + (prochainEtatBateau ? '1' : '0');

                    if (visites.has(cleVisite)) {
                        return;
                    }

                    visites.set(cleVisite, true);
                    file.push({
                        colonne: prochaineColonne,
                        ligne: prochaineLigne,
                        distance: noeud.distance + 1,
                        bateauDisponible: prochainEtatBateau
                    });
                });
            }

            const resultatsUniques = new Map();
            resultats.forEach(function (caseResultat) {
                resultatsUniques.set(cleCase(caseResultat.colonne, caseResultat.ligne), caseResultat);
            });

            return Array.from(resultatsUniques.values());
        }

        function afficherCasesAtteignables() {
            etatCarte.casesAtteignables = calculerCasesAtteignables();
            etatCarte.surbrillanceActive = true;
            dessinerCasesAtteignables();
            surbrillance.classList.add('visible');
            ajouterLogDebug('Cases atteignables recalculées : ' + etatCarte.casesAtteignables.length + ' case(s).');
        }

        function alternerCasesAtteignables() {
            if (etatCarte.surbrillanceActive) {
                masquerCasesAtteignables();
            } else {
                afficherCasesAtteignables();
            }
        }

        function deplacerJoueurVers(colonne, ligne, source) {
            const caseCible = etatCarte.casesAtteignables.find(function (caseAtteignable) {
                return caseAtteignable.colonne === colonne && caseAtteignable.ligne === ligne;
            });

            if (!caseCible) {
                ajouterLogDebug('Déplacement refusé vers ' + colonne + ' x ' + ligne + ' : case hors portée ou chemin bloqué.');
                return;
            }

            etatCarte.colonne = borner(colonne, 0, etatCarte.colonneMax);
            etatCarte.ligne = borner(ligne, 0, etatCarte.ligneMax);

            const typeCaseActuelle = obtenirTypeCase(etatCarte.colonne, etatCarte.ligne);
            etatCarte.bateauDisponible = obtenirEtatBateauApresArrivee(typeCaseActuelle);

            mettreAJourRepereJoueur();
            mettreAJourCamera();
            mettreAJourCoordonneesAffichees();
            mettreAJourInformationsEtat();
            mettreAJourEvenements(typeCaseActuelle);
            mettreAJourDirectionActive();
            sauvegarderPositionJoueur();
            masquerCasesAtteignables();
            verifierOuvertureVilleAutomatique();

            ajouterLogDebug('Déplacement validé vers ' + etatCarte.colonne + ' x ' + etatCarte.ligne + ' depuis ' + source + '.');
            ajouterLogDebug('Type de case : ' + typeCaseActuelle + '.');
            lancerJetRencontre(typeCaseActuelle);
        }

        function deplacerJoueurAuClavier(directionColonne, directionLigne) {
            etatCarte.casesAtteignables = calculerCasesAtteignables();

            const caseCible = etatCarte.casesAtteignables.find(function (caseAtteignable) {
                return caseAtteignable.colonne === etatCarte.colonne + directionColonne && caseAtteignable.ligne === etatCarte.ligne + directionLigne;
            });

            if (!caseCible) {
                ajouterLogDebug('Déplacement clavier refusé : obstacle ou case non valide.');
                return;
            }

            deplacerJoueurVers(caseCible.colonne, caseCible.ligne, 'clavier');
        }


        function obtenirCleCaseActuelle() {
            return etatCarte.colonne + '_' + etatCarte.ligne;
        }

        function obtenirModeVilleActuel() {
            const mode = lireStockageJson(cleModeVille);
            if (mode === 'nuit') {
                return 'nuit';
            }
            return 'jour';
        }

        function obtenirConfigurationLieuVille(identifiantLieu) {
            const villes = configurationVilles && configurationVilles.villes ? configurationVilles.villes : {};
            const villeActive = etatVille.code && villes[etatVille.code] ? villes[etatVille.code] : null;
            const lieuxInterieurs = villeActive && villeActive.lieux_interieurs ? villeActive.lieux_interieurs : {};

            if (!identifiantLieu || !lieuxInterieurs[identifiantLieu]) {
                return null;
            }

            return lieuxInterieurs[identifiantLieu];
        }

        function obtenirSceneLieuVille(configurationLieu, identifiantScene) {
            const scenes = configurationLieu && configurationLieu.scenes ? configurationLieu.scenes : {};

            if (identifiantScene && scenes[identifiantScene]) {
                return scenes[identifiantScene];
            }

            return null;
        }

        function echapperTexteHtml(valeur) {
            return String(valeur || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function obtenirDonneesPanneauLieu(identifiantLieu, identifiantInteraction) {
            if (!identifiantLieu || !donneesPanneauxLieuVille[identifiantLieu]) {
                return null;
            }

            const donneesLieu = donneesPanneauxLieuVille[identifiantLieu];
            if (identifiantInteraction && donneesLieu[identifiantInteraction]) {
                return donneesLieu[identifiantInteraction];
            }

            return donneesLieu.apercu || null;
        }

        function construireHtmlPanneauLieu(donneesPanneau) {
            if (!donneesPanneau) {
                return '<div class="bloc-placeholder-lieu-ville"><strong>Interface du lieu</strong><p>Sélectionnez une interaction dans l’image pour afficher son contenu.</p></div>';
            }

            const titre = echapperTexteHtml(donneesPanneau.titre || 'Panneau');
            const description = echapperTexteHtml(donneesPanneau.description || '');
            let contenu = '<div class="bloc-panneau-lieu-ville"><div class="entete-panneau-lieu-ville"><h4>' + titre + '</h4><p>' + description + '</p></div>';

            if (donneesPanneau.type === 'missions' && Array.isArray(donneesPanneau.missions)) {
                contenu += '<div class="grille-cartes-lieu-ville">';
                donneesPanneau.missions.forEach(function (mission) {
                    contenu += '<article class="carte-liste-lieu-ville">'
                        + '<h5>' + echapperTexteHtml(mission.titre) + '</h5>'
                        + '<div class="ligne-meta-lieu-ville">'
                        + '<span class="etiquette-meta-lieu-ville">' + echapperTexteHtml(mission.type) + '</span>'
                        + '<span class="etiquette-meta-lieu-ville">Rang ' + echapperTexteHtml(mission.rang) + '</span>'
                        + '<span class="etiquette-meta-lieu-ville">' + echapperTexteHtml(mission.recompense) + '</span>'
                        + '</div>'
                        + '<p>' + echapperTexteHtml(mission.resume) + '</p>'
                        + '<p><strong>Lieu :</strong> ' + echapperTexteHtml(mission.lieu) + '</p>'
                        + '<p><strong>PNJ :</strong> ' + echapperTexteHtml(mission.pnj) + '</p>'
                        + '<div class="ligne-meta-lieu-ville">'
                        + '<span class="etiquette-meta-lieu-ville">Accepter</span>'
                        + '<span class="etiquette-meta-lieu-ville">Refuser</span>'
                        + '</div>'
                        + '</article>';
                });
                contenu += '</div>';
            } else if ((donneesPanneau.type === 'rumeurs' || donneesPanneau.type === 'resume') && Array.isArray(donneesPanneau.rumeurs || donneesPanneau.cartes)) {
                const elements = donneesPanneau.rumeurs || donneesPanneau.cartes;
                contenu += '<div class="grille-cartes-lieu-ville">';
                elements.forEach(function (element) {
                    contenu += '<article class="carte-liste-lieu-ville"><h5>' + echapperTexteHtml(element.titre) + '</h5><p>' + echapperTexteHtml(element.texte) + '</p></article>';
                });
                contenu += '</div>';
            } else if (donneesPanneau.type === 'informations' && Array.isArray(donneesPanneau.informations)) {
                contenu += '<div class="grille-infos-lieu-ville">';
                donneesPanneau.informations.forEach(function (information) {
                    contenu += '<div class="ligne-info-lieu-ville"><strong>' + echapperTexteHtml(information.libelle) + '</strong><span>' + echapperTexteHtml(information.valeur) + '</span></div>';
                });
                contenu += '</div>';
            } else if (donneesPanneau.type === 'vente' || donneesPanneau.type === 'bourse') {
                if (donneesPanneau.cristal) {
                    contenu += '<div class="ligne-info-lieu-ville"><strong>Estimation</strong><span>' + echapperTexteHtml(donneesPanneau.cristal) + '</span></div>';
                }
                if (Array.isArray(donneesPanneau.stock)) {
                    contenu += '<div class="grille-stock-lieu-ville">';
                    donneesPanneau.stock.forEach(function (ligne) {
                        const progression = Math.max(0, Math.min(100, Number(ligne.progression || 0)));
                        contenu += '<div class="ligne-stock-lieu-ville">'
                            + '<div class="entete-stock-lieu-ville"><strong>' + echapperTexteHtml(ligne.nom) + '</strong><span class="etiquette-stock-lieu-ville">Qté / valeur : ' + echapperTexteHtml(ligne.quantite) + ' · ' + echapperTexteHtml(ligne.prix) + '</span></div>'
                            + '<div class="barre-progression-lieu-ville"><span style="width:' + progression + '%;"></span></div>'
                            + '</div>';
                    });
                    contenu += '</div>';
                }
            } else if (donneesPanneau.type === 'dialogue' && Array.isArray(donneesPanneau.dialogues)) {
                contenu += '<div class="liste-dialogues-lieu-ville">';
                donneesPanneau.dialogues.forEach(function (dialogue) {
                    contenu += '<div class="ligne-dialogue-lieu-ville"><strong>' + echapperTexteHtml(dialogue.titre) + '</strong><p>' + echapperTexteHtml(dialogue.texte) + '</p></div>';
                });
                contenu += '</div>';
            }

            if (donneesPanneau.pied) {
                contenu += '<p class="pied-panneau-lieu-ville">' + echapperTexteHtml(donneesPanneau.pied) + '</p>';
            }

            contenu += '</div>';
            return contenu;
        }

        function afficherPanneauLieuVille(identifiantLieu, identifiantInteraction) {
            if (!contenuLieuVille) {
                return;
            }

            const donneesPanneau = obtenirDonneesPanneauLieu(identifiantLieu, identifiantInteraction);
            contenuLieuVille.innerHTML = construireHtmlPanneauLieu(donneesPanneau);
            contenuLieuVille.scrollTop = 0;
        }

        function rafraichirTexteInteractionLieu(titreInteraction, texteInteraction) {
            if (titreInteractionLieuVille) {
                titreInteractionLieuVille.textContent = titreInteraction || 'Interaction';
            }

            if (etatInteractionLieuVille) {
                etatInteractionLieuVille.textContent = texteInteraction || 'Cliquez sur une icône du lieu pour lancer une discussion ou une action.';
            }
        }

        function mettreAJourBoutonsNavigationLieuVille() {
            if (boutonRetourScene) {
                boutonRetourScene.style.display = etatLieuVille.historiqueScenes && etatLieuVille.historiqueScenes.length > 0 ? 'inline-flex' : 'none';
                boutonRetourScene.textContent = 'Retour à l’accueil';
            }

            if (boutonRetourVille) {
                boutonRetourVille.style.display = 'inline-flex';
            }
        }

        function fermerFenetreLieuVille() {
            if (!fenetreLieuVille) {
                return;
            }

            fenetreLieuVille.classList.add('fenetre-lieu-ville-cachee');
            etatLieuVille.ouvert = false;
            etatLieuVille.identifiant = null;
            etatLieuVille.sceneCourante = null;
            etatLieuVille.historiqueScenes = [];

            if (calqueInteractionsLieuVille) {
                calqueInteractionsLieuVille.innerHTML = '';
            }

            rafraichirTexteInteractionLieu('Interaction', 'Cliquez sur une icône du lieu pour lancer une discussion ou une action.');
            afficherPanneauLieuVille(null, null);
            mettreAJourBoutonsNavigationLieuVille();
        }

        function construireInteractionsLieuVille(configurationScene) {
            if (!calqueInteractionsLieuVille) {
                return;
            }

            calqueInteractionsLieuVille.innerHTML = '';

            const interactions = configurationScene && Array.isArray(configurationScene.interactions)
                ? configurationScene.interactions
                : [];

            interactions.forEach(function (interactionLieu) {
                const positionX = Number(interactionLieu.x);
                const positionY = Number(interactionLieu.y);

                if (!Number.isFinite(positionX) || !Number.isFinite(positionY)) {
                    return;
                }

                const boutonInteraction = document.createElement('button');
                boutonInteraction.type = 'button';
                boutonInteraction.className = 'point-interaction-lieu point-interaction-lieu-' + (interactionLieu.type || 'action');
                boutonInteraction.style.left = positionX + '%';
                boutonInteraction.style.top = positionY + '%';
                boutonInteraction.setAttribute('aria-label', interactionLieu.nom || 'Interaction');
                boutonInteraction.title = interactionLieu.nom || 'Interaction';

                const iconeInteraction = document.createElement('span');
                iconeInteraction.className = 'point-interaction-lieu-icone';
                iconeInteraction.textContent = interactionLieu.icone || '•';

                const etiquetteInteraction = document.createElement('span');
                etiquetteInteraction.className = 'point-interaction-lieu-etiquette';
                etiquetteInteraction.textContent = interactionLieu.nom || 'Interaction';

                boutonInteraction.appendChild(iconeInteraction);
                boutonInteraction.appendChild(etiquetteInteraction);
                boutonInteraction.addEventListener('click', function (evenement) {
                    evenement.preventDefault();
                    evenement.stopPropagation();
                    gererInteractionLieuVille(interactionLieu);
                });

                calqueInteractionsLieuVille.appendChild(boutonInteraction);
            });
        }

        function afficherSceneLieuVille(configurationLieu, identifiantScene, ajouterHistorique) {
            if (!configurationLieu || !titreLieuVille || !texteLieuVille) {
                return;
            }

            const sceneDemandee = obtenirSceneLieuVille(configurationLieu, identifiantScene);
            const configurationAffichee = sceneDemandee || configurationLieu;
            const scenePrecedente = etatLieuVille.sceneCourante;

            if (sceneDemandee) {
                if (ajouterHistorique && scenePrecedente && scenePrecedente !== identifiantScene) {
                    etatLieuVille.historiqueScenes.push(scenePrecedente);
                }
                etatLieuVille.sceneCourante = identifiantScene;
            } else {
                etatLieuVille.sceneCourante = null;
            }

            titreLieuVille.textContent = configurationAffichee && configurationAffichee.titre
                ? configurationAffichee.titre
                : 'Lieu';

            if (sousTitreLieuVille) {
                sousTitreLieuVille.textContent = configurationAffichee && configurationAffichee.sous_titre
                    ? configurationAffichee.sous_titre
                    : 'Explorez le lieu et choisissez une interaction.';
            }

            texteLieuVille.textContent = configurationAffichee && configurationAffichee.description
                ? configurationAffichee.description
                : 'Ce lieu sera détaillé plus tard.';

            if (imageLieuVille) {
                imageLieuVille.src = configurationAffichee && configurationAffichee.fond ? configurationAffichee.fond : 'ressources/images/fonds_dialogue/fond_vide.png';
                imageLieuVille.alt = configurationAffichee && configurationAffichee.titre ? ('Décor de ' + configurationAffichee.titre) : 'Décor du lieu';
            }

            construireInteractionsLieuVille(configurationAffichee);
            afficherPanneauLieuVille(etatLieuVille.identifiant, null);

            if (configurationAffichee && configurationAffichee.texte_interaction_initial) {
                rafraichirTexteInteractionLieu(
                    configurationAffichee.titre || 'Discussion',
                    configurationAffichee.texte_interaction_initial
                );
            } else {
                rafraichirTexteInteractionLieu('Interaction', 'Cliquez sur une icône du lieu pour lancer une discussion ou une action.');
            }

            mettreAJourBoutonsNavigationLieuVille();
        }

        function revenirScenePrecedenteLieuVille() {
            const configurationLieu = obtenirConfigurationLieuVille(etatLieuVille.identifiant);

            if (!configurationLieu) {
                fermerFenetreLieuVille();
                return;
            }

            if (etatLieuVille.historiqueScenes.length > 0) {
                const scenePrecedente = etatLieuVille.historiqueScenes.pop();
                afficherSceneLieuVille(configurationLieu, scenePrecedente, false);
                return;
            }

            if (configurationLieu.scene_initiale) {
                afficherSceneLieuVille(configurationLieu, configurationLieu.scene_initiale, false);
                return;
            }

            fermerFenetreLieuVille();
        }

        function gererInteractionLieuVille(interactionLieu) {
            if (!interactionLieu) {
                return;
            }

            const typeInteraction = interactionLieu.type || 'action';

            if (typeInteraction === 'retour') {
                fermerFenetreLieuVille();
                return;
            }

            if (typeInteraction === 'retour_scene') {
                revenirScenePrecedenteLieuVille();
                return;
            }

            if (typeInteraction === 'scene') {
                const configurationLieu = obtenirConfigurationLieuVille(etatLieuVille.identifiant);
                if (!configurationLieu || !interactionLieu.scene_cible) {
                    return;
                }
                afficherSceneLieuVille(configurationLieu, interactionLieu.scene_cible, true);
                afficherPanneauLieuVille(etatLieuVille.identifiant, interactionLieu.id || null);
                rafraichirTexteInteractionLieu(interactionLieu.nom || 'Lieu', interactionLieu.texte || 'Vous changez de zone.');
                return;
            }

            if (typeInteraction === 'pnj') {
                afficherPanneauLieuVille(etatLieuVille.identifiant, interactionLieu.id || null);
                rafraichirTexteInteractionLieu(interactionLieu.nom || 'Discussion', interactionLieu.texte || 'La discussion avec ce PNJ sera détaillée plus tard.');
                return;
            }

            afficherPanneauLieuVille(etatLieuVille.identifiant, interactionLieu.id || null);
            rafraichirTexteInteractionLieu(interactionLieu.nom || 'Action', interactionLieu.texte || 'Cette action sera branchée plus tard.');
        }

        function ouvrirFenetreLieuVille(pointVille) {
            if (!fenetreLieuVille || !pointVille) {
                return;
            }

            const configurationLieu = obtenirConfigurationLieuVille(pointVille.id || '');

            etatLieuVille.identifiant = pointVille.id || null;
            etatLieuVille.historiqueScenes = [];

            if (configurationLieu && configurationLieu.scene_initiale) {
                afficherSceneLieuVille(configurationLieu, configurationLieu.scene_initiale, false);
            } else {
                afficherSceneLieuVille(configurationLieu, null, false);
            }

            if (pointVille.categorie === 'pnj_ville' && configurationLieu) {
                rafraichirTexteInteractionLieu(
                    configurationLieu.titre || 'Discussion',
                    configurationLieu.texte_interaction_initial || configurationLieu.description || 'Vous engagez la conversation.'
                );
            }

            fenetreLieuVille.classList.remove('fenetre-lieu-ville-cachee');
            etatLieuVille.ouvert = true;
        }

        function appliquerImageVille() {
            if (!imageVilleActive || !etatVille.code || !configurationVilles.villes || !configurationVilles.villes[etatVille.code]) {
                return;
            }

            const ville = configurationVilles.villes[etatVille.code];
            const source = etatVille.mode === 'nuit' ? ville.image_nuit : ville.image_jour;
            imageVilleActive.src = source || '';
            imageVilleActive.alt = ville.nom ? ('Vue de ' + ville.nom) : 'Vue de ville';
        }

        function synchroniserCalquePointsVille() {
            if (!calquePointsVille || !imageVilleActive) {
                return;
            }

            const conteneurVille = calquePointsVille.parentElement;
            if (!conteneurVille) {
                return;
            }

            const rectangleImage = imageVilleActive.getBoundingClientRect();
            const rectangleConteneur = conteneurVille.getBoundingClientRect();

            if (rectangleImage.width <= 0 || rectangleImage.height <= 0 || rectangleConteneur.width <= 0 || rectangleConteneur.height <= 0) {
                return;
            }

            calquePointsVille.style.position = 'absolute';
            calquePointsVille.style.left = (rectangleImage.left - rectangleConteneur.left) + 'px';
            calquePointsVille.style.top = (rectangleImage.top - rectangleConteneur.top) + 'px';
            calquePointsVille.style.width = rectangleImage.width + 'px';
            calquePointsVille.style.height = rectangleImage.height + 'px';
        }

        function rafraichirVilleAffichee() {
            if (!etatVille.ouverte) {
                return;
            }

            synchroniserCalquePointsVille();
            construirePointsVille();
        }

        function determinerVilleDepuisPosition() {
            const cleCaseActuelle = obtenirCleCaseActuelle();
            const villes = configurationVilles && configurationVilles.villes ? configurationVilles.villes : {};

            for (const codeVille in villes) {
                if (!Object.prototype.hasOwnProperty.call(villes, codeVille)) {
                    continue;
                }

                const ville = villes[codeVille];
                const casesMonde = Array.isArray(ville.cases_monde) ? ville.cases_monde : [];

                for (let indexCase = 0; indexCase < casesMonde.length; indexCase += 1) {
                    const caseMonde = casesMonde[indexCase];
                    const cleCaseVille = String(Number(caseMonde.x || 0)) + '_' + String(Number(caseMonde.y || 0));

                    if (cleCaseVille === cleCaseActuelle) {
                        return {
                            code: codeVille,
                            nom: ville.nom || codeVille
                        };
                    }
                }
            }

            return null;
        }

        function obtenirPointsVilleAffiches(villeActiveConfiguration) {
            const pointsFixes = villeActiveConfiguration && Array.isArray(villeActiveConfiguration.points_interieur)
                ? villeActiveConfiguration.points_interieur.filter(function (pointVille) {
                    return (pointVille.categorie || '') !== 'pnj_ville';
                })
                : [];

            const pnjsSecondaires = villeActiveConfiguration && Array.isArray(villeActiveConfiguration.pnjs_secondaires)
                ? villeActiveConfiguration.pnjs_secondaires.slice()
                : [];

            for (let indexMelange = pnjsSecondaires.length - 1; indexMelange > 0; indexMelange -= 1) {
                const indexAleatoire = Math.floor(Math.random() * (indexMelange + 1));
                const valeurTemporaire = pnjsSecondaires[indexMelange];
                pnjsSecondaires[indexMelange] = pnjsSecondaires[indexAleatoire];
                pnjsSecondaires[indexAleatoire] = valeurTemporaire;
            }

            const pnjsAffiches = pnjsSecondaires.slice(0, 4).map(function (pnjSecondaire) {
                return Object.assign({}, pnjSecondaire, {
                    categorie: 'pnj_ville'
                });
            });

            return pointsFixes.concat(pnjsAffiches);
        }

        function construirePointsVille() {
            if (!calquePointsVille) {
                return;
            }

            calquePointsVille.innerHTML = '';

            const villes = configurationVilles && configurationVilles.villes ? configurationVilles.villes : {};
            const villeActiveConfiguration = etatVille.code && villes[etatVille.code] ? villes[etatVille.code] : null;
            const points = obtenirPointsVilleAffiches(villeActiveConfiguration);

            points.forEach(function (pointVille) {
                const positionX = Number(pointVille.x);
                const positionY = Number(pointVille.y);

                if (!Number.isFinite(positionX) || !Number.isFinite(positionY)) {
                    return;
                }

                const bouton = document.createElement('button');
                bouton.type = 'button';
                bouton.className = 'point-interet-ville point-interet-ville-' + (pointVille.categorie || 'lieu');
                bouton.style.left = positionX + '%';
                bouton.style.top = positionY + '%';
                bouton.dataset.id = pointVille.id || '';
                bouton.dataset.categorie = pointVille.categorie || 'lieu';
                bouton.title = pointVille.nom || 'Point d’intérêt';
                bouton.setAttribute('aria-label', pointVille.nom || 'Point d’intérêt');

                const icone = document.createElement('span');
                icone.className = 'point-interet-ville-icone';
                icone.textContent = pointVille.icone || '•';

                const etiquette = document.createElement('span');
                etiquette.className = 'point-interet-ville-etiquette';
                etiquette.textContent = pointVille.nom || 'Lieu';

                bouton.appendChild(icone);
                bouton.appendChild(etiquette);

                bouton.addEventListener('click', function (evenement) {
                    evenement.preventDefault();
                    evenement.stopPropagation();

                    if ((pointVille.categorie || 'lieu') === 'sortie') {
                        fermerFenetreLieuVille();

                        if (Number.isFinite(Number(pointVille.destination_x)) && Number.isFinite(Number(pointVille.destination_y))) {
                            etatCarte.colonne = borner(Number(pointVille.destination_x), 0, etatCarte.colonneMax);
                            etatCarte.ligne = borner(Number(pointVille.destination_y), 0, etatCarte.ligneMax);

                            const typeCaseActuelle = obtenirTypeCase(etatCarte.colonne, etatCarte.ligne);
                            etatCarte.bateauDisponible = obtenirEtatBateauApresArrivee(typeCaseActuelle);

                            if (etatVille.code === 'aqualis') {
                                etatCarte.bateauDisponible = true;
                            }

                            mettreAJourRepereJoueur();
                            mettreAJourCamera();
                            mettreAJourCoordonneesAffichees();
                            mettreAJourInformationsEtat();
                            mettreAJourEvenements(typeCaseActuelle);
                            mettreAJourDirectionActive();
                            sauvegarderPositionJoueur();
                            masquerCasesAtteignables();
                        }

                        fermerSuperpositionVille(true);
                        return;
                    }

                    ouvrirFenetreLieuVille(pointVille);
                });

                calquePointsVille.appendChild(bouton);
            });
        }

        function ouvrirSuperpositionVille(pointVille) {
            if (!superpositionVille || !pointVille || !configurationVilles.villes || !configurationVilles.villes[pointVille.code]) {
                return;
            }

            etatVille.code = pointVille.code;
            etatVille.ouverte = true;
            etatVille.caseDeclenchee = obtenirCleCaseActuelle();
            etatVille.caseFermee = null;
            etatVille.mode = obtenirModeVilleActuel();

            const ville = configurationVilles.villes[pointVille.code];
            if (titreVilleActive) {
                titreVilleActive.textContent = ville.nom || pointVille.nom || 'Ville';
            }
            if (sousTitreVilleActive) {
                sousTitreVilleActive.textContent = 'Choisissez un lieu ou une porte pour continuer.';
            }

            appliquerImageVille();
            fermerFenetreLieuVille();
            superpositionVille.classList.remove('superposition-ville-cachee');
            superpositionVille.setAttribute('aria-hidden', 'false');
            document.body.classList.add('ville-ouverte');

            requestAnimationFrame(function () {
                rafraichirVilleAffichee();
            });

            ajouterLogDebug('Ville ouverte : ' + (ville.nom || pointVille.nom || 'Ville') + '.');
        }

        function fermerSuperpositionVille(estSortieVille) {
            if (!superpositionVille) {
                return;
            }

            superpositionVille.classList.add('superposition-ville-cachee');
            superpositionVille.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('ville-ouverte');
            fermerFenetreLieuVille();

            etatVille.ouverte = false;
            etatVille.code = null;
            etatVille.mode = obtenirModeVilleActuel();
            etatVille.caseFermee = obtenirCleCaseActuelle();

            ajouterLogDebug(estSortieVille ? 'Sortie de ville demandée depuis une porte.' : 'Fenêtre de ville fermée.');
        }

        function verifierOuvertureVilleAutomatique() {
            const cleCaseActuelle = obtenirCleCaseActuelle();
            const pointVille = determinerVilleDepuisPosition();

            if (!pointVille) {
                etatVille.caseDeclenchee = null;
                etatVille.caseFermee = null;
                if (etatVille.ouverte) {
                    fermerSuperpositionVille(false);
                }
                return;
            }

            if (etatVille.ouverte) {
                return;
            }

            if (etatVille.caseFermee === cleCaseActuelle) {
                return;
            }

            ouvrirSuperpositionVille(pointVille);
        }

        function appliquerModeVille(mode) {
            const modeNormalise = mode === 'nuit' ? 'nuit' : 'jour';
            ecrireStockageJson(cleModeVille, modeNormalise);
            etatVille.mode = modeNormalise;
            if (etatVille.ouverte) {
                appliquerImageVille();
            }
            ajouterLogDebug('Mode d’affichage des villes : ' + modeNormalise + '.');
        }

        function finaliserInitialisation() {
            contenu.style.width = etatCarte.largeurMonde + 'px';
            contenu.style.height = etatCarte.hauteurMonde + 'px';

            imageCarte.style.width = etatCarte.largeurMonde + 'px';
            imageCarte.style.height = etatCarte.hauteurMonde + 'px';
            imageCarte.style.display = 'block';

            const geometrie = obtenirGeometrieAffichee();

            grille.style.width = etatCarte.largeurMonde + 'px';
            grille.style.height = etatCarte.hauteurMonde + 'px';
            grille.style.backgroundSize = geometrie.largeurCaseAffichee + 'px ' + geometrie.hauteurCaseAffichee + 'px';
            grille.style.display = 'block';

            surbrillance.style.width = etatCarte.largeurMonde + 'px';
            surbrillance.style.height = etatCarte.hauteurMonde + 'px';
            surbrillanceLieux.style.width = etatCarte.largeurMonde + 'px';
            surbrillanceLieux.style.height = etatCarte.hauteurMonde + 'px';
            surbrillanceLieux.style.pointerEvents = 'none';
            dessinerSurbrillancesLieux();

            etatCarte.bateauDisponible = obtenirTypeCase(etatCarte.colonne, etatCarte.ligne) === 'ponton' || obtenirTypeCase(etatCarte.colonne, etatCarte.ligne) === 'eau';

            mettreAJourRepereJoueur();
            mettreAJourCamera();
            mettreAJourCoordonneesAffichees();
            mettreAJourInformationsEtat();
            mettreAJourEvenements(obtenirTypeCase(etatCarte.colonne, etatCarte.ligne));
            mettreAJourDirectionActive();
            sauvegarderPositionJoueur();
            etatVille.mode = obtenirModeVilleActuel();
            verifierOuvertureVilleAutomatique();

            carteDejaInitialisee = true;
            ajouterLogDebug('Carte prête : grille officielle 40 x 27 chargée.');
        }

        repereJoueur.addEventListener('click', function (evenement) {
            evenement.preventDefault();
            evenement.stopPropagation();
            alternerCasesAtteignables();
        });

        surbrillance.addEventListener('click', function (evenement) {
            const caseCliquee = evenement.target.closest('.case-atteignable-monde');
            if (!caseCliquee) {
                return;
            }

            evenement.preventDefault();
            evenement.stopPropagation();
            deplacerJoueurVers(Number(caseCliquee.dataset.colonne), Number(caseCliquee.dataset.ligne), 'souris');
        });

        window.addEventListener('resize', function () {
            if (carteDejaInitialisee) {
                mettreAJourCamera();
                mettreAJourRepereJoueur();
                dessinerSurbrillancesLieux();
                if (etatCarte.surbrillanceActive) {
                    dessinerCasesAtteignables();
                }
                if (etatVille.ouverte) {
                    rafraichirVilleAffichee();
                }
            }
        });

        if (boutonDebugMonture) {
            boutonDebugMonture.addEventListener('click', function () {
                etatCarte.modeMontureActif = !etatCarte.modeMontureActif;
                mettreAJourInformationsEtat();
                ajouterLogDebug(etatCarte.modeMontureActif ? 'Monture activée.' : 'Monture désactivée.');
                if (etatCarte.surbrillanceActive) {
                    afficherCasesAtteignables();
                }
            });
        }

        if (boutonDebugAfficherCases) {
            boutonDebugAfficherCases.addEventListener('click', function () {
                afficherCasesAtteignables();
            });
        }

        if (boutonDebugReinitialiserLogs) {
            boutonDebugReinitialiserLogs.addEventListener('click', function () {
                viderLogsDebug();
                ajouterLogDebug('Logs réinitialisés.');
            });
        }

        if (boutonDebugVilleJour) {
            boutonDebugVilleJour.addEventListener('click', function () {
                appliquerModeVille('jour');
            });
        }

        if (boutonDebugVilleNuit) {
            boutonDebugVilleNuit.addEventListener('click', function () {
                appliquerModeVille('nuit');
            });
        }

        if (boutonFermerVille) {
            boutonFermerVille.addEventListener('click', function () {
                fermerSuperpositionVille(false);
            });
        }

        if (boutonFermerLieuVille) {
            boutonFermerLieuVille.addEventListener('click', fermerFenetreLieuVille);
        }

        if (boutonRetourScene) {
            boutonRetourScene.addEventListener('click', revenirScenePrecedenteLieuVille);
        }

        if (boutonRetourVille) {
            boutonRetourVille.addEventListener('click', fermerFenetreLieuVille);
        }


        window.addEventListener('storage', function (evenement) {
            if (evenement.key === cleDestinationActive || evenement.key === cleQueteSuivie) {
                mettreAJourDirectionActive();
            }

            if (evenement.key === cleModeVille) {
                etatVille.mode = obtenirModeVilleActuel();
                if (etatVille.ouverte) {
                    appliquerImageVille();
                }
            }

            if (evenement.key === clePositionJoueur) {
                const position = lireStockageJson(clePositionJoueur);
                if (!position) {
                    return;
                }

                etatCarte.colonne = borner(Number(position.x || etatCarte.colonne), 0, etatCarte.colonneMax);
                etatCarte.ligne = borner(Number(position.y || etatCarte.ligne), 0, etatCarte.ligneMax);
                const typeCaseActuelle = obtenirTypeCase(etatCarte.colonne, etatCarte.ligne);
                etatCarte.bateauDisponible = typeCaseActuelle === 'ponton' || typeCaseActuelle === 'eau';
                mettreAJourRepereJoueur();
                mettreAJourCamera();
                mettreAJourCoordonneesAffichees();
                mettreAJourInformationsEtat();
                mettreAJourDirectionActive();
                verifierOuvertureVilleAutomatique();
            }
        });

        window.addEventListener('elementia-destination-changee', mettreAJourDirectionActive);

        if (imageVilleActive) {
            imageVilleActive.addEventListener('load', function () {
                if (etatVille.ouverte) {
                    rafraichirVilleAffichee();
                }
            });
        }

        imageCarte.addEventListener('error', function () {
            console.error('[Elementia] Image carte introuvable : ' + cheminCarte);
        });

        imageCarte.src = cheminCarte;

        function essayerInitialiser() {
            if (!imageCarte.complete || imageCarte.naturalWidth <= 0 || viewport.clientWidth <= 0 || viewport.clientHeight <= 0) {
                requestAnimationFrame(essayerInitialiser);
                return;
            }

            finaliserInitialisation();
        }

        essayerInitialiser();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialiserCarteElementia);
    } else {
        initialiserCarteElementia();
    }
})();
