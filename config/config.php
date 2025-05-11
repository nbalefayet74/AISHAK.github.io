<?php
/*-----------------------------------------------------------------
 |  Fichier central de configuration
 |  Placez ici tout ce qui doit être partagé par vos scripts PHP.
 *----------------------------------------------------------------*/

session_start();                     // démarrage (ou reprise) de session

// (1) Variables d’environnement : plus sûr que de mettre les identifiants en clair
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'aishak');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: 'secret');

try {
    // (2) Connexion PDO avec gestion UTF-8 et exceptions
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    // En production, logguez plutôt l’erreur dans un fichier hors web-root
    exit('Erreur de connexion : ' . $e->getMessage());
}
?>
