<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $kode_penyewa = $_POST['kode_penyewa'] ?? '';
    $nama_lengkap = $_POST['nama_lengkap'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $status_member = $_POST['status_member'] ?? 'Regular';

    // Insert menggunakan PDO
    $stmt = $pdo->prepare("INSERT INTO penyewa (kode_penyewa, nama_lengkap, no_hp, alamat, status_member) VALUES (:kode_penyewa, :nama_lengkap, :no_hp, :alamat, :status_member)");
    
    $berhasil = $stmt->execute([
        'kode_penyewa' => $kode_penyewa,
        'nama_lengkap' => $nama_lengkap,
        'no_hp' => $no_hp,
        'alamat' => $alamat,
        'status_member' => $status_member
    ]);

    // Set notifikasi Flash Message
    if ($berhasil) {
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data penyewa berhasil ditambahkan!'];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menambahkan data penyewa.'];
    }
    
    // Redirect kembali ke tabel
    header("Location: list.php");
    exit;
}

header("Location: list.php");
exit;
?>