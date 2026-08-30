# 3. Penjelasan `buku/list.html` (Daftar Buku)

File ini menampilkan **tabel** berisi daftar buku perpustakaan (data
contoh/statis, 5 baris).

## 3.1 Kerangka Halaman

Bagian `<header>` dan `<footer>` polanya **sama persis** dengan
`index.html` (lihat [dokumentasi index.html](02-index-html.md)), hanya
saja path pada `href` berubah karena file ini berada di dalam folder
`buku/`, bukan di root:

```html
<li><a href="../index.html">Beranda</a></li>
<li><a href="list.html">Daftar Buku</a></li>
<li><a href="tambah.html">Tambah Buku</a></li>
<li><a href="../anggota/list.html">Daftar Anggota</a></li>
```

- `../index.html` → naik satu folder ke root, baru buka `index.html`.
- `list.html` dan `tambah.html` → tanpa awalan, karena keduanya ada di
  folder `buku/` yang sama.
- `../anggota/list.html` → naik satu folder ke root, lalu turun ke folder
  `anggota/`.

Bagian yang benar-benar baru di file ini ada di dalam `<main>`, yaitu
**tabel HTML**.

## 3.2 Anatomi Tabel HTML

```html
<table>
    <thead>
        <tr>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Tahun</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Laskar Pelangi</td>
            <td>Andrea Hirata</td>
            <td>2005</td>
            <td>4</td>
            <td>
                <button type="button">Edit</button>
                <button type="button">Hapus</button>
            </td>
        </tr>
        <!-- ... 4 baris lain dengan pola yang sama ... -->
    </tbody>
</table>
```

| Tag | Kepanjangan | Fungsi |
|---|---|---|
| `<table>` | table | Pembungkus seluruh tabel. |
| `<thead>` | table head | Bagian **kepala tabel** — berisi nama-nama kolom. |
| `<tbody>` | table body | Bagian **isi tabel** — berisi baris-baris data sesungguhnya. |
| `<tr>` | table row | Satu **baris** tabel (horizontal). |
| `<th>` | table header cell | Satu **sel judul kolom** (teks otomatis tebal & rata tengah oleh browser). |
| `<td>` | table data cell | Satu **sel data biasa** di dalam baris. |

Cara membaca struktur: `<table>` berisi baris-baris (`<tr>`), dan setiap
baris berisi sel-sel (`<th>` untuk header, `<td>` untuk data). Jadi
tabel ini punya 5 kolom (Judul, Pengarang, Tahun, Stok, Aksi) dan 5 baris
data buku.

### Kolom "Aksi"

```html
<td>
    <button type="button">Edit</button>
    <button type="button">Hapus</button>
</td>
```

- Setiap baris punya 2 tombol: **Edit** dan **Hapus**.
- `type="button"` artinya tombol ini **tombol biasa**, bukan tombol
  submit form (beda dengan tombol "Simpan" di halaman form — lihat
  [dokumentasi buku/tambah.html §4.5](04-buku-tambah-html.md#45-tombol-submit)).
  Kalau `type` tidak ditulis dan tombol ini berada **di dalam** sebuah
  `<form>`, browser akan menganggapnya tombol submit secara default —
  makanya di sini sengaja ditulis eksplisit `type="button"`.
- **Penting untuk dipahami:** tombol ini **belum berfungsi apa-apa**.
  Belum ada JavaScript yang menghubungkan klik tombol dengan aksi
  edit/hapus data. Ini baru kerangka tampilan (UI), logikanya menyusul di
  jobsheet berikutnya saat belajar JavaScript.

## 3.3 Data yang Ditampilkan (Dummy)

Ada 5 baris data buku yang diketik manual langsung di HTML:

| Judul | Pengarang | Tahun | Stok |
|---|---|---|---|
| Laskar Pelangi | Andrea Hirata | 2005 | 4 |
| Bumi Manusia | Pramoedya Ananta Toer | 1980 | 2 |
| Negeri 5 Menara | Ahmad Fuadi | 2009 | 0 |
| Filosofi Teras | Henry Manampiring | 2018 | 5 |
| Ronggeng Dukuh Paruk | Ahmad Tohari | 1982 | 1 |

Karena ini **HTML statis** (belum terhubung database), data ini tidak
bisa ditambah/diubah lewat aplikasi — untuk menambah baris baru, kamu
harus mengedit langsung kode HTML-nya (copy-paste satu blok `<tr>...</tr>`
lalu ganti isinya).

## 3.4 Kenapa Pakai `<table>`, Bukan `<div>` Bertumpuk?

Tabel adalah pilihan tag yang tepat di sini karena datanya memang
**tabular** — punya kolom dan baris yang jelas relasinya (setiap baris
adalah satu buku, setiap kolom adalah satu atribut buku). Browser dan
screen reader juga memahami struktur `<table>` secara khusus (misalnya
bisa mengumumkan "kolom Tahun, baris 2, isinya 1980"), yang tidak bisa
didapat kalau memakai `<div>` biasa.

Lanjut ke: [Penjelasan `buku/tambah.html`](04-buku-tambah-html.md)
