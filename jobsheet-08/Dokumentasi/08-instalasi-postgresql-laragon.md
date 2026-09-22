# 8. Instalasi PostgreSQL di Laragon (Khusus Pengguna Windows)

Bab ini adalah **lampiran praktis** untuk pengguna Windows yang memakai
**Laragon** sebagai lingkungan pengembangan lokal. Berbeda dari
[bab 3](03-persiapan-database.md) yang menjelaskan **konsep** di balik
setiap langkah persiapan database, bab ini murni **langkah klik-per-klik**
untuk pengguna yang benar-benar baru dan belum pernah menginstal
PostgreSQL sama sekali.

## 8.1 Apa itu Laragon?

**Laragon** adalah aplikasi "paket instan" untuk Windows yang
menyediakan lingkungan pengembangan web lokal — membundel Apache/Nginx,
PHP, MySQL/MariaDB, dan alat bantu lain dalam satu aplikasi, tanpa perlu
menginstal masing-masing secara terpisah. Kabar yang perlu diketahui
sejak awal: **PostgreSQL tidak selalu ikut terpasang otomatis** saat
kamu pertama kali memasang Laragon — ia perlu **ditambahkan** lewat
fitur bernama **Quick Add**, dijelaskan mulai [§8.3](#83-menambahkan-postgresql-lewat-quick-add).

## 8.2 Memastikan Laragon Sudah Terpasang

Kalau kamu sudah bisa menjalankan `php -S localhost:8000` sejak
jobsheet-07, berarti Laragon (atau alat sejenis) sudah terpasang —
langsung lompat ke [§8.3](#83-menambahkan-postgresql-lewat-quick-add).
Kalau belum sama sekali, ini langkah instalasi Laragon-nya:

1. Buka browser, kunjungi **laragon.org**, klik tombol **Download**.
2. Pilih **Laragon Full** (disarankan untuk pemula — sudah membawa
   lebih banyak komponen bawaan) atau **Laragon Lite** (lebih ringan,
   komponen tambahan diunduh belakangan lewat Quick Add). Untuk
   panduan ini, **keduanya sama-sama bisa dipakai** karena PostgreSQL
   tetap dipasang lewat Quick Add di kedua varian.
3. Jalankan file installer yang sudah diunduh (`laragon-wamp.exe` atau
   sejenisnya). Ikuti wizard instalasi: klik **Next** berulang,
   biarkan lokasi instalasi default (`C:\laragon`), lalu klik
   **Finish**.
4. Laragon akan terbuka otomatis setelah instalasi selesai —
   tampilannya berupa jendela dengan daftar service (Apache, MySQL,
   dst.) di kiri, dan beberapa tombol (**Start All**, **Stop All**,
   **Menu**, dst.) di kanan.

## 8.3 Menambahkan PostgreSQL Lewat Quick Add

**Quick Add** adalah fitur bawaan Laragon untuk menambah komponen baru
(database, bahasa pemrograman, editor, dst.) hanya dengan beberapa
klik, tanpa perlu mengunduh dan mengonfigurasi manual dari situs lain.

1. Buka aplikasi Laragon (kalau belum terbuka).
2. Klik kanan di **area kosong** jendela utama Laragon (atau klik kanan
   ikon Laragon di *system tray* — area ikon kecil dekat jam Windows,
   pojok kanan bawah layar).
3. Dari menu yang muncul, arahkan ke **Tools → Quick Add**.
4. Akan muncul daftar komponen yang bisa ditambahkan, salah satunya
   **PostgreSQL** dengan beberapa pilihan versi (misalnya
   `postgresql-15`, `postgresql-16`, dst.). Pilih versi yang **terbaru**
   yang tersedia di daftar itu, kecuali kamu punya alasan khusus
   memilih versi tertentu.
5. Klik pilihan tersebut — Laragon akan **otomatis mengunduh dan
   memasang** PostgreSQL versi itu ke dalam folder Laragon (biasanya
   `C:\laragon\bin\postgresql\` untuk programnya, dan
   `C:\laragon\data\postgresql-XX\` untuk data database-nya). Proses
   ini butuh koneksi internet dan beberapa menit tergantung kecepatan
   unduhan.
6. Setelah selesai, **restart Laragon** — klik tombol **Stop All**
   (kalau ada service yang berjalan), lalu tutup dan buka ulang
   aplikasi Laragon, atau klik **Start All** lagi. Ini penting supaya
   Laragon "mengenali" PostgreSQL yang baru saja ditambahkan.

**Prasyarat teknis:** pastikan Windows-mu (64-bit) sudah punya
**Visual C++ Redistributable** (versi 2015-2019) terpasang — kebanyakan
komputer Windows modern sudah memilikinya secara bawaan. Kalau proses
instalasi PostgreSQL gagal aneh, ini kemungkinan penyebabnya, dan bisa
diunduh gratis dari situs resmi Microsoft.

## 8.4 Menjalankan Service PostgreSQL

Setelah restart, buka kembali jendela utama Laragon:

1. Perhatikan **daftar service** di sisi kiri jendela — sekarang
   seharusnya ada entri **PostgreSQL** di situ, dengan sebuah indikator
   titik berwarna (merah = tidak aktif, hijau = aktif/berjalan).
2. Kalau indikatornya **merah**, klik tombol **Start All** di kanan
   jendela (menyalakan semua service sekaligus), atau klik kanan
   khusus pada baris **PostgreSQL** lalu pilih **Start**.
3. Tunggu beberapa detik, indikator akan berubah **hijau** — tandanya
   PostgreSQL sudah berjalan dan siap menerima koneksi.

Ingat dari [dokumentasi jobsheet-08 §4.2](04-koneksi-pdo.md#42-lima-variabel-konfigurasi):
PostgreSQL secara default "mendengarkan" di **port `5432`** — nilai ini
sudah cocok dengan `$port = "5432";` di `includes/koneksi.php`, jadi
kamu **tidak perlu mengubah apa pun** terkait port. Port ini juga tidak
akan bentrok dengan MySQL/MariaDB Laragon yang memakai port `3306`
— keduanya bisa aktif bersamaan.

## 8.5 Membuka Terminal Laragon

Beberapa langkah berikutnya butuh mengetik perintah — Laragon punya
**Terminal bawaan** yang sudah otomatis "tahu" lokasi program `psql`,
`php`, dan semua komponen lain yang terpasang, tanpa kamu perlu
mengatur *PATH* Windows secara manual.

1. Di jendela utama Laragon, klik **Menu → Laragon → Terminal** (atau
   tekan kombinasi tombol **Ctrl + `** — tombol backtick, biasanya di
   kiri atas keyboard dekat angka 1 — saat jendela Laragon aktif).
2. Sebuah jendela terminal (mirip Command Prompt, tapi lebih canggih)
   akan terbuka/muncul di bagian bawah jendela Laragon.
3. Semua perintah di bab ini selanjutnya (`psql`, `createdb`) diketik
   di terminal ini.

## 8.6 Mengaktifkan Ekstensi PHP `pdo_pgsql`

Ingat dari [bab 3 §3.1](03-persiapan-database.md#31-langkah-1-pastikan-postgresql--ekstensi-php-siap):
PHP butuh ekstensi `pdo_pgsql` aktif supaya bisa "berbicara" dengan
PostgreSQL lewat PDO. Cara mengaktifkannya khusus di Laragon:

**Cara termudah (lewat menu):**
1. Klik kanan jendela Laragon → **Menu → PHP → Extensions**.
2. Cari **`pdo_pgsql`** di daftar (dan sebaiknya juga **`pgsql`**),
   klik untuk mengaktifkannya. Kalau ekstensi itu belum pernah
   diunduh, Laragon akan mengunduhkannya otomatis.
3. **Restart** Apache/server (klik **Stop All** lalu **Start All**)
   supaya PHP membaca ulang konfigurasi ekstensinya.

**Cara manual (edit `php.ini` langsung):**
1. Klik kanan jendela Laragon → **Menu → PHP → php.ini** — ini akan
   membuka file konfigurasi PHP di editor teks.
2. Cari baris `;extension=pdo_pgsql` dan `;extension=pgsql` (tanda
   titik koma `;` di depan berarti "dinonaktifkan").
3. Hapus tanda titik koma di **kedua** baris itu, simpan file.
4. Restart Apache/server seperti di atas.

**Memverifikasi ekstensi sudah aktif** — buka Terminal Laragon
([§8.5](#85-membuka-terminal-laragon)), ketik:
```bash
php -m | findstr pgsql
```
(`findstr` adalah "pencari teks" bawaan Windows, setara `grep` di
Linux/Mac yang mungkin kamu lihat di referensi lain). Kalau muncul
baris `pdo_pgsql` dan `pgsql`, berarti ekstensinya sudah aktif dan
siap dipakai `includes/koneksi.php`.

## 8.7 Login ke PostgreSQL & Menyamakan Password dengan `koneksi.php`

Ingat dari [dokumentasi jobsheet-08 §4.2](04-koneksi-pdo.md#42-lima-variabel-konfigurasi),
`includes/koneksi.php` jobsheet ini memakai kredensial default
**`$user = "postgres";`** dan **`$pass = "postgres";`**. Instalasi
PostgreSQL lewat Laragon Quick Add **tidak selalu** memakai kredensial
default yang sama persis (tergantung versi) — jadi langkah paling aman
adalah **login sekali**, lalu **menetapkan sendiri** password `postgres`
supaya cocok dengan kode yang sudah ditulis.

Di Terminal Laragon, ketik:
```bash
psql -U postgres
```

Ada 2 kemungkinan yang terjadi:

**Kemungkinan 1 — langsung masuk tanpa diminta password sama sekali**
(muncul langsung prompt `postgres=#`). Kalau ini terjadi, lanjut ke
langkah **menetapkan password** di bawah.

**Kemungkinan 2 — diminta mengetik `Password for user postgres:`.**
Coba salah satu dari kemungkinan berikut (ketik, lalu tekan Enter):
- Kosongkan saja (langsung tekan Enter tanpa mengetik apa pun).
- Ketik `postgres`.
- Ketik `root`.

Kalau salah satu berhasil (muncul prompt `postgres=#`), lanjut ke
langkah berikut. **Kalau semuanya gagal** (`password authentication
failed`), dan port `5432` sudah dipastikan **bukan** dipakai instalasi
lain ([§8.9](#89-kalau-service-postgresql-laragon-gagal-start-bentrok-port-5432)),
ikuti [§8.10](#810-jalan-pintas-kalau-lupatidak-tahu-password-postgres)
untuk mengatur ulang password secara paksa.

**Setelah berhasil login** (terlihat prompt `postgres=#`), ketik persis:
```sql
ALTER USER postgres WITH PASSWORD 'postgres';
```
Tekan Enter — akan muncul `ALTER ROLE`, tandanya berhasil. Ini
**menetapkan** password akun `postgres` menjadi `postgres`, sama persis
dengan yang sudah ditulis di `includes/koneksi.php`
([dokumentasi jobsheet-08 §4.2](04-koneksi-pdo.md#42-lima-variabel-konfigurasi)) —
jadi kamu **tidak perlu mengedit kode PHP apa pun** setelah ini. Ketik
`\q` lalu Enter untuk keluar dari `psql`.

## 8.8 Membuat Database & Menjalankan Skema

Setelah PostgreSQL berjalan dan password cocok, ikuti [bab 3 §3.2-3.3](03-persiapan-database.md#32-langkah-2-membuat-database)
seperti biasa, dari Terminal Laragon:

```bash
createdb -U postgres simpus_mini
```

(Perhatikan tambahan `-U postgres` dibanding contoh di
[bab 3](03-persiapan-database.md) — ini menegaskan **user** mana yang
dipakai membuat database, berguna kalau Laragon-mu punya lebih dari
satu akun PostgreSQL.)

Lalu pindah ke folder jobsheet-08 dengan perintah `cd`, misalnya:
```bash
cd D:\1.MateriKuliah\PemogramanWeb-2026\kode-praktikum\jobsheet-08
psql -U postgres -d simpus_mini -f sql/01_buku_anggota.sql
```

Kalau berhasil, akan muncul dua baris `CREATE TABLE` — persis seperti
yang dibahas di [bab 3 §3.3](03-persiapan-database.md#33-langkah-3-menjalankan-skema).

## 8.9 Kalau Service PostgreSQL Laragon Gagal Start (Bentrok Port 5432)

Kadang muncul dialog error **"waiting for server to start...."** saat
klik **Start All**/**Start** di Laragon, padahal langkah-langkah di atas
sudah diikuti persis. Ini **bukan berarti** ada yang salah dengan
instalasi PostgreSQL-mu — penyebab paling umum adalah **program lain
sudah lebih dulu memakai port `5432`**, sehingga PostgreSQL bawaan
Laragon tidak kebagian port untuk "mendengarkan" koneksi (ingat dari
[§8.4](#84-menjalankan-service-postgresql), PostgreSQL selalu memakai
port ini secara default). Penyebab yang paling sering terjadi:
komputer yang sama juga pernah dipasangi PostgreSQL **secara terpisah**
(misalnya lewat installer resmi dari postgresql.org, bukan lewat
Laragon) yang otomatis menyala sebagai *Windows Service* setiap kali
komputer dinyalakan — dua-duanya sama-sama berebut port `5432`, dan
yang menyala **lebih dulu** yang menang.

**Cara memastikan ini penyebabnya** — buka **Command Prompt** atau
**PowerShell** (tidak harus Terminal Laragon untuk langkah ini), ketik:
```powershell
netstat -ano | findstr ":5432"
```
Kalau muncul baris `LISTENING` dengan sebuah angka PID (*Process ID*)
di ujung kanan, cari tahu proses apa itu:
```powershell
Get-Process -Id <PID_yang_muncul>
```
Kalau hasilnya `postgres` tapi kamu **yakin** belum pernah menjalankan
PostgreSQL Laragon-mu hari itu, kemungkinan besar itu instalasi
PostgreSQL lain yang berjalan otomatis sebagai *service*.

**Cara mengatasinya** — pilih salah satu:

1. **Hentikan service PostgreSQL yang lain** (kalau memang tidak
   dipakai untuk proyek lain). Buka PowerShell **sebagai Administrator**
   (klik kanan ikon PowerShell → "Run as administrator" — wajib, kalau
   tidak akan muncul error "Access is denied"), lalu:
   ```powershell
   Get-Service | Where-Object { $_.DisplayName -match "PostgreSQL" }
   ```
   Ini menampilkan **semua** service PostgreSQL yang terpasang di
   komputer (biasanya lebih dari satu kalau memang ada bentrok). Cari
   nama service yang **bukan** milik Laragon (biasanya bernama seperti
   `postgresql-x64-<versi>`), lalu:
   ```powershell
   Stop-Service -Name "<nama-service>" -Force
   Set-Service -Name "<nama-service>" -StartupType Manual
   ```
   `StartupType Manual` mencegah service itu otomatis menyala lagi
   setiap kali komputer di-restart (kalau dibiarkan `Automatic`, port
   `5432` akan kembali direbut lagi di restart berikutnya) — service-nya
   sendiri **tidak dihapus**, cuma tidak otomatis jalan lagi.
2. **Atau, biarkan service lain itu tetap jalan**, dan pindahkan
   PostgreSQL Laragon ke port lain (misalnya `5433`) lewat
   `postgresql.conf` di folder data-nya (`C:\laragon\data\postgresql-XX\`),
   lalu sesuaikan `$port` di `includes/koneksi.php` supaya cocok. Opsi
   ini lebih rumit dan **hanya disarankan** kalau service lain itu
   memang masih dipakai untuk keperluan lain.

Setelah salah satu langkah di atas selesai, klik **Stop** lalu
**Start All** lagi di Laragon — indikator PostgreSQL seharusnya
berubah hijau tanpa dialog error.

## 8.10 Jalan Pintas Kalau Lupa/Tidak Tahu Password `postgres`

Kalau di [§8.7](#87-login-ke-postgresql--menyamakan-password-dengan-koneksiphp)
semua kemungkinan password gagal, kamu bisa **memaksa** PostgreSQL
menerima koneksi tanpa password **sementara waktu**, mengganti
passwordnya, lalu mengembalikan pengaturan semula.

1. Buka folder data PostgreSQL, misalnya
   `C:\laragon\data\postgresql-16\` (sesuaikan angka versi dengan yang
   kamu pasang). Cari file bernama **`pg_hba.conf`**, buka dengan
   Notepad.
2. Cari baris yang mengandung `127.0.0.1/32` (biasanya diakhiri kata
   `scram-sha-256` atau `md5`), misalnya:
   ```
   host    all             all             127.0.0.1/32            scram-sha-256
   ```
3. Ganti kata terakhir di baris itu (`scram-sha-256`/`md5`) menjadi
   **`trust`**, simpan file.
4. Kembali ke Laragon, **restart** service PostgreSQL (klik kanan
   PostgreSQL di daftar service → **Stop**, lalu **Start** lagi).
5. Di Terminal Laragon, ketik `psql -U postgres` — kali ini seharusnya
   **langsung masuk** tanpa diminta password sama sekali (karena
   `trust` berarti "percaya siapa pun yang terhubung dari komputer
   ini").
6. Jalankan `ALTER USER postgres WITH PASSWORD 'postgres';` seperti di
   [§8.7](#87-login-ke-postgresql--menyamakan-password-dengan-koneksiphp),
   lalu `\q`.
7. **Kembalikan** baris di `pg_hba.conf` yang tadi diubah, ganti
   `trust` kembali menjadi nilai aslinya (`scram-sha-256`/`md5`),
   simpan.
8. Restart lagi service PostgreSQL lewat Laragon.

Sekarang password `postgres` sudah pasti `postgres`, dan koneksi tetap
membutuhkan password (tidak dibiarkan `trust` selamanya) — langkah 7-8
**penting** untuk tidak dilewati, supaya PostgreSQL tidak menerima
sembarang koneksi begitu saja.

## 8.11 Ringkasan Checklist

Sebelum menjalankan `php -S localhost:8000` (atau lewat Laragon) di
folder jobsheet-08, pastikan semua ini sudah "centang":

- [ ] Laragon terpasang dan terbuka.
- [ ] PostgreSQL sudah ditambahkan lewat Quick Add ([§8.3](#83-menambahkan-postgresql-lewat-quick-add)).
- [ ] Indikator PostgreSQL di daftar service Laragon berwarna **hijau**,
      tanpa dialog error "waiting for server to start...." ([§8.4](#84-menjalankan-service-postgresql);
      kalau muncul error itu, kemungkinan bentrok port — lihat [§8.9](#89-kalau-service-postgresql-laragon-gagal-start-bentrok-port-5432)).
- [ ] `php -m | findstr pgsql` menampilkan `pdo_pgsql` dan `pgsql`
      ([§8.6](#86-mengaktifkan-ekstensi-php-pdo_pgsql)).
- [ ] `psql -U postgres` bisa login, dan password sudah ditetapkan ke
      `postgres` ([§8.7](#87-login-ke-postgresql--menyamakan-password-dengan-koneksiphp)).
- [ ] Database `simpus_mini` sudah dibuat dan skema `01_buku_anggota.sql`
      sudah dijalankan ([§8.8](#88-membuat-database--menjalankan-skema)).

Kalau semua sudah tercentang, lanjutkan ke
[dokumentasi jobsheet-08 §4](04-koneksi-pdo.md) untuk memahami
bagaimana `includes/koneksi.php` benar-benar menggunakan semua yang
baru saja kamu siapkan ini.
