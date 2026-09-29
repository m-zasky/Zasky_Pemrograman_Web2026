<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Menentukan file tujuan
if ($path === '/' || $path === '') {
    $file = __DIR__ . '/index.php';
} else {
    $file = __DIR__ . $path;
    // Jika mengarah ke folder, otomatis cari index.php di dalamnya
    if (is_dir($file)) {
        $file = rtrim($file, '/') . '/index.php';
    }
}

// Eksekusi file jika ada dan berekstensi .php
if (file_exists($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
    // Menyesuaikan posisi folder agar include/require lokal tidak error
    chdir(dirname($file));
    require basename($file);
} else {
    http_response_code(404);
    echo "404 - Halaman tidak ditemukan.";
}
?>