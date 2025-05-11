<?php
declare(strict_types=1);

namespace App\Middlewares;

use Throwable;
use function App\Config\logger;

/**
 * Intercepte toutes les exceptions des contrôleurs
 * et renvoie une réponse 500 (ou JSON) propre.
 */
class ErrorMiddleware
{
    public function handle(array $params = []): void
    {
        try {
            // Le contrôleur sera exécuté après ce middleware,
            // lorsque Router aura terminé de dérouler toute la pile.
        } catch (Throwable $e) {
            logger()->error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            http_response_code(500);
            echo 'Internal Server Error';
            exit;
        }
    }
}
