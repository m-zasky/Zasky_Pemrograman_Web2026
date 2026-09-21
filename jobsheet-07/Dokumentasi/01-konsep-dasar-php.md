# 1. Konsep Dasar PHP

Ini pengenalan pertamamu ke PHP. Kenali dulu bagaimana PHP berbeda
secara **mendasar** dari HTML/CSS/JavaScript yang sudah kamu pelajari.

## 1.1 Server-Side vs Client-Side: Bedanya Apa?

Ini konsep **paling penting** untuk dipahami sebelum apa pun lainnya:

| | **Client-side** (HTML, CSS, JavaScript) | **Server-side** (PHP) |
|---|---|---|
| Berjalan di mana? | Di **browser** pengguna (komputer/HP pembaca situs) | Di **server** (komputer tempat aplikasi web ditempatkan) |
| Kapan? | Setelah halaman **diterima** browser | **Sebelum** halaman dikirim ke browser |
| Bisa dilihat pengguna? | Ya — lewat "View Source"/DevTools, kode aslinya terlihat | **Tidak pernah** — pengguna hanya menerima **hasil akhirnya** (HTML biasa) |
| Contoh di SIMPUS-Mini | `app.js` mengatur menu hamburger ([dokumentasi jobsheet-05](../../jobsheet-05/Dokumentasi/README.md)) | `proses_tambah.php` memvalidasi & menyimpan data ([bab 4](04-proses-tambah-validasi-server.md)) |

Bayangkan mengirim surat lewat kantor pos: **server-side** adalah
proses di kantor pos (menyortir, memvalidasi alamat, mencatat) yang
**tidak terlihat** oleh pengirim maupun penerima surat — mereka hanya
melihat hasilnya (surat terkirim atau dikembalikan). **Client-side**
adalah hal-hal yang terjadi setelah surat itu sampai di tangan
penerima (misalnya penerima membuka amplop, membaca isinya).

## 1.2 Sintaks Dasar: Tag `<?php ?>`

```php
<?php
$page_title = "Beranda";
?>
```

Kode PHP selalu diapit tag pembuka **`<?php`** dan tag penutup **`?>`**.
Di **luar** tag ini, semua teks (termasuk HTML biasa) diperlakukan apa
adanya, persis seperti file `.html` biasa. Inilah kenapa file `.php`
bisa berisi **campuran** HTML dan PHP dalam satu file — perhatikan
`buku/list.php` ([bab 5](05-list-php-render-dan-flash.md)) berisi tag
`<section>`, `<table>` HTML biasa, **diselingi** potongan kode PHP di
sana-sini.

## 1.3 Variabel PHP: Selalu Diawali `$`

```php
$page_title = "Beranda";
$totalBuku = count($_SESSION['buku'] ?? []);
```

