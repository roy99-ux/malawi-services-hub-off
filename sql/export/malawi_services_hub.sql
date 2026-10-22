-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2026 at 07:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `malawi_services_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `entity_type` varchar(50) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES
(1, 1, 'login', 'user', 1, 'User logged in', '::1', '2026-04-15 06:40:49'),
(2, 3, 'login', 'user', 3, 'User logged in', '::1', '2026-04-15 06:51:52'),
(3, 1, 'login', 'user', 1, 'User logged in', '::1', '2026-04-15 07:27:31'),
(4, 1, 'login', 'user', 1, 'User logged in', '::1', '2026-04-15 08:38:46'),
(5, 3, 'login', 'user', 3, 'User logged in', '::1', '2026-04-15 09:46:54'),
(6, 1, 'login', 'user', 1, 'User logged in', '::1', '2026-04-15 09:47:59'),
(7, 3, 'login', 'user', 3, 'User logged in', '::1', '2026-04-15 09:49:34'),
(8, 1, 'login', 'user', 1, 'User logged in', '::1', '2026-04-15 17:24:48'),
(9, 3, 'login', 'user', 3, 'User logged in', '::1', '2026-04-16 18:03:26'),
(10, 3, 'login', 'user', 3, 'User logged in', '::1', '2026-04-16 23:58:11'),
(11, 1, 'login', 'user', 1, 'User logged in', '::1', '2026-04-17 00:02:43'),
(12, 3, 'login', 'user', 3, 'User logged in', '::1', '2026-04-17 00:03:27'),
(13, 1, 'login', 'user', 1, 'User logged in', '::1', '2026-04-17 00:10:05'),
(14, 4, 'login', 'user', 4, 'User logged in', '::1', '2026-04-23 07:27:20'),
(15, 4, 'login', 'user', 4, 'User logged in', '::1', '2026-04-23 07:32:41'),
(16, 4, 'login', 'user', 4, 'User logged in', '::1', '2026-06-12 05:26:27'),
(17, 4, 'login', 'user', 4, 'User logged in', '::1', '2026-07-15 05:23:51'),
(18, 1, 'login', 'user', 1, 'User logged in', '::1', '2026-07-22 06:56:22'),
(19, 3, 'login', 'user', 3, 'User logged in', '::1', '2026-07-22 06:57:00'),
(20, 1, 'login', 'user', 1, 'User logged in', '::1', '2026-07-22 06:57:50'),
(21, 3, 'login', 'user', 3, 'User logged in', '::1', '2026-07-22 06:59:39'),
(22, 4, 'login', 'user', 4, 'User logged in', '::1', '2026-07-22 07:00:37'),
(23, 3, 'login', 'user', 3, 'User logged in', '::1', '2026-07-22 07:04:32'),
(24, 1, 'login', 'user', 1, 'User logged in', '::1', '2026-07-22 07:05:01'),
(25, 3, 'login', 'user', 3, 'User logged in', '::1', '2026-07-22 07:07:29'),
(26, 4, 'login', 'user', 4, 'User logged in', '::1', '2026-07-22 07:09:47'),
(27, 4, 'login', 'user', 4, 'User logged in', '::1', '2026-07-22 07:19:19'),
(28, 4, 'login', 'user', 4, 'User logged in', '::1', '2026-07-22 07:39:23'),
(29, 4, 'login', 'user', 4, 'User logged in', '::1', '2026-07-22 07:39:26'),
(30, 1, 'login', 'user', 1, 'User logged in', '::1', '2026-07-23 05:50:03'),
(31, 3, 'login', 'user', 3, 'User logged in', '::1', '2026-07-23 05:51:33'),
(32, 1, 'login', 'user', 1, 'User logged in', '::1', '2026-07-23 05:56:15'),
(33, 3, 'login', 'user', 3, 'User logged in', '::1', '2026-07-23 05:59:19'),
(34, 3, 'login', 'user', 3, 'User logged in', '::1', '2026-07-23 06:07:05'),
(35, 4, 'login', 'user', 4, 'User logged in', '::1', '2026-07-23 06:13:41'),
(36, 4, 'login', 'user', 4, 'User logged in', '::1', '2026-07-23 06:39:37'),
(37, 5, 'login', 'user', 5, 'User logged in', '::1', '2026-07-23 06:49:48'),
(38, 5, 'login', 'user', 5, 'User logged in', '::1', '2026-07-23 06:53:46'),
(39, 4, 'login', 'user', 4, 'User logged in', '::1', '2026-07-23 06:59:25'),
(40, 5, 'login', 'user', 5, 'User logged in', '::1', '2026-07-23 07:05:22'),
(41, 4, 'login', 'user', 4, 'User logged in', '::1', '2026-07-23 07:45:24'),
(42, 5, 'login', 'user', 5, 'User logged in', '::1', '2026-07-23 07:51:35'),
(43, 4, 'login', 'user', 4, 'User logged in', '::1', '2026-07-29 02:02:04');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `service_category_id` int(11) NOT NULL,
  `quote_amount` decimal(10,2) NOT NULL,
  `negotiated_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','quoted','negotiating','accepted','confirmed','in_progress','completed','cancelled','disputed') DEFAULT 'pending',
  `description` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `scheduled_date` date DEFAULT NULL,
  `completed_date` date DEFAULT NULL,
  `payment_status` enum('pending','paid','refunded') DEFAULT 'pending',
  `rating` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_id`, `provider_id`, `service_category_id`, `quote_amount`, `negotiated_amount`, `status`, `description`, `address`, `scheduled_date`, `completed_date`, `payment_status`, `rating`, `review`, `created_at`, `transaction_id`) VALUES
(1, 3, 1, 8, 12000.00, 11500.00, 'completed', 'IT Service-web development', 'gdziya@gmail.com', '2026-07-24', '2026-08-20', 'paid', 4, 'Awesome', '2026-07-23 06:12:13', NULL),
(2, 5, 1, 8, 13000.00, 12000.00, 'confirmed', 'Mobile App Development', 'Chikapa', '2026-07-22', '2026-07-25', 'pending', 5, 'Great work', '2026-07-23 06:52:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `user1_id` int(11) NOT NULL,
  `user2_id` int(11) NOT NULL,
  `last_message` text DEFAULT NULL,
  `last_message_time` datetime DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `portfolios`
--

CREATE TABLE `portfolios` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bio` text DEFAULT NULL,
  `experience_years` int(11) DEFAULT 0,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_complete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfolios`
--

INSERT INTO `portfolios` (`id`, `user_id`, `bio`, `experience_years`, `hourly_rate`, `location`, `category_id`, `is_approved`, `created_at`, `is_complete`) VALUES
(1, 1, 'A skilled IT Technician', 3, 12000.00, 'Blantyre', 8, 0, '2026-04-15 06:28:39', 0);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `portfolio_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `images` text DEFAULT NULL,
  `videos` text DEFAULT NULL,
  `completion_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `portfolio_id`, `title`, `description`, `images`, `videos`, `completion_date`) VALUES
(1, 1, 'Malawi Services Hub Website', 'A services marketplace', 'assets/uploads/projects/1776245091_plumbing2.jpeg', 'assets/uploads/videos/1776245091_252100.mp4', NULL),
(4, 1, 'design', 'a design post', 'assets/uploads/projects/1784704024_create-admin-panel-dashboard-in-php-and-mysql.jpg', 'assets/uploads/videos/1784704024_252100.mp4', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

CREATE TABLE `qualifications` (
  `id` int(11) NOT NULL,
  `portfolio_id` int(11) NOT NULL,
  `degree` varchar(200) DEFAULT NULL,
  `institution` varchar(200) DEFAULT NULL,
  `year` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qualifications`
