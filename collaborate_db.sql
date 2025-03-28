-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test3`
--
CREATE DATABASE IF NOT EXISTS `test3` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `test3`;

-- --------------------------------------------------------

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `host`
--

CREATE TABLE `host` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CommunityName` varchar(50) NOT NULL,
  `About` varchar(250) NOT NULL,
  `Category` enum('Indoor','Outdoor') NOT NULL,
  `email` varchar(64) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `Requirments` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sample data for the host table (optional)
--

INSERT INTO `host` (`CommunityName`, `About`, `Category`, `email`, `PhoneNumber`, `Requirments`) VALUES
('Hiking Club', 'We organize weekend hikes on local trails', 'Outdoor', 'hiking@example.com', '1234567890', 'Comfortable shoes and water bottle required'),
('Book Club', 'Monthly book discussions and literary events', 'Indoor', 'books@example.com', '9876543210', 'No requirements, just love for reading');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */; 