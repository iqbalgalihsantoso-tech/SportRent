PENGUMPULAN UJIAN TENGAH SEMESTER (UTS) PEMROGRAMAN WEB
======================================================
Nama Mahasiswa  : Iqbal Galih Santoso
NPM             : 24311147
Kelas           : SI24B
Program Studi   : Sistem Informasi
Perguruan Tinggi: Universitas Teknokrat Indonesia
Mata Kuliah     : Pemrograman Web
Judul Project   : SportRent - Futsal Court Booking Management System
Tahun Akademik  : 2026

STRUKTUR PENGUMPULAN:
UTS-PW-Iqbal-Galih-Santoso-24311147/
├── SportRent/                  (Direktori Source Code Lengkap CodeIgniter 4)
├── database/
│   └── db_sport_rent.sql       (Dump database MySQL dengan 4 tabel relasional)
├── presentasi/
│   └── Presentasi_SportRent.pptx
└── README.txt

AKUN DEMO UNTUK PENGUJIAN:
1. Administrator:
   Email    : admin@sportrent.test
   Password : Admin123!
   Akses    : Panel Admin (CRUD Lapangan, CRUD Booking, Verifikasi Bayar, Laporan, Statistik)

2. Customer:
   Email    : customer@sportrent.test
   Password : Customer123!
   Akses    : Area Member (Katalog Lapangan, Booking Online Bebas Bentrok, Riwayat Mandiri)

3. Akun Mahasiswa Pengembang:
   Email    : iqbal@sportrent.test
   Password : Iqbal123!

CARA MENJALANKAN DENGAN LARAGON:
1. Pastikan folder project berada pada direktori Laragon:
   C:\laragon\www\SportRent
2. Nyalakan Service Apache & MySQL melalui aplikasi Laragon (Start All).
3. Buat database "db_sport_rent" di phpMyAdmin dan impor file "database/db_sport_rent.sql".
4. Akses melalui web browser:
   http://sportrent.test atau http://localhost/SportRent/public
   (Atau via terminal spark: php spark serve)
