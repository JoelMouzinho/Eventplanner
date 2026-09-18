<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/EventService.php';

requireLogin();

$userId = currentUserId();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        $error = 'Die Anfrage ist abgelaufen. Bitte versuche es erneut.';
    } elseif (($_POST['action'] ?? '') === 'update_profile') {
        updateUserProfile(
            $pdo,
            $userId,
            $_POST['first_name'] ?? '',
            $_POST['last_name'] ?? ''
        );

        redirect('/events/');
    } elseif (($_POST['action'] ?? '') === 'create') {
        $eventId = createEvent($pdo, $userId, $_POST['event_name'] ?? '');
        $_SESSION['current_event_id'] = $eventId;
        redirect('/home/');
    } elseif (($_POST['action'] ?? '') === 'delete' && isset($_POST['event_id'])) {
        deleteEvent($pdo, (int) $_POST['event_id'], $userId);
        redirect('/events/');
    }
}

$events = getUserEvents($pdo, $userId);
$account = getUserAccountInfo($pdo, $userId);
$dashboardStats = getUserDashboardStats($pdo, $userId);
?>
