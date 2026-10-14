# Jobsheet 6 — Fetch API & JSON

Sub-CPMK: Menerapkan komunikasi asinkron (AJAX/fetch, JSON).

## Perubahan dari Jobsheet 5

- Tambah `data/alat.json` (10 objek) dan `data/penyewa.json` (4 objek) sebagai pengganti sementara API sungguhan.
- `alat/list.html` & `penyewa/list.html`: `<tbody>` dikosongkan; baris dirender dinamis oleh `assets/js/alat.js` / `assets/js/penyewa.js` memakai `fetch` + `async/await`.
- Tambah `#loading-indicator` yang tampil selama fetch (jeda simulasi 600 ms di `alat.js` / `penyewa.js`).
- Tambah tombol **Muat Ulang** di halaman Data Alat.
- Error handling `try/catch/finally`: pesan gagal tampil di dalam tabel.
- `alat.js` / `penyewa.js` berstruktur sama dengan `buku.js` / `anggota.js` contoh dosen (satu fungsi `async` per halaman: fetch -> forEach -> baris tabel).
- `app.js`: `terapkanFilter()` dipanggil setelah data termuat agar pencarian dan counter bekerja pada baris hasil fetch; hapus memakai event delegation.
- `style.css`: hanya ditambah style `.loading-indicator`, `.btn:disabled`, dan perataan tombol di `.search-box`.
- Placeholder form tambah disesuaikan dengan data baru (`ALT011`, `PL005`).

## Cara menjalankan

**Penting:** `fetch()` ke file lokal diblokir browser bila dibuka lewat `file://`. Jalankan lewat server lokal, misalnya:

```bash
php -S localhost:8000
```

lalu buka `http://localhost:8000/index.html`. Bisa juga memakai ekstensi "Live Server" di VSCode.

## Catatan

- Uji error handling dengan mengganti sementara nama file di `fetch(...)` (`alat.js` / `penyewa.js`) menjadi nama yang salah.
- Pola `fetch` + `async/await` ini dipakai ulang saat memanggil endpoint PHP sungguhan di jobsheet berikutnya.
