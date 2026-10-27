<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../includes/header.php';

$page_title = "Sewa Alat Baru";

// Ambil data penyewa
$stmt_penyewa = $pdo->query("SELECT id, kode_penyewa, nama_lengkap FROM penyewa ORDER BY nama_lengkap ASC");
$penyewa_list = $stmt_penyewa->fetchAll();

// Ambil data alat yang stoknya > 0
$stmt_alat = $pdo->query("SELECT id, kode_alat, nama_alat, stok, tarif FROM alat WHERE stok > 0 ORDER BY nama_alat ASC");
$alat_list = $stmt_alat->fetchAll();
?>

<div class="card">
    <h2>Formulir Peminjaman Alat Outdoor</h2>
    <p class="subtitle">Pilih penyewa dan alat outdoor yang akan disewa.</p>
    <hr class="divider">

    <form method="post" action="proses_tambah.php" id="form-tambah">
        <?php echo csrf_field(); ?>
        <p>
            <label for="id_penyewa">Pilih Penyewa:</label>
            <select id="id_penyewa" name="id_penyewa" required>
                <option value="">-- Pilih Penyewa --</option>
                <?php foreach ($penyewa_list as $p): ?>
                    <option value="<?php echo $p['id']; ?>">
                        <?php echo e($p['kode_penyewa']); ?> - <?php echo e($p['nama_lengkap']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="id_alat">Pilih Alat Outdoor (Stok > 0):</label>
            <select id="id_alat" name="id_alat" required>
                <option value="">-- Pilih Alat --</option>
                <?php foreach ($alat_list as $a): ?>
                    <option value="<?php echo $a['id']; ?>">
                        <?php echo e($a['nama_alat']); ?> (Stok: <?php echo $a['stok']; ?> - Rp <?php echo number_format($a['tarif'], 0, ',', '.'); ?>/hari)
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p style="margin-top: 1.5rem;">
            <button type="submit" class="btn-submit">Proses Peminjaman</button>
            <a href="riwayat.php" class="btn-cancel">Batal</a>
        </p>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>