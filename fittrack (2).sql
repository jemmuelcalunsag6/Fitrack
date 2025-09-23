-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2025 at 03:27 PM
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
-- Database: `fittrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `booked_sessions`
--

CREATE TABLE `booked_sessions` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `session_date` datetime NOT NULL,
  `status` enum('completed','cancelled','pending') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booked_sessions`
--

INSERT INTO `booked_sessions` (`booking_id`, `user_id`, `trainer_id`, `session_date`, `status`) VALUES
(21, 26, 3, '2025-01-01 14:44:00', 'completed'),
(22, 35, 3, '2024-12-26 03:33:00', 'cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `progress_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `body_fat_percentage` decimal(5,2) DEFAULT NULL,
  `fitness_level` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`progress_id`, `user_id`, `date`, `weight`, `height`, `body_fat_percentage`, `fitness_level`, `notes`, `created_at`, `updated_at`) VALUES
(1, 26, '2024-12-17', 42.00, 180.00, 12.00, 'Beginner', 'still bad', '2024-12-17 18:55:11', '2024-12-17 18:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `session_date` datetime NOT NULL,
  `session_type` varchar(255) NOT NULL,
  `status` enum('booked','completed','cancelled') DEFAULT 'booked',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `trainer_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `experience` text NOT NULL,
  `about_me` text NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`trainer_id`, `first_name`, `last_name`, `specialization`, `experience`, `about_me`, `profile_image`, `created_at`, `updated_at`, `email`) VALUES
(1, 'Viel', 'Dela Cruz', 'Strength Training', '5 years of experience in personal training, specializing in strength and conditioning.', 'I am passionate about helping others reach their fitness goals through tailored training.', NULL, '2024-11-13 21:15:46', '2024-12-17 15:31:42', 'vielalfonzo16@gmail.com'),
(2, 'Dhann', 'Dalistan', 'Yoga', '3 years of experience in yoga training, focusing on mindfulness and flexibility.', 'I am committed to a holistic approach to wellness, incorporating the transformative power of yoga.', NULL, '2024-11-13 21:15:46', '2024-12-17 15:31:42', 'dhann2002@gmail.com'),
(3, 'Charles', 'Daplas', 'Nutrition Coaching', '4 years of experience in nutrition coaching and dietary planning.', 'I aim to educate clients on healthy eating habits and lifestyle changes.', NULL, '2024-11-13 21:15:46', '2024-12-17 15:31:42', 'norielfernandez42@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` int(11) DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `role` enum('user','trainer') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `created_at`, `updated_at`, `reset_token`, `reset_token_expiry`, `verification_token`, `verified`, `role`) VALUES
(26, 'test', 'noveldaplas@gmail.com', '$2y$10$4MKky9ZVyYxDu7qiXld.wulX0n6b1inn5hHIgDXyljeCxtFHXwQfO', 'test', 'test', '2024-12-15 19:54:32', '2024-12-15 19:54:42', NULL, NULL, NULL, 1, 'user'),
(30, 'TrainerDaplas', 'norielfernandez42@gmail.com', '$2y$10$wayy2RkUF./hfPlpkHaQ6.VY0KVv9InqN0NXhmgSaJqbRdg7zhU8a', 'Charles', 'Daplas', '2024-12-17 15:46:13', '2024-12-17 15:48:47', NULL, NULL, NULL, 1, 'trainer'),
(35, 'eyvaks', 'daplasextra@gmail.com', '$2y$10$Cji/DMpiUADMrZ3bKVaAReWmshVmLtoYRZYhlKnXujwo5Xx6bs7kW', 'char', 'daps', '2024-12-17 19:33:08', '2024-12-17 20:27:09', NULL, NULL, NULL, 1, 'user'),
(36, 'test', 'extradaplas@gmail.com', '$2y$10$5BbfUkW5mlue7BI8Sm.cLOpo3kY8sg6uwvpDWHQ36SR2TbnXBwjS6', 'test', 'testing', '2024-12-18 17:14:36', '2025-06-07 13:53:12', '97c27fc23b4bfc8c7020425f6b9ba278d4e990eeb22bad123684618c0cfc12e361f7e877b671cc2977374b34f765f4e47905', 1749307992, NULL, 1, 'user'),
(38, 'testing', 'charlesdaplas@gmail.com', '$2y$10$VBUmT7JusQ6fEKFceKS1OOT69NwR876YbOFRqVWsBMZFi6xrhMKmW', 'charles', 'daplas', '2025-05-09 19:35:29', '2025-05-09 19:36:24', NULL, NULL, NULL, 1, 'user'),
(39, 'testing', 'charlesdaplas@gmail.com', '$2y$10$jprSW7v/9RjgYkBkY/2lke616RuL8SF28woUpdsSqxl2aTqQvXPCC', 'charles', 'daplas', '2025-05-09 19:39:42', '2025-05-09 19:39:42', NULL, NULL, 'cedd338449e1be6d4dce79acc5c2438f', 0, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booked_sessions`
--
ALTER TABLE `booked_sessions`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`progress_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`trainer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booked_sessions`
--
ALTER TABLE `booked_sessions`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `trainer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booked_sessions`
--
ALTER TABLE `booked_sessions`
  ADD CONSTRAINT `booked_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booked_sessions_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`trainer_id`);

--
-- Constraints for table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`trainer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
