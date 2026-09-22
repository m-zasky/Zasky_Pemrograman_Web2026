<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = trim($_POST['kode_alat'] ?? '');
    $nama = trim($_POST['nama_alat'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $tarif = trim($_POST['tarif'] ?? '');
    $stok = trim($_POST['stok'] ?? '');

    // Validasi murni server-side
    if (empty($kode) || empty($nama) || empty($kategori) || empty($tarif) || empty($stok)) {
        $_SESSION['error_alat'] = "Gagal! Semua kolom wajib diisi.";
        header("Location: tambah.php");
        exit;
    }

    if (!isset($_SESSION['alat'])) {
        $_SESSION['alat'] = [];
    }

    $_SESSION['alat'][] = [
        'kode' => $kode,
        'nama' => $nama,
        'kategori' => $kategori,
        'tarif' => $tarif,
        'stok' => $stok
    ];

    $_SESSION['flash_alat'] = "Data alat [$nama] berhasil ditambahkan!";
    header("Location: list.php");
    exit;
}