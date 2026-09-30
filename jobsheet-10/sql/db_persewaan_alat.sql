CREATE DATABASE db_persewaan_alat;

-- Skrip Tabel Alat (Adaptasi dari tabel buku Jobsheet 8-9)
CREATE TABLE
    IF NOT EXISTS alat (
        id SERIAL PRIMARY KEY,
        kode_alat VARCHAR(50) UNIQUE NOT NULL,
        nama_alat VARCHAR(100) NOT NULL,
        kategori VARCHAR(50) NOT NULL,
        tarif INT NOT NULL,
        stok INT NOT NULL,
    );

-- Skrip Tabel Penyewa (Adaptasi dari tabel anggota Jobsheet 8-9)
CREATE TABLE
    IF NOT EXISTS penyewa (
        id SERIAL PRIMARY KEY,
        kode_penyewa VARCHAR(50) UNIQUE NOT NULL,
        nama_lengkap VARCHAR(100) NOT NULL,
        no_hp VARCHAR(20) NOT NULL,
        alamat TEXT NOT NULL,
        status_member VARCHAR(50) DEFAULT 'Regular',

    );

-- Penambahan Jobsheet-10
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'petugas'
);


SELECT
    *
FROM
    alat;