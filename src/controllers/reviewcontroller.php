<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\ReviewService;
use App\Models\Review;
use function App\Security\csrf_validate;
use function App\Security\csrf_field;
use function App\Config\logger;

/**
 *  ReviewController
 *  ------------------------------------------------------------------
 *  • POST /ride/{id}/reviews  → store()
 *  • GET  /ride/{id}/reviews  → list()
 *  ------------------------------------------------------------------
 */
class ReviewController
{
    /* Ajoute un avis sur un trajet */
    public function store(string $rideId): void
    {
        csrf_validate();

        $data = [
            'ride_id' => (int) $rideId,
            'author_id' => $_SESSION['user_id'] ?? 0,
            'rating' => (int) ($_POST['rating'] ?? 0),
            'comment' => trim($_POST['comment'] ?? ''),
        ];

        try {
            ReviewService::create($data);
        } catch (\Throwable $e) {
            logger()->error('Review create: ' . $e->getMessage());
            http_response_code(422);
            exit('Impossible d’enregistrer votre avis');
        }

        header('Location: /ride/' . $rideId);
        exit;
    }

    /* Renvoie la liste (JSON) des avis d’un trajet */
    public function list(string $rideId): void
    {
        $reviews = Review::forRide((int) $rideId);

        header('Content-Type: application/json');
        echo json_encode($reviews, JSON_THROW_ON_ERROR);
    }
}
