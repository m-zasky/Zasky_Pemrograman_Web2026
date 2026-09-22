# 4. Koneksi PHP ke Database: `koneksi.php`

File PHP baru yang menjadi **jembatan** antara kode PHP dan database
PostgreSQL yang sudah disiapkan di [bab 3](03-persiapan-database.md).

## 4.1 Kode Lengkap

```php
<?php
$host = "localhost";
$port = "5432";
$db   = "simpus_mini";
$user = "postgres";
$pass = "postgres";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
```

## 4.2 Lima Variabel Konfigurasi

```php
$host = "localhost";
$port = "5432";
$db   = "simpus_mini";
$user = "postgres";
$pass = "postgres";
```

| Variabel | Artinya |
|---|---|
| `$host` | Alamat **komputer** tempat PostgreSQL berjalan. `"localhost"` berarti "komputer yang sama dengan tempat kode PHP ini dijalankan" — untuk pengembangan lokal, PostgreSQL biasanya berjalan di komputer yang sama. |
| `$port` | "Pintu" jaringan tempat PostgreSQL "mendengarkan" permintaan koneksi. `5432` adalah port **standar/default** PostgreSQL. |
| `$db` | Nama database yang ingin dihubungi — harus sama persis dengan nama yang dibuat lewat `createdb` ([bab 3 §3.2](03-persiapan-database.md#32-langkah-2-membuat-database)). |
| `$user`, `$pass` | Kredensial login ke PostgreSQL (ingat dari [bab 3 §3.4](03-persiapan-database.md#34-langkah-4-menyesuaikan-kredensial)). |

## 4.3 Membuat Koneksi: `new PDO(...)`

```php
$pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
```

- **`new PDO(...)`** — membuat sebuah **objek** PDO baru, yang mewakili
  satu koneksi aktif ke database. Objek `$pdo` inilah yang nanti dipakai
  untuk menjalankan query `SELECT`/`INSERT` di
  [bab 5](05-insert-prepared-statement.md) dan [bab 6](06-membaca-data-select.md).
- **`"pgsql:host=$host;port=$port;dbname=$db"`** — disebut **DSN**
  (*Data Source Name*), sebuah string yang merangkum **semua** informasi
  tempat dan jenis database yang ingin dihubungi dalam satu baris teks.
  `pgsql:` di depan memberi tahu PDO untuk memakai **driver** PostgreSQL
  secara spesifik (ingat dari
  [bab 1 §1.4](01-konsep-dasar-database-sql.md#14-apa-itu-pdo), PDO bisa
  dipakai untuk berbagai jenis database — `pgsql:` inilah yang
  menentukan jenisnya di sini). Perhatikan variabel PHP (`$host`,
  `$port`, `$db`) ditulis **langsung di dalam string** yang diapit
  tanda kutip dua — ini disebut **string interpolation**, PHP otomatis
  mengganti `$host` dengan nilai sungguhannya (`"localhost"`) saat
  string ini diproses.
- **`$user`, `$pass`** — dikirim sebagai **parameter terpisah** (bukan
  digabung ke dalam string DSN), karena keduanya adalah informasi
  sensitif yang secara konvensi dipisahkan dari string koneksi.

## 4.4 Menangani Kegagalan Koneksi

```php
try {
    $pdo = new PDO(...);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
```

- Ingat pola **`try`/`catch`** dari
  [dokumentasi jobsheet-06 §1.6](../../jobsheet-06/Dokumentasi/01-konsep-dasar-fetch-json.md#16-menangani-kegagalan-trycatchfinally) —
  konsepnya sama persis di PHP: kode yang **berpotensi gagal** (di
  sini, mencoba membuat koneksi database) dibungkus `try`, dan kalau
  gagal, `catch` menangkap error-nya supaya program tidak berhenti
  total tanpa penjelasan.
- **`catch (PDOException $e)`** — `PDOException` adalah **jenis error**
  spesifik yang dilempar PDO ketika koneksi gagal (misalnya karena
  PostgreSQL belum berjalan, kredensial salah, atau nama database
  tidak ditemukan — persis kasus-kasus yang dibahas di
  [bab 3 §3.5](03-persiapan-database.md#35-urutan-ini-penting--jangan-dibalik)).
- **`die("...")`** — perintah PHP yang **langsung menghentikan** seluruh
  eksekusi skrip **seketika itu juga**, sambil menampilkan pesan yang
  diberikan. Ini pilihan yang masuk akal khusus untuk kegagalan koneksi
  database: kalau database tidak bisa dihubungi sama sekali, **hampir
  semua** halaman di aplikasi ini (yang butuh membaca/menulis data)
  tidak akan bisa berfungsi sama sekali — lebih baik langsung berhenti
  dengan pesan yang jelas, daripada melanjutkan dan menghasilkan
  error-error membingungkan di banyak tempat berbeda.
- **`$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);`** —
  mengatur PDO supaya, **setelah koneksi berhasil**, setiap kegagalan
  query berikutnya (misalnya `INSERT` yang gagal karena melanggar
  `UNIQUE` di [bab 2 §2.4](02-skema-database-sql.md#24-mendefinisikan-kolom-nama-tipe-dan-batasan))
  juga akan dilemparkan sebagai `PDOException`, bukan sekadar
  diabaikan diam-diam — praktik yang baik supaya masalah database tidak
  pernah "tersembunyi" tanpa disadari.

## 4.5 Bagaimana `koneksi.php` Dipakai di Halaman Lain?

```php
require __DIR__ . '/includes/koneksi.php';
```

Perhatikan halaman-halaman yang butuh akses database (`index.php`,
`buku/list.php`, `buku/proses_tambah.php`, dst.) memanggil file ini
lewat **`require`**, bukan **`include`** yang sudah kamu kenal dari
[dokumentasi jobsheet-07 §2.2](../../jobsheet-07/Dokumentasi/02-includes-header-footer.md#22-memanggil-include).
Bedanya: kalau file yang di-`include` ternyata **tidak ditemukan**, PHP
hanya menampilkan **peringatan** dan tetap **melanjutkan** menjalankan
sisa kode (berpotensi menyebabkan error lain yang membingungkan di
kemudian hari, karena variabel `$pdo` yang seharusnya ada jadi tidak
ada). `require` yang gagal menemukan filenya akan langsung
menghentikan skrip dengan **fatal error** seketika itu juga. Karena
`$pdo` adalah sesuatu yang **wajib ada** supaya semua query database
berikutnya bisa jalan (tanpa `$pdo`, seluruh halaman ini tidak berguna
sama sekali), `require` adalah pilihan yang lebih tepat dibanding
`include` — mencerminakan bahwa file ini **wajib** berhasil dimuat,
tidak seperti `header.php`/`footer.php` yang meski penting, secara
teknis halaman masih "bisa jalan" (meski tidak lengkap) tanpanya.

Lanjut ke: [Menyimpan Data: Prepared Statement & `INSERT`](05-insert-prepared-statement.md)
