<?php
// ---------------------------------------------------------
// MODÈLE DES COMPÉTENCES DU PERSONNAGE
// ---------------------------------------------------------
declare(strict_types=1);

require_once __DIR__ . '/../configuration/base_de_donnees.php';

if (!class_exists('Competence')) {
    class Competence
    {
        // -------------------------------------------------
        // Retourne la liste complète des compétences d’un
        // personnage avec un maximum d’informations.
        // -------------------------------------------------
        public static function chargerCompetencesPersonnage(int $personnageId): array
        {
            global $connexion_base;

            if (!($connexion_base instanceof PDO)) {
                return [];
            }

            if (self::tableExiste($connexion_base, 'personnage_competences_progression')) {
                return self::chargerDepuisProgression($connexion_base, $personnageId);
            }

            if (self::tableExiste($connexion_base, 'personnage_competences')) {
                return self::chargerDepuisAncienneTable($connexion_base, $personnageId);
            }

            return [];
        }

        // -------------------------------------------------
        // Charge les compétences depuis la table moderne.
        // Cette version vérifie les colonnes réelles avant
        // de construire la requête pour éviter les erreurs
        // SQL quand la base n’a pas encore tous les champs.
        // -------------------------------------------------
        private static function chargerDepuisProgression(PDO $connexionBase, int $personnageId): array
        {
            $jointureCataloguePossible = self::tableExiste($connexionBase, 'catalogue_competences');

            // ---------------------------------------------
            // Colonnes garanties côté progression.
            // ---------------------------------------------
            $select = [
                'pcp.code_competence',
                'pcp.niveau_sort',
                'pcp.niveau_max_actuel',
                'pcp.est_ultime',
                'pcp.xp_actuelle',
                'pcp.xp_suivante',
                'pcp.est_equipee',
                'pcp.ordre_slot'
            ];

            // ---------------------------------------------
            // Si le catalogue existe, on ne lit que les
            // colonnes qui existent vraiment en base.
            // ---------------------------------------------
            if ($jointureCataloguePossible) {
                $colonnesCatalogue = self::obtenirColonnesTable($connexionBase, 'catalogue_competences');

                $select[] = self::expressionColonneCatalogue($colonnesCatalogue, 'nom', 'cc.nom', 'pcp.code_competence') . ' AS nom';
                $select[] = self::expressionColonneCatalogue($colonnesCatalogue, 'resume', 'cc.resume', "''") . ' AS resume';

                if (isset($colonnesCatalogue['description_detaillee'])) {
                    $select[] = 'COALESCE(cc.description_detaillee, cc.resume, \'\') AS description_detaillee';
                } else {
                    $select[] = self::expressionColonneCatalogue($colonnesCatalogue, 'resume', 'cc.resume', "''") . ' AS description_detaillee';
                }

                if (isset($colonnesCatalogue['famille_competence'])) {
                    $select[] = "COALESCE(cc.famille_competence, CASE WHEN pcp.niveau_max_actuel <= 10 THEN 'neutre' ELSE 'elementaire' END) AS famille_competence";
                } else {
                    $select[] = "CASE WHEN pcp.niveau_max_actuel <= 10 THEN 'neutre' ELSE 'elementaire' END AS famille_competence";
                }

                $select[] = self::expressionColonneCatalogue($colonnesCatalogue, 'element', 'cc.element', "'Neutre'") . ' AS element';
                $select[] = self::expressionColonneCatalogue($colonnesCatalogue, 'classe', 'cc.classe', "''") . ' AS classe';
                $select[] = self::expressionColonneCatalogue($colonnesCatalogue, 'ressource_utilisee', 'cc.ressource_utilisee', "'PM'") . ' AS ressource_utilisee';
                $select[] = self::expressionColonneCatalogue($colonnesCatalogue, 'cout_utilisation', 'cc.cout_utilisation', '0') . ' AS cout_utilisation';
                $select[] = self::expressionColonneCatalogue($colonnesCatalogue, 'portee', 'cc.portee', "'Variable'") . ' AS portee';
                $select[] = self::expressionColonneCatalogue($colonnesCatalogue, 'type_cible', 'cc.type_cible', "'Cible unique'") . ' AS type_cible';
                $select[] = self::expressionColonneCatalogue($colonnesCatalogue, 'valeur_base', 'cc.valeur_base', '0') . ' AS valeur_base';
                $select[] = self::expressionColonneCatalogue($colonnesCatalogue, 'formule_effet', 'cc.formule_effet', "''") . ' AS formule_effet';
                $select[] = self::expressionColonneCatalogue($colonnesCatalogue, 'declencheur_progression', 'cc.declencheur_progression', "''") . ' AS declencheur_progression';

                if (isset($colonnesCatalogue['niveau_max_naturel'])) {
                    $select[] = 'COALESCE(cc.niveau_max_naturel, pcp.niveau_max_actuel) AS niveau_max_naturel';
                } else {
                    $select[] = 'pcp.niveau_max_actuel AS niveau_max_naturel';
                }

                $sql = 'SELECT ' . implode(",\n                            ", $select) . "
                        FROM personnage_competences_progression pcp
                        LEFT JOIN catalogue_competences cc ON cc.code_competence = pcp.code_competence
                        WHERE pcp.personnage_id = :personnage_id
                        ORDER BY pcp.ordre_slot ASC, pcp.code_competence ASC";
            } else {
                $select[] = 'pcp.code_competence AS nom';
                $select[] = "'' AS resume";
                $select[] = "'' AS description_detaillee";
                $select[] = "CASE WHEN pcp.niveau_max_actuel <= 10 THEN 'neutre' ELSE 'elementaire' END AS famille_competence";
                $select[] = "'Neutre' AS element";
                $select[] = "'' AS classe";
                $select[] = "'PM' AS ressource_utilisee";
                $select[] = '0 AS cout_utilisation';
                $select[] = "'Variable' AS portee";
                $select[] = "'Cible unique' AS type_cible";
                $select[] = '0 AS valeur_base';
                $select[] = "'' AS formule_effet";
                $select[] = "'' AS declencheur_progression";
                $select[] = 'pcp.niveau_max_actuel AS niveau_max_naturel';

                $sql = 'SELECT ' . implode(",\n                            ", $select) . "
                        FROM personnage_competences_progression pcp
                        WHERE pcp.personnage_id = :personnage_id
                        ORDER BY pcp.ordre_slot ASC, pcp.code_competence ASC";
            }

            $requete = $connexionBase->prepare($sql);
            $requete->execute(['personnage_id' => $personnageId]);
            $competences = $requete->fetchAll(PDO::FETCH_ASSOC) ?: [];

            foreach ($competences as &$competence) {
                $competence = self::normaliserCompetence($competence);
            }

            return $competences;
        }

        // -------------------------------------------------
        // Charge les compétences depuis l’ancienne table.
        // -------------------------------------------------
        private static function chargerDepuisAncienneTable(PDO $connexionBase, int $personnageId): array
        {
            $requete = $connexionBase->prepare(
                'SELECT id, nom_competence, type_competence, ordre_affichage
                 FROM personnage_competences
                 WHERE personnage_id = :personnage_id
                 ORDER BY ordre_affichage ASC, id ASC'
            );

            $requete->execute(['personnage_id' => $personnageId]);
            $lignes = $requete->fetchAll(PDO::FETCH_ASSOC) ?: [];
            $competences = [];

            foreach ($lignes as $index => $ligne) {
                $famille = ((string) ($ligne['type_competence'] ?? 'neutre')) === 'elementaire' ? 'elementaire' : 'neutre';
                $competences[] = self::normaliserCompetence([
                    'code_competence' => 'ancienne_' . (int) ($ligne['id'] ?? ($index + 1)),
                    'nom' => (string) ($ligne['nom_competence'] ?? 'Compétence'),
                    'resume' => $famille === 'elementaire'
                        ? 'Compétence élémentaire déjà choisie par votre personnage.'
                        : 'Compétence neutre déjà choisie par votre personnage.',
                    'description_detaillee' => $famille === 'elementaire'
                        ? 'Cette compétence fait partie du noyau de départ de votre personnage. Elle pourra ensuite évoluer avec le niveau du sort, vos statistiques et les futures règles de combat.'
                        : 'Cette compétence neutre accompagne la progression globale de votre personnage et pourra évoluer avec vos actions futures.',
                    'famille_competence' => $famille,
                    'element' => $famille === 'elementaire' ? 'Élément du personnage' : 'Neutre',
                    'classe' => '',
                    'ressource_utilisee' => 'PM',
                    'cout_utilisation' => $famille === 'elementaire' ? 8 : 4,
                    'portee' => $famille === 'elementaire' ? '1 à 4 cases' : 'Personnel',
                    'type_cible' => $famille === 'elementaire' ? 'Cible unique' : 'Soi-même',
                    'valeur_base' => $famille === 'elementaire' ? 12 : 0,
                    'formule_effet' => $famille === 'elementaire'
                        ? 'Puissance de base évolutive selon la magie ou l’attaque.'
                        : 'Effet utilitaire évolutif selon le niveau du sort.',
                    'declencheur_progression' => $famille === 'neutre' ? 'Évolue selon vos actions.' : '',
                    'niveau_sort' => 1,
                    'niveau_max_actuel' => $famille === 'elementaire' ? 20 : 10,
                    'niveau_max_naturel' => $famille === 'elementaire' ? 20 : 10,
                    'est_ultime' => 0,
                    'xp_actuelle' => 0,
                    'xp_suivante' => 100,
                    'est_equipee' => 1,
                    'ordre_slot' => (int) ($ligne['ordre_affichage'] ?? ($index + 1))
                ]);
            }

            return $competences;
        }

        // -------------------------------------------------
        // Uniformise une compétence pour la vue.
        // -------------------------------------------------
        private static function normaliserCompetence(array $competence): array
        {
            $famille = (string) ($competence['famille_competence'] ?? 'neutre');
            $niveauSort = max(1, (int) ($competence['niveau_sort'] ?? 1));
            $niveauMaxActuel = max($niveauSort, (int) ($competence['niveau_max_actuel'] ?? ($famille === 'elementaire' ? 20 : 10)));
            $xpActuelle = max(0, (int) ($competence['xp_actuelle'] ?? 0));
            $xpSuivante = max(1, (int) ($competence['xp_suivante'] ?? 100));
            $pourcentageXp = (int) min(100, floor(($xpActuelle / $xpSuivante) * 100));

            return [
                'code_competence' => (string) ($competence['code_competence'] ?? ''),
                'nom' => (string) ($competence['nom'] ?? 'Compétence inconnue'),
                'resume' => (string) ($competence['resume'] ?? ''),
                'description_detaillee' => (string) ($competence['description_detaillee'] ?? ''),
                'famille_competence' => $famille,
                'element' => (string) ($competence['element'] ?? 'Neutre'),
                'classe' => (string) ($competence['classe'] ?? ''),
                'ressource_utilisee' => (string) ($competence['ressource_utilisee'] ?? 'PM'),
                'cout_utilisation' => (int) ($competence['cout_utilisation'] ?? 0),
                'portee' => (string) ($competence['portee'] ?? 'Variable'),
                'type_cible' => (string) ($competence['type_cible'] ?? 'Cible unique'),
                'valeur_base' => (int) ($competence['valeur_base'] ?? 0),
                'formule_effet' => (string) ($competence['formule_effet'] ?? ''),
                'declencheur_progression' => (string) ($competence['declencheur_progression'] ?? ''),
                'niveau_sort' => $niveauSort,
                'niveau_max_actuel' => $niveauMaxActuel,
                'niveau_max_naturel' => max($niveauMaxActuel, (int) ($competence['niveau_max_naturel'] ?? $niveauMaxActuel)),
                'est_ultime' => (int) ($competence['est_ultime'] ?? 0),
                'xp_actuelle' => $xpActuelle,
                'xp_suivante' => $xpSuivante,
                'pourcentage_xp' => $pourcentageXp,
                'est_equipee' => (int) ($competence['est_equipee'] ?? 1),
                'ordre_slot' => max(1, (int) ($competence['ordre_slot'] ?? 1))
            ];
        }

        // -------------------------------------------------
        // Retourne les colonnes réelles d’une table.
        // -------------------------------------------------
        private static function obtenirColonnesTable(PDO $connexionBase, string $nomTable): array
        {
            $requete = $connexionBase->prepare(
                'SELECT COLUMN_NAME
                 FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = :table_nom'
            );

            $requete->execute(['table_nom' => $nomTable]);
            $lignes = $requete->fetchAll(PDO::FETCH_COLUMN) ?: [];
            $colonnes = [];

            foreach ($lignes as $nomColonne) {
                $colonnes[(string) $nomColonne] = true;
            }

            return $colonnes;
        }

        // -------------------------------------------------
        // Construit une expression SQL sûre pour une colonne
        // du catalogue si elle existe réellement.
        // -------------------------------------------------
        private static function expressionColonneCatalogue(array $colonnesCatalogue, string $nomColonne, string $expressionColonne, string $expressionDefaut): string
        {
            if (isset($colonnesCatalogue[$nomColonne])) {
                return 'COALESCE(' . $expressionColonne . ', ' . $expressionDefaut . ')';
            }

            return $expressionDefaut;
        }

        // -------------------------------------------------
        // Vérifie l’existence d’une table.
        // -------------------------------------------------
        private static function tableExiste(PDO $connexionBase, string $nomTable): bool
        {
            $requete = $connexionBase->prepare('SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table_nom LIMIT 1');
            $requete->execute(['table_nom' => $nomTable]);
            return (bool) $requete->fetchColumn();
        }
    }
}
