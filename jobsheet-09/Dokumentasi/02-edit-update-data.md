# 2. Mengubah Data: `edit.php` & `proses_edit.php`

Dua file baru yang bekerja sama untuk fitur **Update** — mirip pola
`tambah.php` + `proses_tambah.php` yang sudah kamu kenal, tapi dengan
satu langkah tambahan penting: **mengambil data lama terlebih dulu**.

## 2.1 `buku/edit.php` — Kode Lengkap

```php
<?php
$page_title = "Edit Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    header('Location: list.php');
    exit;
}
?>
        <section>
            <h2>Edit Buku</h2>
            ...
            <form id="form-tambah" method="post" action="proses_edit.php">
                <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
                <p>
                    <label for="judul">Judul</label><br>
                    <input type="text" id="judul" name="judul" value="<?php echo $buku['judul']; ?>" required>
                </p>
                ...
            </form>
        </section>
```

## 2.2 Mengambil `id` dari URL: `$_GET['id']`

```php
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}
```

- **`$_GET`** adalah superglobal baru (ingat dari
  [dokumentasi jobsheet-07 §1.5](../../jobsheet-07/Dokumentasi/01-konsep-dasar-php.md#15-superglobal-variabel-bawaan-yang-selalu-tersedia)) —
  bedanya dengan `$_POST`, `$_GET` mengambil data yang **ditempelkan ke
  URL** itu sendiri, dalam bentuk `?nama=nilai`. Ingat dari
  [dokumentasi jobsheet-01 §4.2](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#42-elemen-form):
  ini seperti "kebalikan" dari `method="post"` — datanya **terlihat**
  di address bar.
- Halaman ini dibuka lewat tautan seperti
  `edit.php?id=3` — angka `3` di situ adalah `id` buku yang mau diubah,
  dan `$_GET['id']` mengambilnya. Ingat dari mana tautan ini berasal:
  `<a href="edit.php?id=<?php echo $buku['id']; ?>" class="btn-edit">Edit</a>`
  di `list.php`, dibahas di [bab 5](05-pagination-dan-pencarian-server.md).
- Kalau `$id` kosong (halaman ini dibuka tanpa parameter `id` sama
  sekali, misalnya diketik manual tanpa `?id=...`), pengguna
  **diarahkan kembali** ke `list.php` — mencegah kode di bawahnya
  mencoba mencari buku dengan `id` yang tidak jelas.

## 2.3 Mengambil Data Lama: `SELECT ... WHERE id = :id`

```php
$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    header('Location: list.php');
    exit;
}
```

- **`WHERE id = :id`** — klausa SQL baru yang belum pernah dipakai di
  jobsheet-08: `WHERE` **menyaring** baris mana saja yang diambil
  (tanpa `WHERE`, `SELECT` mengambil **semua** baris, ingat dari
  [dokumentasi jobsheet-08 §6.1](../../jobsheet-08/Dokumentasi/06-membaca-data-select.md#61-bukulistphp-mengambil-semua-baris)) —
  di sini hanya baris yang `id`-nya cocok dengan `:id`. Ini **prepared
  statement**, sama konsepnya dengan `INSERT` di
  [dokumentasi jobsheet-08 §5](../../jobsheet-08/Dokumentasi/05-insert-prepared-statement.md) —
  placeholder `:id` diisi nilai sungguhan lewat `execute(['id' => $id])`.
- **`->fetch(PDO::FETCH_ASSOC)`** — method baru, **tunggal**, beda dari
  `fetchAll()` yang sudah kamu kenal
  ([dokumentasi jobsheet-08 §6.3](../../jobsheet-08/Dokumentasi/06-membaca-data-select.md#63-mengubah-hasil-query-jadi-array-php-fetchallpdofetch_assoc)):
  `fetch()` mengambil **satu baris saja** (masuk akal di sini — karena
  `id` adalah `PRIMARY KEY`, ingat dari
  [dokumentasi jobsheet-08 §2.4](../../jobsheet-08/Dokumentasi/02-skema-database-sql.md#24-mendefinisikan-kolom-nama-tipe-dan-batasan),
  query `WHERE id = :id` **paling banyak** hanya akan cocok dengan satu
  baris).
- Kalau `$buku` ternyata `false`/kosong (misalnya `id` yang diminta
  tidak ada di database — sudah dihapus, atau memang tidak pernah
  ada), pengguna diarahkan kembali ke `list.php` — mencegah halaman
  menampilkan form dengan data yang tidak ada.

## 2.4 Mengisi Form dengan Data Lama: Atribut `value`

```php
<input type="text" id="judul" name="judul" value="<?php echo $buku['judul']; ?>" required>
```

Ini **perbedaan visual** paling mencolok dibanding form Tambah Buku
(`tambah.php`, ingat dari
[dokumentasi jobsheet-01 §4.1](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#41-kode-form-lengkap)):
atribut **`value="..."`** diisi dengan data yang **sudah ada**
(`$buku['judul']`), sehingga saat halaman dibuka, kotak input **sudah
terisi** teks yang mau diubah — pengguna tidak perlu mengetik ulang
semuanya dari nol, cukup mengubah bagian yang perlu diperbaiki.

**Kasus khusus untuk `<select>`:**
```php
<select id="kategori" name="kategori">
    <?php foreach (['fiksi' => 'Fiksi', 'non-fiksi' => 'Non-Fiksi', 'referensi' => 'Referensi'] as $value => $label): ?>
    <option value="<?php echo $value; ?>" <?php echo $buku['kategori'] === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
    <?php endforeach; ?>
</select>
```

- **`foreach ([...] as $value => $label)`** — mengulang array
  asosiatif yang berisi 3 pasangan (nilai teknis → label tampilan),
  menghasilkan 3 elemen `<option>` — cara yang lebih ringkas dibanding
  menulis 3 baris `<option>` manual seperti di
  [dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#41-kode-form-lengkap).
- **`$buku['kategori'] === $value ? 'selected' : ''`** — untuk **setiap**
  opsi, memeriksa apakah nilainya **cocok** dengan kategori buku yang
  sedang diedit. Kalau cocok, atribut HTML **`selected`** ditambahkan —
  inilah cara memberi tahu `<select>` opsi mana yang harus **tampil
  terpilih** sejak awal, konsep yang setara dengan `value="..."` pada
  `<input>` biasa, hanya sedikit berbeda mekanismenya karena `<select>`
  bekerja dengan daftar opsi, bukan satu kotak teks tunggal.

## 2.5 Kotak Tersembunyi: `<input type="hidden" name="id">`

```php
<input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
```

**`type="hidden"`** adalah jenis input baru — sebuah field yang **tidak
tampil sama sekali** di layar, tapi **tetap ikut terkirim** bersama
form saat di-submit (persis seperti field biasa lainnya). Ini dipakai
untuk membawa informasi yang **dibutuhkan server** (`id` buku yang
sedang diedit) tapi **tidak perlu dilihat atau diubah** pengguna — beda
dari `judul`/`pengarang`/dst. yang memang perlu diketik ulang pengguna.
Tanpa field tersembunyi ini, `proses_edit.php` ([§2.6](#26-proses_editphp-menjalankan-update))
tidak akan tahu **baris mana** yang harus di-`UPDATE`.

## 2.6 `proses_edit.php`: Menjalankan `UPDATE`

```php
$id = $_POST['id'] ?? null;
// ...ambil field lain dari $_POST, validasi (identik dengan proses_tambah.php)...

if (!$id) {
    header('Location: list.php');
    exit;
}

// ...kalau ada error validasi, redirect ke edit.php?id=... (bukan tambah.php)...

$stmt = $pdo->prepare(
    "UPDATE buku SET judul = :judul, pengarang = :pengarang, tahun = :tahun,
     isbn = :isbn, stok = :stok, kategori = :kategori WHERE id = :id"
);
$stmt->execute([
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => (int) $tahun,
    'isbn' => $isbn,
    'stok' => (int) $stok,
    'kategori' => $kategori,
    'id' => $id,
]);
```

- **`$id = $_POST['id'] ?? null;`** — sekarang mengambil `id` dari
  **`$_POST`**, bukan `$_GET` seperti di `edit.php`
  ([§2.2](#22-mengambil-id-dari-url-_getid)) — karena field tersembunyi
  di [§2.5](#25-kotak-tersembunyi-input-typehidden-nameid) dikirim
  lewat `method="post"` (ingat dari
  [dokumentasi jobsheet-07 §4.1](../../jobsheet-07/Dokumentasi/04-proses-tambah-validasi-server.md#41-form-yang-kini-benar-benar-hidup)),
  bukan lagi lewat URL.
- **Validasi tetap sama persis** dengan `proses_tambah.php`
  ([dokumentasi jobsheet-07 §4.3](../../jobsheet-07/Dokumentasi/04-proses-tambah-validasi-server.md#43-validasi-server-side)) —
  aturan yang sama berlaku baik saat menambah data baru **maupun**
  mengubah data lama. Satu-satunya beda: kalau validasi gagal, redirect
  mengarah ke **`edit.php?id=' . urlencode($id)`**, bukan `tambah.php`
  — mengembalikan pengguna ke form edit yang sama (bukan form kosong).
- **`UPDATE buku SET kolom1 = :kolom1, ... WHERE id = :id`** — perintah
  SQL baru: `SET` menentukan kolom mana yang **nilainya diubah**, dan
  **`WHERE id = :id`** memastikan perubahan **hanya** memengaruhi satu
  baris spesifik. **Ini bagian paling krusial untuk dipahami**: kalau
  klausa `WHERE` ini **terlupa/hilang**, perintah `UPDATE` akan
  **mengubah SEMUA baris** di tabel `buku` sekaligus dengan nilai yang
  sama — kesalahan serius yang bisa merusak seluruh data tabel dalam
  sekali jalan. Selalu periksa klausa `WHERE` ada dan benar setiap kali
  menulis `UPDATE`/`DELETE`.
- **`urlencode($id)`** — fungsi PHP yang mengubah karakter tertentu
  supaya **aman** dimasukkan ke dalam URL (misalnya spasi diubah jadi
  `%20`). Meski `id` di sini biasanya berupa angka biasa (tidak
  mengandung karakter spesial), ini kebiasaan baik yang aman diterapkan
  kapan pun sebuah nilai disisipkan ke URL.

Lanjut ke: [Menghapus Data: `hapus.php`](03-hapus-delete-data.md)
