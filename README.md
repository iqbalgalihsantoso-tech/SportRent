# SportRent - Futsal Court Booking Management System

SportRent adalah sistem informasi pemesanan lapangan futsal berbasis web modern, responsif, dan terintegrasi database MySQL. Aplikasi ini dikembangkan untuk memfasilitasi pelanggan (Customer) dalam menyewa lapangan secara online dengan pencegahan double booking otomatis, serta memberikan panel kendali bagi Pengelola Lapangan (Admin) dalam mengelola data lapangan, jadwal, verifikasi pembayaran, dan laporan pendapatan.

> **Tugas Ujian Tengah Semester (UTS) Pemrograman Web**  
> **Nama Pengembang:** Iqbal Galih Santoso  
> **NPM:** 24311147  
> **Kelas:** SI24B  
> **Program Studi:** Sistem Informasi  
> **Fakultas / Kampus:** Fakultas Teknik dan Ilmu Komputer, Universitas Teknokrat Indonesia  

---

## 🚀 Fitur Unggulan

### 1. Modul Publik & Beranda
- **Hero Section Modern:** Dilengkapi gambar lapangan futsal beresolusi tinggi, slogan menarik, dan CTA booking instan.
- **Statistik Dinamis Real-Time:** Menghitung total lapangan, total booking, dan pelanggan terdaftar langsung dari database.
- **Katalog Lapangan:** Menampilkan foto, nama lapangan, tipe lantai, status ketersediaan, dan rincian harga sewa per jam.
- **Halaman Tentang Kami:** Informasi lengkap identitas pengembang mahasiswa UTS dan spesifikasi arsitektur aplikasi.

### 2. Modul Autentikasi & Otorisasi
- **Multi-Role User:** Pemisahan hak akses antara `admin` dan `customer` dengan filter middleware (`AuthFilter.php`).
- **Registrasi Publik Aman:** Pendaftaran publik otomatis menetapkan role `customer`.
- **Enkripsi Kata Sandi:** Menggunakan `password_hash()` standar algoritma BCRYPT dan validasi `password_verify()`.
- **Proteksi Session & CSRF:** Mencegah eksploitasi CSRF dan akses URL tanpa login.

### 3. Modul Admin (CRUD Lengkap Sesuai Ketentuan UTS)
- **Data Utama (CRUD `bookings`):**
  - **Create:** Menambahkan data booking manual / offline.
  - **Read:** Menampilkan tabel booking lengkap dengan pencarian, filter tanggal, dan filter status.
  - **Update:** Mengedit jadwal bermain, durasi, lapangan, dan status booking.
  - **Delete:** Menghapus booking dengan dialog konfirmasi dan cascade foreign key ke pembayaran.
- **Data Pendukung (CRUD `lapangan`):**
  - **Create:** Menambah data lapangan dengan unggah foto lapangan.
  - **Read:** Menampilkan tabel lapangan, jenis lantai, tarif per jam, dan status ketersediaan.
  - **Update:** Mengubah nama, lantai, tarif sewa, status (Tersedia/Tidak Aktif), dan foto.
  - **Delete:** Penghapusan aman dengan proteksi foreign key (jika memiliki riwayat pemesanan, otomatis beralih ke status `Tidak Aktif`).
- **Verifikasi Pembayaran:** Admin dapat mengonfirmasi atau menolak bukti pembayaran pelanggan, yang secara otomatis memperbarui status booking menjadi `Dikonfirmasi`.
- **Data Pelanggan:** Daftar seluruh member terdaftar beserta agregasi jumlah booking yang pernah dilakukan.
- **Laporan & Export:** Menghitung omset pendapatan terverifikasi pada rentang tanggal tertentu dan siap dicetak (`window.print()`).

### 4. Modul Customer
- **Pemesanan Lapangan Online:** Form pemesanan dengan dropdown dinamis yang mengambil data dari tabel `lapangan`.
- **Algoritma Deteksi Bentrok Jadwal (Anti Overlap):**
  - Sistem memvalidasi apakah lapangan sudah dipesan pada rentang jam tersebut dengan logika overlap:
    $$\text{Jam Mulai Ada} < \text{Jam Selesai Baru} \quad \text{dan} \quad \text{Jam Selesai Ada} > \text{Jam Mulai Baru}$$
  - Pemesanan dengan jadwal berbenturan otomatis ditolak.
