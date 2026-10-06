# 5. Audit SQL Injection & Security Checklist

Bab ini membahas dua kerentanan yang **ternyata sudah aman** sejak
jobsheet sebelumnya, dan bagaimana `docs/security-checklist.md`
mendokumentasikan seluruh audit jobsheet ini secara terstruktur.

## 5.1 Apa itu SQL Injection?

**SQL Injection** adalah celah yang memungkinkan penyerang **mengubah
makna** sebuah query SQL dengan menyisipkan potongan SQL tambahan lewat
input form. Ingat contoh konkretnya sudah dibahas di
[dokumentasi jobsheet-08 §5.3](../../jobsheet-08/Dokumentasi/05-insert-prepared-statement.md#53-apa-itu-prepared-statement-dan-kenapa-penting):
kalau sebuah query dibangun dengan **menggabungkan** teks input
langsung (`"... VALUES ('" . $judul . "')"`), input yang berisi tanda
kutip dan potongan SQL bisa mengacaukan struktur query aslinya.

## 5.2 Kenapa Sudah Aman Sejak Jobsheet-08?

Ingat dari [dokumentasi jobsheet-08 §5](../../jobsheet-08/Dokumentasi/05-insert-prepared-statement.md),
**setiap** query di aplikasi ini — `INSERT`, `SELECT ... WHERE`,
`UPDATE`, `DELETE` — sejak jobsheet-08 selalu ditulis memakai
**prepared statement** (`$pdo->prepare()` + placeholder `:parameter`
+ `execute([...])`), bukan menggabung string. Ini artinya nilai yang
dikirim lewat `$_POST`/`$_GET` **tidak pernah** diperlakukan sebagai
bagian dari perintah SQL — selalu murni sebagai **data**. Audit di
jobsheet ini **memeriksa ulang** semua query di `buku/`, `anggota/`,
`auth/` untuk memastikan **tidak ada satu pun** yang menyimpang dari
pola ini, sesuai catatan di
[`docs/security-checklist.md`](../docs/security-checklist.md):

> Diaudit ulang, sudah aman — tidak ada satupun query yang
> menyisipkan `$_POST`/`$_GET` langsung ke string SQL. Diuji input
> `' OR '1'='1` di form login → tidak berhasil bypass.

## 5.3 Mencoba Sendiri: Uji `' OR '1'='1`

`' OR '1'='1` adalah contoh klasik percobaan SQL injection — kalau
sebuah query login dibangun dengan penggabungan string yang tidak
aman, seperti:
```php
// CONTOH TIDAK AMAN — bukan cara aplikasi ini menulis query
"SELECT * FROM users WHERE username = '" . $username . "'"
```
memasukkan `' OR '1'='1` sebagai username bisa mengubah query itu
menjadi secara efektif "cocokkan baris mana pun" (karena `'1'='1'`
selalu bernilai benar), berpotensi melewati pengecekan login sama
sekali tanpa perlu tahu password siapa pun.

Ingat dari [dokumentasi jobsheet-10 §3.2](../../jobsheet-10/Dokumentasi/03-login-dan-logout.md#32-proses_loginphp-memverifikasi-password),
query login aplikasi ini ditulis:
```php
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
```
Karena `:username` adalah placeholder prepared statement, isi
`$username` — apa pun isinya, termasuk `' OR '1'='1` — selalu
diperlakukan sebagai **satu nilai teks utuh** yang dicari persis di
kolom `username`, bukan bagian dari struktur query. Kalau kamu mencoba
login dengan username `' OR '1'='1`, hasilnya tetap "Username atau
password salah" — bukti nyata prepared statement bekerja.

## 5.4 Audit Validasi & Sanitasi Input

Ingat dari [`docs/security-checklist.md`](../docs/security-checklist.md),
kerentanan #4 juga **sudah ada** sejak jobsheet-07/08/09 (validasi tipe
lewat `is_numeric()`, wajib-isi lewat pengecekan `=== ''`). Satu
perbaikan kecil ditambahkan di jobsheet ini:

```php
// buku/edit.php
<input type="hidden" name="id" value="<?php echo (int) $buku['id']; ?>">
```

Bandingkan dengan versi jobsheet-09
([dokumentasi jobsheet-09 §2.5](../../jobsheet-09/Dokumentasi/02-edit-update-data.md#25-kotak-tersembunyi-input-typehidden-nameid))
yang mencetak `$buku['id']` **tanpa** type casting. Menambahkan
**`(int)`** secara eksplisit di sini memastikan nilai yang disisipkan
ke `value="..."` **selalu** berupa angka murni — lapisan pengaman
tambahan meski `$buku['id']` pada praktiknya memang selalu angka
(berasal dari kolom `SERIAL`, ingat dari
[dokumentasi jobsheet-08 §2.4](../../jobsheet-08/Dokumentasi/02-skema-database-sql.md#24-mendefinisikan-kolom-nama-tipe-dan-batasan)).

## 5.5 Membaca `docs/security-checklist.md` Secara Utuh

Dokumen ini adalah **laporan audit terstruktur** — format yang umum
dipakai dalam pekerjaan keamanan sungguhan (bukan sekadar catatan
biasa seperti README):

| Kolom | Isinya |
|---|---|
| `#` | Nomor urut kerentanan |
| `Kerentanan` | Nama celah keamanan yang diperiksa |
| `Ditemukan di` | File-file yang relevan/terdampak |
| `Sebelum` | Kondisi kode **sebelum** audit/perbaikan |
| `Sesudah (perbaikan)` | Apa yang dilakukan, plus **bukti** bahwa perbaikan itu benar-benar bekerja |

Pola "Sebelum vs Sesudah, disertai bukti pengujian konkret" ini
**bukan sekadar formalitas** — ini kebiasaan penting dalam pekerjaan
keamanan sungguhan: klaim "sudah aman" tanpa bukti pengujian nyata
tidak banyak bergerak nilainya. Setiap baris di checklist ini bisa
kamu **verifikasi ulang sendiri** mengikuti langkah pengujian yang
disebutkan (misalnya `' OR '1'='1` untuk SQL injection,
`<script>alert(1)</script>` untuk XSS).

Bagian "Catatan Implementasi" di akhir dokumen juga mendokumentasikan
**keputusan desain penting** yang sudah dibahas di
[bab 3 §3.7](03-csrf-dan-token.md#37-memanggil-csrf_verify-di-awal-setiap-proses) —
urutan `auth.php` sebelum `csrf.php` — sebagai bagian resmi dari
catatan audit, bukan cuma komentar kode biasa.

Lanjut ke: [Rangkuman & Latihan Lanjutan](06-rangkuman-latihan.md)
