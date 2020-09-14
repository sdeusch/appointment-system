-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 14, 2020 at 08:18 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone
= "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_massage`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment`
(
  `id` int
(11) NOT NULL,
  `patient_id` int
(11) NOT NULL,
  `therapist_id` int
(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `confirmed` tinyint
(1) NOT NULL,
  `delivered` tinyint
(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`
id`,
`patient_id
`, `therapist_id`, `start_time`, `end_time`, `confirmed`, `delivered`) VALUES
(1, 1, 1, '2020-09-12 16:00:00', '2020-09-12 17:00:00', 0, 0),
(30, 18, 1, '2020-09-14 09:50:00', '2020-09-14 09:55:00', 1, 0),
(31, 18, 1, '2020-09-14 11:00:00', '2020-09-14 12:00:00', 1, 0),
(32, 18, 1, '2020-09-14 09:00:00', '2020-09-14 09:30:00', 1, 0),
(33, 20, 1, '2020-09-14 10:00:00', '2020-09-14 10:30:00', 1, 0),
(34, 18, 1, '2020-09-14 13:00:00', '2020-09-14 14:00:00', 1, 0),
(35, 23, 3, '2020-09-15 09:00:00', '2020-09-15 10:00:00', 1, 0),
(36, 23, 1, '2020-09-18 11:00:00', '2020-09-18 11:30:00', 1, 0),
(37, 23, 2, '2020-09-26 09:15:00', '2020-09-26 10:00:00', 1, 0),
(38, 22, 1, '2020-09-15 16:15:00', '2020-09-15 16:45:00', 1, 0),
(39, 22, 1, '2020-09-21 16:15:00', '2020-09-21 16:30:00', 1, 0),
(40, 27, 2, '2020-09-16 17:00:00', '2020-09-16 18:00:00', 1, 0),
(41, 27, 3, '2020-09-17 10:00:00', '2020-09-17 11:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient`
(
  `id` int
(11) NOT NULL,
  `password` varchar
(20) NOT NULL,
  `patientFirstName` varchar
(20) NOT NULL,
  `patientLastName` varchar
(20) NOT NULL,
  `patientDOB` date NOT NULL,
  `patientGender` varchar
(10) NOT NULL,
  `patientAddress` varchar
(100) DEFAULT NULL,
  `patientPhone` varchar
(15) DEFAULT NULL,
  `patientEmail` varchar
(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`
id`,
`password
`, `patientFirstName`, `patientLastName`, `patientDOB`, `patientGender`, `patientAddress`, `patientPhone`, `patientEmail`) VALUES
(1, '123', 'Lukas', 'Deusch', '1992-05-17', 'male', 'Hauptstraße 1, Mülln, Salzburg, A-5021', '173567758', 'lukas@gmail.com'),
(21, '123', 'Alfred', 'Pickelmayr', '1981-01-07', 'männlich', '123 Am Bach, Im Wald, Andern, Schweiz', '312-312-3452', 'picklme@aol.com'),
(22, '123', 'Luigi', 'Andreotti', '1989-07-10', 'männlich', '', '', 'luigi@gmail.com'),
(23, '123', 'Thomas', 'Untermaier', '1990-04-11', 'männlich', '', '', 'thom123@gmail.com'),
(24, '123', 'Thomas', 'Untermaier', '1990-04-11', 'männlich', '', '', 'thom123@gmail.com'),
(25, '123', 'Thomas', 'Untermaier', '1990-04-11', 'männlich', '', '', 'thom123@gmail.com'),
(26, '123', 'Luigi', 'Andreotti', '1989-07-10', 'männlich', '', '', 'luigi@gmail.com'),
(27, '123', 'Elfriede', 'Neuman', '1990-07-10', 'weiblich', '', '', 'neuman@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `therapist`
--

CREATE TABLE `therapist`
(
  `id` int
(11) NOT NULL,
  `employeeNum` int
(11) NOT NULL,
  `password` varchar
(20) NOT NULL,
  `firstName` varchar
(20) NOT NULL,
  `lastName` varchar
(20) NOT NULL,
  `jobTitle` varchar
(10) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar
(100) NOT NULL,
  `phone` varchar
(15) NOT NULL,
  `email` varchar
(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `therapist`
--

INSERT INTO `therapist` (`
id`,
`employeeNum
`, `password`, `firstName`, `lastName`, `jobTitle`, `dob`, `address`, `phone`, `email`) VALUES
(1, 123456, '123', 'Katherina', 'Weitwinkel', '', '1995-12-01', 'Hauptstraße 31, 3020 Eigendorf, Österreich', '312-313-321', 'kath243@yahoo.com'),
(2, 234567, '123', 'Werner', 'Kovacs', 'Direktor', '1990-10-13', 'Dorfstraße 29, 2040 Mülln, Österreich', '321-312-3131', 'wkovacs@gmail.com'),
(3, 345678, '123', 'Christine', 'Kreuzberger', 'Masseuse', '1995-08-23', 'Am Weg 21, 1020 Wien, Österreich', '321-523-3243', 'chriskreuz@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `work_schedule`
--

CREATE TABLE `work_schedule`
(
  `id` int
(11) NOT NULL,
  `therapist_id` int
(11) NOT NULL,
  `work_day` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `comment` varchar
(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `work_schedule`
--

INSERT INTO `work_schedule` (`
id`,
`therapist_id
`, `work_day`, `start_time`, `end_time`, `comment`) VALUES
(3, 1, '2020-09-15', '14:00:00', '17:00:00', 'Sonntag nachmittags'),
(4, 1, '2020-09-14', '09:00:00', '17:00:00', ''),
(5, 1, '2020-09-15', '09:00:00', '17:00:00', ''),
(7, 1, '2020-09-16', '09:00:00', '17:00:00', 'Mittwoch '),
(10, 1, '2020-09-17', '10:00:00', '18:30:00', 'Donnerstag'),
(11, 1, '2020-09-18', '08:00:00', '12:00:00', 'Halbtags'),
(12, 1, '2020-09-21', '09:00:00', '17:00:00', 'Montag'),
(13, 1, '2020-09-22', '09:00:00', '17:00:00', 'Dienstag'),
(14, 1, '2020-09-25', '10:30:00', '13:00:00', 'Vormittags'),
(15, 2, '2020-09-16', '16:00:00', '18:30:00', 'Nachmittag'),
(16, 2, '2020-09-17', '16:00:00', '18:00:00', 'Donnerstag nachmittag '),
(17, 2, '2020-09-26', '08:00:00', '11:30:00', 'Samstag morgen'),
(18, 3, '2020-09-15', '08:00:00', '16:00:00', ''),
(19, 3, '2020-09-16', '08:00:00', '11:00:00', 'Mittwoch vormittag'),
(20, 3, '2020-09-16', '14:00:00', '18:00:00', 'Mittwoch nachmittag'),
(21, 3, '2020-09-17', '07:00:00', '11:00:00', 'Donnerstag'),
(22, 3, '2020-09-18', '07:00:00', '16:00:00', 'Freitag '),
(23, 3, '2020-09-22', '07:00:00', '16:30:00', 'Dienstag ganztags');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
ADD PRIMARY KEY
(`id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
ADD PRIMARY KEY
(`id`);

--
-- Indexes for table `therapist`
--
ALTER TABLE `therapist`
ADD PRIMARY KEY
(`id`),
ADD UNIQUE KEY `employeeNum`
(`employeeNum`);

--
-- Indexes for table `work_schedule`
--
ALTER TABLE `work_schedule`
ADD PRIMARY KEY
(`id`),
ADD UNIQUE KEY `uq_therapist_day_start_time`
(`therapist_id`,`work_day`,`start_time`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `therapist`
--
ALTER TABLE `therapist`
  MODIFY `id` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `work_schedule`
--
ALTER TABLE `work_schedule`
  MODIFY `id` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
