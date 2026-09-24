<?php
require_once __DIR__ . '/../../backend/controllers/UebersichtController.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Übersicht - Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>

<body>

    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main>
        <section class="intro">
            <h2><?= htmlspecialchars($data['name']) ?> - Übersicht</h2>
            <p>Alle Infos zu deinem Event auf einen Blick.</p>
        </section>

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
            <div class="overview-card no-print" style="max-width:500px; margin:0 auto 20px; text-align:center;">
                <h3>🔗 Event teilen</h3>
                <p style="font-size:0.9rem;">Diesen Link kann jede Person ohne eigenes Konto öffnen (nur ansehen, keine
                    Bearbeitung).</p>
                <input type="text" readonly id="share-link-input" value="<?= htmlspecialchars($shareUrl) ?>"
                    style="width:100%; margin:10px 0; padding:8px; box-sizing:border-box;" onclick="this.select()">
                <button type="button" class="save-btn" id="share-link-copy">Link kopieren</button>
            </div>

            <a href="<?= url('/events/') ?>" class="save-btn" style="text-decoration:none; display:inline-block;">✅
                Fertig
                – zu Mein Dashboard</a>
        </div>

    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <script src="<?= url('/js/theme-toggle.js') ?>"></script>
    <script src="<?= url('/js/countdown.js') ?>"></script>
    <script>
        document.getElementById('share-link-copy').addEventListener('click', function () {
            const input = document.getElementById('share-link-input');
            input.select();
            navigator.clipboard.writeText(input.value).then(function () {
                const btn = document.getElementById('share-link-copy');
                const original = btn.textContent;
                btn.textContent = 'Kopiert ✓';
                setTimeout(function () { btn.textContent = original; }, 2000);
            });
        });
    </script>
</body>

</html>