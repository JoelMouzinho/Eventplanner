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
        $error = 'Die Anfrage ist abgelaufen. Bitte versueche es erneut.';
    } elseif (($_POST['action'] ?? '') === 'add_item') {

        $category = $_POST['category'] ?? 'sonstiges';
        $label = trim($_POST['label'] ?? '');
        $planned = (float) str_replace(',', '.', $_POST['planned_amount'] ?? '0');
        $actual = (float) str_replace(',', '.', $_POST['actual_amount'] ?? '0');

        if (!array_key_exists($category, budgetCategoryLabels())) {
            $category = 'sonstiges';
        }

        if($label === '') {
            $error = 'Bitte gib eine Bezeichnung für den Posten ein.';
        } elseif ($planned < 0 || $actual <0) {
            $error = 'Beträge dürfen nicht negativ sein.';
        } else {
            addBudgetItem($pdo, $eventId, $category, $label, $planned, $actual);
            redirect('/budget/?saved=1');
        }
    } elseif (($_POST['action'] ?? '') === 'delete_item' && isset($_POST['item_id'])) {
        deleteBudgetItem($pdo, $eventID, (int) $_POST['item_id']);
        redirect('/budget/');
    } elseif (($_POST['action'] ?? '') === 'set_limit') {
        $limitRaw = trim($_POST['budget_limit'] ?? '');
        $limit = $limitRaw === '' ? null : (float) str_replace(',', '.', $limitRaw);

        if ($limit !== null && $limit < 0) {
            $error = 'Das Budget-Limit darf nicht negativ sein.';
        } else {
            updateEventBudgetLimit($pdo, $eventId, $limit);
            redirect('/budget/?saved=1');
        }
    }
}

$data = loadEventData($pdo, $eventId);
$items = getBudgetItems($pdo, $eventId);
$totals = getBudgetTotals($pdo, $eventId);
$categoryLabels = budgetCategoryLabels();
$budgetLimit = $data['budget_limit'] !== null ? (float) $data['budget_limit'] : null;