# 2. Apa yang Berubah di File HTML?

Sama seperti transisi jobsheet-01 → jobsheet-02
([lihat penjelasan pola ini](../../jobsheet-02/Dokumentasi/02-perubahan-file-html.md#22-kenapa-struktur-html-sengaja-tidak-diubah)),
struktur besar HTML jobsheet-03 **tidak berubah** dari jobsheet-02.
Ada 3 penambahan kecil namun penting di HTML, ditambah beberapa baris CSS
baru murni di `style.css` (dibahas mulai [bab 3](03-css-hamburger-checkbox-hack.md)).

## 2.1 `<meta viewport>`

```html
<meta name="viewport" content="width=device-width, initial-scale=1">
```

Ditambahkan di `<head>` **semua 5 halaman** HTML, tepat di bawah
`<meta charset="UTF-8">`. Penjelasan lengkap kenapa baris ini penting ada
di [konsep dasar §1.2](01-konsep-dasar-responsive.md).

## 2.2 Pasangan Checkbox + Label untuk Hamburger Menu

```html
<header>
    <h1>SIMPUS-Mini</h1>
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="nav-toggle-label">&#9776;</label>
    <nav>
        ...
    </nav>
</header>
```

Dua elemen baru muncul di dalam `<header>`, **sebelum** `<nav>`:

- **`<input type="checkbox" id="nav-toggle" class="nav-toggle">`** —
  sebuah kotak centang (checkbox) biasa. Tapi lewat CSS (dibahas di
  [bab 3](03-css-hamburger-checkbox-hack.md)), checkbox ini akan
  **disembunyikan** dari tampilan — ia dipakai bukan untuk dicentang
  secara visual, melainkan sekadar untuk **menyimpan status**
  "menu sedang terbuka atau tertutup" (dicentang = terbuka).
- **`<label for="nav-toggle" class="nav-toggle-label">&#9776;</label>`** —
  ingat dari
  [dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#43-pola-setiap-isian-form-label--input),
  atribut `for="nav-toggle"` **menghubungkan** label ini ke checkbox
  yang `id`-nya `nav-toggle`. Efeknya: **mengklik label ini sama saja
  dengan mengklik checkbox itu sendiri** — inilah dasar dari teknik
  "checkbox hack" yang dijelaskan lebih detail di
  [bab 3](03-css-hamburger-checkbox-hack.md).
- **`&#9776;`** — ini adalah **HTML entity** berbasis kode numerik
  (mirip `&copy;` atau `&mdash;` yang sudah dibahas di
  [dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/02-index-html.md#footer--kaki-halaman)),
  menampilkan karakter simbol **☰** (tiga garis horizontal, ikon
  "hamburger" yang lazim dipakai untuk menu di layar sempit).

**Penting:** ketiga elemen ini (`h1`, `input`, `label`) semuanya berada
**langsung di dalam `<header>`**, sejajar dengan `<nav>` — bukan di
dalam `<nav>`. Susunan ini sengaja dipilih supaya CSS bisa memanfaatkan
**sibling combinator** (`~`) antara checkbox dan `<nav>`, dijelaskan
detail mekanismenya di [bab 3](03-css-hamburger-checkbox-hack.md).

## 2.3 Pembungkus `<div class="table-responsive">`

Di `buku/list.html` dan `anggota/list.html`, tabel yang sebelumnya berdiri
sendiri (lihat [dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/03-buku-list-html.md#32-anatomi-tabel-html))
sekarang dibungkus satu `<div>` tambahan:

```html
<div class="table-responsive">
<table>
    ...
</table>
</div>
```

`<div>` di sini dipakai murni sebagai **pembungkus teknis** untuk
keperluan styling (`overflow-x: auto`, dibahas di
[bab 4](04-css-table-responsive.md)) — beda dengan tag semantic
(`header`, `section`, `article`, dst. dari
[dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/01-konsep-dasar.md#13-tag-semantic-html5))
yang membawa makna konten. `<div>` memang **sengaja tidak** punya makna
semantic — ia hanya "kotak polos" yang dipakai ketika kita butuh
target CSS/JS tanpa perlu tag khusus. Class `table-responsive` di sini
adalah nama yang **kita buat sendiri** (bukan nama bawaan HTML), dipilih
supaya mudah dibaca maksudnya: "tabel yang sudah dibuat responsif".

Lanjut ke: [CSS: Menu Hamburger dengan Checkbox Hack](03-css-hamburger-checkbox-hack.md)
