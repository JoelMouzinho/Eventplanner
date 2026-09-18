<?php
require_once __DIR__ . '/../backend/config/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seite nicht gefunden - Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>
<body class="landing-page">
    <main class="landing">
        <section class="landing-card">
            <p class="landing-eyebrow">FEHLER 404</p>
            <h1>Seite nicht gefunden</h1>
            <p class="landing-text">Diese Adresse gibt es nicht (mehr).</p>
            <div class="landing-actions">
                <a class="landing-btn primary" href="<?= url('/') ?>">Zur Startseite</a>
            </div>
        </section>
    </main>
</body>
</html>
