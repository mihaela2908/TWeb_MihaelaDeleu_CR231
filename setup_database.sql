-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS contact_form_db;

-- Use the database
USE contact_form_db;

-- Create table for contact messages
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    submission_date DATETIME NOT NULL,
    is_read BOOLEAN DEFAULT 0
);