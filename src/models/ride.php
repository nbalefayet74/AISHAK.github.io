<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use function App\Config\db;

class Ride
{
    public static function latest(int $n = 5): array
    {
        $stmt = db()->prepare(
            'SELECT id, depart, destination, date 
               FROM rides 
           ORDER BY date DESC 
              LIMIT ?'
        );
        $stmt->bindValue(1, $n, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function findOrFail(int $id): array
    {
        $stmt = db()->prepare('SELECT * FROM rides WHERE id = ?');
        $stmt->execute([$id]);
        $ride = $stmt->fetch();
        if (!$ride) {
            http_response_code(404);
            exit('Trajet introuvable');
        }
        return $ride;
    }
}

