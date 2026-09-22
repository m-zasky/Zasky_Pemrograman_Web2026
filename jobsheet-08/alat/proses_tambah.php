<?php
session_start();
require_once '../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = trim($_POST['kode_alat'] ?? '');
    $nama = trim($_POST['nama_alat'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $tarif = trim($_POST['tarif'] ?? '');
    $stok = trim($_POST['stok'] ?? '');

    if (empty($kode) || empty($nama) || empty($kategori) || empty($tarif) || empty($stok)) {
        $_SESSION['error_alat'] = "Gagal! Semua kolom wajib diisi.";
        header("Location: tambah.php");
        exit;
    }

    try {
        $sql = "INSERT INTO alat (kode_alat, nama_alat, kategori, tarif, stok) VALUES (:kode, :nama, :kategori, :tarif, :stok)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':kode' => $kode,
            ':nama' => $nama,
            ':kategori' => $kategori,
            ':tarif' => $tarif,
            ':stok' => $stok
        ]);

        $_SESSION['flash_alat'] = "Data alat [$nama] berhasil ditambahkan ke database!";
        header("Location: list.php");
        exit;

    } catch (PDOException $e) {
        // Menangkap error jika kode_alat kembar (UNIQUE constraint violation = 23505)
        if ($e->getCode() == '23505') {
            $_SESSION['error_alat'] = "Kode alat '$kode' sudah terdaftar! Gunakan kode lain.";
        } else {
            $_SESSION['error_alat'] = "Terjadi kesalahan database: " . $e->getMessage();
        }
        header("Location: tambah.php");
        exit;
    }
}