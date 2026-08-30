# 1. Konsep Dasar yang Dipakai di Jobsheet Ini

Sebelum masuk ke penjelasan tiap file, kenali dulu istilah-istilah yang
akan terus muncul di semua file HTML jobsheet ini.

## 1.1 Apa itu "tag" dan "elemen"?

HTML ditulis memakai **tag** yang biasanya berpasangan: tag pembuka
`<namatag>` dan tag penutup `</namatag>`. Isi di antara keduanya disebut
**elemen**.

```html
<h1>SIMPUS-Mini</h1>
```

`<h1>` adalah tag pembuka, `</h1>` tag penutup, dan seluruh potongan kode
di atas adalah elemen `h1` (judul level 1).

## 1.2 Struktur Wajib Setiap Halaman HTML

Semua file di jobsheet ini diawali dengan pola yang sama:

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMPUS-Mini | Beranda</title>
</head>
<body>
    ...
</body>
</html>
```

| Bagian | Fungsi |
|---|---|
| `<!DOCTYPE html>` | Memberi tahu browser bahwa dokumen ini HTML5. Wajib ada di baris paling atas. |
| `<html lang="id">` | Elemen pembungkus seluruh halaman. `lang="id"` memberi tahu browser (dan screen reader) bahwa isi halaman berbahasa Indonesia. |
| `<head>` | Berisi informasi *tentang* halaman yang **tidak tampil** di layar: judul tab, encoding karakter, link CSS, dsb. |
| `<meta charset="UTF-8">` | Mengatur pengkodean karakter jadi UTF-8, supaya karakter seperti `é`, `&mdash;`, atau huruf non-Latin tampil benar, tidak jadi simbol aneh. |
| `<title>` | Teks yang muncul di **tab browser**. Perhatikan tiap halaman punya title berbeda (`SIMPUS-Mini \| Beranda`, `SIMPUS-Mini \| Daftar Buku`, dst.) supaya pengguna tahu sedang di halaman mana. |
| `<body>` | Berisi semua konten yang **tampil** di layar: teks, gambar, tabel, form, dll. |

## 1.3 Tag Semantic HTML5

"Semantic" artinya nama tag menjelaskan **makna/peran** kontennya, bukan
sekadar kotak kosong seperti `<div>`. Ini yang dipakai di jobsheet ini:

- **`<header>`** — bagian kepala halaman, biasanya berisi judul situs dan
  navigasi. Muncul di **semua** halaman jobsheet ini dengan isi yang mirip
  (judul `SIMPUS-Mini` + menu `nav`).
- **`<nav>`** — kelompok tautan navigasi (menu). Di dalamnya dipakai
  `<ul>`/`<li>`/`<a>` biasa, tapi dibungkus `<nav>` supaya browser/screen
  reader tahu ini adalah "menu", bukan daftar isi biasa.
- **`<main>`** — konten **utama** halaman. Hanya boleh ada **satu**
  `<main>` per halaman.
- **`<section>`** — mengelompokkan konten yang temanya sama, biasanya
  diawali sebuah heading (`<h2>`, dst.).
- **`<article>`** — potongan konten yang berdiri sendiri/bisa dipisah dari
  konteks sekitarnya. Di `index.html`, tiap kartu statistik (Total Buku,
  Total Anggota, Sedang Dipinjam) dibungkus `<article>` karena masing-
  masing adalah info yang berdiri sendiri.
- **`<footer>`** — bagian kaki halaman, biasanya berisi copyright/info
  tambahan. Sama di semua halaman: `© 2026 SIMPUS-Mini — Jobsheet 1`.

Kenapa tidak pakai `<div>` saja untuk semuanya? Karena `<div>` tidak
membawa makna apa pun — browser, mesin pencari, dan alat bantu difabel
(screen reader) tidak tahu apakah sebuah `<div>` itu menu, konten utama,
atau footer. Dengan tag semantic, kode lebih mudah dibaca **dan** lebih
ramah aksesibilitas & SEO.

## 1.4 Kenapa Belum Ada CSS?

Sesuai catatan di [README.md](../README.md) jobsheet ini, tahap ini
**sengaja belum diberi CSS/JavaScript**. Tujuannya supaya kamu fokus dulu
pada struktur (kerangka) halaman. Karena belum ada CSS, tampilan di
browser akan terlihat polos (font default, tanpa warna/tata letak rapi) —
itu **normal**, bukan kesalahan. Styling akan dipelajari di jobsheet
berikutnya.

## 1.5 Navigasi Antar Halaman (`<a href="...">`)

Perhatikan menu `<nav>` di setiap file memakai path relatif berbeda-beda
tergantung lokasi file itu sendiri, misalnya:

- Dari `index.html` (di folder root) ke daftar buku: `href="buku/list.html"`
  (turun ke folder `buku`).
- Dari `buku/list.html` kembali ke beranda: `href="../index.html"`
  (`../` berarti naik satu folder ke atas).
- Dari `buku/list.html` ke `buku/tambah.html`: cukup `href="tambah.html"`
  karena masih di folder yang sama.

Ini penting dipahami karena kesalahan path relatif adalah salah satu
penyebab paling umum tautan "tidak jalan" saat belajar HTML.

Lanjut ke: [Penjelasan `index.html`](02-index-html.md)
