<?php
declare(strict_types=1);
if (!class_exists('Equipement')) {
class Equipement
{
    private PDO $connexion_base;
    public function __construct(PDO $connexion_base) { $this->connexion_base = $connexion_base; }

    public function listerEquipementPersonnage(int $personnage_id): array
    {
        $requete = $this->connexion_base->prepare('SELECT ep.id AS equipement_id, ep.personnage_id, ep.catalogue_slot_id, ep.instance_objet_id,
            cse.code_slot, cse.nom_slot, cse.icone_slot_vide, cse.position_x_interface, cse.position_y_interface, cse.largeur_interface, cse.hauteur_interface,
            co.id AS catalogue_objet_id, co.code_objet, co.nom_objet, co.description_objet, co.type_objet, co.categorie_objet, co.rarete_objet, co.icone_objet,
            co.mode_maniement, co.code_groupe_slots_lies,
            co.bonus_point_de_vie, co.bonus_attaque, co.bonus_magie, co.bonus_agilite, co.bonus_intelligence, co.bonus_synchronisation_elementaire,
            co.bonus_critique, co.bonus_dexterite, co.bonus_defense, co.poids_unitaire, io.quantite, io.durabilite_actuelle, io.durabilite_maximum
            FROM equipements_personnage ep
            INNER JOIN catalogue_slots_equipement cse ON cse.id = ep.catalogue_slot_id
            INNER JOIN instances_objets io ON io.id = ep.instance_objet_id
            INNER JOIN catalogue_objets co ON co.id = io.catalogue_objet_id
            WHERE ep.personnage_id = :personnage_id ORDER BY cse.ordre_affichage ASC');
        $requete->execute(['personnage_id' => $personnage_id]);
        return $requete->fetchAll() ?: [];
    }

    public function verifierProprieteInstance(int $personnage_id, int $instance_objet_id): bool
    {
        $requete = $this->connexion_base->prepare('SELECT id FROM instances_objets WHERE id = :instance_objet_id AND personnage_proprietaire_id = :personnage_id LIMIT 1');
        $requete->execute(['instance_objet_id' => $instance_objet_id, 'personnage_id' => $personnage_id]);
        return (bool) $requete->fetch();
    }

    public function instanceDejaEquipee(int $instance_objet_id): bool
    {
        $requete = $this->connexion_base->prepare('SELECT id FROM equipements_personnage WHERE instance_objet_id = :instance_objet_id LIMIT 1');
        $requete->execute(['instance_objet_id' => $instance_objet_id]);
        return (bool) $requete->fetch();
    }

    public function desequiperInstance(int $personnage_id, int $instance_objet_id): bool
    {
        $requete = $this->connexion_base->prepare('DELETE FROM equipements_personnage WHERE personnage_id = :personnage_id AND instance_objet_id = :instance_objet_id');
        return $requete->execute(['personnage_id' => $personnage_id, 'instance_objet_id' => $instance_objet_id]);
    }

    public function equiperInstanceDansSlots(int $personnage_id, array $catalogue_slot_ids, int $instance_objet_id): bool
    {
        if (empty($catalogue_slot_ids)) {
            return false;
        }

        $requete = $this->connexion_base->prepare('INSERT INTO equipements_personnage (personnage_id, catalogue_slot_id, instance_objet_id)
            VALUES (:personnage_id, :catalogue_slot_id, :instance_objet_id)
            ON DUPLICATE KEY UPDATE instance_objet_id = VALUES(instance_objet_id), date_mise_a_jour = CURRENT_TIMESTAMP');

        foreach ($catalogue_slot_ids as $catalogue_slot_id) {
            $requete->execute([
                'personnage_id' => $personnage_id,
                'catalogue_slot_id' => (int) $catalogue_slot_id,
                'instance_objet_id' => $instance_objet_id,
            ]);
        }

        return true;
    }

    public function determinerSlotsCiblesPourInstance(int $personnage_id, int $instance_objet_id, string $slot_cible = ''): array
    {
        $objet = $this->chargerDefinitionObjet($personnage_id, $instance_objet_id);
        if (!$objet) {
            return [];
        }

        $slotsAutorises = $this->listerSlotsCompatiblesPourInstance($personnage_id, $instance_objet_id);
        if (empty($slotsAutorises)) {
            return [];
        }

        $parCode = [];
        $premierPrincipal = null;
        foreach ($slotsAutorises as $slot) {
            $parCode[(string) $slot['code_slot']] = $slot;
            if ($premierPrincipal === null && (int) ($slot['est_slot_principal'] ?? 0) === 1) {
                $premierPrincipal = $slot;
            }
        }

        $mode = (string) ($objet['mode_maniement'] ?? 'aucun');

        if ($mode === 'deux_mains') {
            return $this->extraireIdsDepuisSlots([
                $parCode['main_gauche'] ?? null,
                $parCode['main_droite'] ?? null,
            ]);
        }

        if ($mode === 'double_slot_lie') {
            return $this->extraireIdsDepuisSlots($slotsAutorises);
        }

        if ($mode === 'une_main_droite') {
            return $this->extraireIdsDepuisSlots([
                $parCode['main_droite'] ?? $premierPrincipal ?? ($slotsAutorises[0] ?? null)
            ]);
        }

        if ($mode === 'une_main_gauche') {
            return $this->extraireIdsDepuisSlots([
                $parCode['main_gauche'] ?? $premierPrincipal ?? ($slotsAutorises[0] ?? null)
            ]);
        }

        if ($slot_cible !== '') {
            foreach ($slotsAutorises as $slot) {
                if ((string) $slot['code_slot'] === $slot_cible) {
                    return [(int) $slot['id']];
                }
            }
        }

        if ($premierPrincipal) {
            return [(int) $premierPrincipal['id']];
        }

        return [(int) $slotsAutorises[0]['id']];
    }

    public function listerSlotsCompatiblesPourInstance(int $personnage_id, int $instance_objet_id): array
    {
        $requete = $this->connexion_base->prepare('SELECT cse.*, cosa.est_slot_principal
            FROM instances_objets io
            INNER JOIN catalogue_objets co ON co.id = io.catalogue_objet_id
            INNER JOIN catalogue_objets_slots_autorises cosa ON cosa.catalogue_objet_id = co.id
            INNER JOIN catalogue_slots_equipement cse ON cse.id = cosa.catalogue_slot_id
            WHERE io.id = :instance_objet_id
              AND io.personnage_proprietaire_id = :personnage_id
              AND cse.groupe_slot = "equipement_personnage"
            ORDER BY cosa.est_slot_principal DESC, cse.ordre_affichage ASC');
        $requete->execute(['personnage_id' => $personnage_id, 'instance_objet_id' => $instance_objet_id]);
        return $requete->fetchAll() ?: [];
    }

    public function listerEquipementsDansSlots(int $personnage_id, array $catalogue_slot_ids): array
    {
        if (empty($catalogue_slot_ids)) {
            return [];
        }

        $marqueurs = implode(', ', array_fill(0, count($catalogue_slot_ids), '?'));
        $sql = 'SELECT * FROM equipements_personnage WHERE personnage_id = ? AND catalogue_slot_id IN (' . $marqueurs . ')';
        $requete = $this->connexion_base->prepare($sql);
        $parametres = array_merge([$personnage_id], array_map('intval', $catalogue_slot_ids));
        $requete->execute($parametres);
        return $requete->fetchAll() ?: [];
    }

    public function slotsSontLibres(int $personnage_id, array $catalogue_slot_ids): bool
    {
        return count($this->listerEquipementsDansSlots($personnage_id, $catalogue_slot_ids)) === 0;
    }

    public function trouverEquipementDansSlot(int $personnage_id, int $catalogue_slot_id): ?array
    {
        $requete = $this->connexion_base->prepare('SELECT ep.* FROM equipements_personnage ep WHERE ep.personnage_id = :personnage_id AND ep.catalogue_slot_id = :catalogue_slot_id LIMIT 1');
        $requete->execute(['personnage_id' => $personnage_id, 'catalogue_slot_id' => $catalogue_slot_id]);
        $resultat = $requete->fetch();
        return $resultat ?: null;
    }

    public function trouverSlotLibreCompatible(int $personnage_id, int $instance_objet_id): ?array
    {
        $ids = $this->determinerSlotsCiblesPourInstance($personnage_id, $instance_objet_id);
        if (empty($ids) || !$this->slotsSontLibres($personnage_id, $ids)) {
            return null;
        }

        $requete = $this->connexion_base->prepare('SELECT * FROM catalogue_slots_equipement WHERE id = :id LIMIT 1');
        $requete->execute(['id' => (int) $ids[0]]);
        $slot = $requete->fetch();
        return $slot ?: null;
    }

    public function trouverPremierSlotCompatible(int $personnage_id, int $instance_objet_id): ?array
    {
        $ids = $this->determinerSlotsCiblesPourInstance($personnage_id, $instance_objet_id);
        if (empty($ids)) {
            return null;
        }

        $requete = $this->connexion_base->prepare('SELECT * FROM catalogue_slots_equipement WHERE id = :id LIMIT 1');
        $requete->execute(['id' => (int) $ids[0]]);
        $slot = $requete->fetch();
        return $slot ?: null;
    }

    public function trouverSlotCompatiblePourCible(int $personnage_id, int $instance_objet_id, string $slot_cible): ?array
    {
        $ids = $this->determinerSlotsCiblesPourInstance($personnage_id, $instance_objet_id, $slot_cible);
        if (empty($ids)) {
            return null;
        }

        $requete = $this->connexion_base->prepare('SELECT * FROM catalogue_slots_equipement WHERE id = :id LIMIT 1');
        $requete->execute(['id' => (int) $ids[0]]);
        $slot = $requete->fetch();
        return $slot ?: null;
    }

    private function chargerDefinitionObjet(int $personnage_id, int $instance_objet_id): ?array
    {
        $requete = $this->connexion_base->prepare('SELECT co.id, co.code_objet, co.categorie_objet, co.mode_maniement, co.code_groupe_slots_lies
            FROM instances_objets io
            INNER JOIN catalogue_objets co ON co.id = io.catalogue_objet_id
            WHERE io.id = :instance_objet_id AND io.personnage_proprietaire_id = :personnage_id LIMIT 1');
        $requete->execute(['instance_objet_id' => $instance_objet_id, 'personnage_id' => $personnage_id]);
        $objet = $requete->fetch();
        return $objet ?: null;
    }

    private function extraireIdsDepuisSlots(array $slots): array
    {
        $ids = [];
        foreach ($slots as $slot) {
            if ($slot && isset($slot['id'])) {
                $ids[] = (int) $slot['id'];
            }
        }
        return array_values(array_unique($ids));
    }
}
}
