// ===== Hamburger menu (JS-driven) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

/* ==============================================================================
 * KODE PENYEBAB BUG (SEBELUM DIPERBAIKI):
 * Fungsi di bawah ini adalah penyebab data tidak terhapus secara permanen di database.
 * 
 * MENGAPA KODE INI MENJADI PENYEBAB ERROR?
 * - Fungsi ini mencegat klik tombol hapus menggunakan event listener global.
 * - Baris "row.remove()" hanya menghapus elemen tabel secara visual di layar browser 
 *   (front-end only) dan memunculkan alert "Berhasil dihapus dari tampilan."
 * - Karena tidak ada pengiriman data (submit form) ke file server (hapus.php), 
 *   maka data di database PostgreSQL tidak tersentuh sama sekali. Akibatnya, 
 *   ketika halaman di-refresh, data tersebut muncul kembali.
 * ==============================================================================

function initHapusConfirm() {
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-hapus");
        if (!btn) return;

        const row = btn.closest("tr");
        const nama = row ? row.querySelectorAll("td")[2]?.textContent : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
        if (yakin && row) {
            row.remove(); // <-- PENYEBAB UTAMA: Hanya menghapus tampilan visual browser!
            alert("Berhasil dihapus dari tampilan.");
        }
    });
}
============================================================================== */


// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}

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
    const formAlat = document.getElementById("formAlat");
    const formPenyewa = document.getElementById("formPenyewa");
    const form = formAlat || formPenyewa;

    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        const inputs = form.querySelectorAll("input, select, textarea");
        inputs.forEach(input => {
            if (input.value.trim() === "") {
                tampilkanError(input, "Field ini wajib diisi.");
                valid = false;
            } else {
                hapusError(input);
            }
        });

        if (!valid) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initTableFilter();
    initValidasiForm();
    
    // SOLUSI PERBAIKAN:
    // initHapusConfirm(); // <-- Fungsi penyebab bug dimatikan. 
    // Penghapusan data kini diserahkan sepenuhnya ke form HTML yang langsung 
    // mengeksekusi skrip server di file "hapus.php" agar data terhapus permanen di database.
});