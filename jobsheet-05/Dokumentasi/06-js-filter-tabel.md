# 6. JS: Filter Tabel Real-Time

Fungsi ini menghubungkan kolom pencarian baru
([bab 2 §2.2](02-perubahan-file-html.md#22-kolom-pencarian-baru-di-halaman-daftar))
dengan tabel di bawahnya, menyaring baris **sambil** pengguna mengetik —
tanpa tombol "Cari" terpisah, tanpa reload halaman.

## 6.1 Kode Lengkap

```js
// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}
```

## 6.2 Mengambil Kotak Input dan Tabelnya

```js
const input = document.getElementById("search-input");
const table = document.querySelector(".table-responsive table");
```

- `input` — kotak pencarian, dicari lewat `id="search-input"` (ingat
  dari [bab 2 §2.2](02-perubahan-file-html.md#22-kolom-pencarian-baru-di-halaman-daftar)).
- `table` — dicari dengan selector `".table-responsive table"`,
  descendant selector yang mengambil elemen `<table>` di dalam `<div
  class="table-responsive">` (ingat wrapper ini dari
  [dokumentasi jobsheet-03](../../jobsheet-03/Dokumentasi/04-css-table-responsive.md)).
  Selector ini sengaja **spesifik** (bukan cuma `"table"`) supaya kalau
  suatu saat ada tabel lain di halaman yang sama untuk keperluan
  berbeda, fungsi ini tidak salah sasaran.
- Guard clause `if (!input || !table) return;` — pola yang sama persis
  dengan [bab 4 §4.3](04-js-hamburger-menu.md#43-penjaga-keamanan-guard-clause),
  memastikan fungsi ini aman dipanggil di halaman mana pun (termasuk
  Beranda yang tidak punya kolom pencarian maupun tabel sama sekali).

## 6.3 Event `keyup`: Bereaksi Setiap Ketikan

```js
input.addEventListener("keyup", function () {
    // ...
});
```

Ingat dari [bab 1 §1.6](01-konsep-dasar-javascript-dom.md#16-apa-itu-event-dan-event-listener),
event `keyup` terjadi setiap kali sebuah tombol keyboard **dilepas**
(setelah ditekan) saat fokus berada di elemen `input`. Karena event ini
terpicu untuk **setiap huruf** yang diketik (bukan menunggu pengguna
menekan Enter atau tombol "Cari"), efeknya terasa seperti pencarian
"real-time" — tabel langsung tersaring seiring pengguna mengetik.

## 6.4 Mengambil Kata Kunci Pencarian

```js
const keyword = input.value.toLowerCase();
```

- **`input.value`** — nilai/teks yang **sedang** diketik di dalam kotak
  input saat ini (berbeda dengan `placeholder` dari
  [bab 2 §2.2](02-perubahan-file-html.md#22-kolom-pencarian-baru-di-halaman-daftar)
  yang hanya teks contoh, bukan nilai sungguhan).
- **`.toLowerCase()`** — mengubah semua huruf jadi huruf kecil. Ini
  penting supaya pencarian **tidak peka huruf besar/kecil** (*case-
  insensitive*) — mengetik "laskar" tetap menemukan "Laskar Pelangi"
  meskipun huruf "L"-nya besar di data aslinya.

## 6.5 Mengulang Setiap Baris Tabel

```js
const rows = table.querySelectorAll("tbody tr");
rows.forEach(function (row) {
    const teks = row.textContent.toLowerCase();
    row.style.display = teks.includes(keyword) ? "" : "none";
});
```

- `table.querySelectorAll("tbody tr")` — mengambil **semua** baris data
  (ingat dari [dokumentasi jobsheet-01 §3.2](../../jobsheet-01/Dokumentasi/03-buku-list-html.md#32-anatomi-tabel-html),
  baris data berada di dalam `<tbody>`, terpisah dari baris judul kolom
  di `<thead>` — sehingga baris judul **tidak ikut** disaring/
  disembunyikan).
- Untuk **setiap** baris, `row.textContent` mengambil **seluruh teks**
  di dalam baris itu (gabungan semua sel `<td>`-nya jadi satu string
  panjang, termasuk teks tombol "Edit"/"Hapus" di dalamnya), lalu
  diubah ke huruf kecil juga (`.toLowerCase()`) supaya konsisten dengan
  `keyword`.
- **`teks.includes(keyword)`** — mengembalikan `true` kalau `teks`
  **mengandung** `keyword` di bagian mana pun (bukan harus sama persis
  dari awal). Contoh: `"laskar pelangi andrea hirata 2005 4"
  .includes("hirata")` bernilai `true`.
- **`row.style.display = ... ? "" : "none";"`** — mengatur properti CSS
  `display` **langsung dari JavaScript**:
  - Kalau `teks.includes(keyword)` bernilai `true` (baris cocok) →
    `row.style.display = ""` — mengosongkan nilai `display` supaya
    kembali ke perilaku default tabel (baris tampil normal).
  - Kalau `false` (tidak cocok) → `row.style.display = "none"` — baris
    **disembunyikan** total dari tampilan.

## 6.6 Kenapa Baris Disembunyikan, Bukan Dihapus?

Perhatikan fungsi ini memakai `row.style.display = "none"`, **bukan**
`row.remove()` seperti pada tombol Hapus di
[bab 5 §5.6](05-js-konfirmasi-hapus.md#56-menghapus-baris-dari-tampilan).
Ini perbedaan penting: `.remove()` **menghapus permanen** elemen dari
DOM (perlu dibuat ulang untuk memunculkannya lagi), sedangkan
`style.display = "none"` hanya **menyembunyikan sementara** — elemennya
tetap ada di DOM, hanya tidak terlihat. Ini pilihan yang tepat untuk
fitur pencarian: begitu pengguna **menghapus** teks di kolom cari
(kembali kosong), fungsi ini berjalan lagi dan `keyword` jadi string
kosong (`""`) — dan **setiap** teks baris pasti "mengandung" string
kosong (`teks.includes("")` selalu `true`), sehingga **semua baris
otomatis muncul kembali** tanpa perlu logika tambahan apa pun.

Lanjut ke: [JS: Validasi Form](07-js-validasi-form.md)
