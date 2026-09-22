<?php
session_start();
require_once '../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $kode_penyewa = trim($_POST['kode_penyewa'] ?? '');
    $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
    $no_hp = trim($_POST['no_hp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    // Validasi sederhana jika ada kolom kosong
    if (empty($kode_penyewa) || empty($nama_lengkap) || empty($no_hp) || empty($alamat)) {
        $_SESSION['error_penyewa'] = "Gagal! Semua kolom wajib diisi.";
        header("Location: tambah.php");
        exit;
    }

    // Poin 1 Latihan Tambahan: Bungkus dengan try-catch
    try {
        $sql = "INSERT INTO penyewa (kode_penyewa, nama_lengkap, no_hp, alamat) VALUES (:kode, :nama, :hp, :alamat)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':kode' => $kode_penyewa,
            ':nama' => $nama_lengkap,
            ':hp' => $no_hp,
            ':alamat' => $alamat
        ]);

        // Jika sukses
        $_SESSION['flash_penyewa'] = "Data penyewa [$nama_lengkap] berhasil ditambahkan!";
        header("Location: list.php");
        exit;

    } catch (PDOException $e) {
        // Tangani error UNIQUE dengan rapi (Kode 23505 adalah standar PostgreSQL untuk duplikat data)
        if ($e->getCode() == '23505') {
            $_SESSION['error_penyewa'] = "Kode Penyewa '$kode_penyewa' sudah dipakai, gunakan kode lain.";
        } else {
            $_SESSION['error_penyewa'] = "Terjadi kesalahan sistem: " . $e->getMessage();
        }
        
        header("Location: tambah.php");
        exit;
    }
}