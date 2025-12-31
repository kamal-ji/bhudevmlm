-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 10, 2025 at 08:37 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-external_api_token', 's:433:\"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJjbG91ZGVycCIsImp0aSI6IngvUWpEN1l0ZmZBeVdCYjJpZS9rZ1hwSG9iUU5wUDhlNFRzMDFuay9GSHJEWmlvUk1DUzFBZ0hSb3JMVUkvMXVhZ3VBcWZzQzNBeDlFcTdLS3ZoeUFBPT0iLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3JvbGUiOiJBZG1pbiIsImV4cCI6MTc2MDA5MDA3MCwiaXNzIjoiaHR0cDovL2xvY2FsaG9zdDo2MTk1NSIsImF1ZCI6Imh0dHA6Ly9sb2NhbGhvc3Q6NDIwMCJ9.5NiBP1dv1tY2FgKTXV2idGgLhQWl_a8T0mkI2Uuetg4\";', 1760079441),
('laravel-cache-companySettings', 'a:19:{s:12:\"api_base_url\";s:30:\"https://erp.tiarasoftwares.in/\";s:4:\"name\";s:7:\"Tiarass\";s:5:\"appid\";s:12:\"Tiara_Falcon\";s:9:\"image_url\";s:50:\"https://tiarasoftwares.co.in/uploads/client/tiara/\";s:8:\"logo_url\";s:58:\"https://tiarasoftwares.co.in/uploads/client/tiara/logo.png\";s:20:\"firebase_auth_domain\";s:27:\"tiara-adb0a.firebaseapp.com\";s:14:\"firbase_apiKey\";s:39:\"AIzaSyCCpefxXHckoxYQfEFEI0qpVokZ5HCRGMI\";s:9:\"copyright\";s:10:\"Tiara@2025\";s:8:\"x-apikey\";s:88:\"x/QjD7YtffAyWBb2ie/kgXpHobQNpP8e4Ts01nk/FHrDZioRMCS1AgHRorLUI/1uaguAqfsC3Ax9Eq7KKvhyAA==\";s:4:\"uuid\";s:36:\"0bb9497b-2681-49df-95d7-fbe44c983876\";s:8:\"db_state\";s:6:\"online\";s:7:\"emailid\";s:24:\"naren@tiarasoftwares.com\";s:8:\"username\";s:8:\"clouderp\";s:8:\"password\";s:6:\"123456\";s:19:\"firebase_project_id\";s:11:\"tiara-adb0a\";s:23:\"firebase_storage_bucket\";s:31:\"tiara-adb0a.firebasestorage.app\";s:28:\"firebase_messaging_sender_id\";s:12:\"424284680643\";s:15:\"firebase_app_id\";s:41:\"1:424284680643:web:8e3b6bc8067073cf0b8d76\";s:23:\"firebase_measurement_id\";s:12:\"G-B0FQY3FCD1\";}', 2075439343);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_settings`
--

DROP TABLE IF EXISTS `email_settings`;
CREATE TABLE IF NOT EXISTS `email_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `smtp_host` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_port` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_encryption` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_settings`
--

INSERT INTO `email_settings` (`id`, `smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `smtp_encryption`, `from_address`, `from_name`, `created_at`, `updated_at`) VALUES
(1, 'smtp.mailtrap.io', '587', 'your_smtp_username', 'your_smtp_password', 'tls', 'example@domain.com', 'Your Application Name', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_27_110720_create_settings_table', 2),
(5, '2025_09_27_110755_create_settings_table', 3),
(6, '2025_10_01_073715_create_email_settings_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CM6JZlvXt2XhfZu9Bg16i1mQd42b8gW90vytywSY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiRUxaNGJUQWczNHJxU2p3SGdKbHVLVWlsbFNjVGpZTmc4OFZZTWZ0cCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMzoiZXh0ZXJuYWxfdXNlciI7YTo4OntzOjI6ImlkIjtpOjMxNjtzOjk6ImNvbXBhbnlpZCI7aToxO3M6MTI6ImNvbXBhbnlfdXVpZCI7czozNjoiZDliYzEyZjktNjU4OS00ZDRhLThkNTEtOTQyNGQ5OWU1ODA2IjtzOjQ6Im5hbWUiO3M6MTI6IkthbWFsIFNoYXJtYSI7czo0OiJyb2xlIjtzOjQ6InVzZXIiO3M6NToiZW1haWwiO3M6MjA6ImthbWFsamkwMTBAZ21haWwuY29tIjtzOjY6InJvbGVpZCI7aToxO3M6NToiaW1hZ2UiO3M6MDoiIjt9czoxMzoiYXV0aGVudGljYXRlZCI7YjoxO3M6MTA6ImxvZ2luX3RpbWUiO086MjU6IklsbHVtaW5hdGVcU3VwcG9ydFxDYXJib24iOjM6e3M6NDoiZGF0ZSI7czoyNjoiMjAyNS0xMC0xMCAwNTo0NjowMi44MDI2MjciO3M6MTM6InRpbWV6b25lX3R5cGUiO2k6MztzOjg6InRpbWV6b25lIjtzOjM6IlVUQyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvY3VzdG9tZXJzIjt9fQ==', 1760079343);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(555) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'api_base_url', 'https://erp.tiarasoftwares.in/', '2025-09-27 11:11:40', NULL),
(2, 'name', 'Tiarass', '2025-09-27 11:11:40', '2025-10-01 01:02:00'),
(3, 'appid', 'Tiara_Falcon', '2025-09-27 11:11:40', NULL),
(4, 'image_url', 'https://tiarasoftwares.co.in/uploads/client/tiara/', '2025-09-27 11:11:40', NULL),
(5, 'logo_url', 'https://tiarasoftwares.co.in/uploads/client/tiara/logo.png', '2025-09-27 11:11:40', NULL),
(19, 'firebase_auth_domain', 'tiara-adb0a.firebaseapp.com', '2025-10-01 06:58:03', NULL),
(18, 'firbase_apiKey', 'AIzaSyCCpefxXHckoxYQfEFEI0qpVokZ5HCRGMI', '2025-10-01 06:58:03', NULL),
(10, 'copyright', 'Tiara@2025', '2025-09-27 11:11:40', NULL),
(11, 'x-apikey', 'x/QjD7YtffAyWBb2ie/kgXpHobQNpP8e4Ts01nk/FHrDZioRMCS1AgHRorLUI/1uaguAqfsC3Ax9Eq7KKvhyAA==', '2025-09-27 11:11:40', NULL),
(12, 'uuid', '0bb9497b-2681-49df-95d7-fbe44c983876', NULL, NULL),
(13, 'db_state', 'online', NULL, NULL),
(14, 'emailid', 'naren@tiarasoftwares.com', NULL, NULL),
(15, 'username', 'clouderp', NULL, NULL),
(16, 'password', '123456', NULL, NULL),
(20, 'firebase_project_id', 'tiara-adb0a', '2025-10-01 06:58:03', NULL),
(21, 'firebase_storage_bucket', 'tiara-adb0a.firebasestorage.app', '2025-10-01 06:58:03', NULL),
(22, 'firebase_messaging_sender_id', '424284680643', '2025-10-01 06:58:03', NULL),
(23, 'firebase_app_id', '1:424284680643:web:8e3b6bc8067073cf0b8d76', '2025-10-01 06:58:03', NULL),
(24, 'firebase_measurement_id', 'G-B0FQY3FCD1', '2025-10-01 06:58:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
