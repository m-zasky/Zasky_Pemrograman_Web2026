# Jobsheet 12 — Integrasi Modul Peminjaman

Sub-CPMK: Mengintegrasikan front-end dan back-end proyek secara utuh.

## Perubahan dari Jobsheet 11
- Tambah `sql/03_peminjaman.sql` — tabel `peminjaman` (relasi ke `buku` dan `anggota`), melengkapi ERD yang sudah dirancang di Jobsheet 8.
- Tambah modul **Peminjaman** (menghubungkan seluruh entitas yang sudah dibangun sejak Jobsheet 8-10 sekaligus):
  - `peminjaman/tambah.php` + `proses_tambah.php`: pilih anggota + buku (dropdown hanya `stok > 0`), simpan transaksi **dan** kurangi stok buku dalam satu **transaction** (`beginTransaction`/`commit`/`rollBack`) dengan `SELECT ... FOR UPDATE` untuk mencegah race condition stok.
  - `peminjaman/kembali.php` + `proses_kembali.php`: daftar transaksi aktif (`status = 'dipinjam'`), tombol Kembalikan menambah kembali stok buku dalam transaction serupa.
  - `peminjaman/riwayat.php`: histori peminjaman per anggota (JOIN `peminjaman` + `buku`).
- `includes/header.php`: navbar menambahkan menu Peminjaman Baru, Pengembalian, Riwayat (hanya saat login).
- `index.php`: kartu "Sedang Dipinjam" kini `COUNT(*) FROM peminjaman WHERE status = 'dipinjam'` (sebelumnya statis `0`).

## Cara menjalankan
```bash
psql -d simpus_mini -f sql/03_peminjaman.sql
```
**Opsi 1 — PHP built-in server**:
```bash
php -S localhost:8000
```

**Opsi 2 — Laragon (Apache)**: lewat virtual host langsung ke folder `jobsheet-12/` (mis. `http://jobsheet12.test/`), atau bersarang di bawah domain proyek (mis. `http://dp2026.test/kode-praktikum/jobsheet-12/`) — path CSS/JS/link/redirect login sudah relatif otomatis (lihat `includes/header.php` & `includes/auth.php`), jadi keduanya jalan.

## Pengujian end-to-end yang disarankan
Registrasi petugas → Login → Tambah Buku & Anggota → Peminjaman Baru → cek stok buku berkurang di Daftar Buku → cek kartu "Sedang Dipinjam" di Beranda bertambah → Pengembalian → cek stok kembali bertambah dan transaksi hilang dari daftar aktif → Riwayat (pilih anggota) → transaksi muncul berstatus "Selesai" → Logout.

## Catatan
- Validasi bisnis tambahan (anggota dengan peminjaman terlambat >14 hari tidak boleh meminjam buku baru) belum diterapkan — jadi tugas mandiri.
- Operasi stok memakai `SELECT ... FOR UPDATE` di dalam transaction, bukan sekadar `UPDATE buku SET stok = stok - 1` tanpa pengecekan, agar stok tidak bisa menjadi negatif bila dua peminjaman diproses hampir bersamaan.
