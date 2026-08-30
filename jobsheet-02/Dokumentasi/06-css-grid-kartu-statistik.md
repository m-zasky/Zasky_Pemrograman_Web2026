# 6. CSS: Kartu Statistik dengan CSS Grid

Bagian ini memperkenalkan **CSS Grid**, sistem layout lain (selain
Flexbox) yang dipakai khusus untuk menyusun 3 kartu statistik di
Beranda (Total Buku, Total Anggota, Sedang Dipinjam) menjadi 3 kolom
sejajar.

## 6.1 Mengingat Kembali HTML-nya

Dari [dokumentasi HTML jobsheet-01](../../jobsheet-01/dokumentasi/02-index-html.md#22-penjelasan-bagian-per-bagian),
`index.html` punya struktur `<main>` berisi **2 buah `<section>`**:

```html
<main>
    <section>                          <!-- section ke-1: sambutan -->
        <h2>Selamat Datang...</h2>
        <p>...</p>
    </section>

    <section>                          <!-- section ke-2: ringkasan statistik -->
        <h2>Ringkasan</h2>
        <article>...Total Buku...</article>
        <article>...Total Anggota...</article>
        <article>...Sedang Dipinjam...</article>
    </section>
</main>
```

Section **kedua** inilah yang berisi 3 `<article>` kartu statistik, dan
inilah yang jadi target CSS Grid.

## 6.2 Kode CSS

```css
/* ===== Kartu Statistik (CSS Grid) ===== */
main section:nth-of-type(2) {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

main section:nth-of-type(2) article {
    background-color: #eef4fa;
    border-radius: 8px;
    padding: 1.25rem;
    text-align: center;
}

main section:nth-of-type(2) article h3 {
    font-size: 0.95rem;
    color: #55677a;
    margin-bottom: 0.5rem;
}

main section:nth-of-type(2) article p {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1d5b8a;
}
```

## 6.3 Selector `:nth-of-type(2)` — Memilih "Section Kedua Saja"

```css
main section:nth-of-type(2) { ... }
```

- Perhatikan HTML `index.html` punya **2 elemen `<section>`** yang sama
  jenis tag-nya, tanpa `class` atau `id` pembeda apa pun di antara
  keduanya.
- `:nth-of-type(2)` adalah pseudo-class yang memilih elemen berdasarkan
  **urutan kemunculannya** di antara saudara-saudara dengan **tag yang
  sama**. Jadi `section:nth-of-type(2)` artinya "section yang urutannya
  ke-**2** di antara semua elemen `<section>` yang sejenis".
- Digabung dengan `main` di depannya (descendant selector), maka
  `main section:nth-of-type(2)` berarti "section kedua yang berada di
  dalam `<main>`" — yaitu section "Ringkasan" (bukan section "Selamat
  Datang" yang urutannya pertama).

Inilah yang dimaksud catatan di [README.md](../README.md) jobsheet ini:
*"Kartu statistik di Beranda memakai `main section:nth-of-type(2)`
sebagai grid 3 kolom"* — dan alasan kenapa pendekatan ini dipilih
(ketimbang menambahkan `class` khusus di HTML) dijelaskan di
[§6.7](#67-kenapa-tidak-pakai-class-saja).

## 6.4 Mengaktifkan Grid: `display: grid`

```css
display: grid;
grid-template-columns: repeat(3, 1fr);
gap: 1rem;
```

- `display: grid;` — mengubah section ini menjadi **grid container**.
  Semua anak langsungnya (di sini: 3 elemen `<article>`) otomatis menjadi
  **grid item** yang disusun mengikuti kolom/baris yang didefinisikan.
- `grid-template-columns: repeat(3, 1fr);` — mendefinisikan **3 kolom**,
  masing-masing lebar `1fr`. `repeat(3, 1fr)` adalah singkatan dari
  menulis `1fr 1fr 1fr` tiga kali. Ingat satuan `fr` dari
  [konsep dasar §1.6](01-konsep-dasar-css.md#16-satuan-ukuran-yang-dipakai):
  karena ketiga kolom sama-sama `1fr`, ruang yang tersedia dibagi **rata
  sama besar** ke 3 kolom itu.
- `gap: 1rem;` — jarak seragam antar kolom (dan antar baris jika ada
  lebih dari satu baris), sama seperti fungsi `gap` di Flexbox navbar
  ([bab 4](04-css-header-navbar-flexbox.md#46-flexbox-bertingkat-navbar-di-dalam-header)).

## 6.5 Flexbox vs Grid — Bedanya Apa?

Pertanyaan wajar dari pemula: kenapa navbar pakai Flexbox tapi kartu
statistik pakai Grid, padahal sama-sama "menyusun elemen sejajar"?

| | Flexbox | CSS Grid |
|---|---|---|
| Dimensi | 1 dimensi (baris **atau** kolom) | 2 dimensi (baris **dan** kolom sekaligus) |
| Cocok untuk | Menyusun jumlah item yang **tidak tetap/fleksibel** dalam satu baris/kolom (seperti menu navbar yang jumlah itemnya bisa berubah) | Menyusun **tata letak kisi/kotak-kotak** dengan ukuran kolom yang presisi ditentukan sejak awal (seperti kartu statistik yang selalu 3 kolom sejajar) |

Di jobsheet ini, navbar dipilih Flexbox karena hanya perlu menyusun
item menu sejajar horizontal (1 arah), sedangkan kartu statistik dipilih
Grid karena butuh kontrol eksplisit "3 kolom sama lebar" — kasus paling
umum di mana Grid lebih ringkas dipakai dibanding Flexbox.

## 6.6 Styling Isi Tiap Kartu (`<article>`)

```css
main section:nth-of-type(2) article {
    background-color: #eef4fa;
    border-radius: 8px;
    padding: 1.25rem;
    text-align: center;
}
```

Setiap `<article>` (kartu individual) diberi latar biru sangat muda
(`#eef4fa`, beda dari latar putih section itu sendiri — lihat
[bab 5](05-css-main-dan-section.md#53-kartu-putih-untuk-setiap-section)
— supaya kartu terlihat sebagai "kotak di dalam kotak"), sudut membulat,
padding, dan teks rata tengah (`text-align: center`).

```css
main section:nth-of-type(2) article h3 {
    font-size: 0.95rem;
    color: #55677a;
    margin-bottom: 0.5rem;
}

main section:nth-of-type(2) article p {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1d5b8a;
}
```

- `<h3>` (judul kecil, misal "Total Buku") dibuat **lebih kecil**
  (`0.95rem`, lebih kecil dari ukuran teks normal `1rem`) dan berwarna
  abu-kebiruan (`#55677a`) — karena ini hanya label, bukan fokus utama.
- `<p>` (angkanya, misal "12") dibuat jauh **lebih besar**
  (`1.8rem`), tebal (`font-weight: 700` = bold), dan berwarna biru tema
  (`#1d5b8a`) — karena inilah informasi utama yang ingin ditonjolkan ke
  pengguna. Perbedaan ukuran dan bobot font antara label kecil dan angka
  besar ini adalah teknik umum dalam desain UI yang disebut **hierarki
  visual** (*visual hierarchy*) — mengarahkan mata pengguna ke informasi
  terpenting lebih dulu.

## 6.7 Kenapa Tidak Pakai `class` Saja?

Sesuai catatan di [README.md](../README.md) jobsheet ini: *"Class CSS
bersifat generik (berbasis tag semantic + `nth-child`) agar bisa dipakai
ulang di halaman Anggota tanpa duplikasi class."* Artinya, alih-alih
menambahkan `class="stat-grid"` secara manual di HTML lalu menulis
`.stat-grid { display: grid; ... }` di CSS, jobsheet ini sengaja memilih
pendekatan selector berbasis **struktur & posisi** (`main
section:nth-of-type(2)`). Keuntungannya: HTML tetap bersih tanpa
tambahan atribut `class` apa pun, dan gaya yang sama otomatis berlaku di
halaman lain asalkan strukturnya serupa. Kekurangannya (yang perlu kamu
sadari sebagai pembelajar): kalau urutan `<section>` di HTML berubah
(misalnya section "Ringkasan" dipindah jadi section pertama), gaya
Grid ini **ikut salah sasaran** karena `:nth-of-type(2)` menempel pada
posisi, bukan makna. Ini adalah trade-off (kompromi) yang wajar dipahami
saat kamu mulai membuat keputusan desain CSS sendiri di kemudian hari.

Lanjut ke: [CSS: Styling Tabel](07-css-tabel.md)
