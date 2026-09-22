# 7. Rangkuman & Latihan Lanjutan

## 7.1 Rangkuman Keseluruhan Jobsheet 8

| Bagian | Konsep yang Dipelajari |
|---|---|
| [Konsep Dasar](01-konsep-dasar-database-sql.md) | Database relasional, tabel/kolom/baris, SQL, PDO |
| [Skema SQL](02-skema-database-sql.md) | `CREATE TABLE`, tipe data (`SERIAL`, `VARCHAR`, `INTEGER`), batasan (`PRIMARY KEY`, `NOT NULL`, `UNIQUE`, `DEFAULT`) |
| [Persiapan Database](03-persiapan-database.md) | `createdb`, `psql -f`, ekstensi `pdo_pgsql`, kredensial |
| [Koneksi PDO](04-koneksi-pdo.md) | DSN, `new PDO(...)`, `try`/`catch` untuk kegagalan koneksi, `require` vs `include` |
| [Prepared Statement & INSERT](05-insert-prepared-statement.md) | `prepare()`, placeholder `:nama`, `execute()`, kenapa lebih aman dari penggabungan string |
| [Membaca Data SELECT](06-membaca-data-select.md) | `query()` vs `prepare()`, `fetchAll(PDO::FETCH_ASSOC)`, `fetchColumn()`, `COUNT(*)` |

## 7.2 Konsep Inti yang Perlu Diingat

1. **Database menyelesaikan masalah "data hilang"** dari jobsheet-07 —
   data sekarang tersimpan permanen di PostgreSQL, terpisah dari sesi
   browser mana pun
   ([bab 1 §1.1](01-konsep-dasar-database-sql.md#11-kenapa-butuh-database-mengingat-kembali-masalahnya)).
2. **Skema SQL mendefinisikan aturan data**, bukan cuma nama kolom —
   `NOT NULL`, `UNIQUE`, tipe data yang tepat semuanya membantu menjaga
   kualitas data langsung dari lapisan database
   ([bab 2](02-skema-database-sql.md)).
3. **PDO adalah jembatan seragam** antara PHP dan berbagai jenis
   database, dimulai dengan membuat koneksi lewat DSN
   ([bab 4](04-koneksi-pdo.md)).
4. **Prepared statement (`prepare()`+`execute()`) adalah cara aman**
   memasukkan data dari pengguna ke query SQL — pakai ini kapan pun ada
   nilai dari luar (seperti `$_POST`) yang perlu masuk ke query
   ([bab 5 §5.3](05-insert-prepared-statement.md#53-apa-itu-prepared-statement-dan-kenapa-penting)).
5. **Struktur array hasil `fetchAll(PDO::FETCH_ASSOC)` konsisten**
   dengan struktur `$_SESSION` sebelumnya — kode yang menampilkan data
   tidak perlu berubah sama sekali, hanya sumber datanya yang berpindah
   ([bab 6 §6.4](06-membaca-data-select.md#64-menampilkan-hasilnya-di-tabel-tidak-berubah)).

## 7.3 Cara Mencoba Sendiri

1. Selesaikan **semua** langkah persiapan di
   [bab 3](03-persiapan-database.md) — ini **wajib** sebelum melangkah
   lebih jauh.
2. Jalankan `php -S localhost:8000` (atau lewat Laragon), buka `http://localhost:8000/index.php` —
   kartu statistik seharusnya menampilkan `0` untuk Total Buku dan Total
   Anggota (database baru dibuat, belum ada data).
3. Tambahkan satu buku lewat `buku/tambah.php`. Amati kamu diarahkan ke
   `list.php` dengan buku barumu muncul **di baris paling atas** (ingat
   `ORDER BY id DESC` dari [bab 6 §6.1](06-membaca-data-select.md#61-bukulistphp-mengambil-semua-baris)).
4. Kembali ke Beranda — amati kartu "Total Buku" sekarang bertambah
   jadi `1`.
5. **Uji persistensi** sesuai catatan di [README.md](../README.md)
   jobsheet ini: tutup browser **sepenuhnya**, buka lagi, kunjungi
   `list.php` — buku yang tadi kamu tambahkan **masih ada**. Bandingkan
   pengalaman ini dengan uji yang sama di
   [dokumentasi jobsheet-07 §7.3](../../jobsheet-07/Dokumentasi/07-rangkuman-latihan.md#73-cara-mencoba-sendiri)
   langkah ke-6, di mana data **hilang** setelah browser ditutup.
6. Coba tambahkan **dua** anggota dengan `no_anggota` yang **sama
   persis** — amati apa yang terjadi (ingat batasan `UNIQUE` dari
   [bab 2 §2.4](02-skema-database-sql.md#24-mendefinisikan-kolom-nama-tipe-dan-batasan)).
   Kemungkinan besar kamu akan melihat **halaman error PHP mentah**,
   bukan pesan flash yang rapi — ini kesempatan bagus untuk latihan
   di [§7.4](#74-ide-latihan-tambahan-opsional) poin 1.

## 7.4 Ide Latihan Tambahan (Opsional)

1. **Tangani error `UNIQUE` dengan rapi** — bungkus `$stmt->execute(...)`
   di `anggota/proses_tambah.php` dengan `try`/`catch (PDOException $e)`,
   lalu set `$_SESSION['flash']` berisi pesan seperti "No. Anggota
   sudah dipakai, gunakan nomor lain." alih-alih membiarkan error mentah
   ditampilkan ke pengguna.
2. **Tambah kolom baru** — misalnya `tanggal_ditambahkan TIMESTAMP
   DEFAULT NOW()` di tabel `buku` (cari tahu sendiri arti `NOW()` dan
   `TIMESTAMP` lewat dokumentasi PostgreSQL), lalu tampilkan kolom itu
   di `buku/list.php`.
3. **Buat query pencarian di server** — tambahkan
   `WHERE judul ILIKE :keyword` (`ILIKE` = pencocokan teks tanpa
   memandang huruf besar/kecil di PostgreSQL) ke query `SELECT` di
   `buku/list.php`, dihubungkan dengan kolom pencarian yang sudah ada
   di HTML — bandingkan dengan filter tabel **sisi klien** yang sudah
   kamu bangun di
   [dokumentasi jobsheet-05 §6](../../jobsheet-05/Dokumentasi/06-js-filter-tabel.md).
4. **Migrasi data lama** — coba tulis skrip PHP kecil terpisah yang
   membaca `data/buku.json` dari jobsheet-06
   ([dokumentasi jobsheet-06 §3](../../jobsheet-06/Dokumentasi/03-data-json.md))
   lalu memasukkan seluruh isinya ke tabel `buku` lewat `INSERT` —
   latihan bagus untuk memahami bagaimana data lama bisa "dipindahkan"
   ke database baru.

Kalau ada bagian yang masih membingungkan, coba baca ulang
[bab 1](01-konsep-dasar-database-sql.md) sambil mempraktikkan langkah
5 di [§7.3](#73-cara-mencoba-sendiri) — merasakan sendiri data yang
**benar-benar bertahan** setelah browser ditutup adalah cara paling
meyakinkan untuk memahami kenapa database itu penting.
