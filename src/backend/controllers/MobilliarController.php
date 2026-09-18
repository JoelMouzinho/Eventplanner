<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/EventService.php';

requireLogin();

$userId = currentUserId();
$eventId = getCurrentEventId($pdo, $userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected = $_POST['mobilliar'] ?? [];
    saveEventData($pdo, $eventId, ['mobilliar' => $selected]);
    redirect('/mobilliar/?saved=1');
}

$data = loadEventData($pdo, $eventId);
$selectedMobilliar = $data['mobilliar'];

function isChecked(array $selected, string $value): string
{
    return in_array($value, $selected, true) ? 'checked' : '';
}
?>
