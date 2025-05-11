<?php
declare(strict_types=1);

namespace App\Middlewares;

use function App\Security\csrf_validate;

/**
 * Valide le token CSRF pour toutes les requêtes « non-GET ».
 */
class CsrfMiddleware
{
    public function handle(array $params = []): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        if ($method !== 'GET' && $method !== 'HEAD') {
            csrf_validate();      // stoppe la requête si token invalide
        }
    }
}
