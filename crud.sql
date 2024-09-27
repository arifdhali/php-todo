-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 27, 2024 at 06:53 AM
-- Server version: 8.0.27
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `area` text,
  `stage` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `labor_cost` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_parent` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `area`, `stage`, `start_date`, `end_date`, `labor_cost`) VALUES
(17, 1, 'Enim corrupti dolor', 'Design', 'Meeting with Dev', '2024-09-28', '2024-09-30', '1231'),
(18, 1, 'Odio perspiciatis c', 'Development', 'Meeting with Dev', '2024-09-28', '2024-10-02', '32');

-- --------------------------------------------------------

--
-- Table structure for table `task_notification`
--

DROP TABLE IF EXISTS `task_notification`;
CREATE TABLE IF NOT EXISTS `task_notification` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `task_c_date` datetime NOT NULL,
  `task_status` enum('Progress','Due','Complete') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`notification_id`),
  KEY `fk_task_notification_parent` (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `task_notification`
--

INSERT INTO `task_notification` (`notification_id`, `task_id`, `task_c_date`, `task_status`) VALUES
(9, 17, '2024-09-27 12:20:37', 'Complete'),
(10, 18, '2024-09-27 12:21:12', 'Complete');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_mobile` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_image` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `user_email`, `user_mobile`, `user_password`, `user_image`) VALUES
(1, 'Arif', 'arif@gmail.com', '2312321321312', '$2y$10$5.1L6cHfeIXzUttABFY66ezlvPsHbwW31hZOacFgHB3CD13pRAMki', './storage/users/2024-09-24_11-22_user-pexels-pixabay-33545.jpg');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `user_id_parent` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_notification`
--
ALTER TABLE `task_notification`
  ADD CONSTRAINT `fk_task_notification_parent` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
