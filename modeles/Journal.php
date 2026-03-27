<?php
// ---------------------------------------------------------
// MODÈLE DU JOURNAL DU MONDE ET DU JOUEUR
// ---------------------------------------------------------
declare(strict_types=1);

require_once __DIR__ . '/../configuration/base_de_donnees.php';

if (!class_exists('Journal')) {
    class Journal
    {
        // -------------------------------------------------
        // Retourne les entrées du journal à afficher.
        // -------------------------------------------------
        public static function chargerEntreesPersonnage(int $personnageId, array $personnage = [], array $quetes = [], array $competences = []): array
        {
            global $connexion_base;

            if (($connexion_base instanceof PDO) && self::tableExiste($connexion_base, 'journal')) {
                $entreesBase = self::chargerDepuisBase($connexion_base, $personnageId);

                if (!empty($entreesBase)) {
                    return $entreesBase;
                }
            }

            return self::construireEntreesParDefaut($personnage, $quetes, $competences);
        }

        private static function chargerDepuisBase(PDO $connexionBase, int $personnageId): array
        {
            $requete = $connexionBase->prepare(
                'SELECT id, categorie, titre, resume, details, importance, date_evenement
                 FROM journal
                 WHERE personnage_id = :personnage_id OR personnage_id IS NULL
                 ORDER BY date_evenement DESC, id DESC
                 LIMIT 80'
            );

            $requete->execute(['personnage_id' => $personnageId]);
            $entrees = $requete->fetchAll(PDO::FETCH_ASSOC) ?: [];

            foreach ($entrees as &$entree) {
                $entree = self::normaliserEntree($entree);
            }

            return $entrees;
        }

        private static function construireEntreesParDefaut(array $personnage, array $quetes, array $competences): array
        {
            $nom = (string) ($personnage['nom'] ?? 'Le personnage');
            $region = (string) ($personnage['region_depart'] ?? 'Elementia');
            $element = (string) ($personnage['element'] ?? 'Neutre');
            $niveau = (int) ($personnage['niveau'] ?? 1);
            $nombreCompetences = count($competences);
            $nombreQuetes = count($quetes);
            $positionX = (int) ($personnage['position_x'] ?? 18);
            $positionY = (int) ($personnage['position_y'] ?? 12);

            return [
                self::normaliserEntree([
                    'id' => 1,
                    'categorie' => 'monde',
                    'titre' => 'Le monde d’Elementia reste en mouvement',
                    'resume' => 'Les régions vivent, les villages se stabilisent et les événements majeurs finiront par remonter ici.',
                    'details' => 'Cette fenêtre est prête à recevoir les combats, rumeurs, quêtes, évolutions du monde et événements importants du personnage.',
                    'importance' => 'majeure',
                    'date_evenement' => date('Y-m-d H:i:s')
                ]),
                self::normaliserEntree([
                    'id' => 2,
                    'categorie' => 'personnage',
                    'titre' => $nom . ' a rejoint la région de ' . $region,
                    'resume' => 'Votre aventure commence dans la région liée à votre élément de départ.',
                    'details' => 'Élément : ' . $element . ' · Niveau : ' . $niveau . ' · Position actuelle : ' . $positionX . ' x ' . $positionY . '.',
                    'importance' => 'normale',
                    'date_evenement' => date('Y-m-d H:i:s', strtotime('-20 minutes'))
                ]),
                self::normaliserEntree([
                    'id' => 3,
                    'categorie' => 'competence',
                    'titre' => 'Compétences prêtes à être consultées',
                    'resume' => 'Le personnage dispose actuellement de ' . $nombreCompetences . ' compétence(s) visible(s).',
                    'details' => 'La fenêtre Compétences permet de voir le niveau, le coût, la portée, l’effet et la progression de chaque sort sélectionné.',
                    'importance' => 'normale',
                    'date_evenement' => date('Y-m-d H:i:s', strtotime('-1 hour'))
                ]),
                self::normaliserEntree([
                    'id' => 4,
                    'categorie' => 'quete',
                    'titre' => 'Suivi de quêtes initialisé',
                    'resume' => 'Nombre de quêtes actuellement visibles : ' . $nombreQuetes . '.',
                    'details' => 'Les futures étapes de jeu pourront pousser ici les mises à jour de progression, les réussites, les échecs et les nouvelles missions.',
                    'importance' => 'mineure',
                    'date_evenement' => date('Y-m-d H:i:s', strtotime('-2 hours'))
                ]),
                self::normaliserEntree([
                    'id' => 5,
                    'categorie' => 'combat',
                    'titre' => 'Journal de combat prêt',
                    'resume' => 'Les futurs affrontements pourront être archivés ici.',
                    'details' => 'Rencontres de monstres, victoires, défaites, gains, pertes et événements liés au combat seront centralisés dans ce panneau.',
                    'importance' => 'mineure',
                    'date_evenement' => date('Y-m-d H:i:s', strtotime('-1 day'))
                ])
            ];
        }

        private static function normaliserEntree(array $entree): array
        {
            return [
                'id' => (int) ($entree['id'] ?? 0),
                'categorie' => (string) ($entree['categorie'] ?? 'monde'),
                'titre' => (string) ($entree['titre'] ?? 'Événement'),
                'resume' => (string) ($entree['resume'] ?? ''),
                'details' => (string) ($entree['details'] ?? ''),
                'importance' => (string) ($entree['importance'] ?? 'normale'),
                'date_evenement' => (string) ($entree['date_evenement'] ?? '')
            ];
        }

        private static function tableExiste(PDO $connexionBase, string $nomTable): bool
        {
            $requete = $connexionBase->prepare('SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table_nom LIMIT 1');
            $requete->execute(['table_nom' => $nomTable]);
            return (bool) $requete->fetchColumn();
        }
    }
}
