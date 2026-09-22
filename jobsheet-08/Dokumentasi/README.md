# Dokumentasi Jobsheet 8 — Koneksi PostgreSQL

Dokumentasi ini melanjutkan
[dokumentasi jobsheet-07](../../jobsheet-07/Dokumentasi/README.md)
(PHP Dasar & Form Handling). Jobsheet-08 menutup satu "lubang" penting
yang sudah disinggung berkali-kali di dokumentasi sebelumnya: data yang
**benar-benar tersimpan**, tidak hilang begitu sesi browser berakhir.

## Tentang `docs/wireframe.md`

File ini **identik persis** dengan
[`docs/wireframe.md` di jobsheet-07](../../jobsheet-07/docs/wireframe.md) —
tidak ada rancangan UI/UX baru di jobsheet ini.

## Kenapa Ini Penting?

Ingat catatan yang sudah berulang kali muncul sejak
[dokumentasi jobsheet-07 §3.5](../../jobsheet-07/Dokumentasi/03-session-dan-alur-data.md#35-kenapa-data-ini-sementara):
data di `$_SESSION` **hilang** begitu sesi browser berakhir. Jobsheet-08
mengganti sumber data dari `$_SESSION` menjadi **database PostgreSQL**
sungguhan — data yang kamu tambahkan sekarang akan **tetap ada**
meskipun kamu menutup browser, mematikan komputer, atau kembali lagi
besok.

## Apa yang Baru di Jobsheet 8?

Sesuai [README.md](../README.md) jobsheet ini:

1. **`sql/01_buku_anggota.sql`** — skema database: perintah SQL untuk
   membuat tabel `buku` dan `anggota`.
2. **`includes/koneksi.php`** — kode PHP yang menghubungkan aplikasi ke
   database PostgreSQL, memakai **PDO**.
3. **`proses_tambah.php`** (buku & anggota) — `$_SESSION['buku'][] = ...`
   dari jobsheet-07 diganti `INSERT ... RETURNING id` lewat **prepared
   statement**.
4. **`list.php`** (buku & anggota) — sumber data diganti dari
   `$_SESSION` menjadi `SELECT * FROM ... ORDER BY id DESC`.
5. **`index.php`** — kartu statistik Total Buku/Anggota sekarang
   `SELECT COUNT(*)` dari database sungguhan, bukan lagi dummy/session.

## Daftar Isi

1. [Konsep Dasar Database & SQL](01-konsep-dasar-database-sql.md)
2. [Skema Database: `01_buku_anggota.sql`](02-skema-database-sql.md)
3. [Persiapan Database Sebelum Menjalankan](03-persiapan-database.md)
4. [Koneksi PHP ke Database: `koneksi.php`](04-koneksi-pdo.md)
5. [Menyimpan Data: Prepared Statement & `INSERT`](05-insert-prepared-statement.md)
6. [Membaca Data: `SELECT`](06-membaca-data-select.md)
7. [Rangkuman & Latihan Lanjutan](07-rangkuman-latihan.md)
8. [Lampiran: Instalasi PostgreSQL di Laragon (Windows)](08-instalasi-postgresql-laragon.md)

## Struktur Folder

```
jobsheet-08/
├── index.php                      # Kartu statistik dari SELECT COUNT(*)
├── includes/
│   ├── header.php, footer.php      # Tidak berubah dari jobsheet-07
│   └── koneksi.php                  # BARU — koneksi PDO ke PostgreSQL
├── sql/
│   └── 01_buku_anggota.sql          # BARU — skema tabel buku & anggota
├── buku/
│   ├── list.php                     # SELECT * FROM buku, bukan $_SESSION
│   ├── tambah.php                   # Tidak berubah dari jobsheet-07
│   └── proses_tambah.php            # INSERT via prepared statement
├── anggota/
│   ├── list.php
│   ├── tambah.php
│   └── proses_tambah.php            # INSERT via prepared statement
├── docs/wireframe.md                 # Identik dengan jobsheet-07
├── README.md
└── Dokumentasi/                      # Folder dokumentasi ini
```

**Catatan penting** dari [README.md](../README.md) jobsheet ini:

- Query di sini memakai **prepared statement** (`:nama_parameter`),
  bukan menggabung string mentah — ini fondasi keamanan yang akan
  diperdalam di Jobsheet 11.
- Kolom `id` sudah ikut ter-fetch lewat `SELECT *`, meski belum dipakai
  di tampilan — akan dipakai untuk tautan Edit/Hapus mulai Jobsheet 9.
- **Jobsheet ini butuh persiapan tambahan** (menginstal/menjalankan
  PostgreSQL, membuat database) sebelum bisa dicoba — dibahas lengkap
  di [bab 3](03-persiapan-database.md).
