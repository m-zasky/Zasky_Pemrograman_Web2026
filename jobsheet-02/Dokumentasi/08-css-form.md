# 8. CSS: Styling Form

Bagian ini mempercantik form di `buku/tambah.html` dan
`anggota/tambah.html` (lihat strukturnya di
[dokumentasi HTML jobsheet-01](../../jobsheet-01/dokumentasi/04-buku-tambah-html.md)).

## 8.1 Kode CSS

```css
/* ===== Form ===== */
form p {
    margin-bottom: 1rem;
}

form label {
    display: block;
    margin-bottom: 0.35rem;
    font-weight: 600;
    color: #444;
}

form input,
form select {
    width: 100%;
    max-width: 400px;
    padding: 0.55rem 0.7rem;
    border: 1px solid #cdd4da;
    border-radius: 4px;
    font-size: 1rem;
}

form button[type="submit"] {
    background-color: #1d5b8a;
    color: #fff;
    border: none;
    padding: 0.6rem 1.5rem;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
}

form button[type="submit"]:hover {
    background-color: #164869;
}
```

## 8.2 Jarak Antar Field

```css
form p {
    margin-bottom: 1rem;
}
```

Ingat dari [dokumentasi HTML](../../jobsheet-01/dokumentasi/04-buku-tambah-html.md#43-pola-setiap-isian-form-label--input),
setiap field form dibungkus tag `<p>`. Aturan ini memberi jarak `1rem`
di bawah **setiap** `<p>` di dalam form, sehingga tiap field (Judul,
Pengarang, dst.) punya jarak yang jelas dari field berikutnya, tidak
menempel rapat.

## 8.3 Label sebagai Blok Tersendiri

```css
form label {
    display: block;
    margin-bottom: 0.35rem;
    font-weight: 600;
    color: #444;
}
```

- `display: block;` — secara default, `<label>` adalah elemen *inline*
  (sejajar dengan teks di sekitarnya, tidak otomatis pindah baris).
  Mengubahnya jadi `block` memaksa label **selalu memenuhi satu baris
  penuh**, memastikan input di bawahnya (ingat HTML memakai `<br>`
  setelah label — lihat [dokumentasi HTML §4.3](../../jobsheet-01/dokumentasi/04-buku-tambah-html.md#43-pola-setiap-isian-form-label--input))
  selalu berada tepat di baris baru.
- `margin-bottom: 0.35rem;` — jarak kecil antara teks label dan kotak
  input di bawahnya.
- `font-weight: 600;` — label dibuat agak tebal, supaya nama field
  (misalnya "Judul") lebih menonjol dibanding teks isian biasa,
  membantu pengguna memindai form dengan cepat.
- `color: #444;` — abu-abu gelap, sedikit lebih terang dari warna teks
  body (`#2b2b2b` dari [bab 3](03-css-reset-dan-body.md#32-gaya-dasar-body)),
  memberi variasi warna tanpa kontras berlebihan.

## 8.4 Kotak Input & Dropdown

```css
form input,
form select {
    width: 100%;
    max-width: 400px;
    padding: 0.55rem 0.7rem;
    border: 1px solid #cdd4da;
    border-radius: 4px;
    font-size: 1rem;
}
```

- Selector `form input, form select` (dipisah koma, sama seperti
  `th, td` di [bab 7](07-css-tabel.md#73-sel-header-th-dan-sel-data-td))
  menerapkan gaya yang sama ke **semua** elemen `<input>` (termasuk
  `type="text"` dan `type="number"`) **dan** elemen `<select>` di dalam
  form — mencakup semua field yang dibahas di
  [dokumentasi HTML §4.4](../../jobsheet-01/dokumentasi/04-buku-tambah-html.md#44-jenis-jenis-input-yang-dipakai).
- `width: 100%; max-width: 400px;` — kombinasi ini artinya: lebar input
  mengikuti lebar kotak pembungkusnya (`100%`), **tapi** tidak akan
  pernah melebihi `400px`. Di layar sempit (HP), input akan menyempit
  penuh mengikuti layar; di layar lebar, input tidak akan melebar tak
  wajar sampai selebar section (`1000px` dari [bab 5](05-css-main-dan-section.md)).
- `border: 1px solid #cdd4da;` — garis tepi tipis abu-abu muda,
  menggantikan border bawaan browser yang biasanya lebih tebal/gelap.
- `border-radius: 4px;` dan `padding`/`font-size` — sudut sedikit
  membulat dan ruang yang nyaman di dalam kotak, konsisten dengan gaya
  komponen lain (tombol, kartu) di halaman ini.

**Catatan:** aturan ini **tidak** menyertakan `box-sizing`, tapi karena
di [bab 3](03-css-reset-dan-body.md#31-css-reset-dengan-selector-universal-)
sudah ada `* { box-sizing: border-box; }` yang berlaku untuk semua
elemen, `padding` dan `border` pada input ini otomatis "dimakan" dari
dalam `width: 100%`/`max-width: 400px`, bukan menambah lebar total —
inilah manfaat konkret dari reset di awal file yang sudah dijelaskan di
[bab 3](03-css-reset-dan-body.md).

## 8.5 Tombol Submit

```css
form button[type="submit"] {
    background-color: #1d5b8a;
    color: #fff;
    border: none;
    padding: 0.6rem 1.5rem;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
}

form button[type="submit"]:hover {
    background-color: #164869;
}
```

- **`button[type="submit"]`** adalah **attribute selector** (lihat
  [konsep dasar §1.4](01-konsep-dasar-css.md#14-jenis-jenis-selector-yang-dipakai-di-stylecss)):
  memilih elemen `<button>` yang punya atribut `type` bernilai persis
  `"submit"`. Ini secara khusus menyasar tombol "Simpan" (lihat
  [dokumentasi HTML §4.5](../../jobsheet-01/dokumentasi/04-buku-tambah-html.md#45-tombol-submit)),
  **tanpa** menyentuh tombol Edit/Hapus di tabel yang bertipe
  `type="button"` ([dokumentasi HTML §3.2](../../jobsheet-01/dokumentasi/03-buku-list-html.md#kolom-aksi)) —
  contoh nyata kenapa penulisan `type="button"` secara eksplisit di
  HTML (dibanding membiarkan default) penting: ia menjadi "penanda" yang
  bisa dipakai CSS untuk membedakan jenis tombol.
- Tombol diberi warna biru tema solid, teks putih, tanpa border, dan
  kursor pointer — tampil sebagai tombol aksi utama yang jelas.
- `:hover` mengubah warna jadi biru **lebih gelap** (`#164869` dibanding
  `#1d5b8a`) saat disorot kursor — memberi umpan balik visual yang sama
  konsepnya dengan `a:hover` ([bab 3](03-css-reset-dan-body.md#33-gaya-tautan-a))
  dan `tbody tr:hover` ([bab 7](07-css-tabel.md#75-baris-selang-seling--efek-hover)).

Lanjut ke: [CSS: Footer](09-css-footer.md)
