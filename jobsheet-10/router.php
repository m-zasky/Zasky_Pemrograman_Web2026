<?php
// Set lokasi simpan session ke /tmp khusus di Vercel serverless
if (session_status() === PHP_SESSION_NONE) {
    if (getenv('VERCEL') || isset($_ENV['VERCEL'])) {
        session_save_path('/tmp');
    }
    ini_set('session.cookie_path', '/');
    session_start();
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Tentukan file tujuan
if ($path === '/' || $path === '') {
    $file = __DIR__ . '/index.php';
} else {
    $file = __DIR__ . $path;
    if (is_dir($file)) {
        $file = rtrim($file, '/') . '/index.php';
    }
}

// Cek keberadaan file
if (file_exists($file)) {
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    
    if ($ext === 'php') {
        chdir(dirname($file));
        require basename($file);
    } else {
        // Layani file statis (CSS, JS, Gambar) dengan Content-Type yang pas
        $mime_types = [
            'css'  => 'text/css; charset=utf-8',
            'js'   => 'application/javascript; charset=utf-8',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml',
            'ico'  => 'image/x-icon'
        ];
        
        if (array_key_exists($ext, $mime_types)) {
            header('Content-Type: ' . $mime_types[$ext]);
        }
        readfile($file);
    }
} else {
    http_response_code(404);
    echo "404 - File tidak ditemukan.";
}