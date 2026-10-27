<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/csrf.php';

if (session_status() === PHP_SESSION_NONE) {
    if (getenv('VERCEL') || isset($_ENV['VERCEL'])) {
        session_save_path('/tmp');
    }
    ini_set('session.cookie_path', '/');
    session_start();
}

if (isset($_COOKIE['app_user_session'])) {
    $sessData = json_decode(base64_decode($_COOKIE['app_user_session']), true);
    if (is_array($sessData)) {
        $_SESSION['user_id'] = $sessData['user_id'] ?? null;
        $_SESSION['nama']    = $sessData['nama'] ?? null;
        $_SESSION['role']    = $sessData['role'] ?? null;
    }
}

$sudahLogin = isset($_SESSION['user_id']);
$current_script = basename($_SERVER['SCRIPT_NAME']);
$current_dir = basename(dirname($_SERVER['SCRIPT_NAME']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persewaan Alat Outdoor</title>
    <link rel="stylesheet" href="/assets/css/style.css?v=3.0">
    <script src="/assets/js/app.js?v=3.0" defer></script>
</head>
<body>
    <header>
        <div class="header-top">
            <div class="brand">
                <h1>Persewaan Alat Outdoor</h1>
                <p>Web Pengelola Data Persewaan Alat Outdoor</p>
            </div>
            
            <div class="auth-box">
                <?php if ($sudahLogin): ?>
                    <span class="user-greeting">Halo, <?php echo e($_SESSION['nama'] ?? 'User'); ?></span>
                    <a href="/auth/logout.php" class="btn-logout">Logout</a>
                <?php else: ?>
                    <a href="/auth/login.php" class="btn-login">Login</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="header-nav-bar">
            <div class="nav-container">
                <button type="button" id="nav-toggle-btn" class="nav-toggle-btn" aria-label="Menu">&#9776;</button>
                
                <nav id="main-nav">
                    <a href="/index.php" class="<?php echo ($current_script == 'index.php') ? 'active' : ''; ?>">Beranda</a>
                    <a href="/alat/list.php" class="<?php echo ($current_dir == 'alat' && $current_script == 'list.php') ? 'active' : ''; ?>">Data Alat</a>
                    <?php if ($sudahLogin): ?>
                        <a href="/alat/tambah.php" class="<?php echo ($current_dir == 'alat' && $current_script == 'tambah.php') ? 'active' : ''; ?>">Tambah Alat</a>
                        <a href="/penyewa/list.php" class="<?php echo ($current_dir == 'penyewa' && $current_script == 'list.php') ? 'active' : ''; ?>">Data Penyewa</a>
                        <a href="/penyewa/tambah.php" class="<?php echo ($current_dir == 'penyewa' && $current_script == 'tambah.php') ? 'active' : ''; ?>">Tambah Penyewa</a>
                        <a href="/peminjaman/tambah.php" class="<?php echo ($current_dir == 'peminjaman' && $current_script == 'tambah.php') ? 'active' : ''; ?>">Sewa Baru</a>
                        <a href="/peminjaman/kembali.php" class="<?php echo ($current_dir == 'peminjaman' && $current_script == 'kembali.php') ? 'active' : ''; ?>">Pengembalian</a>
                        <a href="/peminjaman/riwayat.php" class="<?php echo ($current_dir == 'peminjaman' && $current_script == 'riwayat.php') ? 'active' : ''; ?>">Riwayat</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>

    <main>