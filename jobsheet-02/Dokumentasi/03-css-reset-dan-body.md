# 3. CSS: Reset & Gaya Dasar Body

Ini bagian **paling atas** file `style.css` — fondasi yang memengaruhi
seluruh halaman.

## 3.1 CSS Reset dengan Selector Universal `*`

```css
/* ===== Reset & Base ===== */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
```

- `*` adalah **universal selector** — artinya aturan ini berlaku untuk
  **semua elemen HTML** tanpa kecuali (`div`, `p`, `h1`, `button`, dst).
- `margin: 0; padding: 0;` menghapus jarak bawaan (default) yang secara
  otomatis diberikan browser ke banyak elemen (misalnya `<h1>`, `<p>`,
  `<ul>` punya margin bawaan yang berbeda-beda tiap browser). Ini disebut
  **CSS reset** — "menyamakan garis start" supaya tampilan konsisten di
  semua browser, sebelum diatur ulang sesuai keinginan kita sendiri di
  aturan-aturan berikutnya.
- `box-sizing: border-box;` — ini yang paling penting untuk dipahami:
  secara default (`content-box`), kalau kamu mengatur `width: 200px` lalu
  menambahkan `padding: 20px`, lebar **total** kotak yang tampil di layar
  jadi 240px (200 + 20 + 20 kiri-kanan) — membingungkan untuk pemula.
  Dengan `border-box`, `width: 200px` berarti lebar **total** kotak
  (termasuk padding & border) tetap 200px — padding "dimakan" dari dalam.
  Inilah alasan hampir semua developer CSS modern selalu menambahkan
  aturan `box-sizing: border-box;` di awal stylesheet mereka.

Komentar `/* ===== Reset & Base ===== */` di atasnya adalah **komentar
CSS** (diapit `/* ... */`), tidak memengaruhi tampilan sama sekali —
hanya catatan untuk programmer supaya file mudah dinavigasi (bandingkan
dengan komentar HTML `<!-- ... -->`).

## 3.2 Gaya Dasar `<body>`

```css
body {
    font-family: "Segoe UI", Arial, sans-serif;
    color: #2b2b2b;
    background-color: #f5f6f8;
    line-height: 1.5;
}
```

| Properti | Nilai | Penjelasan |
|---|---|---|
| `font-family` | `"Segoe UI", Arial, sans-serif` | Daftar font **berurutan berdasarkan prioritas**: browser mencoba pakai "Segoe UI" dulu; kalau font itu tidak tersedia di komputer pengguna, coba "Arial"; kalau itu juga tidak ada, pakai font `sans-serif` generik apa pun yang tersedia di sistem. Selalu sertakan font generik di akhir daftar sebagai jaminan cadangan (*fallback*). |
| `color` | `#2b2b2b` | Warna **teks**, abu-abu sangat gelap (hampir hitam, tapi tidak hitam pekat `#000` — supaya lebih lembut di mata). |
| `background-color` | `#f5f6f8` | Warna **latar belakang** seluruh halaman, abu-abu sangat muda. |
| `line-height` | `1.5` | Jarak antar baris teks, 1.5 kali tinggi font. Tanpa satuan, artinya kelipatan dari ukuran font elemen itu sendiri. Nilai ini membuat teks lebih nyaman dibaca dibanding default browser (biasanya sekitar `1.2`). |

Karena aturan ini ditempel di selector `body`, dan hampir semua elemen
lain berada **di dalam** `<body>`, properti `font-family`, `color`, dan
`line-height` ini otomatis "diturunkan" (*inherited*) ke elemen anak
seperti `<p>`, `<h2>`, `<td>`, dst., kecuali elemen tersebut diberi
aturan CSS lain yang menimpanya secara spesifik (misalnya `header h1`
punya `font-size` sendiri, dijelaskan di [bab 4](04-css-header-navbar-flexbox.md)).

## 3.3 Gaya Tautan (`<a>`)

```css
a {
    color: #1d5b8a;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
```

- `a { color: #1d5b8a; }` — semua tautan diberi warna biru (senada
  dengan warna header, lihat [bab 4](04-css-header-navbar-flexbox.md)),
  menggantikan warna biru bawaan browser.
- `text-decoration: none;` — menghilangkan garis bawah otomatis yang
  biasanya menyertai tautan, supaya tampilan lebih bersih.
- `a:hover { text-decoration: underline; }` — ini **pseudo-class**
  (lihat [konsep dasar §1.4](01-konsep-dasar-css.md#14-jenis-jenis-selector-yang-dipakai-di-stylecss)):
  garis bawah baru muncul **saat kursor mouse diarahkan (hover)** ke atas
  tautan. Ini memberi umpan balik visual ke pengguna bahwa teks tersebut
  bisa diklik, tanpa membuat tampilan berantakan saat tidak sedang
  disentuh kursor.

Lanjut ke: [CSS: Header & Navbar dengan Flexbox](04-css-header-navbar-flexbox.md)
