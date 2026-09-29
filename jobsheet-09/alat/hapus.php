<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM alat WHERE id = :id");
        if ($stmt->execute(['id' => $id])) {
            $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data alat berhasil dihapus!'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus data alat.'];
        }
    }
}

header("Location: list.php");
exit;
?>