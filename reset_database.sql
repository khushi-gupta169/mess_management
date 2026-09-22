-- Drop all tables in reverse order (to handle foreign keys)
DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS fee_records;
DROP TABLE IF EXISTS extra_meals;
DROP TABLE IF EXISTS holidays;
DROP TABLE IF EXISTS menu_items;
DROP TABLE IF EXISTS menus;
DROP TABLE IF EXISTS kyc_documents;
DROP TABLE IF EXISTS parents;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS migrations;