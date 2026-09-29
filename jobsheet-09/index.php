<?php 
require_once __DIR__ . '/includes/koneksi.php';
include __DIR__ . '/includes/header.php'; 

// Menghitung total data dari database PostgreSQL
try {
    $stmtAlat = $pdo->query("SELECT COUNT(*) FROM alat");
    $totalAlat = $stmtAlat->fetchColumn();

    $stmtPenyewa = $pdo->query("SELECT COUNT(*) FROM penyewa");
    $totalPenyewa = $stmtPenyewa->fetchColumn();
} catch (PDOException $e) {
    $totalAlat = 0;
    $totalPenyewa = 0;
}
?>

<div class="card-container">
    <h2 class="page-title">Dashboard</h2>
    <p class="page-subtitle">Selamat Datang di Web Pengelola Data Persewaan Alat Outdoor</p>

    <div class="divider"></div>

    <h3 class="section-title">Statistik Rental</h3>
    <div class="stat-grid">
        <div class="stat-card">
            <h3>Total Alat</h3>
            <div class="stat-number"><?= $totalAlat; ?></div>
        </div>
        <div class="stat-card">
            <h3>Total Penyewa</h3>
            <div class="stat-number"><?= $totalPenyewa; ?></div>
        </div>
        <div class="stat-card">
            <h3>Alat Sedang Disewa</h3>
            <div class="stat-number">0</div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>