-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2022 at 09:08 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bgcollection`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories`
--

CREATE TABLE `accessories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `accessories_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accessories_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accessories`
--

INSERT INTO `accessories` (`id`, `unit_id`, `accessories_name`, `accessories_photo`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'access_1', NULL, 3, NULL, '2022-09-28 23:34:02', '2022-09-28 23:34:02'),
(2, 2, 'access2', NULL, 3, NULL, '2022-09-29 00:20:39', '2022-09-29 00:20:39'),
(3, 2, 'access 3', NULL, 3, NULL, '2022-09-29 00:31:12', '2022-09-29 00:31:12'),
(4, 3, 'access 4', NULL, 3, NULL, '2022-09-29 01:28:27', '2022-09-29 01:28:27'),
(5, 4, 'bbbbb', NULL, 3, NULL, '2022-09-29 05:31:08', '2022-09-29 05:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `booking_histories`
--

CREATE TABLE `booking_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `style_id` bigint(20) UNSIGNED NOT NULL,
  `accessories_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED DEFAULT NULL,
  `size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `garments_quantity` double(8,2) DEFAULT NULL,
  `requered_quantity` double(8,2) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `buyers`
--

CREATE TABLE `buyers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `buyer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `color_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `color_name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'blue', 3, NULL, '2022-09-28 23:34:02', '2022-09-28 23:34:02'),
(2, 'dark greesn', 3, NULL, '2022-09-29 00:20:39', '2022-09-29 00:20:39'),
(3, 'eeeee', 3, NULL, '2022-09-29 05:31:08', '2022-09-29 05:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `style_id` bigint(20) UNSIGNED NOT NULL,
  `accessories_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED DEFAULT NULL,
  `size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `garments_quantity` double(8,2) DEFAULT NULL,
  `requered_quantity` double(8,2) DEFAULT NULL,
  `received_quantity` double(8,2) DEFAULT NULL,
  `stock_quantity` double(8,2) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `style_id`, `accessories_id`, `color_id`, `size_id`, `garments_quantity`, `requered_quantity`, `received_quantity`, `stock_quantity`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, NULL, NULL, 1789.00, 1789.00, NULL, NULL, '2022-09-28 23:34:02', '2022-09-29 00:18:06'),
