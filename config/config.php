<?php
// Paramètres de l'application.
// C'est le SEUL fichier à modifier pour changer de base ou de serveur.
// On les lit ailleurs avec l'opérateur :: , par exemple Config::DB_NAME

class Config
{
    const DB_HOST    = 'localhost';
    const DB_NAME    = 'magasin2';
    const DB_USER    = 'root';
    const DB_PASS    = '';
    const DB_CHARSET = 'utf8mb4';
}
