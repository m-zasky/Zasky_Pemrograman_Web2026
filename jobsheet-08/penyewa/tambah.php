<?php 
session_start();
include '../includes/header.php'; 
?>

<div class="card-container">
    <h2 class="page-title">Formulir Tambah Penyewa</h2>
    <div class="divider"></div>

    <!-- Menampilkan pesan error dari try-catch di proses_tambah.php -->
    <?php if (isset($_SESSION['error_penyewa'])): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
            <?= $_SESSION['error_penyewa']; unset($_SESSION['error_penyewa']); ?>
        </div>
    <?php endif; ?>

    <form action="proses_tambah.php" method="POST">
        <div class="form-group">
            <label for="kode_penyewa">Kode Penyewa:</label>
            <input type="text" id="kode_penyewa" name="kode_penyewa" class="form-control" placeholder="Contoh: PNY-001" required>
        </div>
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap:</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Contoh: Budi Santoso" required>
        </div>
        <div class="form-group">
            <label for="no_hp">No. HP / WhatsApp:</label>
            <input type="text" id="no_hp" name="no_hp" class="form-control" placeholder="Contoh: 081234567890" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat Lengkap:</label>
            <textarea id="alamat" name="alamat" class="form-control" placeholder="Contoh: Jl. Semeru No. 4, Malang" rows="3" required></textarea>
        </div>
        <div class="button-group">
            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <button type="reset" class="btn btn-secondary">Batal</button>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>