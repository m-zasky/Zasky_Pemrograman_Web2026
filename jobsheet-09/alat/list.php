<?php
$page_title = "Daftar Alat";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$perPage = 10;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM alat WHERE nama_alat ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM alat WHERE nama_alat ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM alat")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM alat ORDER BY id DESC LIMIT :limit OFFSET :offset");
}
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$daftarAlat = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>

<div class="card-container">
    <h2 class="page-title">Daftar Alat</h2>
    
    <div style="margin-bottom: 1.5rem; margin-top: 1rem;">
        <a href="tambah.php" class="btn btn-primary" style="text-decoration: none;">+ Tambah Alat Baru</a>
    </div>

    <?php if ($flash): ?>
        <div class="<?php echo $flash['type'] === 'success' ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo $flash['pesan']; ?>
        </div>
    <?php endif; ?>

    <div class="search-box">
        <form method="get" action="list.php" style="flex-direction: row; align-items: center; gap: 10px; margin-top: 0;">
            <input type="text" id="search-input" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Cari nama alat..." style="width: auto; flex: 1; max-width: 320px; padding: 0.5rem 0.75rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem;">Cari</button>
            <?php if($keyword !== ''): ?>
                <a href="list.php" class="btn btn-secondary" style="padding: 0.5rem 1rem; text-decoration:none;">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama Alat</th>
                    <th>Harga Sewa</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarAlat)): ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data alat yang cocok.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($daftarAlat as $alat): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($alat['nama_alat']); ?></td>
                        <td>Rp <?php echo number_format($alat['tarif'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($alat['stok']); ?></td>
                        <td style="display: flex; gap: 5px; align-items: center;">
                            <a href="edit.php?id=<?php echo $alat['id']; ?>" class="btn-action btn-edit" style="text-decoration: none;">Edit</a>
                            <form method="post" action="hapus.php" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="margin: 0; display: block;">
                                <input type="hidden" name="id" value="<?php echo $alat['id']; ?>">
                                <button type="submit" class="btn-action btn-hapus">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination" style="margin-top: 20px; display: flex; gap: 5px;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>"
           style="padding: 6px 12px; border: 1px solid var(--accent-gold); text-decoration: none; border-radius: 4px; color: <?php echo $i === $page ? '#fff' : 'var(--text-dark)'; ?>; background-color: <?php echo $i === $page ? 'var(--accent-gold)' : 'transparent'; ?>; transition: 0.2s;">
            <?php echo $i; ?>
        </a>
        <?php endfor; ?>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>