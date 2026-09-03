# 2. Cara Membaca Wireframe

**Wireframe** yang dipakai di `docs/wireframe.md` ditulis dalam bentuk
**ASCII art** (gambar dari karakter teks biasa) di dalam blok kode markdown
— mirip pendekatan yang tadinya dipakai untuk diagram box model di
[dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/01-konsep-dasar-css.md#15-kotak-setiap-elemen-html-box-model)
sebelum diganti SVG. Bedanya, untuk **wireframe rancangan** (bukan
diagram final yang dipublikasikan), ASCII art justru pilihan yang tepat:
cepat digambar, mudah diubah lagi kalau rancangan berubah, dan tidak
butuh alat desain khusus — cocok untuk tahap "sketsa kasar" sebelum
sesuatu benar-benar dibangun.

## 2.1 Contoh: Wireframe Halaman Login

```
+--------------------------------------+
|              SIMPUS-Mini             |
|--------------------------------------|
|                                      |
|        [ Login Petugas ]            |
|                                      |
|   Username : [______________]       |
|   Password : [______________]       |
|                                      |
|          [   Masuk   ]              |
|                                      |
|   Belum punya akun? Daftar di sini  |
+--------------------------------------+
```

## 2.2 Aturan Membaca Simbol-Simbolnya

Wireframe teks seperti ini punya konvensi (kesepakatan) simbol yang
sederhana:

- Kotak dari karakter pagar (`+`), strip (`-`), dan garis tegak lurus
  (dibaca "pipe") — menandai **batas luar** sebuah halaman atau
  kotak/panel di dalamnya.
- Garis tegak lurus tunggal di tengah kotak (garis vertikal pemisah) —
  menandai **pembatas antar bagian/section** di dalam satu halaman,
  mirip fungsi elemen `<section>` yang sudah kamu kenal dari
  [dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/01-konsep-dasar.md#13-tag-semantic-html5).
- `[______________]` (kurung siku berisi garis bawah) — sebuah
  **kotak input**, tempat pengguna mengetik teks (nantinya jadi
  `<input type="text">` atau `<input type="password">`, ingat konsep ini
  dari [dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#43-pola-setiap-isian-form-label--input)).
- `[  Teks  ]` (kurung siku berisi teks) — sebuah **tombol** yang bisa
  diklik (nantinya jadi `<button>`).
- Teks biasa tanpa kurung — label atau keterangan statis (nantinya jadi
  `<label>`, `<h1>`, `<p>`, dst).

Menerjemahkan wireframe Login di atas ke istilah HTML yang sudah kamu
kenal:

- `SIMPUS-Mini` di baris atas → nantinya jadi `<header><h1>` seperti di
  semua halaman yang sudah ada.
- `Login Petugas` → judul section, mirip `<h2>` di halaman-halaman
  lain (misalnya "Daftar Buku" di
  [dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/03-buku-list-html.md)).
- `Username : [______________]` dan `Password : [______________]` →
  akan jadi pasangan `<label>` + `<input>`, persis polanya seperti form
  "Tambah Buku" yang sudah kamu pelajari di
  [dokumentasi jobsheet-01 §4.3](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#43-pola-setiap-isian-form-label--input) —
  hanya saja `Password` nantinya memakai `type="password"` (jenis input
  baru yang belum pernah dipakai di jobsheet-01 sampai jobsheet-03,
  supaya karakter yang diketik disembunyikan sebagai titik-titik).
- `[ Masuk ]` → tombol submit, seperti `<button type="submit">Simpan</button>`
  yang sudah kamu kenal dari form Tambah Buku/Anggota.

## 2.3 Wireframe yang Lebih Kompleks: Dashboard Petugas

```
+-----------------------------------------------------+
| SIMPUS-Mini      Beranda | Buku | Anggota | Peminjaman | (Nama Petugas) Logout |
|-------------------------------------------------------|
|  [Total Buku]   [Total Anggota]   [Sedang Dipinjam]    |
|                                                         |
|  Aksi Cepat:                                           |
|  [ + Peminjaman Baru ]   [ + Pengembalian ]            |
|                                                         |
|  Transaksi Terbaru                                     |
|  --------------------------------------------------    |
|  Anggota | Buku | Tgl Pinjam | Status                  |
+-----------------------------------------------------+
```

Perhatikan baris navigasi paling atas: `Beranda | Buku | Anggota | Peminjaman`
— ini terlihat sangat mirip navbar yang **sudah ada** di
[`index.html`](../index.html) saat ini, hanya **ditambah** satu menu baru
("Peminjaman") dan indikator status login di kanan (`(Nama Petugas) Logout`).
Baris `[Total Buku] [Total Anggota] [Sedang Dipinjam]` juga persis
menggambarkan kartu statistik yang **sudah kamu bangun** sejak jobsheet-02
memakai CSS Grid (lihat
[dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/06-css-grid-kartu-statistik.md)).

Ini bukan kebetulan — wireframe Dashboard sengaja dirancang supaya
**melanjutkan** elemen yang sudah ada (navbar, kartu statistik),
ditambah bagian baru (`Aksi Cepat`, `Transaksi Terbaru`). Hubungan ini
dibahas lebih detail di
[bab 5](05-keterhubungan-dengan-kode.md).

## 2.4 Kenapa Wireframe Sengaja Tidak Berwarna/Detail?

Wireframe sengaja dibuat **polos** (tanpa warna, tanpa font, tanpa
ukuran presisi) supaya diskusi rancangan fokus ke **struktur dan alur**
dulu — elemen apa saja yang perlu ada, di mana posisinya secara garis
besar — tanpa terjebak berdebat soal warna tombol atau jenis font di
tahap yang masih sangat awal. Detail visual seperti itu **sudah punya
jawabannya** kalau nanti diimplementasikan, karena tinggal mengikuti
`style.css` yang sudah dibangun ([dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/README.md))
— sesuai catatan di [wireframe.md](../docs/wireframe.md) bagian
"Konsistensi dengan Desain yang Sudah Berjalan".

Lanjut ke: [User Flow: Peminjaman & Pengembalian](03-user-flow-peminjaman-pengembalian.md)
