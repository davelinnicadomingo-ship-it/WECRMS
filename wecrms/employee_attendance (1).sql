-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2025 at 12:16 PM
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
-- Database: `employee_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `email_notification` tinyint(1) DEFAULT 0,
  `sms_notification` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','leave') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `date`, `status`) VALUES
(1, 3, '2025-09-09', 'present'),
(2, 3, '2025-09-11', 'leave'),
(3, 3, '2025-09-12', 'present');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `sender` enum('employee','bot') NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `employee_id`, `sender`, `message`, `created_at`) VALUES
(1, 0, '', 'ID Request', '2025-09-26 10:51:57'),
(2, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-26 10:51:57'),
(3, 0, '', 'id request', '2025-09-26 10:52:03'),
(4, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-26 10:52:03'),
(5, 0, '', 'alek', '2025-09-26 10:52:07'),
(6, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-26 10:52:07'),
(7, 0, '', 'ID Request', '2025-09-26 10:52:32'),
(8, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-26 10:52:32'),
(9, 0, '', 'ID Request', '2025-09-26 10:58:15'),
(10, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-26 10:58:15'),
(11, 0, '', 'ID Request', '2025-09-26 13:22:09'),
(12, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-26 13:22:09'),
(13, 0, '', 'Almene', '2025-09-26 13:39:16'),
(14, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-26 13:39:16'),
(15, 0, '', 'asdadas', '2025-09-26 13:39:20'),
(16, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-26 13:39:20'),
(17, 0, '', 'dasdasd', '2025-09-26 13:51:12'),
(18, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-26 13:51:12'),
(19, 0, '', 'asdasd', '2025-09-26 13:51:44'),
(20, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-26 13:51:44'),
(21, 0, '', 'ID Request', '2025-09-26 13:51:45'),
(22, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-26 13:51:46'),
(23, 0, '', 'asdsa', '2025-09-26 13:52:00'),
(24, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-26 13:52:00'),
(25, 0, '', 'ID Request', '2025-09-26 13:52:03'),
(26, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-26 13:52:03'),
(27, 0, '', 'ID Request', '2025-09-27 15:25:30'),
(28, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-27 15:25:30'),
(29, 0, '', 'ID Request', '2025-09-30 04:11:43'),
(30, 0, 'bot', '🤖 Thanks for your message! We\'ll get back to you soon.', '2025-09-30 04:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `datehired` date NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `phone` varchar(100) NOT NULL,
  `address` varchar(250) NOT NULL,
  `nationality` text NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `role` enum('admin','hr','employee') NOT NULL DEFAULT 'employee',
  `username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `position`, `department`, `datehired`, `status`, `phone`, `address`, `nationality`, `password`, `role`, `username`) VALUES
(1, 'System Admin', 'admin@example.com', 'Unknown', 'General', '2025-09-09', 'active', '0', '', '', 'admin', 'employee', '0'),
(2, 'HR Manager', 'hr1@example.com', 'Unknown', 'General', '2025-09-09', 'active', '0', '', '', 'hr123', 'hr', '0'),
(3, 'Alek Almene', 'alekalmene@trustaiph.com', 'Unknown', 'General', '2025-09-09', 'active', '+63 123 456 7891', '629 J Nepomuceno, Quiapo, Manila, 1001 Metro Manila', 'Filipino', 'alek123', 'employee', '0');

-- --------------------------------------------------------

--
-- Table structure for table `employee_attendance`
--

CREATE TABLE `employee_attendance` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `email_notification` tinyint(1) DEFAULT 0,
  `sms_notification` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_status`
--

CREATE TABLE `employee_status` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `status_text` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('open','in progress','on hold','closed') DEFAULT 'open',
  `priority` enum('Low','Medium','High') DEFAULT 'Medium',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `employee_attendance`
--
ALTER TABLE `employee_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_status`
--
ALTER TABLE `employee_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee_attendance`
--
ALTER TABLE `employee_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_status`
--
ALTER TABLE `employee_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_status`
--
ALTER TABLE `employee_status`
  ADD CONSTRAINT `employee_status_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
