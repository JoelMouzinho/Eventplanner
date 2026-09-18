<?php
require_once __DIR__ . '/../backend/controllers/HomeLandingController.php';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>
<body class="landing-page">
    <main class="landing">
        <section class="landing-card">
            <p class="landing-eyebrow">PARTY-ORGANIZER</p>
            <h1>Plane dein Event.<br><span>Einfach & übersichtlich.</span></h1>
            <p class="landing-text">
                Erstelle dein persönliches Event, wähle Unterhaltung, Mobiliar,
                Menü, Energieversorgung und Termin und behalte alles an einem Ort.
            </p>
            <div class="landing-actions">
                <a class="landing-btn primary" href="<?= url('/login/') ?>">Einloggen</a>
                <a class="landing-btn secondary" href="<?= url('/register/') ?>">Kostenlos registrieren</a>
            </div>
            <p class="landing-note">Ein Benutzerkonto ist erforderlich, um den Event-Manager zu nutzen.</p>
        </section>
    </main>
    <script src="<?= url('/js/theme-toggle.js') ?>"></script>
</body>
</html>
