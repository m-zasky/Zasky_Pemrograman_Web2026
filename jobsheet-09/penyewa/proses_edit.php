<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id']);
    $nama_lengkap = trim($_POST['nama_lengkap']);
    $alamat = trim($_POST['alamat']);
    $no_hp = trim($_POST['no_hp']);

    $stmt = $pdo->prepare("UPDATE penyewa SET nama_lengkap = :nama_lengkap, alamat = :alamat, no_hp = :no_hp WHERE id = :id");
    
    $berhasil = $stmt->execute([
        'nama_lengkap' => $nama_lengkap,
        'alamat' => $alamat,
        'no_hp' => $no_hp,
        'id' => $id
    ]);

    if ($berhasil) {
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data penyewa berhasil diupdate!'];
        header("Location: list.php");
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mengupdate data penyewa.'];
        header("Location: edit.php?id=" . $id);
    }
    exit;
}
header("Location: list.php");
exit;
?>