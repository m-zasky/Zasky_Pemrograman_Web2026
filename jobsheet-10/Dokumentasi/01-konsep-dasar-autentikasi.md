# 1. Konsep Dasar Autentikasi & Otorisasi

## 1.1 Autentikasi vs Otorisasi: Dua Istilah yang Sering Tertukar

| Istilah | Pertanyaan yang Dijawab | Contoh di Jobsheet Ini |
|---|---|---|
| **Autentikasi** (*authentication*) | "Kamu **siapa**?" | Proses Login — memverifikasi username & password ([bab 3](03-login-dan-logout.md)) |
| **Otorisasi** (*authorization*) | "Kamu **boleh** melakukan apa?" | `includes/auth.php` — memeriksa apakah pengunjung boleh membuka halaman tertentu ([bab 4](04-guard-auth-php.md)) |

Ingat istilah "otorisasi" sudah disinggung sejak
[dokumentasi jobsheet-04 §4.4](../../jobsheet-04/Dokumentasi/04-aktor-dan-otorisasi.md#44-apa-itu-otorisasi-dan-kenapa-belum-ada-di-jobsheet-ini) —
saat itu dijelaskan otorisasi **belum bisa** dibangun karena baru
sebatas HTML/CSS statis. Sekarang, dengan PHP dan `$_SESSION` yang
sudah kamu kuasai sejak jobsheet-07, keduanya **sama-sama** bisa
diwujudkan: autentikasi lewat Login, otorisasi lewat guard clause di
[bab 4](04-guard-auth-php.md).

## 1.2 Kenapa Password Tidak Boleh Disimpan Apa Adanya?

Bayangkan tabel `users` menyimpan password **persis seperti yang
diketik** pengguna (disebut *plaintext*). Kalau suatu saat database
ini bocor (diretas, di-backup ke tempat yang tidak aman, dll.),
**semua** password pengguna langsung diketahui pihak yang tidak
berhak — dan karena banyak orang memakai password yang sama di
berbagai layanan, kebocoran ini bisa berdampak jauh melampaui aplikasi
SIMPUS-Mini itu sendiri.

**Hashing** adalah solusinya: password diubah lewat fungsi matematika
satu arah menjadi "acakan" karakter yang **tidak bisa dikembalikan**
ke password aslinya. PHP punya fungsi bawaan untuk ini:

- **`password_hash($password, PASSWORD_DEFAULT)`** — mengubah password
  asli jadi hash, dipakai saat Registrasi ([bab 2](02-skema-users-dan-registrasi.md)).
- **`password_verify($password, $hash)`** — memeriksa apakah sebuah
  password **cocok** dengan hash yang tersimpan, **tanpa** perlu
  mengetahui password aslinya — dipakai saat Login ([bab 3](03-login-dan-logout.md)).

Detail cara kerja kedua fungsi ini dibahas di bab-bab berikutnya.

## 1.3 Kolom `password` Bertipe `VARCHAR(255)` — Bukan Kebetulan

Ingat dari [dokumentasi jobsheet-08 §2.4](../../jobsheet-08/Dokumentasi/02-skema-database-sql.md#24-mendefinisikan-kolom-nama-tipe-dan-batasan),
`VARCHAR(255)` membatasi panjang teks maksimal 255 karakter. Hasil dari
`password_hash()` — dibahas di [bab 2](02-skema-users-dan-registrasi.md) —
selalu berupa teks acakan yang **panjang** (biasanya sekitar 60
karakter untuk algoritma default PHP saat ini, tapi bisa berbeda
tergantung algoritma yang dipakai `PASSWORD_DEFAULT` di masa depan).
`VARCHAR(255)` sengaja dipilih **cukup longgar** supaya muat menampung
hash ini, **berapa pun** panjang persisnya.

## 1.4 Session: Mengingat "Siapa yang Login" Antar Halaman

Ingat konsep session dari
[dokumentasi jobsheet-07 §3](../../jobsheet-07/Dokumentasi/03-session-dan-alur-data.md):
`$_SESSION` menjembatani data antar permintaan HTTP yang terpisah. Di
jobsheet-07, `$_SESSION` dipakai menyimpan **data buku/anggota**
sementara. Di jobsheet ini, `$_SESSION` dipakai untuk tujuan yang **jauh
lebih umum** dalam pengembangan web: menyimpan **identitas pengguna
yang sedang login** (`$_SESSION['user_id']`, `$_SESSION['nama']`,
`$_SESSION['role']` — dibahas di [bab 3](03-login-dan-logout.md)), supaya
server "ingat" siapa yang sedang mengunjungi di **setiap** halaman
berikutnya, tanpa pengguna perlu login ulang di setiap klik.

Dengan bekal konsep ini, kamu siap membaca implementasi sungguhannya
mulai bab 2.

Lanjut ke: [Tabel `users` & Registrasi](02-skema-users-dan-registrasi.md)
