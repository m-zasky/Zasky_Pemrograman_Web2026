<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

$page_title = "Tambah Penyewa Baru";
?>

<div class="card">
    <h2>Formulir Tambah Penyewa</h2>
    <p class="subtitle">Silakan isi data penyewa baru di bawah ini.</p>
    <hr class="divider">

    <form method="post" action="proses_tambah.php" id="form-tambah">
        <?php echo csrf_field(); ?>
        <p>
            <label for="kode_penyewa">Kode Penyewa:</label>
            <input type="text" id="kode_penyewa" name="kode_penyewa" placeholder="Contoh: PNY-001" required>
        </p>
        <p>
            <label for="nama_lengkap">Nama Lengkap:</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Contoh: Budi Santoso" required>
        </p>
        <p>
            <label for="no_hp">No. HP / WhatsApp:</label>
            <input type="text" id="no_hp" name="no_hp" placeholder="Contoh: 081234567890" required>
        </p>
        <p>
            <label for="alamat">Alamat Lengkap:</label>
            <textarea id="alamat" name="alamat" rows="3" placeholder="Contoh: Jl. Semeru No. 4, Malang" required></textarea>
        </p>
        <p style="margin-top: 1.5rem;">
            <button type="submit" class="btn-submit">Simpan Data</button>
            <a href="list.php" class="btn-cancel">Batal</a>
        </p>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>