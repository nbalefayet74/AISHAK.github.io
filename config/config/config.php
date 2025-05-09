<?php
// Charge .env : composer require vlucas/phpdotenv
require_once dirname(__DIR__).'/vendor/autoload.php';
Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();

// Démarre la session le plus tôt possible
session_start([
    'cookie_httponly' => true,
    'cookie_secure'   => isset($_SERVER['HTTPS']),
    'cookie_samesite' => 'Strict',
]);

try {
    $pdo = new PDO(
        $_ENV['DB_DSN'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]
    );
} catch (PDOException $e) {
    // Ne jamais afficher l’erreur brute ; loguez-la seulement
    error_log($e->getMessage());
    http_response_code(500);
    exit('Erreur interne');
}
