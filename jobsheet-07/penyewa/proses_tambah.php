<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = trim($_POST['kode_penyewa'] ?? '');
    $nama = trim($_POST['nama_lengkap'] ?? '');
    $hp = trim($_POST['no_hp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    if (empty($kode) || empty($nama) || empty($hp) || empty($alamat)) {
        $_SESSION['error_penyewa'] = "Gagal! Semua kolom penyewa wajib diisi.";
        header("Location: tambah.php");
        exit;
    }

    if (!isset($_SESSION['penyewa'])) {
        $_SESSION['penyewa'] = [];
    }

    $_SESSION['penyewa'][] = [
        'kode' => $kode,
        'nama' => $nama,
        'hp' => $hp,
        'alamat' => $alamat,
        'status' => 'Regular' // Default status
    ];

    $_SESSION['flash_penyewa'] = "Data penyewa [$nama] berhasil ditambahkan!";
    header("Location: list.php");
    exit;
}