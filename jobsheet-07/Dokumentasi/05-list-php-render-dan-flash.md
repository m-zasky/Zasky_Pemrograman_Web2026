# 5. Menampilkan Data: `list.php` & Flash Message

Ini adalah sisi lain dari alur data yang sudah dipetakan di
[bab 3 §3.4](03-session-dan-alur-data.md#34-alur-lengkap-dari-form-sampai-tabel) —
bagaimana `$_SESSION['buku']` yang sudah diisi
`proses_tambah.php` ([bab 4](04-proses-tambah-validasi-server.md))
akhirnya benar-benar tampil sebagai tabel di layar.

## 5.1 Kode Lengkap `buku/list.php`

```php
<?php
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$daftarBuku = $_SESSION['buku'] ?? [];
?>
        <section>
            <h2>Daftar Buku</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <div class="search-box">
                <label for="search-input">Cari Judul Buku</label>
                <input type="text" id="search-input" placeholder="Ketik judul buku...">
            </div>

            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarBuku)): ?>
                    <tr>
                        <td colspan="5">Belum ada data buku. Silakan tambah lewat menu "Tambah Buku".</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($daftarBuku as $buku): ?>
                        <tr>
                            <td><?php echo $buku['judul']; ?></td>
                            <td><?php echo $buku['pengarang']; ?></td>
                            <td><?php echo $buku['tahun']; ?></td>
                            <td><?php echo $buku['stok']; ?></td>
                            <td>
                                <button type="button">Edit</button>
                                <button type="button" class="btn-hapus">Hapus</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
```

## 5.2 Mengambil dan "Menghapus" Flash Message

```php
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
```

- Baris pertama mengambil `$_SESSION['flash']` yang mungkin sudah diset
  oleh `proses_tambah.php` ([bab 4 §4.4-4.5](04-proses-tambah-validasi-server.md#44-kalau-ada-error-simpan-flash--redirect-kembali)),
  atau `null` kalau belum ada apa pun.
- **`unset($_SESSION['flash']);`** — menghapus kunci `'flash'` dari
  `$_SESSION` **seketika setelah dibaca**. Ini kunci dari konsep "flash
  message" — pesan yang **hanya muncul sekali**. Kalau baris `unset`
  ini tidak ada, pesan "Buku berhasil ditambahkan." akan **terus
  muncul** setiap kali kamu membuka ulang `list.php` di kemudian hari
  (karena data itu masih tersimpan di `$_SESSION`), padahal pesan itu
  seharusnya hanya relevan **tepat setelah** aksi tambah data terjadi.
  Dengan `unset` segera setelah dibaca, pesan itu otomatis "sekali
  pakai."

## 5.3 Menampilkan Flash Message di HTML

```php
<?php if ($flash): ?>
    <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
<?php endif; ?>
```

- **`<?php if ($flash): ?>`** — ingat sintaks alternatif ini dari
  [bab 2 §2.5](02-includes-header-footer.md#25-pola-extra_scripts-untuk-script-tambahan-per-halaman):
  kalau `$flash` berisi sesuatu (bukan `null`), paragraf ini ditampilkan;
  kalau tidak, seluruh blok ini **dilewati sepenuhnya** — tidak ada
  `<p>` kosong yang muncul di HTML kalau tidak ada pesan flash.
- **`class="flash flash-<?php echo $flash['type']; ?>"`** — perhatikan
  **dua** class ditulis sekaligus, dipisah spasi: `flash` (gaya dasar,
  sama untuk semua flash message) dan `flash-error`/`flash-success`
  (gaya spesifik, tergantung nilai `$flash['type']` yang diset di
  `proses_tambah.php`). Kalau `$flash['type']` adalah `'success'`, hasil
  akhirnya jadi `class="flash flash-success"`. Penjelasan CSS untuk
  kedua class ini ada di [bab 6](06-css-flash-message.md).

## 5.4 Menampilkan Tabel dari Array Session

```php
<?php if (empty($daftarBuku)): ?>
<tr>
    <td colspan="5">Belum ada data buku. Silakan tambah lewat menu "Tambah Buku".</td>
</tr>
<?php else: ?>
    <?php foreach ($daftarBuku as $buku): ?>
    <tr>
        <td><?php echo $buku['judul']; ?></td>
        <td><?php echo $buku['pengarang']; ?></td>
        <td><?php echo $buku['tahun']; ?></td>
        <td><?php echo $buku['stok']; ?></td>
        <td>
            <button type="button">Edit</button>
            <button type="button" class="btn-hapus">Hapus</button>
        </td>
    </tr>
    <?php endforeach; ?>
<?php endif; ?>
```

- **`empty($daftarBuku)`** — memeriksa apakah array `$daftarBuku`
  **kosong** (belum ada satu pun buku ditambahkan sepanjang sesi ini).
  Kalau kosong, tampilkan **satu baris pesan** ("Belum ada data buku...")
  memakai `colspan="5"` (ingat atribut ini dari
  [dokumentasi jobsheet-06 §4.7](../../jobsheet-06/Dokumentasi/04-js-fetch-render-buku.md#47-menangkap-dan-menampilkan-error) —
  konsep yang persis sama, hanya sekarang ditangani di PHP, bukan
  JavaScript).
- **`foreach ($daftarBuku as $buku): ... endforeach;`** — mengulang
  **setiap** elemen di array `$daftarBuku`, dengan `$buku` mewakili
  satu buku pada tiap putaran. Bandingkan langsung dengan
  `daftarBuku.forEach(function (buku) { ... })` yang sudah kamu pakai
  di JavaScript
  ([dokumentasi jobsheet-06 §4.6](../../jobsheet-06/Dokumentasi/04-js-fetch-render-buku.md#46-membuat-baris-tabel-dari-data)) —
  **konsep yang identik** (mengulang setiap item array), hanya sintaks
  bahasanya berbeda.
- **`<?php echo $buku['judul']; ?>`** — mengambil nilai dari kunci
  `'judul'` pada array asosiatif `$buku`, sama persis strukturnya
  dengan yang disimpan `proses_tambah.php`
  ([bab 4 §4.5](04-proses-tambah-validasi-server.md#45-kalau-valid-simpan-ke-session--redirect-ke-daftar)).

## 5.5 Perbandingan Besar: Rendering di Server vs di Browser

Ini pergeseran konseptual paling penting di jobsheet ini:

| | Jobsheet-06 (Fetch/JSON) | Jobsheet-07 (PHP) |
|---|---|---|
| Di mana tabel "dirakit"? | Di **browser**, oleh JavaScript (`buku.js`) | Di **server**, oleh PHP (`list.php`) |
| Sumber data | File `data/buku.json`, diambil lewat `fetch()` | `$_SESSION['buku']`, dibaca langsung di server |
| HTML yang diterima browser | `<tbody>` kosong dulu, lalu diisi belakangan oleh JS | `<tbody>` **sudah terisi penuh** sejak awal — hasil akhir jadi, siap tampil |
| Butuh loading indicator? | Ya (ingat [dokumentasi jobsheet-06 §4.3](../../jobsheet-06/Dokumentasi/04-js-fetch-render-buku.md#43-menampilkan-dan-menyembunyikan-loading-indicator)) | Tidak — data sudah "jadi" sebelum halaman dikirim, tidak ada jeda yang terlihat pengguna |

Perhatikan `buku/list.php` **tidak lagi punya** elemen
`#loading-indicator` maupun memuat `buku.js` — karena tidak ada lagi
proses "menunggu" yang terlihat oleh pengguna: begitu `list.php`
selesai diproses server, HTML yang dikirim **sudah lengkap** berisi
seluruh baris tabel, siap ditampilkan seketika oleh browser.

Lanjut ke: [CSS: Gaya Flash Message](06-css-flash-message.md)
