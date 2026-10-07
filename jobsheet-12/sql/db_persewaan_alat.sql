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
        tanggal_ditambahkan TIMESTAMP DEFAULT NOW ()
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
        -- Poin 2: Menambahkan kolom timestamp otomatis
        -- Kolom ini menggunakan tipe data TIMESTAMP dengan nilai default fungsi NOW() 
        -- agar sistem secara otomatis mencatat tanggal dan waktu saat data baru dimasukkan
        tanggal_ditambahkan TIMESTAMP DEFAULT NOW ()
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

CREATE TABLE IF NOT EXISTS peminjaman (
    id SERIAL PRIMARY KEY,
    id_penyewa INT NOT NULL REFERENCES penyewa(id) ON DELETE CASCADE,
    id_alat INT NOT NULL REFERENCES alat(id) ON DELETE CASCADE,
    tanggal_pinjam DATE NOT NULL DEFAULT CURRENT_DATE,
    tanggal_kembali DATE NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'dipinjam', -- 'dipinjam' atau 'kembali'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);