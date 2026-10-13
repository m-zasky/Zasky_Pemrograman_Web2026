// alat.js — halaman Data Alat (alat/list.html)
// Bergantung pada app.js (muatDataGenerik), jadi app.js harus dimuat lebih dulu.

// Mengubah angka 45000 menjadi "Rp 45.000" (format Indonesia)
function formatRupiah(angka) {
    return "Rp " + Number(angka).toLocaleString("id-ID");
}

function muatDaftarAlat() {
    // Urutan kunci = urutan kolom tabel (setelah "No", sebelum "Aksi")
    muatDataGenerik(
        "../data/alat.json",
        ["kode_alat", "nama_alat", "kategori", "tarif", "stok"],
        { tarif: formatRupiah }
    );
}

document.addEventListener("DOMContentLoaded", function () {
    muatDaftarAlat();

    // Tombol Muat Ulang: ambil ulang data dari JSON
    const btnReload = document.getElementById("btn-reload");
    if (btnReload) {
        btnReload.addEventListener("click", muatDaftarAlat);
    }
});
