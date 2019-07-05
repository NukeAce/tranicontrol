-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Mar 03, 2019 at 10:32 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bakerydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nuban',
  `source` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'balance',
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_code` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int(32) NOT NULL,
  `currency` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NGN',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
