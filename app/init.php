<?php
// Fichier d'initialisation, inclus en premier par chaque page de public/.

// Chemins relatifs : ils s'écrivent à partir du dossier public/ (celui de la page exécutée).
// C'est pourquoi on écrit '../app/Database.php', même si ce fichier est dans le même dossier qu'init.php.

// 1. Paramètres (classe Config) : chargés en premier, Database en a besoin
require_once '../config/config.php';

// 2. Classes de l'application
//    L'ordre compte : Model utilise Database, et les classes filles héritent de Model.
require_once '../app/Database.php';
require_once '../app/Models/Model.php';
require_once '../app/Models/ProduitModel.php';
require_once '../app/Models/CategorieModel.php';

// 3. Fonctions utilitaires

// Redirige vers une autre page et arrête le script
function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}
