<?php include '../includes/header.php'; ?>

<div class="card-container">
    <h2 class="page-title">Formulir Tambah Penyewa</h2>
    <div class="divider"></div>

    <?php if (isset($_SESSION['error_penyewa'])): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
            <?= $_SESSION['error_penyewa']; unset($_SESSION['error_penyewa']); ?>
        </div>
    <?php endif; ?>

    <form action="proses_tambah.php" method="POST" id="formPenyewa">
        <div class="form-group">
            <label for="kode_penyewa">ID Penyewa:</label>
            <input type="text" id="kode_penyewa" name="kode_penyewa" class="form-control" placeholder="Contoh: PLG003">
        </div>
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap:</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Contoh: Budi Santoso">
        </div>
        <div class="form-group">
            <label for="no_hp">No. Telepon / WhatsApp:</label>
            <input type="text" id="no_hp" name="no_hp" class="form-control" placeholder="Contoh: 08123456789">
        </div>
        <div class="form-group">
            <label for="alamat">Alamat Lengkap:</label>
            <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan alamat lengkap penyewa"></textarea>
        </div>
        <div class="button-group">
            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <button type="reset" class="btn btn-secondary">Batal</button>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>