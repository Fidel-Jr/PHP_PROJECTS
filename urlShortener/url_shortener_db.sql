-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2023 at 08:37 AM
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
-- Database: `url_shortener_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `url`
--

CREATE TABLE `url` (
  `id` int(11) NOT NULL,
  `shorten_url` varchar(500) NOT NULL,
  `orig_url` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `url`
--

INSERT INTO `url` (`id`, `shorten_url`, `orig_url`) VALUES
(1, 'rebrand.ly/2nmkrw3', 'https://www.youtube.com/watch?v=fIYyemqKR58'),
(4, 'rebrand.ly/fjqumuc', 'https://www.google.com/search?q=fonts+google+apis&rlz=1C1CHBD_enPH938PH940&oq=&aqs=chrome.7.69i59i450l8.25955j0j7&sourceid=chrome&ie=UTF-8'),
(5, 'rebrand.ly/6dh1up5', 'https://tenor.com/view/hollow-purple-gif-25623869'),
(6, 'rebrand.ly/kpwhbew', 'https://www.google.com/search?q=youtube&rlz=1C1CHBD_enPH938PH940&oq=&aqs=chrome.1.35i39i362l5j46i39i199i362i465j35i39i362l2.467959j0j7&sourceid=chrome&ie=UTF-8'),
(7, 'rebrand.ly/byvgkos', 'https://www.google.com/search?q=php&rlz=1C1CHBD_enPH938PH940&ei=zAmsZMzoDOyH4-EPkKi1kA0&ved=0ahUKEwjM_oDEoYSAAxXswzgGHRBUDdIQ4dUDCA8&uact=5&oq=php&gs_lcp=Cgxnd3Mtd2l6LXNlcnAQAzIKCAAQigUQsQMQQzIHCAAQigUQQzIHCAAQigUQQzIHCAAQigUQQzINCAAQigUQsQMQgwEQQzIICAAQigUQkQIyBwgAEIoFEEMyBwgAEIoFEEMyBwgAEIoFEEMyBwgAEIoFEEM6DwgAEIoFEOoCELQCEEMYAToPCC4QigUQ6gIQtAIQQxgBOhkIABCKBRDqAhC0AhCKAxC3AxDUAxDlAhgBOhUILhADEI8BEOoCELQCEIwDEOUCGAI6FQgAEAMQjwEQ6gIQtAIQjAMQ5QIYAjoLCAAQgAQQsQMQgwE6EQguEIMBEMcBELEDENEDEIAEOhEILh');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `url`
--
ALTER TABLE `url`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `url`
--
ALTER TABLE `url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
