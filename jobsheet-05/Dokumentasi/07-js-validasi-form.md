# 7. JS: Validasi Form

Bab paling panjang di jobsheet ini — validasi form melibatkan 3 fungsi
yang saling bekerja sama: dua fungsi pembantu (`tampilkanError`,
`hapusError`) dan satu fungsi utama (`initValidasiForm`).

## 7.1 Kode Lengkap

```js
// ===== Validasi form (client-side) =====
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        const judul = form.querySelector("[name='judul'], [name='nama']");
        if (judul && judul.value.trim() === "") {
            tampilkanError(judul, "Field ini wajib diisi.");
            valid = false;
        } else if (judul) {
            hapusError(judul);
        }

        // ...(pengecekan pengarang, tahun, stok dengan pola serupa)...

        if (!valid) {
            e.preventDefault();
        }
    });
}
```

## 7.2 Mengingat Dulu: Ingat Konsep "Belum Diproses" dari Jobsheet-01

Ingat dari [dokumentasi jobsheet-01 §4.2](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#42-elemen-form),
tag `<form>` di halaman Tambah Buku/Anggota **tidak** punya atribut
`action`/`method` — artinya menekan "Simpan" hanya me-reload halaman
tanpa mengirim data ke mana pun. Validasi di jobsheet ini **tidak
mengubah fakta itu** — form masih belum benar-benar menyimpan data ke
mana pun. Yang baru ditambahkan hanyalah **pemeriksaan** yang berjalan
tepat **sebelum** proses submit (yang sebenarnya belum melakukan apa-apa
itu) — mempersiapkan pola yang nantinya tetap berguna begitu form
sungguhan terhubung ke server.

## 7.3 Fungsi Pembantu: `tampilkanError`

```js
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}
```

Fungsi ini menerima 2 **parameter** (nilai masukan): `input` (elemen
field yang bermasalah) dan `pesan` (teks error yang ingin ditampilkan).

1. **`hapusError(input);`** — memanggil fungsi lain
   ([§7.4](#74-fungsi-pembantu-hapuserror)) untuk **membersihkan dulu**
   pesan error lama (kalau ada) sebelum menambah yang baru — mencegah
   dua pesan error menumpuk untuk field yang sama.
2. **`document.createElement("span")`** — method DOM untuk **membuat
   elemen HTML baru** dari kode JavaScript, sepenuhnya belum ada di
   HTML manapun sampai baris ini dijalankan. Ini beda dengan seluruh
   fungsi sebelumnya (`initNavToggle`, `initHapusConfirm`,
   `initTableFilter`) yang hanya **memilih** elemen yang sudah ada —
   ini pertama kalinya `app.js` benar-benar **membuat** elemen baru.
3. **`span.className = "error";`** — memberi elemen `<span>` yang baru
   dibuat itu atribut `class="error"`, menghubungkannya ke gaya CSS
   `.error` yang sudah dibahas di
   [bab 3 §3.2](03-css-pendukung-javascript.md#32-gaya-baru-pesan-error-validasi).
4. **`span.textContent = pesan;`** — mengisi teks di dalam `<span>` itu
   dengan pesan error yang diberikan (misalnya "Field ini wajib diisi.").
5. **`input.insertAdjacentElement("afterend", span);`** — method DOM
   untuk **menyisipkan** elemen baru ke posisi tertentu **relatif**
   terhadap elemen lain, tanpa perlu tahu struktur DOM di sekelilingnya
   secara detail. `"afterend"` berarti "tepat setelah elemen `input`,
   sebagai saudara sejajar (sibling), bukan di dalamnya." Hasilnya,
   `<span class="error">` akan muncul **tepat di bawah** kotak input
   yang bermasalah (ingat `.error { display: block; }` dari
   [bab 3 §3.2](03-css-pendukung-javascript.md#32-gaya-baru-pesan-error-validasi)
   membuatnya pindah ke baris baru).

## 7.4 Fungsi Pembantu: `hapusError`

```js
function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}
```

- **`input.nextElementSibling`** — properti yang mengambil elemen
  **tepat setelah** `input` di level yang sama (sibling berikutnya) —
  kebalikan logis dari `insertAdjacentElement("afterend", ...)` yang
  dipakai di [§7.3](#73-fungsi-pembantu-tampilkanerror) untuk
  menyisipkannya.
- **`next.classList.contains("error")`** — memeriksa **apakah** elemen
  sibling berikutnya itu punya class `error` (ingat `classList` dari
  [bab 4 §4.4](04-js-hamburger-menu.md#44-memasang-event-listener),
  `.contains()` di sini mengecek keberadaan satu class tertentu,
  berbeda dari `.toggle()` yang membalik status).
- Kalau memang ada **dan** class-nya `error` → berarti itu memang pesan
  error yang pernah ditambahkan `tampilkanError` sebelumnya, aman untuk
  dihapus dengan `.remove()`. Pengecekan `classList.contains("error")`
  ini penting supaya fungsi ini **tidak salah menghapus** elemen lain
  yang kebetulan menjadi sibling berikutnya (misalnya `<br>` pada field
  yang belum pernah error sama sekali).

## 7.5 Fungsi Utama: `initValidasiForm`

```js
function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;
        // ...pengecekan tiap field...
        if (!valid) {
            e.preventDefault();
        }
    });
}
```

- `form` dicari lewat `id="form-tambah"` — ingat dari
  [bab 2 §2.4](02-perubahan-file-html.md#24-idform-tambah-di-form-tambah-bukuanggota),
  `id` ini sengaja dibuat **sama** di kedua form Tambah Buku dan Tambah
  Anggota.
- `let valid = true;` — beda dengan `const` yang dipakai di fungsi lain
  ([bab 4 §4.2](04-js-hamburger-menu.md#42-mengambil-dua-elemen-yang-dibutuhkan)),
  `let` dipakai di sini karena nilai `valid` **akan diubah** menjadi
  `false` kalau ada field yang tidak valid ditemukan saat pengecekan.
- **`form.addEventListener("submit", function (e) { ... })`** — event
  `submit` (ingat dari [bab 1 §1.6](01-konsep-dasar-javascript-dom.md#16-apa-itu-event-dan-event-listener))
  terpicu tepat saat tombol `<button type="submit">` ditekan. Perhatikan
  fungsinya menerima **parameter `e`** (singkatan dari *event*) — objek
  yang berisi informasi tentang kejadian ini, dan dipakai di
  [§7.7](#77-mencegah-submit-jika-tidak-valid).

## 7.6 Pola Pengecekan per Field

```js
const judul = form.querySelector("[name='judul'], [name='nama']");
if (judul && judul.value.trim() === "") {
    tampilkanError(judul, "Field ini wajib diisi.");
    valid = false;
} else if (judul) {
    hapusError(judul);
}
```

- **`form.querySelector("[name='judul'], [name='nama']")`** — attribute
  selector (ingat konsepnya dari
  [dokumentasi jobsheet-02 §8.5](../../jobsheet-02/Dokumentasi/08-css-form.md#85-tombol-submit))
  yang dipisah koma, artinya "cari field yang `name`-nya `judul` **atau**
  `nama`." Inilah **trik utama** yang membuat satu fungsi
  `initValidasiForm` bisa menangani **dua form yang berbeda field-nya**:
  di form Tambah Buku field pertamanya bernama `judul`
  ([dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#41-kode-form-lengkap)),
  di form Tambah Anggota bernama `nama`
  ([dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/06-anggota-tambah-html.md#61-kode-lengkap)) —
  selector ini akan menemukan **salah satu yang benar-benar ada** di
  form tempat kode ini berjalan, karena hanya satu dari keduanya yang
  akan cocok tergantung halaman mana yang sedang dibuka.
- **`judul.value.trim() === ""`** — `.trim()` menghapus spasi kosong di
  awal/akhir teks (supaya mengetik "   " -- hanya spasi -- tetap
  dianggap kosong, bukan dianggap valid). `=== ""` memeriksa apakah
  hasilnya benar-benar string kosong.
- Kalau kosong → panggil `tampilkanError` ([§7.3](#73-fungsi-pembantu-tampilkanerror))
  dengan pesannya, lalu set `valid = false` — menandai bahwa form ini
  **tidak boleh** diproses lebih lanjut.
- Kalau **tidak** kosong (`else if (judul)`) → panggil `hapusError`
  ([§7.4](#74-fungsi-pembantu-hapuserror)) — membersihkan pesan error
  lama kalau field ini **sebelumnya** pernah error tapi sekarang sudah
  diperbaiki pengguna.

Pola yang sama persis diulang untuk field `pengarang`, dengan
penyesuaian untuk `tahun` dan `stok`:

```js
const tahun = form.querySelector("[name='tahun']");
if (tahun) {
    const nilai = parseInt(tahun.value, 10);
    if (isNaN(nilai) || nilai < 1900 || nilai > 2026) {
        tampilkanError(tahun, "Tahun harus di antara 1900-2026.");
        valid = false;
    } else {
        hapusError(tahun);
    }
}
```

- **`parseInt(tahun.value, 10)`** — mengubah teks (misalnya `"2005"`)
  menjadi **angka** sungguhan (`2005`), dengan `10` menandakan basis
  bilangan desimal (basis 10 — praktik yang baik untuk selalu
  disertakan eksplisit, meski untuk kasus umum sering diabaikan).
- **`isNaN(nilai)`** — `NaN` adalah singkatan dari *Not a Number*,
  nilai yang muncul kalau `parseInt` gagal mengubah teks jadi angka
  (misalnya kalau field dikosongkan). `isNaN()` memeriksa apakah nilai
  itu memang bukan angka yang valid.
- **`nilai < 1900 || nilai > 2026`** — mengecek rentang tahun yang
  masuk akal, **menduplikasi** aturan yang sebenarnya sudah ada di HTML
  lewat `min="1900" max="2026"` (ingat dari
  [dokumentasi jobsheet-01 §4.4](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md#44-jenis-jenis-input-yang-dipakai)).
  Ini **bukan** duplikasi yang sia-sia — dibahas alasannya di
  [§7.8](#78-kenapa-validasi-html-required-min-max-masih-perlu-diduplikasi-di-js).

Field `stok` memakai pola serupa, hanya memeriksa `nilai < 0` (stok
tidak boleh negatif, tanpa batas atas).

## 7.7 Mencegah Submit Jika Tidak Valid

```js
if (!valid) {
    e.preventDefault();
}
```

Setelah **semua** field diperiksa, kalau `valid` masih bernilai `false`
(artinya minimal satu field bermasalah), baris **`e.preventDefault();`**
dipanggil — method ini **membatalkan** perilaku bawaan event yang
sedang terjadi. Untuk event `submit`, perilaku bawaannya adalah "kirim
form" (yang di jobsheet ini sebenarnya cuma me-reload halaman, ingat
[§7.2](#72-mengingat-dulu-ingat-konsep-belum-diproses-dari-jobsheet-01)).
Dengan `preventDefault()` dipanggil, halaman **tidak** ikut ter-reload —
pengguna tetap berada di form yang sama, dengan pesan-pesan error yang
baru saja dimunculkan tetap terlihat, siap untuk diperbaiki.

Kalau `valid` tetap `true` (semua field lolos pengecekan),
`e.preventDefault()` **tidak** dipanggil, sehingga form melanjutkan
perilaku bawaannya seperti biasa (reload halaman, sesuai kondisi form
yang memang belum terhubung ke server sungguhan).

## 7.8 Kenapa Validasi HTML (`required`, `min`, `max`) Masih Perlu Diduplikasi di JS?

Pertanyaan wajar: kalau HTML sudah punya `required` dan `min`/`max`
sejak jobsheet-01, kenapa perlu ditulis ulang logikanya di JavaScript?
Jawabannya sudah disinggung sebagai catatan penting di
[README.md](../README.md) jobsheet ini:

> Validasi di sini murni client-side dan bisa dilewati (nonaktifkan JS).

Sebenarnya justru **sebaliknya** yang perlu digarisbawahi di sini:
validasi bawaan HTML (`required`, `min`, `max`) **maupun** validasi
JavaScript **sama-sama** berjalan di **sisi klien** (browser pengguna)
— keduanya bisa dilewati oleh pengguna yang cukup paham (misalnya lewat
DevTools, atau mengirim request langsung tanpa lewat form). Menduplikasi
aturan di JavaScript di jobsheet ini bertujuan untuk **latihan** memakai
`insertAdjacentElement`, `classList`, dan manipulasi DOM lain sesuai
Sub-CPMK jobsheet ini — **bukan** untuk menambah keamanan sungguhan.
Lapisan validasi yang **benar-benar tidak bisa dilewati** adalah
validasi **sisi server** (server-side), yang baru akan ditambahkan di
Jobsheet 7 — sesuai catatan resmi di [README.md](../README.md) jobsheet
ini. Aturan pentingnya: **jangan pernah mengandalkan validasi client-side
saja** untuk data yang benar-benar sensitif/penting.

Lanjut ke: [Rangkuman & Latihan Lanjutan](08-rangkuman-latihan.md)
