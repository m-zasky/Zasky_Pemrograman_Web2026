<?php
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // Session Fixation Prevention
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];
    
    $cookiePayload = base64_encode(json_encode([
        'user_id' => $user['id'],
        'nama'    => $user['nama'],
        'role'    => $user['role']
    ]));
    setcookie('app_user_session', $cookiePayload, [
        'expires'  => time() + 86400,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_write_close();
    header('Location: /index.php');
    exit;
}

$_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username atau password salah.'];
session_write_close();
header('Location: /auth/login.php');
exit;