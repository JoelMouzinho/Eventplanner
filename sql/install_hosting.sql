-- ============================================
-- Eventplanner - Installation auf dem Webhosting
-- --------------------------------------------
-- Diese Datei in phpMyAdmin auf der BEREITS ANGELEGTEN Datenbank
-- importieren (Reiter "Importieren"). Sie enthaelt bewusst kein
-- CREATE DATABASE, da der Datenbankname vom Hoster vorgegeben wird.
--
-- Benoetigt MySQL 5.7+ oder 8.0 (wegen der JSON-Spalten).
-- ============================================

-- ============================================
-- MyFoods-Eventplaner - Datenbankschema
-- ============================================
-- Benutzer zuerst anlegen, da events.user_id darauf verweist.
USE `h230486_party-organizer`;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    first_name VARCHAR(100) NOT NULL DEFAULT '',
    last_name VARCHAR(100) NOT NULL DEFAULT '',
    phone VARCHAR(30) DEFAULT NULL,
    password_hash VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    share_token VARCHAR(64) NULL UNIQUE,
    name VARCHAR(255) NOT NULL DEFAULT 'Mein Event',
    session_id VARCHAR(64) NULL,
    user_id INT NOT NULL,
    ort VARCHAR(32) DEFAULT NULL,
    unterhaltung JSON DEFAULT NULL,
    mobilliar JSON DEFAULT NULL,
    menue VARCHAR(255) DEFAULT NULL,
    energie JSON DEFAULT NULL,
    termin_date DATE DEFAULT NULL,
    termin_time TIME DEFAULT NULL,
    termin_endtime TIME DEFAULT NULL,
    termin_notes TEXT DEFAULT NULL,
    budget_limit DECIMAL(10,2) NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    rejected_at TIMESTAMP NULL DEFAULT NULL,
    rejection_reason TEXT NULL DEFAULT NULL,
    INDEX idx_events_user_id (user_id),
    CONSTRAINT fk_events_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    identifier VARCHAR(255) NOT NULL,   -- E-Mail + IP kombiniert
    attempts INT NOT NULL DEFAULT 1,
    locked_until DATETIME NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_identifier (identifier)
);

-- Preis-Katalog fuer den automatischen Budget-Tracker: was jede
-- Auswahlmoeglichkeit (Ort, Unterhaltung, Mobiliar, Menue, Energie) kostet.
-- Wird vom Admin unter /admin/pricing.php gepflegt.
CREATE TABLE IF NOT EXISTS pricing_catalog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(32) NOT NULL,
    item_key VARCHAR(64) NOT NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    UNIQUE KEY uniq_category_item (category, item_key)
);

INSERT INTO pricing_catalog (category, item_key, price) VALUES
    ('ort', 'zuhause', 0),
    ('ort', 'veranstaltungsraum', 450),
    ('ort', 'restaurant', 600),
    ('ort', 'draussen', 100),
    ('ort', 'hotel', 800),
    ('ort', 'anderer_ort', 200),

    ('unterhaltung', 'sound', 150),
    ('unterhaltung', 'tv', 50),
    ('unterhaltung', 'karaoke', 120),
    ('unterhaltung', 'band', 900),
    ('unterhaltung', 'spiele', 40),
    ('unterhaltung', 'comedy', 500),

    ('mobilliar', 'stuehle', 80),
    ('mobilliar', 'tische', 100),
    ('mobilliar', 'grill', 60),
    ('mobilliar', 'bar', 150),

    ('menue', 'menue_pauschal', 0),

    ('energie', 'stromanschluss', 0),
    ('energie', 'generator', 180),
    ('energie', 'verlaengerung', 15),
    ('energie', 'beleuchtung', 90),
    ('energie', 'notstrom', 120),
    ('energie', 'technik', 70)
ON DUPLICATE KEY UPDATE price = price;

-- ============================================
-- Nach der ersten Registrierung: dich selbst zum Admin machen.
-- E-Mail anpassen und einzeln ausfuehren.
-- ============================================
-- UPDATE users SET is_admin = 1 WHERE email = 'deine@email.ch';
