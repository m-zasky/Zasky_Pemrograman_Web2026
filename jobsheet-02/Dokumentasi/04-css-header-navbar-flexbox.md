# 4. CSS: Header & Navbar dengan Flexbox

Bagian ini adalah pengenalan pertama ke **Flexbox** — salah satu sistem
tata letak (*layout*) terpenting di CSS modern.

## 4.1 Kode CSS

```css
/* ===== Header & Navbar (Flexbox) ===== */
header {
    background-color: #1d5b8a;
    color: #fff;
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}

header h1 {
    font-size: 1.4rem;
}

header nav ul {
    list-style: none;
    display: flex;
    gap: 1.25rem;
}

header nav a {
    color: #fff;
    font-weight: 500;
}
```

## 4.2 Apa itu Flexbox?

Secara default, elemen HTML seperti `<h1>` dan `<nav>` di dalam `<header>`
akan tersusun **vertikal** (bertumpuk ke bawah), karena keduanya adalah
elemen *block*. Padahal yang kita inginkan: judul "SIMPUS-Mini" di kiri,
menu navigasi di kanan, **sejajar dalam satu baris horizontal**. Di sinilah
Flexbox berperan — sistem tata letak 1 dimensi yang mengatur bagaimana
elemen-elemen anak tersusun di dalam sebuah kotak pembungkus.

## 4.3 Mengaktifkan Flexbox: `display: flex`

```css
header {
    display: flex;
    ...
}
```

Menuliskan `display: flex;` pada `<header>` mengubah `<header>` menjadi
**flex container**, dan **semua anak langsung**-nya (di sini: `<h1>` dan
`<nav>`) otomatis menjadi **flex item** yang tersusun sejajar secara
horizontal (default-nya), bukan bertumpuk vertikal lagi.

## 4.4 Mengatur Posisi Flex Item

| Properti | Nilai | Efek |
|---|---|---|
| `align-items: center;` | — | Menyejajarkan flex item secara **vertikal di tengah** sumbu silang (*cross axis*) — supaya `<h1>` dan `<nav>` sama-sama center secara vertikal meski tingginya berbeda. |
| `justify-content: space-between;` | — | Mengatur jarak antar flex item pada sumbu utama (*main axis*, horizontal). `space-between` mendorong item **pertama menempel di ujung kiri**, item **terakhir menempel di ujung kanan**, dan sisa ruang kosong dibagi rata di antaranya. Inilah yang membuat `<h1>` di kiri dan `<nav>` di kanan header. |
| `flex-wrap: wrap;` | — | Mengizinkan flex item **pindah ke baris baru** kalau ruang tidak cukup (misalnya di layar HP yang sempit), daripada dipaksa muat dalam satu baris sampai terpotong/menyempit berlebihan. |

## 4.5 Padding pada Header

```css
padding: 1rem 1.5rem;
```

CSS memperbolehkan menulis 2 nilai sekaligus pada properti `padding`
(atau `margin`): nilai **pertama untuk atas-bawah**, nilai **kedua untuk
kiri-kanan**. Jadi `1rem 1.5rem` berarti padding atas & bawah `1rem`,
padding kiri & kanan `1.5rem`. Ini cara singkat menulis 4 nilai berbeda
tanpa harus menulis `padding-top`, `padding-right`, `padding-bottom`,
`padding-left` satu per satu.

## 4.6 Flexbox Bertingkat: Navbar di Dalam Header

Menariknya, Flexbox dipakai **dua kali bertingkat** di sini — sekali di
`<header>` (menyusun `h1` & `nav` horizontal), dan sekali lagi di dalam
`<nav> <ul>` untuk menyusun **item-item menu**:

```css
header nav ul {
    list-style: none;
    display: flex;
    gap: 1.25rem;
}
```

- **`header nav ul`** — descendant selector (lihat
  [konsep dasar §1.4](01-konsep-dasar-css.md#14-jenis-jenis-selector-yang-dipakai-di-stylecss)):
  memilih elemen `<ul>` yang berada di dalam `<nav>` yang berada di
  dalam `<header>`.
- `list-style: none;` — menghapus bulatan/titik (bullet point) bawaan
  daftar `<ul>`, karena di navbar kita tidak butuh tampilan bullet list.
- `display: flex;` — mengubah `<ul>` (yang isinya `<li>` per item menu)
  jadi flex container juga, sehingga semua `<li>` tersusun sejajar
  horizontal alih-alih bertumpuk vertikal seperti daftar biasa.
- `gap: 1.25rem;` — properti modern Flexbox/Grid untuk memberi **jarak
  seragam** antar flex item, tanpa perlu mengatur `margin` manual di
  tiap item satu-satu.

```css
header nav a {
    color: #fff;
    font-weight: 500;
}
```

Ini menimpa (*override*) warna tautan bawaan (`a { color: #1d5b8a; }`
dari [bab 3](03-css-reset-dan-body.md#33-gaya-tautan-a)) **khusus untuk
tautan di dalam navbar** — supaya teks menu berwarna putih (`#fff`),
kontras dengan latar belakang header yang biru tua. `font-weight: 500`
membuat teksnya sedikit lebih tebal dari normal (`400`) tapi belum
setebal `bold` (`700`).

## 4.7 Kenapa Selector `header nav a` Lebih "Menang" daripada `a`?

Ini contoh sederhana konsep **spesifisitas CSS** (*specificity*):
selector yang lebih spesifik/detail (`header nav a`, menyebutkan 3 tag
bersarang) mengalahkan selector yang lebih umum (`a`, hanya 1 tag),
**tanpa memedulikan urutan penulisan di file**. Jadi meskipun aturan
`a { color: #1d5b8a; }` ditulis lebih dulu di file, aturan `header nav a`
tetap yang menentukan warna tautan di dalam navbar, karena lebih
spesifik.

Lanjut ke: [CSS: Layout `main` & `section`](05-css-main-dan-section.md)
