# 7. Menjalankan Lewat Server Lokal (CORS)

Ini bagian **paling penting untuk diketahui sebelum mencoba** jobsheet
ini sendiri — beda dari semua jobsheet sebelumnya yang bisa langsung
dibuka dengan klik dua kali file HTML-nya.

## 7.1 Peringatan dari README

> **Penting:** `fetch()` ke file lokal akan diblokir kebijakan CORS
> jika dibuka langsung dengan `file://`. Jalankan lewat server lokal...

Kalau kamu membuka `buku/list.html` langsung dengan cara yang sama
seperti jobsheet-01 sampai jobsheet-05 (klik dua kali di File Explorer),
tabelnya **tidak akan pernah terisi** — akan macet menampilkan "Memuat
data..." selamanya, atau langsung menampilkan pesan error "Gagal memuat
data". Ini **bukan bug** di kodenya, melainkan pembatasan keamanan
browser yang disebut **CORS**.

## 7.2 Apa itu CORS?

**CORS** (*Cross-Origin Resource Sharing*) adalah kebijakan keamanan
browser yang membatasi permintaan `fetch()` (dan teknik AJAX serupa)
antar **origin** (asal) yang berbeda. Ketika kamu membuka file HTML
langsung dari File Explorer, alamatnya di browser akan terlihat seperti:

```
file:///D:/1.MateriKuliah/PemogramanWeb-2026/kode-praktikum/jobsheet-06/buku/list.html
```

Protokol **`file://`** ini diperlakukan browser secara **sangat
ketat** — banyak browser modern (terutama Chrome) sama sekali **tidak
mengizinkan** `fetch()` mengambil file lain lewat protokol ini, sebagai
bagian dari kebijakan keamanannya, meskipun secara teknis file yang
diminta (`data/buku.json`) berada tepat di folder yang bersebelahan di
komputer yang sama. Ini beda dengan tag `<link>` atau `<script src="...">`
yang sudah kamu pakai sejak jobsheet-02 dan jobsheet-05 — tag-tag itu
**tidak** terkena pembatasan CORS seketat `fetch()`.

## 7.3 Solusi: Jalankan Lewat Server Lokal

Solusinya adalah membuka halaman ini bukan lewat `file://`, melainkan
lewat **`http://`** — dengan menjalankan **server lokal** sederhana di
komputermu sendiri. README menyarankan 2 cara:

**Cara 1 — Lewat PHP (kalau PHP sudah terpasang di komputermu):**
```bash
php -S localhost:8000
```
Jalankan perintah ini di folder `jobsheet-06/` lewat terminal, lalu buka
`http://localhost:8000/index.html` di browser.

**Cara 2 — Ekstensi "Live Server" di VS Code:**
Kalau kamu memakai editor VS Code, pasang ekstensi bernama **Live
Server**, lalu klik kanan file `index.html` → "Open with Live Server".
Ini akan otomatis menjalankan server lokal dan membuka browser untukmu,
tanpa perlu mengetik perintah apa pun di terminal.

**Cara 3 — Laragon (Apache):** kalau kamu memakai Laragon, cukup taruh
folder proyek di dalam `C:\laragon\www\`, nyalakan Apache lewat menu
Laragon, lalu buka `http://<nama-domain>.test/.../jobsheet-06/index.html`
di browser (nama domainnya otomatis dibuat Laragon dari nama folder
proyekmu). Semua path `fetch()` di jobsheet ini memakai path relatif
biasa (`../data/buku.json`, dst.), jadi tetap benar diakses dari
kedalaman folder mana pun.

Ketiga cara ini punya tujuan yang sama: membuat halaman diakses lewat
alamat `http://...` (bukan `file://...`), sehingga `fetch()`
diizinkan mengambil file JSON di folder yang sama.

## 7.4 Kenapa Ini Baru Muncul Sekarang, Bukan di Jobsheet Sebelumnya?

Jobsheet-01 sampai jobsheet-05 semuanya bisa dibuka langsung dengan
`file://` karena **tidak ada satu pun** yang memakai `fetch()` untuk
mengambil file lain — CSS (`<link>`) dan JavaScript (`<script src>`)
tidak terkena pembatasan CORS seketat ini. Baru di jobsheet-06, dengan
diperkenalkannya `fetch()` untuk mengambil `data/buku.json` dan
`data/anggota.json`, batasan CORS ini pertama kali "terasa" — dan
memang sengaja diperkenalkan bersamaan dengan `fetch()` di jobsheet ini
karena keduanya **selalu berkaitan** dalam praktik pengembangan web
sungguhan.

## 7.5 Cara Menguji Penanganan Error

Sesuai catatan di [README.md](../README.md) jobsheet ini:

> Uji error handling dengan mengganti sementara nama file di `fetch(...)`
> menjadi nama yang salah.

Coba lakukan ini sebagai latihan: buka `assets/js/buku.js`, ubah baris
`fetch("../data/buku.json")` menjadi misalnya
`fetch("../data/bukuu.json")` (sengaja salah ketik), simpan, lalu buka
halaman `buku/list.html` lewat server lokal. Kamu akan melihat pesan
error "Gagal memuat data: Gagal mengambil data (status 404)" tampil di
dalam tabel — ini membuktikan langsung bahwa blok `try`/`catch` yang
sudah dibahas di [bab 4 §4.7](04-js-fetch-render-buku.md#47-menangkap-dan-menampilkan-error)
benar-benar bekerja, bukan cuma teori. Setelah selesai mencoba, jangan
lupa kembalikan nama filenya ke `buku.json` semula.

Lanjut ke: [Rangkuman & Latihan Lanjutan](08-rangkuman-latihan.md)