--

INSERT INTO `qualifications` (`id`, `portfolio_id`, `degree`, `institution`, `year`) VALUES
(3, 1, 'Bachelor of IT', 'BIU', '2026');

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT 'fa-service',
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`, `icon`, `is_active`) VALUES
(1, 'Plumbing', 'wrench', 1),
(2, 'Electrical', 'bolt', 1),
(3, 'Carpentry', 'hammer', 1),
(4, 'Cleaning', 'broom', 1),
(5, 'Painting', 'paint-roller', 1),
(6, 'Gardening', 'seedling', 1),
(7, 'Tutoring', 'chalkboard-user', 1),
(8, 'IT Support', 'laptop-code', 1),
(9, 'Photography', 'camera', 1),
(10, 'Catering', 'utensils', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) DEFAULT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES
(1, 'site_name', 'Malawi Service Marketplace', '2026-04-13 06:29:35'),
(2, 'admin_email', 'admin@malawimarketplace.com', '2026-04-13 06:29:35'),
(3, 'smtp_host', '', '2026-04-13 06:29:35'),
(4, 'smtp_port', '', '2026-04-13 06:29:35'),
(5, 'smtp_user', 'malawiserviceshub@gmail.com', '2026-07-23 07:47:50'),
(6, 'smtp_pass', 'admin1234', '2026-07-23 06:38:21'),
(9, 'commission_fee', '10', '2026-07-23 06:38:21'),
(14, 'paychangu_store_id', 'pub-test-L3S2JjdWc0nDz1wJxSXv2UlLdYrqPCT5', '2026-07-23 07:47:26'),
(15, 'paychangu_store_key', 'sec-test-•••••••••••••••••••••••••••••••••••••••••', '2026-07-23 07:04:42'),
(16, 'paychangu_api_url', 'https://sandbox.paychangu.com/v1', '2026-07-23 07:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `portfolio_id` int(11) NOT NULL,
  `skill_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `portfolio_id`, `skill_name`) VALUES
