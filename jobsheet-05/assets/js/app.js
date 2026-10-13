// ===== Hamburger Menu (JS-driven) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// ===== Helper Counter Tabel =====
function updateCounter() {
    const table = document.querySelector(".table-responsive table");
    const counterEl = document.getElementById("table-counter");
    if (!table || !counterEl) return;

    const allRows = table.querySelectorAll("tbody tr");
    let visibleCount = 0;

    allRows.forEach(function (row) {
        if (row.style.display !== "none") {
            visibleCount++;
        }
    });

    counterEl.textContent = "Menampilkan " + visibleCount + " dari " + allRows.length + " data";
}

// ===== Konfirmasi Tombol Hapus =====
function initHapusConfirm() {
    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const row = btn.closest("tr");
            const namaTD = row ? row.querySelectorAll("td")[2] : null;
            const nama = namaTD ? namaTD.textContent : "data ini";
            const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
            
            if (yakin && row) {
                row.remove();
                updateCounter();
            }
        });
    });
}

// ===== Filter/Pencarian Tabel Real-Time =====
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
        updateCounter();
    });
}

// ===== Validasi Form Client-Side =====
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
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;
        const inputs = form.querySelectorAll("input[required], select[required], textarea[required]");

        inputs.forEach(function (input) {
            if (input.value.trim() === "") {
                tampilkanError(input, "Bagian ini wajib diisi.");
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
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
    updateCounter();
});