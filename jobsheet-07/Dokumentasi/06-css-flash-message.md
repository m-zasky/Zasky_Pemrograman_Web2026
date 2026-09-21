# 6. CSS: Gaya Flash Message

Satu-satunya perubahan `style.css` di jobsheet ini — mendukung tampilan
flash message yang sudah dibahas di
[bab 5 §5.3](05-list-php-render-dan-flash.md#53-menampilkan-flash-message-di-html).

## 6.1 Kode CSS

```css
/* ===== Flash Message ===== */
.flash {
    padding: 0.75rem 1rem;
    border-radius: 6px;
    margin-bottom: 1rem;
    font-weight: 500;
}

.flash-success {
    background-color: #d4edda;
    color: #155724;
}

.flash-error {
    background-color: #f8d7da;
    color: #721c24;
}
```

## 6.2 Gaya Dasar (`.flash`)

`.flash` berisi gaya yang **selalu sama** untuk kedua jenis pesan:
padding nyaman, sudut membulat (`border-radius`, ingat konsepnya dari
[dokumentasi jobsheet-02 §5.3](../../jobsheet-02/Dokumentasi/05-css-main-dan-section.md#53-kartu-putih-untuk-setiap-section)),
jarak di bawahnya, dan teks yang sedikit tebal (`font-weight: 500`,
konsisten dengan bobot yang dipakai label form sejak
[dokumentasi jobsheet-02 §8.3](../../jobsheet-02/Dokumentasi/08-css-form.md#83-label-sebagai-blok-tersendiri)).

## 6.3 Gaya Spesifik per Jenis (`.flash-success`, `.flash-error`)

Ingat dari [bab 5 §5.3](05-list-php-render-dan-flash.md#53-menampilkan-flash-message-di-html),
elemen flash message selalu punya **dua** class sekaligus: `flash` dan
salah satu dari `flash-success`/`flash-error`. Kedua class tambahan ini
memberi **warna berbeda** tergantung jenis pesannya:

| Class | Warna Latar | Warna Teks | Kesan |
|---|---|---|---|
| `.flash-success` | `#d4edda` (hijau sangat muda) | `#155724` (hijau tua) | Positif — data berhasil disimpan |
| `.flash-error` | `#f8d7da` (merah muda pucat) | `#721c24` (merah tua/marun) | Peringatan — ada yang perlu diperbaiki |

Pola warna hijau=sukses, merah=gagal ini konsisten dengan konvensi
warna yang sudah kamu pakai sejak awal — ingat warna merah pada tombol
Hapus dan pesan error validasi
([dokumentasi jobsheet-05 §3.2](../../jobsheet-05/Dokumentasi/03-css-pendukung-javascript.md#32-gaya-baru-pesan-error-validasi))
memakai kombinasi merah yang senada (`#d9534f`) untuk maksud yang
sama: menandakan sesuatu yang butuh perhatian pengguna.

Lanjut ke: [Rangkuman & Latihan Lanjutan](07-rangkuman-latihan.md)
