// penyewa.js — halaman Data Penyewa (penyewa/list.html)
// Bergantung pada app.js (muatDataGenerik), jadi app.js harus dimuat lebih dulu.

function muatDaftarPenyewa() {
    // Urutan kunci = urutan kolom tabel (setelah "No", sebelum "Aksi")
    muatDataGenerik(
        "../data/penyewa.json",
        ["kode_penyewa", "nama_penyewa", "no_wa", "alamat", "status_member"]
    );
}

document.addEventListener("DOMContentLoaded", function () {
    muatDaftarPenyewa();
});