(19, 1, 'Coding'),
(20, 1, 'Graphic Design');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `portfolio_id` int(11) NOT NULL,
  `client_name` varchar(100) DEFAULT NULL,
  `client_email` varchar(100) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `text` text NOT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `location` varchar(100) NOT NULL,
  `role` enum('customer','provider','admin') DEFAULT 'customer',
  `profile_pic` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_profile_complete` tinyint(1) DEFAULT 0,
  `email_verified` tinyint(1) DEFAULT 0,
  `twofa_secret` varchar(255) DEFAULT NULL,
  `twofa_enabled` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `email_verification_token` varchar(255) DEFAULT NULL,
  `reset_password_token` varchar(255) DEFAULT NULL,
  `reset_password_expire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `location`, `role`, `profile_pic`, `is_active`, `is_profile_complete`, `email_verified`, `twofa_secret`, `twofa_enabled`, `created_at`, `last_login`, `email_verification_token`, `reset_password_token`, `reset_password_expire`) VALUES
(1, 'Roy Dziyanjanani', 'roydziyanjanani8@gmail.com', '$2y$10$ySX4QxsVIWCdMm8s/ITYDux31FdFWR4SKwW/ucWMTVQa4GRVFwbK6', '+265885348937', 'Blantyre', 'provider', NULL, 1, 1, 0, NULL, 0, '2026-04-15 06:28:39', '2026-07-22 22:56:15', 'cd9c851ab501fb9f3aab16e530dc4750577a15615a98050f6413d2077bfd3d04', '6df3d6c3dda9b74c301268f5ca4b3d7323a64dd60f312a5dd791e4a192c255cf', '2026-04-15 10:26:30'),
(2, 'Jones', 'gdziyanjanani@gmail.com', '$2y$10$8jKRmWJVt1QbKLfV5Gkp1u0cjiOjfrh9j0BFVOI34EK.kyhxN7Fde', '0996967290', 'Blantyre', 'customer', NULL, 1, 0, 0, NULL, 0, '2026-04-15 06:49:15', NULL, 'c8e5936d03902737af5e7f43334509b0c12ab9fa830d52424245f84f2c9f1565', 'b16f39d680dcc3088715e8cc624b2dc7fc272f24d6d5568d378a4693c295f1e1', '2026-07-23 09:46:53'),
(3, 'Jaden', 'jadnband@gmail.com', '$2y$10$XmGmOit155Zc6lQv9TSA0eFshWUFQfcjPCigBcvSy172peoQlQu0O', '0885348939', 'Blantyre', 'customer', 'assets/uploads/profiles/user_3_1776237564.jpg', 1, 0, 0, NULL, 0, '2026-04-15 06:51:33', '2026-07-22 23:07:05', '05097158960178bf99184a0766491c8e5039362776cdbe8d3cfc4edb0537700f', NULL, NULL),
(4, 'Dave', 'malawiserviceshub@gmail.com', '$2y$10$CwcbJpFuCs31MY.bVkzHiuhK8/FnvMKa.ZcqzOsMO3tBGfdtVYMFO', '+265888123456', 'Blantyre', 'admin', NULL, 1, 0, 0, NULL, 0, '2026-04-23 07:26:56', '2026-07-28 19:02:04', 'f5e246a908db77855fb11c3d34f693a0b76415cab40e7707e96d9a186854f608', 'ae684f8356a65cff80ac148b9e3e3841b272227e25a04aef69e69a6c27a231e2', '2026-09-19 04:13:06'),
(5, 'Janet', 'janetk@gmail.com', '$2y$10$53ws4pknAkqZwzUfE9o5fOGGk13LxrLaI/6VaBjy07SjriQE19bgS', '099116518', 'Ntcheu', 'customer', NULL, 1, 0, 0, NULL, 0, '2026-07-23 06:49:24', '2026-07-23 00:51:35', '84ba5e7e9af25cade7b266fe59ab9991835413b4588ba41b06173d233417bda4', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `provider_id` (`provider_id`),
  ADD KEY `service_category_id` (`service_category_id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_pair` (`user1_id`,`user2_id`),
  ADD KEY `user2_id` (`user2_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portfolio_id` (`portfolio_id`);

--
-- Indexes for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portfolio_id` (`portfolio_id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portfolio_id` (`portfolio_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portfolio_id` (`portfolio_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `qualifications`
--
ALTER TABLE `qualifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`service_category_id`) REFERENCES `service_categories` (`id`);

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `conversations_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD CONSTRAINT `portfolios_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `portfolios_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD CONSTRAINT `qualifications_ibfk_1` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
