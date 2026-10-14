// Mengambil & menampilkan Daftar Alat secara asinkron dari data/alat.json
// (struktur sama dengan buku.js pada contoh SIMPUS-Mini)

// Mengubah angka 45000 menjadi "Rp 45.000"
function formatRupiah(angka) {
    return "Rp " + Number(angka).toLocaleString("id-ID");
}

async function muatDaftarAlat() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // simulasi delay jaringan agar loading indicator terlihat
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/alat.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftarAlat = await res.json();

        daftarAlat.forEach(function (alat, i) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + (i + 1) + "</td>" +
                "<td>" + alat.kode_alat + "</td>" +
                "<td>" + alat.nama_alat + "</td>" +
                "<td>" + alat.kategori + "</td>" +
                "<td>" + formatRupiah(alat.tarif) + "</td>" +
                "<td>" + alat.stok + "</td>" +
                "<td>" +
                "<button type=\"button\" class=\"btn-action btn-edit\">Edit</button> " +
                "<button type=\"button\" class=\"btn-action btn-hapus\">Hapus</button>" +
                "</td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        // class "row-pesan" = baris pesan, tidak dihitung sebagai data oleh counter
        tbody.innerHTML =
            "<tr class=\"row-pesan\"><td colspan=\"7\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none";
        terapkanFilter(); // fungsi dari app.js: terapkan kata kunci cari & perbarui counter
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarAlat);