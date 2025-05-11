<?php
declare(strict_types=1);

namespace App\Middlewares;

use App\Services\AuthService;

class AuthMiddleware
{
    public function handle(): void
    {
        if (!AuthService::user()) {
            header('Location: /login');
            exit;
        }
    }
}

