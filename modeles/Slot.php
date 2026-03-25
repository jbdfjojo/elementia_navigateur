<?php
// ---------------------------------------------------------
// MODÈLE SLOT
// ---------------------------------------------------------
declare(strict_types=1);

if (!class_exists('Slot')) {
    class Slot
    {
        // -------------------------------------------------
        // Connexion PDO partagée
        // -------------------------------------------------
        private PDO $connexion_base;

        // -------------------------------------------------
        // Constructeur
        // -------------------------------------------------
        public function __construct(PDO $connexion_base)
        {
            // ---------------------------------------------
            // On stocke la connexion reçue
            // ---------------------------------------------
            $this->connexion_base = $connexion_base;
        }

        // -------------------------------------------------
        // Liste tous les slots actifs d'équipement
        // -------------------------------------------------
        public function listerSlotsEquipementActifs(): array
        {
            // ---------------------------------------------
            // Requête SQL sur le catalogue des slots
            // ---------------------------------------------
            $requete = $this->connexion_base->query(
                'SELECT *
                 FROM catalogue_slots_equipement
                 WHERE groupe_slot = "equipement_personnage"
                   AND est_actif = 1
                 ORDER BY ordre_affichage ASC, id ASC'
            );

            // ---------------------------------------------
            // Retour des lignes
            // ---------------------------------------------
            return $requete->fetchAll();
        }

        // -------------------------------------------------
        // Retourne un slot par son code métier
        // -------------------------------------------------
        public function chargerSlotParCode(string $code_slot): ?array
        {
            // ---------------------------------------------
            // Préparation de la requête
            // ---------------------------------------------
            $requete = $this->connexion_base->prepare(
                'SELECT *
                 FROM catalogue_slots_equipement
                 WHERE code_slot = :code_slot
                   AND est_actif = 1
                 LIMIT 1'
            );

            // ---------------------------------------------
            // Exécution de la requête
            // ---------------------------------------------
            $requete->execute([
                'code_slot' => $code_slot,
            ]);

            // ---------------------------------------------
            // Lecture du résultat
            // ---------------------------------------------
            $resultat = $requete->fetch();

            // ---------------------------------------------
            // Si aucune ligne n'est trouvée
            // ---------------------------------------------
            if ($resultat === false) {
                return null;
            }

            // ---------------------------------------------
            // Retour du slot
            // ---------------------------------------------
            return $resultat;
        }
    }
}
