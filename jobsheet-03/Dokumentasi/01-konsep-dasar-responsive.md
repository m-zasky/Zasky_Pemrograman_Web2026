# 1. Konsep Dasar Responsive Design

Sebelum membedah kode, kenali dulu istilah-istilah besar di balik
"tampilan responsif" yang akan terus muncul di bab-bab berikutnya.

## 1.1 Apa itu Responsive Web Design?

**Responsive Web Design (RWD)** adalah pendekatan membangun halaman web
agar **tata letaknya menyesuaikan diri secara otomatis** dengan lebar
layar perangkat yang dipakai — HP, tablet, laptop, atau monitor besar —
memakai **satu** file HTML/CSS yang sama, tanpa perlu membuat versi
terpisah untuk tiap perangkat (misalnya `m.situs.com` khusus HP yang
dulu populer sebelum era RWD).

Sebelum jobsheet ini, halaman `index.html` dkk. sebenarnya **sudah
"jalan"** di HP (browser tetap menampilkannya), tapi belum **responsif**
— karena tanpa `<meta name="viewport">` (dibahas di [§1.2](#12-meta-nameviewport--supaya-browser-hp-tidak-berbohong)),
browser HP akan menganggap halaman itu dirancang untuk layar desktop,
lalu memperkecil (zoom out) seluruh halaman supaya "muat" di layar kecil
— hasilnya teks jadi sangat kecil dan pengguna harus pinch-zoom manual.

## 1.2 `<meta name="viewport">` — Supaya Browser HP Tidak "Berbohong"

```html
<meta name="viewport" content="width=device-width, initial-scale=1">
```

Ini ditambahkan di `<head>` setiap halaman jobsheet ini (lihat detail
perubahannya di [bab 2](02-perubahan-file-html.md#21-meta-viewport)).
Tanpa baris ini, browser mobile **berpura-pura** memiliki lebar layar
sekitar 980px (disebut *default layout viewport*) lalu men-zoom-out hasil
render-nya supaya muat di layar sungguhan yang jauh lebih sempit — inilah
sebabnya banyak situs lama terlihat "mini" dan butuh di-zoom manual saat
dibuka di HP.

Atribut `content` berisi dua instruksi:

| Instruksi | Artinya |
|---|---|
| `width=device-width` | Lebar viewport (area tampilan) **disamakan** dengan lebar layar fisik perangkat, bukan lebar default 980px tadi. |
| `initial-scale=1` | Level zoom awal diatur ke **1:1** (tidak di-zoom out ataupun in) saat halaman pertama kali dimuat. |

Dengan dua instruksi ini, 1 piksel CSS (`px` yang kamu tulis di
`style.css`) kurang lebih sama dengan 1 piksel yang benar-benar terlihat
proporsional di layar HP, sehingga **media query** (dibahas selanjutnya)
bisa bekerja secara akurat berdasarkan lebar layar yang sesungguhnya.

## 1.3 Media Query: CSS yang "Bertanya" Dulu

**Media query** adalah fitur CSS yang memungkinkan sekumpulan aturan CSS
hanya berlaku **jika kondisi tertentu terpenuhi** — paling umum,
kondisinya adalah lebar layar (viewport). Sintaksnya:

```css
@media (max-width: 768px) {
    /* aturan CSS di sini HANYA berlaku
       kalau lebar layar 768px atau lebih sempit */
}
```

- `@media` — kata kunci yang memulai blok media query.
- `(max-width: 768px)` — **kondisi**: berlaku selama lebar viewport
  **kurang dari atau sama dengan** 768px.
- Semua aturan CSS di dalam kurung kurawal `{ }` hanya "aktif" ketika
  kondisi itu benar. Begitu layar diperlebar melebihi 768px (misalnya
  jendela browser di-resize), aturan di dalamnya otomatis **berhenti**
  berlaku — tidak butuh JavaScript maupun reload halaman sama sekali,
  murni kemampuan CSS.

Penjelasan detail tiap breakpoint yang dipakai jobsheet ini ada di
[bab 5](05-css-media-query-breakpoint.md).

## 1.4 Breakpoint: Titik Ambang Batas

**Breakpoint** adalah nilai lebar layar tertentu yang dipakai sebagai
"garis batas" di media query — di jobsheet ini ada 2 breakpoint:

| Breakpoint | Nilai | Kira-kira Mewakili |
|---|---|---|
| Tablet | `768px` | Tablet dan layar sempit lainnya |
| Mobile | `480px` | HP |

Angka-angka ini **bukan aturan baku universal** — banyak proyek memilih
breakpoint berbeda tergantung kebutuhan desainnya. 768px dan 480px hanya
kebiasaan umum yang mendekati lebar rata-rata perangkat tablet dan HP.

## 1.5 Pendekatan "Desktop-First" yang Dipakai di Jobsheet Ini

Ada dua strategi umum menulis CSS responsif:

| Strategi | Cara Kerja |
|---|---|
| **Desktop-first** | Tulis dulu gaya **default** untuk layar besar, lalu **timpa** sebagian gaya itu di dalam `@media (max-width: ...)` untuk layar yang lebih sempit. |
| **Mobile-first** | Kebalikannya: tulis dulu gaya default untuk layar **sempit**, lalu tambahkan lebih banyak gaya di dalam `@media (min-width: ...)` untuk layar yang lebih lebar. |

Jobsheet ini memakai pendekatan **desktop-first**: perhatikan seluruh
gaya dari [jobsheet-02](../../jobsheet-02/Dokumentasi/README.md) (grid 3
kolom, navbar horizontal, dst.) tetap menjadi **gaya default/dasar**, dan
`style.css` di jobsheet ini hanya **menambahkan** dua blok
`@media (max-width: ...)` di bagian **paling bawah** file untuk
menimpanya di layar sempit (lihat [bab 5](05-css-media-query-breakpoint.md)).

**Kenapa harus di bagian bawah file?** Karena kalau dua aturan CSS
punya spesifisitas selector yang sama (ingat konsep spesifisitas dari
[dokumentasi jobsheet-02](../../jobsheet-02/Dokumentasi/04-css-header-navbar-flexbox.md#47-kenapa-selector-header-nav-a-lebih-menang-daripada-a)),
aturan yang ditulis **belakangan** di file yang menang. Kalau blok
`@media` diletakkan **sebelum** gaya default, gaya default yang ditulis
sesudahnya justru akan menimpa balik hasil media query — sehingga efek
responsifnya "hilang" secara tidak sengaja. Ini kesalahan umum pemula
saat pertama kali menambahkan media query ke stylesheet yang sudah ada.

Dengan bekal istilah-istilah di atas, sekarang kamu siap membaca
perubahan konkretnya mulai bab 2.

Lanjut ke: [Apa yang Berubah di File HTML?](02-perubahan-file-html.md)
