<?php
$page_title = "Edit Data Penyewa";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

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
    echo "<div class='card-container'><p>Data penyewa tidak ditemukan.</p></div>";
    include __DIR__ . '/../includes/footer.php';
    exit;
}
?>

<div class="card-container">
    <h2 class="page-title">Edit Data Penyewa</h2>

    <?php if ($flash): ?>
        <div class="<?php echo $flash['type'] === 'success' ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo $flash['pesan']; ?>
        </div>
    <?php endif; ?>

    <!-- ============================================================================== -->
    <!-- PENAMBAHAN POIN-1: Menambahkan atribut onsubmit untuk konfirmasi sebelum Update -->
    <!-- Penjelasan: Atribut ini memunculkan dialog pop-up konfirmasi di browser saat -->
    <!-- tombol "Update Data" ditekan pada entitas penyewa. -->
    <!-- ============================================================================== -->
    <form method="post" action="proses_edit.php" onsubmit="return confirm('Apakah Anda yakin ingin memperbarui data penyewa ini?');">
        
        <!-- Input tersembunyi untuk menyimpan ID data penyewa yang diedit -->
        <input type="hidden" name="id" value="<?php echo $penyewa['id']; ?>">
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="nama_lengkap">Nama Penyewa:</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($penyewa['nama_lengkap']); ?>" class="form-control" required>
        </div>
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" class="form-control" required style="height: 80px;"><?php echo htmlspecialchars($penyewa['alamat']); ?></textarea>
        </div>
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="no_hp">No HP:</label>
            <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($penyewa['no_hp']); ?>" class="form-control" required>
        </div>
        
        <div class="button-group">
            <button type="submit" class="btn btn-primary">Update Data</button>
            <a href="list.php" class="btn btn-secondary" style="text-decoration: none;">Batal</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?><?php
$page_title = "Edit Data Penyewa";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

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
    echo "<div class='card-container'><p>Data penyewa tidak ditemukan.</p></div>";
    include __DIR__ . '/../includes/footer.php';
    exit;
}
?>

<div class="card-container">
    <h2 class="page-title">Edit Data Penyewa</h2>

    <?php if ($flash): ?>
        <div class="<?php echo $flash['type'] === 'success' ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo $flash['pesan']; ?>
        </div>
    <?php endif; ?>

    <!-- ============================================================================== -->
    <!-- PENAMBAHAN POIN-1: Menambahkan atribut onsubmit untuk konfirmasi sebelum Update -->
    <!-- Penjelasan: Atribut ini memunculkan dialog pop-up konfirmasi di browser saat -->
    <!-- tombol "Update Data" ditekan pada entitas penyewa. -->
    <!-- ============================================================================== -->
    <form method="post" action="proses_edit.php" onsubmit="return confirm('Apakah Anda yakin ingin memperbarui data penyewa ini?');">
        
        <!-- Input tersembunyi untuk menyimpan ID data penyewa yang diedit -->
        <input type="hidden" name="id" value="<?php echo $penyewa['id']; ?>">
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="nama_lengkap">Nama Penyewa:</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($penyewa['nama_lengkap']); ?>" class="form-control" required>
        </div>
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" class="form-control" required style="height: 80px;"><?php echo htmlspecialchars($penyewa['alamat']); ?></textarea>
        </div>
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="no_hp">No HP:</label>
            <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($penyewa['no_hp']); ?>" class="form-control" required>
        </div>
        
        <div class="button-group">
            <button type="submit" class="btn btn-primary">Update Data</button>
            <a href="list.php" class="btn btn-secondary" style="text-decoration: none;">Batal</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>