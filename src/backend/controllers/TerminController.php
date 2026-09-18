<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/EventService.php';

requireLogin();

$userId = currentUserId();
$eventId = getCurrentEventId($pdo, $userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    saveEventData($pdo, $eventId, [
        'termin_date'    => $_POST['date'] ?? '',
        'termin_time'    => $_POST['time'] ?? '',
        'termin_endtime' => $_POST['endTime'] ?? '',
        'termin_notes'   => trim($_POST['notes'] ?? ''),
    ]);
    redirect('/termin/?saved=1');
}

$data = loadEventData($pdo, $eventId);
?>
