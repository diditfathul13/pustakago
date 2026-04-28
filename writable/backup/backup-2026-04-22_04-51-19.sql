-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: didit
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `buku`
--

DROP TABLE IF EXISTS `buku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `isbn` varchar(50) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `kategori` enum('Novel','Horor','Romance','Sains','Sejarah','manajemen') DEFAULT NULL,
  `penulis` varchar(255) DEFAULT NULL,
  `jumlah` int(11) DEFAULT 0,
  `tersedia` int(11) DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku`
--

LOCK TABLES `buku` WRITE;
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` VALUES (5,'978-602-291-662-8','laskar pelangi','Novel','Andrea Hirata',NULL,11,NULL,'1776751712_24a92115e01b7b450028.jpg'),(6,'978-602-7870-41-3','dilan 1990','Romance','pidi baiq',NULL,11,NULL,'1776753450_104956deea6e25280779.jpg'),(7,'978-602-225-300-6','Danur (atau Danur: Gerbang Dialog','Horor','Risa Saraswati',NULL,10,NULL,'1776754497_f6b09fbc43f01c4679ef.jpg'),(8,'1234','dilan 1990','Horor','milea',NULL,10,NULL,'1776797878_a9c1fbc1670229a71d71.jpg');
/*!40000 ALTER TABLE `buku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman`
--

DROP TABLE IF EXISTS `peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peminjaman` (
  `id_pinjam` int(11) NOT NULL AUTO_INCREMENT,
  `id_buku` int(11) NOT NULL,
  `nama_peminjam` varchar(255) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('pending','dipinjam','menunggu_kembali','kembali') DEFAULT 'dipinjam',
  PRIMARY KEY (`id_pinjam`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` VALUES (1,2,'Didit Fathul','2026-04-20','2026-04-20',''),(2,2,'obett suka sholat','2026-04-20','2026-04-20',''),(3,2,'obett suka sholat','2026-04-20','2026-04-20',''),(4,2,'obett suka sholat','2026-04-20','2026-04-20',''),(5,3,'obett suka sholat','2026-04-20','2026-04-20',''),(6,2,'Didit Admin','2026-04-20','2026-04-20',''),(7,2,'Didit Admin','2026-04-20','2026-04-20',''),(8,4,'Didit Admin','2026-04-21','2026-04-21',''),(9,4,'Didit Admin','2026-04-21','2026-04-21',''),(31,6,'dadan ramdan','2026-04-21','2026-04-24','kembali'),(32,7,'dadan ramdan','2026-04-21','2026-04-22','kembali'),(36,8,'dadan ramdan','2026-04-22','2026-04-25','kembali');
/*!40000 ALTER TABLE `peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` int(10) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `password` varchar(100) NOT NULL,
  `foto` text DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (12,'obett suka sholat','','obet','user','$2y$10$pMcc0U9weHQFgEK9avWlwO1oWjDVcdmkOD5iaeBMfAE6NbpwHbFiS','1776715999_f1dd1341abcaf0b3e82a.jpg'),(13,'Didit Fathul','','didit14','admin','$2y$10$W53a5X9vnQq35kF7fMZpHOaDfC0cYQtuGeuEtvjWv4O1S9oLE8w8O','1776715967_2c2d7e73219882c2d27c.jpg'),(14,'dadan ramdan','','dadan','user','$2y$10$AtuYu.E8M4d/LF93UxafF.wg6HDMoUrrZ.MRfl19QLD7MHcS7Fg7i','1776715868_b07a88354bcb6c45edcb.jpg');
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

-- Dump completed on 2026-04-22 11:51:21
