# Wireframe & User Flow — Persewaan Alat Outdoor

Sub-CPMK: Merancang UI/UX aplikasi (proyek).

Halaman yang sudah ada (Beranda, Daftar/Tambah Alat, Daftar/Tambah Penyewa — Jobsheet 1-3) belum mencakup fitur Login, Dashboard Petugas, dan Persewaan/Pengembalian. Dokumen ini merancang wireframe untuk halaman-halaman tersebut sebelum diimplementasikan mulai Jobsheet 5 dan seterusnya.

## Aktor
- **Tamu**: hanya bisa melihat katalog alat (Beranda, Daftar Alat) tanpa login.
- **Petugas**: login untuk mengakses seluruh fitur CRUD dan transaksi persewaan.

## User Flow — Persewaan Alat

```
[Petugas Login] -> [Dashboard] -> [Pilih menu "Persewaan Baru"]
        -> [Pilih Penyewa] -> [Pilih Alat (stok > 0)]
        -> [Simpan] -> [Stok alat berkurang 1] -> [Kembali ke Dashboard]
```

## User Flow — Pengembalian Alat

```
[Dashboard] -> [Menu "Pengembalian"] -> [Cari transaksi aktif (penyewa/alat)]
        -> [Tandai "Dikembalikan"] -> [Stok alat bertambah 1]
        -> [Kembali ke Dashboard]
```

## Wireframe: Halaman Login

```
+--------------------------------------+
|        Persewaan Alat Outdoor        |
|--------------------------------------|
|                                      |
|        [ Login Petugas ]             |
|                                      |
|   Username : [______________]        |
|   Password : [______________]        |
|                                      |
|          [   Masuk   ]               |
|                                      |
|   Belum punya akun? Daftar di sini   |
+--------------------------------------+
```

## Wireframe: Dashboard Petugas

```
+-----------------------------------------------------------------------+
| Persewaan Outdoor   Beranda | Alat | Penyewa | Persewaan | (Nama) Logout |
|-----------------------------------------------------------------------|
|  [Total Alat]   [Total Penyewa]   [Sedang Disewa]                     |
|                                                                       |
|  Aksi Cepat:                                                          |
|  [ + Persewaan Baru ]   [ + Pengembalian ]                              |
|                                                                       |
|  Transaksi Terbaru                                                    |
|  --------------------------------------------------                   |
|  Penyewa | Alat | Tgl Sewa | Status                                   |
+-----------------------------------------------------------------------+
```

## Wireframe: Form Persewaan

```
+--------------------------------------+
|  Form Persewaan Alat Outdoor         |
|--------------------------------------|
|  Penyewa : [ dropdown pilih penyewa ]|
|  Alat    : [ dropdown, hanya stok>0 ]|
|  Tanggal Sewa : [ auto: hari ini ]   |
|                                      |
|          [  Simpan Persewaan  ]      |
+--------------------------------------+
```

## Wireframe: Form Pengembalian

```
+--------------------------------------+
|  Pengembalian Alat Outdoor           |
|--------------------------------------|
|  Cari transaksi aktif:               |
|  [ nama penyewa / nama alat ______ ] |
|                                      |
|  Penyewa | Alat | Tgl Sewa | [Kembalikan] |
+--------------------------------------+
```

## Wireframe: Riwayat Persewaan per Penyewa

```
+--------------------------------------+
|  Riwayat Persewaan — Farelyan Hilmy  |
|--------------------------------------|
|  Alat          | Sewa     | Kembali | Status      |
|  Tenda Dome 4P | 01/07    | 03/07   | Selesai     |
|  Carrier 60L   | 15/07    | -       | Disewa      |
+--------------------------------------+
```

## Konsistensi dengan Desain yang Sudah Berjalan
- Warna aksen, tipografi navbar, dan gaya tabel/kartu mengikuti `assets/css/style.css` yang sudah dibangun sejak Jobsheet 2-3.
- Navbar akan ditambah menu **Persewaan** dan indikator status login (nama petugas / tombol Logout) mulai implementasi di Jobsheet 10.
- Edge case yang perlu ditangani saat implementasi: alat stok habis tidak boleh dipilih di form persewaan; penyewa dengan tunggakan terlambat divalidasi di Jobsheet 12 (tugas mandiri).