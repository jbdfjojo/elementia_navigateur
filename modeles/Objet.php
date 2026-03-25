<?php
// ======================================================
// MODELE OBJET
// ======================================================

require_once __DIR__ . '/../configuration/base_de_donnees.php';

class Objet
{
    // --------------------------------------------------
    // Charger objet catalogue
    // --------------------------------------------------
    public static function charger(int $objetId)
    {
        global $connexion_base;

        $sql = "
            SELECT *
            FROM catalogue_objets
            WHERE id = :id
        ";

        $requete = $connexion_base->prepare($sql);

        $requete->execute([
            'id' => $objetId
        ]);

        return $requete->fetch();
    }
}
