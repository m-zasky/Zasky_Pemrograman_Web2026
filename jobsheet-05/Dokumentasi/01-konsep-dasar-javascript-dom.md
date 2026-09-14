# 1. Konsep Dasar JavaScript & DOM

Ini pengenalan pertamamu ke JavaScript di seluruh rangkaian jobsheet ini.
Kenali dulu istilah-istilah dasarnya sebelum masuk ke kode `app.js`.

## 1.1 Apa Beda HTML, CSS, dan JavaScript?

Kamu sudah tahu HTML mengatur **struktur/isi**
([dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/01-konsep-dasar.md))
dan CSS mengatur **tampilan**
([dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/README.md)).
**JavaScript (JS)** menambah lapisan ketiga: **perilaku/interaktivitas**
— apa yang terjadi ketika pengguna mengklik sesuatu, mengetik sesuatu,
atau men-submit form. Tiga lapisan ini sengaja dipisah ke file berbeda
(`.html`, `.css`, `.js`) supaya masing-masing bisa diubah tanpa
mengganggu yang lain — prinsip yang sama dengan *separation of concerns*
yang sudah dibahas di
[dokumentasi jobsheet-02 §2.2](../../jobsheet-02/Dokumentasi/02-perubahan-file-html.md#22-kenapa-struktur-html-sengaja-tidak-diubah).

## 1.2 Menghubungkan JavaScript ke HTML

```html
<script src="assets/js/app.js"></script>
```

Bandingkan dengan cara menghubungkan CSS
(`<link rel="stylesheet" href="...">`, lihat
[dokumentasi jobsheet-02 §1.3](../../jobsheet-02/Dokumentasi/01-konsep-dasar-css.md#13-menghubungkan-css-ke-html)) —
untuk JavaScript, tag yang dipakai adalah `<script>`, dengan atribut
`src` menunjuk ke lokasi file `.js`-nya. Perhatikan di setiap halaman
jobsheet ini, tag `<script>` diletakkan **di akhir `<body>`**, tepat
sebelum `</body>` ditutup — bukan di `<head>` seperti `<link>` CSS.
Alasannya dijelaskan di [§1.3](#13-kenapa-script-diletakkan-di-akhir-body).

## 1.3 Kenapa `<script>` Diletakkan di Akhir `<body>`?

Browser membaca dan menjalankan file HTML **dari atas ke bawah, baris
demi baris**. Kalau `<script>` diletakkan di `<head>` (di bagian paling
atas), kode JavaScript akan dijalankan **sebelum** elemen-elemen di
`<body>` (seperti `<button id="nav-toggle-btn">` atau `<table>`) selesai
dibuat oleh browser — akibatnya, kode JS yang mencoba mencari elemen itu
akan gagal karena elemennya belum ada. Dengan meletakkan `<script>` di
**paling akhir** `<body>`, seluruh HTML di atasnya sudah pasti selesai
dibuat browser terlebih dulu sebelum `app.js` mulai dijalankan.

## 1.4 Apa itu DOM?

**DOM (Document Object Model)** adalah representasi halaman HTML dalam
bentuk yang bisa "dibaca dan diubah" oleh JavaScript — bayangkan seluruh
struktur HTML (setiap `<header>`, `<table>`, `<button>`, dst.) diubah
menjadi sebuah "pohon" objek yang bisa dijelajahi dan dimodifikasi lewat
kode. Sub-CPMK jobsheet ini secara eksplisit menyebut "manipulasi DOM &
event" — DOM adalah **objek** yang dimanipulasi, sementara **event**
(dibahas di [§1.6](#16-apa-itu-event-dan-event-listener)) adalah
**pemicu** yang menentukan kapan manipulasi itu terjadi.

## 1.5 Memilih Elemen dari DOM

`app.js` memakai 3 cara berbeda untuk "mengambil" elemen HTML supaya
bisa dimanipulasi:

| Fungsi | Mengambil | Contoh Pemakaian di `app.js` |
|---|---|---|
| `document.getElementById("id")` | **Satu** elemen berdasarkan atribut `id`-nya (harus unik di satu halaman — ingat aturan `id` unik dari [dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#43-pola-setiap-isian-form-label--input)). | `document.getElementById("nav-toggle-btn")` |
| `document.querySelector("selector")` | Elemen **pertama** yang cocok dengan selector CSS (boleh selector apa pun yang sudah kamu kenal dari [dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/01-konsep-dasar-css.md#14-jenis-jenis-selector-yang-dipakai-di-stylecss)). | `document.querySelector("header nav")` |
| `document.querySelectorAll("selector")` | **Semua** elemen yang cocok dengan selector, sebagai kumpulan (bisa diulang satu-satu dengan `.forEach()`). | `document.querySelectorAll(".btn-hapus")` |

Menariknya, `querySelector`/`querySelectorAll` memakai **selector CSS
yang sama persis** dengan yang kamu tulis di `style.css` — ini kabar
baik, artinya kemampuan membaca selector CSS yang sudah kamu kuasai
sejak jobsheet-02 langsung berguna juga untuk menulis JavaScript.

## 1.6 Apa itu Event dan Event Listener?

**Event** adalah "kejadian" yang terjadi di halaman — pengguna
mengklik (`click`), mengetik lalu melepas tombol keyboard (`keyup`),
atau menekan tombol submit form (`submit`). **Event listener** adalah
kode yang "menunggu" kejadian tertentu terjadi pada sebuah elemen, lalu
menjalankan fungsi tertentu sebagai responsnya:

```js
elemen.addEventListener("click", function () {
    // kode ini dijalankan SETIAP KALI elemen di-klik
});
```

Polanya selalu sama: **pilih elemen** (§1.5) → panggil
`.addEventListener(namaEvent, fungsi)` di elemen itu → tulis fungsi yang
berisi apa yang harus terjadi. Tiga event yang dipakai di jobsheet ini:

| Event | Terjadi Saat | Dipakai di |
|---|---|---|
| `click` | Elemen diklik | Tombol hamburger ([bab 4](04-js-hamburger-menu.md)), tombol Hapus ([bab 5](05-js-konfirmasi-hapus.md)) |
| `keyup` | Tombol keyboard dilepas (setelah diketik) | Kolom pencarian ([bab 6](06-js-filter-tabel.md)) |
| `submit` | Form akan dikirim (tombol submit ditekan) | Validasi form ([bab 7](07-js-validasi-form.md)) |

## 1.7 Struktur Umum Kode di `app.js`

Sebelum membedah tiap fitur satu per satu di bab 4-7, perhatikan pola
besar yang diulang di seluruh file:

```js
function initNavToggle() {
    // ambil elemen, pasang event listener
}

// ...fungsi init lain...

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});
```

- Setiap fitur dibungkus dalam **fungsinya sendiri** (`initNavToggle`,
  `initHapusConfirm`, dst.) — kebiasaan menulis kode yang baik supaya
  tiap fitur mudah dibaca terpisah, bukan tercampur semua jadi satu blok
  kode panjang.
- **`document.addEventListener("DOMContentLoaded", ...)`** di baris
  paling bawah adalah "titik masuk" (entry point) seluruh script:
  `DOMContentLoaded` adalah event khusus yang terjadi **setelah seluruh
  HTML selesai dimuat browser** menjadi DOM. Semua fungsi `init...`
  dipanggil di dalamnya untuk memastikan elemen yang mereka cari
  (misalnya `#nav-toggle-btn`) **sudah pasti ada** di DOM saat kode
  dijalankan — lapisan keamanan tambahan di atas penempatan `<script>`
  di akhir `<body>` yang sudah dibahas di [§1.3](#13-kenapa-script-diletakkan-di-akhir-body).
- Perhatikan juga tiap fungsi `init...` di `app.js` selalu diawali
  pengecekan seperti `if (!toggleBtn || !nav) return;` — ini **penjaga
  keamanan** (*guard clause*): kalau elemen yang dicari ternyata tidak
  ada di halaman itu (misalnya halaman tanpa tabel tidak punya elemen
  `.table-responsive table`), fungsinya berhenti lebih awal (`return`)
  alih-alih error karena mencoba memanggil method pada sesuatu yang
  `null`. Berkat penjaga ini, satu file `app.js` yang sama bisa dipakai
  di **semua** halaman (Beranda tanpa tabel, halaman list dengan tabel,
  halaman tambah dengan form) tanpa menimbulkan error di halaman yang
  tidak punya elemen tertentu.

Dengan bekal istilah-istilah ini, sekarang kamu siap membaca perubahan
konkretnya mulai bab 2.

Lanjut ke: [Apa yang Berubah di File HTML?](02-perubahan-file-html.md)
