# 6. Rangkuman & Latihan Lanjutan

## 6.1 Rangkuman Keseluruhan Jobsheet 12

| Bagian | Konsep yang Dipelajari |
|---|---|
| [Konsep Dasar Integrasi & Transaction](01-konsep-dasar-integrasi-dan-transaksi.md) | Kenapa butuh tabel relasi, foreign key, transaction, race condition |
| [Skema `peminjaman`](02-skema-peminjaman-dan-relasi.md) | `REFERENCES`, tipe `DATE`, `DEFAULT CURRENT_DATE`, relasi many-to-many |
| [Peminjaman Baru](03-peminjaman-baru-dan-transaction.md) | `beginTransaction`/`commit`/`rollBack`, `SELECT ... FOR UPDATE` |
| [Pengembalian](04-pengembalian-buku.md) | Transaction kebalikan, defense in depth (method + CSRF) |
| [Riwayat & `JOIN`](05-riwayat-peminjaman-join.md) | `JOIN ... ON`, alias tabel, perbandingan string `(string) === (string)` |

## 6.2 Konsep Inti yang Perlu Diingat

1. **Tabel relasi (seperti `peminjaman`) menjembatani dua entitas**
   lewat foreign key, memungkinkan satu buku dipinjam banyak anggota
   dari waktu ke waktu, dan sebaliknya
   ([bab 1 §1.1-1.2](01-konsep-dasar-integrasi-dan-transaksi.md#11-kenapa-peminjaman-butuh-tabel-sendiri)).
2. **Transaction memastikan beberapa perintah SQL berhasil/gagal
   bersama-sama** — mencegah data setengah-jadi kalau salah satu
   langkah gagal di tengah proses
   ([bab 3 §3.4](03-peminjaman-baru-dan-transaction.md#34-transaction-begintransaction-commit-rollback)).
3. **`SELECT ... FOR UPDATE` mencegah race condition** dengan mengunci
   baris yang sedang diperiksa/diubah sampai transaction selesai —
   penting kapan pun ada kemungkinan dua proses mengubah data yang
   sama secara bersamaan
   ([bab 3 §3.5](03-peminjaman-baru-dan-transaction.md#35-mencegah-race-condition-select--for-update)).
4. **`JOIN` menggabungkan data dari beberapa tabel** menjadi satu hasil
   query, berdasarkan hubungan foreign key/primary key
   ([bab 5](05-riwayat-peminjaman-join.md)).
5. **Defense in depth** — melapisi beberapa pertahanan sekaligus
   (pemeriksaan method HTTP **dan** token CSRF **dan** guard login)
   lebih aman daripada mengandalkan satu lapisan saja
   ([bab 4 §4.3](04-pengembalian-buku.md#43-kenapa-guard-method-masih-diperiksa-padahal-sudah-ada-csrf)).

## 6.3 Cara Mencoba Sendiri

Ikuti alur pengujian end-to-end dari [README.md](../README.md) jobsheet
ini secara berurutan:

1. Jalankan skema tambahan dan server:
   ```bash
   psql -d simpus_mini -f sql/03_peminjaman.sql
   php -S localhost:8000
   ```
   (atau lewat Laragon — lihat [README.md](../README.md) jobsheet ini
   untuk opsi vhost-nya)
2. **Registrasi** petugas baru → **Login**.
3. **Tambah Buku** (kalau belum ada) & **Tambah Anggota** (kalau belum
   ada).
4. Klik **Peminjaman Baru**, pilih anggota dan buku, simpan — cek
   **Daftar Buku**, amati stok buku itu **berkurang 1**.
5. Kembali ke **Beranda**, amati kartu "Sedang Dipinjam" **bertambah**
   (ingat dari [README.md](../README.md) jobsheet ini, angka ini kini
   dihitung sungguhan dari `COUNT(*) FROM peminjaman WHERE status = 'dipinjam'`,
   bukan lagi statis `0` sejak jobsheet-01).
6. Klik **Pengembalian**, cari transaksi yang baru dibuat, klik
   "Kembalikan" — cek stok buku **bertambah kembali**, dan transaksi
   **hilang** dari daftar aktif.
7. Klik **Riwayat**, pilih anggota yang sama — transaksi tadi
   **muncul**, berstatus **"Selesai"**.
8. **Logout**, coba akses `/peminjaman/tambah.php` langsung — amati
   diarahkan ke Login (ingat guard `auth.php` dari
   [dokumentasi jobsheet-10 §4](../../jobsheet-10/Dokumentasi/04-guard-auth-php.md)
   berlaku juga di modul baru ini).

## 6.4 Ide Latihan Tambahan (Opsional)

1. **Terapkan validasi bisnis yang belum ada** — sesuai catatan di
   [README.md](../README.md) jobsheet ini: anggota dengan peminjaman
   **terlambat lebih dari 14 hari** tidak boleh meminjam buku baru.
   Petunjuk: hitung selisih `CURRENT_DATE` dengan `tanggal_pinjam` pada
   transaksi aktif anggota tersebut sebelum mengizinkan `INSERT` baru
   di `proses_tambah.php`.
2. **Tambah kolom "jatuh tempo"** — misalnya `tanggal_jatuh_tempo DATE`
   yang otomatis diisi 14 hari setelah `tanggal_pinjam` (petunjuk: cari
   fungsi tanggal PostgreSQL seperti `tanggal_pinjam + INTERVAL '14 days'`),
   lalu tampilkan di `kembali.php` untuk membantu Petugas melihat
   transaksi mana yang sudah lewat jatuh tempo.
3. **Uji race condition secara manual** — buka dua tab browser
   berbeda (atau dua sesi terpisah), coba pinjamkan buku dengan stok
   tersisa 1 dari **kedua** tab hampir bersamaan. Amati hanya **satu**
   yang berhasil, yang lain mendapat pesan "Stok buku tidak tersedia."
   (bukti `FOR UPDATE` dari [bab 3 §3.5](03-peminjaman-baru-dan-transaction.md#35-mencegah-race-condition-select--for-update)
   bekerja).
4. **Tambah `JOIN` tambahan di `kembali.php`/`riwayat.php`** — misalnya
   sertakan juga kolom `no_hp` anggota (dari tabel `anggota`) di daftar
   transaksi aktif, sebagai latihan menambah kolom ke query `JOIN` yang
   sudah ada.

Kalau ada bagian yang masih membingungkan, terutama soal transaction
dan `FOR UPDATE` di [bab 3](03-peminjaman-baru-dan-transaction.md),
coba praktikkan langsung latihan uji race condition di
[§6.4 poin 3](#64-ide-latihan-tambahan-opsional) — melihat sendiri
bagaimana permintaan kedua "menunggu" dan akhirnya ditolak adalah cara
paling nyata untuk memahami kenapa penguncian baris ini penting,
melampaui sekadar membaca penjelasan teoretisnya.
