# 4. CSS: Tabel yang Bisa Di-scroll (`table-responsive`)

Bab pendek ini membahas solusi untuk masalah klasik: tabel dengan banyak
kolom (seperti Daftar Buku dari
[dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/03-buku-list-html.md))
akan terlihat sangat sempit dan sulit dibaca kalau dipaksa muat di layar
HP.

## 4.1 Kode CSS

```css
/* ===== Tabel Responsif ===== */
.table-responsive {
    overflow-x: auto;
}
```

Hanya **satu properti**, tapi cukup untuk menyelesaikan masalahnya.

## 4.2 Dua Pilihan Menghadapi Tabel Lebar di Layar Sempit

Ada dua strategi umum menangani tabel lebar di layar sempit:

1. **Memampatkan isi tabel** — memaksa semua kolom mengecil supaya muat
   di layar sempit. Masalahnya: teks jadi terpotong/tidak terbaca,
   terutama untuk kolom seperti "Pengarang" yang berisi nama panjang.
2. **Membiarkan tabel selebar aslinya, tapi bisa di-scroll ke samping**
   — inilah pendekatan yang dipilih jobsheet ini. Lebar kolom tetap
   nyaman dibaca, dan pengguna tinggal geser (swipe di HP, atau scroll
   horizontal di trackpad/mouse) untuk melihat kolom yang belum terlihat.

## 4.3 Kenapa Perlu Dibungkus `<div>`?

Ingat dari [bab 2 §2.3](02-perubahan-file-html.md#23-pembungkus-div-classtable-responsive),
`<table>` dibungkus tambahan `<div class="table-responsive">`. Ini karena
`overflow-x: auto` **tidak bisa diterapkan langsung** ke elemen
`<table>` seefektif kalau diterapkan ke sebuah `<div>` pembungkus:

- `<table>` yang lebar (isinya banyak kolom) akan tetap **mendorong
  melebar** kotak pembungkusnya sendiri, alih-alih terpotong dan
  memicu scrollbar pada dirinya sendiri.
- Dengan membungkusnya dalam `<div class="table-responsive">` yang
  diberi `overflow-x: auto`, `<div>` inilah yang punya **lebar tetap**
  (mengikuti kotak `<section>` pembungkusnya — lihat
  [dokumentasi jobsheet-02 §5.3](../../jobsheet-02/Dokumentasi/05-css-main-dan-section.md#53-kartu-putih-untuk-setiap-section)),
  sementara `<table>` di dalamnya boleh melebar sesukanya. Kalau lebar
  `<table>` melebihi lebar `<div>` pembungkusnya, barulah `overflow-x: auto`
  menampilkan **scrollbar horizontal** otomatis, khusus di dalam area
  tabel itu saja — bukan men-scroll seluruh halaman.

## 4.4 Nilai `auto` pada `overflow-x`

```css
overflow-x: auto;
```

- `overflow-x` mengatur perilaku konten yang melebihi lebar elemen,
  **khusus arah horizontal** (ada juga `overflow-y` untuk arah
  vertikal, dan `overflow` untuk keduanya sekaligus).
- Nilai `auto` berarti: browser **hanya menampilkan** scrollbar kalau
  memang dibutuhkan (isi di dalamnya melebihi lebar kotak). Kalau
  tabelnya cukup sempit untuk muat (misalnya di layar desktop lebar),
  tidak ada scrollbar yang muncul sama sekali — perilaku ini lebih
  ramah dibanding nilai `scroll` yang akan **selalu** menampilkan
  scrollbar meskipun tidak diperlukan.

## 4.5 Kapan Efek Ini Benar-Benar Terlihat?

Berbeda dengan menu hamburger ([bab 3](03-css-hamburger-checkbox-hack.md))
yang baru aktif di breakpoint mobile, aturan `.table-responsive` ini
**selalu aktif** di semua ukuran layar (tidak dibungkus `@media` sama
sekali) — hanya saja efeknya **tidak terlihat** di layar lebar karena
tabelnya memang sudah cukup sempit untuk muat tanpa perlu scroll. Efek
scroll horizontal baru "kelihatan" ketika lebar layar (dan karenanya
lebar `<section>` pembungkus dari
[dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/05-css-main-dan-section.md))
menyempit lebih kecil dari lebar total tabel (5 kolom Daftar Buku, atau
5 kolom Daftar Anggota).

Lanjut ke: [CSS: Media Query & Breakpoint](05-css-media-query-breakpoint.md)
