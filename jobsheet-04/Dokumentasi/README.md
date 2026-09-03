# Dokumentasi Jobsheet 4 — UI/UX Design

Dokumentasi ini melanjutkan
[dokumentasi jobsheet-03](../../jobsheet-03/Dokumentasi/README.md), tapi
isinya **berbeda bentuk** dari dokumentasi jobsheet sebelumnya. Kalau
jobsheet-01 sampai jobsheet-03 dokumentasinya membedah kode HTML/CSS
baris per baris, jobsheet-04 **tidak menambah kode apa pun** — sesuai
[README.md](../README.md) jobsheet ini: *"Tidak ada perubahan kode —
halaman HTML/CSS tetap sama persis dengan Jobsheet 3."*

Jadi dokumentasi ini fokus ke hal yang benar-benar baru: **proses
perancangan (UI/UX design)** yang dituangkan di `docs/wireframe.md` —
sebuah dokumen rencana untuk fitur yang **belum ada kodenya** (Login,
Dashboard Petugas, Peminjaman, Pengembalian, Riwayat), yang baru akan
mulai diimplementasikan di jobsheet-jobsheet berikutnya.

## Kenapa Ada Jobsheet Tanpa Kode Baru?

Ini bukan kekurangan — justru ini bagian penting dari cara kerja
pengembangan software yang benar. Sebelum menulis kode untuk fitur baru
yang cukup kompleks (Login, transaksi Peminjaman/Pengembalian),
developer terlebih dulu **merancang** bagaimana fitur itu akan terlihat
dan bagaimana alur penggunaannya — supaya tidak menulis kode dulu baru
menyadari alurnya membingungkan atau tidak lengkap. Proses merancang ini
disebut **UI/UX design**, dan dituangkan dalam bentuk **wireframe** dan
**user flow** — dua istilah yang akan dijelaskan tuntas di bab 2 dan 3.

## Daftar Isi

1. [Konsep Dasar UI/UX Design](01-konsep-uiux-design.md)
2. [Cara Membaca Wireframe](02-cara-membaca-wireframe.md)
3. [User Flow: Peminjaman & Pengembalian](03-user-flow-peminjaman-pengembalian.md)
4. [Aktor & Kaitannya dengan Otorisasi](04-aktor-dan-otorisasi.md)
5. [Keterhubungan dengan Kode yang Sudah Ada](05-keterhubungan-dengan-kode.md)
6. [Rangkuman & Latihan Lanjutan](06-rangkuman-latihan.md)

## Struktur Folder

```
jobsheet-04/
├── index.html              # Sama persis dengan jobsheet-03
├── assets/css/style.css    # Sama persis dengan jobsheet-03
├── buku/                    # Sama persis dengan jobsheet-03
├── anggota/                 # Sama persis dengan jobsheet-03
├── docs/
│   └── wireframe.md         # BARU — rancangan fitur yang belum dikoding
├── Infografis.png
├── README.md
└── Dokumentasi/             # Folder dokumentasi ini
```

Karena HTML/CSS-nya identik dengan jobsheet-03, kamu tidak perlu membaca
ulang penjelasan tag/CSS — cukup rujuk kembali ke
[dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/README.md),
[jobsheet-02](../../jobsheet-02/Dokumentasi/README.md), dan
[jobsheet-03](../../jobsheet-03/Dokumentasi/README.md) kalau perlu
menyegarkan ingatan.
