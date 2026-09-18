<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/EventService.php';

requireLogin();

$userId = currentUserId();
$eventId = getCurrentEventId($pdo, $userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menue = trim($_POST['menue'] ?? '');
    saveEventData($pdo, $eventId, ['menue' => $menue]);
    redirect('/menue/?saved=1');
}

$data = loadEventData($pdo, $eventId);
$menue = $data['menue'];
?>
