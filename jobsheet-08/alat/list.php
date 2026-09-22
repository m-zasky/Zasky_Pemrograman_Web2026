<?php 
require_once '../includes/koneksi.php';
include '../includes/header.php'; 

// Logika Pencarian Server-Side (ILIKE)
$keyword = $_GET['q'] ?? '';
if (!empty($keyword)) {
    $sql = "SELECT * FROM alat WHERE nama_alat ILIKE :keyword OR kategori ILIKE :keyword OR kode_alat ILIKE :keyword ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':keyword' => "%$keyword%"]);
} else {
    $sql = "SELECT * FROM alat ORDER BY id DESC";
    $stmt = $pdo->query($sql);
}
$data_alat = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card-container">
    <h2 class="page-title">Daftar Alat Outdoor</h2>
    <div class="divider"></div>

    <?php if (isset($_SESSION['flash_alat'])): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
            <?= $_SESSION['flash_alat']; unset($_SESSION['flash_alat']); ?>
        </div>
    <?php endif; ?>

    <!-- Form Pencarian Server-Side -->
    <form method="GET" action="list.php" class="search-box" style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
        <input type="text" name="q" placeholder="Cari nama, kategori, atau kode..." value="<?= htmlspecialchars($keyword); ?>" style="flex: 1; max-width: 320px; padding: 0.5rem 0.75rem; border: 1px solid #cdd4da; border-radius: 4px;">
        <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem;">Cari</button>
        <?php if (!empty($keyword)): ?>
            <a href="list.php" class="btn btn-secondary" style="padding: 0.5rem 1rem; text-decoration: none; line-height: 1.5;">Reset</a>
        <?php endif; ?>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Alat</th>
                    <th>Nama Alat</th>
                    <th>Kategori</th>
                    <th>Tarif / Hari</th>
                    <th>Stok</th>
                    <th>Tanggal Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data_alat)): ?>
                    <?php foreach ($data_alat as $index => $item): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($item['kode_alat']); ?></td>
                            <td><?= htmlspecialchars($item['nama_alat']); ?></td>
                            <td><?= htmlspecialchars($item['kategori']); ?></td>
                            <td>Rp <?= number_format($item['tarif'], 0, ',', '.'); ?></td>
                            <td><?= htmlspecialchars($item['stok']); ?></td>
                            <td><?= htmlspecialchars($item['tanggal_ditambahkan'] ?? '-'); ?></td>
                            <td>
                                <button type="button" class="btn-action btn-edit">Edit</button>
                                <button type="button" class="btn-action btn-hapus">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">Belum ada data alat di database.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>