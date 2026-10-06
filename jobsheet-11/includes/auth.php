<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Guard Clause: Jika belum login, tendang ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>