<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/EventService.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCsrfToken($_POST['csrf_token'] ?? null)) {
    $userId = currentUserId();

    $eventName = trim($_POST['event_name'] ?? '');

    if ($eventName === '') {
        $eventName = 'Mein Event';
    }

    $eventId = createEvent($pdo, $userId, $eventName);

    $_SESSION['current_event_id'] = $eventId;

    redirect('/home/');
}


redirect('/events/');