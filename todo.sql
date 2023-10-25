-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2023 at 04:48 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todo`
--

-- --------------------------------------------------------

--
-- Table structure for table `list`
--

CREATE TABLE `list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `category` varchar(300) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `list`
--

INSERT INTO `list` (`id`, `user_id`, `title`, `category`, `date`, `status`) VALUES
(16, 5, 'Go To Manila', 'HITC MANILA WORLD TOUR', '2022-12-16', 'Completed'),
(23, 5, 'Concert', 'World Tour', '2023-07-20', NULL),
(36, 1, 'Create Power Point Presentation', 'School Project', '2023-09-30', NULL),
(37, 1, 'Create Power Point Presentation 2', 'School Project', '2023-10-27', NULL),
(40, 1, 'Defense For Second Semester', 'School Project', '2023-05-30', 'Completed'),
(41, 1, 'Create System with database', 'School Project', '2023-05-25', 'Completed'),
(42, 1, 'Run', 'Healthy Lifestyle', '2023-07-03', 'Completed'),
(44, 1, 'Create To Do List Website', 'Portfolio Project', '2023-07-05', 'Completed'),
(45, 1, 'Take pictures', 'Recognition Day', '2023-07-06', 'Completed'),
(46, 1, 'Create Data Analysis Project', 'Portfolio Project', '2023-07-10', 'Completed'),
(47, 1, 'Prepare For Graduation', 'School Graduation', '2023-07-06', 'Completed'),
(48, 1, 'Master SQL', 'Learn new skill', '2023-07-10', NULL),
(49, 1, 'Watch Movie', 'Reward for completing a project', '2023-07-05', 'Completed'),
(50, 1, 'Sleep', 'Healthy Lifestyle', '2023-07-05', 'Completed'),
(51, 1, 'Create Data Analysis Project 2', 'Portfolio Project', '2023-07-10', NULL),
(52, 1, 'Study', 'Learn new skill', '2023-07-08', NULL),
(53, 27, 'Kill The Higher Ups', 'Murder', '2023-09-20', NULL),
(54, 27, 'Eat Shoko', 'Pervert', '2023-07-08', 'Completed'),
(55, 27, 'Exorcise Sukuna', 'Exorcise', '2023-07-09', NULL),
(56, 27, 'Fight Sukuna', 'Fight between the strongest', '2023-07-10', NULL),
(57, 1, 'Learn Wordpress', 'Learn new tools', '2023-07-18', NULL),
(60, 29, 'Publish an Article', 'Business', '2023-08-25', NULL),
(61, 29, 'Publish an Article 2', 'Business', '2023-08-28', NULL),
(63, 29, 'Sleep', 'Healthy Lifestyle', '2023-08-24', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` char(255) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `password`, `gender`, `age`, `profile_picture`) VALUES
(1, 'Fidel', 'Colinares', 'Wangjo4', '$2y$10$bhT.tj9KtdU2lR0ALLKNbORxlWGqJX5RyezUqw8nUyw9xJJaQG/UK', 'Male', 19, 'Wangjo464aa71dfc74849.60496574.jpeg'),
(5, 'Niki', 'Selene', 'nikiselene', '$2y$10$Rk1tCCKScJVWD.NZ.6NfyeDgZGDTmiyasPWKr2cLVKZAtpmHIJUoW', 'Female', 24, 'nikiselene64a94bf0a1d0c6.78932049.jpg'),
(25, 'Akari', 'Devi', 'akariD', '$2y$10$omd9dUkh61esUFGOYwpS6O9FTzw4o85pUPWo6MjkbljegDDC16ouq', 'Female', 21, 'akiraD64a94c8259c924.65293385.png'),
(26, 'jonjon', 'Salonga', 'jonjoncolins', '$2y$10$g4/iFyUpms5JDTEM7B.mEuO1L2acr7aFgo./4yPFLIEk98sqvxXhq', 'Female', 16, 'default_profile.jpg'),
(27, 'Gojo', 'Satoru', 'gojosatoru', '$2y$10$MRdt.OFXRbNZsFGZigpm/uWIHOQO5uxmhEyLA2leuxADZ5piwxlcu', 'Male', 28, 'gojosatoru64a94da8091f36.79631678.jpg'),
(28, 'Geto', 'Suguru', 'getosuguru', '$2y$10$TqYJ6R6sewV4cpLGlOLaHOax1e86IvPVaJBscrhhmDcPWGkIT6iJS', 'Male', 28, 'getosuguru64a94fe5ec4994.54214043.jpeg'),
(29, 'Gihyu', 'Bernard', 'gihyusanchez', '$2y$10$a4vC2KIky/MolwSxjopHZuwFHjrjzTn4oDw5YXIWV8FkCaxFHO7ty', 'Male', 21, 'gihyusanchez64e76fedc39cc8.01308291.jpeg'),
(30, 'Fidel', 'Sal', 'Fidelsalonga', '$2y$10$NQSRWmLz0xAjYNU1fPQ8sOyzs0EDuCiVK62hnQe2nKP8iuESXZHFq', 'Female', 19, 'Fidelsalonga65392a4a907ea1.36969735.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `list`
--
ALTER TABLE `list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `list`
--
ALTER TABLE `list`
  ADD CONSTRAINT `list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
