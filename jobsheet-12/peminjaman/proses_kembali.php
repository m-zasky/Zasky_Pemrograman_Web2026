<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID Peminjaman tidak valid!'];
    header('Location: kembali.php');
    exit;
}

try {
    // 1. Mulai DB Transaction
    $pdo->beginTransaction();

    // 2. Lock Row Peminjaman
    $stmt = $pdo->prepare("SELECT id_alat, status FROM peminjaman WHERE id = :id FOR UPDATE");
    $stmt->execute(['id' => $id]);
    $peminjaman = $stmt->fetch();

    if (!$peminjaman || $peminjaman['status'] !== 'dipinjam') {
        $pdo->rollBack();
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Transaksi tidak ditemukan atau sudah dikembalikan!'];
        header('Location: kembali.php');
        exit;
    }

    // 3. Update status peminjaman & tanggal kembali
    $stmt_update_p = $pdo->prepare("UPDATE peminjaman SET status = 'kembali', tanggal_kembali = CURRENT_DATE WHERE id = :id");
    $stmt_update_p->execute(['id' => $id]);

    // 4. Kembalikan Stok Alat (+1)
    $stmt_update_a = $pdo->prepare("UPDATE alat SET stok = stok + 1 WHERE id = :id_alat");
    $stmt_update_a->execute(['id_alat' => $peminjaman['id_alat']]);

    // 5. Commit Transaction
    $pdo->commit();

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Alat berhasil dikembalikan dan stok telah bertambah!'];
    header('Location: kembali.php');
    exit;

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memproses pengembalian: ' . $e->getMessage()];
    header('Location: kembali.php');
    exit;
}