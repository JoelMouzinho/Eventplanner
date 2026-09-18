<?php
// ============================================
// Bootstrap: Umgebung laden, Fehleranzeige und Session-Sicherheit setzen.
// Wird von auth.php als Erstes eingebunden.
// ============================================

/**
 * Konfiguration: env.php ueberschreibt die Standardwerte.
 * env.php wird NICHT ins Git eingecheckt und liegt nur auf dem jeweiligen Server.
 */
function config(string $key, $default = null)
{
    static $config = null;

    if ($config === null) {
        $config = [
            'env'         => 'local',
            'db_host'     => 'localhost',
            'db_name'     => 'eventplaner',
            'db_user'     => 'root',
            'db_pass'     => '',
            'db_charset'  => 'utf8mb4',
            'force_https' => false,
        ];

        $envFile = __DIR__ . '/env.php';
        if (is_file($envFile)) {
            $custom = require $envFile;
            if (is_array($custom)) {
                $config = array_merge($config, $custom);
            }
        }
    }

    return $config[$key] ?? $default;
}

function isProduction(): bool
{
    return config('env') === 'production';
}

// --- Fehleranzeige ---------------------------------------------------------
// Auf dem Hosting NIE Fehler im Browser anzeigen (verraet Pfade und DB-Daten).
if (isProduction()) {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
} else {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

// --- Session-Cookie absichern (muss vor session_start() passieren) ----------
if (session_status() !== PHP_SESSION_ACTIVE) {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $https,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

require_once __DIR__ . '/url.php';
