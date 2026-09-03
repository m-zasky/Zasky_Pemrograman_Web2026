# 6. Rangkuman & Latihan Lanjutan

## 6.1 Rangkuman Keseluruhan Jobsheet 4

| Bagian | Konsep yang Dipelajari |
|---|---|
| [Konsep Dasar UI/UX](01-konsep-uiux-design.md) | Beda UI vs UX, alasan merancang sebelum coding |
| [Cara Membaca Wireframe](02-cara-membaca-wireframe.md) | Konvensi simbol ASCII wireframe, menerjemahkannya ke elemen HTML |
| [User Flow](03-user-flow-peminjaman-pengembalian.md) | Diagram alur langkah demi langkah, mencatat aturan bisnis sejak tahap rancangan |
| [Aktor & Otorisasi](04-aktor-dan-otorisasi.md) | Konsep aktor (Tamu vs Petugas), pengantar otorisasi |
| [Keterhubungan dengan Kode](05-keterhubungan-dengan-kode.md) | Bagaimana rancangan baru memakai ulang CSS/pola yang sudah dibangun sejak jobsheet-02/03 |

## 6.2 Konsep Inti yang Perlu Diingat

1. **Tidak semua jobsheet harus menambah kode.** Merancang dulu sebelum
   coding adalah bagian sah dan penting dari proses pengembangan
   software, bukan langkah yang bisa dilewati begitu saja
   ([bab 1](01-konsep-uiux-design.md)).
2. **Wireframe menjawab "apa isinya", user flow menjawab "bagaimana
   urutannya"** — keduanya saling melengkapi, bukan saling
   menggantikan ([bab 2](02-cara-membaca-wireframe.md),
   [bab 3](03-user-flow-peminjaman-pengembalian.md)).
3. **Mendefinisikan aktor di awal** membantu menentukan halaman mana
   yang perlu dijaga otorisasinya, jauh sebelum kode pengecekan login
   itu sendiri ditulis ([bab 4](04-aktor-dan-otorisasi.md)).
4. **Rancangan yang baik memakai ulang** apa yang sudah ada (CSS,
   pola komponen) alih-alih membangun dari nol — terlihat dari
   bagaimana wireframe Dashboard mengadopsi kartu statistik dan navbar
   yang sudah kamu bangun sejak jobsheet-02
   ([bab 5](05-keterhubungan-dengan-kode.md)).
5. **Mencatat edge case sejak tahap rancangan** (stok buku habis,
   anggota bertunggakan) mencegah kasus-kasus itu terlupakan saat
   coding sungguhan nanti ([bab 5 §5.5](05-keterhubungan-dengan-kode.md#55-edge-case-yang-sudah-dicatat-sejak-sekarang)).

## 6.3 Cara "Mencoba" Jobsheet Ini

Karena tidak ada kode baru untuk dijalankan di browser, cara terbaik
mempraktikkan jobsheet ini adalah **membaca ulang wireframe sambil
membayangkan dirimu sebagai Petugas** yang menjalankan setiap langkah:

1. Buka [`docs/wireframe.md`](../docs/wireframe.md) dan baca tiap
   wireframe sambil membayangkan bagaimana tampilannya kalau digambar
   sungguhan mengikuti `style.css` yang sudah ada.
2. Ikuti user flow Peminjaman ([bab 3 §3.2](03-user-flow-peminjaman-pengembalian.md#32-user-flow-peminjaman-buku))
   langkah demi langkah sambil membayangkan halaman mana yang terbuka
   di tiap kotak.
3. Bandingkan navbar dan kartu statistik di [`index.html`](../index.html)
   yang sudah berjalan dengan wireframe Dashboard Petugas — temukan
   sendiri bagian mana yang sama persis dan mana yang baru.

## 6.4 Ide Latihan Tambahan (Opsional)

1. **Gambar wireframe halaman baru** memakai konvensi ASCII yang sama
   ([bab 2 §2.2](02-cara-membaca-wireframe.md#22-aturan-membaca-simbol-simbolnya)) —
   misalnya halaman "Registrasi Anggota Baru" untuk aktor Tamu yang
   ingin jadi anggota perpustakaan.
2. **Buat user flow baru** untuk skenario yang belum digambarkan di
   `wireframe.md`, misalnya: "Petugas mencari anggota yang tunggakannya
   sudah lewat jatuh tempo."
3. **Identifikasi edge case tambahan** yang mungkin belum tercatat,
   contoh: apa yang terjadi kalau Petugas mencoba meminjamkan buku yang
   sama ke anggota yang sama dua kali berturut-turut?
4. **Coba implementasikan wireframe Login sebagai HTML statis** (tanpa
   logika login sungguhan, mirip form Tambah Buku yang belum diproses
   di jobsheet-01) sebagai latihan menerjemahkan wireframe ke kode
   nyata — gunakan pola `<label>` + `<input>` yang sudah kamu kuasai
   dari [dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md),
   ditambah satu `<input type="password">` baru untuk field Password.

Kalau ada bagian yang masih membingungkan, coba baca ulang
[bab 1](01-konsep-uiux-design.md) — konsep "kenapa merancang dulu"
adalah fondasi yang menjelaskan alasan di balik seluruh isi jobsheet ini.
