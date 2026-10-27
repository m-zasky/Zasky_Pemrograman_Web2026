<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../includes/header.php';

$page_title = "Riwayat Peminjaman";

// Query riwayat transaksi lengkap dengan JOIN
$sql = "SELECT p.id, py.kode_penyewa, py.nama_lengkap, a.nama_alat, p.tanggal_pinjam, p.tanggal_kembali, p.status 
        FROM peminjaman p
        JOIN penyewa py ON p.id_penyewa = py.id
        JOIN alat a ON p.id_alat = a.id
        ORDER BY p.id DESC";

$stmt = $pdo->query($sql);
$riwayat_list = $stmt->fetchAll();
?>

<div class="card">
    <h2>Riwayat Peminjaman Alat Outdoor</h2>
    <p class="subtitle">Seluruh histori transaksi peminjaman dan pengembalian alat.</p>
    <hr class="divider">

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Penyewa</th>
                <th>Alat Outdoor</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($riwayat_list)): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Belum ada riwayat transaksi.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($riwayat_list as $index => $item): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo e($item['kode_penyewa']); ?> - <?php echo e($item['nama_lengkap']); ?></td>
                        <td><?php echo e($item['nama_alat']); ?></td>
                        <td><?php echo e($item['tanggal_pinjam']); ?></td>
                        <td><?php echo $item['tanggal_kembali'] ? e($item['tanggal_kembali']) : '-'; ?></td>
                        <td>
                            <?php if ($item['status'] === 'dipinjam'): ?>
                                <span style="color: #d97706; font-weight: bold;">Dipinjam</span>
                            <?php else: ?>
                                <span style="color: #059669; font-weight: bold;">Selesai</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>