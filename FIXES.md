# Behobene URL-Fehler

## Ursache
Die Links waren gemischt relativ (`../home/`, `./`), teils hart verdrahtet
(`/Eventplanner/src/public/ort/`) und teils absolut ab Server-Wurzel (`/events/`).
Sobald das Projekt in einem Unterordner lief oder eine URL umgeschrieben wurde,
zeigten sie ins Leere. Dazu kamen falsche `require`-Pfade und eine `.htaccess`
im falschen Ordner.

## Was geändert wurde
1. **Neu: `src/backend/config/url.php`** – `base_path()`, `url()`, `redirect()`.
   Der Basis-Pfad wird automatisch erkannt (DocumentRoot vs. Unterordner) und
   kann per `define('APP_BASE_PATH', '/dein/pfad')` überschrieben werden.
2. **Alle Views** – jeder `href`, `src` und `action` läuft jetzt über `url()`.
   Auch CSS/JS werden dadurch immer gefunden.
3. **Alle Controller** – `header('Location: ...')` + `exit` ersetzt durch `redirect()`.
4. **`src/public/index.php`** ist jetzt der Front-Controller und löst URLs über
   `src/backend/routes/web.php` auf. Die Landing-Page liegt in `src/public/landing.php`.
   Dadurch funktioniert z.B. `/events/quick-create` (Datei heisst `quick-create.php`).
5. **`.htaccess`** liegt jetzt in `src/public/` (dort, wo der DocumentRoot hinzeigt).
   Die Datei im Projekt-Root leitet nur noch nach `src/public/` weiter.
6. **Falsche Include-Pfade repariert**
   - `src/public/index.php`: `../../backend` -> `../backend`
   - `HomeLandingController`: `__DIR__/middleware/auth.php` -> `__DIR__/../middleware/auth.php`
   - `AdminIndexController` hat sich selbst eingebunden und damit gar nichts geladen;
     lädt jetzt Auth, DB, Service und füllt `$stats` und `$earliestEvent`.
7. **Logout** landet auf der Startseite statt auf `/home/` (das sofort zurückgeworfen hätte).
8. Neu: `src/public/404.php` für unbekannte Adressen.

## Start
DocumentRoot auf `src/public` zeigen – oder das Projekt wie bisher unter
`http://localhost/Eventplanner/` öffnen, beides funktioniert jetzt.
