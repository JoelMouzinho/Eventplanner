<?php
/**
 * Login-Absicherung gegen Brute-Force Attacken
 */

const LOGIN_MAX_ATTEMPTS = 5;
const LOGIN_LOCKOUT_SECONDS = 300; // 5 Minuten

function loginIdentifier(string $email): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    return hash('sha256', strtolower($email) . '|' . $ip);
}

/**
 * Gibt die verbleibende Sperrzeit in Sekunden zurück
 */
function loginLockRemaining(PDO $pdo, string $email): int
{
    $stmt = $pdo->prepare('SELECT locked_until FROM login_attempts WHERE identifier = :id LIMIT 1');
    $stmt->execute(['id' => loginIdentifier($email)]);
    $row = $stmt->fetch();

    if (!$row || $row['locked_until'] === null) {
        return 0;
    }

    $remaining = strtotime($row['locked_until']) - time();

    return $remaining > 0 ? $remaining : 0;
}

/**
 * Vermerkt einen fehlgeschlagenen Login-Versuch und sperrt bei Bedarf
 */
function recordFailedLogin(PDO $pdo, string $email): void
{
    $id = loginIdentifier($email);

    $stmt = $pdo->prepare('SELECT attempts FROM login_attempts WHERE identifier = :id LIMIT 1');
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();

    $attempts = $row ? (int) $row['attempts'] + 1 : 1;
    $lockedUntil = null;

    if ($attempts >= LOGIN_MAX_ATTEMPTS) {
        $lockedUntil = date('Y-m-d H:i:s', time() + LOGIN_LOCKOUT_SECONDS);
        $attempts = 0;
    }

    $upsert = $pdo->prepare('
    INSERT INTO login_attempts (identifier, attempts, locked_until)
    VALUES (:id, :attempts, :locked_until)
    ON DUPLICATE KEY UPDATE attempts = :attempts2, locked_until = :locked_until2
    ');
    $upsert->execute([
        'id' => $id,
        'attempts' => $attempts,
        'locked_until' => $lockedUntil,
        'attempts2' => $attempts,
        'locked_until2' => $lockedUntil,
    ]);
}

/**
 * Setzt den Zähler nach erfolgreichem Login zurück
 */
function clearFailedLogins(PDO $pdo, string $email): void
{
    $stmt = $pdo->prepare('DELETE FROM login_attempts WHERE identifier = :id');
    $stmt->execute(['id' => loginIdentifier($email)]);
}