<?php
/**
 * Skrip Migrasi Data JSON ke PostgreSQL
 * Diadaptasi dari pola migrasi standar Jobsheet 8
 */
require __DIR__ . '/includes/koneksi.php';

$jsonFile = __DIR__ . '/data/alat.json';

// 1. Cek apakah file JSON ada
if (!file_exists($jsonFile)) {
    die("File JSON tidak ditemukan di: " . $jsonFile);
}

// 2. Baca dan decode isi file JSON
$jsonData = file_get_contents($jsonFile);
$dataAlat = json_decode($jsonData, true);

if (empty($dataAlat)) {
    die("Data JSON kosong atau format tidak valid.");
}

// 3. Siapkan Prepared Statement
$stmt = $pdo->prepare("
    INSERT INTO alat (kode_alat, nama_alat, kategori, tarif, stok) 
    VALUES (:kode_alat, :nama_alat, :kategori, :tarif, :stok)
");

$berhasil = 0;
$gagal = 0;

echo "<h2>Proses Migrasi Data Alat...</h2><ul>";

// 4. Looping data JSON dan masukkan ke database
foreach ($dataAlat as $alat) {
    try {
        $stmt->execute([
            'kode_alat' => $alat['kode_alat'],
            'nama_alat' => $alat['nama_alat'],
            'kategori'  => $alat['kategori'],
            'tarif'     => $alat['tarif'],
            'stok'      => $alat['stok']
        ]);
        echo "<li><span style='color:green;'>[BERHASIL]</span> Alat {$alat['nama_alat']} ({$alat['kode_alat']}) diimpor.</li>";
        $berhasil++;
    } catch (PDOException $e) {
        $gagal++;
        if ($e->getCode() === '23505') {
            echo "<li><span style='color:orange;'>[Dilewati]</span> Kode alat {$alat['kode_alat']} sudah ada di database.</li>";
        } else {
            echo "<li><span style='color:red;'>[GAGAL]</span> Kode alat {$alat['kode_alat']}: {$e->getMessage()}</li>";
        }
    }
}

echo "</ul>";
echo "<p><strong>Selesai!</strong> Total berhasil: {$berhasil}, Dilewati/Gagal: {$gagal}.</p>";
echo "<a href='alat/list.php'>Lihat Daftar Alat</a>";
?>