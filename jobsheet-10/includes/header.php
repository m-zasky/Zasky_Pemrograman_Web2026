<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$sudahLogin = isset($_SESSION['user_id']);

$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);

$current_script = basename($_SERVER['SCRIPT_NAME']);
$current_dir = basename(dirname($_SERVER['SCRIPT_NAME']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persewaan Alat Outdoor</title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css?v=1.1">
    <script src="<?php echo $base; ?>assets/js/app.js?v=1.1" defer></script>
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
                    <span class="user-greeting">Halo, <?php echo htmlspecialchars($_SESSION['nama'] ?? 'User'); ?></span>
                    <a href="<?php echo $base; ?>auth/logout.php" class="btn-logout">Logout</a>
                <?php else: ?>
                    <a href="<?php echo $base; ?>auth/login.php" class="btn-login">Login</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="header-nav-bar">
            <div class="nav-container">
                <button type="button" id="nav-toggle-btn" class="nav-toggle-btn" aria-label="Menu">&#9776;</button>
                
                <nav id="main-nav">
                    <a href="<?php echo $base; ?>index.php" class="<?php echo ($current_script == 'index.php') ? 'active' : ''; ?>">Beranda</a>
                    <a href="<?php echo $base; ?>alat/list.php" class="<?php echo ($current_dir == 'alat' && $current_script == 'list.php') ? 'active' : ''; ?>">Data Alat</a>
                    <?php if ($sudahLogin): ?>
                        <a href="<?php echo $base; ?>alat/tambah.php" class="<?php echo ($current_dir == 'alat' && $current_script == 'tambah.php') ? 'active' : ''; ?>">Tambah Alat</a>
                        <a href="<?php echo $base; ?>penyewa/list.php" class="<?php echo ($current_dir == 'penyewa' && $current_script == 'list.php') ? 'active' : ''; ?>">Data Penyewa</a>
                        <a href="<?php echo $base; ?>penyewa/tambah.php" class="<?php echo ($current_dir == 'penyewa' && $current_script == 'tambah.php') ? 'active' : ''; ?>">Tambah Penyewa</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>

    <main>