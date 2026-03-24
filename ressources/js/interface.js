
// ---------------------------------------------------------
// GESTION DU CHARGEMENT VISUEL GLOBAL
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
});
