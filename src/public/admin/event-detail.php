<?php
require_once __DIR__ . '/../../backend/controllers/AdminEventDetailController.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party-Details - Admin</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>

<body>

    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main>
        <section class="intro">
            <h2><?= $data ? htmlspecialchars($data['name']) : 'Event nicht gefunden' ?></h2>
            <?php if ($data): ?>
                <p>Besitzer: <strong><?= htmlspecialchars($data['owner_email']) ?></strong></p>
                <?php if ($data['rejected_at']): ?>
                    <p><span class="status-badge rejected">Abgelehnt</span></p>
                <?php endif; ?>
            <?php endif; ?>
            <p><a href="<?= url('/admin/events.php') ?>" class="back-link">← Zurück zur Event-Verwaltung</a></p>
        </section>

        <?php if ($error !== ''): ?>
            <div class="error-message" style="max-width:500px; margin:0 auto 20px;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!$data): ?>
            <p class="overview-empty" style="text-align:center;">Dieses Event existiert nicht (mehr).</p>
        <?php else: ?>

            <section class="features">

                <div class="overview-card">
                    <h3>📍 Ort</h3>
                    <?php if (!empty($data['ort'])): ?>
                        <p><?= htmlspecialchars($ortLabels[$data['ort']] ?? $data['ort']) ?></p>
                    <?php else: ?>
                        <p class="overview-empty">Kein Ort gewählt</p>
                    <?php endif; ?>
                </div>

                <div class="overview-card">
                    <h3>🎉 Unterhaltung</h3>
                    <?php if (!empty($data['unterhaltung'])): ?>
                        <ul class="overview-list">
                            <?php foreach ($data['unterhaltung'] as $item): ?>
                                <li><?= htmlspecialchars($unterhaltungLabels[$item] ?? $item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="overview-empty">Keine Auswahl getroffen</p>
                    <?php endif; ?>
                </div>

                <div class="overview-card">
                    <h3>🪑 Mobiliar</h3>
                    <?php if (!empty($data['mobilliar'])): ?>
                        <ul class="overview-list">
                            <?php foreach ($data['mobilliar'] as $item): ?>
                                <li><?= htmlspecialchars($mobilliarLabels[$item] ?? $item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="overview-empty">Keine Auswahl getroffen</p>
                    <?php endif; ?>
                </div>

                <div class="overview-card">
                    <h3>📄 Menü</h3>
                    <?php if ($data['menue']): ?>
                        <p><?= htmlspecialchars($data['menue']) ?></p>
                    <?php else: ?>
                        <p class="overview-empty">Kein Menü gewählt</p>
                    <?php endif; ?>
                </div>

                <div class="overview-card">
                    <h3>⚡ Energieversorgung</h3>
                    <?php if (!empty($data['energie'])): ?>
                        <ul class="overview-list">
                            <?php foreach ($data['energie'] as $item): ?>
                                <li><?= htmlspecialchars($energieLabels[$item] ?? $item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="overview-empty">Keine Auswahl getroffen</p>
                    <?php endif; ?>
                </div>

                <div class="overview-card overview-termin">
                    <h3>📅 Termin</h3>
                    <?php if ($data['termin_date'] && $data['termin_time']): ?>
                        <p>
                            <?= htmlspecialchars($data['termin_date']) ?> um <?= htmlspecialchars($data['termin_time']) ?>
                            <?php if ($data['termin_endtime']): ?>
                                – <?= htmlspecialchars($data['termin_endtime']) ?>
                            <?php endif; ?>
                        </p>
                    <?php else: ?>
                        <p class="overview-empty">Kein Termin festgelegt</p>
                    <?php endif; ?>

                    <?php if ($data['termin_notes']): ?>
                        <div class="overview-notes">📝 <?= nl2br(htmlspecialchars($data['termin_notes'])) ?></div>
                    <?php endif; ?>
                </div>

            </section>

            <div class="admin-nav">
                <p class="overview-empty" style="width:100%; text-align:center;">
                    Angelegt am <?= htmlspecialchars($data['created_at']) ?>,
                    zuletzt geändert am <?= htmlspecialchars($data['updated_at']) ?>
                </p>
            </div>

            <?php if ($data['rejected_at']): ?>
                <div class="reject-banner" style="text-align:center;">
                    <p><strong>Abgelehnt am <?= htmlspecialchars($data['rejected_at']) ?></strong></p>
                    <p style="margin-top:8px;">📝 <?= nl2br(htmlspecialchars($data['rejection_reason'])) ?></p>
                </div>
                <div class="admin-nav">
                    <form method="post" action="<?= url('/admin/event-detail.php') ?>?event_id=<?= (int) $eventId ?>">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
                        <input type="hidden" name="action" value="unreject">
                        <button type="submit" class="admin-link-btn">Ablehnung zurücknehmen</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="overview-card" style="max-width:500px; margin:0 auto 20px;">
                    <h3>🚫 Event ablehnen</h3>
                    <form method="post" action="<?= url('/admin/event-detail.php') ?>?event_id=<?= (int) $eventId ?>" class="reject-form">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
                        <input type="hidden" name="action" value="reject">
                        <label for="reason">Begründung:</label>
                        <textarea id="reason" name="reason" rows="3" placeholder="Warum wird dieses Event abgelehnt?"
                            required></textarea>
                        <button type="submit" class="reject-btn">Event ablehnen</button>
                    </form>
                </div>
            <?php endif; ?>

            <div class="admin-nav">
                <form method="post" action="<?= url('/admin/event-detail.php') ?>?event_id=<?= (int) $eventId ?>"
                    onsubmit="return confirm('Dieses Event wirklich löschen?');">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit" class="event-delete-btn">Event löschen</button>
                </form>
            </div>

        <?php endif; ?>
    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <script src="<?= url('/js/theme-toggle.js') ?>"></script>
</body>

</html>