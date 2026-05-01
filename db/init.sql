CREATE DATABASE IF NOT EXISTS donor_db;
CREATE DATABASE IF NOT EXISTS auth_db;

USE donor_db;

CREATE TABLE IF NOT EXISTS pendonors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    golongan_darah VARCHAR(5),
    email VARCHAR(100) UNIQUE
);

CREATE TABLE IF NOT EXISTS stok_darah (
    id INT AUTO_INCREMENT PRIMARY KEY,
    golongan_darah VARCHAR(5) UNIQUE,
    jumlah_kantong INT DEFAULT 0
);

CREATE TABLE IF NOT EXISTS jadwal_donor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pendonor_id INT,
    tanggal_donor DATE,
    lokasi VARCHAR(100),
    FOREIGN KEY (pendonor_id) REFERENCES pendonors(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS riwayat_stok (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stok_id INT,
    tipe ENUM('masuk', 'keluar'),
    jumlah INT,
    keterangan TEXT,
    FOREIGN KEY (stok_id) REFERENCES stok_darah(id)
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