<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Ride;
use function App\Config\db;

class RideService
{
    public static function create(array $data): array
    {
        $stmt = db()->prepare(
            'INSERT INTO rides (depart, destination, date, seats, driver_id) 
                   VALUES (:depart,:dest,:date,:seats,:driver_id)'
        );
        $stmt->execute([
            ':depart'    => $data['depart'],
            ':dest'      => $data['destination'],
            ':date'      => $data['date'],
            ':seats'     => $data['seats'],
            ':driver_id' => $data['driver_id'],
        ]);
        $id = (int) db()->lastInsertId();
        return Ride::findOrFail($id);
    }

    public static function cancel(int $rideId, int $userId): void
    {
        // Vérifie que c'est bien le conducteur
        $ride = Ride::findOrFail($rideId);
        if ($ride['driver_id'] !== $userId) {
            throw new \RuntimeException('Not authorized');
        }
        db()->prepare('UPDATE rides SET status = ? WHERE id = ?')->execute(['canceled', $rideId]);
    }
}

