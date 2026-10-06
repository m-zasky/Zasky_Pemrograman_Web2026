<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM alat WHERE id = :id");
$stmt->execute(['id' => $id]);
$alat = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$alat) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data alat tidak ditemukan.'];
    header('Location: list.php');
    exit;
}
?>

<div class="card">
    <h2>Edit Data Alat</h2>
    <p class="subtitle">Ubah informasi alat outdoor di bawah ini.</p>
    <hr class="divider">

    <form method="post" action="proses_edit.php">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo e($alat['id']); ?>">
        <p>
            <label for="nama_alat">Nama Alat</label>
            <input type="text" id="nama_alat" name="nama_alat" value="<?php echo e($alat['nama_alat']); ?>" required>
        </p>
        <p>
            <label for="kategori">Kategori</label>
            <input type="text" id="kategori" name="kategori" value="<?php echo e($alat['kategori']); ?>" required>
        </p>
        <p>
            <label for="tarif">Harga Sewa / Hari (Rp)</label>
            <input type="number" id="tarif" name="tarif" value="<?php echo e($alat['tarif']); ?>" required min="0">
        </p>
        <p>
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" value="<?php echo e($alat['stok']); ?>" required min="0">
        </p>
        <p style="margin-top: 1.5rem;">
            <button type="submit">Update Data</button>
            <a href="list.php">Batal</a>
        </p>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>