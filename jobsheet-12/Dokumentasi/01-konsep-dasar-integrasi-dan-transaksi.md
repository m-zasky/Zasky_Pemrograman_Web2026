# 1. Konsep Dasar: Relasi Tabel & Transaction

Dua konsep besar yang benar-benar baru di jobsheet ini: **tabel yang
saling terhubung** (relasi), dan **transaction** (kelompok perintah SQL
yang harus berhasil/gagal bersama-sama).

## 1.1 Kenapa Peminjaman Butuh Tabel Sendiri?

Ingat tabel `buku` dan `anggota` sejak
[dokumentasi jobsheet-08 §2](../../jobsheet-08/Dokumentasi/02-skema-database-sql.md) —
masing-masing berdiri sendiri, tidak saling "tahu" satu sama lain.
Tapi satu **transaksi peminjaman** pada dasarnya menyatukan **dua**
informasi sekaligus: *buku mana* yang dipinjam **dan** *anggota mana*
yang meminjamnya — plus informasi baru yang tidak dimiliki keduanya:
kapan dipinjam, kapan (atau belum) dikembalikan, dan statusnya. Tabel
`peminjaman` yang baru inilah yang menyimpan **hubungan** antara
sebuah buku dan seorang anggota, ditambah data spesifik transaksi itu
sendiri.

## 1.2 Foreign Key: Menghubungkan Antar Tabel

```sql
buku_id INTEGER NOT NULL REFERENCES buku(id),
anggota_id INTEGER NOT NULL REFERENCES anggota(id),
```

**`REFERENCES buku(id)`** adalah **foreign key** (kunci asing) — aturan
yang memberi tahu database: "kolom `buku_id` di tabel ini **harus**
berisi nilai yang benar-benar ada sebagai `id` di tabel `buku`." Ini
konsep baru yang melengkapi `PRIMARY KEY` yang sudah kamu kenal sejak
[dokumentasi jobsheet-08 §2.4](../../jobsheet-08/Dokumentasi/02-skema-database-sql.md#24-mendefinisikan-kolom-nama-tipe-dan-batasan).
Manfaatnya: database **sendiri** yang menolak kalau ada percobaan
mencatat peminjaman dengan `buku_id` yang **tidak pernah ada** di
tabel `buku` — mencegah data yang tidak konsisten ("peminjaman buku
hantu") tanpa perlu kode PHP tambahan untuk memeriksanya secara manual.
Penjelasan detail seluruh skema ada di [bab 2](02-skema-peminjaman-dan-relasi.md).

## 1.3 Kenapa Butuh Transaction?

Perhatikan alur mencatat peminjaman baru
([bab 3](03-peminjaman-baru-dan-transaction.md)) sebenarnya melibatkan
**dua** perintah SQL terpisah:
1. `INSERT` baris baru ke tabel `peminjaman`.
2. `UPDATE` mengurangi `stok` di tabel `buku`.

Bayangkan kalau perintah **pertama** berhasil, tapi entah kenapa
(misalnya server tiba-tiba mati) perintah **kedua** gagal dijalankan —
hasilnya: ada catatan peminjaman yang tersimpan, tapi stok buku **tidak
pernah berkurang**. Data jadi tidak konsisten — sistem "berbohong"
tentang berapa banyak stok buku yang sebenarnya tersedia.

**Transaction** menyelesaikan masalah ini: mengelompokkan beberapa
perintah SQL supaya **semuanya berhasil bersama-sama, atau semuanya
dibatalkan bersama-sama** — tidak ada kondisi "setengah berhasil."
Detail cara memakainya (`beginTransaction`, `commit`, `rollBack`)
dibahas di [bab 3 §3.4](03-peminjaman-baru-dan-transaction.md#34-transaction-begintransaction-commit-rollback).

## 1.4 Apa itu Race Condition?

**Race condition** adalah masalah yang muncul ketika **dua proses
berjalan hampir bersamaan** dan saling mengganggu hasil satu sama lain.
Contoh konkret di aplikasi ini: bayangkan sebuah buku stoknya tinggal
**1**, dan **dua** petugas (di komputer berbeda) **secara bersamaan**
mencoba meminjamkan buku itu ke anggota berbeda. Kalau kedua proses
sama-sama membaca "stok = 1" **sebelum** salah satu sempat
menguranginya, keduanya bisa **sama-sama** menganggap peminjaman itu
sah — hasil akhirnya, stok buku bisa menjadi **-1** (angka yang tidak
masuk akal), atau dua orang meminjam buku fisik yang sama yang
sebenarnya hanya ada satu eksemplar.

Solusi untuk masalah ini — **`SELECT ... FOR UPDATE`** — dibahas
detail di [bab 3 §3.5](03-peminjaman-baru-dan-transaction.md#35-mencegah-race-condition-select--for-update).

## 1.5 Peta Modul Peminjaman

```
peminjaman/
├── tambah.php + proses_tambah.php   → mencatat peminjaman baru, kurangi stok
├── kembali.php + proses_kembali.php → menandai selesai, tambah kembali stok
└── riwayat.php                       → melihat histori per anggota
```

Ketiga halaman ini **sama-sama** butuh data dari **lebih dari satu**
tabel (`peminjaman`, `buku`, `anggota`) — inilah kenapa relasi tabel
([§1.2](#12-foreign-key-menghubungkan-antar-tabel)) dan `JOIN`
(dibahas di [bab 5](05-riwayat-peminjaman-join.md)) menjadi penting di
jobsheet ini, berbeda dari jobsheet-jobsheet sebelumnya yang tiap
halaman biasanya hanya bekerja dengan **satu** tabel saja.

Lanjut ke: [Skema `peminjaman` & Relasi Antar Tabel](02-skema-peminjaman-dan-relasi.md)
