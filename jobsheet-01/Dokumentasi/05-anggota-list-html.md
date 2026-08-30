# 5. Penjelasan `anggota/list.html` (Daftar Anggota)

File ini adalah **tugas mandiri** di jobsheet 1 — polanya sengaja dibuat
mirip dengan [`buku/list.html`](03-buku-list-html.md) supaya kamu belajar
menerapkan sendiri konsep tabel HTML pada data yang berbeda (anggota,
bukan buku).

## 5.1 Kode Lengkap

```html
<table>
    <thead>
        <tr>
            <th>No. Anggota</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>No. HP</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>A001</td>
            <td>Siti Aminah</td>
            <td>Malang</td>
            <td>0812xxxx</td>
            <td>
                <button type="button">Edit</button>
                <button type="button">Hapus</button>
            </td>
        </tr>
        <tr>
            <td>A002</td>
            <td>Budi Santoso</td>
            <td>Batu</td>
            <td>0813xxxx</td>
            <td>
                <button type="button">Edit</button>
                <button type="button">Hapus</button>
            </td>
        </tr>
    </tbody>
</table>
```

## 5.2 Apa yang Sama dengan `buku/list.html`?

Strukturnya **identik** dengan daftar buku: `<table>` → `<thead>` (baris
judul kolom) → `<tbody>` (baris-baris data) → tiap baris `<tr>` berisi
sel `<td>`, dan kolom terakhir "Aksi" berisi dua tombol `type="button"`
(Edit & Hapus) yang juga **belum berfungsi**. Kalau bagian ini belum
jelas, baca dulu penjelasan detailnya di
[dokumentasi buku/list.html §3.2](03-buku-list-html.md#32-anatomi-tabel-html).

## 5.3 Apa yang Berbeda?

Perbedaannya hanya pada **nama kolom** dan **datanya**, karena entitas
yang ditampilkan beda (anggota, bukan buku):

| Kolom Buku | Kolom Anggota |
|---|---|
| Judul | No. Anggota |
| Pengarang | Nama |
| Tahun | Alamat |
| Stok | No. HP |
| Aksi | Aksi |

Data yang ditampilkan (2 baris, lebih sedikit dari daftar buku yang 5
baris):

| No. Anggota | Nama | Alamat | No. HP |
|---|---|---|---|
| A001 | Siti Aminah | Malang | 0812xxxx |
| A002 | Budi Santoso | Batu | 0813xxxx |

Nomor No. HP sengaja ditulis `0812xxxx`/`0813xxxx` (bukan angka lengkap
asli) karena ini hanya **data contoh** untuk latihan, bukan data pribadi
sungguhan — praktik yang baik saat membuat contoh/dummy data.

## 5.4 Perhatikan: Menu Navigasi

```html
<nav>
    <ul>
        <li><a href="../index.html">Beranda</a></li>
        <li><a href="../buku/list.html">Daftar Buku</a></li>
        <li><a href="list.html">Daftar Anggota</a></li>
        <li><a href="tambah.html">Tambah Anggota</a></li>
    </ul>
</nav>
```

Perhatikan bahwa file ini memuat 4 tautan navigasi, termasuk **"Tambah
Anggota"** menuju `tambah.html` — berbeda dari menu di `index.html` dan
`buku/*.html` yang tidak menyertakan tautan tersebut. Ini bagian dari
tugas mandiri: pastikan menu di setiap halaman **konsisten** menampilkan
seluruh 5 halaman jobsheet ini (Beranda, Daftar Buku, Tambah Buku, Daftar
Anggota, Tambah Anggota) — sebagai latihan, coba periksa dan lengkapi
sendiri menu di `index.html`, `buku/list.html`, dan `buku/tambah.html`
supaya tautan "Daftar Anggota" **dan** "Tambah Anggota" sama-sama muncul
di semua halaman.

Lanjut ke: [Penjelasan `anggota/tambah.html`](06-anggota-tambah-html.md)
