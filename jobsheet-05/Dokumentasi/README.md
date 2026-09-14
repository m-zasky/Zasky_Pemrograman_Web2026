# Dokumentasi Jobsheet 5 — JavaScript DOM & Event

Dokumentasi ini melanjutkan
[dokumentasi jobsheet-03](../../jobsheet-03/Dokumentasi/README.md) (HTML/CSS
responsif) dan [jobsheet-04](../../jobsheet-04/Dokumentasi/README.md)
(rancangan UI/UX). Jobsheet-05 adalah titik penting: ini **pertama
kalinya** aplikasi SIMPUS-Mini punya **JavaScript** — kode yang membuat
halaman benar-benar bisa "bereaksi" terhadap tindakan pengguna, bukan
sekadar tampilan statis.

## Tentang `docs/wireframe.md`

File ini **identik persis** dengan
[`docs/wireframe.md` di jobsheet-04](../../jobsheet-04/docs/wireframe.md) —
tidak ada perubahan rancangan UI/UX baru di jobsheet ini. Kalau kamu
belum membaca rancangan itu, baca dulu
[dokumentasi jobsheet-04](../../jobsheet-04/Dokumentasi/README.md)
sebelum lanjut ke sini.

## Apa yang Baru di Jobsheet 5?

Sesuai [README.md](../README.md) jobsheet ini, ada 4 penambahan besar,
semuanya lewat file baru `assets/js/app.js`:

1. **Menu hamburger diganti dari CSS ke JavaScript** — sebelumnya
   memakai "checkbox hack" murni CSS (lihat
   [dokumentasi jobsheet-03](../../jobsheet-03/Dokumentasi/03-css-hamburger-checkbox-hack.md)),
   sekarang memakai tombol asli + `classList.toggle()`.
2. **Validasi form sisi klien (client-side)** — form Tambah Buku dan
   Tambah Anggota sekarang menolak data yang tidak valid **sebelum**
   ter-submit, dengan pesan error yang muncul langsung di halaman.
3. **Filter/pencarian tabel real-time** — mengetik di kolom cari
   langsung menyaring baris tabel tanpa reload halaman.
4. **Tombol Hapus yang benar-benar berfungsi** (di sisi tampilan) —
   menampilkan konfirmasi lalu menghapus barisnya dari layar.

## Daftar Isi

1. [Konsep Dasar JavaScript & DOM](01-konsep-dasar-javascript-dom.md)
2. [Apa yang Berubah di File HTML?](02-perubahan-file-html.md)
3. [CSS Pendukung Fitur JavaScript](03-css-pendukung-javascript.md)
4. [JS: Menu Hamburger](04-js-hamburger-menu.md)
5. [JS: Konfirmasi Hapus](05-js-konfirmasi-hapus.md)
6. [JS: Filter Tabel Real-Time](06-js-filter-tabel.md)
7. [JS: Validasi Form](07-js-validasi-form.md)
8. [Rangkuman & Latihan Lanjutan](08-rangkuman-latihan.md)

## Struktur Folder

```
jobsheet-05/
├── index.html
├── assets/
│   ├── css/style.css        # Ditambah gaya untuk error & search-box
│   └── js/
│       └── app.js            # BARU — seluruh interaktivitas jobsheet ini
├── buku/
│   ├── list.html              # Ditambah kolom pencarian + class btn-hapus
│   └── tambah.html            # Ditambah id="form-tambah" untuk validasi
├── anggota/
│   ├── list.html
│   └── tambah.html
├── docs/wireframe.md          # Identik dengan jobsheet-04
├── README.md
└── Dokumentasi/                # Folder dokumentasi ini
```

**Catatan penting** dari [README.md](../README.md) jobsheet ini yang
perlu diingat sejak awal: validasi di jobsheet ini murni berjalan di
**browser pengguna** (client-side) dan **bisa dilewati** kalau JavaScript
dinonaktifkan — belum aman untuk diandalkan sepenuhnya. Validasi
sisi server (server-side) yang wajib dan tidak bisa dilewati baru akan
ditambahkan di Jobsheet 7. Begitu juga tombol Hapus: baru menghilangkan
baris dari tampilan, **belum** benar-benar menghapus data — itu menyusul
di Jobsheet 9.
