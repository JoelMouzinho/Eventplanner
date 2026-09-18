<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/EventService.php';

requireAdmin($pdo);

$eventId = (int) ($_GET['event_id'] ?? 0);
$data = getEventForAdmin($pdo, $eventId);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $data) {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        $error = 'Die Anfrage ist abgelaufen. Bitte versuche es erneut.';
    } elseif (($_POST['action'] ?? '') === 'delete') {
        deleteEventAsAdmin($pdo, $eventId);
        redirect('/admin/events.php');
    } elseif (($_POST['action'] ?? '') === 'reject') {
        $reason = trim($_POST['reason'] ?? '');
        if ($reason === '') {
            $error = 'Bitte gib eine Begründung für die Ablehnung an.';
        } else {
            rejectEvent($pdo, $eventId, $reason);
            redirect('/admin/event-detail.php?event_id=' . $eventId);
        }
    } elseif (($_POST['action'] ?? '') === 'unreject') {
        unrejectEvent($pdo, $eventId);
        redirect('/admin/event-detail.php?event_id=' . $eventId);
    }
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
?>
