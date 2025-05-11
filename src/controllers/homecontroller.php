<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Ride;
use function App\Config\logger;

/**
 *  HomeController
 *  ------------------------------------------------------------------
 *  • index()  → GET /
 *  ------------------------------------------------------------------
 */
class HomeController
{
    /**
     *  Page d’accueil.
     *
     *  – Récupère les 5 trajets les plus récents (Model Ride)
     *  – Rend une petite vue HTML (pour un vrai projet, branchez Twig/Blade)
     */
    public function index(): void
    {
        /* 1. Données -------------------------------------------------- */
        try {
            // ↓ Méthode statique que vous définirez dans Ride::latest(int $n)
            $rides = Ride::latest(5);
        } catch (\Throwable $e) {
            logger()->warning('Ride::latest échoue : ' . $e->getMessage());
            $rides = [];
        }

        /* 2. Vue (très simple) --------------------------------------- */
        header('Content-Type: text/html; charset=utf-8'); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Accueil · <?= htmlspecialchars(APP_NAME, ENT_QUOTES) ?></title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    <h1>Bienvenue sur <?= htmlspecialchars(APP_NAME, ENT_QUOTES) ?></h1>

    <h2>Les 5 derniers trajets proposés</h2>
    <?php if ($rides): ?>
        <ul>
            <?php foreach ($rides as $ride): ?>
                <li>
                    <?= htmlspecialchars($ride['depart']) ?>
                    &nbsp;→&nbsp;
                    <?= htmlspecialchars($ride['destination']) ?>
                    (<?= htmlspecialchars(date('d/m/Y H:i', strtotime($ride['date']))) ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun trajet disponible pour l’instant.</p>
    <?php endif; ?>
</body>
</html>
<?php
    }
}
