# Deployment auf green.ch (party-organizer.ch)

Reihenfolge einhalten — jeder Schritt baut auf dem vorherigen auf.

---

## 1. Domain dem Hosting zuweisen

1. Im Kundenportal `my.green.ch` anmelden.
2. **Alle Domänen** → bei `party-organizer.ch` auf das Lupen-Symbol.
3. Hosting-Paket aus dem Dropdown wählen → **Speichern**.

Danach dauert es je nach DNS-Stand einige Stunden, bis die Domain zeigt.
Zum Testen kann in der Zwischenzeit die technische Hosting-Adresse
(vom Control Panel angezeigt) verwendet werden.

---

## 2. Datenbank anlegen

Im **Web & Mail Control Panel** → links **Datenbanken** → neue MySQL-Datenbank.

- Version: **MySQL 8.0** (das Schema nutzt JSON-Spalten, ab 5.7 nötig)
- Zeichensatz: **utf8mb4**

Notiere dir sofort: **Host, Datenbankname, Benutzer, Passwort**.
Der Datenbankname ist bei green.ch vorgegeben und heisst nicht `eventplaner`.

---

## 3. FTP-Benutzer anlegen

Im Control Panel → **FTP** → Benutzer erstellen.
Notiere: **Server, Benutzername, Passwort**.

---

## 4. Document-Root festlegen (wichtig)

Control Panel → **Domains** → bei `party-organizer.ch` auf **Aktionen** →
**Domain bearbeiten**. Dort wird festgelegt, welcher Ordner ausgeliefert wird.

### Variante A (empfohlen)

Ordner auf **`.../party-organizer.ch/src/public`** setzen.

Nur `src/public` ist dann öffentlich, `src/backend` und `sql/` liegen
ausserhalb der Reichweite des Browsers. Das ist die sichere Variante.

### Variante B (falls sich der Ordner nicht ändern lässt)

Document-Root bleibt auf dem Projekt-Ordner. Dann zusätzlich in
`src/backend/config/env.php` eintragen:

```php
'base_path' => '',
```

Die `.htaccess` im Projekt-Root schiebt die Requests dann intern nach
`src/public` und sperrt `src/backend` und `sql` per `[F]`.

---

## 5. Konfiguration vorbereiten (lokal, vor dem Upload)

1. `src/backend/config/env.example.php` kopieren nach
   `src/backend/config/env.php`.
2. Werte aus Schritt 2 eintragen:

```php
return [
    'env'         => 'production',
    'db_host'     => 'ausSchritt2',
    'db_name'     => 'ausSchritt2',
    'db_user'     => 'ausSchritt2',
    'db_pass'     => 'ausSchritt2',
    'db_charset'  => 'utf8mb4',
    'force_https' => true,
];
```

`env.php` steht in der `.gitignore` und bleibt lokal bzw. auf dem Server.
Lokal auf XAMPP brauchst du keine `env.php` — ohne die Datei gelten
weiterhin die XAMPP-Standardwerte (`root`, kein Passwort).

---

## 6. Upload mit FileZilla

**Verbindung:** Server, Benutzer und Passwort aus Schritt 3, Port 21,
Verschlüsselung *"Explizites FTP über TLS"*. Eine Meldung zum Zertifikat
kannst du bestätigen.

**Was hochladen** — je nach Variante aus Schritt 4:

| Variante | Lokal | Ziel auf dem Server |
|---|---|---|
| A | Inhalt von `Eventplanner/` | der Domain-Ordner (`src/`, `sql/`, `.htaccess`) |
| B | Inhalt von `Eventplanner/` | der Domain-Ordner |

**Nicht hochladen:** `node_modules/`, `package-lock.json`, `.git/`.
Die `sql/`-Dateien brauchst du nur einmal für den Import — danach
kannst du den Ordner löschen.

**Versteckte Dateien:** In FileZilla unter *Server → Anzeige versteckter
Dateien erzwingen* einschalten, sonst werden die `.htaccess`-Dateien
nicht mitkopiert. Das ist der häufigste Fehler beim ersten Deployment.

**Übertragungsmodus:** Binär oder Automatisch, nicht ASCII.

---

## 7. Datenbank importieren

Control Panel → **phpMyAdmin** → deine Datenbank links auswählen →
Reiter **Importieren** → Datei `sql/install_hosting.sql` wählen → **OK**.

Diese Datei enthält bewusst kein `CREATE DATABASE`, weil der Name vom
Hoster vorgegeben ist. (Die alte `schema.sql` und die `migration_*.sql`
sind nur für bestehende lokale Installationen.)

Danach sollten die Tabellen `users` und `events` existieren.

---

## 8. Erster Test und Admin-Konto

1. `https://party-organizer.ch` aufrufen → Landing-Page.
2. Registrieren mit deiner E-Mail.
3. In phpMyAdmin im Reiter **SQL** ausführen:

```sql
UPDATE users SET is_admin = 1 WHERE email = 'deine@email.ch';
```

4. Neu einloggen → im Burger-Menü erscheint **Admin-Dashboard**.

---

## 9. PHP-Version prüfen

Control Panel → **Domains** → **Domain bearbeiten** → PHP-Einstellungen.
Der Code braucht **PHP 8.0 oder neuer** (er nutzt typisierte
Rückgabewerte und den `?->`/`??`-Stil). PHP 8.2 oder 8.3 ist eine gute Wahl.

---

## Wenn etwas nicht geht

| Symptom | Ursache |
|---|---|
| **500 Internal Server Error** | Fast immer eine `php_flag`- oder `php_value`-Zeile in einer `.htaccess`. Die wurden hier bereits entfernt — falls du eine alte Version hochgeladen hast, ersetze sie. |
| **Weisse Seite** | PHP-Fehler bei abgeschalteter Anzeige. Im Control Panel das Error-Log ansehen. |
| **403 auf jeder Seite** | Document-Root zeigt auf einen Ordner ohne `index.php`, oder Dateirechte. Ordner `755`, Dateien `644`. |
| **Startseite geht, Unterseiten 404** | `mod_rewrite` greift nicht: `.htaccess` fehlt (versteckte Dateien!) oder wurde nicht in `src/public` hochgeladen. |
| **"Die Anwendung ist gerade nicht erreichbar"** | DB-Zugangsdaten in `env.php` stimmen nicht oder der DB-Host ist nicht `localhost`. |
| **Links zeigen auf `/src/public/...`** | Variante B ohne `'base_path' => ''` in der `env.php`. |
| **Login klappt, aber man ist sofort wieder ausgeloggt** | Session-Cookie mit `secure` über eine `http://`-URL. Immer `https://` aufrufen. |

---

## Danach

- Ein Backup einrichten: phpMyAdmin → **Exportieren** speichert die
  Datenbank als `.sql`. Mach das nach dem ersten echten Einsatz.
- `sql/` und `FIXES.md` vom Server löschen, die gehören nicht ins Web.
