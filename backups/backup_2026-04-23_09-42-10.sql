-- Malawi Service Marketplace Backup
-- Date: 2026-04-23 09:42:10

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `entity_type` varchar(50) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('1', '1', 'login', 'user', '1', 'User logged in', '::1', '2026-04-14 23:40:49');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('2', '3', 'login', 'user', '3', 'User logged in', '::1', '2026-04-14 23:51:52');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('3', '1', 'login', 'user', '1', 'User logged in', '::1', '2026-04-15 00:27:31');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('4', '1', 'login', 'user', '1', 'User logged in', '::1', '2026-04-15 01:38:46');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('5', '3', 'login', 'user', '3', 'User logged in', '::1', '2026-04-15 02:46:54');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('6', '1', 'login', 'user', '1', 'User logged in', '::1', '2026-04-15 02:47:59');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('7', '3', 'login', 'user', '3', 'User logged in', '::1', '2026-04-15 02:49:34');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('8', '1', 'login', 'user', '1', 'User logged in', '::1', '2026-04-15 10:24:48');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('9', '3', 'login', 'user', '3', 'User logged in', '::1', '2026-04-16 11:03:26');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('10', '3', 'login', 'user', '3', 'User logged in', '::1', '2026-04-16 16:58:11');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('11', '1', 'login', 'user', '1', 'User logged in', '::1', '2026-04-16 17:02:43');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('12', '3', 'login', 'user', '3', 'User logged in', '::1', '2026-04-16 17:03:27');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('13', '1', 'login', 'user', '1', 'User logged in', '::1', '2026-04-16 17:10:05');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('14', '4', 'login', 'user', '4', 'User logged in', '::1', '2026-04-23 00:27:20');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_address`, `created_at`) VALUES ('15', '4', 'login', 'user', '4', 'User logged in', '::1', '2026-04-23 00:32:41');

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `provider_id` (`provider_id`),
  KEY `service_category_id` (`service_category_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`),
  CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`service_category_id`) REFERENCES `service_categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `conversations`;
CREATE TABLE `conversations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user1_id` int(11) NOT NULL,
  `user2_id` int(11) NOT NULL,
  `last_message` text DEFAULT NULL,
  `last_message_time` datetime DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_pair` (`user1_id`,`user2_id`),
  KEY `user2_id` (`user2_id`),
  CONSTRAINT `conversations_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `users` (`id`),
  CONSTRAINT `conversations_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conversation_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `conversation_id` (`conversation_id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `portfolios`;
CREATE TABLE `portfolios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bio` text DEFAULT NULL,
  `experience_years` int(11) DEFAULT 0,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_complete` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `portfolios_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `portfolios_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `portfolios` (`id`, `user_id`, `bio`, `experience_years`, `hourly_rate`, `location`, `category_id`, `is_approved`, `created_at`, `is_complete`) VALUES ('1', '1', 'A skilled IT Technician', '3', '12000.00', 'Blantyre', '8', '0', '2026-04-14 23:28:39', '0');

DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `portfolio_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `images` text DEFAULT NULL,
  `videos` text DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `portfolio_id` (`portfolio_id`),
  CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `projects` (`id`, `portfolio_id`, `title`, `description`, `images`, `videos`, `completion_date`) VALUES ('1', '1', 'Malawi Services Hub Website', 'A services marketplace', 'assets/uploads/projects/1776245091_plumbing2.jpeg', 'assets/uploads/videos/1776245091_252100.mp4', '');
INSERT INTO `projects` (`id`, `portfolio_id`, `title`, `description`, `images`, `videos`, `completion_date`) VALUES ('2', '1', 'Malawi Services Hub Website', '', '', 'assets/uploads/videos/1776245166_252100.mp4', '');
INSERT INTO `projects` (`id`, `portfolio_id`, `title`, `description`, `images`, `videos`, `completion_date`) VALUES ('3', '1', 'Malawi Services Hub Web', 'service', 'assets/uploads/projects/1776245686_plumbing2.jpeg', 'assets/uploads/videos/1776245686_252100.mp4', '');

