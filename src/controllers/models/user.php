<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\Timestamps;
use PDO;
use PDOException;
use function App\Config\db;

/**
 *  Classe User  (table : users)
 *  ---------------------------------------------------------------
 *  Colonnes recommandées :
 *      id            INT      PRIMARY KEY AUTO_INCREMENT
 *      email         VARCHAR  UNIQUE
 *      password      VARCHAR  (hash bcrypt)
 *      role          TINYINT  (ROLE_USER, ROLE_ADMIN…)
 *      deleted_at    DATETIME NULL
 *      created_at    DATETIME
 *      updated_at    DATETIME
 *  ---------------------------------------------------------------
 */
class User
{
    use Timestamps;

    public int    $id;
    public string $email;
    public string $password;
    public int    $role = ROLE_USER;
    public ?string $deleted_at = null;

    /*────────────────────── Recherche ──────────────────────*/

    /** Renvoie l’utilisateur ou null */
    public static function find(int $id): ?self
    {
        $stmt = db()->prepare('SELECT * FROM users WHERE id = ? AND deleted_at IS NULL');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::fromRow($row) : null;
    }

    public static function findByEmail(string $email): ?self
    {
        $stmt = db()->prepare('SELECT * FROM users WHERE email = ? AND deleted_at IS NULL');
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ? self::fromRow($row) : null;
    }

    /*────────────────────── Création ───────────────────────*/

    /**
     *  Crée un nouvel utilisateur et renvoie l’instance.
     *  Lève PDOException si l’e-mail existe déjà.
     */
    public static function create(string $email, string $plainPassword, int $role = ROLE_USER): self
    {
        $hash = password_hash($plainPassword, PASSWORD_BCRYPT);

        $user = new self();
        $user->email    = $email;
        $user->password = $hash;
        $user->role     = $role;
        $user->touch();                         // created_at / updated_at

        $stmt = db()->prepare(
            'INSERT INTO users (email,password,role,created_at,updated_at)
             VALUES (:email,:pwd,:role,:c,:u)'
        );
        $stmt->execute([
            ':email' => $user->email,
            ':pwd'   => $user->password,
            ':role'  => $user->role,
            ':c'     => $user->created_at,
            ':u'     => $user->updated_at,
        ]);

        $user->id = (int) db()->lastInsertId();
        return $user;
    }

    /*──────────────────── Mise à jour du mot de passe ────────────────────*/

    public function updatePassword(string $newPlainPassword): void
    {
        $this->password   = password_hash($newPlainPassword, PASSWORD_BCRYPT);
        $this->updated_at = date('Y-m-d H:i:s');

        db()->prepare('UPDATE users SET password = ?, updated_at = ? WHERE id = ?')
            ->execute([$this->password, $this->updated_at, $this->id]);
    }

    /*──────────────────── Suppression douce ────────────────────*/

    public function softDelete(): void
    {
        $this->deleted_at = date('Y-m-d H:i:s');
        db()->prepare('UPDATE users SET deleted_at = ? WHERE id = ?')
            ->execute([$this->deleted_at, $this->id]);
    }

    /*──────────────────── Helper interne ─────────────────────*/

    private static function fromRow(array $row): self
    {
        $u = new self();
        foreach ($row as $k => $v) {
            if (property_exists($u, $k)) {
                $u->$k = $v;
            }
        }
        return $u;
    }
}
