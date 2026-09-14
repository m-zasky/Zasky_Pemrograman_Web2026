# 2. Apa yang Berubah di File HTML?

Sebelum membedah `app.js` fungsi per fungsi, kenali dulu perubahan kecil
di HTML yang menjadi "kait" (hook) bagi JavaScript untuk mencari elemen
yang perlu dimanipulasi. Tanpa perubahan-perubahan ini, `app.js` tidak
akan punya elemen yang bisa ditemukan lewat `getElementById`/
`querySelector` (ingat konsepnya dari
[bab 1 §1.5](01-konsep-dasar-javascript-dom.md#15-memilih-elemen-dari-dom)).

## 2.1 Hamburger: dari Checkbox ke Tombol Asli

**Sebelumnya (jobsheet-03),** menu hamburger dibuat dari pasangan
`<input type="checkbox">` + `<label>` (checkbox hack, lihat
[dokumentasi jobsheet-03](../../jobsheet-03/Dokumentasi/03-css-hamburger-checkbox-hack.md)).
**Sekarang:**

```html
<button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>
```

- Elemen `<input type="checkbox">` **dihapus total** — tidak dibutuhkan
  lagi karena status buka/tutup menu sekarang disimpan lewat class CSS
  yang ditambahkan JavaScript, bukan status "tercentang" checkbox
  (dijelaskan detail di [bab 4](04-js-hamburger-menu.md)).
- `<label>` diganti jadi `<button type="button">` — tombol asli yang
  memang dirancang untuk diklik, dengan `id="nav-toggle-btn"` sebagai
  "kait" supaya `document.getElementById("nav-toggle-btn")` di `app.js`
  bisa menemukannya.
- Class `nav-toggle-label` **tetap dipertahankan** namanya (meski
  elemennya sudah bukan `<label>` lagi) supaya gaya CSS yang sudah ada
  (ukuran font, warna, dll. — lihat
  [dokumentasi jobsheet-03 §3.3](../../jobsheet-03/Dokumentasi/03-css-hamburger-checkbox-hack.md#33-langkah-2--label-berperan-sebagai-tombol-pengganti))
  tidak perlu ditulis ulang. Perubahan yang perlu di CSS dibahas di
  [bab 3](03-css-pendukung-javascript.md).
- **`aria-label="Menu"`** adalah atribut baru untuk **aksesibilitas** —
  memberi tahu pembaca layar (*screen reader*) bahwa tombol berisi
  simbol ☰ ini fungsinya adalah "Menu", karena teks `&#9776;` sendiri
  (ingat entity ini dari
  [dokumentasi jobsheet-03 §2.2](../../jobsheet-03/Dokumentasi/02-perubahan-file-html.md#22-pasangan-checkbox--label-untuk-hamburger-menu))
  tidak bermakna apa pun kalau dibacakan sebagai teks biasa.

## 2.2 Kolom Pencarian Baru di Halaman Daftar

Di `buku/list.html` dan `anggota/list.html`, ada `<div>` baru sebelum
tabel:

```html
<div class="search-box">
    <label for="search-input">Cari Judul Buku</label>
    <input type="text" id="search-input" placeholder="Ketik judul buku...">
</div>
```

- Pola `<label for="...">` + `<input id="...">` ini **sama persis**
  dengan pola form yang sudah kamu kuasai sejak
  [dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#43-pola-setiap-isian-form-label--input) —
  meskipun `<input>` ini **tidak berada di dalam `<form>`**, karena
  memang tidak dimaksudkan untuk "disimpan" atau di-submit, hanya untuk
  dibaca nilainya secara langsung oleh JavaScript setiap kali diketik
  (dijelaskan di [bab 6](06-js-filter-tabel.md)).
- Atribut **`placeholder`** adalah atribut HTML yang belum pernah dipakai
  di jobsheet-jobsheet sebelumnya — menampilkan teks abu-abu contoh
  (misalnya "Ketik judul buku...") di dalam kotak input **selama masih
  kosong**, teks itu otomatis hilang begitu pengguna mulai mengetik.
  Beda dengan `value`, teks placeholder **tidak ikut terkirim** kalau
  form di-submit.
- `id="search-input"` adalah "kait" yang dicari
  `document.getElementById("search-input")` di `app.js`
  ([bab 6](06-js-filter-tabel.md)).

## 2.3 Class `btn-hapus` di Tombol Hapus

```html
<button type="button">Edit</button>
<button type="button" class="btn-hapus">Hapus</button>
```

Ingat dari [dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/03-buku-list-html.md#kolom-aksi),
kedua tombol Edit dan Hapus di kolom "Aksi" sejak awal memang belum
berfungsi (`type="button"` tanpa aksi apa pun). Sekarang tombol Hapus
diberi **`class="btn-hapus"`** — bukan untuk keperluan gaya CSS (warnanya
tetap diatur lewat `:last-of-type` seperti dijelaskan di
[dokumentasi jobsheet-02 §7.6](../../jobsheet-02/Dokumentasi/07-css-tabel.md#76-tombol-aksi-edit--hapus)),
melainkan supaya `document.querySelectorAll(".btn-hapus")` di `app.js`
bisa menemukan **semua** tombol Hapus sekaligus di satu halaman
(dijelaskan di [bab 5](05-js-konfirmasi-hapus.md)). Tombol **Edit tidak
diberi class** apa pun karena jobsheet ini memang belum menambahkan
fungsi apa pun untuknya.

## 2.4 `id="form-tambah"` di Form Tambah Buku/Anggota

```html
<form id="form-tambah">
```

Kedua form (`buku/tambah.html` dan `anggota/tambah.html`) sekarang
punya `id="form-tambah"` di tag `<form>`-nya — sebelumnya
([dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#42-elemen-form))
tag `<form>` tidak punya atribut apa pun. `id` ini adalah "kait" yang
dicari `document.getElementById("form-tambah")` supaya JavaScript bisa
memasang **event listener submit** untuk validasi (dijelaskan detail di
[bab 7](07-js-validasi-form.md)). Perhatikan **kedua form** memakai `id`
yang **sama** (`form-tambah`) meskipun field-fieldnya berbeda (Judul/
Pengarang untuk buku, Nama/No. Anggota untuk anggota) — ini aman karena
`id` hanya perlu unik **di dalam satu halaman**, dan kedua form ini
berada di halaman yang berbeda. Cara `app.js` menangani perbedaan field
di kedua form ini dengan **satu fungsi validasi yang sama** dibahas di
[bab 7](07-js-validasi-form.md).

Lanjut ke: [CSS Pendukung Fitur JavaScript](03-css-pendukung-javascript.md)
