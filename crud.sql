-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 24, 2024 at 12:24 PM
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
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `area`, `stage`, `start_date`, `end_date`, `labor_cost`) VALUES
(15, 0, 'Qui blanditiis eos ', 'Design', 'Planning & Costing', '2024-09-18', '2024-09-21', '231231'),
(9, 0, 'Neque reprehenderit', 'Development', 'Planning & Costing', '2024-09-14', '2024-09-24', '1001'),
(10, 0, 'Officia impedit ali', 'Design', 'Meeting with Dev', '2024-09-20', '2024-10-31', '12222'),
(17, 0, 'Ut dolor tenetur mag', 'Design', 'Planning & Costing', '2024-09-21', '2024-09-18', '321'),
(19, 1, 'Qui esse eveniet e', 'Development', 'Meeting with Dev', '2024-09-24', '2024-09-30', '2111'),
(21, 2, 'Praesentium praesent', 'Development', 'Meeting with Dev', '2024-09-24', '2024-10-11', '32322'),
(22, 3, 'ACTS', 'Design', 'Planning & Costing', '2024-09-23', '2024-09-30', '400'),
(23, 1, 'Commodi sint dolorum', 'Development', 'Meeting with Dev', '2024-09-23', '2024-09-27', '1211'),
(24, 2, 'Ex eos anim exceptu', 'Development', 'Meeting with Dev', '2024-09-24', '2024-09-30', '1001'),
(25, 2, 'Native E-commerce', 'Development', 'Meeting with Dev', '2024-09-24', '2024-09-27', '12222'),
(27, 1, 'Et quasi voluptatem', 'Development', 'Planning & Costing', '2024-09-25', '2024-09-28', '322'),
(28, 22, 'Calculus', 'Design', 'Planning & Costing', '2024-09-24', '2024-09-25', '2310');

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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `user_email`, `user_mobile`, `user_password`, `user_image`) VALUES
(22, 'duvuqaqahe', 'kezetoz@mailinator.com', '312321312312312', '$2y$10$lfvfz0743sQsHHygmlRXfuo21zKqT6AfSw6bA2Wq8O.X40SCx9MPu', './storage/users/2024-09-24_11-26_user-pexels-pixabay-33545.jpg'),
(1, 'Arif', 'arif@gmail.com', '2312321321312', '$2y$10$5.1L6cHfeIXzUttABFY66ezlvPsHbwW31hZOacFgHB3CD13pRAMki', './storage/users/2024-09-24_11-22_user-pexels-pixabay-33545.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
