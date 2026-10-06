document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const mainNav = document.getElementById("main-nav");

    if (toggleBtn && mainNav) {
        toggleBtn.onclick = function (e) {
            e.preventDefault();
            if (mainNav.style.display === "flex") {
                mainNav.style.display = "none";
            } else {
                mainNav.style.display = "flex";
            }
        };
    }

    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});

function initHapusConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target;
        if (!form.classList.contains("form-hapus")) return;

        const row = form.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        const yakin = confirm('Yakin ingin menghapus "' + nama.trim() + '"?');
        if (!yakin) {
            e.preventDefault();
        }
    });
}

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

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;
        const inputsRequired = form.querySelectorAll("input[required], select[required]");
        inputsRequired.forEach(function (input) {
            if (input.value.trim() === "") {
                valid = false;
            }
        });

        if (!valid) {
            e.preventDefault();
            alert("Harap isi semua field yang wajib!");
        }
    });
}