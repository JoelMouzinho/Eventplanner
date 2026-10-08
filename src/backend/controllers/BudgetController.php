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

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        $error = 'Die Anfrage ist abgelaufen. Bitte versuche es erneut.';
    } elseif (($_POST['action'] ?? '') === 'set_limit') {
        $limitRaw = trim($_POST['budget_limit'] ?? '');
        $limit = $limitRaw === '' ? null : (float) str_replace(',', '.', $limitRaw);

        if($limit !== null && $limit < 0) {
            $error = 'Das Budget darf nicht negativ sein.';
        } else {
            updateEventBudgetLimit($pdo, $eventId, $limit);
            redirect('/budget/?saved=1');
        }
    }
}

$data = loadEventData($pdo, $eventId);
$budget = calculateEventBudget($pdo, $data);