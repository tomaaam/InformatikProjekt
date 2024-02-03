-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2023 at 10:47 AM
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
-- Database: `informatikhighscores`
--

-- --------------------------------------------------------

--
-- Table structure for table `s1`
--

CREATE TABLE `s1` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(20) NOT NULL DEFAULT 'Anonym',
  `SCORE` int(11) NOT NULL,
  `DATE` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `s2`
--

CREATE TABLE `s2` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(20) NOT NULL DEFAULT 'Anonym',
  `SCORE` int(11) NOT NULL,
  `DATE` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `s3`
--

CREATE TABLE `s3` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(20) NOT NULL DEFAULT 'Anonym',
  `SCORE` int(11) NOT NULL,
  `DATE` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `s4`
--

CREATE TABLE `s4` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(20) NOT NULL DEFAULT 'Anonym',
  `SCORE` int(11) NOT NULL,
  `DATE` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `s5`
--

CREATE TABLE `s5` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(20) NOT NULL DEFAULT 'Anonym',
  `SCORE` int(11) NOT NULL,
  `DATE` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `s5`
--

CREATE TABLE `s6` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(20) NOT NULL DEFAULT 'Anonym',
  `SCORE` int(11) NOT NULL,
  `DATE` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `s1`
--
ALTER TABLE `s1`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `s2`
--
ALTER TABLE `s2`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `s3`
--
ALTER TABLE `s3`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `s4`
--
ALTER TABLE `s4`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `s5`
--
ALTER TABLE `s5`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `s5`
--
ALTER TABLE `s6`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `s1`
--
ALTER TABLE `s1`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `s2`
--
ALTER TABLE `s2`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `s3`
--
ALTER TABLE `s3`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `s4`
--
ALTER TABLE `s4`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `s5`
--
ALTER TABLE `s5`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- AUTO_INCREMENT for table `s5`
--
ALTER TABLE `s6`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
