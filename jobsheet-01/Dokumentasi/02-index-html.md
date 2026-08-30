# 2. Penjelasan `index.html` (Halaman Beranda)

File ini adalah **halaman pertama** yang dibuka ketika aplikasi dijalankan
(karena namanya `index.html`, nama baku yang otomatis dicari browser/server
sebagai halaman utama sebuah folder).

## 2.1 Kode Lengkap

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMPUS-Mini | Beranda</title>
</head>
<body>
    <header>
        <h1>SIMPUS-Mini</h1>
        <nav>
            <ul>
                <li><a href="index.html">Beranda</a></li>
                <li><a href="buku/list.html">Daftar Buku</a></li>
                <li><a href="buku/tambah.html">Tambah Buku</a></li>
                <li><a href="anggota/list.html">Daftar Anggota</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
            <p>Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan.</p>
        </section>

        <section>
            <h2>Ringkasan</h2>
            <article>
                <h3>Total Buku</h3>
                <p>12</p>
            </article>
            <article>
                <h3>Total Anggota</h3>
                <p>8</p>
            </article>
            <article>
                <h3>Sedang Dipinjam</h3>
                <p>3</p>
            </article>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 1</p>
    </footer>
</body>
</html>
```

## 2.2 Penjelasan Bagian per Bagian

### `<header>` — Kepala Halaman

```html
<header>
    <h1>SIMPUS-Mini</h1>
    <nav>...</nav>
</header>
```

- `<h1>SIMPUS-Mini</h1>` adalah judul utama aplikasi. Setiap halaman HTML
  sebaiknya hanya punya **satu** `<h1>` — ini heading level tertinggi.
- Di dalam `<header>` ada `<nav>` yang berisi menu navigasi ke 4 halaman:
  Beranda, Daftar Buku, Tambah Buku, dan Daftar Anggota. Perhatikan tidak
  ada tautan "Tambah Anggota" di menu ini — itu wajar, karena tugas
  mandiri (lihat [dokumentasi anggota/tambah.html](06-anggota-tambah-html.md))
  memang meminta kamu mempraktikkan sendiri konsistensi menu ini.

### `<nav>` — Menu Navigasi

```html
<nav>
    <ul>
        <li><a href="index.html">Beranda</a></li>
        <li><a href="buku/list.html">Daftar Buku</a></li>
        <li><a href="buku/tambah.html">Tambah Buku</a></li>
        <li><a href="anggota/list.html">Daftar Anggota</a></li>
    </ul>
</nav>
```

- `<ul>` (unordered list / daftar tak berurutan) membungkus daftar menu.
- Tiap `<li>` (list item) adalah satu item menu, berisi satu tautan `<a>`.
- `href` pada setiap `<a>` menentukan halaman tujuan. Karena `index.html`
  berada di folder **root** jobsheet-01, path ke folder `buku/` dan
  `anggota/` ditulis langsung tanpa `../` (lihat [konsep dasar §1.5](01-konsep-dasar.md#15-navigasi-antar-halaman-a-href)).

### `<main>` — Konten Utama

Berisi dua `<section>`:

**Section 1 — Sambutan**
```html
<section>
    <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
    <p>Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan.</p>
</section>
```
Sekadar teks sambutan: satu `<h2>` (judul sub-bagian, satu level di bawah
`<h1>`) dan satu paragraf `<p>`.

**Section 2 — Ringkasan Statistik**
```html
<section>
    <h2>Ringkasan</h2>
    <article>
        <h3>Total Buku</h3>
        <p>12</p>
    </article>
    <article>
        <h3>Total Anggota</h3>
        <p>8</p>
    </article>
    <article>
        <h3>Sedang Dipinjam</h3>
        <p>3</p>
    </article>
</section>
```
- Setiap `<article>` di sini mewakili satu "kartu" statistik yang berdiri
  sendiri: judul kecil (`<h3>`, satu level di bawah `<h2>`) + angka
  (`<p>`).
- Angka `12`, `8`, `3` di sini **hanya data contoh (dummy)**, diketik
  manual. Belum ada logika yang menghitung dari data asli — itu akan
  dipelajari saat masuk ke pemrograman sisi server/JavaScript.
- Kenapa dipilih `<article>` dan bukan `<div>`? Karena tiap kartu bisa
  "berdiri sendiri" secara makna — kalau dipindah ke halaman lain pun,
  informasinya tetap utuh dan masuk akal (misalnya "Total Buku: 12").

### `<footer>` — Kaki Halaman

```html
<footer>
    <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 1</p>
</footer>
```

- `&copy;` adalah **HTML entity** (kode karakter khusus) untuk simbol `©`.
- `&mdash;` adalah entity untuk tanda pisah panjang `—` (em dash).
  Entity dipakai karena beberapa karakter simbol tidak selalu bisa/aman
  diketik langsung di HTML, jadi ditulis dalam bentuk kode ini.

## 2.3 Kesimpulan

`index.html` menunjukkan pola dasar yang **diulang** di semua halaman lain
di jobsheet ini: `header` (judul + nav) → `main` (isi khusus halaman) →
`footer` (copyright). Setelah paham file ini, kamu akan lebih mudah
memahami 4 file HTML lainnya karena kerangkanya sama, hanya isi
`<main>`-nya yang berbeda.

Lanjut ke: [Penjelasan `buku/list.html`](03-buku-list-html.md)
