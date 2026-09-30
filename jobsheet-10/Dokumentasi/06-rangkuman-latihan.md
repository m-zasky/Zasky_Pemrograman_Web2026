# 6. Rangkuman & Latihan Lanjutan

## 6.1 Rangkuman Keseluruhan Jobsheet 10

| Bagian | Konsep yang Dipelajari |
|---|---|
| [Konsep Dasar Autentikasi](01-konsep-dasar-autentikasi.md) | Autentikasi vs otorisasi, kenapa password harus di-hash |
| [Tabel `users` & Registrasi](02-skema-users-dan-registrasi.md) | Skema `users`, `password_hash()`, cek username duplikat |
| [Login & Logout](03-login-dan-logout.md) | `password_verify()`, menyimpan identitas ke `$_SESSION`, `session_destroy()` |
| [Guard `auth.php`](04-guard-auth-php.md) | Urutan `include` yang kritis, `session_status()`, guard yang bekerja tanpa database |
| [Navbar Dinamis & CSS](05-navbar-dinamis-dan-css.md) | Menu & status login kondisional, `$sudahLogin` |

## 6.2 Konsep Inti yang Perlu Diingat

1. **Password harus di-hash, tidak pernah disimpan apa adanya** —
   `password_hash()` saat menyimpan, `password_verify()` saat
   memeriksa, keduanya **tidak pernah** membutuhkan/menghasilkan
   password asli dalam bentuk yang bisa dibaca kembali
   ([bab 1 §1.2](01-konsep-dasar-autentikasi.md#12-kenapa-password-tidak-boleh-disimpan-apa-adanya)).
2. **Urutan `include`/`require` bisa jadi krusial** — `auth.php` wajib
   dipanggil sebelum ada output HTML apa pun, karena `header('Location: ...')`
   gagal kalau dipanggil terlambat
   ([bab 4 §4.3](04-guard-auth-php.md#43-kenapa-harus-jadi-baris-paling-pertama)).
3. **`session_status()` mencegah konflik `session_start()` ganda**,
   penting begitu banyak file berbeda perlu memeriksa/memulai session
   yang sama
   ([bab 4 §4.4](04-guard-auth-php.md#44-kenapa-session_status-diperiksa-dulu)).
4. **Guard clause otorisasi seharusnya tidak bergantung pada
   database** — supaya proteksi tetap berfungsi meski ada bagian lain
   dari aplikasi yang gagal
   ([bab 4 §4.6](04-guard-auth-php.md#46-kenapa-guard-ini-tetap-bekerja-meski-database-belum-tersambung)).
5. **Menyembunyikan menu di UI bukan pengganti otorisasi
   sungguhan** — keduanya perlu ada bersamaan: UI yang rapi **dan**
   guard yang benar-benar memblokir akses langsung
   ([bab 5 §5.4](05-navbar-dinamis-dan-css.md#54-menu-yang-muncul-hilang-php-if-sudahlogin-)).

## 6.3 Cara Mencoba Sendiri

1. Jalankan skema tambahan (ingat dari [README.md](../README.md)):
   ```bash
   psql -d simpus_mini -f sql/02_users.sql
   ```
2. Jalankan `php -S localhost:8000` (atau lewat Laragon), buka
   `http://localhost:8000/buku/tambah.php` **langsung** tanpa login —
   amati kamu diarahkan ke halaman Login (bukti guard `auth.php`
   bekerja).
3. Klik "Daftar di sini", isi form Registrasi — amati password yang
   kamu ketik **tidak pernah muncul** di database secara langsung
   (kalau penasaran, lihat isi kolom `password` di tabel `users` lewat
   `psql`, akan terlihat teks acakan panjang, bukan password aslimu).
4. Login dengan akun yang baru dibuat — amati navbar berubah:
   muncul menu Tambah Buku/Daftar Anggota/Tambah Anggota, dan nama
   petugas + tautan Logout di pojok kanan.
5. Buka kembali `/buku/tambah.php` — sekarang **berhasil** diakses
   (dibandingkan langkah 2 tadi).
6. Klik Logout — amati navbar kembali seperti semula (menu terbatas,
   tautan Login muncul lagi), dan coba akses `/buku/tambah.php` lagi —
   kembali diarahkan ke Login.
7. Coba **salah** memasukkan password saat Login — amati pesan error
   umum "Username atau password salah." muncul (ingat alasannya dari
   [bab 3 §3.2](03-login-dan-logout.md#32-proses_loginphp-memverifikasi-password)).

## 6.4 Ide Latihan Tambahan (Opsional)

1. **Terapkan kontrol akses berbasis `role`** — sesuai catatan di
   [README.md](../README.md) jobsheet ini yang menyebutnya sebagai
   tugas mandiri: buat aturan misalnya hanya `role === 'admin'` yang
   boleh mengakses `anggota/hapus.php`, sementara `'petugas'` biasa
   hanya boleh melihat dan menambah data. Petunjuk: kamu perlu
   menambah pengecekan baru **setelah** `require auth.php`, memeriksa
   `$_SESSION['role']`.
2. **Tambah "Ingat Saya" (Remember Me)** — cari tahu lewat dokumentasi
   PHP resmi bagaimana cookie dengan masa berlaku panjang bisa dipakai
   untuk menjaga sesi login tetap aktif meski browser ditutup (petunjuk:
   fungsi `setcookie()`), lalu diskusikan sendiri risiko keamanannya
   dibanding sekadar mengandalkan `$_SESSION` biasa.
3. **Batasi percobaan Login yang gagal** — tambahkan penghitung
   percobaan gagal per username (bisa disimpan sementara di
   `$_SESSION` untuk latihan), dan tampilkan peringatan setelah
   beberapa kali gagal berturut-turut — langkah awal mencegah serangan
   *brute-force* menebak password.
4. **Uji coba mematikan PostgreSQL** sesuai catatan di
   [README.md](../README.md) jobsheet ini — coba hentikan sementara
   layanan PostgreSQL di komputermu, lalu akses `/buku/tambah.php`
   tanpa login — buktikan sendiri kamu tetap diarahkan ke Login
   (bukan melihat error koneksi database), sesuai penjelasan di
   [bab 4 §4.6](04-guard-auth-php.md#46-kenapa-guard-ini-tetap-bekerja-meski-database-belum-tersambung).

Kalau ada bagian yang masih membingungkan, terutama soal urutan
`include`/`require` di [bab 4](04-guard-auth-php.md), coba baca ulang
sambil membayangkan skenario jika urutannya dibalik — memahami
**kenapa** sesuatu harus dilakukan dalam urutan tertentu jauh lebih
berharga daripada sekadar menghafal urutannya.
