<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/EventService.php';

$token = trim($_GET['token'] ?? '');
$data = $token !== '' ? loadEventByShareToken($pdo, $token) : null;

if ($data === null) {
    http_response_code(404);
}

$ortLabels = [
    'zuhause' => '🏠 Zuhause',
    'veranstaltungsraum' => '🏢 Veranstaltungsraum',
    'restaurant' => '🍽️ Restaurant',
    'draussen' => '🌳 Draußen',
    'hotel' => '🏨 Hotel',
    'anderer_ort' => '📍 Anderer Ort',
];
$unterhaltungLabels = [
    'sound' => '🎵 Sound / Musik',
    'tv' => '📺 TV / Filme',
    'karaoke' => '🎤 Karaoke',
    'band' => '🎸 Live Band',
    'spiele' => '🎮 Spiele / Quiz',
    'comedy' => '🎭 Comedy / Show',
];
$mobilliarLabels = [
    'stuehle' => '🪑 Stühle',
    'tische' => '📋 Tische',
    'grill' => '🔥 Grill',
    'bar' => '🍹 Bar',
];
$energieLabels = [
    'stromanschluss' => '⚡ Stromanschluss',
    'generator' => '⚙️ Generator',
    'verlaengerung' => '🔌 Verlängerungskabel',
    'beleuchtung' => '💡 Beleuchtung',
    'notstrom' => '🆘 Notstrom',
    'technik' => '🎚️ Technik-Anschlüsse',
];