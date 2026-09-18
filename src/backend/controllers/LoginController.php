<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../services/EventService.php';
require_once __DIR__ . '/../services/LoginThrottle.php';

if (isLoggedIn()) {
    redirect('/events/');
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    $lockRemaining = $email !== '' ? loginLockRemaining($pdo, $email) : 0;

    if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        $error = 'Die Anfrage ist abgelaufen. Bitte versuche es erneut.';
    } elseif ($lockRemaining > 0) {
        $minutes = (int) ceil($lockRemaining / 60);
        $error = "Zu viele Fehlversuche. Bitte in $minutes Minute(n) erneut versuchen.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Bitte gib eine gültige E-Mail-Adresse und dein Passwort ein.';
    } else {
        $stmt = $pdo->prepare('SELECT id, email, password_hash FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            recordFailedLogin($pdo, $email);
            $error = 'E-Mail-Adresse oder Passwort ist falsch.';
        } else {
            clearFailedLogins($pdo, $email);
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['user_email'] = $user['email'];

            redirect('/events/');
        }
    }
}
?>