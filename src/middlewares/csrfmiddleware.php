<?php
declare(strict_types=1);

namespace App\Middlewares;

use function App\Security\csrf_validate;

class CsrfMiddleware
{
    public function handle(): void
    {
        csrf_validate();   // stoppe la requête si mauvais token
    }
}

