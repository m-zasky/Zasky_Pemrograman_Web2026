<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM penyewa WHERE id = :id");
$stmt->execute(['id' => $id]);
$penyewa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$penyewa) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data penyewa tidak ditemukan.'];
    header('Location: list.php');
    exit;
}
?>

<div class="card">
    <h2>Edit Data Penyewa</h2>
    <p class="subtitle">Ubah informasi penyewa di bawah ini.</p>
    <hr class="divider">

    <form method="post" action="proses_edit.php">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo e($penyewa['id']); ?>">
        <p>
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo e($penyewa['nama_lengkap']); ?>" required>
        </p>
        <p>
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" value="<?php echo e($penyewa['alamat']); ?>" required>
        </p>
        <p>
            <label for="no_hp">No. HP / WhatsApp</label>
            <input type="text" id="no_hp" name="no_hp" value="<?php echo e($penyewa['no_hp']); ?>" required>
        </p>
        <p style="margin-top: 1.5rem;">
            <button type="submit">Update Data</button>
            <a href="list.php">Batal</a>
        </p>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>