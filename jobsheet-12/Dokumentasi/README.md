# Dokumentasi Jobsheet 12 — Integrasi Modul Peminjaman

Dokumentasi ini melanjutkan
[dokumentasi jobsheet-11](../../jobsheet-11/Dokumentasi/README.md)
(Keamanan Web Dasar). Jobsheet-12 adalah **puncak** dari seluruh
rangkaian jobsheet SIMPUS-Mini — ingat wireframe Peminjaman/Pengembalian
yang sudah kamu bedah sejak
[dokumentasi jobsheet-04 §3](../../jobsheet-04/Dokumentasi/03-user-flow-peminjaman-pengembalian.md),
8 jobsheet yang lalu — sekarang **benar-benar dibangun**, menghubungkan
**semua** yang sudah kamu pelajari: HTML/CSS, PHP, database, sesi,
otorisasi, dan keamanan, sekaligus dalam satu fitur.

## Tentang `docs/wireframe.md` dan `docs/security-checklist.md`

Kedua file ini **identik persis** dengan versi di
[jobsheet-11](../../jobsheet-11/docs/). Tidak ada rancangan UI/UX
maupun audit keamanan baru — jobsheet ini murni **mengimplementasikan**
apa yang sudah dirancang dan diamankan sebelumnya.

## Apa yang Baru di Jobsheet 12?

Sesuai [README.md](../README.md) jobsheet ini:

1. **`sql/03_peminjaman.sql`** — tabel `peminjaman` baru, **terhubung**
   (lewat *foreign key*) ke tabel `buku` dan `anggota` yang sudah ada
   sejak jobsheet-08.
2. **`peminjaman/tambah.php` + `proses_tambah.php`** — mencatat
   peminjaman baru **dan** mengurangi stok buku **dalam satu
   transaction**, dengan `SELECT ... FOR UPDATE` untuk mencegah *race
   condition*.
3. **`peminjaman/kembali.php` + `proses_kembali.php`** — daftar
   transaksi aktif, tombol Kembalikan yang menambah kembali stok buku.
4. **`peminjaman/riwayat.php`** — histori peminjaman per anggota,
   memakai `JOIN` untuk menggabungkan data dari 3 tabel sekaligus.
5. **Navbar** menambahkan 3 menu baru (Peminjaman Baru, Pengembalian,
   Riwayat), hanya untuk Petugas yang login.
6. **Kartu "Sedang Dipinjam"** di Beranda kini benar-benar dihitung
   dari database, menggantikan angka statis `0` sejak jobsheet-01.

## Daftar Isi

1. [Konsep Dasar: Relasi Tabel & Transaction](01-konsep-dasar-integrasi-dan-transaksi.md)
2. [Skema `peminjaman` & Relasi Antar Tabel](02-skema-peminjaman-dan-relasi.md)
3. [Peminjaman Baru & Database Transaction](03-peminjaman-baru-dan-transaction.md)
4. [Pengembalian Buku](04-pengembalian-buku.md)
5. [Riwayat Peminjaman & `JOIN`](05-riwayat-peminjaman-join.md)
6. [Rangkuman & Latihan Lanjutan](06-rangkuman-latihan.md)

## Struktur Folder

```
jobsheet-12/
├── index.php                       # Kartu "Sedang Dipinjam" kini dari database
├── includes/
│   ├── header.php                    # + 3 menu Peminjaman
│   └── ...                            # Tidak berubah lainnya
├── peminjaman/
│   ├── tambah.php, proses_tambah.php  # BARU — transaction + FOR UPDATE
│   ├── kembali.php, proses_kembali.php # BARU — transaction serupa
│   └── riwayat.php                     # BARU — JOIN 2 tabel
├── sql/
│   ├── 01_buku_anggota.sql
│   ├── 02_users.sql
│   └── 03_peminjaman.sql               # BARU — tabel peminjaman + foreign key
├── buku/, anggota/, auth/               # Tidak berubah dari jobsheet-11
├── docs/
│   ├── wireframe.md                     # Identik dengan jobsheet-11
│   └── security-checklist.md            # Identik dengan jobsheet-11
├── README.md
└── Dokumentasi/                          # Folder dokumentasi ini
```

**Catatan penting** dari [README.md](../README.md) jobsheet ini:
validasi bisnis tambahan (anggota dengan peminjaman terlambat >14 hari
tidak boleh meminjam buku baru) **belum diterapkan** — dijadikan tugas
mandiri (lihat [bab 6](06-rangkuman-latihan.md)).
