<?php
require_once __DIR__ . '/../../backend/controllers/MobilliarController.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobilliar - Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>

<body>

    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main>
        <section class="intro">
            <h2>Mobiliar auswählen</h2>
            <p>Event: <strong><?= htmlspecialchars($data['name']) ?></strong></p>
        </section>

        <?php if (isset($_GET['saved'])): ?>
            <p class="success" style="text-align:center; margin-bottom:20px;">✅ Gespeichert!</p>
        <?php endif; ?>

        <form method="post" action="<?= url('/mobilliar/') ?>">
            <section class="features">

                <label class="feature">
                    <input type="checkbox" name="mobilliar[]" value="stuehle" <?= isChecked($selectedMobilliar, 'stuehle') ?>>
                    <h3>Stühle</h3>
                    <p>Sitzgelegenheiten für deine Gäste.</p>
                </label>

                <label class="feature">
                    <input type="checkbox" name="mobilliar[]" value="tische" <?= isChecked($selectedMobilliar, 'tische') ?>>
                    <h3>Tische</h3>
                    <p>Tische für Essen, Getränke und Deko.</p>
                </label>

                <label class="feature">
                    <input type="checkbox" name="mobilliar[]" value="grill" <?= isChecked($selectedMobilliar, 'grill') ?>>
                    <h3>Grill</h3>
                    <p>Grill für Speisen direkt vor Ort.</p>
                </label>

                <label class="feature">
                    <input type="checkbox" name="mobilliar[]" value="bar" <?= isChecked($selectedMobilliar, 'bar') ?>>
                    <h3>Bar</h3>
                    <p>Bar-Theke für Getränke und Ausschank.</p>
                </label>

            </section>

            <div style="text-align:center; margin-top:30px;">
                <button type="submit" class="save-btn">Speichern</button>
                <a href="<?= url('/menue/') ?>" class="next-link">Weiter zu Menü →</a>
            </div>
        </form>
    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <script src="<?= url('/js/theme-toggle.js') ?>"></script>
</body>

</html>