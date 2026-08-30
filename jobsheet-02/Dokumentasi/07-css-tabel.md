# 7. CSS: Styling Tabel

Bagian ini mempercantik tabel `<table>` di `buku/list.html` dan
`anggota/list.html` (lihat strukturnya di
[dokumentasi HTML jobsheet-01 §3.2](../../jobsheet-01/dokumentasi/03-buku-list-html.md#32-anatomi-tabel-html)).

## 7.1 Kode CSS

```css
/* ===== Tabel ===== */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    text-align: left;
    padding: 0.65rem 0.75rem;
    border-bottom: 1px solid #e2e6ea;
}

thead {
    background-color: #1d5b8a;
    color: #fff;
}

tbody tr:nth-child(even) {
    background-color: #f7f9fb;
}

tbody tr:hover {
    background-color: #eef4fa;
}

td button {
    padding: 0.35rem 0.7rem;
    margin-right: 0.35rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.85rem;
}

td button:first-of-type {
    background-color: #f0ad4e;
    color: #fff;
}

td button:last-of-type {
    background-color: #d9534f;
    color: #fff;
}
```

## 7.2 Lebar Tabel & `border-collapse`

```css
table {
    width: 100%;
    border-collapse: collapse;
}
```

- `width: 100%;` — tabel melebar memenuhi seluruh lebar kotak
  pembungkusnya (kartu `<section>`, lihat [bab 5](05-css-main-dan-section.md)),
  bukan hanya selebar isi terpanjangnya seperti perilaku default tabel.
- `border-collapse: collapse;` — mengatur agar garis batas (`border`)
  antar sel tabel **digabung menjadi satu garis tipis**, bukan tampil
  sebagai dua garis terpisah dengan jarak di antaranya (perilaku default
  `border-collapse: separate`). Ini yang membuat garis pembatas baris di
  tabel terlihat rapi & tipis, bukan bergaris ganda.

## 7.3 Sel Header (`th`) dan Sel Data (`td`)

```css
th, td {
    text-align: left;
    padding: 0.65rem 0.75rem;
    border-bottom: 1px solid #e2e6ea;
}
```

- Selector `th, td` (dipisah koma) berarti aturan yang sama diterapkan
  ke **kedua** jenis sel sekaligus — cara menyingkat penulisan kalau dua
  selector berbeda butuh gaya identik, daripada menulis dua blok terpisah.
- `text-align: left;` — teks rata kiri. Ini sengaja ditulis eksplisit
  karena `<th>` secara default punya perataan tengah (`center`) di
  kebanyakan browser — aturan ini menyamakan perataan `th` dengan `td`
  supaya kolom judul dan data sejajar rapi.
- `border-bottom: 1px solid #e2e6ea;` — garis tipis abu-abu muda **hanya
  di bagian bawah** tiap sel, memisahkan baris satu dengan baris di
  bawahnya (mirip garis pada tabel excel yang sederhana, tanpa garis
  vertikal antar kolom).

## 7.4 Header Tabel Berwarna

```css
thead {
    background-color: #1d5b8a;
    color: #fff;
}
```

Baris judul kolom (`<thead>`, lihat
[dokumentasi HTML jobsheet-01](../../jobsheet-01/dokumentasi/03-buku-list-html.md#32-anatomi-tabel-html))
diberi latar biru tema yang sama dengan header halaman, dengan teks
putih — menegaskan secara visual bahwa baris ini adalah "judul kolom",
berbeda dari baris-baris data di bawahnya.

## 7.5 Baris Selang-seling & Efek Hover

```css
tbody tr:nth-child(even) {
    background-color: #f7f9fb;
}

tbody tr:hover {
    background-color: #eef4fa;
}
```

- **`tbody tr:nth-child(even)`** — mirip `:nth-of-type(2)` di
  [bab 6](06-css-grid-kartu-statistik.md#63-selector-nth-of-type2--memilih-section-kedua-saja),
  tapi `:nth-child(even)` memilih **semua baris bernomor genap** (baris
  ke-2, ke-4, ke-6, dst.) di dalam `<tbody>`, lalu diberi warna latar
  abu sangat muda (`#f7f9fb`) yang sedikit berbeda dari latar putih
  section. Efek ini disebut **zebra stripes** (garis-garis mirip
  zebra) — teknik desain tabel klasik yang membantu mata pembaca
  **mengikuti satu baris data secara horizontal** tanpa "tersasar" ke
  baris lain, terutama pada tabel dengan banyak kolom.
- **`tbody tr:hover`** — pseudo-class `:hover`, sama konsepnya dengan
  `a:hover` di [bab 3](03-css-reset-dan-body.md#33-gaya-tautan-a): saat
  kursor mouse diarahkan ke atas sebuah baris, latar baris itu berubah
  jadi biru sangat muda (`#eef4fa`, warna yang sama dengan latar kartu
  statistik di [bab 6](06-css-grid-kartu-statistik.md#66-styling-isi-tiap-kartu-article)),
  menandakan baris mana yang sedang "disorot" — berguna terutama saat
  tabel punya banyak baris.

**Catatan penting:** aturan `:hover` ini diletakkan **setelah** aturan
`:nth-child(even)` di file CSS. Karena keduanya punya spesifisitas yang
sama (sama-sama satu pseudo-class ditambah `tr`), urutan penulisan di
file **menentukan** aturan mana yang menang ketika kursor berada di atas
baris genap — dan karena `:hover` ditulis belakangan, warnanya (`#eef4fa`)
yang tampil, menimpa warna zebra stripe (`#f7f9fb`) sementara kursor ada
di situ.

## 7.6 Tombol Aksi (Edit & Hapus)

```css
td button {
    padding: 0.35rem 0.7rem;
    margin-right: 0.35rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.85rem;
}
```

Ini gaya dasar yang berlaku untuk **kedua** tombol (Edit dan Hapus) di
kolom "Aksi" (lihat HTML-nya di
[dokumentasi jobsheet-01](../../jobsheet-01/dokumentasi/03-buku-list-html.md#kolom-aksi)):

- `border: none;` — menghapus garis bingkai/border bawaan tombol HTML
  (biasanya abu-abu 3D ala tombol Windows lama).
- `border-radius: 4px;` — sudut sedikit membulat.
- `cursor: pointer;` — mengubah bentuk kursor mouse menjadi ikon
  "tangan menunjuk" saat berada di atas tombol, memberi sinyal visual
  bahwa elemen ini bisa diklik (tombol HTML biasanya sudah begini secara
  default, tapi baris ini menjamin konsistensi meski gaya lain berubah).
- `margin-right: 0.35rem;` — jarak di sebelah kanan setiap tombol, agar
  tombol "Edit" dan "Hapus" tidak saling menempel.

```css
td button:first-of-type {
    background-color: #f0ad4e;
    color: #fff;
}

td button:last-of-type {
    background-color: #d9534f;
    color: #fff;
}
```

Dua aturan ini membedakan warna **berdasarkan urutan tombol**, bukan
berdasarkan teks/isi tombolnya:

- **`:first-of-type`** — tombol **pertama** di antara tombol-tombol
  sejenis di dalam sel yang sama → diberi warna **oranye/kuning**
  (`#f0ad4e`). Karena di HTML tombol pertama selalu "Edit", maka secara
  visual tombol Edit selalu oranye.
- **`:last-of-type`** — tombol **terakhir** → diberi warna **merah**
  (`#d9534f`), sesuai konvensi umum antarmuka (UI) bahwa warna merah
  menandakan aksi berisiko/merusak seperti "Hapus".

Ini contoh lain dari pola yang sama dengan
[kartu statistik di bab 6](06-css-grid-kartu-statistik.md#67-kenapa-tidak-pakai-class-saja):
CSS "menebak" peran elemen dari **posisinya** dalam HTML (tombol
pertama = Edit, tombol terakhir = Hapus), bukan dari `class` khusus
seperti `class="btn-edit"` atau `class="btn-hapus"`. Cara ini ringkas,
tapi mengasumsikan urutan tombol di HTML **tidak akan berubah** — kalau
suatu saat kamu menambahkan tombol ketiga (misalnya "Detail") di antara
Edit dan Hapus, warnanya bisa jadi tidak sesuai harapan lagi.

Lanjut ke: [CSS: Styling Form](08-css-form.md)
