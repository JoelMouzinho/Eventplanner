<?php
require_once __DIR__ . '/../../backend/controllers/BudgetController.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget - Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>

<body>

    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main>
        <section class="intro">
            <h2>Budget</h2>
            <p>Event: <strong><?= htmlspecialchars($data['name']) ?></strong></p>
            <p>Die Kosten werden automatisch aus deiner Auswahl bei Ort, Unterhaltung, Mobiliar, Menü und
                Energieversorgung berechnet.</p>
        </section>

        <?php if (isset($_GET['saved'])): ?>
            <p class="success" style="text-align:center; margin-bottom:20px;">✅ Gespeichert!</p>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="error-message" style="max-width:500px; margin:0 auto 20px;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="auth-card" style="max-width:420px; margin:0 auto 20px;">
            <h3 style="margin-bottom:15px;">Dein Budget</h3>

            <form method="post" action="<?= url('/budget/') ?>" class="auth-form">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
                <input type="hidden" name="action" value="set_limit">

                <label for="budget_limit">Maximales Budget (CHF)</label>
                <input type="number" id="budget_limit" name="budget_limit" step="0.01" min="0"
                    value="<?= $budget['limit'] !== null ? htmlspecialchars((string) $budget['limit']) : '' ?>"
                    placeholder="z.B. 2000">

                <button type="submit" class="save-btn">Budget speichern</button>
            </form>
        </div>

        <?php if ($budget['limit'] !== null): ?>
            <div class="budget-status <?= $budget['fits'] ? 'budget-status--ok' : 'budget-status--over' ?>">
                <?php if ($budget['fits']): ?>
                    ✅ Passt ins Budget — noch CHF <?= number_format($budget['difference'], 2, '.', "'") ?> Spielraum.
                <?php else: ?>
                    ❌ Passt nicht ins Budget — CHF <?= number_format(abs($budget['difference']), 2, '.', "'") ?> zu
                    viel.
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <section class="features" style="margin-bottom:30px;">
            <div class="overview-card">
                <h3>💰 Berechnete Kosten</h3>
                <p style="font-size:28px; font-weight:bold; color:var(--primary-color);">
                    CHF <?= number_format($budget['total'], 2, '.', "'") ?>
                </p>
                <p class="overview-empty">Automatisch aus deiner Auswahl berechnet</p>
            </div>

            <?php if ($budget['limit'] !== null): ?>
                <div class="overview-card">
                    <h3>🎯 Dein Budget</h3>
                    <p style="font-size:28px; font-weight:bold; color:var(--primary-color);">
                        CHF <?= number_format($budget['limit'], 2, '.', "'") ?>
                    </p>
                </div>
            <?php endif; ?>
        </section>

        <?php if (empty($budget['items'])): ?>
            <p style="text-align:center; color:#999;">
                Noch keine Auswahl getroffen. Wähle Ort, Unterhaltung, Mobiliar, Menü und Energieversorgung aus — die
                Kosten erscheinen hier automatisch.
            </p>
        <?php else: ?>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Kategorie</th>
                            <th>Auswahl</th>
                            <th>Preis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($budget['items'] as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['categoryLabel']) ?></td>
                                <td><?= htmlspecialchars($item['itemLabel']) ?></td>
                                <td>CHF <?= number_format($item['price'], 2, '.', "'") ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="2" style="text-align:right; font-weight:bold;">Gesamt</td>
                            <td style="font-weight:bold;">CHF <?= number_format($budget['total'], 2, '.', "'") ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div style="text-align:center; margin-top:30px;">
            <a href="<?= url('/uebersicht/') ?>" class="next-link">Weiter zu Übersicht →</a>
        </div>
    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <script src="<?= url('/js/theme-toggle.js') ?>"></script>
</body>

</html>