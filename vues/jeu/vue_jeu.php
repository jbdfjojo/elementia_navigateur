<?php
require_once __DIR__ . '/../../controleurs/ControleurJeu.php';

$personnage = [];
$inventaire = [];
$poids_inventaire = 0;
$equipements = [];
$competences = [];
$quetes = [];
$journal = [];
$carte = [];

if (isset($_SESSION['personnage_id'])) {
    $donnees_jeu = ControleurJeu::chargerDonnees((int) $_SESSION['personnage_id']);
    $personnage = $donnees_jeu['personnage'] ?? [];
    $inventaire = $donnees_jeu['inventaire'] ?? [];
    $poids_inventaire = (int) ($donnees_jeu['poids_inventaire'] ?? 0);
    $equipements = $donnees_jeu['equipements'] ?? [];
    $competences = $donnees_jeu['competences'] ?? [];
    $quetes = $donnees_jeu['quetes'] ?? [];
    $journal = $donnees_jeu['journal'] ?? [];
    $carte = $donnees_jeu['carte'] ?? [];
}
?>
<section class="page-jeu">
    <?php include __DIR__ . '/interface_jeu.php'; ?>
</section>
