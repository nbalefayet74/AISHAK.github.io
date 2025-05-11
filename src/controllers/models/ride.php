<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\Timestamps;
use PDO;
use function App\Config\db;

/**
 *  Modèle Ride  (table : rides)
 *  ------------------------------------------------------------------
 *  Colonnes conseillées :
 *      id            INT PK AI
 *      depart        VARCHAR
 *      destination   VARCHAR
 *      date          DATETIME
 *      seats         TINYINT
 *      driver_id     INT (FK users.id)
 *      status        ENUM('pending','accepted','started','completed','canceled')
 *      created_at    DATETIME
 *      updated_at    DATETIME
 *  ------------------------------------------------------------------
 */
class Ride
{
    use Timestamps;

    public int    $id;
    public string $depart;
    public string $destination;
    public string $date;
    public int    $seats;
    public int    $driver_id;
    public string $status = RIDE_PENDING;

    /*────────────────── Création ──────────────────*/

    public static function create(array $data): self
    {
        $ride = new self();
        $ride->depart      = $data['depart'];
        $ride->destination = $data['destination'];
        $ride->date        = $data['date'];
        $ride->seats       = $data['seats'];
        $ride->driver_id   = $data['driver_id'];
        $ride->touch();

        db()->prepare(
            'INSERT INTO rides
             (depart,destination,date,seats,driver_id,status,created_at,updated_at)
             VALUES (:dep,:dest,:d,:s,:driver,:status,:c,:u)'
        )->execute([
            ':dep'    => $ride->depart,
            ':dest'   => $ride->destination,
            ':d'      => $ride->date,
            ':s'      => $ride->seats,
            ':driver' => $ride->driver_id,
            ':status' => $ride->status,
            ':c'      => $ride->created_at,
            ':u'      => $ride->updated_at,
        ]);

        $ride->id = (int) db()->lastInsertId();
        return $ride;
    }

    /*────────────────── Lecture ───────────────────*/

    public static function find(int $id): ?self
    {
        $stmt = db()->prepare('SELECT * FROM rides WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::fromRow($row) : null;
    }

    public static function findOrFail(int $id): self
    {
        $ride = self::find($id);
        if (!$ride) {
            http_response_code(404);
            exit('Trajet introuvable');
        }
        return $ride;
    }

    public static function latest(int $n = 5): array
    {
        $stmt = db()->prepare(
            'SELECT id, depart, destination, date, seats, status
               FROM rides
           ORDER BY date DESC
              LIMIT ?'
        );
        $stmt->bindValue(1, $n, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /*────────────────── Mise à jour d’état ───────────────────*/

    public function updateStatus(string $newStatus): void
    {
        $allowed = [
            RIDE_PENDING,
            RIDE_ACCEPTED,
            RIDE_STARTED,
            RIDE_COMPLETED,
            RIDE_CANCELED,
        ];
        if (!in_array($newStatus, $allowed, true)) {
            throw new \InvalidArgumentException('Statut invalide');
        }
        $this->status     = $newStatus;
        $this->updated_at = date('Y-m-d H:i:s');

        db()->prepare('UPDATE rides SET status = ?, updated_at = ? WHERE id = ?')
            ->execute([$this->status, $this->updated_at, $this->id]);
    }

    /*────────────────── Hydratation ──────────────────*/

    private static function fromRow(array $row): self
    {
        $r = new self();
        foreach ($row as $k => $v) {
            if (property_exists($r, $k)) {
                $r->$k = $v;
            }
        }
        return $r;
    }
}
