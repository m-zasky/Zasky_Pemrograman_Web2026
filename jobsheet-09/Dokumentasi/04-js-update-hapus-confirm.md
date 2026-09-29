# 4. JS: Konfirmasi Hapus via Event `submit`

Karena tombol Hapus sekarang berupa `<form>` sungguhan (ingat dari
[bab 3 §3.5](03-hapus-delete-data.md#35-bagaimana-form-html-memicu-ini-pratinjau-singkat)),
`initHapusConfirm` di `app.js` perlu diubah cara kerjanya secara
mendasar.

## 4.1 Kode Sebelum dan Sesudah

**Sebelumnya (jobsheet-06, event delegation pada `click`):**
```js
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

**Sekarang (jobsheet-09, event delegation pada `submit`):**
```js
// Tombol Hapus kini berada di dalam <form class="form-hapus" method="post">
// yang benar-benar mengirim request DELETE ke server (buku/hapus.php,
// anggota/hapus.php). Konfirmasi dilakukan pada event "submit" agar bisa
// dibatalkan (preventDefault) sebelum request terkirim.
function initHapusConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target;
        if (!form.classList.contains("form-hapus")) return;

        const row = form.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
        if (!yakin) {
            e.preventDefault();
        }
    });
}
```

## 4.2 Kenapa Tidak Bisa Memakai Pola `click` Lagi?

Ingat dari [dokumentasi jobsheet-05](../../jobsheet-05/Dokumentasi/05-js-konfirmasi-hapus.md)
dan [dokumentasi jobsheet-06 §6](../../jobsheet-06/Dokumentasi/06-js-event-delegation-hapus.md),
versi lama bekerja dengan cara: tunggu klik pada tombol, tampilkan
`confirm()`, **kalau OK** baru hapus barisnya dari tampilan lewat
`row.remove()`. Pola ini masuk akal ketika tombol Hapus **tidak
benar-benar mengirim apa pun ke server** — menghapus baris dari DOM
sudah cukup (ingat catatan "front-end only, belum ke server" dari
[dokumentasi jobsheet-05 §5.6](../../jobsheet-05/Dokumentasi/05-js-konfirmasi-hapus.md#56-menghapus-baris-dari-tampilan)).

Sekarang tombol Hapus berada di dalam `<form method="post" action="hapus.php">`
yang **sungguhan** mengirim data ke server ([bab 3](03-hapus-delete-data.md)).
Kalau kode JS tetap menunggu event `click` pada tombol lalu baru
menampilkan `confirm()`, **form akan tetap ter-submit ke server lebih
dulu** (klik tombol submit memicu submit form secara otomatis,
terlepas dari apa pun yang terjadi di event listener `click` yang
terpisah) — pesan konfirmasi jadi percuma karena data sudah kadung
terkirim dan buku sudah terhapus sungguhan sebelum pengguna sempat
membatalkannya.

## 4.3 Solusi: Dengarkan Event `submit`, Bukan `click`

```js
document.addEventListener("submit", function (e) {
    const form = e.target;
    if (!form.classList.contains("form-hapus")) return;
    ...
});
```

- Event delegation di `document` — pola yang sama dari
  [dokumentasi jobsheet-06 §6.3](../../jobsheet-06/Dokumentasi/06-js-event-delegation-hapus.md#63-solusi-event-delegation),
  hanya sekarang mendengarkan event **`submit`**, bukan `click`. Event
  `submit` terjadi tepat **sebelum** browser benar-benar mengirim data
  form — memberi kesempatan JavaScript untuk **ikut campur** sebelum
  pengiriman sungguhan terjadi.
- **`e.target`** di sini adalah `<form>` itu sendiri (karena event
  `submit` terjadi pada elemen `<form>`, bukan pada tombolnya) — beda
  dari `e.target` pada event `click` di jobsheet-06 yang merujuk ke
  elemen paling spesifik yang diklik.
- **`form.classList.contains("form-hapus")`** — memeriksa apakah form
  yang di-submit ini memang form Hapus (ingat class `form-hapus` dari
  [bab 3 §3.5](03-hapus-delete-data.md#35-bagaimana-form-html-memicu-ini-pratinjau-singkat)),
  bukan form lain di halaman yang sama (seperti form pencarian dari
  [bab 5](05-pagination-dan-pencarian-server.md), atau form Tambah/Edit
  yang punya validasinya sendiri di
  [dokumentasi jobsheet-05 §7](../../jobsheet-05/Dokumentasi/07-js-validasi-form.md)).
  Kalau bukan, `return` — biarkan form itu diproses seperti biasa,
  tanpa campur tangan fungsi ini.

## 4.4 Membatalkan Submit dengan `preventDefault()`

```js
const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
if (!yakin) {
    e.preventDefault();
}
```

Ini **kebalikan logika** dibanding versi jobsheet-06: dulu, aksi
(`row.remove()`) dijalankan **kalau** pengguna menekan OK. Sekarang,
karena form akan **otomatis** ter-submit ke server kecuali dicegah,
logikanya dibalik: `e.preventDefault()` (ingat method ini dari
[dokumentasi jobsheet-05 §7.7](../../jobsheet-05/Dokumentasi/07-js-validasi-form.md#77-mencegah-submit-jika-tidak-valid))
dipanggil **kalau pengguna menekan Cancel** (`!yakin`, artinya `yakin`
bernilai `false`) — **membatalkan** pengiriman form sepenuhnya. Kalau
pengguna menekan OK, **tidak ada** yang dicegah — form melanjutkan
proses submit normalnya ke `hapus.php`, benar-benar menghapus data di
database ([bab 3](03-hapus-delete-data.md)).

## 4.5 Mencari Baris: `form.closest("tr")`

```js
const row = form.closest("tr");
```

Pola `.closest()` ini sudah kamu kenal dari
[dokumentasi jobsheet-05 §5.3](../../jobsheet-05/Dokumentasi/05-js-konfirmasi-hapus.md#53-mencari-baris-tabel-yang-jadi-induk-tombol) —
hanya sekarang dipanggil dari elemen `form` (bukan `btn` seperti
sebelumnya), karena `<form class="form-hapus">` yang membungkus tombol
sekarang **juga** berada langsung di dalam `<td>` yang sama, sejajar
dengan `<tr>` yang sama pula (ingat struktur HTML dari
[bab 3 §3.5](03-hapus-delete-data.md#35-bagaimana-form-html-memicu-ini-pratinjau-singkat)).

## 4.6 Perbandingan Ringkas Ketiga Versi `initHapusConfirm`

| | Jobsheet-05 | Jobsheet-06 | Jobsheet-09 |
|---|---|---|---|
| Event yang didengarkan | `click` (per tombol) | `click` (delegation di `document`) | `submit` (delegation di `document`) |
| Aksi kalau pengguna OK | `row.remove()` (hapus dari tampilan saja) | `row.remove()` (hapus dari tampilan saja) | Tidak ada — form lanjut submit ke `hapus.php` sungguhan |
| Aksi kalau pengguna Cancel | Tidak ada apa-apa | Tidak ada apa-apa | `e.preventDefault()` — batalkan submit |
| Data benar-benar terhapus? | Tidak (front-end only) | Tidak (front-end only) | **Ya** — lewat `DELETE` di database |

Progresi ini menunjukkan bagaimana **pola JavaScript yang sama**
(event delegation, `confirm()`, `.closest()`) terus dipakai ulang dan
disesuaikan sedikit demi sedikit seiring aplikasi menjadi lebih
sungguhan — bukan ditulis ulang dari nol setiap kali kebutuhannya
berubah.

Lanjut ke: [Pagination & Pencarian Sisi Server](05-pagination-dan-pencarian-server.md)
