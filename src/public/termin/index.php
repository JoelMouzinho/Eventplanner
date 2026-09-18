<?php
require_once __DIR__ . '/../../backend/controllers/TerminController.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termin - Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>

<body>

    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main>
        <section class="intro">
            <h2>Termin festlegen</h2>
            <p>Event: <strong><?= htmlspecialchars($data['name']) ?></strong></p>
        </section>

        <?php if (isset($_GET['saved'])): ?>
            <p class="success" style="text-align:center; margin-bottom:20px;">✅ Gespeichert!</p>
        <?php endif; ?>

        <form method="post" action="<?= url('/termin/') ?>">
            <div class="form-row">
                <div class="form-group">
                    <label for="date">Datum:</label>
                    <input type="date" id="date" class="date-input" name="date"
                        value="<?= htmlspecialchars($data['termin_date']) ?>" min="<?= date('Y-m-d') ?>">
                </div>

                <div class="form-group">
                    <label for="time">Startzeit:</label>
                    <input type="time" id="time" class="time-input" name="time"
                        value="<?= htmlspecialchars($data['termin_time']) ?>">
                </div>

                <div class="form-group">
                    <label for="endTime">Endzeit:</label>
                    <input type="time" id="endTime" class="time-input" name="endTime"
                        value="<?= htmlspecialchars($data['termin_endtime']) ?>">
                </div>
            </div>

            <label for="notes">Notizen:</label>
            <textarea id="notes" class="note-input" name="notes"
                rows="4"><?= htmlspecialchars($data['termin_notes'] ?? '') ?></textarea>

            <div style="text-align:center; margin-top:30px;">
                <button type="submit" class="save-btn">Speichern</button>
                <a href="<?= url('/uebersicht/') ?>" class="next-link">Weiter zu Übersicht →</a>
            </div>
        </form>
    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <script src="<?= url('/js/theme-toggle.js') ?>"></script>
    <script>
        document.querySelector('form').addEventListener('submit', function (e) {
            const time = document.getElementById('time').value;
            const endTime = document.getElementById('endTime').value;
            if (time && endTime && endTime <= time) {
                e.preventDefault();
                alert('Die Endzeit muss nach der Startzeit liegen.');
            }
        });
    </script>
</body>

</html>