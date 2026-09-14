# Dokumentasi Jobsheet 6 — Fetch API & JSON

Dokumentasi ini melanjutkan
[dokumentasi jobsheet-05](../../jobsheet-05/Dokumentasi/README.md)
(JavaScript DOM & Event). Kalau kamu belum paham dasar JavaScript —
memilih elemen DOM, event listener, `classList`, dsb. — baca dulu
dokumentasi jobsheet-05 sebelum lanjut ke sini, karena jobsheet ini
banyak membangun di atas konsep tersebut.

## Tentang `docs/wireframe.md`

File ini **identik persis** dengan
[`docs/wireframe.md` di jobsheet-05](../../jobsheet-05/docs/wireframe.md) —
tidak ada rancangan UI/UX baru di jobsheet ini. Baca
[dokumentasi jobsheet-04](../../jobsheet-04/Dokumentasi/README.md) kalau
perlu menyegarkan ingatan soal wireframe & user flow.

## Apa yang Baru di Jobsheet 6?

Sesuai [README.md](../README.md) jobsheet ini, ini titik penting lain
dalam perjalanan SIMPUS-Mini: untuk **pertama kalinya**, data tabel
(Daftar Buku & Daftar Anggota) **tidak lagi ditulis manual** di HTML —
diambil secara dinamis dari file JSON memakai JavaScript. Empat
perubahan besarnya:

1. **Dua file JSON baru** (`data/buku.json`, `data/anggota.json`) —
   sumber data, menggantikan sementara API/server sungguhan yang belum
   ada.
2. **Rendering tabel dipindah ke JavaScript** — `<tbody>` di HTML
   sekarang **kosong**, diisi dinamis oleh `assets/js/buku.js` /
   `assets/js/anggota.js` lewat `fetch` + `async/await`.
3. **Loading indicator** — teks "Memuat data..." muncul sesaat selagi
   data sedang diambil.
4. **Penanganan error** dengan `try/catch` — kalau pengambilan data
   gagal, tabel menampilkan pesan error alih-alih halaman kosong/rusak.

Ditambah satu perubahan pendukung: `initHapusConfirm` di `app.js`
diubah ke pola **event delegation**, karena tombol Hapus sekarang berada
di baris yang baru dibuat setelah halaman selesai dimuat (dibahas di
[bab 6](06-js-event-delegation-hapus.md)).

## Daftar Isi

1. [Konsep Dasar: AJAX, JSON, Promise, async/await](01-konsep-dasar-fetch-json.md)
2. [Apa yang Berubah di File HTML?](02-perubahan-file-html.md)
3. [Data JSON: `buku.json` & `anggota.json`](03-data-json.md)
4. [JS: Mengambil & Menampilkan Daftar Buku](04-js-fetch-render-buku.md)
5. [JS: Mengambil & Menampilkan Daftar Anggota](05-js-fetch-render-anggota.md)
6. [JS: Event Delegation pada Tombol Hapus](06-js-event-delegation-hapus.md)
7. [Menjalankan Lewat Server Lokal (CORS)](07-menjalankan-dengan-server-lokal.md)
8. [Rangkuman & Latihan Lanjutan](08-rangkuman-latihan.md)

## Struktur Folder

```
jobsheet-06/
├── index.html
├── assets/
│   ├── css/style.css        # Tidak berubah dari jobsheet-05
│   └── js/
│       ├── app.js            # initHapusConfirm diubah (event delegation)
│       ├── buku.js           # BARU — fetch + render Daftar Buku
│       └── anggota.js        # BARU — fetch + render Daftar Anggota
├── data/
│   ├── buku.json              # BARU — 10 objek data buku
│   └── anggota.json           # BARU — 4 objek data anggota
├── buku/
│   ├── list.html               # <tbody> kosong + loading-indicator
│   └── tambah.html
├── anggota/
│   ├── list.html
│   └── tambah.html
├── docs/wireframe.md            # Identik dengan jobsheet-05
├── README.md
└── Dokumentasi/                 # Folder dokumentasi ini
```

**Catatan penting** sejak awal (dari [README.md](../README.md) jobsheet
ini): `data/buku.json` dan `data/anggota.json` adalah **pengganti
sementara** untuk API sungguhan. Pola `fetch` + `async/await` yang kamu
pelajari di sini akan dipakai ulang untuk memanggil endpoint PHP asli
mulai Jobsheet 9 — meskipun mulai Jobsheet 7, rendering utama justru
berpindah ke sisi server (PHP), bukan lagi sepenuhnya di browser seperti
di jobsheet ini.
