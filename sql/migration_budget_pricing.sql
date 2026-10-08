-- ============================================
-- Migration: Automatischer Budget-Tracker
-- In phpMyAdmin im Reiter "SQL" auf der Datenbank ausführen
-- ============================================

-- Vom Kunden festgelegtes maximales Budget pro Event.
ALTER TABLE events
    ADD COLUMN IF NOT EXISTS budget_limit DECIMAL(10,2) NULL DEFAULT NULL AFTER termin_notes;

-- Preis-Katalog: was jede Auswahlmöglichkeit (Ort, Unterhaltung, Mobiliar,
-- Menü, Energieversorgung) kostet. Wird vom Admin unter /admin/pricing.php
-- gepflegt; der Budget-Tracker rechnet die Auswahl eines Events automatisch
-- anhand dieser Preise zusammen.
CREATE TABLE IF NOT EXISTS pricing_catalog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(32) NOT NULL,
    item_key VARCHAR(64) NOT NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    UNIQUE KEY uniq_category_item (category, item_key)
);

-- Alle bestehenden Auswahlmöglichkeiten mit Platzhalter-Preisen (CHF)
-- vorbelegen. Werte danach unter /admin/pricing.php anpassen.
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
