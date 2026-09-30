# Jobsheet 10 — Autentikasi & Manajemen Sesi

Sub-CPMK: Menerapkan autentikasi & manajemen sesi pengguna.

## Perubahan dari Jobsheet 9
- Tambah `sql/02_users.sql` — tabel `users` (nama, username, password, role).
- Tambah `auth/register.php` + `proses_register.php` (password disimpan dengan `password_hash()`, cek username duplikat), `auth/login.php` + `proses_login.php` (`password_verify()`), `auth/logout.php` (`session_destroy()`).
- Tambah `includes/auth.php` — guard clause: redirect ke `auth/login.php` bila `$_SESSION['user_id']` belum ada. **Wajib di-include sebagai baris pertama** (sebelum `header.php`) agar `header('Location: ...')` masih bisa dipanggil sebelum ada output HTML.
- `includes/header.php`: `session_start()` diubah jadi `if (session_status() === PHP_SESSION_NONE)` agar tidak konflik dengan `auth.php` yang juga memulai session; navbar kini menampilkan nama petugas + Logout jika sudah login, atau link Login jika belum.
- Halaman yang **dikunci** (butuh login): `buku/tambah.php`, `buku/edit.php`, `buku/proses_tambah.php`, `buku/proses_edit.php`, `buku/hapus.php`, seluruh halaman `anggota/*`.
- Halaman yang **tetap publik**: `index.php` (Beranda) dan `buku/list.php` (katalog buku bisa dilihat Tamu tanpa login — sesuai wireframe Jobsheet 4).

## Persiapan database
Jalankan skema tambahan:
```bash
psql -d simpus_mini -f sql/02_users.sql
```

## Cara menjalankan
**Opsi 1 — PHP built-in server**:
```bash
php -S localhost:8000
```
Uji: akses `http://localhost:8000/buku/tambah.php` langsung tanpa login → harus redirect ke halaman Login. Daftar akun via Register, login, coba akses halaman yang sama → berhasil.

**Opsi 2 — Laragon (Apache)**: lewat virtual host langsung ke folder `jobsheet-10/` (mis. `http://jobsheet10.test/`), atau bersarang di bawah domain proyek (mis. `http://dp2026.test/kode-praktikum/jobsheet-10/`) — path CSS/JS/link/redirect login sudah relatif otomatis (lihat `includes/header.php` & `includes/auth.php`), jadi keduanya jalan.

## Catatan
- Guard `auth.php` sudah diverifikasi mengembalikan HTTP 302 ke `auth/login.php` untuk halaman terkunci meski database belum tersambung (guard berjalan sebelum kode butuh koneksi DB).
- Perbedaan akses berdasarkan `role` (mis. hanya `admin` boleh hapus anggota) belum diterapkan di jobsheet ini — jadi tugas mandiri.
