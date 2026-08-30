# 10. Rangkuman & Latihan Lanjutan

## 10.1 Rangkuman Keseluruhan Jobsheet 2

| Bagian `style.css` | Selector Utama | Konsep CSS yang Dipelajari |
|---|---|---|
| [Reset & Body](03-css-reset-dan-body.md) | `*`, `body`, `a` | CSS reset, `box-sizing: border-box`, pewarisan gaya (*inheritance*), pseudo-class `:hover` |
| [Header & Navbar](04-css-header-navbar-flexbox.md) | `header`, `header nav ul` | **Flexbox** (`display: flex`, `align-items`, `justify-content`, `flex-wrap`, `gap`) |
| [Main & Section](05-css-main-dan-section.md) | `main`, `section` | `max-width` + `margin: auto` untuk menengahkan konten, `box-shadow`, `border-radius` |
| [Grid Kartu Statistik](06-css-grid-kartu-statistik.md) | `main section:nth-of-type(2)` | **CSS Grid** (`display: grid`, `grid-template-columns`, `fr` unit), pseudo-class posisi `:nth-of-type` |
| [Tabel](07-css-tabel.md) | `table`, `th, td`, `tbody tr:nth-child(even)` | `border-collapse`, *zebra stripes* dengan `:nth-child(even)`, styling tombol dengan `:first-of-type`/`:last-of-type` |
| [Form](08-css-form.md) | `form label`, `form input, form select` | Attribute selector `button[type="submit"]`, `display: block`, batas lebar responsif |
| [Footer](09-css-footer.md) | `footer` | Hierarki visual lewat ukuran & warna teks |

## 10.2 Konsep Inti yang Perlu Diingat

1. **CSS terpisah dari HTML** dan dihubungkan lewat `<link rel="stylesheet">`
   — satu file CSS bisa dipakai ulang di banyak halaman HTML sekaligus
   ([bab 1](01-konsep-dasar-css.md), [bab 2](02-perubahan-file-html.md)).
2. **`box-sizing: border-box`** membuat perhitungan lebar/tinggi elemen
   jauh lebih mudah diprediksi ketika ada `padding`/`border`
   ([bab 3](03-css-reset-dan-body.md)).
3. **Flexbox** untuk tata letak 1 dimensi (navbar), **CSS Grid** untuk
   tata letak 2 dimensi berbasis kolom/baris (kartu statistik) — dua
   alat berbeda untuk kebutuhan berbeda
   ([bab 4](04-css-header-navbar-flexbox.md), [bab 6](06-css-grid-kartu-statistik.md)).
4. **Pseudo-class** (`:hover`, `:nth-child`, `:nth-of-type`,
   `:first-of-type`, `:last-of-type`) memungkinkan styling berdasarkan
   **state** (kondisi kursor) atau **posisi** elemen, tanpa perlu
   menambah atribut apa pun di HTML.
5. **Spesifisitas** menentukan aturan mana yang menang kalau ada dua
   aturan CSS yang menyasar elemen yang sama — selector lebih spesifik
   (lebih banyak "syarat") umumnya menang, kecuali kalau spesifisitasnya
   sama, di mana **urutan penulisan di file** yang menentukan
   ([bab 4 §4.7](04-css-header-navbar-flexbox.md#47-kenapa-selector-header-nav-a-lebih-menang-daripada-a),
   [bab 7 §7.5](07-css-tabel.md#75-baris-selang-seling--efek-hover)).

## 10.3 Cara Mencoba Sendiri

1. Buka `index.html` di browser dan bandingkan dengan tampilan
   `index.html` jobsheet-01 (tanpa CSS) — perhatikan navbar sekarang
   sejajar horizontal, dan kartu statistik tersusun 3 kolom.
2. Buka *DevTools* browser (klik kanan → *Inspect*/*Inspeksi*, atau
   tombol `F12`), klik tab **Elements/Inspector**, lalu klik salah satu
   elemen (misalnya kartu "Total Buku"). Panel di sebelahnya akan
   menampilkan aturan CSS mana saja yang berlaku pada elemen itu —
   cara terbaik untuk **melihat langsung** hubungan antara selector CSS
   dan tampilannya.
3. Di DevTools, coba ubah salah satu nilai CSS secara langsung (misalnya
   ubah `grid-template-columns: repeat(3, 1fr)` menjadi `repeat(2, 1fr)`)
   dan lihat efeknya seketika — perubahan ini **sementara**, hanya di
   browser, tidak mengubah file aslinya, jadi aman untuk bereksperimen.

## 10.4 Ide Latihan Tambahan (Opsional)

1. **Ubah skema warna** — ganti nilai `#1d5b8a` (warna biru tema) di
   seluruh file `style.css` dengan warna lain, misalnya hijau tua, lalu
   amati bagaimana warna itu konsisten muncul di header, judul section,
   tombol submit, dan header tabel — karena semuanya memakai nilai hex
   yang sama.
2. **Tambah kolom keempat** di grid kartu statistik — tambahkan satu
   `<article>` baru di HTML (misalnya "Buku Terlambat"), lalu ubah
   `repeat(3, 1fr)` menjadi `repeat(4, 1fr)` di CSS.
3. **Buat tombol ketiga di tabel** — tambahkan tombol "Detail" di antara
   Edit dan Hapus pada `buku/list.html`, lalu amati apakah warnanya
   sesuai harapan (ingat catatan di
   [bab 7 §7.6](07-css-tabel.md#76-tombol-aksi-edit--hapus) tentang
   `:first-of-type`/`:last-of-type` yang berbasis posisi, bukan makna).
   Coba perbaiki dengan memberi `class` khusus jika warnanya tidak
   sesuai.
4. **Uji responsivitas sederhana** — perkecil lebar jendela browser
   secara bertahap sampai sangat sempit (seperti lebar HP), amati kapan
   `flex-wrap: wrap` pada navbar mulai memindahkan menu ke baris baru.

Kalau ada bagian yang masih membingungkan, coba baca ulang
[konsep dasar CSS di bab 1](01-konsep-dasar-css.md) — sebagian besar
istilah teknis di bab-bab lain dijelaskan di sana.
