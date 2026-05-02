CREATE DATABASE IF NOT EXISTS donor_db;
CREATE DATABASE IF NOT EXISTS auth_db;

USE donor_db;

DROP TABLE IF EXISTS riwayat_stok;
DROP TABLE IF EXISTS jadwal_donor;
DROP TABLE IF EXISTS stok_darah;
DROP TABLE IF EXISTS pendonors;

CREATE TABLE IF NOT EXISTS pendonors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    golongan_darah VARCHAR(5),
    email VARCHAR(100) UNIQUE
);

CREATE TABLE IF NOT EXISTS stok_darah (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),          
    golongan_darah VARCHAR(5),
    jumlah_kantong INT DEFAULT 0,
    lokasi VARCHAR(100)         
);

INSERT IGNORE INTO stok_darah (nama, golongan_darah, jumlah_kantong, lokasi) VALUES 
('Farouq Adzmi', 'O', 500, 'PMI Jakarta Pusat'),
('Paruk Hensem', 'AB', 250, 'RS Medika'),
('Paruk Ajah', 'A', 300, 'PMI Jakarta Selatan'),
('Farouuuuuuuq', 'B', 150, 'RS Sehat Sejahtera'),
('Paruk Farouq', 'O', 450, 'PMI Jakarta Timur');

CREATE TABLE IF NOT EXISTS jadwal_donor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pendonor_id INT,
    tanggal_donor DATE,
    lokasi VARCHAR(100),
    FOREIGN KEY (pendonor_id) REFERENCES pendonors(id) ON DELETE CASCADE
);
USE auth_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255) NULL,
    email VARCHAR(100) UNIQUE,
    nama VARCHAR(100),
    foto VARCHAR(255),        
    oauth_provider VARCHAR(20) DEFAULT NULL, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT IGNORE INTO users (username, password, email, nama) 
VALUES ('admin', 'admin', 'admin@mail.com', 'Administrator');

