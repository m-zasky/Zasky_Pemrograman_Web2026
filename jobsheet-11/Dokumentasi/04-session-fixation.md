# 4. Session Fixation

Perbaikan paling ringkas di jobsheet ini — **satu baris kode** — tapi
butuh pemahaman konsep session yang cukup mendalam untuk mengerti
kenapa baris itu penting.

## 4.1 Apa itu Session Fixation?

**Session fixation** adalah serangan di mana penyerang **memaksa**
korban memakai **ID sesi yang sudah diketahui penyerang**, lalu
menunggu korban login memakai ID sesi itu — begitu korban login,
penyerang (yang sudah tahu ID sesi itu sejak awal) bisa **ikut memakai**
sesi yang sama, seolah-olah dia juga sudah login sebagai korban.

## 4.2 Kenapa Ini Bisa Terjadi?

Ingat dari [dokumentasi jobsheet-07 §3.1](../../jobsheet-07/Dokumentasi/03-session-dan-alur-data.md#31-apa-itu-session),
server memberi setiap pengunjung sebuah "tanda pengenal" unik (ID
sesi) untuk mengingat mereka antar halaman. Secara default, **satu** ID
sesi yang sama bisa saja tetap dipakai **sebelum** dan **sesudah**
proses login — artinya, kalau seseorang entah bagaimana sudah tahu ID
sesi seorang pengunjung **sebelum** pengunjung itu login (misalnya
lewat tautan yang sudah menyertakan ID sesi tertentu, atau celah teknis
lain di luar cakupan jobsheet ini), ID sesi yang sama itu akan **tetap
valid** dan terhubung ke akun korban setelah korban berhasil login —
tanpa server pernah "mengganti" identitas sesi itu pada momen penting
(saat login) tersebut.

## 4.3 Solusi: `session_regenerate_id(true)`

```php
// auth/proses_login.php
if ($user && password_verify($password, $user['password'])) {
    // Regenerasi session ID setelah login berhasil untuk mencegah session fixation.
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];
    header('Location: ../index.php');
    exit;
}
```

- **`session_regenerate_id(true)`** — fungsi PHP bawaan yang
  **mengganti** ID sesi saat ini dengan ID sesi **baru** yang benar-
  benar acak, sambil **mempertahankan** seluruh data `$_SESSION` yang
  sudah ada (data tidak hilang, hanya "label pengenal"-nya yang
  berganti).
- Argumen **`true`** memberi tahu PHP untuk **menghapus** data sesi
  lama yang terkait dengan ID sesi sebelumnya di sisi server — tanpa
  ini, ID sesi lama (yang mungkin sudah "diketahui" penyerang) masih
  bisa dipakai untuk mengakses data yang sama untuk sementara.
- Dipanggil **tepat setelah** `password_verify()` berhasil (ingat
  fungsi ini dari
  [dokumentasi jobsheet-10 §3.2](../../jobsheet-10/Dokumentasi/03-login-dan-logout.md#32-proses_loginphp-memverifikasi-password)),
  **sebelum** `$_SESSION['user_id']` dan data lain diisi. Urutan ini
  penting: ID sesi "lama" (yang berpotensi sudah diketahui pihak lain
  sebelum korban login) **dibuang** tepat pada momen paling kritis —
  transisi dari "belum login" ke "sudah login" — sebelum data penting
  apa pun (identitas pengguna yang login) disimpan ke sesi itu.

## 4.4 Kenapa Baris Ini Tidak Ada di Registrasi/Logout?

Perhatikan `session_regenerate_id(true)` **hanya** dipanggil di
`proses_login.php`, tidak di `proses_register.php` maupun
`logout.php`. Ini masuk akal:

- **Registrasi** ([dokumentasi jobsheet-10 §2.3](../../jobsheet-10/Dokumentasi/02-skema-users-dan-registrasi.md#23-proses_registerphp-validasi--password-hashing))
  tidak langsung membuat pengguna **login** — setelah mendaftar,
  pengguna diarahkan ke halaman Login ([dokumentasi jobsheet-10 §3.4](../../jobsheet-10/Dokumentasi/03-login-dan-logout.md#34-alur-lengkap-registrasi--login--logout)),
  jadi tidak ada transisi "belum login → sudah login" yang perlu
  diamankan di titik ini.
- **Logout** ([dokumentasi jobsheet-10 §3.3](../../jobsheet-10/Dokumentasi/03-login-dan-logout.md#33-authlogoutphp-mengakhiri-sesi))
  memanggil `session_destroy()` yang **menghapus total** seluruh data
  sesi — sesi itu sendiri sudah "berakhir," tidak ada lagi yang perlu
  diregenerasi.

Perbaikan ini konsisten dengan pola yang sudah kamu lihat berkali-kali:
kadang solusi keamanan yang tepat justru **sangat kecil** (satu baris
kode di satu titik yang presisi), asalkan **ditempatkan di titik yang
benar** dalam alur program.

Lanjut ke: [Audit SQL Injection & Security Checklist](05-audit-sql-injection-dan-checklist.md)
