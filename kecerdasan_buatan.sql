/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.2.2-MariaDB, for Android (aarch64)
--
-- Host: 127.0.0.1    Database: kecerdasan_buatan
-- ------------------------------------------------------
-- Server version	12.2.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `buildings`
--

DROP TABLE IF EXISTS `buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `buildings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buildings`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `buildings` WRITE;
/*!40000 ALTER TABLE `buildings` DISABLE KEYS */;
INSERT INTO `buildings` VALUES
(1,'GEDUNG C','2026-05-28 01:03:18','2026-05-28 01:03:18');
/*!40000 ALTER TABLE `buildings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES
('laravel-cache-boost:mcp:database-schema:mysql::1:0:0:0','a:2:{s:6:\"engine\";s:5:\"mysql\";s:6:\"tables\";a:18:{s:9:\"buildings\";a:4:{s:2:\"id\";s:19:\"bigint(20) unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:5:\"cache\";a:3:{s:3:\"key\";s:12:\"varchar(255)\";s:5:\"value\";s:10:\"mediumtext\";s:10:\"expiration\";s:10:\"bigint(20)\";}s:11:\"cache_locks\";a:3:{s:3:\"key\";s:12:\"varchar(255)\";s:5:\"owner\";s:12:\"varchar(255)\";s:10:\"expiration\";s:10:\"bigint(20)\";}s:7:\"courses\";a:7:{s:2:\"id\";s:19:\"bigint(20) unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:4:\"code\";s:12:\"varchar(255)\";s:3:\"sks\";s:7:\"int(11)\";s:4:\"type\";s:20:\"enum(\'theory\',\'lab\')\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:16:\"course_offerings\";a:9:{s:2:\"id\";s:19:\"bigint(20) unsigned\";s:9:\"course_id\";s:19:\"bigint(20) unsigned\";s:11:\"lecturer_id\";s:19:\"bigint(20) unsigned\";s:7:\"room_id\";s:19:\"bigint(20) unsigned\";s:3:\"sks\";s:7:\"int(11)\";s:4:\"type\";s:20:\"enum(\'theory\',\'lab\')\";s:4:\"name\";s:12:\"varchar(255)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:4:\"days\";a:4:{s:2:\"id\";s:19:\"bigint(20) unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:11:\"failed_jobs\";a:7:{s:2:\"id\";s:19:\"bigint(20) unsigned\";s:4:\"uuid\";s:12:\"varchar(255)\";s:10:\"connection\";s:12:\"varchar(255)\";s:5:\"queue\";s:12:\"varchar(255)\";s:7:\"payload\";s:8:\"longtext\";s:9:\"exception\";s:8:\"longtext\";s:9:\"failed_at\";s:9:\"timestamp\";}s:4:\"jobs\";a:7:{s:2:\"id\";s:19:\"bigint(20) unsigned\";s:5:\"queue\";s:12:\"varchar(255)\";s:7:\"payload\";s:8:\"longtext\";s:8:\"attempts\";s:20:\"smallint(5) unsigned\";s:11:\"reserved_at\";s:16:\"int(10) unsigned\";s:12:\"available_at\";s:16:\"int(10) unsigned\";s:10:\"created_at\";s:16:\"int(10) unsigned\";}s:11:\"job_batches\";a:10:{s:2:\"id\";s:12:\"varchar(255)\";s:4:\"name\";s:12:\"varchar(255)\";s:10:\"total_jobs\";s:7:\"int(11)\";s:12:\"pending_jobs\";s:7:\"int(11)\";s:11:\"failed_jobs\";s:7:\"int(11)\";s:14:\"failed_job_ids\";s:8:\"longtext\";s:7:\"options\";s:10:\"mediumtext\";s:12:\"cancelled_at\";s:7:\"int(11)\";s:10:\"created_at\";s:7:\"int(11)\";s:11:\"finished_at\";s:7:\"int(11)\";}s:9:\"lecturers\";a:5:{s:2:\"id\";s:19:\"bigint(20) unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:3:\"nip\";s:12:\"varchar(255)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:10:\"migrations\";a:3:{s:2:\"id\";s:16:\"int(10) unsigned\";s:9:\"migration\";s:12:\"varchar(255)\";s:5:\"batch\";s:7:\"int(11)\";}s:21:\"password_reset_tokens\";a:3:{s:5:\"email\";s:12:\"varchar(255)\";s:5:\"token\";s:12:\"varchar(255)\";s:10:\"created_at\";s:9:\"timestamp\";}s:5:\"rooms\";a:6:{s:2:\"id\";s:19:\"bigint(20) unsigned\";s:11:\"building_id\";s:19:\"bigint(20) unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:4:\"type\";s:20:\"enum(\'theory\',\'lab\')\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:9:\"schedules\";a:8:{s:2:\"id\";s:19:\"bigint(20) unsigned\";s:18:\"course_offering_id\";s:19:\"bigint(20) unsigned\";s:7:\"room_id\";s:19:\"bigint(20) unsigned\";s:6:\"day_id\";s:19:\"bigint(20) unsigned\";s:18:\"start_time_slot_id\";s:19:\"bigint(20) unsigned\";s:8:\"batch_id\";s:12:\"varchar(255)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:8:\"sessions\";a:6:{s:2:\"id\";s:12:\"varchar(255)\";s:7:\"user_id\";s:19:\"bigint(20) unsigned\";s:10:\"ip_address\";s:11:\"varchar(45)\";s:10:\"user_agent\";s:4:\"text\";s:7:\"payload\";s:8:\"longtext\";s:13:\"last_activity\";s:7:\"int(11)\";}s:8:\"settings\";a:5:{s:2:\"id\";s:19:\"bigint(20) unsigned\";s:3:\"key\";s:12:\"varchar(255)\";s:5:\"value\";s:8:\"longtext\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:10:\"time_slots\";a:6:{s:2:\"id\";s:19:\"bigint(20) unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:10:\"start_time\";s:4:\"time\";s:8:\"end_time\";s:4:\"time\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:5:\"users\";a:8:{s:2:\"id\";s:19:\"bigint(20) unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:5:\"email\";s:12:\"varchar(255)\";s:17:\"email_verified_at\";s:9:\"timestamp\";s:8:\"password\";s:12:\"varchar(255)\";s:14:\"remember_token\";s:12:\"varchar(100)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}}}',1779958874),
('laravel-cache-boost:mcp:database-schema:mysql:course_offerings:0:0:0:0','a:2:{s:6:\"engine\";s:5:\"mysql\";s:6:\"tables\";a:1:{s:16:\"course_offerings\";a:5:{s:7:\"columns\";a:9:{s:2:\"id\";a:1:{s:4:\"type\";s:19:\"bigint(20) unsigned\";}s:9:\"course_id\";a:1:{s:4:\"type\";s:19:\"bigint(20) unsigned\";}s:11:\"lecturer_id\";a:1:{s:4:\"type\";s:19:\"bigint(20) unsigned\";}s:7:\"room_id\";a:1:{s:4:\"type\";s:19:\"bigint(20) unsigned\";}s:3:\"sks\";a:1:{s:4:\"type\";s:7:\"int(11)\";}s:4:\"type\";a:1:{s:4:\"type\";s:20:\"enum(\'theory\',\'lab\')\";}s:4:\"name\";a:1:{s:4:\"type\";s:12:\"varchar(255)\";}s:10:\"created_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}s:10:\"updated_at\";a:1:{s:4:\"type\";s:9:\"timestamp\";}}s:7:\"indexes\";a:4:{s:34:\"course_offerings_course_id_foreign\";a:4:{s:7:\"columns\";a:1:{i:0;s:9:\"course_id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:36:\"course_offerings_lecturer_id_foreign\";a:4:{s:7:\"columns\";a:1:{i:0;s:11:\"lecturer_id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:32:\"course_offerings_room_id_foreign\";a:4:{s:7:\"columns\";a:1:{i:0;s:7:\"room_id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}}s:12:\"foreign_keys\";a:3:{i:0;a:7:{s:4:\"name\";s:34:\"course_offerings_course_id_foreign\";s:7:\"columns\";a:1:{i:0;s:9:\"course_id\";}s:14:\"foreign_schema\";s:17:\"kecerdasan_buatan\";s:13:\"foreign_table\";s:7:\"courses\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:8:\"restrict\";s:9:\"on_delete\";s:7:\"cascade\";}i:1;a:7:{s:4:\"name\";s:36:\"course_offerings_lecturer_id_foreign\";s:7:\"columns\";a:1:{i:0;s:11:\"lecturer_id\";}s:14:\"foreign_schema\";s:17:\"kecerdasan_buatan\";s:13:\"foreign_table\";s:9:\"lecturers\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:8:\"restrict\";s:9:\"on_delete\";s:7:\"cascade\";}i:2;a:7:{s:4:\"name\";s:32:\"course_offerings_room_id_foreign\";s:7:\"columns\";a:1:{i:0;s:7:\"room_id\";}s:14:\"foreign_schema\";s:17:\"kecerdasan_buatan\";s:13:\"foreign_table\";s:5:\"rooms\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:8:\"restrict\";s:9:\"on_delete\";s:7:\"cascade\";}}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}}}',1779962128),
('laravel-cache-boost:mcp:database-schema:mysql:course_offerings:0:0:0:1','a:2:{s:6:\"engine\";s:5:\"mysql\";s:6:\"tables\";a:1:{s:16:\"course_offerings\";a:5:{s:7:\"columns\";a:9:{s:2:\"id\";a:4:{s:4:\"type\";s:19:\"bigint(20) unsigned\";s:8:\"nullable\";b:0;s:7:\"default\";N;s:14:\"auto_increment\";b:1;}s:9:\"course_id\";a:4:{s:4:\"type\";s:19:\"bigint(20) unsigned\";s:8:\"nullable\";b:0;s:7:\"default\";N;s:14:\"auto_increment\";b:0;}s:11:\"lecturer_id\";a:4:{s:4:\"type\";s:19:\"bigint(20) unsigned\";s:8:\"nullable\";b:0;s:7:\"default\";N;s:14:\"auto_increment\";b:0;}s:7:\"room_id\";a:4:{s:4:\"type\";s:19:\"bigint(20) unsigned\";s:8:\"nullable\";b:1;s:7:\"default\";s:4:\"NULL\";s:14:\"auto_increment\";b:0;}s:3:\"sks\";a:4:{s:4:\"type\";s:7:\"int(11)\";s:8:\"nullable\";b:1;s:7:\"default\";s:4:\"NULL\";s:14:\"auto_increment\";b:0;}s:4:\"type\";a:4:{s:4:\"type\";s:20:\"enum(\'theory\',\'lab\')\";s:8:\"nullable\";b:1;s:7:\"default\";s:4:\"NULL\";s:14:\"auto_increment\";b:0;}s:4:\"name\";a:4:{s:4:\"type\";s:12:\"varchar(255)\";s:8:\"nullable\";b:1;s:7:\"default\";s:4:\"NULL\";s:14:\"auto_increment\";b:0;}s:10:\"created_at\";a:4:{s:4:\"type\";s:9:\"timestamp\";s:8:\"nullable\";b:1;s:7:\"default\";s:4:\"NULL\";s:14:\"auto_increment\";b:0;}s:10:\"updated_at\";a:4:{s:4:\"type\";s:9:\"timestamp\";s:8:\"nullable\";b:1;s:7:\"default\";s:4:\"NULL\";s:14:\"auto_increment\";b:0;}}s:7:\"indexes\";a:4:{s:34:\"course_offerings_course_id_foreign\";a:4:{s:7:\"columns\";a:1:{i:0;s:9:\"course_id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:36:\"course_offerings_lecturer_id_foreign\";a:4:{s:7:\"columns\";a:1:{i:0;s:11:\"lecturer_id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:32:\"course_offerings_room_id_foreign\";a:4:{s:7:\"columns\";a:1:{i:0;s:7:\"room_id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:0;s:10:\"is_primary\";b:0;}s:7:\"primary\";a:4:{s:7:\"columns\";a:1:{i:0;s:2:\"id\";}s:4:\"type\";s:5:\"btree\";s:9:\"is_unique\";b:1;s:10:\"is_primary\";b:1;}}s:12:\"foreign_keys\";a:3:{i:0;a:7:{s:4:\"name\";s:34:\"course_offerings_course_id_foreign\";s:7:\"columns\";a:1:{i:0;s:9:\"course_id\";}s:14:\"foreign_schema\";s:17:\"kecerdasan_buatan\";s:13:\"foreign_table\";s:7:\"courses\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:8:\"restrict\";s:9:\"on_delete\";s:7:\"cascade\";}i:1;a:7:{s:4:\"name\";s:36:\"course_offerings_lecturer_id_foreign\";s:7:\"columns\";a:1:{i:0;s:11:\"lecturer_id\";}s:14:\"foreign_schema\";s:17:\"kecerdasan_buatan\";s:13:\"foreign_table\";s:9:\"lecturers\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:8:\"restrict\";s:9:\"on_delete\";s:7:\"cascade\";}i:2;a:7:{s:4:\"name\";s:32:\"course_offerings_room_id_foreign\";s:7:\"columns\";a:1:{i:0;s:7:\"room_id\";}s:14:\"foreign_schema\";s:17:\"kecerdasan_buatan\";s:13:\"foreign_table\";s:5:\"rooms\";s:15:\"foreign_columns\";a:1:{i:0;s:2:\"id\";}s:9:\"on_update\";s:8:\"restrict\";s:9:\"on_delete\";s:7:\"cascade\";}}s:8:\"triggers\";a:0:{}s:17:\"check_constraints\";a:0:{}}}}',1779962134);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `course_offerings`
--

