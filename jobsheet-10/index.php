<?php
require_once 'includes/header.php';
require_once 'includes/koneksi.php';

// Ambil total data dari database
$total_alat = 0;
$total_penyewa = 0;
$sedang_disewa = 0;

try {
    $total_alat = $pdo->query("SELECT COUNT(*) FROM alat")->fetchColumn();
    $total_penyewa = $pdo->query("SELECT COUNT(*) FROM penyewa")->fetchColumn();
} catch (PDOException $e) {
    // Penanganan jika tabel belum dibuat
}
?>

<div class="card">
    <h2>Dashboard</h2>
    <p class="subtitle">Selamat Datang di Web Pengelola Data Persewaan Alat Outdoor</p>
    <hr class="divider">
    
    <h3 class="section-title">Statistik Rental</h3>
    
    <div class="stat-grid">
        <div class="stat-card">
            <span class="stat-label">TOTAL ALAT</span>
            <div class="stat-value"><?php echo $total_alat; ?></div>
        </div>
        <div class="stat-card">
            <span class="stat-label">TOTAL PENYEWA</span>
            <div class="stat-value"><?php echo $total_penyewa; ?></div>
        </div>
        <div class="stat-card">
            <span class="stat-label">ALAT SEDANG DISEWA</span>
            <div class="stat-value"><?php echo $sedang_disewa; ?></div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>