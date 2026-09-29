# 6. CSS Pendukung Fitur Baru

Beberapa penambahan `style.css` untuk mendukung tautan Edit, form
Hapus, pagination, dan form pencarian yang sudah dibahas di
bab-bab sebelumnya.

## 6.1 Tautan Edit yang Terlihat Seperti Tombol

```css
td button:first-of-type,
td a.btn-edit {
    background-color: #f0ad4e;
    color: #fff;
}

td a.btn-edit {
    display: inline-block;
    padding: 0.35rem 0.7rem;
    margin-right: 0.35rem;
    border-radius: 4px;
    font-size: 0.85rem;
}
```

Ingat dari [bab 2](02-edit-update-data.md), tombol Edit sekarang berupa
tag **`<a>`** (tautan biasa, ke `edit.php?id=...`), **bukan**
`<button>` seperti versi jobsheet-05/06/07/08 (yang belum benar-benar
berfungsi). Masalahnya: `<a>` secara default **tidak terlihat** seperti
tombol — hanya teks biru bergaris bawah (ingat gaya dasar `<a>` dari
[dokumentasi jobsheet-02 §3.3](../../jobsheet-02/Dokumentasi/03-css-reset-dan-body.md#33-gaya-tautan-a)).
Aturan `td a.btn-edit` di sini "menyamarkan" tautan itu supaya terlihat
**identik** dengan tombol Hapus di sebelahnya:

- **`display: inline-block`** — wajib diberikan, karena `<a>` adalah
  elemen *inline* secara default (ingat konsep ini dari
  [dokumentasi jobsheet-02 §8.3](../../jobsheet-02/Dokumentasi/08-css-form.md#83-label-sebagai-blok-tersendiri)) —
  tanpa ini, properti `padding` vertikal pada tautan tidak akan
  memberi ruang yang terlihat seperti tombol sungguhan.
- Sisa propertinya (padding, border-radius, font-size) **disamakan**
  dengan gaya `td button` yang sudah ada sejak
  [dokumentasi jobsheet-02 §7.6](../../jobsheet-02/Dokumentasi/07-css-tabel.md#76-tombol-aksi-edit--hapus).
- Warna oranyenya (`#f0ad4e`) digabung lewat selector `td button:first-of-type, td a.btn-edit` —
  dua selector berbeda (satu untuk kasus lama, satu untuk kasus baru)
  yang **kebetulan** butuh warna sama, digabung jadi satu aturan
  dengan koma (pola yang sama dari
  [dokumentasi jobsheet-02 §7.3](../../jobsheet-02/Dokumentasi/07-css-tabel.md#73-sel-header-th-dan-sel-data-td)).

## 6.2 Form Hapus yang Tidak Merusak Tata Letak

```css
td form.form-hapus {
    display: inline;
}
```

Ingat dari [bab 3](03-hapus-delete-data.md), tombol Hapus sekarang
dibungkus `<form>`. Masalahnya: `<form>` secara default adalah elemen
**block** (memenuhi satu baris penuh, mendorong elemen setelahnya
turun ke baris baru) — kalau dibiarkan begitu, tombol Edit dan form
Hapus yang seharusnya **sejajar** di satu sel `<td>` akan malah
terpisah baris. `display: inline` memaksa `<form>` ini berperilaku
seperti elemen *inline* biasa (mengalir sejajar dengan konten di
sekitarnya, seperti teks biasa), sehingga tautan Edit dan tombol Hapus
tetap terlihat berdampingan seperti sebelumnya.

## 6.3 Navigasi Pagination

```css
.pagination {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
}

.pagination a {
    padding: 0.4rem 0.75rem;
    border: 1px solid #cdd4da;
    border-radius: 4px;
    color: #1d5b8a;
}

.pagination a.active {
    background-color: #1d5b8a;
    color: #fff;
    border-color: #1d5b8a;
}
```

- **`.pagination { display: flex; gap: 0.5rem; }`** — ingat Flexbox
  dari [dokumentasi jobsheet-02 §4](../../jobsheet-02/Dokumentasi/04-css-header-navbar-flexbox.md):
  menyusun semua tautan nomor halaman ([bab 5 §5.9](05-pagination-dan-pencarian-server.md#59-menampilkan-navigasi-halaman))
  sejajar horizontal dengan jarak seragam.
- **`.pagination a`** — setiap nomor halaman diberi bingkai tipis dan
  sudut membulat, terlihat seperti tombol kecil yang bisa diklik.
- **`.pagination a.active`** — selector gabungan (elemen `<a>` **yang
  juga** punya class `active`) memberi warna latar biru tema penuh
  untuk halaman yang **sedang dibuka** — ingat class `active` ini
  ditambahkan lewat PHP di [bab 5 §5.9](05-pagination-dan-pencarian-server.md#59-menampilkan-navigasi-halaman)
  (`$i === $page ? 'active' : ''`), memberi umpan balik visual jelas
  "kamu sedang di halaman ini."

## 6.4 Form Pencarian Sejajar dengan Tombol "Cari"

```css
.search-box form {
    display: flex;
    gap: 0.5rem;
    align-items: flex-end;
}

.search-box button {
    padding: 0.55rem 1.2rem;
    border: none;
    border-radius: 4px;
    background-color: #1d5b8a;
    color: #fff;
    cursor: pointer;
}
```

- **`display: flex; align-items: flex-end;`** — menyusun label+input
  pencarian ([bab 5 §5.8](05-pagination-dan-pencarian-server.md#58-form-pencarian-methodget))
  sejajar horizontal dengan tombol "Cari" di sampingnya.
  `align-items: flex-end` (belum pernah dipakai sebelumnya di
  dokumentasi ini) menyejajarkan kedua elemen berdasarkan **tepi
  bawahnya** — penting di sini karena `<span>` pembungkus label+input
  lebih tinggi (2 baris: label lalu input) dibanding tombol "Cari"
  (1 baris saja), dan tanpa pengaturan ini keduanya akan terlihat
  tidak sejajar rapi secara vertikal.
- **`.search-box button`** — gaya tombol "Cari" dibuat senada dengan
  tombol submit form lain ([dokumentasi jobsheet-02 §8.5](../../jobsheet-02/Dokumentasi/08-css-form.md#85-tombol-submit)),
  warna biru tema solid dengan teks putih.

Lanjut ke: [Rangkuman & Latihan Lanjutan](07-rangkuman-latihan.md)