DROP TABLE IF EXISTS `course_offerings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_offerings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint(20) unsigned NOT NULL,
  `lecturer_id` bigint(20) unsigned NOT NULL,
  `room_id` bigint(20) unsigned DEFAULT NULL,
  `sks` int(11) DEFAULT NULL,
  `type` enum('theory','lab') DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_offerings_course_id_foreign` (`course_id`),
  KEY `course_offerings_lecturer_id_foreign` (`lecturer_id`),
  KEY `course_offerings_room_id_foreign` (`room_id`),
  CONSTRAINT `course_offerings_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_offerings_lecturer_id_foreign` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_offerings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_offerings`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `course_offerings` WRITE;
/*!40000 ALTER TABLE `course_offerings` DISABLE KEYS */;
INSERT INTO `course_offerings` VALUES
(5,4,5,NULL,3,'theory','Kesehatan Ternak (MARSELINUS HAMBAKODU S.Pt, M.Si)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(6,5,6,NULL,2,'theory','Etika Kristen dalam Bisnis (DESY ASNΑΤΗ SITANIAPESSY S.SI (Teol)., M.Si)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(7,6,5,NULL,3,'theory','Agrowisata Peternakan (MARSELINUS HAMBAKODU S.Pt, M.Si)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(8,7,7,NULL,3,'theory','Kebijakan Pembangunan Peternakan (IVEN PATU SIRAPPA S.Pt., M.Si)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(9,8,8,NULL,3,'theory','Ilmu Reproduksi Ternak (Dr. Ir. ALEXANDER KAKA S.Pt., M.Si)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(10,9,9,NULL,3,'theory','Teknologi dan Rekayasa Ilmu Pangan (YESSY TAMU INA SPt., MS.i)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(11,9,10,NULL,3,'theory','Teknologi dan Rekayasa Ilmu Pangan (YATRIS RAMBU TEGA S.Pi., M.P)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(12,10,5,NULL,3,'theory','Ekologi Sabana (MARSELINUS HAMBAKODU S.Pt, M.Si)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(13,8,11,NULL,3,'theory','Ilmu Reproduksi Ternak (ALEXANDER KAKA S.Pt., M.Si)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(14,11,2,NULL,4,'theory','Biokimia Ternak (AMELIA FLORIDA KIHA S.Pt., M.Sc)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(15,12,7,NULL,3,'theory','Perencanaan dan Evaluasi Peternakan (IVEN PATU SIRAPPA S.Pt., M.Si)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(16,13,12,NULL,3,'theory','Bahasa Inggris (SURYANI KURNIAWI KAHI LEBA КАРОЕ S.S.,M.Hum)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(17,14,1,NULL,3,'theory','Fisika Dasar (DENISIUS UMBU PATI SKM., M.Kes)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(18,15,7,NULL,3,'theory','Penyuluhan Pembangunan (IVEN PATU SIRAPPA S.Pt., M.Si)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(19,15,9,NULL,3,'theory','Penyuluhan Pembangunan (YESSY TAMU INA SPt., MS.i)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(20,16,11,NULL,3,'theory','Bioteknologi Reproduksi Mutakhir (ALEXANDER KAKA S.Pt., M.Si)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(21,17,9,NULL,3,'theory','Pengantar Ilmu dan Industri Peternakan (YESSY TAMU INA SPt., MS.i)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(22,18,13,NULL,3,'theory','Teknologi Pengolahan Pakan (I MADE ADI SUDARMA S.Pt., M.Si)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(23,19,14,NULL,2,'lab','Aplikasi Komputer (DENISIUS UMBU PATI SKM.,M.Kes)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(24,19,15,NULL,2,'lab','Aplikasi Komputer (TRI SARY DEWI NOVYANTI BERTHA MIRA S.T, M. Kom.)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(25,20,14,NULL,4,'lab','Statistika (DENISIUS UMBU PATI SKM.,M.Kes)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(26,20,2,NULL,4,'lab','Statistika (AMELIA FLORIDA KIHA S.Pt., M.Sc)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(27,21,13,NULL,4,'lab','Bahan Pakan dan Formulasi Ransum (I MADE ADI SUDARMA S.Pt., M.Si)','2026-05-28 01:03:19','2026-05-28 01:55:37'),
(28,1,1,NULL,2,'theory',NULL,'2026-05-28 01:44:46','2026-05-28 01:55:37'),
(29,2,2,NULL,3,'theory',NULL,'2026-05-28 01:47:26','2026-05-28 01:55:37'),
(30,22,4,NULL,2,'theory',NULL,'2026-05-28 01:49:28','2026-05-28 01:55:37');
/*!40000 ALTER TABLE `course_offerings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `sks` int(11) NOT NULL,
  `type` enum('theory','lab') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES
