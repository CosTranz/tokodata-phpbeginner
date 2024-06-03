# Menjalankan Proyek Tokodata

Proyek Tokodata adalah aplikasi web sederhana yang dibuat menggunakan PHP dan MySQL. Proyek ini dirancang untuk dijalankan di server lokal menggunakan XAMPP.

## Instalasi

### 1. Instal XAMPP

- Unduh XAMPP dari [situs web resmi](https://www.apachefriends.org/index.html).
- Ikuti instruksi instalasi yang diberikan.

### 2. Start Apache dan MySQL

- Buka XAMPP Control Panel.
- Klik tombol Start di samping Apache dan MySQL.

### 3. Salin Proyek ke Direktori htdocs

- Salin folder proyek `tokodata` ke dalam direktori `htdocs` di direktori instalasi XAMPP. 
  Contoh: `C:\xampp\htdocs\tokodata`.

### 4. Impor Database

- Buka phpMyAdmin melalui XAMPP Control Panel (klik tombol Admin di samping MySQL).
- Buat database baru dengan nama `tokodata`.
- Impor file `database.sql` ke database `tokodata` dari folder proyek.

### 5. Konfigurasi Koneksi Database

- Buka file `config.php` di dalam folder `tokodata`.
- Sesuaikan konfigurasi database (`$host`, `$username`, `$password`, `$database`) sesuai dengan konfigurasi MySQL Anda.

### 6. Akses Proyek di Browser

- Buka browser dan ketikkan URL berikut: `http://localhost/tokodata/index.php`.

### 7. Login Sebagai Admin

- Gunakan username `admin` dan password `admin` untuk masuk sebagai admin.

## Struktur Proyek

```plaintext
tokodata/
├── assets/
├── config.php
├── database.sql
├── index.php
├── login.php
└── ...
