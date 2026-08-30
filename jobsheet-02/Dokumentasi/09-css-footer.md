# 9. CSS: Footer

Bagian terakhir dan paling sederhana di `style.css`.

## 9.1 Kode CSS

```css
/* ===== Footer ===== */
footer {
    text-align: center;
    padding: 1.25rem;
    color: #7a8794;
    font-size: 0.9rem;
}
```

## 9.2 Penjelasan

Menata teks copyright di [`<footer>`](../../jobsheet-01/dokumentasi/02-index-html.md#footer--kaki-halaman)
(`© 2026 SIMPUS-Mini — Jobsheet 1`) yang muncul di semua halaman:

| Properti | Efek |
|---|---|
| `text-align: center;` | Teks diratakan ke **tengah** halaman, bukan rata kiri seperti teks pada umumnya — memberi kesan footer sebagai penutup yang "netral", tidak berat sebelah. |
| `padding: 1.25rem;` | Jarak seragam di keempat sisi, memberi ruang napas di sekitar teks copyright. |
| `color: #7a8794;` | Abu-abu medium — sengaja dibuat **lebih pudar/kurang menonjol** dibanding warna teks utama (`#2b2b2b` dari [bab 3](03-css-reset-dan-body.md#32-gaya-dasar-body)), karena info copyright memang bukan informasi utama yang perlu menarik perhatian pengguna. |
| `font-size: 0.9rem;` | Ukuran teks sedikit **lebih kecil** dari ukuran normal (`1rem`), memperkuat kesan bahwa ini teks sekunder/tambahan. |

Pola ini — memperkecil ukuran dan memudarkan warna untuk informasi yang
kurang penting — adalah teknik hierarki visual yang sama dengan yang
dibahas di [bab 6 (label kartu statistik)](06-css-grid-kartu-statistik.md#66-styling-isi-tiap-kartu-article):
elemen yang secara fungsi kurang penting diberi bobot visual yang lebih
ringan, supaya perhatian pengguna terfokus ke konten utama halaman.

Lanjut ke: [Rangkuman & Latihan Lanjutan](10-rangkuman-latihan.md)
