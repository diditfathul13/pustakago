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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku`
--

LOCK TABLES `buku` WRITE;
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` VALUES (5,'978-602-291-662-8','laskar pelangi','Novel','Andrea Hirata',NULL,10,NULL,'1776751712_24a92115e01b7b450028.jpg'),(6,'978-602-7870-41-3','dilan 1990','Romance','pidi baiq',NULL,10,'bucin','1776753450_104956deea6e25280779.jpg'),(8,'1234','Lorong keramat','Horor','raafi ahmad',NULL,10,NULL,'1776797878_a9c1fbc1670229a71d71.jpg'),(9,'978-602-7870-41-3','sejarah indonesia','Sejarah','sukarno hatta',10,10,'penjajahan','1776964860_d36a3646610e8400a9ca.jpg'),(10,'978-979-061-862-6','Manajemen Risiko Perusahaan: Prinsip, Penerapan, dan Penelitian (Edisi 3)','manajemen','Bambang Rianto Rustam',10,10,'','1776967453_eef0a4bbd284a714c51d.jpg'),(11,'978-602-1232-47-7','Manajemen Keuangan','manajemen','Erna Chotidjah Suhatmi, SE., M.Ak.',10,10,'Keuangan / Akuntansi','1776967552_fa6795053f0fbc4fbfcf.jpg'),(12,'978-623-7343-51-6','Manajemen Waktu','manajemen','Tsamrotul Ilmi',10,10,'Self-Improvement / Pengembangan Diri','1776967654_d08a24803d087df5fbfb.png'),(13,'978-623-02-1533-9','anajemen Bisnis Berbasis Teknologi Digital','manajemen','Dr. Ir. H. R. Zulki Zulkifli Noor, S.H., M.H., M.M.',10,10,'Bisnis / Teknologi','1776967746_3909e6a2dd00f7ae4db6.jpg');
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
  `denda` int(11) NOT NULL,
  `bukti_bayar` varchar(225) NOT NULL,
  `status_bayar` enum('belum','proses','lunas','') NOT NULL,
  `status` enum('pending','dipinjam','menunggu_kembali','kembali') DEFAULT 'dipinjam',
  `pesan_admin` text DEFAULT NULL,
  PRIMARY KEY (`id_pinjam`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` VALUES (2,2,'obett suka sholat','2026-04-20','2026-04-20',0,'','belum','',NULL),(3,2,'obett suka sholat','2026-04-20','2026-04-20',0,'','belum','',NULL),(4,2,'obett suka sholat','2026-04-20','2026-04-20',0,'','belum','',NULL),(5,3,'obett suka sholat','2026-04-20','2026-04-20',0,'','belum','',NULL),(6,2,'Didit Admin','2026-04-20','2026-04-20',0,'','belum','',NULL),(7,2,'Didit Admin','2026-04-20','2026-04-20',0,'','belum','',NULL),(8,4,'Didit Admin','2026-04-21','2026-04-21',0,'','belum','',NULL),(9,4,'Didit Admin','2026-04-21','2026-04-21',0,'','belum','',NULL),(52,7,'Rendi Pehul','2026-04-23','2026-04-21',10000,'1776927414_17670bf4fb37fd7e62d9.png','lunas','kembali',NULL),(70,9,'Rendi Pehul','2026-04-25','2026-04-23',10000,'1777142753_07fa2a4577b3193ca655.jpg','lunas','kembali',NULL),(71,13,'Rendi Pehul','2026-04-25','2026-04-23',10000,'1777143541_140507227979026fa28d.jpg','lunas','kembali','kudu mayar cebannn'),(72,9,'Rendi Pehul','2026-04-25','2026-04-24',10000,'','belum','dipinjam','gewat mayar bisi di ontrog');
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (13,'Didit Fathul','','didit14','admin','$2y$10$W53a5X9vnQq35kF7fMZpHOaDfC0cYQtuGeuEtvjWv4O1S9oLE8w8O','1776715967_2c2d7e73219882c2d27c.jpg'),(14,'dadan ramdan','','dadan','user','$2y$10$AtuYu.E8M4d/LF93UxafF.wg6HDMoUrrZ.MRfl19QLD7MHcS7Fg7i','1776715868_b07a88354bcb6c45edcb.jpg'),(16,'Rendi Pehul','','pehul','user','$2y$10$Hh5g2Nzoh3NAmDyydS/uReyPTsU8HtVDfAkZk73jF2NwwgXrQ7O6i','1776837600_a307f7cab9fd6ac6f4f2.jpg');
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

-- Dump completed on 2026-04-26 18:04:06
