<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Menentukan file tujuan
if ($path === '/' || $path === '') {
    $file = __DIR__ . '/index.php';
} else {
    $file = __DIR__ . $path;
    if (is_dir($file)) {
        $file = rtrim($file, '/') . '/index.php';
    }
}

// Cek apakah file benar-benar ada di dalam folder
if (file_exists($file)) {
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    
    // Jika file PHP, eksekusi seperti biasa
    if ($ext === 'php') {
        chdir(dirname($file));
        require basename($file);
    } else {
        // JIKA FILE STATIS (CSS, JS, Gambar), paksa PHP yang menyajikannya!
        $mime_types = [
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml'
        ];
        
        if (array_key_exists($ext, $mime_types)) {
            header('Content-Type: ' . $mime_types[$ext]);
        }
        // Keluarkan isi file CSS/Gambar ke browser
        readfile($file);
    }
} else {
    http_response_code(404);
    echo "404 - File tidak ditemukan.";
}
?>