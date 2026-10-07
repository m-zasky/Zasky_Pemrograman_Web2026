# 5. Riwayat Peminjaman & `JOIN`

Halaman paling sederhana secara alur (hanya membaca data, tidak ada
transaction), tapi memperkenalkan konsep SQL penting: **`JOIN`**.

## 5.1 Apa itu `JOIN`?

Ingat dari [bab 1 §1.1](01-konsep-dasar-integrasi-dan-transaksi.md#11-kenapa-peminjaman-butuh-tabel-sendiri),
tabel `peminjaman` hanya menyimpan **angka** (`buku_id`, `anggota_id`) —
bukan judul buku atau nama anggota secara langsung. Kalau kamu hanya
menjalankan `SELECT * FROM peminjaman`, hasilnya berupa deretan angka
yang tidak berarti apa-apa bagi pengguna (siapa yang mau melihat
"buku_id: 3, anggota_id: 7"?).

**`JOIN`** adalah perintah SQL yang **menggabungkan** baris dari dua
tabel (atau lebih) berdasarkan kecocokan kolom tertentu — biasanya
foreign key dengan primary key yang dirujuknya
([dokumentasi jobsheet-12 §2.2](02-skema-peminjaman-dan-relasi.md#22-kolom-foreign-key-buku_id-dan-anggota_id)).
Hasilnya: satu baris gabungan yang berisi kolom dari **kedua** tabel
sekaligus.

## 5.2 Kode Query Lengkap

```php
$stmt = $pdo->prepare(
    "SELECT b.judul, p.tanggal_pinjam, p.tanggal_kembali, p.status
     FROM peminjaman p
     JOIN buku b ON b.id = p.buku_id
     WHERE p.anggota_id = :id
     ORDER BY p.tanggal_pinjam DESC"
);
```

## 5.3 Alias Tabel: `p` dan `b`

```sql
FROM peminjaman p
JOIN buku b ON b.id = p.buku_id
```

- **`peminjaman p`** dan **`buku b`** — memberi tabel sebuah **alias**
  (nama pendek sementara): `peminjaman` disingkat `p`, `buku` disingkat
  `b`. Ini murni untuk **mempersingkat penulisan** query — tanpa
  alias, setiap penyebutan kolom harus menulis nama tabel lengkap
  (`peminjaman.tanggal_pinjam` alih-alih `p.tanggal_pinjam`), yang
  membuat query panjang menjadi sulit dibaca, apalagi kalau melibatkan
  banyak tabel sekaligus (ingat `kembali.php` di
  [bab 4 §4.1](04-pengembalian-buku.md#41-peminjamankembaliphp-daftar-transaksi-aktif)
  yang menggabungkan **3** tabel: `p`, `b`, `a`).

## 5.4 Klausa `ON`: Syarat Penggabungan

```sql
JOIN buku b ON b.id = p.buku_id
```

**`ON b.id = p.buku_id`** adalah **syarat** bagaimana baris dari kedua
tabel dicocokkan: "gabungkan baris `buku` dengan baris `peminjaman`
**kalau** `id` di tabel `buku` sama dengan `buku_id` di tabel
`peminjaman`." Inilah wujud konkret dari relasi foreign key yang sudah
dibahas di
[bab 2 §2.2](02-skema-peminjaman-dan-relasi.md#22-kolom-foreign-key-buku_id-dan-anggota_id) —
`JOIN ... ON` "menerjemahkan" hubungan antar tabel itu menjadi data
gabungan yang sesungguhnya bisa ditampilkan.

## 5.5 Memilih Kolom dari Kedua Tabel

```sql
SELECT b.judul, p.tanggal_pinjam, p.tanggal_kembali, p.status
```

Perhatikan daftar kolom yang diambil **bercampur** dari kedua tabel:
`b.judul` (dari tabel `buku`), sementara `p.tanggal_pinjam`,
`p.tanggal_kembali`, `p.status` (dari tabel `peminjaman`). Inilah
manfaat `JOIN` yang sesungguhnya: satu baris hasil query ini terlihat
seperti "satu tabel gabungan" yang berisi kolom relevan dari **kedua**
sumber data, meski di database aslinya tersimpan sebagai dua tabel
terpisah.

## 5.6 Menyaring Berdasarkan Anggota Terpilih

```php
$anggotaId = $_GET['anggota_id'] ?? '';
// ...
if ($anggotaId !== '') {
    // ...
    $stmt->execute(['id' => $anggotaId]);
    $riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
```

- **`WHERE p.anggota_id = :id`** — menyaring hasil `JOIN` supaya
  **hanya** menampilkan riwayat peminjaman milik **satu** anggota
  spesifik, sesuai wireframe yang sudah kamu bedah sejak
  [dokumentasi jobsheet-04 §2.3](../../jobsheet-04/Dokumentasi/02-cara-membaca-wireframe.md#23-wireframe-yang-lebih-kompleks-dashboard-petugas):
  *"Riwayat Peminjaman — Siti Aminah"*.
- **`$_GET['anggota_id']`** — nomor anggota yang mau dilihat riwayatnya
  diambil dari URL (ingat konsep ini dari
  [dokumentasi jobsheet-09 §2.2](../../jobsheet-09/Dokumentasi/02-edit-update-data.md#22-mengambil-id-dari-url-_getid)),
  dikirim lewat form `method="get"` yang berisi dropdown pilihan
  anggota.
- Kalau `$anggotaId` masih kosong (halaman baru dibuka, belum memilih
  anggota apa pun), query `JOIN` ini **sama sekali tidak dijalankan** —
  `$riwayat` tetap berupa array kosong yang sudah diinisialisasi di
  awal file, dan halaman hanya menampilkan form pemilihan anggota tanpa
  tabel riwayat.

## 5.7 Mempertahankan Pilihan Dropdown: Perbandingan String

```php
<option value="<?php echo $anggota['id']; ?>" <?php echo (string) $anggotaId === (string) $anggota['id'] ? 'selected' : ''; ?>>
```

- Ingat pola `selected` dari
  [dokumentasi jobsheet-09 §2.4](../../jobsheet-09/Dokumentasi/02-edit-update-data.md#24-mengisi-form-dengan-data-lama-atribut-value) —
  menandai opsi yang **sedang dipilih** supaya tetap terlihat terpilih
  setelah halaman submit ulang (mirip `value="..."` yang mempertahankan
  isi kotak pencarian, ingat dari
  [dokumentasi jobsheet-09 §5.8](../../jobsheet-09/Dokumentasi/05-pagination-dan-pencarian-server.md#58-form-pencarian-methodget)).
- **`(string) $anggotaId === (string) $anggota['id']`** — kedua nilai
  **sengaja** di-cast ke `(string)` (ingat konsep type casting dari
  [dokumentasi jobsheet-07 §4.5](../../jobsheet-07/Dokumentasi/04-proses-tambah-validasi-server.md#45-kalau-valid-simpan-ke-session--redirect-ke-daftar))
  sebelum dibandingkan dengan `===` (perbandingan **ketat**, yang
  memeriksa tipe data **dan** nilai sekaligus). `$anggotaId` dari
  `$_GET` **selalu** berupa string (ingat semua data dari
  `$_GET`/`$_POST` berbentuk teks apa adanya, dari
  [dokumentasi jobsheet-08 §5.4](../../jobsheet-08/Dokumentasi/05-insert-prepared-statement.md#54-menjalankan-query-stmt-execute)),
  sementara `$anggota['id']` dari hasil `SELECT` biasanya sudah berupa
  **integer**. Tanpa `(string)` di kedua sisi, `===` akan **selalu**
  bernilai `false` (karena tipe data `"3"` dan `3` dianggap berbeda
  oleh `===`), meski nilainya "sama" secara makna — mengubah keduanya
  jadi string dulu memastikan perbandingan berjalan sesuai maksudnya.

## 5.8 Menampilkan Status yang Ramah Dibaca

```php
<td><?php echo $r['status'] === 'dipinjam' ? 'Dipinjam' : 'Selesai'; ?></td>
```

Ingat ternary operator dari
[dokumentasi jobsheet-05 §5.4](../../jobsheet-05/Dokumentasi/05-js-konfirmasi-hapus.md#54-mengambil-namajudul-dari-baris-itu) —
kolom `status` di database menyimpan nilai teknis (`'dipinjam'` atau
`'dikembalikan'`, ingat dari
[bab 2 §2.4](02-skema-peminjaman-dan-relasi.md#24-kolom-status)), tapi
ke pengguna ditampilkan label yang lebih ramah dibaca: "Dipinjam" atau
"Selesai" — persis seperti yang dirancang di wireframe Riwayat
Peminjaman sejak jobsheet-04.

Lanjut ke: [Rangkuman & Latihan Lanjutan](06-rangkuman-latihan.md)
