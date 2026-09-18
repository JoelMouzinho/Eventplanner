<?php
// ============================================
// Front-Controller: nimmt alle Requests entgegen und
// loest sie ueber src/backend/routes/web.php auf.
// ============================================

require_once __DIR__ . '/../backend/config/bootstrap.php';

$routes = require __DIR__ . '/../backend/routes/web.php';

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$uri = rawurldecode((string) ($uri ?? '/'));

// Basis-Pfad (z.B. /Eventplanner/src/public) abschneiden
$base = base_path();
if ($base !== '' && stripos($uri, $base) === 0) {
    $uri = substr($uri, strlen($base));
}
if ($uri === '' || $uri[0] !== '/') {
    $uri = '/' . $uri;
}

// Mit und ohne abschliessenden Slash pruefen
$candidates = [$uri];
$candidates[] = substr($uri, -1) === '/' ? rtrim($uri, '/') : $uri . '/';

$route = null;
foreach ($candidates as $candidate) {
    if ($candidate !== '' && isset($routes[$candidate])) {
        $route = $routes[$candidate];
        break;
    }
}

// Notnagel: Projekt wurde ueber einen anderen Pfad erreicht
if ($route === null && ($pos = stripos($uri, '/src/public')) !== false) {
    $uri = substr($uri, $pos + strlen('/src/public'));
    $uri = $uri === '' ? '/' : $uri;
    foreach ([$uri, rtrim($uri, '/') ?: '/'] as $candidate) {
        if (isset($routes[$candidate])) {
            $route = $routes[$candidate];
            break;
        }
    }
}

if ($route === null) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

require __DIR__ . '/../' . ltrim($route['view'], '/');
