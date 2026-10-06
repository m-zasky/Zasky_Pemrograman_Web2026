# 2. XSS & Fungsi `e()`

## 2.1 Apa itu XSS?

**XSS (Cross-Site Scripting)** adalah celah yang memungkinkan
penyerang menyisipkan **kode HTML/JavaScript miliknya sendiri** ke
dalam halaman yang dilihat **pengguna lain** — bukan lewat meretas
server, melainkan lewat data yang **tampak seperti data biasa**
(misalnya judul buku), tapi sebenarnya berisi kode berbahaya.

## 2.2 Contoh Konkret Serangannya

Bayangkan seseorang mengisi form Tambah Buku
([dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md))
dengan judul:
```
<script>alert('halaman ini sudah diretas!')</script>
```

Ingat dari [dokumentasi jobsheet-09 §5.4](../../jobsheet-09/Dokumentasi/05-pagination-dan-pencarian-server.md)
(dan sebelumnya), `buku/list.php` mencetak judul lewat:
```php
<td><?php echo $buku['judul']; ?></td>
```

Kalau `$buku['judul']` berisi teks di atas, `echo` akan mencetaknya
**apa adanya** ke HTML — dan browser yang menerima HTML itu akan
**menjalankan** tag `<script>` itu sebagai kode sungguhan, bukan
menampilkannya sebagai teks. **Setiap** pengunjung yang membuka
`buku/list.php` akan ikut menjalankan skrip itu di browser mereka
sendiri — inilah kenapa disebut "cross-site" (lintas situs/pengguna):
satu input dari satu orang bisa memengaruhi **semua** pengunjung lain.

Contoh `alert()` di atas hanya kotak pesan sederhana untuk demonstrasi
— skrip berbahaya sungguhan bisa mencuri cookie/session pengguna lain,
mengubah tampilan halaman untuk menipu (*phishing*), atau melakukan
aksi lain atas nama pengguna yang sedang login.

## 2.3 Fungsi `e()`: Solusinya

```php
// includes/helpers.php
function e($value)
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}
```

