function muatDaftarBuku() {
    // Memanggil fungsi generik dengan JSON buku dan daftar kunci kolomnya
    muatDataGenerik("../data/buku.json", ["judul", "pengarang", "tahun", "stok", "kategori"]);
}

document.addEventListener("DOMContentLoaded", function () {
    muatDaftarBuku();

    const btnReload = document.getElementById("btn-reload");
    if (btnReload) {
        btnReload.addEventListener("click", muatDaftarBuku);
    }
});