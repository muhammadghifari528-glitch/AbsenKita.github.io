# AbsenKita - Aplikasi Absensi

Aplikasi absensi berbasis Laravel dan MySQL.

## Fitur
- Login admin
- Mengelola kegiatan
- Mengelola peserta
- Mencatat kehadiran
- Melihat dashboard
- Mengekspor laporan

## Teknologi
- Laravel
- PHP
- MySQL

## Menjalankan aplikasi secara lokal
1. Salin `.env.example` menjadi `.env`.
2. Jalankan `composer install`.
3. Jalankan `php artisan key:generate`.
4. Atur database di file `.env`.
5. Jalankan `php artisan migrate --seed`.
6. Jalankan `php artisan serve`.

Jangan unggah file `.env` atau informasi rahasia ke GitHub.


