<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

$page_title = "Tambah Alat Baru";
?>

<div class="card">
    <h2>Formulir Tambah Alat Outdoor</h2>
    <p class="subtitle">Silakan isi data inventaris alat outdoor baru di bawah ini.</p>
    <hr class="divider">

    <form method="post" action="proses_tambah.php" id="form-tambah">
        <?php echo csrf_field(); ?>
        <p>
            <label for="kode_alat">Kode Alat:</label>
            <input type="text" id="kode_alat" name="kode_alat" placeholder="Contoh: ALT006" required>
        </p>
        <p>
            <label for="nama_alat">Nama Alat:</label>
            <input type="text" id="nama_alat" name="nama_alat" placeholder="Contoh: Tenda Dome 2 Person" required>
        </p>
        <p>
            <label for="kategori">Kategori:</label>
            <select id="kategori" name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Tenda">Tenda</option>
                <option value="Carrier">Carrier / Tas</option>
                <option value="Cooking Set">Cooking Set</option>
                <option value="Sleeping Bag">Sleeping Bag</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </p>
        <p>
            <label for="tarif">Tarif / Hari (RP):</label>
            <input type="number" id="tarif" name="tarif" placeholder="Contoh: 35000" required min="0">
        </p>
        <p>
            <label for="stok">Stok Alat:</label>
            <input type="number" id="stok" name="stok" placeholder="Contoh: 5" required min="0">
        </p>
        <p style="margin-top: 1.5rem;">
            <button type="submit" class="btn-submit">Simpan Data</button>
            <a href="list.php" class="btn-cancel">Batal</a>
        </p>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>