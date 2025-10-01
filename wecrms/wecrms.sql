-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2025 at 12:18 PM
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
-- Database: `wecrms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `two_factor_enabled` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `email`, `password`, `full_name`, `phone`, `two_factor_enabled`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@trustingsocial.ai', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', '+63 912 345 6789', 0, '2025-09-29 08:31:53', '2025-09-29 08:31:53');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `send_email` tinyint(1) DEFAULT 0,
  `send_sms` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `message`, `send_email`, `send_sms`, `created_by`, `created_at`) VALUES
(1, 'Welcome New Team Members', 'We are excited to welcome our new team members who joined us this quarter. Please make them feel welcome and help them settle in.', 1, 0, 1, '2025-09-29 08:31:53'),
(2, 'Office Hours Update', 'Starting October 1st, our office hours will be updated to 8:00 AM - 5:00 PM, Monday to Friday.', 1, 1, 1, '2025-09-29 08:31:53'),
(3, 'Team Building Event', 'Annual team building event scheduled for November 15th at Tagaytay. More details to follow soon.', 1, 0, 1, '2025-09-29 08:31:53');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `position` varchar(100) NOT NULL,
  `department` varchar(50) DEFAULT NULL,
  `hire_date` date NOT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active',
  `avatar_color` varchar(7) DEFAULT '#6366f1',
  `address` text DEFAULT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_phone` varchar(20) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `first_name`, `last_name`, `email`, `phone`, `position`, `department`, `hire_date`, `salary`, `status`, `avatar_color`, `address`, `emergency_contact_name`, `emergency_contact_phone`, `birth_date`, `created_at`, `updated_at`) VALUES
