# Dokumentasi Jobsheet 10 — Autentikasi & Manajemen Sesi

Dokumentasi ini melanjutkan
[dokumentasi jobsheet-09](../../jobsheet-09/Dokumentasi/README.md) (CRUD
Penuh). Jobsheet-10 mewujudkan sesuatu yang sudah dirancang **jauh
sebelumnya**: ingat wireframe halaman Login dan pembagian aktor
Tamu/Petugas yang sudah dibahas di
[dokumentasi jobsheet-04](../../jobsheet-04/Dokumentasi/04-aktor-dan-otorisasi.md) —
sekarang, 6 jobsheet kemudian, fitur itu **benar-benar dibangun**.

## Tentang `docs/wireframe.md`

File ini **identik persis** dengan
[`docs/wireframe.md` di jobsheet-09](../../jobsheet-09/docs/wireframe.md).

## Apa yang Baru di Jobsheet 10?

Sesuai [README.md](../README.md) jobsheet ini:

1. **`sql/02_users.sql`** — tabel `users` baru (nama, username,
   password, role).
2. **Registrasi** (`auth/register.php` + `proses_register.php`) —
   password disimpan **terenkripsi** lewat `password_hash()`, dengan
   pengecekan username duplikat.
3. **Login** (`auth/login.php` + `proses_login.php`) — memverifikasi
   password lewat `password_verify()`.
4. **Logout** (`auth/logout.php`) — mengakhiri sesi lewat
   `session_destroy()`.
5. **`includes/auth.php`** — "penjaga gerbang" yang mengalihkan
   pengunjung yang belum login ke halaman Login, dipasang di semua
   halaman yang **wajib** login.
6. **Navbar dinamis** — menu dan status login/logout kini berubah
   tergantung apakah pengunjung sudah login atau belum.

## Mengingat Kembali: Aktor Tamu vs Petugas

Ingat dari [dokumentasi jobsheet-04 §4](../../jobsheet-04/Dokumentasi/04-aktor-dan-otorisasi.md),
`wireframe.md` sejak awal membedakan 2 aktor:

> - **Tamu**: hanya bisa melihat katalog buku (Beranda, Daftar Buku)
>   tanpa login.
> - **Petugas**: login untuk mengakses seluruh fitur CRUD dan transaksi
>   peminjaman.

Jobsheet ini **mewujudkan pembagian itu secara teknis**:

| Halaman | Akses |
|---|---|
| `index.php` (Beranda) | **Publik** — Tamu boleh mengakses |
| `buku/list.php` (katalog buku) | **Publik** — Tamu boleh mengakses |
| `buku/tambah.php`, `buku/edit.php`, `buku/hapus.php` | **Terkunci** — wajib login |
| Seluruh halaman `anggota/*` | **Terkunci** — wajib login |

## Daftar Isi

1. [Konsep Dasar Autentikasi & Otorisasi](01-konsep-dasar-autentikasi.md)
2. [Tabel `users` & Registrasi](02-skema-users-dan-registrasi.md)
3. [Login & Logout](03-login-dan-logout.md)
4. [Guard Halaman: `includes/auth.php`](04-guard-auth-php.md)
5. [Navbar Dinamis & CSS Pendukung](05-navbar-dinamis-dan-css.md)
6. [Rangkuman & Latihan Lanjutan](06-rangkuman-latihan.md)

## Struktur Folder

```
jobsheet-10/
├── index.php                   # Tidak berubah — tetap publik
├── includes/
│   ├── auth.php                  # BARU — guard clause login
│   ├── header.php                # Navbar & status login kini dinamis
│   ├── footer.php, koneksi.php   # Tidak berubah
├── auth/
│   ├── register.php, proses_register.php   # BARU
│   ├── login.php, proses_login.php          # BARU
│   └── logout.php                            # BARU
├── sql/
│   ├── 01_buku_anggota.sql
│   └── 02_users.sql              # BARU — tabel users
├── buku/
│   ├── list.php                   # Tidak berubah — tetap publik
│   ├── tambah.php, edit.php, hapus.php, proses_*.php  # + require auth.php
├── anggota/                        # SEMUA halaman + require auth.php
├── docs/wireframe.md                # Identik dengan jobsheet-09
├── README.md
└── Dokumentasi/                     # Folder dokumentasi ini
```

**Catatan penting** dari [README.md](../README.md) jobsheet ini:
`includes/auth.php` sudah diverifikasi tetap mengembalikan redirect ke
halaman Login **meski database belum tersambung** — karena guard ini
berjalan **sebelum** kode yang membutuhkan koneksi database. Selain itu,
**perbedaan akses berdasarkan `role`** (misalnya hanya admin yang boleh
menghapus anggota) **belum** diterapkan di jobsheet ini — dijadikan
tugas mandiri (lihat [bab 6](06-rangkuman-latihan.md)).
