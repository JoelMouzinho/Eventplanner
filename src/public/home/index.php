<?php
require_once __DIR__ . '/../../backend/controllers/HomeController.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>

<body>

    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main>
        <section class="intro">
            <h2><?= htmlspecialchars($data['name']) ?></h2>
            <p>Nutze die Navigation, um alle Bereiche deines Events zu planen.</p>
            <p><a href="<?= url('/events/') ?>" class="back-link">← Zurück zu Mein Dashboard</a></p>
        </section>

        <?php if ($data['rejected_at']): ?>
            <div class="reject-banner">
                <p><strong>⚠️ Dieses Event wurde abgelehnt.</strong></p>
                <p style="margin-top:8px;">📝 <?= nl2br(htmlspecialchars($data['rejection_reason'])) ?></p>
            </div>
        <?php endif; ?>

        <section class="features">
            <a href="<?= url('/ort/') ?>" class="feature">
                <h3>Ort</h3>
                <p>Wähle den Ort für dein Event aus.</p>
            </a>
            <a href="<?= url('/unterhaltung/') ?>" class="feature">
                <h3>Unterhaltung</h3>
                <p>Wähle passende Unterhaltung für dein Event aus.</p>
            </a>
            <a href="<?= url('/mobilliar/') ?>" class="feature">
                <h3>Mobilliar</h3>
                <p>Plane die Tischordnung und Sitzplätze.</p>
            </a>
            <a href="<?= url('/menue/') ?>" class="feature">
                <h3>Menü</h3>
                <p>Erstelle ein individuelles Menü für deine Gäste.</p>
            </a>
            <a href="<?= url('/energieversorgung/') ?>" class="feature">
                <h3>Energieversorgung</h3>
                <p>Stelle sicher, dass dein Event ausreichend Energie hat.</p>
            </a>
            <a href="<?= url('/termin/') ?>" class="feature">
                <h3>Termin</h3>
                <p>Finde den perfekten Termin für dein Event.</p>
            </a>
            <a href="<?= url('/uebersicht/') ?>" class="feature">
                <h3>Übersicht</h3>
                <p>Behalte alle Informationen auf einen Blick.</p>
            </a>
        </section>
    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <script src="<?= url('/js/theme-toggle.js') ?>"></script>
</body>

</html>