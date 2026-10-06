# 1. Konsep Dasar Keamanan Web

## 1.1 Kenapa Keamanan Dibahas Terpisah, Bukan Sejak Awal?

Wajar bertanya: kenapa celah keamanan seperti XSS dan CSRF baru dibahas
di jobsheet-11, padahal form dan output data sudah ada sejak
jobsheet-01? Jawabannya berkaitan dengan urutan belajar: sebelum bisa
memahami **cara memperbaiki** sebuah celah keamanan, kamu perlu dulu
memahami **cara kerja** fitur yang terkait dengannya — form
([dokumentasi jobsheet-01](../../jobsheet-01/Dokumentasi/04-buku-tambah-html.md)),
proses server-side ([dokumentasi jobsheet-07](../../jobsheet-07/Dokumentasi/README.md)),
database ([dokumentasi jobsheet-08](../../jobsheet-08/Dokumentasi/README.md)),
dan session/login
([dokumentasi jobsheet-10](../../jobsheet-10/Dokumentasi/README.md)).
Jobsheet ini sengaja diletakkan **setelah** semua fondasi itu selesai,
supaya kamu bisa memahami **mengapa** tiap celah berbahaya dalam
konteks kode yang sudah kamu tulis sendiri, bukan sekadar teori
abstrak.

## 1.2 Lima Kerentanan yang Diaudit di Jobsheet Ini

Ingat dari [`docs/security-checklist.md`](../docs/security-checklist.md),
ada 5 kerentanan yang diperiksa:

| # | Kerentanan | Pertanyaan Intinya |
|---|---|---|
| 1 | SQL Injection | Bisakah pengguna menyisipkan **perintah SQL** lewat input form? |
| 2 | XSS | Bisakah pengguna menyisipkan **kode HTML/JavaScript** yang dijalankan di browser pengguna lain? |
| 3 | CSRF | Bisakah **situs lain** memicu aksi (hapus/ubah data) di aplikasi ini, atas nama pengguna yang sedang login, tanpa sepengetahuannya? |
| 4 | Validasi & Sanitasi Input | Apakah data yang masuk **benar-benar diperiksa** bentuk dan jenisnya? |
| 5 | Session Fixation | Bisakah penyerang **"mencuri"** ID sesi pengguna lain sebelum mereka login? |

Menariknya, **kerentanan #1 dan #4 ternyata sudah aman** sejak
jobsheet-08 dan jobsheet-07 — audit di jobsheet ini **mengonfirmasi**
itu, bukan memperbaikinya dari nol. Hanya #2, #3, #5 yang benar-benar
butuh kode baru. Ini contoh nyata kenapa **audit keamanan** (memeriksa
ulang kode yang sudah ada) sama pentingnya dengan menulis kode baru —
kadang hasilnya adalah konfirmasi "sudah aman," bukan selalu perbaikan.

## 1.3 Prinsip Besar: Jangan Pernah Percaya Input dari Luar

Kelima kerentanan di atas sebenarnya berakar dari **satu prinsip yang
sama**: **jangan pernah mempercayai data yang datang dari luar aplikasi
begitu saja** — baik dari `$_POST`, `$_GET`, maupun sumber lain yang
bisa dimanipulasi pengguna (atau pihak lain yang berpura-pura jadi
pengguna). Perhatikan bagaimana prinsip ini sudah muncul berulang kali
sejak jobsheet-jobsheet sebelumnya, meski belum disebut eksplisit
sebagai "prinsip keamanan":

- Validasi server-side ([dokumentasi jobsheet-07 §4.6](../../jobsheet-07/Dokumentasi/04-proses-tambah-validasi-server.md#46-kenapa-validasi-ini-yang-benar-benar-bisa-diandalkan)) —
  tidak percaya validasi client-side saja.
- Prepared statement ([dokumentasi jobsheet-08 §5.3](../../jobsheet-08/Dokumentasi/05-insert-prepared-statement.md#53-apa-itu-prepared-statement-dan-kenapa-penting)) —
  tidak percaya `$_POST` bisa digabung langsung ke query SQL.
- Guard clause otorisasi ([dokumentasi jobsheet-10 §4](../../jobsheet-10/Dokumentasi/04-guard-auth-php.md)) —
  tidak percaya pengguna hanya akan mengklik tautan yang "seharusnya."

Jobsheet ini **melengkapi** daftar itu dengan 2 aturan baru: jangan
percaya bahwa **teks yang ditampilkan kembali ke HTML aman apa adanya**
(→ XSS, [bab 2](02-xss-dan-fungsi-e.md)), dan jangan percaya bahwa
**setiap permintaan `POST` yang diterima server benar-benar berasal
dari niat pengguna sendiri** (→ CSRF, [bab 3](03-csrf-dan-token.md)).

Lanjut ke: [XSS & Fungsi `e()`](02-xss-dan-fungsi-e.md)
