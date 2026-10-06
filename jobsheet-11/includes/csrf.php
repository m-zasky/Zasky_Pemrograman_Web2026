<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Menghasilkan Token CSRF
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Input hidden untuk disisipkan di dalam tag <form>
function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

// Memverifikasi token CSRF pada permintaan POST
function csrf_verify() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? '';
        if (!$token || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            die("403 Forbidden: Token CSRF tidak valid atau kedaluwarsa.");
        }
    }
}