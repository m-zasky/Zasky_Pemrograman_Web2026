<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_alat = $_POST['kode_alat'] ?? '';
    $nama_alat = $_POST['nama_alat'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $tarif = $_POST['tarif'] ?? 0;
    $stok = $_POST['stok'] ?? 0;

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
?>