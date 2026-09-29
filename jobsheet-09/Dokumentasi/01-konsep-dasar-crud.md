# 1. Konsep Dasar CRUD

## 1.1 Apa itu CRUD?

**CRUD** adalah singkatan dari 4 operasi dasar yang hampir **selalu**
dibutuhkan aplikasi apa pun yang mengelola data:

| Huruf | Operasi | Perintah SQL | Sudah Dibangun Sejak |
|---|---|---|---|
| **C**reate | Menambah data baru | `INSERT` | Jobsheet 8 ([dokumentasi jobsheet-08 §5](../../jobsheet-08/Dokumentasi/05-insert-prepared-statement.md)) |
| **R**ead | Membaca/menampilkan data | `SELECT` | Jobsheet 8 ([dokumentasi jobsheet-08 §6](../../jobsheet-08/Dokumentasi/06-membaca-data-select.md)) |
| **U**pdate | Mengubah data yang sudah ada | `UPDATE` | **Jobsheet 9** ([bab 2](02-edit-update-data.md)) |
| **D**elete | Menghapus data | `DELETE` | **Jobsheet 9** ([bab 3](03-hapus-delete-data.md)) |

Hampir semua aplikasi berbasis data — dari SIMPUS-Mini sampai aplikasi
sekelas media sosial atau e-commerce — pada dasarnya menjalankan
kombinasi 4 operasi ini berulang-ulang. Menguasai pola CRUD berarti
menguasai fondasi **mayoritas** aplikasi web yang pernah kamu pakai.

## 1.2 Pola yang Berulang: Form Kosong vs Form Terisi

Perhatikan **Create** ([dokumentasi jobsheet-08](../../jobsheet-08/Dokumentasi/05-insert-prepared-statement.md))
dan **Update** ([bab 2](02-edit-update-data.md)) sebenarnya memakai
**pola form yang sangat mirip** — bedanya:

| | Create (`tambah.php`) | Update (`edit.php`) |
|---|---|---|
| Kondisi awal form | **Kosong**, siap diisi dari nol | **Sudah terisi** data yang mau diubah |
| Query yang dijalankan setelah submit | `INSERT` (baris baru) | `UPDATE` (baris yang sudah ada) |
| Perlu tahu identitas baris? | Tidak — baris ini belum ada | **Ya** — perlu tahu baris **mana** yang diubah (lewat `id`) |

Poin terakhir ini penting: `UPDATE` dan `DELETE` **selalu** butuh cara
untuk menunjuk **satu baris spesifik** — di sinilah kolom `id` (`SERIAL
PRIMARY KEY`, ingat dari
[dokumentasi jobsheet-08 §2.4](../../jobsheet-08/Dokumentasi/02-skema-database-sql.md#24-mendefinisikan-kolom-nama-tipe-dan-batasan))
akhirnya benar-benar dipakai untuk pertama kalinya, setelah sejak
jobsheet-08 hanya "ikut ter-fetch" tanpa dipakai di tampilan (ingat
catatan ini dari
[dokumentasi jobsheet-08 README](../../jobsheet-08/Dokumentasi/README.md)).

## 1.3 Kenapa Delete Butuh Perhatian Ekstra?

Di antara 4 operasi CRUD, **Delete** adalah satu-satunya yang
**merusak** (destruktif) — sekali data dihapus, **tidak ada cara**
"undo" bawaan (beda dengan Update yang salah, masih bisa diubah lagi
lewat form Edit). Karena risikonya, jobsheet ini menerapkan
**pengaman tambahan** yang tidak ada di operasi lain: memastikan
Delete **hanya** bisa dipicu lewat `method="post"` (bukan `GET`,
seperti tautan biasa) — dijelaskan alasannya secara mendalam di
[bab 3](03-hapus-delete-data.md).

## 1.4 Peta Lengkap: Semua Fitur di Setiap Tabel

```
buku/
├── list.php          → Read (+ pagination & pencarian, bab 5)
├── tambah.php + proses_tambah.php  → Create (sejak jobsheet-08)
├── edit.php + proses_edit.php      → Update (BARU)
└── hapus.php                        → Delete (BARU)
```

Struktur yang **persis sama** berlaku untuk folder `anggota/`. Dengan
peta ini, kamu siap membedah tiap file baru mulai bab 2.

Lanjut ke: [Mengubah Data: `edit.php` & `proses_edit.php`](02-edit-update-data.md)
