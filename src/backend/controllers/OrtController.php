<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/EventService.php';

requireLogin();

$userId = currentUserId();
$eventId = getCurrentEventId($pdo, $userId);

if (!$eventId) {
    redirect('/home/');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (verifyCsrfToken($_POST['csrf_token'] ?? null)) {

        $selectedOrt = $_POST['ort'] ?? '';

        $allowedOrte = [
            'zuhause',
            'veranstaltungsraum',
            'restaurant',
            'draussen',
            'hotel',
            'anderer_ort'
        ];

        if (in_array($selectedOrt, $allowedOrte, true)) {

            saveEventData($pdo, $eventId, [
                'ort' => $selectedOrt
            ]);

            redirect('/ort/?saved=1');
        }
    }
}

$data = loadEventData($pdo, $eventId);
$selectedOrt = $data['ort'] ?? '';

function isChecked(string $selected, string $value): string
{
    return $selected === $value ? 'checked' : '';
}
?>
