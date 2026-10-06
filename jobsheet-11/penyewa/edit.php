<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
require_once '../includes/koneksi.php';

$page_title = "Edit Data Penyewa";

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: list.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM penyewa WHERE id = :id");
$stmt->execute(['id' => $id]);
$penyewa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$penyewa) {
    echo "<div class='card'><p>Data penyewa tidak ditemukan.</p></div>";
    require_once '../includes/footer.php';
    exit;
}
?>

<div class="card">
    <h2>Edit Data Penyewa</h2>
    <p class="subtitle">Perbarui informasi data penyewa.</p>
    <hr class="divider">

    <?php if ($flash): ?>
        <div class="flash flash-<?php echo $flash['type']; ?>">
            <?php echo $flash['pesan']; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="proses_edit.php" onsubmit="return confirm('Apakah Anda yakin ingin memperbarui data penyewa ini?');">
        <input type="hidden" name="id" value="<?php echo $penyewa['id']; ?>">
        
        <p>
            <label for="nama_lengkap">Nama Penyewa:</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($penyewa['nama_lengkap']); ?>" required>
        </p>
        
        <p>
            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" required style="width: 100%; max-width: 450px; padding: 0.7rem 0.85rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.95rem; height: 90px;"><?php echo htmlspecialchars($penyewa['alamat']); ?></textarea>
        </p>
        
        <p>
            <label for="no_hp">No HP:</label>
            <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($penyewa['no_hp']); ?>" required>
        </p>
        
        <p style="margin-top: 1.5rem;">
            <button type="submit">Update Data</button>
            <a href="list.php">Batal</a>
        </p>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>