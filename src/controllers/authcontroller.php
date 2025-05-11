<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\AuthService;
use function App\Security\csrf_validate;
use function App\Security\csrf_field;
use function App\Config\logger;

/**
 *  AuthController
 *  ------------------------------------------------------------------
 *  • GET  /login        → showLogin()
 *  • POST /login        → login()
 *  • GET  /logout       → logout()
 *  ------------------------------------------------------------------
 */
class AuthController
{
    /* Affiche le formulaire de connexion */
    public function showLogin(): void
    {
        header('Content-Type: text/html; charset=utf-8'); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion · <?= APP_NAME ?></title>
</head>
<body>
    <h1>Connexion</h1>
    <form method="post" action="/login">
        <?= csrf_field() ?>
        <label>E-mail :<br>
            <input type="email" name="email" required>
        </label><br>
        <label>Mot de passe :<br>
            <input type="password" name="password" required>
        </label><br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
<?php
    }

    /* Traite la soumission du formulaire */
    public function login(): void
    {
        csrf_validate();                   // bloque si token absent/erroné

        $email    = $_POST['email']    ?? '';
        $password = $_POST['password'] ?? '';

        try {
            $user = AuthService::attempt($email, $password);
            if (!$user) {
                $_SESSION['flash_error'] = 'Identifiants invalides';
                header('Location: /login');
                exit;
            }
        } catch (\Throwable $e) {
            logger()->error('Login error: ' . $e->getMessage());
            http_response_code(500);
            exit('Internal Server Error');
        }

        header('Location: /');
        exit;
    }

    /* Déconnecte l’utilisateur */
    public function logout(): void
    {
        AuthService::logout();
        header('Location: /login');
        exit;
    }
}
