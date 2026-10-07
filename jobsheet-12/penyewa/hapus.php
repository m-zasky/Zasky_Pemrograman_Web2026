<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$id = (int)($_POST['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM penyewa WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data penyewa berhasil dihapus!'];
} else {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID data tidak valid.'];
}

header('Location: list.php');
exit;