DROP TABLE IF EXISTS `qualifications`;
CREATE TABLE `qualifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `portfolio_id` int(11) NOT NULL,
  `degree` varchar(200) DEFAULT NULL,
  `institution` varchar(200) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `portfolio_id` (`portfolio_id`),
  CONSTRAINT `qualifications_ibfk_1` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `qualifications` (`id`, `portfolio_id`, `degree`, `institution`, `year`) VALUES ('2', '1', 'Bachelor of IT', 'BIU', '2026');

DROP TABLE IF EXISTS `service_categories`;
CREATE TABLE `service_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT 'fa-service',
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `service_categories` (`id`, `name`, `icon`, `is_active`) VALUES ('1', 'Plumbing', 'wrench', '1');
INSERT INTO `service_categories` (`id`, `name`, `icon`, `is_active`) VALUES ('2', 'Electrical', 'bolt', '1');
INSERT INTO `service_categories` (`id`, `name`, `icon`, `is_active`) VALUES ('3', 'Carpentry', 'hammer', '1');
INSERT INTO `service_categories` (`id`, `name`, `icon`, `is_active`) VALUES ('4', 'Cleaning', 'broom', '1');
INSERT INTO `service_categories` (`id`, `name`, `icon`, `is_active`) VALUES ('5', 'Painting', 'paint-roller', '1');
INSERT INTO `service_categories` (`id`, `name`, `icon`, `is_active`) VALUES ('6', 'Gardening', 'seedling', '1');
INSERT INTO `service_categories` (`id`, `name`, `icon`, `is_active`) VALUES ('7', 'Tutoring', 'chalkboard-user', '1');
INSERT INTO `service_categories` (`id`, `name`, `icon`, `is_active`) VALUES ('8', 'IT Support', 'laptop-code', '1');
INSERT INTO `service_categories` (`id`, `name`, `icon`, `is_active`) VALUES ('9', 'Photography', 'camera', '1');
INSERT INTO `service_categories` (`id`, `name`, `icon`, `is_active`) VALUES ('10', 'Catering', 'utensils', '1');

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) DEFAULT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES ('1', 'site_name', 'Malawi Service Marketplace', '2026-04-12 23:29:35');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES ('2', 'admin_email', 'admin@malawimarketplace.com', '2026-04-12 23:29:35');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES ('3', 'smtp_host', '', '2026-04-12 23:29:35');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES ('4', 'smtp_port', '', '2026-04-12 23:29:35');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES ('5', 'smtp_user', '', '2026-04-12 23:29:35');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES ('6', 'smtp_pass', '', '2026-04-12 23:29:35');

DROP TABLE IF EXISTS `skills`;
CREATE TABLE `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `portfolio_id` int(11) NOT NULL,
  `skill_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `portfolio_id` (`portfolio_id`),
  CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `skills` (`id`, `portfolio_id`, `skill_name`) VALUES ('17', '1', 'Coding');
INSERT INTO `skills` (`id`, `portfolio_id`, `skill_name`) VALUES ('18', '1', 'Graphic Design');

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `portfolio_id` int(11) NOT NULL,
  `client_name` varchar(100) DEFAULT NULL,
  `client_email` varchar(100) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `text` text NOT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `portfolio_id` (`portfolio_id`),
  CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `reset_password_expire` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `location`, `role`, `profile_pic`, `is_active`, `is_profile_complete`, `email_verified`, `twofa_secret`, `twofa_enabled`, `created_at`, `last_login`, `email_verification_token`, `reset_password_token`, `reset_password_expire`) VALUES ('1', 'Roy Dziyanjanani', 'roydziyanjanani8@gmail.com', '$2y$10$ySX4QxsVIWCdMm8s/ITYDux31FdFWR4SKwW/ucWMTVQa4GRVFwbK6', '+265885348937', 'Blantyre', 'provider', '', '1', '1', '0', '', '0', '2026-04-14 23:28:39', '2026-04-16 17:10:05', 'cd9c851ab501fb9f3aab16e530dc4750577a15615a98050f6413d2077bfd3d04', '6df3d6c3dda9b74c301268f5ca4b3d7323a64dd60f312a5dd791e4a192c255cf', '2026-04-15 10:26:30');
INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `location`, `role`, `profile_pic`, `is_active`, `is_profile_complete`, `email_verified`, `twofa_secret`, `twofa_enabled`, `created_at`, `last_login`, `email_verification_token`, `reset_password_token`, `reset_password_expire`) VALUES ('2', 'Jones', 'jones@gmail.com', '$2y$10$8jKRmWJVt1QbKLfV5Gkp1u0cjiOjfrh9j0BFVOI34EK.kyhxN7Fde', '0996967290', 'Blantyre', 'customer', '', '1', '0', '0', '', '0', '2026-04-14 23:49:15', '', 'c8e5936d03902737af5e7f43334509b0c12ab9fa830d52424245f84f2c9f1565', '', '');
INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `location`, `role`, `profile_pic`, `is_active`, `is_profile_complete`, `email_verified`, `twofa_secret`, `twofa_enabled`, `created_at`, `last_login`, `email_verification_token`, `reset_password_token`, `reset_password_expire`) VALUES ('3', 'Jaden', 'jaden@gmail.com', '$2y$10$XmGmOit155Zc6lQv9TSA0eFshWUFQfcjPCigBcvSy172peoQlQu0O', '0885348939', 'Blantyre', 'customer', 'assets/uploads/profiles/user_3_1776237564.jpg', '1', '0', '0', '', '0', '2026-04-14 23:51:33', '2026-04-16 17:03:27', '05097158960178bf99184a0766491c8e5039362776cdbe8d3cfc4edb0537700f', '', '');
INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `location`, `role`, `profile_pic`, `is_active`, `is_profile_complete`, `email_verified`, `twofa_secret`, `twofa_enabled`, `created_at`, `last_login`, `email_verification_token`, `reset_password_token`, `reset_password_expire`) VALUES ('4', 'Dave', 'dave@gmail.com', '$2y$10$CwcbJpFuCs31MY.bVkzHiuhK8/FnvMKa.ZcqzOsMO3tBGfdtVYMFO', '+265888123456', 'Blantyre', 'admin', '', '1', '0', '0', '', '0', '2026-04-23 00:26:56', '2026-04-23 00:32:41', 'f5e246a908db77855fb11c3d34f693a0b76415cab40e7707e96d9a186854f608', '', '');

