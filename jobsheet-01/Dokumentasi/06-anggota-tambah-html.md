# 6. Penjelasan `anggota/tambah.html` (Form Tambah Anggota)

Sama seperti `anggota/list.html`, file ini juga bagian **tugas mandiri**:
polanya dibuat mirip [`buku/tambah.html`](04-buku-tambah-html.md), tapi
untuk data anggota.

## 6.1 Kode Lengkap

```html
<form>
    <p>
        <label for="nama">Nama</label><br>
        <input type="text" id="nama" name="nama" required>
    </p>
    <p>
        <label for="no_anggota">No. Anggota</label><br>
        <input type="text" id="no_anggota" name="no_anggota" required>
    </p>
    <p>
        <label for="alamat">Alamat</label><br>
        <input type="text" id="alamat" name="alamat">
    </p>
    <p>
        <label for="no_hp">No. HP</label><br>
        <input type="text" id="no_hp" name="no_hp">
    </p>
    <p>
        <button type="submit">Simpan</button>
    </p>
</form>
```

## 6.2 Apa yang Sama dengan `buku/tambah.html`?

Pola dasarnya identik dengan form tambah buku: setiap field dibungkus
`<p>`, berisi pasangan `<label for="...">` + `<input id="..." name="...">`,
dan diakhiri tombol `<button type="submit">Simpan</button>`. Jika belum
paham cara kerja pasangan label-input atau kenapa tombolnya `type="submit"`,
baca dulu [dokumentasi buku/tambah.html §4.3–4.5](04-buku-tambah-html.md#43-pola-setiap-isian-form-label--input).

## 6.3 Apa yang Berbeda?

Field yang diminta lebih sedikit dan lebih sederhana dibanding form buku
— **semua** field di sini bertipe `type="text"` (tidak ada `type="number"`
atau `<select>`, karena data anggota di jobsheet ini tidak butuh angka
atau pilihan kategori):

| Field | Kode Input | Wajib Diisi? |
|---|---|---|
| Nama | `<input type="text" id="nama" name="nama" required>` | Ya (`required`) |
| No. Anggota | `<input type="text" id="no_anggota" name="no_anggota" required>` | Ya (`required`) |
| Alamat | `<input type="text" id="alamat" name="alamat">` | Tidak |
| No. HP | `<input type="text" id="no_hp" name="no_hp">` | Tidak |

Perhatikan penamaan atribut `id`/`name` yang memakai **underscore**
(`no_anggota`, `no_hp`) karena nama field terdiri dari beberapa kata.
Ini konvensi penamaan yang umum di HTML/pemrograman supaya nama variabel
tidak mengandung spasi (spasi pada `name` bisa menimbulkan masalah saat
data dikirim/diproses).

## 6.4 Kenapa "No. Anggota" Berupa Teks, Bukan Angka?

Menarik untuk diperhatikan: field **"No. Anggota"** memakai
`type="text"`, bukan `type="number"`, meskipun namanya mengandung kata
"nomor". Ini karena format nomor anggota di aplikasi ini adalah kombinasi
huruf + angka, contohnya `A001`, `A002` (lihat data di
[anggota/list.html](05-anggota-list-html.md#53-apa-yang-berbeda)) — dan
`type="number"` hanya menerima digit murni, tidak bisa memuat huruf `A`.
Ini contoh nyata pentingnya memilih `type` input sesuai **bentuk data
sesungguhnya**, bukan sekadar namanya.

## 6.5 Latihan Reflektif

Sebagai latihan mandiri, coba bandingkan sendiri form ini dengan form
buku dan jawab pertanyaan berikut untuk menguji pemahaman:

1. Kenapa field "Alamat" dan "No. HP" tidak diberi `required`, sedangkan
   "Nama" dan "No. Anggota" diberi?
2. Apa yang akan terjadi (di browser) kalau kamu klik tombol "Simpan"
   tanpa mengisi field "Nama"? Coba buka filenya di browser dan praktikkan.
3. Form ini juga **belum punya `action`** pada tag `<form>`-nya — apa
   dampaknya saat tombol "Simpan" ditekan?

Lanjut ke: [Rangkuman & Latihan Lanjutan](07-rangkuman-latihan.md)
