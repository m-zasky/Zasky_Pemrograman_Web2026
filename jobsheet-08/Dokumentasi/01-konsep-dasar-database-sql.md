# 1. Konsep Dasar Database & SQL

Ini pengenalan pertamamu ke database sungguhan. Kenali dulu istilah-
istilah dasarnya sebelum membaca kode PHP yang menghubunginya.

## 1.1 Kenapa Butuh Database? (Mengingat Kembali Masalahnya)

Perjalanan penyimpanan data SIMPUS-Mini sejauh ini:

| Jobsheet | Cara Menyimpan Data | Masalahnya |
|---|---|---|
| 01-05 | Ditulis manual di HTML | Tidak bisa ditambah lewat form sama sekali |
| 06 | File `data/*.json` | Bisa **dibaca**, tapi tidak bisa **ditambah** lewat form (ingat [dokumentasi jobsheet-06](../../jobsheet-06/Dokumentasi/README.md)) |
| 07 | `$_SESSION` | Bisa ditambah **dan** dibaca, tapi **hilang** saat sesi browser berakhir (ingat [dokumentasi jobsheet-07 §3.5](../../jobsheet-07/Dokumentasi/03-session-dan-alur-data.md#35-kenapa-data-ini-sementara)) |
| **08** | **Database PostgreSQL** | **Bisa ditambah, dibaca, dan tersimpan permanen** |

Database menyelesaikan masalah terakhir: data disimpan di **program
khusus** (disebut *Database Management System*/DBMS — PostgreSQL adalah
salah satu contohnya) yang berjalan **terus-menerus** di komputer/server,
terpisah dari aplikasi PHP-mu sendiri. Kalau kamu menutup browser,
bahkan mematikan server PHP-nya sekalipun, PostgreSQL **tetap berjalan**
dan datanya tetap tersimpan aman, siap dibaca lagi kapan pun aplikasi
PHP-mu terhubung kembali.

## 1.2 Database Relasional: Tabel, Baris, Kolom

PostgreSQL adalah **database relasional** — data disimpan dalam bentuk
**tabel**, mirip konsepnya dengan tabel HTML yang sudah sangat kamu
kenal sejak
[dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/03-buku-list-html.md#32-anatomi-tabel-html):

| Istilah Database | Istilah Tabel HTML yang Setara |
|---|---|
| **Tabel** (*table*) | `<table>` — misalnya tabel `buku` |
| **Kolom** (*column*) | `<th>` — misalnya kolom `judul`, `pengarang`, `tahun` |
| **Baris** (*row*) | `<tr>` — satu baris = satu buku |

Bedanya: tabel di database **benar-benar tersimpan** di disk (bukan
sekadar tampilan), dan punya **aturan ketat** tentang jenis data apa
yang boleh masuk ke tiap kolom (dibahas di [bab 2](02-skema-database-sql.md)) —
sesuatu yang tidak dimiliki tabel HTML biasa.

## 1.3 Apa itu SQL?

**SQL** (*Structured Query Language*) adalah bahasa khusus untuk
"berbicara" dengan database relasional — membuat tabel, menyimpan data,
mengambil data, dst. Berbeda dari PHP/JavaScript yang menulis
**instruksi langkah demi langkah** (buat variabel, lalu lakukan ini,
lalu lakukan itu), SQL lebih bersifat **mendeklarasikan apa yang
diinginkan**, dan database sendiri yang menentukan cara paling efisien
mendapatkannya. Empat perintah SQL dasar yang akan kamu temui:

| Perintah | Fungsi | Dibahas di |
|---|---|---|
| `CREATE TABLE` | Membuat tabel baru beserta struktur kolomnya | [bab 2](02-skema-database-sql.md) |
| `INSERT` | Menambahkan satu baris data baru | [bab 5](05-insert-prepared-statement.md) |
| `SELECT` | Mengambil/membaca data | [bab 6](06-membaca-data-select.md) |
| `UPDATE`/`DELETE` | Mengubah/menghapus data | Belum dipakai di jobsheet ini — menyusul di Jobsheet 9 |

## 1.4 Apa itu PDO?

PHP sendiri **tidak otomatis** tahu cara berkomunikasi dengan
PostgreSQL — dibutuhkan sebuah "jembatan". **PDO** (*PHP Data Objects*)
adalah lapisan bawaan PHP yang menyediakan **cara seragam** untuk
terhubung ke berbagai jenis database (PostgreSQL, MySQL, SQLite, dst.)
memakai kode PHP yang mirip, hanya berbeda sedikit di bagian
penyambungan awal. Detail cara memakainya di jobsheet ini dibahas di
[bab 4](04-koneksi-pdo.md).

## 1.5 Kenapa Ada Langkah "Persiapan" Sebelum Menjalankan Jobsheet Ini?

Berbeda dari jobsheet-01 sampai jobsheet-07 yang langsung bisa dicoba
(paling banter perlu `php -S localhost:8000` atau Laragon), jobsheet ini butuh
**PostgreSQL sungguhan terpasang dan berjalan** di komputermu, plus
sebuah database baru yang **harus dibuat dan diisi skemanya lebih
dulu** sebelum aplikasi PHP bisa terhubung ke mana pun. Langkah-langkah
persiapan ini dibahas lengkap di [bab 3](03-persiapan-database.md) —
jangan lewati bab itu sebelum mencoba menjalankan jobsheet ini sendiri.

Lanjut ke: [Skema Database: `01_buku_anggota.sql`](02-skema-database-sql.md)