- **`htmlspecialchars(...)`** — fungsi bawaan PHP yang mengubah
  karakter-karakter HTML yang punya makna khusus (`<`, `>`, `&`, `"`,
  `'`) menjadi **HTML entity** — ingat konsep entity dari
  [dokumentasi jobsheet-01 §2.2](../../jobsheet-01/Dokumentasi/02-index-html.md#footer--kaki-halaman)
  (`&copy;`, `&mdash;`). Karakter `<` diubah jadi `&lt;`, `>` jadi
  `&gt;`, dan seterusnya. Hasilnya, teks `<script>...</script>`
  berubah jadi `&lt;script&gt;...&lt;/script&gt;` — browser akan
  menampilkan teks **persis seperti yang diketik** (termasuk tanda
  `<` dan `>`-nya secara harfiah), **bukan** menjalankannya sebagai
  tag HTML sungguhan.
- **`(string) ($value ?? '')`** — ingat type casting `(int)` dari
  [dokumentasi jobsheet-07 §4.5](../../jobsheet-07/Dokumentasi/04-proses-tambah-validasi-server.md#45-kalau-valid-simpan-ke-session--redirect-ke-daftar) —
  di sini `(string)` memaksa nilai apa pun (termasuk `null`) diperlakukan
  sebagai teks, dan `?? ''` (ingat dari
  [dokumentasi jobsheet-07 §1.6](../../jobsheet-07/Dokumentasi/01-konsep-dasar-php.md#16-operator--null-coalescing))
  memberi string kosong sebagai cadangan kalau nilainya `null` — mencegah
  `htmlspecialchars()` menerima nilai yang tidak diharapkannya.
- **`ENT_QUOTES`** — parameter yang memberi tahu `htmlspecialchars()`
  untuk **juga** meng-escape tanda kutip tunggal (`'`) **dan** ganda
  (`"`), bukan cuma salah satunya (perilaku default PHP versi lama
  hanya meng-escape kutip ganda). Ini penting khusus untuk atribut
  seperti `value="..."` ([§2.5](#25-kenapa-atribut-value-juga-butuh-e))
  yang **juga** diapit tanda kutip — kalau data mengandung tanda kutip
  yang sama tanpa di-escape, itu bisa "memutus" atribut HTML lebih
  awal dan menyisipkan atribut/kode baru yang tidak diinginkan.
- **`'UTF-8'`** — parameter *encoding* karakter, memastikan fungsi ini
  menangani karakter non-ASCII (huruf beraksen, dst.) dengan benar.

## 2.4 Di Mana Saja `e()` Dipakai?

Ingat catatan di [README.md](../README.md) jobsheet ini:
*"seluruh output data dari database/`$_GET` (judul, pengarang, nama,
alamat, no_hp, nilai pencarian, nama petugas di navbar) dibungkus
`e()`"*. Bandingkan langsung sebelum/sesudah di `buku/list.php`:

**Sebelumnya (jobsheet-09):**
```php
<td><?php echo $buku['judul']; ?></td>
```

**Sekarang (jobsheet-11):**
```php
<td><?php echo e($buku['judul']); ?></td>
```

Pola yang sama diterapkan di:
- Nilai pencarian: `<input ... value="<?php echo e($keyword); ?>">`
  (ingat `$keyword` dari `$_GET['q']`,
  [dokumentasi jobsheet-09 §5.6](../../jobsheet-09/Dokumentasi/05-pagination-dan-pencarian-server.md#56-pencarian-sisi-server-ilike)) —
  inilah tepatnya celah yang disebutkan **belum diperbaiki** di
  [dokumentasi jobsheet-09 §5.8](../../jobsheet-09/Dokumentasi/05-pagination-dan-pencarian-server.md#58-form-pencarian-methodget),
  sekarang sudah ditutup.
- Nama petugas di navbar: `<span><?php echo e($_SESSION['nama']); ?></span>`
  ([dokumentasi jobsheet-10 §5.5](../../jobsheet-10/Dokumentasi/05-navbar-dinamis-dan-css.md#55-status-login-di-pojok-kanan-auth-status)) —
  penting karena nama ini **awalnya** berasal dari input form
  Registrasi ([dokumentasi jobsheet-10 §2.2](../../jobsheet-10/Dokumentasi/02-skema-users-dan-registrasi.md#22-halaman-registerphp)),
  jadi tetap perlu diperlakukan sebagai data yang berpotensi
  berbahaya.

## 2.5 Kenapa Atribut `value` Juga Butuh `e()`?

```php
<input type="text" id="judul" name="judul" value="<?php echo e($buku['judul']); ?>" required>
```

Ini kasus khusus di form Edit
([dokumentasi jobsheet-09 §2.4](../../jobsheet-09/Dokumentasi/02-edit-update-data.md#24-mengisi-form-dengan-data-lama-atribut-value)):
selain berbahaya kalau dicetak sebagai **isi** elemen (seperti kasus
`<td>` di [§2.4](#24-di-mana-saja-e-dipakai)), teks yang mengandung
tanda kutip ganda (`"`) juga berbahaya kalau dicetak **di dalam**
atribut `value="..."` — tanda kutip yang tidak di-escape bisa
"menutup" atribut itu lebih awal dari yang seharusnya, memungkinkan
penyerang menyisipkan atribut HTML tambahan (misalnya
`onmouseover="kodeJahat()"`) tepat setelahnya. Inilah kenapa
`ENT_QUOTES` di [§2.3](#23-fungsi-e-solusinya) penting — memastikan
tanda kutip di dalam data juga ikut di-escape dengan aman.

## 2.6 Mengapa Kolom `tahun` dan `stok` Tidak Dibungkus `e()`?

Perhatikan di `buku/list.php`:
```php
<td><?php echo $buku['judul']; ?></td>      <!-- salah, seharusnya e() -->
<td><?php echo $buku['tahun']; ?></td>      <!-- tetap begini, tanpa e() -->
```

Ingat dari [dokumentasi jobsheet-08 §2.4](../../jobsheet-08/Dokumentasi/02-skema-database-sql.md#24-mendefinisikan-kolom-nama-tipe-dan-batasan),
kolom `tahun` dan `stok` bertipe `INTEGER` di database — nilainya
**selalu** angka murni, tidak mungkin berisi tag HTML apa pun (database
akan menolak menyimpan teks seperti `<script>` ke kolom bertipe angka).
Karena itu, membungkus keduanya dengan `e()` **tidak salah**, tapi juga
**tidak diperlukan** — `e()` hanya benar-benar penting untuk kolom
bertipe teks (`VARCHAR`) yang **bisa** memuat karakter HTML berbahaya.

## 2.7 Cara Membuktikannya Sendiri

Sesuai [README.md](../README.md) jobsheet ini:

> tambah buku dengan judul `<script>alert(1)</script>` → di Daftar
> Buku harus tampil sebagai teks, bukan pop-up.

Coba lakukan ini sendiri: tambahkan buku dengan judul persis
`<script>alert(1)</script>`, lalu buka `buku/list.php` — kamu akan
melihat **teks** `<script>alert(1)</script>` tertulis apa adanya di
kolom Judul (bukan kotak pop-up `alert()` yang muncul) — bukti nyata
`e()` bekerja.

Lanjut ke: [CSRF & Token Verifikasi](03-csrf-dan-token.md)
