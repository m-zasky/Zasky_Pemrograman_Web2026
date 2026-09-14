# 6. JS: Event Delegation pada Tombol Hapus

Perubahan kecil di `app.js` ini punya alasan besar di baliknya — dan
memperkenalkan pola penting bernama **event delegation**.

## 6.1 Kode Sebelum dan Sesudah

**Sebelumnya (jobsheet-05):**
```js
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

**Sekarang (jobsheet-06):**
```js
// Memakai event delegation di document karena baris tabel sekarang
// dirender dinamis via fetch (lihat buku.js/anggota.js) sehingga
// tombol .btn-hapus belum tentu ada saat DOMContentLoaded.
function initHapusConfirm() {
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-hapus");
        if (!btn) return;

        const row = btn.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
        if (yakin && row) {
            row.remove();
        }
    });
}
```

## 6.2 Apa Masalah yang Diperbaiki di Sini?

Ingat cara kerja `initHapusConfirm` versi jobsheet-05
([dokumentasi jobsheet-05 §5.2](../../jobsheet-05/Dokumentasi/05-js-konfirmasi-hapus.md#52-memasang-event-listener-ke-banyak-tombol-sekaligus)):
`document.querySelectorAll(".btn-hapus")` mencari **semua** tombol
Hapus yang **sudah ada di DOM saat itu juga**, lalu memasang event
listener ke masing-masing satu per satu. Kode ini dijalankan sekali
saat `DOMContentLoaded` ([dokumentasi jobsheet-05 §1.7](../../jobsheet-05/Dokumentasi/01-konsep-dasar-javascript-dom.md#17-struktur-umum-kode-di-appjs)).

Masalahnya: di jobsheet-06, tombol `.btn-hapus` **tidak lagi ada** di
HTML sejak awal — ingat dari [bab 2 §2.1](02-perubahan-file-html.md#21-tbody-yang-sekarang-kosong),
`<tbody>` sekarang **kosong**, dan baris-baris tabel (termasuk tombol
Hapus di dalamnya) baru **dibuat belakangan** oleh `buku.js`/`anggota.js`
lewat `tbody.appendChild(tr)` (ingat dari
[bab 4 §4.6](04-js-fetch-render-buku.md#46-membuat-baris-tabel-dari-data)) —
dan proses itu sendiri baru selesai **setelah** proses `fetch`
asinkron rampung (butuh waktu, apalagi dengan delay simulasi 600ms dari
[bab 4 §4.4](04-js-fetch-render-buku.md#44-simulasi-delay-jaringan)).

Kalau `initHapusConfirm` versi lama tetap dipakai: saat `DOMContentLoaded`
terpicu dan `querySelectorAll(".btn-hapus")` dijalankan, **belum ada
satu pun** tombol `.btn-hapus` di DOM (karena `buku.js` belum selesai
mengambil data) — akibatnya, **tidak ada event listener yang terpasang
sama sekali**, dan tombol Hapus yang muncul belakangan tidak akan
pernah bereaksi saat diklik.

## 6.3 Solusi: Event Delegation

**Event delegation** adalah teknik memasang **satu** event listener di
elemen **leluhur** (di sini: `document`, elemen paling atas/luar dari
semuanya) alih-alih memasang listener terpisah ke setiap elemen target.
Teknik ini memanfaatkan sifat alami event di browser yang disebut
**event bubbling** — ketika sebuah elemen diklik, "kejadian" klik itu
**menjalar ke atas** melalui seluruh elemen leluhurnya (dari tombol →
`<td>` → `<tr>` → `<tbody>` → ... → `document`), bukan cuma terjadi di
elemen yang diklik itu sendiri.

```js
document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-hapus");
    if (!btn) return;
    // ...
});
```

- Event listener dipasang **satu kali saja**, di `document` — elemen
  yang **selalu ada** sejak awal, tidak peduli baris tabel mana pun
  yang belum/sudah dibuat.
- **`e.target`** — properti pada objek event (`e`) yang merujuk ke
  elemen **paling spesifik** yang benar-benar diklik pengguna (bisa
  jadi tombolnya sendiri, atau kadang elemen lain di dalamnya).
- **`e.target.closest(".btn-hapus")`** — ingat method `.closest()` dari
  [dokumentasi jobsheet-05 §5.3](../../jobsheet-05/Dokumentasi/05-js-konfirmasi-hapus.md#53-mencari-baris-tabel-yang-jadi-induk-tombol),
  tapi kali ini dipakai untuk tujuan berbeda: mencari **ke atas** dari
  elemen yang diklik, untuk memastikan klik itu **benar-benar terjadi**
  pada (atau di dalam) sebuah tombol `.btn-hapus` — karena `document`
  menerima event klik dari **mana saja** di seluruh halaman (termasuk
  klik di tombol Edit, klik di kolom pencarian, dll).
- **`if (!btn) return;`** — kalau klik ternyata terjadi di tempat lain
  (bukan tombol Hapus), `.closest(".btn-hapus")` akan mengembalikan
  `null`, dan fungsi berhenti di sini — tidak melakukan apa-apa untuk
  klik yang tidak relevan.

Setelah `btn` ditemukan, sisa kodenya (mencari `row` lewat
`btn.closest("tr")`, menampilkan `confirm()`, memanggil `row.remove()`)
**persis sama** dengan versi jobsheet-05 — konsep-konsep itu sudah
dibahas tuntas di
[dokumentasi jobsheet-05 §5.3-5.6](../../jobsheet-05/Dokumentasi/05-js-konfirmasi-hapus.md#53-mencari-baris-tabel-yang-jadi-induk-tombol).

## 6.4 Kenapa Ini Berhasil untuk Tombol yang "Belum Ada"?

Ini bagian paling penting untuk dipahami: karena event listener
dipasang di `document` (bukan di tombolnya masing-masing), listener ini
**tidak peduli** kapan tombol `.btn-hapus` itu dibuat — entah sudah ada
sejak `DOMContentLoaded`, atau baru muncul beberapa ratus milidetik
kemudian setelah `fetch` selesai ([bab 4](04-js-fetch-render-buku.md)).
Selama tombol itu **ada di DOM saat diklik** (kapan pun itu), klik pada
tombol tersebut akan tetap "menjalar" naik sampai ke `document`, dan
listener yang sudah terpasang sejak awal akan tetap mendeteksinya lewat
`e.target.closest(".btn-hapus")`.

## 6.5 Kapan Sebaiknya Memakai Event Delegation?

| Situasi | Pendekatan yang Cocok |
|---|---|
| Elemen target **sudah ada** sejak halaman dimuat, jumlahnya tetap | Pasang listener langsung ke tiap elemen (`querySelectorAll(...).forEach(...)`, seperti [dokumentasi jobsheet-05](../../jobsheet-05/Dokumentasi/05-js-konfirmasi-hapus.md)) |
| Elemen target **dibuat/dihapus secara dinamis** setelah halaman dimuat (lewat `fetch`, atau interaksi pengguna lain) | Event delegation di elemen leluhur yang stabil (seperti di jobsheet ini) |

Aturan praktisnya: begitu kamu mulai membuat elemen secara dinamis lewat
JavaScript (seperti `buku.js`/`anggota.js` di jobsheet ini), pertanyaan
"apakah elemen ini butuh event listener, dan kapan elemen ini akan
ada?" jadi penting untuk dipikirkan — kalau jawabannya "elemen ini bisa
muncul kapan saja, bahkan setelah kode ini pertama kali berjalan", event
delegation biasanya jadi pilihan yang lebih aman.

Lanjut ke: [Menjalankan Lewat Server Lokal (CORS)](07-menjalankan-dengan-server-lokal.md)
