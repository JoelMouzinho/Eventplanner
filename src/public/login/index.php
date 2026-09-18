<?php
require_once __DIR__ . '/../../backend/controllers/LoginController.php';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>
<body>
<?php include __DIR__ . '/../layout/header.php'; ?>

<main>
    <section class="auth-card">
        <div class="intro">
            <h2>Einloggen</h2>
            <p>Melde dich an, um deine Eventplanung wieder aufzurufen.</p>
        </div>

        <?php if ($error !== ''): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= url('/login/') ?>" class="auth-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">

            <label for="email">E-Mail-Adresse</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" autocomplete="email" required>

            <label for="password">Passwort</label>
            <input type="password" id="password" name="password" autocomplete="current-password" required>

            <button type="submit" class="save-btn">Einloggen</button>
        </form>

        <p class="auth-switch">Noch kein Konto? <a href="<?= url('/register/') ?>">Jetzt registrieren</a></p>
    </section>
</main>

<?php include __DIR__ . '/../layout/footer.php'; ?>
<script src="<?= url('/js/theme-toggle.js') ?>"></script>
</body>
</html>