(2, 2, 2, 2, 2, NULL, NULL, 500.00, 500.00, NULL, NULL, '2022-09-29 00:20:39', '2022-09-29 00:20:39'),
(3, 1, 3, 1, 1, NULL, NULL, 33665.00, 33665.00, NULL, NULL, '2022-09-29 00:31:12', '2022-09-29 00:31:12'),
(4, 2, 1, 2, 2, NULL, NULL, 102.00, 102.00, NULL, NULL, '2022-09-29 01:27:48', '2022-09-29 01:27:48'),
(5, 2, 4, 2, 1, NULL, NULL, 380.00, 380.00, NULL, NULL, '2022-09-29 01:28:27', '2022-09-29 01:28:27'),
(6, 5, 5, 3, 3, NULL, NULL, 412.00, 412.00, NULL, NULL, '2022-09-29 05:31:08', '2022-09-29 05:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_09_25_044234_create_roles_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_09_25_044343_create_buyers_table', 1),
(7, '2022_09_25_044439_create_orders_table', 1),
(8, '2022_09_25_044455_create_styles_table', 1),
(9, '2022_09_25_044520_create_units_table', 1),
(10, '2022_09_25_052245_create_accessories_table', 1),
(11, '2022_09_25_052329_create_colors_table', 1),
(12, '2022_09_25_052417_create_sizes_table', 1),
(13, '2022_09_25_052757_create_suppliers_table', 1),
(14, '2022_09_25_052900_create_booking_histories_table', 1),
(15, '2022_09_25_052905_create_inventories_table', 1),
(16, '2022_09_25_053106_create_stock_in_histories_table', 1),
(17, '2022_09_25_053253_create_receivers_table', 1),
(18, '2022_09_25_053315_create_stock_out_histories_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `buyer_id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receivers`
--

CREATE TABLE `receivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `receiver_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super Admin', '2022-09-28 22:38:28', NULL),
(2, 2, 'Marchendiser Representative ', '2022-09-28 22:38:28', NULL),
(3, 3, 'Store Representative', '2022-09-28 22:38:28', NULL),
(4, 4, 'Only Viewer', '2022-09-28 22:38:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `size`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'XXL', 3, NULL, '2022-09-28 23:34:02', '2022-09-28 23:34:02'),
(2, 'S', 3, NULL, '2022-09-29 00:20:39', '2022-09-29 00:20:39'),
(3, 'fffff', 3, NULL, '2022-09-29 05:31:08', '2022-09-29 05:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `stock_in_histories`
--

CREATE TABLE `stock_in_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `style_id` bigint(20) UNSIGNED NOT NULL,
  `accessories_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED DEFAULT NULL,
  `size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `callan_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mrr_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `collected_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `quantity` double(8,2) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_in_histories`
--

INSERT INTO `stock_in_histories` (`id`, `style_id`, `accessories_id`, `color_id`, `size_id`, `supplier_id`, `callan_no`, `mrr_no`, `collected_by`, `received_date`, `quantity`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, '65656', '4635', 'shawon', '2022-09-29', 1000.00, 3, NULL, '2022-09-28 23:34:02', '2022-09-28 23:34:02'),
(2, 1, 1, 1, 1, 1, 'Quaerat quo nulla no', 'Velit quisquam eos', 'Quis qui non enim qu', '1982-07-29', 255.00, 3, NULL, '2022-09-29 00:11:47', '2022-09-29 00:11:47'),
(3, 1, 1, 1, 1, 1, 'Quaerat quo nulla no', 'Velit quisquam eos', 'Quis qui non enim qu', '1982-07-29', 255.00, 3, NULL, '2022-09-29 00:11:52', '2022-09-29 00:11:52'),
(4, 1, 1, 1, 1, 1, 'Reprehenderit odit u', 'Vitae ex in aut reru', 'Ad aut dignissimos p', '2009-06-18', 93.00, 3, NULL, '2022-09-29 00:13:21', '2022-09-29 00:13:21'),
(5, 1, 1, 1, 1, 1, 'Reprehenderit odit u', 'Vitae ex in aut reru', 'Ad aut dignissimos p', '2009-06-18', 93.00, 3, NULL, '2022-09-29 00:13:51', '2022-09-29 00:13:51'),
(6, 1, 1, 1, 1, 1, 'Reprehenderit odit u', 'Vitae ex in aut reru', 'Ad aut dignissimos p', '2009-06-18', 93.00, 3, NULL, '2022-09-29 00:16:40', '2022-09-29 00:16:40'),
(7, 1, 1, 1, 1, 1, 'Reprehenderit odit u', 'Vitae ex in aut reru', 'Ad aut dignissimos p', '2009-06-18', 93.00, 3, NULL, '2022-09-29 00:17:12', '2022-09-29 00:17:12'),
(8, 1, 1, 1, 1, 1, 'Reprehenderit odit u', 'Vitae ex in aut reru', 'Ad aut dignissimos p', '2009-06-18', 93.00, 3, NULL, '2022-09-29 00:18:06', '2022-09-29 00:18:06'),
(9, 2, 2, 2, 2, 2, '54446', '552515', 'shawon', '2022-09-29', 500.00, 3, NULL, '2022-09-29 00:20:39', '2022-09-29 00:20:39'),
(10, 1, 3, 1, 1, 2, '+64+6', '66465', 'uiyfuyj', '2022-09-29', 33665.00, 3, NULL, '2022-09-29 00:31:12', '2022-09-29 00:31:12'),
(11, 2, 1, 2, 2, 1, 'Accusamus excepturi', 'Labore odit sit nihi', 'Ex sit est velit sus', '1992-02-13', 102.00, 3, NULL, '2022-09-29 01:27:48', '2022-09-29 01:27:48'),
(12, 2, 4, 2, 1, 2, 'Ut ullamco cupidatat', 'Itaque possimus rec', 'Distinctio Dolore q', '1999-06-09', 380.00, 3, NULL, '2022-09-29 01:28:27', '2022-09-29 01:28:27'),
(13, 5, 5, 3, 3, 3, 'Velit possimus odi', 'Sit saepe enim praes', 'Molestiae proident', '2020-07-20', 412.00, 3, NULL, '2022-09-29 05:31:08', '2022-09-29 05:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `stock_out_histories`
--

CREATE TABLE `stock_out_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `style_id` bigint(20) UNSIGNED NOT NULL,
  `accessories_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED DEFAULT NULL,
  `size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `line_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` double(8,2) NOT NULL,
  `stock_out_date` date DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `styles`
--

CREATE TABLE `styles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `style_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `styles`
--

INSERT INTO `styles` (`id`, `order_id`, `style_no`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, NULL, '#0001', 3, NULL, '2022-09-28 23:34:02', '2022-09-28 23:34:02'),
(2, NULL, '000s2', 3, NULL, '2022-09-29 00:20:39', '2022-09-29 00:20:39'),
(3, NULL, 'gbnvb', 3, NULL, '2022-09-29 05:29:34', '2022-09-29 05:29:34'),
(5, NULL, 'aaaaa', 3, NULL, '2022-09-29 05:31:08', '2022-09-29 05:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Jolil', 3, NULL, '2022-09-28 23:34:02', '2022-09-28 23:34:02'),
(2, 'kasem', 3, NULL, '2022-09-29 00:20:39', '2022-09-29 00:20:39'),
(3, 'ddddd', 3, NULL, '2022-09-29 05:31:08', '2022-09-29 05:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'piece', 3, NULL, '2022-09-28 23:34:02', '2022-09-28 23:34:02'),
(2, 'kg', 3, NULL, '2022-09-29 00:20:39', '2022-09-29 00:20:39'),
(3, 'fit', 3, NULL, '2022-09-29 01:28:27', '2022-09-29 01:28:27'),
(4, 'cccc', 3, NULL, '2022-09-29 05:31:08', '2022-09-29 05:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role_id`, `email`, `email_verified_at`, `password`, `deleted_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Head Office', 1, 'admin@gmail.com', '2022-09-28 22:38:28', '$2y$10$XYSjHK8A2HeGwgMZTRfkeehCsmDPOChIZtb1lHoMO4w8/4cbI.umW', NULL, NULL, '2022-09-28 22:38:28', NULL),
(2, 'MR', 2, 'mr@gmail.com', '2022-09-28 22:38:28', '$2y$10$4SZlUa5aUBRTjP0jD/KJEeHKMwAc9QlocSuL3D.Nx7rpsMferD1dW', NULL, NULL, '2022-09-28 22:38:29', NULL),
(3, 'Amirul Islam', 3, 'store@gmail.com', '2022-09-28 22:38:29', '$2y$10$qOobavIv4/gOFbpKGuLb2O0YddjSVDiF0kIIW0I9gsrwBqFO7bMli', NULL, NULL, '2022-09-28 22:38:29', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accessories_accessories_name_unique` (`accessories_name`),
  ADD UNIQUE KEY `accessories_accessories_photo_unique` (`accessories_photo`),
  ADD KEY `accessories_unit_id_foreign` (`unit_id`),
  ADD KEY `accessories_created_by_foreign` (`created_by`),
  ADD KEY `accessories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `booking_histories`
--
ALTER TABLE `booking_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_histories_style_id_foreign` (`style_id`),
  ADD KEY `booking_histories_accessories_id_foreign` (`accessories_id`),
  ADD KEY `booking_histories_color_id_foreign` (`color_id`),
  ADD KEY `booking_histories_size_id_foreign` (`size_id`),
  ADD KEY `booking_histories_created_by_foreign` (`created_by`),
  ADD KEY `booking_histories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `buyers`
--
ALTER TABLE `buyers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `buyers_buyer_name_unique` (`buyer_name`),
  ADD KEY `buyers_created_by_foreign` (`created_by`),
  ADD KEY `buyers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `colors_color_name_unique` (`color_name`),
  ADD KEY `colors_created_by_foreign` (`created_by`),
  ADD KEY `colors_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventories_style_id_foreign` (`style_id`),
  ADD KEY `inventories_accessories_id_foreign` (`accessories_id`),
  ADD KEY `inventories_color_id_foreign` (`color_id`),
  ADD KEY `inventories_size_id_foreign` (`size_id`),
  ADD KEY `inventories_created_by_foreign` (`created_by`),
  ADD KEY `inventories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_no_unique` (`order_no`),
  ADD KEY `orders_buyer_id_foreign` (`buyer_id`),
  ADD KEY `orders_created_by_foreign` (`created_by`),
  ADD KEY `orders_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `receivers`
--
ALTER TABLE `receivers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receivers_created_by_foreign` (`created_by`),
  ADD KEY `receivers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_role_id_unique` (`role_id`),
  ADD UNIQUE KEY `roles_role_name_unique` (`role_name`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sizes_size_unique` (`size`),
  ADD KEY `sizes_created_by_foreign` (`created_by`),
  ADD KEY `sizes_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `stock_in_histories`
--
ALTER TABLE `stock_in_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_in_histories_style_id_foreign` (`style_id`),
  ADD KEY `stock_in_histories_accessories_id_foreign` (`accessories_id`),
  ADD KEY `stock_in_histories_color_id_foreign` (`color_id`),
  ADD KEY `stock_in_histories_size_id_foreign` (`size_id`),
  ADD KEY `stock_in_histories_supplier_id_foreign` (`supplier_id`),
  ADD KEY `stock_in_histories_created_by_foreign` (`created_by`),
  ADD KEY `stock_in_histories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `stock_out_histories`
--
ALTER TABLE `stock_out_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_out_histories_style_id_foreign` (`style_id`),
  ADD KEY `stock_out_histories_accessories_id_foreign` (`accessories_id`),
  ADD KEY `stock_out_histories_color_id_foreign` (`color_id`),
  ADD KEY `stock_out_histories_size_id_foreign` (`size_id`),
  ADD KEY `stock_out_histories_receiver_id_foreign` (`receiver_id`),
  ADD KEY `stock_out_histories_created_by_foreign` (`created_by`),
  ADD KEY `stock_out_histories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `styles`
--
ALTER TABLE `styles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `styles_style_no_unique` (`style_no`),
  ADD KEY `styles_order_id_foreign` (`order_id`),
  ADD KEY `styles_created_by_foreign` (`created_by`),
  ADD KEY `styles_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_supplier_name_unique` (`supplier_name`),
  ADD KEY `suppliers_created_by_foreign` (`created_by`),
  ADD KEY `suppliers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_unit_unique` (`unit`),
  ADD KEY `units_updated_by_foreign` (`updated_by`),
  ADD KEY `units_created_by_foreign` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories`
--
ALTER TABLE `accessories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `booking_histories`
--
ALTER TABLE `booking_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buyers`
--
ALTER TABLE `buyers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `receivers`
--
ALTER TABLE `receivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_in_histories`
--
ALTER TABLE `stock_in_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `stock_out_histories`
--
ALTER TABLE `stock_out_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `styles`
--
ALTER TABLE `styles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accessories`
--
ALTER TABLE `accessories`
  ADD CONSTRAINT `accessories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accessories_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accessories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_histories`
--
ALTER TABLE `booking_histories`
  ADD CONSTRAINT `booking_histories_accessories_id_foreign` FOREIGN KEY (`accessories_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_histories_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_histories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_histories_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_histories_style_id_foreign` FOREIGN KEY (`style_id`) REFERENCES `styles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_histories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buyers`
--
ALTER TABLE `buyers`
  ADD CONSTRAINT `buyers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `buyers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `colors`
--
ALTER TABLE `colors`
  ADD CONSTRAINT `colors_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `colors_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_accessories_id_foreign` FOREIGN KEY (`accessories_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_style_id_foreign` FOREIGN KEY (`style_id`) REFERENCES `styles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `receivers`
--
ALTER TABLE `receivers`
  ADD CONSTRAINT `receivers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `receivers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sizes`
--
ALTER TABLE `sizes`
  ADD CONSTRAINT `sizes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sizes_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_in_histories`
--
ALTER TABLE `stock_in_histories`
  ADD CONSTRAINT `stock_in_histories_accessories_id_foreign` FOREIGN KEY (`accessories_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_in_histories_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_in_histories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_in_histories_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_in_histories_style_id_foreign` FOREIGN KEY (`style_id`) REFERENCES `styles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_in_histories_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_in_histories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_out_histories`
--
ALTER TABLE `stock_out_histories`
  ADD CONSTRAINT `stock_out_histories_accessories_id_foreign` FOREIGN KEY (`accessories_id`) REFERENCES `accessories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_out_histories_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_out_histories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_out_histories_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `receivers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_out_histories_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_out_histories_style_id_foreign` FOREIGN KEY (`style_id`) REFERENCES `styles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_out_histories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `styles`
--
ALTER TABLE `styles`
  ADD CONSTRAINT `styles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `styles_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `styles_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `suppliers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `units_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
