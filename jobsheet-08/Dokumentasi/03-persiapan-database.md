# 3. Persiapan Database Sebelum Menjalankan

Bab ini membedah **langkah demi langkah** persiapan yang tertulis di
[README.md](../README.md) jobsheet ini — **wajib** dilakukan sebelum
mencoba menjalankan aplikasi, berbeda dari jobsheet-jobsheet sebelumnya
yang bisa langsung dicoba.

## 3.1 Langkah 1: Pastikan PostgreSQL & Ekstensi PHP Siap

> Pastikan PostgreSQL berjalan dan ekstensi PHP `pdo_pgsql` aktif
> (`php -m | grep pgsql`; bila belum ada, aktifkan `extension=pdo_pgsql`
> di `php.ini` lalu restart server).

- **PostgreSQL harus terpasang dan berjalan** di komputermu (ingat dari
  [bab 1 §1.1](01-konsep-dasar-database-sql.md#11-kenapa-butuh-database-mengingat-kembali-masalahnya):
  ia adalah program terpisah yang berjalan sendiri, bukan bagian dari
  PHP). Kalau kamu memakai **Windows dengan Laragon** dan belum pernah
  memasang PostgreSQL sama sekali, ikuti dulu panduan langkah-per-langkah
  di [bab 8 (Lampiran)](08-instalasi-postgresql-laragon.md) sebelum
  melanjutkan bab ini.
- **`php -m`** menampilkan daftar seluruh **ekstensi** (modul tambahan)
  yang aktif di instalasi PHP-mu. `pdo_pgsql` adalah ekstensi
  **spesifik** yang memungkinkan PDO (ingat dari
  [bab 1 §1.4](01-konsep-dasar-database-sql.md#14-apa-itu-pdo)) berbicara
  dengan PostgreSQL — tanpa ekstensi ini aktif, baris
  `new PDO("pgsql:...")` di [bab 4](04-koneksi-pdo.md) akan gagal total.
- **`php.ini`** adalah file konfigurasi utama PHP. Kalau ekstensi
  `pdo_pgsql` belum aktif, kamu perlu membuka file ini, mencari baris
  `;extension=pdo_pgsql` (tanda titik koma di depan berarti "dinonaktifkan/
  dikomentari"), menghapus titik koma itu, menyimpan file, lalu
  **me-restart** server PHP supaya perubahan konfigurasi terbaca ulang.

## 3.2 Langkah 2: Membuat Database

```bash
createdb simpus_mini
```

**`createdb`** adalah perintah command-line bawaan PostgreSQL untuk
membuat sebuah **database baru** bernama `simpus_mini` — wadah kosong
tempat semua tabel (dan datanya) nanti akan disimpan. Bandingkan dengan
istilah `db` di
[`includes/koneksi.php`](04-koneksi-pdo.md#42-lima-variabel-konfigurasi) —
nama `simpus_mini` inilah yang harus **sama persis** dengan yang ditulis
di sana.

## 3.3 Langkah 3: Menjalankan Skema

```bash
psql -d simpus_mini -f sql/01_buku_anggota.sql
```

**`psql`** adalah program command-line untuk **berinteraksi** dengan
PostgreSQL. Perintah ini berarti: "hubungkan ke database `simpus_mini`
(`-d simpus_mini`), lalu jalankan seluruh perintah SQL yang ada di file
`sql/01_buku_anggota.sql` (`-f ...`)." Setelah perintah ini berhasil,
tabel `buku` dan `anggota` yang sudah dibahas di
[bab 2](02-skema-database-sql.md) akan benar-benar **ada** di dalam
database `simpus_mini`, siap menerima data.

## 3.4 Langkah 4: Menyesuaikan Kredensial

> Sesuaikan kredensial di `includes/koneksi.php` (`$user`, `$pass`)
> dengan environment lokal.

**Kredensial** (*credentials*) adalah informasi identitas/otorisasi —
di sini, nama pengguna (`$user`) dan kata sandi (`$pass`) yang dipakai
untuk masuk ke PostgreSQL di komputermu. Instalasi PostgreSQL yang
berbeda-beda punya kredensial default yang berbeda pula (tergantung
cara instalasinya) — kalau nilai default `"postgres"`/`"postgres"` yang
sudah ditulis di `koneksi.php` (dibahas di
[bab 4](04-koneksi-pdo.md)) ternyata tidak cocok dengan instalasi
PostgreSQL-mu, kamu perlu menggantinya secara manual dengan kredensial
yang benar di komputermu sendiri.

## 3.5 Urutan Ini Penting — Jangan Dibalik

Perhatikan urutan 4 langkah di atas **saling bergantung**: kamu tidak
bisa menjalankan skema ([§3.3](#33-langkah-3-menjalankan-skema)) sebelum
database-nya dibuat ([§3.2](#32-langkah-2-membuat-database)), dan
aplikasi PHP tidak akan bisa terhubung sama sekali
([bab 4](04-koneksi-pdo.md)) kalau ekstensi `pdo_pgsql` belum aktif
([§3.1](#31-langkah-1-pastikan-postgresql--ekstensi-php-siap)) atau
kredensialnya salah ([§3.4](#34-langkah-4-menyesuaikan-kredensial)).
Kalau salah satu langkah terlewat, gejalanya biasanya muncul sebagai
pesan **"Koneksi database gagal: ..."** — dibahas cara membaca pesan
error ini di [bab 4 §4.4](04-koneksi-pdo.md#44-menangani-kegagalan-koneksi).

Lanjut ke: [Koneksi PHP ke Database: `koneksi.php`](04-koneksi-pdo.md)
