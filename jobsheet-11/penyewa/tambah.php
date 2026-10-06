<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
require_once '../includes/koneksi.php';

$page_title = "Tambah Penyewa";
?>

<div class="card">
    <h2>Formulir Tambah Penyewa</h2>
    <p class="subtitle">Silakan isi data penyewa baru di bawah ini.</p>
    <hr class="divider">

    <?php if (isset($_SESSION['error_penyewa'])): ?>
        <div class="flash flash-error">
            <?php echo $_SESSION['error_penyewa']; unset($_SESSION['error_penyewa']); ?>
        </div>
    <?php endif; ?>

    <form action="proses_tambah.php" method="POST">
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
            <textarea id="alamat" name="alamat" placeholder="Contoh: Jl. Semeru No. 4, Malang" rows="3" required style="width: 100%; max-width: 450px; padding: 0.7rem 0.85rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.95rem;"></textarea>
        </p>
        <p style="margin-top: 1.5rem;">
            <button type="submit">Simpan Data</button>
            <a href="list.php">Batal</a>
        </p>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>