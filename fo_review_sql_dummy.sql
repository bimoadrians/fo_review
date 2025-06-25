-- --------------------------------------------------------
-- Host:                         192.168.10.100
-- Server version:               8.0.42-0ubuntu0.24.04.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_sahabat_unggul
CREATE DATABASE IF NOT EXISTS `db_sahabat_unggul` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_sahabat_unggul`;

-- Dumping structure for table db_sahabat_unggul.fo_review_d
CREATE TABLE IF NOT EXISTS `fo_review_d` (
  `rev_id` bigint NOT NULL,
  `rev_proc_id` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `rev_ss` double DEFAULT NULL COMMENT 'Sample Size',
  `rev_rej` double DEFAULT NULL COMMENT 'Reject',
  `rev_avgppm` double DEFAULT NULL COMMENT 'Average PPM',
  `rev_seam` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `rev_spi` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `rev_dim` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL COMMENT 'Dimention',
  `rev_oth` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL COMMENT 'Others',
  `rev_act` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL COMMENT 'Action',
  `rev_c_aes` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `rev_c_func` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `rev_c_dim` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `rev_c_stat` double DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_id` bigint DEFAULT NULL,
  `mod_date` datetime DEFAULT NULL,
  `mod_id` bigint DEFAULT NULL,
  PRIMARY KEY (`rev_id`,`rev_proc_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_sahabat_unggul.fo_review_d: ~11 rows (approximately)

-- Dumping structure for table db_sahabat_unggul.fo_review_dc
CREATE TABLE IF NOT EXISTS `fo_review_dc` (
  `rev_id` bigint NOT NULL,
  `rev_proc_id` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `rev_proc` varchar(255) COLLATE utf8mb3_bin DEFAULT NULL,
  `rev_mc` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `rev_seam` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `rev_spi` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `rev_dim` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL COMMENT 'Dimention',
  `rev_oth` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL COMMENT 'Others',
  `rev_act` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL COMMENT 'Action',
  `rev_c_aes` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `rev_c_func` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `rev_c_dim` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `rev_c_stat` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `add_id` bigint DEFAULT NULL,
  `mod_date` datetime DEFAULT NULL,
  `mod_id` bigint DEFAULT NULL,
  PRIMARY KEY (`rev_id`,`rev_proc_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_sahabat_unggul.fo_review_dc: ~5 rows (approximately)

-- Dumping structure for table db_sahabat_unggul.fo_review_h
CREATE TABLE IF NOT EXISTS `fo_review_h` (
  `rev_id` bigint NOT NULL AUTO_INCREMENT,
  `rev_avgppm` double DEFAULT NULL COMMENT 'Average PPM',
  `rev_date` date NOT NULL,
  `rev_line` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `rev_group` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `rev_part` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `rev_by` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL COMMENT 'Review By',
  `rev_stage` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL COMMENT 'PP/PS',
  `rev_ss` double DEFAULT NULL COMMENT 'Sample Size',
  `rev_rej` double DEFAULT NULL COMMENT 'Reject',
  `add_date` datetime DEFAULT NULL,
  `add_id` bigint DEFAULT NULL,
  `mod_date` datetime DEFAULT NULL,
  `mod_id` bigint DEFAULT NULL,
  PRIMARY KEY (`rev_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_sahabat_unggul.fo_review_h: ~1 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
