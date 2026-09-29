<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id']);
    $nama_alat = trim($_POST['nama_alat']);
    $tarif = trim($_POST['tarif']);
    $stok = trim($_POST['stok']);

    $stmt = $pdo->prepare("UPDATE alat SET nama_alat = :nama_alat, tarif = :tarif, stok = :stok WHERE id = :id");
    
    $berhasil = $stmt->execute([
        'nama_alat' => $nama_alat,
        'tarif' => $tarif,
        'stok' => $stok,
        'id' => $id
    ]);

    if ($berhasil) {
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data alat berhasil diupdate!'];
        header("Location: list.php");
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mengupdate data alat.'];
        header("Location: edit.php?id=" . $id);
    }
    exit;
}
header("Location: list.php");
exit;
?>