# 2. Skema Database: `01_buku_anggota.sql`

File ini adalah **cetak biru** (skema) struktur database — perintah SQL
yang menentukan tabel apa saja yang ada dan aturan tiap kolomnya.

## 2.1 Kode Lengkap

```sql
-- Jobsheet 8: skema awal database simpus_mini (PostgreSQL)
-- Jalankan setelah membuat database, misal:
--   createdb simpus_mini
--   psql -d simpus_mini -f sql/01_buku_anggota.sql

CREATE TABLE IF NOT EXISTS buku (
    id SERIAL PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    pengarang VARCHAR(255) NOT NULL,
    tahun INTEGER NOT NULL,
    isbn VARCHAR(50),
    stok INTEGER NOT NULL DEFAULT 0,
    kategori VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS anggota (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    no_anggota VARCHAR(50) NOT NULL UNIQUE,
    alamat VARCHAR(255),
    no_hp VARCHAR(30)
);
```

## 2.2 Komentar SQL

```sql
-- Jobsheet 8: skema awal database simpus_mini (PostgreSQL)
```

Baris yang diawali **dua tanda hubung** (`--`) adalah **komentar SQL** —
tidak dieksekusi sama sekali, murni catatan untuk pembaca kode (mirip
fungsi `<!-- ... -->` di HTML yang sudah kamu kenal sejak
[dokumentasi jobsheet-06 §2.1](../../jobsheet-06/Dokumentasi/02-perubahan-file-html.md#21-tbody-yang-sekarang-kosong),
atau `//` di JavaScript/PHP).

## 2.3 `CREATE TABLE IF NOT EXISTS`

```sql
CREATE TABLE IF NOT EXISTS buku (
    ...
);
```

- **`CREATE TABLE nama_tabel (...)`** — perintah SQL untuk membuat tabel
  baru bernama `buku`, dengan struktur kolom yang didefinisikan di
  dalam tanda kurung.
- **`IF NOT EXISTS`** — pengaman: kalau tabel `buku` **sudah ada**
  sebelumnya (misalnya kamu menjalankan file ini dua kali tanpa
  sengaja), perintah ini **tidak akan error** — ia hanya akan
  melewatinya begitu saja, bukan mencoba membuat ulang tabel yang sudah
  ada (yang justru akan gagal dan menghapus data yang sudah ada kalau
  tidak ada pengaman ini).

## 2.4 Mendefinisikan Kolom: Nama, Tipe, dan Batasan

Setiap baris di dalam tanda kurung `CREATE TABLE` mendefinisikan **satu
kolom**, dengan pola: `nama_kolom TIPE_DATA [batasan tambahan]`.

### `id SERIAL PRIMARY KEY`

- **`SERIAL`** — tipe data khusus PostgreSQL untuk **angka yang
  bertambah otomatis** (*auto-increment*): setiap kali baris baru
  ditambahkan, PostgreSQL sendiri yang mengisi nilai `id`-nya (1, 2, 3,
  dan seterusnya), kamu **tidak perlu** menentukannya secara manual.
- **`PRIMARY KEY`** — menandai kolom ini sebagai **kunci utama**:
  nilainya **wajib unik** (tidak boleh ada dua baris dengan `id` yang
  sama) dan **wajib selalu ada** (tidak boleh kosong). Setiap tabel
  yang dirancang dengan baik biasanya punya satu kolom primary key —
  cara paling andal untuk merujuk ke **satu baris spesifik**, akan
  dipakai untuk fitur Edit/Hapus mulai Jobsheet 9 (ingat catatan di
  [README.md](../README.md) jobsheet ini).

### `judul VARCHAR(255) NOT NULL`

- **`VARCHAR(255)`** — tipe data untuk **teks**, dengan panjang
  **maksimal** 255 karakter (`VARCHAR` = *variable character*, artinya
  panjang sebenarnya boleh lebih pendek dari batas maksimalnya, beda
  dengan `CHAR` yang selalu memakai panjang tetap). Ingat kolom teks
  yang sudah kamu kenal sejak
  [dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#44-jenis-jenis-input-yang-dipakai):
  `judul`, `pengarang`, `isbn`, `kategori` semuanya bertipe `VARCHAR`
  karena isinya teks.
- **`NOT NULL`** — batasan yang mewajibkan kolom ini **selalu terisi**,
  tidak boleh kosong/`NULL` (istilah database untuk "tidak ada nilai
  sama sekali", beda dari string kosong `""`). Perhatikan ini **cocok**
  dengan atribut `required` pada `<input>` yang sudah kamu kenal sejak
  [dokumentasi jobsheet-01 §4.4](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#44-jenis-jenis-input-yang-dipakai) —
  kolom `judul`, `pengarang` di sini sama-sama `NOT NULL`, konsisten
  dengan field `judul`/`pengarang` yang sejak awal memang wajib diisi.

### `tahun INTEGER NOT NULL`

**`INTEGER`** — tipe data untuk **angka bulat** (tanpa desimal). Kolom
`tahun` dan `stok` bertipe ini, konsisten dengan tipe `type="number"`
yang sudah kamu pakai di HTML sejak
[dokumentasi jobsheet-01 §4.4](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#44-jenis-jenis-input-yang-dipakai),
dan `(int)` type casting yang sudah kamu pakai di PHP sejak
[dokumentasi jobsheet-07 §4.5](../../jobsheet-07/Dokumentasi/04-proses-tambah-validasi-server.md#45-kalau-valid-simpan-ke-session--redirect-ke-daftar).

### `isbn VARCHAR(50)` (Tanpa `NOT NULL`)

Perhatikan kolom `isbn` dan `kategori` **tidak** diberi `NOT NULL` —
artinya kolom ini **boleh kosong** (`NULL`). Ini konsisten dengan
[dokumentasi jobsheet-01 §4.4](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#44-jenis-jenis-input-yang-dipakai):
field ISBN di form memang **tidak** diberi `required` sejak awal
(tidak semua buku lama punya ISBN) — aturan database ini **selaras**
dengan aturan yang sudah ada di form HTML.

### `stok INTEGER NOT NULL DEFAULT 0`

**`DEFAULT 0`** — kalau saat `INSERT` (dibahas di
[bab 5](05-insert-prepared-statement.md)) kolom `stok` **tidak diisi
sama sekali**, PostgreSQL otomatis mengisinya dengan `0`. Ini jaring
pengaman tambahan, meski di praktiknya `proses_tambah.php` selalu
mengirim nilai stok secara eksplisit.

### `no_anggota VARCHAR(50) NOT NULL UNIQUE`

**`UNIQUE`** — batasan baru yang belum muncul di tabel `buku`: nilai
kolom ini **tidak boleh ada yang sama** di antara semua baris. Ini
masuk akal untuk nomor anggota — ingat dari
[dokumentasi jobsheet-01 §6.4](../../jobsheet-01/Dokumentasi/06-anggota-tambah-html.md#64-kenapa-no-anggota-berupa-teks-bukan-angka),
`no_anggota` (seperti `A001`) berfungsi sebagai **identitas** anggota,
jadi wajib berbeda-beda untuk setiap orang — database sendiri yang akan
**menolak** percobaan menyimpan dua anggota dengan `no_anggota` yang
sama persis, tanpa perlu kode PHP tambahan untuk memeriksanya secara
manual (meski jobsheet ini **belum** menangani error itu dengan rapi di
sisi PHP — ide latihan lanjutan di [bab 7](07-rangkuman-latihan.md)).

## 2.5 Bagaimana Kolom-Kolom Ini Berhubungan dengan Kode PHP?

Perhatikan **nama setiap kolom** di sini — `judul`, `pengarang`, `tahun`,
`isbn`, `stok`, `kategori` untuk tabel `buku`; `nama`, `no_anggota`,
`alamat`, `no_hp` untuk tabel `anggota` — **persis sama** dengan nama
kunci array asosiatif yang dipakai `proses_tambah.php` sejak
[dokumentasi jobsheet-07](../../jobsheet-07/Dokumentasi/04-proses-tambah-validasi-server.md),
yang juga sama dengan atribut `name` pada `<input>` sejak
[dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md).
Penamaan konsisten ini (sudah disinggung juga di
[dokumentasi jobsheet-06 §3.3](../../jobsheet-06/Dokumentasi/03-data-json.md#33-kenapa-nama-kuncinya-persis-sama-dengan-atribut-name-di-form))
sekarang terbukti manfaatnya di lapisan **paling dalam**: dari HTML,
lewat PHP, sampai ke kolom database — satu field yang sama selalu punya
nama yang sama di **setiap** lapisan aplikasi.

Lanjut ke: [Persiapan Database Sebelum Menjalankan](03-persiapan-database.md)
