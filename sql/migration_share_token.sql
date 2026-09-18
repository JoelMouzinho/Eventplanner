-- ============================================
-- Migration: Freigabe-Link für Events
-- In phpMyAdmin im Reiter "SQL" auf der Datenbank ausführen
-- ============================================

ALTER TABLE events
    ADD COLUMN share_token VARCHAR(64) NULL UNIQUE AFTER id;