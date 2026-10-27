<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$id           = (int)($_POST['id'] ?? 0);
$nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
$alamat       = trim($_POST['alamat'] ?? '');
$no_hp        = trim($_POST['no_hp'] ?? '');

if ($id <= 0 || $nama_lengkap === '' || $alamat === '' || $no_hp === '') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data input tidak valid.'];
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("UPDATE penyewa SET nama_lengkap = :nama, alamat = :alamat, no_hp = :no_hp WHERE id = :id");
$stmt->execute([
    'id'     => $id,
    'nama'   => $nama_lengkap,
    'alamat' => $alamat,
    'no_hp'  => $no_hp
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data penyewa berhasil diperbarui!'];
header('Location: list.php');
exit;