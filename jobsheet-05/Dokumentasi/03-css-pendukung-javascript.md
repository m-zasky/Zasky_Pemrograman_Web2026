# 3. CSS Pendukung Fitur JavaScript

Beberapa baris `style.css` berubah atau ditambah, semuanya untuk
mendukung fitur JavaScript baru di [bab 4](04-js-hamburger-menu.md)
sampai [bab 7](07-js-validasi-form.md). Bab ini membahas perubahan CSS
itu **sebelum** masuk ke JavaScript-nya sendiri, supaya alurnya runtut.

## 3.1 Hamburger: dari `.nav-toggle` ke Tombol Asli

**Dihapus** dari `style.css`:
```css
.nav-toggle {
    display: none;
}
```
Aturan ini dulu menyembunyikan elemen `<input type="checkbox">` (lihat
[dokumentasi jobsheet-03 §3.2](../../jobsheet-03/Dokumentasi/03-css-hamburger-checkbox-hack.md#32-langkah-1--sembunyikan-checkbox-aslinya)).
Karena elemen checkbox-nya sendiri sudah dihapus dari HTML
([bab 2 §2.1](02-perubahan-file-html.md#21-hamburger-dari-checkbox-ke-tombol-asli)),
aturan CSS untuk menyembunyikannya juga tidak diperlukan lagi.

**Ditambah** ke `.nav-toggle-label` (yang sekarang menata elemen
`<button>`, bukan `<label>`):
```css
.nav-toggle-label {
    display: none;
    font-size: 1.6rem;
    color: #fff;
    background: none;
    border: none;
    cursor: pointer;
}
```
Dua baris baru, `background: none;` dan `border: none;`, **tidak
diperlukan** saat elemennya masih `<label>` (label tidak punya latar
atau bingkai bawaan), tapi **wajib** sekarang karena elemennya adalah
`<button>` — dan tombol HTML secara default punya latar abu-abu dan
bingkai 3D bawaan browser. Tanpa dua baris ini, tombol hamburger akan
terlihat seperti kotak abu-abu biasa, bukan ikon ☰ polos yang menyatu
dengan warna header biru.

**Berubah** di dalam `@media (max-width: 480px)`:
```css
header nav.nav-open {
    display: block;
}
```
Sebelumnya (jobsheet-03): `.nav-toggle:checked ~ nav { display: block; }`
— selector berbasis **status checkbox** (`:checked`) dan **sibling
combinator** `~` (ingat konsepnya dari
[dokumentasi jobsheet-03 §3.5](../../jobsheet-03/Dokumentasi/03-css-hamburger-checkbox-hack.md#35-langkah-4--sibling-combinator-menghubungkan-status-ke-nav)).
Sekarang selector-nya jauh lebih sederhana: **`header nav.nav-open`** —
elemen `<nav>` di dalam `<header>` yang **punya class `nav-open`**.
Tidak ada lagi pseudo-class atau sibling combinator sama sekali, karena
status "menu terbuka" sekarang murni ditentukan oleh **ada atau
tidaknya** class `nav-open` — dan yang menambah/menghapus class itu
adalah JavaScript (dijelaskan di [bab 4](04-js-hamburger-menu.md)), bukan
lagi status tercentang sebuah checkbox tersembunyi.

## 3.2 Gaya Baru: Pesan Error Validasi

```css
/* ===== Pesan Error Validasi ===== */
.error {
    display: block;
    color: #d9534f;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}
```

Class `error` ini **belum ada** di HTML manapun secara statis — class
ini akan **dibuat dan disisipkan sepenuhnya oleh JavaScript** setiap
kali validasi form gagal (dijelaskan detail di
[bab 7](07-js-validasi-form.md)). CSS ini menyiapkan **bagaimana rupanya**
kalau/ketika elemen `<span class="error">` itu benar-benar muncul nanti:

- `display: block;` — memastikan pesan error tampil di **baris baru**
  sendiri, di bawah kotak input, bukan menempel sejajar di sampingnya
  (ingat elemen `<span>` secara default bersifat *inline*, sama seperti
  pembahasan `display: block` pada `<label>` di
  [dokumentasi jobsheet-02 §8.3](../../jobsheet-02/Dokumentasi/08-css-form.md#83-label-sebagai-blok-tersendiri)).
- `color: #d9534f;` — warna merah, sama persis dengan warna tombol
  Hapus ([dokumentasi jobsheet-02 §7.6](../../jobsheet-02/Dokumentasi/07-css-tabel.md#76-tombol-aksi-edit--hapus)) —
  konsisten menandakan "sesuatu yang perlu perhatian/tindakan" di
  seluruh aplikasi.
- `font-size: 0.85rem;` dan `margin-top: 0.25rem;` — teks sedikit lebih
  kecil dari input di atasnya, dengan jarak tipis supaya terlihat jelas
  sebagai keterangan tambahan, bukan menyatu dengan input.

## 3.3 Gaya Baru: Kolom Pencarian

```css
/* ===== Kolom Pencarian ===== */
.search-box {
    margin-bottom: 1rem;
}

.search-box input {
    width: 100%;
    max-width: 320px;
    padding: 0.5rem 0.75rem;
    border: 1px solid #cdd4da;
    border-radius: 4px;
}
```

- `.search-box { margin-bottom: 1rem; }` memberi jarak antara kotak
  pencarian dan tabel di bawahnya.
- `.search-box input` menata kotak input pencarian mirip gaya input
  form yang sudah kamu kenal dari
  [dokumentasi jobsheet-02 §8.4](../../jobsheet-02/Dokumentasi/08-css-form.md#84-kotak-input--dropdown) —
  border tipis, sudut membulat, padding nyaman — hanya saja `max-width`
  dibuat lebih sempit (`320px`, dibanding `400px` pada input form) karena
  kolom pencarian memang tidak perlu selebar field form biasa.

Dengan CSS sudah siap menyambut elemen-elemen baru ini, sekarang saatnya
membedah JavaScript yang benar-benar menggerakkannya, dimulai dari menu
hamburger.

Lanjut ke: [JS: Menu Hamburger](04-js-hamburger-menu.md)
