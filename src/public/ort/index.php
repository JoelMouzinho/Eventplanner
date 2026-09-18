<?php
require_once __DIR__ . '/../../backend/controllers/OrtController.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ort - Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>

<body>

    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main>

        <section class="intro">
            <h2>Ort auswählen</h2>
            <p>Event: <strong><?= htmlspecialchars($data['name']) ?></strong></p>
        </section>

        <?php if (isset($_GET['saved'])): ?>
            <p class="success" style="text-align:center; margin-bottom:20px;">
                ✅ Gespeichert!
            </p>
        <?php endif; ?>

        <form method="post" action="<?= url('/ort/') ?>">

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">

            <section class="features">

                <label class="feature">
                    <input type="radio" name="ort" value="zuhause" <?= isChecked($selectedOrt, 'zuhause') ?>>

                    <h3>🏠 Zuhause</h3>
                    <p>Das Event findet bei dir oder an einer privaten Adresse statt.</p>
                </label>

                <label class="feature">
                    <input type="radio" name="ort" value="veranstaltungsraum" <?= isChecked($selectedOrt, 'veranstaltungsraum') ?>>

                    <h3>🏢 Veranstaltungsraum</h3>
                    <p>Ein gemieteter Raum oder eine spezielle Eventlocation.</p>
                </label>

                <label class="feature">
                    <input type="radio" name="ort" value="restaurant" <?= isChecked($selectedOrt, 'restaurant') ?>>

                    <h3>🍽️ Restaurant</h3>
                    <p>Das Event findet in einem Restaurant statt.</p>
                </label>

                <label class="feature">
                    <input type="radio" name="ort" value="draussen" <?= isChecked($selectedOrt, 'draussen') ?>>

                    <h3>🌳 Draußen</h3>
                    <p>Zum Beispiel im Park, Garten oder auf einer Wiese.</p>
                </label>

                <label class="feature">
                    <input type="radio" name="ort" value="hotel" <?= isChecked($selectedOrt, 'hotel') ?>>

                    <h3>🏨 Hotel</h3>
                    <p>Das Event findet in einem Hotel statt.</p>
                </label>

                <label class="feature">
                    <input type="radio" name="ort" value="anderer_ort" <?= isChecked($selectedOrt, 'anderer_ort') ?>>

                    <h3>📍 Anderer Ort</h3>
                    <p>Der Veranstaltungsort passt zu keiner der anderen Kategorien.</p>
                </label>

            </section>

            <div class="step-nav">

                <button type="submit" class="save-btn">
                    Speichern
                </button>

                <a href="<?= url('/unterhaltung/') ?>" class="next-link">
                    Weiter zu Unterhaltung →
                </a>

            </div>

        </form>

    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <script src="<?= url('/js/theme-toggle.js') ?>"></script>

</body>

</html>