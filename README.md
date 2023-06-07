## Manajemen Penjualan Kendaraan
Sebuah aplikasi manajemen penjualan kendaraan. Aplikasi ini memungkinkan pengguna untuk mengelola informasi kendaraan yang dijual, termasuk data kendaraan, stok, harga, dan detail lainnya.

Fitur Fitur yang tersedia
- Pendaftaran pengguna: Pengguna dapat mendaftar sebagai pengguna baru dengan memberikan nama, alamat email, dan kata sandi.
- Otentikasi pengguna: Pengguna dapat melakukan login menggunakan alamat email dan kata sandi yang terdaftar.
- Manajemen kendaraan: Pengguna dapat menambahkan, mengedit, dan menghapus data kendaraan yang dijual, termasuk tahun keluaran, warna
harga, stok, dan detail kendaraan.
- Pencarian kendaraan: Pengguna dapat melakukan pencarian kendaraan
- Melihat semua kendaraan: Pengguna dapat melihat informasi terkait kendaraan yang tersedia
- Laporan penjualan: Pengguna dapat melihat laporan penjualan kendaraan yang telah terjadi

## Persyaratan Sistem

- PHP 8 atau lebih baru
- Laravel 8 atau lebih baru
- MongoDB 4.2

## Instalasi

1. Clone Repositori ini:
```bash
git clone git@github.com:Narukane/inosoft-technical-test.git
```

2. Pindah ke direktori proyek:
```bash
cd inosoft-technical-test
```

3. Edit file `.env` dan `.env.testing` sesui environment yang ada:
```bash
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=nama_database
DB_USERNAME=username
DB_PASSWORD=password
```

4. Instal Dependensi dengan Composer:
```bash
composer install
```

5. Generate key aplikasi:
```bash
php artisan key:generate
```

6. Jalankan aplikasi:
```bash
php artisan serve
```

## Penggunaan
Untuk memudahkan penggunaan disni terdapat direktori `postman` yang berisi collection dan environment untuk bisa melakukan request pada aplikasi

## Route list
Untuk melihat route list yang tersedia bisa menggunakan command:
```bash
php artisan route:list
```

## Testing
Untuk menjalankan test perludipastikan untuk `.env.testing` sudah sesuai dengan environment yang ada

Command melakukan test:
```bash
php artisan test --env=testing
```



