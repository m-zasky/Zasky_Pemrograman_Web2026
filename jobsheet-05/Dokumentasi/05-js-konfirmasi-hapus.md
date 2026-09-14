# 5. JS: Konfirmasi Hapus

Fungsi ini membuat tombol "Hapus" di tabel Daftar Buku/Anggota —
yang sejak jobsheet-01 hanya pajangan tanpa fungsi
([dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/03-buku-list-html.md#kolom-aksi)) —
akhirnya benar-benar melakukan sesuatu.

## 5.1 Kode Lengkap

```js
// ===== Konfirmasi hapus (front-end only, belum ke server) =====
function initHapusConfirm() {
    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const row = btn.closest("tr");
            const nama = row ? row.querySelector("td")?.textContent : "data ini";
            const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
            if (yakin && row) {
                row.remove();
            }
        });
    });
}
```

## 5.2 Memasang Event Listener ke Banyak Tombol Sekaligus

```js
document.querySelectorAll(".btn-hapus").forEach(function (btn) {
    btn.addEventListener("click", function () {
        // ...
    });
});
```

Ingat dari [bab 1 §1.5](01-konsep-dasar-javascript-dom.md#15-memilih-elemen-dari-dom),
`querySelectorAll(".btn-hapus")` mengambil **semua** tombol Hapus di
satu halaman (5 tombol di Daftar Buku, 2 tombol di Daftar Anggota —
ingat class ini baru ditambahkan di
[bab 2 §2.3](02-perubahan-file-html.md#23-class-btn-hapus-di-tombol-hapus)).
Karena hasilnya berupa **kumpulan** elemen (bukan satu elemen seperti
`getElementById`), kita perlu **`.forEach(...)`** untuk mengulang satu
per satu, dan memasang `addEventListener` **terpisah** ke tiap tombol —
setiap tombol Hapus jadi punya "pendengar klik"-nya sendiri-sendiri.

## 5.3 Mencari Baris Tabel yang Jadi Induk Tombol

```js
const row = btn.closest("tr");
```

**`.closest("tr")`** adalah method yang mencari **ke atas** dari elemen
`btn` (tombol yang diklik) menuju elemen induknya, berhenti begitu
menemukan elemen pertama yang cocok dengan selector `"tr"` — dalam kasus
ini, baris tabel (`<tr>`) yang membungkus tombol tersebut (ingat struktur
tabel dari [dokumentasi jobsheet-01 §3.2](../../jobsheet-01/Dokumentasi/03-buku-list-html.md#32-anatomi-tabel-html):
tombol Hapus berada di dalam `<td>`, yang berada di dalam `<tr>`).
`.closest()` berguna justru karena tombolnya sendiri **tidak tahu**
baris keberapa dirinya berada — ia hanya tahu "cari `<tr>` terdekat di
atasku", tidak peduli itu baris ke-1, ke-3, atau ke-5.

## 5.4 Mengambil Nama/Judul dari Baris Itu

```js
const nama = row ? row.querySelector("td")?.textContent : "data ini";
```

Baris ini terlihat rumit, mari dibedah dari luar ke dalam:

- **`kondisi ? nilaiJikaBenar : nilaiJikaSalah`** adalah **ternary
  operator** — bentuk singkat dari `if/else` yang ditulis dalam satu
  baris sebagai sebuah *nilai* (bukan sebagai blok kode terpisah).
  Baris ini setara dengan:
  ```js
  let nama;
  if (row) {
      nama = row.querySelector("td")?.textContent;
  } else {
      nama = "data ini";
  }
  ```
- **`row.querySelector("td")`** — mengambil sel `<td>` **pertama** di
  dalam baris itu (ingat urutan kolom Daftar Buku: Judul, Pengarang,
  Tahun, Stok, Aksi — jadi `<td>` pertama selalu berisi **Judul** buku,
  atau **No. Anggota** di tabel Anggota).
- **`?.`** (disebut *optional chaining*) — mirip titik (`.`) biasa untuk
  mengakses properti, tapi **aman** kalau nilai di depannya `null`/
  `undefined`. Kalau `row.querySelector("td")` ternyata tidak menemukan
  apa-apa (mengembalikan `null`), `?.textContent` tidak akan
  menyebabkan error, melainkan mengembalikan `undefined` dengan aman.
- **`.textContent`** — mengambil **teks yang tampil** di dalam elemen
  itu (misalnya `"Laskar Pelangi"`).
- Kalau `row` sendiri ternyata `null` (kasus yang seharusnya jarang
  terjadi), fallback teks `"data ini"` dipakai sebagai gantinya, supaya
  pesan konfirmasi tetap masuk akal (lihat [§5.5](#55-menampilkan-dialog-konfirmasi)).

## 5.5 Menampilkan Dialog Konfirmasi

```js
const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
```

**`confirm(pesan)`** adalah fungsi bawaan browser (bukan sesuatu yang
perlu diimpor/didefinisikan) yang menampilkan **kotak dialog bawaan
browser** berisi pesan, dengan dua tombol: **OK** dan **Cancel**. Fungsi
ini **menghentikan sementara** eksekusi kode (dan interaksi pengguna
dengan halaman) sampai pengguna memilih salah satu tombol, lalu
mengembalikan nilai `true` (kalau OK diklik) atau `false` (kalau Cancel
diklik) — nilai itulah yang disimpan ke variabel `yakin`.

Perhatikan tanda kutip dua yang di-*escape* dengan backslash (`\"`) di
dalam string yang juga diapit tanda kutip dua — ini diperlukan supaya
JavaScript tidak salah mengira tanda kutip di tengah teks sebagai akhir
dari string. Hasil akhirnya, pesan yang muncul ke pengguna misalnya:
`Yakin ingin menghapus "Laskar Pelangi"?`.

## 5.6 Menghapus Baris dari Tampilan

```js
if (yakin && row) {
    row.remove();
}
```

- `&&` berarti **dan** — kode di dalam `if` hanya dijalankan kalau
  **kedua** kondisi benar: pengguna menekan OK (`yakin` bernilai
  `true`) **dan** baris `row` memang ditemukan.
- **`row.remove()`** adalah method DOM yang menghapus elemen itu **dari
  tampilan halaman** secara langsung — baris tabel itu akan lenyap dari
  layar seketika, tanpa perlu me-reload halaman.

**Penting untuk diingat** (sudah disinggung juga di
[README.md](../README.md) jobsheet ini): `row.remove()` **hanya**
menghapus elemen dari DOM/tampilan browser saat ini. Begitu halaman
di-refresh, baris itu akan **muncul kembali** karena datanya masih
tertulis apa adanya di file HTML — belum ada mekanisme yang benar-benar
menghapus data secara permanen (misalnya ke database). Fitur hapus yang
sungguhan baru akan dibangun mulai Jobsheet 9.

Lanjut ke: [JS: Filter Tabel Real-Time](06-js-filter-tabel.md)
