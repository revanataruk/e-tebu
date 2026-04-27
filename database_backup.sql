-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for e_tebu_db
CREATE DATABASE IF NOT EXISTS `e_tebu_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `e_tebu_db`;

-- Dumping structure for table e_tebu_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table e_tebu_db.migrations: ~5 rows (approximately)
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(1, '2026-04-14-182817', 'App\\Database\\Migrations\\Pengguna', 'default', 'App', 1776191642, 1),
	(2, '2026-04-14-182822', 'App\\Database\\Migrations\\MusimTanam', 'default', 'App', 1776191747, 2),
	(3, '2026-04-14-182833', 'App\\Database\\Migrations\\KategoriAkun', 'default', 'App', 1776191747, 2),
	(4, '2026-04-14-182839', 'App\\Database\\Migrations\\Transaksi', 'default', 'App', 1776191747, 2),
	(5, '2026-04-14-182847', 'App\\Database\\Migrations\\BuktiTransaksi', 'default', 'App', 1776191747, 2);

-- Dumping structure for table e_tebu_db.tb_bukti_transaksi
CREATE TABLE IF NOT EXISTS `tb_bukti_transaksi` (
  `id_bukti` int unsigned NOT NULL AUTO_INCREMENT,
  `id_transaksi` int unsigned NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `path_file` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_bukti`),
  KEY `tb_bukti_transaksi_id_transaksi_foreign` (`id_transaksi`),
  CONSTRAINT `tb_bukti_transaksi_id_transaksi_foreign` FOREIGN KEY (`id_transaksi`) REFERENCES `tb_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table e_tebu_db.tb_bukti_transaksi: ~0 rows (approximately)

-- Dumping structure for table e_tebu_db.tb_kategori_akun
CREATE TABLE IF NOT EXISTS `tb_kategori_akun` (
  `id_kategori` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_biaya` enum('Tetap','Variabel') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipe_akun` enum('Pemasukan','Pengeluaran') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table e_tebu_db.tb_kategori_akun: ~0 rows (approximately)

-- Dumping structure for table e_tebu_db.tb_musim_tanam
CREATE TABLE IF NOT EXISTS `tb_musim_tanam` (
  `id_musim` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_musim` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_musim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table e_tebu_db.tb_musim_tanam: ~0 rows (approximately)

-- Dumping structure for table e_tebu_db.tb_pengguna
CREATE TABLE IF NOT EXISTS `tb_pengguna` (
  `id_user` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table e_tebu_db.tb_pengguna: ~0 rows (approximately)
INSERT INTO `tb_pengguna` (`id_user`, `username`, `password`, `nama_lengkap`) VALUES
	(1, 'admin', '12345', 'Pak Muzaki');

-- Dumping structure for table e_tebu_db.tb_transaksi
CREATE TABLE IF NOT EXISTS `tb_transaksi` (
  `id_transaksi` int unsigned NOT NULL AUTO_INCREMENT,
  `id_musim` int unsigned NOT NULL,
  `id_kategori` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `status_lunas` tinyint(1) NOT NULL DEFAULT '0',
  `jatuh_tempo` date DEFAULT NULL,
  `jenis_pembayaran` enum('Tunai','Kredit') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `tb_transaksi_id_musim_foreign` (`id_musim`),
  KEY `tb_transaksi_id_kategori_foreign` (`id_kategori`),
  CONSTRAINT `tb_transaksi_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `tb_kategori_akun` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_transaksi_id_musim_foreign` FOREIGN KEY (`id_musim`) REFERENCES `tb_musim_tanam` (`id_musim`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table e_tebu_db.tb_transaksi: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
