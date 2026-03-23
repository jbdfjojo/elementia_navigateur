// ---------------------------------------------------------
// GESTION DU CHARGEMENT VISUEL
// ---------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
    // -----------------------------------------------------
    // Récupération de l'écran de chargement
    // -----------------------------------------------------
    const ecranChargement = document.getElementById('ecran-chargement');

    // -----------------------------------------------------
    // Masquage doux du chargement après affichage de la vue
    // -----------------------------------------------------
    window.setTimeout(function () {
        if (ecranChargement) {
            ecranChargement.classList.add('cache');
        }
    }, 350);

    // -----------------------------------------------------
    // Réaffichage du chargement pendant les soumissions
    // -----------------------------------------------------
    const formulaires = document.querySelectorAll('.formulaire-avec-chargement');

    formulaires.forEach(function (formulaire) {
        formulaire.addEventListener('submit', function () {
            if (ecranChargement) {
                ecranChargement.classList.remove('cache');
            }
        });
    });
});
