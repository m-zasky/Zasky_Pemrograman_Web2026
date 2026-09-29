<?php include '../includes/header.php'; ?>

<div class="card-container">
    <h2 class="page-title">Formulir Tambah Alat Outdoor</h2>
    <div class="divider"></div>

    <?php if (isset($_SESSION['error_alat'])): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
            <?= $_SESSION['error_alat']; unset($_SESSION['error_alat']); ?>
        </div>
    <?php endif; ?>

    <form action="proses_tambah.php" method="POST" id="formAlat">
        <div class="form-group">
            <label for="kode_alat">Kode Alat:</label>
            <input type="text" id="kode_alat" name="kode_alat" class="form-control" placeholder="Contoh: ALT006">
        </div>
        <div class="form-group">
            <label for="nama_alat">Nama Alat:</label>
            <input type="text" id="nama_alat" name="nama_alat" class="form-control" placeholder="Contoh: Tenda Dome 2 Person">
        </div>
        <div class="form-group">
            <label for="kategori">Kategori:</label>
            <select id="kategori" name="kategori" class="form-control">
                <option value="">-- Pilih Kategori --</option>
                <option value="Tenda">Tenda</option>
                <option value="Tas / Carrier">Tas / Carrier</option>
                <option value="Alat Masak">Alat Masak</option>
                <option value="Perlengkapan Tidur">Perlengkapan Tidur</option>
                <option value="Penerangan">Penerangan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="tarif">Tarif / Hari (RP):</label>
            <input type="number" id="tarif" name="tarif" class="form-control" placeholder="Contoh: 35000">
        </div>
        <div class="form-group">
            <label for="stok">Stok Alat:</label>
            <input type="number" id="stok" name="stok" class="form-control" placeholder="Contoh: 5" min="0">
        </div>
        <div class="button-group">
            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <button type="reset" class="btn btn-secondary">Batal</button>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>