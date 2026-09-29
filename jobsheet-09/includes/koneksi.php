<?php
// Cek apakah Environment Variable DATABASE_URL tersedia (dari Vercel/Cloud Supabase)
$database_url = getenv('DATABASE_URL');

if ($database_url) {
    // Konfigurasi otomatis untuk Cloud (Supabase)
    $parsed_url = parse_url($database_url);
    $host = $parsed_url['host'] ?? '';
    $port = $parsed_url['port'] ?? '5432';
    $user = $parsed_url['user'] ?? '';
    $pass = $parsed_url['pass'] ?? '';
    $db   = ltrim($parsed_url['path'] ?? '', '/');

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$db";
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Koneksi Database Cloud Gagal: " . $e->getMessage());
    }
} else {
    // Konfigurasi untuk Pengembangan Lokal (di Laptop Anda)
    $host = "localhost";
    $port = "5432";
    $dbname = "db_persewaan_alat"; 
    $user = "postgres"; 
    $password = "12345678"; // Sesuaikan dengan password PostgreSQL lokal Anda jika berbeda

    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Koneksi database gagal: " . $e->getMessage());
    }
}
?>