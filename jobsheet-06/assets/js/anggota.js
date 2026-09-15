function muatDaftarAnggota() {
    // Memanggil fungsi generik dengan JSON anggota dan daftar kunci kolomnya
    muatDataGenerik("../data/anggota.json", ["no_anggota", "nama", "alamat", "no_hp"]);
}

document.addEventListener("DOMContentLoaded", function () {
    muatDaftarAnggota();
});