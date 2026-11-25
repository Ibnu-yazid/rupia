# RUPIA (Laravel)

Aplikasi pencatatan keuangan pribadi RUPIA yang dibangun dengan Laravel 12, PHP 8.2+, dan MySQL/MariaDB.

## Fitur

- Registrasi, login, dan logout dengan autentikasi Laravel.
- Dashboard total pemasukan, pengeluaran, dan saldo.
- CRUD kategori pemasukan/pengeluaran.
- Pencatatan dan riwayat transaksi.
- Grafik laporan pengeluaran dan arus kas bulanan.
- Pengaturan profil dan unggah foto.

## Menjalankan di XAMPP

1. Pastikan PHP 8.2+, Composer, dan MySQL aktif.
2. Buat database MySQL kosong bernama `db_rupia` melalui phpMyAdmin.
3. Salin `.env.example` menjadi `.env`, lalu sesuaikan konfigurasi `DB_*` jika perlu.
4. Dari folder proyek, jalankan:

   ```sh
   composer install
   php artisan key:generate
   php artisan migrate
   php artisan storage:link
   php artisan serve
   ```

5. Buka URL yang ditampilkan `artisan serve` (biasanya `http://127.0.0.1:8000`) dan buat akun melalui halaman Daftar.

Untuk memakai Apache XAMPP, arahkan document root/virtual host ke folder `public`, bukan ke root proyek. Folder `storage` dan `bootstrap/cache` harus bisa ditulis oleh PHP.

Migration membuat tabel `users`, `categories`, dan `transactions`; data pada database lama tidak otomatis diimpor. Buat backup sebelum mengganti database yang sudah berisi data.

## Pengujian

```sh
php artisan test
```