(1,'Kapita Selekta Sumba','MKW21 201',2,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(2,'Ilmu Kesuburan Tanah dan Pemupukan','PTK21 320',3,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(4,'Kesehatan Ternak','PTK21 209',3,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(5,'Etika Kristen dalam Bisnis','MKW21 106',2,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(6,'Agrowisata Peternakan','PTK21 315',3,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(7,'Kebijakan Pembangunan Peternakan','PTK21 307',3,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(8,'Ilmu Reproduksi Ternak','PTK21 208',3,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(9,'Teknologi dan Rekayasa Ilmu Pangan','PTK21 319',3,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(10,'Ekologi Sabana','PTK21 107',3,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(11,'Biokimia Ternak','PTK21 105',4,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(12,'Perencanaan dan Evaluasi Peternakan','PTK21 316',3,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(13,'Bahasa Inggris','PTK21 108',3,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(14,'Fisika Dasar','PTK21 102',3,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(15,'Penyuluhan Pembangunan','PTK21 306',3,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(16,'Bioteknologi Reproduksi Mutakhir','PTK21 317',3,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(17,'Pengantar Ilmu dan Industri Peternakan','PTK21 106',3,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(18,'Teknologi Pengolahan Pakan','PTK21 313',3,'theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(19,'Aplikasi Komputer','PTK21 310',2,'lab','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(20,'Statistika','PTK21 210',4,'lab','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(21,'Bahan Pakan dan Formulasi Ransum','PTK21 207',4,'lab','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(22,'Kewarganegaraan','MKW21 104',2,'theory','2026-05-28 01:49:28','2026-05-28 01:49:28');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `days`
--

DROP TABLE IF EXISTS `days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `days` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `days`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `days` WRITE;
/*!40000 ALTER TABLE `days` DISABLE KEYS */;
INSERT INTO `days` VALUES
(1,'Senin','2026-05-28 01:09:46','2026-05-28 01:09:46'),
(2,'Selasa','2026-05-28 01:09:47','2026-05-28 01:09:47'),
(3,'Rabu','2026-05-28 01:09:47','2026-05-28 01:09:47'),
(4,'Kamis','2026-05-28 01:09:47','2026-05-28 01:09:47'),
(5,'Jumat','2026-05-28 01:09:47','2026-05-28 01:09:47');
/*!40000 ALTER TABLE `days` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `lecturers`
--

DROP TABLE IF EXISTS `lecturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecturers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lecturers_nip_unique` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturers`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `lecturers` WRITE;
/*!40000 ALTER TABLE `lecturers` DISABLE KEYS */;
INSERT INTO `lecturers` VALUES
(1,'DENISIUS UMBU PATI SKM., M.Kes',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19'),
(2,'AMELIA FLORIDA KIHA S.Pt., M.Sc',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19'),
(3,'YONCE MELYANUS KILLA S.P., M. P',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19'),
(4,'ARIS UMBU HINA PARI S.AP., M.AP',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19'),
(5,'MARSELINUS HAMBAKODU S.Pt, M.Si',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19'),
(6,'DESY ASNΑΤΗ SITANIAPESSY S.SI (Teol)., M.Si',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19'),
(7,'IVEN PATU SIRAPPA S.Pt., M.Si',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19'),
(8,'Dr. Ir. ALEXANDER KAKA S.Pt., M.Si',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19'),
(9,'YESSY TAMU INA SPt., MS.i',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19'),
(10,'YATRIS RAMBU TEGA S.Pi., M.P',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19'),
(11,'ALEXANDER KAKA S.Pt., M.Si',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19'),
(12,'SURYANI KURNIAWI KAHI LEBA КАРОЕ S.S.,M.Hum',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19'),
(13,'I MADE ADI SUDARMA S.Pt., M.Si',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19'),
(14,'DENISIUS UMBU PATI SKM.,M.Kes',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19'),
(15,'TRI SARY DEWI NOVYANTI BERTHA MIRA S.T, M. Kom.',NULL,'2026-05-28 01:03:19','2026-05-28 01:03:19');
/*!40000 ALTER TABLE `lecturers` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_05_27_120506_create_university_scheduling_tables',1),
(5,'2026_05_27_122226_remove_email_from_lecturers_table',1),
(6,'2026_05_27_123138_create_buildings_table',1),
(7,'2026_05_27_123157_add_building_id_to_rooms_table',1),
(8,'2026_05_27_123556_remove_code_from_buildings_table',1),
(9,'2026_05_27_124230_remove_capacity_from_rooms_table',1),
(10,'2026_05_27_125522_add_room_id_to_course_offerings_table',1),
(11,'2026_05_27_131057_add_sks_and_type_to_course_offerings_table',1),
(12,'2026_05_27_131821_remove_unique_from_course_code',1),
(13,'2026_05_27_141023_create_settings_table',1),
(14,'2026_05_27_145354_add_sks_duration_to_settings',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `building_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('theory','lab') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rooms_building_id_foreign` (`building_id`),
  CONSTRAINT `rooms_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES
(2,1,'Ruang C 2.1','theory','2026-05-28 01:03:19','2026-05-28 01:03:19'),
(3,1,'Ruang LAB KOMPUTER C 2.3','lab','2026-05-28 01:03:19','2026-05-28 01:03:19');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_offering_id` bigint(20) unsigned NOT NULL,
  `room_id` bigint(20) unsigned NOT NULL,
  `day_id` bigint(20) unsigned NOT NULL,
  `start_time_slot_id` bigint(20) unsigned NOT NULL,
  `batch_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_course_offering_id_foreign` (`course_offering_id`),
  KEY `schedules_room_id_foreign` (`room_id`),
  KEY `schedules_day_id_foreign` (`day_id`),
  KEY `schedules_start_time_slot_id_foreign` (`start_time_slot_id`),
  KEY `schedules_batch_id_index` (`batch_id`),
  CONSTRAINT `schedules_course_offering_id_foreign` FOREIGN KEY (`course_offering_id`) REFERENCES `course_offerings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_day_id_foreign` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_start_time_slot_id_foreign` FOREIGN KEY (`start_time_slot_id`) REFERENCES `time_slots` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES
(1,5,2,2,9,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(2,6,2,5,2,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(3,7,2,4,12,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(4,8,2,2,6,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(5,9,2,4,6,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(6,10,2,1,10,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(7,11,2,5,7,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(8,12,2,5,4,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(9,13,2,2,2,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(10,14,2,3,5,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(11,15,2,5,13,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(12,16,2,1,1,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(13,17,2,4,1,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(14,18,2,2,13,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(15,19,2,3,12,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(16,20,2,1,6,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(17,21,2,5,10,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(18,22,2,4,9,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(19,23,3,5,9,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(20,24,3,3,9,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(21,25,3,5,11,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(22,26,3,5,1,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(23,27,3,3,5,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(24,28,2,1,14,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(25,29,2,3,1,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38'),
(26,30,2,3,10,'62da62e4-3834-48f4-bd5c-e2791d971ae0','2026-05-28 02:34:38','2026-05-28 02:34:38');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('8TQrQ2AmSqlpN1p9SP1vXHNdYwacOla6OB13bF7t',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJwYUplbmlFckxlZnZnRzQ0dmZoMzI2cVBWVG9Ra0lXWDJwdjBOYnR2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJzY2hlZHVsZXMuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1779964479);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`value`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES
(1,'active_days','[1,2,3,4,5]','2026-05-28 00:59:37','2026-05-28 00:59:37'),
(2,'operational_hours','{\"start\":\"07:00\",\"end\":\"22:40\"}','2026-05-28 00:59:37','2026-05-28 01:34:19'),
(3,'blackout_hours','[]','2026-05-28 00:59:37','2026-05-28 01:11:58'),
(4,'sks_duration','50','2026-05-28 00:59:37','2026-05-28 00:59:37');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `time_slots`
--

DROP TABLE IF EXISTS `time_slots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `time_slots` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_slots`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `time_slots` WRITE;
/*!40000 ALTER TABLE `time_slots` DISABLE KEYS */;
INSERT INTO `time_slots` VALUES
(1,'Slot 07:00','07:00:00','07:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00'),
(2,'Slot 08:00','08:00:00','08:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00'),
(3,'Slot 09:00','09:00:00','09:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00'),
(4,'Slot 10:00','10:00:00','10:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00'),
(5,'Slot 11:00','11:00:00','11:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00'),
(6,'Slot 12:00','12:00:00','12:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00'),
(7,'Slot 13:00','13:00:00','13:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00'),
(8,'Slot 14:00','14:00:00','14:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00'),
(9,'Slot 15:00','15:00:00','15:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00'),
(10,'Slot 16:00','16:00:00','16:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00'),
(11,'Slot 17:00','17:00:00','17:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00'),
(12,'Slot 18:00','18:00:00','18:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00'),
(13,'Slot 19:00','19:00:00','19:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00'),
(14,'Slot 20:00','20:00:00','20:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00'),
(15,'Slot 21:00','21:00:00','21:50:00','2026-05-28 02:13:00','2026-05-28 02:13:00');
/*!40000 ALTER TABLE `time_slots` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-05-28 18:45:24
