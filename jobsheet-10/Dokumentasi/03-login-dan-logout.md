# 3. Login & Logout

## 3.1 `auth/login.php` — Form Login

```php
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Login";
include __DIR__ . '/../includes/header.php';
```

Kerangkanya **identik persis** dengan `register.php`
([dokumentasi jobsheet-10 §2.2](02-skema-users-dan-registrasi.md#22-halaman-registerphp)) —
periksa session, alihkan ke Beranda kalau sudah login, baru tampilkan
form (username + password, tanpa `minlength` karena bukan aturan baru
yang perlu ditegakkan di sini — panjang password yang benar sudah
ditentukan saat Registrasi).

## 3.2 `proses_login.php`: Memverifikasi Password

```php
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];
    header('Location: ../index.php');
    exit;
}

$_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username atau password salah.'];
header('Location: login.php');
exit;
```

- **`SELECT * FROM users WHERE username = :username`** — mencari
  pengguna berdasarkan username yang diketik. Ingat pola
  `WHERE ... = :parameter` dan `->fetch(PDO::FETCH_ASSOC)` (untuk **satu**
  baris) dari
  [dokumentasi jobsheet-09 §2.3](../../jobsheet-09/Dokumentasi/02-edit-update-data.md#23-mengambil-data-lama-select--where-id--id).
- **`password_verify($password, $user['password'])`** — inilah
  pasangan dari `password_hash()` yang dibahas di
  [bab 2 §2.3](02-skema-users-dan-registrasi.md#23-proses_registerphp-validasi--password-hashing).
  Fungsi ini menerima **password asli** yang baru saja diketik
  (`$password`) dan **hash** yang tersimpan di database
  (`$user['password']`), lalu memeriksa apakah keduanya **cocok** —
  **tanpa** pernah membalik hash itu kembali menjadi teks asli
  (memang **tidak mungkin** dibalik, itulah gunanya hashing satu arah
  dari [dokumentasi jobsheet-10 §1.2](01-konsep-dasar-autentikasi.md#12-kenapa-password-tidak-boleh-disimpan-apa-adanya)).
  `password_verify()` mengembalikan `true`/`false`.
- **`$user && password_verify(...)`** — dua kondisi harus **sama-sama**
  benar: `$user` harus ditemukan (username-nya memang ada) **dan**
  password-nya cocok. Kalau username **tidak ditemukan sama sekali**,
  `$user` bernilai `false`, dan PHP **tidak akan mengevaluasi**
  `password_verify(...)` sama sekali (perilaku "short-circuit" pada
  `&&` — kalau bagian kiri sudah `false`, bagian kanan tidak perlu
  diperiksa lagi) — mencegah error karena mencoba mengakses
  `$user['password']` padahal `$user` adalah `false`.

### Menyimpan Identitas ke Session

```php
$_SESSION['user_id'] = $user['id'];
$_SESSION['nama'] = $user['nama'];
$_SESSION['role'] = $user['role'];
```

Setelah kredensial terverifikasi, **3 potong informasi** disimpan ke
`$_SESSION` — inilah "bukti" bahwa pengguna ini sudah login, yang akan
diperiksa di **setiap** halaman berikutnya oleh `includes/auth.php`
([bab 4](04-guard-auth-php.md)) dan ditampilkan di navbar
([bab 5](05-navbar-dinamis-dan-css.md)):

| Kunci | Dipakai untuk |
|---|---|
| `$_SESSION['user_id']` | Diperiksa `auth.php` — penanda utama "sudah login" |
| `$_SESSION['nama']` | Ditampilkan di navbar ("halo, nama petugas") |
| `$_SESSION['role']` | Disiapkan untuk kontrol akses berbasis peran di masa depan (ingat catatan di [README.md](../README.md) jobsheet ini) |

### Kenapa Pesan Error-nya Tidak Spesifik?

```php
$_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username atau password salah.'];
```

Perhatikan pesan error ini **sengaja tidak membedakan** apakah
username-nya yang salah atau password-nya yang salah — keduanya
digabung jadi satu pesan umum "Username atau password salah." Ini
**praktik keamanan yang disengaja**: kalau aplikasi menampilkan pesan
berbeda ("Username tidak ditemukan" vs "Password salah"), orang yang
mencoba menebak-nebak akun orang lain bisa memakai perbedaan pesan itu
untuk mengetahui username mana yang **valid** (dengan mencoba banyak
username dan melihat pesan mana yang muncul), sebelum mencoba menebak
passwordnya. Pesan yang digabung menutup celah informasi ini.

## 3.3 `auth/logout.php`: Mengakhiri Sesi

```php
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
header('Location: login.php');
exit;
```

- **`session_destroy()`** — fungsi PHP bawaan yang **menghapus
  seluruh** data session pengguna saat ini sekaligus, termasuk
  `user_id`, `nama`, `role` yang tadi disimpan di
  [§3.2](#32-proses_loginphp-memverifikasi-password). Setelah baris ini,
  pengguna **tidak lagi dianggap login** — pemeriksaan
  `isset($_SESSION['user_id'])` di halaman mana pun (termasuk
  `includes/auth.php`, [bab 4](04-guard-auth-php.md)) akan kembali
  bernilai `false`.
- Setelah sesi dihancurkan, pengguna langsung diarahkan ke halaman
  Login — alur yang masuk akal setelah logout. Target-nya cukup
  `login.php` saja (bukan `/auth/login.php` atau `../auth/login.php`)
  karena `logout.php` **sendiri** sudah berada di dalam folder `auth/`
  — `login.php` di situ merujuk ke file tetangga di folder yang sama.

## 3.4 Alur Lengkap: Registrasi → Login → Logout

```
[register.php] --(isi form)--> [proses_register.php]
     --(password_hash, simpan ke DB)--> [redirect ke login.php]

[login.php] --(isi form)--> [proses_login.php]
     --(password_verify cocok)--> [set $_SESSION, redirect ke index.php]
     --(tidak cocok)--> [redirect kembali ke login.php + flash error]

[halaman mana pun] --(klik Logout)--> [logout.php]
     --(session_destroy)--> [redirect ke login.php]
```

Bandingkan alur ini dengan user flow Peminjaman/Pengembalian yang
sudah kamu bedah sejak
[dokumentasi jobsheet-04 §3](../../jobsheet-04/Dokumentasi/03-user-flow-peminjaman-pengembalian.md) —
alur "Login" yang saat itu masih berupa **kotak rancangan** kini
benar-benar berupa **kode PHP yang berjalan sungguhan**.

Lanjut ke: [Guard Halaman: `includes/auth.php`](04-guard-auth-php.md)
