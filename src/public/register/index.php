<?php
require_once __DIR__ . '/../../backend/controllers/RegisterController.php';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrieren - Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>
<body>
<?php include __DIR__ . '/../layout/header.php'; ?>

<main>
    <section class="auth-card">
        <div class="intro">
            <h2>Konto erstellen</h2>
            <p>Registriere dich, damit deine Eventplanung deinem Benutzerkonto zugeordnet wird.</p>
        </div>

        <?php if ($error !== ''): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= url('/register/') ?>" class="auth-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">

            <label for="email">E-Mail-Adresse</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" autocomplete="email" required>

            <label for="password">Passwort</label>
            <input type="password" id="password" name="password" minlength="8" autocomplete="new-password" required>

            <label for="password_confirm">Passwort wiederholen</label>
            <input type="password" id="password_confirm" name="password_confirm" minlength="8" autocomplete="new-password" required>

            <button type="submit" class="save-btn">Registrieren</button>
        </form>

        <p class="auth-switch">Du hast bereits ein Konto? <a href="<?= url('/login/') ?>">Jetzt einloggen</a></p>
    </section>
</main>

<?php include __DIR__ . '/../layout/footer.php'; ?>
<script src="<?= url('/js/theme-toggle.js') ?>"></script>
</body>
</html>
