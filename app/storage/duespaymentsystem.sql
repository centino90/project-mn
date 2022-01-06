-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2022 at 08:49 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `duespaymentsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `profile_id` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fb_user_id` varchar(255) DEFAULT NULL,
  `fb_access_token` varchar(255) DEFAULT NULL,
  `google_user_id` varchar(255) DEFAULT NULL,
  `google_access_token` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT 'member',
  `profile_img_path` varchar(255) DEFAULT NULL,
  `thumbnail_img_path` varchar(255) DEFAULT NULL,
  `account_status` varchar(255) DEFAULT 'inactive',
  `logged_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `email_verified` varchar(255) DEFAULT NULL,
  `changing_email` varchar(255) DEFAULT NULL,
  `new_email` varchar(255) DEFAULT NULL,
  `new_password` varchar(255) DEFAULT NULL,
  `forgot_password_vkey` varchar(255) DEFAULT NULL,
  `account_registration_vkey` varchar(255) DEFAULT NULL,
  `change_email_vkey` varchar(255) DEFAULT NULL,
  `email_vkey` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `profile_id`, `email`, `password`, `fb_user_id`, `fb_access_token`, `google_user_id`, `google_access_token`, `role`, `profile_img_path`, `thumbnail_img_path`, `account_status`, `logged_at`, `created_at`, `deleted_at`, `email_verified`, `changing_email`, `new_email`, `new_password`, `forgot_password_vkey`, `account_registration_vkey`, `change_email_vkey`, `email_vkey`) VALUES
(20, '19', 'kecesomu@mailinator.com', '$2y$10$RMFOoXG4y9zU3ARd1FHmau3TfyqOEVQ1.H.AOrhAutCU2i35NmQ7i', NULL, NULL, NULL, NULL, 'admin', 'img/profiles/Sasha-1641123198.webp', 'img/profiles/thumbnails/Sasha-1641123198.webp', 'active', '2022-01-05 07:37:05', '2022-01-02 09:44:05', NULL, '1', NULL, NULL, NULL, NULL, '61d173f7ac9b8', NULL, '61d173e589b20'),
(22, NULL, 'ansit@superadmin.com', '$2y$10$eCnl6O8wXFfP66HNxbe6Ru/X/BvBPOqHpEOg6Tlab1heYA/c1f8zi', NULL, NULL, NULL, NULL, 'superadmin', NULL, NULL, 'inactive', NULL, '2022-01-05 11:17:34', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, NULL, 'carlos@superadmin.com', '$2y$10$eCnl6O8wXFfP66HNxbe6Ru/X/BvBPOqHpEOg6Tlab1heYA/c1f8zi', NULL, NULL, NULL, NULL, 'superadmin', NULL, NULL, 'inactive', NULL, '2022-01-05 11:17:34', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, NULL, 'president@superadmin.com', '$2y$10$eCnl6O8wXFfP66HNxbe6Ru/X/BvBPOqHpEOg6Tlab1heYA/c1f8zi', NULL, NULL, NULL, NULL, 'superadmin', NULL, NULL, 'inactive', NULL, '2022-01-05 11:17:34', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '271', 'xyfamele@mailinator.com', '$2y$10$/dWPs78Ghc9UmBL0CVQ0XObHLdDrK2YemmFYUCGXjMTxmiYGDZn2y', NULL, NULL, '105003354943600421494', 'ya29.a0ARrdaM9bo9nZmij5AQ1Wn_io--V5GrPNqFKrOKZ0gpZY1n82tALADza4KLw74LgAp_MUpbL4AGM-eOlTCpqMv3W7HXlerAz1jKucyvEZbzRUcXOX9irIfRTcK4Hb2YrIKz-lfww6uNsHyDRxK3rkjJvANKkt', 'admin', NULL, NULL, 'inactive', '2022-01-05 12:01:39', '2022-01-05 11:39:49', NULL, '1', NULL, NULL, NULL, NULL, '61d583a0e05d8', NULL, '61d58385a77b0'),
(27, '274', 'huzoli@mailinator.com', '$2y$10$kIv3dvd0aoaT9kyq4pb8KuD9ExwBn2RK1vZUrNG1dxBpF2QesdgFy', NULL, NULL, '108714037774712897467', 'ya29.a0ARrdaM-w0SQxwu_JEsvMg1TE9qxQqpfUgIIqV1NJX_u2QyYk79Bk48_cFhIWSFfGgkKLS2oiryLmnajdw4muCkLF3lV1E4oG4x-bkiaUd519Dk0vqN2am-3I31m8PY-WjYLyGAVmoDBVh-DOqk5sMTgdkOCrm_c', 'member', NULL, NULL, 'inactive', '2022-01-05 12:14:11', '2022-01-05 18:48:24', NULL, '1', NULL, NULL, NULL, NULL, '61d5eaeed7168', NULL, NULL),
(40, '356', 'zakunywi@mailinator.com', '$2y$10$RNyOmmB3anPUVvBtu/HNiuL8ydsmFyMg5CbUqWN738RbhLFoeikEe', NULL, NULL, '104128608322787432739', 'ya29.a0ARrdaM9CkoReTXRTAOJ9T_UPTsa7HOoGGyM_WnuhSLZG6QU5MeLtZmmzkGB7_sDaIKb7I-ANPdnV53CzyKeCjFxmBdV_kcF6WZL5YjLvjHaJeaXg_mSODcDVZZYu7KbcXp3lyox1XwqwkNnqyvBEhkuAoXBA', 'member', NULL, NULL, 'inactive', '2022-01-05 12:19:37', '2022-01-05 19:14:16', NULL, '1', NULL, NULL, NULL, NULL, '61d5ee2436ee8', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `initiator` varchar(255) DEFAULT NULL,
  `message` varchar(555) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `user_id`, `initiator`, `message`, `type`, `read_at`, `created_at`) VALUES
(1, '1', NULL, 'Admin: Daigdigan, Joan S. registered 8 payment to PDA', 'add_payment', NULL, '2021-12-20 12:47:38'),
(2, '1', NULL, 'Admin: Daigdigan, Joan S. registered an amount of 500 as dues payment to DCC', 'add_payment', NULL, '2021-12-20 12:49:22'),
(3, '1', NULL, 'Admin: Daigdigan, Joan S. registered an amount of 1000 as dues payment to PDA', 'add_payment', NULL, '2021-12-20 13:43:45'),
(4, '1', NULL, 'Admin: Daigdigan, Joan S. registered an amount of 500 as dues payment to DCC with an OR No. of 768', 'add_payment', NULL, '2021-12-20 14:03:47'),
(5, '1', NULL, 'Daigdigan, Joan S. (Admin): logged in successfully', 'user_login', NULL, '2021-12-20 14:08:55'),
(6, '1', NULL, 'Daigdigan, Joan S. (Admin): logged in successfully', 'user_login', NULL, '2021-12-20 14:42:20'),
(7, '1', NULL, 'Daigdigan, Joan S. (Admin): logged in successfully', 'user_login', NULL, '2021-12-20 15:44:14'),
(8, '1', NULL, 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-20 15:52:25'),
(9, '1', NULL, 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-20 20:20:26'),
(10, '1', NULL, 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-20 20:59:40'),
(11, '1', NULL, 'Admin: Daigdigan, Joan S.deactivated', 'change_status', NULL, '2021-12-20 21:00:00'),
(12, '1', NULL, 'Admin: Daigdigan, Joan S.deactivated', 'change_status', NULL, '2021-12-20 21:02:22'),
(13, '1', NULL, 'Admin: Daigdigan, Joan S.deactivated', 'change_status', NULL, '2021-12-20 21:06:31'),
(14, '1', NULL, 'Admin: Daigdigan, Joan S.activatedAlba, Ruby Socorro E.', 'change_status', NULL, '2021-12-20 21:06:44'),
(15, '1', NULL, 'Admin: Daigdigan, Joan S.activatedAlba, Ruby Socorro E.', 'change_status', NULL, '2021-12-20 21:07:04'),
(16, '1', NULL, 'Admin: Daigdigan, Joan S.deactivatedAlba, Ruby Socorro E.', 'change_status', NULL, '2021-12-20 21:09:29'),
(17, '1', NULL, 'Admin: Daigdigan, Joan S.activated Alba, Ruby Socorro E.', 'change_status', NULL, '2021-12-20 21:10:01'),
(18, '1', NULL, 'Admin: Daigdigan, Joan S.deactivated Alba, Ruby Socorro E.', 'change_status', NULL, '2021-12-20 21:11:06'),
(19, '1', NULL, 'Admin: Daigdigan, Joan S.activated Ansit, Anthony P.', 'change_status', NULL, '2021-12-20 21:11:21'),
(20, '1', NULL, 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-20 21:57:31'),
(21, '1', NULL, 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-20 22:12:10'),
(22, '1', NULL, 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-21 09:35:39'),
(23, '1', NULL, 'Admin: Daigdigan, Joan S.activated ', 'change_status', NULL, '2021-12-21 09:36:11'),
(24, '1', NULL, 'Admin: Daigdigan, Joan S.activated ', 'change_status', NULL, '2021-12-21 09:36:19'),
(25, '1', NULL, 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-21 11:00:03'),
(26, '1', NULL, 'Admin: Daigdigan, Joan S.updated remarks ', 'change_status', NULL, '2021-12-21 11:27:22'),
(27, '1', NULL, 'Admin: Daigdigan, Joan S.updated remarks De Guzman, Albert G.', 'change_status', NULL, '2021-12-21 11:33:23'),
(28, '1', NULL, 'Admin: Daigdigan, Joan S.updated remarks of De Guzman, Albert G.', 'change_status', NULL, '2021-12-21 11:34:46'),
(29, '1', NULL, 'Admin: Daigdigan, Joan S.updated remarks of De Guzman, Albert G.', 'change_status', NULL, '2021-12-21 11:35:14'),
(30, '1', NULL, 'Admin: Daigdigan, Joan S.deactivated of Falcon, Maria Veronica K.', 'change_status', NULL, '2021-12-21 11:42:49'),
(31, '1', NULL, 'Admin: Daigdigan, Joan S.updated remarks of De Guzman, Albert G.', 'change_status', NULL, '2021-12-21 11:49:14'),
(32, '1', NULL, 'Admin: Daigdigan, Joan S.activated of De Guzman, Albert G.', 'change_status', NULL, '2021-12-21 11:50:02'),
(33, '1', NULL, 'Admin: Daigdigan, Joan S.deactivated of De Guzman, Albert G.', 'change_status', NULL, '2021-12-21 11:50:11'),
(34, '1', NULL, 'Admin: Daigdigan, Joan S.activated of De Guzman, Albert G.', 'change_status', NULL, '2021-12-21 11:52:20'),
(35, '1', NULL, 'Admin: Daigdigan, Joan S.activated of Falcon, Maria Veronica K.', 'change_status', NULL, '2021-12-21 11:55:03'),
(36, '1', NULL, 'Admin: Daigdigan, Joan S.deactivated of Falcon, Maria Veronica K.', 'change_status', NULL, '2021-12-21 11:55:25'),
(37, '1', NULL, 'Admin: Daigdigan, Joan S.deactivated of De Guzman, Albert G.', 'change_status', NULL, '2021-12-21 11:55:28'),
(38, '1', NULL, 'Admin: Daigdigan, Joan S.updated remarks of De Guzman, Albert G.', 'change_status', NULL, '2021-12-21 11:55:33'),
(39, '1', NULL, 'Admin: Daigdigan, Joan S.activated of Falcon, Maria Veronica K.', 'change_status', NULL, '2021-12-21 11:55:40'),
(40, '1', NULL, 'Admin: Daigdigan, Joan S.updated remarks of De Guzman, Albert G.', 'change_status', NULL, '2021-12-21 11:56:13'),
(41, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S.updated remarks of Falcon, Maria Veronica K.', 'change_status', NULL, '2021-12-21 12:05:34'),
(42, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 6 payments.', 'add_payment', NULL, '2021-12-21 12:11:50'),
(43, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 30 as dues payment to PDA with an OR No. of 786', 'add_payment', NULL, '2021-12-21 12:18:26'),
(44, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S.deactivated of Yambao, Princess Katrina A.', 'change_status', NULL, '2021-12-21 12:36:48'),
(45, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S.updated remarks of ', 'change_status', NULL, '2021-12-21 13:07:32'),
(46, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-21 14:56:47'),
(47, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-21 22:20:01'),
(48, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-21 22:42:25'),
(49, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-21 22:50:55'),
(50, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 48 as dues payment to PDA with an OR No. of 722', 'add_payment', NULL, '2021-12-21 22:53:28'),
(51, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 500 as dues payment to PDA with an OR No. of ewqe123', 'add_payment', NULL, '2021-12-21 22:55:12'),
(52, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 49 as dues payment to PDA with an OR No. of 238', 'add_payment', NULL, '2021-12-21 22:57:08'),
(53, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 6 payments.', 'add_payment', NULL, '2021-12-21 23:08:03'),
(54, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 6 payments.', 'add_payment', NULL, '2021-12-21 23:19:22'),
(55, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 1 payments.', 'add_payment', NULL, '2021-12-21 23:24:21'),
(56, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 1 payments.', 'add_payment', NULL, '2021-12-21 23:24:52'),
(57, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 1 payments.', 'add_payment', NULL, '2021-12-21 23:26:38'),
(58, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 09:48:10'),
(59, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 10:02:14'),
(60, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 2 payments.', 'add_payment', NULL, '2021-12-22 10:40:44'),
(61, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 2 payments.', 'add_payment', NULL, '2021-12-22 10:42:59'),
(62, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 2 payments.', 'add_payment', NULL, '2021-12-22 10:45:43'),
(63, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 2 payments.', 'add_payment', NULL, '2021-12-22 10:49:19'),
(64, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 2 payments.', 'add_payment', NULL, '2021-12-22 10:52:13'),
(65, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 2 payments.', 'add_payment', NULL, '2021-12-22 10:53:06'),
(66, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 2 payments.', 'add_payment', NULL, '2021-12-22 10:55:02'),
(67, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 2 payments.', 'add_payment', NULL, '2021-12-22 10:57:07'),
(68, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 2 payments.', 'add_payment', NULL, '2021-12-22 10:57:26'),
(69, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 2 payments.', 'add_payment', NULL, '2021-12-22 10:59:10'),
(70, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 2 payments.', 'add_payment', NULL, '2021-12-22 11:08:11'),
(71, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 2 payments.', 'add_payment', NULL, '2021-12-22 11:10:06'),
(72, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 2 payments.', 'add_payment', NULL, '2021-12-22 11:11:10'),
(73, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S.deactivated of Daniels, Leslie R.', 'change_status', NULL, '2021-12-22 11:13:49'),
(74, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S.activated of Daniels, Leslie R.', 'change_status', NULL, '2021-12-22 11:13:53'),
(75, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 11:34:35'),
(76, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 13:06:30'),
(77, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 16:13:25'),
(78, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the profile of ', 'change_profile', NULL, '2021-12-22 16:36:15'),
(79, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the profile of Feria, Rene June V.', 'change_profile', NULL, '2021-12-22 16:39:00'),
(80, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the profile of Feria, Rene June V.', 'change_profile', NULL, '2021-12-22 16:40:36'),
(81, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the profile of Feria, Rene June V.', 'change_profile', NULL, '2021-12-22 16:40:45'),
(82, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the profile of Feria, Rene June V.', 'change_profile', NULL, '2021-12-22 16:40:52'),
(83, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 17:06:37'),
(84, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the personal info of Feria, Rene June V.', 'update_user', NULL, '2021-12-22 17:08:27'),
(85, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the personal info of Feria, Rene June V.', 'update_user', NULL, '2021-12-22 17:08:59'),
(86, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the personal info of Feria, Rene June V.', 'update_user', NULL, '2021-12-22 17:09:11'),
(87, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the personal info of Feria, Rene June V.', 'update_user', NULL, '2021-12-22 17:09:21'),
(88, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the personal info of Feria, Rene June V.', 'update_user', NULL, '2021-12-22 17:09:26'),
(89, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the personal info of Feria, Rene June V.', 'update_user', NULL, '2021-12-22 17:09:29'),
(90, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the personal info of Feria, Rene June V.', 'update_user', NULL, '2021-12-22 17:11:11'),
(91, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the personal info of Feria, Rene June V.', 'update_user', NULL, '2021-12-22 17:11:19'),
(92, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the license info of ', 'update_user', NULL, '2021-12-22 17:25:28'),
(93, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the license info of Feria, Rene June V.', 'update_user', NULL, '2021-12-22 17:25:45'),
(94, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the license info of Feria, Rene June V.', 'update_user', NULL, '2021-12-22 17:25:50'),
(95, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the license info of Feria, Rene June V.', 'update_user', NULL, '2021-12-22 17:26:03'),
(96, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the license info of Feria, Rene June V.', 'update_user', NULL, '2021-12-22 17:27:36'),
(97, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the clinic info of Feria, Rene June V.', 'update_user', NULL, '2021-12-22 17:39:29'),
(98, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 19:02:05'),
(99, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the clinic info of Daniels, Leslie R.', 'update_user', NULL, '2021-12-22 19:02:16'),
(100, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the emergency info of Daniels, Leslie R.', 'update_user', NULL, '2021-12-22 19:08:37'),
(101, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the emergency info of Daniels, Leslie R.', 'update_user', NULL, '2021-12-22 19:09:14'),
(102, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the emergency info of Daniels, Leslie R.', 'update_user', NULL, '2021-12-22 19:09:17'),
(103, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the emergency info of Daniels, Leslie R.', 'update_user', NULL, '2021-12-22 19:09:27'),
(104, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the emergency info of Daniels, Leslie R.', 'update_user', NULL, '2021-12-22 19:09:33'),
(105, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the emergency info of Daniels, Leslie R.', 'update_user', NULL, '2021-12-22 19:10:30'),
(106, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the emergency info of Daniels, Leslie R.', 'update_user', NULL, '2021-12-22 19:10:34'),
(107, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the emergency info of Daniels, Leslie R.', 'update_user', NULL, '2021-12-22 19:10:41'),
(108, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 19:59:15'),
(109, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 20:18:02'),
(110, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 20:31:53'),
(111, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 21:05:38'),
(112, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 21:07:14'),
(113, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 21:08:32'),
(114, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 21:11:27'),
(115, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 6 payments.', 'add_payment', NULL, '2021-12-22 21:15:12'),
(116, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 21:29:41'),
(117, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 21:49:46'),
(118, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 21:51:18'),
(119, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 22:21:31'),
(120, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-22 22:27:57'),
(121, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 6 payments.', 'add_payment', NULL, '2021-12-22 23:13:09'),
(122, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-23 10:48:46'),
(123, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-23 10:50:29'),
(124, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the personal info of Daigdigan, Joan S.', 'update_user', NULL, '2021-12-23 10:51:13'),
(125, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the license info of Daigdigan, Joan S.', 'update_user', NULL, '2021-12-23 10:51:21'),
(126, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the clinic info of Daigdigan, Joan S.', 'update_user', NULL, '2021-12-23 10:51:37'),
(127, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the clinic info of Daigdigan, Joan S.', 'update_user', NULL, '2021-12-23 10:52:08'),
(128, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-23 11:19:39'),
(129, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. deactivated DOMINGO, MARIA CRISTINA P.', 'change_status', NULL, '2021-12-23 11:52:17'),
(130, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. activated Maganda-Tiaga, Elaine Joy M.', 'change_status', NULL, '2021-12-23 11:52:30'),
(131, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. deactivated Mansukhani, Rosario H.', 'change_status', NULL, '2021-12-23 11:53:20'),
(132, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-23 12:14:15'),
(133, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-23 13:22:35'),
(134, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-23 14:09:11'),
(135, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-23 17:38:55'),
(136, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-23 18:00:41'),
(137, '100015', ',  .', ',  . (member): logged in successfully', 'user_login', NULL, '2021-12-26 05:57:45'),
(138, '100016', ',  .', ',  . (member): logged in successfully', 'user_login', NULL, '2021-12-26 05:59:48'),
(139, '100016', ',  .', ',  . (member): logged in successfully', 'user_login', NULL, '2021-12-26 06:01:01'),
(140, '100016', ',  .', ',  . (member): logged in successfully', 'user_login', NULL, '2021-12-26 06:01:04'),
(141, '100016', 'Johns, Abel M.', 'Johns, Abel M. (member): logged in successfully', 'user_login', NULL, '2021-12-26 06:02:14'),
(142, '100016', 'Johns, Abel M.', 'Johns, Abel M. (member): logged in successfully', 'user_login', NULL, '2021-12-26 06:05:45'),
(143, '100016', 'Johns, Abel M.', 'Johns, Abel M. (member): logged in successfully', 'user_login', NULL, '2021-12-26 06:10:00'),
(144, '100016', 'Johns, Abel M.', 'Johns, Abel M. (member): logged in successfully', 'user_login', NULL, '2021-12-26 06:12:43'),
(145, '100016', 'Johns, Abel M.', 'Johns, Abel M. (member): logged in successfully', 'user_login', NULL, '2021-12-26 06:55:30'),
(146, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-26 07:11:03'),
(147, '100016', 'Johns, Abel M.', 'Johns, Abel M. (member): logged in successfully', 'user_login', NULL, '2021-12-26 07:11:34'),
(148, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-28 07:20:39'),
(149, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the emergency info of Luayon, Aries G.', 'update_user', NULL, '2021-12-28 07:26:54'),
(150, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-30 07:43:03'),
(151, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the personal info of Daigdigan, Joan S.', 'update_user', NULL, '2021-12-30 07:43:25'),
(152, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. updated the license info of Daigdigan, Joan S.', 'update_user', NULL, '2021-12-30 07:44:02'),
(153, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 72 as dues payment to 57 with an OR No. of 244', 'add_dues', NULL, '2021-12-30 08:09:35'),
(154, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 96 as dues payment to 69 with an OR No. of 545', 'add_dues', NULL, '2021-12-30 08:11:06'),
(155, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 43 as dues payment to 1 with an OR No. of 646 and row no. of 40', 'add_dues', NULL, '2021-12-30 08:26:07'),
(156, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 25 as dues payment to 5 with an OR No. of 387 and row no. of 44', 'add_dues', NULL, '2021-12-30 08:30:20'),
(157, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 3 as dues payment to 39(1998-08-01) with an OR No. of 131 and row no. of 46', 'add_dues', NULL, '2021-12-30 08:32:52'),
(158, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 38 as dues payment to 37(1970) with an OR No. of 574 and row no. of 47', 'add_dues', NULL, '2021-12-30 08:33:17'),
(159, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 38 as dues payment to 37(1989) with an OR No. of 574 and row no. of 48', 'add_dues', NULL, '2021-12-30 08:33:43'),
(160, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 85 as dues payment to 90 (2014) with an OR No. of 796 and row no. of 49', 'add_dues', NULL, '2021-12-30 08:33:57'),
(161, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 90 as dues payment to 44 (2019) with an OR No. of 679 and row no. of 50', 'add_dues', NULL, '2021-12-30 08:35:25'),
(162, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 78 as dues payment to 100 (2002) with an OR No. of 654 and row no. of 51', 'add_dues', NULL, '2021-12-30 08:36:10'),
(163, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 32 as dues payment to PDA (2017) with an OR No. of 270 and row no. of 52', 'add_dues', NULL, '2021-12-30 08:38:47'),
(164, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 2 payments.', 'add_dues', NULL, '2021-12-30 08:44:10'),
(165, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 1 payments.', 'add_dues', NULL, '2021-12-30 08:44:50'),
(166, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 1 payments [Array]', 'add_dues', NULL, '2021-12-30 08:47:32'),
(167, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 1 payments [ PDA - 2010-02-03 (qwe123)]', 'add_dues', NULL, '2021-12-30 08:48:11'),
(168, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 1 payments [PDA - 2010-02-03 (#qwe123)]', 'add_dues', NULL, '2021-12-30 08:49:19'),
(169, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010-02-03 (#qwe123),PDA - 2010-02-03 (#asdw),DCC - 2010-02-03 (#qweqwq),DCC - 2010-02-03 (#trtrt)]', 'add_dues', NULL, '2021-12-30 08:50:39'),
(170, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123),PDA - 2010 (#asdw),DCC - 2010 (#qweqwq),DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 08:51:30'),
(171, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 08:51:55'),
(172, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 08:58:02'),
(173, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:29:02'),
(174, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:29:34'),
(175, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:32:59'),
(176, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:33:37'),
(177, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:37:44'),
(178, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:40:25'),
(179, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:40:45'),
(180, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:42:22'),
(181, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:42:56'),
(182, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:43:36'),
(183, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:45:44'),
(184, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:47:49'),
(185, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:48:04'),
(186, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:49:31'),
(187, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:50:11'),
(188, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:51:20'),
(189, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:53:26'),
(190, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:54:55'),
(191, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:55:10'),
(192, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:55:31'),
(193, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:56:23'),
(194, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:56:38'),
(195, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:57:28'),
(196, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:58:16'),
(197, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:59:07'),
(198, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 09:59:55'),
(199, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:00:50'),
(200, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:01:35'),
(201, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:07:12'),
(202, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:11:43'),
(203, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:13:28'),
(204, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:14:58'),
(205, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:16:24'),
(206, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:20:16'),
(207, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:21:15'),
(208, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:24:14'),
(209, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:25:54'),
(210, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:26:37'),
(211, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:27:30'),
(212, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:28:05'),
(213, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:28:17'),
(214, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:28:47'),
(215, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:29:50'),
(216, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 10:30:06'),
(217, '1', 'Daigdigan, Joan S.', 'Daigdigan, Joan S. (admin): logged in successfully', 'user_login', NULL, '2021-12-30 10:41:34'),
(218, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:18:10'),
(219, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:18:43'),
(220, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:20:12'),
(221, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:20:49'),
(222, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:23:28'),
(223, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:24:48'),
(224, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:25:28'),
(225, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:25:40'),
(226, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:26:42'),
(227, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:27:27'),
(228, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:27:45'),
(229, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:27:54'),
(230, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:28:51'),
(231, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:30:08'),
(232, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:30:44'),
(233, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:31:24'),
(234, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:33:12'),
(235, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:33:56'),
(236, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:34:20'),
(237, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:34:33'),
(238, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:39:02'),
(239, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:40:13'),
(240, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:42:36'),
(241, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2021-12-30 11:45:53'),
(242, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 72 as dues payment to DCC (1997) with an OR No. of 203 and row no. of 346', 'add_dues', NULL, '2021-12-30 11:50:17'),
(243, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 99 as dues payment to PDA (1991) with an OR No. of 521 and row no. of 347', 'add_dues', NULL, '2021-12-30 11:50:27'),
(244, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 91 as dues payment to PDA (1998) with an OR No. of 140 and row no. of 348', 'add_dues', NULL, '2021-12-30 11:50:45'),
(245, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 88 as dues payment to PDA (2016) with an OR No. of 536 and row no. of 349', 'add_dues', NULL, '2021-12-30 11:53:53'),
(246, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 27 as dues payment to PDA (2002) with an OR No. of 700 and row no. of 350', 'add_dues', NULL, '2021-12-30 11:54:07'),
(247, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 29 as dues payment to PDA (2005) with an OR No. of 693 and row no. of 351', 'add_dues', NULL, '2021-12-30 11:54:19'),
(248, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 99 as dues payment to DCC (1989) with an OR No. of 783 and row no. of 352', 'add_dues', NULL, '2021-12-30 11:55:01'),
(249, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 99 as dues payment to DCC (1989) with an OR No. of 783 and row no. of 353', 'add_dues', NULL, '2021-12-30 11:55:13'),
(250, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 99 as dues payment to DCC (1989) with an OR No. of 783 and row no. of 354', 'add_dues', NULL, '2021-12-30 11:55:16'),
(251, '1', 'Daigdigan, Joan S.', 'Admin: Daigdigan, Joan S. registered an amount of 78 as dues payment to DCC (1986) with an OR No. of 486 and row no. of 355', 'add_dues', NULL, '2021-12-30 11:56:26'),
(252, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2021-12-31 07:19:12'),
(253, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2021-12-31 07:29:41'),
(254, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2021-12-31 07:33:55'),
(255, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2021-12-31 08:17:13'),
(256, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-01 06:29:23'),
(257, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-01 06:29:53'),
(258, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-01 06:36:29'),
(259, '1', 'Barnett, Whilemina R.', 'Barnett, Whilemina R. (member): logged in successfully', 'user_login', NULL, '2022-01-01 06:45:06'),
(260, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-01 06:58:08'),
(261, '1', 'Barnett, Whilemina R.', 'Barnett, Whilemina R. (member): logged in successfully', 'user_login', NULL, '2022-01-01 07:05:52'),
(262, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-01 07:05:58'),
(263, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-01 07:33:01'),
(264, '1', 'Barnett, Whilemina R.', 'Barnett, Whilemina R. (member): logged in successfully', 'user_login', NULL, '2022-01-01 07:39:25'),
(265, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-01 07:41:07'),
(266, '1', 'Barnett, Whilemina R.', 'Barnett, Whilemina R. (member): logged in successfully', 'user_login', NULL, '2022-01-01 07:48:45'),
(267, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-01 08:02:21'),
(268, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-01 08:03:38'),
(269, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-01 08:07:53'),
(270, '1', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-01 08:21:50'),
(271, '13', 'Ansit, Anthony J.', 'Ansit, Anthony J. (): logged in successfully', 'user_login', NULL, '2022-01-02 05:26:02'),
(272, '18', 'Qwe, Adsadasd', 'Qwe, Adsadasd (): logged in successfully', 'user_login', NULL, '2022-01-02 05:40:40'),
(273, '20', 'Dickerson, Sasha R.', 'Dickerson, Sasha R. (member): logged in successfully', 'user_login', NULL, '2022-01-02 09:57:08'),
(274, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-02 10:00:24'),
(275, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-02 10:35:56'),
(276, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. imported 2 profiles.', 'add_profile', NULL, '2022-01-02 10:36:59'),
(277, '21', 'Qwe, Adsadasd', 'Qwe, Adsadasd (member): logged in successfully', 'user_login', NULL, '2022-01-02 10:44:15'),
(278, '21', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-02 10:45:11'),
(279, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-02 10:45:22'),
(280, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2022-01-02 10:53:05'),
(281, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2022-01-02 10:53:41'),
(282, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. registered an amount of 86 as dues payment to DCC (2007) with an OR No. of 166 and row no. of 472', 'add_dues', NULL, '2022-01-02 10:56:30'),
(283, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. registered an amount of 21 as dues payment to DCC (1983) with an OR No. of 241 and row no. of 473', 'add_dues', NULL, '2022-01-02 10:56:36'),
(284, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2022-01-02 11:14:20'),
(285, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. imported 4 payments [PDA - 2010 (#qwe123), PDA - 2010 (#asdw), DCC - 2010 (#qweqwq), DCC - 2010 (#trtrt)]', 'add_dues', NULL, '2022-01-02 11:16:08'),
(286, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. imported 1 payments [PDA - 2010 (#qwe123)]', 'add_dues', NULL, '2022-01-02 11:29:40'),
(287, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. imported 1 payments [PDA - 2010 (#qwe123)]', 'add_dues', NULL, '2022-01-02 11:30:07'),
(288, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the profile of De Guzman, Albert G.', 'update_user', NULL, '2022-01-02 11:55:48'),
(289, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the profile of Daigdigan, Joan S.', 'update_user', NULL, '2022-01-02 11:56:12'),
(290, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-02 12:51:11'),
(291, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. imported 1 payments [PDA - 2010 (#qwe123)]', 'add_dues', NULL, '2022-01-02 12:51:42'),
(292, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. registered an amount of 69 as dues payment to PDA (1989) with an OR No. of 49 and row no. of 494', 'add_dues', NULL, '2022-01-02 13:01:53'),
(293, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. registered an amount of 69 as dues payment to PDA (1989) with an OR No. of 49 and row no. of 495', 'add_dues', NULL, '2022-01-02 13:02:00'),
(294, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. registered an amount of 23 as dues payment to DCC (1994) with an OR No. of 135 and row no. of 496', 'add_dues', NULL, '2022-01-02 13:04:23'),
(295, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. registered an amount of 23 as dues payment to DCC (1994) with an OR No. of 135 and row no. of 497', 'add_dues', NULL, '2022-01-02 13:04:38'),
(296, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. registered an amount of 23 as dues payment to DCC (1994) with an OR No. of 135 and row no. of 498', 'add_dues', NULL, '2022-01-02 13:04:55'),
(297, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. registered an amount of 36 as dues payment to PDA (1999) with an OR No. of 632 and row no. of 499', 'add_dues', NULL, '2022-01-02 13:05:00'),
(298, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. registered an amount of 86 as dues payment to PDA (2006) with an OR No. of 3 and row no. of 500', 'add_dues', NULL, '2022-01-02 13:05:11'),
(299, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. registered an amount of 86 as dues payment to PDA (2006) with an OR No. of 3 and row no. of 501', 'add_dues', NULL, '2022-01-02 13:06:26'),
(300, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the profile of Hao, Jean M.', 'update_user', NULL, '2022-01-02 13:13:23'),
(301, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the profile of Hao, Jean M.', 'update_user', NULL, '2022-01-02 13:13:48'),
(302, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the profile of Hao, Jean M.', 'update_user', NULL, '2022-01-02 13:13:52'),
(303, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the personal info of Ansit, Anthony J.', 'update_user', NULL, '2022-01-02 13:14:30'),
(304, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the license info of Ansit, Anthony J.', 'update_user', NULL, '2022-01-02 13:14:37'),
(305, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the clinic info of Ansit, Anthony J.', 'update_user', NULL, '2022-01-02 13:14:40'),
(306, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the emergency info of Ansit, Anthony J.', 'update_user', NULL, '2022-01-02 13:14:43'),
(307, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the personal info of Ansit, Anthony J.', 'update_user', NULL, '2022-01-02 13:15:41'),
(308, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the license info of Ansit, Anthony J.', 'update_user', NULL, '2022-01-02 13:15:44'),
(309, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the emergency info of Ansit, Anthony J.', 'update_user', NULL, '2022-01-02 13:17:29'),
(310, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the emergency info of Ansit, Anthony J.', 'update_user', NULL, '2022-01-02 13:17:33'),
(311, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the emergency info of Ansit, Anthony J.', 'update_user', NULL, '2022-01-02 13:17:36'),
(312, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the emergency info of Ansit, Anthony J.', 'update_user', NULL, '2022-01-02 13:17:44'),
(313, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. imported 2 profiles.', 'add_profile', NULL, '2022-01-02 15:23:00'),
(314, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the emergency info of Ansit, Anthony J.', 'update_user', NULL, '2022-01-02 15:43:56'),
(315, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. updated the personal info of Ansit, Anthony J.', 'update_user', NULL, '2022-01-02 16:18:26'),
(316, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-04 14:06:47'),
(317, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. imported 994 profiles.', 'add_profile', NULL, '2022-01-04 16:36:25'),
(318, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-04 17:02:12'),
(319, '20', 'Dickerson, Sasha R.', 'Admin: Dickerson, Sasha R. imported 994 profiles.', 'add_profile', NULL, '2022-01-04 17:41:28'),
(320, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-04 18:11:14'),
(321, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-04 18:11:35'),
(322, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-04 18:12:02');
INSERT INTO `activities` (`id`, `user_id`, `initiator`, `message`, `type`, `read_at`, `created_at`) VALUES
(323, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-04 18:12:57'),
(324, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-04 18:14:12'),
(325, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-04 18:18:22'),
(326, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-04 18:19:00'),
(327, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-04 18:19:43'),
(328, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-05 10:31:03'),
(329, '25', 'APURADA, TERESA D.', 'APURADA, TERESA D. (member): logged in successfully', 'user_login', NULL, '2022-01-05 11:40:42'),
(330, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-05 11:40:51'),
(331, '20', NULL, ' (admin): logged in successfully', 'user_login', NULL, '2022-01-05 14:37:04'),
(332, '25', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-05 14:38:21'),
(333, '25', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-05 15:15:54'),
(334, '25', 'APURADA, TERESA D.', 'APURADA, TERESA D. (member): logged in successfully', 'user_login', NULL, '2022-01-05 15:20:38'),
(335, '25', 'APURADA, TERESA D.', 'APURADA, TERESA D. (member): logged in successfully', 'user_login', NULL, '2022-01-05 15:24:29'),
(336, '25', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-05 15:34:51'),
(337, '25', 'APURADA, TERESA D.', 'APURADA, TERESA D. (member): logged in successfully', 'user_login', NULL, '2022-01-05 18:44:10'),
(338, '25', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-05 18:44:58'),
(339, '25', 'APURADA, TERESA D.', 'APURADA, TERESA D. (member): logged in successfully', 'user_login', NULL, '2022-01-05 18:48:29'),
(340, '25', NULL, ' (member): logged in successfully', 'user_login', NULL, '2022-01-05 18:48:50'),
(341, '25', 'APURADA, TERESA D.', 'APURADA, TERESA D. (member): logged in successfully', 'user_login', NULL, '2022-01-05 18:50:14'),
(342, '27', 'BANGI, LORI M.', 'BANGI, LORI M. (member): logged in successfully', 'user_login', NULL, '2022-01-05 19:01:14'),
(343, '27', 'BANGI, LORI M.', 'BANGI, LORI M. (member): logged in successfully', 'user_login', NULL, '2022-01-05 19:01:24'),
(344, '25', 'APURADA, TERESA D.', 'APURADA, TERESA D. (member): logged in successfully', 'user_login', NULL, '2022-01-05 19:01:39'),
(345, '27', 'BANGI, LORI M.', 'BANGI, LORI M. (member): logged in successfully', 'user_login', NULL, '2022-01-05 19:14:11'),
(346, '40', 'Estrada, Lucy L.', 'Estrada, Lucy L. (member): logged in successfully', 'user_login', NULL, '2022-01-05 19:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE `clinics` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `contact_number` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`user_id`, `name`, `street`, `district`, `city`, `contact_number`) VALUES
(1, 'Morgan Key', 'Fugit ea commodo et debitis i', 'Qui non nisi qui voluptatem s', 'Deleniti et amet est eaque do', '499'),
(2, 'De Guzman Dental Clinic', 'Door 6 Galaxy Arcade Ilustre st. Davao City', '', '76A', '0822229957'),
(3, 'Tooth Friendly Dental Clinic', 'Doir A7 Quibod Bldg.(union Bank) Rizal St.', '3A / District 1', 'Davao City', '09157719183'),
(4, 'tooth land dental clinic ', '055B Quezon Ave., Cotabato City', '', 'cotabato city', '4216091'),
(6, 'Horfilla Dental Clinic', '2nd floor Callao Building, 20 Inigo st., Obrero', '18-B', 'Davao city', '09088922517'),
(7, 'Smileguard ', 'Unit 107 Goldwin Bldg Quirino St Davao city ', 'District 1', 'Davao', '3003424'),
(8, 'jimenez dental clinic', 'room 106 la cima bldg 2', 'palma gil st', 'davao city', '2277461'),
(9, 'Ivy Baitista-Magbiray Orthodontic clinic', 'Unit 10, 2nd flr, Don Dionisio Complex, Cabagiuo Ave. Davao City', 'Agdao', 'Davao', '09989944764'),
(10, 'Flozz Dental Clinic', 'Door # 3 Cisa Building, Jacinto Street', 'Barangay 32', 'Davao City', '2860048'),
(11, 'QUINONEZ-CELIS Dental Clijic', 'Unit 5 #26 Juna Ave Juna Subdivision', 'Matina', 'Davao City ', '09258499385'),
(12, 'Yardley Middleton', 'Qui expedita at praesentium ne', 'Explicabo Dolorem et omnis se', 'Voluptatem vel commodi nostrud', '383'),
(13, 'Preston Best', 'Molestias ullamco et eaque tem', 'Et dolore non dolore reprehend', 'Sit ut voluptate sit enim comm', '483'),
(14, 'Sabado-Cuaton Dental Clinic', 'Door 2F Penta Point Bldg. Km5 San Pedro Village Extension', 'Buhangin', 'Davao City', '+639421551053'),
(15, 'BARBON DENTAL CLINIC', 'Phase 2, Sandawa road', 'BARANGAY 76-A', 'Davao city', '09214525048'),
(16, 'Salvadico Dental Clinic', '#11, T.Martinez st. PH 2 SIR, New Matina Davao City', '76-A', 'Davao City', '09176180668'),
(17, 'Ducase family care', 'Door 1 and 2 L/A building lapu lapu street agdao', 'Agdao', 'Davao city', '3241352'),
(18, '', '', '', '', ''),
(19, 'Lori Moral-Bangi', '2nd flr greenfield building Purok 4 poblacion BE dujali davao del norte', 'Dujali', 'Be dujali', '09228981556'),
(20, 'Carolyn Irwin', 'Dolor itaque qui obcaecati cul', 'Id voluptatum unde nisi rerum', 'Omnis sunt et sequi assumenda', '267'),
(21, '', '', '', '', ''),
(22, 'Smile Guard Dental Clinic', 'unit 107 Goldwin Bldg. Quirini Ave. ', 'District 1', 'Davao', '3314122'),
(24, 'DE LIMA DENTAL CARE ', 'S207 HEALTH SCIENCE AND WELLNESS CENTER MDMRCI HOSPITAL BAJADA DAVAO CITY ', '20-B', 'DAVAO CITY ', '287 7777 loc. 2207'),
(25, 'Ethel Caceres ', 'Daily Fit Dental Wellness Clinic Door 2 2nd floor LTG Bldg Km. 8', 'Sasa', 'Davao City ', '9279008112'),
(26, 'M C Suobiron Dental Clinic', 'Door 3 Aranas bldg. Maya st. Ecoland 2', 'Bucana', 'Davao City', '09228217339'),
(27, 'Smile Doctor Dental and Orthodontic Clinic', 'Door 1, Normalita Bldg., Lim St.', 'Toril', 'Davao City', '09639719658'),
(28, 'Hernaez-Mansukhani Dental Clinic', 'Door 3, Bldg. 2, Fuent Bldg., 234 Juan Luna St.', '29-C', 'DAVAO CITY', '222-2244'),
(29, 'Molar world dental ', 'CM Recto', 'Baranggay 34-D', 'Davao city ', '09094878090'),
(30, 'Toothfully Yours Dental Care', 'Door # 3, Quisa Realty, Sampaguita St., Mintal, Davao City', 'Mintal', 'Davao City', '09089882163'),
(31, 'Aim Dental Avenue', 'Level 2-202, robinsons cybergate, jp laurel', 'Buhangin', 'Davao', ''),
(32, 'Hernaez-Mansukhani Dental Clinic', 'Bldg 2 Door 3 Fuente Juan Luna Bldg, 234 Jyan Luna St.', 'Barangay 29-C', 'Davao City', '(082)2222244'),
(33, 'Nazareno Dental Clinic', '88 Cor inigo N. Torres BO. Obrero Davao City', '18-B', 'Davao City', '09156513662'),
(34, 'Clitar Dental Clinic', 'G/F Clitar Building Daang Patnubay St SIR Phase 1 DC', 'Bucana', 'Davao City', '09094755442'),
(35, 'Booc-Nombrado Dental Clinic', 'Booc-Nombrado Dental Clinic, Malanos St., ', 'Calinan', 'Davao City', '(0943) 368 9728'),
(36, 'Apurada Dental Clinic', 'Door 8.Mantex Arcade.Magallanes Davao City', '1', 'Davao', '09338577230'),
(37, '', '', '', '', ''),
(38, 'Yambao dental clinic', 'Esperanza building, 2nd floor, green meadows village, ', 'Brgy sto nino, tugbok district', 'Davao city', '019190984145'),
(39, 'Urbidontics', '2nd floor Abreeza Mall, J.P. Laurel Ave.', 'Bajada', 'Davao City', '09228025948'),
(40, 'Dr. Carrie Lou Umusig-Mendez', 'Door 1 Moneygate Bldg., Ponciano St', 'Brgy 20-B(Pob)', 'Davao City', '09778091220'),
(42, 'Borres Dental Clinic', 'Ph-2,Abukay St D.D.F Village ', 'Mandug,Buhangin ', 'Davao City', '227-1624'),
(43, 'Toothway Dental Clinic', 'G. Ortiz Road, Ulas', 'Talomo', 'Davao City', '09306639003'),
(44, 'Jacqueline Galagate Delgado', '217 R.Castillo St. Brgy. Ubalde Agdao Davao City', 'Ubalde', 'Davao City', '09107149326  09776231495'),
(45, 'AJ Lim Dental Clinic ', '498 Quirino Ave fronting Palma Gil Elementary school ', '9A', 'Davao City', '2219173'),
(47, 'Maganda Tiaga dental clinic', 'Rm 5 grandma complex agton st toril dc', 'Toril', 'Davao city', '0922 883 6897'),
(48, 'Cabalza-Susi Dental Clinic', '05 Oriole st., St. Michael village 2, Maa, Davao City', 'Maa', 'Davao City', '09228089336'),
(49, 'Maria Cristina Domingo', 'Unit 507 Davao Doctors Hospital Medical Tower, Quirino Ave., Davao City', 'Poblacion District', 'Davao City', '09396141011'),
(50, 'dent-all dental center', 'door 3 aala building mc. arthur highway', 'matina ', 'davao city', '2952057'),
(602, 'Harriet Hutchinson', 'Aliquam sequi sunt omnis non n', 'Deleniti aut veniam nihil nos', 'Qui veniam ea quae ad molesti', '672'),
(100016, 'Jena Sheppard', 'Autem culpa tempor deserunt s', 'Optio beatae et vel blanditii', 'Exercitationem id ut minus dol', '70');

-- --------------------------------------------------------

--
-- Table structure for table `dues`
--

CREATE TABLE `dues` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date_posted` date NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  `amount` int(11) NOT NULL,
  `channel` varchar(255) DEFAULT NULL,
  `or_number` varchar(255) DEFAULT NULL,
  `remarks` varchar(555) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dues`
--

INSERT INTO `dues` (`id`, `user_id`, `type`, `date_posted`, `date_created`, `amount`, `channel`, `or_number`, `remarks`) VALUES
(285, 1, 'PDA', '0000-00-00', '2005-05-15', 1000, 'gcash', 'qwe1212', NULL),
(286, 2, 'PDA', '0000-00-00', '2010-05-15', 1000, 'gcash', '123qweqw', 'last payed 1 year ago'),
(287, 3, 'PDA', '0000-00-00', '2015-05-15', 1000, 'gcash', 'weadasqq1', NULL),
(288, 4, 'PDA', '0000-00-00', '2021-05-15', 1000, 'gcash', 'weert555', 'transferred'),
(289, 6, 'PDA', '0000-00-00', '2021-05-15', 1000, 'gcash', 'tertryu767', NULL),
(290, 1, 'PDA', '0000-00-00', '2021-12-23', 82, 'Hic maiores veniam libero con', '447', 'Occaecat suscipit vitae aute e'),
(291, 1, 'dcc', '0000-00-00', '2005-05-15', 1000, 'gcash', 'qwe1212', NULL),
(292, 2, 'dcc', '0000-00-00', '2010-05-15', 1000, 'gcash', '123qweqw', 'last payed 1 year ago'),
(293, 3, 'dcc', '0000-00-00', '2015-05-15', 1000, 'gcash', 'weadasqq1', NULL),
(294, 4, 'dcc', '0000-00-00', '2021-05-15', 1000, 'gcash', 'weert555', 'transferred'),
(295, 6, 'dcc', '0000-00-00', '2021-05-15', 1000, 'gcash', 'tertryu767', NULL),
(296, 4, 'DCC', '2021-12-27', '2021-12-27', 99, 'Harum deleniti do dolor ab sit', '637', 'Sunt reprehenderit soluta co'),
(297, 4, 'DCC', '1982-07-03', '2021-12-27', 96, 'Tempor nihil cumque ea blandit', '374', 'Sed ipsum deserunt enim omnis');

-- --------------------------------------------------------

--
-- Table structure for table `dues22`
--

CREATE TABLE `dues22` (
  `id` int(11) NOT NULL,
  `profile_id` varchar(255) DEFAULT NULL,
  `prc_number` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `channel` varchar(255) DEFAULT NULL,
  `or_number` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `date_posted` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dues22`
