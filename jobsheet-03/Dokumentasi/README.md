# Dokumentasi Jobsheet 3 — Responsive Design

Dokumentasi ini melanjutkan
[dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/README.md) dan
ditujukan untuk mahasiswa yang baru belajar HTML/CSS. Kalau kamu belum
paham HTML dasar (jobsheet-01) atau CSS dasar — Flexbox, Grid, box model
(jobsheet-02) — sebaiknya baca dulu dokumentasi jobsheet sebelumnya karena
bab-bab di sini akan sering merujuk balik ke sana.

## Apa yang Baru di Jobsheet 3?

Sesuai [README.md](../README.md) jobsheet ini, ada 4 penambahan dari
jobsheet-02:

1. Tag `<meta name="viewport">` di semua halaman.
2. Menu **hamburger** (ikon ☰) di layar sempit, dibuat murni dengan CSS
   memakai teknik **checkbox hack** (tanpa JavaScript sama sekali).
3. Tabel dibungkus `<div class="table-responsive">` supaya bisa di-scroll
   ke samping di layar sempit, alih-alih memampatkan kolom sampai tidak
   terbaca.
4. **Media query** di `style.css` yang mengubah grid kartu statistik dari
   3 kolom → 2 kolom → 1 kolom mengikuti lebar layar.

Semua perubahan ini masuk dalam topik besar **Responsive Web Design** —
membuat satu halaman web yang tampilannya menyesuaikan diri secara
otomatis di berbagai ukuran layar (HP, tablet, laptop, monitor besar),
tanpa perlu membuat halaman terpisah untuk tiap perangkat.

## Daftar Isi

1. [Konsep Dasar Responsive Design](01-konsep-dasar-responsive.md)
2. [Apa yang Berubah di File HTML?](02-perubahan-file-html.md)
3. [CSS: Menu Hamburger dengan Checkbox Hack](03-css-hamburger-checkbox-hack.md)
4. [CSS: Tabel yang Bisa Di-scroll (`table-responsive`)](04-css-table-responsive.md)
5. [CSS: Media Query & Breakpoint](05-css-media-query-breakpoint.md)
6. [Rangkuman & Latihan Lanjutan](06-rangkuman-latihan.md)

## Struktur Folder

```
jobsheet-03/
├── index.html
├── assets/
│   └── css/
│       └── style.css      # Ditambah checkbox hack + media query
├── buku/
│   ├── list.html           # Tabel dibungkus .table-responsive
│   └── tambah.html
├── anggota/
│   ├── list.html           # Tabel dibungkus .table-responsive
│   └── tambah.html
├── README.md
└── Dokumentasi/            # Folder dokumentasi ini
```

Silakan baca urut dari nomor 1, atau langsung loncat ke bagian yang ingin
dipahami.
