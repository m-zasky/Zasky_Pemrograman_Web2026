# Jobsheet 8 — Koneksi PostgreSQL

Sub-CPMK: Menghubungkan aplikasi dengan basis data PostgreSQL.

## Perubahan dari Jobsheet 7
- Tambah `sql/01_buku_anggota.sql` — DDL tabel `buku` dan `anggota` (ERD dasar).
- Tambah `includes/koneksi.php` — koneksi `PDO` driver `pgsql`.
- `buku/proses_tambah.php` & `anggota/proses_tambah.php`: `$_SESSION['buku'][] = ...` (Jobsheet 7) diganti `INSERT ... RETURNING id` via prepared statement.
- `buku/list.php` & `anggota/list.php`: sumber data diganti dari `$_SESSION` menjadi `SELECT * FROM ... ORDER BY id DESC`.
- `index.php`: kartu statistik Total Buku/Anggota kini `SELECT COUNT(*)` dari database (bukan dummy/session lagi).

## Persiapan database
1. Pastikan PostgreSQL berjalan dan ekstensi PHP `pdo_pgsql` aktif (`php -m | grep pgsql`; bila belum ada, aktifkan `extension=pdo_pgsql` di `php.ini` lalu restart server).
2. Buat database:
   ```bash
   createdb simpus_mini
   ```
3. Jalankan skema:
   ```bash
   psql -d simpus_mini -f sql/01_buku_anggota.sql
   ```
4. Sesuaikan kredensial di `includes/koneksi.php` (`$user`, `$pass`) dengan environment lokal.

## Cara menjalankan
**Opsi 1 — PHP built-in server**:
```bash
php -S localhost:8000
```
Buka `http://localhost:8000/index.php`.

**Opsi 2 — Laragon (Apache)**: lewat virtual host langsung ke folder `jobsheet-08/` (mis. `http://jobsheet08.test/`), atau bersarang di bawah domain proyek (mis. `http://dp2026.test/kode-praktikum/jobsheet-08/`) — path CSS/JS/link sudah relatif otomatis (lihat `includes/header.php`), jadi keduanya jalan.

## Catatan
- Data yang diinput sekarang **persisten** — coba tutup-buka browser, data tetap ada (beda dengan Jobsheet 7 yang hilang saat sesi berakhir).
- Query memakai prepared statement (`:nama_parameter`) — bukan concatenation string — sebagai fondasi keamanan yang diperdalam di Jobsheet 11.
- Kolom `id` sudah ikut ter-fetch dari `SELECT *` meski belum dipakai di tampilan — akan digunakan untuk link Edit/Hapus mulai Jobsheet 9.
