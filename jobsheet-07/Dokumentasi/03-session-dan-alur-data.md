# 3. Session & Alur Data

Sebelum membedah `proses_tambah.php` dan `list.php`, pahami dulu **ke
mana** data buku/anggota sebenarnya "disimpan" di jobsheet ini — karena
jawabannya cukup mengejutkan untuk pemula.

## 3.1 Apa itu Session?

**Session** adalah cara server "mengingat" seorang pengunjung **antar
halaman**, bahkan antar kunjungan berbeda dalam rentang waktu tertentu.
Protokol HTTP (dasar komunikasi web) sebenarnya bersifat **stateless**
(tidak mengingat apa pun) — setiap kali browser meminta sebuah halaman,
server memperlakukannya sebagai permintaan yang **benar-benar baru**,
tanpa tahu apakah permintaan sebelumnya datang dari orang yang sama.
Session menyelesaikan ini: server memberi setiap pengunjung sebuah
"tanda pengenal" unik (biasanya lewat cookie tersembunyi di browser),
supaya server bisa mencocokkan "oh, permintaan ini datang dari
pengunjung yang sama seperti tadi" dan mengambilkan data yang relevan.

## 3.2 Mengaktifkan Session: `session_start()`

```php
<?php
session_start();
?>
```

Ingat baris ini dari [bab 2 §2.1](02-includes-header-footer.md#21-includesheaderphp--kode-lengkap)
— berada di **baris paling atas** `header.php`. `session_start()`
**wajib** dipanggil di **setiap** halaman yang ingin menggunakan
`$_SESSION` (ingat superglobal ini dari
[bab 1 §1.5](01-konsep-dasar-php.md#15-superglobal-variabel-bawaan-yang-selalu-tersedia)),
dan **harus** dipanggil **sebelum** ada output apa pun dikirim ke
browser (karena itulah letaknya di baris paling atas file, sebelum
`<!DOCTYPE html>`). Karena setiap halaman meng-`include` `header.php`
([bab 2 §2.2](02-includes-header-footer.md#22-memanggil-include)),
`session_start()` otomatis terpanggil di **semua** halaman tanpa perlu
menulisnya berulang-ulang — manfaat lain dari pola `include` yang sudah
dibahas di [bab 2](02-includes-header-footer.md).

## 3.3 `$_SESSION` sebagai "Keranjang" Data Sementara

Bayangkan `$_SESSION` sebagai sebuah **keranjang** yang disediakan
server khusus untuk **satu pengunjung**, dan keranjang itu **tetap ada**
selama pengunjung itu berpindah-pindah halaman (selama sesi browsernya
aktif). Di jobsheet ini, ada 2 "slot" yang dipakai di keranjang itu:

| Kunci | Isinya | Diisi oleh |
|---|---|---|
| `$_SESSION['buku']` | Array berisi semua buku yang sudah ditambahkan | `buku/proses_tambah.php` ([bab 4](04-proses-tambah-validasi-server.md)) |
| `$_SESSION['anggota']` | Array berisi semua anggota yang sudah ditambahkan | `anggota/proses_tambah.php` |
| `$_SESSION['flash']` | Pesan sukses/gagal untuk ditampilkan **sekali saja** | Kedua file `proses_tambah.php` |

## 3.4 Alur Lengkap: dari Form Sampai Tabel

Mari telusuri **seluruh perjalanan** data dari saat kamu mengisi form
Tambah Buku sampai muncul di tabel Daftar Buku:

1. Kamu membuka `buku/tambah.php`, mengisi form, klik "Simpan".
2. Browser mengirim data form (lewat `method="post"`, dibahas di
   [bab 4 §4.2](04-proses-tambah-validasi-server.md#42-menerima-data-form-_post)) ke
   `buku/proses_tambah.php`.
3. `proses_tambah.php` **memvalidasi** data itu ([bab 4](04-proses-tambah-validasi-server.md)).
   Kalau valid: data itu ditambahkan ke **array** `$_SESSION['buku']`
   (data buku yang sudah ada sebelumnya **tidak hilang** — ingat
   `$_SESSION` bersifat "keranjang", data baru ditambahkan ke situ,
   bukan menimpanya).
4. `proses_tambah.php` mengatur `$_SESSION['flash']` berisi pesan
   sukses, lalu **mengalihkan** (redirect) browser ke `buku/list.php`.
5. `buku/list.php` dibuka (sebagai permintaan halaman **baru**, terpisah
   dari langkah sebelumnya) — ia membaca `$_SESSION['buku']` (yang
   sekarang **sudah berisi** buku yang baru saja ditambahkan di langkah
   3) dan `$_SESSION['flash']` (pesan sukses dari langkah 4), lalu
   merender keduanya jadi tabel HTML dan pesan flash (dibahas di
   [bab 5](05-list-php-render-dan-flash.md)).

Perhatikan **setiap langkah di atas adalah permintaan HTTP terpisah**
ke server (langkah 2, langkah 5 masing-masing satu kali "kunjungan"
baru) — dan `$_SESSION` inilah **satu-satunya** cara data (buku yang
baru ditambahkan, pesan flash) bisa "menyeberang" dari satu permintaan
ke permintaan berikutnya, karena seperti dibahas di
[§3.1](#31-apa-itu-session), HTTP sendiri tidak mengingat apa pun antar
permintaan.

## 3.5 Kenapa Data Ini "Sementara"?

Ingat catatan penting di [README.md](../README.md) jobsheet ini: data
di `$_SESSION` akan **hilang** begitu sesi browser berakhir (menutup
browser sepenuhnya, membersihkan cookie, atau sesi kedaluwarsa di
server setelah periode tidak aktif). Ini **jembatan sementara** — bukan
penyimpanan data yang sesungguhnya. Bandingkan dengan
`data/buku.json` di jobsheet-06
([dokumentasi jobsheet-06 §3](../../jobsheet-06/Dokumentasi/03-data-json.md)):
file JSON itu **tetap ada** di folder, tidak peduli sesi browser mana
pun yang mengaksesnya — tapi juga **tidak bisa ditambah** datanya lewat
form (hanya bisa dibaca, tidak ditulis). `$_SESSION` di jobsheet-07
**bisa ditambah** lewat form, tapi **tidak permanen** antar sesi.
Kombinasi "bisa ditambah **dan** permanen" baru akan tercapai mulai
Jobsheet 8 dengan database PostgreSQL sungguhan.

Lanjut ke: [Memproses Form: `proses_tambah.php`](04-proses-tambah-validasi-server.md)
