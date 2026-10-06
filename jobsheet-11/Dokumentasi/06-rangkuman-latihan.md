# 6. Rangkuman & Latihan Lanjutan

## 6.1 Rangkuman Keseluruhan Jobsheet 11

| Bagian | Konsep yang Dipelajari |
|---|---|
| [Konsep Dasar Keamanan](01-konsep-dasar-keamanan-web.md) | 5 kerentanan yang diaudit, prinsip "jangan percaya input dari luar" |
| [XSS & `e()`](02-xss-dan-fungsi-e.md) | `htmlspecialchars()`, `ENT_QUOTES`, kenapa output data perlu di-escape |
| [CSRF & Token](03-csrf-dan-token.md) | `random_bytes()`, `hash_equals()`, token per-sesi, urutan guard vs csrf |
| [Session Fixation](04-session-fixation.md) | `session_regenerate_id(true)`, kenapa dipanggil tepat setelah login |
| [Audit SQLi & Checklist](05-audit-sql-injection-dan-checklist.md) | Kenapa prepared statement sejak jobsheet-08 sudah cukup, format laporan audit |

## 6.2 Konsep Inti yang Perlu Diingat

1. **Audit keamanan bisa menghasilkan "sudah aman," bukan cuma
   perbaikan baru** — SQL injection dan validasi input di jobsheet ini
   dikonfirmasi aman, bukan ditulis ulang dari nol
   ([bab 1 §1.2](01-konsep-dasar-keamanan-web.md#12-lima-kerentanan-yang-diaudit-di-jobsheet-ini)).
2. **Selalu escape data sebelum dicetak ke HTML**, terutama data yang
   pernah melewati input pengguna (form, `$_GET`) — `e()` menjadi
   kebiasaan yang harus otomatis dilakukan setiap kali menulis
   `<?php echo ...; ?>` untuk data semacam itu
   ([bab 2](02-xss-dan-fungsi-e.md)).
3. **Metode `POST` saja tidak cukup mencegah CSRF** — token per-sesi
   yang diverifikasi lewat `hash_equals()` adalah lapisan proteksi
   tambahan yang benar-benar dibutuhkan
   ([bab 3](03-csrf-dan-token.md)).
4. **Regenerasi ID sesi tepat setelah login** menutup celah session
   fixation — perbaikan kecil di titik yang presisi
   ([bab 4](04-session-fixation.md)).
5. **Laporan audit yang baik selalu menyertakan bukti pengujian
   konkret** (before/after, langkah verifikasi), bukan sekadar klaim
   "sudah diperbaiki"
   ([bab 5 §5.5](05-audit-sql-injection-dan-checklist.md#55-membaca-docssecurity-checklistmd-secara-utuh)).

## 6.3 Cara Mencoba Sendiri

Ikuti ketiga langkah pengujian dari [README.md](../README.md) jobsheet
ini, satu per satu:

1. **Uji CSRF**: login lewat browser, lalu jalankan di terminal:
   ```bash
   curl -X POST http://localhost:8000/buku/proses_tambah.php -d "judul=x"
   ```
   Amati responsnya berupa pesan penolakan dengan status HTTP 403
   (ingat [bab 3 §3.8](03-csrf-dan-token.md#38-cara-membuktikannya-sendiri)).
2. **Uji XSS**: tambahkan buku dengan judul `<script>alert(1)</script>`,
   buka `buku/list.php` — amati teks itu tampil apa adanya, **tidak**
   ada kotak pop-up yang muncul (ingat
   [bab 2 §2.7](02-xss-dan-fungsi-e.md#27-cara-membuktikannya-sendiri)).
3. **Uji urutan guard**: coba akses `buku/proses_tambah.php` lewat
   `POST` **tanpa login sama sekali** (misalnya lewat `curl` di
   browser/terminal yang belum pernah login) — amati kamu tetap
   diarahkan ke halaman Login, membuktikan `auth.php` benar-benar
   berjalan **sebelum** `csrf_verify()` (ingat
   [bab 3 §3.7](03-csrf-dan-token.md#37-memanggil-csrf_verify-di-awal-setiap-proses)).
4. **Uji SQL injection**: coba login dengan username `' OR '1'='1`
   dan password apa saja — amati tetap muncul "Username atau password
   salah" (ingat [bab 5 §5.3](05-audit-sql-injection-dan-checklist.md#53-mencoba-sendiri-uji--or-11)).

## 6.4 Ide Latihan Tambahan (Opsional)

1. **Tambah proteksi CSRF ke form pencarian** — form `method="get"` di
   `buku/list.php`
   ([dokumentasi jobsheet-09 §5.8](../../jobsheet-09/Dokumentasi/05-pagination-dan-pencarian-server.md#58-form-pencarian-methodget))
   **sengaja tidak** diberi token CSRF — diskusikan sendiri kenapa: apa
   bedanya risiko form `GET` (yang hanya membaca data) dengan form
   `POST` (yang mengubah data) dalam konteks serangan CSRF?
2. **Tambah baris baru ke `security-checklist.md`** — audit satu
   bagian aplikasi yang belum eksplisit disebutkan (misalnya:
   "Apakah pesan error PHP mentah pernah bocor ke pengguna, membocorkan
   detail struktur database/server?"), lengkap dengan kolom Sebelum/
   Sesudah seperti baris-baris lainnya.
3. **Terapkan `e()` di halaman yang belum diperiksa** — telusuri
   sendiri apakah ada tempat lain di aplikasi (di luar yang disebutkan
   di [README.md](../README.md)) yang mencetak data dari database/
   `$_GET`/`$_POST` tanpa dibungkus `e()`.
4. **Pelajari `Content-Security-Policy` (CSP)** — cari tahu lewat
   dokumentasi web resmi bagaimana header HTTP ini bisa menjadi
   **lapisan pertahanan tambahan** terhadap XSS, bahkan seandainya ada
   satu tempat yang lolos dari `e()` tanpa sengaja.

Kalau ada bagian yang masih membingungkan, terutama soal CSRF di
[bab 3](03-csrf-dan-token.md) — konsep ini memang salah satu yang
paling abstrak di seluruh rangkaian jobsheet — coba baca ulang sambil
mempraktikkan langsung uji `curl` di [§6.3](#63-cara-mencoba-sendiri)
poin 1 dan 3, membandingkan responsnya satu sama lain untuk melihat
sendiri bagaimana dua lapisan proteksi (login **dan** token CSRF)
bekerja terpisah namun saling melengkapi.
