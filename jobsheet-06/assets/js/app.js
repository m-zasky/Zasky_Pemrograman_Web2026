// =====================================================================
// app.js — Persewaan Alat Outdoor (Jobsheet 6: Fetch API & JSON)
// Fitur Jobsheet 5 (hamburger, pencarian, counter, hapus, validasi) tetap ada.
// Jobsheet 6: baris tabel kini diisi lewat fetch di alat.js / penyewa.js,
// sehingga hapus memakai event delegation dan filter bisa dipanggil ulang
// (terapkanFilter) setelah data selesai dimuat.
// Dimuat di semua halaman; tiap fungsi berhenti sendiri bila elemennya tidak ada.
// =====================================================================

// ===== 1. Hamburger menu (JS-driven) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        const terbuka = nav.classList.toggle("nav-open");
        toggleBtn.setAttribute("aria-expanded", terbuka);
    });
}

// ===== Helper: tabel data, kolom "nama", dan baris data =====
// data-kolom-nama di <table> menentukan kolom yang dipakai untuk pencarian
// & konfirmasi hapus (di proyek ini kolom ke-3 => indeks 2).
function getTable() {
    return document.querySelector(".table-responsive table");
}

function getKolomNama(table) {
    const idx = parseInt(table.dataset.kolomNama, 10);
    return isNaN(idx) ? 0 : idx;
}

// [BARU J6] Baris pesan (error / data kosong) diberi class "row-pesan"
// dan tidak ikut dihitung sebagai data.
function getRows(table) {
    return table.querySelectorAll("tbody tr:not(.row-pesan)");
}

// ===== 2. Penghitung baris: "Menampilkan X dari Y alat" =====
function updateCounter() {
    const table = getTable();
    const counterEl = document.getElementById("table-counter");
    if (!table || !counterEl) return;

    const allRows = getRows(table);
    let visibleCount = 0;

    allRows.forEach(function (row) {
        if (row.style.display !== "none") {
            visibleCount++;
        }
    });

    const label = counterEl.dataset.label || "data";
    counterEl.textContent = "Menampilkan " + visibleCount + " dari " + allRows.length + " " + label;
}

// ===== Helper: nomor urut dirapikan ulang setelah hapus =====
function nomorUlang(table) {
    getRows(table).forEach(function (row, i) {
        const kolomNo = row.querySelector("td");
        if (kolomNo) kolomNo.textContent = i + 1;
    });
}

// ===== 3. Konfirmasi hapus (front-end only, belum ke server) =====
// Event delegation: listener dipasang SEKALI di <table>, bukan di tiap tombol.
// Wajib begitu karena baris kini dibuat dinamis oleh fetch, setelah halaman
// selesai dimuat — tombol .btn-hapus belum ada saat DOMContentLoaded.
function initHapusConfirm() {
    const table = getTable();
    if (!table) return;

    table.addEventListener("click", function (e) {
        // console.log("Elemen yang diklik (e.target):", e.target); // aktifkan untuk praktikum

        const btn = e.target.closest(".btn-hapus");
        if (!btn) return;

        const row = btn.closest("tr");
        const sel = row.querySelectorAll("td")[getKolomNama(table)];
        const nama = sel ? sel.textContent.trim() : "data ini";

        if (confirm("Yakin ingin menghapus \"" + nama + "\"?")) {
            row.remove();
            nomorUlang(table);
            updateCounter();
        }
    });
}

// ===== 4. Pencarian tabel real-time =====
// [UBAH J6] Logika dipisah ke terapkanFilter() agar bisa dipanggil ulang
// setelah data selesai dimuat (mis. kata kunci masih terisi saat Muat Ulang).
function terapkanFilter() {
    const input = document.getElementById("search-input");
    const table = getTable();
    if (!input || !table) return;

    const keyword = input.value.toLowerCase().trim();
    const kolom = getKolomNama(table);

    getRows(table).forEach(function (row) {
        const sel = row.querySelectorAll("td")[kolom];
        const teks = sel ? sel.textContent.toLowerCase() : "";
        row.style.display = teks.includes(keyword) ? "" : "none";
    });
    updateCounter();
}

function initTableFilter() {
    const input = document.getElementById("search-input");
    if (!input) return;
    input.addEventListener("input", terapkanFilter);
}

// ===== 5. Validasi form (client-side) =====
// Field kosong dicegat dulu oleh popup bawaan browser (atribut required).
// Kode di bawah menangani aturan yang tidak bisa dicek browser.
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.classList.add("is-invalid");
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    input.classList.remove("is-invalid");
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    // Daftar field wajib dari kedua form (alat & penyewa).
    // Field yang tidak ada di halaman itu otomatis dilewati.
    const fieldWajib = [
        "kode_alat", "nama_alat", "kategori", "tarif", "stok",   // form alat
        "kode_penyewa", "nama_lengkap", "no_hp", "alamat"        // form penyewa
    ];

    // Helper: cek aturan khusus, hanya jika field ada & sudah terisi.
    function cekAturan(nama, fungsiValid, pesan) {
        const input = form.querySelector("[name='" + nama + "']");
        if (!input || input.value.trim() === "") return true;
        if (!fungsiValid(input.value.trim())) {
            tampilkanError(input, pesan);
            return false;
        }
        return true;
    }

    form.addEventListener("submit", function (e) {
        let valid = true;

        // a) Cadangan untuk isian yang hanya berisi spasi
        fieldWajib.forEach(function (fieldName) {
            const input = form.querySelector("[name='" + fieldName + "']");
            if (!input) return;
            if (input.value.trim() === "") {
                tampilkanError(input, "Field ini wajib diisi.");
                valid = false;
            } else {
                hapusError(input);
            }
        });

        // b) Aturan khusus per field
        valid = cekAturan("kode_alat",
            function (v) { return /^ALT\d{3}$/i.test(v); },
            "Format kode: ALT + 3 angka (contoh: ALT011).") && valid;

        valid = cekAturan("tarif",
            function (v) { return Number(v) > 0; },
            "Tarif harus lebih dari 0.") && valid;

        valid = cekAturan("stok",
            function (v) { return Number.isInteger(Number(v)) && Number(v) >= 0; },
            "Stok harus bilangan bulat dan tidak boleh negatif.") && valid;

        valid = cekAturan("kode_penyewa",
            function (v) { return /^PL\d{3}$/i.test(v); },
            "Format kode: PL + 3 angka (contoh: PL005).") && valid;

        valid = cekAturan("no_hp",
            function (v) { return /^08\d{8,11}$/.test(v); },
            "No. HP harus angka, diawali 08, panjang 10-13 digit.") && valid;

        // c) Gagal -> batalkan submit & fokus ke field salah pertama
        if (!valid) {
            e.preventDefault();
            const pertama = form.querySelector(".is-invalid");
            if (pertama) pertama.focus();
        }
    });

    // Pesan error hilang otomatis begitu user mulai memperbaiki isian
    form.addEventListener("input", function (e) {
        if (e.target.classList.contains("is-invalid")) {
            hapusError(e.target);
        }
    });
}

// ===== Jalankan semua setelah HTML selesai dimuat =====
document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
    // updateCounter() tidak dipanggil di sini: tabel masih kosong sampai fetch selesai.
    // Counter diperbarui lewat terapkanFilter() di alat.js / penyewa.js.
});
