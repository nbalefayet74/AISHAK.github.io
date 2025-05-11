<?php
declare(strict_types=1);

namespace App\Helpers;

class Response
{
    public static function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_THROW_ON_ERROR);
    }

    public static function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }
}

