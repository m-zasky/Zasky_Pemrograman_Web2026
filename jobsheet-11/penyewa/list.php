<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

$page_title = "Daftar Penyewa";
$sudahLogin = isset($_SESSION['user_id']);

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$perPage = 10;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM penyewa WHERE nama_lengkap ILIKE :kw1 OR alamat ILIKE :kw2");
    $hitung->execute([
        'kw1' => '%' . $keyword . '%',
        'kw2' => '%' . $keyword . '%'
    ]);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM penyewa WHERE nama_lengkap ILIKE :kw1 OR alamat ILIKE :kw2 ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw1', '%' . $keyword . '%');
    $stmt->bindValue('kw2', '%' . $keyword . '%');
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

<div class="card">
    <h2>Daftar Penyewa</h2>
    <p class="subtitle">Kelola data penyewa alat outdoor di sini.</p>
    <hr class="divider">

    <?php if ($flash): ?>
        <div class="flash flash-<?php echo e($flash['type']); ?>">
            <?php echo e($flash['pesan']); ?>
        </div>
    <?php endif; ?>

    <?php if ($sudahLogin): ?>
        <div style="margin-bottom: 1.5rem;">
            <a href="tambah.php" class="btn-tambah">+ Tambah Penyewa Baru</a>
        </div>
    <?php endif; ?>

    <div class="search-box">
        <form method="get" action="list.php">
            <input type="text" id="search-input" name="q" value="<?php echo e($keyword); ?>" placeholder="Cari nama atau alamat...">
            <button type="submit">Cari</button>
            <?php if($keyword !== ''): ?>
                <a href="list.php" style="padding: 0.55rem 1rem; background-color: #e5e7eb; color: #374151; border-radius: 6px; font-weight: 600;">Reset</a>
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
                    <?php if ($sudahLogin): ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarPenyewa)): ?>
                <tr>
                    <td colspan="<?php echo $sudahLogin ? 4 : 3; ?>" style="text-align: center; color: #6b7280; padding: 2rem;">Tidak ada data penyewa yang cocok.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($daftarPenyewa as $penyewa): ?>
                    <tr>
                        <td><?php echo e($penyewa['nama_lengkap']); ?></td>
                        <td><?php echo e($penyewa['alamat']); ?></td>
                        <td><?php echo e($penyewa['no_hp']); ?></td>
                        
                        <?php if ($sudahLogin): ?>
                            <td>
                                <div class="action-cell">
                                    <a href="edit.php?id=<?php echo e($penyewa['id']); ?>" class="btn-edit">Edit</a>
                                    <form method="post" action="hapus.php" class="form-hapus">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="id" value="<?php echo e($penyewa['id']); ?>">
                                        <button type="submit" class="btn-hapus">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1): ?>
    <div class="pagination" style="margin-top: 1.5rem; display: flex; gap: 0.5rem;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>"
           style="padding: 0.4rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; text-decoration: none; font-weight: 600; background-color: <?php echo $i === $page ? '#eab308' : '#ffffff'; ?>; color: <?php echo $i === $page ? '#0a0f18' : '#374151'; ?>;">
            <?php echo $i; ?>
        </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>