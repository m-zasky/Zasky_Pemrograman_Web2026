<?php
$page_title = "Edit Data Alat";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

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
    echo "<div class='card-container'><p>Data alat tidak ditemukan.</p></div>";
    include __DIR__ . '/../includes/footer.php';
    exit;
}
?>

<div class="card-container">
    <h2 class="page-title">Edit Data Alat</h2>

    <?php if ($flash): ?>
        <div class="<?php echo $flash['type'] === 'success' ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo $flash['pesan']; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="proses_edit.php">
        <input type="hidden" name="id" value="<?php echo $alat['id']; ?>">
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="nama_alat">Nama Alat:</label>
            <input type="text" id="nama_alat" name="nama_alat" value="<?php echo htmlspecialchars($alat['nama_alat']); ?>" class="form-control" required>
        </div>
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="tarif">Harga Sewa:</label>
            <input type="number" id="tarif" name="tarif" value="<?php echo htmlspecialchars($alat['tarif']); ?>" class="form-control" required>
        </div>
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="stok">Stok:</label>
            <input type="number" id="stok" name="stok" value="<?php echo htmlspecialchars($alat['stok']); ?>" class="form-control" required>
        </div>
        
        <div class="button-group">
            <button type="submit" class="btn btn-primary">Update Data</button>
            <a href="list.php" class="btn btn-secondary" style="text-decoration: none;">Batal</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>