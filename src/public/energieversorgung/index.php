<?php
require_once __DIR__ . '/../../backend/controllers/EnergieversorgungController.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energieversorgung - Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>

<body>

    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main>
        <section class="intro">
            <h2>Energieversorgung auswählen</h2>
            <p>Event: <strong><?= htmlspecialchars($data['name']) ?></strong></p>
        </section>

        <?php if (isset($_GET['saved'])): ?>
            <p class="success" style="text-align:center; margin-bottom:20px;">✅ Gespeichert!</p>
        <?php endif; ?>

        <form method="post" action="<?= url('/energieversorgung/') ?>">
            <section class="features">

                <label class="feature">
                    <input type="checkbox" name="energie[]" value="stromanschluss" <?= isChecked($selectedEnergie, 'stromanschluss') ?>>
                    <h3>Stromanschluss</h3>
                    <p>Standard Stromversorgung vor Ort nutzen.</p>
                </label>

                <label class="feature">
                    <input type="checkbox" name="energie[]" value="generator" <?= isChecked($selectedEnergie, 'generator') ?>>
                    <h3>Generator</h3>
                    <p>Mobiler Generator für unabhängige Stromversorgung.</p>
                </label>

                <label class="feature">
                    <input type="checkbox" name="energie[]" value="verlaengerung" <?= isChecked($selectedEnergie, 'verlaengerung') ?>>
                    <h3>Verlängerungskabel</h3>
                    <p>Zusätzliche Kabel für flexible Stromverteilung.</p>
                </label>

                <label class="feature">
                    <input type="checkbox" name="energie[]" value="beleuchtung" <?= isChecked($selectedEnergie, 'beleuchtung') ?>>
                    <h3>Beleuchtung</h3>
                    <p>Zusätzliche Lichtquellen für dein Event.</p>
                </label>

                <label class="feature">
                    <input type="checkbox" name="energie[]" value="notstrom" <?= isChecked($selectedEnergie, 'notstrom') ?>>
                    <h3>Notstrom</h3>
                    <p>Backup-Lösung für Stromausfälle.</p>
                </label>

                <label class="feature">
                    <input type="checkbox" name="energie[]" value="technik" <?= isChecked($selectedEnergie, 'technik') ?>>
                    <h3>Technik-Anschlüsse</h3>
                    <p>Anschlüsse für Musik, Bühne und Geräte.</p>
                </label>

            </section>

            <div style="text-align:center; margin-top:30px;">
                <button type="submit" class="save-btn">Speichern</button>
                <a href="<?= url('/termin/') ?>" class="next-link">Weiter zu Termin →</a>
            </div>
        </form>
    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <script src="<?= url('/js/theme-toggle.js') ?>"></script>
</body>

</html>