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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    rejected_at TIMESTAMP NULL DEFAULT NULL,
    rejection_reason TEXT NULL DEFAULT NULL,
    INDEX idx_events_user_id (user_id),
    CONSTRAINT fk_events_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ============================================
-- Nach der ersten Registrierung: dich selbst zum Admin machen.
-- E-Mail anpassen und einzeln ausfuehren.
-- ============================================
-- UPDATE users SET is_admin = 1 WHERE email = 'deine@email.ch';
