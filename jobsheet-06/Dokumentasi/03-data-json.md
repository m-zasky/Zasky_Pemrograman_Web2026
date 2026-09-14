# 3. Data JSON: `buku.json` & `anggota.json`

Sebelum membedah kode yang **membaca** file JSON ini, kenali dulu isi
dan strukturnya.

## 3.1 `data/buku.json` — 10 Objek Buku

```json
[
    { "judul": "Laskar Pelangi", "pengarang": "Andrea Hirata", "tahun": 2005, "stok": 4 },
    { "judul": "Bumi Manusia", "pengarang": "Pramoedya Ananta Toer", "tahun": 1980, "stok": 2 },
    { "judul": "Negeri 5 Menara", "pengarang": "Ahmad Fuadi", "tahun": 2009, "stok": 0 },
    { "judul": "Filosofi Teras", "pengarang": "Henry Manampiring", "tahun": 2018, "stok": 5 },
    { "judul": "Ronggeng Dukuh Paruk", "pengarang": "Ahmad Tohari", "tahun": 1982, "stok": 1 },
    { "judul": "Cantik Itu Luka", "pengarang": "Eka Kurniawan", "tahun": 2002, "stok": 3 },
    { "judul": "Pulang", "pengarang": "Tere Liye", "tahun": 2015, "stok": 2 },
    { "judul": "Sang Pemimpi", "pengarang": "Andrea Hirata", "tahun": 2006, "stok": 6 },
    { "judul": "Perahu Kertas", "pengarang": "Dee Lestari", "tahun": 2009, "stok": 0 },
    { "judul": "Gadis Kretek", "pengarang": "Ratih Kumala", "tahun": 2012, "stok": 4 }
]
```

Bandingkan dengan tabel Daftar Buku yang sudah kamu kenal sejak
[dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/03-buku-list-html.md#33-data-yang-ditampilkan-dummy):
5 buku pertama **persis sama** dengan data dummy yang dulu ditulis
manual di HTML — hanya sekarang formatnya JSON, dan **ditambah** 5 buku
baru (total jadi 10), yang tidak akan pernah tampil kalau kamu membuka
HTML lama karena baris HTML lama memang statis dan tidak terhubung ke
file ini sama sekali.

## 3.2 `data/anggota.json` — 4 Objek Anggota

```json
[
    { "no_anggota": "A001", "nama": "Siti Aminah", "alamat": "Malang", "no_hp": "0812xxxx" },
    { "no_anggota": "A002", "nama": "Budi Santoso", "alamat": "Batu", "no_hp": "0813xxxx" },
    { "no_anggota": "A003", "nama": "Dewi Lestari", "alamat": "Malang", "no_hp": "0814xxxx" },
    { "no_anggota": "A004", "nama": "Rizky Firmansyah", "alamat": "Lawang", "no_hp": "0815xxxx" }
]
```

Sama polanya: 2 anggota pertama sama dengan data dummy lama di
[dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/05-anggota-list-html.md#53-apa-yang-berbeda),
ditambah 2 anggota baru.

## 3.3 Kenapa Nama Kuncinya Persis Sama dengan Atribut `name` di Form?

Perhatikan kunci-kunci JSON ini — `judul`, `pengarang`, `tahun`, `stok`
untuk buku; `no_anggota`, `nama`, `alamat`, `no_hp` untuk anggota —
**persis sama** dengan atribut `name` pada input form Tambah Buku/Tambah
Anggota yang sudah kamu pelajari di
[dokumentasi jobsheet-01 §4](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md)
dan [§6](../../jobsheet-01/Dokumentasi/06-anggota-tambah-html.md). Ini
**bukan kebetulan** — penamaan yang konsisten di seluruh aplikasi
(HTML, JSON, dan nanti database sungguhan) membuat data jauh lebih mudah
dilacak: satu field yang sama selalu punya **nama yang sama** di setiap
lapisan, tidak perlu "menerjemahkan" nama field yang berbeda-beda di
setiap tempat.

## 3.4 Tipe Data di Dalam JSON

JSON mendukung beberapa tipe nilai dasar, dan kedua file ini memakai 2
di antaranya:

| Tipe | Contoh di Data Ini | Ciri |
|---|---|---|
| **String** (teks) | `"Laskar Pelangi"`, `"A001"` | Selalu diapit tanda kutip dua. |
| **Number** (angka) | `2005`, `4`, `0` | **Tidak** diapit tanda kutip. |

Perhatikan `"tahun": 2005` dan `"stok": 4` ditulis **tanpa** tanda kutip
— artinya JavaScript akan membacanya sebagai **angka sungguhan**, bukan
teks. Ini penting: kalau kamu menuliskan `"tahun": "2005"` (dengan
kutip), nilainya akan jadi teks `"2005"`, yang meskipun terlihat sama
di layar, **tidak bisa** langsung dipakai untuk perbandingan angka
seperti `tahun > 2000` tanpa dikonversi dulu (ingat `parseInt()` yang
dipakai untuk keperluan serupa di
[dokumentasi jobsheet-05 §7.6](../../jobsheet-05/Dokumentasi/07-js-validasi-form.md#76-pola-pengecekan-per-field)).
Sebaliknya, perhatikan `"no_anggota": "A001"` sengaja ditulis sebagai
**string** (bukan angka) — konsisten dengan pembahasan
[dokumentasi jobsheet-01 §6.4](../../jobsheet-01/Dokumentasi/06-anggota-tambah-html.md#64-kenapa-no-anggota-berupa-teks-bukan-angka)
kenapa nomor anggota memakai huruf+angka, jadi tidak mungkin disimpan
sebagai tipe angka murni.

## 3.5 Bagaimana Data Ini "Berubah" Jadi Objek JavaScript?

File `.json` ini **hanyalah teks** yang disimpan di server/folder —
belum menjadi objek JavaScript yang bisa diakses lewat `buku.judul`
sampai benar-benar **diambil dan diuraikan (parse)** oleh kode. Proses
ini dilakukan oleh method `.json()` yang dipanggil setelah `fetch()`
berhasil — dibahas detail langkah demi langkah di
[bab 4 §4.5](04-js-fetch-render-buku.md#45-mengambil-data-dan-memeriksa-keberhasilannya).

Lanjut ke: [JS: Mengambil & Menampilkan Daftar Buku](04-js-fetch-render-buku.md)
