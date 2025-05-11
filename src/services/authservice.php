<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;

class AuthService
{
    public static function attempt(string $email, string $password): ?array
    {
        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            return null;
        }
        $_SESSION['user_id'] = $user['id'];
        return $user;
    }

    public static function logout(): void
    {
        session_destroy();
    }

    public static function user(): ?array
    {
        return isset($_SESSION['user_id']) ? User::find((int) $_SESSION['user_id']) : null;
    }
}

