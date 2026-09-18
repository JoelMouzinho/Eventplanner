<?php
require_once __DIR__ . '/../../backend/controllers/UnterhaltungController.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unterhaltung - Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>

<body>

    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main>
        <section class="intro">
            <h2>Unterhaltung auswählen</h2>
            <p>Event: <strong><?= htmlspecialchars($data['name']) ?></strong></p>
        </section>

        <?php if (isset($_GET['saved'])): ?>
            <p class="success" style="text-align:center; margin-bottom:20px;">✅ Gespeichert!</p>
        <?php endif; ?>

        <form method="post" action="<?= url('/unterhaltung/') ?>">
            <section class="features">

                <label class="feature">
                    <input type="checkbox" name="entertainment[]" value="sound" <?= isChecked($selectedUnterhaltung, 'sound') ?>>
                    <h3>Sound / Musik</h3>
                    <p>Musikanlage und Beschallung für die Feier.</p>
                </label>

                <label class="feature">
                    <input type="checkbox" name="entertainment[]" value="tv" <?= isChecked($selectedUnterhaltung, 'tv') ?>>
                    <h3>TV / Filme</h3>
                    <p>Bildschirm für Filme oder Übertragungen.</p>
                </label>

                <label class="feature">
                    <input type="checkbox" name="entertainment[]" value="karaoke" <?= isChecked($selectedUnterhaltung, 'karaoke') ?>>
                    <h3>Karaoke</h3>
                    <p>Karaoke-Equipment für gesellige Stunden.</p>
                </label>

                <label class="feature">
                    <input type="checkbox" name="entertainment[]" value="band" <?= isChecked($selectedUnterhaltung, 'band') ?>>
                    <h3>Live Band</h3>
                    <p>Live-Musik für besondere Atmosphäre.</p>
                </label>

                <label class="feature">
                    <input type="checkbox" name="entertainment[]" value="spiele" <?= isChecked($selectedUnterhaltung, 'spiele') ?>>
                    <h3>Spiele / Quiz</h3>
                    <p>Gesellschaftsspiele und Quizrunden.</p>
                </label>

                <label class="feature">
                    <input type="checkbox" name="entertainment[]" value="comedy" <?= isChecked($selectedUnterhaltung, 'comedy') ?>>
                    <h3>Comedy / Show</h3>
                    <p>Unterhaltungsprogramm oder Show-Act.</p>
                </label>

            </section>

            <div class="step-nav">
                <button type="submit" class="save-btn">Speichern</button>
                <a href="<?= url('/mobilliar/') ?>" class="next-link">Weiter zu Mobiliar →</a>
            </div>
        </form>
    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <script src="<?= url('/js/theme-toggle.js') ?>"></script>
</body>

</html>