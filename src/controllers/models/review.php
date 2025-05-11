<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\Timestamps;
use PDO;
use function App\Config\db;

/**
 *  Modèle Review  (table : reviews)
 *  ------------------------------------------------------------------
 *  Colonnes conseillées :
 *      id          INT PK AI
 *      ride_id     INT  FK rides.id
 *      author_id   INT  FK users.id
 *      rating      TINYINT (1–5)
 *      comment     TEXT
 *      created_at  DATETIME
 *  ------------------------------------------------------------------
 */
class Review
{
    use Timestamps;

    public int    $id;
    public int    $ride_id;
    public int    $author_id;
    public int    $rating;
    public string $comment;

    /*────────────────── Création ──────────────────*/

    public static function create(array $data): self
    {
        $rev = new self();
        $rev->ride_id   = $data['ride_id'];
        $rev->author_id = $data['author_id'];
        $rev->rating    = $data['rating'];
        $rev->comment   = $data['comment'];
        $rev->touch();

        db()->prepare(
            'INSERT INTO reviews
             (ride_id,author_id,rating,comment,created_at)
             VALUES (:ride,:author,:rate,:comm,:c)'
        )->execute([
            ':ride'   => $rev->ride_id,
            ':author' => $rev->author_id,
            ':rate'   => $rev->rating,
            ':comm'   => $rev->comment,
            ':c'      => $rev->created_at,
        ]);

        $rev->id = (int) db()->lastInsertId();
        return $rev;
    }

    /*────────────────── Liste des avis d’un trajet ────────────────*/

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
