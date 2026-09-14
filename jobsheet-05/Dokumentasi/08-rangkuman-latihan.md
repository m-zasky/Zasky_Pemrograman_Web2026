# 8. Rangkuman & Latihan Lanjutan

## 8.1 Rangkuman Keseluruhan Jobsheet 5

| Bagian | Fungsi di `app.js` | Konsep yang Dipelajari |
|---|---|---|
| [Konsep Dasar JS & DOM](01-konsep-dasar-javascript-dom.md) | — | `<script>`, DOM, `getElementById`/`querySelector`, event & event listener |
| [Perubahan HTML](02-perubahan-file-html.md) | — | Tombol hamburger asli, `search-box`, class `btn-hapus`, `id="form-tambah"` |
| [CSS Pendukung](03-css-pendukung-javascript.md) | — | Gaya untuk `.error`, `.search-box`, penyesuaian hamburger |
| [Menu Hamburger](04-js-hamburger-menu.md) | `initNavToggle` | `classList.toggle()`, event `click`, guard clause |
| [Konfirmasi Hapus](05-js-konfirmasi-hapus.md) | `initHapusConfirm` | `querySelectorAll` + `forEach`, `closest()`, `confirm()`, `remove()` |
| [Filter Tabel](06-js-filter-tabel.md) | `initTableFilter` | Event `keyup`, `textContent`, `style.display`, `includes()` |
| [Validasi Form](07-js-validasi-form.md) | `initValidasiForm`, `tampilkanError`, `hapusError` | Event `submit`, `preventDefault()`, `createElement`, `insertAdjacentElement`, `classList.contains()` |

## 8.2 Konsep Inti yang Perlu Diingat

1. **JavaScript menambah lapisan perilaku**, terpisah dari struktur
   (HTML) dan tampilan (CSS) — dihubungkan lewat `<script src="...">`
   yang diletakkan di akhir `<body>` ([bab 1](01-konsep-dasar-javascript-dom.md)).
2. **DOM adalah "pohon" objek** yang bisa dibaca dan diubah lewat
   `getElementById`/`querySelector`/`querySelectorAll`, memakai selector
   CSS yang sama dengan yang sudah kamu kuasai sejak jobsheet-02
   ([bab 1 §1.5](01-konsep-dasar-javascript-dom.md#15-memilih-elemen-dari-dom)).
3. **Event listener adalah pola inti interaktivitas**: pilih elemen →
   `.addEventListener(event, fungsi)` → tulis reaksinya. Tiga event
   utama di jobsheet ini: `click`, `keyup`, `submit`
   ([bab 1 §1.6](01-konsep-dasar-javascript-dom.md#16-apa-itu-event-dan-event-listener)).
4. **`classList.toggle()`/`.contains()`** adalah cara modern mengatur
   status tampilan lewat class CSS, menggantikan trik CSS murni seperti
   checkbox hack ketika JavaScript sudah tersedia
   ([bab 4 §4.6](04-js-hamburger-menu.md#46-bandingkan-dengan-checkbox-hack-jobsheet-03)).
5. **Guard clause** (`if (!elemen) return;`) penting supaya satu file
   JavaScript yang sama aman dipakai di banyak halaman berbeda, tanpa
   error di halaman yang tidak punya elemen tertentu
   ([bab 1 §1.7](01-konsep-dasar-javascript-dom.md#17-struktur-umum-kode-di-appjs)).
6. **Validasi client-side bisa dilewati** dan bukan pengganti validasi
   server-side — ini lapisan kenyamanan pengguna, bukan lapisan keamanan
   ([bab 7 §7.8](07-js-validasi-form.md#78-kenapa-validasi-html-required-min-max-masih-perlu-diduplikasi-di-js)).

## 8.3 Cara Mencoba Sendiri

1. Buka `index.html`, perkecil layar ke mode mobile (DevTools
   responsif, ingat caranya dari
   [dokumentasi jobsheet-03 §5.6](../../jobsheet-03/Dokumentasi/05-css-media-query-breakpoint.md#56-cara-menguji-sendiri-di-browser)),
   lalu klik ikon hamburger — bandingkan rasanya dengan versi checkbox
   hack di jobsheet-03 (secara visual identik, tapi mekanismenya
   berbeda total di balik layar).
2. Buka `buku/list.html`, ketik sebagian judul buku (misalnya "bumi") di
   kolom cari, amati baris lain otomatis hilang. Hapus teksnya lagi,
   amati semua baris muncul kembali.
3. Klik tombol "Hapus" di salah satu baris — muncul dialog konfirmasi.
   Klik "Cancel", baris tetap ada. Coba lagi dan klik "OK", baris
   hilang. Refresh halaman — perhatikan baris itu muncul kembali (ingat
   catatan di [bab 5 §5.6](05-js-konfirmasi-hapus.md#56-menghapus-baris-dari-tampilan)).
4. Buka `buku/tambah.html`, langsung klik "Simpan" tanpa mengisi apa
   pun — amati pesan error merah muncul di bawah field yang wajib
   diisi. Isi salah satu field yang error, klik "Simpan" lagi — amati
   pesan error field itu hilang, sementara field lain yang masih kosong
   tetap menampilkan errornya.
5. Buka **DevTools Console** (`F12` → tab *Console*) sambil mencoba
   langkah 2-4 di atas — perhatikan tidak ada pesan error JavaScript
   yang muncul, menandakan guard clause dan penanganan elemen sudah
   benar.

## 8.4 Ide Latihan Tambahan (Opsional)

1. **Tambah validasi field baru** — misalnya field ISBN di form Tambah
   Buku (yang saat ini tidak wajib diisi, ingat dari
   [dokumentasi jobsheet-01 §4.4](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#44-jenis-jenis-input-yang-dipakai))
   validasi supaya hanya menerima angka dan tanda hubung.
2. **Tambah animasi sederhana** pada `initNavToggle` — misalnya
   tambahkan class CSS `transition` pada `header nav` di `style.css`
   supaya menu terbuka/tertutup dengan efek geser halus, alih-alih
   langsung muncul/hilang seketika.
3. **Perluas `initTableFilter`** supaya pencarian bisa dibatasi ke satu
   kolom saja (misalnya hanya kolom "Judul"), bukan mencari di seluruh
   teks baris — petunjuk: gunakan `row.querySelector("td")` seperti pola
   yang sudah dipakai di [bab 5 §5.4](05-js-konfirmasi-hapus.md#54-mengambil-namajudul-dari-baris-itu),
   alih-alih `row.textContent`.
4. **Tambah counter jumlah baris tersisa** setelah difilter atau
   dihapus — tampilkan misalnya "Menampilkan 3 dari 5 buku" di atas
   tabel, diperbarui setiap kali `initTableFilter` atau
   `initHapusConfirm` berjalan.
5. **Refactor validasi** — coba ubah `initValidasiForm` supaya nama
   field yang wajib divalidasi diambil dari sebuah array/daftar,
   alih-alih menulis blok `if` terpisah untuk tiap field satu-satu
   (petunjuk: pikirkan pola perulangan `forEach` yang sudah dipakai di
   [bab 5](05-js-konfirmasi-hapus.md) dan [bab 6](06-js-filter-tabel.md)).

Kalau ada bagian yang masih membingungkan, coba baca ulang
[bab 1](01-konsep-dasar-javascript-dom.md) sambil mempraktikkan langsung
di DevTools Console — ketik `document.querySelector("header nav")` di
tab Console salah satu halaman, lalu amati elemen apa yang dikembalikan,
supaya konsep "memilih elemen dari DOM" terasa nyata, bukan sekadar
teori.
