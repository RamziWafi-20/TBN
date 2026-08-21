-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Agu 2026 pada 14.20
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
CREATE DATABASE IF NOT EXISTS `tbn` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `tbn`;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tbn`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ai_scans`
--

CREATE TABLE `ai_scans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `waste_report_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `waste_type` varchar(255) NOT NULL,
  `material` varchar(255) DEFAULT NULL,
  `confidence` decimal(5,2) NOT NULL,
  `estimated_weight` decimal(10,2) NOT NULL,
  `recyclable` tinyint(1) NOT NULL,
  `estimated_value` decimal(12,2) NOT NULL,
  `recommendation` text DEFAULT NULL,
  `raw_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`raw_response`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'info',
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `type`, `is_published`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'Program Jumat Bebas Plastik', 'Ajak kelasmu mengurangi plastik sekali pakai dan setorkan material yang sudah dipilah ke TBN.', 'event', 1, '2026-08-13 23:58:29', '2026-08-13 23:58:29', '2026-08-13 23:58:29'),
(2, 'Update Harga Material', 'Harga material TBN diperbarui untuk membantu simulasi nilai ekonomi.', 'update', 1, '2026-08-12 23:58:29', '2026-08-13 23:58:29', '2026-08-13 23:58:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `email_verification_codes`
--

CREATE TABLE `email_verification_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `code_hash` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `attempts` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `last_sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
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
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2026_08_14_000001_create_waste_tables', 1),
(3, '0001_01_01_000001_create_cache_table', 2),
(4, '0001_01_01_000002_create_jobs_table', 2),
(5, '2026_08_14_084718_create_waste_records_table', 2),
(6, '2026_08_14_100000_add_ai_fields_to_waste_records_table', 2),
(7, '2026_08_14_100001_normalize_user_roles', 2),
(9, '2026_08_14_093006_add_nis_to_users_table', 3),
(10, '2026_08_14_110000_prepare_users_and_email_verification', 4),
(11, '2026_08_14_120000_add_profile_fields_to_users', 5),
(12, '2026_08_14_130000_ensure_analytics_tables', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'info',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Selamat datang di TBN', 'Mulai kontribusimu dengan memindai dan melaporkan sampah.', 'success', NULL, '2026-08-13 23:58:29', '2026-08-13 23:58:29'),
(2, 1, 'Dashboard siap', 'Data demo TBN telah dimuat.', 'info', NULL, '2026-08-13 23:58:29', '2026-08-13 23:58:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
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
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('SZRpjw89FmNWBtXUr4g2qK6FIlgXuHQv3iMEyx1a', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV29MRTVPQ1Z1UkowQUQ4ZEgxemJISmhtWjNneU55d0Zac3oxZWhYUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1786692055),
('VbPF3qGDKCYQHQhcId28JJADW7PoYVHoSAaxBUnU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVjFaTzZzbzMydERwYndBQzdib2xWdlQwUHNEVzc4RTZKaFZIaFljQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1786693780),
('vc6XgJbDnjFUy8KEcl69ktbaFfzTZK6hQ5xiK8w4', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiakV5RTZkZktlUnFQT2YzZldNVGV4QmNSeHAzY0hGUzBwdEZzUEtTYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1786694931);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nis` varchar(30) DEFAULT NULL,
  `class_name` varchar(50) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL DEFAULT 'Siswa',
  `eco_points` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `nis`, `class_name`, `profile_photo`, `email_verified_at`, `password`, `role`, `eco_points`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'TBN Administrator', 'TBNADMIN', 'admin@tbn.local', NULL, NULL, NULL, '2026-08-14 00:00:00', '$2y$12$PK8Z6locjclEZrWbOyRkqeea5QfXBHNTxT8xeFkt573KxB6OIq6tC', 'Pengelola', 2500, NULL, '2026-08-13 23:58:28', '2026-08-13 23:58:28'),
