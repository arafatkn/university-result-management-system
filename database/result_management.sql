-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2018 at 05:08 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `result_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '0',
  `password` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `role`, `password`, `name`, `department`) VALUES
(1, 'admin', 1, '$2y$10$EkDD.WJLCEk46Z1pfbOCvuDH51EvS/Fehpt.WjD.FGzpRGKHP4YXW', 'Md. Mahmudul Hasan', 'CSE');

-- --------------------------------------------------------

--
-- Table structure for table `classtest`
--

CREATE TABLE `classtest` (
  `id` int(10) UNSIGNED NOT NULL,
  `sdc_id` int(10) UNSIGNED NOT NULL,
  `roll` int(10) UNSIGNED NOT NULL,
  `type` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `num` tinyint(3) UNSIGNED NOT NULL,
  `marks` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `classtest`
--

INSERT INTO `classtest` (`id`, `sdc_id`, `roll`, `type`, `num`, `marks`) VALUES
(1, 1, 150101, 'ct', 1, -1),
(2, 1, 150102, 'ct', 1, 9),
(3, 1, 150103, 'ct', 1, 7),
(4, 1, 150104, 'ct', 1, 8),
(5, 1, 150107, 'ct', 1, 6),
(6, 1, 150101, 'pt', 1, 9),
(7, 1, 150102, 'pt', 1, 6),
(8, 1, 150103, 'pt', 1, 7),
(9, 1, 150104, 'pt', 1, 7),
(10, 1, 150107, 'pt', 1, 8),
(11, 1, 150101, 'ct', 2, 10),
(12, 1, 150102, 'ct', 2, 9),
(13, 1, 150103, 'ct', 2, 10),
(14, 1, 150104, 'ct', 2, 8),
(15, 1, 150107, 'ct', 2, 4),
(17, 0, 150101, '', 0, 0),
(18, 0, 150102, '', 0, 0),
(19, 0, 150103, '', 0, 0),
(20, 0, 150104, '', 0, 0),
(21, 0, 150107, '', 0, 0),
(22, 0, 150130, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `credit` decimal(3,2) UNSIGNED NOT NULL,
  `year` tinyint(1) UNSIGNED NOT NULL,
  `semester` tinyint(1) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `code`, `title`, `credit`, `year`, `semester`, `status`) VALUES
(1, 'CSE-3107', 'Database Management Systems', '3.00', 3, 1, 1),
(2, 'CSE-1201', 'Object Oriented Programming', '3.00', 1, 2, 1),
(3, 'CSE-3108', 'Database Management Systems Sessional', '1.50', 3, 1, 1),
(4, 'CSE-2103', 'Digital Systems', '3.00', 2, 1, 0),
(5, 'CSE-3101', 'Computer Architechture', '3.00', 3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `id` int(10) UNSIGNED NOT NULL,
  `roll` int(10) UNSIGNED NOT NULL,
  `year` tinyint(3) UNSIGNED NOT NULL,
  `semester` tinyint(3) UNSIGNED NOT NULL,
  `c_id` int(10) UNSIGNED NOT NULL,
  `marks` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`id`, `roll`, `year`, `semester`, `c_id`, `marks`) VALUES
(1, 150101, 3, 1, 1, 1),
(2, 150101, 3, 1, 3, 85),
(3, 150102, 3, 1, 1, 74),
(4, 150102, 3, 1, 3, 79),
(5, 150103, 3, 1, 1, 76),
(6, 150103, 3, 1, 3, 69),
(7, 150101, 3, 1, 5, 75),
(8, 150102, 3, 1, 5, 72),
(9, 150103, 3, 1, 5, 78);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `roll` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `session` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`roll`, `name`, `session`) VALUES
(150101, 'Mahedi Hasan', '2014-15'),
(150102, 'Shila Akther', '2014-15'),
(150103, 'Monira Khatun', '2014-15'),
(160101, 'Demo Student', '2015-16'),
(160102, 'Demo Student 2', '2015-16'),
(160103, 'Demo Student 3', '2015-16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classtest`
--
ALTER TABLE `classtest`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `sdc_id` (`sdc_id`,`roll`,`type`,`num`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roll_c_id` (`roll`,`c_id`) USING BTREE;

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`roll`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `classtest`
--
ALTER TABLE `classtest`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
