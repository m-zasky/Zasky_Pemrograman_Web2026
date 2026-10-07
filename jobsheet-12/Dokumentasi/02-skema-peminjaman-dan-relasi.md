# 2. Skema `peminjaman` & Relasi Antar Tabel

## 2.1 Kode Lengkap `sql/03_peminjaman.sql`

```sql
-- Jobsheet 12: tabel peminjaman, menghubungkan buku, anggota, dan users
-- Jalankan: psql -d simpus_mini -f sql/03_peminjaman.sql

CREATE TABLE IF NOT EXISTS peminjaman (
    id SERIAL PRIMARY KEY,
    buku_id INTEGER NOT NULL REFERENCES buku(id),
    anggota_id INTEGER NOT NULL REFERENCES anggota(id),
    tanggal_pinjam DATE NOT NULL DEFAULT CURRENT_DATE,
    tanggal_kembali DATE,
    status VARCHAR(20) NOT NULL DEFAULT 'dipinjam'
);
```

Elemen `SERIAL PRIMARY KEY`, `NOT NULL`, `VARCHAR`, `DEFAULT` sudah
kamu kuasai sejak
[dokumentasi jobsheet-08 §2](../../jobsheet-08/Dokumentasi/02-skema-database-sql.md).
Mari bedah bagian-bagian yang baru.

## 2.2 Kolom Foreign Key: `buku_id` dan `anggota_id`

```sql
buku_id INTEGER NOT NULL REFERENCES buku(id),
anggota_id INTEGER NOT NULL REFERENCES anggota(id),
```

Ingat konsep foreign key dari
[bab 1 §1.2](01-konsep-dasar-integrasi-dan-transaksi.md#12-foreign-key-menghubungkan-antar-tabel).
Perhatikan pola penamaan kolomnya: **`buku_id`** — gabungan nama tabel
yang dirujuk (`buku`) ditambah `_id`. Ini konvensi penamaan yang umum
dipakai supaya sekilas membaca nama kolom saja sudah cukup untuk
menebak tabel mana yang dirujuknya, tanpa perlu membuka skema tabel
`peminjaman` secara lengkap. Sama halnya dengan `anggota_id`, merujuk
ke `anggota(id)`.

## 2.3 Tipe Data `DATE` dan `DEFAULT CURRENT_DATE`

```sql
tanggal_pinjam DATE NOT NULL DEFAULT CURRENT_DATE,
tanggal_kembali DATE,
```

- **`DATE`** — tipe data baru, khusus menyimpan **tanggal** (tanpa
  jam/menit/detik) — cocok untuk kolom seperti ini yang hanya perlu
  tahu "tanggal berapa," bukan waktu presisi ke detik.
- **`DEFAULT CURRENT_DATE`** — ingat konsep `DEFAULT` dari
  [dokumentasi jobsheet-08 §2.4](../../jobsheet-08/Dokumentasi/02-skema-database-sql.md#24-mendefinisikan-kolom-nama-tipe-dan-batasan),
  di sini dipasangkan dengan **`CURRENT_DATE`** — fungsi bawaan
  PostgreSQL yang selalu bernilai "tanggal hari ini." Kalau `INSERT`
  tidak menyebutkan nilai untuk `tanggal_pinjam` secara eksplisit,
  PostgreSQL otomatis mengisinya dengan tanggal saat baris itu dibuat —
  mewujudkan wireframe form Peminjaman yang sudah kamu bedah sejak
  [dokumentasi jobsheet-04 §2.3](../../jobsheet-04/Dokumentasi/02-cara-membaca-wireframe.md#23-wireframe-yang-lebih-kompleks-dashboard-petugas):
  *"Tanggal Pinjam: [ auto: hari ini ]"*.
- **`tanggal_kembali DATE`** (tanpa `NOT NULL`) — kolom ini **boleh
  kosong** (`NULL`), karena saat buku baru dipinjam, tanggal
  kembalinya **belum diketahui** — kolom ini baru akan diisi saat
  proses Pengembalian ([bab 4](04-pengembalian-buku.md)).

## 2.4 Kolom `status`

```sql
status VARCHAR(20) NOT NULL DEFAULT 'dipinjam'
```

Menyimpan **status** transaksi peminjaman, dengan **dua** nilai yang
mungkin di aplikasi ini: `'dipinjam'` (nilai default saat baru dibuat)
atau `'dikembalikan'` (diubah saat proses Pengembalian). Kolom ini
persis mewujudkan kolom "Status" yang sudah kamu bedah di wireframe
Riwayat Peminjaman sejak
[dokumentasi jobsheet-04 §2.3](../../jobsheet-04/Dokumentasi/02-cara-membaca-wireframe.md#23-wireframe-yang-lebih-kompleks-dashboard-petugas).

## 2.5 Diagram Relasi Sederhana

```
buku                    peminjaman                  anggota
┌──────────┐            ┌──────────────────┐        ┌──────────┐
│ id (PK)  │◄───────────│ buku_id (FK)      │        │ id (PK)  │
│ judul    │            │ anggota_id (FK) ──┼───────►│ nama     │
│ stok     │            │ tanggal_pinjam    │        │ no_ang.  │
│ ...      │            │ tanggal_kembali   │        │ ...      │
└──────────┘            │ status            │        └──────────┘
                         └──────────────────┘
```

- **PK** (*Primary Key*) — kunci utama tiap tabel, ingat dari
  [dokumentasi jobsheet-08 §2.4](../../jobsheet-08/Dokumentasi/02-skema-database-sql.md#24-mendefinisikan-kolom-nama-tipe-dan-batasan).
- **FK** (*Foreign Key*) — kolom yang **menunjuk** ke Primary Key
  tabel lain, ingat dari [§2.2](#22-kolom-foreign-key-buku_id-dan-anggota_id).

Tabel `peminjaman` berada **di tengah**, secara harfiah menjadi
"jembatan" yang menghubungkan satu baris `buku` dengan satu baris
`anggota` — pola desain database yang sangat umum, disebut **relasi
banyak-ke-banyak** (*many-to-many*): satu buku bisa dipinjam oleh
banyak anggota berbeda **dari waktu ke waktu** (satu per satu, karena
stoknya terbatas), dan satu anggota bisa meminjam banyak buku berbeda.

## 2.6 Menjalankan Skema Tambahan

Sesuai [README.md](../README.md) jobsheet ini:
```bash
psql -d simpus_mini -f sql/03_peminjaman.sql
```

Ingat pola perintah ini dari
[dokumentasi jobsheet-08 §3.3](../../jobsheet-08/Dokumentasi/03-persiapan-database.md#33-langkah-3-menjalankan-skema) —
menjalankan file skema tambahan **tanpa** mengulang seluruh setup dari
awal, karena `CREATE TABLE IF NOT EXISTS`
([dokumentasi jobsheet-08 §2.3](../../jobsheet-08/Dokumentasi/02-skema-database-sql.md#23-create-table-if-not-exists))
aman dijalankan kapan pun tanpa mengganggu tabel `buku`/`anggota`/`users`
yang sudah ada.

Lanjut ke: [Peminjaman Baru & Database Transaction](03-peminjaman-baru-dan-transaction.md)