(2, 'Ramzi Wafi', 'RAMZIUSER', 'ramzi@tbn.local', NULL, 'XII RPL 2', NULL, '2026-08-14 00:00:00', '$2y$12$RdD3oGViHb0do/37FQFFMuuMOancnJbZx65HJ7F.6UX/9AJ4P1mei', 'Siswa', 1240, NULL, '2026-08-13 23:58:29', '2026-08-13 23:58:29'),
(4, 'Siswa Demo TBN', 'SISWADUMMY', 'siswa@tbn.test', '0098765432', 'XII RPL 2', NULL, '2026-08-14 00:00:00', '$2y$12$RdD3oGViHb0do/37FQFFMuuMOancnJbZx65HJ7F.6UX/9AJ4P1mei', 'Siswa', 0, NULL, '2026-08-14 13:06:53', '2026-08-14 13:06:53'),
(5, 'Pengelola Demo TBN', 'PENGELOLADUMMY', 'pengelola@tbn.test', '0098765431', NULL, NULL, '2026-08-14 00:00:00', '$2y$12$PK8Z6locjclEZrWbOyRkqeea5QfXBHNTxT8xeFkt573KxB6OIq6tC', 'Pengelola', 0, NULL, '2026-08-14 13:06:53', '2026-08-14 13:06:53'),
(10, 'Fahri', 'FAHRI2', 'fahri2@tbn.local', '1234561', NULL, NULL, '2026-08-14 07:01:47', '$2y$12$VBzUSNlxX5f5O5RLn13xYeJZQ5qUCN9ukab76AqQ1gfzQJhgJ9SoS', 'Pengelola', 0, NULL, '2026-08-14 06:51:58', '2026-08-14 07:01:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `waste_categories`
--

CREATE TABLE `waste_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `material` varchar(255) NOT NULL,
  `default_price_per_kg` decimal(12,2) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `waste_categories`
--

INSERT INTO `waste_categories` (`id`, `name`, `material`, `default_price_per_kg`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Botol Plastik', 'PET', 5000.00, '#3AA346', '2026-08-13 23:58:29', '2026-08-13 23:58:29'),
(2, 'Kertas', 'Paper', 3000.00, '#3AA346', '2026-08-13 23:58:29', '2026-08-13 23:58:29'),
(3, 'Kardus', 'Cardboard', 2500.00, '#3AA346', '2026-08-13 23:58:29', '2026-08-13 23:58:29'),
(4, 'Kaleng', 'Metal', 8000.00, '#3AA346', '2026-08-13 23:58:29', '2026-08-13 23:58:29'),
(5, 'Kaca', 'Glass', 1800.00, '#3AA346', '2026-08-13 23:58:29', '2026-08-13 23:58:29'),
(6, 'Organik', 'Organic', 1000.00, '#3AA346', '2026-08-13 23:58:29', '2026-08-13 23:58:29'),
(7, 'Sampah Campuran', 'Mixed', 500.00, '#3AA346', '2026-08-13 23:58:29', '2026-08-13 23:58:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `waste_records`
--

CREATE TABLE `waste_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `waste_name` varchar(150) DEFAULT NULL,
  `waste_type` varchar(255) NOT NULL,
  `condition` varchar(80) DEFAULT NULL,
  `ai_confidence` decimal(5,2) NOT NULL DEFAULT 0.00,
  `estimated_weight` double NOT NULL,
  `estimated_price` decimal(10,2) NOT NULL,
  `advice` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `waste_reports`
--

CREATE TABLE `waste_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `waste_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `ai_confidence` decimal(5,2) DEFAULT NULL,
  `ai_estimated_weight` decimal(10,2) DEFAULT NULL,
  `actual_weight` decimal(10,2) DEFAULT NULL,
  `estimated_value` decimal(12,2) DEFAULT NULL,
  `actual_value` decimal(12,2) DEFAULT NULL,
  `status` enum('Menunggu','Diverifikasi','Dikumpulkan','Ditimbang','Diproses','Selesai') NOT NULL DEFAULT 'Menunggu',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `waste_reports`
--

INSERT INTO `waste_reports` (`id`, `code`, `user_id`, `waste_category_id`, `image_path`, `ai_confidence`, `ai_estimated_weight`, `actual_weight`, `estimated_value`, `actual_value`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'TBN-4C43D1F', 2, 1, NULL, 94.00, 12.50, 12.50, 62500.00, 62500.00, 'Selesai', NULL, '2026-08-13 23:58:29', '2026-08-13 23:58:29'),
(2, 'TBN-90051D0', 2, 2, NULL, 94.00, 8.20, 8.20, 24600.00, 24600.00, 'Diverifikasi', NULL, '2026-08-13 23:58:29', '2026-08-13 23:58:29'),
(3, 'TBN-2694625', 2, 4, NULL, 94.00, 4.50, 4.50, 36000.00, 36000.00, 'Diproses', NULL, '2026-08-13 23:58:29', '2026-08-13 23:58:29');
(4, 'TBN-DEMO401', 4, 3, NULL, 97.00, 5.00, 5.00, 12500.00, 12500.00, 'Selesai', 'Setoran demo siswa.', '2026-08-14 08:00:00', '2026-08-14 08:10:00'),
(5, 'TBN-DEMO402', 4, 1, NULL, 95.00, 3.00, 3.00, 15000.00, 15000.00, 'Selesai', 'Setoran demo siswa.', '2026-08-14 09:00:00', '2026-08-14 09:10:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `waste_transactions`
--

CREATE TABLE `waste_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `waste_report_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `gross_value` decimal(12,2) NOT NULL,
  `processing_cost` decimal(12,2) NOT NULL,
  `selling_value` decimal(12,2) NOT NULL,
  `net_profit` decimal(12,2) NOT NULL,
  `transaction_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `waste_transactions`
--

INSERT INTO `waste_transactions` (`id`, `waste_report_id`, `type`, `gross_value`, `processing_cost`, `selling_value`, `net_profit`, `transaction_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Material Sale', 62500.00, 12500.00, 75000.00, 62500.00, '2026-08-14', '2026-08-13 23:58:29', '2026-08-13 23:58:29'),
(2, 3, 'Material Sale', 36000.00, 7200.00, 43200.00, 36000.00, '2026-08-14', '2026-08-13 23:58:29', '2026-08-13 23:58:29');
(3, 4, 'Material Sale', 12500.00, 2500.00, 15000.00, 12500.00, '2026-08-14', '2026-08-14 08:10:00', '2026-08-14 08:10:00'),
(4, 5, 'Material Sale', 15000.00, 3000.00, 18000.00, 15000.00, '2026-08-14', '2026-08-14 09:10:00', '2026-08-14 09:10:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ai_scans`
--
ALTER TABLE `ai_scans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ai_scans_user_id_foreign` (`user_id`),
  ADD KEY `ai_scans_waste_report_id_foreign` (`waste_report_id`);

--
-- Indeks untuk tabel `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `email_verification_codes`
--
ALTER TABLE `email_verification_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_verification_codes_user_id_expires_at_index` (`user_id`,`expires_at`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `waste_categories`
--
ALTER TABLE `waste_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `waste_records`
--
ALTER TABLE `waste_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waste_records_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `waste_reports`
--
ALTER TABLE `waste_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `waste_reports_code_unique` (`code`),
  ADD KEY `waste_reports_user_id_foreign` (`user_id`),
  ADD KEY `waste_reports_waste_category_id_foreign` (`waste_category_id`);

--
-- Indeks untuk tabel `waste_transactions`
--
ALTER TABLE `waste_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waste_transactions_waste_report_id_foreign` (`waste_report_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `ai_scans`
--
ALTER TABLE `ai_scans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `email_verification_codes`
--
ALTER TABLE `email_verification_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `waste_categories`
--
ALTER TABLE `waste_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `waste_records`
--
ALTER TABLE `waste_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `waste_reports`
--
ALTER TABLE `waste_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `waste_transactions`
--
ALTER TABLE `waste_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `ai_scans`
--
ALTER TABLE `ai_scans`
  ADD CONSTRAINT `ai_scans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ai_scans_waste_report_id_foreign` FOREIGN KEY (`waste_report_id`) REFERENCES `waste_reports` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `email_verification_codes`
--
ALTER TABLE `email_verification_codes`
  ADD CONSTRAINT `email_verification_codes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `waste_records`
--
ALTER TABLE `waste_records`
  ADD CONSTRAINT `waste_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `waste_reports`
--
ALTER TABLE `waste_reports`
  ADD CONSTRAINT `waste_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `waste_reports_waste_category_id_foreign` FOREIGN KEY (`waste_category_id`) REFERENCES `waste_categories` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `waste_transactions`
--
ALTER TABLE `waste_transactions`
  ADD CONSTRAINT `waste_transactions_waste_report_id_foreign` FOREIGN KEY (`waste_report_id`) REFERENCES `waste_reports` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
