# 6. Rangkuman & Latihan Lanjutan

## 6.1 Rangkuman Keseluruhan Jobsheet 3

| Bagian | Lokasi Kode | Konsep yang Dipelajari |
|---|---|---|
| [Konsep Dasar](01-konsep-dasar-responsive.md) | — | Responsive design, `<meta viewport>`, media query, breakpoint, strategi desktop-first |
| [Perubahan HTML](02-perubahan-file-html.md) | Semua file `.html` | Tag viewport, pasangan `input[checkbox]`+`label`, `<div class="table-responsive">` |
| [Hamburger Checkbox Hack](03-css-hamburger-checkbox-hack.md) | `.nav-toggle`, `.nav-toggle-label`, `.nav-toggle:checked ~ nav` | Sibling combinator `~`, pseudo-class `:checked`, interaktivitas murni CSS tanpa JavaScript |
| [Tabel Responsif](04-css-table-responsive.md) | `.table-responsive` | `overflow-x: auto`, pola wrapper `<div>` untuk scroll horizontal |
| [Media Query & Breakpoint](05-css-media-query-breakpoint.md) | `@media (max-width: 768px)`, `@media (max-width: 480px)` | Sintaks `@media`, breakpoint tablet/mobile, override berbasis urutan penulisan |

## 6.2 Konsep Inti yang Perlu Diingat

1. **`<meta name="viewport">` adalah syarat wajib** untuk responsive
   design — tanpanya, seluruh media query di CSS tidak akan bekerja
   sebagaimana mestinya di HP karena browser mobile akan menganggap
   lebar layar 980px ([bab 1](01-konsep-dasar-responsive.md#12-meta-nameviewport--supaya-browser-hp-tidak-berbohong)).
2. **CSS bisa dibuat interaktif tanpa JavaScript**, memanfaatkan
   pseudo-class state bawaan seperti `:checked` (checkbox hack) yang
   dikombinasikan dengan sibling combinator `~`
   ([bab 3](03-css-hamburger-checkbox-hack.md)). Ini teknik yang
   berguna untuk interaksi sederhana, meski untuk kasus lebih kompleks
   JavaScript tetap lebih fleksibel (disinggung di
   [README.md](../README.md) jobsheet ini — akan diganti JavaScript di
   Jobsheet 5).
3. **`overflow-x: auto` pada `<div>` pembungkus** adalah pola umum
   menangani tabel/konten lebar di layar sempit tanpa merusak tata letak
   halaman lain ([bab 4](04-css-table-responsive.md)).
4. **Media query menimpa gaya dasar berdasarkan urutan penulisan**
   ketika spesifisitas selectornya sama — karena itu breakpoint di
   jobsheet ini sengaja diletakkan di **bagian paling bawah** file
   ([bab 5](05-css-media-query-breakpoint.md)).
5. **Desktop-first vs mobile-first** adalah dua strategi menulis CSS
   responsif; jobsheet ini memakai desktop-first (`max-width`), lawan
   dari mobile-first (`min-width`) — keduanya valid, pilihannya
   tergantung kebiasaan tim/proyek
   ([bab 1 §1.5](01-konsep-dasar-responsive.md#15-pendekatan-desktop-first-yang-dipakai-di-jobsheet-ini)).

## 6.3 Cara Mencoba Sendiri

1. Ikuti langkah pengujian DevTools di
   [bab 5 §5.6](05-css-media-query-breakpoint.md#56-cara-menguji-sendiri-di-browser).
2. Di DevTools mode responsif, coba **ubah lebar layar perlahan** sambil
   mengamati kartu statistik — perhatikan tepat di angka 768px dan 480px
   susunannya "patah" ke jumlah kolom yang berbeda. Ini adalah efek
   breakpoint yang bekerja tepat di titik yang ditentukan.
3. Klik ikon hamburger ☰ berkali-kali di mode mobile, amati bahwa menu
   terbuka/tertutup **tanpa reload halaman** — buktikan sendiri bahwa
   ini murni CSS dengan membuka tab **Console** DevTools; tidak akan
   ada log/error JavaScript apa pun yang terpicu dari interaksi ini.

## 6.4 Ide Latihan Tambahan (Opsional)

1. **Tambah breakpoint baru** — misalnya `@media (min-width: 1400px)`
   untuk layar monitor sangat lebar, ubah `main { max-width: 1000px; }`
   (dari [dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/05-css-main-dan-section.md#52-membatasi-lebar--menengahkan-konten-main))
   menjadi lebih lebar khusus di breakpoint ini.
2. **Ubah breakpoint tablet** dari `768px` menjadi `900px`, lalu amati
   di lebar layar berapa susunan kartu berubah — buktikan bahwa breakpoint
   memang bisa disesuaikan bebas sesuai kebutuhan desain.
3. **Terapkan pola `table-responsive`** ke elemen lain yang berpotensi
   melebar di layar sempit, misalnya kalau suatu saat kamu menambahkan
   blok kode `<pre>` yang panjang di salah satu halaman.
4. **Ubah posisi ikon hamburger** — misalnya pindahkan `.nav-toggle-label`
   ke urutan terakhir di `<header>` (setelah `<nav>`) lalu amati apakah
   sibling combinator `.nav-toggle:checked ~ nav` di
   [bab 3 §3.5](03-css-hamburger-checkbox-hack.md#35-langkah-4--sibling-combinator-menghubungkan-status-ke-nav)
   masih bekerja — ingat catatan bahwa combinator `~` mensyaratkan
   target berada **setelah** elemen sumbernya di HTML.
5. **Bandingkan dengan pendekatan mobile-first** — coba tulis ulang
   `style.css` dari nol memakai `@media (min-width: ...)` alih-alih
   `max-width`, dan rasakan sendiri bedanya alur berpikirnya.

Kalau ada bagian yang masih membingungkan, terutama soal sibling
combinator dan checkbox hack, coba baca ulang
[bab 3](03-css-hamburger-checkbox-hack.md) sambil mempraktikkan langsung
di DevTools — konsep ini jauh lebih mudah dipahami dengan mencoba klik
ikon hamburger sambil melihat panel **Elements** DevTools berubah
menampilkan/menyembunyikan atribut `checked` pada checkbox-nya secara
langsung.