(1, 'EMP001', 'Alek', 'Almeñe', 'alek.almene@trustingsocial.ai', '+63 917 123 4567', 'Graphic Designer', 'Design', '2023-01-15', 35000.00, 'Active', '#8B5CF6', '123 Makati Ave, Makati City, Metro Manila', 'Maria Almeñe', '+63 917 123 4568', '1995-03-20', '2025-09-29 08:31:53', '2025-09-29 08:31:53'),
(2, 'EMP002', 'Raven', 'Gepulani', 'raven.gepulani@trustingsocial.ai', '+63 918 234 5678', 'Frontend Developer', 'Development', '2023-02-20', 45000.00, 'Active', '#3B82F6', '456 BGC, Taguig City, Metro Manila', 'John Gepulani', '+63 918 234 5679', '1992-07-15', '2025-09-29 08:31:53', '2025-09-29 08:31:53'),
(3, 'EMP003', 'Shaira', 'Cacao', 'shaira.cacao@trustingsocial.ai', '+63 919 345 6789', 'UI/UX Designer', 'Design', '2023-03-10', 40000.00, 'Active', '#EF4444', '789 Ortigas Ave, Pasig City, Metro Manila', 'Pedro Cacao', '+63 919 345 6790', '1994-11-08', '2025-09-29 08:31:53', '2025-09-29 08:31:53'),
(4, 'EMP004', 'Kimberly', 'Salcedo', 'kimberly.salcedo@trustingsocial.ai', '+63 920 456 7890', 'Backend Developer', 'Development', '2023-04-05', 48000.00, 'Active', '#10B981', '321 Alabang Hills, Muntinlupa City, Metro Manila', 'Robert Salcedo', '+63 920 456 7891', '1993-05-25', '2025-09-29 08:31:53', '2025-09-29 08:31:53'),
(5, 'EMP005', 'Miguel', 'Santos', 'miguel.santos@trustingsocial.ai', '+63 921 567 8901', 'Project Manager', 'Management', '2023-05-12', 55000.00, 'Active', '#F59E0B', '654 Quezon Ave, Quezon City, Metro Manila', 'Carmen Santos', '+63 921 567 8902', '1990-12-03', '2025-09-29 08:31:53', '2025-09-29 08:31:53');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(20) DEFAULT 'info' CHECK (`type` in ('info','success','warning','error')),
  `user_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `message`, `type`, `user_id`, `is_read`, `created_at`) VALUES
(1, 'New Employee Added', 'Miguel Santos has been added to the system as Project Manager', 'info', 1, 0, '2025-09-29 08:31:53'),
(2, 'Ticket Update', 'Ticket #2 - System Access Issue has been updated to In Progress', 'warning', 1, 0, '2025-09-29 08:31:53'),
(3, 'Task Completed', 'User Experience Research task has been marked as completed', 'success', 1, 1, '2025-09-29 08:31:53'),
(4, 'System Maintenance', 'Scheduled system maintenance on October 1st from 2:00 AM to 4:00 AM', 'warning', 1, 0, '2025-09-29 08:31:53'),
(5, 'Employee Birthday', 'Reminder: Kimberly Salcedo\'s birthday is coming up on May 25th', 'info', 1, 1, '2025-09-29 08:31:53'),
(6, 'Leave Request Approved', 'Shaira Cacao\'s vacation leave request has been approved', 'success', 1, 0, '2025-09-29 08:31:53'),
(7, 'Equipment Request', 'New equipment request from Miguel Santos requires approval', 'warning', 1, 0, '2025-09-29 08:31:53');

-- --------------------------------------------------------

--
-- Table structure for table `progress_tracking`
--

CREATE TABLE `progress_tracking` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `task_title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `progress_percentage` int(11) DEFAULT 0 CHECK (`progress_percentage` >= 0 and `progress_percentage` <= 100),
  `status` varchar(20) NOT NULL CHECK (`status` in ('Open','In Progress','Completed','On Hold')),
  `priority` varchar(10) DEFAULT 'Medium' CHECK (`priority` in ('High','Medium','Low')),
  `start_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `completed_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress_tracking`
--

INSERT INTO `progress_tracking` (`id`, `employee_id`, `task_title`, `description`, `progress_percentage`, `status`, `priority`, `start_date`, `due_date`, `completed_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Logo Design for Q4 Campaign', 'Design new logo variations for upcoming marketing campaign', 75, 'In Progress', 'High', '2024-09-15', '2024-10-01', NULL, '2025-09-29 08:31:53', '2025-09-29 08:31:53'),
(2, 2, 'Website Frontend Redesign', 'Implement new UI design for company website homepage', 90, 'In Progress', 'High', '2024-09-10', '2024-09-30', NULL, '2025-09-29 08:31:53', '2025-09-29 08:31:53'),
(3, 3, 'User Experience Research', 'Conduct user testing for mobile app interface improvements', 100, 'Completed', 'Medium', '2024-09-01', '2024-09-25', NULL, '2025-09-29 08:31:53', '2025-09-29 08:31:53'),
(4, 4, 'API Development', 'Develop RESTful API for mobile application backend', 60, 'In Progress', 'High', '2024-09-20', '2024-10-15', NULL, '2025-09-29 08:31:53', '2025-09-29 08:31:53'),
(5, 5, 'Project Planning Q4', 'Plan and organize development projects for fourth quarter', 40, 'In Progress', 'Medium', '2024-09-25', '2024-10-10', NULL, '2025-09-29 08:31:53', '2025-09-29 08:31:53'),
(6, 1, 'Brand Guidelines Update', 'Update company brand guidelines and style manual', 20, 'Open', 'Low', '2024-10-01', '2024-10-30', NULL, '2025-09-29 08:31:53', '2025-09-29 08:31:53'),
(7, 3, 'Mobile App Wireframes', 'Create wireframes for new mobile application features', 0, 'On Hold', 'Medium', '2024-10-05', '2024-10-20', NULL, '2025-09-29 08:31:53', '2025-09-29 08:31:53');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_number` varchar(20) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `priority` varchar(10) NOT NULL CHECK (`priority` in ('High','Medium','Low')),
  `status` varchar(20) NOT NULL CHECK (`status` in ('Open','In Progress','Completed','On Hold')),
  `assigned_to` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `resolved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_number`, `title`, `description`, `category`, `priority`, `status`, `assigned_to`, `created_by`, `created_at`, `updated_at`, `resolved_at`) VALUES
(1, '#1', 'Lost ID or access card', 'Employee reported lost ID card and needs replacement for office access', 'Access Control', 'Medium', 'Open', 1, 1, '2025-09-29 08:31:53', '2025-09-29 08:31:53', NULL),
(2, '#2', 'System Access Issue', 'Unable to access company systems and email account', 'Technical Support', 'High', 'In Progress', 2, 2, '2025-09-29 08:31:53', '2025-09-29 08:31:53', NULL),
(3, '#3', 'Leave Request', 'Requesting 5 days vacation leave for family emergency', 'HR Request', 'Low', 'Completed', 3, 3, '2025-09-29 08:31:53', '2025-09-29 08:31:53', NULL),
(4, '#4', 'Equipment Request', 'Need new laptop for development work, current one is slow', 'Equipment', 'Medium', 'Open', 4, 4, '2025-09-29 08:31:53', '2025-09-29 08:31:53', NULL),
(5, '#5', 'Password Reset', 'Forgot password for company portal and email', 'Technical Support', 'Medium', 'In Progress', 5, 5, '2025-09-29 08:31:53', '2025-09-29 08:31:53', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_employees_status` (`status`),
  ADD KEY `idx_employees_position` (`position`),
  ADD KEY `idx_employees_department` (`department`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notifications_user_id` (`user_id`),
  ADD KEY `idx_notifications_is_read` (`is_read`);

--
-- Indexes for table `progress_tracking`
--
ALTER TABLE `progress_tracking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_progress_status` (`status`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_number` (`ticket_number`),
  ADD KEY `idx_tickets_status` (`status`),
  ADD KEY `idx_tickets_priority` (`priority`),
  ADD KEY `idx_tickets_category` (`category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `progress_tracking`
--
ALTER TABLE `progress_tracking`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
