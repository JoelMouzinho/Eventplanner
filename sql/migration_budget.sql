-- ============================================
-- Migration: Budget-Tracker pro Event
-- In phpMyAdmin im Reiter "SQL" auf der Datenbank ausführen
-- ============================================

ALTER TABLE events
    ADD COLUMN IF NOT EXISTS budget_limit DECIMAL(10,2) NULL DEFAULT NULL AFTER termin_notes;

CREATE TABLE IF NOT EXISTS budget_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    category VARCHAR(32) NOT NULL DEFAULT 'sonstiges',
    label VARCHAR(255) NOT NULL,
    planned_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
    actual_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_budget_items_event_id (event_id),
    CONSTRAINT fk_budget_items_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE ON UPDATE CASCADE
);
