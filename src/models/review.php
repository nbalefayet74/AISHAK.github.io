<?php
declare(strict_types=1);

namespace App\Models;

use function App\Config\db;

class Review
{
    public static function forRide(int $rideId): array
    {
        $stmt = db()->prepare(
            'SELECT r.*, u.email AS author_email
               FROM reviews r
               JOIN users u ON u.id = r.author_id
              WHERE ride_id = ?
           ORDER BY created_at DESC'
        );
        $stmt->execute([$rideId]);
        return $stmt->fetchAll();
    }
}

