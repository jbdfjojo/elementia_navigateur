<?php
declare(strict_types=1);
require_once __DIR__ . '/../configuration/base_de_donnees.php';
if (!class_exists('Carte')) {
    class Carte
    {
        public static function chargerDonneesFenetre(array $personnage = []): array
        {
            global $connexion_base;
            $positionX = max(0, (int) ($personnage['position_x'] ?? 18));
            $positionY = max(0, (int) ($personnage['position_y'] ?? 12));
            $region = (string) ($personnage['region_depart'] ?? 'Elementia');
            $colonnes = 40;
            $lignes = 27;
            $largeurMonde = 2534;
            $hauteurMonde = 1690;
            $pointsInteret = [];
            $zonesColoriees = [];
            if ($connexion_base instanceof PDO) {
                $requeteCarte = $connexion_base->query("SELECT colonnes, lignes, largeur_affichee, hauteur_affichee FROM monde_cartes WHERE id = 1 LIMIT 1");
                $carteBase = $requeteCarte ? $requeteCarte->fetch(PDO::FETCH_ASSOC) : null;
                if (is_array($carteBase)) {
                    $colonnes = max(1, (int) ($carteBase['colonnes'] ?? $colonnes));
                    $lignes = max(1, (int) ($carteBase['lignes'] ?? $lignes));
                    $largeurMonde = max(1, (int) ($carteBase['largeur_affichee'] ?? $largeurMonde));
                    $hauteurMonde = max(1, (int) ($carteBase['hauteur_affichee'] ?? $hauteurMonde));
                }
                $requeteZones = $connexion_base->query("SELECT nom_zone, code_zone, type_zone, colonne_origine, ligne_origine, largeur_cases, hauteur_cases FROM monde_zones WHERE code_carte = 'monde_principal' ORDER BY id ASC");
                $zones = $requeteZones ? $requeteZones->fetchAll(PDO::FETCH_ASSOC) : [];
                foreach ($zones as $zone) {
                    $typeZone = (string) ($zone['type_zone'] ?? 'zone_speciale');
                    $typeVisuel = 'special';
                    if ($typeZone === 'ville' || $typeZone === 'village') {
                        $typeVisuel = 'ville';
                    } elseif ($typeZone === 'port') {
                        $typeVisuel = 'ponton';
                    }
                    $x = (float) ($zone['colonne_origine'] ?? 0);
                    $y = (float) ($zone['ligne_origine'] ?? 0);
                    $nomZoneNormalise = mb_strtolower(trim((string) ($zone['nom_zone'] ?? '')), 'UTF-8');
                    if ($nomZoneNormalise === 'verdalis') { $x += 1; }
                    if ($nomZoneNormalise === 'aqualis') { $x += 1; $y += 1; }
                    if ($nomZoneNormalise === 'pyros' || str_contains($nomZoneNormalise, 'pyros')) { $y += 1; }
                    if ($nomZoneNormalise === 'port marchand de verdalis') { $x += 2; $y += 1; }
                    if ($nomZoneNormalise === 'village de pêcheurs' || $nomZoneNormalise === 'village de pecheurs') { $x += 1; $y += 1; }
                    $pointsInteret[] = [
                        'nom' => (string) ($zone['nom_zone'] ?? 'Lieu'),
                        'code' => (string) ($zone['code_zone'] ?? ''),
                        'type' => $typeVisuel,
                        'x' => $x,
                        'y' => $y,
                    ];
                    $zonesColoriees[] = [
                        'code' => (string) ($zone['code_zone'] ?? ''),
                        'nom' => (string) ($zone['nom_zone'] ?? 'Lieu'),
                        'type' => $typeVisuel,
                        'colonne' => (int) ($zone['colonne_origine'] ?? 0),
                        'ligne' => (int) ($zone['ligne_origine'] ?? 0),
                        'largeur' => max(1, (int) ($zone['largeur_cases'] ?? 1)),
                        'hauteur' => max(1, (int) ($zone['hauteur_cases'] ?? 1)),
                    ];
                }
                $requetePontons = $connexion_base->query("SELECT colonne, ligne FROM monde_cases WHERE est_ponton = 1 ORDER BY ligne ASC, colonne ASC");
                $pontons = $requetePontons ? $requetePontons->fetchAll(PDO::FETCH_ASSOC) : [];
                foreach ($pontons as $ponton) {
                    $xPonton = (int) ($ponton['colonne'] ?? 0);
                    $yPonton = (int) ($ponton['ligne'] ?? 0);
                    $dejaPresent = False;
                    foreach ($pointsInteret as $pointExistant) {
                        if (($pointExistant['type'] ?? '') !== 'ponton') { continue; }
                        if (abs(((float) ($pointExistant['x'] ?? 0)) - $xPonton) <= 1.0 && abs(((float) ($pointExistant['y'] ?? 0)) - $yPonton) <= 1.0) {
                            $dejaPresent = True;
                            break;
                        }
                    }
                    if (!$dejaPresent) {
                        $pointsInteret[] = [
                            'nom' => 'Ponton',
                            'code' => 'ponton_' . $xPonton . '_' . $yPonton,
                            'type' => 'ponton',
                            'x' => (float) $xPonton,
                            'y' => (float) $yPonton,
                        ];
                    }
                    $zonesColoriees[] = [
                        'code' => 'ponton_case_' . $xPonton . '_' . $yPonton,
                        'nom' => 'Ponton',
                        'type' => 'ponton',
                        'colonne' => $xPonton,
                        'ligne' => $yPonton,
                        'largeur' => 1,
                        'hauteur' => 1,
                    ];
                }
            }
            return [
                'image_carte' => 'ressources/images/carte/carte_du_monde.png',
                'largeur_monde' => $largeurMonde,
                'hauteur_monde' => $hauteurMonde,
                'colonnes' => $colonnes,
                'lignes' => $lignes,
                'position_joueur' => ['x' => $positionX, 'y' => $positionY, 'region' => $region],
                'legende' => [
                    ['code' => 'ville', 'libelle' => 'Ville ou capitale', 'couleur' => '#57c26f'],
                    ['code' => 'ponton', 'libelle' => 'Ponton ou accès naval', 'couleur' => '#4aa7d6'],
                    ['code' => 'special', 'libelle' => 'Lieu spécial', 'couleur' => '#8f6bd6'],
                    ['code' => 'repere', 'libelle' => 'Repère personnel', 'couleur' => '#e38bd3'],
                    ['code' => 'joueur', 'libelle' => 'Position du joueur', 'couleur' => '#f4f1d4']
                ],
                'points_interet' => $pointsInteret,
                'zones_colorees' => $zonesColoriees
            ];
        }

        public static function creerTablesNavigationSiNecessaire(): void
        {
            global $connexion_base;

            $connexion_base->exec(
                "CREATE TABLE IF NOT EXISTS personnage_reperes_carte (
                    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    personnage_id INT NOT NULL,
                    nom VARCHAR(120) NOT NULL,
                    position_x INT NOT NULL,
                    position_y INT NOT NULL,
                    est_actif TINYINT(1) NOT NULL DEFAULT 0,
                    est_selectionne TINYINT(1) NOT NULL DEFAULT 0,
                    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    INDEX idx_personnage_reperes_carte_personnage (personnage_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
            );

            $connexion_base->exec(
                "CREATE TABLE IF NOT EXISTS personnage_navigation (
                    personnage_id INT NOT NULL PRIMARY KEY,
                    type_destination VARCHAR(20) NOT NULL DEFAULT 'aucune',
                    quete_id INT NULL,
                    repere_id INT NULL,
                    date_mise_a_jour DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
            );
        }

        public static function listerReperesPersonnels(int $personnageId): array
        {
            global $connexion_base;

            self::creerTablesNavigationSiNecessaire();

            $sql = "SELECT id, nom, position_x, position_y, est_actif, est_selectionne
                    FROM personnage_reperes_carte
                    WHERE personnage_id = :personnage_id
                    ORDER BY id ASC";
            $requete = $connexion_base->prepare($sql);
            $requete->execute(['personnage_id' => $personnageId]);

            $resultats = $requete->fetchAll() ?: [];

            return array_map(function (array $repere): array {
                $estSelectionne = ((int) ($repere['est_selectionne'] ?? 0)) === 1;
                $estActif = ((int) ($repere['est_actif'] ?? 0)) === 1;

                return [
                    'id' => (int) $repere['id'],
                    'nom' => (string) $repere['nom'],
                    'x' => (int) $repere['position_x'],
                    'y' => (int) $repere['position_y'],
                    'actif' => $estSelectionne || $estActif,
                    'selectionne' => $estSelectionne || $estActif,
                ];
            }, $resultats);
        }

        public static function lireRepereSelectionneId(int $personnageId): int
        {
            $destination = self::lireDestinationActive($personnageId);
            return (int) ($destination['repere_id'] ?? 0);
        }

        public static function creerReperePersonnel(int $personnageId, string $nom, int $positionX, int $positionY): array
        {
            global $connexion_base;

            self::creerTablesNavigationSiNecessaire();
            $connexion_base->prepare("UPDATE personnage_reperes_carte SET est_actif = 0, est_selectionne = 0 WHERE personnage_id = :personnage_id")
                ->execute(['personnage_id' => $personnageId]);

            $sql = "INSERT INTO personnage_reperes_carte (personnage_id, nom, position_x, position_y, est_actif, est_selectionne)
                    VALUES (:personnage_id, :nom, :position_x, :position_y, 1, 1)";
            $requete = $connexion_base->prepare($sql);
            $requete->execute([
                'personnage_id' => $personnageId,
                'nom' => trim($nom) !== '' ? trim($nom) : ('Repère ' . $positionX . ' x ' . $positionY),
                'position_x' => max(0, min(39, $positionX)),
                'position_y' => max(0, min(26, $positionY)),
            ]);

            $repereId = (int) $connexion_base->lastInsertId();
            self::definirRepereActif($personnageId, $repereId);

            foreach (self::listerReperesPersonnels($personnageId) as $repere) {
                if ($repere['id'] === $repereId) {
                    return $repere;
                }
            }

            return [];
        }

        public static function supprimerReperePersonnel(int $personnageId, int $repereId): void
        {
            global $connexion_base;

            self::creerTablesNavigationSiNecessaire();

            $connexion_base->prepare(
                "DELETE FROM personnage_reperes_carte WHERE id = :id AND personnage_id = :personnage_id"
            )->execute([
                'id' => $repereId,
                'personnage_id' => $personnageId,
            ]);

            $connexion_base->prepare(
                "UPDATE personnage_navigation
                 SET repere_id = NULL,
                     type_destination = CASE
                         WHEN quete_id IS NOT NULL AND quete_id > 0 THEN 'quete'
                         ELSE 'aucune'
                     END
                 WHERE personnage_id = :personnage_id AND repere_id = :repere_id"
            )->execute([
                'personnage_id' => $personnageId,
                'repere_id' => $repereId,
            ]);
        }

        public static function definirRepereActif(int $personnageId, int $repereId): void
        {
            global $connexion_base;

            self::creerTablesNavigationSiNecessaire();

            $connexion_base->prepare(
                "UPDATE personnage_reperes_carte SET est_actif = 0, est_selectionne = 0 WHERE personnage_id = :personnage_id"
            )->execute(['personnage_id' => $personnageId]);

            $connexion_base->prepare(
                "UPDATE personnage_reperes_carte SET est_actif = 1, est_selectionne = 1 WHERE personnage_id = :personnage_id AND id = :id"
            )->execute([
                'personnage_id' => $personnageId,
                'id' => $repereId,
            ]);

            $sql = "INSERT INTO personnage_navigation (personnage_id, type_destination, repere_id, quete_id)
                    VALUES (:personnage_id, 'repere', :repere_id, NULL)
                    ON DUPLICATE KEY UPDATE
                        repere_id = VALUES(repere_id),
                        type_destination = CASE
                            WHEN quete_id IS NOT NULL AND quete_id > 0 THEN 'mixte'
                            ELSE 'repere'
                        END";
            $connexion_base->prepare($sql)->execute([
                'personnage_id' => $personnageId,
                'repere_id' => $repereId,
            ]);
        }

        public static function lireDestinationActive(int $personnageId): array
        {
            global $connexion_base;

            self::creerTablesNavigationSiNecessaire();

            $sql = "SELECT type_destination, quete_id, repere_id
                    FROM personnage_navigation
                    WHERE personnage_id = :personnage_id
                    LIMIT 1";
            $requete = $connexion_base->prepare($sql);
            $requete->execute(['personnage_id' => $personnageId]);
            $navigation = $requete->fetch() ?: [];

            $queteId = (int) ($navigation['quete_id'] ?? 0);
            $repereId = (int) ($navigation['repere_id'] ?? 0);
            $type = 'aucune';

            if ($queteId > 0 && $repereId > 0) {
                $type = 'mixte';
            } elseif ($queteId > 0) {
                $type = 'quete';
            } elseif ($repereId > 0) {
                $type = 'repere';
            }

            return [
                'type' => $type,
                'quete_id' => $queteId,
                'repere_id' => $repereId,
            ];
        }

        public static function effacerDestinationActive(int $personnageId): void
        {
            global $connexion_base;

            self::creerTablesNavigationSiNecessaire();

            $connexion_base->prepare(
                "INSERT INTO personnage_navigation (personnage_id, type_destination, quete_id, repere_id)
                 VALUES (:personnage_id, 'aucune', NULL, NULL)
                 ON DUPLICATE KEY UPDATE type_destination = 'aucune', quete_id = NULL, repere_id = NULL"
            )->execute(['personnage_id' => $personnageId]);

            $connexion_base->prepare(
                "UPDATE personnage_reperes_carte SET est_actif = 0, est_selectionne = 0 WHERE personnage_id = :personnage_id"
            )->execute(['personnage_id' => $personnageId]);
        }

        public static function effacerQueteSuivie(int $personnageId): void
        {
            global $connexion_base;

            self::creerTablesNavigationSiNecessaire();

            $connexion_base->prepare(
                "INSERT INTO personnage_navigation (personnage_id, type_destination, quete_id, repere_id)
                 VALUES (:personnage_id, 'aucune', NULL, NULL)
                 ON DUPLICATE KEY UPDATE
                    quete_id = NULL,
                    type_destination = CASE
                        WHEN repere_id IS NOT NULL AND repere_id > 0 THEN 'repere'
                        ELSE 'aucune'
                    END"
            )->execute(['personnage_id' => $personnageId]);
        }

        public static function effacerRepereActif(int $personnageId): void
        {
            global $connexion_base;

            self::creerTablesNavigationSiNecessaire();

            $connexion_base->prepare(
                "UPDATE personnage_reperes_carte SET est_actif = 0, est_selectionne = 0 WHERE personnage_id = :personnage_id"
            )->execute(['personnage_id' => $personnageId]);

            $connexion_base->prepare(
                "INSERT INTO personnage_navigation (personnage_id, type_destination, quete_id, repere_id)
                 VALUES (:personnage_id, 'aucune', NULL, NULL)
                 ON DUPLICATE KEY UPDATE
                    repere_id = NULL,
                    type_destination = CASE
                        WHEN quete_id IS NOT NULL AND quete_id > 0 THEN 'quete'
                        ELSE 'aucune'
                    END"
            )->execute(['personnage_id' => $personnageId]);
        }

        public static function trouverPointInteretParTexte(string $texte): ?array
        {
            $texteNormalise = self::normaliserTexte($texte);

            if ($texteNormalise === '') {
                return null;
            }

            $carte = self::chargerDonneesFenetre([]);
            $points = $carte['points_interet'] ?? [];

            foreach ($points as $point) {
                $nomPoint = self::normaliserTexte((string) ($point['nom'] ?? ''));
                if ($nomPoint !== '' && str_contains($texteNormalise, $nomPoint)) {
                    return [
                        'nom' => (string) ($point['nom'] ?? 'Lieu'),
                        'x' => (int) round((float) ($point['x'] ?? 0)),
                        'y' => (int) round((float) ($point['y'] ?? 0)),
                        'type' => (string) ($point['type'] ?? 'special'),
                    ];
                }
            }

            return null;
        }

        private static function normaliserTexte(string $texte): string
        {
            $texte = mb_strtolower(trim($texte), 'UTF-8');
            $texte = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $texte) ?: $texte;
            $texte = preg_replace('/[^a-z0-9 ]+/', ' ', $texte) ?: '';
            $texte = preg_replace('/\s+/', ' ', $texte) ?: '';
            return trim($texte);
        }

    }
}
?>