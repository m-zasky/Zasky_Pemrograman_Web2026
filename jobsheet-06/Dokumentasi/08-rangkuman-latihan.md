# 8. Rangkuman & Latihan Lanjutan

## 8.1 Rangkuman Keseluruhan Jobsheet 6

| Bagian | Konsep yang Dipelajari |
|---|---|
| [Konsep Dasar](01-konsep-dasar-fetch-json.md) | AJAX, format JSON, `fetch()`, Promise, `async`/`await`, `try`/`catch`/`finally` |
| [Perubahan HTML](02-perubahan-file-html.md) | `<tbody>` kosong, loading indicator, urutan `<script>` |
| [Data JSON](03-data-json.md) | Struktur `buku.json`/`anggota.json`, tipe data JSON |
| [Fetch & Render Buku](04-js-fetch-render-buku.md) | Alur lengkap `muatDaftarBuku`: fetch → cek status → parse → render → error handling |
| [Fetch & Render Anggota](05-js-fetch-render-anggota.md) | Pola yang sama diterapkan ke data berbeda |
| [Event Delegation](06-js-event-delegation-hapus.md) | Kenapa & bagaimana menangani elemen yang dibuat dinamis |
| [Server Lokal & CORS](07-menjalankan-dengan-server-lokal.md) | Kenapa `fetch()` butuh `http://`, cara menjalankan server lokal |

## 8.2 Konsep Inti yang Perlu Diingat

1. **`fetch()` selalu asinkron** — hasilnya berupa Promise, butuh
   `await` (di dalam `async function`) untuk mendapatkan data
   sungguhan ([bab 1](01-konsep-dasar-fetch-json.md)).
2. **`res.ok` harus diperiksa manual** — `fetch()` tidak otomatis
   dianggap gagal hanya karena file/endpoint tidak ditemukan
   ([bab 4 §4.5](04-js-fetch-render-buku.md#45-mengambil-data-dan-memeriksa-keberhasilannya)).
3. **`try`/`catch`/`finally` menjaga aplikasi tetap "hidup"** meski
   terjadi kegagalan jaringan — pengguna melihat pesan error yang jelas,
   bukan halaman rusak/kosong tanpa penjelasan
   ([bab 1 §1.6](01-konsep-dasar-fetch-json.md#16-menangani-kegagalan-trycatchfinally)).
4. **Event delegation diperlukan untuk elemen dinamis** — begitu elemen
   dibuat setelah `DOMContentLoaded` (lewat `fetch` atau interaksi
   lain), pasang listener di elemen leluhur yang stabil, bukan di
   elemen itu sendiri ([bab 6](06-js-event-delegation-hapus.md)).
5. **`fetch()` butuh server, bukan `file://`** — ingat menjalankan lewat
   `php -S localhost:8000`, Live Server, atau Laragon setiap kali mencoba
   jobsheet ini ([bab 7](07-menjalankan-dengan-server-lokal.md)).

## 8.3 Cara Mencoba Sendiri

1. **Jalankan server lokal dulu** (ingat [bab 7](07-menjalankan-dengan-server-lokal.md) —
   ini **wajib**, tidak seperti jobsheet-jobsheet sebelumnya).
2. Buka `http://localhost:8000/buku/list.html` (sesuaikan port kalau
   berbeda). Amati sekilas teks "Memuat data..." muncul sebelum tabel
   terisi 10 baris buku.
3. Buka **DevTools → tab Network**, refresh halaman, cari permintaan ke
   `buku.json` — klik untuk melihat respons JSON mentahnya, bandingkan
   dengan isi file `data/buku.json` yang sudah kamu baca di
   [bab 3](03-data-json.md).
4. Coba fitur pencarian dan tombol Hapus seperti di jobsheet-05 — amati
   keduanya tetap berfungsi normal meski barisnya sekarang dibuat
   dinamis.
5. Praktikkan langkah menguji error di
   [bab 7 §7.5](07-menjalankan-dengan-server-lokal.md#75-cara-menguji-penanganan-error) —
   sengaja salah ketik nama file JSON, amati pesan error tampil rapi di
   dalam tabel.

## 8.4 Ide Latihan Tambahan (Opsional)

1. **Tambah tombol "Muat Ulang"** di halaman Daftar Buku yang, saat
   diklik, memanggil ulang `muatDaftarBuku()` — perhatikan fungsi ini
   sudah mengosongkan `tbody` terlebih dulu
   ([bab 4 §4.3](04-js-fetch-render-buku.md#43-menampilkan-dan-menyembunyikan-loading-indicator)),
   jadi aman dipanggil berkali-kali.
2. **Satukan `buku.js` dan `anggota.js`** jadi satu fungsi generik yang
   menerima nama file JSON dan daftar nama kunci sebagai parameter —
   latihan langsung untuk pertanyaan yang diajukan di
   [bab 5 §5.4](05-js-fetch-render-anggota.md#54-kenapa-ditulis-di-dua-file-terpisah-bukan-satu-fungsi-generik).
3. **Tambah kolom baru** di `data/buku.json` (misalnya `"kategori"`),
   lalu tampilkan di tabel dengan menambah satu `<th>` di HTML dan satu
   `<td>` di `tr.innerHTML` pada `buku.js`.
4. **Uji delegasi event lebih jauh** — tambahkan `console.log(e.target)`
   di awal fungsi `initHapusConfirm` ([bab 6](06-js-event-delegation-hapus.md)),
   buka Console, lalu klik berbagai tempat di halaman (bukan cuma
   tombol Hapus) untuk melihat sendiri bagaimana `document` menerima
   **semua** event klik di halaman, dan bagaimana `e.target.closest(...)`
   menyaring hanya yang relevan.
5. **Ganti delay simulasi** di [bab 4 §4.4](04-js-fetch-render-buku.md#44-simulasi-delay-jaringan)
   dari `600` menjadi `3000` (3 detik), amati loading indicator jadi
   jauh lebih terlihat — ini juga cara yang baik untuk merasakan
   pentingnya loading indicator pada koneksi yang lambat.

Kalau ada bagian yang masih membingungkan, coba baca ulang
[bab 1](01-konsep-dasar-fetch-json.md) sambil membuka DevTools Console —
ketik `await fetch("../data/buku.json").then(r => r.json())` langsung
di Console (dari halaman `buku/list.html` yang dibuka lewat server
lokal) untuk melihat sendiri data yang dikembalikan, tanpa perlu
membaca lewat tabel.
