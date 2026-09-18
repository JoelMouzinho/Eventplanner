<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/EventService.php';

requireAdmin($pdo);

$currentUserId = currentUserId();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        $error = 'Die Anfrage ist abgelaufen. Bitte versuche es erneut.';
    } else {
        $targetId = (int) ($_POST['user_id'] ?? 0);
        $action = $_POST['action'] ?? '';

        if ($action === 'toggle_admin') {
            if ($targetId === $currentUserId) {
                $error = 'Du kannst dir selbst nicht die Admin-Rechte entziehen.';
            } else {
                $makeAdmin = ($_POST['make_admin'] ?? '0') === '1';
                setUserAdminStatus($pdo, $targetId, $makeAdmin);
            }
        } elseif ($action === 'delete') {
            if ($targetId === $currentUserId) {
                $error = 'Du kannst dein eigenes Konto hier nicht löschen.';
            } else {
                deleteUserAsAdmin($pdo, $targetId);
            }
        }
    }
}

$users = getAllUsersWithEventCounts($pdo);
?>
