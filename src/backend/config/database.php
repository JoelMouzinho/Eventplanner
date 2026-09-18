<?php
// ============================================
// Datenbankverbindung
// Zugangsdaten kommen aus config/env.php (siehe env.example.php).
// ============================================

require_once __DIR__ . '/bootstrap.php';

// Kein "charset=..." in der DSN: manche Hoster verwenden eine PDO-MySQL-
// Erweiterung, die gegen eine aeltere libmysqlclient kompiliert ist und
// dort "utf8mb4" nicht als DSN-Charset kennt (Fehler 2019 "Unknown
// character set"), obwohl der MySQL-Server selbst utf8mb4 unterstuetzt.
// Der Zeichensatz wird stattdessen ueber SET NAMES gesetzt, das geht
// immer und ist ausserdem SQL-Injection-sicherer als eine Interpolation.
$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s',
    config('db_host'),
    config('db_port'),
    config('db_name')
);

$charset = config('db_charset', 'utf8mb4');

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '" . $charset . "'",
];

try {
    $pdo = new PDO($dsn, config('db_user'), config('db_pass'), $options);
} catch (PDOException $e) {
    error_log('DB-Verbindung fehlgeschlagen: ' . $e->getMessage());

    if (isProduction()) {
        http_response_code(503);
        exit('Die Anwendung ist gerade nicht erreichbar. Bitte später nochmals versuchen.');
    }

    exit('Datenbankverbindung fehlgeschlagen: ' . $e->getMessage());
}