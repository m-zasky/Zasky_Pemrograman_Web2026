# 3. Menghapus Data: `hapus.php`

File paling singkat di jobsheet ini, tapi menyimpan detail keamanan
paling penting untuk dipahami.

## 3.1 Kode Lengkap

```php
<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

// Sengaja hanya menerima POST (bukan GET) agar penghapusan tidak bisa
// dipicu tanpa sengaja lewat link/preview crawler.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM buku WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil dihapus.'];
}

header('Location: list.php');
exit;
```

## 3.2 Kenapa Delete Tidak Boleh Sesederhana Sebuah Tautan?

Bayangkan seandainya menghapus buku dibuat **semudah** tautan biasa:
```html
<a href="hapus.php?id=3">Hapus</a>
```

Ini terlihat sederhana, tapi punya bahaya tersembunyi: **tautan
`<a href>` selalu memakai `GET`** — dan permintaan `GET` bisa terpicu
**tanpa sengaja** oleh banyak hal di luar kendali pengguna:

- **Crawler mesin pencari** (seperti Googlebot) yang menjelajahi setiap
  tautan di halaman untuk mengindeksnya — kalau tautan Hapus ada di
  halaman publik, crawler bisa "mengklik"-nya begitu saja saat
  menjelajah.
- **Fitur pratinjau tautan** di beberapa aplikasi chat/email yang
  "mengunjungi" URL secara otomatis untuk menampilkan pratinjau,
  tanpa pengguna benar-benar mengklik sama sekali.
- **Tombol "back"** browser yang kadang mengulang permintaan terakhir.

Karena alasan-alasan ini, ada konvensi penting dalam pengembangan web:
**`GET` seharusnya hanya dipakai untuk operasi yang aman diulang tanpa
efek samping** (seperti menampilkan halaman, ingat
`buku/list.php?page=2` di [bab 5](05-pagination-dan-pencarian-server.md)),
sedangkan operasi yang **mengubah data** (apalagi yang **merusak**
seperti Delete) harus memakai `POST`.

## 3.3 Memeriksa Metode HTTP: `$_SERVER['REQUEST_METHOD']`

```php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}
```

- **`$_SERVER`** adalah superglobal PHP lain (ingat konsepnya dari
  [dokumentasi jobsheet-07 §1.5](../../jobsheet-07/Dokumentasi/01-konsep-dasar-php.md#15-superglobal-variabel-bawaan-yang-selalu-tersedia))
  berisi informasi teknis tentang permintaan yang sedang diproses.
- **`$_SERVER['REQUEST_METHOD']`** berisi teks `'GET'` atau `'POST'`
  (atau metode lain), tergantung **bagaimana** permintaan ke halaman
  ini dibuat.
- Kalau metodenya **bukan** `'POST'` (misalnya seseorang mencoba
  membuka `hapus.php?id=3` langsung lewat address bar, yang selalu
  memakai `GET`), pengguna langsung **diarahkan kembali** ke `list.php`
  **tanpa** ada satu baris data pun yang terhapus — permintaan itu
  ditolak mentah-mentah sebelum sempat menyentuh database sama sekali.

## 3.4 Perintah `DELETE`

```php
$id = $_POST['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM buku WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil dihapus.'];
}
```

- **`DELETE FROM buku WHERE id = :id`** — perintah SQL baru: menghapus
  baris dari tabel `buku` yang `id`-nya cocok. Sama seperti `UPDATE`
  ([dokumentasi jobsheet-09 §2.6](02-edit-update-data.md#26-proses_editphp-menjalankan-update)),
  **klausa `WHERE` di sini wajib ada** — `DELETE FROM buku` **tanpa**
  `WHERE` akan menghapus **SELURUH** baris di tabel `buku` sekaligus,
  tanpa peringatan apa pun dari database.
- Perhatikan `$id` diperiksa dulu (`if ($id)`) sebelum query
  dijalankan — mencegah percobaan `DELETE ... WHERE id = :id` dengan
  `id` kosong/`null` yang bisa berperilaku tidak terduga.
- Kalau berhasil, flash message sukses diset — pola yang sama persis
  dengan Create ([dokumentasi jobsheet-08 §5.5](../../jobsheet-08/Dokumentasi/05-insert-prepared-statement.md#55-bagian-yang-tidak-berubah-sama-sekali))
  dan Update ([bab 2 §2.6](02-edit-update-data.md#26-proses_editphp-menjalankan-update)).

## 3.5 Bagaimana Form HTML Memicu Ini? (Pratinjau Singkat)

Ingat dari [README.md](../README.md) jobsheet ini, tombol Hapus di
`list.php` sekarang **bukan lagi** `<button>` polos, melainkan
`<form>` sungguhan:

```html
<form class="form-hapus" method="post" action="hapus.php">
    <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
    <button type="submit" class="btn-hapus">Hapus</button>
</form>
```

- `method="post"` — inilah yang membuat permintaan ini **selalu**
  memakai `POST`, lolos pemeriksaan di [§3.3](#33-memeriksa-metode-http-_serverrequest_method).
- `<input type="hidden" name="id">` — pola yang **sama persis** dengan
  form Edit ([bab 2 §2.5](02-edit-update-data.md#25-kotak-tersembunyi-input-typehidden-nameid)) —
  membawa `id` baris yang mau dihapus tanpa perlu ditampilkan ke
  pengguna.
- `<button type="submit">` — ingat dari
  [dokumentasi jobsheet-01 §4.5](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#45-tombol-submit),
  tombol ini yang memicu form untuk benar-benar di-submit ke
  `action="hapus.php"`.

Perubahan konfirmasi lewat JavaScript untuk pola `<form>` baru ini
dibahas detail di [bab 4](04-js-update-hapus-confirm.md).

Lanjut ke: [JS: Konfirmasi Hapus via Event `submit`](04-js-update-hapus-confirm.md)
