# 4. Guard Halaman: `includes/auth.php`

Ini file **terpendek** di jobsheet ini, tapi menyimpan detail paling
krusial untuk dipahami — kesalahan urutan sedikit saja bisa membuat
seluruh mekanisme proteksinya gagal total.

## 4.1 Kode Lengkap

```php
<?php
// Guard clause: di-include di baris paling atas setiap halaman yang
// membutuhkan login (sebelum header.php mengeluarkan output apa pun),
// agar header('Location: ...') masih bisa dipanggil.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}
```

`includes/auth.php` selalu di-`require` dari halaman yang **satu
folder lebih dalam** dari root proyek (`buku/`, `anggota/`, lihat
[§4.7](#47-halaman-mana-saja-yang-memakai-guard-ini)), jadi
`../auth/login.php` (naik satu folder, lalu turun ke `auth/`) selalu
tepat sasaran — beda dengan `includes/header.php` yang butuh
perhitungan `$base` dinamis karena dipakai bersama oleh halaman di
kedalaman yang **berbeda-beda** (ingat
[dokumentasi jobsheet-07 §2.3](../../jobsheet-07/Dokumentasi/02-includes-header-footer.md#23-path-relatif-otomatis-di-includesheaderphp)).

## 4.2 Cara Memakainya di Halaman Lain

```php
<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Tambah Buku";
include __DIR__ . '/../includes/header.php';
```

Ini baris **pertama** di `buku/tambah.php` (ingat dari
[dokumentasi jobsheet-10 README](../README.md), halaman ini termasuk
yang "terkunci"). Perhatikan `require __DIR__ . '/../includes/auth.php';`
dipanggil **sebelum** apa pun yang lain — bahkan sebelum
`include header.php`. Urutan ini **bukan kebetulan**, dijelaskan
alasannya di [§4.3](#43-kenapa-harus-jadi-baris-paling-pertama).

## 4.3 Kenapa Harus Jadi Baris Paling Pertama?

Ingat dari [dokumentasi jobsheet-07 §4.4](../../jobsheet-07/Dokumentasi/04-proses-tambah-validasi-server.md#44-kalau-ada-error-simpan-flash--redirect-kembali):
**`header('Location: ...')` hanya bekerja kalau belum ada output HTML
apa pun** yang terkirim ke browser sebelumnya. Kalau
`include header.php` dipanggil **lebih dulu** — yang langsung mulai
mencetak `<!DOCTYPE html>`, `<head>`, dst. — maka saat `auth.php`
mencoba memanggil `header('Location: ../auth/login.php')` setelahnya,
perintah itu akan **gagal** (biasanya memicu peringatan PHP "headers
already sent") karena browser sudah mulai menerima sebagian halaman.

Coba bayangkan urutan yang **salah**:
```php
// SALAH — jangan tiru
include __DIR__ . '/../includes/header.php';  // mulai cetak HTML
require __DIR__ . '/../includes/auth.php';    // terlambat! redirect gagal
```
Dengan urutan ini, pengunjung yang belum login akan **tetap melihat**
sebagian halaman (header, navbar) sebelum redirect gagal dipanggil —
proteksinya bocor. Urutan yang **benar** (auth.php dulu, baru
header.php) memastikan pemeriksaan login selesai **sebelum** satu
karakter HTML pun dikirim ke browser.

## 4.4 Kenapa `session_status()` Diperiksa Dulu?

```php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
```

Bandingkan dengan jobsheet-07/08/09 yang memanggil `session_start()`
langsung tanpa pengecekan apa pun. Masalahnya muncul di jobsheet ini
karena `session_start()` sekarang dipanggil di **banyak tempat
berbeda** yang berpotensi saling tumpang tindih:

- `auth.php` memanggilnya (baris pertama di halaman terkunci).
- `header.php` juga memanggilnya (ingat dari
  [dokumentasi jobsheet-10 §5](05-navbar-dinamis-dan-css.md), untuk
  memeriksa `$sudahLogin`).
- `login.php`/`register.php`/`proses_login.php`/dst. juga memanggilnya
  masing-masing.

Kalau `session_start()` dipanggil **dua kali** dalam satu permintaan
halaman yang sama (misalnya sekali oleh `auth.php`, sekali lagi oleh
`header.php` yang di-include setelahnya), PHP akan memunculkan
**peringatan/error** "session already started." **`session_status()`**
adalah fungsi PHP yang memeriksa **status session saat ini** —
`PHP_SESSION_NONE` berarti "belum ada session yang dimulai sama
sekali." Dengan membungkus `session_start()` di dalam pengecekan ini,
baris tersebut **aman dipanggil berkali-kali** dari file manapun —
session hanya benar-benar dimulai **sekali** di panggilan pertama,
panggilan-panggilan berikutnya di file lain akan melihat status sudah
`PHP_SESSION_ACTIVE` dan melewati `session_start()` begitu saja.

## 4.5 Inti Pemeriksaan: `isset($_SESSION['user_id'])`

```php
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}
```

Ingat `$_SESSION['user_id']` diset saat Login berhasil
([dokumentasi jobsheet-10 §3.2](03-login-dan-logout.md#32-proses_loginphp-memverifikasi-password)).
Kalau kunci ini **belum ada** (pengunjung belum pernah login, atau
sudah logout — ingat `session_destroy()` menghapus semuanya, dari
[dokumentasi jobsheet-10 §3.3](03-login-dan-logout.md#33-authlogoutphp-mengakhiri-sesi)),
`!isset(...)` bernilai `true`, dan pengunjung **langsung dialihkan** ke
halaman Login — persis pola guard clause `header('Location: ...') + exit;`
yang sudah kamu kenal sejak
[dokumentasi jobsheet-09 §2.2](../../jobsheet-09/Dokumentasi/02-edit-update-data.md#22-mengambil-id-dari-url-_getid).

## 4.6 Kenapa Guard Ini Tetap Bekerja Meski Database Belum Tersambung?

Ingat catatan penting di [README.md](../README.md) jobsheet ini:
*"Guard `auth.php` sudah diverifikasi mengembalikan HTTP 302 ke
`../auth/login.php` untuk halaman terkunci meski database belum
tersambung."* Perhatikan kode `auth.php` di [§4.1](#41-kode-lengkap)
**sama sekali tidak menyentuh** `$pdo` atau memanggil `koneksi.php`
apa pun — ia **hanya** memeriksa `$_SESSION`, yang sepenuhnya dikelola
PHP sendiri tanpa butuh database. Karena `auth.php` dipanggil **paling
awal** ([§4.3](#43-kenapa-harus-jadi-baris-paling-pertama)), sebelum
baris manapun yang butuh `require koneksi.php`, proteksi ini tetap
berfungsi **bahkan kalau PostgreSQL sedang mati total** — pengunjung
yang belum login tetap teralihkan ke Login, tidak pernah sampai ke
titik kode yang akan gagal karena database tidak tersedia.

## 4.7 Halaman Mana Saja yang Memakai Guard Ini?

Ingat dari [README.md](../README.md) jobsheet ini, `auth.php`
di-`require` di:

- `buku/tambah.php`, `buku/edit.php`, `buku/proses_tambah.php`,
  `buku/proses_edit.php`, `buku/hapus.php`
- **Seluruh** halaman `anggota/*.php`

Sementara `index.php` dan `buku/list.php` **sengaja tidak** memanggil
`auth.php` sama sekali — tetap bisa diakses Tamu tanpa login, sesuai
pembagian aktor yang sudah dirancang sejak
[dokumentasi jobsheet-04](../../jobsheet-04/Dokumentasi/04-aktor-dan-otorisasi.md).

Lanjut ke: [Navbar Dinamis & CSS Pendukung](05-navbar-dinamis-dan-css.md)
