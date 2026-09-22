<?php 
require_once __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php'; 

// Ambil data penyewa langsung dari database PostgreSQL
try {
    $stmt = $pdo->query("SELECT * FROM penyewa ORDER BY id DESC");
    $data_penyewa = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $data_penyewa = [];
}
?>

<div class="card-container">
    <h2 class="page-title">Daftar Penyewa Rental Outdoor</h2>
    <div class="divider"></div>

    <?php if (isset($_SESSION['flash_penyewa'])): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
            <?= $_SESSION['flash_penyewa']; unset($_SESSION['flash_penyewa']); ?>
        </div>
    <?php endif; ?>

    <div class="search-box">
        <input type="text" id="search-input" placeholder="Ketik untuk mencari data...">
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Penyewa</th>
                    <th>Nama Penyewa</th>
                    <th>No WhatsApp</th>
                    <th>Alamat</th>
                    <th>Status Member</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data_penyewa)): ?>
                    <?php foreach ($data_penyewa as $index => $item): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($item['kode_penyewa']); ?></td>
                            <td><?= htmlspecialchars($item['nama_lengkap']); ?></td>
                            <td><?= htmlspecialchars($item['no_hp']); ?></td>
                            <td><?= htmlspecialchars($item['alamat']); ?></td>
                            <td><?= htmlspecialchars($item['status_member']); ?></td>
                            <td>
                                <a href="edit.php?id=<?= $item['id']; ?>" class="btn-action btn-edit">Edit</a>
                                <a href="hapus.php?id=<?= $item['id']; ?>" class="btn-action btn-hapus" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">Belum ada data penyewa.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>