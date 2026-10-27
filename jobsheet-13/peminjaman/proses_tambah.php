<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$id_penyewa = (int)($_POST['id_penyewa'] ?? 0);
$id_alat    = (int)($_POST['id_alat'] ?? 0);

if ($id_penyewa <= 0 || $id_alat <= 0) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Penyewa dan Alat wajib dipilih!'];
    header('Location: tambah.php');
    exit;
}

try {
    // 1. Mulai DB Transaction
    $pdo->beginTransaction();

    // 2. Lock Row Alat (SELECT ... FOR UPDATE) untuk mencegah race condition stok
    $stmt = $pdo->prepare("SELECT stok FROM alat WHERE id = :id FOR UPDATE");
    $stmt->execute(['id' => $id_alat]);
    $alat = $stmt->fetch();

    if (!$alat || $alat['stok'] <= 0) {
        $pdo->rollBack();
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Stok alat sudah habis atau tidak ditemukan!'];
        header('Location: tambah.php');
        exit;
    }

    // 3. Insert Transaksi Peminjaman Baru
    $stmt_insert = $pdo->prepare("INSERT INTO peminjaman (id_penyewa, id_alat, tanggal_pinjam, status) VALUES (:id_penyewa, :id_alat, CURRENT_DATE, 'dipinjam')");
    $stmt_insert->execute([
        'id_penyewa' => $id_penyewa,
        'id_alat'    => $id_alat
    ]);

    // 4. Kurangi Stok Alat (-1)
    $stmt_update = $pdo->prepare("UPDATE alat SET stok = stok - 1 WHERE id = :id");
    $stmt_update->execute(['id' => $id_alat]);

    // 5. Commit Transaction
    $pdo->commit();

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Transaksi peminjaman berhasil diproses!'];
    header('Location: kembali.php');
    exit;

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memproses peminjaman: ' . $e->getMessage()];
    header('Location: tambah.php');
    exit;
}