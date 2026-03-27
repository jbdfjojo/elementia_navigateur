<?php
// ---------------------------------------------------------
// MODÈLE DES QUÊTES DU PERSONNAGE
// ---------------------------------------------------------
declare(strict_types=1);

require_once __DIR__ . '/../configuration/base_de_donnees.php';
require_once __DIR__ . '/Carte.php';

if (!class_exists('Quete')) {
    class Quete
    {
        // -------------------------------------------------
        // Retourne les quêtes visibles pour le personnage.
        // -------------------------------------------------
        public static function chargerQuetesPersonnage(int $personnageId, array $personnage = []): array
        {
            global $connexion_base;

            if (($connexion_base instanceof PDO) && self::tableExiste($connexion_base, 'personnage_quetes')) {
                $quetesBase = self::chargerDepuisBase($connexion_base, $personnageId);

                if (!empty($quetesBase)) {
                    return self::enrichirAvecCarte($quetesBase, $personnageId);
                }
            }

            return self::enrichirAvecCarte(self::construireQuetesParDefaut($personnage), $personnageId);
        }

        private static function chargerDepuisBase(PDO $connexionBase, int $personnageId): array
        {
            $jointureQuete = self::tableExiste($connexionBase, 'quetes');

            if ($jointureQuete) {
                $sql = "SELECT
                            pq.id,
                            pq.personnage_id,
                            COALESCE(q.titre, pq.code_quete) AS titre,
                            COALESCE(q.resume, q.description, '') AS resume,
                            COALESCE(q.description, '') AS description,
                            COALESCE(q.objectif, '') AS objectif,
                            COALESCE(q.recompense, '') AS recompense,
                            COALESCE(pq.etat, 'en_cours') AS etat,
                            COALESCE(pq.progression_actuelle, 0) AS progression_actuelle,
                            COALESCE(pq.progression_maximum, 1) AS progression_maximum,
                            COALESCE(pq.categorie, q.categorie, 'principale') AS categorie,
                            COALESCE(pq.zone, q.zone, '') AS zone,
                            COALESCE(pq.date_mise_a_jour, pq.date_creation, NOW()) AS date_evenement
                        FROM personnage_quetes pq
                        LEFT JOIN quetes q ON q.code_quete = pq.code_quete
                        WHERE pq.personnage_id = :personnage_id
                        ORDER BY pq.date_mise_a_jour DESC, pq.id DESC";
            } else {
                $sql = "SELECT
                            pq.id,
                            pq.personnage_id,
                            pq.code_quete AS titre,
                            '' AS resume,
                            '' AS description,
                            '' AS objectif,
                            '' AS recompense,
                            COALESCE(pq.etat, 'en_cours') AS etat,
                            COALESCE(pq.progression_actuelle, 0) AS progression_actuelle,
                            COALESCE(pq.progression_maximum, 1) AS progression_maximum,
                            COALESCE(pq.categorie, 'principale') AS categorie,
                            COALESCE(pq.zone, '') AS zone,
                            COALESCE(pq.date_mise_a_jour, pq.date_creation, NOW()) AS date_evenement
                        FROM personnage_quetes pq
                        WHERE pq.personnage_id = :personnage_id
                        ORDER BY pq.date_mise_a_jour DESC, pq.id DESC";
            }

            $requete = $connexionBase->prepare($sql);
            $requete->execute(['personnage_id' => $personnageId]);
            $quetes = $requete->fetchAll(PDO::FETCH_ASSOC) ?: [];

            foreach ($quetes as &$quete) {
                $quete = self::normaliserQuete($quete);
            }

            return $quetes;
        }

        private static function construireQuetesParDefaut(array $personnage): array
        {
            $nom = (string) ($personnage['nom'] ?? 'Voyageur');
            $element = (string) ($personnage['element'] ?? 'Neutre');
            $region = (string) ($personnage['region_depart'] ?? 'Elementia');

            return [
                self::normaliserQuete([
                    'id' => 1,
                    'titre' => 'Premiers pas à ' . $region,
                    'resume' => 'Prenez vos repères dans votre région de départ et parlez aux premiers habitants rencontrés.',
                    'description' => 'Cette quête sert d’introduction. Elle permet au joueur de comprendre sa région, son orientation et les premiers points d’intérêt utiles.',
                    'objectif' => 'Explorer la zone de départ, repérer la ville sûre la plus proche et parler à un PNJ important.',
                    'recompense' => '50 cristaux verts · 1 ration · entrée dans le journal du monde',
                    'etat' => 'en_cours',
                    'progression_actuelle' => 1,
                    'progression_maximum' => 3,
                    'categorie' => 'principale',
                    'zone' => $region,
                    'date_evenement' => date('Y-m-d H:i:s')
                ]),
                self::normaliserQuete([
                    'id' => 2,
                    'titre' => 'Maîtrise élémentaire : ' . $element,
                    'resume' => 'Commencez à prendre en main vos compétences élémentaires.',
                    'description' => $nom . ' doit apprendre à utiliser ses sorts de départ avec discipline avant d’entrer dans des zones plus dangereuses.',
                    'objectif' => 'Ouvrir la fenêtre Compétences, lire vos sorts actifs et préparer votre style de jeu.',
                    'recompense' => '1 entrée de codex · 25 XP de personnage · progression du tutoriel',
                    'etat' => 'en_attente',
                    'progression_actuelle' => 0,
                    'progression_maximum' => 1,
                    'categorie' => 'apprentissage',
                    'zone' => $region,
                    'date_evenement' => date('Y-m-d H:i:s', strtotime('-1 hour'))
                ]),
                self::normaliserQuete([
                    'id' => 3,
                    'titre' => 'Le monde observe',
                    'resume' => 'Le Journal suivra bientôt les événements majeurs, combats et mouvements du monde.',
                    'description' => 'Cette quête de préparation sert de repère pour les futures quêtes dynamiques, les rumeurs et les événements mondiaux.',
                    'objectif' => 'Consulter le journal du monde et rester prêt pour la prochaine vraie quête dynamique.',
                    'recompense' => 'Déblocage futur du suivi d’événements mondiaux',
                    'etat' => 'terminee',
                    'progression_actuelle' => 1,
                    'progression_maximum' => 1,
                    'categorie' => 'journal',
                    'zone' => 'Monde',
                    'date_evenement' => date('Y-m-d H:i:s', strtotime('-1 day'))
                ])
            ];
        }

        private static function normaliserQuete(array $quete): array
        {
            $progressionActuelle = max(0, (int) ($quete['progression_actuelle'] ?? 0));
            $progressionMaximum = max(1, (int) ($quete['progression_maximum'] ?? 1));
            $pourcentage = (int) min(100, floor(($progressionActuelle / $progressionMaximum) * 100));

            return [
                'id' => (int) ($quete['id'] ?? 0),
                'titre' => (string) ($quete['titre'] ?? 'Quête inconnue'),
                'resume' => (string) ($quete['resume'] ?? ''),
                'description' => (string) ($quete['description'] ?? ''),
                'objectif' => (string) ($quete['objectif'] ?? ''),
                'recompense' => (string) ($quete['recompense'] ?? ''),
                'etat' => (string) ($quete['etat'] ?? 'en_cours'),
                'progression_actuelle' => $progressionActuelle,
                'progression_maximum' => $progressionMaximum,
                'pourcentage_progression' => $pourcentage,
                'categorie' => (string) ($quete['categorie'] ?? 'principale'),
                'zone' => (string) ($quete['zone'] ?? ''),
                'date_evenement' => (string) ($quete['date_evenement'] ?? '')
            ];
        }


        public static function definirQueteSuivie(int $personnageId, int $queteId): void
        {
            global $connexion_base;

            Carte::creerTablesNavigationSiNecessaire();

            $connexion_base->prepare(
                "INSERT INTO personnage_navigation (personnage_id, type_destination, quete_id, repere_id)
                 VALUES (:personnage_id, 'quete', :quete_id, NULL)
                 ON DUPLICATE KEY UPDATE
                    quete_id = VALUES(quete_id),
                    type_destination = CASE
                        WHEN repere_id IS NOT NULL AND repere_id > 0 THEN 'mixte'
                        ELSE 'quete'
                    END"
            )->execute([
                'personnage_id' => $personnageId,
                'quete_id' => $queteId,
            ]);
        }

        public static function effacerQueteSuivie(int $personnageId): void
        {
            Carte::effacerQueteSuivie($personnageId);
        }

        public static function obtenirQueteSuivieId(int $personnageId): int
        {
            $destination = Carte::lireDestinationActive($personnageId);
            return (int) ($destination['quete_id'] ?? 0);
        }

        public static function enrichirAvecCarte(array $quetes, int $personnageId): array
        {
            $queteSuivieId = self::obtenirQueteSuivieId($personnageId);

            foreach ($quetes as &$quete) {
                $point = self::trouverPointCartePourQuete($quete);
                $quete['a_position_carte'] = $point !== null;
                $quete['position_carte'] = $point;
                $quete['est_suivie'] = ((int) ($quete['id'] ?? 0)) === $queteSuivieId;
            }

            return $quetes;
        }

        public static function trouverPointCartePourQuete(array $quete): ?array
        {
            $champs = [
                (string) ($quete['zone'] ?? ''),
                (string) ($quete['objectif'] ?? ''),
                (string) ($quete['resume'] ?? ''),
                (string) ($quete['description'] ?? ''),
                (string) ($quete['titre'] ?? ''),
            ];

            foreach ($champs as $champ) {
                $point = Carte::trouverPointInteretParTexte($champ);
                if ($point !== null) {
                    return $point;
                }
            }

            return null;
        }

        private static function tableExiste(PDO $connexionBase, string $nomTable): bool
        {
            $requete = $connexionBase->prepare('SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table_nom LIMIT 1');
            $requete->execute(['table_nom' => $nomTable]);
            return (bool) $requete->fetchColumn();
        }
    }
}
