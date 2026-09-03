# 5. CSS: Media Query & Breakpoint

Bab ini membahas dua blok `@media` di bagian **paling bawah** `style.css`
— tempat sebagian besar "keajaiban" responsif jobsheet ini benar-benar
terjadi.

## 5.1 Kode CSS Lengkap

```css
/* ===== Responsive Breakpoints ===== */

/* Tablet ke bawah */
@media (max-width: 768px) {
    main section:nth-of-type(2) {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Mobile */
@media (max-width: 480px) {
    header {
        position: relative;
    }

    .nav-toggle-label {
        display: block;
    }

    header nav {
        display: none;
        width: 100%;
        order: 3;
        margin-top: 1rem;
    }

    .nav-toggle:checked ~ nav {
        display: block;
    }

    header nav ul {
        flex-direction: column;
        gap: 0.75rem;
    }

    main section:nth-of-type(2) {
        grid-template-columns: 1fr;
    }

    form input,
    form select {
        max-width: 100%;
    }
}
```

## 5.2 Breakpoint 1: Tablet (768px ke Bawah) — Grid 3 Kolom Jadi 2 Kolom

```css
@media (max-width: 768px) {
    main section:nth-of-type(2) {
        grid-template-columns: repeat(2, 1fr);
    }
}
```

Ingat dari [dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/06-css-grid-kartu-statistik.md),
selector `main section:nth-of-type(2)` menargetkan section "Ringkasan"
(kartu statistik Total Buku/Anggota/Sedang Dipinjam) di Beranda, yang
gaya dasarnya (di luar media query) adalah `grid-template-columns:
repeat(3, 1fr)` — 3 kolom sama lebar. Di dalam breakpoint ini, nilai
tersebut **ditimpa** menjadi `repeat(2, 1fr)` — 2 kolom. Karena selector-nya
identik persis dengan gaya dasar (sama-sama `main section:nth-of-type(2)`,
spesifisitas sama), aturan di dalam `@media` yang ditulis lebih akhir
di file yang menang selama kondisi lebar layar terpenuhi (ingat urutan
penulisan penting — sudah dibahas di
[konsep dasar §1.5](01-konsep-dasar-responsive.md#15-pendekatan-desktop-first-yang-dipakai-di-jobsheet-ini)).

Hasilnya: di layar tablet (≤768px), 3 kartu statistik yang tadinya
sejajar dalam 1 baris kini tersusun 2 kolom (kartu ketiga otomatis
turun ke baris kedua) — CSS Grid menangani pengaturan baris baru ini
secara otomatis begitu jumlah kolom berkurang.

## 5.3 Breakpoint 2: Mobile (≤480px) — Perubahan Terbanyak

Blok kedua ini jauh lebih ramai karena di layar HP paling banyak
penyesuaian yang diperlukan:

| Aturan | Efek |
|---|---|
| `header { position: relative; }` | Dasar penempatan untuk `<nav>` yang terbuka — dibahas di [bab 3 §3.6](03-css-hamburger-checkbox-hack.md#36-mengapa-aturan-ini-perlu-diulang-di-dalam-media-query). |
| `.nav-toggle-label { display: block; }` | Ikon hamburger ☰ dimunculkan — dibahas di [bab 3 §3.6](03-css-hamburger-checkbox-hack.md#36-mengapa-aturan-ini-perlu-diulang-di-dalam-media-query). |
| `header nav { display: none; ... }` | Menu disembunyikan **secara default** di layar mobile — dibahas di [bab 3 §3.4](03-css-hamburger-checkbox-hack.md#34-langkah-3--sembunyikan-menu-di-layar-sempit-dulu). |
| `.nav-toggle:checked ~ nav { display: block; }` | Menu dimunculkan **saat hamburger diklik** — inti checkbox hack, dibahas di [bab 3 §3.5](03-css-hamburger-checkbox-hack.md#35-langkah-4--sibling-combinator-menghubungkan-status-ke-nav). |
| `header nav ul { flex-direction: column; ... }` | Item menu tersusun vertikal saat terbuka — dibahas di [bab 3 §3.7](03-css-hamburger-checkbox-hack.md#37-sentuhan-terakhir-menu-vertikal-saat-terbuka). |
| `main section:nth-of-type(2) { grid-template-columns: 1fr; }` | Kartu statistik jadi **1 kolom** (bertumpuk penuh vertikal) — lihat [§5.4](#54-grid-kartu-statistik-di-mobile-1-kolom). |
| `form input, form select { max-width: 100%; }` | Input form melebar penuh — lihat [§5.5](#55-input-form-melebar-penuh-di-mobile). |

Bagian menu hamburger sudah dibahas mendalam di
[bab 3](03-css-hamburger-checkbox-hack.md), jadi bab ini akan fokus ke
dua baris terakhir yang belum dibahas.

## 5.4 Grid Kartu Statistik di Mobile: 1 Kolom

```css
main section:nth-of-type(2) {
    grid-template-columns: 1fr;
}
```

Nilai `1fr` (hanya **satu** bagian pecahan) berarti grid ini sekarang
hanya punya **1 kolom** yang lebarnya memenuhi seluruh ruang tersedia —
efektif membuat ketiga kartu statistik (Total Buku, Total Anggota,
Sedang Dipinjam) tersusun **bertumpuk vertikal**, satu di bawah satu,
masing-masing selebar penuh layar. Ini progresi lengkap yang terjadi di
3 breakpoint berbeda:

| Lebar Layar | `grid-template-columns` | Susunan Kartu |
|---|---|---|
| Desktop (>768px) | `repeat(3, 1fr)` (gaya dasar, [jobsheet-02](../../jobsheet-02/Dokumentasi/06-css-grid-kartu-statistik.md)) | 3 kolom sejajar |
| Tablet (≤768px) | `repeat(2, 1fr)` ([§5.2](#52-breakpoint-1-tablet-768px-ke-bawah--grid-3-kolom-jadi-2-kolom)) | 2 kolom, kartu ke-3 turun baris |
| Mobile (≤480px) | `1fr` | 1 kolom, semua bertumpuk vertikal |

Di layar sempit seperti HP, 3 kartu berdampingan akan membuat masing-
masing kartu terlalu sempit untuk menampilkan angka besarnya dengan
nyaman (ingat ukuran font `1.8rem` pada angka statistik dari
[dokumentasi jobsheet-02 §6.6](../../jobsheet-02/Dokumentasi/06-css-grid-kartu-statistik.md#66-styling-isi-tiap-kartu-article)) —
menyusunnya vertikal memberi tiap kartu ruang penuh selebar layar.

## 5.5 Input Form Melebar Penuh di Mobile

```css
form input,
form select {
    max-width: 100%;
}
```

Ingat dari [dokumentasi jobsheet-02 §8.4](../../jobsheet-02/Dokumentasi/08-css-form.md#84-kotak-input--dropdown),
gaya dasar input/select adalah `width: 100%; max-width: 400px;` — lebar
penuh, tapi **dibatasi** maksimal 400px supaya tidak melebar berlebihan
di layar desktop yang luas. Di breakpoint mobile ini, batas `max-width`
tersebut **dilonggarkan** menjadi `100%` — di layar HP yang sudah sempit
dengan sendirinya (jarang melebihi 400px), pembatasan 400px justru tidak
diperlukan lagi dan malah bisa menyisakan ruang kosong janggal di kanan
input kalau lebar layar sedikit di atas 400px. Perhatikan properti
`width: 100%` dari gaya dasar **tidak perlu diulang** di sini — hanya
`max-width` yang perlu ditimpa, karena `width: 100%` memang sudah berlaku
sejak gaya dasar dan tidak bertentangan dengan tujuan breakpoint ini.

## 5.6 Cara Menguji Sendiri di Browser

1. Buka `index.html` (atau halaman lain) di browser.
2. Buka **DevTools** (klik kanan → *Inspect*, atau tombol `F12`).
3. Aktifkan **mode responsif/perangkat** (di Chrome: ikon HP/tablet di
   pojok kiri atas panel DevTools, atau `Ctrl+Shift+M`).
4. Ubah lebar layar secara bertahap dari lebar (>768px) ke sempit
   (<480px), amati:
   - Kartu statistik berubah dari 3 → 2 → 1 kolom tepat saat melewati
     768px dan 480px.
   - Menu navigasi (di header) berubah jadi ikon ☰ begitu lebar ≤480px.
   - Klik ikon ☰ tersebut — menu akan terbuka vertikal di bawah header
     (efek checkbox hack dari [bab 3](03-css-hamburger-checkbox-hack.md)).
   - Buka `buku/list.html`, perkecil layar sampai tabelnya lebih lebar
     dari layar — coba scroll tabel itu ke samping.

Lanjut ke: [Rangkuman & Latihan Lanjutan](06-rangkuman-latihan.md)
