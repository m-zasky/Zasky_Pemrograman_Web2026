# 5. Pagination & Pencarian Sisi Server

Bab paling padat SQL di jobsheet ini — `buku/list.php` sekarang jauh
lebih canggih dibanding versi jobsheet-08 yang sekadar `SELECT *`.

## 5.1 Kode Lengkap Bagian Query

```php
$perPage = 5;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM buku WHERE judul ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM buku WHERE judul ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM buku ORDER BY id DESC LIMIT :limit OFFSET :offset");
}
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = max(1, (int) ceil($totalRows / $perPage));
```

## 5.2 Kenapa Butuh Pagination?

Bayangkan tabel `buku` sudah berisi 200 buku — menampilkan **semuanya
sekaligus** dalam satu halaman akan membuat halaman sangat panjang dan
lambat dimuat. **Pagination** (penomoran halaman) membagi data jadi
beberapa "halaman" berisi sejumlah baris tetap — di jobsheet ini,
**5 baris per halaman** (`$perPage = 5`).

## 5.3 Menghitung Halaman: `$page` dan `$offset`

```php
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
```

- **`$_GET['page'] ?? 1`** — nomor halaman diambil dari URL (ingat
  `$_GET` dari [dokumentasi jobsheet-09 §2.2](02-edit-update-data.md#22-mengambil-id-dari-url-_getid)),
  misalnya dari `list.php?page=2`. Kalau parameter `page` tidak ada
  sama sekali (pertama kali membuka halaman), dianggap halaman `1`.
- **`max(1, ...)`** — fungsi PHP yang mengembalikan nilai **terbesar**
  di antara argumennya. Dipakai di sini sebagai **pengaman**: kalau
  seseorang mencoba membuka `list.php?page=0` atau `page=-5` (nilai
  yang tidak masuk akal), `$page` akan tetap dipaksa minimal `1`.
- **`$offset = ($page - 1) * $perPage;`** — **offset** adalah "berapa
  baris yang perlu dilompati dari awal" sebelum mulai mengambil data.
  Kalau `$page = 1`: offset `(1-1) * 5 = 0` (mulai dari baris
  pertama). Kalau `$page = 2`: offset `(2-1) * 5 = 5` (lompati 5 baris
  pertama, mulai dari baris ke-6). Kalau `$page = 3`: offset `10`, dan
  seterusnya.

## 5.4 `LIMIT` dan `OFFSET` dalam Query SQL

```sql
SELECT * FROM buku ORDER BY id DESC LIMIT :limit OFFSET :offset
```

- **`LIMIT :limit`** — klausa SQL baru: membatasi hasil **maksimal**
  sejumlah baris tertentu (di sini, `$perPage` = 5).
- **`OFFSET :offset`** — melompati sejumlah baris dari awal sebelum
  mulai mengambil (dihitung di [§5.3](#53-menghitung-halaman-page-dan-offset)).

Kombinasi keduanya inilah yang menghasilkan "potongan" data per
halaman: halaman 1 mengambil baris ke 1-5, halaman 2 mengambil baris ke
6-10, dan seterusnya — **`ORDER BY id DESC`** (ingat dari
[dokumentasi jobsheet-08 §6.1](../../jobsheet-08/Dokumentasi/06-membaca-data-select.md#61-bukulistphp-mengambil-semua-baris))
tetap penting di sini supaya urutan potongannya **konsisten** setiap
kali — tanpa `ORDER BY`, database **tidak menjamin** urutan baris yang
sama setiap query, yang bisa membuat pagination menampilkan data
duplikat atau melewatkan baris tertentu.

## 5.5 `bindValue()` dan `PDO::PARAM_INT`

```php
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
```

- **`bindValue(nama, nilai, tipe)`** — cara **lain** mengisi
  placeholder prepared statement, selain lewat array di
  `execute([...])` seperti yang sudah kamu kenal dari
  [dokumentasi jobsheet-08 §5.4](../../jobsheet-08/Dokumentasi/05-insert-prepared-statement.md#54-menjalankan-query-stmt-execute).
  `bindValue()` mengisi placeholder **satu per satu**, dipanggil
  **sebelum** `execute()` (yang di sini dipanggil **tanpa** argumen
  sama sekali, karena semua placeholder sudah diisi lebih dulu).
- **`PDO::PARAM_INT`** — parameter ketiga yang **secara eksplisit**
  memberi tahu PDO bahwa nilai ini harus diperlakukan sebagai
  **angka**, bukan teks. Ini penting khusus untuk `LIMIT`/`OFFSET` —
  PostgreSQL cukup ketat soal tipe data di klausa ini, dan tanpa
  `PDO::PARAM_INT`, nilai yang terkirim sebagai teks (perilaku default
  `bindValue`/`execute` biasa) bisa menyebabkan error SQL.

## 5.6 Pencarian Sisi Server: `ILIKE`

```php
if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM buku WHERE judul ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM buku WHERE judul ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
}
```

- **`$keyword = trim($_GET['q'] ?? '')`** — kata kunci pencarian
  diambil dari parameter URL `q` (dari form `method="get"`, dibahas di
  [§5.8](#58-form-pencarian-methodget)).
- **`ILIKE`** — operator pencocokan teks khusus PostgreSQL, mirip
  `LIKE` biasa tapi **tidak peduli huruf besar/kecil** (*case-
  insensitive*) — konsepnya setara dengan `.toLowerCase()` yang sudah
  kamu pakai untuk pencarian client-side sejak
  [dokumentasi jobsheet-05 §6.4](../../jobsheet-05/Dokumentasi/06-js-filter-tabel.md#64-mengambil-kata-kunci-pencarian).
- **`'%' . $keyword . '%'`** — tanda persen (`%`) di kedua sisi kata
  kunci adalah **wildcard** (karakter pengganti bebas) di SQL, berarti
  "boleh ada teks apa saja sebelum dan sesudah kata kunci ini." Kalau
  `$keyword` adalah `"bumi"`, pola `'%bumi%'` akan cocok dengan judul
  apa pun yang **mengandung** kata "bumi" di bagian mana pun — persis
  konsepnya dengan `teks.includes(keyword)` yang sudah kamu pakai di
  JavaScript
  ([dokumentasi jobsheet-05 §6.5](../../jobsheet-05/Dokumentasi/06-js-filter-tabel.md#65-mengulang-setiap-baris-tabel)).
- Perhatikan `$totalRows` **juga** dihitung ulang dengan `WHERE`/`ILIKE`
  yang sama — ini penting supaya jumlah halaman ([§5.7](#57-menghitung-total-halaman))
  dihitung berdasarkan **jumlah hasil pencarian**, bukan jumlah total
  seluruh buku di database.

## 5.7 Menghitung Total Halaman

```php
$totalPages = max(1, (int) ceil($totalRows / $perPage));
```

- **`ceil(...)`** — fungsi pembulatan **ke atas**. Kalau ada 12 buku
  dengan 5 per halaman, `12 / 5 = 2.4`, dibulatkan ke atas jadi `3`
  halaman (2 halaman penuh + 1 halaman berisi sisa 2 buku).
- **`max(1, ...)`** — pengaman lagi: kalau `$totalRows` adalah `0`
  (tidak ada data/hasil pencarian sama sekali), `$totalPages` tetap
  dipaksa minimal `1` — supaya navigasi halaman tetap menampilkan
  minimal satu tombol "1", bukan kosong sama sekali.

## 5.8 Form Pencarian: `method="get"`

```html
<form method="get" action="list.php">
    <span>
        <label for="search-input">Cari Judul Buku</label><br>
        <input type="text" id="search-input" name="q" value="<?php echo $keyword; ?>" placeholder="Ketik judul buku...">
    </span>
    <button type="submit">Cari</button>
</form>
```

Berbeda dari form Tambah/Edit yang memakai `method="post"` (ingat dari
[dokumentasi jobsheet-07 §4.1](../../jobsheet-07/Dokumentasi/04-proses-tambah-validasi-server.md#41-form-yang-kini-benar-benar-hidup)),
form pencarian ini sengaja memakai **`method="get"`** — cocok karena
mencari data **tidak mengubah apa pun** di server (aman diulang
berkali-kali, aman jadi tautan yang bisa di-bookmark/dibagikan), sesuai
prinsip yang sudah dibahas di
[bab 3 §3.2](03-hapus-delete-data.md#32-kenapa-delete-tidak-boleh-sesederhana-sebuah-tautan) —
`GET` untuk operasi aman/dibaca, `POST` untuk operasi yang mengubah data.

**`value="<?php echo $keyword; ?>"`** membuat kata kunci yang baru saja
dicari **tetap terlihat** di kotak input setelah halaman submit —
tanpa baris ini, kotak pencarian akan **kosong lagi** setiap kali
halaman dimuat ulang, meskipun pencariannya berhasil dan hasilnya
tampil. Ingat catatan penting dari [README.md](../README.md) jobsheet
ini: nilai ini **belum di-escape** sebelum ditampilkan kembali — celah
ini akan dibahas dan diperbaiki di Jobsheet 11.

## 5.9 Menampilkan Navigasi Halaman

```php
<nav class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>"
       class="<?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
</nav>
```

- **`for ($i = 1; $i <= $totalPages; $i++)`** — perulangan PHP baru
  (belum pernah dipakai sebelumnya di dokumentasi ini): "mulai dari `i=1`,
  ulangi selama `i` masih kurang dari atau sama dengan `$totalPages`,
  tambah `i` satu setiap putaran" — menghasilkan satu tautan angka
  untuk **setiap** nomor halaman yang ada.
- **`&q=' . urlencode($keyword)`** ditambahkan **hanya kalau** sedang
  ada pencarian aktif (`$keyword !== ''`) — memastikan kata kunci
  pencarian **ikut terbawa** saat berpindah antar halaman hasil
  pencarian, bukan hilang begitu saja.
- **`class="<?php echo $i === $page ? 'active' : ''; ?>"`** — halaman
  yang **sedang aktif** diberi class `active`, dipakai CSS untuk
  menyorotnya secara visual (dibahas di [bab 6](06-css-pendukung.md)).

Lanjut ke: [CSS Pendukung Fitur Baru](06-css-pendukung.md)
