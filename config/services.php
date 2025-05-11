<?php
/**
 *  config/services.php
 *  -------------------------------------------------------------
 *  Conteneur ultra-léger façon "Service Locator" + helpers globaux.
 *  Usage :
 *      cache()->set('key', 'value');
 *      logger()->info('Hello');
 *  -------------------------------------------------------------
 */

declare(strict_types=1);

namespace App\Config;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

// Autoload (composer require monolog/monolog symfony/cache)
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/app.php';       // constantes APP_DEBUG, etc.

final class Services
{
    private static array $instances = [];

    /**
     * Retourne un service partagé (créé au premier appel).
     */
    public static function get(string $key): mixed
    {
        if (!isset(self::$instances[$key])) {
            self::$instances[$key] = self::create($key);
        }
        return self::$instances[$key];
    }

    /** Instancie le service demandé. */
    private static function create(string $key): mixed
    {
        return match ($key) {
            'logger' => self::makeLogger(),
            'cache'  => self::makeCache(),
            default  => throw new \InvalidArgumentException("Service '$key' inconnu"),
        };
    }

    private static function makeLogger(): Logger
    {
        $logger = new Logger(APP_NAME);
        $handler = new StreamHandler(__DIR__ . '/../storage/logs/app.log',
            APP_DEBUG ? Logger::DEBUG : Logger::WARNING);
        $logger->pushHandler($handler);
        return $logger;
    }

    private static function makeCache(): CacheInterface
    {
        // 15 min de TTL par défaut
        return new FilesystemAdapter(namespace: APP_NAME, defaultLifetime: 900,
                                    directory: __DIR__ . '/../storage/cache');
    }

    // Interdiction d'instancier la classe
    private function __construct() {}
}

/*-------------------------- Helpers globaux --------------------------*/
if (!function_exists('logger')) {
    function logger(): Logger
    {
        return Services::get('logger');
    }
}
if (!function_exists('cache')) {
    function cache(): CacheInterface
    {
        return Services::get('cache');
    }
}
