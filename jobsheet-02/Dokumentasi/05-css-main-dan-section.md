# 5. CSS: Layout `main` & `section`

Bagian ini mengatur lebar konten utama halaman dan tampilan setiap
`<section>` menjadi "kartu" (card) putih yang terangkat dari latar
belakang abu-abu.

## 5.1 Kode CSS

```css
/* ===== Main Layout ===== */
main {
    max-width: 1000px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

section {
    background-color: #fff;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

section h2 {
    margin-bottom: 1rem;
    color: #1d5b8a;
}
```

## 5.2 Membatasi Lebar & Menengahkan Konten (`main`)

```css
main {
    max-width: 1000px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}
```

- `max-width: 1000px;` — lebar `<main>` **tidak akan pernah melebihi**
  1000px, meskipun layar monitor jauh lebih lebar. Ini praktik umum
  supaya teks/konten tidak melebar tak wajar dan sulit dibaca di layar
  besar (bayangkan membaca paragraf yang lebarnya sama dengan layar
  monitor 27 inci — matanya cepat lelah).
- `margin: 2rem auto;` — ingat dari [bab 4](04-css-header-navbar-flexbox.md#45-padding-pada-header),
  2 nilai berarti atas-bawah lalu kiri-kanan. Di sini: margin atas-bawah
  `2rem`, dan margin kiri-kanan `auto`. Nilai `auto` pada margin kiri-kanan
  adalah **trik klasik CSS** untuk **menengahkan elemen secara horizontal**
  — browser otomatis membagi rata sisa ruang kosong di kiri dan kanan
  `<main>` (yang lebarnya dibatasi `max-width: 1000px` tadi), sehingga
  kontennya selalu berada di tengah layar.
- `padding: 0 1.5rem;` — padding atas-bawah `0`, padding kiri-kanan
  `1.5rem`. Ini memberi sedikit jarak dari tepi layar supaya konten tidak
  terlalu mepet ke pinggir, terutama di layar sempit (HP/tablet) di mana
  `max-width: 1000px` belum berlaku (layarnya memang lebih sempit dari itu).

## 5.3 Kartu Putih untuk Setiap `<section>`

```css
section {
    background-color: #fff;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}
```

| Properti | Efek |
|---|---|
| `background-color: #fff;` | Latar putih, kontras dengan latar halaman abu-abu (`#f5f6f8` dari `body`, [bab 3](03-css-reset-dan-body.md#32-gaya-dasar-body)) — inilah yang membuat tiap `<section>` terlihat sebagai "kartu" terpisah. |
| `border-radius: 8px;` | Membuat sudut kotak **melengkung/membulat** sebesar 8px, bukan siku tajam. Efek visual yang umum dipakai untuk kesan modern dan lembut. |
| `padding: 1.5rem;` | Satu nilai saja berarti jarak yang **sama di keempat sisi** (atas, bawah, kiri, kanan) — memberi ruang napas antara tepi kartu dan isinya. |
| `margin-bottom: 1.5rem;` | Jarak di **bawah** tiap kartu, memisahkannya dari kartu/elemen berikutnya di bawahnya. |
| `box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);` | Memberi **bayangan halus** di sekeliling kartu, memberi kesan kartu "terangkat" sedikit dari latar belakang. Nilainya: `0` (bayangan tidak bergeser ke kanan/kiri), `1px` (bergeser 1px ke bawah), `3px` (blur/kabur sejauh 3px), dan `rgba(0, 0, 0, 0.08)` (warna hitam dengan opacity/transparansi hanya 8% — bayangan sangat samar/halus, tidak mencolok). |

**Catatan tentang `rgba()`:** ini format warna alternatif dari hex
(`#1d5b8a`) yang dijelaskan di [konsep dasar §1.7](01-konsep-dasar-css.md#17-warna-dalam-format-hex).
`rgba(R, G, B, A)` menulis warna dalam angka Merah-Hijau-Biru (0–255)
ditambah **Alpha** (tingkat transparansi, dari `0` = tembus pandang total
sampai `1` = pekat penuh). Format ini dipilih di sini **karena butuh
transparansi** untuk bayangan, sesuatu yang tidak bisa dilakukan format
hex biasa.

## 5.4 Judul di Dalam Section

```css
section h2 {
    margin-bottom: 1rem;
    color: #1d5b8a;
}
```

Setiap `<h2>` yang berada di dalam `<section>` (semua judul section di
seluruh halaman, seperti "Ringkasan", "Daftar Buku", "Tambah Anggota")
diberi jarak `1rem` di bawahnya (memisahkan judul dari konten di
bawahnya) dan warna biru senada dengan header (`#1d5b8a`) — memberi kesan
"warna tema" yang konsisten di seluruh aplikasi.

Lanjut ke: [CSS: Kartu Statistik dengan CSS Grid](06-css-grid-kartu-statistik.md)
