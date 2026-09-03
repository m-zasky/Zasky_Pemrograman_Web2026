# 4. Aktor & Kaitannya dengan Otorisasi

## 4.1 Apa itu "Aktor" dalam Rancangan UI/UX?

**Aktor** adalah istilah untuk **jenis pengguna** yang berinteraksi
dengan sistem, dibedakan berdasarkan **apa yang boleh mereka lakukan**.
`docs/wireframe.md` mendefinisikan 2 aktor untuk SIMPUS-Mini:

> - **Tamu**: hanya bisa melihat katalog buku (Beranda, Daftar Buku)
>   tanpa login.
> - **Petugas**: login untuk mengakses seluruh fitur CRUD dan transaksi
>   peminjaman.

Mendefinisikan aktor di awal itu penting karena **halaman yang sama
persis** bisa punya arti berbeda tergantung siapa yang membukanya —
dan itu menentukan fitur apa saja yang perlu dibangun untuk masing-masing.

## 4.2 Aktor "Tamu" — Yang Sudah Bisa Kamu Coba Sekarang

Semua halaman yang **sudah ada** sejak jobsheet-01 sampai jobsheet-03 —
[Beranda](../index.html), [Daftar Buku](../buku/list.html), dan
seterusnya — sebenarnya **mewakili sudut pandang aktor Tamu**: siapa
pun bisa membukanya langsung tanpa perlu login apa pun. Coba perhatikan:
halaman-halaman itu memang tidak punya elemen "logout" atau nama
pengguna di mana pun — konsisten dengan definisi aktor Tamu yang "hanya
bisa melihat katalog buku... tanpa login."

## 4.3 Aktor "Petugas" — Yang Baru Dirancang di Jobsheet Ini

Semua wireframe baru di `docs/wireframe.md` (Login, Dashboard, form
Peminjaman/Pengembalian, Riwayat) adalah sudut pandang aktor
**Petugas** — dan **semuanya** mensyaratkan login terlebih dulu. Ini
terlihat jelas dari user flow yang sudah dibahas di
[bab 3](03-user-flow-peminjaman-pengembalian.md): baik alur Peminjaman
maupun Pengembalian **selalu dimulai** dari kotak yang mengandaikan
Petugas sudah masuk sistem (`[Petugas Login]` atau langsung
`[Dashboard]`, yang hanya bisa dicapai setelah login).

## 4.4 Apa itu Otorisasi, dan Kenapa Belum Ada di Jobsheet Ini?

**Otorisasi** (*authorization*) adalah mekanisme sistem untuk
**membatasi** siapa yang boleh melakukan/melihat apa — misalnya
memastikan hanya Petugas yang login yang bisa membuka halaman
Peminjaman, sementara Tamu yang mencoba membukanya akan dialihkan
(redirect) ke halaman Login.

Perhatikan otorisasi ini **butuh kode program sungguhan** untuk bekerja
(memeriksa status login, menyimpan sesi pengguna, dsb.) — sesuatu yang
belum bisa dilakukan HTML/CSS statis seperti yang sudah kamu pelajari di
[jobsheet-01](../../jobsheet-01/Dokumentasi/README.md) sampai
[jobsheet-03](../../jobsheet-03/Dokumentasi/README.md). Inilah kenapa
fitur Login dan Peminjaman **belum diimplementasikan** di jobsheet ini —
sesuai catatan di [README.md](../README.md) jobsheet ini, fitur ini baru
akan dibangun mulai jobsheet-jobsheet mendatang dengan bantuan
JavaScript, lalu PHP/PostgreSQL untuk mengelola data sungguhan di sisi
server.

## 4.5 Kenapa Merancang Aktor Lebih Dulu Itu Penting?

Dengan mendefinisikan 2 aktor ini **sebelum** menulis kode Login,
developer sudah punya jawaban jelas untuk pertanyaan-pertanyaan yang
akan muncul saat coding nanti, misalnya:

- Halaman mana saja yang perlu dijaga dengan pengecekan login, dan mana
  yang tetap boleh diakses bebas? (Jawabannya sudah tersirat dari
  pembagian aktor: halaman katalog untuk Tamu tetap bebas, halaman
  transaksi untuk Petugas perlu dijaga.)
- Apa yang terjadi kalau Tamu mencoba mengakses URL halaman Dashboard
  secara langsung tanpa login? (Ini "edge case" yang perlu dipikirkan
  sejak tahap rancangan, meski implementasi teknisnya menyusul nanti.)

Lanjut ke: [Keterhubungan dengan Kode yang Sudah Ada](05-keterhubungan-dengan-kode.md)
