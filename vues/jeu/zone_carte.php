<div class="zone-monde">
    <div class="zone-carte-simulee">
        <?php include __DIR__ . '/bloc_evenements.php'; ?>
        <div class="texte-centre-monde">
            <h2>Bienvenue, <?= htmlspecialchars($_SESSION['personnage_nom'] ?? 'Aventurier', ENT_QUOTES, 'UTF-8'); ?></h2>
            <p>Le monde d’Elementia vous attend.</p>
        </div>
    </div>
</div>
