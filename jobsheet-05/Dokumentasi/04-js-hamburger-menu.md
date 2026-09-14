# 4. JS: Menu Hamburger

Fungsi pertama di `app.js`, dan yang paling sederhana — cocok jadi titik
awal belajar membaca kode JavaScript.

## 4.1 Kode Lengkap

```js
// ===== Hamburger menu (JS-driven, menggantikan checkbox hack) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}
```

## 4.2 Mengambil Dua Elemen yang Dibutuhkan

```js
const toggleBtn = document.getElementById("nav-toggle-btn");
const nav = document.querySelector("header nav");
```

- `const` adalah kata kunci untuk mendeklarasikan sebuah **variabel**
  (tempat menyimpan nilai) yang nilainya **tidak akan diganti** lagi
  setelah didefinisikan — cocok dipakai di sini karena `toggleBtn` dan
  `nav` selalu merujuk ke elemen yang sama sepanjang fungsi ini berjalan.
- `toggleBtn` diisi dengan tombol hamburger (`id="nav-toggle-btn"`,
  ingat dari [bab 2 §2.1](02-perubahan-file-html.md#21-hamburger-dari-checkbox-ke-tombol-asli)).
- `nav` diisi dengan elemen `<nav>` yang berada di dalam `<header>` —
  memakai selector CSS `"header nav"` yang **persis sama** dengan
  descendant selector yang sudah kamu kenal dari
  [dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/01-konsep-dasar-css.md#14-jenis-jenis-selector-yang-dipakai-di-stylecss).

## 4.3 Penjaga Keamanan (Guard Clause)

```js
if (!toggleBtn || !nav) return;
```

- Tanda seru `!` di depan sebuah nilai berarti **kebalikan/negasi** —
  `!toggleBtn` bernilai benar (*true*) kalau `toggleBtn` adalah `null`
  (tidak ditemukan elemennya).
- `||` berarti **atau** — kondisi ini benar kalau **salah satu saja**
  dari `toggleBtn` atau `nav` tidak ditemukan.
- Kalau kondisi ini benar, `return;` menghentikan fungsi **sebelum**
  baris berikutnya (`toggleBtn.addEventListener(...)`) sempat dijalankan
  — mencegah error "Cannot read properties of null" yang akan muncul
  kalau kita mencoba memanggil `.addEventListener` pada nilai `null`.

Baris ini persis konsep yang sudah disinggung di
[dokumentasi jobsheet-05 §1.7](01-konsep-dasar-javascript-dom.md#17-struktur-umum-kode-di-appjs):
karena `app.js` yang sama dimuat di **semua** halaman lewat
`<script src="assets/js/app.js">`, dan fungsi ini dipanggil di semua
halaman itu juga (lihat [bab 1 §1.7](01-konsep-dasar-javascript-dom.md#17-struktur-umum-kode-di-appjs)),
guard clause ini memastikan kode tidak akan error meskipun (secara
hipotetis) suatu halaman ternyata tidak punya tombol hamburger.

## 4.4 Memasang Event Listener

```js
toggleBtn.addEventListener("click", function () {
    nav.classList.toggle("nav-open");
});
```

- `toggleBtn.addEventListener("click", ...)` — ingat pola ini dari
  [bab 1 §1.6](01-konsep-dasar-javascript-dom.md#16-apa-itu-event-dan-event-listener):
  "setiap kali tombol ini diklik, jalankan fungsi berikut."
- **`nav.classList`** adalah objek yang mewakili **daftar semua class**
  yang dimiliki elemen `nav` saat ini (mirip atribut `class="..."` di
  HTML, tapi dalam bentuk yang bisa diprogram).
- **`.toggle("nav-open")`** adalah method yang **membalik status** satu
  class tertentu:
  - Kalau elemen `nav` **belum** punya class `nav-open` → class itu
    **ditambahkan**.
  - Kalau elemen `nav` **sudah** punya class `nav-open` → class itu
    **dihapus**.

Inilah kenapa satu fungsi klik yang sama bisa dipakai untuk **membuka
dan menutup** menu secara bergantian — kita tidak perlu menulis kondisi
`if/else` manual untuk mengecek status sebelumnya, `classList.toggle()`
sudah menangani logika bolak-balik itu secara otomatis.

## 4.5 Menghubungkan Kembali ke CSS

Ingat dari [bab 3 §3.1](03-css-pendukung-javascript.md#31-hamburger-dari-nav-toggle-ke-tombol-asli),
CSS di dalam `@media (max-width: 480px)` punya aturan:

```css
header nav.nav-open {
    display: block;
}
```

Alur lengkapnya sekarang:

1. Pengguna mengklik tombol hamburger (`#nav-toggle-btn`).
2. Event listener `click` di [§4.4](#44-memasang-event-listener) terpicu.
3. `nav.classList.toggle("nav-open")` menambahkan class `nav-open` ke
   elemen `<nav>`.
4. CSS `header nav.nav-open { display: block; }` otomatis berlaku
   karena elemen `<nav>` sekarang cocok dengan selector itu → menu
   **muncul**.
5. Klik tombol sekali lagi → `classList.toggle()` **menghapus** class
   `nav-open` → elemen `<nav>` tidak lagi cocok dengan selector CSS
   tadi → menu kembali ke `display: none` dari gaya dasarnya → menu
   **tersembunyi lagi**.

## 4.6 Bandingkan dengan Checkbox Hack (Jobsheet-03)

| | Checkbox Hack (Jobsheet-03) | JS-Driven (Jobsheet-05) |
|---|---|---|
| Penyimpan status | Atribut `checked` pada `<input type="checkbox">` tersembunyi | Class `nav-open` pada elemen `<nav>` |
| Yang mengubah status | Browser secara otomatis (perilaku bawaan checkbox) | Kode JavaScript (`classList.toggle`) |
| Selector CSS | `.nav-toggle:checked ~ nav` (pseudo-class + sibling combinator) | `header nav.nav-open` (selector class biasa) |
| Butuh JavaScript? | Tidak sama sekali | Ya |

Checkbox hack ([dokumentasi jobsheet-03](../../jobsheet-03/Dokumentasi/03-css-hamburger-checkbox-hack.md))
tetap merupakan trik CSS yang sah dan berguna terutama saat JavaScript
belum dipelajari/tersedia. Tapi begitu JavaScript masuk (seperti di
jobsheet ini), pendekatan berbasis `classList` biasanya **lebih mudah
dibaca dan dikembangkan** — tidak perlu memahami sibling combinator
untuk sekadar tahu "menu ini sedang terbuka atau tertutup", cukup
periksa ada-tidaknya satu class.

Lanjut ke: [JS: Konfirmasi Hapus](05-js-konfirmasi-hapus.md)
