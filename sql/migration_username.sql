USE `h230486_party-organizer`;

ALTER TABLE users
    ADD COLUMN first_name VARCHAR(100) NOT NULL DEFAULT '' AFTER email,
    ADD COLUMN last_name VARCHAR(100) NOT NULL DEFAULT '' AFTER first_name;
SQL