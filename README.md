# Eventplanner

## Struktur
- `src/public/` – Frontend / Views / Assets (bestehende URLs bleiben erhalten)
- `src/backend/` – Backend: Controller, Services, Middleware, DB-Konfiguration und Routes
- `sql/` – Datenbankschema und Migrationen

## Start
Den Apache-DocumentRoot auf `src/public` setzen (wie beim bisherigen Projekt). Danach die bestehende URL des Projekts öffnen.

Die bestehende serverseitige PHP-Funktionalität wurde beibehalten. Es wurden keine Formulare, Seiten oder Abläufe auf eine neue API umgestellt.
