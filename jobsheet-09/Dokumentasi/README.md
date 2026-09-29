# Dokumentasi Jobsheet 9 — CRUD Penuh

Dokumentasi ini melanjutkan
[dokumentasi jobsheet-08](../../jobsheet-08/Dokumentasi/README.md)
(Koneksi PostgreSQL). Jobsheet-09 **melengkapi** apa yang sudah dibangun
sejak jobsheet-08 — kalau jobsheet-08 baru mencakup **Create** (tambah
data) dan **Read** (tampilkan data), jobsheet ini menambahkan dua huruf
terakhir dari **CRUD**: **Update** (ubah) dan **Delete** (hapus).

## Tentang `docs/wireframe.md`

File ini **identik persis** dengan
[`docs/wireframe.md` di jobsheet-08](../../jobsheet-08/docs/wireframe.md) —
tidak ada rancangan UI/UX baru di jobsheet ini.

## Apa yang Baru di Jobsheet 9?

Sesuai [README.md](../README.md) jobsheet ini:

1. **`edit.php` + `proses_edit.php`** (buku & anggota) — melengkapi
   **Update**: form yang **sudah terisi** data lama, lalu menyimpan
   perubahannya.
2. **`hapus.php`** (buku & anggota) — melengkapi **Delete**, sengaja
   **hanya menerima `POST`** (bukan `GET`) supaya tidak terpicu tidak
   sengaja lewat tautan biasa atau crawler mesin pencari.
3. Tombol Hapus di `list.php` sekarang berupa **`<form>` sungguhan**
   (bukan `<button>` polos seperti jobsheet-05/06) — `app.js` diubah
   menangani konfirmasi di event `submit`, bukan `click`.
4. **Pagination** (`LIMIT`/`OFFSET`, 5 baris per halaman) dan
   **pencarian sisi server** (`WHERE ... ILIKE ...`) — menggantikan
   pencarian client-side murni dari jobsheet-05/06 untuk kebutuhan
   mencari **lintas semua halaman**, bukan cuma baris yang sedang
   tampil.

## Daftar Isi

1. [Konsep Dasar CRUD](01-konsep-dasar-crud.md)
2. [Mengubah Data: `edit.php` & `proses_edit.php`](02-edit-update-data.md)
3. [Menghapus Data: `hapus.php`](03-hapus-delete-data.md)
4. [JS: Konfirmasi Hapus via Event `submit`](04-js-update-hapus-confirm.md)
5. [Pagination & Pencarian Sisi Server](05-pagination-dan-pencarian-server.md)
6. [CSS Pendukung Fitur Baru](06-css-pendukung.md)
7. [Rangkuman & Latihan Lanjutan](07-rangkuman-latihan.md)

## Struktur Folder

```
jobsheet-09/
├── index.php
├── includes/                       # Tidak berubah dari jobsheet-08
├── buku/
│   ├── list.php                     # + pagination, pencarian server, tombol Hapus jadi form
│   ├── tambah.php, proses_tambah.php # Tidak berubah dari jobsheet-08
│   ├── edit.php                      # BARU — form edit terisi data lama
│   ├── proses_edit.php               # BARU — UPDATE ke database
│   └── hapus.php                     # BARU — DELETE, hanya menerima POST
├── anggota/                          # Struktur sama persis dengan buku/
│   ├── list.php, tambah.php, proses_tambah.php
│   ├── edit.php, proses_edit.php, hapus.php
├── assets/
│   ├── css/style.css                 # + gaya btn-edit, pagination, search form
│   └── js/app.js                      # initHapusConfirm: click → submit
├── docs/wireframe.md                  # Identik dengan jobsheet-08
├── README.md
└── Dokumentasi/                       # Folder dokumentasi ini
```

**Catatan penting** dari [README.md](../README.md) jobsheet ini:

- Kolom pencarian sekarang melayani **dua peran sekaligus**: filter
  instan sisi klien (JavaScript, dari jobsheet-05) untuk baris yang
  **sedang tampil**, dan pencarian penuh **lintas-halaman** lewat
  tombol "Cari" (sisi server) — dibahas di
  [bab 5](05-pagination-dan-pencarian-server.md).
- Nilai pencarian (`q`) **belum di-escape** saat ditampilkan kembali ke
  atribut `value` — ini **sengaja belum diperbaiki**, akan diaudit dan
  diperbaiki menyeluruh (bersama celah keamanan lain) di Jobsheet 11.
