# 2. Tabel `users` & Registrasi

## 2.1 Skema `sql/02_users.sql`

```sql
-- Jobsheet 10: tabel users (Petugas) untuk autentikasi
-- Jalankan: psql -d simpus_mini -f sql/02_users.sql

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'petugas'
);
```

Semua elemen di sini sudah kamu kenal dari
[dokumentasi jobsheet-08 §2](../../jobsheet-08/Dokumentasi/02-skema-database-sql.md):
`SERIAL PRIMARY KEY` untuk `id` yang bertambah otomatis, `NOT NULL`
untuk kolom wajib, `VARCHAR` untuk teks. Dua hal baru untuk
diperhatikan:

- **`username VARCHAR(50) NOT NULL UNIQUE`** — ingat batasan `UNIQUE`
  dari [dokumentasi jobsheet-08 §2.4](../../jobsheet-08/Dokumentasi/02-skema-database-sql.md#24-mendefinisikan-kolom-nama-tipe-dan-batasan)
  (dipakai juga untuk `no_anggota`): **wajib berbeda** untuk setiap
  baris — masuk akal, karena username dipakai sebagai "identitas
  login" yang harus unik supaya sistem tahu **akun mana** yang sedang
  mencoba masuk.
- **`role VARCHAR(20) NOT NULL DEFAULT 'petugas'`** — kolom baru untuk
  menyimpan **peran** pengguna. `DEFAULT 'petugas'` (ingat konsep
  `DEFAULT` dari
  [dokumentasi jobsheet-08 §2.4](../../jobsheet-08/Dokumentasi/02-skema-database-sql.md#24-mendefinisikan-kolom-nama-tipe-dan-batasan))
  berarti setiap akun baru otomatis berperan sebagai "petugas" kalau
  tidak ditentukan lain. Kolom ini **disiapkan** untuk kebutuhan masa
  depan (misalnya membedakan `admin` dari `petugas` biasa) — ingat
  catatan di [README.md](../README.md) jobsheet ini bahwa perbedaan
  akses berdasarkan `role` **belum diterapkan**, baru disiapkan
  kolomnya saja.

## 2.2 Halaman `register.php`

```php
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Registrasi Petugas";
include __DIR__ . '/../includes/header.php';
```

- **`session_status() === PHP_SESSION_NONE`** — cara PHP memeriksa
  apakah session **sudah** dimulai sebelumnya di request ini. Kenapa
  perlu diperiksa dulu (bukan langsung panggil `session_start()` saja
  seperti di jobsheet-07/08/09)? Dijelaskan alasannya di
  [bab 4 §4.4](04-guard-auth-php.md#44-kenapa-session_status-diperiksa-dulu).
- **`if (isset($_SESSION['user_id'])) { header('Location: ../index.php'); exit; }`** —
  pola baru: kalau pengguna **sudah login**, halaman Registrasi (dan
  Login, lihat [bab 3](03-login-dan-logout.md)) langsung mengalihkannya
  ke Beranda. Masuk akal — tidak ada gunanya menampilkan form
  registrasi/login ke seseorang yang sudah punya sesi aktif. Perhatikan
  target-nya `../index.php`, bukan `/index.php` — karena `register.php`
  berada satu folder di dalam (`auth/`), path relatif biasa (`../`)
  sudah cukup untuk sampai ke `index.php` di root proyek, tidak perlu
  variabel `$base` seperti di `includes/header.php` (ingat
  [dokumentasi jobsheet-07 §2.3](../../jobsheet-07/Dokumentasi/02-includes-header-footer.md#23-path-relatif-otomatis-di-includesheaderphp)
  — `$base` dipakai di situ karena `header.php` dipakai bersama oleh
  halaman di kedalaman berbeda-beda, sedangkan `header('Location: ...')`
  di sini hanya perlu berlaku untuk file ini sendiri).

Sisa halaman ini adalah form HTML biasa, mengikuti pola `<label>` +
`<input>` yang sudah sangat kamu kenal sejak
[dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md) —
hanya perhatikan field password memakai **`type="password"`** (jenis
input yang sudah disinggung sejak
[dokumentasi jobsheet-04 §2.2](../../jobsheet-04/Dokumentasi/02-cara-membaca-wireframe.md#22-aturan-membaca-simbol-simbolnya)
sebagai rencana, sekarang benar-benar diimplementasikan) dan atribut
**`minlength="6"`** — validasi HTML baru yang membatasi panjang
**minimal** teks yang boleh diketik (beda dari `min`/`max` pada
`type="number"` yang membatasi **nilai** angka, ingat dari
[dokumentasi jobsheet-01 §4.4](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#44-jenis-jenis-input-yang-dipakai)).

## 2.3 `proses_register.php`: Validasi & Password Hashing

```php
$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($username === '') {
    $errors[] = "Username wajib diisi.";
}
if (strlen($password) < 6) {
    $errors[] = "Password minimal 6 karakter.";
}
```

- Pola validasi ini **identik** dengan `proses_tambah.php` sejak
  [dokumentasi jobsheet-07 §4.3](../../jobsheet-07/Dokumentasi/04-proses-tambah-validasi-server.md#43-validasi-server-side) —
  array `$errors`, flash message kalau gagal.
- **`strlen($password) < 6`** — fungsi PHP yang menghitung **panjang**
  sebuah string. Ini validasi **server-side** untuk aturan yang sama
  dengan `minlength="6"` di HTML ([§2.2](#22-halaman-registerphp)) —
  ingat prinsip pentingnya menduplikasi validasi HTML/JS di server dari
  [dokumentasi jobsheet-07 §4.6](../../jobsheet-07/Dokumentasi/04-proses-tambah-validasi-server.md#46-kenapa-validasi-ini-yang-benar-benar-bisa-diandalkan):
  `minlength` bisa dilewati, `strlen()` di server tidak bisa.

```php
$cek = $pdo->prepare("SELECT id FROM users WHERE username = :username");
$cek->execute(['username' => $username]);
if ($cek->fetch()) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username sudah digunakan.'];
    header('Location: register.php');
    exit;
}
```

- Ini **pengecekan tambahan** yang belum pernah kamu lihat di
  `proses_tambah.php` manapun sebelumnya: sebelum benar-benar
  memasukkan data baru, kode ini **bertanya dulu** ke database "apakah
  sudah ada pengguna dengan username ini?" Meski kolom `username`
  sudah diberi batasan `UNIQUE` di database ([§2.1](#21-skema-sql02_userssql)) —
  yang akan **menolak** `INSERT` yang melanggarnya — pengecekan manual
  ini memungkinkan aplikasi memberi **pesan error yang ramah**
  ("Username sudah digunakan.") alih-alih membiarkan pengguna melihat
  error database mentah yang membingungkan.

```php
$stmt = $pdo->prepare(
    "INSERT INTO users (nama, username, password, role) VALUES (:nama, :username, :password, 'petugas')"
);
$stmt->execute([
    'nama' => $nama,
    'username' => $username,
    'password' => password_hash($password, PASSWORD_DEFAULT),
]);
```

- Pola `prepare()`/`execute()` ini sudah kamu kuasai sejak
  [dokumentasi jobsheet-08 §5](../../jobsheet-08/Dokumentasi/05-insert-prepared-statement.md).
- **`password_hash($password, PASSWORD_DEFAULT)`** — inilah momen
  paling penting di seluruh file ini. Password **asli** yang diketik
  pengguna (`$password`, teks biasa) **tidak pernah** disimpan langsung
  ke database — yang disimpan adalah **hasil hash-nya**.
  **`PASSWORD_DEFAULT`** adalah konstanta PHP yang menunjuk ke
  algoritma hashing **terbaik yang tersedia saat ini** (PHP bisa
  memperbarui algoritma defaultnya di versi mendatang tanpa kamu perlu
  mengubah kode ini) — praktik yang jauh lebih aman dibanding menentukan
  algoritma spesifik secara manual.
- Perhatikan `'petugas'` di klausa `VALUES` ditulis **langsung** (bukan
  placeholder `:role`) — karena setiap akun yang mendaftar lewat form
  ini **selalu** diberi role `'petugas'` tanpa pengecualian, tidak
  perlu diambil dari input pengguna sama sekali (mencegah seseorang
  mendaftar sendiri sebagai `'admin'` lewat form publik ini).

Lanjut ke: [Login & Logout](03-login-dan-logout.md)
