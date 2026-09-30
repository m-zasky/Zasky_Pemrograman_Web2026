<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_penyewa = trim($_POST['kode_penyewa'] ?? '');
    $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
    $no_hp = trim($_POST['no_hp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $status_member = trim($_POST['status_member'] ?? 'Regular');

    $stmt = $pdo->prepare("INSERT INTO penyewa (kode_penyewa, nama_lengkap, no_hp, alamat, status_member) VALUES (:kode_penyewa, :nama_lengkap, :no_hp, :alamat, :status_member)");
    
    $berhasil = $stmt->execute([
        'kode_penyewa' => $kode_penyewa,
        'nama_lengkap' => $nama_lengkap,
        'no_hp' => $no_hp,
        'alamat' => $alamat,
        'status_member' => $status_member
    ]);

    if ($berhasil) {
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data penyewa berhasil ditambahkan!'];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menambahkan data penyewa.'];
    }
    
    header("Location: list.php");
    exit;
}

header("Location: list.php");
exit;