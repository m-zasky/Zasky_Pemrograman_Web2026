<?php
// Pastikan guard auth atau session terpanggil dengan benar
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$sudahLogin = isset($_SESSION['user_id']);

// Pemanggilan header dan koneksi HANYA SEKALI
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

$page_title = "Daftar Alat";

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Pengaturan Pagination (10 baris per halaman)
$perPage = 10;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM alat WHERE nama_alat ILIKE :kw1 OR kategori ILIKE :kw2");
    $hitung->execute([
        'kw1' => '%' . $keyword . '%',
        'kw2' => '%' . $keyword . '%'
    ]);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM alat WHERE nama_alat ILIKE :kw1 OR kategori ILIKE :kw2 ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw1', '%' . $keyword . '%');
    $stmt->bindValue('kw2', '%' . $keyword . '%');
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

<div class="card">
    <h2>Daftar Alat</h2>
    <p class="subtitle">Kelola data inventaris alat outdoor di sini.</p>
    <hr class="divider">

    <?php if ($flash): ?>
        <div class="flash flash-<?php echo $flash['type']; ?>">
            <?php echo $flash['pesan']; ?>
        </div>
    <?php endif; ?>

    <!-- Tombol Tambah Alat (Hanya muncul jika sudah login) -->
    <?php if ($sudahLogin): ?>
        <div style="margin-bottom: 1.5rem;">
            <a href="tambah.php" class="btn-tambah">+ Tambah Alat Baru</a>
        </div>
    <?php endif; ?>

    <!-- Kotak Pencarian -->
    <div class="search-box">
        <form method="get" action="list.php">
            <input type="text" id="search-input" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Cari nama alat atau kategori...">
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
                    <th>Nama Alat</th>
                    <th>Kategori</th>
                    <th>Harga Sewa</th>
                    <th>Stok</th>
                    <?php if ($sudahLogin): ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarAlat)): ?>
                <tr>
                    <td colspan="<?php echo $sudahLogin ? 5 : 4; ?>" style="text-align: center; color: #6b7280; padding: 2rem;">Tidak ada data alat yang ditemukan.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($daftarAlat as $alat): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($alat['nama_alat']); ?></td>
                        <td><?php echo htmlspecialchars($alat['kategori']); ?></td>
                        <td>Rp <?php echo number_format($alat['tarif'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($alat['stok']); ?></td>
                        
                        <!-- Kolom Aksi (Hanya muncul jika sudah login) -->
                        <?php if ($sudahLogin): ?>
                            <td>
                                <a href="edit.php?id=<?php echo $alat['id']; ?>" class="btn-edit">Edit</a>
                                <form method="post" action="hapus.php" class="form-hapus" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    <input type="hidden" name="id" value="<?php echo $alat['id']; ?>">
                                    <button type="submit" class="btn-hapus">Hapus</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paging -->
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