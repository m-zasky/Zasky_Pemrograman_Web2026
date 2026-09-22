<?php include '../includes/header.php'; ?>

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
                <?php if (!empty($_SESSION['penyewa'])): ?>
                    <?php foreach ($_SESSION['penyewa'] as $index => $item): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($item['kode']); ?></td>
                            <td><?= htmlspecialchars($item['nama']); ?></td>
                            <td><?= htmlspecialchars($item['hp']); ?></td>
                            <td><?= htmlspecialchars($item['alamat']); ?></td>
                            <td><?= htmlspecialchars($item['status']); ?></td>
                            <td>
                                <button type="button" class="btn-action btn-edit">Edit</button>
                                <button type="button" class="btn-action btn-hapus">Hapus</button>
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

<?php include '../includes/footer.php'; ?>