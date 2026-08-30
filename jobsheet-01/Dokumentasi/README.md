# Dokumentasi Jobsheet 1 — SIMPUS-Mini

Dokumentasi ini dibuat khusus untuk mahasiswa yang baru belajar HTML/CSS.
Setiap file kode di jobsheet-01 dijelaskan baris per baris: tag apa yang
dipakai, kenapa dipakai, dan apa gunanya di dunia nyata.

## Daftar Isi

1. [Konsep Dasar yang Dipakai di Jobsheet Ini](01-konsep-dasar.md)
2. [Penjelasan `index.html` (Halaman Beranda)](02-index-html.md)
3. [Penjelasan `buku/list.html` (Daftar Buku)](03-buku-list-html.md)
4. [Penjelasan `buku/tambah.html` (Form Tambah Buku)](04-buku-tambah-html.md)
5. [Penjelasan `anggota/list.html` (Daftar Anggota)](05-anggota-list-html.md)
6. [Penjelasan `anggota/tambah.html` (Form Tambah Anggota)](06-anggota-tambah-html.md)
7. [Rangkuman & Latihan Lanjutan](07-rangkuman-latihan.md)

## Tentang Program Ini

Jobsheet 1 membangun kerangka awal aplikasi **SIMPUS-Mini**, yaitu sistem
perpustakaan mini yang bisa mengelola data **buku** dan **anggota**.
Di tahap ini aplikasi **belum bisa menyimpan data sungguhan** — semua data
di tabel masih data dummy (contoh) yang ditulis manual di HTML, dan form
belum diproses ke mana pun. Fokus jobsheet ini murni pada:

- Struktur halaman web memakai **HTML5 semantic** (`header`, `nav`, `main`,
  `section`, `article`, `footer`), bukan `div` polos di semua tempat.
- Penamaan atribut `id` dan `name` pada form, yang nantinya akan dipakai
  lagi ketika belajar CSS (jobsheet 2) dan JavaScript/backend (jobsheet
  berikutnya).

## Struktur Folder

```
jobsheet-01/
├── index.html            # Halaman beranda
├── buku/
│   ├── list.html          # Tabel daftar buku (statis)
│   └── tambah.html        # Form tambah buku (belum diproses)
├── anggota/
│   ├── list.html          # Tabel daftar anggota (statis)
│   └── tambah.html        # Form tambah anggota (belum diproses)
├── README.md              # Ringkasan singkat jobsheet (dari dosen)
└── dokumentasi/           # Folder dokumentasi ini
```

Silakan baca urut dari nomor 1 supaya konsepnya nyambung, atau langsung
loncat ke file yang ingin dipahami.
