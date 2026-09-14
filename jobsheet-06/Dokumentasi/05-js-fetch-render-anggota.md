# 5. JS: Mengambil & Menampilkan Daftar Anggota

Kabar baik: `anggota.js` punya **struktur yang identik** dengan
`buku.js` yang sudah kamu bedah tuntas di [bab 4](04-js-fetch-render-buku.md).
Bab ini hanya menyoroti bagian yang **berbeda**.

## 5.1 Kode Lengkap

```js
// Mengambil & menampilkan Daftar Anggota secara asinkron dari data/anggota.json
async function muatDaftarAnggota() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/anggota.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftarAnggota = await res.json();

        daftarAnggota.forEach(function (anggota) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + anggota.no_anggota + "</td>" +
                "<td>" + anggota.nama + "</td>" +
                "<td>" + anggota.alamat + "</td>" +
                "<td>" + anggota.no_hp + "</td>" +
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

document.addEventListener("DOMContentLoaded", muatDaftarAnggota);
```

## 5.2 Perbandingan Langsung dengan `buku.js`

| Bagian | `buku.js` | `anggota.js` |
|---|---|---|
| Nama fungsi | `muatDaftarBuku` | `muatDaftarAnggota` |
| Sumber data | `fetch("../data/buku.json")` | `fetch("../data/anggota.json")` |
| Nama variabel array hasil | `daftarBuku` | `daftarAnggota` |
| Nama variabel per-item di `forEach` | `buku` | `anggota` |
| Kunci objek yang diakses | `.judul`, `.pengarang`, `.tahun`, `.stok` | `.no_anggota`, `.nama`, `.alamat`, `.no_hp` |
| Event pemicu | `DOMContentLoaded` → `muatDaftarBuku` | `DOMContentLoaded` → `muatDaftarAnggota` |

Semua bagian lain — pengambilan elemen ([dokumentasi bab 4 §4.2](04-js-fetch-render-buku.md#42-mengambil-elemen-yang-dibutuhkan)),
loading indicator ([§4.3](04-js-fetch-render-buku.md#43-menampilkan-dan-menyembunyikan-loading-indicator)),
delay simulasi ([§4.4](04-js-fetch-render-buku.md#44-simulasi-delay-jaringan)),
pengecekan `res.ok` ([§4.5](04-js-fetch-render-buku.md#45-mengambil-data-dan-memeriksa-keberhasilannya)),
penanganan error ([§4.7](04-js-fetch-render-buku.md#47-menangkap-dan-menampilkan-error)),
dan blok `finally` ([§4.8](04-js-fetch-render-buku.md#48-blok-finally-selalu-menyembunyikan-loading))
— **identik persis**, cukup baca ulang [bab 4](04-js-fetch-render-buku.md)
kalau ada bagian yang lupa.

## 5.3 Kenapa Kolom yang Diakses Berbeda?

Perbedaan paling penting untuk diperhatikan ada di bagian `forEach`:
`anggota.no_anggota`, `anggota.nama`, `anggota.alamat`, `anggota.no_hp`
— empat kunci ini **harus** sesuai persis dengan nama kunci yang
sungguhan ada di `data/anggota.json` (ingat strukturnya dari
[bab 3 §3.2](03-data-json.md#32-dataanggotajson--4-objek-anggota)).
Kalau salah ketik nama kunci (misalnya menulis `anggota.nomor` padahal
di JSON kuncinya `no_anggota`), JavaScript **tidak akan error** — ia
hanya akan mengembalikan `undefined` (nilai "tidak ada"), sehingga sel
tabel yang seharusnya berisi data malah tampil kosong atau bertuliskan
"undefined". Ini kesalahan umum yang mudah terlewat karena tidak
memunculkan error yang jelas di Console — kalau tabel tampil tapi datanya
kosong/aneh, periksa dulu apakah nama kunci di kode sudah sesuai persis
dengan nama kunci di file JSON-nya.

## 5.4 Kenapa Ditulis di Dua File Terpisah, Bukan Satu Fungsi Generik?

Kamu mungkin bertanya: kenapa tidak dibuat **satu** fungsi generik saja
yang menerima nama file JSON dan daftar kolom sebagai parameter,
dipakai ulang untuk buku maupun anggota — mengurangi duplikasi kode?
Ini pertanyaan yang bagus, dan jawabannya berkaitan dengan tahap belajar
saat ini: menulis dua fungsi terpisah yang **mirip tapi eksplisit**
lebih mudah dibaca dan ditelusuri untuk pemula, sebelum mempelajari
teknik menulis fungsi yang lebih generik/reusable. Ini juga ide latihan
lanjutan yang bagus untuk dicoba sendiri — lihat
[bab 8](08-rangkuman-latihan.md).

Lanjut ke: [JS: Event Delegation pada Tombol Hapus](06-js-event-delegation-hapus.md)
