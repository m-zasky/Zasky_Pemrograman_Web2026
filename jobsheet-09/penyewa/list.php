<?php
$page_title = "Daftar Penyewa";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$perPage = 5;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM penyewa WHERE nama_lengkap ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM penyewa WHERE nama_lengkap ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM penyewa")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM penyewa ORDER BY id DESC LIMIT :limit OFFSET :offset");
}
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$daftarPenyewa = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>

<div class="card-container">
    <h2 class="page-title">Daftar Penyewa</h2>

    <div style="margin-bottom: 1.5rem; margin-top: 1rem;">
        <a href="tambah.php" class="btn btn-primary" style="text-decoration: none;">+ Tambah Penyewa Baru</a>
    </div>

    <?php if ($flash): ?>
        <div class="<?php echo $flash['type'] === 'success' ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo $flash['pesan']; ?>
        </div>
    <?php endif; ?>

    <div class="search-box">
        <form method="get" action="list.php" style="flex-direction: row; align-items: center; gap: 10px; margin-top: 0;">
            <input type="text" id="search-input" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Cari nama penyewa..." style="width: auto; flex: 1; max-width: 320px; padding: 0.5rem 0.75rem;">
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
                    <th>Nama Penyewa</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarPenyewa)): ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data penyewa yang cocok.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($daftarPenyewa as $penyewa): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($penyewa['nama_lengkap']); ?></td>
                        <td><?php echo htmlspecialchars($penyewa['alamat']); ?></td>
                        <td><?php echo htmlspecialchars($penyewa['no_hp']); ?></td>
                        <td style="display: flex; gap: 5px; align-items: center;">
                            <a href="edit.php?id=<?php echo $penyewa['id']; ?>" class="btn-action btn-edit" style="text-decoration: none;">Edit</a>
                            <form method="post" action="hapus.php" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="margin: 0; display: block;">
                                <input type="hidden" name="id" value="<?php echo $penyewa['id']; ?>">
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