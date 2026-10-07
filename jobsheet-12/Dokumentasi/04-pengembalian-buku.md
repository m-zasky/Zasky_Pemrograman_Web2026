# 4. Pengembalian Buku

Modul ini adalah **kebalikan** logis dari Peminjaman Baru
([bab 3](03-peminjaman-baru-dan-transaction.md)) — memakai pola
transaction yang sama, hanya arah perubahannya dibalik.

## 4.1 `peminjaman/kembali.php`: Daftar Transaksi Aktif

```php
$sqlDasar = "SELECT p.id, b.judul, a.nama, p.tanggal_pinjam
             FROM peminjaman p
             JOIN buku b ON b.id = p.buku_id
             JOIN anggota a ON a.id = p.anggota_id
             WHERE p.status = 'dipinjam'";
```

Query ini memakai **`JOIN`** — konsep yang dibahas mendalam di
[bab 5](05-riwayat-peminjaman-join.md), karena `riwayat.php` memakainya
dengan cara yang lebih mudah dijelaskan langkah demi langkah. Inti
singkatnya di sini: query ini menggabungkan data dari **3 tabel**
sekaligus (`peminjaman`, `buku`, `anggota`) supaya bisa menampilkan
**judul buku** dan **nama anggota** secara langsung, padahal tabel
`peminjaman` sendiri hanya menyimpan `buku_id`/`anggota_id` berupa
angka (ingat dari [bab 2](02-skema-peminjaman-dan-relasi.md)).
**`WHERE p.status = 'dipinjam'`** memastikan **hanya** transaksi yang
belum dikembalikan yang muncul di halaman ini.

Sisa halaman ini — kolom pencarian (`method="get"`, `ILIKE`), tombol
"Kembalikan" dibungkus `<form method="post">` dengan `csrf_field()` dan
`<input type="hidden" name="id">` — adalah pola yang **identik** dengan
yang sudah kamu kenal sejak
[dokumentasi jobsheet-09](../../jobsheet-09/Dokumentasi/05-pagination-dan-pencarian-server.md)
dan [dokumentasi jobsheet-11](../../jobsheet-11/Dokumentasi/03-csrf-dan-token.md).

## 4.2 `proses_kembali.php`: Transaction Kebalikan

```php
try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT buku_id, status FROM peminjaman WHERE id = :id FOR UPDATE");
    $stmt->execute(['id' => $id]);
    $trx = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$trx || $trx['status'] !== 'dipinjam') {
        throw new Exception('Transaksi tidak ditemukan atau sudah dikembalikan.');
    }

    $updatePeminjaman = $pdo->prepare(
        "UPDATE peminjaman SET status = 'dikembalikan', tanggal_kembali = CURRENT_DATE WHERE id = :id"
    );
    $updatePeminjaman->execute(['id' => $id]);

    $updateBuku = $pdo->prepare("UPDATE buku SET stok = stok + 1 WHERE id = :buku_id");
    $updateBuku->execute(['buku_id' => $trx['buku_id']]);

    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil dikembalikan.'];
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memproses pengembalian: ' . $e->getMessage()];
}
```

Bandingkan langkah demi langkah dengan `proses_tambah.php` yang sudah
kamu bedah di [bab 3](03-peminjaman-baru-dan-transaction.md):

| | Peminjaman Baru | Pengembalian |
|---|---|---|
| Baris yang dikunci `FOR UPDATE` | Baris **buku** (cek stok) | Baris **peminjaman** (cek status) |
| Syarat kegagalan | `!$buku \|\| $buku['stok'] < 1` | `!$trx \|\| $trx['status'] !== 'dipinjam'` |
| Perubahan pada tabel `peminjaman` | `INSERT` baris baru, `status = 'dipinjam'` | `UPDATE status = 'dikembalikan'`, isi `tanggal_kembali` |
| Perubahan pada tabel `buku` | `stok = stok - 1` | `stok = stok + 1` |

- **`FOR UPDATE` di sini mengunci baris `peminjaman`**, bukan `buku` —
  masuk akal, karena race condition yang perlu dicegah di sini berbeda:
  bayangkan **dua** klik tombol "Kembalikan" untuk transaksi yang
  **sama**, hampir bersamaan (misalnya karena pengguna klik dua kali
  tidak sengaja) — tanpa penguncian, kedua proses bisa sama-sama lolos
  pengecekan `status === 'dipinjam'` dan **sama-sama** menambah stok
  buku (`stok + 1` dua kali), padahal pengembalian sungguhan hanya
  terjadi sekali.
- **`$trx['status'] !== 'dipinjam'`** — pengecekan ini penting: kalau
  transaksi yang sama entah bagaimana **sudah** berstatus
  `'dikembalikan'` (misalnya dari percobaan klik ganda tadi, atau
  transaksi yang memang tidak valid), proses ini **menolak**
  melanjutkan — mencegah stok bertambah dua kali untuk **satu**
  pengembalian buku yang sama.
- **`UPDATE peminjaman SET status = 'dikembalikan', tanggal_kembali = CURRENT_DATE`** —
  mengubah **dua kolom sekaligus** dalam satu perintah `UPDATE` (ingat
  sintaks `SET kolom1 = ..., kolom2 = ...` dari
  [dokumentasi jobsheet-09 §2.6](../../jobsheet-09/Dokumentasi/02-edit-update-data.md#26-proses_editphp-menjalankan-update)) —
  status berubah **dan** tanggal kembali terisi otomatis dengan
  tanggal hari ini, dalam satu langkah.

## 4.3 Kenapa Guard Method Masih Diperiksa Padahal Sudah Ada CSRF?

```php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: kembali.php');
    exit;
}

csrf_verify();
```

Ingat dari [dokumentasi jobsheet-09 §3.3](../../jobsheet-09/Dokumentasi/03-hapus-delete-data.md#33-memeriksa-metode-http-_serverrequest_method),
pemeriksaan `$_SERVER['REQUEST_METHOD']` mencegah operasi ini terpicu
lewat `GET` (tautan/crawler). Meski token CSRF
([dokumentasi jobsheet-11 §3](../../jobsheet-11/Dokumentasi/03-csrf-dan-token.md))
sudah menutup celah pemalsuan permintaan `POST` dari situs lain, kedua
lapisan ini **melengkapi**, bukan menggantikan satu sama lain —
pemeriksaan method mencegah kasus lebih sederhana (klik tautan biasa),
sementara token CSRF mencegah kasus yang lebih canggih (form palsu yang
juga memakai `POST`). Prinsip melapisi beberapa pertahanan sekaligus
seperti ini disebut **defense in depth** — jangan bergantung pada satu
lapisan proteksi saja.

Lanjut ke: [Riwayat Peminjaman & `JOIN`](05-riwayat-peminjaman-join.md)
