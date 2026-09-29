CREATE DATABASE db_persewaan_alat;

-- Skrip Tabel Alat (Adaptasi dari tabel buku Jobsheet 8)
CREATE TABLE
    IF NOT EXISTS alat (
        id SERIAL PRIMARY KEY,
        kode_alat VARCHAR(50) UNIQUE NOT NULL,
        nama_alat VARCHAR(100) NOT NULL,
        kategori VARCHAR(50) NOT NULL,
        tarif INT NOT NULL,
        stok INT NOT NULL,
        tanggal_ditambahkan TIMESTAMP DEFAULT NOW ()
    );

-- Skrip Tabel Penyewa (Adaptasi dari tabel anggota Jobsheet 8)
CREATE TABLE
    IF NOT EXISTS penyewa (
        id SERIAL PRIMARY KEY,
        kode_penyewa VARCHAR(50) UNIQUE NOT NULL,
        nama_lengkap VARCHAR(100) NOT NULL,
        no_hp VARCHAR(20) NOT NULL,
        alamat TEXT NOT NULL,
        status_member VARCHAR(50) DEFAULT 'Regular',
        -- Poin 2: Menambahkan kolom timestamp otomatis
        -- Kolom ini menggunakan tipe data TIMESTAMP dengan nilai default fungsi NOW() 
        -- agar sistem secara otomatis mencatat tanggal dan waktu saat data baru dimasukkan
        tanggal_ditambahkan TIMESTAMP DEFAULT NOW ()
    );

SELECT
    *
FROM
    alat;