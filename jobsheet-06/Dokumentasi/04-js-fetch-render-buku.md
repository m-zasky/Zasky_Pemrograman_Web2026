# 4. JS: Mengambil & Menampilkan Daftar Buku

Ini fungsi paling penting di jobsheet ini — menggabungkan **semua**
konsep dari [bab 1](01-konsep-dasar-fetch-json.md) jadi satu alur nyata.

## 4.1 Kode Lengkap

```js
// Mengambil & menampilkan Daftar Buku secara asinkron dari data/buku.json
async function muatDaftarBuku() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // simulasi delay jaringan agar loading indicator terlihat
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/buku.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftarBuku = await res.json();

        daftarBuku.forEach(function (buku) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + buku.judul + "</td>" +
                "<td>" + buku.pengarang + "</td>" +
                "<td>" + buku.tahun + "</td>" +
                "<td>" + buku.stok + "</td>" +
                "<td>" +
                "<button type=\"button\">Edit</button> " +
                "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
                "</td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"5\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarBuku);
```

## 4.2 Mengambil Elemen yang Dibutuhkan

```js
const tbody = document.querySelector(".table-responsive table tbody");
const loading = document.getElementById("loading-indicator");
if (!tbody) return;
```

- `tbody` — elemen `<tbody>` kosong yang sudah dibahas di
  [bab 2 §2.1](02-perubahan-file-html.md#21-tbody-yang-sekarang-kosong),
  tempat baris-baris hasil fetch nanti akan disisipkan.
- `loading` — elemen indikator "Memuat data..." dari
  [bab 2 §2.2](02-perubahan-file-html.md#22-elemen-baru-loading-indicator).
- Guard clause `if (!tbody) return;` — pola yang sama dari
  [dokumentasi jobsheet-05 §1.7](../../jobsheet-05/Dokumentasi/01-konsep-dasar-javascript-dom.md#17-struktur-umum-kode-di-appjs).
  Perhatikan hanya `tbody` yang diperiksa (bukan `loading` juga) — ini
  sedikit tidak konsisten dengan pola guard clause yang lebih lengkap
  di `app.js` ([dokumentasi jobsheet-05 §4.3](../../jobsheet-05/Dokumentasi/04-js-hamburger-menu.md#43-penjaga-keamanan-guard-clause)),
  tapi aman **untuk saat ini** karena `buku.js` hanya dimuat di halaman
  yang memang selalu punya kedua elemen tersebut (ingat dari
  [bab 2 §2.3](02-perubahan-file-html.md#23-urutan-tag-script-yang-baru)).

## 4.3 Menampilkan (dan Menyembunyikan) Loading Indicator

```js
loading.style.display = "block";
tbody.innerHTML = "";
```

- **`loading.style.display = "block";`** — mengubah gaya `display`
  elemen loading indicator secara langsung dari JavaScript (sama
  konsepnya dengan `row.style.display` yang sudah kamu pakai di
  [dokumentasi jobsheet-05 §6.5](../../jobsheet-05/Dokumentasi/06-js-filter-tabel.md#65-mengulang-setiap-baris-tabel)),
  menimpa `style="display:none;"` bawaan dari HTML
  ([bab 2 §2.2](02-perubahan-file-html.md#22-elemen-baru-loading-indicator)) —
  teks "Memuat data..." pun muncul.
- **`tbody.innerHTML = "";`** — mengosongkan isi `<tbody>` (berjaga-jaga
  kalau fungsi ini dipanggil lebih dari sekali, misalnya kalau nanti
  ditambah tombol "Muat Ulang").

Di akhir fungsi (baik berhasil maupun gagal), baris
`loading.style.display = "none";` di dalam blok **`finally`** ([§4.8](#48-blok-finally-selalu-menyembunyikan-loading))
akan menyembunyikannya kembali.

## 4.4 Simulasi Delay Jaringan

```js
await new Promise((resolve) => setTimeout(resolve, 600));
```

Ingat dari [dokumentasi jobsheet-06 §1.4](01-konsep-dasar-fetch-json.md#14-apa-itu-promise-kenapa-butuh-await),
`fetch()` sendiri sudah mengembalikan Promise. Baris ini **membuat
Promise baru secara manual** yang sengaja "menunda" selama 600
milidetik (`setTimeout(resolve, 600)`) sebelum melanjutkan — murni
untuk **keperluan belajar**, supaya loading indicator sempat terlihat
oleh mata (karena mengambil file JSON lokal biasanya **sangat cepat**,
kurang dari sepersekian detik, sehingga tanpa delay buatan ini, teks
"Memuat data..." mungkin tidak sempat terlihat sama sekali). Ingat
catatan dari [README.md](../README.md) jobsheet ini: delay ini memang
disimulasikan, bukan delay jaringan sungguhan.

## 4.5 Mengambil Data dan Memeriksa Keberhasilannya

```js
const res = await fetch("../data/buku.json");
if (!res.ok) {
    throw new Error("Gagal mengambil data (status " + res.status + ")");
}
const daftarBuku = await res.json();
```

- **`fetch("../data/buku.json")`** — perhatikan path relatifnya `../`
  karena `buku.js` dimuat dari halaman `buku/list.html` (di dalam folder
  `buku/`), sedangkan `data/buku.json` berada di folder `data/` yang
  sejajar (`../` naik dulu ke root, ingat aturan path relatif dari
  [dokumentasi jobsheet-01 §1.5](../../jobsheet-01/Dokumentasi/01-konsep-dasar.md#15-navigasi-antar-halaman-a-href)).
- **`res.ok`** — properti pada hasil `fetch` yang bernilai `true` kalau
  permintaan berhasil (status HTTP 200-an), `false` kalau gagal
  (misalnya file tidak ditemukan, status 404). Menariknya, `fetch()`
  **tidak otomatis** dianggap gagal (tidak masuk ke `catch`) hanya
  karena file tidak ditemukan — itulah kenapa perlu pengecekan manual
  `if (!res.ok)`.
- **`throw new Error("...")`** — membuat dan "melempar" sebuah objek
  Error secara manual. Melempar error di sini **sengaja** memindahkan
  alur eksekusi langsung ke blok `catch` di bawah ([§4.7](#47-menangkap-dan-menampilkan-error)),
  seakan-akan terjadi error sungguhan — trik umum untuk mengubah
  "kegagalan logis" (fetch "berhasil" secara teknis tapi filenya
  ternyata tidak ada) menjadi alur penanganan error yang seragam.
- **`await res.json()`** — mengubah isi respons (yang awalnya berupa
  teks JSON mentah) menjadi **array objek JavaScript** sungguhan yang
  bisa diakses lewat `.judul`, `.pengarang`, dst. (ingat pembahasan
  konsep ini di [dokumentasi jobsheet-06 §3.5](03-data-json.md#35-bagaimana-data-ini-berubah-jadi-objek-javascript)).
  Perhatikan `.json()` **juga** memakai `await` — ia sendiri adalah
  proses asinkron terpisah (membaca dan menguraikan teks butuh waktu
  juga, meski biasanya sangat singkat).

## 4.6 Membuat Baris Tabel dari Data

```js
daftarBuku.forEach(function (buku) {
    const tr = document.createElement("tr");
    tr.innerHTML =
        "<td>" + buku.judul + "</td>" +
        "<td>" + buku.pengarang + "</td>" +
        "<td>" + buku.tahun + "</td>" +
        "<td>" + buku.stok + "</td>" +
        "<td>" +
        "<button type=\"button\">Edit</button> " +
        "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
        "</td>";
    tbody.appendChild(tr);
});
```

- **`daftarBuku.forEach(...)`** — mengulang **setiap** objek buku di
  dalam array hasil `res.json()` (pola `forEach` yang sama dengan yang
  sudah kamu pakai di
  [dokumentasi jobsheet-05 §5.2](../../jobsheet-05/Dokumentasi/05-js-konfirmasi-hapus.md#52-memasang-event-listener-ke-banyak-tombol-sekaligus)
  dan [§6.5](../../jobsheet-05/Dokumentasi/06-js-filter-tabel.md#65-mengulang-setiap-baris-tabel)).
- **`document.createElement("tr")`** — membuat elemen `<tr>` baru dari
  kode (ingat method serupa, `createElement("span")`, dari
  [dokumentasi jobsheet-05 §7.3](../../jobsheet-05/Dokumentasi/07-js-validasi-form.md#73-fungsi-pembantu-tampilkanerror)).
- **`tr.innerHTML = "..."`** — mengisi elemen `<tr>` yang baru dibuat
  itu dengan potongan HTML (dalam bentuk **teks**, digabung dengan
  operator `+`) berisi 5 sel `<td>`, termasuk tombol Edit dan Hapus.
  Perhatikan **`buku.judul`**, **`buku.pengarang`**, dst. — ini cara
  mengakses **nilai** dari sebuah kunci di dalam objek JavaScript
  (`buku` di sini adalah satu objek dari array `daftarBuku`, sesuai
  struktur yang sudah dibahas di [bab 3](03-data-json.md)).
- **`tbody.appendChild(tr);`** — method DOM untuk **menambahkan**
  elemen `tr` yang baru dibuat itu sebagai anak terakhir dari `tbody`.
  Method ini dipanggil **sekali per buku**, sehingga setelah seluruh
  `forEach` selesai, `<tbody>` akan berisi 10 baris `<tr>` (jumlah objek
  di `data/buku.json`, ingat dari [bab 3 §3.1](03-data-json.md#31-databukujson--10-objek-buku)) —
  padahal di HTML aslinya `<tbody>` itu benar-benar kosong.

**Catatan tentang keamanan:** menulis `tr.innerHTML = "<td>" + buku.judul + "</td>"`
dengan cara menggabung teks langsung seperti ini berpotensi menimbulkan
celah keamanan (disebut **XSS**, *Cross-Site Scripting*) **kalau** data
`buku.judul` berasal dari input pengguna yang tidak tepercaya (misalnya
kalau ada pengguna jahat berhasil menyisipkan kode HTML/JavaScript ke
dalam judul buku). Di jobsheet ini amannya terjaga karena data
`buku.json` sepenuhnya dikontrol oleh developer sendiri (bukan input
pengguna) — tapi ini catatan penting untuk diingat ketika nanti data
benar-benar berasal dari pengguna (mulai form yang tersambung ke server
di jobsheet-jobsheet selanjutnya).

## 4.7 Menangkap dan Menampilkan Error

```js
} catch (err) {
    tbody.innerHTML =
        "<tr><td colspan=\"5\">Gagal memuat data: " + err.message + "</td></tr>";
}
```

Kalau **apa pun** di dalam blok `try` gagal — baik `fetch` itu sendiri
gagal total (misalnya nama file salah ketik), maupun `throw new Error`
di [§4.5](#45-mengambil-data-dan-memeriksa-keberhasilannya) sengaja
dipanggil — kode di blok `catch` ini yang dijalankan. `err.message`
berisi teks penjelasan error (baik pesan yang kita tulis sendiri lewat
`throw new Error("...")`, maupun pesan bawaan browser kalau error-nya
jenis lain). Perhatikan **`colspan="5"`** — atribut HTML yang belum
pernah dipakai di jobsheet-jobsheet sebelumnya: membuat satu sel `<td>`
**merentang lebar 5 kolom sekaligus** (jumlah kolom tabel Daftar Buku),
supaya pesan error tampil sebagai satu baris penuh yang rapi, bukan
menyempil hanya di kolom pertama.

## 4.8 Blok `finally`: Selalu Menyembunyikan Loading

```js
} finally {
    loading.style.display = "none";
}
```

Ingat dari [dokumentasi jobsheet-06 §1.6](01-konsep-dasar-fetch-json.md#16-menangani-kegagalan-trycatchfinally),
blok `finally` **selalu** dijalankan — entah data berhasil dimuat
([§4.6](#46-membuat-baris-tabel-dari-data)) atau gagal
([§4.7](#47-menangkap-dan-menampilkan-error)). Inilah alasan kenapa
kode menyembunyikan kembali loading indicator diletakkan di sini,
bukan di akhir blok `try` saja — kalau diletakkan di akhir `try`, baris
itu **tidak akan pernah dijalankan** kalau terjadi error (karena error
langsung melompat ke `catch`, melewati sisa kode di `try`), dan loading
indicator akan **macet** tampil selamanya meskipun proses fetch sudah
gagal dan berhenti.

## 4.9 Memanggil Fungsi Saat Halaman Siap

```js
document.addEventListener("DOMContentLoaded", muatDaftarBuku);
```

Pola yang sama dengan `app.js`
([dokumentasi jobsheet-05 §1.7](../../jobsheet-05/Dokumentasi/01-konsep-dasar-javascript-dom.md#17-struktur-umum-kode-di-appjs)):
`muatDaftarBuku` baru dipanggil **setelah** seluruh HTML selesai dimuat
menjadi DOM, memastikan elemen `<tbody>` dan `#loading-indicator` sudah
pasti ada saat fungsi ini mulai mencarinya.

Lanjut ke: [JS: Mengambil & Menampilkan Daftar Anggota](05-js-fetch-render-anggota.md)
