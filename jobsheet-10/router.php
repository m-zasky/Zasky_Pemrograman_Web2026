<?php
if (session_status() === PHP_SESSION_NONE) {
    if (getenv('VERCEL') || isset($_ENV['VERCEL'])) {
        session_save_path('/tmp');
    }
    ini_set('session.cookie_path', '/');
    session_start();
}

// Sync Cookie Login ke $_SESSION (Mengatasi masalah multi-instance Serverless Vercel)
if (isset($_COOKIE['app_user_session'])) {
    $sessData = json_decode(base64_decode($_COOKIE['app_user_session']), true);
    if (is_array($sessData)) {
        $_SESSION['user_id'] = $sessData['user_id'] ?? null;
        $_SESSION['nama']    = $sessData['nama'] ?? null;
        $_SESSION['role']    = $sessData['role'] ?? null;
    }
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$filePath = __DIR__ . $uri;

// 1. Jika request file statis (CSS, JS, Gambar)
if ($uri !== '/' && file_exists($filePath) && is_file($filePath)) {
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    
    if ($ext === 'php') {
        chdir(dirname($filePath));
        require basename($filePath);
        exit;
    }
    
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

// 2. Routing ke index.php
if ($uri === '/' || $uri === '') {
    chdir(__DIR__);
    require __DIR__ . '/index.php';
    exit;
}

// 3. Routing ke subfolder
if (is_dir($filePath) && file_exists($filePath . '/index.php')) {
    chdir($filePath);
    require $filePath . '/index.php';
    exit;
}

http_response_code(404);
echo "404 - Halaman tidak ditemukan.";