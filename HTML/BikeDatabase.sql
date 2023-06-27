-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 20, 2023 at 04:52 PM
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
-- Database: `BikeDatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `idno` int(10) NOT NULL,
  `fname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `depname` varchar(20) DEFAULT NULL,
  `pass` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bikeinfo`
--

CREATE TABLE `bikeinfo` (
  `bikeid` int(6) NOT NULL,
  `biketype` varchar(20) DEFAULT NULL,
  `bikecolor` varchar(20) DEFAULT NULL,
  `bikedep` varchar(20) DEFAULT NULL,
  `stat` set('available','borrowed','repair') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bikeinfo`
--

INSERT INTO `bikeinfo` (`bikeid`, `biketype`, `bikecolor`, `bikedep`, `stat`) VALUES
(3, 'gian', 'red', 'ccje', 'available'),
(4, 'giant xtc', 'red', 'nursing', 'available'),
(11, 'mountain', 'red', 'ccsit', 'available'),
(9211, 'japan', 'red', 'ccsict', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `transno` int(11) NOT NULL,
  `bikeid` int(11) DEFAULT NULL,
  `studidno` int(11) DEFAULT NULL,
  `studfname` varchar(50) DEFAULT NULL,
  `studlname` varchar(50) DEFAULT NULL,
  `course` varchar(50) DEFAULT NULL,
  `depname` varchar(50) DEFAULT NULL,
  `dtborrow` datetime DEFAULT NULL,
  `dtreturn` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`transno`, `bikeid`, `studidno`, `studfname`, `studlname`, `course`, `depname`, `dtborrow`, `dtreturn`) VALUES
(7, 3, 210395, 'Alfred', 'Marcelino', 'bsit', 'ccsict', '2023-06-20 20:26:00', '2023-06-20 20:33:00'),
(8, 4, 210395, 'Alfred', 'Marcelino', 'bsit', 'ccsict', '2023-06-20 20:26:00', '2023-06-20 20:34:00');

-- --------------------------------------------------------

--
-- Table structure for table `repairlist`
--

CREATE TABLE `repairlist` (
  `bikeid` int(45) NOT NULL,
  `studino` int(45) NOT NULL,
  `brokenparts` varchar(50) NOT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idno`);

--
-- Indexes for table `bikeinfo`
--
ALTER TABLE `bikeinfo`
  ADD PRIMARY KEY (`bikeid`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`transno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `transno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
