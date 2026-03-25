<?php
/* ========================================================= */
/* FENÊTRE PERSONNAGE                                       */
/* ========================================================= */
/*
Cette fenêtre affiche :
- à gauche : la silhouette du personnage avec les emplacements d'équipement
- à droite : les statistiques actuelles du personnage actif

Important :
- Les slots sont pour l'instant visuels uniquement
- La logique réelle de slot / drop sera ajoutée plus tard
*/

/* On sécurise la variable personnage pour éviter les erreurs PHP */
$personnage = $personnage ?? [];

/*
Fonction utilitaire :
permet de lire proprement une statistique sans erreur si la clé n'existe pas
*/
function valeurStatPersonnage(array $personnage, string $cle): int
{
    return (int) ($personnage[$cle] ?? 0);
}
?>
<div id="fenetre-personnage"
     class="fenetre-jeu-modele fenetre-jeu-cachee"
     data-cle-fenetre="personnage"
     role="dialog"
     aria-modal="true"
     aria-labelledby="titre-fenetre-personnage">

    <!-- ===================================================== -->
    <!-- EN-TÊTE DE LA FENÊTRE                                 -->
    <!-- ===================================================== -->
    <div class="entete-fenetre-jeu entete-fenetre-personnage">
        <div>
            <h2 id="titre-fenetre-personnage">Personnage</h2>
            <p>Équipement du personnage à gauche et statistiques du personnage actif à droite.</p>
        </div>

        <button type="button"
                class="bouton-fermer-fenetre"
                data-fermer-fenetre="oui"
                aria-label="Fermer la fenêtre">×</button>
    </div>

    <!-- ===================================================== -->
    <!-- CONTENU DE LA FENÊTRE                                 -->
    <!-- ===================================================== -->
    <div class="contenu-fenetre-jeu contenu-fenetre-personnage">
        <div class="zone-feuille-personnage">

            <!-- ============================================= -->
            <!-- COLONNE GAUCHE : SILHOUETTE + SLOTS           -->
            <!-- ============================================= -->
            <section class="carte-personnage"
                     aria-label="Équipement du personnage">

                <!--
                Cette zone sert de repère visuel :
                la silhouette est affichée en fond
                et les slots sont placés au-dessus
                -->
                <div class="zone-silhouette-personnage">

                    <!-- Silhouette image de fond -->
                    <div class="silhouette-personnage-image" aria-hidden="true"></div>

                    <!-- Slots équipement -->
                    <div class="slot-personnage slot-tete">Tête</div>

                    <div class="slot-personnage slot-gants-gauche">Gants</div>
                    <div class="slot-personnage slot-gants-droite">Gants</div>

                    <div class="slot-personnage slot-torse">Torse</div>
                    <div class="slot-personnage slot-jambes">Jambes</div>

                    <div class="slot-personnage slot-collier">Collier</div>
                    <div class="slot-personnage slot-bague-1">Bague I</div>
                    <div class="slot-personnage slot-bague-2">Bague II</div>

                    <div class="slot-personnage slot-main-gauche">Main gauche</div>
                    <div class="slot-personnage slot-artefact">Artefact</div>
                    <div class="slot-personnage slot-main-droite">Main droite</div>

                    <div class="slot-personnage slot-sac">Sac</div>
                </div>
            </section>

            <!-- ============================================= -->
            <!-- COLONNE DROITE : STATISTIQUES                 -->
            <!-- ============================================= -->
            <aside class="carte-statistiques"
                   aria-label="Statistiques du personnage">

                <div class="entete-stats-personnage">
                    <h3>Statistiques</h3>
                    <p>Valeurs actuelles du personnage actif.</p>
                </div>

                <div class="grille-statistiques-personnage">
                    <div class="ligne-statistique-personnage">
                        <span>PV</span>
                        <strong><?= valeurStatPersonnage($personnage, 'pv') ?></strong>
                    </div>

                    <div class="ligne-statistique-personnage">
                        <span>Attaque</span>
                        <strong><?= valeurStatPersonnage($personnage, 'attaque') ?></strong>
                    </div>

                    <div class="ligne-statistique-personnage">
                        <span>Magie</span>
                        <strong><?= valeurStatPersonnage($personnage, 'magie') ?></strong>
                    </div>

                    <div class="ligne-statistique-personnage">
                        <span>Agilité</span>
                        <strong><?= valeurStatPersonnage($personnage, 'agilite') ?></strong>
                    </div>

                    <div class="ligne-statistique-personnage">
                        <span>Intelligence</span>
                        <strong><?= valeurStatPersonnage($personnage, 'intelligence') ?></strong>
                    </div>

                    <div class="ligne-statistique-personnage">
                        <span>Synchronisation</span>
                        <strong><?= valeurStatPersonnage($personnage, 'synchronisation') ?></strong>
                    </div>

                    <div class="ligne-statistique-personnage">
                        <span>Critique</span>
                        <strong><?= valeurStatPersonnage($personnage, 'critique') ?></strong>
                    </div>

                    <div class="ligne-statistique-personnage">
                        <span>Dextérité</span>
                        <strong><?= valeurStatPersonnage($personnage, 'dexterite') ?></strong>
                    </div>

                    <div class="ligne-statistique-personnage ligne-statistique-personnage-large">
                        <span>Défense</span>
                        <strong><?= valeurStatPersonnage($personnage, 'defense') ?></strong>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
