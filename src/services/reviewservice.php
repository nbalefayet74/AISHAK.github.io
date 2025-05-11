<?php
declare(strict_types=1);

namespace App\Services;

use function App\Config\db;

class ReviewService
{
    public static function create(array $data): void
    {
        db()->prepare(
            'INSERT INTO reviews (ride_id, author_id, rating, comment) 
                   VALUES (:ride,:author,:rating,:comment)'
        )->execute([
            ':ride'    => $data['ride_id'],
            ':author'  => $data['author_id'],
            ':rating'  => $data['rating'],
            ':comment' => $data['comment'],
        ]);
    }
}

