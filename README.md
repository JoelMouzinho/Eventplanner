# Party-Organizer (Eventplanner)

Web-App zur Planung von Events: Örtlichkeit, Unterhaltung, Mobiliar, Menü,
Energieversorgung und Termine an einem Ort verwalten, inkl. Übersicht,
Teilen-Funktion per Link und Admin-Bereich.

Live: **https://party-organizer.ch**

## Tech-Stack

- **PHP 8.0+** (kein Framework, eigener schlanker Front-Controller)
- **MySQL 8.0** (nutzt JSON-Spalten, daher ≥ 5.7 nötig)
- Server-seitig gerendertes HTML (PHP-Views), Vanilla CSS/JS
- Apache mit `mod_rewrite` für saubere URLs

> `package.json`, `tsconfig.json` und `nodemon.json` im Projekt-Root stammen
> aus einem frühen Prototyp (Express/EJS) und werden von der aktuellen
> PHP-Anwendung **nicht** mehr verwendet. Sie können bei Bedarf entfernt
> werden.

## Projektstruktur

```
├── src/
│   ├── public/          Document-Root der Domain (einzig öffentlicher Ordner)
│   │   ├── index.php     Front-Controller (routet alle Requests)
│   │   ├── css/          Stylesheet
│   │   ├── js/           Client-JS (Theme-Toggle etc.)
│   │   ├── layout/       Header/Footer-Partials
│   │   └── <seite>/      Eine View je Route, z.B. events/, home/, admin/
│   └── backend/          Nicht öffentlich erreichbar
│       ├── config/       bootstrap.php, database.php, url.php, env.php (lokal)
│       ├── controllers/  Ein Controller je Route
│       ├── services/     EventService, LoginThrottle
│       ├── middleware/   auth.php (Login, CSRF, Session)
│       └── routes/       web.php – zentrale Zuordnung URL → View/Controller
├── sql/
│   ├── schema.sql            Vollständiges Schema für lokale Neuinstallation
│   ├── install_hosting.sql   Schema ohne CREATE DATABASE, für Shared Hosting
│   └── migration_*.sql       Einzelne Migrationen für bestehende Installationen
├── DEPLOY.md             Schritt-für-Schritt-Anleitung fürs Deployment (green.ch)
└── FIXES.md              Log behobener Bugs
```

## Features

- Registrierung, Login (mit Brute-Force-Throttling), Logout
- Event-Verwaltung mit Teilbereichen: Örtlichkeit, Unterhaltung, Mobiliar,
  Menü, Energieversorgung, Termine
- Übersichtsseite pro Event
- Event per Link teilen (`/teilen/`, Token-basiert, ohne Login einsehbar)
- Profil bearbeiten: Name/Telefon, Passwort ändern, E-Mail ändern,
  Konto inkl. aller Events selbst löschen
- Admin-Bereich (Events- und Benutzerverwaltung), zugänglich für Nutzer mit
  `is_admin = 1`
- Impressum & Datenschutzerklärung
- Dark-Mode-Umschalter (Präferenz in `localStorage`)

## Lokale Einrichtung (XAMPP o.ä.)

1. Projekt in den `htdocs`-Ordner legen bzw. Apache-`DocumentRoot` auf
   `src/public` setzen.
2. Datenbank `eventplaner` anlegen und `sql/schema.sql` importieren.
3. Ohne `src/backend/config/env.php` gelten automatisch die
   XAMPP-Standardwerte (Host `localhost`, User `root`, kein Passwort).
   Für abweichende Zugangsdaten `env.example.php` nach `env.php` kopieren
   und anpassen (diese Datei ist in `.gitignore` und wird nicht committet).
4. Seite im Browser öffnen – die URL-Struktur (`/login/`, `/events/`, …)
   funktioniert dank `.htaccess` + Front-Controller direkt mit.

## Deployment

Siehe **[DEPLOY.md](DEPLOY.md)** für die vollständige Anleitung (Domain,
Datenbank, FTP-Upload, `.htaccess`-Varianten, Fehlerbehebung) am Beispiel
des Hostings bei green.ch.

## Sicherheit

- Passwörter werden gehasht gespeichert, nie im Klartext.
- CSRF-Token pro Session für alle Formulare.
- Login-Versuche werden gedrosselt (`LoginThrottle.php`).
- Session-Cookie mit `httponly`, `secure` (bei HTTPS) und `samesite=Lax`.
- `src/backend` und `sql/` liegen ausserhalb des Document-Roots und sind
  über den Browser nicht erreichbar.
- Sicherheits-Header (u. a. `X-Frame-Options`, `X-Content-Type-Options`,
  HSTS) werden über `.htaccess` gesetzt.