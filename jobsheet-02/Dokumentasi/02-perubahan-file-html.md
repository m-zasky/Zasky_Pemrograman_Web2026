# 2. Apa yang Berubah di File HTML?

Kabar baik: kalau kamu sudah paham
[dokumentasi HTML jobsheet-01](../../jobsheet-01/dokumentasi/README.md),
kamu **tidak perlu belajar ulang** struktur HTML-nya di jobsheet ini.
Semua `header`, `nav`, `main`, `section`, `article`, `table`, `form`,
`footer` di 5 file HTML **persis sama** dengan jobsheet-01.

Satu-satunya perubahan di setiap file HTML adalah **satu baris baru** di
dalam `<head>`:

```html
<link rel="stylesheet" href="assets/css/style.css">
```

(penjelasan tag `<link>` ada di
[konsep dasar CSS §1.3](01-konsep-dasar-css.md#13-menghubungkan-css-ke-html))

## 2.1 Path CSS Berbeda-beda per File

Karena file `style.css` disimpan di satu lokasi (`jobsheet-02/assets/css/style.css`),
sedangkan file-file HTML tersebar di beberapa folder dengan kedalaman
berbeda, nilai `href` pada tag `<link>` harus disesuaikan:

| File HTML | Lokasi File | `href` yang Dipakai |
|---|---|---|
| `index.html` | folder root (`jobsheet-02/`) | `assets/css/style.css` |
| `buku/list.html` | dalam folder `buku/` | `../assets/css/style.css` |
| `buku/tambah.html` | dalam folder `buku/` | `../assets/css/style.css` |
| `anggota/list.html` | dalam folder `anggota/` | `../assets/css/style.css` |
| `anggota/tambah.html` | dalam folder `anggota/` | `../assets/css/style.css` |

Polanya sama seperti path pada `<a href="...">` di menu navigasi
([lihat penjelasan jobsheet-01 §1.5](../../jobsheet-01/dokumentasi/01-konsep-dasar.md#15-navigasi-antar-halaman-a-href)):
`../` berarti "naik satu folder ke atas" sebelum masuk ke `assets/css/style.css`.

**Kesalahan paling umum** pemula saat menambahkan CSS ke banyak halaman
di folder berbeda adalah **lupa menyesuaikan jumlah `../`** — akibatnya
file CSS "tidak ke-load" dan halaman tetap tampil polos tanpa ada pesan
error yang jelas di layar (biasanya baru terlihat errornya di tab
*Console*/*Network* pada DevTools browser).

## 2.2 Kenapa Struktur HTML Sengaja Tidak Diubah?

Ini keputusan desain yang penting dipahami: CSS **seharusnya** bisa
mengubah total tampilan sebuah halaman **tanpa** perlu mengubah struktur
HTML-nya. Prinsip ini disebut **separation of concerns** (pemisahan
tanggung jawab) — HTML mengurus struktur/makna konten, CSS mengurus
tampilan. Jobsheet ini sengaja dirancang begitu supaya kamu bisa
membandingkan langsung: font "Segoe UI", warna biru pada header,
navbar sejajar horizontal, kartu statistik yang tersusun rapi 3 kolom —
semua itu **murni hasil CSS**, bukan HTML baru.

Coba bandingkan tangkapan layar `index.html` jobsheet-01 (tanpa CSS,
tampilan default browser, semua elemen bertumpuk vertikal polos) dengan
`index.html` jobsheet-02 (dengan CSS) untuk melihat sendiri betapa
besarnya efek CSS terhadap tampilan, padahal HTML-nya identik.

Lanjut ke: [CSS: Reset & Gaya Dasar Body](03-css-reset-dan-body.md)
