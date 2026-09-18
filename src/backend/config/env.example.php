<?php
// ============================================
// Vorlage fuer die serverspezifische Konfiguration.
// KOPIEREN nach env.php und dort die echten Werte eintragen.
// env.php gehoert NICHT ins Git-Repository.
// ============================================

return [
    'env'         => 'production',   // 'production' auf dem Hosting, 'local' auf XAMPP

    'db_host'     => 'localhost',    // von green.ch im Control Panel angezeigter DB-Host
    'db_name'     => 'DEINE_DB',     // z.B. party_organizer
    'db_user'     => 'DEIN_DB_USER',
    'db_pass'     => 'DEIN_DB_PASSWORT',
    'db_charset'  => 'utf8mb4',

    'force_https' => true,

    // Nur setzen, falls die automatische Pfad-Erkennung danebenliegt:
    // 'base_path' => '',
];
