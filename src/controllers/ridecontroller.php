<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\RideService;
use App\Models\Ride;
use function App\Security\csrf_validate;
use function App\Security\csrf_field;
use function App\Config\logger;

/**
 *  RideController
 *  ------------------------------------------------------------------
 *  • GET  /rides              → index()
 *  • GET  /rides/create       → create()
 *  • POST /rides              → store()
 *  • GET  /ride/{id}          → show()
 *  • POST /ride/{id}/cancel   → cancel()
 *  ------------------------------------------------------------------
 */
class RideController
{
    /* Liste tous les trajets */
    public function index(): void
    {
        $rides = Ride::latest(20);   // Méthode modèle (à écrire)

        header('Content-Type: application/json');
        echo json_encode($rides, JSON_THROW_ON_ERROR);
    }

    /* Formulaire de création d’un trajet */
    public function create(): void
    {
        header('Content-Type: text/html; charset=utf-8'); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Nouveau trajet</title>
</head>
<body>
    <h1>Proposer un trajet</h1>
    <form method="post" action="/rides">
        <?= csrf_field() ?>
        <label>Départ :<br><input name="depart" required></label><br>
        <label>Destination :<br><input name="destination" required></label><br>
        <label>Date/heure :<br><input type="datetime-local" name="date" required></label><br>
        <label>Places :<br><input type="number" name="seats" min="1" max="8" value="1" required></label><br>
        <button type="submit">Publier</button>
    </form>
</body>
</html>
<?php
    }

    /* Traite la création */
    public function store(): void
    {
        csrf_validate();

        $data = [
            'depart'      => $_POST['depart']      ?? '',
            'destination' => $_POST['destination'] ?? '',
            'date'        => $_POST['date']        ?? '',
            'seats'       => (int) ($_POST['seats'] ?? 1),
            'driver_id'   => $_SESSION['user_id'] ?? null,
        ];

        try {
            $ride = RideService::create($data);
        } catch (\Throwable $e) {
            logger()->error('Ride create: ' . $e->getMessage());
            http_response_code(422);
            exit('Impossible de créer le trajet');
        }

        header('Location: /ride/' . $ride['id']);
        exit;
    }

    /* Affiche le détail d’un trajet */
    public function show(string $id): void
    {
        $ride = Ride::findOrFail((int) $id);

        header('Content-Type: application/json');
        echo json_encode($ride, JSON_THROW_ON_ERROR);
    }

    /* Annule un trajet (POST) */
    public function cancel(string $id): void
    {
        csrf_validate();

        try {
            RideService::cancel((int) $id, $_SESSION['user_id'] ?? 0);
        } catch (\Throwable $e) {
            logger()->warning('Cancel ride: ' . $e->getMessage());
            http_response_code(403);
            exit('Action non autorisée');
        }

        header('Location: /rides');
        exit;
    }
}
