# GoTube Web

Aplikasi monitoring tabung, pengiriman, outlet, dan sales berbasis Laravel 12 / PHP 8.2+.

## Instalasi

1. Jalankan `composer install` dan `npm ci`.
2. Salin `.env.example` menjadi `.env`, lalu sesuaikan koneksi database.
3. Jalankan `php artisan key:generate` dan `php artisan migrate`.
4. Jalankan `npm run build` dan `php artisan storage:link`.
5. Arahkan document root web server ke folder `public`, atau gunakan `php artisan serve` untuk pengembangan.

## Export sales

Export Excel berisi sheet **Rekap Sales** dan **Detail Sales** dengan tema biru GoTube, format Rupiah, filter Excel, freeze pane, dan pengaturan cetak. Filter serta urutan dari halaman sales tetap digunakan untuk detail; rekap memakai kumpulan data dengan filter yang sama.

## Pengujian

Jalankan `php artisan test`. Pengujian export mencakup kecocokan rekap/detail dengan filter, perhitungan total, tata letak sheet, penomoran ulang, teks panjang, dan data kosong.

File `.env`, database lokal, dependensi, cache, serta unggahan pengguna tidak disertakan dalam repository.
