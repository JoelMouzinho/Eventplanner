-- ============================================
-- Migration: Erweitertes Profil (Telefonnummer)
-- In phpMyAdmin im Reiter "SQL" auf der Datenbank "eventplaner" ausführen
-- ============================================

USE eventplaner;

ALTER TABLE users
    ADD COLUMN IF NOT EXISTS phone VARCHAR(30) DEFAULT NULL AFTER last_name;