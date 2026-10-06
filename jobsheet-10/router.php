<?php
// Pengaturan session khusus Vercel
if (session_status() === PHP_SESSION_NONE) {
    if (getenv('VERCEL') || isset($_ENV['VERCEL'])) {
        session_save_path('/tmp');
    }
    ini_set('session.cookie_path', '/');
    session_start();
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$filePath = __DIR__ . $uri;

// 1. Jika request adalah file statis (CSS, JS, Gambar), sajikan langsung
if ($uri !== '/' && file_exists($filePath) && is_file($filePath)) {
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    
    // Jika file PHP, jalankan
    if ($ext === 'php') {
        chdir(dirname($filePath));
        require basename($filePath);
        exit;
    }
    
    // Header tipe file statis
    $mimes = [
        'css'  => 'text/css; charset=utf-8',
        'js'   => 'application/javascript; charset=utf-8',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'ico'  => 'image/x-icon'
    ];
    
    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
    }
    readfile($filePath);
    exit;
}

// 2. Routing untuk halaman root /
if ($uri === '/' || $uri === '') {
    chdir(__DIR__);
    require __DIR__ . '/index.php';
    exit;
}

// 3. Routing untuk folder (misal /alat/ -> /alat/index.php)
if (is_dir($filePath) && file_exists($filePath . '/index.php')) {
    chdir($filePath);
    require $filePath . '/index.php';
    exit;
}

// 4. Jika file tidak ditemukan
http_response_code(404);
echo "404 - Halaman tidak ditemukan.";