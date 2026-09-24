-- ============================================
-- Migration: Brute-Force-Schutz beim Login
-- In phpMyAdmin im Reiter "SQL" auf der Datenbank ausführen
-- ============================================

CREATE TABLE IF NOT EXISTS login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    identifier VARCHAR(255) NOT NULL,   -- E-Mail + IP kombiniert
    attempts INT NOT NULL DEFAULT 1,
    locked_until DATETIME NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_identifier (identifier)
);