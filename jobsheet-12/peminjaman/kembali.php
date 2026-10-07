<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../includes/header.php';

$page_title = "Pengembalian Alat";

// Query daftar alat yang sedang dipinjam
$sql = "SELECT p.id, py.kode_penyewa, py.nama_lengkap, a.nama_alat, p.tanggal_pinjam 
        FROM peminjaman p
        JOIN penyewa py ON p.id_penyewa = py.id
        JOIN alat a ON p.id_alat = a.id
        WHERE p.status = 'dipinjam'
        ORDER BY p.tanggal_pinjam DESC";

$stmt = $pdo->query($sql);
$peminjaman_list = $stmt->fetchAll();
?>

<div class="card">
    <h2>Pengembalian Alat Outdoor</h2>
    <p class="subtitle">Daftar transaksi sewa yang masih aktif (belum dikembalikan).</p>
    <hr class="divider">

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash flash-<?php echo $_SESSION['flash']['type']; ?>">
            <?php echo e($_SESSION['flash']['pesan']); ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Penyewa</th>
                <th>Nama Penyewa</th>
                <th>Nama Alat</th>
                <th>Tgl Pinjam</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($peminjaman_list)): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada alat yang sedang dipinjam saat ini.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($peminjaman_list as $index => $item): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo e($item['kode_penyewa']); ?></td>
                        <td><?php echo e($item['nama_lengkap']); ?></td>
                        <td><?php echo e($item['nama_alat']); ?></td>
                        <td><?php echo e($item['tanggal_pinjam']); ?></td>
                        <td>
                            <form method="post" action="proses_kembali.php" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="btn-submit" onclick="return confirm('Proses pengembalian alat ini?')">Kembalikan</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>