<?php
require_once '../includes/auth.php'; // Penjaga halaman (wajib login)
require_once '../includes/header.php';
require_once '../includes/koneksi.php';

$page_title = "Tambah Alat";
?>

<div class="card">
    <h2>Formulir Tambah Alat Outdoor</h2>
    <p class="subtitle">Silakan isi data inventaris alat outdoor baru di bawah ini.</p>
    <hr class="divider">

    <?php if (isset($_SESSION['error_alat'])): ?>
        <div class="flash flash-error">
            <?php echo $_SESSION['error_alat']; unset($_SESSION['error_alat']); ?>
        </div>
    <?php endif; ?>

    <form action="proses_tambah.php" method="POST" id="formAlat">
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
                <option value="Tas / Carrier">Tas / Carrier</option>
                <option value="Alat Masak">Alat Masak</option>
                <option value="Perlengkapan Tidur">Perlengkapan Tidur</option>
                <option value="Penerangan">Penerangan</option>
            </select>
        </p>
        <p>
            <label for="tarif">Tarif / Hari (RP):</label>
            <input type="number" id="tarif" name="tarif" placeholder="Contoh: 35000" required>
        </p>
        <p>
            <label for="stok">Stok Alat:</label>
            <input type="number" id="stok" name="stok" placeholder="Contoh: 5" min="0" required>
        </p>
        <p style="margin-top: 1.5rem;">
            <button type="submit">Simpan Data</button>
            <a href="list.php">Batal</a>
        </p>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>