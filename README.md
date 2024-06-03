Menjalankan Proyek Tokodata
Ini adalah proyek Tokodata yang dibuat menggunakan PHP dan MySQL. Proyek ini dijalankan di server lokal menggunakan XAMPP.

Langkah-langkah untuk Menjalankan Proyek
Install XAMPP:

Unduh dan install XAMPP sesuai dengan sistem operasi Anda.
Start Apache dan MySQL:

Buka XAMPP Control Panel.
Klik tombol Start di samping Apache dan MySQL untuk menjalankan server.
Salin Proyek ke Direktori htdocs:

Salin folder proyek tokodata ke dalam direktori htdocs di direktori instalasi XAMPP. Biasanya, direktori htdocs berada di C:\xampp\htdocs\.
Impor Database:

Buka phpMyAdmin melalui XAMPP Control Panel (klik tombol Admin di samping MySQL).
Buat database baru dengan nama tokodata.
Impor file SQL ke database tokodata dari folder proyek yang bernama database.sql.
Konfigurasi Koneksi Database:

Buka file config.php di dalam folder tokodata.
Sesuaikan konfigurasi database ($host, $username, $password, $database) sesuai dengan konfigurasi MySQL Anda.
Akses Proyek di Browser:

Buka browser dan ketikkan URL berikut: http://localhost/tokodata/index.php.
Login Sebagai Admin:

Gunakan username admin dan password admin untuk masuk sebagai admin.

Struktur Proyek
tokodata/
├── assets/
├── config.php
├── database.sql
├── index.php
├── login.php
└── ...

Catatan
Pastikan XAMPP berjalan dengan baik dan tidak ada konflik dengan port lain yang digunakan. Jika Anda mengalami masalah saat menjalankan proyek, pastikan untuk memeriksa log error di XAMPP untuk informasi lebih lanjut.
