<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

require_once __DIR__ . '/configuration/base_de_donnees.php';
require_once __DIR__ . '/coeur/Routeur.php';

Routeur::gerer($connexion_base);