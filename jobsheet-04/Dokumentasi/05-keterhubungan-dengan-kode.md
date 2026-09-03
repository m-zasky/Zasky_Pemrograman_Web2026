# 5. Keterhubungan dengan Kode yang Sudah Ada

Bab ini menghubungkan rancangan wireframe di `docs/wireframe.md` dengan
kode HTML/CSS yang **sudah benar-benar berjalan** sejak jobsheet-01
sampai jobsheet-03 — supaya kamu melihat bahwa rancangan ini bukan
proyek terpisah, melainkan **kelanjutan langsung** dari yang sudah kamu
bangun.

## 5.1 Catatan Resmi dari `wireframe.md`

Dokumen [`wireframe.md`](../docs/wireframe.md) sendiri menutup dengan
bagian "Konsistensi dengan Desain yang Sudah Berjalan":

> - Warna aksen, tipografi navbar, dan gaya tabel/kartu mengikuti
>   `assets/css/style.css` yang sudah dibangun sejak Jobsheet 2-3.
> - Navbar akan ditambah menu **Peminjaman** dan indikator status login
>   (nama petugas / tombol Logout) mulai implementasi di Jobsheet 10.
> - Edge case yang perlu ditangani saat implementasi: buku stok habis
>   tidak boleh dipilih di form peminjaman; anggota dengan tunggakan
>   terlambat divalidasi di Jobsheet 12 (tugas mandiri).

Mari bedah tiap poin ini satu per satu.

## 5.2 Warna & Gaya Tetap Sama — Tidak Perlu Membangun CSS dari Nol

Ingat dari [dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/README.md),
kamu sudah membangun:

- Warna tema biru `#1d5b8a` untuk header, judul section, dan tombol
  submit (lihat [dokumentasi jobsheet-02 §3.2](../../jobsheet-02/Dokumentasi/03-css-reset-dan-body.md#32-gaya-dasar-body)).
- Gaya kartu putih dengan bayangan halus untuk `<section>` (lihat
  [dokumentasi jobsheet-02 §5.3](../../jobsheet-02/Dokumentasi/05-css-main-dan-section.md#53-kartu-putih-untuk-setiap-section)).
- Gaya tabel dengan header berwarna dan baris selang-seling (lihat
  [dokumentasi jobsheet-02 §7](../../jobsheet-02/Dokumentasi/07-css-tabel.md)).
- Gaya form dengan label tebal dan input rapi (lihat
  [dokumentasi jobsheet-02 §8](../../jobsheet-02/Dokumentasi/08-css-form.md)).

Semua wireframe halaman baru (Login, Dashboard, form Peminjaman/
Pengembalian) **sengaja dirancang mengikuti pola yang sama** — artinya
saat halaman-halaman ini benar-benar dikoding nanti, kamu **tidak perlu
menulis ulang CSS dari nol**. Form Login misalnya, akan memakai pola
`<label>` + `<input>` yang **identik** dengan form Tambah Buku yang
sudah kamu pelajari di
[dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md),
sehingga otomatis mendapat gaya rapi dari `form label` dan
`form input` di `style.css` tanpa perlu menulis CSS baru.

## 5.3 Navbar Akan Bertambah Menu — Tapi Pola CSS-nya Tidak Berubah

Ingat dari [dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/04-css-header-navbar-flexbox.md)
dan [dokumentasi jobsheet-03](../../jobsheet-03/Dokumentasi/03-css-hamburger-checkbox-hack.md),
navbar dibangun dengan Flexbox (`header nav ul { display: flex; ... }`)
yang menyusun **jumlah item menu berapa pun** secara otomatis sejajar
horizontal (atau vertikal di layar mobile lewat checkbox hack). Artinya,
menambahkan satu `<li><a>` baru untuk menu "Peminjaman" nanti di
Jobsheet 10 **tidak memerlukan perubahan CSS sama sekali** — cukup
menambah satu baris HTML, dan Flexbox akan otomatis menata ulang
seluruh menu. Ini contoh nyata manfaat mendesain sistem CSS yang
generik sejak awal (ingat catatan serupa soal selector generik di
[dokumentasi jobsheet-02 §6.7](../../jobsheet-02/Dokumentasi/06-css-grid-kartu-statistik.md#67-kenapa-tidak-pakai-class-saja)).

Begitu juga indikator status login (`(Nama Petugas) Logout`) yang
terlihat di wireframe Dashboard — ini akan jadi elemen tambahan baru di
dalam `<header>`, kemungkinan disusun sejajar dengan `<h1>` dan `<nav>`
memakai `justify-content: space-between` yang sama seperti yang
membuat `<h1>` dan `<nav>` sejajar sekarang (lihat
[dokumentasi jobsheet-02 §4.4](../../jobsheet-02/Dokumentasi/04-css-header-navbar-flexbox.md#44-mengatur-posisi-flex-item)).

## 5.4 Kartu Statistik yang Sama, Konteks yang Beda

Wireframe Dashboard Petugas menampilkan baris
`[Total Buku] [Total Anggota] [Sedang Dipinjam]` — bandingkan dengan
kartu statistik yang **sudah ada dan berfungsi** di
[`index.html`](../index.html) saat ini (lihat penjelasan lengkapnya di
[dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/02-index-html.md#main--konten-utama)
dan cara stylingnya dengan CSS Grid di
[dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/06-css-grid-kartu-statistik.md)).
Ini bukan kebetulan — rancangan Dashboard Petugas **menggunakan ulang**
komponen kartu statistik yang sama persis, hanya dalam konteks halaman
yang berbeda (khusus Petugas yang sudah login, bukan Beranda publik).

## 5.5 Edge Case yang Sudah Dicatat Sejak Sekarang

Dua "edge case" (kasus khusus/pengecualian) sudah dicatat di
`wireframe.md`:

1. **Buku stok habis tidak boleh dipilih** di form Peminjaman — ini
   sudah muncul juga di user flow
   ([bab 3 §3.2](03-user-flow-peminjaman-pengembalian.md#32-user-flow-peminjaman-buku),
   catatan `(stok > 0)`). Data stok ini **sudah ada** sejak jobsheet-01:
   lihat kolom "Stok" di
   [tabel Daftar Buku](../../jobsheet-01/Dokumentasi/03-buku-list-html.md#33-data-yang-ditampilkan-dummy) —
   nantinya tinggal ditambah logika pengecekan `stok > 0` saat
   menampilkan pilihan buku di form Peminjaman.
2. **Anggota dengan tunggakan terlambat** — kasus ini ditandai untuk
   ditangani di "Jobsheet 12 (tugas mandiri)", menunjukkan bahwa tidak
   semua detail perlu diselesaikan **sekaligus**; mencatatnya di tahap
   rancangan memastikan kasus ini tidak terlupakan meski implementasinya
   ditunda ke jobsheet lain.

Mencatat edge case seperti ini di tahap wireframe — jauh sebelum
menulis kode penanganannya — adalah kebiasaan baik yang mencegah
"kejutan" di tengah proses coding nanti.

Lanjut ke: [Rangkuman & Latihan Lanjutan](06-rangkuman-latihan.md)