- **Kalkulasi Biaya Backend Otomatis:** Perhitungan total biaya sewa dikalkulasi ulang di server ($\text{Durasi} \times \text{Harga Per Jam}$) untuk mencegah manipulasi form.
- **Riwayat Booking Mandiri:** Pelanggan hanya dapat melihat riwayat dan tiket miliknya sendiri.
- **Pembatalan Mandiri:** Pelanggan dapat membatalkan pemesanan yang masih berstatus `Pending`.

---

## 🛠️ Teknologi yang Digunakan
- **Backend:** PHP 8.1 / 8.2 & CodeIgniter 4 (MVC Architecture)
- **Database:** MySQL 8.0 (InnoDB, Foreign Key Relations)
- **Frontend:** HTML5, CSS3 kustom, Bootstrap 5.3.3, Bootstrap Icons
- **Local Dev Environment:** Laragon & Composer
- **Editor:** Visual Studio Code / Antigravity IDE

---

## 📂 Struktur Folder MVC

```text
SportRent/
│
├── app/
│   ├── Commands/
│   │   └── TestSchedule.php       # Perintah uji CLI spark
│   ├── Config/
│   │   ├── Database.php           # Konfigurasi database MySQL
│   │   ├── Filters.php            # Pendaftaran AuthFilter
│   │   └── Routes.php             # Pemetaan seluruh routing aplikasi
│   ├── Controllers/
│   │   ├── Auth.php               # Login, Register, Logout
│   │   ├── Booking.php            # CRUD Booking Admin & Customer Booking
│   │   ├── Dashboard.php          # Dashboard Admin & Member
│   │   ├── Home.php               # Landing page & katalog publik
│   │   ├── Lapangan.php           # CRUD Lapangan Admin
│   │   ├── Laporan.php            # Rekapitulasi transaksi & cetak laporan
│   │   ├── Pelanggan.php          # Manajemen data pelanggan
│   │   ├── Pembayaran.php         # Verifikasi transfer pembayaran
│   │   └── Tentang.php            # Profil pengembang UTS
│   ├── Database/
│   │   ├── Migrations/            # 4 migration tabel relasional
│   │   └── Seeds/
│   │       └── DatabaseSeeder.php # Seeder akun demo dan data awal
│   ├── Filters/
│   │   └── AuthFilter.php         # Middleware pembatas role admin & customer
│   ├── Models/
│   │   ├── BookingModel.php       # Model booking, query builder, validasi jadwal
│   │   ├── LapanganModel.php      # Model lapangan
│   │   ├── PaymentModel.php       # Model pembayaran
│   │   └── UserModel.php          # Model autentikasi & akun
│   └── Views/
│       ├── layouts/               # Master layout reusable (main & admin)
│       ├── home/                  # Halaman landing page & katalog lapangan
│       ├── auth/                  # Halaman login & register
│       ├── admin/                 # Seluruh view panel dashboard admin
│       ├── customer/              # View formulir booking & riwayat pelanggan
│       └── tentang.php            # Halaman tentang identitas UTS
│
├── database/
│   └── db_sport_rent.sql          # File SQL Export siap diimpor
├── public/
│   ├── assets/                    # File CSS, JS, dan Gambar lapangan/bukti
│   └── index.php                  # Front controller CodeIgniter 4
├── .env                           # Konfigurasi environment database lokal
└── composer.json                  # Dependency CodeIgniter 4
```

---

## 💾 Struktur Database `db_sport_rent`

Database terdiri atas 4 tabel relasional:
1. **`users`**
   - `id` (INT PK Auto Increment)
   - `nama` (VARCHAR 150)
   - `email` (VARCHAR 150, UNIQUE)
   - `password` (VARCHAR 255)
   - `no_hp` (VARCHAR 20)
   - `role` (ENUM: `'admin'`, `'customer'`)
   - `created_at`, `updated_at` (DATETIME)
