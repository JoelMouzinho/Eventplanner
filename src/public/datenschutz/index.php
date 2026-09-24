<?php
require_once __DIR__ . '/../../backend/controllers/DatenschutzController.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datenschutzerklärung - Party-Organizer</title>
    <link rel="stylesheet" href="<?= url('/css/styles.css') ?>">
</head>

<body>

    <?php include __DIR__ . '/../layout/legal-header.php'; ?>

    <main>
        <section class="legal-page">

            <h1>Datenschutzerklärung</h1>

            <p class="legal-intro">
                Mit dieser Datenschutzerklärung informieren wir darüber, welche
                Personendaten bei der Nutzung von ITKFA Party-Organizer bearbeitet
                werden und zu welchen Zwecken dies erfolgt.
            </p>

            <p>
                <a href="<?= isLoggedIn() ? url('/home/') : url('/') ?>" class="back-link">← Zurück</a>
            </p>

            <section class="legal-section">
                <h2>1. Verantwortliche Stelle</h2>

                <p>
                    Verantwortlich für die Bearbeitung von Personendaten ist:
                </p>

                <p>
                    <strong>Vorname Nachname</strong><br>
                    ITKFA Party-Organizer<br>
                    Strasse Hausnummer<br>
                    PLZ Ort<br>
                    Schweiz
                </p>

                <p>
                    E-Mail:
                    <a href="mailto:DEINE-EMAIL@BEISPIEL.CH">
                        DEINE-EMAIL@BEISPIEL.CH
                    </a>
                </p>
            </section>

            <section class="legal-section">
                <h2>2. Welche Personendaten werden bearbeitet?</h2>

                <p>
                    Bei der Nutzung von Party-Organizer können insbesondere
                    folgende Daten bearbeitet werden:
                </p>

                <ul>
                    <li>E-Mail-Adresse</li>
                    <li>Vorname und Nachname</li>
                    <li>Telefonnummer, sofern angegeben</li>
                    <li>Passwort bzw. der daraus erzeugte Passwort-Hash</li>
                    <li>von Benutzern erstellte Eventdaten</li>
                    <li>Angaben zu Terminen, Uhrzeiten und Notizen</li>
                    <li>technisch erforderliche Daten für die Anmeldung und Session-Verwaltung</li>
                </ul>
            </section>

            <section class="legal-section">
                <h2>3. Zweck der Datenbearbeitung</h2>

                <p>
                    Die Daten werden insbesondere bearbeitet, um:
                </p>

                <ul>
                    <li>Benutzerkonten zu erstellen und zu verwalten,</li>
                    <li>die Anmeldung und Authentifizierung zu ermöglichen,</li>
                    <li>Events und deren Inhalte zu speichern und anzuzeigen,</li>
                    <li>die vom Benutzer gewünschten Funktionen bereitzustellen,</li>
                    <li>die Sicherheit und Funktionsfähigkeit der Anwendung zu gewährleisten.</li>
                </ul>
            </section>

            <section class="legal-section">
                <h2>4. Benutzerkonto</h2>

                <p>
                    Für die Nutzung bestimmter Funktionen ist die Erstellung eines
                    Benutzerkontos erforderlich. Dabei werden die für die
                    Registrierung notwendigen Angaben gespeichert.
                </p>

                <p>
                    Das Passwort wird nicht im Klartext gespeichert, sondern
                    geschützt verarbeitet.
                </p>
            </section>

            <section class="legal-section">
                <h2>5. Events</h2>

                <p>
                    Wenn Benutzer Events erstellen, werden die eingegebenen
                    Eventdaten gespeichert, damit diese innerhalb des jeweiligen
                    Benutzerkontos bereitgestellt und verwaltet werden können.
                </p>
            </section>

            <section class="legal-section">
                <h2>6. Löschung des Benutzerkontos</h2>

                <p>
                    Benutzer können ihr Benutzerkonto über die dafür vorgesehene
                    Funktion löschen. Soweit keine gesetzlichen Aufbewahrungspflichten
                    oder andere rechtlich zulässige Gründe entgegenstehen, werden
                    die mit dem Benutzerkonto verbundenen Daten gelöscht.
                </p>
            </section>

            <section class="legal-section">
                <h2>7. Cookies und Sessions</h2>

                <p>
                    Party-Organizer kann technisch notwendige Cookies bzw.
                    Session-Daten verwenden, die für die Anmeldung und den Betrieb
                    der Anwendung erforderlich sind.
                </p>

                <p>
                    Solche technisch notwendigen Daten dienen insbesondere dazu,
                    Benutzer angemeldet zu halten und die Anwendung sicher
                    bereitzustellen.
                </p>
            </section>

            <section class="legal-section">
                <h2>8. Server- und Logdaten</h2>

                <p>
                    Beim Aufruf der Website können durch den Hosting-Anbieter
                    technisch bedingte Informationen verarbeitet werden. Dazu
                    können insbesondere IP-Adresse, Datum und Uhrzeit des Zugriffs,
                    angeforderte Ressourcen sowie technische Informationen zum
                    verwendeten Browser gehören.
                </p>

                <p>
                    Diese Daten dienen insbesondere dem sicheren und stabilen
                    Betrieb der Website.
                </p>
            </section>

            <section class="legal-section">
                <h2>9. Weitergabe an Dritte</h2>

                <p>
                    Personendaten werden grundsätzlich nicht verkauft.
                </p>

                <p>
                    Eine Weitergabe kann erfolgen, soweit dies für den technischen
                    Betrieb der Anwendung erforderlich ist, beispielsweise an
                    Hosting- oder IT-Dienstleister, oder wenn eine gesetzliche
                    Verpflichtung dazu besteht.
                </p>
            </section>

            <section class="legal-section">
                <h2>10. Bearbeitung im Ausland</h2>

                <p>
                    Sofern bei der Nutzung von Dienstleistern Personendaten in ein
                    anderes Land übermittelt oder dort bearbeitet werden, werden
                    die dafür geltenden datenschutzrechtlichen Anforderungen
                    berücksichtigt.
                </p>
            </section>

            <section class="legal-section">
                <h2>11. Datensicherheit</h2>

                <p>
                    Es werden angemessene technische und organisatorische
                    Massnahmen eingesetzt, um Personendaten vor unbefugtem Zugriff,
                    Verlust, Veränderung oder Missbrauch zu schützen.
                </p>
            </section>

            <section class="legal-section">
                <h2>12. Aufbewahrungsdauer</h2>

                <p>
                    Personendaten werden grundsätzlich nur so lange aufbewahrt,
                    wie dies für den jeweiligen Zweck erforderlich ist oder
                    gesetzliche Aufbewahrungspflichten bestehen.
                </p>
            </section>

            <section class="legal-section">
                <h2>13. Rechte betroffener Personen</h2>

                <p>
                    Betroffene Personen haben nach den gesetzlichen Voraussetzungen
                    insbesondere das Recht, Auskunft über die Bearbeitung ihrer
                    Personendaten zu verlangen. Je nach Situation bestehen zudem
                    Rechte auf Berichtigung oder Löschung sowie weitere Rechte nach
                    dem geltenden Datenschutzrecht.
                </p>

                <p>
                    Für entsprechende Anliegen kann die oben genannte
                    verantwortliche Stelle kontaktiert werden.
                </p>
            </section>

            <section class="legal-section">
                <h2>14. Änderungen</h2>

                <p>
                    Diese Datenschutzerklärung kann angepasst werden, wenn sich
                    die Datenbearbeitungen, technischen Gegebenheiten oder
                    rechtlichen Anforderungen ändern.
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