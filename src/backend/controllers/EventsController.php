<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/EventService.php';

requireLogin();

$userId = currentUserId();
$error = '';
$profileError = '';
$passwordError = '';
$emailError = '';
$deleteError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        $error = 'Die Anfrage ist abgelaufen. Bitte versuche es erneut.';
    } elseif (($_POST['action'] ?? '') === 'update_profile') {
        updateUserProfile(
            $pdo,
            $userId,
            $_POST['first_name'] ?? '',
            $_POST['last_name'] ?? '',
            $_POST['phone'] ?? ''
        );

        redirect('/events/?updated=profile');
    } elseif (($_POST['action'] ?? '') === 'change_password') {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $newPasswordConfirm = $_POST['new_password_confirm'] ?? '';

        if (!verifyUserPassword($pdo, $userId, $currentPassword)) {
            $passwordError = 'Dein aktuelles Passwort ist nicht korrekt.';
        } elseif (strlen($newPassword) < 8) {
            $passwordError = 'Das neue Passwort muss mindestens 8 Zeichen lang sein.';
        } elseif ($newPassword !== $newPasswordConfirm) {
            $passwordError = 'Die neuen Passwörter stimmen nicht überein.';
        } elseif ($newPassword === $currentPassword) {
            $passwordError = 'Das neue Passwort muss sich vom aktuellen unterscheiden.';
        } else {
            updateUserPassword($pdo, $userId, $newPassword);
            redirect('/events/?updated=password');
        }
    } elseif (($_POST['action'] ?? '') === 'change_email') {
        $currentPassword = $_POST['current_password_email'] ?? '';
        $newEmail = strtolower(trim($_POST['new_email'] ?? ''));

        if (!verifyUserPassword($pdo, $userId, $currentPassword)) {
            $emailError = 'Dein aktuelles Passwort ist nicht korrekt.';
        } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $emailError = 'Bitte gib eine gültige E-Mail-Adresse ein.';
        } elseif (emailExistsForOtherUser($pdo, $newEmail, $userId)) {
            $emailError = 'Diese E-Mail-Adresse wird bereits von einem anderen Konto verwendet.';
        } else {
            updateUserEmail($pdo, $userId, $newEmail);
            $_SESSION['user_email'] = $newEmail;
            redirect('/events/?updated=email');
        }
    } elseif (($_POST['action'] ?? '') === 'delete_account') {
        $currentPassword = $_POST['current_password_delete'] ?? '';
        $confirmed = ($_POST['confirm_delete'] ?? '') === '1';

        if (!verifyUserPassword($pdo, $userId, $currentPassword)) {
            $deleteError = 'Dein aktuelles Passwort ist nicht korrekt.';
        } elseif (!$confirmed) {
            $deleteError = 'Bitte bestätige, dass du dein Konto endgültig löschen möchtest.';
        } else {
            deleteOwnAccount($pdo, $userId);
            logoutUser();
            redirect('/');
        }
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

$updatedNotice = $_GET['updated'] ?? '';
$updatedMessages = [
    'profile' => 'Profil aktualisiert!',
    'password' => 'Passwort geändert!',
    'email' => 'E-Mail-Adresse geändert!',
];

$profileModalShouldOpen = $profileError !== ''
    || $passwordError !== ''
    || $emailError !== ''
    || $deleteError !== ''
    || isset($updatedMessages[$updatedNotice]);
