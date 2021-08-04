-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2021 at 11:05 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wp_plugindev_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_book_authors`
--

CREATE TABLE `wp_book_authors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `fb_link` varchar(100) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wp_book_authors`
--

INSERT INTO `wp_book_authors` (`id`, `name`, `fb_link`, `about`, `created_at`) VALUES
(1, 'Dennis Mark', 'https://fb.me/dennis-mark', 'Fusce ultricies tellus quis purus accumsan sollicitudin. In enim diam, eleifend et quam non, lacinia dictum velit. Phasellus porta, neque sit amet dignissim tempor.', '2021-08-03 16:37:41'),
(2, 'Andrew Sons', 'https://fb.me/andrew-sons', 'Praesent eget leo accumsan, volutpat dui a, consequat ex. Vestibulum nulla libero, condimentum non egestas vel, suscipit sit amet nunc. Cras nec scelerisque libero.', '2021-08-03 16:37:53'),
(3, 'Michael Jones', 'https://fb.me/michael-jones', 'Curabitur laoreet nulla eros. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', '2021-08-03 16:38:05'),
(4, 'Albert Kark', 'https://fb.me/albert-kark', 'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.', '2021-08-03 16:38:21'),
(5, 'Mandia Karw', 'https://fb.me/mandia-karw', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla at blandit leo. Nullam quis volutpat arcu. Nullam aliquet sed velit id tempus. Suspendisse sodales et turpis sed bibendum.', '2021-08-03 16:38:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_book_authors`
--
ALTER TABLE `wp_book_authors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_book_authors`
--
ALTER TABLE `wp_book_authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
