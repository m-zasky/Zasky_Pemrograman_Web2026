# 3. CSRF & Token Verifikasi

Ini bab paling teknis di jobsheet ini — melibatkan mekanisme yang
belum pernah kamu lihat sebelumnya: **token** sekali pakai per sesi.

## 3.1 Apa itu CSRF?

**CSRF (Cross-Site Request Forgery)** adalah celah yang memungkinkan
**situs lain** memicu sebuah permintaan (misalnya menghapus buku) ke
aplikasi ini, **atas nama** pengguna yang sedang login — tanpa
pengguna itu sadar atau bermaksud melakukannya.

## 3.2 Contoh Konkret Serangannya

Bayangkan kamu sedang login di SIMPUS-Mini, lalu tanpa sengaja membuka
sebuah situs jahat di tab lain. Situs jahat itu berisi HTML seperti:

```html
<form action="http://localhost:8000/buku/hapus.php" method="post" id="jahat">
    <input type="hidden" name="id" value="1">
</form>
<script>document.getElementById('jahat').submit();</script>
```

Ingat dari [dokumentasi jobsheet-09 §3](../../jobsheet-09/Dokumentasi/03-hapus-delete-data.md),
`hapus.php` sudah diproteksi supaya **hanya** menerima `POST` (bukan
`GET`) — tapi form di atas **juga** memakai `method="post"`! Browser
tidak peduli form itu berasal dari situs mana pun — kalau kamu sedang
login (session aktif tersimpan di cookie browser), browser akan tetap
menyertakan cookie session itu ke permintaan `POST` ini, membuat server
mengira ini adalah permintaan sah dari kamu sendiri. Perlindungan
`$_SERVER['REQUEST_METHOD'] !== 'POST'` ([dokumentasi jobsheet-09 §3.3](../../jobsheet-09/Dokumentasi/03-hapus-delete-data.md#33-memeriksa-metode-http-_serverrequest_method))
**tidak cukup** untuk mencegah skenario ini — itulah kenapa dibutuhkan
lapisan proteksi baru: **token CSRF**.

## 3.3 Ide Dasar Token CSRF

Solusinya: setiap form `POST` yang **sah** (dibuat oleh aplikasi ini
sendiri) disisipi sebuah **token rahasia** — deretan karakter acak yang
**hanya** diketahui server dan halaman yang benar-benar dibuka dari
aplikasi ini. Saat form itu di-submit, server memeriksa apakah token
yang dikirim **cocok** dengan token yang seharusnya. Situs jahat di
[§3.2](#32-contoh-konkret-serangannya) **tidak mungkin tahu** token ini
(karena token dibuat ulang tiap sesi dan tidak pernah "bocor" ke situs
lain), sehingga form palsu buatannya akan **ditolak** server meski
cookie session-nya valid.

## 3.4 Membuat Token: `csrf_token()`

```php
function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
```

- **`random_bytes(32)`** — fungsi PHP bawaan yang menghasilkan **32
  byte data acak** yang **kriptografis aman** (dirancang khusus supaya
  tidak bisa ditebak polanya, berbeda dari fungsi acak biasa seperti
  `rand()` yang tidak cocok untuk keperluan keamanan).
- **`bin2hex(...)`** — mengubah data biner acak itu menjadi teks
  heksadesimal (karakter `0-9` dan `a-f`) — supaya aman disisipkan ke
  HTML sebagai nilai atribut biasa.
- **`empty($_SESSION['csrf_token'])`** — token **hanya dibuat sekali**
  per sesi: kalau sudah ada token tersimpan di `$_SESSION` dari
  kunjungan sebelumnya, token itu yang dipakai ulang (bukan membuat
  token baru setiap kali fungsi ini dipanggil) — supaya token yang sama
  bisa dipakai berkali-kali selama sesi itu masih aktif, dan tidak
  berubah-ubah setiap halaman yang dibuka.
- Token disimpan ke **`$_SESSION['csrf_token']`** — ingat konsep
  `$_SESSION` sebagai penyimpanan khusus per-pengunjung dari
  [dokumentasi jobsheet-07 §3](../../jobsheet-07/Dokumentasi/03-session-dan-alur-data.md) —
  inilah kenapa token ini **unik per sesi**: setiap pengunjung (setiap
  sesi browser) punya token acaknya sendiri, tidak dibagi dengan
  pengunjung lain.

## 3.5 Menyisipkan Token ke Form: `csrf_field()`

```php
function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}
```

- Menghasilkan **satu baris HTML** berupa `<input type="hidden">` —
  ingat konsep input tersembunyi ini dari
  [dokumentasi jobsheet-09 §2.5](../../jobsheet-09/Dokumentasi/02-edit-update-data.md#25-kotak-tersembunyi-input-typehidden-nameid),
  dipakai untuk membawa data (`id` baris) tanpa perlu ditampilkan ke
  pengguna. Di sini polanya sama: token CSRF **tidak perlu dilihat**
  pengguna, tapi **wajib** ikut terkirim bersama form.
- Dipakai di HTML dengan `<?php echo csrf_field(); ?>`, ditulis **di
  dalam** setiap `<form method="post">` — ingat dari [README.md](../README.md)
  jobsheet ini: dipasang di form Tambah/Edit/Hapus Buku & Anggota,
  Login, dan Register.

## 3.6 Memverifikasi Token: `csrf_verify()`

```php
function csrf_verify()
{
    $token = $_POST['csrf_token'] ?? '';
    if ($token === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        die('Permintaan ditolak: token CSRF tidak valid atau kedaluwarsa.');
    }
}
```

- **`$token = $_POST['csrf_token'] ?? ''`** — mengambil token yang
  **dikirim** bersama form (dari `<input type="hidden" name="csrf_token">`
  di [§3.5](#35-menyisipkan-token-ke-form-csrf_field)).
- **`hash_equals($_SESSION['csrf_token'] ?? '', $token)`** — fungsi PHP
  khusus untuk **membandingkan dua string secara aman**, dirancang
  supaya waktu eksekusinya **selalu sama** tidak peduli seberapa mirip
  kedua string itu. Ini penting secara teknis: perbandingan biasa
  (`===`) pada string bisa (dalam kasus yang sangat jarang dan sulit
  dieksploitasi) membocorkan informasi lewat **perbedaan waktu proses**
  antara percobaan yang "hampir benar" dan yang "sangat salah" —
  `hash_equals()` menutup celah teoretis ini, praktik yang baik khusus
  untuk membandingkan data sensitif seperti token keamanan.
- **`http_response_code(403)`** — mengatur kode status HTTP respons
  jadi **403 Forbidden**, kode standar yang berarti "server memahami
  permintaanmu, tapi menolak untuk memprosesnya" — kode yang tepat
  untuk kasus ini (beda dari status 404 "tidak ditemukan", atau 500
  "error server").
- **`die('...')`** — ingat fungsi ini dari
  [dokumentasi jobsheet-08 §4.4](../../jobsheet-08/Dokumentasi/04-koneksi-pdo.md#44-menangani-kegagalan-koneksi):
  menghentikan eksekusi **seketika**, memastikan **tidak ada** kode
  setelahnya (seperti `INSERT`/`UPDATE`/`DELETE` ke database) yang
  sempat berjalan kalau token tidak valid.

## 3.7 Memanggil `csrf_verify()` di Awal Setiap Proses

```php
// buku/proses_tambah.php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$judul = trim($_POST['judul'] ?? '');
// ...
```

Perhatikan **urutannya**: `auth.php` (guard login,
[dokumentasi jobsheet-10 §4](../../jobsheet-10/Dokumentasi/04-guard-auth-php.md))
dipanggil **lebih dulu**, baru `csrf.php`, baru `csrf_verify()`
dipanggil. Ingat catatan penting di
[`docs/security-checklist.md`](../docs/security-checklist.md):

> Guard `includes/auth.php` selalu dijalankan **sebelum**
> `includes/csrf.php` di halaman proses — memastikan pengguna yang
> belum login tidak bisa memicu pengecekan CSRF sama sekali (langsung
> di-redirect ke login).

Urutan ini konsisten dengan prinsip "guard clause paling penting
duluan" yang sudah dibahas di
[dokumentasi jobsheet-10 §4.3](../../jobsheet-10/Dokumentasi/04-guard-auth-php.md#43-kenapa-harus-jadi-baris-paling-pertama) —
tidak ada gunanya memeriksa token CSRF untuk pengunjung yang bahkan
belum login sama sekali.

## 3.8 Cara Membuktikannya Sendiri

Sesuai [README.md](../README.md) jobsheet ini:

> login, lalu coba kirim `curl -X POST http://localhost:8000/buku/proses_tambah.php -d "judul=x"`
> tanpa `csrf_token` → harus mendapat HTTP 403.

`curl` di sini mensimulasikan "situs jahat" dari
[§3.2](#32-contoh-konkret-serangannya) — mengirim `POST` langsung tanpa
melalui form asli aplikasi (sehingga tidak menyertakan `csrf_token`
yang benar). Coba jalankan perintah ini sendiri (setelah login lewat
browser di sesi yang sama) — kamu akan menerima halaman berisi pesan
"Permintaan ditolak: token CSRF tidak valid atau kedaluwarsa." dengan
status HTTP 403, **bukan** data buku baru yang berhasil tersimpan.

Lanjut ke: [Session Fixation](04-session-fixation.md)
