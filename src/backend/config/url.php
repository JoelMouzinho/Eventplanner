<?php
// ============================================
// Zentrale URL-Erzeugung
// --------------------------------------------
// Alle Links, Formular-Actions und Redirects laufen ueber url() bzw.
// redirect(). Dadurch funktionieren die URLs sowohl wenn der
// DocumentRoot direkt auf src/public zeigt, als auch wenn das Projekt
// in einem Unterordner liegt (z.B. http://localhost/Eventplanner/src/public/).
// ============================================

/**
 * Basis-Pfad der Anwendung, z.B. '' oder '/Eventplanner/src/public'.
 * Kann per define('APP_BASE_PATH', '/mein/pfad') fest vorgegeben werden.
 */
function base_path(): string
{
    static $base = null;

    if ($base !== null) {
        return $base;
    }

    // 1. Manuell gesetzt (config/env.php -> 'base_path' oder define('APP_BASE_PATH', ...))
    if (function_exists('config') && config('base_path') !== null) {
        return $base = rtrim((string) config('base_path'), '/');
    }

    if (defined('APP_BASE_PATH')) {
        return $base = rtrim((string) APP_BASE_PATH, '/');
    }

    $publicDir = realpath(__DIR__ . '/../../public');
    $publicDir = $publicDir === false ? '' : str_replace('\\', '/', $publicDir);

    $docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : false;
    $docRoot = $docRoot === false ? '' : str_replace('\\', '/', $docRoot);

    if ($docRoot !== '' && $publicDir !== '' && stripos($publicDir, $docRoot) === 0) {
        // public-Ordner liegt innerhalb des DocumentRoot -> Rest ist der Basis-Pfad
        $base = rtrim(substr($publicDir, strlen($docRoot)), '/');
    } else {
        // Fallback: aus dem laufenden Skript ableiten
        $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
        $base = rtrim(str_replace('/index.php', '', $script), '/');
    }

    if ($base === '.' || $base === '/') {
        $base = '';
    }

    return $base;
}

/**
 * Baut eine absolute URL aus einem app-internen Pfad: url('/login/').
 */
function url(string $path = '/'): string
{
    if ($path === '' || preg_match('#^([a-z][a-z0-9+.-]*:)?//#i', $path)) {
        return $path;
    }

    return base_path() . '/' . ltrim($path, '/');
}

/**
 * Redirect auf einen app-internen Pfad und Skript beenden.
 */
function redirect(string $path): void
{
    header('Location: ' . url($path), true, 302);
    exit;
}
