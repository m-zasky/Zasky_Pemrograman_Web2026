# 5. Navbar Dinamis & CSS Pendukung

Bab ini membedah perubahan `includes/header.php` — navbar sekarang
"tahu" apakah pengunjungnya sudah login atau belum, dan menyesuaikan
tampilannya secara otomatis.

## 5.1 Kode Lengkap Bagian yang Berubah

```php
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$sudahLogin = isset($_SESSION['user_id']);
?>
...
    <header>
        <h1>SIMPUS-Mini</h1>
        <button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>
        <nav>
            <ul>
                <li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
                <li><a href="<?php echo $base; ?>buku/list.php">Daftar Buku</a></li>
                <?php if ($sudahLogin): ?>
                <li><a href="<?php echo $base; ?>buku/tambah.php">Tambah Buku</a></li>
                <li><a href="<?php echo $base; ?>anggota/list.php">Daftar Anggota</a></li>
                <li><a href="<?php echo $base; ?>anggota/tambah.php">Tambah Anggota</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="auth-status">
            <?php if ($sudahLogin): ?>
                <span><?php echo $_SESSION['nama']; ?></span>
                <a href="<?php echo $base; ?>auth/logout.php">Logout</a>
            <?php else: ?>
                <a href="<?php echo $base; ?>auth/login.php">Login</a>
            <?php endif; ?>
        </div>
    </header>
```

