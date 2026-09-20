<?php
// Impressum ist öffentlich zugänglich, kein Login erforderlich.
// auth.php wird trotzdem geladen (bringt bootstrap.php mit), damit u.a.
// isLoggedIn() im eigenständigen Header korrekt erkennt, ob der Besucher
// eingeloggt ist (z.B. um "Zur Startseite" richtig zu verlinken).
require_once __DIR__ . '/../middleware/auth.php';
