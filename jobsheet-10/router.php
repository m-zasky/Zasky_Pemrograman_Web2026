<?php
// Atur penyimpanan session khusus Vercel
if (session_status() === PHP_SESSION_NONE) {
    if (getenv('VERCEL') || isset($_ENV['VERCEL'])) {
        session_save_path('/tmp');
    }
    ini_set('session.cookie_path', '/');
    session_start();
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Jika request meminta file statis di dalam folder assets, biarkan Vercel yang handle
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|svg)$/', $uri)) {
    return false; 
}

// Tentukan file PHP tujuan
if ($uri === '/' || $uri === '') {
    $file = __DIR__ . '/index.php';
} else {
    $file = __DIR__ . $uri;
    if (is_dir($file)) {
        $file = rtrim($file, '/') . '/index.php';
    }
}

// Eksekusi file PHP jika ada
if (file_exists($file) && is_file($file)) {
    chdir(dirname($file));
    require basename($file);
} else {
    http_response_code(404);
    echo "404 - File tidak ditemukan.";
}