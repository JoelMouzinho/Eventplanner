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
        </section>

        <?php if (isset($_GET['saved'])): ?>
            <p class="success" style="text-align:center; margin-bottom:20px;">✅ Gespeichert!</p>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="error-message" style="max-width:500px; margin:0 auto 20px;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <section class="features" style="margin-bottom:30px;">
            <div class="overview-card">
                <h3>📝 Geplant</h3>
                <p style="font-size:28px; font-weight:bold; color:var(--primary-color);">
                    CHF <?= number_format($totals['planned'], 2, '.', "'") ?>
                </p>
            </div>

            <div class="overview-card">
                <h3>💰 Tatsächlich</h3>
                <p style="font-size:28px; font-weight:bold; color:var(--primary-color);">
                    CHF <?= number_format($totals['actual'], 2, '.', "'") ?>
                </p>
            </div>

            <div class="overview-card">
                <h3>📊 Differenz</h3>
                <?php $diff = $totals['planned'] - $totals['actual']; ?>
                <p class="<?= $diff < 0 ? 'budget-over' : 'budget-under' ?>" style="font-size:28px; font-weight:bold;">
                    <?= $diff < 0 ? '-' : '+' ?>CHF <?= number_format(abs($diff), 2, '.', "'") ?>
                </p>
            </div>
        </section>

        <div class="auth-card" style="max-width:420px; margin:0 auto 30px;">
            <h3 style="margin-bottom:15px;">Budget-Limit</h3>

            <form method="post" action="<?= url('/budget/') ?>" class="auth-form">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
                <input type="hidden" name="action" value="set_limit">

                <label for="budget_limit">Maximales Budget (CHF, optional)</label>
                <input type="number" id="budget_limit" name="budget_limit" step="0.01" min="0"
                    value="<?= $budgetLimit !== null ? htmlspecialchars((string) $budgetLimit) : '' ?>"
                    placeholder="z.B. 2000">

                <button type="submit" class="save-btn">Limit speichern</button>
            </form>

            <?php if ($budgetLimit !== null): ?>
                <?php if ($totals['actual'] > $budgetLimit): ?>
                    <div class="error-message" style="margin-top:15px;">
                        ⚠️ Budget von CHF <?= number_format($budgetLimit, 2, '.', "'") ?> um
                        CHF <?= number_format($totals['actual'] - $budgetLimit, 2, '.', "'") ?> überschritten.
                    </div>
                <?php else: ?>
                    <p class="success" style="margin-top:15px;">
                        ✅ Noch CHF <?= number_format($budgetLimit - $totals['actual'], 2, '.', "'") ?> Spielraum.
                    </p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="auth-card" style="max-width:600px; margin:0 auto 30px;">
            <h3 style="margin-bottom:15px;">Neuer Posten</h3>

            <form method="post" action="<?= url('/budget/') ?>">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
                <input type="hidden" name="action" value="add_item">

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Kategorie</label>
                        <select id="category" name="category">
                            <?php foreach ($categoryLabels as $key => $categoryLabel): ?>
                                <option value="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($categoryLabel) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group" style="flex:2;">
                        <label for="label">Bezeichnung</label>
                        <input type="text" id="label" name="label" placeholder="z.B. DJ, Catering, Dekoration"
                            maxlength="150" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="planned_amount">Geplant (CHF)</label>
                        <input type="number" id="planned_amount" name="planned_amount" step="0.01" min="0" value="0">
                    </div>

                    <div class="form-group">
                        <label for="actual_amount">Tatsächlich (CHF)</label>
                        <input type="number" id="actual_amount" name="actual_amount" step="0.01" min="0" value="0">
                    </div>
                </div>

                <div style="text-align:center; margin-top:20px;">
                    <button type="submit" class="save-btn">➕ Posten hinzufügen</button>
                </div>
            </form>
        </div>

        <?php if (empty($items)): ?>
            <p style="text-align:center; color:#999;">Noch keine Budget-Posten erfasst.</p>
        <?php else: ?>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Kategorie</th>
                            <th>Bezeichnung</th>
                            <th>Geplant</th>
                            <th>Tatsächlich</th>
                            <th>Differenz</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <?php $itemDiff = (float) $item['planned_amount'] - (float) $item['actual_amount']; ?>
                            <tr>
                                <td><?= htmlspecialchars($categoryLabels[$item['category']] ?? $item['category']) ?></td>
                                <td><?= htmlspecialchars($item['label']) ?></td>
                                <td>CHF <?= number_format((float) $item['planned_amount'], 2, '.', "'") ?></td>
                                <td>CHF <?= number_format((float) $item['actual_amount'], 2, '.', "'") ?></td>
                                <td class="<?= $itemDiff < 0 ? 'budget-over' : 'budget-under' ?>">
                                    <?= $itemDiff < 0 ? '-' : '+' ?>CHF <?= number_format(abs($itemDiff), 2, '.', "'") ?>
                                </td>
                                <td class="admin-actions">
                                    <form method="post" action="<?= url('/budget/') ?>"
                                        onsubmit="return confirm('Diesen Posten wirklich löschen?');">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">
                                        <input type="hidden" name="action" value="delete_item">
                                        <input type="hidden" name="item_id" value="<?= (int) $item['id'] ?>">
                                        <button type="submit" class="event-delete-btn">Löschen</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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
