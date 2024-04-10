-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2024 at 10:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bsl_cmn_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bsl_cmn_logs`
--

CREATE TABLE `bsl_cmn_logs` (
  `bsl_cmn_logs_id` int(10) UNSIGNED NOT NULL,
  `bsl_cmn_logs_person` int(10) UNSIGNED NOT NULL,
  `bsl_cmn_logs_time` timestamp NULL DEFAULT NULL,
  `bsl_cmn_logs_mealtype` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bsl_cmn_logs`
--

INSERT INTO `bsl_cmn_logs` (`bsl_cmn_logs_id`, `bsl_cmn_logs_person`, `bsl_cmn_logs_time`, `bsl_cmn_logs_mealtype`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 1, '2024-04-01 09:58:21', '2024-04-01 09:58:21'),
(2, 2, NULL, 2, '2024-04-01 10:00:27', '2024-04-01 10:00:27'),
(3, 1, NULL, 2, '2024-04-01 18:13:17', '2024-04-01 18:13:17'),
(8, 3, NULL, 2, '2024-04-02 03:24:27', '2024-04-02 03:24:27'),
(9, 4, NULL, 1, '2024-04-02 05:09:21', '2024-04-02 05:09:21'),
(26, 1, '2024-04-05 12:49:45', 1, '2024-04-05 12:49:45', '2024-04-05 12:49:45'),
(27, 1, '2024-04-05 13:15:50', 2, '2024-04-05 13:15:50', '2024-04-05 13:15:50'),
(34, 1, '2024-04-06 23:00:12', 2, '2024-04-06 23:00:12', '2024-04-06 23:00:12'),
(35, 1, '2024-04-06 23:00:19', 2, '2024-04-06 23:00:19', '2024-04-06 23:00:19'),
(36, 1, '2024-04-06 23:00:26', 2, '2024-04-06 23:00:26', '2024-04-06 23:00:26'),
(37, 1, '2024-04-06 23:00:31', 2, '2024-04-06 23:00:31', '2024-04-06 23:00:31'),
(38, 1, '2024-04-06 23:01:05', 1, '2024-04-06 23:01:05', '2024-04-06 23:01:05'),
(39, 1, '2024-04-06 23:01:11', 1, '2024-04-06 23:01:11', '2024-04-06 23:01:11'),
(40, 1, '2024-04-06 23:10:40', 1, '2024-04-06 23:10:40', '2024-04-06 23:10:40'),
(41, 1, '2024-04-08 00:03:43', 1, '2024-04-08 00:03:43', '2024-04-08 00:03:43'),
(42, 1, '2024-04-08 00:04:00', 2, '2024-04-08 00:04:00', '2024-04-08 00:04:00'),
(43, 1, '2024-04-08 08:41:44', 1, '2024-04-08 08:41:44', '2024-04-08 08:41:44'),
(44, 22, '2024-04-09 12:17:39', 1, '2024-04-09 12:17:39', '2024-04-09 12:17:39'),
(45, 22, '2024-04-09 12:18:34', 2, '2024-04-09 12:18:34', '2024-04-09 12:18:34'),
(48, 1, '2024-04-09 14:01:02', 1, '2024-04-09 14:01:02', '2024-04-09 14:01:02'),
(49, 1, '2024-04-09 14:02:23', 1, '2024-04-09 14:02:23', '2024-04-09 14:02:23'),
(50, 1, '2024-04-09 14:02:59', 1, '2024-04-09 14:02:59', '2024-04-09 14:02:59'),
(51, 1, '2024-04-09 14:07:21', 1, '2024-04-09 14:07:21', '2024-04-09 14:07:21'),
(52, 1, '2024-04-09 14:13:45', 1, '2024-04-09 14:13:45', '2024-04-09 14:13:45'),
(53, 1, '2024-04-09 14:28:00', 1, '2024-04-09 14:28:00', '2024-04-09 14:28:00'),
(54, 1, '2024-04-09 14:42:31', 1, '2024-04-09 14:42:31', '2024-04-09 14:42:31'),
(55, 1, '2024-04-09 14:44:01', 1, '2024-04-09 14:44:01', '2024-04-09 14:44:01'),
(56, 1, '2024-04-09 14:45:25', 1, '2024-04-09 14:45:25', '2024-04-09 14:45:25'),
(57, 1, '2024-04-09 14:45:38', 1, '2024-04-09 14:45:38', '2024-04-09 14:45:38'),
(58, 1, '2024-04-09 14:45:43', 1, '2024-04-09 14:45:43', '2024-04-09 14:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `bsl_cmn_mealtypes`
--

CREATE TABLE `bsl_cmn_mealtypes` (
  `bsl_cmn_mealtypes_id` int(10) UNSIGNED NOT NULL,
  `bsl_cmn_mealtypes_mealname` varchar(255) NOT NULL,
  `bsl_cmn_mealtypes_site` int(10) UNSIGNED NOT NULL,
  `bsl_cmn_mealtypes_numberofmeals` int(11) NOT NULL,
  `bsl_cmn_mealtypes_starthour` int(11) NOT NULL,
  `bsl_cmn_mealtypes_duration` int(11) NOT NULL,
  `bsl_cmn_mealtypes_status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bsl_cmn_mealtypes`
--

INSERT INTO `bsl_cmn_mealtypes` (`bsl_cmn_mealtypes_id`, `bsl_cmn_mealtypes_mealname`, `bsl_cmn_mealtypes_site`, `bsl_cmn_mealtypes_numberofmeals`, `bsl_cmn_mealtypes_starthour`, `bsl_cmn_mealtypes_duration`, `bsl_cmn_mealtypes_status`, `created_at`, `updated_at`) VALUES
(1, 'Tea', 1, 1, 7, 24, 1, NULL, NULL),
(2, 'Lunch', 1, 1, 7, 24, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bsl_cmn_sites`
--

CREATE TABLE `bsl_cmn_sites` (
  `bsl_cmn_sites_id` int(10) UNSIGNED NOT NULL,
  `bsl_cmn_sites_name` varchar(255) NOT NULL,
  `bsl_cmn_sites_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bsl_cmn_sites`
--

INSERT INTO `bsl_cmn_sites` (`bsl_cmn_sites_id`, `bsl_cmn_sites_name`, `bsl_cmn_sites_status`, `created_at`, `updated_at`) VALUES
(1, 'Terminal C', 1, NULL, NULL),
(2, 'SGR', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bsl_cmn_users`
--

CREATE TABLE `bsl_cmn_users` (
  `bsl_cmn_users_id` int(10) UNSIGNED NOT NULL COMMENT 'bsl_cmn_users_id',
  `bsl_cmn_users_firstname` varchar(255) NOT NULL,
  `bsl_cmn_users_lastname` varchar(255) NOT NULL,
  `bsl_cmn_users_employment_number` varchar(255) DEFAULT NULL,
  `bsl_cmn_users_pin` varchar(255) DEFAULT NULL,
  `bsl_cmn_users_email` varchar(255) DEFAULT NULL,
  `bsl_cmn_users_department` varchar(255) DEFAULT NULL,
  `bsl_cmn_users_status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bsl_cmn_users_type` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bsl_cmn_users`
--

INSERT INTO `bsl_cmn_users` (`bsl_cmn_users_id`, `bsl_cmn_users_firstname`, `bsl_cmn_users_lastname`, `bsl_cmn_users_employment_number`, `bsl_cmn_users_pin`, `bsl_cmn_users_email`, `bsl_cmn_users_department`, `bsl_cmn_users_status`, `created_at`, `updated_at`, `bsl_cmn_users_type`) VALUES
(1, 'John', 'Doe', 'G001', '1560', NULL, 'ICT', 1, '2024-03-31 09:06:32', '2024-03-31 09:06:32', 1),
(2, 'Omar', 'Wendo', 'G002', '8123', NULL, NULL, 1, '2024-04-01 09:59:51', '2024-04-01 09:59:51', 1),
(3, 'Jane', 'Doe', 'G003', '9424', NULL, NULL, 1, '2024-04-01 19:09:19', '2024-04-01 19:09:19', 1),
(4, 'Ali', 'Adulqadir', 'G005', '8776', NULL, NULL, 1, '2024-04-02 05:07:44', '2024-04-02 05:07:44', 1),
(19, 'Purity', 'Wakini', 'G1021', '2058', 'purityw@bulkstream.com', NULL, 1, '2024-04-09 11:35:58', '2024-04-09 11:35:58', 1),
(21, 'Peter', 'Kikumu', 'G1014', 'NULL', 'peter.kikumu@ke.bulkstream.com', NULL, 1, NULL, NULL, 1),
(22, 'Peter', 'Mutsoli', 'G1108', '3733', 'peter.mutsoli@bulkstream.com', NULL, 1, '2024-04-09 12:16:28', '2024-04-09 12:16:28', 1),
(29, 'Kinzani', 'Rhova', 'G3300', '7727', NULL, NULL, 1, '2024-04-09 12:47:29', '2024-04-09 12:47:29', 1),
(30, 'Kinzani', 'Rhova', 'G4657', '1543', 'keith.rhova@bulkstream.com', NULL, 1, '2024-04-09 12:51:22', '2024-04-09 12:51:22', 1),
(31, 'Keiva', 'Rhoth', NULL, '1749', NULL, NULL, 1, '2024-04-09 13:11:54', '2024-04-09 13:11:54', 5),
(32, 'Kinzani', 'Rhova', 'G45678', '3970', NULL, 'ICT', 1, '2024-04-09 13:16:19', '2024-04-09 13:16:19', 1),
(33, 'Kinzani', 'Rhova', NULL, '9651', NULL, NULL, 1, '2024-04-09 13:24:19', '2024-04-09 13:24:19', 1),
(34, 'Kinzani', 'Rhova', NULL, '6637', 'keith.rhova@mbarakibulk.com', NULL, 1, '2024-04-09 13:25:05', '2024-04-09 13:25:05', 2),
(35, 'Kinzani', 'Rhova', 'G2345t', '3834', NULL, 'ICT', 1, '2024-04-09 13:25:33', '2024-04-09 13:25:33', 2);

-- --------------------------------------------------------

--
-- Table structure for table `bsl_cmn_user_types`
--

CREATE TABLE `bsl_cmn_user_types` (
  `bsl_cmn_user_types_id` int(10) UNSIGNED NOT NULL,
  `bsl_cmn_user_types_name` varchar(255) NOT NULL,
  `bsl_cmn_user_types_status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bsl_cmn_user_types`
--

INSERT INTO `bsl_cmn_user_types` (`bsl_cmn_user_types_id`, `bsl_cmn_user_types_name`, `bsl_cmn_user_types_status`, `created_at`, `updated_at`) VALUES
(1, 'Bulkstream Limited', 1, NULL, NULL),
(2, 'Bulkstream Logistics', 1, NULL, NULL),
(5, 'Visitor', 1, NULL, NULL),
(6, 'Contractor', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

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
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_03_27_091037_drop_users_table', 1),
(5, '2024_03_27_115802_create_custom_user_table', 1),
(6, '2024_03_27_121036_create_sites_table', 1),
(7, '2024_03_27_122020_create_meals_table', 1),
(8, '2024_03_27_130335_create_logs_table', 1),
(9, '2024_03_27_130823_create_user_types_table', 1),
(10, '2024_03_27_131138_add_status_on_user_types_table', 1),
(11, '2024_03_27_131648_add_foreign_key', 2),
(12, '2024_03_27_132423_add_status_on_users', 3),
(13, '2024_03_27_132549_add_status_on_mealtypes', 3),
(14, '2024_04_01_125425_add_updated_at_to_bsl_cmn_logs_table', 4),
(15, '2024_04_01_125620_drop_bsl_cmn_logs_time_column', 5),
(16, '2024_04_02_095208_add_email_to_bsl_cmn_users_table', 6),
(17, '2024_04_02_103852_add_bsl_cmn_logs_time_to_bsl_cmn_logs_table', 7),
(18, '2024_04_09_155555_add_bsl_cmn_users_department_to_bsl_cmn_users_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('dZNLmyUTs5kuTdT71DmnuTUPzrEZ4TVJN5rxTNVz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNHl0amJIUDZkQllZNUtGYzZXV2RHdHNXcmtYNzdDYnd0WlRpUUZpUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1712673983);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bsl_cmn_logs`
--
ALTER TABLE `bsl_cmn_logs`
  ADD PRIMARY KEY (`bsl_cmn_logs_id`),
  ADD KEY `bsl_cmn_logs_bsl_cmn_logs_person_foreign` (`bsl_cmn_logs_person`),
  ADD KEY `bsl_cmn_logs_bsl_cmn_logs_mealtype_foreign` (`bsl_cmn_logs_mealtype`);

--
-- Indexes for table `bsl_cmn_mealtypes`
--
ALTER TABLE `bsl_cmn_mealtypes`
  ADD PRIMARY KEY (`bsl_cmn_mealtypes_id`),
  ADD KEY `bsl_cmn_mealtypes_bsl_cmn_mealtypes_site_foreign` (`bsl_cmn_mealtypes_site`);

--
-- Indexes for table `bsl_cmn_sites`
--
ALTER TABLE `bsl_cmn_sites`
  ADD PRIMARY KEY (`bsl_cmn_sites_id`);

--
-- Indexes for table `bsl_cmn_users`
--
ALTER TABLE `bsl_cmn_users`
  ADD PRIMARY KEY (`bsl_cmn_users_id`),
  ADD UNIQUE KEY `bsl_cmn_users_bsl_cmn_users_email_unique` (`bsl_cmn_users_email`),
  ADD KEY `bsl_cmn_users_bsl_cmn_users_type_foreign` (`bsl_cmn_users_type`);

--
-- Indexes for table `bsl_cmn_user_types`
--
ALTER TABLE `bsl_cmn_user_types`
  ADD PRIMARY KEY (`bsl_cmn_user_types_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bsl_cmn_logs`
--
ALTER TABLE `bsl_cmn_logs`
  MODIFY `bsl_cmn_logs_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `bsl_cmn_mealtypes`
--
ALTER TABLE `bsl_cmn_mealtypes`
  MODIFY `bsl_cmn_mealtypes_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bsl_cmn_sites`
--
ALTER TABLE `bsl_cmn_sites`
  MODIFY `bsl_cmn_sites_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bsl_cmn_users`
--
ALTER TABLE `bsl_cmn_users`
  MODIFY `bsl_cmn_users_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'bsl_cmn_users_id', AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `bsl_cmn_user_types`
--
ALTER TABLE `bsl_cmn_user_types`
  MODIFY `bsl_cmn_user_types_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bsl_cmn_logs`
--
ALTER TABLE `bsl_cmn_logs`
  ADD CONSTRAINT `bsl_cmn_logs_bsl_cmn_logs_mealtype_foreign` FOREIGN KEY (`bsl_cmn_logs_mealtype`) REFERENCES `bsl_cmn_mealtypes` (`bsl_cmn_mealtypes_id`),
  ADD CONSTRAINT `bsl_cmn_logs_bsl_cmn_logs_person_foreign` FOREIGN KEY (`bsl_cmn_logs_person`) REFERENCES `bsl_cmn_users` (`bsl_cmn_users_id`);

--
-- Constraints for table `bsl_cmn_mealtypes`
--
ALTER TABLE `bsl_cmn_mealtypes`
  ADD CONSTRAINT `bsl_cmn_mealtypes_bsl_cmn_mealtypes_site_foreign` FOREIGN KEY (`bsl_cmn_mealtypes_site`) REFERENCES `bsl_cmn_sites` (`bsl_cmn_sites_id`);

--
-- Constraints for table `bsl_cmn_users`
--
ALTER TABLE `bsl_cmn_users`
  ADD CONSTRAINT `bsl_cmn_users_bsl_cmn_users_type_foreign` FOREIGN KEY (`bsl_cmn_users_type`) REFERENCES `bsl_cmn_user_types` (`bsl_cmn_user_types_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
