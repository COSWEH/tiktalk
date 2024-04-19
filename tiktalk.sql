-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2024 at 09:15 AM
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
-- Database: `tiktalk`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account`
--

CREATE TABLE `tbl_account` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_account`
--

INSERT INTO `tbl_account` (`userid`, `username`, `email`, `password`, `gender`) VALUES
(1, 'vinci', 'thecobraunitsorrow2020@gmail.com', '$2y$10$EAZsu0uwvwxBvpyj9VSnDOJ3zXED09fX7ofwDtIQcK56ReIkTG/bS', 'male'),
(2, 'qwe', 'qwe@gmail.com', '$2y$10$XdoVzt3i3QJ9QUXLST/9uui/smPiUQrpIYPvn.KpXKBnRDJSyZjE2', 'male'),
(3, 'yvez', 'yvezsantiago@goodsam.edu.ph', '$2y$10$oiuBGSZ70dTntmRPPdjh4uGbPzrrAp46kwjWcPl3ItoT6Zr4puLAy', 'male'),
(4, 'pao', 'oloap0428@gmail.com', '$2y$10$WKp8ZJjEHNKdujwZ574Y1uzmpmtzmhgj7Q9xFbjF6UKHPPe9x2fBy', 'male');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_message`
--

CREATE TABLE `tbl_message` (
  `messageid` int(11) NOT NULL,
  `message` text NOT NULL,
  `userid` int(11) NOT NULL,
  `send_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_message`
--

INSERT INTO `tbl_message` (`messageid`, `message`, `userid`, `send_at`) VALUES
(1, '&lt;h1&gt;TEST&lt;/h1&gt;', 2, '2024-04-18 19:11:41'),
(2, '&lt;p&gt;TEST TEST TEST&lt;/p&gt;', 3, '2024-04-18 19:12:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_account`
--
ALTER TABLE `tbl_account`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `tbl_message`
--
ALTER TABLE `tbl_message`
  ADD PRIMARY KEY (`messageid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_account`
--
ALTER TABLE `tbl_account`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_message`
--
ALTER TABLE `tbl_message`
  MODIFY `messageid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
