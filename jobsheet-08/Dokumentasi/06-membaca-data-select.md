# 6. Membaca Data: `SELECT`

Bab terakhir sebelum rangkuman: bagaimana `list.php` dan `index.php`
**membaca kembali** data yang sudah tersimpan lewat proses `INSERT`
di [bab 5](05-insert-prepared-statement.md).

## 6.1 `buku/list.php`: Mengambil Semua Baris

**Sebelumnya (jobsheet-07):**
```php
$daftarBuku = $_SESSION['buku'] ?? [];
```

**Sekarang (jobsheet-08):**
```php
require __DIR__ . '/../includes/koneksi.php';

$daftarBuku = $pdo->query("SELECT * FROM buku ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
```

Mari bedah query SQL-nya:

- **`SELECT * FROM buku`** — "ambil **semua kolom** (`*`) dari **semua
  baris** di tabel `buku`" (ingat struktur tabelnya dari
  [bab 2](02-skema-database-sql.md)).
- **`ORDER BY id DESC`** — mengurutkan hasilnya berdasarkan kolom `id`,
  secara **menurun** (`DESC` = *descending*, dari besar ke kecil). Ingat
  `id` bertambah otomatis setiap ada baris baru
  ([bab 2 §2.4](02-skema-database-sql.md#24-mendefinisikan-kolom-nama-tipe-dan-batasan)) —
  mengurutkan menurun berdasarkan `id` berarti **buku yang paling baru
  ditambahkan muncul paling atas** di tabel. Bandingkan dengan
  `$_SESSION['buku']` di jobsheet-07 yang selalu menampilkan buku
  **sesuai urutan ditambahkan** (baru selalu di bawah, karena
  `[] = ...` menambah ke akhir array) — sekarang urutannya sengaja
  dibalik supaya data terbaru lebih mudah terlihat.

## 6.2 Menjalankan Query Sederhana: `$pdo->query(...)`

```php
$pdo->query("SELECT * FROM buku ORDER BY id DESC")
```

Perhatikan di sini memakai **`$pdo->query(...)`**, **bukan**
`$pdo->prepare(...)` + `execute(...)` seperti `INSERT` di
[bab 5](05-insert-prepared-statement.md#52-menyiapkan-query-pdo-prepare).
Bedanya: `query()` dipakai untuk perintah SQL yang **tidak melibatkan
nilai dari luar** (tidak ada data pengguna yang perlu disisipkan ke
dalam query ini) — query ini selalu persis sama teksnya setiap kali
dijalankan, jadi tidak butuh mekanisme placeholder seperti prepared
statement. Aturan praktisnya: **kapan pun ada nilai dari `$_POST` (atau
sumber luar lain) yang perlu masuk ke query**, selalu pakai
`prepare()`+`execute()` demi keamanan ([bab 5 §5.3](05-insert-prepared-statement.md#53-apa-itu-prepared-statement-dan-kenapa-penting)) —
kalau tidak ada nilai luar sama sekali, `query()` yang lebih sederhana
sudah cukup.

## 6.3 Mengubah Hasil Query Jadi Array PHP: `fetchAll(PDO::FETCH_ASSOC)`

```php
->fetchAll(PDO::FETCH_ASSOC)
```

- **`fetchAll(...)`** — mengambil **seluruh** baris hasil query
  sekaligus, dikembalikan sebagai sebuah array.
- **`PDO::FETCH_ASSOC`** — mode pengambilan yang menentukan **bentuk**
  tiap baris di dalam array itu: sebagai **array asosiatif**, dengan
  kunci berupa **nama kolom** (`'judul'`, `'pengarang'`, dst.) — persis
  bentuk yang sudah kamu pakai untuk mengakses `$buku['judul']` di
  [bab 6.4](#64-menampilkan-hasilnya-di-tabel-tidak-berubah) dan yang
  sudah kamu kenal dari struktur `$_SESSION['buku']` di jobsheet-07.
  Hasil akhirnya, `$daftarBuku` sekarang berbentuk **persis sama**
  strukturnya dengan `$_SESSION['buku']` sebelumnya — array berisi
  banyak array asosiatif, satu per buku.

## 6.4 Menampilkan Hasilnya di Tabel: Tidak Berubah

```php
<?php foreach ($daftarBuku as $buku): ?>
<tr>
    <td><?php echo $buku['judul']; ?></td>
    ...
```

Ini bagian yang **paling menenangkan** untuk disadari: kode `foreach`
untuk menampilkan tabel ([dokumentasi jobsheet-07 §5.4](../../jobsheet-07/Dokumentasi/05-list-php-render-dan-flash.md#54-menampilkan-tabel-dari-array-session))
**sama sekali tidak perlu diubah**. Karena `fetchAll(PDO::FETCH_ASSOC)`
menghasilkan struktur array yang identik dengan `$_SESSION['buku']`
sebelumnya, kode yang **menampilkan** data tidak peduli dari mana
sebenarnya `$daftarBuku` berasal (session atau database) — inilah
manfaat nyata menjaga struktur data tetap **konsisten** di seluruh
lapisan aplikasi, seperti yang sudah disinggung di
[bab 2 §2.5](02-skema-database-sql.md#25-bagaimana-kolom-kolom-ini-berhubungan-dengan-kode-php).

## 6.5 `index.php`: Menghitung Total dengan `COUNT(*)`

```php
require __DIR__ . '/includes/koneksi.php';

$totalBuku = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
$totalAnggota = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
```

- **`SELECT COUNT(*) FROM buku`** — alih-alih mengambil **seluruh**
  data buku hanya untuk menghitung jumlahnya (yang akan boros, apalagi
  kalau datanya sangat banyak), `COUNT(*)` adalah instruksi SQL yang
  meminta database **sendiri** yang menghitung jumlah barisnya, dan
  hanya mengembalikan **satu angka** hasilnya.
- **`->fetchColumn()`** — method PDO untuk mengambil **satu nilai
  tunggal** dari hasil query (cocok dipakai di sini karena hasil
  `COUNT(*)` memang cuma satu angka, beda dengan `fetchAll()` yang
  mengambil banyak baris sekaligus seperti di [§6.3](#63-mengubah-hasil-query-jadi-array-php-fetchallpdofetch_assoc)).

Bandingkan dengan jobsheet-07:
```php
$totalBuku = count($_SESSION['buku'] ?? []);
```
Fungsi PHP `count()` (menghitung jumlah item array PHP di memori)
diganti `SELECT COUNT(*)` (menghitung jumlah baris di database) — dua
cara berbeda untuk **tujuan konsep yang sama**: mengetahui berapa
banyak data yang ada, hanya sekarang datanya benar-benar berasal dari
database, bukan array sementara di `$_SESSION`.

Lanjut ke: [Rangkuman & Latihan Lanjutan](07-rangkuman-latihan.md)
