<?php
/**
 *  config/mailer.php
 *  ------------------------------------------------------------------
 *  Prépare une instance PHPMailer pré-configurée et expose la fonction
 *  mailer() pour l’obtenir facilement dans tout le projet.
 *  ------------------------------------------------------------------
 *  Dépendances :
 *      composer require phpmailer/phpmailer
 */

declare(strict_types=1);

namespace App\Config;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ▸ Autoload Composer
require_once __DIR__ . '/../vendor/autoload.php';

// ▸ Charge les constantes APP_DEBUG, APP_NAME, etc.
require_once __DIR__ . '/app.php';

/**
 *  Classe utilitaire façon singleton
 */
class Mailer
{
    /** @var ?PHPMailer Instance unique paresseuse */
    private static ?PHPMailer $mailer = null;

    /**
     *  Retourne l’instance PHPMailer configurée.
     */
    public static function get(): PHPMailer
    {
        if (self::$mailer === null) {
            $m = new PHPMailer(true);

            try {
                // ──────────────────────────────────────────────────────
                // 1. Mode transport
                // ──────────────────────────────────────────────────────
                // • SMTP conseillé (plus fiable que mail()).
                // • Basculez sur mail() en changeant MAIL_DRIVER.
                // • Variables récupérées depuis .env ou le système.
                // ──────────────────────────────────────────────────────
                $driver = getenv('MAIL_DRIVER') ?: 'smtp';

                if ($driver === 'smtp') {
                    $m->isSMTP();
                    $m->Host       = getenv('MAIL_HOST')     ?: 'smtp.example.com';
                    $m->Port       = getenv('MAIL_PORT')     ?: 587;
                    $m->SMTPAuth   = filter_var(getenv('MAIL_SMTPAUTH') ?: true, FILTER_VALIDATE_BOOL);
                    $m->SMTPSecure = getenv('MAIL_SECURE')   ?: PHPMailer::ENCRYPTION_STARTTLS;
                    $m->Username   = getenv('MAIL_USERNAME') ?: 'no-reply@example.com';
                    $m->Password   = getenv('MAIL_PASSWORD') ?: 'secret';
                } else {
                    // Fallback PHP mail()
                    $m->isMail();
                }

                // ──────────────────────────────────────────────────────
                // 2. Paramètres généraux
                // ──────────────────────────────────────────────────────
                $m->CharSet  = 'UTF-8';
                $m->setLanguage('fr');
                $m->isHTML(true);                          // Autorise HTML par défaut
                $m->setFrom(
                    getenv('MAIL_FROM_ADDRESS') ?: 'no-reply@example.com',
                    getenv('MAIL_FROM_NAME')    ?: APP_NAME
                );

                // ──────────────────────────────────────────────────────
                // 3. Debug / logs
                // ──────────────────────────────────────────────────────
                $m->SMTPDebug = APP_DEBUG ? PHPMailer::DEBUG_SERVER : 0;
                // Pour logguer dans un fichier :
                // $m->Debugoutput = function ($str, $level) {
                //     error_log("[MAIL] $level: $str");
                // };

            } catch (Exception $e) {
                if (APP_DEBUG) {
                    throw $e;
                }
                error_log('[MAIL] Init error: ' . $e->getMessage());
            }

            self::$mailer = $m;
        }

        return self::$mailer;
    }

    // Singleton strict
    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}
}

/**
 *  Helper global : mailer() → PHPMailer
 *
 *  Exemple d’envoi rapide :
 *      $mail = mailer();
 *      $mail->addAddress('bob@example.com', 'Bob');
 *      $mail->Subject = 'Bienvenue !';
 *      $mail->Body    = '<p>Merci de votre inscription !</p>';
 *      $mail->AltBody = 'Merci de votre inscription !';
 *      $mail->send();
 */
function mailer(): PHPMailer
{
    return Mailer::get();
}
