<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$id        = (int)($_POST['id'] ?? 0);
$nama_alat = trim($_POST['nama_alat'] ?? '');
$kategori  = trim($_POST['kategori'] ?? '');
$tarif     = (int)($_POST['tarif'] ?? 0);
$stok      = (int)($_POST['stok'] ?? 0);

if ($id <= 0 || $nama_alat === '' || $kategori === '') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data input tidak valid.'];
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("UPDATE alat SET nama_alat = :nama, kategori = :kategori, tarif = :tarif, stok = :stok WHERE id = :id");
$stmt->execute([
    'id'       => $id,
    'nama'     => $nama_alat,
    'kategori' => $kategori,
    'tarif'    => $tarif,
    'stok'     => $stok
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data alat berhasil diperbarui!'];
header('Location: list.php');
exit;