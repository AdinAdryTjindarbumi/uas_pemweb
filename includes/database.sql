-- Membuat database 'toko_mebel'
CREATE DATABASE IF NOT EXISTS toko_mebel;

-- Menggunakan database 'toko_mebel'
USE toko_mebel;

-- Tabel untuk menyimpan data inventory
CREATE TABLE IF NOT EXISTS inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price INT NOT NULL
);

-- Tabel untuk menyimpan data employees
CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    position VARCHAR(255) NOT NULL
);