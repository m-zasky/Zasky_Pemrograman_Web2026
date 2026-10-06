<?php
require_once '../includes/auth.php'; // Penjaga halaman (wajib login)
require_once '../includes/header.php';
require_once '../includes/koneksi.php';

$page_title = "Edit Data Alat";

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: list.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM alat WHERE id = :id");
$stmt->execute(['id' => $id]);
$alat = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$alat) {
    echo "<div class='card'><p>Data alat tidak ditemukan.</p></div>";
    require_once '../includes/footer.php';
    exit;
}
?>

<div class="card">
    <h2>Edit Data Alat</h2>
    <p class="subtitle">Perbarui informasi inventaris alat outdoor.</p>
    <hr class="divider">

    <?php if ($flash): ?>
        <div class="flash flash-<?php echo $flash['type']; ?>">
            <?php echo $flash['pesan']; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="proses_edit.php" onsubmit="return confirm('Apakah Anda yakin ingin memperbarui data alat ini?');">
        <input type="hidden" name="id" value="<?php echo $alat['id']; ?>">
        
        <p>
            <label for="nama_alat">Nama Alat:</label>
            <input type="text" id="nama_alat" name="nama_alat" value="<?php echo htmlspecialchars($alat['nama_alat']); ?>" required>
        </p>
        
        <p>
            <label for="tarif">Harga Sewa (Rp):</label>
            <input type="number" id="tarif" name="tarif" value="<?php echo htmlspecialchars($alat['tarif']); ?>" required>
        </p>
        
        <p>
            <label for="stok">Stok:</label>
            <input type="number" id="stok" name="stok" value="<?php echo htmlspecialchars($alat['stok']); ?>" required min="0">
        </p>
        
        <p style="margin-top: 1.5rem;">
            <button type="submit">Update Data</button>
            <a href="list.php">Batal</a>
        </p>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>