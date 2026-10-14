// Mengambil & menampilkan Daftar Penyewa secara asinkron dari data/penyewa.json
// (struktur sama dengan anggota.js pada contoh SIMPUS-Mini)
async function muatDaftarPenyewa() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/penyewa.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftarPenyewa = await res.json();

        daftarPenyewa.forEach(function (penyewa, i) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + (i + 1) + "</td>" +
                "<td>" + penyewa.kode_penyewa + "</td>" +
                "<td>" + penyewa.nama_penyewa + "</td>" +
                "<td>" + penyewa.no_wa + "</td>" +
                "<td>" + penyewa.alamat + "</td>" +
                "<td>" + penyewa.status_member + "</td>" +
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

document.addEventListener("DOMContentLoaded", muatDaftarPenyewa);
