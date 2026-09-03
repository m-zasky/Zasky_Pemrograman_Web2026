# 3. User Flow: Peminjaman & Pengembalian

Kalau wireframe ([bab 2](02-cara-membaca-wireframe.md)) menggambarkan
**satu halaman**, **user flow** menggambarkan **urutan langkah** yang
dilalui pengguna melintasi beberapa halaman/aksi untuk menyelesaikan satu
tugas tertentu.

## 3.1 Apa itu User Flow?

**User flow** (alur pengguna) adalah diagram sederhana berbentuk
kotak-kotak yang dihubungkan tanda panah `->`, menunjukkan **urutan
langkah demi langkah**. Setiap kotak mewakili satu layar, satu aksi, atau
satu keputusan yang dilakukan pengguna. Tujuannya: memastikan **tidak ada
langkah yang terlewat atau ambigu** sebelum fitur itu benar-benar dikoding.

## 3.2 User Flow: Peminjaman Buku

```
[Petugas Login] -> [Dashboard] -> [Pilih menu "Peminjaman Baru"]
        -> [Pilih Anggota] -> [Pilih Buku (stok > 0)]
        -> [Simpan] -> [Stok buku berkurang 1] -> [Kembali ke Dashboard]
```

Mari telusuri kotak demi kotak:

1. **`[Petugas Login]`** — Petugas harus login lebih dulu (wireframe
   halaman ini sudah dibahas di
   [bab 2 §2.1](02-cara-membaca-wireframe.md#21-contoh-wireframe-halaman-login)).
   Kotak ini menegaskan bahwa fitur peminjaman **tidak bisa diakses
   Tamu** — dibahas lebih dalam soal aktor di
   [bab 4](04-aktor-dan-otorisasi.md).
2. **`[Dashboard]`** — setelah login berhasil, Petugas mendarat di
   halaman Dashboard (wireframe-nya di
   [bab 2 §2.3](02-cara-membaca-wireframe.md#23-wireframe-yang-lebih-kompleks-dashboard-petugas)).
3. **`[Pilih menu "Peminjaman Baru"]`** — Petugas mengklik salah satu
   tombol "Aksi Cepat" yang ada di Dashboard.
4. **`[Pilih Anggota]`** dan **`[Pilih Buku (stok > 0)]`** — dua langkah
   pengisian form berurutan. Perhatikan catatan penting `(stok > 0)` —
   ini adalah **aturan bisnis** (business rule) yang sengaja dituliskan
   di user flow: buku yang stoknya habis **tidak boleh muncul** sebagai
   pilihan. Menuliskan aturan ini di tahap rancangan memastikan
   developer tidak lupa menerapkannya nanti saat coding (ingat
   pentingnya merancang dulu dari
   [bab 1 §1.2](01-konsep-uiux-design.md#12-kenapa-merancang-dulu-baru-coding)).
5. **`[Simpan]`** — Petugas menekan tombol submit (mirip
   `<button type="submit">` yang sudah kamu kenal dari
   [dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#45-tombol-submit),
   hanya saja form ini nantinya **benar-benar akan diproses** ke
   database — beda dengan form Tambah Buku/Anggota yang di
   jobsheet-01 sampai jobsheet-03 memang sengaja belum diproses).
6. **`[Stok buku berkurang 1]`** — ini adalah **efek samping otomatis**
   di balik layar: begitu peminjaman disimpan, sistem harus mengurangi
   angka stok buku itu sendiri. Kotak ini **bukan** sebuah halaman,
   melainkan pengingat bahwa ada **logika program** yang perlu ditulis
   di balik tombol Simpan (baru akan diimplementasikan dengan
   JavaScript/backend di jobsheet-jobsheet mendatang — lihat
   [README.md](../README.md) jobsheet ini).
7. **`[Kembali ke Dashboard]`** — alur ditutup dengan kembali ke titik
   awal, menunjukkan siklus selesai dan Petugas bisa mengulang alur ini
   untuk peminjaman berikutnya.

## 3.3 User Flow: Pengembalian Buku

```
[Dashboard] -> [Menu "Pengembalian"] -> [Cari transaksi aktif (anggota/buku)]
        -> [Tandai "Dikembalikan"] -> [Stok buku bertambah 1]
        -> [Kembali ke Dashboard]
```

Alur ini punya bentuk mirip, tapi perhatikan perbedaannya:

- Dimulai dari **mencari transaksi yang aktif** (peminjaman yang belum
  dikembalikan), bukan mengisi form data baru dari nol — masuk akal,
  karena mengembalikan buku berarti **mencocokkan** dengan data
  peminjaman yang sudah ada, bukan membuat data baru.
- Efek sampingnya adalah **kebalikan** dari alur peminjaman: stok
  **bertambah** 1, bukan berkurang.

Membandingkan dua user flow yang mirip strukturnya seperti ini adalah
cara yang baik untuk memeriksa **konsistensi rancangan** — kalau kedua
alur ini bentuknya sangat berbeda tanpa alasan jelas, itu bisa jadi
tanda ada sesuatu yang perlu dipikirkan ulang.

## 3.4 Kenapa User Flow Ditulis Sebelum Ada Form-nya?

Sama seperti alasan di [bab 1 §1.2](01-konsep-uiux-design.md#12-kenapa-merancang-dulu-baru-coding):
menuliskan urutan langkah ini **sebelum** ada satu baris kode form
Peminjaman memastikan pertanyaan-pertanyaan penting sudah terjawab lebih
dulu, misalnya:

- Apakah anggota bisa meminjam **lebih dari satu buku** sekaligus dalam
  satu transaksi? (Wireframe form Peminjaman di
  `docs/wireframe.md` menunjukkan satu buku per transaksi — ini
  keputusan rancangan yang sudah diambil sejak tahap ini.)
- Siapa saja yang boleh mengakses fitur ini? (Dijawab di
  [bab 4](04-aktor-dan-otorisasi.md).)
- Bagaimana urutan yang paling wajar dari sudut pandang Petugas yang
  benar-benar memakainya sehari-hari?

Lanjut ke: [Aktor & Kaitannya dengan Otorisasi](04-aktor-dan-otorisasi.md)
