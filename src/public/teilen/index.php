<?php
require_once __DIR__ . '/../../backend/controllers/ShareController.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data ? htmlspecialchars($data['name']) . ' - ' : '' ?>Geteiltes Event - Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>

<body>

    <header class="site-header">
        <a href="<?= url('/') ?>" class="logo">🎉 Party-Organizer</a>
    </header>

    <main>
        <?php if ($data === null): ?>
            <section class="intro">
                <h2>Link ungültig</h2>
                <p>Dieser Freigabe-Link existiert nicht oder wurde widerrufen.</p>
            </section>
        <?php else: ?>
            <section class="intro">
                <h2><?= htmlspecialchars($data['name']) ?> - Übersicht</h2>
                <p>Du siehst diese Seite über einen geteilten Link. Änderungen sind hier nicht möglich.</p>
            </section>

            <?php if ($data['termin_date']): ?>
                <section class="countdown-box" data-event-date="<?= htmlspecialchars($data['termin_date']) ?>"
                    data-event-time="<?= htmlspecialchars($data['termin_time'] ?: '00:00') ?>">
                    <span class="countdown-label">Bis zum Event:</span>
                    <span class="countdown-value">–</span>
                </section>
            <?php endif; ?>

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

            <div class="step-nav">
                <button type="button" class="save-btn no-print" onclick="window.print()">🖨️ Als PDF speichern /
                    drucken</button>
            </div>
        <?php endif; ?>
    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <script src="<?= url('/js/theme-toggle.js') ?>"></script>
    <?php if ($data && $data['termin_date']): ?>
        <script src="<?= url('/js/countdown.js') ?>"></script>
    <?php endif; ?>
</body>

</html>