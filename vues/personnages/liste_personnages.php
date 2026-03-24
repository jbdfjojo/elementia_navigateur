<?php if (empty($personnages)) : ?>
    <p class="texte-explicatif">Aucun personnage n’est encore créé sur ce compte.</p>
<?php else : ?>
    <div class="liste-personnages">
        <?php foreach ($personnages as $personnage) : ?>
            <div class="carte-personnage">
                <?php $chemin_avatar = !empty($personnage['portrait']) ? (string) $personnage['portrait'] : ''; ?>

                <?php if ($chemin_avatar !== '') : ?>
                    <div class="cadre-avatar-liste">
                        <img src="<?= htmlspecialchars($chemin_avatar, ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($personnage['nom'], ENT_QUOTES, 'UTF-8'); ?>" class="avatar-personnage-liste">
                    </div>
                <?php endif; ?>

                <h3><?= htmlspecialchars($personnage['nom'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <p>Élément : <?= htmlspecialchars($personnage['element'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>Classe : <?= htmlspecialchars((string) ($personnage['classe'] ?? 'Non définie'), ENT_QUOTES, 'UTF-8'); ?></p>
                <p>Niveau : <?= (int) $personnage['niveau']; ?></p>
                <p>Région : <?= htmlspecialchars((string) ($personnage['region_depart'] ?? 'Non définie'), ENT_QUOTES, 'UTF-8'); ?></p>

                <div class="zone-actions-carte-personnage">
                    <form method="post" action="index.php" class="formulaire-avec-chargement">
                        <input type="hidden" name="action" value="selectionner_personnage">
                        <input type="hidden" name="personnage_id" value="<?= (int) $personnage['id']; ?>">
                        <button type="submit">Jouer avec ce personnage</button>
                    </form>

                    <form method="post" action="index.php" class="formulaire-avec-chargement" onsubmit="return confirm('Voulez-vous vraiment supprimer ce personnage ?');">
                        <input type="hidden" name="action" value="supprimer_personnage">
                        <input type="hidden" name="personnage_id" value="<?= (int) $personnage['id']; ?>">
                        <button type="submit" class="bouton-secondaire">Supprimer</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
