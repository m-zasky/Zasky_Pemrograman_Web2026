# 7. Rangkuman & Latihan Lanjutan

## 7.1 Rangkuman Keseluruhan Jobsheet 1

| File | Fungsi | Elemen Baru yang Dipelajari |
|---|---|---|
| [`index.html`](02-index-html.md) | Beranda + ringkasan statistik | `header`, `nav`, `main`, `section`, `article`, `footer` |
| [`buku/list.html`](03-buku-list-html.md) | Tabel daftar buku | `table`, `thead`, `tbody`, `tr`, `th`, `td`, `button type="button"` |
| [`buku/tambah.html`](04-buku-tambah-html.md) | Form tambah buku | `form`, `label`, `input` (`text`/`number`), `select`/`option`, `button type="submit"`, atribut `required`/`min`/`max` |
| [`anggota/list.html`](05-anggota-list-html.md) | Tabel daftar anggota (tugas mandiri) | Penerapan ulang pola tabel pada data berbeda |
| [`anggota/tambah.html`](06-anggota-tambah-html.md) | Form tambah anggota (tugas mandiri) | Penerapan ulang pola form pada data berbeda |

Secara umum, jobsheet 1 mengajarkan **3 pola HTML** yang akan terus
dipakai berulang-ulang di seluruh aplikasi:

1. **Kerangka halaman** (`header` + `nav` + `main` + `footer`) — sama di
   semua 5 halaman.
2. **Tabel data** (`table`/`thead`/`tbody`/`tr`/`th`/`td`) — dipakai di
   kedua halaman "list".
3. **Form isian** (`form`/`label`/`input`/`select`/`button`) — dipakai di
   kedua halaman "tambah".

## 7.2 Hal yang Perlu Diingat: Ini Baru Kerangka

Beberapa hal yang **sengaja belum ada** di jobsheet ini (bukan bug,
memang belum waktunya dipelajari):

- **Tidak ada CSS** → tampilan masih polos, tanpa warna/tata letak rapi.
- **Tidak ada JavaScript** → tombol Edit/Hapus di tabel belum berfungsi.
- **Form belum terhubung ke mana pun** (`<form>` tanpa `action`) → tombol
  "Simpan" belum benar-benar menyimpan data.
- **Data tabel adalah data statis (dummy)**, diketik manual di HTML,
  bukan diambil dari database.

Semua ini akan mulai dipelajari di jobsheet berikutnya.

## 7.3 Cara Mencoba Sendiri

1. Buka file `index.html` langsung di browser (klik dua kali, atau
   klik kanan → *Open with* → pilih browser). Belum butuh server apa pun.
2. Klik menu navigasi di header untuk berpindah antar halaman, perhatikan
   bagaimana `href` pada tiap `<a>` menentukan halaman tujuan.
3. Coba isi form di `buku/tambah.html` atau `anggota/tambah.html`, lalu
   klik "Simpan" — amati bahwa tidak terjadi apa-apa selain reload
   halaman (karena belum ada `action`).
4. Coba kosongkan salah satu field yang punya atribut `required`, lalu
   klik "Simpan" — perhatikan browser menampilkan peringatan validasi
   otomatis bawaan HTML5.

## 7.4 Ide Latihan Tambahan (Opsional)

Untuk memperdalam pemahaman, coba lakukan sendiri (tidak wajib, tapi
sangat disarankan untuk latihan):

1. **Lengkapi konsistensi menu** — tambahkan tautan "Daftar Anggota" dan
   "Tambah Anggota" ke menu `<nav>` di `index.html`, `buku/list.html`,
   dan `buku/tambah.html` (lihat catatan di
   [dokumentasi anggota/list.html §5.4](05-anggota-list-html.md#54-perhatikan-menu-navigasi)).
2. **Tambah 2 baris data buku baru** di `buku/list.html` dengan meng-copy
   satu blok `<tr>...</tr>` lalu mengganti isinya.
3. **Tambah kolom baru** di tabel anggota, misalnya "Tanggal Bergabung",
   lengkap dengan `<th>` dan `<td>`-nya di setiap baris.
4. **Tambah field baru** di form tambah anggota, misalnya "Email"
   memakai `<input type="email">` (`type="email"` otomatis memvalidasi
   format alamat email tanpa perlu JavaScript tambahan).

Selamat belajar — kalau ada bagian yang masih membingungkan, coba baca
ulang [konsep dasar di file 1](01-konsep-dasar.md), karena hampir semua
istilah teknis di file-file lain dijelaskan di sana.
