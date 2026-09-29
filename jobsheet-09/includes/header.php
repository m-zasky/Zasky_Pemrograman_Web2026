<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page = basename($_SERVER['PHP_SELF']);
$dir = basename(dirname($_SERVER['PHP_SELF']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Persewaan Alat Outdoor</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header>
        <div class="header-banner">
            <h1>Persewaan Alat Outdoor</h1>
            <p class="subtitle">Web Pengelola Data Persewaan Alat Outdoor</p>
        </div>
        
        <!-- Tombol Hamburger baru berbasis JS -->
        <button id="nav-toggle-btn" class="nav-toggle-btn">&#9776;</button>
        
        <nav>
            <ul>
                <li><a href="/index.php" class="<?= $page == 'index.php' ? 'active' : '' ?>">Beranda</a></li>
                <li><a href="/alat/list.php" class="<?= ($page == 'list.php' && $dir == 'alat') ? 'active' : '' ?>">Data Alat</a></li>
                <li><a href="/alat/tambah.php" class="<?= ($page == 'tambah.php' && $dir == 'alat') ? 'active' : '' ?>">Tambah Alat</a></li>
                <li><a href="/penyewa/list.php" class="<?= ($page == 'list.php' && $dir == 'penyewa') ? 'active' : '' ?>">Data Penyewa</a></li>
                <li><a href="/penyewa/tambah.php" class="<?= ($page == 'tambah.php' && $dir == 'penyewa') ? 'active' : '' ?>">Tambah Penyewa</a></li>
            </ul>
        </nav>
    </header>
    <main>