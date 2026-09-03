# 3. CSS: Menu Hamburger dengan Checkbox Hack

Ini bagian paling "ajaib" di jobsheet ini: menu yang bisa dibuka-tutup
dengan diklik, **tanpa satu baris JavaScript pun**. Triknya disebut
**checkbox hack**, memanfaatkan pseudo-class `:checked` dan **sibling
combinator** CSS.

## 3.1 Potongan CSS yang Terlibat

Kode ini tersebar di 2 tempat berbeda di `style.css`: gaya dasar (selalu
aktif) dan gaya di dalam media query mobile (hanya aktif di layar
sempit).

**Gaya dasar** (di luar media query):
```css
/* ===== Hamburger Menu (checkbox hack) ===== */
.nav-toggle {
    display: none;
}

.nav-toggle-label {
    display: none;
    font-size: 1.6rem;
    color: #fff;
    cursor: pointer;
}
```

**Di dalam `@media (max-width: 480px)`** (dibahas lengkap di
[bab 5](05-css-media-query-breakpoint.md)):
```css
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
```

## 3.2 Langkah 1 — Sembunyikan Checkbox Aslinya

```css
.nav-toggle {
    display: none;
}
```

Checkbox HTML aslinya (kotak kecil yang bisa dicentang) **disembunyikan
total** dengan `display: none`. Ingat dari HTML-nya
([bab 2 §2.2](02-perubahan-file-html.md#22-pasangan-checkbox--label-untuk-hamburger-menu)),
checkbox ini memang tidak dimaksudkan untuk terlihat — ia hanya dipakai
sebagai "penyimpan status" tersembunyi: **dicentang = menu terbuka,
tidak dicentang = menu tertutup**. Status ini yang nanti "dibaca" oleh
CSS lain lewat pseudo-class `:checked` di [§3.5](#35-langkah-4--sibling-combinator-menghubungkan-status-ke-nav).

## 3.3 Langkah 2 — Label Berperan sebagai Tombol Pengganti

```css
.nav-toggle-label {
    display: none;      /* disembunyikan di layar besar */
    font-size: 1.6rem;
    color: #fff;
    cursor: pointer;
}
```

Karena checkbox aslinya disembunyikan, `<label>` (berisi ikon ☰ dari
[bab 2](02-perubahan-file-html.md#22-pasangan-checkbox--label-untuk-hamburger-menu))
yang tampil menggantikannya sebagai "tombol" yang bisa diklik pengguna.
Ingat hubungan `<label for="nav-toggle">` dengan
`<input id="nav-toggle">` sudah dijelaskan konsepnya di
[dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#43-pola-setiap-isian-form-label--input):
**mengklik label = mengklik checkbox-nya**, meskipun checkbox itu
sendiri tidak terlihat sama sekali di layar. `cursor: pointer` menandakan
label ini bisa diklik (sama seperti tombol biasa, lihat
[dokumentasi jobsheet-02 §7.6](../../jobsheet-02/Dokumentasi/07-css-tabel.md#76-tombol-aksi-edit--hapus)).

Perhatikan `.nav-toggle-label` diberi `display: none` di gaya dasar —
artinya di layar **besar** (desktop/tablet), ikon hamburger ini **tidak
tampil sama sekali**, karena menu navigasi memang sudah langsung terlihat
sejajar horizontal (lihat
[dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/04-css-header-navbar-flexbox.md)).
Ikon ini baru dimunculkan (`display: block`) khusus di dalam
`@media (max-width: 480px)` — dijelaskan alurnya di [§3.6](#36-mengapa-aturan-ini-perlu-diulang-di-dalam-media-query).

## 3.4 Langkah 3 — Sembunyikan Menu di Layar Sempit (Dulu)

```css
header nav {
    display: none;
    width: 100%;
    order: 3;
    margin-top: 1rem;
}
```

Aturan ini **hanya berlaku di dalam** `@media (max-width: 480px)` — di
layar sempit, `<nav>` (menu navigasi lengkap) disembunyikan **secara
default**, supaya tidak memenuhi layar HP yang kecil. `order: 3` adalah
properti Flexbox (ingat `<header>` adalah flex container dari
[dokumentasi jobsheet-02 §4.3](../../jobsheet-02/Dokumentasi/04-css-header-navbar-flexbox.md#43-mengaktifkan-flexbox-display-flex)) —
mengatur `<nav>` supaya **selalu tampil paling akhir/bawah** di antara
flex item lain (`h1`, checkbox tersembunyi, label) ketika ia memang
ditampilkan nanti, alih-alih tersisip di tengah.

## 3.5 Langkah 4 — Sibling Combinator: Menghubungkan Status ke `nav`

```css
.nav-toggle:checked ~ nav {
    display: block;
}
```

Ini **inti** dari seluruh trik checkbox hack. Mari bedah selector ini
bagian per bagian:

| Bagian | Artinya |
|---|---|
| `.nav-toggle` | Elemen dengan class `nav-toggle` — yaitu checkbox kita. |
| `:checked` | Pseudo-class (ingat dari [dokumentasi jobsheet-02 §1.4](../../jobsheet-02/Dokumentasi/01-konsep-dasar-css.md#14-jenis-jenis-selector-yang-dipakai-di-stylecss)): berlaku **hanya saat** elemen itu dalam kondisi tercentang. |
| `~` | **General sibling combinator** — selector baru yang belum pernah dibahas di jobsheet sebelumnya. Artinya "pilih elemen `nav` yang merupakan **saudara** (sibling) dari `.nav-toggle`, dan muncul **setelahnya** di HTML." |
| `nav` | Elemen target yang gayanya diubah. |

Jadi selector lengkap `.nav-toggle:checked ~ nav` berarti: **"kalau
checkbox `.nav-toggle` sedang tercentang, ubah gaya elemen `<nav>` yang
posisinya sejajar (sibling) setelahnya."** Inilah kenapa susunan HTML di
[bab 2 §2.2](02-perubahan-file-html.md#22-pasangan-checkbox--label-untuk-hamburger-menu)
penting: `input`, `label`, dan `nav` harus sama-sama berada **langsung**
di dalam `<header>` (sibling satu sama lain), bukan `nav` di dalam
elemen lain — sibling combinator **hanya** bekerja antar elemen yang
levelnya sejajar.

**Alur lengkapnya:**
1. Pengguna klik label (ikon ☰).
2. Karena `<label for="nav-toggle">`, klik ini **mencentang** checkbox
   tersembunyi `#nav-toggle`.
3. Checkbox kini cocok dengan `:checked`.
4. Selector `.nav-toggle:checked ~ nav` menjadi aktif → `<nav>`
   (sebelumnya `display: none` dari [§3.4](#34-langkah-3--sembunyikan-menu-di-layar-sempit-dulu))
   berubah jadi `display: block` → menu **muncul**.
5. Klik label sekali lagi → checkbox tidak lagi tercentang → aturan
   `:checked ~ nav` tidak berlaku lagi → `<nav>` kembali ke `display: none`
   dari aturan dasarnya → menu **tersembunyi lagi**.

Semua perpindahan status ini murni ditangani browser lewat CSS, tanpa
event listener atau kode JavaScript apa pun — makanya disebut teknik
"checkbox hack": **meminjam** perilaku bawaan checkbox (bisa
dicentang/tidak, dan punya pseudo-class `:checked`) untuk keperluan yang
sebenarnya di luar konteks form biasa.

## 3.6 Mengapa Aturan Ini Perlu Diulang di Dalam Media Query?

```css
header {
    position: relative;
}

.nav-toggle-label {
    display: block;
}
```

Perhatikan `.nav-toggle-label` muncul **dua kali** di `style.css`:
sekali di gaya dasar (`display: none;`, [§3.3](#33-langkah-2--label-berperan-sebagai-tombol-pengganti)),
sekali lagi di dalam `@media (max-width: 480px)` (`display: block;`).
Ini **bukan** duplikasi yang salah — ini pola umum di CSS responsif
desktop-first (ingat [konsep dasar §1.5](01-konsep-dasar-responsive.md#15-pendekatan-desktop-first-yang-dipakai-di-jobsheet-ini)):
gaya dasar menyembunyikan ikon hamburger di layar besar, lalu media
query **menimpanya kembali** menjadi terlihat khusus saat layar ≤480px.
Karena aturan di dalam `@media` ditulis **setelah** gaya dasar di file
(dan spesifisitas keduanya sama, sama-sama satu class selector), aturan
di dalam media query yang menang saat kondisinya terpenuhi.

`header { position: relative; }` juga hanya diaktifkan di breakpoint
mobile ini — properti `position: relative` diperlukan supaya elemen
`<nav>` (yang nanti akan diberi `width: 100%` saat terbuka) mengukur
lebarnya relatif terhadap `<header>`, bukan elemen lain di luar yang
mungkin ukurannya berbeda.

## 3.7 Sentuhan Terakhir: Menu Vertikal saat Terbuka

```css
header nav ul {
    flex-direction: column;
    gap: 0.75rem;
}
```

Ingat dari [dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/04-css-header-navbar-flexbox.md#46-flexbox-bertingkat-navbar-di-dalam-header),
`header nav ul` sudah menjadi flex container (`display: flex`) sejak
jobsheet-02, menyusun item menu **horizontal** secara default.
Properti `flex-direction: column` di dalam media query mobile ini
mengubah arah susunan flex item jadi **vertikal** — masuk akal karena di
layar HP yang sempit, menu yang terbuka lebih nyaman ditampilkan sebagai
daftar bertumpuk ke bawah daripada dipaksa sejajar horizontal yang akan
terlalu sempit per itemnya.

Lanjut ke: [CSS: Tabel yang Bisa Di-scroll (`table-responsive`)](04-css-table-responsive.md)
