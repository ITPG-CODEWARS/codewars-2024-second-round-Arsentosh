-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2024 at 09:58 AM
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
-- Database: `urls`
--

-- --------------------------------------------------------

--
-- Table structure for table `url_shorten`
--

CREATE TABLE `url_shorten` (
  `id` int(11) NOT NULL,
  `url` varchar(2048) NOT NULL,
  `short_code` varchar(6) NOT NULL,
  `hits` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `url_shorten`
--

INSERT INTO `url_shorten` (`id`, `url`, `short_code`, `hits`) VALUES
(1, 'https://www.youtube.com/watch?v=OhQA4PDdp0Q', '66e295', 1),
(2, 'https://www.youtube.com/', 'd0dc92', 4),
(3, 'https://www.youtube.com/alabala', '64c94b', 1),
(4, 'https://drive.google.com/drive/', '7da623', 0),
(5, 'https://learn.microsoft.com/en-us/visualstudio/install/modify-visual-studio?view=vs-2022', '4b96d7', 1),
(6, 'https://it-kariera.mon.bg/e-learning/mod/vpl/view.php?id=5&userid=7247', 'cba044', 1),
(7, 'https://sourceforge.net/projects/xampp/', '99e3d8', 2),
(8, 'https://chatgpt.com/c/672f4b4a-5c08-8009-8671-d0862943cbeb', '1520eb', 3),
(9, 'https://www.google.com/', '6db461', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'lol', '$2y$10$oqu.N4ykB5NZ6SUOQVZ0.Ox4NCvxfORMYp9EZy0y3iI4a0uiMQRBi', 'lol@gmail.com', '2024-11-09 21:15:17'),
(2, 'arsentosh', '$2y$10$zRbNsnbJAADVljCJInMR6.FnioQlC9tNd2.pHlo1Ws3hnLPidduCq', 'doncenkoarsenij185@gmail.com', '2024-11-10 11:22:54'),
(3, 'donchenko', '$2y$10$wqbQrKkX/3tCMEg63GC5GewEIU3gdzdunzk8z.tOhZ4tf9oyh48I2', '+35987996@8379', '2024-11-11 12:38:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `url_shorten`
--
ALTER TABLE `url_shorten`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_code` (`short_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `url_shorten`
--
ALTER TABLE `url_shorten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
