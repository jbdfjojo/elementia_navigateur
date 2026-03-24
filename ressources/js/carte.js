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
        const boutonDebugReinitialiserLogs = document.getElementById('bouton-debug-reinitialiser-logs');
        const debugEtatMode = document.getElementById('debug-etat-mode');
        const debugEtatBateau = document.getElementById('debug-etat-bateau');
        const debugEtatPosition = document.getElementById('debug-etat-position');
        const debugJournalDeplacement = document.getElementById('debug-journal-deplacement');

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
            masquerCasesAtteignables();

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

            etatCarte.bateauDisponible = obtenirTypeCase(etatCarte.colonne, etatCarte.ligne) === 'ponton';

            mettreAJourRepereJoueur();
            mettreAJourCamera();
            mettreAJourCoordonneesAffichees();
            mettreAJourInformationsEtat();
            mettreAJourEvenements(obtenirTypeCase(etatCarte.colonne, etatCarte.ligne));

            carteDejaInitialisee = true;
            ajouterLogDebug('Carte prête : grille officielle 40 x 27 chargée.');
        }

        repereJoueur.addEventListener('click', function (evenement) {
            evenement.preventDefault();
            evenement.stopPropagation();
            alternerCasesAtteignables();
        });

        repereJoueur.addEventListener('keydown', function (evenement) {
            if (evenement.key === 'Enter' || evenement.key === ' ') {
                evenement.preventDefault();
                alternerCasesAtteignables();
            }
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
            }
        });

        document.addEventListener('keydown', function (evenement) {
            const tagCible = (evenement.target && evenement.target.tagName) ? evenement.target.tagName.toLowerCase() : '';
            if (tagCible === 'input' || tagCible === 'textarea' || tagCible === 'select') {
                return;
            }

            if (evenement.key === 'ArrowUp' || evenement.key === 'z' || evenement.key === 'Z') {
                deplacerJoueurAuClavier(0, -1);
            }
            if (evenement.key === 'ArrowDown' || evenement.key === 's' || evenement.key === 'S') {
                deplacerJoueurAuClavier(0, 1);
            }
            if (evenement.key === 'ArrowLeft' || evenement.key === 'q' || evenement.key === 'Q') {
                deplacerJoueurAuClavier(-1, 0);
            }
            if (evenement.key === 'ArrowRight' || evenement.key === 'd' || evenement.key === 'D') {
                deplacerJoueurAuClavier(1, 0);
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
