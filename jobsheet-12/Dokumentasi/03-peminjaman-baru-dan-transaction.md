# 3. Peminjaman Baru & Database Transaction

Bab paling teknis di jobsheet ini — menggabungkan transaction database
dengan penguncian baris (`FOR UPDATE`) untuk mencegah race condition.

## 3.1 `peminjaman/tambah.php`: Menyiapkan Dropdown

```php
$daftarAnggota = $pdo->query("SELECT * FROM anggota ORDER BY nama")->fetchAll(PDO::FETCH_ASSOC);
$daftarBukuTersedia = $pdo->query("SELECT * FROM buku WHERE stok > 0 ORDER BY judul")->fetchAll(PDO::FETCH_ASSOC);
```

- **`SELECT * FROM buku WHERE stok > 0`** — inilah kode yang mewujudkan
  aturan bisnis yang sudah dirancang sejak
  [dokumentasi jobsheet-04 §5.5](../../jobsheet-04/Dokumentasi/05-keterhubungan-dengan-kode.md#55-edge-case-yang-sudah-dicatat-sejak-sekarang):
  *"Buku stok habis tidak boleh dipilih di form peminjaman."* Klausa
  `WHERE stok > 0` memastikan **hanya** buku yang stoknya tersedia yang
  muncul di dropdown — buku dengan stok `0` tidak akan pernah menjadi
  pilihan sama sekali.

```php
<?php if (empty($daftarAnggota)): ?>
    <p class="flash flash-error">Belum ada data anggota. Tambahkan anggota terlebih dahulu.</p>
<?php elseif (empty($daftarBukuTersedia)): ?>
    <p class="flash flash-error">Tidak ada buku dengan stok tersedia saat ini.</p>
<?php else: ?>
    <form>...</form>
<?php endif; ?>
```

Ini pola percabangan **3 arah** (`if`/`elseif`/`else`) — belum pernah
dipakai persis seperti ini sebelumnya di dokumentasi ini. Kalau tidak
ada anggota sama sekali, atau tidak ada buku tersedia sama sekali, form
peminjaman **tidak ditampilkan** — hanya pesan error yang relevan.
Form baru muncul kalau **kedua** syarat terpenuhi.

## 3.2 Menampilkan Pilihan yang Informatif

```php
<option value="<?php echo $anggota['id']; ?>">
    <?php echo e($anggota['nama']); ?> (<?php echo e($anggota['no_anggota']); ?>)
</option>
```

Perhatikan **`value`** opsi ini berisi `id` (angka, dipakai server
untuk mengetahui pilihan mana yang dikirim), sementara **teks yang
tampil** ke pengguna menggabungkan nama **dan** nomor anggota — ingat
konsep beda `value` vs teks tampilan `<option>` dari
[dokumentasi jobsheet-01 §4.4](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#select-dan-option--dropdown-pilihan).
Ini penting secara praktis: kalau ada dua anggota bernama sama persis
("Budi Santoso" misalnya), menampilkan nomor anggotanya sekaligus
membantu Petugas memilih **orang yang benar**. Pola serupa (menyertakan
stok di teks pilihan buku) juga dipakai untuk dropdown buku. Ingat
`e()` dari
[dokumentasi jobsheet-11 §2](../../jobsheet-11/Dokumentasi/02-xss-dan-fungsi-e.md)
dipakai membungkus setiap data teks yang berasal dari database.

## 3.3 `proses_tambah.php`: Kerangka Besarnya

```php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$anggotaId = $_POST['anggota_id'] ?? '';
$bukuId = $_POST['buku_id'] ?? '';

if ($anggotaId === '' || $bukuId === '') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Anggota dan buku wajib dipilih.'];
    header('Location: tambah.php');
    exit;
}

try {
    $pdo->beginTransaction();
    // ...
    $pdo->commit();
    // redirect sukses
} catch (Exception $e) {
    $pdo->rollBack();
    // redirect gagal
}
```

Kerangka luar file ini sudah sangat kamu kenal: guard `auth.php`
([dokumentasi jobsheet-10 §4](../../jobsheet-10/Dokumentasi/04-guard-auth-php.md)),
`csrf_verify()`
([dokumentasi jobsheet-11 §3.7](../../jobsheet-11/Dokumentasi/03-csrf-dan-token.md#37-memanggil-csrf_verify-di-awal-setiap-proses)),
validasi wajib-isi
([dokumentasi jobsheet-07 §4.3](../../jobsheet-07/Dokumentasi/04-proses-tambah-validasi-server.md#43-validasi-server-side)).
Yang benar-benar baru adalah blok `try { ... beginTransaction ... commit
} catch { ... rollBack }` — dibahas detail mulai [§3.4](#34-transaction-begintransaction-commit-rollback).

## 3.4 Transaction: `beginTransaction`, `commit`, `rollBack`

```php
try {
    $pdo->beginTransaction();

    // ... beberapa perintah SQL ...

    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Peminjaman berhasil dicatat.'];
    header('Location: ../index.php');
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mencatat peminjaman: ' . $e->getMessage()];
    header('Location: tambah.php');
    exit;
}
```

- **`$pdo->beginTransaction();`** — menandai **awal** sekelompok
  perintah SQL yang harus berhasil/gagal bersama-sama (ingat konsepnya
  dari [bab 1 §1.3](01-konsep-dasar-integrasi-dan-transaksi.md#13-kenapa-butuh-transaction)).
  Setelah baris ini, **semua** perintah `INSERT`/`UPDATE` berikutnya
  **belum benar-benar permanen** di database — mereka baru "dicoba,"
  menunggu konfirmasi akhir.
- **`$pdo->commit();`** — **mengunci** seluruh perubahan yang terjadi
  sejak `beginTransaction()` menjadi **permanen** di database sekaligus.
  Dipanggil **hanya** kalau seluruh perintah di dalamnya berhasil tanpa
  error.
- **`$pdo->rollBack();`** — **membatalkan total** seluruh perubahan
  yang terjadi sejak `beginTransaction()`, seolah-olah **tidak pernah
  terjadi sama sekali** — dipanggil di blok `catch`, tepat ketika ada
  yang gagal di tengah proses.
- Pola `try`/`catch` di sini persis sama konsepnya dengan
  [dokumentasi jobsheet-06 §1.6](../../jobsheet-06/Dokumentasi/01-konsep-dasar-fetch-json.md#16-menangani-kegagalan-trycatchfinally),
  hanya sekarang dipakai untuk **transaction** SQL, bukan `fetch()`.

## 3.5 Mencegah Race Condition: `SELECT ... FOR UPDATE`

```php
$cek = $pdo->prepare("SELECT stok FROM buku WHERE id = :id FOR UPDATE");
$cek->execute(['id' => $bukuId]);
$buku = $cek->fetch(PDO::FETCH_ASSOC);

if (!$buku || $buku['stok'] < 1) {
    throw new Exception('Stok buku tidak tersedia.');
}
```

- **`FOR UPDATE`** — klausa SQL yang **mengunci** baris yang diambil
  query ini, mencegah transaction **lain** membaca/mengubah baris yang
  sama **sampai** transaction ini selesai (`commit`/`rollBack`). Ingat
  skenario race condition dari
  [bab 1 §1.4](01-konsep-dasar-integrasi-dan-transaksi.md#14-apa-itu-race-condition):
  kalau dua petugas mencoba meminjamkan buku stok-1 yang sama secara
  bersamaan, `FOR UPDATE` memastikan petugas **kedua** harus **menunggu**
  sampai transaction petugas **pertama** selesai — begitu menunggu
  selesai, petugas kedua akan membaca stok yang **sudah** diperbarui
  (kemungkinan besar sudah `0`), sehingga pengecekan `$buku['stok'] < 1`
  di bawahnya akan **menolak** peminjaman kedua itu dengan benar,
  bukan malah membuat stok jadi negatif.
- **`if (!$buku || $buku['stok'] < 1) { throw new Exception(...); }`** —
  **`throw new Exception(...)`** adalah cara PHP "melempar" error secara
  manual (ingat konsep serupa `throw new Error(...)` di JavaScript dari
  [dokumentasi jobsheet-06 §4.5](../../jobsheet-06/Dokumentasi/04-js-fetch-render-buku.md#45-mengambil-data-dan-memeriksa-keberhasilannya)).
  Melempar Exception di sini **langsung melompat** ke blok `catch`
  ([§3.4](#34-transaction-begintransaction-commit-rollback)), yang akan
  memanggil `rollBack()` — membatalkan transaction ini **sebelum**
  sempat mengubah data apa pun, meski proses sudah sampai di tengah
  jalan.

## 3.6 Mencatat Peminjaman & Mengurangi Stok

```php
$insert = $pdo->prepare(
    "INSERT INTO peminjaman (buku_id, anggota_id, tanggal_pinjam, status)
     VALUES (:buku_id, :anggota_id, CURRENT_DATE, 'dipinjam')"
);
$insert->execute(['buku_id' => $bukuId, 'anggota_id' => $anggotaId]);

$update = $pdo->prepare("UPDATE buku SET stok = stok - 1 WHERE id = :id");
$update->execute(['id' => $bukuId]);

$pdo->commit();
```

- `INSERT` baris baru ke `peminjaman` — pola yang sudah kamu kuasai
  sejak [dokumentasi jobsheet-08 §5](../../jobsheet-08/Dokumentasi/05-insert-prepared-statement.md).
  Perhatikan `CURRENT_DATE` ditulis **langsung** di query (bukan
  parameter) — meski kolom `tanggal_pinjam` sudah punya
  `DEFAULT CURRENT_DATE` ([bab 2 §2.3](02-skema-peminjaman-dan-relasi.md#23-tipe-data-date-dan-default-current_date)),
  menuliskannya eksplisit di sini membuat maksud kode lebih jelas
  dibaca, meski secara teknis bisa juga dihilangkan dan mengandalkan
  nilai default.
- **`UPDATE buku SET stok = stok - 1 WHERE id = :id`** — perhatikan
  **`stok = stok - 1`**: nilai baru dihitung **berdasarkan nilai
  lama**-nya sendiri (ambil stok saat ini, kurangi 1), bukan menuliskan
  angka tetap. Pola ini aman dipakai di sini **karena** sudah dilindungi
  `FOR UPDATE` di [§3.5](#35-mencegah-race-condition-select--for-update) —
  tidak ada transaction lain yang bisa mengubah nilai `stok` di
  tengah-tengah antara saat dibaca dan saat diperbarui.
- **`$pdo->commit();`** — dipanggil **hanya** setelah **kedua** perintah
  (`INSERT` dan `UPDATE`) berhasil dieksekusi tanpa error — inilah
  momen kedua perubahan itu **benar-benar** menjadi permanen di
  database, sekaligus, sesuai prinsip transaction dari
  [bab 1 §1.3](01-konsep-dasar-integrasi-dan-transaksi.md#13-kenapa-butuh-transaction).

Lanjut ke: [Pengembalian Buku](04-pengembalian-buku.md)
