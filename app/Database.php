<?php

/**
 * Connexion à la base de données (pattern Singleton).
 * Une seule connexion PDO est créée pendant toute l'exécution de la page.
 */
class Database
{
    // Stocke l'unique instance de la classe (non initialisé au départ)
    private static Database $instance;

    private PDO $pdo;

    // Constructeur privé : impossible de faire "new Database()" depuis l'extérieur
    private function __construct()
    {
        // Les paramètres viennent de la classe Config (config/config.php)
        $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME
            . ';charset=' . Config::DB_CHARSET;

        $this->pdo = new PDO($dsn, Config::DB_USER, Config::DB_PASS);
        // Une erreur SQL lève une PDOException (capturée par try / catch)
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Les lignes sont lues sous forme de tableaux associatifs : $p['designation']
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    // Empêche la copie de l'instance
    private function __clone() {}

    // Crée l'instance au premier appel, puis renvoie toujours la même
    public static function getInstance(): Database
    {
        if (!isset(self::$instance)) {   // pas encore créée ?
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
