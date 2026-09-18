<?php
require_once __DIR__ . '/../../backend/controllers/AdminIndexController.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Dashboard - Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>

<body>

    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main>
        <section class="intro">
            <h2>Admin-Dashboard</h2>
            <p>Übersicht über alle Nutzer und Events.</p>
        </section>

        <section class="features">
            <div class="overview-card">
                <h3>👥 Nutzer</h3>
                <p style="font-size:32px; font-weight:bold; color:var(--primary-color);"><?= $stats['userCount'] ?></p>
            </div>

            <div class="overview-card">
                <h3>🎉 Events</h3>
                <p style="font-size:32px; font-weight:bold; color:var(--primary-color);"><?= $stats['eventCount'] ?></p>
            </div>

            <div class="overview-card">
                <h3>🛡️ Admins</h3>
                <p style="font-size:32px; font-weight:bold; color:var(--primary-color);"><?= $stats['adminCount'] ?></p>
            </div>

            <div class="overview-card">
                <h3>✅ Aktive Planer</h3>
                <p style="font-size:32px; font-weight:bold; color:var(--primary-color);">
                    <?= $stats['usersWithEvents'] ?>
                </p>
                <p class="overview-empty">Nutzer mit mind. 1 Event</p>
            </div>

            <?php if ($stats['newestUser']): ?>
                <div class="overview-card">
                    <h3>🆕 Neuster Nutzer</h3>
                    <p><?= htmlspecialchars($stats['newestUser']['email']) ?></p>
                    <p class="overview-empty"><?= htmlspecialchars($stats['newestUser']['created_at']) ?></p>
                </div>
            <?php endif; ?>

            <?php if ($earliestEvent): ?>
                <a href="<?= url('/admin/event-detail.php') ?>?event_id=<?= (int) $earliestEvent['id'] ?>" class="feature overview-card"
                    style="text-align:left;">
                    <h3>⏰ Frühestes Event</h3>
                    <p style="font-weight:bold;"><?= htmlspecialchars($earliestEvent['name']) ?></p>
                    <p>
                        <?= htmlspecialchars($earliestEvent['termin_date']) ?>
                        <?php if ($earliestEvent['termin_time']): ?>
                            um <?= htmlspecialchars($earliestEvent['termin_time']) ?>
                        <?php endif; ?>
                    </p>
                    <p class="overview-empty"><?= htmlspecialchars($earliestEvent['owner_email']) ?></p>
                </a>
            <?php else: ?>
                <div class="overview-card">
                    <h3>⏰ Frühestes Event</h3>
                    <p class="overview-empty">Noch kein Event mit Termin vorhanden.</p>
                </div>
            <?php endif; ?>
        </section>

        <div class="admin-nav">
            <a href="<?= url('/admin/users.php') ?>" class="save-btn" style="text-decoration:none; display:inline-block;">👥 Nutzer
                verwalten</a>
            <a href="<?= url('/admin/events.php') ?>" class="save-btn" style="text-decoration:none; display:inline-block;">🎉 Events
                verwalten</a>
        </div>
    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <script src="<?= url('/js/theme-toggle.js') ?>"></script>
</body>

</html>