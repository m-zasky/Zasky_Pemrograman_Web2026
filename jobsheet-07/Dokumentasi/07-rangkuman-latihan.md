# 7. Rangkuman & Latihan Lanjutan

## 7.1 Rangkuman Keseluruhan Jobsheet 7

| Bagian | Konsep yang Dipelajari |
|---|---|
| [Konsep Dasar PHP](01-konsep-dasar-php.md) | Server-side vs client-side, tag `<?php ?>`, variabel `$`, `echo`, superglobal, `??` |
| [Includes Header/Footer](02-includes-header-footer.md) | `include`, `__DIR__`, path relatif otomatis (`$base`), sintaks alternatif `if/foreach: endif/endforeach` |
| [Session & Alur Data](03-session-dan-alur-data.md) | `session_start()`, `$_SESSION` sebagai "keranjang" data antar halaman, alur form → proses → tabel |
| [Proses Tambah & Validasi Server](04-proses-tambah-validasi-server.md) | `$_POST`, `is_numeric`, `header('Location: ...')` + `exit`, type casting `(int)` |
| [List.php & Flash Message](05-list-php-render-dan-flash.md) | `unset()` untuk pesan sekali-pakai, `foreach` PHP, rendering di server vs browser |
| [CSS Flash Message](06-css-flash-message.md) | Konvensi warna sukses/gagal |

## 7.2 Konsep Inti yang Perlu Diingat

1. **Server-side berjalan sebelum halaman sampai ke browser** — kode
   PHP tidak pernah terlihat pengguna, hanya hasilnya
   ([bab 1 §1.1](01-konsep-dasar-php.md#11-server-side-vs-client-side-bedanya-apa)).
2. **`include` menghapus duplikasi kode** antar halaman — sekali ubah
   `header.php`, semua halaman yang meng-include-nya ikut berubah
   ([bab 2](02-includes-header-footer.md)).
3. **`$_SESSION` menjembatani data antar permintaan HTTP yang terpisah**
   — tapi sifatnya sementara, hilang saat sesi browser berakhir
   ([bab 3](03-session-dan-alur-data.md)).
4. **Validasi server-side tidak bisa dilewati pengguna**, berbeda dari
   validasi HTML/JavaScript yang keduanya berjalan di browser dan bisa
   dinonaktifkan
   ([bab 4 §4.6](04-proses-tambah-validasi-server.md#46-kenapa-validasi-ini-yang-benar-benar-bisa-diandalkan)).
5. **Redirect setelah POST (`header('Location: ...')` + `exit`)**
   adalah pola umum untuk mencegah data ter-submit ulang kalau pengguna
   me-refresh halaman hasil, dan untuk langsung mengarahkan ke halaman
   yang relevan (form kalau error, daftar kalau sukses)
   ([bab 4 §4.4-4.5](04-proses-tambah-validasi-server.md#44-kalau-ada-error-simpan-flash--redirect-kembali)).
6. **Flash message adalah pola "sekali tampil"** — disimpan lalu segera
   dihapus (`unset`) setelah dibaca, supaya tidak muncul berulang di
   kunjungan berikutnya
   ([bab 5 §5.2](05-list-php-render-dan-flash.md#52-mengambil-dan-menghapus-flash-message)).

## 7.3 Cara Mencoba Sendiri

1. **Jalankan server-nya** (ingat
   [bab 1 §1.7](01-konsep-dasar-php.md#17-menjalankan-php-butuh-server-sungguhan)
   dan [bab 2 §2.3](02-includes-header-footer.md#23-path-relatif-otomatis-di-includesheaderphp) —
   path-nya sudah relatif otomatis, jadi tidak wajib dari folder tertentu):
   ```bash
   php -S localhost:8000
   ```
   Buka `http://localhost:8000/index.php` (atau lewat Laragon, lihat
   [README.md](../README.md) untuk opsi vhost-nya).
2. Klik "Tambah Buku", isi form dengan data valid, klik "Simpan" —
   amati kamu diarahkan ke `list.php` dengan pesan hijau "Buku berhasil
   ditambahkan." di atas tabel, dan buku barumu muncul di baris
   terakhir.
3. Refresh halaman `list.php` — amati pesan hijau tadi **sudah tidak
   muncul lagi** (bukti `unset()` dari
   [bab 5 §5.2](05-list-php-render-dan-flash.md#52-mengambil-dan-menghapus-flash-message)
   bekerja), tapi data bukunya **tetap ada** (karena `$_SESSION['buku']`
   tidak ikut dihapus, hanya `$_SESSION['flash']`).
4. Coba submit form kosong — amati pesan **merah** muncul di
   `tambah.php`, dan tidak ada data baru yang tersimpan.
5. Praktikkan uji dari [README.md](../README.md) jobsheet ini:
   nonaktifkan JavaScript di pengaturan browser, submit form kosong
   lagi — buktikan validasi server tetap bekerja meski JavaScript mati
   total (ingat [bab 4 §4.6](04-proses-tambah-validasi-server.md#46-kenapa-validasi-ini-yang-benar-benar-bisa-diandalkan)).
6. Tutup browser sepenuhnya (bukan cuma tab-nya), buka lagi — amati
   data buku yang tadi kamu tambahkan **sudah hilang** (bukti sifat
   sementara `$_SESSION` dari
   [bab 3 §3.5](03-session-dan-alur-data.md#35-kenapa-data-ini-sementara)).

## 7.4 Ide Latihan Tambahan (Opsional)

1. **Tambah validasi ISBN** di `buku/proses_tambah.php` — misalnya
   memastikan ISBN yang diisi (kalau tidak kosong) hanya berisi angka
   dan tanda hubung, memakai fungsi PHP `preg_match()`.
2. **Tambah flash message di `anggota/proses_tambah.php`** untuk kasus
   yang belum ditangani — bandingkan dengan versi `buku/proses_tambah.php`
   yang sudah divalidasi lebih lengkap (rentang tahun, stok non-negatif)
   — field apa lagi di form anggota yang mungkin perlu aturan validasi
   tambahan?
3. **Buat halaman `debug_session.php`** sementara (untuk latihan, hapus
   setelah selesai) yang menampilkan isi `$_SESSION` mentah lewat
   `<pre><?php print_r($_SESSION); ?></pre>` — cara yang berguna untuk
   "mengintip" langsung apa yang sebenarnya tersimpan di server saat
   belajar.
4. **Tambah tombol "Reset Data"** yang memanggil `session_destroy()`
   untuk mengosongkan seluruh `$_SESSION` secara manual, tanpa perlu
   menutup browser — cari tahu sendiri lewat dokumentasi PHP resmi
   bagaimana fungsi ini bekerja.

Kalau ada bagian yang masih membingungkan, coba baca ulang
[bab 3](03-session-dan-alur-data.md) sambil mempraktikkan langkah 2-3
di [§7.3](#73-cara-mencoba-sendiri) — melihat sendiri data "bertahan"
antar halaman lalu "hilang" setelah browser ditutup adalah cara paling
efektif untuk benar-benar memahami apa itu session.
