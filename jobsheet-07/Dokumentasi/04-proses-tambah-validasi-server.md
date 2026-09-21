# 4. Memproses Form: `proses_tambah.php`

Ini file paling penting untuk dipahami di jobsheet ini — tempat data
form benar-benar **diproses** untuk pertama kalinya sejak jobsheet-01.

## 4.1 Form yang Kini Benar-Benar "Hidup"

Ingat dari [dokumentasi jobsheet-01 §4.2](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#42-elemen-form),
tag `<form>` sejak jobsheet-01 **tidak** punya `action`/`method`,
sehingga menekan "Simpan" tidak melakukan apa-apa. Sekarang:

```php
<form id="form-tambah" method="post" action="proses_tambah.php">
```

- **`method="post"`** — menentukan **cara** data dikirim. Data yang
  dikirim lewat `POST` **tidak terlihat** di address bar browser (beda
  dengan `method="get"` yang menempelkan data ke URL, cara yang lazim
  dipakai untuk pencarian). `POST` lebih cocok untuk form yang
  menambah/mengubah data, seperti menambah buku baru.
- **`action="proses_tambah.php"`** — menentukan **ke mana** data
  dikirim ketika form di-submit. Perhatikan ini path **relatif polos**
  (tanpa prefix `$base` seperti menu navigasi di
  [bab 2 §2.3](02-includes-header-footer.md#23-path-relatif-otomatis-di-includesheaderphp)) —
  karena `proses_tambah.php` **selalu** berada tepat di folder yang
  sama dengan `tambah.php` yang memanggilnya (`buku/tambah.php` →
  `buku/proses_tambah.php`, `anggota/tambah.php` →
  `anggota/proses_tambah.php`), jadi path relatif sederhana sudah cukup
  di sini, tidak perlu `__DIR__` atau perhitungan `$base`.

## 4.2 Menerima Data Form: `$_POST`

```php
<?php
session_start();

$judul = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun = $_POST['tahun'] ?? '';
$isbn = trim($_POST['isbn'] ?? '');
$stok = $_POST['stok'] ?? '';
$kategori = trim($_POST['kategori'] ?? '');
```

- **`$_POST['judul']`** — mengambil nilai field bernama `judul` yang
  dikirim lewat form (ingat atribut `name="judul"` pada `<input>` sejak
  [dokumentasi jobsheet-01 §4.3](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#43-pola-setiap-isian-form-label--input) —
  `$_POST` mengambil datanya persis berdasarkan nama atribut `name` itu).
- **`?? ''`** — operator null coalescing yang sudah dibahas di
  [bab 1 §1.6](01-konsep-dasar-php.md#16-operator--null-coalescing):
  kalau field itu entah bagaimana tidak terkirim sama sekali,
  gunakan string kosong sebagai gantinya, mencegah error.
- **`trim(...)`** — menghapus spasi kosong di awal/akhir teks (persis
  konsep yang sama dengan `.trim()` di JavaScript yang sudah kamu pakai
  di [dokumentasi jobsheet-05 §7.6](../../jobsheet-05/Dokumentasi/07-js-validasi-form.md#76-pola-pengecekan-per-field)).
  Perhatikan `$tahun` dan `$stok` **tidak** di-`trim()` — karena
  keduanya akan diperiksa sebagai **angka** ([§4.3](#43-validasi-server-side)),
  bukan teks, jadi spasi di sekitarnya tidak relevan untuk diperiksa
  dengan cara yang sama seperti field teks.

## 4.3 Validasi Server-Side

```php
$errors = [];
if ($judul === '') {
    $errors[] = "Judul wajib diisi.";
}
if ($pengarang === '') {
    $errors[] = "Pengarang wajib diisi.";
}
if (!is_numeric($tahun) || $tahun < 1900 || $tahun > 2026) {
    $errors[] = "Tahun harus di antara 1900-2026.";
}
if (!is_numeric($stok) || $stok < 0) {
    $errors[] = "Stok tidak boleh negatif.";
}
```

- **`$errors = [];`** — membuat sebuah **array kosong**, tempat
  menampung daftar pesan kesalahan yang ditemukan (sintaks `[]` di PHP
  modern setara dengan `array()`).
- **`$errors[] = "...";`** — menambahkan satu item baru ke **akhir**
  array `$errors` (tanda kurung siku kosong `[]` di sisi kiri berarti
  "tambahkan item baru", bukan mengakses index tertentu).
- **`is_numeric($tahun)`** — memeriksa apakah nilai `$tahun` **berupa
  angka** (atau teks yang bisa dianggap angka, seperti `"2005"`).
  Fungsi ini setara konsepnya dengan pengecekan `isNaN()` yang sudah
  kamu pakai di JavaScript
  ([dokumentasi jobsheet-05 §7.6](../../jobsheet-05/Dokumentasi/07-js-validasi-form.md#76-pola-pengecekan-per-field)),
  hanya dengan logika terbalik (`is_numeric` mengembalikan `true` kalau
  memang angka, `isNaN` mengembalikan `true` kalau **bukan** angka).
- Pola pemeriksaan rentang tahun (`1900-2026`) dan stok non-negatif
  **persis meniru** aturan yang sama yang sudah ada sejak
  [dokumentasi jobsheet-01 §4.4](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#44-jenis-jenis-input-yang-dipakai)
  (atribut HTML `min`/`max`) dan divalidasi ulang di JavaScript sejak
  [dokumentasi jobsheet-05 §7.6](../../jobsheet-05/Dokumentasi/07-js-validasi-form.md#76-pola-pengecekan-per-field) —
  sekarang ditulis untuk **ketiga kalinya**, kali ini di server. Alasan
  kenapa ini **tidak sia-sia** dijelaskan di [§4.6](#46-kenapa-validasi-ini-yang-benar-benar-bisa-diandalkan).

## 4.4 Kalau Ada Error: Simpan Flash & Redirect Kembali

```php
if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}
```

- **`!empty($errors)`** — memeriksa apakah array `$errors` **berisi**
  sesuatu (ada minimal satu pesan kesalahan yang ditambahkan tadi).
- **`$_SESSION['flash'] = ['type' => 'error', 'pesan' => ...];`** —
  menyimpan **array asosiatif** (array dengan kunci bernama, mirip
  objek di JavaScript) ke `$_SESSION['flash']` — ingat konsep ini dari
  [bab 3 §3.3](03-session-dan-alur-data.md#33-_session-sebagai-keranjang-data-sementara).
  Kunci `'type'` (`'error'` atau `'success'`) menentukan **jenis**
  pesan (dipakai untuk styling, lihat [bab 6](06-css-flash-message.md)),
  kunci `'pesan'` berisi **teks** pesannya.
- **`implode(' ', $errors)`** — menggabungkan **semua** item di array
  `$errors` menjadi **satu string**, dipisah spasi (`' '`). Kalau ada 2
  error ("Judul wajib diisi." dan "Tahun harus di antara 1900-2026."),
  hasilnya jadi satu kalimat gabungan: `"Judul wajib diisi. Tahun harus
  di antara 1900-2026."`.
- **`header('Location: tambah.php');`** — perintah PHP untuk mengirim
  **HTTP redirect** ke browser: instruksi "tolong buka halaman
  `tambah.php` sebagai gantinya." Browser akan otomatis pindah ke
  halaman itu tanpa campur tangan pengguna.
- **`exit;`** — menghentikan eksekusi skrip PHP **seketika itu juga**.
  Ini **wajib** ditulis setelah `header('Location: ...')` — tanpa
  `exit`, PHP akan **tetap melanjutkan** menjalankan baris-baris kode
  berikutnya (termasuk kode menyimpan data di
  [§4.5](#45-kalau-valid-simpan-ke-session--redirect-ke-daftar)) meskipun
  perintah redirect sudah "dikirim", karena `header()` hanya mengatur
  instruksi HTTP, bukan benar-benar menghentikan program seperti
  `return` pada fungsi.

## 4.5 Kalau Valid: Simpan ke Session & Redirect ke Daftar

```php
if (!isset($_SESSION['buku'])) {
    $_SESSION['buku'] = [];
}

$_SESSION['buku'][] = [
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => (int) $tahun,
    'isbn' => $isbn,
    'stok' => (int) $stok,
    'kategori' => $kategori,
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil ditambahkan.'];
header('Location: list.php');
exit;
```

- **`if (!isset($_SESSION['buku'])) { $_SESSION['buku'] = []; }`** —
  memeriksa apakah `$_SESSION['buku']` **sudah pernah dibuat**
  sebelumnya (`isset` = "apakah sudah diset"). Kalau ini adalah buku
  **pertama** yang ditambahkan sepanjang sesi ini, `$_SESSION['buku']`
  belum ada sama sekali — baris ini membuatnya sebagai array kosong
  terlebih dulu, supaya baris berikutnya (`$_SESSION['buku'][] = ...`)
  bisa langsung menambahkan item ke dalamnya tanpa error.
- **`$_SESSION['buku'][] = [...]`** — menambahkan **satu array
  asosiatif baru** (representasi satu buku, dengan kunci-kunci yang
  **sama persis** dengan struktur `data/buku.json` di jobsheet-06,
  ingat dari
  [dokumentasi jobsheet-06 §3.1](../../jobsheet-06/Dokumentasi/03-data-json.md#31-databukujson--10-objek-buku)) —
  ke **akhir** array `$_SESSION['buku']`, tanpa menghapus buku-buku
  yang sudah ditambahkan sebelumnya.
- **`(int) $tahun`** dan **`(int) $stok`** — ini **type casting**,
  memaksa nilai untuk diperlakukan sebagai **tipe integer** (angka
  bulat), bukan lagi teks. Ingat dari
  [dokumentasi jobsheet-06 §3.4](../../jobsheet-06/Dokumentasi/03-data-json.md#34-tipe-data-di-dalam-json)
  pentingnya membedakan angka dari teks — data yang dikirim lewat
  `$_POST` **selalu** berupa teks apa adanya (meskipun terlihat seperti
  angka), jadi `(int)` memastikan nilai `tahun`/`stok` yang tersimpan
  di `$_SESSION` benar-benar bertipe angka, bukan teks `"2005"`.
- Redirect ke `list.php` (bukan `tambah.php` seperti kasus error) —
  membawa pengguna langsung melihat **hasil** dari data yang baru saja
  ditambahkan.

## 4.6 Kenapa Validasi Ini yang Benar-Benar Bisa Diandalkan?

Ingat catatan penting dari [dokumentasi jobsheet-05 §7.8](../../jobsheet-05/Dokumentasi/07-js-validasi-form.md#78-kenapa-validasi-html-required-min-max-masih-perlu-diduplikasi-di-js):
validasi HTML (`required`, `min`/`max`) **dan** validasi JavaScript
sama-sama berjalan di **browser pengguna**, dan keduanya **bisa
dilewati** (menonaktifkan JavaScript, atau mengirim data langsung tanpa
lewat form sama sekali). Validasi di `proses_tambah.php` ini **berbeda
secara mendasar**: karena berjalan di **server** ([bab 1 §1.1](01-konsep-dasar-php.md#11-server-side-vs-client-side-bedanya-apa)),
kode ini **selalu** dijalankan untuk **setiap** data yang masuk, apa pun
cara pengiriman datanya — pengguna tidak punya cara untuk "mematikan"
kode PHP di server, tidak seperti mematikan JavaScript di browser
sendiri.

Coba buktikan sendiri sesuai catatan di [README.md](../README.md)
jobsheet ini: **nonaktifkan JavaScript** di pengaturan browser, lalu
buka `buku/tambah.php` dan submit form kosong. Validasi JavaScript
([dokumentasi jobsheet-05 §7](../../jobsheet-05/Dokumentasi/07-js-validasi-form.md))
tidak akan berjalan sama sekali (karena JS dimatikan), tapi form tetap
akan gagal tersimpan dan kamu diarahkan kembali ke `tambah.php` dengan
pesan error — bukti nyata bahwa validasi server bekerja **independen**
dari validasi client.

Lanjut ke: [Menampilkan Data: `list.php` & Flash Message](05-list-php-render-dan-flash.md)
