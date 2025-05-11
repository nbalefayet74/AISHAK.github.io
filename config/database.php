<?php
/**
 *  config/database.php
 *  -------------------------------------------------------------
 *  Fournit une connexion PDO unique (pattern Singleton)
 *  et une fonction globale db() pour y accéder facilement.
 *  -------------------------------------------------------------
 */

declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;

// ▸ Charge les constantes DB_HOST, DB_NAME, DB_USER, DB_PASS
require_once __DIR__ . '/config.php';

class Database
{
    /** @var ?PDO  Instance unique (lazy-loaded) */
    private static ?PDO $pdo = null;

    /**
     * Retourne la connexion PDO (créée au premier appel).
     */
    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                DB_HOST,
                DB_NAME
            );

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                // Activez la ligne suivante si vous voulez du "persistent connection"
                // PDO::ATTR_PERSISTENT         => true,
            ];

            try {
                self::$pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                // En mode debug, on relance l’exception
                if (defined('APP_DEBUG') && APP_DEBUG === true) {
                    throw $e;
                }
                // Sinon, on loggue et on affiche un message générique
                error_log('[DB] Connexion impossible : ' . $e->getMessage());
                http_response_code(500);
                exit('Internal Server Error');
            }
        }

        return self::$pdo;
    }

    /** Constructeur/clone/wakeup privés : Singleton "pur" */
    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}
}

/**
 *  Helper global : db() → PDO
 *
 *  Exemple :
 *      $stmt = db()->prepare('SELECT * FROM users WHERE id = ?');
 *      $stmt->execute([$id]);
 *      $user = $stmt->fetch();
 */
function db(): PDO
{
    return Database::getConnection();
}
