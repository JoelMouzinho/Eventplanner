<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/EventService.php';

requireLogin();

$userId = currentUserId();
$eventId = getCurrentEventId($pdo, $userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected = $_POST['entertainment'] ?? [];
    saveEventData($pdo, $eventId, ['unterhaltung' => $selected]);
    redirect('/unterhaltung/?saved=1');
}

$data = loadEventData($pdo, $eventId);
$selectedUnterhaltung = $data['unterhaltung'];

function isChecked(array $selected, string $value): string
{
    return in_array($value, $selected, true) ? 'checked' : '';
}
?>
