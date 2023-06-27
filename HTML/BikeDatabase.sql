-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 27, 2023 at 04:09 PM
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

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idno`, `fname`, `lname`, `depname`, `pass`) VALUES
(210395, 'Alfred', 'Marcelino', 'CCSICT', 'Alfred45!');

-- --------------------------------------------------------

--
-- Table structure for table `bikeinfo`
--

CREATE TABLE `bikeinfo` (
  `bikeid` int(6) NOT NULL,
  `biketype` varchar(20) DEFAULT NULL,
  `bikecolor` varchar(20) DEFAULT NULL,
  `bikedep` varchar(20) DEFAULT NULL,
  `stat` set('available','borrowed','repair') NOT NULL DEFAULT 'available',
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bikeinfo`
--

INSERT INTO `bikeinfo` (`bikeid`, `biketype`, `bikecolor`, `bikedep`, `stat`, `count`) VALUES
(201, 'Hard Tail', 'Black', 'CCSICT', 'available', 2),
(202, 'Full Suspension', 'White', 'CCJE', 'available', 1),
(203, 'Gravel Bike', 'matte/gold', 'COE', 'available', 0),
(204, 'Road Bike', 'Glossy Red', 'AGRI', 'available', 0),
(205, 'TT Bike', 'matte gray', 'CBAPA', 'available', 0),
(206, 'E-Bike', 'Army green', 'NURSING', 'available', 0),
(207, 'Fixed Gear', 'carbon', 'FISHERIES', 'available', 0),
(208, 'Bmx', 'Glossy black', 'BPED', 'available', 1),
(209, 'Uni Cycle', 'Green', 'BSMA', 'available', 0),
(210, 'Rigid Bike', 'Black', 'VETMED', 'available', 0),
(211, 'Giant xtc', 'Maroon', 'CCSICT', 'available', 0);

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
(1, 201, 0, 'Added by admin', '---', '---', '---', '2023-06-27 16:06:29', '2023-06-27 16:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `repairlist`
--

CREATE TABLE `repairlist` (
  `no` int(11) NOT NULL,
  `bikeid` int(45) NOT NULL,
  `studidno` int(45) NOT NULL,
  `brokenparts` varchar(50) NOT NULL,
  `dateadded` date NOT NULL
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
-- Indexes for table `repairlist`
--
ALTER TABLE `repairlist`
  ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `transno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `repairlist`
--
ALTER TABLE `repairlist`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