2. **`lapangan`** (Tabel Pendukung UTS)
   - `id` (INT PK Auto Increment)
   - `nama_lapangan` (VARCHAR 150)
   - `jenis_lantai` (VARCHAR 150)
   - `harga_per_jam` (INT)
   - `deskripsi` (VARCHAR 150)
   - `status` (VARCHAR 50: `'Tersedia'`, `'Tidak Aktif'`)
   - `gambar` (VARCHAR 255)
   - `created_at`, `updated_at` (DATETIME)
3. **`bookings`** (Tabel Utama UTS)
   - `id` (INT PK Auto Increment)
   - `kode_booking` (VARCHAR 50, UNIQUE)
   - `user_id` (INT FK -> `users.id`)
   - `lapangan_id` (INT FK -> `lapangan.id`)
   - `tanggal_booking` (DATE)
   - `jam_mulai` (TIME)
   - `durasi` (INT)
   - `total_harga` (INT)
   - `status` (VARCHAR 50: `'Pending'`, `'Dikonfirmasi'`, `'Selesai'`, `'Dibatalkan'`)
   - `catatan` (TEXT)
   - `created_at`, `updated_at` (DATETIME)
4. **`payments`**
   - `id` (INT PK Auto Increment)
   - `booking_id` (INT FK -> `bookings.id` ON DELETE CASCADE)
   - `metode_pembayaran` (VARCHAR 100)
   - `jumlah_pembayaran` (INT)
   - `status_pembayaran` (VARCHAR 50: `'Belum Dibayar'`, `'Menunggu Verifikasi'`, `'Dibayar'`, `'Ditolak'`)
   - `bukti_transfer` (VARCHAR 255)
   - `tanggal_pembayaran` (DATETIME)
   - `created_at`, `updated_at` (DATETIME)

---

## 🔑 Akun Demo Pengujian

| Peran | Alamat Email | Kata Sandi | Akses Hak |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@sportrent.test` | `Admin123!` | Kelola seluruh sistem, CRUD lapangan, CRUD booking, verifikasi bayar, laporan |
| **Customer 1** | `customer@sportrent.test` | `Customer123!` | Booking lapangan, lihat riwayat mandiri, batalkan pesanan |
| **Customer 2** | `iqbal@sportrent.test` | `Iqbal123!` | Akun uji coba atas nama Iqbal Galih Santoso |

*Catatan: Pelanggan baru juga dapat langsung membuat akun melalui menu **Daftar** pada website.*

---

## ⚡ Panduan Menjalankan Project

### A. Menggunakan Laragon (Rekomendasi)
1. Letakkan folder project di direktori root Laragon:
   `C:\laragon\www\SportRent`
2. Buka aplikasi Laragon, klik tombol **Start All** (Apache & MySQL).
3. Jika Laragon Auto Virtual Host aktif, buka peramban dan akses:
   `http://sportrent.test`
4. Alternatif Document Root langsung:
   `http://localhost/SportRent/public`

### B. Menggunakan CodeIgniter Spark CLI
Buka terminal PowerShell pada direktori `C:\laragon\www\SportRent`:
```bash
php spark serve
```
Akses melalui peramban: `http://localhost:8080`

### C. Import Database Manual (Jika Dibutuhkan)
Jika ingin mengimpor ulang database:
1. Buka phpMyAdmin di `http://localhost/phpmyadmin`
2. Buat database baru bernama `db_sport_rent`
3. Klik menu **Import**, pilih file: `database/db_sport_rent.sql`, lalu klik **Go**.
4. Atau jalankan perintah spark berikut di terminal:
   ```bash
   php spark migrate
   php spark db:seed DatabaseSeeder
   ```

### D. Menguji Logika Pemesanan (Testing CLI)
Jalankan pengujian deteksi bentrok jadwal dan kalkulasi sistem:
```bash
php spark test:schedule
```
Semua parameter akan terverifikasi dengan indikator status hijau `[PASS]`.

---

&copy; 2026 **SportRent** &bull; Iqbal Galih Santoso (24311147) &bull; Universitas Teknokrat Indonesia.
