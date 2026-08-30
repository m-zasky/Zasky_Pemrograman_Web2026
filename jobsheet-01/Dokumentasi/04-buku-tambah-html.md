# 4. Penjelasan `buku/tambah.html` (Form Tambah Buku)

File ini menampilkan **form** (formulir isian) untuk menambah data buku
baru. Ini adalah file pertama di jobsheet ini yang memperkenalkan elemen
`<form>` dan berbagai jenis `<input>`.

## 4.1 Kode Form Lengkap

```html
<form>
    <p>
        <label for="judul">Judul</label><br>
        <input type="text" id="judul" name="judul" required>
    </p>
    <p>
        <label for="pengarang">Pengarang</label><br>
        <input type="text" id="pengarang" name="pengarang" required>
    </p>
    <p>
        <label for="tahun">Tahun Terbit</label><br>
        <input type="number" id="tahun" name="tahun" min="1900" max="2026" required>
    </p>
    <p>
        <label for="isbn">ISBN</label><br>
        <input type="text" id="isbn" name="isbn">
    </p>
    <p>
        <label for="stok">Stok</label><br>
        <input type="number" id="stok" name="stok" min="0" required>
    </p>
    <p>
        <label for="kategori">Kategori</label><br>
        <select id="kategori" name="kategori">
            <option value="fiksi">Fiksi</option>
            <option value="non-fiksi">Non-Fiksi</option>
            <option value="referensi">Referensi</option>
        </select>
    </p>
    <p>
        <button type="submit">Simpan</button>
    </p>
</form>
```

## 4.2 Elemen `<form>`

```html
<form>
    ...
</form>
```

`<form>` membungkus semua elemen isian (input) yang **akan dikirim
bersama-sama** ketika tombol submit ditekan. Perhatikan tag `<form>` di
sini **tidak punya atribut `action` maupun `method`** — artinya jika
tombol "Simpan" ditekan sekarang, form ini **belum mengirim data ke mana
pun** (browser hanya akan reload halaman yang sama). Ini sesuai catatan
di README: form-nya "belum diproses". Menghubungkan form ke penyimpanan
data (`action="..."`, `method="post"`, lalu backend yang memprosesnya)
adalah materi jobsheet selanjutnya.

## 4.3 Pola Setiap Isian Form: `<label>` + `<input>`

Setiap isian dibungkus `<p>` (paragraf) dan berisi sepasang
`<label>`–`<input>`, misalnya:

```html
<p>
    <label for="judul">Judul</label><br>
    <input type="text" id="judul" name="judul" required>
</p>
```

- **`<label for="judul">Judul</label>`** — teks keterangan "Judul" yang
  tampil di sebelah/atas kotak isian. Atribut `for="judul"` **menghubungkan**
  label ini ke input yang `id`-nya `judul`. Manfaatnya: kalau pengguna
  klik tulisan label "Judul", browser otomatis memfokuskan kursor ke
  kotak input-nya — ini praktik penting untuk aksesibilitas dan
  kenyamanan pengguna (terutama di HP, area klik jadi lebih besar).
- **`<br>`** — line break, membuat input pindah ke baris baru di bawah
  label (bukan sejajar di kanan label).
- **`<input>`** — kotak isian itu sendiri. Atribut pentingnya:
  - `type="text"` — jenis input berupa teks bebas.
  - `id="judul"` — identitas unik elemen ini di halaman, dipakai untuk
    dihubungkan dengan `<label for="judul">` di atas.
  - `name="judul"` — nama field yang akan dikirim ke server saat form
    di-submit (contoh: `judul=Laskar+Pelangi`). **`id` dan `name` sengaja
    dibuat sama nilainya** di form ini untuk memudahkan, tapi keduanya
    punya fungsi berbeda: `id` untuk dihubungkan ke `<label>`/CSS/JS di
    **halaman ini**, sedangkan `name` untuk **data yang dikirim** ke
    server.
  - `required` — atribut validasi bawaan HTML5: browser akan menolak
    submit form (dan menampilkan pesan peringatan) kalau field ini
    dikosongkan.

## 4.4 Jenis-Jenis Input yang Dipakai

| Field | Kode | Penjelasan |
|---|---|---|
| Judul | `<input type="text" ... required>` | Teks bebas, wajib diisi. |
| Pengarang | `<input type="text" ... required>` | Teks bebas, wajib diisi. |
| Tahun Terbit | `<input type="number" min="1900" max="2026" required>` | Hanya menerima angka; `min`/`max` membatasi rentang tahun yang masuk akal (1900–2026) langsung dari browser, tanpa perlu JavaScript tambahan. |
| ISBN | `<input type="text" ... >` (tanpa `required`) | Teks bebas, **boleh dikosongkan** — tidak semua buku lama punya ISBN. |
| Stok | `<input type="number" min="0" required>` | Angka, minimal `0` (stok tidak mungkin negatif), wajib diisi. |
| Kategori | `<select>` dengan `<option>` | Lihat penjelasan di bawah. |

### `<select>` dan `<option>` — Dropdown Pilihan

```html
<select id="kategori" name="kategori">
    <option value="fiksi">Fiksi</option>
    <option value="non-fiksi">Non-Fiksi</option>
    <option value="referensi">Referensi</option>
</select>
```

- `<select>` membuat **menu dropdown** (kotak pilihan yang bisa diklik
  untuk membuka daftar opsi).
- Setiap `<option>` adalah satu pilihan di dalam dropdown itu.
  - `value="fiksi"` — nilai yang **benar-benar dikirim** ke server saat
    dipilih.
  - `Fiksi` (teks di antara tag) — yang **tampil** ke pengguna di layar.
  - Nilai `value` dan teks tampilan **tidak harus sama**; di sini
    kebetulan mirip (`non-fiksi` vs `Non-Fiksi`) supaya konsisten dan
    mudah dibaca kode maupun tampilannya.
- Berbeda dengan field lain, `<select>` di sini **tidak** dipasangi
  `required` karena selalu ada opsi terpilih secara default (opsi
  pertama, `Fiksi`), jadi field ini otomatis "terisi".

## 4.5 Tombol Submit

```html
<button type="submit">Simpan</button>
```

- `type="submit"` membuat tombol ini, saat diklik, **mengirimkan seluruh
  isi form** (sesuai aturan `action`/`method` di tag `<form>` — yang saat
  ini belum diisi). Ini beda dengan tombol `type="button"` di
  [buku/list.html](03-buku-list-html.md#kolom-aksi) yang tidak melakukan
  submit apa pun.
- Karena `<form>` belum punya `action`, saat ini menekan "Simpan" hanya
  akan me-reload halaman yang sama tanpa efek apa pun yang terlihat.

## 4.6 Ringkasan Alur Belajar

Urutan penting yang perlu diingat dari file ini:

1. `<form>` = wadah pengiriman data.
2. `<label for="...">` dipasangkan dengan `<input id="...">` yang sama.
3. `name="..."` menentukan nama data yang dikirim ke server.
4. Atribut HTML5 (`required`, `min`, `max`) memberi validasi dasar **tanpa
   JavaScript**.
5. `<select>`/`<option>` dipakai kalau pilihan pengguna terbatas pada
   beberapa opsi tetap (bukan teks bebas).

Lanjut ke: [Penjelasan `anggota/list.html`](05-anggota-list-html.md)
