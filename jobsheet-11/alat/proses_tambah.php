<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_alat = trim($_POST['kode_alat'] ?? '');
    $nama_alat = trim($_POST['nama_alat'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $tarif = trim($_POST['tarif'] ?? 0);
    $stok = trim($_POST['stok'] ?? 0);

    $stmt = $pdo->prepare("INSERT INTO alat (kode_alat, nama_alat, kategori, tarif, stok) VALUES (:kode_alat, :nama_alat, :kategori, :tarif, :stok)");
    
    $berhasil = $stmt->execute([
        'kode_alat' => $kode_alat,
        'nama_alat' => $nama_alat,
        'kategori' => $kategori,
        'tarif' => $tarif,
        'stok' => $stok
    ]);

    if ($berhasil) {
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data alat berhasil ditambahkan!'];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menambahkan data alat.'];
    }
    
    header("Location: list.php");
    exit;
}

header("Location: list.php");
exit;