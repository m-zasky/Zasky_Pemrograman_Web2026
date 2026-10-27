<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$kode_penyewa = trim($_POST['kode_penyewa'] ?? '');
$nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
$no_hp        = trim($_POST['no_hp'] ?? '');
$alamat       = trim($_POST['alamat'] ?? '');

if ($kode_penyewa === '' || $nama_lengkap === '' || $no_hp === '' || $alamat === '') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Semua kolom wajib diisi.'];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare("INSERT INTO penyewa (kode_penyewa, nama_lengkap, no_hp, alamat) VALUES (:kode, :nama, :no_hp, :alamat)");
$stmt->execute([
    'kode'   => $kode_penyewa,
    'nama'   => $nama_lengkap,
    'no_hp'  => $no_hp,
    'alamat' => $alamat
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data penyewa berhasil ditambahkan!'];
header('Location: list.php');
exit;