Perhatikan setiap `href` diawali `<?php echo $base; ?>` (tanpa garis
miring `/` di depan sisa path-nya) — `$base` inilah variabel yang
dihitung otomatis di baris-baris paling atas `header.php`, dijelaskan
lengkap di
[dokumentasi jobsheet-07 §2.3](../../jobsheet-07/Dokumentasi/02-includes-header-footer.md#23-path-relatif-otomatis-di-includesheaderphp).
Kalau kamu belum baca bab itu, sebaiknya baca dulu sebelum lanjut —
bab ini (navbar dinamis) berfokus ke bagian **login/logout**-nya saja,
bukan mengulang penjelasan `$base`.

## 5.2 `session_start()` yang Diamankan

```php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
```

Ingat dari [dokumentasi jobsheet-10 §4.4](04-guard-auth-php.md#44-kenapa-session_status-diperiksa-dulu):
`header.php` **juga** perlu tahu status login (untuk menampilkan
`$sudahLogin` di bawah), jadi ia juga memanggil `session_start()` —
tapi dengan pengaman `session_status()` yang sama, supaya tidak
bentrok kalau `auth.php` sudah memanggilnya lebih dulu di halaman yang
terkunci ([dokumentasi jobsheet-10 §4.2](04-guard-auth-php.md#42-cara-memakainya-di-halaman-lain)).

## 5.3 Satu Variabel, Dipakai Berkali-Kali: `$sudahLogin`

```php
$sudahLogin = isset($_SESSION['user_id']);
```

Nilai `true`/`false` ini disimpan **satu kali** ke variabel
`$sudahLogin`, lalu dipakai **berulang** di bawahnya — daripada menulis
`isset($_SESSION['user_id'])` berkali-kali di setiap tempat yang
membutuhkannya. Kebiasaan menyimpan hasil pengecekan ke variabel
seperti ini membuat kode lebih ringkas dan lebih mudah dibaca.

## 5.4 Menu yang Muncul-Hilang: `<?php if ($sudahLogin): ?>`

```php
<li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
<li><a href="<?php echo $base; ?>buku/list.php">Daftar Buku</a></li>
<?php if ($sudahLogin): ?>
<li><a href="<?php echo $base; ?>buku/tambah.php">Tambah Buku</a></li>
<li><a href="<?php echo $base; ?>anggota/list.php">Daftar Anggota</a></li>
<li><a href="<?php echo $base; ?>anggota/tambah.php">Tambah Anggota</a></li>
<?php endif; ?>
```

Ingat sintaks alternatif `if (...): ... endif;` dari
[dokumentasi jobsheet-07 §2.5](../../jobsheet-07/Dokumentasi/02-includes-header-footer.md#25-pola-extra_scripts-untuk-script-tambahan-per-halaman).
Menu "Beranda" dan "Daftar Buku" **selalu tampil** (sesuai dengan
`index.php`/`buku/list.php` yang tetap publik, ingat dari
[dokumentasi jobsheet-10 README](../README.md)). Tiga menu lainnya
(Tambah Buku, Daftar Anggota, Tambah Anggota) hanya muncul kalau
`$sudahLogin` bernilai `true` — **konsisten** dengan halaman mana saja
yang sebenarnya dikunci oleh `auth.php`
([dokumentasi jobsheet-10 §4.7](04-guard-auth-php.md#47-halaman-mana-saja-yang-memakai-guard-ini)).

**Catatan penting:** menyembunyikan menu ini di navbar **bukan**
mekanisme keamanan itu sendiri — ini murni **kenyamanan tampilan**
(tidak menampilkan tautan ke halaman yang toh akan menolak akses
Tamu). Proteksi sesungguhnya tetap `includes/auth.php`
([bab 4](04-guard-auth-php.md)) — bahkan kalau seseorang mengetik
`/buku/tambah.php` **langsung** di address bar tanpa mengklik menu apa
pun, `auth.php` tetap akan mengalihkannya ke Login.

## 5.5 Status Login di Pojok Kanan: `.auth-status`

```php
<div class="auth-status">
    <?php if ($sudahLogin): ?>
        <span><?php echo $_SESSION['nama']; ?></span>
        <a href="<?php echo $base; ?>auth/logout.php">Logout</a>
    <?php else: ?>
        <a href="<?php echo $base; ?>auth/login.php">Login</a>
    <?php endif; ?>
</div>
```

- Kalau **sudah login**: menampilkan nama petugas (`$_SESSION['nama']`,
  ingat disimpan saat Login di
  [dokumentasi jobsheet-10 §3.2](03-login-dan-logout.md#32-proses_loginphp-memverifikasi-password))
  dan tautan Logout.
- Kalau **belum login**: menampilkan tautan Login saja.

Ini **persis** mewujudkan wireframe Dashboard yang sudah kamu bedah
sejak [dokumentasi jobsheet-04 §2.3](../../jobsheet-04/Dokumentasi/02-cara-membaca-wireframe.md#23-wireframe-yang-lebih-kompleks-dashboard-petugas):
*"(Nama Petugas) Logout"* — potongan wireframe yang saat itu masih
berupa teks ASCII kini benar-benar ditampilkan dari data session
sungguhan.

## 5.6 CSS Pendukung: `.auth-status`

```css
.auth-status {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #fff;
}

.auth-status a {
    color: #fff;
    text-decoration: underline;
}
```

- **`display: flex; align-items: center; gap: 0.75rem;`** — ingat
  Flexbox dari [dokumentasi jobsheet-02 §4](../../jobsheet-02/Dokumentasi/04-css-header-navbar-flexbox.md):
  menyusun nama petugas dan tautan Logout (atau tautan Login saja)
  sejajar horizontal dengan jarak rapi, sejajar secara vertikal dengan
  elemen lain di header.
- **`color: #fff`** — teks putih, konsisten dengan warna teks navbar
  lain di header biru tema ([dokumentasi jobsheet-02 §4.6](../../jobsheet-02/Dokumentasi/04-css-header-navbar-flexbox.md#46-flexbox-bertingkat-navbar-di-dalam-header)).
- **`.auth-status a { text-decoration: underline; }`** — tautan Login/
  Logout di sini sengaja **diberi** garis bawah (berbeda dari tautan
  menu navbar utama yang tidak bergaris bawah, ingat dari
  [dokumentasi jobsheet-02 §4.6](../../jobsheet-02/Dokumentasi/04-css-header-navbar-flexbox.md#46-flexbox-bertingkat-navbar-di-dalam-header)) —
  memberi sedikit pembeda visual bahwa area ini adalah "status akun",
  terpisah secara fungsi dari menu navigasi biasa.

Lanjut ke: [Rangkuman & Latihan Lanjutan](06-rangkuman-latihan.md)
