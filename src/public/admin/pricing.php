<?php
require_once __DIR__ . '/../../backend/controllers/AdminPricingController.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preise - Admin</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>

<body>

    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main>
        <section class="intro">
            <h2>Preise verwalten</h2>
            <p>Lege fest, was jede Auswahlmöglichkeit kostet. Diese Preise fliessen automatisch in den
                Budget-Rechner jedes Events ein.</p>
            <p><a href="<?= url('/admin/') ?>" class="back-link">← Zurück zum Dashboard</a></p>
        </section>

        <?php if ($saved): ?>
            <p class="success" style="text-align:center; margin-bottom:20px;">✅ Preise gespeichert!</p>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="error-message" style="max-width:500px; margin:0 auto 20px;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= url('/admin/pricing.php') ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">

            <?php foreach ($definition as $category => $categoryData): ?>
                <div class="auth-card" style="max-width:600px; margin:0 auto 24px;">
                    <h3 style="margin-bottom:15px;"><?= htmlspecialchars($categoryData['label']) ?></h3>

                    <?php foreach ($categoryData['items'] as $itemKey => $itemLabel): ?>
                        <div class="form-row" style="margin-bottom:10px;">
                            <div class="form-group" style="flex:2;">
                                <label style="margin-top:0;"><?= htmlspecialchars($itemLabel) ?></label>
                            </div>
                            <div class="form-group">
                                <input type="number" step="0.01" min="0"
                                    name="price[<?= htmlspecialchars($category) ?>][<?= htmlspecialchars($itemKey) ?>]"
                                    value="<?= htmlspecialchars((string) ($prices[$category][$itemKey] ?? 0)) ?>">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <div style="text-align:center; margin-top:20px;">
                <button type="submit" class="save-btn">Preise speichern</button>
            </div>
        </form>
    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <script src="<?= url('/js/theme-toggle.js') ?>"></script>
</body>

</html>