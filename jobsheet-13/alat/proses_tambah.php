<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$kode_alat = trim($_POST['kode_alat'] ?? '');
$nama_alat = trim($_POST['nama_alat'] ?? '');
$kategori  = trim($_POST['kategori'] ?? '');
$tarif     = (int)($_POST['tarif'] ?? 0);
$stok      = (int)($_POST['stok'] ?? 0);

if ($kode_alat === '' || $nama_alat === '' || $kategori === '') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Semua kolom wajib diisi.'];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare("INSERT INTO alat (kode_alat, nama_alat, kategori, tarif, stok) VALUES (:kode, :nama, :kategori, :tarif, :stok)");
$stmt->execute([
    'kode'     => $kode_alat,
    'nama'     => $nama_alat,
    'kategori' => $kategori,
    'tarif'    => $tarif,
    'stok'     => $stok
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data alat berhasil ditambahkan!'];
header('Location: list.php');
exit;