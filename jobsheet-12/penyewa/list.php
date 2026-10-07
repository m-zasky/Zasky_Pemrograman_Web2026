<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../includes/header.php';

$q = trim($_GET['q'] ?? '');

if ($q !== '') {
    $stmt = $pdo->prepare("SELECT * FROM penyewa WHERE nama_lengkap ILIKE :q OR kode_penyewa ILIKE :q OR no_hp ILIKE :q ORDER BY id DESC");
    $stmt->execute(['q' => "%$q%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM penyewa ORDER BY id DESC");
}
$penyewa_list = $stmt->fetchAll();
?>

<div class="card">
    <h2>Daftar Penyewa</h2>
    <p class="subtitle">Kelola data penyewa alat outdoor di sini.</p>
    <hr class="divider">

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash flash-<?php echo $_SESSION['flash']['type']; ?>">
            <?php echo e($_SESSION['flash']['pesan']); ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <p><a href="tambah.php" class="btn-submit">+ Tambah Penyewa Baru</a></p>

    <form method="get" action="list.php" style="margin-bottom: 1.5rem;">
        <input type="text" name="q" value="<?php echo e($q); ?>" placeholder="Cari nama, kode, atau no hp..." style="width: 250px; display: inline-block;">
        <button type="submit" class="btn-cancel">Cari</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Kode Penyewa</th>
                <th>Nama Penyewa</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($penyewa_list)): ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data penyewa yang cocok.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($penyewa_list as $item): ?>
                    <tr>
                        <td><?php echo e($item['kode_penyewa']); ?></td>
                        <td><?php echo e($item['nama_lengkap']); ?></td>
                        <td><?php echo e($item['no_hp']); ?></td>
                        <td><?php echo e($item['alamat']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $item['id']; ?>" class="btn-submit" style="padding: 4px 8px; font-size: 12px;">Edit</a>
                            <form method="post" action="hapus.php" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="btn-cancel" style="padding: 4px 8px; font-size: 12px; background-color: #6b7280;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>