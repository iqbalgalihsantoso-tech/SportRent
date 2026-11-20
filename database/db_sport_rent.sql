-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_sport_rent
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `db_sport_rent`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `db_sport_rent` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `db_sport_rent`;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kode_booking` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int unsigned NOT NULL,
  `lapangan_id` int unsigned NOT NULL,
  `tanggal_booking` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `durasi` int NOT NULL,
  `total_harga` int NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `catatan` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_booking` (`kode_booking`),
  KEY `bookings_user_id_foreign` (`user_id`),
  KEY `bookings_lapangan_id_foreign` (`lapangan_id`),
  CONSTRAINT `bookings_lapangan_id_foreign` FOREIGN KEY (`lapangan_id`) REFERENCES `lapangan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES (1,'BK-202611-0001',2,1,'2026-11-19','16:00:00',2,200000,'Dikonfirmasi','Latihan tim rutin','2026-11-19 23:08:26','2026-11-19 23:08:26'),(2,'BK-202611-0002',3,2,'2026-11-20','19:00:00',1,120000,'Pending','Fun match mingguan','2026-11-19 23:08:26','2026-11-19 23:08:26');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lapangan`
--

DROP TABLE IF EXISTS `lapangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lapangan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_lapangan` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_lantai` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `harga_per_jam` int NOT NULL,
  `deskripsi` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Tersedia',
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lapangan`
--

LOCK TABLES `lapangan` WRITE;
/*!40000 ALTER TABLE `lapangan` DISABLE KEYS */;
INSERT INTO `lapangan` VALUES (1,'Lapangan A - Sintetis Pro','Rumput Sintetis',100000,'Lapangan rumput sintetis standar FIFA monofilament dengan pencahayaan LED terang dan jaring pengaman lengkap.','Tersedia','lapangan-sintetis.jpg','2026-11-19 23:08:26','2026-11-19 23:08:26'),(2,'Lapangan B - Vinyl Tournament','Vinyl',120000,'Lantai vinyl shock absorption berkualitas tinggi untuk kelincahan dan kenyamanan pergerakan kaki pemain.','Tersedia','lapangan-vinyl.jpg','2026-11-19 23:08:26','2026-11-19 23:08:26'),(3,'Lapangan C - Interlock Premier','Interlock',150000,'Lapangan modular interlock berstandar kejuaraan nasional dengan grip maksimal dan sirkulasi udara sejuk.','Tersedia','lapangan-interlock.jpg','2026-11-19 23:08:26','2026-11-19 23:08:26');
/*!40000 ALTER TABLE `lapangan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026-11-19-000001','App\\Database\\Migrations\\CreateUsersTable','default','App',1795104468,1),(2,'2026-11-19-000002','App\\Database\\Migrations\\CreateLapanganTable','default','App',1795104468,1),(3,'2026-11-19-000003','App\\Database\\Migrations\\CreateBookingsTable','default','App',1795104468,1),(4,'2026-11-19-000004','App\\Database\\Migrations\\CreatePaymentsTable','default','App',1795104468,1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` int unsigned NOT NULL,
  `metode_pembayaran` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_pembayaran` int NOT NULL,
  `status_pembayaran` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Menunggu Verifikasi',
  `bukti_transfer` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_pembayaran` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_booking_id_foreign` (`booking_id`),
  CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,'Transfer Bank BCA',200000,'Dibayar','sample-transfer.jpg','2026-11-19 23:08:26','2026-11-19 23:08:26','2026-11-19 23:08:26'),(2,2,'QRIS',120000,'Menunggu Verifikasi','sample-qris.jpg','2026-11-19 23:08:26','2026-11-19 23:08:26','2026-11-19 23:08:26');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('admin','customer') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'customer',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator SportRent','admin@sportrent.test','$2y$10$SS64B9Lz2HqZaql1rdrHx.yvVFg8TWHupilesFu8LOJhbT3TgDVjK','081234567890','admin','2026-11-19 23:08:26','2026-11-19 23:08:26'),(2,'Budi Santoso','customer@sportrent.test','$2y$10$xYVZHStQmdCpKQ0Oalz7Ju8nfFBx17jOJ/CO87aiZDdBUlr0KRu/6','082198765432','customer','2026-11-19 23:08:26','2026-11-19 23:08:26'),(3,'Iqbal Galih Santoso','iqbal@sportrent.test','$2y$10$Fh7Lzx2fV49o.vQX6CFskOBKHwMBV7Znn3gdfvzsJMOY6JaqH36je','089876543210','customer','2026-11-19 23:08:26','2026-11-19 23:08:26');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-19 23:38:45
