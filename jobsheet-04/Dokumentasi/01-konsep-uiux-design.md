# 1. Konsep Dasar UI/UX Design

## 1.1 Apa Beda UI dan UX?

Dua istilah ini sering disebut berbarengan, tapi artinya berbeda:

| Istilah | Kepanjangan | Fokus |
|---|---|---|
| **UI** | *User Interface* (Antarmuka Pengguna) | **Tampilan** — warna, tombol, tata letak, tipografi. Ini yang sudah kamu bangun sejak jobsheet-02 lewat `style.css` ([lihat dokumentasinya](../../jobsheet-02/Dokumentasi/README.md)). |
| **UX** | *User Experience* (Pengalaman Pengguna) | **Alur & rasa** — apakah pengguna mudah menyelesaikan tugasnya, apakah langkah-langkahnya masuk akal, apakah tidak membingungkan. |

Analogi sederhana: kalau sebuah aplikasi adalah sebuah toko, **UI**
adalah bagaimana rak dan etalase toko itu ditata supaya enak dipandang;
**UX** adalah apakah pelanggan bisa dengan mudah menemukan barang yang
dicari dan sampai ke kasir tanpa tersesat. Toko bisa saja terlihat cantik
(UI bagus) tapi membingungkan untuk berbelanja (UX buruk), atau
sebaliknya.

## 1.2 Kenapa Merancang Dulu, Baru Coding?

Bayangkan langsung menulis kode HTML untuk halaman "Peminjaman Buku"
tanpa rancangan lebih dulu — kamu harus memutuskan sekaligus: field apa
saja yang dibutuhkan, urutan langkahnya bagaimana, apa yang terjadi kalau
buku stoknya habis, halaman apa yang muncul setelah data disimpan, dan
seterusnya — semuanya sambil menulis tag HTML. Sangat mudah lupa satu
kondisi penting (seperti "buku stok 0 tidak boleh dipinjam") kalau
merancang dan menulis kode dilakukan **bersamaan**.

Dengan membuat rancangan dulu di atas kertas/teks (seperti
`docs/wireframe.md`), developer bisa:

1. Memikirkan **seluruh alur** dulu sebelum terikat detail teknis kode.
2. Menemukan celah/pertanyaan (misalnya: "bagaimana kalau anggota masih
   punya tunggakan?") **sebelum** menulis kode, saat masih murah untuk
   diubah — mengubah satu baris teks rancangan jauh lebih murah daripada
   menulis ulang kode yang sudah jadi.
3. Punya "peta" yang jelas untuk dirujuk saat mulai coding beneran nanti.

Inilah kenapa jobsheet-04 ini **sengaja tidak menambah kode** — seluruh
energi jobsheet ini dicurahkan untuk merancang dulu, sesuai Sub-CPMK
jobsheet ini: *"Merancang UI/UX aplikasi (proyek)."*

## 1.3 Dua Alat Bantu Rancangan: Wireframe & User Flow

`docs/wireframe.md` berisi dua jenis dokumen rancangan yang saling
melengkapi:

- **Wireframe** — sketsa kasar tata letak *satu halaman*, tanpa detail
  warna/font, hanya menunjukkan elemen apa saja yang ada dan di mana
  posisinya. Dibahas detail di [bab 2](02-cara-membaca-wireframe.md).
- **User flow** — diagram yang menunjukkan **urutan perpindahan** antar
  halaman/langkah yang dilalui pengguna untuk menyelesaikan satu tugas
  (misalnya meminjam buku). Dibahas detail di
  [bab 3](03-user-flow-peminjaman-pengembalian.md).

Kalau wireframe menjawab "halaman ini isinya apa saja?", user flow
menjawab "untuk sampai ke sini, pengguna harus lewat mana saja?" —
keduanya perlu dilihat bersamaan untuk memahami rancangan secara utuh.

Lanjut ke: [Cara Membaca Wireframe](02-cara-membaca-wireframe.md)
