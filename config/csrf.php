<?php
/**
 *  config/csrf.php
 *  -------------------------------------------------------------
 *  Génération et validation simples de tokens CSRF stockés en
 *  session.  À appeler dans tous les formulaires POST sensibles.
 *  -------------------------------------------------------------
 */

declare(strict_types=1);

namespace App\Security;

session_start();  // doit être lancé avant l’appel

/** Durée de validité d’un token (en secondes) */
const CSRF_TTL = 7200;   // 2 heures

/**
 *  csrf_token() → string
 *  Retourne un token valide (en crée un nouveau si expiré/absent).
 */
function csrf_token(): string
{
    if (empty($_SESSION['csrf']) || ($_SESSION['csrf_expiry'] ?? 0) < time()) {
        $_SESSION['csrf']        = bin2hex(random_bytes(32));
        $_SESSION['csrf_expiry'] = time() + CSRF_TTL;
    }
    return $_SESSION['csrf'];
}

/**
 *  csrf_field() → string
 *  Renvoie directement l’input caché pour vos formulaires.
 */
function csrf_field(): string
{
    return '<input type="hidden" name="__token" value="' . htmlspecialchars(csrf_token()) . '">';
}

/**
 *  csrf_validate() → void
 *  À appeler au début de chaque script qui traite un POST.
 *  Termine la requête si le token est invalide ou manquant.
 */
function csrf_validate(): void
{
    $valid = (isset($_POST['__token'])
        && hash_equals($_SESSION['csrf'] ?? '', $_POST['__token'])
        && ($_SESSION['csrf_expiry'] ?? 0) >= time());

    if (!$valid) {
        http_response_code(419);      // 419 : Authentication Timeout
        exit('Invalid CSRF token');
    }
}
