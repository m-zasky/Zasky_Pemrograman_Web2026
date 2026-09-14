# 1. Konsep Dasar: AJAX, JSON, Promise, async/await

Sub-CPMK jobsheet ini menyebut "komunikasi asinkron (AJAX/fetch, JSON)"
— empat istilah yang perlu dipahami dulu sebelum membaca kode
`buku.js`/`anggota.js`.

## 1.1 Apa itu AJAX?

**AJAX** (*Asynchronous JavaScript and XML* — namanya historis, sekarang
hampir selalu dipakai dengan JSON, bukan XML) adalah teknik mengambil
data dari server **tanpa perlu me-reload seluruh halaman**. Bandingkan
dengan form yang sudah kamu kenal sejak
[dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#42-elemen-form):
men-submit form biasa membuat browser memuat ulang **seluruh** halaman.
Dengan AJAX, JavaScript bisa mengambil data baru di **latar belakang**,
lalu memperbarui **sebagian** halaman saja (di jobsheet ini: mengisi
`<tbody>` tabel) — pengalaman yang jauh lebih mulus bagi pengguna.

## 1.2 Apa itu JSON?

**JSON** (*JavaScript Object Notation*) adalah format teks untuk
menyimpan data terstruktur, dirancang supaya mudah dibaca manusia
**dan** mudah diproses program. Lihat `data/buku.json`:

```json
[
    { "judul": "Laskar Pelangi", "pengarang": "Andrea Hirata", "tahun": 2005, "stok": 4 },
    { "judul": "Bumi Manusia", "pengarang": "Pramoedya Ananta Toer", "tahun": 1980, "stok": 2 }
]
```

- Kurung siku `[ ]` di luar menandakan sebuah **array** (daftar/list)
  berisi banyak item.
- Setiap item dibungkus kurung kurawal `{ }` — ini disebut **objek**,
  kumpulan pasangan **kunci** (*key*) dan **nilai** (*value*), dipisah
  titik dua. Contoh: kunci `"judul"` bernilai `"Laskar Pelangi"`.
- Bandingkan strukturnya dengan satu baris `<tr>` di tabel HTML statis
  yang sudah kamu kenal sejak
  [dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/03-buku-list-html.md#33-data-yang-ditampilkan-dummy):
  satu objek JSON `{ "judul": ..., "pengarang": ..., "tahun": ..., "stok": ... }`
  membawa informasi yang **persis sama** dengan satu baris `<tr>` yang
  berisi 4 sel `<td>` — hanya bentuk penyimpanannya berbeda. Penjelasan
  detail kedua file JSON ini ada di [bab 3](03-data-json.md).

**Penting:** JSON punya aturan penulisan yang lebih ketat daripada objek
JavaScript biasa — nama kunci **wajib** diapit tanda kutip dua (`"judul"`,
bukan `judul` tanpa kutip), dan JSON **tidak mengizinkan** komentar
sama sekali. Aturan ketat ini sengaja dibuat supaya format JSON bisa
diproses secara konsisten oleh hampir semua bahasa pemrograman, bukan
cuma JavaScript.

## 1.3 Apa itu `fetch()`?

**`fetch(url)`** adalah fungsi bawaan browser untuk **meminta** data dari
sebuah alamat (bisa file lokal seperti `data/buku.json`, atau alamat
server sungguhan). Bentuk paling sederhananya:

```js
fetch("../data/buku.json")
```

Baris ini saja **belum** memberi kita data — ia hanya **memulai**
permintaan. Untuk memahami kenapa dibutuhkan langkah tambahan, kita
perlu paham dulu konsep **Promise**.

## 1.4 Apa itu Promise? (Kenapa Butuh `await`?)

Mengambil data lewat jaringan **butuh waktu** — bisa beberapa milidetik,
bisa juga beberapa detik tergantung kecepatan koneksi. JavaScript
**tidak berhenti total** menunggu proses ini selesai (kalau berhenti
total, seluruh halaman akan "membeku" selama menunggu) — sebagai
gantinya, `fetch()` langsung mengembalikan sebuah **Promise**: sebuah
"janji" bahwa hasilnya (data sungguhan, atau error) akan tersedia
**nanti**, bukan seketika itu juga.

**`await`** adalah kata kunci yang berarti "tunggu sampai Promise ini
selesai, baru lanjutkan ke baris berikutnya" — tanpa `await`, kita hanya
akan mendapat "janji"-nya, bukan data sungguhan:

```js
const res = await fetch("../data/buku.json");
```

Baris ini berarti: "mulai ambil data dari `buku.json`, **tunggu**
sampai prosesnya selesai, baru simpan hasilnya ke `res`."

## 1.5 Apa itu `async function`?

`await` **hanya boleh dipakai** di dalam fungsi yang ditandai
**`async`** di depannya:

```js
async function muatDaftarBuku() {
    // boleh pakai "await" di sini
}
```

Kata kunci `async` memberi tahu JavaScript bahwa fungsi ini **berjalan
secara asinkron** — ia boleh "berhenti sejenak" di baris yang ada
`await`-nya (menunggu Promise selesai) tanpa memblokir seluruh halaman
untuk melakukan hal lain sementara itu. Pasangan `async`/`await` ini
adalah cara **modern** menulis kode asinkron di JavaScript — jauh lebih
mudah dibaca dibanding cara-cara lama (`.then()`/`.catch()` berantai)
yang tidak dipakai di jobsheet ini.

## 1.6 Menangani Kegagalan: `try`/`catch`/`finally`

```js
try {
    // kode yang mungkin gagal (misalnya fetch gagal karena file tidak ada)
} catch (err) {
    // dijalankan HANYA kalau ada error di blok try
} finally {
    // selalu dijalankan, entah berhasil atau gagal
}
```

- **`try { ... }`** membungkus kode yang berpotensi gagal.
- **`catch (err) { ... }`** menangkap error itu (disimpan ke variabel
  `err`) supaya program **tidak berhenti total/crash** — alih-alih,
  kita bisa menampilkan pesan yang ramah ke pengguna (lihat penerapannya
  di [bab 4](04-js-fetch-render-buku.md)).
- **`finally { ... }`** selalu dijalankan di akhir, **baik** `try`
  berhasil **maupun** `catch` menangani error — cocok untuk kode yang
  harus selalu dijalankan apa pun hasilnya, seperti menyembunyikan
  loading indicator (dijelaskan di [bab 4](04-js-fetch-render-buku.md)).

Dengan bekal 6 konsep di atas (AJAX, JSON, `fetch`, Promise/`await`,
`async function`, `try`/`catch`/`finally`), kamu siap membaca kode
`buku.js` dan `anggota.js` baris demi baris mulai bab 4.

Lanjut ke: [Apa yang Berubah di File HTML?](02-perubahan-file-html.md)