- Setiap **variabel** (tempat menyimpan nilai) di PHP **wajib** diawali
  tanda dolar (**`$`**) — beda dengan JavaScript yang memakai `let`/
  `const` tanpa simbol khusus (ingat dari
  [dokumentasi jobsheet-05 §4.2](../../jobsheet-05/Dokumentasi/04-js-hamburger-menu.md#42-mengambil-dua-elemen-yang-dibutuhkan)).
  `$page_title` dan `$totalBuku` adalah dua variabel berbeda.
- Setiap baris pernyataan PHP diakhiri **titik koma** (`;`) — sama
  seperti kebiasaan yang sudah kamu lihat di JavaScript.

## 1.4 Menampilkan Nilai ke HTML: `echo`

```php
<p><?php echo $totalBuku; ?></p>
```

**`echo`** adalah perintah PHP untuk "mencetak/menampilkan" sebuah nilai
ke output HTML yang dikirim ke browser. Baris ini menghasilkan HTML
seperti `<p>12</p>` (kalau nilai `$totalBuku` adalah `12`) — perhatikan
begitu PHP selesai memproses, **tidak ada jejak PHP tersisa** di HTML
yang diterima browser; yang terlihat hanyalah angka biasa di dalam tag
`<p>`. Inilah wujud nyata dari "server-side" yang dibahas di
[§1.1](#11-server-side-vs-client-side-bedanya-apa) — proses `echo`
terjadi di server, hasilnya (angka `12`) yang sampai ke browser.

## 1.5 Superglobal: Variabel Bawaan yang Selalu Tersedia

PHP punya beberapa variabel spesial yang disebut **superglobal** —
selalu tersedia di mana pun tanpa perlu dideklarasikan sendiri,
namanya selalu huruf besar semua:

| Superglobal | Isinya |
|---|---|
| `$_SESSION` | Data yang disimpan **antar halaman** untuk **satu pengunjung** yang sama, selama sesi browsernya masih aktif. Dibahas mendalam di [bab 3](03-session-dan-alur-data.md). |
| `$_POST` | Data yang **dikirim** lewat form dengan `method="post"` (ingat dari [dokumentasi jobsheet-01 §4.2](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#42-elemen-form), form sebelumnya tidak punya `method` sama sekali). Dibahas di [bab 4](04-proses-tambah-validasi-server.md). |

## 1.6 Operator `??` (Null Coalescing)

```php
$flash = $_SESSION['flash'] ?? null;
$totalBuku = count($_SESSION['buku'] ?? []);
```

**`??`** adalah operator "kalau tidak ada, pakai nilai ini" — mirip
konsepnya dengan *optional chaining* `?.` di JavaScript yang sudah kamu
kenal dari
[dokumentasi jobsheet-05 §5.4](../../jobsheet-05/Dokumentasi/05-js-konfirmasi-hapus.md#54-mengambil-namajudul-dari-baris-itu),
tapi cara kerjanya sedikit berbeda: `$_SESSION['flash'] ?? null` berarti
"ambil `$_SESSION['flash']` **kalau ada**; kalau kunci itu belum pernah
diset sama sekali, pakai `null` sebagai gantinya" — mencegah error
"undefined array key" yang akan muncul kalau kunci itu diakses langsung
padahal belum pernah ada.

## 1.7 Menjalankan PHP: Butuh Server Sungguhan

Berbeda dari HTML biasa yang bisa dibuka langsung dengan klik dua kali
(`file://`), file `.php` **wajib** diproses oleh **PHP interpreter**
sebelum bisa dilihat sebagai halaman web — kalau kamu membuka
`index.php` langsung di browser tanpa server, browser hanya akan
menampilkan **kode PHP mentahnya sebagai teks**, bukan hasil akhirnya.
Sesuai [README.md](../README.md) jobsheet ini, jalankan:

```bash
php -S localhost:8000
```

Jalankan perintah ini **dari dalam folder `jobsheet-07/`** supaya
`http://localhost:8000/` memetakan langsung ke folder ini. Path
CSS/JS/menu di jobsheet ini dihitung **relatif otomatis** terhadap
folder proyek (bukan digantung ke akar server) — dijelaskan detail di
[bab 2 §2.3](02-includes-header-footer.md#23-path-relatif-otomatis-di-includesheaderphp),
jadi selain lewat `php -S`, proyek ini juga tetap bisa dibuka lewat
Laragon meskipun diakses bersarang di dalam beberapa folder (misalnya
`http://dp2026.test/kode-praktikum/jobsheet-07/`).
Setelah server berjalan, buka `http://localhost:8000/index.php` — mirip
dengan cara menjalankan jobsheet-06 (ingat
[dokumentasi jobsheet-06 §7.3](../../jobsheet-06/Dokumentasi/07-menjalankan-dengan-server-lokal.md#73-solusi-jalankan-lewat-server-lokal)),
hanya saja kali ini server yang sama juga **memproses** kode PHP-nya,
bukan cuma menyajikan file statis apa adanya.

Dengan bekal konsep dasar ini, kamu siap membaca file-file PHP jobsheet
ini mulai bab 2.

Lanjut ke: [`includes/header.php` & `includes/footer.php`](02-includes-header-footer.md)
