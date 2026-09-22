<?php
$host = "localhost";
$port = "5432";
$dbname = "db_persewaan_alat"; // Sesuaikan dengan nama database PostgreSQL kamu
$user = "postgres";             // Username database kamu
$password = "12345678";         // Password database kamu

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    // Set error mode ke exception agar error tertangkap
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>