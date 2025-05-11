<?php
/**
 *  config/app.php
 *  ------------------------------------------------------------------
 *  Réglages généraux de l’application.
 *  Chargeable très tôt (avant database.php, routes.php, etc.).
 *  ------------------------------------------------------------------
 */

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| 1. Nom de l’application
|--------------------------------------------------------------------------
|
| Utilisé pour les titres de page, les e-mails, les logs…
| Vous pouvez le surcharger depuis une variable d’environnement.
|
*/
define('APP_NAME', getenv('APP_NAME') ?: 'AISHAK');


/*
|--------------------------------------------------------------------------
| 2. Fuseau horaire par défaut
|--------------------------------------------------------------------------
|
| Tous les appels date()/DateTime() suivront ce fuseau.
|
*/
date_default_timezone_set(getenv('APP_TIMEZONE') ?: 'Europe/Paris');


/*
|--------------------------------------------------------------------------
| 3. Locale / langue principale
|--------------------------------------------------------------------------
|
| Utile si vous utilisez la fonction locale-aware de PHP ou une lib i18n.
|
*/
setlocale(LC_ALL, getenv('APP_LOCALE') ?: 'fr_FR.UTF-8');


/*
|--------------------------------------------------------------------------
| 4. Environnement & mode debug
|--------------------------------------------------------------------------
|
| Trois valeurs possibles pour APP_ENV : "production", "staging", "local".
| Le mode debug s’active automatiquement si APP_ENV ≠ production
| mais vous pouvez forcer via la variable d’environnement APP_DEBUG.
|
*/
define('APP_ENV', getenv('APP_ENV') ?: 'production');

define(
    'APP_DEBUG',
    filter_var(
        getenv('APP_DEBUG') ?: (APP_ENV !== 'production'),
        FILTER_VALIDATE_BOOL
    )
);


/*
|--------------------------------------------------------------------------
| 5. URL de base
|--------------------------------------------------------------------------
|
| Si votre appli tourne derrière un reverse-proxy ou dans un sous-dossier,
| surchargerez-la via APP_URL.  L’URL est utile pour générer des liens
| absolus dans les e-mails, les redirections, etc.
|
*/
define(
    'APP_URL',
    rtrim(getenv('APP_URL') ?: ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http')
        . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost')), '/')
);


/*
|--------------------------------------------------------------------------
| 6. Gestion des erreurs / affichage
|--------------------------------------------------------------------------
|
| En production : on cache les erreurs à l’utilisateur.
| En dev : affichage + trace complète pour aller plus vite.
|
*/
if (APP_DEBUG) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
}


/*
|--------------------------------------------------------------------------
| 7. Helpers facultatifs
|--------------------------------------------------------------------------
|
| • env()   → récupère une variable d’environnement avec valeur par défaut
| • asset() → fabrique une URL vers un fichier dans /public (CSS, JS, img)
|
*/
if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        $value = getenv($key);
        return $value === false ? $default : $value;
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        return APP_URL . '/' . ltrim($path, '/');
    }
}
