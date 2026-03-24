<?php if ($etape === 1) : ?>
    <?php include __DIR__ . '/etapes/etape_1_element.php'; ?>
<?php elseif ($etape === 2) : ?>
    <?php include __DIR__ . '/etapes/etape_2_classe.php'; ?>
<?php elseif ($etape === 3) : ?>
    <?php include __DIR__ . '/etapes/etape_3_competences_elementaires.php'; ?>
<?php elseif ($etape === 4) : ?>
    <?php include __DIR__ . '/etapes/etape_4_competences_neutres.php'; ?>
<?php else : ?>
    <?php include __DIR__ . '/etapes/etape_5_identite_statistiques.php'; ?>
<?php endif; ?>
