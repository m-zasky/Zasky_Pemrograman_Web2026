# Dokumentasi Jobsheet 11 — Keamanan Web Dasar

Dokumentasi ini melanjutkan
[dokumentasi jobsheet-10](../../jobsheet-10/Dokumentasi/README.md)
(Autentikasi & Manajemen Sesi). Jobsheet-11 menutup **janji** yang
sudah disebutkan berkali-kali di dokumentasi sebelumnya — ingat catatan
di [dokumentasi jobsheet-09](../../jobsheet-09/Dokumentasi/05-pagination-dan-pencarian-server.md#58-form-pencarian-methodget):
*"celah ini akan dibahas dan diperbaiki di Jobsheet 11"* — sekarang
saatnya.

## Tentang `docs/wireframe.md`

File ini **identik persis** dengan
[`docs/wireframe.md` di jobsheet-10](../../jobsheet-10/docs/wireframe.md).

## Apa yang Baru di Jobsheet 11?

Sesuai [README.md](../README.md) jobsheet ini, ada **audit keamanan
menyeluruh** terhadap kode Jobsheet 7-10, mencakup 5 kerentanan
(lihat detail lengkapnya di
[`docs/security-checklist.md`](../docs/security-checklist.md)):

1. **SQL Injection** — diaudit ulang, sudah aman sejak jobsheet-08
   (tidak ada perubahan kode).
2. **XSS (Cross-Site Scripting)** — seluruh output data dari
   database/`$_GET` sekarang dibungkus fungsi `e()` baru.
3. **CSRF (Cross-Site Request Forgery)** — token tersembunyi
   ditambahkan ke semua form `POST`, diverifikasi sebelum menyentuh
   database.
4. **Validasi & Sanitasi Input** — diaudit ulang, ditambah type casting
   eksplisit di beberapa tempat.
5. **Session Fixation** — `session_regenerate_id(true)` dipanggil
   setelah login berhasil.

Dua file baru menjadi pusat perubahan ini: **`includes/helpers.php`**
(fungsi `e()`) dan **`includes/csrf.php`** (`csrf_token()`,
`csrf_field()`, `csrf_verify()`).

## Daftar Isi

1. [Konsep Dasar Keamanan Web](01-konsep-dasar-keamanan-web.md)
2. [XSS & Fungsi `e()`](02-xss-dan-fungsi-e.md)
3. [CSRF & Token Verifikasi](03-csrf-dan-token.md)
4. [Session Fixation](04-session-fixation.md)
5. [Audit SQL Injection & Security Checklist](05-audit-sql-injection-dan-checklist.md)
6. [Rangkuman & Latihan Lanjutan](06-rangkuman-latihan.md)

## Struktur Folder

```
jobsheet-11/
├── includes/
│   ├── helpers.php               # BARU — fungsi e() untuk XSS
│   ├── csrf.php                   # BARU — token CSRF
│   ├── auth.php                   # Tidak berubah dari jobsheet-10
│   └── header.php                 # require_once helpers.php & csrf.php
├── auth/
│   ├── proses_login.php            # + session_regenerate_id(true), csrf_verify()
│   └── ...                          # + csrf_field() di form
├── buku/, anggota/
│   ├── list.php, edit.php            # Output dibungkus e()
│   ├── tambah.php, edit.php           # + csrf_field() di form
│   └── proses_*.php, hapus.php        # + csrf_verify()
├── docs/
│   ├── wireframe.md                   # Identik dengan jobsheet-10
│   └── security-checklist.md          # BARU — audit lengkap
├── README.md
└── Dokumentasi/                        # Folder dokumentasi ini
```

**Catatan penting** dari [README.md](../README.md) jobsheet ini: bagian
"Cara menguji" berisi 3 langkah verifikasi konkret (uji CSRF lewat
`curl`, uji XSS dengan menyimpan `<script>alert(1)</script>`, dan uji
urutan guard) — semuanya dibahas ulang di bab-bab berikutnya dan
dirangkum di [bab 6](06-rangkuman-latihan.md).
