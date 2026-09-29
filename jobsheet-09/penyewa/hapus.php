<?php
// Pastikan session dimulai dengan aman
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM penyewa WHERE id = :id");
        if ($stmt->execute(['id' => $id])) {
            $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data penyewa berhasil dihapus!'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus data penyewa.'];
        }
    }
}

// Kembali ke halaman list
header("Location: list.php");
exit;
?>