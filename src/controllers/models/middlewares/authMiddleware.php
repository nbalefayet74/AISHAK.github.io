<?php
declare(strict_types=1);

namespace App\Middlewares;

use App\Services\AuthService;

/**
 * Vérifie qu’un utilisateur est connecté.
 * À ajouter sur toutes les routes protégées.
 */
class AuthMiddleware
{
    /**
     * @param array $params Segments dynamiques de l’URL (ignorés ici).
     */
    public function handle(array $params = []): void
    {
        if (!AuthService::user()) {
            // Mémorise la page demandée pour y revenir après login
            $_SESSION['intended'] = $_SERVER['REQUEST_URI'] ?? '/';
            header('Location: /login');
            exit;
        }
    }
}
