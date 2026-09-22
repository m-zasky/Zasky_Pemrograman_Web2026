<?php include '../includes/header.php'; ?>

<div class="card-container">
    <h2 class="page-title">Daftar Alat Outdoor</h2>
    <div class="divider"></div>

    <?php if (isset($_SESSION['flash_alat'])): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
            <?= $_SESSION['flash_alat']; unset($_SESSION['flash_alat']); ?>
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
                    <th>Kode Alat</th>
                    <th>Nama Alat</th>
                    <th>Kategori</th>
                    <th>Tarif / Hari</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($_SESSION['alat'])): ?>
                    <?php foreach ($_SESSION['alat'] as $index => $item): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($item['kode']); ?></td>
                            <td><?= htmlspecialchars($item['nama']); ?></td>
                            <td><?= htmlspecialchars($item['kategori']); ?></td>
                            <td>Rp <?= number_format($item['tarif'], 0, ',', '.'); ?></td>
                            <td><?= htmlspecialchars($item['stok']); ?></td>
                            <td>
                                <button type="button" class="btn-action btn-edit">Edit</button>
                                <button type="button" class="btn-action btn-hapus">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">Belum ada data alat.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>