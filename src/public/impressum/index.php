<?php
require_once __DIR__ . '/../../backend/controllers/ImpressumController.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Impressum - Party-Organizer</title>

    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>

<body>

    <?php include __DIR__ . '/../layout/legal-header.php'; ?>

    <main>
        <section class="legal-page">

            <h1>Impressum</h1>

            <p class="legal-intro">
                Angaben zum Betreiber von ITKFA Party-Organizer.
            </p>

            <p>
                <a href="<?= isLoggedIn() ? url('/home/') : url('/') ?>" class="back-link">← Zurück</a>
            </p>

            <section class="legal-section">
                <h2>Betreiber</h2>

                <p>
                    <strong>IT Knowledge Factory</strong><br>
                    Zieglerstrasse 64<br>
                    CH-3007 Bern
                </p>
            </section>

            <section class="legal-section">
                <h2>Kontakt</h2>

                <p>
                    E-Mail:
                    <a href="mailto:contact@it-knowledge-factory.ch">
                        contact@it-knowledge-factory.ch
                    </a>
                </p>

                <p>
                    Telefon: 031 381 26 82
                </p>
            </section>

            <section class="legal-section">
                <h2>Verantwortlich für den Inhalt</h2>

                <p>
                    IT Knowledge Factory<br>
                    oben genannte Adresse
                </p>
            </section>

            <section class="legal-section">
                <h2>Haftung für Inhalte</h2>

                <p>
                    Die Inhalte dieser Website werden mit angemessener Sorgfalt
                    erstellt. Es wird jedoch keine Gewähr für die Richtigkeit,
                    Vollständigkeit und Aktualität der bereitgestellten Inhalte
                    übernommen.
                </p>
            </section>

            <section class="legal-section">
                <h2>Haftung für Links</h2>

                <p>
                    Diese Website kann Links zu externen Websites Dritter enthalten.
                    Auf deren Inhalte und deren Datenschutzpraktiken besteht kein
                    Einfluss. Für die Inhalte externer Websites ist jeweils deren
                    Betreiber verantwortlich.
                </p>
            </section>

            <section class="legal-section">
                <h2>Urheberrecht</h2>

                <p>
                    Die auf dieser Website veröffentlichten Inhalte und Werke
                    unterliegen, soweit gesetzlich möglich, dem Schweizer
                    Urheberrecht. Die Verwendung, Vervielfältigung oder Bearbeitung
                    von Inhalten bedarf grundsätzlich der Zustimmung der jeweiligen
                    Rechteinhaber, sofern keine gesetzliche Ausnahme greift.
                </p>
            </section>

            <p class="legal-date">
                Stand: <?= date('d.m.Y') ?>
            </p>

        </section>
    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <script src="<?= url('/js/theme-toggle.js') ?>"></script>

</body>

</html>