--

INSERT INTO `dues22` (`id`, `profile_id`, `prc_number`, `amount`, `type`, `channel`, `or_number`, `remarks`, `date_posted`, `created_at`, `deleted_at`) VALUES
(460, '19', '123415', '100', 'PDA', 'qweqwe', 'qwe123', NULL, '2009-10-15', '2021-12-31 04:49:29', NULL),
(461, NULL, 'asdsad2', '200', 'PDA', 'qweqwe', 'asdw', NULL, '2010-02-03', '2021-12-31 04:49:29', NULL),
(462, NULL, 'asdzxcz', '111', 'DCC', 'qweqwe', 'qweqwq', NULL, '2010-02-03', '2021-12-31 04:49:29', NULL),
(463, NULL, 'dfgdf', '4343', 'DCC', 'qweqwe', 'trtrt', NULL, '2010-02-03', '2021-12-31 04:49:29', NULL),
(464, '19', '123415', '100', 'PDA', 'qweqwe', 'qwe123', NULL, '2010-02-03', '2022-01-02 10:53:05', NULL),
(465, NULL, 'asdsad2', '200', 'PDA', 'qweqwe', 'asdw', NULL, '2010-02-03', '2022-01-02 10:53:05', NULL),
(466, NULL, 'asdzxcz', '111', 'DCC', 'qweqwe', 'qweqwq', NULL, '2010-02-03', '2022-01-02 10:53:05', NULL),
(467, NULL, 'dfgdf', '4343', 'DCC', 'qweqwe', 'trtrt', NULL, '2010-02-03', '2022-01-02 10:53:05', NULL),
(469, NULL, 'asdsad2', '200', 'PDA', 'qweqwe', 'asdw', NULL, '2010-02-03', '2022-01-02 10:53:41', NULL),
(470, NULL, 'asdzxcz', '111', 'DCC', 'qweqwe', 'qweqwq', NULL, '2010-02-03', '2022-01-02 10:53:41', NULL),
(471, NULL, 'dfgdf', '4343', 'DCC', 'qweqwe', 'trtrt', NULL, '2010-02-03', '2022-01-02 10:53:41', NULL),
(472, NULL, 'jyfeq', '86', 'DCC', '37', '166', 'Corporis quod obcaecati duis q', '2007-01-01', '2022-01-02 10:56:29', NULL),
(473, NULL, 'yrtyrty', '21', 'DCC', '97', '241', 'Sed mollit quia sed amet rem ', '1983-03-01', '2022-01-02 10:56:36', NULL),
(477, NULL, 'asdsad2', '200', 'PDA', 'qweqwe', 'asdw', NULL, '2010-02-03', '2022-01-02 11:14:20', NULL),
(478, NULL, 'asdzxcz', '111', 'DCC', 'qweqwe', 'qweqwq', NULL, '2010-02-03', '2022-01-02 11:14:20', NULL),
(479, NULL, 'dfgdf', '4343', 'DCC', 'qweqwe', 'trtrt', NULL, '2010-02-03', '2022-01-02 11:14:20', NULL),
(481, NULL, 'asdsad2', '200', 'PDA', 'qweqwe', 'asdw', NULL, '2010-02-03', '2022-01-02 11:16:08', NULL),
(482, NULL, 'asdzxcz', '111', 'DCC', 'qweqwe', 'qweqwq', NULL, '2010-02-03', '2022-01-02 11:16:08', NULL),
(483, NULL, 'dfgdf', '4343', 'DCC', 'qweqwe', 'trtrt', NULL, '2010-02-03', '2022-01-02 11:16:08', NULL),
(494, NULL, 'pasyn', '69', 'PDA', '3', '49', 'Est amet natus dignissimos do', '1982-04-01', '2022-01-02 13:01:53', NULL),
(495, NULL, 'pasyn', '69', 'PDA', '3', '49', 'Est amet natus dignissimos do', '1989-04-01', '2022-01-02 13:02:00', NULL),
(496, NULL, 'vugefepa', '23', 'DCC', '87', '135', 'Sit minim velit omnis provide', '1994-08-01', '2022-01-02 13:04:23', NULL),
(497, NULL, 'vugefepa', '23', 'DCC', '87', '135', 'Sit minim velit omnis provide', '1994-08-01', '2022-01-02 13:04:38', NULL),
(500, NULL, 'adsqdqe21', '86', 'PDA', '79', '3', 'Est aut tempor officia qui err', '2006-02-01', '2022-01-02 13:05:11', NULL),
(501, '19', 'weqwe', '86', 'PDA', '79', '3', 'Est aut tempor officia qui err', '2011-02-01', '2022-01-02 13:06:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `status_remarks` varchar(555) DEFAULT NULL,
  `membership_date` date DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `fb_account_name` varchar(255) DEFAULT NULL,
  `prc_number` varchar(255) DEFAULT NULL,
  `prc_registration_date` date DEFAULT NULL,
  `prc_expiration_date` date DEFAULT NULL,
  `field_practice` varchar(255) DEFAULT NULL,
  `type_practice` varchar(255) DEFAULT NULL,
  `clinic_name` varchar(255) DEFAULT NULL,
  `clinic_street` varchar(255) DEFAULT NULL,
  `clinic_district` varchar(255) DEFAULT NULL,
  `clinic_city` varchar(255) DEFAULT NULL,
  `clinic_contact` varchar(255) DEFAULT NULL,
  `emergency_person_name` varchar(255) DEFAULT NULL,
  `emergency_address` varchar(255) DEFAULT NULL,
  `emergency_contact_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `payment_status`, `status_remarks`, `membership_date`, `first_name`, `middle_name`, `last_name`, `birthdate`, `address`, `contact_number`, `gender`, `fb_account_name`, `prc_number`, `prc_registration_date`, `prc_expiration_date`, `field_practice`, `type_practice`, `clinic_name`, `clinic_street`, `clinic_district`, `clinic_city`, `clinic_contact`, `emergency_person_name`, `emergency_address`, `emergency_contact_number`, `created_at`, `deleted_at`) VALUES
(19, 'dormant', NULL, NULL, 'Sasha', 'Rhiannon Weaver', 'Dickerson', '1997-06-07', 'Accusantium iure quia aut dist', '843', 'Female', 'Xyla Hatfield', '46833', '2010-10-29', '2022-01-22', 'Periodontics', 'Clinic Owner', 'Carolyn Irwin', 'Dolor itaque qui obcaecati cul', 'Id voluptatum unde nisi rerum', 'Omnis sunt et sequi assumenda', '267', 'Anjolie Johns', 'Libero autem non quae est eni', '679', '2022-01-02 09:49:42', NULL),
(266, NULL, NULL, NULL, 'ZEHANNE', 'UMAR', 'ABALON', '1983-12-19', 'SAN LORENZO PUAN DAVAO CITY', '09773544890', 'Female', 'Zehanne Umar Abalon', '48880', '0000-00-00', '0000-00-00', 'General Practice', 'Due to pandemic im not practicing', '', '', '', '', '', 'RIHANNE UMAR JAILAN', 'SAN LORENZO PUAN', '09171297988', '2022-01-04 17:41:22', NULL),
(267, NULL, NULL, NULL, 'ROSIE', 'B.', 'ABEQUIBEL', '1960-03-03', 'PUROK 12 KM 14 ROSE ST SAN MIGUEL  VILLAGE PANACAN DAVAO CITY', '09228592689', 'Female', 'Mc B.Sie', '23211', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Abequibel Dental  Clinic', 'Purok 12 Km 14 Rose st San Miguel  Vill', 'Panacan', 'Davao City', '09228592689', 'MATTHEW  B.ABEQUIBEL', 'PUROK 12 KM 14 ROSE ST SAN  MIGUEL  VILL PANACAN DAVAO CITY', '09673547466', '2022-01-04 17:41:22', NULL),
(268, NULL, NULL, NULL, 'MARVIN', 'BANDOQUILLO', 'AGAWIN', '1972-04-18', '12 RICARDO ST, JUNA SUBDIVISION, DAVAO CITY', '09322990484', 'Male', 'Marvin Agawin', '0035214', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'M Aagawin Dental Clinic', '2nd flr., Gima Bldg. , A. Pichon St.', '1-A', 'DaVaO City', '0822243432', 'JOSHUA / JULIAN AGAWIN', '12 RICARDO ST JUNA SUBDIVISION DAVAO CITY', '09225365656', '2022-01-04 17:41:22', NULL),
(269, NULL, NULL, NULL, 'RUBY SOCORRO', 'ECLEO', 'ALBA', '1990-09-18', 'BLK 10, LOT 32, GARDENIA STREET, LA VISTA MONTE II, MATINA, DAVAO CITY', '09771146349', 'Female', 'Ruby Alba', '0055116', '0000-00-00', '0000-00-00', 'General Practice', 'Dental Associate', '', '', '', '', '', 'CORAZON ALBA', 'BLK 10, LOT 32, GARDENIA STREET, LA VISTA MONTE II, MATINA, DAVAO CITY', '+63 977 102 1722', '2022-01-04 17:41:22', NULL),
(270, NULL, NULL, NULL, 'MARJORIE CLARICE', 'ALTAVAS', 'ANG', '1979-07-06', '57 T  MONTEVERDE AVENUE', '09177240005', 'Female', 'Marjorie clarice ducase', 'eqweqw2', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Family Dental care', 'Door 1 and 2 L/A BLDG LAPU LAPU STREET AGDAO', 'Barangay 27 c', 'Davao city', '09177240005', 'BEHNJIE LAO DUCASE', '57 T. MONTEVERDE AVENUE', '09176240005', '2022-01-04 17:41:22', NULL),
(271, NULL, NULL, NULL, 'TERESA', 'DULAY', 'APURADA', '1969-07-14', 'BLK 11.LOT 6.DATEPALM STREE.TWIN PALMS.MAA DAVAO CITY', '09228681249', 'Female', 'Teresa Apurada-Lawas', '0048587', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Apurada Dental Clinic', 'Door 8.Mantex Arcade.Magallanes Davao City', '1', 'Davao', '09338577230', 'ALEXANDER N.LAWAS', 'BLK 11.LOT6.DATEPALM STREET.TWIN PALMS MAA.DAVAO CITY', '09257274398', '2022-01-04 17:41:22', NULL),
(272, NULL, NULL, NULL, 'SHEILA', 'INFANTE', 'BACUS-CAMUS', '1975-09-25', 'BLK. 20 LOT 19 GARDENA ST., ROBINSONS HIGHLANDS, BUHANGIN, DAVAO CITY', '09177004244', 'Female', 'Sheila Bacus', '0039896', '0000-00-00', '0000-00-00', 'General Practice, Endodontics, Prosthodontics, Orthodontics, Oral and maxillofacial surgery', 'Clinic Owner', 'Bacus Dental Clinic', 'M203 MDMRCI Hospital Km. 4 J.P. Laurel Ave., Bajada', '', '', '(082) 287-7777 loc. 3203', 'MARY ANNE I. BACUS', '23 RIVERVIEW VILLAGE BACACA, BAJADA, DAVAO CITY', '09173000412', '2022-01-04 17:41:22', NULL),
(273, NULL, NULL, NULL, 'ALMA LUZ', 'DIZON', 'BANAWIS', '1965-11-23', 'BLDG. 1 ONE OASIS CONDO, ECOLAND, DAVAO CITY', '09177071009', 'Female', 'Amie Dizon Banawis', 'rtrtrtrt', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', '', '', '', '', '', 'GABRIEL ANGELO B. RAZO', '003 JP LAUREL ST., KIDAPAWAN CITY', '09150822611', '2022-01-04 17:41:23', NULL),
(274, NULL, NULL, NULL, 'LORI', 'MORAL', 'BANGI', '1979-12-28', 'PUROK 4 BRGY DUJALI BE DUJALI DAVAO DEL NORTE', '09228981556', 'Male', 'Lori Moral', 'reterter333', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Lori Moral-Bangi', '2nd flr Greenfield Bldg', 'Purok 4 Brgy Dujali', 'BE dujali', '09228981556', 'RUGINALD BANGI', 'PUROK 4 BE DUJALI DAVAO DEL NORTE', '09399242139', '2022-01-04 17:41:23', NULL),
(275, NULL, NULL, NULL, 'GLENDA', 'PERPETUA', 'BARBON', '1971-01-30', 'CORNER PATNUBAY ST SANDAWA ROAD NEW MATINA DAVAO CITY', '09214525048', 'Female', 'Glenda Barbon', '0044542', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'BARBON DENTAL CLINIC', 'Phase 2, Sandawa road', 'BARANGAY 76-A', 'Davao city', '09214525048', 'NORNEL C CRAUSUS', 'CORNER PATNUBAY ST SANDAWA ROAD DAVAO CITY', '09218121015', '2022-01-04 17:41:23', NULL),
(276, NULL, NULL, NULL, 'IVY', 'NALLOS', 'BAUTISTA-MAGBIRAY', '1978-07-30', '#34 BLK 10, CHULA VISTA RESIDENCES, CABATIAN, BUHANGIN, DAVAO CITY', '09209240043', 'Female', 'Yvee', '0044703', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'Ivy Baitista-Magbiray Orthodontic clinic', 'Unit 10, 2nd flr, Don Dionisio Complex, Cabagiuo Ave. Davao City', 'Agdao', 'Davao', '09989944764', 'HAACON MAGBIRAY', '#34 BLK 10, CHULA VISTA RESIDENCES, CABANTIAN, BUHANGIN', '09999978250', '2022-01-04 17:41:23', NULL),
(277, NULL, NULL, NULL, 'AISHA', 'DIDELES', 'BISTON', '1984-05-12', 'BLOCK 70,LOT 16, PHASE 1, CORALLES ST., ESPERANZA DECA HOMES,TIGATTO, DAVAO CITY', '09177099602', 'Female', 'AISHA DIDELES BISTON', '0049831', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'PRINZES SMILE DENTAL CLINIC', 'Door 12, EDC Ventures Corporation, C Bangoy Street, Barangay 34-D, Davao City', 'Barangay 34- D', 'Davao City', '09177099602', 'SORAIDA BISTON', 'DAVAO CITY', '09202575892', '2022-01-04 17:41:23', NULL),
(278, NULL, NULL, NULL, 'HERSON PRINCESS', 'DUCO', 'BOCALA', '1995-08-26', 'BLK. 62 LOT 5 GULFVIEW EXECUTIVE HOMES, BAGO APLAYA, DAVAO CITY', '09233944905', 'Female', 'Princess Bocala', '0056751', '0000-00-00', '0000-00-00', 'General Practice', 'Dental Associate', 'Zyril Dental Clinic', 'Door 10 & 11, F.J. Bldg., MacArthur Highway', 'Brgy. Lizada, Toril District', 'Davao City, Davao del Sur', '09273252326', 'HERMINIO P. BOCALA JR.', 'BLK. 62 LOT 5 GULFVIEW EXECUTIVE HOMES, BAGO APLAYA, DAVAO CITY', '09327716710', '2022-01-04 17:41:23', NULL),
(279, NULL, NULL, NULL, 'MARIA THERESA', 'DIONIO', 'BORRES', '1972-12-25', 'PH-3,ZINC ST. EMILY HOMES CABANTIAN BUHANGIN DAVAO CITY', '09992276206', 'Female', 'Maria Theresa Borres Pangoy', '0036664', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Borres Dental Clinic', 'Ph-2,Abukay St D.D.F Village', 'Mandug,Buhangin', 'Davao City', '227-1624', 'SIMEON A. PANGOY', 'PH-3,ZINC ST. EMILY HOMES CABANTIAN BUHANGIN DAVAO CITY', '09178291475', '2022-01-04 17:41:23', NULL),
(280, NULL, NULL, NULL, 'ANDROLA MARIE', 'BACALLA', 'CABALLERO', '1964-02-19', 'KAPALARAN ST LEDESMA SUBD MARFORI HEIGHTS DAVAO CITY', '09086776341', 'Female', 'ememefsyian89@yahho.com', '09086776341', '0000-00-00', '0000-00-00', 'General Practice', 'Government Dentist', '', '', '', '', '', 'ELODIE CABALLERO TUQUIB', 'S R.I. MATINA', '09212717971 / 392-3420', '2022-01-04 17:41:23', NULL),
(281, NULL, NULL, NULL, 'IMELDA', '', 'CABALZA-SUSI', '1968-08-16', '97 KINGFISHER ST., ST. MICHAEL VILLGE 2, MAA, DAVAO CITY', '09228089336', 'Female', 'Imelda Cabalza', '0035081', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'Cabalza-Susi Dental Clinic', '05 Oriole st., St. Michael village 2, Maa, Davao City', 'Maa', 'Davao City', '09228089336', 'DANTE SUSI', '97 KINGFISHER ST., ST. MICHAEL VILLAGE 2, MAA, DAVAO CITY', '09213815597', '2022-01-04 17:41:23', NULL),
(282, NULL, NULL, NULL, 'ETHEL', 'CHAVEZ', 'CACERES', '1979-10-05', 'BLK8 LOT 10-11 CAMELLA HOMES COMMUNAL DAVAO CITY', '9279008112', 'Female', 'Ethel Chavez-Caceres', '44652', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics, TMD Pain Management', 'Clinic Owner', 'Ethel Caceres', 'Daily Fit Dental Wellness Clinic Door 2 2nd floor LTG Bldg Km. 8', 'Sasa', 'Davao City', '9279008112', 'BENJAMIN B CACERES II', 'BLK8 LOT 10-11 CAMELLA HOMES COMMUNAL DAVAO CITY', '09338622477', '2022-01-04 17:41:23', NULL),
(283, NULL, NULL, NULL, 'MARITES', 'ABAD', 'CAMARILLO', '1973-03-16', 'PRK22 ĎOÑA CONSUELO MALAGAMOT PANACAN DAVAO CITY', '09168216668', 'Female', 'Marites Camarillo', '0043332', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Camarillo dental clinic', 'Door# 4 piatos building ilang davao city', 'Ilang', 'Davao city', '09168216668', 'EDNEN CAMARILLO', 'PRK22 DOÑA CONSUELO MALAGAMOT PANACAN DAVAO CITY', '09464387145', '2022-01-04 17:41:23', NULL),
(284, NULL, NULL, NULL, 'CATHETINE', 'TEE', 'CASCABEL-PACQUING', '1977-10-27', 'BLK 6 LOT 10 PHASE 2 DONA ROSA SUBD LIZADA ,TORIL,DC', '09209646923', 'Female', 'Cathy Cascabel', '0043344', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'Cascabel-Pacquing Dental Clinic', 'Carleo bldg 2nd flr Juan de la cruz st. toril Davao City', 'Toril', 'Davao City', '09209646923', 'RANDELL W.PACQUING', 'DOÑA ROSA SUBD. LIZADA TORIL DAVAO CITY', '(0918) 951 0839', '2022-01-04 17:41:23', NULL),
(285, NULL, NULL, NULL, 'CAROLYNE', 'EVANGELISTA', 'CAUILAN', '1964-08-30', 'LOT1 BLK 4 OPAL ST. SM VILLAGE, BANGKAL, DAVAO CITY', '09215229312', 'Female', 'Carolyne E. Cauilan', '0035451', '0000-00-00', '0000-00-00', 'General Practice', 'Government Dentist', 'Davao City Health Office', 'Puan Health Center', 'Talomo District', 'Davao City', '09215229312', 'MARC THOMAS C. CLAUDIO', 'LOT 1BLK 4 OPAL ST. SM VILLAGE, BANGKAL, DAVAO CITY', '09484510328', '2022-01-04 17:41:24', NULL),
(286, NULL, NULL, NULL, 'MARIE IRIS', 'Q.', 'CELIS', '1974-12-08', 'BLK12 LOT 14 WELLSPRING VILLAGE PHASE 3,CATALUNAN PEQUENO DAVAO CITY', '09258499385', 'Female', 'Marie Iris Q.Celis', '39610', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'QUINONEZ-CELIS Dental Clijic', 'Unit 5 #26 Juna Ave Juna Subdivision', 'Matina', 'Davao City', '09258499385', 'JOEBERT O.CELIS', 'B12 LOT 14 WELLSPRING VILLAGE PHASE 3,CATALUNAN PEQUEÑO DAVAO CITY', '09190085279', '2022-01-04 17:41:24', NULL),
(287, NULL, NULL, NULL, 'MARIE IRIS', 'Q.', 'CELIS', '1974-12-08', 'BLK12 LOT 14 WELLSPRING VILL PH3 CATALUNAN PEQ.DAVAO CITY', '09258499385', 'Female', 'Marie Iris Q.Celis', '039610', '0000-00-00', '0000-00-00', 'General Practice, Prosthodontics', 'Clinic Owner', 'Marie Iris Q.Celis', 'U5 #26 Juna Ave Juna Subdivision', 'Matina/ Talomo', 'Davao City', '09258499385', 'JOMARI CELIS', 'B12 L14 WELLSPRING VILL 3 CAT PEQUEÑO DAVAO CITY', '09472301109', '2022-01-04 17:41:24', NULL),
(288, NULL, NULL, NULL, 'SHANE MARIE', 'DALMAN', 'CLITAR', '1993-12-18', 'B12 L21 P1 NARRA ST VISTA VERDE SUBD PANACAN DC', '09156167269', 'Female', 'Shane Marie Clitar', '54790', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics, Oral and maxillofacial surgery', 'Clinic Owner', 'Clitar Dental Clinic', 'G/F Clitar Building Daang Patnubay St SIR Phase 1 DC', 'Bucana', 'Davao City', '09094755442', 'SIONY BOY BELLA', 'B12 L21 P1 NARRA ST VISTA VERDE SUBD PANACAN DC', '09156779435', '2022-01-04 17:41:24', NULL),
(289, NULL, NULL, NULL, 'CATHERINE', 'MAGTIBAY', 'CRUZA', '1989-07-22', 'PUROK 28 MAA DAVAO CITY', '09123758640', 'Female', 'Katkat Magtibay Cruza', '0047312', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'Magtibay Cruza Dental Clinic', 'Door 3 Maa Plaza Maa DC and Torre bldg. Anda Sanpedro St.', 'Maa and Brgy 2-A', 'Davao City Davao del sur', '09123758640', 'LYNDON D. CRUZA', 'PUROK 28 MAA DAVAO CITY', '09258358091', '2022-01-04 17:41:24', NULL),
(290, NULL, NULL, NULL, 'ETHEL', 'V', 'CUASITO', '1976-10-20', '116 BURGOS ST. MONTE MA. PH2C, CATALUNAN GRANDE, DAVAO CITY', '09177191062', 'Female', 'Ethel Cuasito', '0042086', '0000-00-00', '0000-00-00', 'General Practice, Prosthodontics', 'Clinic Owner', 'Cool Smiles Dental Clinic', 'Door G, Tionko Arcade, Bajada St, JP Laurel Ave.', 'Barangay 19-B', 'Davao City', '2258137', 'ROVIC IRE CUASITO', '116 BURGOS ST. MONTE MA. PH2C, CATALUNAN GRANDE DAVAO CITY', '09177011400', '2022-01-04 17:41:24', NULL),
(291, NULL, NULL, NULL, 'ROVIC IRE', 'BABAO', 'CUASITO', '1976-01-04', '116 BURGOS ST. MONTE MA. PH2C, CATALUNAN GRANDE, DAVAO CITY', '09177011400', 'Male', 'Rovic Ire Cuasito', '0042085', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'Cool Smiles Dental Clinic', 'Door G, Tionko Arcade, Bajada St. JP Laurel Ave.', 'Barangay 19-B', 'Davao City', '2258137', 'ETHEL CUASITO', '116 BURGOS ST. MONTE MA. PH 2C CATALUNAN GRANDE DAVAO CITY', '09177191062', '2022-01-04 17:41:24', NULL),
(292, NULL, NULL, NULL, 'CECILE', 'S.', 'CUATON', '1975-10-28', 'C1 COL.PALACIO ST. PAG ASA HOMES SUBD.BUHANGIN, DAVAO CITY', '09328922875', 'Female', 'Cecile Sabado-cuaton', '0042878', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'Sabado-Cuaton Dental Clinic', 'Door 2F Penta Point Bldg. Km5 San Pedro Village Extension', 'Buhangin', 'Davao City', '+639421551053', 'RIMANDO P. CUATON', 'C1 COL.PALACIO ST. PAG ASA HOMES SUBD BUHANGIN, DAVAO CITY', '+639338195875', '2022-01-04 17:41:24', NULL),
(293, NULL, NULL, NULL, 'BERNARDO', 'MILAN', 'CUNANAN', '1966-07-25', 'ELLES PENSION MT APO ST', '09390972751', 'Male', 'Bern cunanan', '0056415', '0000-00-00', '0000-00-00', 'General Practice', 'Dental Associate', 'Gentle smiles dental clinic', 'Ground floor elles pension house, mt. Apo st.', 'Brgy 7a', 'Davao city', '09390972751', 'DELIA CUNANAN', '333-A MAC ARTHUR HIGHWAY, MATINA', '09338505585', '2022-01-04 17:41:24', NULL),
(294, NULL, NULL, NULL, 'JOAN', 'SARCEDA', 'DAIGDIGAN', '1979-09-13', 'PHASE 2, ROAD 3, DOÑA VICENTA VILLAGE, BAJADA, DAVAO CITY', '09474629921', 'Female', 'Joan Sarceda Daigdigan', '0046833', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Smile Care Clinic', 'Good Shepherd Hospital of Panabo City, Inc., Km. 31 National Highway', 'New Pandan', 'Panabo.City', '09776772513', 'JOSE G. DAIGDIGAN', 'BLK. 1, RPJ VILLAGE, FEEDER ROAD 3, STO. TOMAS, DAVAO DEL NORTE', '09209081016', '2022-01-04 17:41:24', NULL),
(295, NULL, NULL, NULL, 'JISELLE', 'YU', 'DANIEL', '1991-09-30', 'BLK 1 LOT 1 COUNTRY HOMES CABANTIAN DAVAO CITY', '9165210903', 'Female', 'Jiselle Daniel', '56600', '0000-00-00', '0000-00-00', 'General Practice, Endodontics, Orthodontics', 'Dental Associate', 'Molar world dental', 'CM Recto', 'Baranggay 34-D', 'Davao city', '09094878090', 'BERNADETTE DANIEL', 'BLK 1 LOT 1 COUNTRY HOMES CABANTIAN DAVAO CITY', '09229498987', '2022-01-04 17:41:24', NULL),
(296, NULL, NULL, NULL, 'ALBERT', 'GABAN', 'DE GUZMAN', '1970-02-25', '', '09177027725', 'Male', '13 SAN JUAN ST SKYLINE SUBD', '40641', '0000-00-00', '0000-00-00', 'General Practice, Endodontics, Prosthodontics, Orthodontics, Oral and maxillofacial surgery', 'Clinic Owner', 'De Guzman Dental Clinic', 'Door 6 Galaxy Arcade Ilustre st. Davao City', '', '76A', '0822229957', 'MA. CATHRINA DE GUZMAN', '13 SAN JUAN ST SKYLINE SUBD CAT. GRANDE DAVAO CITY', '0822961167', '2022-01-04 17:41:24', NULL),
(297, NULL, NULL, NULL, 'SUZANNE NOREEN', 'DIAZ', 'DE LIMA', '1986-08-14', 'L11 B1 BRC VILLAGE CATALUNAN PEQUEÑO DAVAO CITY', '9274756945', 'Female', 'Suzanne de Lima', '0051043', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'DE LIMA DENTAL CARE', 'S207 HEALTH SCIENCE AND WELLNESS CENTER MDMRCI HOSPITAL BAJADA DAVAO CITY', '20-B', 'DAVAO CITY', '287 7777 loc. 2207', 'DELILAH DE LIMA (MOTHER)', 'L11 B1 BRC VILLAGE CATALUNAN PEQUEÑO DAVAO CITY', '09430698284', '2022-01-04 17:41:24', NULL),
(298, NULL, NULL, NULL, 'CYNTHIA', 'ELTANAL', 'DEL ROSARIO', '1974-05-14', 'DECA TUGBOK DISTRICT PUROK 20,PHASE 3,LOT11 BLOCK 24', '0919 085 3084', 'Female', 'Cynthia rodaje eltanal', '0040346', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'ELTANAL - DEL ROSARIO DENTAL CLINIC', 'Dona segunda complex door 6 ground floor ponciano street acacia davao city', 'Acacia', 'Davao city', '0919 085 3084', 'NEDDIE B. LIMUTIN', 'DECA TUGBOK DISTRICT PUROK 20, PHASE 3 LOT 11 BLOCK 24', '09533540459', '2022-01-04 17:41:24', NULL),
(299, NULL, NULL, NULL, 'SOPHIA', 'VENTURA', 'DELA CRUZ', '1991-11-29', 'BLK 11 LOT 30 CAMELLA COMMUNAL BUHANGIN DAVAO CITY', '09363646367', 'Female', 'Sophia Dela Cruz', '0055007', '0000-00-00', '0000-00-00', 'General Practice', 'Dental Associate', 'Healthy Smile Dental Center', '2nd flr SM City Davao', 'Matina', 'Davao City', '', 'MARIE JEAN DELA CRUZ', 'BLK 11 LOT 30 CAMELLA COMMUNAL BUHANGIN DAVAO CITY', '09338143904', '2022-01-04 17:41:24', NULL),
(300, NULL, NULL, NULL, 'JACQUELINE', 'GALAGATE', 'DELGADO', '1973-11-12', 'BLK 10 LOT 10 SAMANTHA HOMES CATALUNAN PEQUENO DAVAO CITY', '09776231495       09107149326', 'Female', 'Jacqueline Galagate Delgado', '0043121', '0000-00-00', '0000-00-00', 'General Practice', 'Government Dentist', 'Jacqueline Galagate Delgado', '217 R.Castillo St. Brgy. Ubalde Agdao Davao City', 'Ubalde', 'Davao City', '09107149326  09776231495', 'ROMEO ORCAJADA DELGADO JR.', 'BLK 10 LOT 20 SAMANTHA HOMES CATALUNAN PEQUENO DAVAO CITY', '09273437183', '2022-01-04 17:41:24', NULL),
(301, NULL, NULL, NULL, 'LLOYD', 'PACLAR', 'DENIA', '1971-09-13', '2 DAISY ST. MARIAN VILLAGE, MATINA, DAVAO CITY', '09175840142', 'Male', 'Lloyd Denia', '0038933', '0000-00-00', '0000-00-00', 'General Practice', 'Corporate', 'Lloyd Denia', '2 Daisy St. Marian Village Matina, Davao City', 'Matina', 'Davao', '09175840142', 'JON KYLLE LLOYD B. DENIA', '2 DAISY ST. MARIAN VILLAGE, MATINA, DAVAO CITY', '0917-7209112', '2022-01-04 17:41:24', NULL),
(302, NULL, NULL, NULL, 'KRISTINE', 'AQUINO', 'DIZON', '1985-08-01', '32 BRONCO ST, DAMOSA FAIRLANE DAVAO CITY', '09175255747', 'Female', 'Kristine Aquino-Dizon', '49377', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'Dentine Dental Center', 'Door 1 RMC bldg, F. Torres St', '', 'Davao City', '09176793306', 'LEO ALFONSO DIZON', '32 BRONCO ST, DAMOSA FAIRLANE SUBD, DAVAO CITY', '09178503536', '2022-01-04 17:41:25', NULL),
(303, NULL, NULL, NULL, 'LEO ALFONSO', 'TAVITA', 'DIZON', '1983-11-13', '32 BRONCO ST, DAMOSA FAIRLANE SUBD, DAVAO CITY', '09178503536', 'Male', 'Leo Alfonso Tavita Dizon', '49185', '0000-00-00', '0000-00-00', 'Oral and maxillofacial surgery', 'Clinic Owner', 'Dentine Dental Center', 'Door 1 RMC bldg, F. Torres St', '', 'Davao City', '09176793306', 'KRISTINE DIZON', '32 BRONCO ST, DAMOSA FAIRLANE SUBD, DAVAO CITY', '09175255747', '2022-01-04 17:41:25', NULL),
(304, NULL, NULL, NULL, 'MARIA CRISTINA', 'PALAFOX', 'DOMINGO', '1974-01-28', '#14 ADAMS ST,, ROYAL PINES SOUTH, MCARTHUR HIGHWAY, MATINA, DAVAO CITY', '09177054443', 'Female', 'Tina Domingo', '40133', '0000-00-00', '0000-00-00', 'General Practice, Pedodontics', 'Clinic Owner', 'Maria Cristina Domingo', 'Unit 507 Davao Doctors Hospital Medical Tower, Quirino Ave., Davao City', 'Poblacion District', 'Davao City', '09396141011', 'JONATHAN DOMINGO', 'C/O MANULIFE, 7TH FLOOR ABREEZA CORPORATE BLDG, DAVAO CITY', '09197780480', '2022-01-04 17:41:25', NULL),
(305, NULL, NULL, NULL, 'RODEL', 'DIAZ', 'EVASCO', '1968-06-14', 'JAIS PLACE, PLARIZA COMPOUND, PANTINOPLE, MAA DAVAO CITY', '09292464263', 'Male', 'rodel diaz evasco', '00035864', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Dental Associate', 'Villaceran Dental.Clinic', 'Blk 2 Lot 41 SMS,', 'Central Park, Bangkal', 'Davao City', '2978415', 'DR. ELMER VILLACERAN /CLAIRE EVASCO ATOLE', 'BANGKAL DAVAO CITY / BUYO GOA CAMARINES SUR', '09423910646/ 09308728234', '2022-01-04 17:41:25', NULL),
(306, NULL, NULL, NULL, 'MARIA VERONICA', 'KIMPO', 'FALCON', '1972-07-11', '', '09157719183', 'Male', 'Veronica Formalejo Kimpo', '0041216', '0000-00-00', '0000-00-00', 'General Practice, Endodontics, Prosthodontics, Orthodontics, Oral and maxillofacial surgery, Pedodontics, Periodontics', 'Clinic Owner', 'Tooth Friendly Dental Clinic', 'Doir A7 Quibod Bldg.(union Bank) Rizal St.', '3A / District 1', 'Davao City', '09157719183', 'GEMARIE B. MONTALBAN', 'DAVAO CITY', '0915 517 3865', '2022-01-04 17:41:25', NULL),
(307, NULL, NULL, NULL, 'MARIA VERONICA', 'KIMPO', 'FALCON', '1972-07-11', 'L7B15', '09157719183', 'Female', 'Veronica formalejo kimpo', '41216', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'Tooth Friendly Dental Clinic', 'Door A7 Quibod Bldg. Rizal St.', '3A', 'Davao City', '09157719183', 'MATTHEW K. FALCON', 'EL RIO', '09266886107', '2022-01-04 17:41:25', NULL),
(308, NULL, NULL, NULL, 'RENE JUNE', 'VISCAYA', 'FERIA', '1982-06-03', '06 PANDANGO STREET LANZONA SUBD MATINA DAVAO CITY', '09189456151', 'Male', 'Ren-ren', '48141', '0000-00-00', '0000-00-00', 'General Practice, Endodontics, Prosthodontics, Orthodontics, Oral and maxillofacial surgery', 'Clinic Owner', 'dent-all dental center', 'door 3 aala building mc. arthur highway', 'matina', 'davao city', '2952057', 'MAY MARIE S. FERIA', '06 PANDANGO STREET LANZONA SUBD MATINA DAVAO CITY', '09189226122', '2022-01-04 17:41:25', NULL),
(309, NULL, NULL, NULL, 'JOHANNA', 'B', 'GARDUQUE', '1979-08-18', '11 DAHLIA CIRCLE LADISLAWA, BUHANGIN, DAVAO CITY', '09228680508', 'Female', 'Hanna Betia-Garduque', '44706', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Toothwelcare Dental Clinic', '4th Floor Gaisano Mall of Bajada, JP Laurel', '13-B', 'Davao', '09228205747', 'JOSEPH GARDUQUE', '11 DAHLIA CIRCLE LADISLAWA, BUHANGIN DAVAO CITY', '09228606910', '2022-01-04 17:41:25', NULL),
(310, NULL, NULL, NULL, 'MARILEN', 'L', 'GOMEZ-ORINGO', '1977-06-01', '482 RIVERSIDE ROAD JAIL ROAD MA-A DAVAO CITY', '09151821040', 'Female', 'Marilen L. Gomez-Oringo', '042445', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Corporate', 'Smile Guard Dental Clinic', 'unit 107 Goldwin Bldg. Quirini Ave.', 'District 1', 'Davao', '3314122', 'ROLANDO RYAN ORINGO', '482 JAIL ROAD MA-A DAVAO CITY', '09177151028', '2022-01-04 17:41:25', NULL),
(311, NULL, NULL, NULL, 'MARIA AIDA', 'LOZANO', 'GORDO', '1969-06-25', 'B10, L54 MAHOGANY LOOP WOODRIDGE PARK, MA-A', '09432416063', 'Female', 'Maya Gordo', '32101', '0000-00-00', '0000-00-00', 'General Practice', 'Government Dentist', 'Maria Aida L. Gordo', 'City Health Office', '76-A / Talomo North District', 'Davao City', '09432416063', 'GILBERT M. GORDO', 'B10, L54 MAHOGANY LOOP WOODRIDGE PARK, MA-A', '09438121007', '2022-01-04 17:41:25', NULL),
(312, NULL, NULL, NULL, 'GENAFE GRACE', 'OLAER', 'GUMBAN-VENERACION', '1966-09-27', 'BUHANGIN, DAVAO CITY', '09088983432', 'Female', 'Geny Veneracion', '27152', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Genafe Gumban Veneracion Dental Clinic', 'City Triangle, Roxas Avenue,', 'Poblacion District', 'Davao City', '09088983432', 'FERDINAND D. VENERACION', 'BUHANGIN, DAVAO CITY', '09483239089', '2022-01-04 17:41:25', NULL),
(313, NULL, NULL, NULL, 'ERWIN HONORIO', 'ULGASAN', 'GUTIERREZ', '1988-11-14', 'ROSA SANS OBRERO DAVAO CITY', '09171232689', 'Male', 'Tawi ulgasan Gutierrrez', '0051618', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Your dental point clinic', 'Door 2 belfran building Palma Gil Obrero', 'Obrero', 'Davao city', '2278188', 'DR EDWIN GUTIERREZ', '3034 SISON AVENUE SISON SUBDIVISION TAGUM CITY', '09202531577', '2022-01-04 17:41:25', NULL),
(314, NULL, NULL, NULL, 'JEAN', 'MA', 'HAO', '1975-02-21', '901 VINZON ST OBRERO DAVAO CITY', '09228022175', 'Female', 'Jean Hao', '42823', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'Jean M. Hao', 'Km 6 Diversion road buhangin davao city', 'Gov paciano bangoy', 'Davao coty', '09228022175', 'JOAN HAO', '901 VINZON ST OBRERO', '2273650', '2022-01-04 17:41:26', NULL),
(315, NULL, NULL, NULL, 'EDEN', 'PONCIANO', 'HASIM', '1972-08-20', 'ZONE 4 DAPECOL BRAGY TANGLAW, B. E. DUJALI DAVAO DEL NORTEE.', '09173152394', 'Female', 'Eden S Ponciano', '0036411', '0000-00-00', '0000-00-00', 'General Practice', 'Government Dentist', '', '', '', '', '', 'LANDRO T HASIM', 'ZONE 4 DAPECOL BRGY TANGLAW,B.E.DUJALI DAVAO DEL NORTE', '09173152394', '2022-01-04 17:41:26', NULL),
(316, NULL, NULL, NULL, 'CITI SARA', 'MISA', 'HERNAEZ', '1993-08-03', '709 URBAN HIVE PALMS, BACACA RD., DAVAO CITY', '09088658244', 'Female', 'Citi Hernaez', '0054330', '0000-00-00', '0000-00-00', 'General Practice, Endodontics, Prosthodontics, Orthodontics, Oral and maxillofacial surgery, Pedodontics, Periodontics', 'Dental Associate', 'Hernaez-Mansukhani Dental Clinic', 'Door 3, Bldg. 2, Fuent Bldg., 234 Juan Luna St.', '29-C', 'DAVAO CITY', '222-2244', 'ROSARIO H. MANSUKHANI', 'WOODRIDGE, MA-A, DAVAO CITY', '09178034120', '2022-01-04 17:41:26', NULL),
(317, NULL, NULL, NULL, 'JONONA', 'JUNTILLA', 'HERRERA', '1969-01-04', '3 SATURN STREET GSIS HEIGHTS MATINA DAVAO CITY', '09178877660', 'Female', 'Nonon Juntilla', '31642', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Jonona J. Herrera', 'Rm 207 Second Floor ARMCI Magallanes Street', 'Magallanes', 'Davao City', '09178877660', 'GABRIEL ROMMEL P. HERRERA', '139 MARS STREET GSIS HEIGHTS MATINA DAVAO CITY', '09758995207', '2022-01-04 17:41:26', NULL),
(318, NULL, NULL, NULL, 'MARIA REA LANE', 'LAGUNAY', 'HORFILLA-LOPEZ', '1982-10-17', 'G8REA@YAHOO.COM', '09228901132', 'Female', 'G8rea@yahoo.com', '0049493', '0000-00-00', '0000-00-00', 'Pedodontics', 'Clinic Owner', 'Horfilla Dental Clinic', '2nd floor Callao Building, 20 Inigo st., Obrero', '18-B', 'Davao city', '09088922517', 'LOUIE RUEVEN HORFILLA', '149 MAHOGANY ST., PALM VILLAGE, DAVAO CITY', '09228901134', '2022-01-04 17:41:26', NULL),
(319, NULL, NULL, NULL, 'MARICEL', 'TE', 'HUANG', '1979-03-16', '0512 SAMAL CORNER SURIGAO STREET, INSULAR VILLAGE, PHASE 2, LANANG, DAVAO CITY', '09189991188', 'Female', 'Maricel Te-Huang', '0044740', '0000-00-00', '0000-00-00', 'Orthodontics', 'Clinic Owner', 'Flozz Dental Clinic', 'Door # 3 Cisa Building, Jacinto Street', 'Barangay 32', 'Davao City', '2860048', 'JASPER HUANG', '0512 SAMAL CORNER SURIGAO STREE, INSULAR VILLAGE, PHASE 2, LANANG, DAVAO CITY', '09188888666', '2022-01-04 17:41:26', NULL),
(320, NULL, NULL, NULL, 'ANA MARIE', 'ESPINA', 'JIMENEZ', '1971-05-05', 'PH2 BLK4 LOT 17 GULF VIEW', '09173219622', 'Female', 'ana marie jimenez', '38133', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'jimenez dental clinic', 'room 106 la cima bldg 2', 'palma gil st', 'davao city', '2277461', 'RANDY TUQUIB', 'PH 2BLK 4 LOT 17 GULF VIEW', '0906578129', '2022-01-04 17:41:26', NULL),
(321, NULL, NULL, NULL, 'ELIZABETH', 'QUIDILLA', 'JOAQUIN', '1972-11-20', 'LOT 394 3RD STREET NACILLA VILLAGE MAA DAVAO CITY', '09177062845', 'Female', 'Elizabeth Joaquin', '0038244', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'JOAQUIN DENTAL CLINIC', 'DOOR 6A BGP COMMERCIAL COMPLEX 1', 'MATINA CROSSING', 'DAVAO CITY', '3211885', 'MAILA J SO', 'LOT 394 3RD STREET NACILLA VILLAGE MAA DAVAO CITY', '09055178487', '2022-01-04 17:41:26', NULL),
(322, NULL, NULL, NULL, 'CATHERINE ANNE GRACE', 'ABLIN', 'JUANILLO', '1987-04-30', '50 CRYSTAL BAY ROAD HILLCREST SUBD MATINA DAVAO CITY', '639999912984', 'Female', 'Catherine Anne Grace Juanillo', '51276', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'ConfidentGrin Dental Clinic', 'Unit 1 Casa Meding bldg Iñigo St', 'Poblacion 18-  B', 'Davao', '639999912984', 'CHRISTOPHER ARGEL L. MATBAGAN', '50 CRYSTAL BAY ROAD HILLCREST SUBD MATINA DAVAO CITY', '639753573209', '2022-01-04 17:41:26', NULL),
(323, NULL, NULL, NULL, 'EMMARYL', 'ESCALONA', 'JULIAN', '1993-09-18', 'MAA', '09179329884', 'Female', 'Emmaryl E. Julian-Frando', '0055337', '0000-00-00', '0000-00-00', 'General Practice, Endodontics, Prosthodontics, Pedodontics, Periodontics', 'Dental Associate', 'Aim Dental Avenue', 'Level 2-202, robinsons cybergate, jp laurel', 'Buhangin', 'Davao', '', 'MARK CHRISTIAN FRANDO', 'MAA', '09567993639', '2022-01-04 17:41:26', NULL),
(324, NULL, NULL, NULL, 'DARLENE', 'M', 'KILBY', '1972-02-07', 'BLK 17 LOT 2 NHA MAA DAVAO CITY', '09998501965', 'Female', 'M Darlene', '0034069', '0000-00-00', '0000-00-00', 'General Practice', 'ofw', 'n/a ( not practicing)', 'N/A', 'n/a', 'n/a', 'n/a', 'FINOLA NICOLE KILBY', 'BRGY. SAN RAFAEL, CATEEL, DAVAO ORIENTAL', '09395068036', '2022-01-04 17:41:26', NULL),
(325, NULL, NULL, NULL, 'VANESSA ELAINE', 'FADUGA', 'LATAG', '1994-07-08', 'B7, L7, ROSALINA VILL. 1, BAGO GALLERA, DAVAO CITY', '09088738157', 'Female', 'Vanessa Latag', '0056860', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Smile Doctor Dental and Orthodontic Clinic', 'Door 1, Normalita Bldg., Lim St.', 'Toril', 'Davao City', '09639719658', 'JOCELYN F. LATAG', 'B7, L7, ROSALINA VILL. 1, BAGO GALLERA, DAVAO CITY', '09239776496', '2022-01-04 17:41:26', NULL),
(326, NULL, NULL, NULL, 'JENNIFER CHRISTINE', 'YEE', 'LIM', '1972-12-24', 'AML BLDG CAMUS ST EXT DAVAO CITY', '09209125400', 'Female', 'Jen Lim', '35845', '0000-00-00', '0000-00-00', 'General Practice, Endodontics, Periodontics', 'Clinic Owner', 'AJ Lim Dental Clinic', '498 Quirino Ave fronting Palma Gil Elementary school', '9A', 'Davao City', '2219173', 'SHANNEN LIM', 'AML BLDG CAMUS ST EXT DAVAO CITY', '09989915969', '2022-01-04 17:41:26', NULL),
(327, NULL, NULL, NULL, 'ARSENIO JR', 'BARRACOSO', 'LIM', '1973-05-10', 'AML BLDG CAMUS ST EXT DAVAO CITY', '09209248121', 'Male', 'Chin-Jen Lim', '37036', '0000-00-00', '0000-00-00', 'General Practice, Endodontics, Prosthodontics, Orthodontics, Periodontics, Implantology', 'Clinic Owner', 'AJ Lim Dental Clinic', '498 Quirino ave fronting palma gil elementary school', '9A', 'Davao City', '2219173', 'SHANNEN  LIM', 'AML BLDG CAMUS ST EXT DAVAO CITY', '09989915969', '2022-01-04 17:41:26', NULL),
(328, NULL, NULL, NULL, 'FRANCIS JOSE CORAZON', 'M', 'LISTON', '1967-12-04', '15-B JOSE CAMUS ST., DAVAO CITY', '09209458023', 'Male', 'Francis Liston', '27816', '0000-00-00', '0000-00-00', 'General Practice', 'Dental Associate', 'Urbidontics', '2nd floor Abreeza Mall, J.P. Laurel Ave.', 'Bajada', 'Davao City', '09228025948', 'CYNTHIA C. LISTON', '15-B JOSE CAMUS ST., DAVAO CITY', '09189221922', '2022-01-04 17:41:26', NULL),
(329, NULL, NULL, NULL, 'ARIES', 'GULLON', 'LUAYON', '1994-03-05', 'BLK20 LOT5 CELICA ST. BRGY W. AQUINO ADGAO DAVAO CITY', '09153534066', 'Male', 'aries luayon', '056660', '0000-00-00', '0000-00-00', 'General Practice', 'Dental Associate', 'tooth land dental clinic', '055B Quezon Ave., Cotabato City', '', 'cotabato city', '4216091', 'GEALINA G. LUAYON', 'BLK20 LOT5 CELICA ST. BRGY AQUINO, AGDAO DAVAO CITY', '09053360530', '2022-01-04 17:41:27', NULL),
(330, NULL, NULL, NULL, 'AIMEE GRACE', 'MAÑEGO', 'LUZA', '1984-09-08', 'BLOCK 20 LOT 22, MEDITERRANEAN SEA STREET, GULFVIEW EXECUTIVE HOMES, BAGO APLAYA, DAVAO CITY', '09171139908', 'Female', 'Aimee Grace', '0050881', '0000-00-00', '0000-00-00', 'General Practice, aesthetic dentistry', 'Clinic Owner', 'Toothway Dental Clinic', 'G. Ortiz Road, Ulas', 'Talomo', 'Davao City', '09306639003', 'REDIN BOTEROS', 'GULFVIEW EXECUTIVE HOMES, BAGO APLAYA, DAVAO CITY', '09662236124', '2022-01-04 17:41:27', NULL),
(331, NULL, NULL, NULL, 'AMYRA LYDDAH', 'KHO', 'MACARIO', '1961-05-28', 'GREENVIEW ST., KM 14 MACARTHUR HIGHWAY, LUBOGAN, TORIL, DC', '09187149039', 'Female', 'Amyra Lyddah', '23683', '0000-00-00', '0000-00-00', 'General Practice', 'None Practicing', 'Macario Dental Clinic ( closed temporarily )', 'Greenview St., Km 14 MacArthur Highway', 'Lubogan, Toril', 'Davao City', '09187149039', 'ALEXANDER L. MACARIO', 'GREENVIEW ST., KM. 14 MACARTHUR HIGHWAY, LUBOGAN, TORIL 091', '09177711881', '2022-01-04 17:41:27', NULL),
(332, NULL, NULL, NULL, 'ELAINE JOY', 'MAGANDA', 'MAGANDA-TIAGA', '1978-11-04', 'BLK 2 LOT 28 EMERALD ST DOÑA ROSA TORIL DAVAO CITY', '09228836897', 'Female', 'Elaine joy m tiaga', '0043326', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Maganda Tiaga dental clinic', 'Rm 5 grandma complex agton st toril dc', 'Toril', 'Davao city', '0922 883 6897', 'YLL RUSSELL C TIAGA', 'BLK 2 LOT 28 EMERALD ST DOÑA ROSA TORIL DC', '09209799424', '2022-01-04 17:41:27', NULL),
(333, NULL, NULL, NULL, 'MARILOU SE MALIGAD', 'SE', 'MALIGAD', '0066-03-31', 'BLK16LOT4 VILLA MONTE MARIA DAVAO CITY', '09064378583', 'Female', 'Malou maligad', '30605', '0000-00-00', '0000-00-00', 'General Practice, Endodontics, Prosthodontics, Orthodontics, Oral and maxillofacial surgery, Pedodontics, Periodontics, Implant', 'Clinic Owner', 'Maligad dental clinic', 'Art gallery center magallanes st', 'Magallanes st', 'Davao city', '09182314452', 'ALDRICH MALIGAD', 'VILLA MONTE MARIA CAT GRANDE DAVAO CITY', '09182314452', '2022-01-04 17:41:27', NULL),
(334, NULL, NULL, NULL, 'MICHELLE', 'ESPA', 'MAMUYAC', '1978-12-07', 'SEAWIND CONDOMINIUM', '09334517862', 'Female', 'michelle espa mamuyac', '0046163', '0000-00-00', '0000-00-00', 'Orthodontics, Periodontics, CRANIODONTICS', 'Dental Associate', 'TOOTHBERRY DENTAL CLINIC', 'DOOR 1UK BLDG PORRAS ST COR. LUPO DIAZ ST', '16-B', 'DAVAO CITY', '09568415078', 'RICKY LEE MAMUYAC', 'SEAWIND CONDOMINIUM', '09617092838', '2022-01-04 17:41:27', NULL),
(335, NULL, NULL, NULL, 'ROSARIO', 'H', 'MANSUKHANI', '1957-10-30', '28 MOLAVE LANE, WOODRIDGE PARK SUBDIVISION, MAA, DAVAO CITY', '(+63)9178034120', 'Female', 'N/A', '0017002', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Hernaez-Mansukhani Dental Clinic', 'Bldg 2 Door 3 Fuente Juan Luna Bldg, 234 Jyan Luna St.', 'Barangay 29-C', 'Davao City', '(082)2222244', 'PARKASH T. MANSUKHANI', '28 MOLAVE LANE, WOODRIDGE PARK SUBDIVISION, MAA , DAVAO CITY', '(+63)9177297722', '2022-01-04 17:41:27', NULL),
(336, NULL, NULL, NULL, 'MARIA RAINELDA', 'BAGAMASPAD', 'MARIANO', '1966-02-09', '255 PONCE STREET, DAVAO CITY', '09106648100/ 09336803288', 'Female', 'ranee mariano', '0026402', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'Mariano Dental Clinic', '255 Ponce Street, Davao City', 'Brgy.25-C / District 1', 'Davao City', '(082) 271-1738', 'GREG S. BARLIS', '255 PONCE STREET, DAVAO CITY', '09327457100', '2022-01-04 17:41:27', NULL),
(337, NULL, NULL, NULL, 'RENE ANN', 'PATULOT', 'MILAGROSA', '1979-07-02', 'BLK 11 LOT 6 BANANA STREET CIUDAD ESPERANZA CABANTIAN DAVAO CITY', '9159035144', 'Female', 'Rene Ann Milagrosa', '48854', '0000-00-00', '0000-00-00', 'General Practice', 'None Practicing', '', '', '', '', '', 'SERGIA MILAGROSA', 'BLK 11 LOT 6 BANANA STREET CIUDAD ESPERANZA CABANTIAN DAVAO CITY DAVAO DEL SUR 8000', '09177001839', '2022-01-04 17:41:27', NULL),
(338, NULL, NULL, NULL, 'ANNE GELIZA', 'NOMBRADO', 'MOLINA', '1993-04-07', 'BOOC COMPOUND, PUROK 1, SUBASTA, CALINAN DAVAO CITY', '09165371235', 'Female', 'Anne G. Nombrado-Molina', '0055243', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Toothfully Yours Dental Care', 'Door # 3, Quisa Realty, Sampaguita St., Mintal, Davao City', 'Mintal', 'Davao City', '09089882163', 'LESTER JEREMY MOLINA', 'BOOC COMPOUND PUROK 1, SUBASTA, CALINAN, DAVAO CITY', '09166349336', '2022-01-04 17:41:27', NULL),
(339, NULL, NULL, NULL, 'CHARITO', 'SOLON', 'NAZARENO', '1967-06-06', '736 ALZATE EXTENSION N.TORRES BO. OBRERO DAVAO CITY', '09156513662', 'Female', 'Mel Lani', '037460', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Nazareno Dental Clinic', '88 Cor inigo N. Torres BO. Obrero Davao City', '18-B', 'Davao City', '09156513662', 'HECTOR NAZARENO', 'METRO MEDICAL DIAGNOSTIC RESEARCH CENTER', '09188030593', '2022-01-04 17:41:27', NULL),
(340, NULL, NULL, NULL, 'DELMA', 'BOOC', 'NOMBRADO', '1969-07-16', 'BOOC COMPOUND, PUROK 1, SUBASTA, CALINAN, DAVAO CITY', '09177054768', 'Female', 'Delma Nombrado', '0032864', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Booc-Nombrado Dental Clinic', 'Booc-Nombrado Dental Clinic, Malanos St.,', 'Calinan', 'Davao City', '(0943) 368 9728', 'ANNE GELIZA MOLINA', 'BOOC COMPOUND, PUROK 1, SUBASTA, CALINAN, DAVAO CITY', '09165371235', '2022-01-04 17:41:27', NULL),
(341, NULL, NULL, NULL, 'test', 'R.', 'ORINGO', '1977-08-16', '482 RIVERSIDE ROAD MA-A DAVAO CITY', '09177151028', 'Male', 'Ryan Oringo', '42210 test', '0000-00-00', '0000-00-00', 'General Practice, Endodontics', 'Corporate dentist', 'Smileguard', 'Unit 107 Goldwin Bldg Quirino St Davao city', 'District 1', 'Davao', '3003424', 'MARILEN ORINGO', 'SAME', 'Same', '2022-01-04 17:41:27', NULL),
(342, NULL, NULL, NULL, 'ROLANDO RYAN', 'R', 'ORINGO', '1977-11-15', '482 JAIL ROAD MA-A DAVAO CITY', '09177151028', 'Male', 'Ryan Oringo', '042210', '0000-00-00', '0000-00-00', 'General Practice, Endodontics', 'Clinic Owner', 'SmileGuard Dentl Clinic', 'unit 107 goldwin bldg. Quirino Ave. Davao City', 'District 1', 'Davao', '3314122', 'MARILEN ORINGO', '482 JAIL ROAD MAA DAVAO CITY', '09151821040', '2022-01-04 17:41:27', NULL),
(343, NULL, NULL, NULL, 'MACEL', 'SUOBIRON', 'ORTIZ', '1986-03-19', 'BLK.38 LOT 11 DECA HOMES SUBD.', '09228217339', 'Female', 'Macel suobiron-ortiz', '0050361', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'M C Suobiron Dental Clinic', 'Door 3 Aranas bldg. Maya st. Ecoland 2', 'Bucana', 'Davao City', '09228217339', 'JED CHRISTIAN ANGELO M. ORTIZ', 'BLK.38 LOT 11 DECA HOMES, TUGBOK PROPER, DAVAO CITY', '09236086111', '2022-01-04 17:41:27', NULL),
(344, NULL, NULL, NULL, 'JAY LYNN', 'ZANTUA', 'PAJARES', '1962-07-09', 'DECA HOMES TUGBOK DISTRICT PHASE 5 BLOCK 102,LOTS 37-39  MINTAL,DAVAO CITY', '09458396010', 'Female', 'Jay Lynn Fuentes', '0020587', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Jay Lynn Dental Clinic', 'Deca Homes phase 5,blk 102 lots 37-39 mintal,davao city', 'Tugbok', 'Davao', '09916216401', 'ISAGANI V. FUENTES,JR/MARNE P. FUENTES', 'SAME', '09178706710', '2022-01-04 17:41:27', NULL),
(345, NULL, NULL, NULL, 'JAN PAULETTE', 'CHUA', 'REYES', '1990-04-08', '21 DACUDAO AGDAO DAVAO CITY', '09177772948', 'Female', 'Paulette reyes', '0052560', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Retes dental clinic', '2nd floor unit B valencia corp center arellano st. Davao city', 'Barangay 11', 'Davao city', '(082) 324-2897', 'ROXANA TAY', '21 DACUDAO AGDAO DAVAO CITY', '0917 703 0610', '2022-01-04 17:41:27', NULL),
(346, NULL, NULL, NULL, 'GOLDA', 'TAAY', 'SALVADICO', '1975-09-03', '#11, T.MARTINEZ ST. PH2, SIR,NEW MATINA DAVAO CITY', '09176180668', 'Female', 'Diezel gold taay', '0049037', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Salvadico Dental Clinic', '#11, T.Martinez st. PH 2 SIR, New Matina Davao City', '76-A', 'Davao City', '09176180668', 'ANTHONY SALVADICO', '#11, T.MARTINEZ ST. PH2, SIR, NEW MATINA DAVAO CITY', '09176180668', '2022-01-04 17:41:27', NULL),
(347, NULL, NULL, NULL, 'CAMILLE MELISANDE', 'SERAFICA', 'SAN FELIX', '1982-08-03', 'PHASE 1, BLK 7, LOT 8-9, NANGKA LANE, WOODRIDGE PARK, MAA, DAVAO CITY', '09258280803', 'Female', 'SF Milay', '0050854', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'SFA Dental Clinic', '*NO NEW ADDRESS YET', 'N/A', 'Davao City', '09258280803', 'BENJAMIN SIMON B. AUSIN, JR.', 'PHASE 1, BLK 7, LOT 8-9, WOODRIDGE PARK, MAA, DAVAO CITY', '09175988931', '2022-01-04 17:41:28', NULL),
(348, NULL, NULL, NULL, 'SARA JANE', 'BURGOS', 'SANTOS', '1968-04-19', 'BLK30 LOT26 WALINGWALING ST COUNTRY HOMES CABANTIAN DAVAO CITY', '09955874106', 'Female', 'sara jane burgos santos', '32125', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Government Dentist', 'Sara Jane B. Santos Dental Clinic', 'Door 10 2nd Flr.SAMULCO Bldg Km5', 'Buhangin', 'Davao City', '09955874106', 'ARNOLD RAMIL T. SANTOS', 'BLK30 LOT26 WALINGWALING ST COUNTRY HOMES CABANTIAN ADAVAO CITY', '09955874096', '2022-01-04 17:41:28', NULL),
(349, NULL, NULL, NULL, 'MA.THERESA', 'ACHA', 'SARANDE', '1978-02-12', 'KM.26 CROSSING LICANAN LASANG DAVAO CITY', '09228399489', 'Female', 'Ma.Theresa Acha Sarande', '43349', '0000-00-00', '0000-00-00', 'General Practice, Prosthodontics, Orthodontics, Periodontics', 'Clinic Owner', 'Acha Dental Clinic', 'door 8 2nd floor SAMULCO Bldg.', 'Buhangin', 'Davao', '09228399489', 'MR.DOMINGO M.ACHA', 'KM.26 CROSSING LICANAN LASANG DAVAO CITY', '09292433595', '2022-01-04 17:41:28', NULL),
(350, NULL, NULL, NULL, 'RONALD', 'ABEN', 'SORIANO', '0080-08-14', '#8 NARRA ST SMS PHASE 3 BANGKAL DAVAO CITY', '08171037114', 'Male', 'Ron Soriano', '0057346', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'RS Dental Clinic', '01 Vyrgyz Place Maa Road', 'Maa', 'Davao City', '09171037114', 'MAY ANNE SORIANO', '#8 NARRA ST SMS PHASE 3 BANGKAL', '+63 995 336 9137', '2022-01-04 17:41:28', NULL),
(351, NULL, NULL, NULL, 'CARRIE LOU', 'A', 'UMUSIG-MENDEZ', '1978-12-20', 'B13 L9 PH2, ST MARTIN STREET, PLANTACION SOLARIEGA, TALOMO, DAVAO CITY', '09778091220', 'Female', 'CLUM DMD', '0045797', '0000-00-00', '0000-00-00', 'General Practice, Orthodontics', 'Clinic Owner', 'Dr. Carrie Lou Umusig-Mendez', 'Door 1 Moneygate Bldg., Ponciano St', 'Brgy 20-B(Pob)', 'Davao City', '09778091220', 'JASON E. MENDEZ', 'B13 L9 PH2, ST MARTIN STREET, PLANTACION SOLARIEGA, TALOMO, D.C.', '09177155651', '2022-01-04 17:41:28', NULL),
(352, NULL, NULL, NULL, 'GAMALIEL', 'SOLEDAD', 'URBI', '1967-08-03', 'L6B24 AMARANTE ST, LAS TERRAZAS , MAA , DAVAO CITY', '09178115741', 'Male', 'Gammy Urbi', '0028115', '0000-00-00', '0000-00-00', 'General Practice', 'Clinic Owner', 'Urbidontics', '2nd level , ABREEZA mall, JP Laurel, davao city', 'Bajada', 'Davao city', '09178115641', 'DESI URBI', 'AMARANTE ST , LAS TERRAZAS, DAVAO', '09178351376', '2022-01-04 17:41:28', NULL),
(353, NULL, NULL, NULL, 'PRINCESS KATRINA', 'ARCONADO', 'YAMBAO', '1979-09-25', 'L14 B33 TOKYO ST, NORTH BAMBU ESTATE, BRGY STO NINO, TUGBOK DISTRICT, DAVAO CITY', '0190984145', 'Female', 'Princess katrina yambao', '0045383', '0000-00-00', '0000-00-00', 'Orthodontics', 'Clinic Owner', 'Yambao dental clinic', 'Esperanza building, 2nd floor, green meadows village,', 'Brgy sto nino, tugbok district', 'Davao city', '019190984145', 'ORPHA YAMBAO', 'L14 B33 TOKYO ST, NORTH BAMBU ESTATE, BRGY STO NINO, TUGNOK DISTRICT, DAVAO CITY', '09215992559', '2022-01-04 17:41:28', NULL),
(354, NULL, NULL, NULL, 'SHERLY', 'P.', 'ZAMORAS-UGDANG', '1971-03-21', 'PRK 3B BRGY.SAN FRANCISCO PANABO CITY, DVO.DEL NORTE', '0948 475 5245', 'Female', 'Shedmd ZU Evans', '0035427', '0000-00-00', '0000-00-00', 'General Practice', 'Company Dentist', 'Tadeco Hospital', 'Tadeco Central', 'Brgy.A.O.Floirendo', 'Panabo', '09484755245', 'EVAN C.UGDANG', 'PRK 3B BRGY.SAN FRANCISCO PANABO CITY', '09186837458', '2022-01-04 17:41:28', NULL),
(356, NULL, NULL, NULL, 'Lucy', 'Liberty Bryant', 'Estrada', '1985-05-05', 'Et maiores commodi omnis eum s', '613', 'Female', 'Oleg Clark', 'qweqwe1231321', '1981-03-09', '2022-01-27', 'General Practice', 'None Practicing', 'Demetrius Joyce', 'Ullamco ipsam tempore dolore', 'Animi qui nihil veniam dolor', 'Id vel officiis eveniet enim', '975', 'Phoebe Tanner', 'Dolorum aut amet exercitation', '404', '2022-01-05 19:14:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `contact_number` int(100) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `fb_account_name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `account_status` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `prc_number` int(20) DEFAULT NULL,
  `prc_registration_date` date DEFAULT NULL,
  `prc_expiration_date` date DEFAULT NULL,
  `field_practice` varchar(255) DEFAULT NULL,
  `type_practice` varchar(255) DEFAULT NULL,
  `emergency_person_name` varchar(255) DEFAULT NULL,
  `emergency_address` varchar(255) DEFAULT NULL,
  `emergency_contact_number` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `payment_option` varchar(255) DEFAULT NULL,
  `fb_user_id` varchar(500) DEFAULT NULL,
  `fb_access_token` varchar(500) DEFAULT NULL,
  `google_user_id` varchar(255) DEFAULT NULL,
  `google_access_token` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `logged_at` timestamp NULL DEFAULT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'member',
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `changing_email` tinyint(1) NOT NULL DEFAULT 0,
  `new_email` varchar(155) DEFAULT NULL,
  `new_password` varchar(255) DEFAULT NULL,
  `forgot_password_vkey` varchar(255) DEFAULT NULL,
  `account_registration_vkey` varchar(255) DEFAULT NULL,
  `change_email_vkey` varchar(255) DEFAULT NULL,
  `email_vkey` varchar(255) DEFAULT NULL,
  `profile_img_path` varchar(255) DEFAULT NULL,
  `status_remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `birthdate`, `address`, `contact_number`, `gender`, `fb_account_name`, `is_active`, `account_status`, `payment_status`, `prc_number`, `prc_registration_date`, `prc_expiration_date`, `field_practice`, `type_practice`, `emergency_person_name`, `emergency_address`, `emergency_contact_number`, `email`, `password`, `payment_option`, `fb_user_id`, `fb_access_token`, `google_user_id`, `google_access_token`, `created_at`, `logged_at`, `role`, `email_verified`, `changing_email`, `new_email`, `new_password`, `forgot_password_vkey`, `account_registration_vkey`, `change_email_vkey`, `email_vkey`, `profile_img_path`, `status_remarks`) VALUES
(1, 'Joan', 'Sarceda', 'Daigdigan', '1979-09-13', 'Phase 2, Road 3, Doña Vicenta Village, Bajada, Davao City', 2147483647, 'Female', 'Joan Sarceda Daigdigan', 1, 'active', 'dormant', 46833, '2005-02-22', '2021-09-13', 'General Practice', 'Clinic Owner', 'Lawrence Ochoa', 'Tempor irure excepteur fugiat', 796, 'cyno@mailinator.com', '$2y$10$4b1ACMOkBTFeiyhclNfBP.awhol6xJEPG5z4YMiSn/HQ.nRanZPZC', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-16 06:12:40', NULL, 'admin', 1, 0, 'jsdaigdigan3@yahoo.com', '$2y$10$soWyl32S2v4RfXCfnHKQvewsgfoFfOsbVxx2btvqVdat7hdjRdjRK', '61b615516c980', NULL, '61c483f488928', '', 'img/profiles/1641037689.webp', NULL),
(2, 'Albert', 'Gaban', 'De Guzman', '1970-02-25', '13 SAN JUAN ST SKYLINE SUBD', 2147483647, 'Male', '', 0, 'inactive', 'complete_payment', 40641, '2000-02-11', '2024-02-25', 'General Practice, Endodontics, Prosthodontics, Orthodontics, Oral and maxillofacial surgery', 'Clinic Owner', 'Ma. Cathrina De Guzman', '13 san juan st skyline subd cat. grande davao city', 822961167, 'mibuwazuc@mailinator.com', '$2y$10$DWYh2EhDmle1YniHZ23lcOm3LJfZeCVPlJFBUQfENymiqJYYUZ/9C', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-16 06:29:45', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, 'not paying for 3 years'),
(3, 'Maria Veronica', 'Kimpo', 'Falcon', '1972-07-11', '', 2147483647, 'Male', 'Veronica Formalejo Kimpo', 0, NULL, NULL, 41216, '2000-07-07', '2024-07-11', 'General Practice, Endodontics, Prosthodontics, Orthodontics, Oral and maxillofacial surgery, Pedodontics, Periodontics', 'Clinic Owner', 'Gemarie B. Montalban', 'Davao City', 915, 'veronicakimpo1972@gmail.com', '$2y$10$ejJ9Y2XjWjVlLiSx3vxIo.je.FTOwgb1zL3S.6btJGT/My.zwA36K', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-16 06:30:33', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, 'not paying for 6 years'),
(4, 'Aries', 'Gullon', 'Luayon', '1994-03-05', 'Blk20 lot5 celica st. Brgy W. Aquino Adgao Davao city', 2147483647, 'Male', 'aries luayon', 1, NULL, NULL, 56660, '2019-01-07', '2021-03-05', 'General Practice', 'Dental Associate', 'Gealina G. Luayon', 'Blk20 lot5 celica st. brgy Aquino, Agdao Davao city', 2147483647, 'teoluayon5@gmail.com ', '$2y$10$dq9zSncJOf6E6KPiPjThr.kseZntkPFyR88iLdCDyX617eovp7oPa', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-16 06:51:02', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(6, 'Maria Rea Lane', 'Lagunay', 'Horfilla-Lopez', '1982-10-17', 'G8rea@yahoo.com', 2147483647, 'Female', 'G8rea@yahoo.com', 1, NULL, NULL, 49493, '2008-07-07', '2024-10-17', 'Pedodontics', 'Clinic Owner', 'Louie Rueven Horfilla', '149 Mahogany st., Palm village, Davao city', 2147483647, 'Rhorfilla@gmail.com', '$2y$10$QEYtoHyKC5J25yPPrdofTe11EvcAtmLHd8Dln8xzMJG83fopWixNe', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-16 07:42:39', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(7, 'Rolando Ryan ', 'R.', 'Oringo', '1977-08-16', '482 Riverside Road Ma-a Davao City', 2147483647, 'Male', 'Ryan Oringo', 1, NULL, NULL, 42210, '2000-08-16', '2023-08-16', 'General Practice, Endodontics', 'Corporate dentist', 'Marilen oringo', 'Same', 0, 'droringo@yahoo.com', '$2y$10$xvyp9XbfdFavgTd.S2E.x.sOgUQqLDr5YNJ18VIZKCwtAxNBQtQzi', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-16 08:15:32', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(8, 'ana marie', 'espina', 'jimenez', '1971-05-05', 'ph2 blk4 lot 17 gulf view', 2147483647, 'Female', 'ana marie jimenez', 1, NULL, NULL, 38133, '1998-07-06', '2022-05-05', 'General Practice', 'Clinic Owner', 'randy tuquib', 'ph 2blk 4 lot 17 gulf view', 906578129, 'anamarietuquib@icloud.com', '$2y$10$XN3IR92XNUSixLEBDgTyXujSKi15.zDAgtcf928Ul27O6YfNdgkim', 'Collection Center (DCDC Office)', NULL, NULL, NULL, NULL, '2021-08-17 02:41:37', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(9, 'Ivy', 'Nallos', 'Bautista-Magbiray', '1978-07-30', '#34 blk 10, Chula Vista Residences, Cabatian, Buhangin, Davao city', 2147483647, 'Female', 'Yvee', 1, NULL, NULL, 42444, '2001-07-11', '0023-07-30', 'General Practice, Orthodontics', 'Clinic Owner', 'Haacon Magbiray', '#34 blk 10, chula vista residences, Cabantian, buhangin', 2147483647, 'yvidsm@yahoo.com', '$2y$10$BL5aS1hcb0W0tcOLaILUOea4VL5WmfZ79c9GDfFWQa9l/FiSGcAB6', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-17 15:47:15', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(10, 'MARICEL', 'TE', 'HUANG', '1979-03-16', '0512 Samal corner Surigao Street, Insular Village, Phase 2, Lanang, Davao City', 2147483647, 'Female', 'Maricel Te-Huang', 1, NULL, NULL, 44740, '2003-03-18', '2022-03-16', 'Orthodontics', 'Clinic Owner', 'Jasper Huang', '0512 Samal corner Surigao Stree, Insular Village, Phase 2, Lanang, Davao City', 2147483647, 'mariceltehuang@gmail.com', '$2y$10$TzDhlBJOLvND54wnL5uaJO98hfyJbjORBVxcXdQsFKTzi/Ux3Fi3q', 'Bank to Bank Transfer', NULL, NULL, NULL, NULL, '2021-08-19 03:51:35', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(11, ' MARIE IRIS ', 'Q.', 'CELIS', '1974-12-08', 'Blk12 lot 14 Wellspring Village Phase 3,Catalunan Pequeno Davao City', 2147483647, 'Female', 'Marie Iris Q.Celis', 1, NULL, NULL, 39610, '1998-07-31', '2022-12-08', 'General Practice, Orthodontics', 'Clinic Owner', 'Joebert O.Celis', 'B12 Lot 14 Wellspring Village Phase 3,Catalunan Pequeño Davao City', 2147483647, 'Iris_dental@yahoo.com ', '$2y$10$1cpwo4uqcXoG2KLsLOXvJubhETN891tk1SLZ.YqJjLz2bXmiehlyy', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-19 11:11:24', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(12, 'Guinevere', 'Breanna Carr', 'Phelps', '1988-10-06', 'Voluptatibus officia eu ut nis', 436, 'Male', 'Willa Humphrey', 1, NULL, NULL, 294, '1989-11-10', '2022-01-21', 'Prosthodontics', 'Dental Associate', 'Lacota Maxwell', 'Voluptatem natus voluptate nat', 321, 'deckiebeng@yahoo.com', '$2y$10$KFAjNjaP1ssCIt1djZfn8e.u2njqBB23XYmcT9VcLLwDdnr7kHe7y', 'Collection Center (DCDC Office)', NULL, NULL, NULL, NULL, '2021-08-19 13:49:21', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(13, 'anthony', 'jay', 'ansit', '2022-01-12', 'q', 0, 'Male', 'Pamela Dawson', 1, NULL, NULL, 123415, '2021-12-08', '2022-01-20', 'Endodontics', 'School Dentist', 'Haley Jarvis', 'Rem quae cumque in id iusto e', 359, 'gubu@mailinator.com', '$2y$10$amljrBtm8eB1pFQsZWK0nOSTJmxziShHOJLyAcKzyeIeo6C0UXpim', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-20 05:43:25', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(14, 'Cecile', 'S.', 'Cuaton', '1975-10-28', 'C1 Col.Palacio St. Pag asa Homes Subd.Buhangin, Davao City', 2147483647, 'Female', 'Cecile Sabado-cuaton', 1, NULL, NULL, 42878, '2001-12-20', '2024-10-28', 'General Practice, Orthodontics', 'Clinic Owner', 'Rimando P. Cuaton', 'C1 Col.Palacio St. Pag asa Homes Subd Buhangin, Davao City', 2147483647, 'cessabado@yahoo.com', '$2y$10$VqaaTGPHl51cvWoCa/I8hOWqvOtO/xwFIsFe8bfhhySwSQyxRFwkK', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-20 06:21:08', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(15, 'GLENDA', 'PERPETUA', 'BARBON', '1971-01-30', 'Corner patnubay st sandawa road new matina davao city', 2147483647, 'Female', 'Glenda Barbon', 1, NULL, NULL, 43330, '2002-03-13', '2023-01-30', 'General Practice', 'Clinic Owner', 'Nornel C Crausus', 'Corner patnubay st sandawa road davao city', 2147483647, 'glenda.barbon.crausus@gmail.com', '$2y$10$eOKa0RARo/fVQ8fselmCG.wyIBb9w.WjskbonQ9jIbmY/hEvpKTPu', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-20 10:06:11', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(16, 'Golda', 'Taay', 'Salvadico', '1975-09-03', '#11, T.Martinez st. Ph2, SIR,New Matina Davao city', 2147483647, 'Female', 'Diezel gold taay', 1, NULL, NULL, 49037, '2008-01-14', '2022-09-03', 'General Practice', 'Clinic Owner', 'Anthony Salvadico', '#11, T.Martinez st. PH2, SIR, New Matina Davao City', 2147483647, 'goldsalvadico@gmail.com', '$2y$10$Sz6gqAGLYOG1l.JP9vWP7uBpZ4WAxLTpAXKDMNYFhaBvsl.MJbwVG', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-20 11:34:23', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(17, 'Marjorie clarice', 'Altavas', 'Ang', '1979-07-06', '57 t. Monteverde avenue', 2147483647, 'Female', 'Marjorie clarice ducase', 1, NULL, NULL, 44542, '2003-02-07', '2024-07-06', 'General Practice', 'Clinic Owner', 'Behnjie ducase', '57 t. Monteverde avenue', 2147483647, 'aynaducase@gmail.com', '$2y$10$NBF4/o4TvaRNMywVAhPW1eQqBoKHlygQAIBcciJRhIhnKL7vv1Jg2', 'Bank to Bank Transfer', NULL, NULL, NULL, NULL, '2021-08-20 23:16:05', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(18, 'Ruby Socorro', 'Ecleo', 'Alba', '1990-09-18', 'Blk 10, Lot 32, Gardenia Street, La Vista Monte II, Matina, Davao City', 2147483647, 'Female', 'Ruby Alba', 0, NULL, NULL, 55116, '2018-01-17', '2021-09-18', 'General Practice', 'Dental Associate', 'Corazon Alba', 'Blk 10, Lot 32, Gardenia Street, La Vista Monte II, Matina, Davao City', 63, 'rubyealba@yahoo.com', '$2y$10$EwiTzwyGZgj.K5cOZThl2./kcPS9hnKNAkpW1hYxE1JW.udUJQu5q', 'Bank to Bank Transfer', NULL, NULL, NULL, NULL, '2021-08-21 04:52:19', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, ''),
(19, 'Lori', 'Moral', 'Bangi', '1979-12-28', 'Be dujali davao del norte', 2147483647, 'Female', 'Lori Moral', 1, NULL, NULL, 44703, '2003-02-21', '2024-12-28', 'General Practice', 'Clinic Owner', 'Ruginald bangi', 'Purok 4 brgy dujali be dujali davao del norte', 2147483647, 'lorimoral@yahoo.com', '$2y$10$WTBMbsAsYG6bSUsyANlp2ebdAO57vj9YjuGKJYCKgFbW1eVupiN7O', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-21 08:46:25', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(20, 'Jay Lynn', 'Zantua', 'Pajares', '1962-07-09', 'Deca Homes Phase 5 Block 102 Lots 37-39 Brgy Tugbok Mintal,Davao cityMarble Wood St. Brgy. tugbok', 2147483647, 'Female', 'Jay Lynn Fuentes', 1, NULL, NULL, 20587, '1985-10-01', '2024-07-09', 'General Practice', 'Clinic Owner', 'Anjolie Johns', 'Libero autem non quae est eni', 679, 'kecesomu@mailinator.com', '$2y$10$vWiXcCaFwshSfJBNZ6wnour1UOc0MMrRUCabsr2xTLM7CHIL3fsEq', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-21 08:51:16', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(21, 'Rene Ann ', 'Patulot', 'Milagrosa ', '1979-07-02', 'Blk 11 Lot 6 Banana Street Ciudad Esperanza Cabantian Davao City Davao del Sur 8000 ', 2147483647, 'Female', 'Rene Ann Milagrosa ', 1, NULL, NULL, 48854, '2007-08-13', '2022-07-02', 'General Practice', 'None Practicing', 'Sergia Milagrosa ', 'Blk 11 Lot 6 Banana Street Ciudad Esperanza Cabantian Davao City Davao del Sur 8000 ', 2147483647, 'renea_mil1979@yahoo.com ', '$2y$10$O.8sUNxGEYVQxHZH32LYM.HwFCNrkIcGWu2n5xm/b8mvivTITXDj.', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-22 02:08:43', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(22, 'Marilen', 'L', 'Gomez-Oringo', '1977-06-01', '482 Riverside Road Jail Road Ma-a Davao City', 2147483647, 'Female', 'Marilen L. Gomez-Oringo', 1, NULL, NULL, 42445, '2001-07-04', '2023-06-01', 'General Practice, Orthodontics', 'Corporate', 'Rolando Ryan Oringo', '482 Jail Road Ma-a Davao City', 2147483647, 'doctororingo@gmail.com', '$2y$10$RpFPRAH/R/E4483m6WQehOYFeXTE6mZQW65Y0r8mgHlRbTnZL7xIm', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-22 02:35:45', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(24, 'SUZANNE NOREEN ', 'DIAZ ', 'DE LIMA ', '1986-08-14', 'L11 B1 BRC VILLAGE CATALUNAN PEQUEÑO DAVAO CITY ', 2147483647, 'Female', 'Suzanne de Lima ', 1, NULL, NULL, 51043, '2011-07-18', '2024-08-14', 'General Practice', 'Clinic Owner', 'Delilah de Lima (mother) ', 'L11 B1 BRC VILLAGE CATALUNAN PEQUEÑO DAVAO CITY ', 2147483647, 'snoreen.delima@gmail.com ', '$2y$10$lrc.N5r3dp7kl11TTcanguBMuKzQbTiHPyUcJ1DYr86m2Qb/XxIUe', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-22 02:40:15', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(25, 'Ethel ', 'Chavez ', 'Caceres ', '1979-10-05', 'Blk8 Lot 10-11 Camella Homes Communal Davao City ', 2147483647, 'Female', 'Ethel Chavez-Caceres ', 1, NULL, NULL, 44652, '2004-08-23', '2021-10-05', 'General Practice, Orthodontics, TMD Pain Management ', 'Clinic Owner', 'Benjamin B Caceres II', 'Blk8 Lot 10-11 Camella Homes Communal Davao City ', 2147483647, 'dr.ethelchavez_dmd@yahoo.com ', '$2y$10$Ao/R54sBQ4M5LI7abm.hIusKzgpIDW5CoZxVv557PTLBkJrSvvCyq', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-22 04:28:04', NULL, 'admin', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(26, 'Macel', 'Suobiron', 'Ortiz', '1986-03-19', 'Blk.38 lot 11 Deca homes subd.', 2147483647, 'Female', 'Macel suobiron-ortiz', 1, NULL, NULL, 50361, '2010-01-22', '2022-03-19', 'General Practice, Orthodontics', 'Clinic Owner', 'Jed Christian Angelo M. Ortiz', 'Blk.38 lot 11 Deca homes, tugbok proper, davao city', 2147483647, 'wataqyxiv@mailinator.com', '$2y$10$PgpcjzCN56mNGpjUo35HnOQOlfBl4t/IDIcB3i9QrwTjGlzzekT56', 'Collection Center (DCDC Office)', NULL, NULL, NULL, NULL, '2021-08-24 01:35:09', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(27, 'Vanessa Elaine', 'Faduga', 'Latag', '1994-07-08', 'B7, L7, Rosalina Vill. 1, Bago Gallera, Davao City', 2147483647, 'Female', 'Vanessa Latag', 1, NULL, NULL, 56860, '2019-02-13', '2022-07-08', 'General Practice', 'Clinic Owner', 'Jocelyn F. Latag', 'B7, L7, Rosalina Vill. 1, Bago Gallera, Davao City', 2147483647, 'fuqif@mailinator.com', '$2y$10$/NQsUv9FyUEsvNlWtLpzCefp7N70af.SCYpFS9MXspB9ki43NWSXa', 'Bank to Bank Transfer', NULL, NULL, NULL, NULL, '2021-08-24 04:24:13', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(28, 'CITI SARA', 'MISA', 'HERNAEZ', '1993-08-03', '709 Urban Hive Palms, Bacaca Rd., Davao City', 2147483647, 'Female', 'Citi Hernaez', 1, NULL, NULL, 54330, '2017-01-27', '2023-08-03', 'General Practice, Endodontics, Prosthodontics, Orthodontics, Oral and maxillofacial surgery, Pedodontics, Periodontics', 'Dental Associate', 'Rosario H. Mansukhani', 'Woodridge, Ma-a, Davao City', 2147483647, 'csmhernaez@gmail.com', '$2y$10$XtiidY06apyteyWxQFtUPuVGGwAVFi9K0WZoIARXM6vtye0UnaJ0C', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-24 04:26:20', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(29, 'Jiselle ', 'Yu', 'Daniel ', '1991-09-30', 'Blk 1 Lot 1 Country Homes Cabantian Davao City ', 2147483647, 'Female', 'Jiselle Daniel ', 1, NULL, NULL, 56600, '2019-01-17', '2022-09-30', 'General Practice, Endodontics, Orthodontics', 'Dental Associate', 'Bernadette Daniel ', 'Blk 1 Lot 1 Country Homes Cabantian Davao City ', 2147483647, 'jiseldanieldmd@gmail.com ', '$2y$10$BgG5IQKoYZQ3lbrIxV1jIeo9cq3xDscMU5jL4KLAfw9JAViLtgyEy', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-24 04:31:41', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(30, 'Anne Geliza', 'Nombrado', 'Molina', '1993-04-07', 'Booc Compound, Purok 1, Subasta, Calinan Davao City', 2147483647, 'Female', 'Anne G. Nombrado-Molina', 1, NULL, NULL, 55243, '2018-01-18', '2024-04-07', 'General Practice', 'Clinic Owner', 'Lester Jeremy Molina', 'Booc Compound Purok 1, Subasta, Calinan, Davao City', 2147483647, 'nombrado.anne@gmail.com', '$2y$10$UIzuDTD1g6ZrVKe3QIcuEuLIJP2JsjDZAPUOH5hUvKyKz/zzHGGNS', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-24 04:36:03', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(31, 'Emmaryl', 'Escalona', 'Julian', '1993-09-18', 'Maa', 2147483647, 'Female', 'Emmaryl E. Julian-Frando', 1, NULL, NULL, 55337, '2018-01-19', '2021-09-08', 'General Practice, Endodontics, Prosthodontics, Pedodontics, Periodontics', 'Dental Associate', 'Mark Christian Frando', 'Maa', 2147483647, 'emmaryljulian@gmail.com', '$2y$10$NUAVLZ0LlZPLzi982PZ90elzmYPSKHIhx24oqg23DhKP0IBV8Q6QO', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-24 04:42:58', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(32, 'Rosario', 'H', 'Mansukhani', '1957-10-30', '28 Molave Lane, Woodridge Park Subdivision, Maa, Davao City', 0, 'Female', 'N/A', 0, NULL, NULL, 17002, '1982-11-09', '2024-10-30', 'General Practice', 'Clinic Owner', 'Parkash T. Mansukhani', '28 Molave Lane, Woodridge Park Subdivision, Maa , Davao City', 0, 'chitmansukhani@live.com', '$2y$10$Z8XJn.5fVSg1n6B.mhPKxevCZU7TeZ/PpLS/wsRGmB7xaHZy2zQcG', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-24 07:23:39', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, ''),
(33, 'Charito', 'Solon', 'Nazareno', '1967-06-06', '736 Alzate extension N.Torres BO. Obrero Davao City', 2147483647, 'Female', 'Mel Lani', 1, NULL, NULL, 37460, '1997-03-04', '2021-06-06', 'General Practice', 'Clinic Owner', 'Hector Nazareno', 'Metro Medical Diagnostic Research Center', 2147483647, 'chadm.nzreno@gmail.com', '$2y$10$INcYjeO6db0Tskyuu4Y1NOnbFQVq9N9NpiJ8q8kAiYVeKCtT.yBde', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-26 04:15:51', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(34, 'Shane Marie', 'Dalman', 'Clitar', '1993-12-18', 'B12 L21 P1 Narra St Vista Verde Subd Panacan DC', 2147483647, 'Female', 'Shane Marie Clitar', 1, NULL, NULL, 54790, '2018-01-16', '2021-12-18', 'General Practice, Orthodontics, Oral and maxillofacial surgery', 'Clinic Owner', 'Siony Boy Bella', 'B12 L21 P1 Narra St Vista Verde Subd Panacan Dc', 2147483647, 'smdclitar@gmail.com', '$2y$10$pfAi8HjDnC2Ib7tJXpEyKuoy6AsY7/y/5IFB2mEwI41KEXkeczu12', 'Bank to Bank Transfer', NULL, NULL, NULL, NULL, '2021-08-26 08:36:23', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(35, 'Delma', 'Booc', 'Nombrado', '1969-07-16', 'Booc Compound, Purok 1, Subasta, Calinan, Davao City', 2147483647, 'Female', 'Delma Nombrado', 1, NULL, NULL, 32864, '1993-08-09', '2022-07-16', 'General Practice', 'Clinic Owner', 'Anne Geliza Molina', 'Booc Compound, Purok 1, Subasta, Calinan, Davao City', 2147483647, 'bndc_delma@yahoo.com', '$2y$10$p34vwUyjA4XzOqAfRJfguupTIVM9tIg.xy14FwLNJvNLPF93uC70y', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-26 15:54:06', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(36, 'Teresa ', 'Dulay', 'Apurada', '1969-07-14', 'Blk 11.Lot 6.Datepalm stree.Twin Palms.Maa Davao City', 2147483647, 'Female', 'Teresa Apurada-Lawas', 1, NULL, NULL, 48587, '2007-02-26', '2022-07-14', 'General Practice', 'Clinic Owner', 'Alexander N.Lawas', 'Blk 11.Lot6.Datepalm Street.Twin Palms Maa.Davao City', 2147483647, 'tdalawas@gmail.com', '$2y$10$QjOxzG0ufxPUR2qHCTW1Qe5uc/gtTcdbyz7Ftun0MVr.W2pPXI3pS', 'April 28,2021 Provisional receipt#16778', NULL, NULL, NULL, NULL, '2021-08-26 23:53:16', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(37, 'Alma Luz', 'Dizon', 'Banawis', '1965-11-23', 'Bldg. 1 One Oasis Condo, Ecoland, Davao City', 2147483647, 'Female', 'Amie Dizon Banawis', 1, NULL, NULL, 24525, '1988-12-08', '2021-11-23', 'General Practice', 'Clinic Owner', 'Gabriel Angelo B. Razo', '003 JP Laurel St., Kidapawan City', 2147483647, 'aldbsagi23@gmail.com', '$2y$10$EvALfeh8/WUUIf4cc1J6Uekn3EU70PTq.d7zpPDG812ntwWaqSQq2', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-30 00:40:41', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(38, 'Princess Katrina', 'Arconado', 'Yambao', '1979-09-25', 'L14 b33 tokyo st, north bambu estate, brgy sto nino, tugbok district, davao city', 190984145, 'Female', 'Princess katrina yambao', 0, NULL, NULL, 45383, '2004-09-19', '2024-09-25', 'Orthodontics', 'Clinic Owner', 'Orpha yambao', 'L14 b33 tokyo st, north bambu estate, brgy sto nino, tugnok district, davao city', 2147483647, 'Pkyambao@yahoo.con', '$2y$10$6HDlufOro/vCltRH0KroQulxCRjNsZuYfw0TYRXxPZ2dJ2sxb5wwi', 'Gcash', NULL, NULL, NULL, NULL, '2021-08-30 01:32:37', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, 'Set as inactiveqweq'),
(39, 'Francis Jose Corazon', 'M', 'Liston', '1967-12-04', '15-B Jose Camus St., Davao City', 2147483647, 'Male', 'Francis Liston', 1, NULL, NULL, 27816, '1990-12-07', '2022-12-04', 'General Practice', 'Dental Associate', 'Cynthia C. Liston', '15-B Jose Camus St., Davao City', 2147483647, 'fmliston@yahoo.com', '$2y$10$IQXa0LfO6IFktklhw1vwnuSh1RckcHExlgF4Ca46VTqSNhBaFISqO', 'Gcash', NULL, NULL, NULL, NULL, '2021-09-01 00:39:42', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(40, 'Carrie Lou', 'A', 'Umusig-Mendez', '1978-12-20', 'B13 L9 Ph2, St Martin street, Plantacion Solariega, Talomo, Davao City', 2147483647, 'Female', 'CLUM DMD', 1, NULL, NULL, 45797, '2004-03-08', '2023-12-20', 'General Practice, Orthodontics', 'Clinic Owner', 'Jason E. Mendez', 'B13 L9 Ph2, St Martin street, Plantacion Solariega, Talomo, D.C.', 2147483647, 'caymendez.dmd@gmail.com', '$2y$10$eYBCzADHC7OEEUwFE0MC3uPvEoVERWD.PC39N3NrE5xvLw5sUX7kq', 'Gcash', NULL, NULL, NULL, NULL, '2021-09-01 03:08:04', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(42, 'Maria Theresa', 'Dionio', 'Borres', '1972-12-25', 'Ph-3,Zinc St. Emily Homes Cabantian Buhangin Davao City', 2147483647, 'Female', 'Maria Theresa Borres Pangoy', 1, NULL, NULL, 36664, '1996-08-26', '2022-12-25', 'General Practice', 'Clinic Owner', 'Simeon A. Pangoy', 'Ph-3,Zinc St. Emily Homes Cabantian Buhangin Davao City', 2147483647, 'mariatheresapangoy@gmail.com', '$2y$10$HZiUgE4bKWQshJRgq2uKPuSmpK3utQXrvKmxm0zRj.ahaMzv0q5qS', 'Gcash', NULL, NULL, NULL, NULL, '2021-09-01 08:55:29', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(43, 'Aimee Grace', 'Mañego', 'Luza', '1984-09-08', 'block 20 lot 22, Mediterranean sea street, gulfview executive Homes, Bago Aplaya, Davao City', 2147483647, 'Female', 'Aimee Grace', 0, NULL, NULL, 50881, '2011-06-13', '2023-09-08', 'General Practice, aesthetic dentistry', 'Clinic Owner', 'Redin Boteros', 'Gulfview Executive Homes, Bago aplaya, Davao city', 2147483647, 'docaimee.luza@gmail.com', '$2y$10$8O2HxK.Drn/3e4bGfTyFUed.YK5szHj4t7hgn47DUWrtmvlBZ5Fge', 'Gcash', NULL, NULL, NULL, NULL, '2021-09-01 13:57:16', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, ''),
(44, 'Jacqueline', 'Galagate', 'Delgado', '1973-11-12', 'Blk 10 Lot 10 Samantha Homes Catalunan Pequeno Davao City', 2147483647, 'Female', 'Jacqueline Galagate Delgado', 1, NULL, NULL, 43121, '2002-02-06', '2023-11-12', 'General Practice', 'Government Dentist', 'Romeo ORCAJADA Delgado Jr.', 'Blk 10 Lot 20 Samantha Homes Catalunan Pequeno Davao City', 2147483647, 'jacquelinegalagatedelgado@yahoo.com', '$2y$10$uA3A.ENszb2XPccVMVzzg.1ojYGhcMNJ8Za257JZQSikg.Gx1sfD6', 'Gcash', NULL, NULL, NULL, NULL, '2021-09-02 10:08:49', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(45, 'Jennifer Christine ', 'Yee', 'Lim', '1972-12-24', 'AML bldg Camus st ext davao city', 2147483647, 'Female', 'Jen Lim', 1, NULL, NULL, 35845, '1996-02-28', '2024-12-24', 'General Practice, Endodontics, Periodontics', 'Clinic Owner', 'Shannen Lim', 'AML BLDG CAMUS ST EXT DAVAO CITY ', 2147483647, 'ajlimdental@gmail.com ', '$2y$10$tmbFNAptLOQldQmeimyrJ.srfmhZpkysAFWQQAHMNNUQMJw7fYQTm', 'Gcash', NULL, NULL, NULL, NULL, '2021-09-02 13:53:44', NULL, 'admin', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(47, 'Elaine joy', 'Maganda', 'Maganda-Tiaga', '1978-11-04', 'Blk 2 lot 28 emerald st doña rosa toril davao city', 2147483647, 'Female', 'Elaine joy m tiaga', 1, NULL, NULL, 43326, '2002-03-13', '2022-11-04', 'General Practice', 'Clinic Owner', 'Yll russell C tiaga', 'Blk 2 lot 28 emerald st doña rosa toril dc', 2147483647, 'elainetiaga@yahoo.com', '$2y$10$VLD4FZ.mVKspv7GC9EXjtOyz52tnSqxtXFH4U.rEDoAvt4PC1MBmO', 'Bank to Bank Transfer', NULL, NULL, NULL, NULL, '2021-09-03 00:21:54', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, ''),
(48, 'Imelda', '', 'Cabalza-Susi', '1968-08-16', '97 Kingfisher st., St. Michael villge 2, Maa, Davao City', 2147483647, 'Female', 'Imelda Cabalza', 1, NULL, NULL, 35081, '1995-07-20', '2024-08-16', 'General Practice, Orthodontics', 'Clinic Owner', 'Dante Susi', '97 Kingfisher st., St. Michael village 2, Maa, Davao City', 2147483647, 'imeldacabalza@yahoo.com', '$2y$10$t13gDqKfETRF3RofXLNU4eGz1SDV8Vt2oYqE7xmuj3VUJHIV1jupC', 'Gcash', NULL, NULL, NULL, NULL, '2021-09-03 00:43:45', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(49, 'MARIA CRISTINA', 'PALAFOX', 'DOMINGO', '1974-01-28', '#14 Adams St,, Royal Pines South, McArthur Highway, Matina, Davao City', 2147483647, 'Female', 'Tina Domingo', 0, NULL, NULL, 40133, '1999-07-05', '2022-01-28', 'General Practice, Pedodontics', 'Clinic Owner', 'Jonathan Domingo', 'c/o Manulife, 7th floor Abreeza Corporate Bldg, Davao City', 2147483647, 'tiens28@gmail.com', '$2y$10$zdipBO87pH2iySJGJWShse5PN19ebBQST5okHRdJxnmpZzdQgogzy', 'Gcash', NULL, NULL, NULL, NULL, '2021-09-03 07:26:31', NULL, 'member', 1, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, ''),
(50, 'rene june', 'viscaya', 'feria', '1982-06-03', '06 pandango street lanzona subd matina davao city', 2147483647, 'Female', 'Ren-ren', 1, NULL, NULL, 48141, '2006-06-27', '2024-06-03', 'General Practice, Endodontics, Prosthodontics, Orthodontics, Oral and maxillofacial surgery', 'Clinic Owner', 'may marie s. feria', '06 pandango street lanzona subd matina davao city', 2147483647, 'qwe@2qwqew.com', '$2y$10$9xooCB.AnOqJPLMmNOK44.cgXmcG8QXwPjnFofGVzIm2mGhlUNgpa', 'Gcash', NULL, NULL, NULL, NULL, '2021-09-03 09:42:04', NULL, 'admin', 1, 0, NULL, NULL, NULL, NULL, NULL, '', 'img/profiles/1640191267.jpg', NULL),
(602, 'Leslie', 'Rylee Merrill', 'Daniels', '1991-08-12', 'Non voluptate eiusmod rerum qu', 642, 'Male', 'Quintessa Mills', 1, NULL, NULL, 471, '1976-05-23', '2021-12-21', 'Endodontics', 'Government Dentist', 'Arthur KellerMartina Simon', 'Vitae soluta sapiente nostrud Ea officia laboris magnam fuga', 94945, 'anthonyjayansit2326282@gmail.com', '$2y$10$aPnL5bNUb7cjiX/kkRvMRuyQ3Q4jU.7T5HWWmBvYumbfpnNWU2jKq', NULL, '638201287539350', 'EAAIf2R35MYABALG10dyooz6kwEgZCuL4sRV2oSENQ8HkSBR8W3AreVaSzpQUYiE0AHhYHZCmK8vQuvn0kuebguwp8XfDN4VLZBW6ES97U1MpKP7t1zCuztm5uKOk5WLEdb7fpZA0ZAcxQxPkJ4rW91L3nbfhiZBbqGSmUHZABIUyUu6gUNF2zGl4JJKGMaKlcLToAEPJ8QlnBrp4wavP2NGKZCl2MSeJpBJmXYNiyjNtWB2VHDM8NtnzSK7VIEgM1KEeQ3fXXYpLWW5uYVFdpkCW', NULL, NULL, '2021-12-11 12:35:31', NULL, 'member', 1, 0, NULL, '$2y$10$KKZyaWn9l16JGUV2HwDSY.yqs2ZsfQLlwggYkntAaNzX71jkvwZny', '61c48b0645308', '61b49b4480e80', NULL, '61b49b1350140', 'img/profiles/1640202044.png', ''),
(603, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'latop@mailinator.com', '$2y$10$Be26wyPz08Iwj7B2IxlEtelQg0XOnE.cyOoTFUeJb81ZdGrNIEHcK', NULL, NULL, NULL, NULL, NULL, '2021-12-11 13:02:17', NULL, 'member', 0, 0, NULL, NULL, NULL, '61b4a23559d80', NULL, '61b4a1590a028', NULL, NULL),
(604, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jyzeru@mailinator.com', '$2y$10$6KopmjCzwRYP4KXt8sPweuiCQ3BDwHG2KbMwDCcbSvDuEKQW/bUq2', NULL, NULL, NULL, NULL, NULL, '2021-12-11 17:11:17', NULL, 'member', 0, 0, NULL, NULL, NULL, '61b4dbb5a8368', NULL, '61b4dbb597db0', NULL, ''),
(605, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'babamuviki@mailinator.com', '$2y$10$OxVzrd9emRngRqqvkbpORO2H75BnT758Qlq25y/DkoSSPx5JZpMHy', NULL, NULL, NULL, '104128608322787432739', 'ya29.a0ARrdaM8NXLXFO1IJhRwpyVvwmf9vK52aF1_wA_4GUnDcFaInxmtH3CuPmmM75cYlobLwAgMTHPxa9hXEpVA0nxwuw5GE_dVBRN6peYnWnq1ovzCTwYa77sv0Nik0gQk0s1_Ycp5G8X0-LjkaSpDNxa3tzsNr', '2021-12-12 15:20:43', NULL, 'member', 1, 0, NULL, NULL, NULL, '61b613dacd078', NULL, '61b6134ba7eb8', NULL, 'qweqwe123qwe'),
(10001, 'Anthony jay', 'Pañales', 'Ansit', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ansit@superadmin.com', '$2y$10$eCnl6O8wXFfP66HNxbe6Ru/X/BvBPOqHpEOg6Tlab1heYA/c1f8zi', NULL, NULL, NULL, '105003354943600421494', 'ya29.a0ARrdaM-tYCSUtOOXO8BB6wys44TrcrGnvnMjArPRjtR2UszpqafjjIlFgrRq10FG0Tx1tE31L4kYEfGD_eFGsTFaLCsZ4taYWY8L2FlJCaeS6Fhfz7s4-_M1e3OXYXoGBhvFcJOwMBDu-s5lCSgCyr8j5Wbu', '2021-12-16 07:24:26', NULL, 'superadmin', 1, 0, 'naqutati2@mailinator.com', NULL, NULL, '61baed3f98328', '61baf97e79310', '61bae9aad01b0', 'img/profiles/1640569529.png', ''),
(10002, 'president', 'president', 'president', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'president@superadmin.com', '$2y$10$jovOy6QIu2umoTCehzpAD.rdmD9OL7CgNqeSu9QTYkd3aZqH46taq', NULL, NULL, NULL, NULL, NULL, '2021-12-22 12:54:35', NULL, 'superadmin', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10003, 'Carlos', 'Yaku', 'Abiera', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'carlos@superadmin.com', '$2y$10$jovOy6QIu2umoTCehzpAD.rdmD9OL7CgNqeSu9QTYkd3aZqH46taq', NULL, NULL, NULL, NULL, NULL, '2021-12-22 12:54:35', NULL, 'superadmin', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100005, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xedec@mailinator.com', '$2y$10$mTaFmgK.oj6krlosKZMKouliGrkIts5IPQnarnCD7X/MDULrBZK2W', NULL, NULL, NULL, NULL, NULL, '2021-12-23 13:05:13', NULL, 'member', 0, 0, NULL, NULL, NULL, '61c47409c6570', NULL, '61c47409abf90', NULL, NULL),
(100006, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bofefele@mailinator.com', '$2y$10$DGdXRqPrQLLFFR/fuQbEuuL3Ykj/iCQACf74nxZP6br6sJb.Lki7.', NULL, NULL, NULL, NULL, NULL, '2021-12-23 13:07:47', NULL, 'member', 0, 0, NULL, NULL, NULL, '61c474a3e1708', NULL, '61c474a3d1538', NULL, NULL),
(100014, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'lizyroq@mailinator.com', '$2y$10$jc1CA/CpYqhZYeG2Jseus.e/H/W27Cylbcd2Mw9DfQnIY0i/uDdy6', NULL, NULL, NULL, NULL, NULL, '2021-12-23 15:04:53', NULL, 'member', 0, 0, NULL, NULL, NULL, '61c490154c838', NULL, '61c490152ad28', NULL, NULL),
(100016, 'Abel', 'Marny Frazier', 'Johns', '1973-01-18', 'Minim quidem obcaecati Nam inc', 783, 'Male', 'Hop Rosario', 0, NULL, NULL, 206, '1986-05-06', '2022-01-07', 'General Practice', 'None Practicing', 'Lana Whitehead', 'Eaque ullam at cum aperiam num', 874, 'qucyse@mailinator.com', '$2y$10$0lAL.6ijTrrmAKbxMqZ7Xe2kJSohntipprBGgCizinGvtlNYcHMe2', NULL, NULL, NULL, NULL, NULL, '2021-12-26 05:59:07', NULL, 'admin', 1, 0, NULL, NULL, NULL, '61c804bd92f90', NULL, '61c804ab98198', NULL, ''),
(100018, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'kakehevew@mailinator.com', '$2y$10$5R7x6OpabWAA3BrG.yWxq.jHhWLSNgr/wpZGuRm15cp/.krR1nTGm', NULL, NULL, NULL, NULL, NULL, '2021-12-26 07:14:05', NULL, 'member', 1, 0, NULL, NULL, NULL, '61c8166687be0', NULL, '61c8163da9ad8', NULL, NULL),
(100020, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '108714037774712897467', 'ya29.a0ARrdaM_PaADeZzgQEGl_tNul2sjSlHlWwxrbTRRDcI-0GOr_b-snaAqY7qst6WeuIUXyTsEJTvoHDUXuNvnWfYK3xvkj_4wQJ_3yeojjoH0KN2dHNVS3Mc1ZYMQiQnWcsN_KdVmQMBdIsghdlYE3uIvPHDeLBpU', '2021-12-27 01:42:28', NULL, 'member', 0, 0, NULL, NULL, NULL, NULL, NULL, '61c91a0493378', NULL, NULL),
(100021, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pifafi@mailinator.com', '$2y$10$VgH29nR/jxbekgUXGhBAMe5QIhBBn5wzMst27Ln0Ct/PzyO5S4Oza', NULL, NULL, NULL, NULL, NULL, '2021-12-28 03:43:59', NULL, 'member', 1, 0, NULL, NULL, NULL, '61ca880a8e0a8', NULL, '61ca87ff0c670', NULL, NULL),
(100022, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'zeza@mailinator.com', '$2y$10$BS27G5bBlpfHHXQWS1bdbOEQQ/X9Wz8x8OD0lT0Z404H8BxAm2yCS', NULL, NULL, NULL, NULL, NULL, '2021-12-28 03:48:39', NULL, 'member', 1, 0, NULL, NULL, NULL, '61ca89256f860', NULL, '61ca8917e6aa0', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profile_id` (`profile_id`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `dues`
--
ALTER TABLE `dues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dues22`
--
ALTER TABLE `dues22`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prc_number` (`prc_number`);

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
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;

--
-- AUTO_INCREMENT for table `dues`
--
ALTER TABLE `dues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=298;

--
-- AUTO_INCREMENT for table `dues22`
--
ALTER TABLE `dues22`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=502;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=357;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100023;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clinics`
--
ALTER TABLE `clinics`
  ADD CONSTRAINT `clinics_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `dues`
--
ALTER TABLE `dues`
  ADD CONSTRAINT `dues_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
