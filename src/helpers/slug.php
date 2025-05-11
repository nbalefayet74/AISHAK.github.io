<?php
declare(strict_types=1);

namespace App\Helpers;

class Slug
{
    public static function make(string $text): string
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $text));
        return trim($text, '-');
    }
}

