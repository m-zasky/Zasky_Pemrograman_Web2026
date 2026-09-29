# 7. Rangkuman & Latihan Lanjutan

## 7.1 Rangkuman Keseluruhan Jobsheet 9

| Bagian | Konsep yang Dipelajari |
|---|---|
| [Konsep Dasar CRUD](01-konsep-dasar-crud.md) | Create/Read/Update/Delete, kenapa Update/Delete butuh `id` |
| [Edit & Update](02-edit-update-data.md) | `$_GET['id']`, `SELECT ... WHERE`, `fetch()` tunggal, `value="..."`, `UPDATE ... SET ... WHERE` |
| [Hapus & Delete](03-hapus-delete-data.md) | Kenapa Delete harus `POST`, `$_SERVER['REQUEST_METHOD']`, `DELETE FROM ... WHERE` |
| [JS Konfirmasi Hapus](04-js-update-hapus-confirm.md) | Event `submit` vs `click`, `preventDefault()` untuk membatalkan submit sungguhan |
| [Pagination & Pencarian Server](05-pagination-dan-pencarian-server.md) | `LIMIT`/`OFFSET`, `ILIKE`, `bindValue()`, `PDO::PARAM_INT`, `method="get"` |
| [CSS Pendukung](06-css-pendukung.md) | Menyamarkan `<a>` jadi tombol, `display: inline` pada form, styling pagination |

## 7.2 Konsep Inti yang Perlu Diingat

1. **`UPDATE`/`DELETE` tanpa `WHERE` sangat berbahaya** — selalu
   memastikan klausa `WHERE id = :id` ada sebelum menjalankan kedua
   perintah ini, kalau tidak seluruh tabel bisa berubah/terhapus
   sekaligus
   ([bab 2 §2.6](02-edit-update-data.md#26-proses_editphp-menjalankan-update),
   [bab 3 §3.4](03-hapus-delete-data.md#34-perintah-delete)).
2. **`GET` untuk operasi aman, `POST` untuk operasi yang mengubah
   data** — terutama untuk operasi destruktif seperti Delete, yang
   sengaja diblokir kalau diakses lewat `GET`
   ([bab 3 §3.2-3.3](03-hapus-delete-data.md#32-kenapa-delete-tidak-boleh-sesederhana-sebuah-tautan)).
3. **Event `submit` bisa dibatalkan sebelum data terkirim**, beda dari
   menunggu `click` lalu bereaksi setelahnya — penting begitu form
   benar-benar terhubung ke aksi sungguhan di server
   ([bab 4](04-js-update-hapus-confirm.md)).
4. **Pagination (`LIMIT`/`OFFSET`) mencegah satu halaman menampilkan
   seluruh data sekaligus**, penting untuk performa begitu jumlah data
   bertambah banyak
   ([bab 5 §5.2-5.4](05-pagination-dan-pencarian-server.md#52-kenapa-butuh-pagination)).
5. **Pencarian sisi server (`ILIKE`) berbeda tujuannya** dari filter
   sisi klien yang sudah kamu bangun sejak jobsheet-05 — server bisa
   mencari **lintas semua halaman/data**, klien hanya menyaring apa
   yang **sedang tampil**
   ([bab 5 §5.6](05-pagination-dan-pencarian-server.md#56-pencarian-sisi-server-ilike)).

## 7.3 Cara Mencoba Sendiri

1. Jalankan `php -S localhost:8000` atau lewat Laragon (pastikan database dari
   [dokumentasi jobsheet-08](../../jobsheet-08/Dokumentasi/03-persiapan-database.md)
   sudah siap), buka `http://localhost:8000/index.php`.
2. Ikuti siklus lengkap dari [README.md](../README.md) jobsheet ini:
   **tambah** → **tampil** → **ubah (Edit)** → **tampil berubah** →
   **hapus** → **hilang dari list**.
3. Tambahkan **lebih dari 5 buku** (misalnya 7-8 buku), lalu perhatikan
   navigasi pagination muncul dengan lebih dari satu nomor halaman —
   klik ke halaman 2, amati 5 buku pertama (yang paling baru
   ditambahkan, ingat `ORDER BY id DESC`) tetap di halaman 1.
4. Ketik kata kunci di kolom pencarian, klik "Cari" — amati URL
   berubah jadi `list.php?q=...`, dan pagination (kalau hasilnya lebih
   dari 5) ikut menyesuaikan dengan jumlah hasil pencarian, bukan
   jumlah total buku.
5. Coba klik tombol Hapus, lalu klik **Cancel** di dialog konfirmasi —
   amati baris **tidak** hilang dan **tidak** ada permintaan yang
   terkirim ke server (buka DevTools tab **Network** untuk
   membuktikannya).
6. Coba buka `buku/hapus.php` **langsung** lewat address bar (tanpa
   `?id=...` apa pun, dan tanpa lewat form) — amati kamu langsung
   diarahkan ke `list.php` **tanpa** ada data yang terhapus (bukti
   pemeriksaan `$_SERVER['REQUEST_METHOD']` dari
   [bab 3 §3.3](03-hapus-delete-data.md#33-memeriksa-metode-http-_serverrequest_method)
   bekerja).

## 7.4 Ide Latihan Tambahan (Opsional)

1. **Tambah konfirmasi ekstra sebelum Update** — bandingkan dengan
   Delete yang sudah punya `confirm()`; apakah Update juga butuh
   konfirmasi serupa? Pertimbangkan kapan konfirmasi tambahan
   benar-benar diperlukan (ingat: Update tidak destruktif seperti
   Delete, data lama masih "terlihat" sebelum diubah).
2. **Ubah jumlah baris per halaman** — ganti `$perPage = 5;` menjadi
   `10` di `buku/list.php`, amati bagaimana jumlah total halaman
   berubah mengikuti.
3. **Tambah pencarian di kolom lain** — misalnya perluas query di
   [bab 5 §5.6](05-pagination-dan-pencarian-server.md#56-pencarian-sisi-server-ilike)
   supaya juga mencocokkan kolom `pengarang`, bukan cuma `judul`
   (petunjuk: gunakan `OR` di klausa `WHERE`).
4. **Terapkan pola Update/Delete ke fitur lain** — kalau kamu menambah
   entitas baru di proyek pribadimu nanti, coba terapkan pola CRUD
   yang sama persis: `list.php` (Read + pagination), `tambah.php`
   (Create), `edit.php` (Update), `hapus.php` (Delete) — pola 4 file
   ini akan terus berulang untuk hampir semua data yang perlu dikelola.

Kalau ada bagian yang masih membingungkan, terutama soal kenapa
`WHERE` begitu penting di `UPDATE`/`DELETE`, coba baca ulang
[bab 2 §2.6](02-edit-update-data.md#26-proses_editphp-menjalankan-update)
dan [bab 3 §3.4](03-hapus-delete-data.md#34-perintah-delete) sambil
membayangkan skenario terburuknya: satu baris kode yang lupa `WHERE`
bisa mengubah/menghapus **seluruh** data di tabel dalam sekejap —
inilah kenapa kebiasaan ini penting ditanamkan sejak awal belajar SQL.
