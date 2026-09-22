# 5. Menyimpan Data: Prepared Statement & `INSERT`

Ini pengganti langsung dari `$_SESSION['buku'][] = [...]` yang sudah
kamu pelajari di
[dokumentasi jobsheet-07 §4.5](../../jobsheet-07/Dokumentasi/04-proses-tambah-validasi-server.md#45-kalau-valid-simpan-ke-session--redirect-ke-daftar) —
sekarang data benar-benar dikirim ke database, bukan sekadar disimpan
di memori sementara.

## 5.1 Kode yang Berubah di `buku/proses_tambah.php`

**Sebelumnya (jobsheet-07):**
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
```

**Sekarang (jobsheet-08):**
```php
require __DIR__ . '/../includes/koneksi.php';

// ...validasi (tidak berubah dari jobsheet-07)...

$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori)
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)
     RETURNING id"
);
$stmt->execute([
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => (int) $tahun,
    'isbn' => $isbn,
    'stok' => (int) $stok,
    'kategori' => $kategori,
]);
```

Perhatikan seluruh **validasi** ($judul === '', is_numeric($tahun), dst.
— ingat dari
[dokumentasi jobsheet-07 §4.3](../../jobsheet-07/Dokumentasi/04-proses-tambah-validasi-server.md#43-validasi-server-side))
**sama sekali tidak berubah** — validasi tetap penting dan berjalan
persis seperti sebelumnya, **sebelum** kode di bawah ini sempat
dijalankan. Yang berubah **hanya** bagian penyimpanan datanya.

## 5.2 Menyiapkan Query: `$pdo->prepare(...)`

```php
$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori)
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)
     RETURNING id"
);
```

Mari bedah pernyataan SQL `INSERT` ini bagian per bagian:

- **`INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori)`** —
  "tambahkan baris baru ke tabel `buku`, mengisi kolom-kolom ini..."
  (ingat struktur tabel `buku` dari
  [bab 2](02-skema-database-sql.md#21-kode-lengkap)).
- **`VALUES (:judul, :pengarang, ...)`** — "...dengan nilai-nilai
  berikut." Perhatikan yang ditulis di sini **bukan** nilai
  sungguhannya (seperti `'Laskar Pelangi'`), melainkan **placeholder**
  bernama, ditandai titik dua di depan (`:judul`, `:pengarang`, dst).
- **`RETURNING id`** — instruksi khusus PostgreSQL: setelah baris baru
  berhasil ditambahkan, **kembalikan** nilai kolom `id` yang baru saja
  dibuat otomatis (ingat `SERIAL` dari
  [bab 2 §2.4](02-skema-database-sql.md#24-mendefinisikan-kolom-nama-tipe-dan-batasan)).
  Nilai `id` ini **belum dipakai** di jobsheet ini (ingat catatan di
  [README.md](../README.md) jobsheet ini), tapi disiapkan sebagai
  fondasi untuk fitur Edit/Hapus yang sungguhan mulai Jobsheet 9 — untuk
  meng-edit/menghapus satu buku spesifik, aplikasi perlu tahu `id`-nya.
- **`$pdo->prepare(...)`** — method PDO yang **menyiapkan** (tapi belum
  **menjalankan**) query ini. Hasilnya disimpan ke `$stmt` (singkatan
  dari *statement*), sebuah objek yang mewakili "query yang siap
  dieksekusi."

## 5.3 Apa itu Prepared Statement, dan Kenapa Penting?

**Prepared statement** adalah teknik menjalankan query SQL dalam **dua
tahap terpisah**: (1) menyiapkan **struktur** query dengan placeholder
seperti `:judul` ([§5.2](#52-menyiapkan-query-pdo-prepare)), lalu (2)
mengisi placeholder itu dengan **nilai sungguhan** saat dieksekusi
([§5.4](#54-menjalankan-query-stmt-execute)) — **terpisah** dari teks
query itu sendiri.

Ini **jauh lebih aman** dibanding cara "naif" menggabung nilai langsung
ke teks query, misalnya:

```php
// JANGAN LAKUKAN INI — hanya contoh kode yang TIDAK aman
$pdo->query("INSERT INTO buku (judul) VALUES ('" . $judul . "')");
```

Kalau `$judul` berisi teks yang **sengaja dibuat berbahaya** oleh
pengguna jahat (misalnya berisi karakter tanda kutip dan potongan
perintah SQL tambahan), cara penggabungan string ini bisa **mengubah
makna** query SQL itu sendiri — kerentanan yang disebut **SQL
injection**. Dengan prepared statement, nilai yang dikirim lewat
`execute()` **tidak pernah** diperlakukan sebagai bagian dari perintah
SQL — ia selalu diperlakukan murni sebagai **data**, apa pun isinya,
sehingga tidak mungkin mengubah struktur query aslinya. Ingat catatan
di [README.md](../README.md) jobsheet ini: ini baru **fondasi**
keamanan, akan diperdalam lebih jauh di Jobsheet 11.

## 5.4 Menjalankan Query: `$stmt->execute(...)`

```php
$stmt->execute([
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => (int) $tahun,
    'isbn' => $isbn,
    'stok' => (int) $stok,
    'kategori' => $kategori,
]);
```

**`$stmt->execute([...])`** benar-benar **menjalankan** query yang
sudah disiapkan tadi, mengisi setiap placeholder dengan nilai dari
array asosiatif yang diberikan — perhatikan **kunci** array ini
(`'judul'`, `'pengarang'`, dst., **tanpa** titik dua) harus **cocok**
dengan nama placeholder di query (`:judul`, `:pengarang`, **dengan**
titik dua). PDO otomatis mencocokkan keduanya berdasarkan namanya.
Setelah baris ini dijalankan, satu baris baru **benar-benar tersimpan**
di tabel `buku` — bandingkan dengan versi jobsheet-07 yang "hanya"
menyimpan ke array `$_SESSION['buku']` di memori sementara.

## 5.5 Bagian yang Tidak Berubah Sama Sekali

Sisa kode setelah `execute()` — flash message dan redirect — **identik
persis** dengan jobsheet-07:

```php
$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil ditambahkan.'];
header('Location: list.php');
exit;
```

Ini menunjukkan sesuatu yang penting: `$_SESSION['flash']` (pesan
sekali-tampil, ingat dari
[dokumentasi jobsheet-07 §5.2](../../jobsheet-07/Dokumentasi/05-list-php-render-dan-flash.md#52-mengambil-dan-menghapus-flash-message))
**tetap dipakai** di jobsheet ini — hanya `$_SESSION['buku']`/
`$_SESSION['anggota']` (data buku/anggota itu sendiri) yang berpindah
ke database. `$_SESSION` masih berguna untuk data **sementara** seperti
pesan notifikasi, yang memang **seharusnya** hanya bertahan sebentar,
berbeda dari data buku/anggota yang seharusnya permanen.

Lanjut ke: [Membaca Data: `SELECT`](06-membaca-data-select.md)
